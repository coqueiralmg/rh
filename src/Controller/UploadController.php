<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;


class UploadController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function imageEditor()
    {
        if($this->request->is('post'))
        {
            $this->autoRender = false;
            $diretorio = ROOT . DS . '..' . DS . 'webroot' . DS . 'public' . DS . 'editor' . DS . 'images' . DS;
            $url_relativa = '/public/editor/images/';
            $arquivo = $this->request->getData('upload');
            $temp = $arquivo['tmp_name'];
            $nome_arquivo = $arquivo['name'];
            $response = array();

            $file = new File($temp);
            $file->copy($diretorio . $nome_arquivo, true);

            echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction(1, '" . $url_relativa . $nome_arquivo . "', '');</script>";
            
        }
    }
}