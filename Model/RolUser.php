<?php
App::uses('RistoTenantAppModel', 'Risto.Model');
/**
 * Rol Model
 *
 * @property User $User
 */
class RolUser extends RistoTenantAppModel {

/**
 * Asigna el rol al usuario. Primero elimina todos los registros de roles_users
 * cuya user_id sea del usuario en cuestión. Luego en un array se pone cada rol_id
 * que viene con el user_id y se guarda (esto es debido a que un usuario puede 
 * tener muchos roles).
 * 
 * @param $data = $this->request->data (array con las ids de roles + id usuario en sub-indices)
 * @return true
 */
    public function asignarRol($data) {
    	$this->deleteAll(array('user_id' => $data['User']['id']), false);
    	$indice = 0;
    	foreach($data['Rol']['Rol'] as $r) {

    	   $rolesUser[$indice] = array('user_id' => $data['User']['id'], 'rol_id' => $r);    	     	

    	   $indice = $indice + 1;
    	}
    	$this->saveAll($rolesUser);
    	return true; 
    }
       
}