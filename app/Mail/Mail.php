<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Mail extends Mailable
{
    use Queueable, SerializesModels;

    public function removeDuplicateEmail()
    {
        $arrTo  = [];
        $arrCc  = [];
        $arrBcc = [];

        foreach ($this->to as $item) {
            $hash = md5($item['address']);

            $arrTo[$hash] = $item;
        }

        foreach ($this->cc as $item) {
            $hash = md5($item['address']);

            if (isset($arrTo[$hash])) {
                continue;
            }

            $arrCc[$hash] = $item;
        }

        foreach ($this->bcc as $item) {
            $hash = md5($item['address']);

            if (isset($arrTo[$hash]) || isset($arrCc[$hash])) {
                continue;
            }

            $arrBcc[$hash] = $item;
        }

        $this->to  = [];
        $this->cc  = [];
        $this->bcc = [];

        foreach ($arrTo as $item) {
            $this->to[] = $item;
        }

        foreach ($arrCc as $item) {
            $this->cc[] = $item;
        }

        foreach ($arrBcc as $item) {
            $this->bcc[] = $item;
        }
    }
}