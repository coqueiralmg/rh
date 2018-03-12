<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\File;
use Cake\Log\Log;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use Cake\Utility\Xml;
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
        $connection = $this->conectarBanco();

        $t_tipo_funcionario = TableRegistry::get('TipoFuncionario');
        $t_empresas = TableRegistry::get('Empresa');

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

            $this->request->data = $data;
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
                    order by quantidade desc;";

            $relatorio = $connection->prepare($query);
            $relatorio->execute();
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
            'E' => 'Somente funcionários em estágio probatório'
        ];

        $combo_mostra = [
            'T' => 'Todos os atestados cadastrados', 
            '1' => 'Atestados cadastrados no último mês', 
            '3' => 'Atestados cadastrados nos últimos 3 meses',
            '6' => 'Atestados cadastrados nos últimos 6 meses',
            '12' => 'Atestados cadastrados no último ano'
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

    private function conectarBanco() {
        $datasource = Configure::read('Database.datasource');
        

        
        
        $dsn = "mysql:host=" . $host . "; dbname=" . $dbname;
        $link = new PDO($dsn, $username, $password);
        $link->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $link;
    }

    private function getDSN(string $datasource)
    {
        
    }
}