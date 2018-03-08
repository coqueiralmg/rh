<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use \Exception;

class FuncionariosController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_funcionarios = TableRegistry::get('Funcionario');
        $t_tipo_funcionario = TableRegistry::get('TipoFuncionario');
        $t_empresas = TableRegistry::get('Empresa');

        $limite_paginacao = Configure::read('Pagination.limit');
        $condicoes = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 3)
        {
            $matricula = $this->request->query('matricula');
            $nome = $this->request->query('nome');
            $area = $this->request->query('area');
            $cargo = $this->request->query('cargo');
            $empresa = $this->request->query('empresa');
            $tipo = $this->request->query('tipo');
            $mostrar = $this->request->query('mostrar');

            if($matricula != "")
            {
                $condicoes['matricula'] =  $matricula;
            }

            if($nome != "")
            {
                $condicoes['nome LIKE'] = '%' . $nome . '%';
            }

            if($area != "")
            {
                $condicoes['area LIKE'] = '%' . $area . '%';
            }
            
            if($cargo != "")
            {
                $condicoes['cargo LIKE'] = '%' . $cargo . '%';
            }
            
            if ($empresa != "") 
            {
                $condicoes['empresa'] = $empresa;
            }

            if ($tipo != "") 
            {
                $condicoes['tipo'] = $tipo;
            }
            
            if($mostrar == 'E')
            {
                $condicoes['probatorio'] = true;
            }
            else
            {
                if ($mostrar != 'T') 
                {
                    $condicoes["ativo"] = ($mostrar == "A") ? "1" : "0";
                }
            }

            $data['matricula'] = $matricula;
            $data['nome'] = $nome;
            $data['area'] = $area;
            $data['cargo'] = $cargo;
            $data['empresa'] = $empresa;
            $data['tipo'] = $tipo;
            $data['mostrar'] = $mostrar;

            $this->request->data = $data;
        }

        $this->paginate = [
            'limit' => $limite_paginacao,
            'contain' => ['TipoFuncionario'],
            'conditions' => $condicoes,
            'order' => [
                'nome' => 'ASC'
            ]
        ];

        $funcionarios = $this->paginate($t_funcionarios);
        $qtd_total = $t_funcionarios->find('all', [
            'conditions' => $condicoes
            
        ])->count();

        $opcao_paginacao = [
            'name' => 'funcionários',
            'name_singular' => 'funcionário'
        ];

        $combo_mostra = [
            'T' => 'Todos', 
            'A' => 'Somente ativos', 
            'I' => 'Somente inativos',
            'E' => 'Somente funcionários em estágio probatório'
        ];

        $tipos_funcionarios = $t_tipo_funcionario->find('list', [
            'keyField' => 'id',
            'valueField' => 'descricao'
        ]);

        $empresas = $t_empresas->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome'
        ]);
        
        $this->set('title', 'Funcionários');
        $this->set('icon', 'work');
        $this->set('opcao_paginacao', $opcao_paginacao);
        $this->set('combo_mostra', $combo_mostra);
        $this->set('funcionarios', $funcionarios);
        $this->set('qtd_total', $qtd_total);
        $this->set('tipos_funcionarios', $tipos_funcionarios);
        $this->set('empresas', $empresas);
        $this->set('data', $data);
    }

    public function imprimir()
    {
        $t_funcionarios = TableRegistry::get('Funcionario');

        $condicoes = array();

        if (count($this->request->getQueryParams()) > 0)
        {
            $matricula = $this->request->query('matricula');
            $nome = $this->request->query('nome');
            $area = $this->request->query('area');
            $cargo = $this->request->query('cargo');
            $empresa = $this->request->query('empresa');
            $tipo = $this->request->query('tipo');
            $mostrar = $this->request->query('mostrar');

            if($matricula != "")
            {
                $condicoes['matricula'] =  $matricula;
            }

            if($nome != "")
            {
                $condicoes['nome LIKE'] = '%' . $nome . '%';
            }

            if($area != "")
            {
                $condicoes['area LIKE'] = '%' . $area . '%';
            }
            
            if($cargo != "")
            {
                $condicoes['cargo LIKE'] = '%' . $cargo . '%';
            }

            if ($empresa != "") 
            {
                $condicoes['empresa'] = $empresa;
            }

            if ($tipo != "") 
            {
                $condicoes['tipo'] = $tipo;
            }
            
            if($mostrar == 'E')
            {
                $condicoes['probatorio'] = true;
            }
            else
            {
                if ($mostrar != 'T') 
                {
                    $condicoes["ativo"] = ($mostrar == "A") ? "1" : "0";
                }
            }
        }

        $funcionarios = $t_funcionarios->query('all')->contain(['TipoFuncionario'])->where($condicoes)->order(['nome' => 'ASC']);

        $qtd_total = $funcionarios->count();

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão da lista de funcionários.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito')) {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');
        
        $this->set('title', 'Funcionários');
        $this->set('funcionarios', $funcionarios);
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

    public function view(int $id)
    {
        $this->redirect(['action' => 'consulta', $id]);
    }

    public function cadastro(int $id)
    {
        $title = ($id > 0) ? 'Edição de Funcionário' : 'Novo Funcionário';
        $icon = 'work';

        $t_funcionarios = TableRegistry::get('Funcionario');
        $t_tipo_funcionario = TableRegistry::get('TipoFuncionario');
        $t_empresas = TableRegistry::get('Empresa');

        $tipos_funcionarios = $t_tipo_funcionario->find('list', [
            'keyField' => 'id',
            'valueField' => 'descricao'
        ]);

        $empresas = $t_empresas->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome'
        ]);

        if ($id > 0) 
        {
            $funcionario = $t_funcionarios->get($id);
            $this->set('funcionario', $funcionario);
        } 
        else 
        {
            $this->set('funcionario', null);
        }

        $this->set('title', $title);
        $this->set('icon', $icon);
        $this->set('id', $id);
        $this->set('tipos_funcionarios', $tipos_funcionarios);
        $this->set('empresas', $empresas);
    }

    public function consulta(int $id)
    {
        $title = 'Consulta de Dados do Funcionário';
        $icon = 'work';

        $t_funcionarios = TableRegistry::get('Funcionario');
        $funcionario = $t_funcionarios->get($id, ['contain' => ['Empresa', 'TipoFuncionario']]);

        $this->set('title', $title);
        $this->set('icon', $icon);
        $this->set('id', $id);
        $this->set('funcionario', $funcionario);
    }

    public function documento(int $id)
    {
        $t_funcionarios = TableRegistry::get('Funcionario');
        $funcionario = $t_funcionarios->get($id, ['contain' => ['Empresa', 'TipoFuncionario']]);
        $propriedades = $funcionario->getOriginalValues();

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão de um determinado funcionário.',
            'dado_adicional' => json_encode(['registro_impresso' => $id, 'dados_registro' => $propriedades]),
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);
        
        if ($this->request->session()->read('UsuarioSuspeito')) {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');
        
        $this->set('title', 'Dados do Funcionário');
        $this->set('funcionario', $funcionario);
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
            $t_funcionarios = TableRegistry::get('Funcionario');
            $t_atestados = TableRegistry::get('Atestado');

            $exclui_atestados = $this->request->query('atestados');

            $marcado = $t_funcionarios->get($id);
            $nome = $marcado->nome;
            $propriedades = $marcado->getOriginalValues();

            if($exclui_atestados)
            {
                $t_atestados->deleteAll(['funcionario' => $id]);
            }
            else
            {
                $qtd = $t_atestados->find('all', [
                    'conditions' => [
                        'funcionario' => $id
                    ]
                ])->count();

                if($qtd > 0)
                {
                    throw new Exception('Este funcionário não pode ser excluído, porque existem atestados associados a ele. Verifique os seus atestados antes de excluir definitivamente ou deixe-o inativo.');
                }
            }

            $t_funcionarios->delete($marcado);
            $this->Flash->greatSuccess('O funcionário ' . $nome . ' foi excluído com sucesso!');

            $auditoria = [
                'ocorrencia' => 23,
                'descricao' => 'O usuário excluiu um determinado funcionário do sistema.',
                'dado_adicional' => json_encode(['funcionario_excluido' => $id, 'dados_funcionario_excluido' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if ($this->request->session()->read('UsuarioSuspeito')) 
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'index']);
        } 
        catch (Exception $ex) 
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao excluir o funcionário', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'index']);
        }
    }

    public function listar()
    {
        if ($this->request->is('ajax'))
        {
            $t_funcionarios = TableRegistry::get('Funcionario');
            $this->autoRender = false;
            $nome = $this->request->query("nome");

            $funcionarios = $t_funcionarios->find('all', [
                'fields' => ['id', 'nome'],
                'conditions' => [
                    'nome LIKE' => '%' . $nome . '%',
                    'ativo' => true
                ]
            ]);

            $this->response->header('Content-Type', 'application/json');
            echo json_encode($funcionarios);
        }
    }

    protected function insert()
    {
        try 
        {
            $t_funcionarios = TableRegistry::get('Funcionario');
            $entity = $t_funcionarios->newEntity($this->request->data());

            $qcpf = $t_funcionarios->find('all', [
                'conditions' => [
                    'cpf' => $this->Format->clearMask($entity->cpf)
                ]
            ])->count();

            if($qcpf > 0)
            {
                throw new Exception("Existe um funcionário com CPF informado.");
            }
            
            if($entity->pis != '')
            {
                $qpis = $t_funcionarios->find('all', [
                    'conditions' => [
                        'pis' => $entity->pis
                    ]
                ])->count();

                if($qpis > 0)
                {
                    throw new Exception("Existe um funcionário com PIS informado.");
                }
            }
            else
            {
                $entity->pis = null;
            }

            $entity->data_admissao = $this->Format->formatDateDB($entity->data_admissao);
            $entity->cpf = $this->Format->clearMask($entity->cpf);
            $entity->tipo = $this->request->getData('tipo');
            $entity->empresa = $this->request->getData('empresa');

            $t_funcionarios->save($entity);
            $this->Flash->greatSuccess('Funcionário salvo com sucesso');

            $propriedades = $entity->getOriginalValues();

            $auditoria = [
                'ocorrencia' => 21,
                'descricao' => 'O usuário cadastrou o novo funcionário.',
                'dado_adicional' => json_encode(['id_novo_funcionario' => $entity->id, 'campos' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if ($this->request->session()->read('UsuarioSuspeito')) {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'cadastro', $entity->id]);
        } 
        catch (Exception $ex) 
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o funcionário', [
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
            $t_funcionarios = TableRegistry::get('Funcionario');
            $entity = $t_funcionarios->get($id);

            $t_funcionarios->patchEntity($entity, $this->request->data());
            
            $qcpf = $t_funcionarios->find('all', [
                'conditions' => [
                    'cpf' => $this->Format->clearMask($entity->cpf),
                    'id <>' => $id
                ]
            ])->count();

            if($qcpf > 0)
            {
                throw new Exception("Existe um funcionário com CPF informado.");
            }
            
            if($entity->pis != '')
            {
                $qpis = $t_funcionarios->find('all', [
                    'conditions' => [
                        'pis' => $entity->pis,
                        'id <>' => $id
                    ]
                ])->count();

                if($qpis > 0)
                {
                    throw new Exception("Existe um funcionário com PIS informado.");
                }
            }
            else
            {
                $entity->pis = null;
            }

            $entity->data_admissao = $this->Format->formatDateDB($entity->data_admissao);
            $entity->cpf = $this->Format->clearMask($entity->cpf);
            $entity->tipo = $this->request->getData('tipo');
            $entity->empresa = $this->request->getData('empresa');

            $propriedades = $this->Auditoria->changedOriginalFields($entity);
            $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

            $t_funcionarios->save($entity);
            $this->Flash->greatSuccess('Funcionário salvo com sucesso');

            $auditoria = [
                'ocorrencia' => 22,
                'descricao' => 'O usuário modificou os dados de um determinado funcionário.',
                'dado_adicional' => json_encode(['funcionario_modificado' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if ($this->request->session()->read('UsuarioSuspeito')) {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'cadastro', $id]);
        } 
        catch (Exception $ex) 
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o funcionário', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'cadastro', $id]);
        }
    }
}
