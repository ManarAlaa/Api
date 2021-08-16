<?php

namespace App\Traits;

/**
 * 
 */
trait response{
    public function jsnResponse($success , $msg , $data = null){
        return response([
            'successful' => $success,
            'message' => $msg,
            'data'=> $data
        ]);

    }
}



?>