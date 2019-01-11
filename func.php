<?php

function decimal($v, $num = 2, $autoDecimal = false) {
    if (empty($v) | $v == 0) {
        return '---';
    }
    $countDecimal = $num;
    if ($autoDecimal) {
        If ($v < 1) {
            $countDecimal = 8;
        }
    }
    $lang = \Base\I18n::getCurrentLang();
    if($lang==='en'){
           return number_format($v, round($countDecimal), '.', ',');
    }
    return number_format($v, round($countDecimal), ',', '.');
}

function decimalAmericano($v, $num = 2, $autoDecimal = false) {
    if (empty($v) | $v == 0) {
        return '---';
    }
    $countDecimal = $num;
    if ($autoDecimal) {
        If ($v < 1) {
            $countDecimal = 6;
        }
    }
    return number_format($v, round($countDecimal), '.', ',');
}

function decimalAuto($v, $num = 2, $numMax = 2) {

    If ($v < 1) {
        $count = 0;
        $decimal = explode('.', $v)[1];
        $array = str_split($decimal);

        foreach ($array as $a) {

            if ($a == '0') {
                $count++;
            } else {
                break;
            }
        }
        $num = $count + $numMax;
    }
    return number_format($v, $num, ',', '.');
}

function dateDesc($timestamp) {
    $datetime1 = new \DateTime($timestamp); //start time
    $datetime2 = new \DateTime('now'); //end time
    $interval = $datetime1->diff($datetime2);
    $y = (int) $interval->format('%Y');
    $m = (int) $interval->format('%m');
    $d = (int) $interval->format('%d');
    $h = (int) $interval->format('%H');
    $i = (int) $interval->format('%i');
    $s = (int) $interval->format('%s');

    if ($y > 0) {
        if ($y == 1) {
            return _e('há [1] ano',$y);
        } else {
            return _e('há [1] anos',$y);
        }
    }
      if ($m > 0) {
        if ($m == 1) {
            return _e('há [1] mês',$m);
        } else {
            return _e('há [1] meses',$m);
        }
    }
    if ($d > 0) {
        if ($d == 1) {
            return _e('há [1] dia',$d);
        } else {
            return _e('há [1] dias',$d);
        }
    }

    if ($h > 0) {
        if ($h == 1) {
            return _e('há [1] hora',$h);
        } else {
            return _e('há [1] horas',$h);
        }
    }

    if ($i > 0) {
        if ($i == 1) {
            return _e('há [1] minuto',$i);
        } else {
            return _e('há [1] minutos',$i);
        }
    }

    if ($s > 0) {
        if ($s == 1) {
            return _e('há [1] segundo',$s);
        } else {
            return  _e('há [1] segundo',$s);
        }
    }
}

function _e($text) {
   
    $lang = \Base\I18n::getCurrentLang();
    $file = __DIR__ . '/i18n/' . $lang . '.php';

    $data = [];
    if (file_exists($file)) {
        $data = require $file;
    }

    if (isset($data[trim($text)])) {
        $text= $data[$text];
    }
    
    //remove o primeiro parametro que e o texto
    $args = func_get_args();
    unset($args[0]);
    
    foreach($args as $key=>$val){
        $text =str_replace('['.$key.']',$val , $text);
    }
    
    return $text;
}

function siteUrl($url) {
    $lang = \Base\I18n::getCurrentLang();
    $link = '/' . $lang . $url;
    return $link;
}

function numFormat($n, $precision = 3) {
    if ($n < 1000000) {
        // Anything less than a million
        $n_format = number_format($n);
    } else if ($n < 1000000000) {
        // Anything less than a billion
        $n_format = number_format($n / 1000000, $precision) . 'M';
    }else if ($n < 1000000000000) {
        // Anything less than a billion
        $n_format = number_format($n / 1000000000, $precision) . 'B';
    }  else {
        // At least a trillion
        $n_format = number_format($n / 1000000000000, $precision) . 'T';
    }

    return $n_format;
}


function tooltip($txt){
    $txt= str_replace('"', "'",$txt);
    return ' data-toggle="tooltip" data-html="true" title="'.$txt.'"';
}