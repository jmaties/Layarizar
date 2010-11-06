<?php
class PoiController extends AppController {

	var $name = 'Poi';
        //var $uses = array('Poi');
	var $helpers = array('GoogleMap');
	var $components = array('Uploader.Uploader');
	var $paginate = array(
		'limit' => 10,
		'order' => array(
		'Poi.id' => 'desc'
			)
		);
        
function index(){
        $this->pageTitle = "Inicio";
        //$this->Poi->recursive = 0;
		$parametros = array (
			'order' => 'id DESC'
		);
		//$pois = $this->Poi->find('all',$parametros);
		$pois = $this->paginate('Poi');
		//$this->set('pois', $pois);
		 $this->set(compact('pois'));
                //debug($pois);
        }

function add() {
	if (empty($this->data)) {
		$this->data = $this->Poi->read();
	} else {
	//debug($this->data);
	$this->Poi->Behaviors->Attachment->update('Poi', 'file', array('name' => $this->data['Poi']['file']['name']));
		if ($this->Poi->saveWithAction($this->data)) {
			$this->Session->setFlash('Poi creado.');
			$this->set(compact('pois'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
		
function editar($id = null) {
	if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Contenido invalido', true));
            $this->redirect(array('action'=>'index'));
        }
	$this->Poi->id = $id;
	if (empty($this->data)) {
		$this->data = $this->Poi->read();
	} else {
	//debug($this->data);
	if ($this->data['Poi']['file']['error']<>4) {
	
		if (isset($this->data['Poi']['imageURL'])){
			$this->Poi->Behaviors->Attachment->borra($this->data['Poi']['imageURL']);
		}
		$this->Poi->Behaviors->Attachment->update('Poi', 'file', array('name' => $this->data['Poi']['file']['name']));
	}
		if ($this->Poi->saveWithAction($this->data)) {
			$this->Session->setFlash('Poi actualizado.');
			$this->set(compact('pois'));
			$this->redirect(array('action' => 'index'));
		}
	}
}

function borrar($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('id no válido', true));
            $this->redirect(array('action'=>'index'));
        }
	$this->Poi->id = $id;
	$this->data = $this->Poi->read();
	//$imagen = strstr($this->data['Poi']['imageURL'], 'files/base/');
	//debug($this->data['Poi']['imageURL']);
	
	//
        if ($this->Poi->delete($id)) {
		if (isset($this->data['Poi']['imageURL'])){
			$this->Poi->Behaviors->Attachment->borra($this->data['Poi']['imageURL']);
		}
            $this->Session->setFlash(__('Poi borrado', true));
            $this->redirect(array('action'=>'index'));
        }
    }
	function add_action() {
        $this->layout = 'ajax';
    }
	
	function delete_action($id = null) {
        $success = false;
        if ($id != null && $this->Poi->Action->delete($id)) {
            $success = true;
        }

        $this->set(compact('success'));
    }
	
	function borra_foto($id = null) {
        $success = false;
		$this->Poi->id = $id;
		$this->data = $this->Poi->read();
		//debug($this->data);
        if ($id != null && $this->Poi->Behaviors->Attachment->borra($this->data['Poi']['imageURL'])) {
			$this->Poi->updateAll(
				array('Poi.imageURL' => NULL)
				);
            $success = true;
        }

        $this->set(compact('success'));
    }

    function beforeFilter() 
	{
		$this->Auth->allow("");
		parent::beforeFilter();
	}
}
?>