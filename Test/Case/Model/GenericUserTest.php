<?php
App::uses('GenericUser', 'Users.Model');

/**
 * GenericUser Test Case
 */
class GenericUserTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.users.generic_user',
		'plugin.users.rol'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->GenericUser = ClassRegistry::init('Users.GenericUser');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->GenericUser);

		parent::tearDown();
	}

}
