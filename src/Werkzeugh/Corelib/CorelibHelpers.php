<?php namespace Werkzeugh\Corelib;



class CorelibHelpers
{

    public function dash_case($str)
    {
        return str_replace('_','-',snake_case($str));
    }

    public function sendNotifyMail($msg,$data=[],$params=[])
    {

        if (!$params['subject']) {
            $params['subject']=$msg;
        }
        if (!$params['recipient']) {
            $params['recipient']="errors@werkzeugh.at";
        }

        \Mail::send("corelib::emails.data_email",['data'=>$data,'msg'=>$msg], function($message) use ($params)
        {
            $message->to($params['recipient']);
            $message->subject( $params['subject']);
        });

    }
}
