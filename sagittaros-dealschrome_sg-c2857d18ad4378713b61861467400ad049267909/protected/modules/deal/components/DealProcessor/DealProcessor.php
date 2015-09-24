<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class DealProcessor {

    public static function process($doc) {
        $doc = self::preprocess($doc);
        switch ($doc->dealsource) {
            case 'jigocity.com.sg':
                $doc = self::process_no_truncate($doc);
                break;
            case 'outlet.com.sg':
            case 'nicedeal.sg':
                $doc = self::process_modulus_hours($doc);
                break;
        }
        $doc = self::postprocess($doc);
        return $doc;
    }

    protected static function preprocess($doc) {
        $worth = $doc->worth;
        $savings = $worth - $doc->price;
        $savings = number_format($savings, 2);
        $worth = number_format($worth, 2);

        $secsleft = $doc->expiry - time();
        $minsleft = floor($secsleft / 60 % 60);
        $hoursleft = floor($secsleft / 3600) % 100;
        $timeleft_string = $hoursleft . 'h ' . $minsleft . 'm ';
        
        $doc->worth = $worth;
        $doc->savings = $savings;
        $doc->timeleft = $timeleft_string; 
        return $doc;
    }

    protected static function postprocess($doc) {
        return $doc;
    }

    protected static function process_no_truncate($doc) {
        $secsleft = $doc->expiry - time();
        $minsleft = floor($secsleft / 60 % 60);
        $hoursleft = floor($secsleft / 3600);
        $timeleft_string = $hoursleft . 'h ' . $minsleft . 'm ';

        $doc->timeleft = $timeleft_string; 
        return $doc;
    }
    
    protected static function process_modulus_hours($doc) {
        $secsleft = $doc->expiry - time();
        $minsleft = floor($secsleft / 60 % 60);
        $hoursleft = floor($secsleft / 3600) % 24;
        $timeleft_string = $hoursleft . 'h ' . $minsleft . 'm ';

        $doc->timeleft = $timeleft_string; 
        return $doc;
    }

}

