<h2>XML</h2>
<?php 
echo $form->create('', array('type' => 'file'));
//echo $form->create('Inicio', array('type' => 'file'));
echo $form->input('fileName', array('type' => 'file','label'=>'Archivo'));
echo $form->end('Subir');
?>