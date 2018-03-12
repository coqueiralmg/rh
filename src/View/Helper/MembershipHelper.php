<?php

namespace App\View\Helper;

use Cake\Cache\Cache;
use Cake\Network\Exception\InternalErrorException;
use Cake\ORM\TableRegistry;
use Cake\View\Helper;

class MembershipHelper extends Helper
{
    /**
     * Faz tratamento de permissões de tela para usuário.
     * @param string $function Chave da função
     * @param mixed $userID ID o nickname do usuario
     * @return boolean Se o usuário possui a permissão de acessar o componente.
     * @throws InternalErrorException O método de validação de componentes, está chamando uma função inválida.
     */
    public function handleRole($function, $userID = null)
    {
        if (!isset($userID)) {
            $userID = $this->getUser();

            if ($userID == null) {
                return false;
            }
        }

        if (!$this->isFunction($function)) {
            throw new InternalErrorException("O método de validação de componentes, está chamando uma função inválida.");
        }

        $user_functions = $this->request->session()->check('USER_FUNCTIONS') ? $this->request->session()->read('USER_FUNCTIONS') : $this->getFunctionsUser($userID);
        $autorizado = false;

        foreach ($user_functions as $chave => $nome) {
            if ($chave == $function) {
                $autorizado = true;
                break;
            }
        }

        return $autorizado;
    }

    /**
     * Faz tratamento de um conjunto de permissões de tela para usuário.
     * @param array $menu Coleção de chaves de itens do menu.
     * @param string $chave Chave de busca de itens de menu.
     * @return boolean Se o usuário possui a permissão de acessar um conjunto de componentes.
     * @throws InternalErrorException O método de validação de componentes, está chamando uma função inválida.
     */
    public function handleRoles()
    {
        $qtd_args = func_num_args();
        $args = func_get_args();
        $autorizado = false;

        for ($i = 0; $i < $qtd_args && !$autorizado; $i++) {
            $chave = $args[$i];
            $autorizado = $this->handleRole($chave);
        }

        return $autorizado;
    }

    /**
     * Executa todo o processo de validação de menu, verificando se o mesmo usuário tem ou não a permissão de acessar o item do menu.
     * @param string $chave Chave do menu do sistema.
     * @return boolean Se o usuário possui ou não a permissão de acessar o sistema.
     */
    public function handleMenu($chave)
    {
        $menu = $this->actionsMenu();

        $item = $this->getItemMenu($menu, $chave);
        return $item["active"];
    }

    /**
    * Executa o processo de validação de menu, juntamente com seus submenus
    * @param array $chaves Chaves do menu do sistema, que fazem parte do submenu.
    * @return boolean Se o usuário possui ou não a permissão de acessar o sistema.
    */
    public function handleSubmenus()
    {
        $qtd_args = func_num_args();
        $args = func_get_args();
        $autorizado = false;

        for ($i = 0; $i < $qtd_args && !$autorizado; $i++) {
            $chave = $args[$i];
            $autorizado = $this->handleMenu($chave);
        }

        return $autorizado;
    }

    /**
     * Obtém o item de menu
     * @param array $menu Coleção de itens de menu.
     * @param string $chave Chave de busca de itens de menu.
     * @return array Item de menu.
     */
    private function getItemMenu($menu, $chave)
    {
        $it = null;

        foreach ($menu as $item) {
            if ($item["chave"] == $chave) {
                $it = $item;
                break;
            }
        }

        return $it;
    }

    /**
     * Obtém o usuário corrente logado do sistema.
     * @return int ID do usuário;
     */
    private function getUser()
    {
        return $this->request->session()->read('UsuarioID');
    }

    /**
     * Verifica se a chave selecionada é de uma função existente
     * @param string $function Chave da função.
     * @return boolean A função é válida
     */
    private function isFunction(string $function)
    {
        $roles = $this->actionRoles();
        $valido = false;

        foreach ($roles as $key => $value) {
            if ($function == $key) {
                $valido = true;
            }
        }

        return $valido;
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

        foreach ($grupo->funcoes as $func) {
            $fs[$func->chave] = $func->nome;
        }

        $this->request->session()->write('USER_FUNCTIONS', $fs);

        return $fs;
    }

    /**
     * Obtém a lista de roles do sistema
     * @return array Lista de roles padrão do sistema.
     */
    private function actionRoles()
    {
        $actionRoles = array();

        if (Cache::read('ACTION_ROLES') != null) {
            $actionRoles = Cache::read('ACTION_ROLES');
        } else {
            $t_funcao = TableRegistry::get('Funcao');
            $t_acao = TableRegistry::get('Acao');

            $funcoes = $t_funcao->find('all');

            foreach ($funcoes as $funcao) {
                $action = array();
                $query = $t_acao->find('all', [
                    'conditions' => [
                        'funcao' => $funcao->id
                    ]
                ]);
                
                foreach ($query as $acao) {
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

    /**
    * Retorna uma lista de chaves de permissão do menu
    * @return Lista de permissões do menu.
    */
    private function actionsMenu()
    {
        return [
            ['chave' => 'painel', 'active' => true],
            ['chave' => 'usuarios', 'active' => $this->handleRole('listar_usuarios')],
            ['chave' => 'grupo_usuarios', 'active' => $this->handleRole('listar_grupos_usuarios')],
            ['chave' => 'firewall', 'active' => $this->handleRole('listar_ips_firewall')],
            ['chave' => 'funcionarios', 'active' => $this->handleRole('listar_funcionarios')],
            ['chave' => 'atestados', 'active' => $this->handleRole('listar_atestados')],
            ['chave' => 'medicos', 'active' => $this->handleRole('listar_medicos')],
            ['chave' => 'cid', 'active' => $this->handleRole('listar_cid')],
            ['chave' => 'relatorios', 'active' => $this->handleRole('relatorio_visao')],
            ['chave' => 'auditoria', 'active' => $this->handleRole('listar_auditoria')]
        ];
    }
}
