<?php

register_shutdown_function('log_shut');
set_error_handler('log_handler');

//catch function
function log_shut() {
    $error = error_get_last();
    if ($error) {
        log_handler($error['type'], $error['message'], $error['file'], $error['line']);
    }
}

function log_handler($errno, $errstr, $errfile, $errline) {
    $typestr = false;
    switch ($errno) {
        case E_ERROR: // 1 //
            $typestr = 'E_ERROR';
            break;
//        case E_WARNING: // 2 //
//            $typestr = 'E_WARNING';
//            break;
        
//        case E_NOTICE: // 8 //
//            $typestr = 'E_NOTICE';
//            break;
        case E_PARSE: // 4 //
            $typestr = 'E_PARSE';
            break;
        case E_CORE_ERROR: // 16 //
            $typestr = 'E_CORE_ERROR';
            break;
        case E_CORE_WARNING: // 32 //
            $typestr = 'E_CORE_WARNING';
            break;
        case E_COMPILE_ERROR: // 64 //
            $typestr = 'E_COMPILE_ERROR';
            break;
        case E_CORE_WARNING: // 128 //
            $typestr = 'E_COMPILE_WARNING';
            break;
        case E_USER_ERROR: // 256 //
            $typestr = 'E_USER_ERROR';
            break;
        case E_USER_WARNING: // 512 //
            $typestr = 'E_USER_WARNING';
            break;
        case E_USER_NOTICE: // 1024 //
            $typestr = 'E_USER_NOTICE';
            break;
        case E_STRICT: // 2048 //
            $typestr = 'E_STRICT';
            break;
        case E_RECOVERABLE_ERROR: // 4096 //
            $typestr = 'E_RECOVERABLE_ERROR';
            break;
        case E_DEPRECATED: // 8192 //
            $typestr = 'E_DEPRECATED';
            break;
        case E_USER_DEPRECATED: // 16384 //
            $typestr = 'E_USER_DEPRECATED';
            break;
    }
    
    if ($typestr) {
        $msg =[];
               $msg["file"]= $errfile . " at line : " . $errline ;
               $msg["file"]= "type " . $typestr . " : " . $errstr;
//mail 
        log_save($msg, $typestr);
    }
}

function log_save($msg, $typestr) {
    $date = date('Y-m-d_H-i-s');
    $token = md5(uniqid(rand(), true));
    $file = __DIR__ . '/log/' . $date . '_' . $token . '.txt';

    $array = [
        'date' => date('Y-m-d H:i:s'),
        'type' => $typestr,
        'msg' => $msg,
        'server' => $_SERVER
    ];
    $json = json_encode($array);
    file_put_contents($file, $json);
}

?>