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
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rol could not be saved. Please, try again.'),'Risto.flash_error');
			}
		}
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
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Rol->id = $id;
		if (!$this->Rol->exists()) {
			throw new NotFoundException(__('Invalid rol'));
		}
		if ($this->Rol->delete()) {
			$this->Session->setFlash(__('Rol deleted'),'Risto.flash_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Rol was not deleted'),'Risto.flash_error');
		$this->redirect(array('action' => 'index'));
	}


	public function edit_for_user( $userId ) {
		$this->Rol->User->id = $userId;
		if (!$this->Rol->User->exists()) {
			throw new NotFoundException(__('Invalid User'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			debug($this->request->data);
			if ($this->Rol->User->save($this->request->data, array('fieldList'=> array('id')))) {
				$this->Session->setFlash(__('The rol has been saved'),'Risto.flash_success');
				$this->redirect($this->referer());
			} else {
				debug($this->Rol->User->validationErrors);
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
