<h2>Crea Usuario</h2>

<?php
echo $form->create('User', array('action' => 'registra'));
echo $form->inputs(array(
		'legend' => __('Register', true),
		'username',
		'password',
                'email'
		));
echo $form->end(__('Enviar', true));

?>