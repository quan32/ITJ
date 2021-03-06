<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	var $constants;
	public $components = array(
		'Session',
		'Auth' => array(
			'logoutRedirect' => array(
				'controller' => 'pages',
				'action' => 'display',
				'home'
				),
			'authorize' => array('Controller')
			),
		'Log'
		);

	public function beforeFilter(){
		$this->Auth->allow('display');
		$this->loadModel("Constant");
		$this->constants=$this->Constant->find("all");
		$this->set('temp_username',$this->Auth->user('fullname'));
		$this->set('user_role', $this->Auth->user('role'));
		//$this->disableCache();
	}

	// public function appError($error) {
 //        $this->redirect(array('controller'=>'pages','action'=>'display','error'));
 //    }

}
