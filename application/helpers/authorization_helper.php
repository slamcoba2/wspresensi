<?php

class AUTHORIZATION
{
    public static function validateTimestamp($token)
    {
        $CI =& get_instance();
        $token = self::validateToken($token);
        if ($token != false && (now() - $token->timestamp < ($CI->config->item('token_timeout') * 60))) {
            return $token;
        }
        return false;
    }

    public static function validateToken($token)
    {
        $CI =& get_instance();
        return JWT::decode($token, $CI->config->item('jwt_key'));
    }

    public static function generateToken($data)
    {
        $CI =& get_instance();
        return JWT::encode($data, $CI->config->item('jwt_key'));
    }

    public static function TimeExpiredToken($token){
        $CI =& get_instance();
        $now = now();
        $token = AUTHORIZATION::validateToken($token);
        $token_timestamp = $token->timestamp;
        $check = $now - $token_timestamp;
        $timeoutversi_new = 1 * 600;
        //$final = $check < $timeoutversi_new ? $data = array('status' => true, 'token' => $token) : $data = array('status' => false);
        if($check < $timeoutversi_new){
            return $token;
        } else {
            return false;
        }
    }
}