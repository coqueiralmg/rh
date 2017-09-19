<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


class AuditoriaController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_auditoria = TableRegistry::get('Auditoria');
        $t_usuarios = TableRegistry::get('Usuario');

        $limite_paginacao = Configure::read('Pagination.limit');
        $condicoes = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 3)
        {
            $responsavel = $this->request->query('responsavel');
            $ocorrencia = $this->request->query('ocorrencia');
            $data_inicial = $this->request->query('data_inicial');
            $data_final = $this->request->query('data_final');
            $ip = $this->request->query('ip');
            
            if($responsavel != '')
            {
                if($responsavel == 0)
                {
                    $condicoes['Usuario.id IS'] = null;
                }
                else
                {
                    $condicoes['Usuario.id'] = $responsavel;
                }
            }

            if($ocorrencia != '')
            {
                $condicoes['ocorrencia'] = $ocorrencia;
            }

            if($data_inicial != "" && $data_final != "")
            {
                $condicoes["data >="] = $this->Format->formatDateDB($data_inicial);
                $condicoes["data <="] = $this->Format->formatDateDB($data_final);
            }

            if($ip != '')
            {
                $condicoes['ip'] = $ip;
            }

            $data['responsavel'] = $responsavel;
            $data['ocorrencia'] = $ocorrencia;
            $data['data_inicial'] = $data_inicial;
            $data['data_final'] = $data_final;
            $data['ip'] = $ip;

            $this->request->data = $data;
        }

        $this->paginate = [
            'limit' => $limite_paginacao,
            'contain' => ['Usuario'],
            'conditions' => $condicoes,
            'order' => [
                'data' => 'DESC'
            ]
        ];

        $trilha = $this->paginate($t_auditoria);
        $total = $t_auditoria->find('all', ['contain' => ['Usuario'], 'conditions' => $condicoes])->count();

        $usuarios = $t_usuarios->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome'
        ]);

        $combo_usuarios[''] = 'Todos';
        $combo_usuarios[0] = 'Sem usuário associado';

        foreach($usuarios as $key => $value)
        {
            $combo_usuarios[$key] = $value;
        }

        $ocorrencias = $this->Auditoria->obterOcorrencias();
        
        $this->set('title', ' Auditoria do Sistema');
        $this->set('icon', 'fingerprint');
        $this->set('auditoria', $trilha);
        $this->set('qtd_total', $total);
        $this->set('data', $data);
        $this->set('usuarios', $combo_usuarios);
        $this->set('ocorrencias', $ocorrencias);
    }

    public function imprimir()
    {
        $t_auditoria = TableRegistry::get('Auditoria');
        $condicoes = array();

        if (count($this->request->getQueryParams()) > 3)
        {
            $responsavel = $this->request->query('responsavel');
            $ocorrencia = $this->request->query('ocorrencia');
            $data_inicial = $this->request->query('data_inicial');
            $data_final = $this->request->query('data_final');
            $ip = $this->request->query('ip');
            
            if($responsavel != '')
            {
                if($responsavel == 0)
                {
                    $condicoes['Usuario.id IS'] = null;
                }
                else
                {
                    $condicoes['Usuario.id'] = $responsavel;
                }
            }

            if($ocorrencia != '')
            {
                $condicoes['ocorrencia'] = $ocorrencia;
            }

            if($data_inicial != "" && $data_final != "")
            {
                $condicoes["data >="] = $this->Format->formatDateDB($data_inicial);
                $condicoes["data <="] = $this->Format->formatDateDB($data_final);
            }

            if($ip != '')
            {
                $condicoes['ip'] = $ip;
            }
        }

        $trilha = $t_auditoria->find('all', [
            'contain' => ['Usuario'], 
            'conditions' => $condicoes,
            'order' => [
                'data' => 'DESC'
            ]
        ]);

        $total = $trilha->count();

        $auditoria = [
            'ocorrencia' => 33,
            'descricao' => 'O usuário solicitou a impressão da trilha de auditoria.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito')) 
        {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Auditoria do Sistema');
        $this->set('icon', 'fingerprint');
        $this->set('auditoria', $trilha);
        $this->set('qtd_total', $total);
    }

    public function registro(int $id)
    {
        $t_auditoria = TableRegistry::get('Auditoria');

        $registro = $t_auditoria->get($id);

        if($registro->usuario != null && $registro->usuario > 0)
        {
            $registro = $t_auditoria->loadInto($registro, ['Usuario' => ['GrupoUsuario']]);
        }

        $auditoria = [
            'ocorrencia' => 32,
            'descricao' => 'O usuário visualizou um registro da trilha de auditoria.',
            'dado_adicional' => json_encode(['registro_analisado' => $id, 'ocorrencia' => $this->Auditoria->buscarNomeOcorrencia($registro->ocorrencia)]),
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito')) 
        {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->set('title', 'Detalhes do Registro de Auditoria do Sistema');
        $this->set('icon', 'fingerprint');
        $this->set('registro', $registro);
        $this->set('id', $id);
    }

    public function documento(int $id)
    {
        $t_auditoria = TableRegistry::get('Auditoria');
        
        $registro = $t_auditoria->get($id);

        if($registro->usuario != null && $registro->usuario > 0)
        {
            $registro = $t_auditoria->loadInto($registro, ['Usuario' => ['GrupoUsuario']]);
        }

        $propriedades = $registro->getOriginalValues();

        $auditoria = [
            'ocorrencia' => 33,
            'descricao' => 'O usuário solicitou a impressão da registro de auditoria.',
            'dado_adicional' => json_encode(['registro_impresso' => $id, 'dados_registro' => $propriedades]),
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito')) 
        {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Detalhes do Registro de Auditoria do Sistema');
        $this->set('registro', $registro);
    }

    public function delete($id)
    {
        try 
        {
            $t_auditoria = TableRegistry::get('Auditoria');

            $marcado = $t_auditoria->get($id);

            $propriedades = $marcado->getOriginalValues();

            $t_auditoria->delete($marcado);
            $this->Flash->greatSuccess('O registro de auditoria foi excluído com sucesso!');

            $auditoria = [
                'ocorrencia' => 34,
                'descricao' => 'O usuário excluiu um registro da trilha de auditoria.',
                'dado_adicional' => json_encode(['registro_excluido' => $id, 'dados_registro_excluido' => $propriedades]),
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
            $this->Flash->exception('Ocorreu um erro no sistema ao excluir o registro.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'index']);
        }
    }
}