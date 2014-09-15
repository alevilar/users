<?php
App::uses('AppTenantModel', 'Model');
/**
 * Rol Model
 *
 * @property User $User
 */
class Rol extends AppTenantModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
        

    
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'rol_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => '',
			'with' => 'Users.RoleUser',
		)
	);
        
        public function beforeSave($options = array()) {
        	if (empty($this->data['Rol']['machin_name'])) {
            	$this->data['Rol']['machin_name'] = strtolower( Inflector::slug( $this->data['Rol']['name'])) ;
        	}
            return true;
        }
        

}
