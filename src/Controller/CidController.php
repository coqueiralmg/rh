<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Filesystem\File;
use Cake\Log\Log;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use Cake\Utility\Xml;
use \Exception;
use \ZipArchive;

class CidController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_cid = TableRegistry::get('Cid');

        $limite_paginacao = Configure::read('Pagination.limit');
        $condicoes = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 1)
        {
            $codigo = $this->request->query('codigo');
            $detalhamento = $this->request->query('detalhamento');
            $nome = $this->request->query('nome');

            if($codigo != "")
            {
                $condicoes['codigo'] = $codigo;

                if($detalhamento != "")
                {
                    $condicoes['detalhamento'] = $detalhamento;
                }
            }

            if($nome != "")
            {
                $condicoes['nome LIKE'] = '%' . $nome . '%';
            }

            $data['codigo'] = $codigo;
            $data['nome'] = $nome;
            
            $this->request->data = $data;
        }

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $condicoes,
            'order' => [
                'codigo' => 'ASC',
                'detalhamento' => 'ASC'
            ]
        ];

        $itens = $this->paginate($t_cid);

        $qtd_total = $t_cid->find('all', [
            'conditions' => $condicoes
        ])->count();

        $this->set('title', 'CID');
        $this->set('icon', 'grid_on');
        $this->set('itens', $itens);
        $this->set('qtd_total', $qtd_total);
        $this->set('data', $data);
    }

    public function imprimir()
    {
        $t_cid = TableRegistry::get('Cid');
        
        $condicoes = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 1)
        {
            $codigo = $this->request->query('codigo');
            $detalhamento = $this->request->query('detalhamento');
            $nome = $this->request->query('nome');

            if($codigo != "")
            {
                $condicoes['codigo'] = $codigo;

                if($detalhamento != "")
                {
                    $condicoes['detalhamento'] = $detalhamento;
                }
            }

            if($nome != "")
            {
                $condicoes['nome LIKE'] = '%' . $nome . '%';
                
            }
        }

        $itens = $t_cid->find('all', [
            'conditions' => $condicoes
        ]);

        $qtd_total = $itens->count();

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão da lista de CID.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito')) {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Tabela de CID');
        $this->set('itens', $itens);
        $this->set('qtd_total', $qtd_total);
    }

    public function add()
    {
        $this->redirect(['action' => 'cadastro', 0]);
    }

    public function addc()
    {
        $this->redirect(['action' => 'insercao']);
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
        $title = ($id > 0) ? 'Edição de CID' : 'Novo CID';

        $t_cid = TableRegistry::get('Cid');

        if ($id > 0) 
        {
            $cid = $t_cid->get($id);
            $this->set('cid', $cid);
        }
        else
        {
            $this->set('cid', null);
        }

        $this->set('title', $title);
        $this->set('icon', 'grid_on');
        $this->set('id', $id);
    }

    public function consulta(int $id)
    {
        $title = 'Consulta de Dados do CID';

        $t_cid = TableRegistry::get('Cid');
        $cid = $t_cid->get($id);

        $this->set('title', $title);
        $this->set('icon', 'grid_on');
        $this->set('id', $id);
        $this->set('cid', $cid);
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
            $t_cid = TableRegistry::get('Cid');

            $marcado = $t_cid->get($id);
            $codigo = $marcado->cid;

            $propriedades = $marcado->getOriginalValues();

            $t_cid->delete($marcado);

            $this->Flash->greatSuccess('O CID ' . $codigo . ' foi excluído com sucesso!');

            $auditoria = [
                'ocorrencia' => 38,
                'descricao' => 'O usuário excluiu um determinado CID do sistema.',
                'dado_adicional' => json_encode(['cid_excluido' => $id, 'dados_cid_excluido' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if ($this->request->session()->read('UsuarioSuspeito')) 
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'index']);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao excluir o CID.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'index']);
        }
    }

    public function insercao()
    {
        $this->set('title', 'Cadastro em Massa de CID');
        $this->set('icon', 'grid_on');
    }

    public function push()
    {
        if ($this->request->is('post'))
        {
            $t_cid = TableRegistry::get('Cid');
            $campos = $this->request->getData("campos");
            $detalhamentos = $this->request->getData("detalhamento");
            $nomes = $this->request->getData("nome");
            $total = count($codigos);
            $relatorio = array();

            for($i = 0; $i < $total; $i++)
            {
                $codigo = $codigos[$i];
                $detalhamento = $detalhamentos[$i];
                $nome = $nomes[$i];

                if($detalhamento === "")
                {
                    $detalhamento = null;
                }

                $dado['item'] = $i;
                $dado['codigo'] = $codigo;
                $dado['detalhamento'] = $detalhamento;
                $dado['nome'] = $nome;

                $qtd = 0;

                if($detalhamento == null)
                {
                    $qtd = $t_cid->find('all', [
                        'conditions' => [
                            'codigo' => $codigo,
                            'detalhamento IS' => null
                        ]
                    ])->count();
                }
                else
                {
                    $qtd = $t_cid->find('all', [
                        'conditions' => [
                            'codigo' => $codigo,
                            'detalhamento' => $detalhamento
                        ]
                    ])->count();
                }

                if($qtd > 0)
                {
                    $dado['sucesso'] = false;
                    $dado['mensagem'] = 'O CID informado existe no sistema';
                }
                else
                {
                    try
                    {
                        $entity = $t_cid->newEntity();
                    
                        $entity->codigo = $codigo;
                        $entity->detalhamento = $detalhamento;
                        $entity->nome = $nome;
                        $entity->subitem = ($detalhamento != null);

                        $t_cid->save($entity);

                        $dado['sucesso'] = true;
                        $dado['mensagem'] = '';
                    }
                    catch (Exception $ex) 
                    {
                        $dado['sucesso'] = false;
                        $dado['mensagem'] = $ex->getMessage();
                    }
                }

                array_push($relatorio, $dado);
            }

            $this->request->session()->write('Relatorios.Importacao.CID', $relatorio);
            $this->redirect(['action' => 'resultado']);
        }
    }

    public function resultado()
    {
        $relatorio = $this->request->session()->read('Relatorios.Importacao.CID');
        
        $this->set('title', 'Relatório de Cadastro de CID');
        $this->set('icon', 'grid_on');
        $this->set('relatorio', $relatorio);
    }

    public function relatorio()
    {
        $relatorio = $this->request->session()->read('Relatorios.Importacao.CID');

        $this->viewBuilder()->layout('print');
        
        $this->set('title', 'Relatório de Cadastro de CID');
        $this->set('relatorio', $relatorio);
    }

    public function importar()
    {
        $this->set('title', 'Importação de CID via Arquivo');
        $this->set('icon', 'grid_on');
    }

    public function importacao()
    {
        $tipo_arquivo = [
            'CSV' => 'Arquivo CSV',
            'TXT' => 'Arquivo TXT'
        ];

        $separador = [
            'PV' => 'Ponto e vírgula (;)',
            'VG' => 'Vírgula (,)',
            'PP' => 'Ponto (.)',
            'TR' => 'Traço (-)',
            'TB' => 'TAB',
            'SP' => 'Espaço'
        ];


        $this->set('title', 'Importação de CID via Arquivo Padrão');
        $this->set('icon', 'grid_on');
        $this->set('tipo_arquivo', $tipo_arquivo);
        $this->set('separador', $separador);
    }

    public function datasus()
    {
        $tipo_arquivo = [
            'CSV' => 'Arquivo ZIP com CSVs',
            //'XML' => 'Arquivo ZIP com XMLs'
        ];
        
        $this->set('title', 'Importação de CID via Arquivo do Datasus');
        $this->set('icon', 'grid_on');
        $this->set('tipo_arquivo', $tipo_arquivo);
    }

    public function file()
    {
        set_time_limit(600);

        try
        {
            if ($this->request->is('post'))
            {
                $dados = [];
                
                $campos = $this->request->getData("campos");
                $tipo = $this->request->getData("tipo");
                $separador = $this->request->getData("separador");
                $arquivo = $this->request->getData("arquivo");
                $ignorar = $this->request->getData("ignorar");
                $junto = $this->request->getData("junto");
                $separado = $this->request->getData("separado");

                $file_temp = $arquivo['tmp_name'];
                $nome_arquivo = $arquivo['name'];

                $file = new File($file_temp);
                $pivot = new File($nome_arquivo);

                $campos = json_decode($campos);

                if(strtolower($pivot->ext()) != strtolower($tipo))
                {
                    throw new Exception("O arquivo de importação é inválido. Verifique se você selecionou o tipo de arquivo corretamente.");
                }

                $conteudo = $file->read();

                if(mb_detect_encoding($conteudo) != 'UTF-8')
                {
                    $conteudo = utf8_encode($conteudo);
                }

                $linhas = explode("\n", $conteudo);

                $file->close();

                for($i = 0; $i < count($linhas); $i++)
                {
                    $linha = $linhas[$i];
                    $char = $this->obterSeparador($separador);
                    $data = explode($char, $linha);

                    if($i == 0 && $ignorar)
                    {
                        continue;
                    }

                    if(trim($linha) == "")
                    {
                        continue;
                    }

                    if(count($data) < 2)
                    {
                        throw new Exception("O arquivo de importação é inválido. Verifique se você selecionou o caractere separador corretamente.");
                    }

                    if(count($data) != count($campos))
                    {
                        if(count($data) > count($campos))
                        {
                            throw new Exception("O arquivo de importação é inválido. A quantidade de campos informados no arquivo é maior que os campos aceitos pelo sistema. Verifique também se você selecionou o código e o detalhamento no mesmo campo, quando na verdade, os mesmos encontram-se separados.");
                        }

                        if(count($data) < count($campos) - 1)
                        {
                            throw new Exception("O arquivo de importação é inválido. Existem um ou mais campos obrigatórios que não foram informados no arquivo.");
                        }

                        if(count($data) < count($campos))
                        {
                            if(end($campos) != "descricao")
                            {
                                throw new Exception("O arquivo de importação é inválido. O campo de descrição detalhada do CID, que é opcional deve ser posto como último, caso não tiver o mesmo informado no arquivo.");
                            }
                        }
                    }

                    $info = [];
                    
                    for($j = 0; $j < count($data); $j++)
                    {
                        $campo = $campos[$j];
                        $data[$j] = trim($data[$j]);

                        if($campo == "detalhamento")
                        {
                            $detalhamento = $data[$j];

                            if($detalhamento === "")
                            {
                                $detalhamento = null;
                            }
                            else
                            {
                                if(!is_numeric($detalhamento))
                                {
                                    throw new Exception("Existe um dado de detalhamento de cid que não é numérico.");
                                }
                            }

                            $info['detalhamento'] = $detalhamento;
                        }
                        elseif($campo == "codigo_detalhamento")
                        {
                            $valor = $data[$j];
                                
                            if($separado)
                            {
                                $codigo = '';
                                $detalhamento = '';
                                
                                if(strlen($valor) == 3)
                                {
                                    $codigo = $valor;
                                    $detalhamento = null;
                                }
                                else
                                {
                                    $pivot = explode('.', $valor);

                                    $codigo = $pivot[0];
                                    $detalhamento = $pivot[1];

                                    if($detalhamento === "")
                                    {
                                        $detalhamento = null;
                                    }   
                                    else
                                    {
                                        if(!is_numeric($detalhamento))
                                        {
                                            throw new Exception("Foi detectado um código CID inválido e não aceito pelo sistema.");
                                        }
                                    }
                                }

                                $info['codigo'] = $codigo;
                                $info['detalhamento'] = $detalhamento;
                            }
                            else
                            {
                                $codigo = '';
                                $detalhamento = '';
                                
                                if(strpos($valor, '.') >= 0)
                                {
                                    throw new Exception("Arquivo de importação inválido. Os códigos e os detalhamentos estão realmente separados por ponto?");
                                }
                                
                                if(strlen($valor) == 3)
                                {
                                    $codigo = $valor;
                                    $detalhamento = null;
                                }
                                else
                                {
                                    $codigo = substr($valor, 0, -1);
                                    $detalhamento = substr($valor, -1); 

                                    if($detalhamento === "")
                                    {
                                        $detalhamento = null;
                                    }  
                                    else
                                    {
                                        if(!is_numeric($detalhamento))
                                        {
                                            throw new Exception("Foi detectado um código CID inválido e não aceito pelo sistema.");
                                        }
                                    }
                                }

                                $info['codigo'] = $codigo;
                                $info['detalhamento'] = $detalhamento;
                            }
                        }
                        elseif($campo == "nome")
                        {
                            $nome = $data[$j];

                            if(strlen($nome) > 150)
                            {
                                throw new Exception("Foi detectado o nome da doença ou problema com mais de 150 caracteres. Sugerimos que faça abreviação do termo. Caso isso persistir, entre em contato com o suporte.");
                            }

                            $info['nome'] = $nome;
                        }
                        else
                        {
                            $info[$campo] = $data[$j];
                        } 
                    }

                    $dados[] = $info;
                }

                $auditoria = [
                    'ocorrencia' => 39,
                    'descricao' => 'O usuário fez a importação de dados de CID em um aquivo padrão.',
                    'dado_adicional' => json_encode(['metodo' => 'Padrão', 'arquivo' => $nome_arquivo, 'itens_importados' => count($dados)]),
                    'usuario' => $this->request->session()->read('UsuarioID')
                ];
    
                $this->Auditoria->registrar($auditoria);
    
                if ($this->request->session()->read('UsuarioSuspeito')) 
                {
                    $this->Monitoria->monitorar($auditoria);
                }

                $this->import($dados);
            }
        }
        catch (Exception $ex) 
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao efetuar a importação do CID', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'importacao']);
        }
    }

    public function fsus()
    {
        set_time_limit(1200);
        
        try
        {
            $tipo = $this->request->getData("tipo");
            $separador = $this->request->getData("separador");
            $arquivo = $this->request->getData("arquivo");

            $file_temp = $arquivo['tmp_name'];
            $nome_arquivo = $arquivo['name'];
            
            $pivot = new File($nome_arquivo);

            if(strtolower($pivot->ext()) != 'zip')
            {
                throw new Exception("O arquivo de importação é inválido. Verifique se você selecionou o tipo de arquivo corretamente.");
            }

            $zip = new ZipArchive();
            $zip->open($file_temp);
            $lscat = array();
            $lssub = array();
            $xml = null;

            if($tipo == 'CSV')
            {
                $conteudo_categorias = $zip->getFromName('CID-10-CATEGORIAS.CSV');
                $conteudo_subcategorias = $zip->getFromName('CID-10-SUBCATEGORIAS.CSV');

                $conteudo_categorias = utf8_encode($conteudo_categorias);
                $conteudo_subcategorias = utf8_encode($conteudo_subcategorias);

                $lscat = explode("\n", $conteudo_categorias);
                $lssub = explode("\n", $conteudo_subcategorias);

                $auditoria = [
                    'ocorrencia' => 39,
                    'descricao' => 'O usuário fez a importação de dados de CID, por meio do arquivo fornecido pelo Datasus, por meio de CSV.',
                    'dado_adicional' => json_encode(['metodo' => 'Datasus', 'arquivo' => $nome_arquivo, 'itens_importados' => count($lscat) + count($lssub)]),
                    'usuario' => $this->request->session()->read('UsuarioID')
                ];
    
                $this->Auditoria->registrar($auditoria);
    
                if ($this->request->session()->read('UsuarioSuspeito')) 
                {
                    $this->Monitoria->monitorar($auditoria);
                }
            }
            elseif($tipo == 'XML')
            {
                $conteudo = $zip->getFromName('CID10.XML');
                $xml = Xml::build($conteudo);
            }

            $zip->close();
            
            switch ($tipo) {
                case 'CSV':
                    $this->fsuscsv($lscat, $lssub);
                    break;
                
                case 'XML':
                    $this->fsusxml($xml);
                    break;
            }
        }
        catch (Exception $ex) 
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao efetuar a importação do CID', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'datasus']);
        }
    }

    public function listar() 
    {
        if($this->request->is('ajax'))
        {
            $t_cid = TableRegistry::get('Cid');

            $this->autoRender = false;
            $this->validationRole = false;

            $codigo = null;
            $detalhamento = null;
            $condicoes = array();

            $pcodigo = $this->request->query("codigo"); 
            $nome = $this->request->query("nome");

            if(strlen($pcodigo) == 3)
            {
                $codigo = $pcodigo;
            }
            elseif(strlen($pcodigo) == 4)
            {
                if(strpos($pcodigo, '.') === false)
                {
                    $codigo = substr($pcodigo, 0, -1);
                    $detalhamento = substr($pcodigo, -1);
                }
            }
            elseif(strlen($pcodigo) == 5)
            {
                if(strpos($pcodigo, '.') > 0)
                {
                    $pivot = explode('.', $pcodigo);

                    $codigo = $pivot[0];
                    $detalhamento = $pivot[1];
                }
            }

            if($codigo != null && $codigo != "")
            {
                $condicoes['codigo'] = $codigo;

                if($detalhamento != null)
                {
                    $condicoes['detalhamento'] = $detalhamento;
                }
            }

            if($nome != "")
            {
                $condicoes['nome LIKE'] = '%' . $nome . '%';
            }

            if(count($condicoes) > 0)
            {
                $cids = $t_cid->find('all', [
                    'conditions' => $condicoes,
                    'limit' => 10,
                    'order' => [
                        'codigo' => 'ASC',
                        'detalhamento' => 'ASC'
                    ]
                ]);
            }
            else
            {
                $limite_paginacao = Configure::read('Pagination.short.limit');

                $this->paginate = [
                    'limit' => $limite_paginacao,
                    'conditions' => $condicoes,
                    'order' => [
                        'codigo' => 'ASC',
                        'detalhamento' => 'ASC'
                    ]
                ];
        
                $cids = $this->paginate($t_cid);
            }

            $this->response->header('Content-Type', 'application/json');
            echo json_encode($cids);
        }
    }

    public function get()
    {
        $this->validationRole = false;
        $this->autoRender = false;
        
        if ($this->request->is('ajax'))
        {
            $t_cid = TableRegistry::get('Cid');

            $codigo = $this->request->query("codigo"); 
            
            $cid = $t_cid->find('all', [
                'conditions' => [
                    'codigo' => $codigo
                ],
                'order' => [
                    'codigo' => 'ASC',
                    'detalhamento' => 'ASC'
                ]
            ])->first();
            
            $this->response->header('Content-Type', 'application/json');

            if(count($cid) > 0)
            {
                echo json_encode($cid);
            }
            else
            {
                $cid = null;
                echo json_encode($cid);
            }
        }
    }

    protected function insert()
    {
        try 
        {
            $t_cid = TableRegistry::get('Cid');
            $entity = $t_cid->newEntity($this->request->data());
            
            $qcid = 0;

            if($entity->detalhamento === "")
            {
                $entity->detalhamento = null;
                
                $qcid = $t_cid->find('all', [
                    'conditions' => [
                        'codigo' => $entity->codigo,
                        'detalhamento IS' => null
                    ]
                ])->count();
            }
            else
            {
                $qcid = $t_cid->find('all', [
                    'conditions' => [
                        'codigo' => $entity->codigo,
                        'detalhamento' => $entity->detalhamento
                    ]
                ])->count();
            }
            
            if($qcid > 0)
            {
                throw new Exception("Existe um CID com o código informado e detalhamento cadastrado.");
            }

            $t_cid->save($entity);
            
            $this->Flash->greatSuccess('O CID foi salvo com sucesso');
            
            $propriedades = $entity->getOriginalValues();
            
            $auditoria = [
                'ocorrencia' => 35,
                'descricao' => 'O usuário fez o cadastro simples de CID.',
                'dado_adicional' => json_encode(['id_novo_cid' => $entity->id, 'campos' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if ($this->request->session()->read('UsuarioSuspeito')) 
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'cadastro', $entity->id]);
        } 
        catch (Exception $ex) 
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o CID', [
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
            $t_cid = TableRegistry::get('Cid');
            $entity = $t_cid->get($id);

            $t_cid->patchEntity($entity, $this->request->data());

            if($entity->detalhamento === "")
            {
                $entity->detalhamento = null;
            }
            
            $qcid = 0;

            if($detalhamento == null)
            {
                $qcid = $t_cid->find('all', [
                    'conditions' => [
                        'codigo' => $entity->codigo,
                        'detalhamento IS' => null
                    ]
                ])->count();
            }
            else
            {
                $qcid = $t_cid->find('all', [
                    'conditions' => [
                        'codigo' => $entity->codigo,
                        'detalhamento' => $entity->detalhamento
                    ]
                ])->count();
            }
            
            if($qcid > 0)
            {
                throw new Exception("Existe um CID com o código informado e detalhamento cadastrado.");
            }

            $propriedades = $this->Auditoria->changedOriginalFields($entity);
            $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

            $t_cid->save($entity);

            $this->Flash->greatSuccess('O CID foi salvo com sucesso');

            $auditoria = [
                'ocorrencia' => 37,
                'descricao' => 'O usuário modificou os dados de um determinado CID.',
                'dado_adicional' => json_encode(['cid_modificado' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if ($this->request->session()->read('UsuarioSuspeito')) 
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'cadastro', $id]);
        } 
        catch (Exception $ex) 
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o CID', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'cadastro', $id]);
        }
    }

    protected function fsuscsv(array $fcat, array $fsub)
    {
        $categorias = [];
        $subcategorias = [];

        for($i = 1; $i < count($fcat); $i++)
        {
            $linha = $fcat[$i];
            $data = explode(';', $linha);

            if(trim($linha) == "")
            {
                continue;
            }

            $info = [];

            for($j = 0; $j < count($data); $j++)
            {
                $valor = $data[$j];
                
                switch ($j) {
                    case 0:
                        $info['codigo'] = $valor;
                        break;
                    
                    case 2:
                        $info['nome'] = $valor;
                        break;

                }

                $info['detalhamento'] = null;
                $info['descricao'] = null;
            }

            $categorias[] = $info;
        }

        for($i = 1; $i < count($fsub); $i++)
        {
            $linha = $fsub[$i];
            $data = explode(';', $linha);

            if(trim($linha) == "")
            {
                continue;
            }

            $info = [];

            for($j = 0; $j < count($data); $j++)
            {
                $valor = $data[$j];

                if($j == 0)
                {
                    $codigo = substr($valor, 0, -1);
                    $detalhamento = substr($valor, -1);

                    if($detalhamento == 0)
                    {
                        break;
                    }
                    else
                    {
                        $info['codigo'] = $codigo;
                        $info['detalhamento'] = $detalhamento;
                    }
                }
                elseif($j == 4)
                {
                    $info['nome'] = $valor;
                }

                $info['descricao'] = null;
            }

            if(count($info) > 0)
            {
                $subcategorias[] = $info;
            }
        }

        $dados = array_merge($categorias, $subcategorias);

        $this->import($dados);
    }

    protected function fsusxml($xml)
    {
        $dados = [];
        $data = Xml::toArray($xml);

        $pivot = $data['cid10']['capitulo']['grupo']['categoria'];

        for($i = 0; $i < count($pivot); $i++)
        {
            $item = $pivot[$i];
            $info = [];

            $info['codigo'] = $item['@codcat'];
            $info['detalhamento'] = null;
            $info['nome'] = $item['nome'];
            $descricao = null;

            $dados[] = $info;

            if(array_key_exists('subcategoria', $item))
            {
                $subitem = $item['subcategoria'];

                for($j = 0; $j < count($subitem); $j++)
                {
                    $valores = $subitem[$i];
                    $info = [];

                    $valor = $valores['@codsubcat'];

                    $info['codigo'] = substr($valor, 0, -1);
                    $info['detalhamento'] = substr($valor, -1);
                    $info['nome'] = $valores['nome'];
                    $descricao = null;

                    $dados = $info;
                }
            }
        }

        $this->import($dados);
    }

    protected function import(array $data)
    {
        $t_cid = TableRegistry::get('Cid');
        $total = count($data);
        $relatorio = array();

        for($i = 0; $i < $total; $i++)
        {
            $info = $data[$i];
            
            $codigo = $info['codigo'];
            $detalhamento = $info['detalhamento'];
            $nome = $info['nome'];
            $descricao = $info['descricao'];

            $dado['item'] = $i;
            $dado['codigo'] = $codigo;
            $dado['detalhamento'] = $detalhamento;
            $dado['nome'] = $nome;

            $qtd = 0;

            if($detalhamento == null)
            {
                $qtd = $t_cid->find('all', [
                    'conditions' => [
                        'codigo' => $codigo,
                        'detalhamento IS' => null
                    ]
                ])->count();
            }
            else
            {
                $qtd = $t_cid->find('all', [
                    'conditions' => [
                        'codigo' => $codigo,
                        'detalhamento' => $detalhamento
                    ]
                ])->count();
            }

            if($qtd > 0)
            {
                $dado['sucesso'] = false;
                $dado['mensagem'] = 'O CID informado existe no sistema';
            }
            else
            {
                try
                {
                    $entity = $t_cid->newEntity();
                
                    $entity->codigo = $codigo;
                    $entity->detalhamento = $detalhamento;
                    $entity->nome = $nome;
                    $entity->subitem = ($detalhamento != null);
                    $entity->descricao = $descricao;

                    $t_cid->save($entity);

                    $dado['sucesso'] = true;
                    $dado['mensagem'] = '';
                }
                catch (Exception $ex) 
                {
                    $dado['sucesso'] = false;
                    $dado['mensagem'] = $ex->getMessage();
                }
            }

            array_push($relatorio, $dado);
        }

        $this->request->session()->write('Relatorios.Importacao.CID', $relatorio);
        $this->redirect(['action' => 'resultado']);
    }

    private function obterSeparador($separador)
    {
        $caractere = '';
        
        switch ($separador) {
            case 'PV':
                $caractere = ';';
                break;

            case 'VG':
                $caractere = ',';
                break;
            
            case 'PP':
                $caractere = '.';
                break;
            
            case 'TR':
                $caractere = '-';
                break;
            
            case 'TB':
                $caractere = '\t';
                break;
            
            case 'SP':
                $caractere = ' ';
                break;
        }

        return $caractere;
    }
}