<?php
App::uses('UsersAppModel', 'Users.Model');

/**
 * Rol Model
 *
 * @property User $User
 */
class SocialProfile extends UsersAppModel {

/**
 *
 * @var array
 */
	public $belongsTo = array('Users.User');
}