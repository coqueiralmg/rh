<?php

namespace App\View\Helper;

use Cake\View\Helper;

class AgentHelper extends Helper
{
    private $browsers;
    private $oss;

    public function initialize(array $config)
    {
        $this->browsers = $this->arrayBrowsers();
        $this->oss = $this->arrayOperationSystems();
    }

    public function getBrowser(string $userAgent)
    {
        $browserSelect = 'Desconhecido';

        foreach($this->browsers as $browser => $keys)
        {
            if($keys['all'])
            {
                $verificado = false;

                foreach($keys['keys'] as $key)
                {
                    $verificado = (bool) preg_match('/' . $key . '/', $userAgent);
                }

                if($verificado)
                {
                    $browserSelect = $browser;
                    break;
                }
            }
            else
            {
                foreach($keys['keys'] as $key)
                {
                    if(preg_match('/' . $key . '/', $userAgent))
                    {
                        $browserSelect = $browser;
                        break 2;
                    }
                }
            }
        }

        return $browserSelect;
    }

    public function getOperationSystem(string $userAgent)
    {
        $os = 'Desconhecido';

        foreach($this->oss as $key => $value)
        {
            if(preg_match('/' . $value . '/', $userAgent))
            {
                $os = $key;
                break;
            }
        }

        return $os;
    }

    private function arrayBrowsers()
    {
        return [
            'Internet Explorer' => [
                'all' => false,
                'keys' => ['MSIE', 'Trident', 'WOW']
            ],
            'Microsoft Edge' => [
                'all' => true,
                'keys' => ['Edge']
            ],
            'Firefox' => [
                'all' => true,
                'keys' => ['Firefox']
            ],
            'Chrome' => [
                'all' => true,
                'keys' => ['Chrome']
            ],
            'Opera' => [
                'all' => true,
                'keys' => ['Presto']
            ],
            'Safari' => [
                'all' => true,
                'keys' => ['Safari']
            ],
            'BlackBerry' => [
                'all' => true,
                'keys' => ['BlackBerry']
            ],
            'Opera Mobile' => [
                'all' => true,
                'keys' => ['Opera Mobi', 'Opera Mini']
            ]
        ];
    }

    private function arrayOperationSystems()
    {
        return [
            'Windows 3.11' => 'Win16',
            'Windows 95' => 'Win95',
            'Windows 98' => 'Win98',
            'Windows 2000' => 'Windows NT 5.0',
            'Windows XP' => 'Windows NT 5.1',
            'Windows Server 2003' => 'Windows NT 5.2',
            'Windows Vista' => 'Windows NT 6.0',
            'Windows 7' => 'Windows NT 6.1',
            'Windows 8' => 'Windows NT 6.2',
            'Windows 10' => 'Windows NT 10.0',
            'Windows NT 4.0' => 'WinNT',
            'Windows ME' => 'Windows ME',
            'Open BSD' => 'OpenBSD',
            'Sun OS' => 'SunOS',
            'iOS (iPhone)' => 'iPhone',
            'iOS (iPad)' => 'iPad',
            'Ubuntu Linux' => 'Ubuntu; Linux',
            'Android' => 'Linux; Android',
            'Linux' => 'Linux',
            'Mac OS' => 'Mac_PowerPC',
            'QNX' => 'QNX',
            'BeOS' => 'BeOS',
            'OS/2' => 'OS/2'
        ];
    }
}