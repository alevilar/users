<?php
/**
 * Rol Fixture
 */
class Rol201704Fixture extends CakeTestFixture {


	public $table = 'roles';
/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'machin_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'timestamp', 'null' => true, 'default' => null),
		'modified' => array('type' => 'timestamp', 'null' => true, 'default' => null),
		'created_by' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'deleted_date' => array('type' => 'timestamp', 'null' => true, 'default' => null),
		'deleted' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
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
			'id' => '1',
			'name' => 'Mozo',
			'machin_name' => ROL_MOZO,
			'created' => '2017-04-07 20:27:39',
			'modified' => '2017-04-07 20:27:39',
			'created_by' => null,
			'deleted_date' => null,
			'deleted' => '0'
		),
		array(
			'id' => '2',
			'name' => 'Cajero',
			'machin_name' => ROL_CAJERO,
			'created' => '2017-04-07 20:27:39',
			'modified' => '2017-04-07 20:27:39',
			'created_by' => null,
			'deleted_date' => null,
			'deleted' => '0'
		),
		array(
			'id' => '3',
			'name' => 'Encargado',
			'machin_name' => ROL_ENCARGADO,
			'created' => '2017-04-07 20:27:39',
			'modified' => '2017-04-07 20:27:39',
			'created_by' => null,
			'deleted_date' => null,
			'deleted' => '0'
		),
		array(
			'id' => '4',
			'name' => 'Cocinero',
			'machin_name' => ROL_COCINERO,
			'created' => '2017-04-07 20:27:39',
			'modified' => '2017-04-07 20:27:39',
			'created_by' => null,
			'deleted_date' => null,
			'deleted' => '0'
		),
		array(
			'id' => '5',
			'name' => 'Cocinero',
			'machin_name' => ROL_MOZO,
			'created' => '2017-04-07 20:27:39',
			'modified' => '2017-04-07 20:27:39',
			'created_by' => null,
			'deleted_date' => null,
			'deleted' => '0'
		),		
	);
}
