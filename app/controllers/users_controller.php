<?php 

class UsersController extends AppController
{
    var $name = "Users";
    var $helpers = array('Html', 'Form');
    
	
    function login() {
	/**
     *  El AuthComponent proporciona la funcionalidad necesaria
     *  para el acceso (login), por lo que se puede dejar esta función en blanco.
     */
        $this->set('title_for_layout', ' | Usuarios');
    }

    
    
    function logout() {
        //$gigya->logout();
        $this->redirect($this->Auth->logout());
    }
    
    
    function registra()
    {
        if ( !empty( $this->data ) ){
                        $this->User->create();
                        if ( $this->User->save($this->data) ){
                            $this->redirect('/');
                        }         
        }
    }
    function beforeFilter() 
	{
		$this->Auth->allow("registra");
		parent::beforeFilter();
	}
    
}

?>