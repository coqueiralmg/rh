<?php

namespace App\Controller\Component;

use Cake\Core\Configure;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\ORM\Entity;

/**
 * Classe que representa o componente de controle e gerenciamento de auditoria.
 * @package App\Controller\Component
 */
class AuditoriaComponent extends Component
{
    /**
     * Faz o registro de auditoria no sistema, por meio de sistema.
     *
     * @param array $dados Dados a serem adicionados no banco de dados de auditoria.
     * @return int|mixed O valor da auditoria adicionada, se inserida com sucesso.
     */
    public function registrar(array $dados)
    {
        $id = 0;
        $table = TableRegistry::get('Auditoria');
        $auditoria = $table->newEntity();

        $auditoria->data = date("Y-m-d H:i:s");
        $auditoria->ocorrencia = $dados['ocorrencia'];
        $auditoria->descricao = empty($dados['descricao']) ? null : $dados['descricao'];
        $auditoria->dado_adicional = empty($dados['dado_adicional']) ? null : $dados['dado_adicional'];
        $auditoria->usuario = $dados['usuario'];
        $auditoria->ip = $_SERVER['REMOTE_ADDR'];
        $auditoria->agent = $_SERVER['HTTP_USER_AGENT'];

        if ($table->save($auditoria)) {
            $id = $auditoria->id;
        }

        return $id;
    }

    /**
     * Retorna uma lista de registros de auditoria de um determinado usuário.
     * @param int $usuario Um usuário do sistema
     * @return array Lista de registro de auditoria
     */
    public function listar(int $usuario)
    {
        $table = TableRegistry::get('Auditoria');

        $query = $table->find('all', [
           'conditions' => [
               'usuario' => $usuario
           ]
        ]);

        return $query->toArray();
    }

    /**
     * Retorna uma quantidade de registros de auditoria de um determinado usuário.
     * @param int $usuario Um usuário do sistema
     * @return int Quantidade de registro de auditoria no sistema
     */
    public function quantidade(int $usuario)
    {
        $table = TableRegistry::get('Auditoria');

        $query = $table->find('all', [
            'conditions' => [
                'usuario' => $usuario
            ]
        ]);

        return $query->count();
    }

    /**
     * Exclui toda a auditoria de um determinado usuário
     * @param int $usuario Um usuário do sistema
     */
    public function limpar(int $usuario)
    {
        $table = TableRegistry::get('Auditoria');
        $table->deleteAll(['usuario' => $usuario]);
    }

    /**
    * Busca o nome da ocorrência da auditoria por código
    * @param int Código da ocorrência
    * @return string Nome da ocorrência pré-cadastrada na lista
    */
    public function buscarNomeOcorrencia(int $codigo)
    {
        $ocorrencias = Configure::read('Auditoria.ocorrencias');
        return $ocorrencias[$codigo];
    }

    /**
    * Obtém todas as ocorrências pré definidas do código
    * @return array Coletânea de todas as ocorrências pré definidas
    */
    public function obterOcorrencias()
    {
        $ocorrencias = Configure::read('Auditoria.ocorrencias');
        return $ocorrencias;
    }

    /**
    * Obtém a lista de campos originais que foram modificados
    * @param Entity Entidade a ser analisada
    * @return array Lista de campos modificados com seus valores originais
    */
    public function changedOriginalFields(Entity $entity)
    {
        return $entity->extractOriginalChanged($entity->visibleProperties());
    }

    /**
    * Obtém a lista de campos modificados em uma entidade, com seus respectivos valores atualizados
    * @param Entity Entidade a ser analisada
    * @param array Lista de campos de uma propriedade com seus respectivos valores.
    * @return array Lista de campos modificados com seus valores originais
    */
    public function changedFields(Entity $entity, array $propriedades)
    {
        $campos = array();

        foreach ($propriedades as $chave => $valor) {
            $campos[$chave] = $entity->get($chave);
        }

        return $campos;
    }
}
