<?php
/**
 * GenericUser Fixture
 */
class GenericUserFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
		'pin' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'rol_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true),
		'created' => array('type' => 'timestamp', 'null' => true, 'default' => null),
		'modified' => array('type' => 'timestamp', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'pin' => array('column' => 'pin', 'unique' => 1)
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
			'id' => 1,
			'pin' => 'Lorem ipsum dolor sit amet',
			'rol_id' => 1,
			'created' => 1464795357,
			'modified' => 1464795357
		),
	);

}
