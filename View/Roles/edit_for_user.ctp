<?php


echo $this->Form->create('User');
echo $this->Form->input('id');
echo $this->Form->input('Rol');

echo $this->Form->end("Guardar");