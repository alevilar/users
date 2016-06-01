<?php
App::uses('AppModel', 'Model');
/**
 * Rol Model
 *
 * @property User $User
 */
class Rol extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
        


	


/**
 * Sets up the configuration for the model, and loads databse from Multi Tenant Site
 *
 * @param Model $model Model using this behavior.
 * @param array $config Configuration options.
 * @return void
 */
	public function __construct($id = false, $table = null, $ds = null) {

		// usar el correspondiente al tenant
		//debug( Router::$_requests );
		if ( MtSites::isTenant() ) {
			$currentTenant = MtSites::getSiteName();
			if ( $currentTenant ) {
				
				// listar sources actuales
				$sources = ConnectionManager::enumConnectionObjects();

				//copiar del default
				$tenantConf = $sources['default'];

				// colocar el nombre de la base de datos
				$tenantConf['database'] = $tenantConf['database'] ."_". $currentTenant;

				// crear la conexion con la bd
				$confName = 'tenant_'.$currentTenant;
				ConnectionManager::create( $confName, $tenantConf );

				// usar tenant para este model
				$this->useDbConfig = $confName;	

			}
		}

	
		// ahora construir el Model
		parent::__construct($id, $table, $ds);
		
	}



    
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
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed


	/**
 * hasMany associations
 *
 * @var array
 */
	public $hasOne = array('Users.GenericUser');


/**
 * hasMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'User' => array(
			'className' => 'Users.Rol',
			'joinTable' => 'roles_users',
			'foreignKey' => 'user_id',
			'associationForeignKey' => 'rol_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'with' => 'Users.RolUser',
		),
	);
        
        public function beforeSave($options = array()) {
        	if (empty($this->data['Rol']['machin_name'])) {
            	$this->data['Rol']['machin_name'] = strtolower( Inflector::slug( $this->data['Rol']['name'])) ;
        	}
            return true;
        }
        

}
