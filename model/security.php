<?php

trait security
{
    public function hash_password($pass){
       $hash = password_hash($pass,PASSWORD_BCRYPT);
       return $hash;
    }

}
