<?php

namespace App\Controller;

use App\Model\Table\BaseTable;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use Cake\ORM\Entity;
use \Exception;

class GruposController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_grupos = TableRegistry::get('GrupoUsuario');
        $limite_paginacao = Configure::read('Pagination.limit');

        $this->paginate = [
            'limit' => $limite_paginacao
        ];

        $grupos = $this->paginate($t_grupos);
        $qtd_total = $t_grupos->find('all')->count();
        
        $this->set('title', 'Lista de Grupos Usuários');
        $this->set('icon', 'group_work');
        $this->set('grupos', $grupos);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
    }

    public function imprimir()
    {
        $t_grupos = TableRegistry::get('GrupoUsuario');
        $grupos = $t_grupos->find('all');
        $qtd_total = $grupos->count();

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão de listagem de grupos de usuário.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Lista de Grupos Usuários');
        $this->set('grupos', $grupos);
        $this->set('qtd_total', $qtd_total);
    }

    public function add()
    {
        $this->redirect(['action' => 'cadastro', 0]);
    }

    public function edit(int $id)
    {
        $this->redirect(['action' => 'cadastro', $id]);
    }

    public function cadastro(int $id)
    {
        $title = ($id > 0) ? 'Edição do Grupo' : 'Novo Grupo';
        $icon = ($id > 0) ? 'group' : 'group_add';

        $t_grupo_usuario = TableRegistry::get('GrupoUsuario');
        $t_funcao = TableRegistry::get('Funcao');
        $t_grupo_funcao = TableRegistry::get('GrupoFuncao');

        $funcoes = $t_funcao->find('all', ['order' => ['ordem' => 'asc']]);
        $grupos_funcoes = $t_grupo_funcao->find('all', ['order' => ['ordem' => 'asc']]);

        if($id > 0)
        {
            $grupo_usuario = $t_grupo_usuario->get($id);

            $query = $t_grupo_usuario->find('all', [
                'contain' => ['Funcao'],
                'conditions' => [
                    'id' => $id
                ]
            ]);

            $pivot = $query->first();
            $fx = $pivot->funcoes;
            $fy = array();

            foreach($fx as $f)
            {
                $fy[$f->chave] = $f->nome;
            }

            $this->set('grupo_usuario', $grupo_usuario);
            $this->set('funcoes_grupo', $fy);
        }
        else
        {
            $this->set('grupo_usuario', null);
            $this->set('funcoes_grupo', array());
        }

        $this->set('title', $title);
        $this->set('icon', $icon);
        $this->set('funcoes', $funcoes);
        $this->set('id', $id);
        $this->set('grupos_funcoes', $grupos_funcoes);
    }

    public function save(int $id)
    {
        if ($this->request->is('post'))
        {
            $this->insert();
        }
        else if($this->request->is('put'))
        {
            $this->update($id);
        }
    }

    public function delete(int $id)
    {
        try
        {
            $t_grupos = TableRegistry::get('GrupoUsuario');
            $t_usuarios = TableRegistry::get('Usuario');
            $conn = ConnectionManager::get(BaseTable::defaultConnectionName());
            
            $marcado = $t_grupos->get($id);
            $nome = $marcado->nome;
            $propriedades = $marcado->getOriginalValues();

            $qu = $t_usuarios->find('all', [
                'conditions' => [
                    'grupo' => $id
                ]
            ])->count();

            if($qu > 0)
            {
                throw new Exception('Este grupo de usuário não pode ser excluído, porque existem usuários associados a este grupo. Verifique os usuários associados a ele ou deixe o mesmo grupo inativo.');
            }

            $conn->delete('funcao_grupo', [
                'grupo_id' => $id
            ]);

            $t_grupos->delete($marcado);
            $this->Flash->greatSuccess('O grupo de usuário ' . $nome . ' foi excluído com sucesso!');

            $auditoria = [
                'ocorrencia' => 15,
                'descricao' => 'O usuário excluiu um determinado grupo de usuário do sistema.',
                'dado_adicional' => json_encode(['grupo_usuario_excluido' => $id, 'dados_grupo_usuario_excluido' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['controller' => 'grupos', 'action' => 'index']);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao excluir o grupo de usuário', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'index']);
        }
    }

    protected function insert()
    {
        try
        {
            $t_grupo_usuario = TableRegistry::get('GrupoUsuario');

            $entity = $t_grupo_usuario->newEntity($this->request->data());
            $campos = $entity->visibleProperties();
            
            $propriedades = $entity->getOriginalValues();
            $t_grupo_usuario->save($entity);

            $id_grupo = $entity->id;

            $auditoria_funcoes = $this->atualizarFuncoesGrupos($entity, $id_grupo, $campos, false);

            $this->Flash->greatSuccess('Grupo de usuário salvo com sucesso!');

            $auditoria = [
                'ocorrencia' => 13,
                'descricao' => 'O usuário criou um novo grupo de usuário.',
                'dado_adicional' => json_encode([
                    'id_novo_grupo_usuario' => $entity->id,
                    'campos' => $propriedades,
                    'funcoes_associadas' => $auditoria_funcoes
                ]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'cadastro', $id_grupo]);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o grupo de usuário', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'cadastro', 0]);
        }
    }

    protected function update(int $id)
    {
        try
        {
            $t_grupo_usuario = TableRegistry::get('GrupoUsuario');

            $entity = $t_grupo_usuario->get($id);
            $t_grupo_usuario->patchEntity($entity, $this->request->data());

            $campos = $entity->visibleProperties();
            
            $propriedades = $this->Auditoria->changedOriginalFields($entity);
            $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

            $t_grupo_usuario->save($entity);

            $auditoria_funcoes = $this->atualizarFuncoesGrupos($entity, $id, $campos, true);

            $this->request->session()->delete('USER_FUNCTIONS');
            $this->Flash->greatSuccess('Grupo de usuário atualizado com sucesso!');

            $auditoria = [
                'ocorrencia' => 14,
                'descricao' => 'O usuário modificou os dados de um determinado grupo de usuário.',
                'dado_adicional' => json_encode([
                    'grupo_usuario_modificado' => $id,
                    'valores_originais' => $propriedades,
                    'valores_modificados' => $modificadas,
                    'funcoes_associadas' => $auditoria_funcoes
                ]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'cadastro', $id]);

        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o grupo de usuário', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'cadastro', $id]);
        }
    }

    private function atualizarFuncoesGrupos(Entity $entity, int $id_grupo, array $campos, bool $clear = false)
    {
        $t_funcoes = TableRegistry::get('Funcao');
        $t_grupo_usuario = TableRegistry::get('GrupoUsuario');

        $conn = ConnectionManager::get(BaseTable::defaultConnectionName());

        $f_antigas = array();
        $f_novas = array();

        if($clear)
        {
            $e = $t_grupo_usuario->get($id_grupo, [
                'contain' => ['Funcao']
            ]);

            foreach($e->funcoes as $func)
            {
                $f_antigas[$func->chave] = $func->nome;
            }

            $conn->delete('funcao_grupo', [
                'grupo_id' => $id_grupo
            ]);
        }

        foreach($campos as $campo)
        {
            if(strpos($campo, 'chk_') !== false && $entity->get($campo) == 1)
            {
                $chave = str_replace('chk_', '', $campo);
                $funcao = $t_funcoes->find('all', [
                    'conditions' => [
                        'chave' => $chave
                    ]
                ])->first();

                $id_funcao = $funcao->id;

                $conn->insert('funcao_grupo', [
                    'funcao_id' => $id_funcao,
                    'grupo_id' => $id_grupo
                ]);

                $f_novas[$chave] = $funcao->nome;

            }
        }

        $auditoria_funcoes = [
            'funcoes_antigas' => $f_antigas,
            'funcoes_novas' => $f_novas
        ];

        return $auditoria_funcoes;
    }

}