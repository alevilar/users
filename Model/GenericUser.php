<?php
App::uses('AppTenantModel', 'Model');

/**
 * GenericUser Model
 *
 * @property Rol $Rol
 */
class GenericUser extends AppTenantModel {



	public $actsAs = array( 
		'Containable', 
		'Search.Searchable', 
		'Risto.Auditable', 
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'pin' => array(
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'Este PIN ya está siendo utilizado por otro usuario. Por favor ingresar otro número',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'rol_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Rol' => array(
			'className' => 'Users.Rol',
			'foreignKey' => 'rol_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * lista todos los usuarios genericos
 *
 * @return array
 */

public function listarGenericosConNombreRol() {
	$usuariosGenericos =  $this->find('all', array(
		'contain' => array(
			'Rol'
			)
		));


	return Hash::combine($usuariosGenericos, '{n}.GenericUser.id', '{n}.Rol.name');

}

}