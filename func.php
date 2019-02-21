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
    if ($lang === 'en') {
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
            return _e('há [1] ano', $y);
        } else {
            return _e('há [1] anos', $y);
        }
    }
    if ($m > 0) {
        if ($m == 1) {
            return _e('há [1] mês', $m);
        } else {
            return _e('há [1] meses', $m);
        }
    }
    if ($d > 0) {
        if ($d == 1) {
            return _e('há [1] dia', $d);
        } else {
            return _e('há [1] dias', $d);
        }
    }

    if ($h > 0) {
        if ($h == 1) {
            return _e('há [1] hora', $h);
        } else {
            return _e('há [1] horas', $h);
        }
    }

    if ($i > 0) {
        if ($i == 1) {
            return _e('há [1] minuto', $i);
        } else {
            return _e('há [1] minutos', $i);
        }
    }

    if ($s > 0) {
        if ($s == 1) {
            return _e('há [1] segundo', $s);
        } else {
            return _e('há [1] segundo', $s);
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
        $text = $data[$text];
    }

    //remove o primeiro parametro que e o texto
    $args = func_get_args();
    unset($args[0]);

    foreach ($args as $key => $val) {
        $text = str_replace('[' . $key . ']', $val, $text);
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
    } else if ($n < 1000000000000) {
        // Anything less than a billion
        $n_format = number_format($n / 1000000000, $precision) . 'B';
    } else {
        // At least a trillion
        $n_format = number_format($n / 1000000000000, $precision) . 'T';
    }

    return $n_format;
}

function tooltip($txt) {
    $txt = str_replace('"', "'", $txt);
    return ' data-toggle="tooltip" data-html="true" title="' . $txt . '"';
}

function volumeColor($vol24) {
    if ($vol24 > 1000000000) {
        $color_vol24 = "#00abd2";
    } else if ($vol24 > 100000000) {
        $color_vol24 = "#74d9f1";
    } else if ($vol24 > 10000000) {
        $color_vol24 = "#a1e1f1";
    } else if ($vol24 > 1000000) {
        $color_vol24 = "#bfe7f1";
    } else if ($vol24 > 100000) {
        $color_vol24 = "#dcf8ff";
    } else {
        $color_vol24 = "#f4fcff";
    }
    return $color_vol24;
}

function btnBuy($symbol,$large=false){
    
    
    $symbol = strtolower($symbol);
//    $lang = \Base\I18n::getCurrentLang();
//    if($lang != 'pt-br'){
//        return false;
//    }
    
    $ads = [
       'btc'=>['3xbit'],
       'eth'=>['3xbit'],
        'ltc'=>['3xbit'],
        'bch'=>['3xbit'],
        'bsv'=>['3xbit'],
        'dash'=>['3xbit'],
        'nano'=>['3xbit'],
        'doge'=>['3xbit'],
        'smart'=>['3xbit'],
        'zcr'=>['3xbit'],
        'leax'=>['3xbit'],
        'tnj'=>['3xbit'],
    ];
    
    $partners = [
        '3xbit'=>[
            'img'=>'/assets/img/partners/3xbit.png',
            'link'=>'http://3xb.it/crie-sua-conta?utm_source=coingolive&utm_medium=button_buy',
            'desc'=>'3XBIT'
        ]
    ];
    
    if(!isset($ads[$symbol])){
        return false;
    }
    
    $item = '';
    
    foreach($ads[$symbol] as $name){
        $row = $partners[ $name];
        
        
        
        
    $event ="javascript:gtag('event', '".$row['desc']."', {'event_category': 'btnBuy' });";
        
       $item .= ' <a href="'.$row['link'].'" onclick="'.$event.'" class="dropdown-item" target="_blank">
                                        <img src="'.$row['img'].'" alt="'.$row['desc'].'" style="max-width:55px" />
                    </a>';
    }
    
    $float="float:right;";
    $size = 'btn-sm';
    
    if($large){
        $float="";
        $size='';
    }
    
    $html = '<div class="dropdown" style="margin:0;'.$float.'margin-left:10px; margin-top: -2px; margin-bottom: -2px;">
            <button title="Comprar criptomoeda '.$symbol.'" 
                onclick="javascript:gtag(\'event\', \'btnBuyOpen\', {\'event_category\': \'btnBuy\' });" 
                style="margin:0" class="'.$size.' btn btn-primary  dropdown-toggle" 
                type="button" 
                data-toggle="dropdown">
                BUY  <div class="ripple-container"></div></button>
            <div class="dropdown-menu ">
                                   '.$item.'
                                </div>
        </div>';
    return $html;
}

 function formatPorc($porc, $price=false, $moeda_char = '', $desc = '',$border='0px') {

                    $numClass = round(abs($porc) / 20);
                    if ($numClass > 5) {
                        $numClass = 6;
                    }

                    if ($porc < 0) {
                        $class_percent = 'red' . $numClass;
                    } elseif ($porc > 0) {
                        $class_percent = 'green' . $numClass;
                    } else {
                        return '--';
                        $class_percent = 'badge-default';
                    }
                    $tooltip = '';
                    if ($price) {
                        $tooltip = 'data-toggle="tooltip" data-html="true" title="' . $desc . '<br>' . $moeda_char . decimal($price, 2, true) . ' "';
                    }
                    return '<span style="font-size:13px;width:100%;height:100%;padding:14px;display:block;border-radius: '.$border.';" ' . $tooltip . '  class="badge ' . $class_percent . '">' . decimal($porc, 2) . '%</span>';
}