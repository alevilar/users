<?php
App::uses('RistoDualTenantAppModel', 'Risto.Model');
/**
 * Rol Model
 *
 * @property User $User
 */
class Rol extends RistoDualTenantAppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
        


	public $inTenantHasOne = array('Users.GenericUser');


	/**
	 * hasAndBelongsToMany associations
	 *
	 * @var array
	 */
	public $hasAndBelongsToMany = array(
		'User' => array(
			'className' => 'Users.User',
			'joinTable' => 'roles_users',
			'foreignKey' => 'rol_id',
			'associationForeignKey' => 'user_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);



    

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'machin_name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed


        
        public function beforeSave($options = array()) {
        	if (empty($this->data['Rol']['machin_name'])) {
            	$this->data['Rol']['machin_name'] = strtolower( Inflector::slug( $this->data['Rol']['name'])) ;
        	}
            return true;
        }
        

}
