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

function btnAds($symbol, $large = false) {


    $symbol = strtolower($symbol);
//    $lang = \Base\I18n::getCurrentLang();
//    if($lang != 'pt-br'){
//        return false;
//    }

    $ads = [
        'btc' => ['Buy', 'Get Loan'],
        'eth' => ['Buy', 'Get Loan'],
        'xrp' => ['Get Loan'],
        'bnb' => ['Get Loan'],
        'ltc' => ['Buy'],
        'bch' => ['Buy'],
        'bsv' => ['Buy'],
        'dash' => ['Buy'],
        'nano' => ['Buy'],
        'doge' => ['Buy'],
        'smart' => ['Buy'],
        'zcr' => ['Buy'],
        'leax' => ['Buy'],
        'tnj' => ['Buy'],
        'usdt' => ['Buy', 'Earn Interest'],
        'tusd' => ['Buy', 'Earn Interest'],
        'usdc' => ['Earn Interest'],
        'pax' => ['Earn Interest'],
        'dai' => ['Earn Interest']
    ];

    $partners = [
        'Buy' => [
            'link' => 'http://3xb.it/crie-sua-conta?utm_source=coingolive&utm_medium=button_buy',
        ],
        'Get Loan' => [
            'link' => 'https://nexo.io/?utm_source=coingolive&utm_medium=fixed&utm_term=get_loan&utm_content=web_integration&utm_campaign=nexoeverywhere'
        ], 
        'Earn Interest' => [
            'link' => 'https://nexo.io/?utm_source=coingolive&utm_medium=fixed&utm_term=earn_interest&utm_content=web_integration&utm_campaign=nexoeverywhere'
        ],
    ];

    if (!isset($ads[$symbol])) {
        return false;
    }

    $html = '';
    $float = "float:left;margin-left:3px";
    $size = 'btn-ads btn-white';
    foreach ($ads[$symbol] as $name) {
        $row = $partners[$name];
        
        if ($large) {
            $float = "";
            $size=' btn-info';
        }

        $html .= '
            <a target="_blank" rel="nofollow noopener" href="'.$row['link'].'"
                onclick="javascript:gtag(\'event\', \'' . _e($name) . '\', {\'event_category\': \'' . _e($name) . '\' });" class="' . $size . ' btn-sm btn">' . _e($name) . '</a>';
    }

    return '<div style="'.$float.'" >' . $html . '</div>';
}

function formatPorc($porc, $price = false, $moeda_char = '', $desc = '', $border = '0px') {

    $numClass = round(abs($porc) / 20);
    if ($numClass > 5) {
        $numClass = 6;
    }

    if ($porc < 0) {
        $class_percent = 'red' . $numClass;
    } elseif ($porc > 0) {
        $class_percent = 'green' . $numClass;
    } else {
        return '';
        $class_percent = 'badge-default';
    }
    $tooltip = '';
    if ($price) {
        $tooltip = 'data-toggle="tooltip" data-html="true" title="' . $desc . '<br>' . $moeda_char . decimal($price, 2, true) . ' "';
    }
    return '<span style="font-size:13px;width:100%;height:100%;padding:14px;display:block;border-radius: ' . $border . ';" ' . $tooltip . '  class="badge ' . $class_percent . '">' . decimal($porc, 2) . '%</span>';
}

function classPorc($porc, $price = false, $moeda_char = '', $desc = '', $border = '0px') {

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
    return $class_percent;
}
