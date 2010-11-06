<?php
class InicioController extends AppController
{
	var $uses = null;

	function index() {
		if (!empty($this->data)) {
			if ($this->data['fileName']['name']<>'cajeros.xml') {
				$this->Session->setFlash('ERROR EN EL NOMBRE DEL ARCHIVO.');
			} else {	
				$directorio = 'files/uploads/';
				if (move_uploaded_file($this->data['fileName']['tmp_name'], $directorio . $this->data['fileName']['name']))
				{
					//debug($this->data);
					$this->Session->setFlash('Fichero subido.');
				} else {
					$this->Session->setFlash('ERROR.');
				}
			}
		}
	}

	function beforeFilter()
	{
		$this->Auth->allow("");
		parent::beforeFilter();
	}

}
?>