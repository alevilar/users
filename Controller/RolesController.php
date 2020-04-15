<?php
App::uses('UsersAppController', 'Users.Controller');
/**
 * Roles Controller
 *
 * @property Rol $Rol
 */
class RolesController extends UsersAppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Rol->recursive = 0;
		$this->set('roles', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Rol->id = $id;
		if (!$this->Rol->exists()) {
			throw new NotFoundException(__('Invalid rol'));
		}
		$this->set('rol', $this->Rol->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Rol->create();
			if ($this->Rol->save($this->request->data)) {
				$this->Session->setFlash(__('The rol has been saved'),'Risto.flash_success');
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('The rol could not be saved. Please, try again.'),'Risto.flash_error');
			}
		}
		$this->set('roles_machine_names', $this->Rol->find('list', array(
			'recursive' => -1, 
			'fields' => array(
				'machin_name', 
				'name'
			), 
			'conditions' => array(
				'machin_name !=' => ROL_DUENIO
			), 
			'order' => array(
				'Rol.created' => 'DESC'
			))));
        $this->render('edit');
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Rol->id = $id;
		if (!$this->Rol->exists()) {
			throw new NotFoundException(__('Invalid rol'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Rol->save($this->request->data)) {
				$this->Session->setFlash(__('The rol has been saved'),'Risto.flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rol could not be saved. Please, try again.'),'Risto.flash_error');
			}
		} else {
			$this->request->data = $this->Rol->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Rol->id = $id;
		if (!$this->Rol->exists()) {
			throw new NotFoundException(__('Invalid Rol Id'));
		}
		if ($this->Rol->delete($id, true)) {
			$this->Rol->GenericUser->deleteAll(array('GenericUser.rol_id' => $id));
			$this->Session->setFlash(__('Usuario Generico Borrado'),'Risto.flash_success');
			$this->redirect($this->referer());
		} else {
			$this->Session->setFlash(__('Error: Usuario Generico No pudo ser borrado'),'Risto.flash_error');
		}

		$this->redirect(array('action' => 'index'));
	}


	public function edit_for_user( $userId ) {
        $this->Rol->User->id = $userId;
 		if (!$this->Rol->User->exists()) {
 		  throw new NotFoundException(__('Invalid User'));
 		}
         
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Rol->RolUser->asignarRol($this->request->data)) {
				$this->Session->setFlash(__('The rol has been saved'),'Risto.flash_success');
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('The rol could not be saved. Please, try again.'),'Risto.flash_error');
			}
		} else {
			$this->Rol->User->contain(array('Rol'));
			$user = $this->Rol->User->read();
			$this->request->data = $user;
		}
		$this->set('roles', $this->Rol->find("list"));
	}
}
