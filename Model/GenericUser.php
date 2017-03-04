<?php
App::uses('AppTenantModel', 'Model');

/**
 * GenericUser Model
 *
 * @property Rol $Rol
 */
class GenericUser extends AppTenantModel {



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

public function beforesave($options = array()) {

	$id = $this->data['GenericUser']['rol_id'];

	switch ($id) {
		case ROL_ID_MOZO:
			$this->data['GenericUser']['name'] = 'Mozo';
			break;
		
		case ROL_ID_CAJERO:
			$this->data['GenericUser']['name'] = 'Cajero';
			break;

		case ROL_ID_ENCARGADO:
			$this->data['GenericUser']['name'] = 'Encargado';
			break;

		case ROL_ID_COCINERO:
			$this->data['GenericUser']['name'] = 'Cocinero';
			break;
	}
  return true;
}

/**
 * lista todos los usuarios genericos
 *
 * @return array
 */

public function buscarGenericos() {
	return $this->find('list');
}

}