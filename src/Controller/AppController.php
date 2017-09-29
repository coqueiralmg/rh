<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Log\Log;
use Cake\Network\Exception\ForbiddenException;
use Cake\ORM\TableRegistry;
use \Exception;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Define se a tela irá validar a role dentro do sistema.
     * @var bool
     */
    protected $validationRole;
    
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        $this->loadComponent('Auditoria');
        $this->loadComponent('Sender');
        $this->loadComponent('Firewall');
        $this->loadComponent('Monitoria');
        $this->loadComponent('Format');
        $this->loadComponent('Membership');
        $this->loadComponent('Entries');

        $this->registerAccessLog();

        $this->validationRole = true;
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }

        if ($this->validationRole) {
            $this->configurarAcesso();
            $this->controlAuth();

            if ($this->isAuthorized()) {
                $this->carregarDadosSistema();
                $this->accessRole();
            }
        }
    }

    /**
     * Controle simplificado de autenticação do usuário
     */
    protected function controlAuth()
    {
        if (!$this->isAuthorized()) {
            $this->redirectLogin("A sessão foi expirada!");
        }
    }

    /**
     * Verifica se a sessão do usuário foi criada e ativa, ou seja, se o mesmo efetuou o login.
     *
     * @return boolean Se o usuário está logado no sistema e com acesso
     */
    protected function isAuthorized()
    {
        return $this->request->session()->check('Usuario');
    }


    /**
     * Verifica se o usuário possui a permissão de acessar a tela do sistema.
     * @throws ForbiddenException O usuário não tem a permissão de acessar a determinada tela do sistema.
     */
    protected function accessRole()
    {
        $controller = strtolower($this->request->param('controller'));
        $action = strtolower($this->request->param('action'));

        $url = ["controller" => $controller, "action" => $action];
        $userID = (int) $this->request->session()->read('UsuarioID');

        /*
        //Setagem de variáveis para debug
        $this->set('url', $url);
        $this->set('function', $this->Membership->getFunctions($url));
        $this->set('role', $this->Membership->getRoles($url));
        $this->set('roles', $this->Membership->actionRoles());
        */

        if (!$this->Membership->handleRole($url, $userID)) {
            throw new ForbiddenException();
        }
    }

    /**
     * Redireciona para a tela de login com uma mensagem.
     *
     * @param string $mensagem Mensagem a ser exibida na tela de login.
     * @param bool $error Se a mensagem de erro é sucesso.
     */
    protected function redirectLogin(string $mensagem, bool $error = true)
    {
        if ($error) {
            $this->Flash->error($mensagem);
        } else {
            $this->Flash->success($mensagem);
        }

        $this->redirect(['controller' => 'system', 'action' => 'login']);
    }

    protected function configurarAcesso()
    {
        if (!$this->Firewall->verificar()) {
            $mensagem = "O acesso ao sistema está bloqueado para este endereço de IP. Caso tenha sido bloqueado por engano, entre em contato com administrador.";
            $this->redirect(['controller' => 'system', 'action' => 'fail', base64_encode($mensagem)]);
        }
    }

    protected function carregarDadosSistema()
    {
        $t_logs = TableRegistry::get('Auditoria');
        $query = $t_logs->find('all', [
            'conditions' => [
                'usuario' => $this->request->session()->read('UsuarioID'),
                'ocorrencia' => 1
            ],
            'limit' => 1,
            'page' => 2,
            'order' => ['data' => 'DESC']
        ]);

        
        $log = $query->first();

        if ($log != null) {
            $this->set('ultimo_acesso', $log->data);
        } else {
            $this->set('ultimo_acesso', null);
        }
    }

    private function registerAccessLog()
    {
        $this->registerLocalLog();
        $this->registerHostLog();
    }

    private function registerLocalLog()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $method = $this->request->method();
        $scheme = $this->request->scheme();
        $host = $this->request->host();
        $here = $this->request->here();
        $agent = $_SERVER['HTTP_USER_AGENT'];

        $registro = "$ip    $method   $scheme://$host$here    $agent";
        
        Log::info($registro, ['register']);
    }

    private function registerHostLog()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $method = $this->request->method();
        $scheme = $this->request->scheme();
        $host = $this->request->host();
        $here = $this->request->here();
        $agent = $_SERVER['HTTP_USER_AGENT'];

        $data = [
            'ip' => $ip,
            'method' => $method,
            'url' => "$scheme://$host$here",
            'agent' => $agent
        ];

        $registro = json_encode($data);

        $this->Entries->register($registro);
    }
}
