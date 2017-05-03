<?php
App::uses('UsersAppController', 'Users.Controller');
/**
 * genericUsers Controller
 *
 * @property GenericUser $GenericUser
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class GenericUsersController extends UsersAppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->GenericUser->recursive = 0;
		$roles = $this->GenericUser->Rol->find('all', array(
			'contain' => array(
					'GenericUser'
				),
			'conditions' => array(
				'machin_name !=' => 'duenio'
				)
			));
		$this->set('genericUsers', $this->Paginator->paginate());
		$this->set('roles', $roles);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->GenericUser->exists($id)) {
			throw new NotFoundException(__('Invalid generic user'));
		}
		$options = array('conditions' => array('GenericUser.' . $this->GenericUser->primaryKey => $id));
		$this->set('genericUser', $this->GenericUser->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add( $rol_id = null) {
		if (!$this->GenericUser->Rol->exists($rol_id)) {
			throw new NotFoundException(__('Rol Inválido'));
		}
		if ($this->request->is('post')) {
			$this->GenericUser->create();
			if ($this->GenericUser->save($this->request->data)) {
				$this->Flash->success(__('The generic user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The generic user could not be saved. Please, try again.'));
			}
		}
		$this->request->data['GenericUser']['rol_id'] = $rol_id;
		$roles = $this->GenericUser->Rol->find('list');
		$rolName = $this->GenericUser->Rol->field('name', array('id' => $rol_id));
		$this->set(compact('roles', 'rolName'));
		$this->render("form");
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit( $rol_id = null, $id = null) {
		if (!$this->GenericUser->Rol->exists($rol_id)) {
			throw new NotFoundException(__('Rol Inválido'));
		}
		if (!$this->GenericUser->exists($id)) {
			throw new NotFoundException(__('Invalid generic user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->GenericUser->save($this->request->data)) {
				$this->Flash->success(__('The generic user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The generic user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('GenericUser.' . $this->GenericUser->primaryKey => $id));
			$this->request->data = $this->GenericUser->find('first', $options);
		}
		$this->request->data['GenericUser']['rol_id'] = $rol_id;
		$roles = $this->GenericUser->Rol->find('list');
		$rolName = $this->GenericUser->Rol->field('name', array('id' => $rol_id));
		$this->set(compact('roles', 'rolName'));
		$this->render("form");
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->GenericUser->id = $id;
		if (!$this->GenericUser->exists()) {
			throw new NotFoundException(__('Invalid generic user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->GenericUser->delete()) {
			$this->Flash->success(__('The generic user has been deleted.'));
		} else {
			$this->Flash->error(__('The generic user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
