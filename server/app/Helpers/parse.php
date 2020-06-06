<?php

/**
 * Recebe um data no formato de String e converte no padrão de date para savar no banco
 * @author Jos3duardo
 * @param $date
 * @return string
 */
if (!function_exists('dateParse')){
    function dateParse($date){
        //DD/MM/YYY -> YYYY-MM-DD
        $dateArray = explode('/', $date);
        // [dd, mm, yyyy]
        $dateArray = array_reverse($dateArray);
        //[yyyy-mm-dd]
        return implode('-',$dateArray);
    }
}


/**
 * Recebe uma string e retorna um numero formatado sem virgula
 * @param $number
 * @return mixed
 */
if (!function_exists('parse_number')) {
    function parse_number($number)
    {
        //1.000,58 -> 1000.58
        $newNumber = str_replace('.', '', $number);
        $newNumber = str_replace(',', '.', $newNumber);
        return $newNumber;
    }
}

