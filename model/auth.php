<?php

class Auth extends MySqlDb{

    static function login($data) {
        $auth = Auth::checkData(
            'user',
            "username='".$data->username."' AND password='".md5($data->password)."'"
        );
        $obj = new stdClass();
        if ($auth->success == true) {
            $obj->status = 200;
            $obj->success = true;
            $obj->user_id = $auth->user_id;
        } else {
            $obj->status = 401;
            $obj->message = "Username atau password salah";
        }
        return $obj;
    }
}