<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Datasource\ConnectionInterface;
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\File;
use Cake\Log\Log;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use Cake\Utility\Xml;
use \DateInterval;
use \DateTime;
use \Exception;
use \PDO;

class RelatoriosController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_usuarios = TableRegistry::get('Usuario');
        $t_funcionarios = TableRegistry::get('Funcionario');
        $t_atestados = TableRegistry::get('Atestado');
        $t_medicos = TableRegistry::get('Medico');

        $usuarios = $t_usuarios->find('all')->count();
        $funcionarios = $t_funcionarios->find('all')->count();
        $atestados = $t_atestados->find('all')->count();
        $medicos = $t_medicos->find('all')->count();
        
        $this->set('title', 'Visão Geral dos Relatórios');
        $this->set('icon', 'library_books');
        $this->set('usuarios', $usuarios);
        $this->set('funcionarios', $funcionarios);
        $this->set('atestados', $atestados);
        $this->set('medicos', $medicos);
    }

    public function funcionariosatestados()
    {
        $datasource = Configure::read('Database.datasource');
        $connection = ConnectionManager::get($datasource);
        $link = $this->abrirBanco($connection);

        $t_tipo_funcionario = TableRegistry::get('TipoFuncionario');
        $t_empresas = TableRegistry::get('Empresa');

        $relatorio = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 0)
        {
            $empresa = $this->request->query('empresa');
            $tipo_funcionario = $this->request->query('tipo_funcionario');
            $exibir = $this->request->query('exibir');
            $mostrar = $this->request->query('mostrar');

            $data['empresa'] = $empresa;
            $data['tipo_funcionario'] = $tipo_funcionario;
            $data['exibir'] = $exibir;
            $data['mostrar'] = $mostrar;

            $this->request->data = $data;
        }

        $query = $this->montarRelatorioFuncionariosAtestado($data);
        $relatorio = $link->query($query);

        if(count($data) == 0)
        {
            $data['mostrar'] = 'T';
        }

        $tipos_funcionarios = $t_tipo_funcionario->find('list', [
            'keyField' => 'id',
            'valueField' => 'descricao'
        ]);

        $empresas = $t_empresas->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome'
        ]);

        $combo_exibir = [
            'T' => 'Todos',
            'A' => 'Somente os funcionários que solicitatam o atestado',
            'E' => 'Somente funcionários em estágio probatório'
        ];

        $combo_mostra = [
            'T' => 'Todos os atestados cadastrados', 
            '1' => 'Atestados cadastrados no último mês', 
            '3' => 'Atestados cadastrados nos últimos 3 meses',
            '6' => 'Atestados cadastrados nos últimos 6 meses',
            '12' => 'Atestados cadastrados nos últimos 12 meses'
        ];
        
        $this->set('title', 'Relatório de Funcionários por Atestado');
        $this->set('icon', 'assignment_ind');
        $this->set('tipos_funcionarios', $tipos_funcionarios);
        $this->set('empresas', $empresas);
        $this->set('combo_mostra', $combo_mostra);
        $this->set('combo_exibir', $combo_exibir);
        $this->set('data', $data);
        $this->set('relatorio', $relatorio);
    }

    public function imprimirfuncionariosatestados()
    {
        $datasource = Configure::read('Database.datasource');
        $connection = ConnectionManager::get($datasource);
        $link = $this->abrirBanco($connection);

        $relatorio = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 3)
        {
            $empresa = $this->request->query('empresa');
            $tipo_funcionario = $this->request->query('tipo_funcionario');
            $exibir = $this->request->query('exibir');
            $mostrar = $this->request->query('mostrar');

            $data['empresa'] = $empresa;
            $data['tipo_funcionario'] = $tipo_funcionario;
            $data['exibir'] = $exibir;
            $data['mostrar'] = $mostrar;
        }

        $query = $this->montarRelatorioFuncionariosAtestado($data);
        $relatorio = $link->query($query);

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão de Relatório de Funcionários por Atestado.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito')) {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Relatório de Funcionários por Atestado');
        $this->set('relatorio', $relatorio);
    }

    public function atestadosfuncionario()
    {
        $t_atestados = TableRegistry::get('Atestado');
        $t_funcionarios = TableRegistry::get('Funcionario');
        
        $idFuncionario = $this->request->query('idFuncionario');
        $mostrar = $this->request->query('periodo');

        $funcionario = $t_funcionarios->get($idFuncionario);
        $atestados = null;

        $opcoes_subtitulos = [
            'T' => 'Atestados emitidos para o funcionário ' . $funcionario->nome, 
            '1' => 'Atestados emitidos para o funcionário ' . $funcionario->nome . ' nos últimos 30 dias',  
            '3' => 'Atestados emitidos para o funcionário ' . $funcionario->nome . ' nos últimos 3 meses',  
            '6' => 'Atestados emitidos para o funcionário ' . $funcionario->nome . ' nos últimos 6 meses',
            '12' => 'Atestados emitidos para o funcionário ' . $funcionario->nome . ' nos últimos 12 meses',
        ];

        if($mostrar == 'T')
        {
            $atestados = $t_atestados->find('all', [
                'contain' => ['Medico'],
                'conditions' => [
                    'funcionario' => $idFuncionario
                ],
                'order' => [
                    'afastamento' => 'DESC'
                ]
            ]);
        }
        else
        {
            $data_final = new DateTime();
            $data_inicial = $this->calcularDataInicial($mostrar);

            $atestados = $t_atestados->find('all', [
                'contain' => ['Medico'],
                'conditions' => [
                    'funcionario' => $idFuncionario,
                    'emissao >=' => $data_inicial->format("Y-m-d"),
                    'emissao <=' => $data_final->format("Y-m-d")
                ],
                'order' => [
                    'afastamento' => 'DESC'
                ]
            ]);
        }

        $quantidade = $atestados->count();

        $this->set('title', 'Relatório de Funcionários por Atestado');
        $this->set('subtitle', $opcoes_subtitulos[$mostrar]);
        $this->set('icon', 'assignment_ind');
        $this->set('funcionario', $funcionario);
        $this->set('atestados', $atestados);
        $this->set('mostrar', $mostrar);
    }

    public function imprimiratestadosfuncionario()
    {
        $t_atestados = TableRegistry::get('Atestado');
        $t_funcionarios = TableRegistry::get('Funcionario');
        
        $idFuncionario = $this->request->query('idFuncionario');
        $mostrar = $this->request->query('periodo');

        $funcionario = $t_funcionarios->get($idFuncionario);
        $atestados = null;

        $opcoes_subtitulos = [
            'T' => 'Atestados emitidos para o funcionário ' . $funcionario->nome, 
            '1' => 'Atestados emitidos para o funcionário ' . $funcionario->nome . ' nos últimos 30 dias',  
            '3' => 'Atestados emitidos para o funcionário ' . $funcionario->nome . ' nos últimos 3 meses',  
            '6' => 'Atestados emitidos para o funcionário ' . $funcionario->nome . ' nos últimos 6 meses',
            '12' => 'Atestados emitidos para o funcionário ' . $funcionario->nome . ' nos últimos 12 meses',
        ];

        if($mostrar == 'T')
        {
            $atestados = $t_atestados->find('all', [
                'contain' => ['Medico'],
                'conditions' => [
                    'funcionario' => $idFuncionario
                ],
                'order' => [
                    'afastamento' => 'DESC'
                ]
            ]);
        }
        else
        {
            $data_final = new DateTime();
            $data_inicial = $this->calcularDataInicial($mostrar);

            $atestados = $t_atestados->find('all', [
                'contain' => ['Medico'],
                'conditions' => [
                    'funcionario' => $idFuncionario,
                    'emissao >=' => $data_inicial->format("Y-m-d"),
                    'emissao <=' => $data_final->format("Y-m-d")
                ],
                'order' => [
                    'afastamento' => 'DESC'
                ]
            ]);
        }

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão de Relatório de Funcionários por Atestado.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito')) {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Relatório de Funcionários por Atestado');
        $this->set('subtitle', $opcoes_subtitulos[$mostrar]);
        $this->set('icon', 'assignment_ind');
        $this->set('funcionario', $funcionario);
        $this->set('atestados', $atestados);
    }

    public function atestadodetalhe(int $id)
    {
        $title = 'Consulta de Dados do Atestado';
        $icon = 'local_hospital';

        $t_atestado = TableRegistry::get('Atestado');
        
        $atestado = $t_atestado->get($id, ['contain' => ['Funcionario', 'Medico']]);

        $this->set('title', $title);
        $this->set('icon', $icon);
        $this->set('id', $id);
        $this->set('atestado', $atestado);
    }

    public function empresassatestados()
    {
        $datasource = Configure::read('Database.datasource');
        $connection = ConnectionManager::get($datasource);
        $link = $this->abrirBanco($connection);

        $relatorio = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 0)
        {
            $mostrar = $this->request->query('mostrar');
            $data['mostrar'] = $mostrar;

            $this->request->data = $data;
        }
        else
        {
            $data['mostrar'] = 'T';
        }

        $query = $this->montarRelatorioEmpresasAtestado($data);
        $relatorio = $link->query($query);

        $combo_mostra = [
            'T' => 'Todos os atestados cadastrados', 
            '1' => 'Atestados cadastrados no último mês', 
            '3' => 'Atestados cadastrados nos últimos 3 meses',
            '6' => 'Atestados cadastrados nos últimos 6 meses',
            '12' => 'Atestados cadastrados nos últimos 12 meses'
        ];

        $this->set('title', 'Relatório de Empresas por Atestado');
        $this->set('icon', 'business');
        $this->set('combo_mostra', $combo_mostra);
        $this->set('data', $data);
        $this->set('relatorio', $relatorio);
    }

    public function imprimirempresassatestados()
    {
        $datasource = Configure::read('Database.datasource');
        $connection = ConnectionManager::get($datasource);
        $link = $this->abrirBanco($connection);

        $relatorio = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 0)
        {
            $mostrar = $this->request->query('mostrar');
            $data['mostrar'] = $mostrar;

            $this->request->data = $data;
        }
        else
        {
            $data['mostrar'] = 'T';
        }

        $query = $this->montarRelatorioEmpresasAtestado($data);
        $relatorio = $link->query($query);

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão de Relatório de Empresas por Atestado.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito')) {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Relatório de Empresas por Atestado');
        $this->set('icon', 'business');
        $this->set('relatorio', $relatorio);
    }

    public function funcionariosempresa()
    {
        $datasource = Configure::read('Database.datasource');
        $connection = ConnectionManager::get($datasource);
        $link = $this->abrirBanco($connection);

        $t_empresas = TableRegistry::get('Empresa');
        
        $idEmpresa = $this->request->query('idEmpresa');
        $mostrar = $this->request->query('periodo');

        $relatorio = array();
        $data = array();
        
        $data['empresa'] = $idEmpresa;
        $data['mostrar'] = $mostrar;

        $query = $this->montarRelatorioFuncionariosAtestado($data);
        $relatorio = $link->query($query);

        $empresa = $t_empresas->get($idEmpresa);

        $opcoes_subtitulos = [
            'T' => 'Atestados emitidos para os funcionários da empresa ' . $empresa->nome, 
            '1' => 'Atestados emitidos para os funcionários da empresa ' . $empresa->nome . ' nos últimos 30 dias',  
            '3' => 'Atestados emitidos para os funcionários da empresa ' . $empresa->nome . ' nos últimos 3 meses',  
            '6' => 'Atestados emitidos para os funcionários da empresa ' . $empresa->nome . ' nos últimos 6 meses',
            '12' => 'Atestados emitidos para os funcionários da empresa ' . $empresa->nome . ' nos últimos 12 meses',
        ];

        $this->set('title', 'Relatório de Funcionários da Empresa por Atestado');
        $this->set('subtitle', $opcoes_subtitulos[$mostrar]);
        $this->set('icon', 'assignment_ind');
        $this->set('relatorio', $relatorio);
        $this->set('data', $data);
    }

    public function imprimirfuncionariosempresa()
    {
        $datasource = Configure::read('Database.datasource');
        $connection = ConnectionManager::get($datasource);
        $link = $this->abrirBanco($connection);

        $t_empresas = TableRegistry::get('Empresa');
        
        $idEmpresa = $this->request->query('empresa');
        $mostrar = $this->request->query('mostrar');

        $relatorio = array();
        $data = array();
        
        $data['empresa'] = $idEmpresa;
        $data['mostrar'] = $mostrar;

        $query = $this->montarRelatorioFuncionariosAtestado($data);
        $relatorio = $link->query($query);

        $empresa = $t_empresas->get($idEmpresa);

        $opcoes_subtitulos = [
            'T' => 'Atestados emitidos para os funcionários da empresa ' . $empresa->nome, 
            '1' => 'Atestados emitidos para os funcionários da empresa ' . $empresa->nome . ' nos últimos 30 dias',  
            '3' => 'Atestados emitidos para os funcionários da empresa ' . $empresa->nome . ' nos últimos 3 meses',  
            '6' => 'Atestados emitidos para os funcionários da empresa ' . $empresa->nome . ' nos últimos 6 meses',
            '12' => 'Atestados emitidos para os funcionários da empresa ' . $empresa->nome . ' nos últimos 12 meses',
        ];

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão de Relatório de Funcionários da Empresa por Atestado.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito')) {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Relatório de Funcionários da Empresa por Atestado');
        $this->set('subtitle', $opcoes_subtitulos[$mostrar]);
        $this->set('relatorio', $relatorio);
        $this->set('data', $data);
    }

    public function atestadosempresa()
    {
        $t_atestados = TableRegistry::get('Atestado');
        $t_empresas = TableRegistry::get('Empresa');
        
        $idEmpresa = $this->request->query('idEmpresa');
        $mostrar = $this->request->query('periodo');

        $relatorio = array();
        $data = array();
        
        $data['empresa'] = $idEmpresa;
        $data['mostrar'] = $mostrar;

        $empresa = $t_empresas->get($idEmpresa);

        if($mostrar == 'T')
        {
            $atestados = $t_atestados->find('all', [
                'contain' => ['Medico', 'Funcionario'],
                'conditions' => [
                    'empresa' => $idEmpresa
                ],
                'order' => [
                    'afastamento' => 'DESC'
                ]
            ]);
        }
        else
        {
            $data_final = new DateTime();
            $data_inicial = $this->calcularDataInicial($mostrar);

            $atestados = $t_atestados->find('all', [
                'contain' => ['Medico', 'Funcionario'],
                'conditions' => [
                    'empresa' => $idEmpresa,
                    'emissao >=' => $data_inicial->format("Y-m-d"),
                    'emissao <=' => $data_final->format("Y-m-d")
                ],
                'order' => [
                    'afastamento' => 'DESC'
                ]
            ]);
        }

        $opcoes_subtitulos = [
            'T' => 'Atestados emitidos para os funcionários da empresa ' . $empresa->nome, 
            '1' => 'Atestados emitidos para os funcionários da empresa ' . $empresa->nome . ' nos últimos 30 dias',  
            '3' => 'Atestados emitidos para os funcionários da empresa ' . $empresa->nome . ' nos últimos 3 meses',  
            '6' => 'Atestados emitidos para os funcionários da empresa ' . $empresa->nome . ' nos últimos 6 meses',
            '12' => 'Atestados emitidos para os funcionários da empresa ' . $empresa->nome . ' nos últimos 12 meses',
        ];

        $this->set('title', 'Relatório de Atestados da Empresa');
        $this->set('subtitle', $opcoes_subtitulos[$mostrar]);
        $this->set('icon', 'business');
        $this->set('atestados', $atestados);
        $this->set('empresa', $empresa);
        $this->set('data', $data);
        $this->set('mostrar', $mostrar);
    }

    public function imprimiratestadosempresa()
    {
        $t_atestados = TableRegistry::get('Atestado');
        $t_empresas = TableRegistry::get('Empresa');
        
        $idEmpresa = $this->request->query('idEmpresa');
        $mostrar = $this->request->query('periodo');

        $relatorio = array();
        $data = array();
        
        $data['empresa'] = $idEmpresa;
        $data['mostrar'] = $mostrar;

        $empresa = $t_empresas->get($idEmpresa);

        if($mostrar == 'T')
        {
            $atestados = $t_atestados->find('all', [
                'contain' => ['Medico', 'Funcionario'],
                'conditions' => [
                    'empresa' => $idEmpresa
                ],
                'order' => [
                    'afastamento' => 'DESC'
                ]
            ]);
        }
        else
        {
            $data_final = new DateTime();
            $data_inicial = $this->calcularDataInicial($mostrar);

            $atestados = $t_atestados->find('all', [
                'contain' => ['Medico', 'Funcionario'],
                'conditions' => [
                    'empresa' => $idEmpresa,
                    'emissao >=' => $data_inicial->format("Y-m-d"),
                    'emissao <=' => $data_final->format("Y-m-d")
                ],
                'order' => [
                    'afastamento' => 'DESC'
                ]
            ]);
        }

        $opcoes_subtitulos = [
            'T' => 'Atestados emitidos para os funcionários da empresa ' . $empresa->nome, 
            '1' => 'Atestados emitidos para os funcionários da empresa ' . $empresa->nome . ' nos últimos 30 dias',  
            '3' => 'Atestados emitidos para os funcionários da empresa ' . $empresa->nome . ' nos últimos 3 meses',  
            '6' => 'Atestados emitidos para os funcionários da empresa ' . $empresa->nome . ' nos últimos 6 meses',
            '12' => 'Atestados emitidos para os funcionários da empresa ' . $empresa->nome . ' nos últimos 12 meses',
        ];

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão de Relatório de Atestados da Empresa.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito')) {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Relatório de Atestados da Empresa');
        $this->set('subtitle', $opcoes_subtitulos[$mostrar]);
        $this->set('atestados', $atestados);
    }

    public function atestadoscid()
    {
        $datasource = Configure::read('Database.datasource');
        $connection = ConnectionManager::get($datasource);
        $link = $this->abrirBanco($connection);

        $t_tipo_funcionario = TableRegistry::get('TipoFuncionario');
        $t_empresas = TableRegistry::get('Empresa');

        $relatorio = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 0)
        {
            $funcionario = $this->request->query('funcionario');
            $nome_funcionario = $this->request->query('nome_funcionario');
            $empresa = $this->request->query('empresa');
            $tipo_funcionario = $this->request->query('tipo_funcionario');
            $exibir = $this->request->query('exibir');
            $mostrar = $this->request->query('mostrar');

            $data['funcionario'] = $funcionario;
            $data['nome_funcionario'] = $nome_funcionario;
            $data['empresa'] = $empresa;
            $data['tipo_funcionario'] = $tipo_funcionario;
            $data['exibir'] = $exibir;
            $data['mostrar'] = $mostrar;

            $this->request->data = $data;
        }

        $query = $this->montarRelatorioCIDATestado($data);
        $relatorio = $link->query($query);

        $tipos_funcionarios = $t_tipo_funcionario->find('list', [
            'keyField' => 'id',
            'valueField' => 'descricao'
        ]);

        $empresas = $t_empresas->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome'
        ]);

        $combo_exibir = [
            'T' => 'Todos',
            'E' => 'Somente funcionários em estágio probatório'
        ];

        $combo_mostra = [
            'T' => 'Todos os atestados cadastrados', 
            '1' => 'Atestados cadastrados no último mês', 
            '3' => 'Atestados cadastrados nos últimos 3 meses',
            '6' => 'Atestados cadastrados nos últimos 6 meses',
            '12' => 'Atestados cadastrados nos últimos 12 meses'
        ];

        $this->set('title', 'Relatório de Atestados Por CID');
        $this->set('icon', 'grid_on');
        $this->set('relatorio', $relatorio);
        $this->set('tipos_funcionarios', $tipos_funcionarios);
        $this->set('empresas', $empresas);
        $this->set('combo_exibir', $combo_exibir);
        $this->set('combo_mostra', $combo_mostra);
        $this->set('data', $data);
    }

    public function imprimiratestadoscid()
    {
        $datasource = Configure::read('Database.datasource');
        $connection = ConnectionManager::get($datasource);
        $link = $this->abrirBanco($connection);

        $t_tipo_funcionario = TableRegistry::get('TipoFuncionario');
        $t_empresas = TableRegistry::get('Empresa');

        $relatorio = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 3)
        {
            $funcionario = $this->request->query('funcionario');
            $nome_funcionario = $this->request->query('nome_funcionario');
            $empresa = $this->request->query('empresa');
            $tipo_funcionario = $this->request->query('tipo_funcionario');
            $exibir = $this->request->query('exibir');
            $mostrar = $this->request->query('mostrar');

            $data['funcionario'] = $funcionario;
            $data['nome_funcionario'] = $nome_funcionario;
            $data['empresa'] = $empresa;
            $data['tipo_funcionario'] = $tipo_funcionario;
            $data['exibir'] = $exibir;
            $data['mostrar'] = $mostrar;
        }

        $query = $this->montarRelatorioCIDATestado($data);
        $relatorio = $link->query($query);

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão de Relatório de Atestados Por CID.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito')) {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Relatório de Atestados Por CID');
        $this->set('relatorio', $relatorio);
    }

    public function cidatestados($cid)
    {
        $t_atestados = TableRegistry::get('Atestado');
        $t_cid = TableRegistry::get('Cid');   

        $data = array();
        $condicoes= array();

        if (count($this->request->getQueryParams()) > 0)
        {
            $funcionario = $this->request->query('funcionario');
            $empresa = $this->request->query('empresa');
            $tipo_funcionario = $this->request->query('tipo_funcionario');
            $exibir = $this->request->query('exibir');
            $mostrar = $this->request->query('mostrar');

            $data['funcionario'] = $funcionario;
            $data['empresa'] = $empresa;
            $data['tipo_funcionario'] = $tipo_funcionario;
            $data['exibir'] = $exibir;
            $data['mostrar'] = $mostrar;

            if($funcionario != "")
            {
                $condicoes['Atestado.funcionario'] = $funcionario;
            }

            if($empresa != "")
            {
                $condicoes['Funcionario.empresa'] = $empresa;
            }

            if($tipo_funcionario != "")
            {
                $condicoes['Funcionario.tipo'] = $tipo_funcionario;
            }

            if($exibir == "E")
            {
                $condicoes['Funcionario.probatorio'] = $exibir;
            }

            if($mostrar != "T")
            {
                $data_final = new DateTime();
                $data_inicial = $this->calcularDataInicial($mostrar);   

                $condicoes['Atestado.emissao >='] = $data_inicial->format("Y-m-d");
                $condicoes['Atestado.emissao <='] = $data_final->format("Y-m-d");
            }
        }

        $pivot = $t_cid->find('all', [
            'conditions' => [
                'codigo' => $cid,
                'detalhamento IS' => null
            ]
        ])->first();

        $condicoes['Atestado.cid'] = $cid;

        $atestados = $t_atestados->find('all', [
            'contain' => ['Funcionario', 'Medico'],
            'conditions' => $condicoes,
            'order' => [
                'afastamento' => 'DESC'
            ]
        ]);

        if(isset($data['mostrar']))
        {
            $opcoes_subtitulos = [
                'T' => '', 
                '1' => ' nos últimos 30 dias',  
                '3' => ' nos últimos 3 meses',  
                '6' => ' nos últimos 6 meses',
                '12' => ' nos últimos 12 meses',
            ];
    
            $subtitle = ($pivot == null) ? 'Atestados emitidos com o CID ' . $cid : 'Atestados emitidos com o CID ' . $cid . ': ' . $pivot->nome . $opcoes_subtitulos[$data['mostrar']];
        }
        else
        {
            $subtitle = ($pivot == null) ? 'Atestados emitidos com o CID ' . $cid : 'Atestados emitidos com o CID ' . $cid . ': ' . $pivot->nome;
        }

        $this->set('title', 'Relatório de Atestados Por CID');
        $this->set('icon', 'grid_on');
        $this->set('subtitle', $subtitle);
        $this->set('cid', $cid);
        $this->set('atestados', $atestados);
        $this->set('data', $data);
    }

    public function imprimircidatestados($cid)
    {
        $t_atestados = TableRegistry::get('Atestado');
        $t_cid = TableRegistry::get('Cid');   

        $data = array();
        $condicoes= array();

        if (count($this->request->getQueryParams()) > 0)
        {
            $funcionario = $this->request->query('funcionario');
            $empresa = $this->request->query('empresa');
            $tipo_funcionario = $this->request->query('tipo_funcionario');
            $exibir = $this->request->query('exibir');
            $mostrar = $this->request->query('mostrar');

            $data['funcionario'] = $funcionario;
            $data['empresa'] = $empresa;
            $data['tipo_funcionario'] = $tipo_funcionario;
            $data['exibir'] = $exibir;
            $data['mostrar'] = $mostrar;

            if($funcionario != "")
            {
                $condicoes['Atestado.funcionario'] = $funcionario;
            }

            if($empresa != "")
            {
                $condicoes['Funcionario.empresa'] = $empresa;
            }

            if($tipo_funcionario != "")
            {
                $condicoes['Funcionario.tipo'] = $tipo_funcionario;
            }

            if($exibir == "E")
            {
                $condicoes['Funcionario.probatorio'] = $exibir;
            }

            if($mostrar != "T")
            {
                $data_final = new DateTime();
                $data_inicial = $this->calcularDataInicial($mostrar);   

                $condicoes['Atestado.emissao >='] = $data_inicial->format("Y-m-d");
                $condicoes['Atestado.emissao <='] = $data_final->format("Y-m-d");
            }
        }

        $pivot = $t_cid->find('all', [
            'conditions' => [
                'codigo' => $cid,
                'detalhamento IS' => null
            ]
        ])->first();

        $condicoes['Atestado.cid'] = $cid;

        $atestados = $t_atestados->find('all', [
            'contain' => ['Funcionario', 'Medico'],
            'conditions' => $condicoes,
            'order' => [
                'afastamento' => 'DESC'
            ]
        ]);

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão de Relatório de Atestados Por CID.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito')) {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        if(isset($data['mostrar']))
        {
            $opcoes_subtitulos = [
                'T' => '', 
                '1' => ' nos últimos 30 dias',  
                '3' => ' nos últimos 3 meses',  
                '6' => ' nos últimos 6 meses',
                '12' => ' nos últimos 12 meses',
            ];
    
            $subtitle = ($pivot == null) ? 'Atestados emitidos com o CID ' . $cid : 'Atestados emitidos com o CID ' . $cid . ': ' . $pivot->nome . $opcoes_subtitulos[$data['mostrar']];
        }
        else
        {
            $subtitle = ($pivot == null) ? 'Atestados emitidos com o CID ' . $cid : 'Atestados emitidos com o CID ' . $cid . ': ' . $pivot->nome;
        }

        $this->set('title', 'Relatório de Atestados Por CID');
        $this->set('icon', 'grid_on');
        $this->set('subtitle', $subtitle);
        $this->set('cid', $cid);
        $this->set('atestados', $atestados);
    }

    public function medicoatestado()
    {
        $datasource = Configure::read('Database.datasource');
        $connection = ConnectionManager::get($datasource);
        $link = $this->abrirBanco($connection);

        $t_tipo_funcionario = TableRegistry::get('TipoFuncionario');
        $t_empresas = TableRegistry::get('Empresa');

        $relatorio = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 3)
        {
            $funcionario = $this->request->query('funcionario');
            $nome_funcionario = $this->request->query('nome_funcionario');
            $empresa = $this->request->query('empresa');
            $tipo_funcionario = $this->request->query('tipo_funcionario');
            $exibir = $this->request->query('exibir');
            $mostrar = $this->request->query('mostrar');

            $data['funcionario'] = $funcionario;
            $data['nome_funcionario'] = $nome_funcionario;
            $data['empresa'] = $empresa;
            $data['tipo_funcionario'] = $tipo_funcionario;
            $data['exibir'] = $exibir;
            $data['mostrar'] = $mostrar;

            $this->request->data = $data;
        }

        $query = $this->montarRelatorioMedicoAtestado($data);
        $relatorio = $link->query($query);

        $tipos_funcionarios = $t_tipo_funcionario->find('list', [
            'keyField' => 'id',
            'valueField' => 'descricao'
        ]);

        $empresas = $t_empresas->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome'
        ]);

        $combo_exibir = [
            'T' => 'Todos',
            'E' => 'Somente funcionários em estágio probatório'
        ];

        $combo_mostra = [
            'T' => 'Todos os atestados cadastrados', 
            '1' => 'Atestados cadastrados no último mês', 
            '3' => 'Atestados cadastrados nos últimos 3 meses',
            '6' => 'Atestados cadastrados nos últimos 6 meses',
            '12' => 'Atestados cadastrados nos últimos 12 meses'
        ];

        $this->set('title', 'Relatório de Atestados por Médico');
        $this->set('icon', 'grid_on');
        $this->set('relatorio', $relatorio);
        $this->set('tipos_funcionarios', $tipos_funcionarios);
        $this->set('empresas', $empresas);
        $this->set('combo_exibir', $combo_exibir);
        $this->set('combo_mostra', $combo_mostra);
        $this->set('data', $data);
    }

    public function imprimirmedicoatestado()
    {
        $datasource = Configure::read('Database.datasource');
        $connection = ConnectionManager::get($datasource);
        $link = $this->abrirBanco($connection);

        $t_tipo_funcionario = TableRegistry::get('TipoFuncionario');
        $t_empresas = TableRegistry::get('Empresa');

        $relatorio = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 3)
        {
            $funcionario = $this->request->query('funcionario');
            $nome_funcionario = $this->request->query('nome_funcionario');
            $empresa = $this->request->query('empresa');
            $tipo_funcionario = $this->request->query('tipo_funcionario');
            $exibir = $this->request->query('exibir');
            $mostrar = $this->request->query('mostrar');

            $data['funcionario'] = $funcionario;
            $data['nome_funcionario'] = $nome_funcionario;
            $data['empresa'] = $empresa;
            $data['tipo_funcionario'] = $tipo_funcionario;
            $data['exibir'] = $exibir;
            $data['mostrar'] = $mostrar;

            $this->request->data = $data;
        }

        $query = $this->montarRelatorioMedicoAtestado($data);
        $relatorio = $link->query($query);

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão de Relatório de Atestados por Médico.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito')) {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Relatório de Atestados por Médico');
        $this->set('relatorio', $relatorio);
    }

    public function atestadosmedico(int $idMedico)
    {
        $t_atestados = TableRegistry::get('Atestado');
        $t_medicos = TableRegistry::get('Medico');   

        $data = array();
        $condicoes= array();

        if (count($this->request->getQueryParams()) > 3)
        {
            $funcionario = $this->request->query('funcionario');
            $empresa = $this->request->query('empresa');
            $tipo_funcionario = $this->request->query('tipo_funcionario');
            $exibir = $this->request->query('exibir');
            $mostrar = $this->request->query('mostrar');

            $data['funcionario'] = $funcionario;
            $data['empresa'] = $empresa;
            $data['tipo_funcionario'] = $tipo_funcionario;
            $data['exibir'] = $exibir;
            $data['mostrar'] = $mostrar;

            if($funcionario != "")
            {
                $condicoes['Atestado.funcionario'] = $funcionario;
            }

            if($empresa != "")
            {
                $condicoes['Funcionario.empresa'] = $empresa;
            }

            if($tipo_funcionario != "")
            {
                $condicoes['Funcionario.tipo'] = $tipo_funcionario;
            }

            if($exibir == "E")
            {
                $condicoes['Funcionario.probatorio'] = $exibir;
            }

            if($mostrar != "T")
            {
                $data_final = new DateTime();
                $data_inicial = $this->calcularDataInicial($mostrar);   

                $condicoes['Atestado.emissao >='] = $data_inicial->format("Y-m-d");
                $condicoes['Atestado.emissao <='] = $data_final->format("Y-m-d");
            }
        }

        $medico = $t_medicos->get($idMedico);

        $condicoes['Atestado.medico'] = $medico->id;

        $atestados = $t_atestados->find('all', [
            'contain' => ['Funcionario', 'Medico'],
            'conditions' => $condicoes,
            'order' => [
                'afastamento' => 'DESC'
            ]
        ]);

        $this->set('title', 'Relatório de Atestados Por CID');
        $this->set('icon', 'grid_on');
        $this->set('subtitle', 'Atestados emitidos pelo médico ' . $medico->nome);
        $this->set('atestados', $atestados);
        $this->set('medico', $medico);
        $this->set('data', $data);
    }

    public function imprimiratestadosmedico(int $idMedico)
    {
        $t_atestados = TableRegistry::get('Atestado');
        $t_medicos = TableRegistry::get('Medico');   

        $data = array();
        $condicoes= array();

        if (count($this->request->getQueryParams()) > 3)
        {
            $funcionario = $this->request->query('funcionario');
            $empresa = $this->request->query('empresa');
            $tipo_funcionario = $this->request->query('tipo_funcionario');
            $exibir = $this->request->query('exibir');
            $mostrar = $this->request->query('mostrar');

            $data['funcionario'] = $funcionario;
            $data['empresa'] = $empresa;
            $data['tipo_funcionario'] = $tipo_funcionario;
            $data['exibir'] = $exibir;
            $data['mostrar'] = $mostrar;

            if($funcionario != "")
            {
                $condicoes['Atestado.funcionario'] = $funcionario;
            }

            if($empresa != "")
            {
                $condicoes['Funcionario.empresa'] = $empresa;
            }

            if($tipo_funcionario != "")
            {
                $condicoes['Funcionario.tipo'] = $tipo_funcionario;
            }

            if($exibir == "E")
            {
                $condicoes['Funcionario.probatorio'] = $exibir;
            }

            if($mostrar != "T")
            {
                $data_final = new DateTime();
                $data_inicial = $this->calcularDataInicial($mostrar);   

                $condicoes['Atestado.emissao >='] = $data_inicial->format("Y-m-d");
                $condicoes['Atestado.emissao <='] = $data_final->format("Y-m-d");
            }
        }

        $medico = $t_medicos->get($idMedico);

        $condicoes['Atestado.medico'] = $medico->id;

        $atestados = $t_atestados->find('all', [
            'contain' => ['Funcionario', 'Medico'],
            'conditions' => $condicoes,
            'order' => [
                'afastamento' => 'DESC'
            ]
        ]);

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão de Relatório de Atestados por Médico.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito')) {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Relatório de Atestados Por Médico');
        $this->set('subtitle', 'Atestados emitidos pelo médico ' . $medico->nome);
        $this->set('atestados', $atestados);
        $this->set('medico', $medico);
        $this->set('data', $data);
    }

    protected function montarRelatorioMedicoAtestado(array $data)
    {
        $query = "select a.medico,
                        m.nome,
                        m.crm,
                        m.especialidade,
                        count(a.medico) quantidade
                from atestado a
                inner join medico m
                    on a.medico = m.id
                inner join funcionario f
                    on a.funcionario = f.id ";

        if(count($data) > 0)
        {
            if($data['funcionario'] != "")
            {
                $query = $query . "and a.funcionario = " . $data['funcionario'] . " ";
            }

            if($data['empresa'] != "")
            {
                $query = $query . "and f.empresa = " . $data['empresa'] . " ";
            }

            if($data['tipo_funcionario'] != "")
            {
                $query = $query . "and f.tipo = " . $data['tipo_funcionario'] . " ";
            }

            if($data['exibir'] == "E")
            {
                $query = $query . "and f.probatorio = 1 ";
            }

            if($data['mostrar'] != "T")
            {
                $mostrar = $data['mostrar'];
                $data_final = new DateTime();
                $data_inicial = $this->calcularDataInicial($mostrar);   

                $query = $query . "and a.emissao between '" . $data_inicial->format("Y-m-d") . "' and '" . $data_final->format("Y-m-d") . "' ";
            }
        }

        $query = $query . "group by a.medico 
                           order by quantidade desc, m.nome asc";

        return $query;
    }

    protected function montarRelatorioCIDATestado(array $data)
    {
        $query = "select a.cid,
                        c.nome,
                        ifnull(c.nome, 'CID Desconhecido ou inválido') descricao,
                        count(a.id) atestados
                    from atestado a
                    inner join funcionario f
                        on f.id = a.funcionario
                    left join cid c
                        on c.codigo = a.cid
                    where c.detalhamento is null ";

        if(count($data) > 0)
        {
            if($data['funcionario'] != "")
            {
                $query = $query . "and a.funcionario = " . $data['funcionario'] . " ";
            }

            if($data['empresa'] != "")
            {
                $query = $query . "and f.empresa = " . $data['empresa'] . " ";
            }

            if($data['tipo_funcionario'] != "")
            {
                $query = $query . "and f.tipo = " . $data['tipo_funcionario'] . " ";
            }

            if($data['exibir'] == "E")
            {
                $query = $query . "and f.probatorio = 1 ";
            }

            if($data['mostrar'] != "T")
            {
                $mostrar = $data['mostrar'];
                $data_final = new DateTime();
                $data_inicial = $this->calcularDataInicial($mostrar);   

                $query = $query . "and a.emissao between '" . $data_inicial->format("Y-m-d") . "' and '" . $data_final->format("Y-m-d") . "' ";
            }
        }

        $query = $query . "group by a.cid
                    order by atestados desc, a.cid asc, c.detalhamento asc";

        return $query;
    }

    protected function montarRelatorioEmpresasAtestado(array $data)
    {
        $query = "";
        $mostrar = $data['mostrar'];
        
        if($mostrar == 'T')
        {
            $query = "select distinct
                        e.id,
                        e.nome,
                        (select count(d.id)
                        from funcionario d
                        where d.empresa = e.id) funcionarios,
                        count(a.id) atestados
                    from empresa e
                        inner join funcionario f
                            on f.empresa = e.id
                        left join atestado a
                            on a.funcionario = f.id
                    group by e.id
                    order by atestados desc";
        }
        else
        {
            $data_final = new DateTime();
            $data_inicial = $this->calcularDataInicial($mostrar);

            $query = "select distinct
                        e.id,
                        e.nome,
                        (select count(d.id)
                            from funcionario d
                            where d.empresa = e.id) funcionarios,
                        count(a.id) atestados
                        from empresa e
                            inner join funcionario f
                                on f.empresa = e.id
                            left join atestado a
                                on a.funcionario = f.id
                        where a.emissao between '" . $data_inicial->format("Y-m-d") . "' and '" . $data_final->format("Y-m-d") . "'
                           or a.emissao is null
                        group by e.id
                        order by atestados desc";
        }

        return $query;
    }

    protected function montarRelatorioFuncionariosAtestado(array $data)
    {
        $query = "";

        if (count($data) > 0)
        {
            $empresa = $data['empresa'];
            $mostrar = $data['mostrar'];

            if(array_key_exists('tipo_funcionario', $data))
            {
                $tipo_funcionario = $data['tipo_funcionario'];    
            }
            else
            {
                $tipo_funcionario = "";    
            }

            if(array_key_exists('exibir', $data))
            {
                $exibir = $data['exibir'];    
            }
            else
            {
                $exibir = "";
            }

            if($mostrar == 'T')
            {
                $query = "select f.id,
                            f.matricula matricula,
                            f.nome nome,
                            f.cargo cargo,
                            tf.descricao tipo,
                            e.nome empresa,
                            f.probatorio probatorio,
                            (select count(*)
                            from atestado a
                            where a.funcionario = f.id) quantidade
                    from funcionario f
                    inner join empresa e
                        on f.empresa = e.id
                    inner join tipo_funcionario tf
                        on f.tipo = tf.id
                    where f.ativo = 1 ";
            }
            else
            {
                $data_final = new DateTime();
                $data_inicial = $this->calcularDataInicial($mostrar);

                $query = "select f.id,
                            f.matricula matricula,
                            f.nome nome,
                            f.cargo cargo,
                            tf.descricao tipo,
                            e.nome empresa,
                            f.probatorio probatorio,
                            (select count(*)
                            from atestado a
                            where a.funcionario = f.id
                                and a.emissao between '" . $data_inicial->format("Y-m-d") . "' and '" . $data_final->format("Y-m-d") . "') quantidade
                    from funcionario f
                    inner join empresa e
                        on f.empresa = e.id
                    inner join tipo_funcionario tf
                        on f.tipo = tf.id
                    where f.ativo = 1 ";
            }
            
            if($empresa != "")
            {
                $query = $query . "and e.id = " . $empresa . " ";
            }
            
            if($tipo_funcionario != "")
            {
                $query = $query . "and tf.id = " . $tipo_funcionario . " ";
            }

            if($exibir == 'A')
            {
                $query = $query . "having quantidade > 0 ";
            }
            elseif($exibir == 'E')
            {
                $query = $query . "and f.probatorio = 1 ";
            }
            
            $query = $query . "order by quantidade desc, f.nome asc;";
        }
        else
        {
            $query = "select f.id,
                            f.matricula matricula,
                            f.nome nome,
                            f.cargo cargo,
                            tf.descricao tipo,
                            e.nome empresa,
                            f.probatorio probatorio,
                            (select count(*)
                            from atestado a
                            where a.funcionario = f.id) quantidade
                    from funcionario f
                    inner join empresa e
                        on f.empresa = e.id
                    inner join tipo_funcionario tf
                        on f.tipo = tf.id
                    where f.ativo = 1
                    order by quantidade desc, f.nome asc;";
        }

        return $query;
    }

    private function abrirBanco(ConnectionInterface $connection) 
    {
        $config = $connection->config();
        $username = $config['username'];
        $password = $config['password'];

        $dsn = "mysql:host=" . $config['host'] . "; dbname=" . $config['database'];
        $link = new PDO($dsn, $username, $password);

        $link->exec('SET CHARACTER SET utf8');
        $link->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $link;
    } 
    
    private function calcularDataInicial(string $mostrar)
    {
        switch($mostrar)
        {
            case "1":
                $key_sub = "P30D";
                break;

            case "3":
                $key_sub = "P3M";
                break;
            
            case "6":
                $key_sub = "P6M";
                break;
            
            case "12":
                $key_sub = "P1Y";
                break;
        }
        
        $data_inicial = new DateTime();
        $data_inicial->sub(new DateInterval($key_sub));

        return $data_inicial;
    }
}