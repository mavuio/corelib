<?php namespace  Werkzeugh\Corelib\Controllers;

use Werkzeugh\Ecosystem\BaseController;

class LogViewerController extends \MyBackendBaseController {


/*==========  begin listr-setup  ==========*/

    public function init()
    {
        parent::init();
        $this->listr=\App::make('\Werkzeugh\Listr\ListrControllerExtension');
        $this->listr->registerController($this, 'listr');
    }

    public function postListr()
    {
       //dispatcher-needed for listr
       return  $this->listr->dispatch();

    }


/*==========  end listr-setup  ==========*/



    public function getIndex()
    {

        $this->eco->setContentTemplate('corelib::pages.log_viewer');
        $c=['listrArguments'=>['listtype'=>'default']]; //optional arguments
        return $c;

    }

    public function getLogDir()
    {
        return storage_path().'/logs';
    }

    public function getLogfiles()
    {
        // TODO read logfiles

    }

    public function listrQuery()
    {
        return Upload::query();
    }

    public function listrConfig()
    {

        $config=array(
            'displayColumns'=>[
                'id',
                '_bilder',
                'status',
                '_station',
                '_name',
                'email',
                'created_at'
                ],
            'searchFields'=>[
                'keyword'=>['fields'=>['email','firstname','lastname','name']]
                ],
            'orderBy'=>[
                ['created_at','desc']
            ],
            'additionalDataColumns'=>array(
                '_getThumbnailUrl'=> function($rec) { return $rec->getThumbnailUrl(); },
                '_station'=> function($rec) { return $rec->station->name; },
                // '_name'=>['fields'=>['firstname','lastname','name']],
                ),
            'columnTemplates'=>array(
                '_mail'=>'{{rec.msg_to}}  {{rec.msg_subject}} {{rec.msg_sender_ip}} {{rec.msg_from}} {{rec.msg_attachment}}',
                '_bilder'=>'<img src="{{rec._getThumbnailUrl}}">',
                '_station'=>'{{rec._station}}',
                '_name'=>'<span ng-show="rec.name">{{rec.name}}</span><span ng-hide="rec.name">{{rec.firstname}} {{rec.lastname}}</span>',
                ),
            'displayColumnSettings'=>array(
                '_name'=>['label'=>'name'],
                '_bilder'=>['label'=>'Bild'],
                'email'=>['label'=>'E-Mail Adresse'],
                'created_at'=>['label'=>'Erstellungsdatum'],
                ),
            );


        return $config;
    }




}
