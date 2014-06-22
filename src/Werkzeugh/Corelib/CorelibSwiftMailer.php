<?php namespace Werkzeugh\Corelib;

use Swift_Mailer;
use Swift_Mime_Message;

class CorelibSwiftMailer extends Swift_Mailer
{

    public function send(Swift_Mime_Message $message, &$failedRecipients = null)
    {
        $messageRecord=[
            'to'=>$this->formatRecipients($message->getTo()),
            'subject'=>$message->getSubject(),
            'from'=>$this->formatRecipients($message->getFrom()),
            'cc'=>$this->formatRecipients($message->getCc()),
            'bcc'=>$this->formatRecipients($message->getBcc()),
            'body'=>$message->getBody(),
        ];

        $this->logMessage($messageRecord);

        if ($this->isOffline()) {
            return 1;
        }

        return parent::send($message, $failedRecipients );
    }

    public function logMessage($messageRecord)
    {
        \Log::info("sending mail to {$messageRecord[to]}:\"{$messageRecord[subject]}\"",$messageRecord);
    }

    public function formatRecipients($arr)
    {
        $ret=[];
        if(is_array($arr)) {
            foreach ($arr as $email => $name) {
                if ($name) {
                    $ret[]="$name <$email>";
                } else {
                    $ret[]="$email";
                }
            }
        }
        return implode(', ',$ret);
    }

    public function isOffline()
    {

        if(file_exists('/Applications'))
        {
            return !checkdnsrr('google.com', 'ANY');
        }

        return false;
    }

}
