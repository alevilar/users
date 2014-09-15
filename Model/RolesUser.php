<?php
App::uses('AppTenantModel', 'Model');
/**
 * Rol Model
 *
 * @property User $User
 */
class RoleUser extends AppTenantModel {

	public $useTable = 'roles_users';
       
}
