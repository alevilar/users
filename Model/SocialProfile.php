<?php
App::uses('RistoAppModel', 'Risto.Model');

/**
 * Rol Model
 *
 * @property User $User
 */
class SocialProfile extends RistoAppModel {

/**
 *
 * @var array
 */
	public $belongsTo = array('Users.User');
}