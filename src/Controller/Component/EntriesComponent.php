<?php

namespace App\Controller\Component;

require_once(ROOT . DS . 'src' . DS  . 'Libs' . DS . 'LeLogger.php');

use App\Libs\LeLogger;
use Cake\Controller\Component;
use Cake\Core\Configure;

/**
 * Compomente de registro de dados junto a LogEntries
 * @package App\Controller\Component
 */
class EntriesComponent extends Component
{
    /**
    * Faz o registro de log, salvando os dados no LogEntries
    */
    public function register(string $registro)
    {
        $log = $this->configureHostLog();
        $log->Info($registro);
    }

    /**
    * Faz a configuração de comunicação do sistema com o servidor
    * @return App\Libs\LeLogger Motor de registro de log.
    */
    private function configureHostLog()
    {
        $LOGENTRIES_TOKEN = Configure::read('LogEntries.client.token');
        $DATAHUB_IP_ADDRESS = Configure::read('LogEntries.dataHub.IPAddress');
        $DATAHUB_PORT = Configure::read('LogEntries.dataHub.port');
        $DATAHUB_ENABLED = Configure::read('LogEntries.dataHub.enabled');
        $HOST_NAME_ENABLED = Configure::read('LogEntries.host.enabled');
        $HOST_NAME = Configure::read('LogEntries.host.name');
        $HOST_ID = Configure::read('LogEntries.host.id');
        $ADD_LOCAL_TIMESTAMP = Configure::read('LogEntries.localTimestamp');

        $Persistent = Configure::read('LogEntries.persistent');
        $SSL = Configure::read('LogEntries.ssl');
        $Severity = Configure::read('LogEntries.severity');
        
        $ENV_TOKEN = getenv('LOGENTRIES_TOKEN');

        if ($ENV_TOKEN != false && $LOGENTRIES_TOKEN === "")
        {
            $LOGENTRIES_TOKEN = $ENV_TOKEN;
        }
      
        $log = LeLogger::getLogger($LOGENTRIES_TOKEN, $Persistent, $SSL, $Severity, $DATAHUB_ENABLED, $DATAHUB_IP_ADDRESS, $DATAHUB_PORT, $HOST_ID, $HOST_NAME, $HOST_NAME_ENABLED, $ADD_LOCAL_TIMESTAMP);

        return $log;
    }
}