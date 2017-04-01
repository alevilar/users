<?php
App::uses('Rol', 'Users.Model');

/**
 * Rol Test Case
 */
class RolTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.users.rol',
		'plugin.users.user',
		'plugin.users.rol_user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Rol = ClassRegistry::init('Users.Rol');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Rol);

		parent::tearDown();
	}

}
