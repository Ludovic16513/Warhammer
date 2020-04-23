<?php

trait Mail
{
    public function Sendmail($to,$subject,$message,$headers)
    {
        mail($to,$subject,$message,$headers);
    }
}




