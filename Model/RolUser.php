<?php
App::uses('AppModel', 'Model');
/**
 * Rol Model
 *
 * @property User $User
 */
class RolUser extends AppModel {

	public $useTable = 'roles_users';


	


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
		if ( CakeSession::started() ) {
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

       
}
