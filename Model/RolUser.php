<?php
App::uses('AppTenantModel', 'Model');
/**
 * Rol Model
 *
 * @property User $User
 */
class RolUser extends AppTenantModel {

	public $useTable = 'roles_users';
       
}
