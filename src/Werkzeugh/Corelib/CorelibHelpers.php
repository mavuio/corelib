<?php namespace Werkzeugh\Corelib;



class CorelibHelpers
{



    public function MergeArrays($Arr1, $Arr2)
    {
        foreach($Arr2 as $key => $Value)
        {
            if(array_key_exists($key, $Arr1) && is_array($Value))
                $Arr1[$key] = $this->MergeArrays($Arr1[$key], $Arr2[$key]);

            else
                $Arr1[$key] = $Value;

        }

        return $Arr1;

    }


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
