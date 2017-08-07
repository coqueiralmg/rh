<?php

namespace App\Controller\Component;

use Cake\Cache\Cache;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

/**
 * Classe que representa o componente de controle de acesso ao usuário
 * @package App\Controller\Component
 */
class MembershipComponent extends Component
{
    protected $history;

    public function initialize(array $config)
    {

    }

    /**
     * Faz tratamento de permissão de usuário por meio de um controle e de ação selecionada.
     * @param array $url Endereço montado pelo array de controller e action
     * @param int $userID ID do usuário
     * @return bool Se o mesmo usuário tem a permissão de acessar a tela.
     */
    public function handleRole(array $url, int $userID)
    {
        $funcoes = $this->getFunctions($url);
        $autorizado = false;

        if(count($funcoes) > 0)
        {
            foreach($funcoes as $funcao)
            {
                $user_functions = $this->request->session()->check('USER_FUNCTIONS') ? $this->request->session()->read('USER_FUNCTIONS') : $this->getFunctionsUser($userID);

                foreach($user_functions as $chave => $nome)
                {
                    if($chave == $funcao)
                    {
                        $autorizado = true;
                        break 2;
                    }
                }
            }
        }

        return $autorizado;
    }

    /**
     * Obtém a chave da função de acordo com o controller e action selecionado.
     * @param array $url Endereço montado pelo array de controller e action
     * @return array Chave da função cadastrada no sistema ou nulo, se o sistema não encontrar.
     */
    public function getFunctions(array $url)
    {
        $actionRoles = $this->actionRoles();
        $funcoes = array();

        foreach ($actionRoles as $key => $values)
        {
            foreach($values as $value)
            {
                if (($url["controller"] == $value["controller"]) && ($url["action"] == $value["action"]))
                {
                    array_push($funcoes, $key);
                }
            }
        }

        return $funcoes;
    }

    /**
     * Obtem a roles do usuário de acorodo com o controller e action selecionado.
     * @param array $url Endereço montado pelo array de controller e action
     * @return array Roles da funções selecionada ou nulo, caso se o sistema não encontrar.
     */
    public function getRoles(array $url)
    {
        $actionRoles = $this->actionRoles();
        $roles = array();

        foreach ($actionRoles as $key => $values)
        {
            foreach($values as $value)
            {
                if (($url["controller"] == $value["controller"]) && ($url["action"] == $value["action"])) {
                    $roles[$key] = $value;
                }
            }
        }

        return $roles;
    }

    /**
     * Obtém a lista de funções de usuário cadastrado no banco
     * @param int $userID ID de um usuário do sistema.
     * @return array Lista de funções do usuário.
     */
    private function getFunctionsUser(int $userID)
    {
        $usuarios = TableRegistry::get('Usuario');
        $grupos = TableRegistry::get('GrupoUsuario');

        $usuario = $usuarios->get($userID);
        $grupo = $grupos->get($usuario->grupo, ['contain' => ['Funcao']]);
        $fs = array();

        foreach($grupo->funcoes as $func)
        {
            $fs[$func->chave] = $func->nome;
        }

        $this->request->session()->write('USER_FUNCTIONS', $fs);

        return $fs;
    }


    /**
     * Obtém a lista de roles e suas respectivas ações
     * @return array Lista de roles padrão do sistema.
     */
    public function actionRoles()
    {
        $actionRoles = array();

        if(Cache::read('ACTION_ROLES') != null)
        {
            $actionRoles = Cache::read('ACTION_ROLES');
        }
        else
        {
            $t_funcao = TableRegistry::get('Funcao');
            $t_acao = TableRegistry::get('Acao');

            $funcoes = $t_funcao->find('all');

            foreach($funcoes as $funcao)
            {
                $action = array();
                $query = $t_acao->find('all', [
                    'conditions' => [
                        'funcao' => $funcao->id
                    ]
                ]);
                
                foreach($query as $acao)
                {
                    $valor = [
                        'controller' => $acao->controller,
                        'action' => $acao->action
                    ];

                    array_push($action, $valor);
                }

                $actionRoles[$funcao->chave] = $action;
            }

            Cache::write('ACTION_ROLES', $actionRoles);
        }

        return $actionRoles;
    }
}
