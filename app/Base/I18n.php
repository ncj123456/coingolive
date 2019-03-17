<?php

namespace Base;

class I18n {

    static private $currentLang;

    static function getListLangs() {
        $langs = [
            'en' => 'English',
            'pt-br' => 'Português Brasil'
        ];
        return $langs;
    }

    static function getListMoeda() {
        $moedas = [
            'USD'=>'$',
            'BRL' => 'R$',
            'EUR' => '€',
            'BTC'=>'BTC'
        ];
        return $moedas;
    }

    static function setCurrentLang($lang) {
        self::$currentLang = $lang;
    }

    static function getCurrentLang() {
        if(!empty(self::$currentLang)){
                return self::$currentLang;
        }
        return 'en';
    }

}
