<?php
App::uses('UsersAppController', 'Users.Controller');

class SuperRolesController extends UsersAppController {

	public function edit_for_user( $userId ) {
        $this->SuperRol->User->id = $userId;
 		if (!$this->SuperRol->User->exists()) {
 		  throw new NotFoundException(__('Invalid User'));
 		}
         
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->SuperRol->SuperRolUser->asignarRol($this->request->data)) {
				$this->Session->setFlash(__('The rol has been saved'),'Risto.flash_success');
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('The rol could not be saved. Please, try again.'),'Risto.flash_error');
			}
		} else {
			$this->SuperRol->User->contain(array('SuperRol'));
			$user = $this->SuperRol->User->read();
			$this->request->data = $user;
		}
		$this->set('superRoles', $this->SuperRol->find("list"));
	}

}

?>