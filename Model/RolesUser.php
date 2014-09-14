<?php
App::uses('AppTenantModel', 'Model');
/**
 * Rol Model
 *
 * @property User $User
 */
class RolesUser extends AppTenantModel {

	public $useTable = 'roles_users';
       
}
