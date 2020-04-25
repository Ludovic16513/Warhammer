<?php

trait Mail
{
    public function Sendmail($to,$subject,$message,$headers)
    {
        filter_var($to, FILTER_SANITIZE_EMAIL);
        mail($to,$subject,$message,$headers);
    }
}




