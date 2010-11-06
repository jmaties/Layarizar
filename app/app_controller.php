<?php
/**
 *
 */
class AppController extends Controller {
	var $components = array('Auth',
							'Session',
							//'DebugKit.Toolbar',
							'RequestHandler');
	var $helpers = array('Html',
			     'Form',
			     'Javascript',
			     'Session',
			     'Layout',
			     'Action');

	function beforeFilter() {
		// url para usar en la carga de imagenes
		//$this->Session->write('urlbase','http://maties.es');
		// Handle the user auth filter
		// This, along with no salt in the config file allows for straight
		// md5 passwords to be used in the user model
		Security::setHash("md5");
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
		$this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'datos');
		$this->Auth->logoutRedirect = '/';
		$this->Auth->loginError = 'Error usuario / password. Por favor, intentel de nuevo';
		$this->Auth->authError = "Para poder acceder necesitas identificarte";
		$this->Auth->authorize = 'controller';
		$this->set('usuario', $this->Auth->user());
		$this->RequestHandler->setContent('json', 'text/x-json');

		if ($this->RequestHandler->isAjax()) {
			$this->layout = 'ajax';
		}
	}

	function isAuthorized() {
		return true;
	}


}
