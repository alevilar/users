<?php
/**
 * Copyright 2010 - 2014, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2014, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('CakeEmail', 'Network/Email');
App::uses('UsersAppController', 'Users.Controller');
App::uses('MtSites', 'MtSites.Utility');

/**
 * Users Users Controller
 *
 * @package       Users
 * @subpackage    Users.Controller
 * @property	  AuthComponent $Auth
 * @property	  CookieComponent $Cookie
 * @property	  PaginatorComponent $Paginator
 * @property	  SecurityComponent $Security
 * @property	  SessionComponent $Session
 * @property	  User $User
 * @property	  RememberMeComponent $RememberMe
 */
class UsersController extends UsersAppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Users';

/**
 * If the controller is a plugin controller set the plugin name
 *
 * @var mixed
 */
	public $plugin = null;


/**
 * Components
 *
 * @var array
 */
	public $components = array(		
		'Session',
        'Cookie',
        'RequestHandler',
        'MtSites.MtSites',
        'Auth' => array(
            'loginAction' => array('plugin'=>'users','controller' => 'users', 'action' => 'login'),
            'logoutRedirect' => array('plugin'=>'users','controller' => 'users', 'action' => 'login'),
            'loginError' => 'Usuario o Contraseña Incorrectos',
            'authError' => 'Usted no tiene permisos para acceder a esta página.', 
            'authorize' => array('MtSites.MtSites'),
            'authenticate' => array(
                'Form' => array(
                    'recursive' => 1
                )
            ),        
        ),
        'ExtAuth.ExtAuth',
        'Paginator',      
        'Search.Prg' => array(
            'presetForm' => array(
                'paramType' => 'querystring'
                )
            ),
        
        'Security',
		'Users.RememberMe',
	);


/**
 * Preset vars
 *
 * @var array $presetVars
 * @link https://github.com/CakeDC/search
 */
	public $presetVars = true;

/**
 * Constructor
 *
 * @param CakeRequest $request Request object for this controller. Can be null for testing,
 *  but expect that features that use the request parameters will not work.
 * @param CakeResponse $response Response object for this controller.
 */
	public function __construct($request, $response) {
		$this->_setupComponents();
		parent::__construct($request, $response);
		$this->_reInitControllerName();
	}

/**
 * Providing backward compatibility to a fix that was just made recently to the core
 * for users that want to upgrade the plugin but not the core
 *
 * @link http://cakephp.lighthouseapp.com/projects/42648-cakephp/tickets/3550-inherited-controllers-get-wrong-property-names
 * @return void
 */
	protected function _reInitControllerName() {
		$name = substr(get_class($this), 0, -10);
		if ($this->name === null) {
			$this->name = $name;
		} elseif ($name !== $this->name) {
			$this->name = $name;
		}
	}

/**
 * Returns $this->plugin with a dot, used for plugin loading using the dot notation
 *
 * @return mixed string|null
 */
	protected function _pluginDot() {
		if (is_string($this->plugin)) {
			return $this->plugin . '.';
		}
		return $this->plugin;
	}

/**
 * Wrapper for CakePlugin::loaded()
 *
 * @throws MissingPluginException
 * @param string $plugin
 * @param boolean $exceiption
 * @return boolean
 */
	protected function _pluginLoaded($plugin, $exception = true) {
		$result = CakePlugin::loaded($plugin);
		if ($exception === true && $result === false) {
			throw new MissingPluginException(array('plugin' => $plugin));
		}
		return $result;
	}

/**
 * Setup components based on plugin availability
 *
 * @return void
 * @link https://github.com/CakeDC/search
 */
	protected function _setupComponents() {
		if ($this->_pluginLoaded('Search', false)) {
			$this->components[] = 'Search.Prg';
		}
	}

/**
 * beforeFilter callback
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->_setupAuth();
		$this->_setupPagination();

		$this->set('model', $this->modelClass);
		$this->_setDefaultEmail();
	}

/**
 * Sets the default from email config
 *
 * @return void
 */
	protected function _setDefaultEmail() {
		if (!Configure::read('App.defaultEmail')) {
			$config = $this->_getMailInstance()->config();
			if (!empty($config['from'])) {
				Configure::write('App.defaultEmail', $config['from']);
			} else {
				Configure::write('App.defaultEmail', 'noreply@' . env('HTTP_HOST'));
			}
		}
	}

/**
 * Sets the default pagination settings up
 *
 * Override this method or the index action directly if you want to change
 * pagination settings.
 *
 * @return void
 */
	protected function _setupPagination() {
		$this->Paginator->settings = array(
			'limit' => 12,
			'conditions' => array(
				$this->modelClass . '.active' => 1,
				$this->modelClass . '.email_verified' => 1
			)
		);
	}

/**
 * Sets the default pagination settings up
 *
 * Override this method or the index() action directly if you want to change
 * pagination settings. admin_index()
 *
 * @return void
 */
	protected function _setupAdminPagination() {
		$this->Paginator->settings[$this->modelClass] = array(
			'limit' => 20,
			'order' => array(
				$this->modelClass . '.created' => 'desc'
			),
		);
	}

/**
 * Setup Authentication Component
 *
 * @return void
 */
	protected function _setupAuth() {
		if (Configure::read('Users.disableDefaultAuth') === true) {
			return;
		}

		$this->Auth->allow('add', 'reset', 'verify', 'logout', 'view', 'reset_password', 'login', 'resend_verification', 'auth_login', 'auth_callback');

		if (!is_null(Configure::read('Users.allowRegistration')) && !Configure::read('Users.allowRegistration')) {
			$this->Auth->deny('add');
		}

		if ($this->request->action == 'register') {
			$this->Components->disable('Auth');
		}

		$this->Auth->authenticate = array(
			'Form' => array(
				'recursive' => 1,
				'fields' => array(
					'username' => 'email',
					'password' => 'password'),
				'userModel' => $this->_pluginDot() . $this->modelClass,
				'scope' => array(
					$this->modelClass . '.active' => 1,
					$this->modelClass . '.email_verified' => 1
				)
			)
		);
	}


/**
 * The homepage of a users giving him an overview about everything
 *
 * @return void
 */
	public function dashboard() {
		$user = $this->{$this->modelClass}->read(null, $this->Auth->user('id'));
		$this->set('user', $user);
	}

/**
 * Shows a users profile
 *
 * @param string $slug User Slug
 * @return void
 */
	public function view($slug = null) {
		try {
			$this->set('user', $this->{$this->modelClass}->view($slug));
		} catch (Exception $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect('/');
		}
	}

/**
 * Edit the current logged in user
 *
 * Extend the plugin and implement your custom logic here, mostly thought to be
 * used as a dashboard or profile page like method.
 *
 * See the plugins documentation for how to extend the plugin.
 *
 * @return void
 */
	public function my_edit() {
		$user = $this->Auth->user();
		if ( empty($user) ) {
			throw new ForbiddenException(__("You must be logged in"));
		}
        if ( $this->request->is('post') ) {
                if ($this->User->save( $this->request->data) ) {
                        $this->Session->setFlash(__('Se ha guardado la información correctamente'));
                        $this->User->recursive = 1;
                        $user = $this->User->read(null, $id);
                        $this->Session->write('Auth.User', $user);
                } else {
                        $this->Session->setFlash(__('El usuario no pudo ser guardado. Por favor, intente nuevamente.'));
                }
        }
        $this->request->data = $user;
	}

/**
 * Admin Index
 *
 * @return void
 */
	public function index() {
		if ($this->{$this->modelClass}->Behaviors->loaded('Searchable')) {
			$this->Prg->commonProcess();
			unset($this->{$this->modelClass}->validate['username']);
			unset($this->{$this->modelClass}->validate['email']);
			$this->{$this->modelClass}->data[$this->modelClass] = $this->passedArgs;
		}

		$this->passedArgs[$this->modelClass]['site_alias'] = $this->Session->read('MtSites.current');

		//debug($parsedConditions);
		if ($this->{$this->modelClass}->Behaviors->loaded('Searchable')) {
			$parsedConditions = $this->{$this->modelClass}->parseCriteria($this->passedArgs);
		} else {
			$parsedConditions = array();
		}

		$this->_setupAdminPagination();
		$this->Paginator->settings[$this->modelClass]['conditions'] = $parsedConditions;
		$this->set('users', $this->Paginator->paginate());
	}


/**
 * Admin add
 *
 * @return void
 */
	public function add() {
		if ( $this->request->is('post') ) {
			if (MtSites::isTenant() ) {
                $site = $this->{$this->modelClass}->Site->findByAlias($this->Session->read('MtSites.current'));
                $this->request->data['Site']['id'] = $site['Site']['id'];
            }
			$this->request->data[$this->modelClass]['tos'] = true;
			$this->request->data[$this->modelClass]['email_verified'] = true;

			if ($this->{$this->modelClass}->add($this->request->data)) {
				$this->Session->setFlash(__d('users', 'The User has been saved'));
				$this->redirect(array('action' => 'index'));
			}
		}
		$roles = $this->{$this->modelClass}->Rol->find('list');
		$this->set(compact( 'roles'));
		$this->render('admin_form');
	}




/**
 * Admin edit
 *
 * @param null $userId
 * @return void
 */
	public function edit($userId = null) {
		try {
			$result = $this->{$this->modelClass}->edit($userId, $this->request->data);
			if ($result === true) {
				$this->Session->setFlash(__d('users', 'User saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				unset($result[$this->modelClass]['password']);
				$this->request->data = $result;
			}
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect(array('action' => 'index'));
		}
		if (empty($this->request->data)) {
			$this->{$this->modelClass}->recursive = 1;
			$this->request->data = $this->{$this->modelClass}->read(null, $userId);
			unset($this->request->data[$this->modelClass]['password']);
		}

		$roles = $this->{$this->modelClass}->Rol->find('list');
		$this->set(compact( 'roles'));
		$this->render('admin_form');
	}


/**
 * Admin admin_edit_assign_other_site
 *
 * @param null $userId
 * @return void
 */
	public function assign_other_site($userId = null) {

		if ( $this->request->is('post') ) {
			$sites = $this->request->data['Site'];
			$this->request->data = $this->{$this->modelClass}->read(null, $userId);
			$this->request->data['Site'] = $sites;
			if ( $this->{$this->modelClass}->saveAll( $this->request->data) ) {
				$this->Session->setFlash(__d('users', 'User saved'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__d('users', 'User Couldn´t be Saved'), 'Risto.flash_error');
			}
		}

		 $this->{$this->modelClass}->recursive = 1;
		$this->request->data = $this->{$this->modelClass}->read(null, $userId);
		$currLogUser = $this->Auth->user();
		$sites = $currLogUser['Site'];
		$sites = Hash::combine($sites, '{n}.id', '{n}.name');
		$this->set(compact( 'sites'));
	}




/**
 * Delete a user account
 *
 * @param string $userId User ID
 * @return void
 */
	public function delete($userId = null) {
		if ($this->{$this->modelClass}->delete($userId)) {
			$this->Session->setFlash(__d('users', 'User deleted'));
		} else {
			$this->Session->setFlash(__d('users', 'Invalid User'));
		}

		$this->redirect(array('action' => 'index'));
	}



/**
 * User register action
 *
 * @return void
 */
	public function register() {
		if ($this->Auth->user()) {
			$this->Session->setFlash(__d('users', 'You are already registered and logged in!'));
			$this->redirect('/');
		}

		if (!empty($this->request->data)) {
			$user = $this->{$this->modelClass}->register($this->request->data);
			if ($user !== false) {
				$Event = new CakeEvent(
					'Users.Controller.Users.afterRegistration',
					$this,
					array(
						'data' => $this->request->data,
					)
				);
				$this->getEventManager()->dispatch($Event);
				if ($Event->isStopped()) {
					$this->redirect(array('action' => 'login'));
				}

				$this->_sendVerificationEmail($this->{$this->modelClass}->data);
				$this->Session->setFlash(__d('users', 'Your account has been created. You should receive an e-mail shortly to authenticate your account. Once validated you will be able to login.'));
				$this->redirect(array('action' => 'login'));
			} else {
				unset($this->request->data[$this->modelClass]['password']);
				unset($this->request->data[$this->modelClass]['temppassword']);
				$this->Session->setFlash(__d('users', 'Your account could not be created. Please, try again.'), 'default', array('class' => 'message warning'));
			}
		}
	}

/**
 * Common login action
 *
 * @return void
 */
	public function login() {
		$Event = new CakeEvent(
			'Users.Controller.Users.beforeLogin',
			$this,
			array(
				'data' => $this->request->data,
			)
		);

		$this->getEventManager()->dispatch($Event);

		if ($Event->isStopped()) {
			return;
		}

		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$Event = new CakeEvent(
					'Users.Controller.Users.afterLogin',
					$this,
					array(
						'data' => $this->request->data,
						'isFirstLogin' => !$this->Auth->user('last_login')
					)
				);

				$this->getEventManager()->dispatch($Event);

				$this->{$this->modelClass}->id = $this->Auth->user('id');
				$this->{$this->modelClass}->saveField('last_login', date('Y-m-d H:i:s'));

				if ($this->here == $this->Auth->loginRedirect) {
					$this->Auth->loginRedirect = '/';
				}
				$this->Session->setFlash(sprintf(__d('users', '%s you have successfully logged in'), $this->Auth->user($this->{$this->modelClass}->displayField)));
				if (!empty($this->request->data)) {
					$data = $this->request->data[$this->modelClass];
					if (empty($this->request->data[$this->modelClass]['remember_me'])) {
						$this->RememberMe->destroyCookie();
					} else {
						$this->_setCookie();
					}
				}

				if (empty($data[$this->modelClass]['return_to'])) {
					$data[$this->modelClass]['return_to'] = null;
				}

				// Checking for 2.3 but keeping a fallback for older versions
				if (method_exists($this->Auth, 'redirectUrl')) {
					$this->redirect($this->Auth->redirectUrl($data[$this->modelClass]['return_to']));
				} else {
					$this->redirect($this->Auth->redirect($data[$this->modelClass]['return_to']));
				}
			} else {
				$this->Auth->flash['element'] = 'Risto.flash_error';
				$this->Auth->flash(__d('users', 'Invalid e-mail / password combination. Please try again'));
			}
		}
		if (isset($this->request->params['named']['return_to'])) {
			$this->set('return_to', urldecode($this->request->params['named']['return_to']));
		} elseif (isset($this->request->query['return_to'])) {
			$this->set('return_to', $this->request->query['return_to']);
		} else {
			$this->set('return_to', false);
		}
		$allowRegistration = Configure::read('Users.allowRegistration');
		$this->set('allowRegistration', (is_null($allowRegistration) ? true : $allowRegistration));
	}



/**
 * Common logout action
 *
 * @return void
 */
	public function logout() {
		$user = $this->Auth->user();
		$this->Session->destroy();
		$this->RememberMe->destroyCookie();
		$this->Session->setFlash(sprintf(__d('users', '%s you have successfully logged out'), $user[$this->{$this->modelClass}->displayField]));
		$this->redirect($this->Auth->logout());
	}

/**
 * Checks if an email is already verified and if not renews the expiration time
 *
 * @return void
 */
	public function resend_verification() {
		if ($this->request->is('post')) {
			try {
				if ($this->{$this->modelClass}->checkEmailVerification($this->request->data)) {
					$this->_sendVerificationEmail($this->{$this->modelClass}->data);
					$this->Session->setFlash(__d('users', 'The email was resent. Please check your inbox.'));
					$this->redirect('login');
				} else {
					$this->Session->setFlash(__d('users', 'The email could not be sent. Please check errors.'));
				}
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
	}

/**
 * Confirm email action
 *
 * @param string $type Type, deprecated, will be removed. Its just still there for a smooth transistion.
 * @param string $token Token
 * @return void
 */
	public function verify($type = 'email', $token = null) {
		if ($type == 'reset') {
			// Backward compatiblity
			$this->request_new_password($token);
		}

		try {
			$this->{$this->modelClass}->verifyEmail($token);
			$this->Session->setFlash(__d('users', 'Your e-mail has been validated!'));
			return $this->redirect(array('action' => 'login'));
		} catch (RuntimeException $e) {
			$this->Session->setFlash($e->getMessage());
			return $this->redirect('/');
		}
	}

/**
 * This method will send a new password to the user
 *
 * @param string $token Token
 * @throws NotFoundException
 * @return void
 */
	public function request_new_password($token = null) {
		if (Configure::read('Users.sendPassword') !== true) {
			throw new NotFoundException();
		}

		$data = $this->{$this->modelClass}->verifyEmail($token);

		if (!$data) {
			$this->Session->setFlash(__d('users', 'The url you accessed is not longer valid'));
			return $this->redirect('/');
		}

		if ($this->{$this->modelClass}->save($data, array('validate' => false))) {
			$this->_sendNewPassword($data);
			$this->Session->setFlash(__d('users', 'Your password was sent to your registered email account'));
			$this->redirect(array('action' => 'login'));
		}

		$this->Session->setFlash(__d('users', 'There was an error verifying your account. Please check the email you were sent, and retry the verification link.'));
		$this->redirect('/');
	}

/**
 * Sends the password reset email
 *
 * @param array
 * @return void
 */
	protected function _sendNewPassword($userData) {
		$Email = $this->_getMailInstance();
		$Email->from(Configure::read('App.defaultEmail'))
			->to($userData[$this->modelClass]['email'])
			->replyTo(Configure::read('App.defaultEmail'))
			->return(Configure::read('App.defaultEmail'))
			->subject(env('HTTP_HOST') . ' ' . __d('users', 'Password Reset'))
			->template($this->_pluginDot() . 'new_password')
			->viewVars(array(
				'model' => $this->modelClass,
				'userData' => $userData))
			->send();
	}

/**
 * Allows the user to enter a new password, it needs to be confirmed by entering the old password
 *
 * @return void
 */
	public function change_password() {
		if ($this->request->is('post')) {
			$this->request->data[$this->modelClass]['id'] = $this->Auth->user('id');
			if ($this->{$this->modelClass}->changePassword($this->request->data)) {
				$this->Session->setFlash(__d('users', 'Password changed.'));
				// we don't want to keep the cookie with the old password around
				$this->RememberMe->destroyCookie();
				$this->redirect('/');
			}
		}
	}

/**
 * Reset Password Action
 *
 * Handles the trigger of the reset, also takes the token, validates it and let the user enter
 * a new password.
 *
 * @param string $token Token
 * @param string $user User Data
 * @return void
 */
	public function reset_password($token = null, $user = null) {
		if (empty($token)) {
			$admin = false;
			if ($user) {
				$this->request->data = $user;
				$admin = true;
			}
			$this->_sendPasswordReset($admin);
		} else {
			$this->_resetPassword($token);
		}
	}

/**
 * Sets a list of languages to the view which can be used in selects
 *
 * @deprecated No fallback provided, use the Utils plugin in your app directly
 * @param string $viewVar View variable name, default is languages
 * @throws MissingPluginException
 * @return void
 * @link https://github.com/CakeDC/utils
 */
	protected function _setLanguages($viewVar = 'languages') {
		$this->_pluginLoaded('Utils');

		$Languages = new Languages();
		$this->set($viewVar, $Languages->lists('locale'));
	}

/**
 * Sends the verification email
 *
 * This method is protected and not private so that classes that inherit this
 * controller can override this method to change the varification mail sending
 * in any possible way.
 *
 * @param string $to Receiver email address
 * @param array $options EmailComponent options
 * @return void
 */
	protected function _sendVerificationEmail($userData, $options = array()) {
		$defaults = array(
			'from' => Configure::read('App.defaultEmail'),
			'subject' => __d('users', 'Account verification'),
			'template' => $this->_pluginDot() . 'account_verification',
			'layout' => 'default',
			'emailFormat' => CakeEmail::MESSAGE_TEXT
		);

		$options = array_merge($defaults, $options);

		$Email = $this->_getMailInstance();
		$Email->to($userData[$this->modelClass]['email'])
			->from($options['from'])
			->emailFormat($options['emailFormat'])
			->subject($options['subject'])
			->template($options['template'], $options['layout'])
			->viewVars(array(
			'model' => $this->modelClass,
				'user' => $userData
			))
			->send();
	}

/**
 * Checks if the email is in the system and authenticated, if yes create the token
 * save it and send the user an email
 *
 * @param boolean $admin Admin boolean
 * @param array $options Options
 * @return void
 */
	protected function _sendPasswordReset($admin = null, $options = array()) {
		$defaults = array(
			'from' => Configure::read('App.defaultEmail'),
			'subject' => __d('users', 'Password Reset'),
			'template' => $this->_pluginDot() . 'password_reset_request',
			'emailFormat' => CakeEmail::MESSAGE_TEXT,
			'layout' => 'default'
		);

		$options = array_merge($defaults, $options);

		if (!empty($this->request->data)) {
			$user = $this->{$this->modelClass}->passwordReset($this->request->data);

			if (!empty($user)) {

				$Email = $this->_getMailInstance();
				$Email->to($user[$this->modelClass]['email'])
					->from($options['from'])
					->emailFormat($options['emailFormat'])
					->subject($options['subject'])
					->template($options['template'], $options['layout'])
					->viewVars(array(
					'model' => $this->modelClass,
					'user' => $this->{$this->modelClass}->data,
						'token' => $this->{$this->modelClass}->data[$this->modelClass]['password_token']))
					->send();

				if ($admin) {
					$this->Session->setFlash(sprintf(
						__d('users', '%s has been sent an email with instruction to reset their password.'),
						$user[$this->modelClass]['email']));
					$this->redirect(array('action' => 'index', 'admin' => true));
				} else {
					$this->Session->setFlash(__d('users', 'You should receive an email with further instructions shortly'));
					$this->redirect(array('action' => 'login'));
				}
			} else {
				$this->Session->setFlash(__d('users', 'No user was found with that email.'));
				$this->redirect($this->referer('/'));
			}
		}
		$this->render('request_password_change');
	}

/**
 * Sets the cookie to remember the user
 *
 * @param array RememberMe (Cookie) component properties as array, like array('domain' => 'yourdomain.com')
 * @param string Cookie data keyname for the userdata, its default is "User". This is set to User and NOT using the model alias to make sure it works with different apps with different user models across different (sub)domains.
 * @return void
 * @link http://book.cakephp.org/2.0/en/core-libraries/components/cookie.html
 */
	protected function _setCookie($options = array(), $cookieKey = 'rememberMe') {
		$this->RememberMe->settings['cookieKey'] = $cookieKey;
		$this->RememberMe->configureCookie($options);
		$this->RememberMe->setCookie();
	}

/**
 * This method allows the user to change his password if the reset token is correct
 *
 * @param string $token Token
 * @return void
 */
	protected function _resetPassword($token) {
		$user = $this->{$this->modelClass}->checkPasswordToken($token);
		if (empty($user)) {
			$this->Session->setFlash(__d('users', 'Invalid password reset token, try again.'));
			$this->redirect(array('action' => 'reset_password'));
			return;
		}

		if (!empty($this->request->data) && $this->{$this->modelClass}->resetPassword(Hash::merge($user, $this->request->data))) {
			if ($this->RememberMe->cookieIsSet()) {
				$this->Session->setFlash(__d('users', 'Password changed.'));
				$this->_setCookie();
			} else {
				$this->Session->setFlash(__d('users', 'Password changed, you can now login with your new password.'));
				$this->redirect($this->Auth->loginAction);
			}
		}

		$this->set('token', $token);
	}

/**
 * Returns a CakeEmail object
 *
 * @return object CakeEmail instance
 * @link http://book.cakephp.org/2.0/en/core-utility-libraries/email.html
 */
	protected function _getMailInstance() {
		return $this->{$this->modelClass}->getMailInstance();
	}

/**
 * Default isAuthorized method
 *
 * This is called to see if a user (when logged in) is able to access an action
 *
 * @param array $user
 * @return boolean True if allowed
 * @link http://book.cakephp.org/2.0/en/core-libraries/components/authentication.html#using-controllerauthorize
 */
	public function isAuthorized($user = null) {
		return parent::isAuthorized($user);
	}




	/**
	 * 
	 * -------------------------------------------------------------------------------------------
	 *
	 * 				OAUTH
	 */

	public function auth_login($provider) {
	    $result = $this->ExtAuth->login($provider);
	    if ($result['success']) {
	    	$Event = new CakeEvent(
				'Users.Controller.Users.afterLogin',
				$this,
				array(
					'data' => $this->request->data,
					'isFirstLogin' => !$this->Auth->user('last_login')
				)
			);

			$this->getEventManager()->dispatch($Event);

	    	$this->Auth->loginRedirect = $result['redirectURL'];
	        $this->redirect( $this->Auth->redirectUrl() );

	    } else {
	        $this->Session->setFlash($result['message']);
	        $this->redirect($this->Auth->redirectUrl());
	    }
	}

	public function auth_callback($provider) {
	    $result = $this->ExtAuth->loginCallback($provider);
	    if ($result['success']) {
	    	debug($result['profile']);
	        $this->__successfulExtAuth($result['profile'], $result['accessToken']);

	    } else {
	        $this->Session->setFlash($result['message']);
	    }
        $this->redirect($this->Auth->redirectUrl());
	}


	private function __successfulExtAuth($incomingProfile, $accessToken) {

	    // search for profile
	    $this->User->SocialProfile->recursive = -1;
	    $existingProfile = $this->User->SocialProfile->find('first', array(
	        'conditions' => array('oid' => $incomingProfile['oid'])
	    ));

	    if ($existingProfile) {

	        // Existing profile? log the associated user in.
	        $user = $this->User->find('first', array(
	            'conditions' => array('id' => $existingProfile['SocialProfile']['user_id'])
	        ));

	        $this->__doAuthLogin($user);
	    } else {
	    	// verificar que no se haya registrado con otra credencial
	    	$existingUser = $this->User->find('first', array(
		        'conditions' => array('email' => $incomingProfile['email'])
		    ));
		    if ( $existingUser ) {
		    	// User exists but never (logged using oauth) saved UserProfile => save UserProfile
	            $incomingProfile['user_id'] = $existingUser['User']['id'];
	            $incomingProfile['last_login'] = date('Y-m-d h:i:s');
	            $incomingProfile['access_token'] = serialize($accessToken);
	            $this->User->SocialProfile->save($incomingProfile);
	            $this->Session->setFlash(__('Your %s account has been linked to user %s.', $incomingProfile['provider'], $existingUser['User']['username']));

	            // log in
	            $this->__doAuthLogin($existingUser);

	            $this->redirect($this->Auth->redirectUrl());
		    }



	        // New profile.
	        if ($this->Auth->loggedIn()) {

	            // user logged in already, attach profile to logged in user.
	            // create social profile linked to current user
	            $incomingProfile['user_id'] = $this->Auth->user('id');
	            $this->User->SocialProfile->save($incomingProfile);
	            $this->Session->setFlash('Your ' . $incomingProfile['provider'] . ' account has been linked.');
	            $this->redirect($this->Auth->redirectUrl());

	        } else {

	            // no-one logged in, must be a registration.
	            unset($incomingProfile['id']);
	            $user = $this->User->register(array('User' => $incomingProfile), array('emailVerification'=>false));
	            if (!$user) {
	            	debug($this->User->validationErrors);
	            	throw new CakeException(__d('users', 'Error registering users'));
	            }
	            // create social profile linked to new user
	            $incomingProfile['user_id'] = $user['User']['id'];
	            $incomingProfile['last_login'] = date('Y-m-d h:i:s');
	            $incomingProfile['access_token'] = serialize($accessToken);
	            $this->User->SocialProfile->save($incomingProfile);

	            // log in
	            $this->__doAuthLogin($user);
	        }
	    }
	}

	private function __doAuthLogin($user) {
		debug($user);
	    if ($this->Auth->login($user['User'])) {
	        $user['last_login'] = date('Y-m-d H:i:s');
	        $this->User->save(array('User' => $user));

	        $this->Session->setFlash(sprintf(__d('users', '%s you have successfully logged in'), $this->Auth->user('username')));

	        $Event = new CakeEvent(
				'Users.Controller.Users.afterLogin',
				$this,
				array(
					'data' => $this->request->data,
					'isFirstLogin' => !$this->Auth->user('last_login')
				)
			);

			$this->getEventManager()->dispatch($Event);
			
	        $this->redirect($this->Auth->redirectUrl());
	    }
	}



}
