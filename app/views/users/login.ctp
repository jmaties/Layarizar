<?php
echo $session->flash('auth');
echo $form->create('User', array('action' => 'login'));
echo $form->inputs(array(
		'legend' => __('Login', true),
		'username'=>array('label'=>'Usuario'),
		'password'=>array('label'=>'Contraseña')
		));
echo $form->end('Login');
?>