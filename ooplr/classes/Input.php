<?php

class Input{
    public static function exists($type = 'post'){
        switch($type){
            case 'post':
                return (!empty($_POST))? true: false;
            break;
            case 'get':
                return (!empty($_GET))? true: false;
            break;

            default:
                return false;
            break;
        }
    }
    public static function get($item){
        if(isset($_POST)){
            return (isset($_POST[$item]) ? $_POST[$item] : null);
        }else if (isset($_get)){
            return (isset($_GET[$item]) ? $_GET[$item] : null);
        }
        return '';
    }
}