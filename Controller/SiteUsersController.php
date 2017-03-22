<?php

class SiteUsersController extends UsersAppController {


	public $uses = array('Users.User','MtSites.Site');



	public function beforeRender (){
		if ( !MtSites::isTenant()) {
        	throw new ForbiddenException( __("El Tenant no es válido o no fue encontrado en el sistema"));
        }

		parent::beforeRender();
		$this->set('model', $this->modelClass);
	}


/**
 * Admin Index
 *
 * @return void
 */
	public function index() {
		if ($this->{$this->modelClass}->Behaviors->loaded('Searchable')) {
			$this->Prg->commonProcess();
			unset($this->{$this->modelClass}->validate['username']);
			unset($this->{$this->modelClass}->validate['email']);
			$this->{$this->modelClass}->data[$this->modelClass] = $this->passedArgs;
		}

		$site_alias = MtSites::getSiteName();

		$this->Paginator->settings[$this->modelClass] = array(
			'recursive' => 1,			
		);

		$this->set('users', $this->Paginator->paginate());
		$this->set(compact('site_alias'));		
	}



/**
 * Admin add
 *
 * @return void
 */
	public function add() {		
        
        $site = $this->{$this->modelClass}->Site->findByAlias(MtSites::getSiteName() );
        $this->request->data['Site']['id'] = $site['Site']['id'];
		
		if ( $this->request->is('post') ) {	
            
			$this->request->data[$this->modelClass]['tos'] = true;
			$this->request->data[$this->modelClass]['email_verified'] = true;
			//save new user
			if ($this->{$this->modelClass}->add($this->request->data)) {
				$this->Session->setFlash(__d('users', 'The User has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('users', 'The User couldn`t be saved'), 'Risto.flash_error');
			}
		}
		$roles = $this->{$this->modelClass}->Rol->find('list');
		$this->set(compact( 'roles', 'site'));
	}



/**
 * Admin edit
 *
 * @param null $userId
 * @return void
 */
	public function edit($userId = null) {

		if ( $this->request->is('post')) {
			unset ( $this->request->data[$this->modelClass]['last_login'] );

			
			$this->{$this->modelClass}->bindModel(array(
		        'hasMany' => array(
		            'RolUser' => array(
		                'classname' => 'Users.RolUser',
		            ) 
		        ) 
		    ));

			$rolUser = array();
			if (!empty($this->request->data['Rol']['Rol'])) {
			    	$rolUser[] = array(
			    		'rol_id' => $this->request->data['Rol']['Rol'],
			    		'user_id' => $userId,
			    		);
			}

			$this->{$this->modelClass}->RolUser->deleteAll(array('RolUser.user_id' => $userId ));

			if ( $this->{$this->modelClass}->RolUser->saveMany( $rolUser ) ) {
				$this->Session->setFlash(__d('users', 'User saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('users', 'Error saving'), 'Risto.flash_error');
			}
		}

		if (empty($this->request->data)) {
			$this->{$this->modelClass}->recursive = 1;
			$this->request->data = $this->{$this->modelClass}->read(null, $userId);
			unset($this->request->data[$this->modelClass]['password']);
		}

		$roles = $this->{$this->modelClass}->Rol->find('list');
		$this->set(compact( 'roles'));
		$this->render('admin_form');
	}

	
/**
 * Admin add
 *
 * @return void
 */
	public function delete_from_tenant ( $user_id ) {
		if ( $this->request->is('post') ) {
			$alias = MtSites::getSiteName();			
			if ( $this->{$this->modelClass}->dismissUserFromSite($alias, $user_id) ) {
				$user['user_id'] = $user_id;
				$this->User->RolUser->deleteAll($user, false);
				$this->Session->setFlash(__d('users','El usuario fue removido satisfactoriamente del comercio'));
			} else {
				$this->Session->setFlash(__d('users','Error al remover al usuario del comercio.'), 'Risto.flash_error');
			}
		}

		$this->redirect(array('action'=>'index'));
	}


	
/**
 * Admin add
 *
 * @return void
 */
	public function add_existing($user_id, $siteAlias = null, $rol_id = null) {
	  if($siteAlias == null) {		
		$siteAlias = MtSites::getSiteName();
	  }
        $site = $this->{$this->modelClass}->Site->findByAlias($siteAlias);
        $this->request->data['Site']['id'] = $site['Site']['id'];
		if ( $this->request->is('post','put','ajax') ) {	

			$wasFound = $this->{$this->modelClass}->find('first', array(
				'conditions' => array(
						$this->modelClass.'.id' => $user_id
					),
				'contain' => array(
						'Site' => array(
							'conditions' => array(
								'Site.id' => $this->request->data['Site']['id'],
								)
							) 
					),
				));
			
			if ( !empty( $wasFound['Site']) ) {
				$this->Session->setFlash(__d('users', 'El usuario ya se encuentra en este comercio'), 'Risto.Flash/flash_warning');
				$this->redirect(array('action' => 'index'));
			} elseif ( $wasFound ) {
				// assign user Rol & Site
 
				if (!empty($this->request->data['Rol']['Rol'][0]) || !empty($rol_id)) {
					if($rol_id == null) {
					$rol_id = $this->request->data['Rol']['Rol'][0];
				    }
				    debug($rol_id); die; 

					$this->{$this->modelClass}->hasAndBelongsToMany['Rol']['unique'] = false;
					if ( $this->{$this->modelClass}->addRoleIntoSite($rol_id, $user_id) ) {
						$site_id = $this->request->data['Site']['id'];
                        debug($site_id.'  ASDASDA   '.$user_id);
						if ( $this->{$this->modelClass}->addIntoSite($site_id, $user_id) ) {
							$this->Session->setFlash(__d('users', 'El usuario ha sido vinculado con este comercio satisfactoriamente', $wasFound[$this->modelClass]['username']));
							MtSites::loadSessionData();
						} else {
							$this->Session->setFlash(__d('users', 'Error al vincular el usuario al comercio'), 'Risto.flash_error');
						}

					} else {
						$this->Session->setFlash(__d('users', 'Error guardando el rol del usuario'), 'Risto.flash_error');
					}
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__d('users', 'Error: no has elegido el rol del usuario, intentelo de nuevo.'), 'Risto.flash_error');
				}

				$this->redirect(array('action' => 'index'));

			} else{
				debug($wasFound);
				$this->Session->setFlash(__d('users', 'El usuario no pudo ser encontrado'), 'Risto.flash_error');
			}
		}
		$roles = $this->{$this->modelClass}->Rol->find('list');
		$this->set('site', $site);
		$this->set(compact( 'roles'));
	}

    public function assign_other_site($user_id) {

		if ($this->request->is('post','put','ajax')) {
			$site_id = $this->request->data['User']['site'];
			$rol_id = $this->request->data['User']['rol'];
			$site = $this->Site->find('first', array('fields' => 'alias', 'conditions' => array('id' => $site_id)));
            $siteAlias = $site['Site']['alias'];
			$this->add_existing($user_id, $siteAlias, $rol_id);
		}

		$this->{$this->modelClass}->recursive = 1;
		$this->request->data = $this->{$this->modelClass}->read(null, $user_id);
		$roles = $this->User->Rol->find('list', array('fields' => array('id','name')));
		$user = $this->User->find('first', array('conditions' => array('id' => $user_id), 'recursive' => -1));
		$currLogUser = $this->Auth->user();
		$sites = $currLogUser['Site'];
		$sites = Hash::combine($sites, '{n}.id', '{n}.name');
		$this->set(compact('sites', 'roles', 'user'));
	}
	
}