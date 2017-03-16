<?php 
	echo $this->Paginator->counter(array(
		'format' => 'Página %page% de %pages%, mostrando %current% registros de un total de %count%, empezando en el registro %start% y finalizando en el registro %end%.')); 
?>