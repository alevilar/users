<?php
/**
 * User Fixture
 */
class UserFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'username' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'password_token' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'email_verified' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'email_token' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'email_token_expires' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'tos' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'active' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'last_login' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'last_action' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'is_admin' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'role' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'deleted' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'BY_USERNAME' => array('column' => 'username', 'unique' => 0),
			'BY_EMAIL' => array('column' => 'email', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '590b8e47-d5e8-4691-b578-47bca73ba8b7',
			'username' => 'pascual_el_admin',
			'slug' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'password_token' => 'Lorem ipsum dolor sit amet',
			'email' => 'Lorem ipsum dolor sit amet',
			'email_verified' => 1,
			'email_token' => 'Lorem ipsum dolor sit amet',
			'email_token_expires' => '2017-05-04 17:25:43',
			'tos' => 1,
			'active' => 1,
			'last_login' => '2017-05-04 17:25:43',
			'last_action' => '2017-05-04 17:25:43',
			'is_admin' => 1,
			'role' => 'Lorem ipsum dolor sit amet',
			'created' => '2017-05-04 17:25:43',
			'modified' => '2017-05-04 17:25:43',
			'deleted_date' => '2017-05-04 17:25:43',
			'deleted' => 1
		),
	);

}
