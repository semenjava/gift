<?php

namespace common\helpers;

class StringHelper {
    
    const GET_DATA_FORMAT = 'php:d.m.Y';
    
    public static function encodeEmoji($str) {
        return empty($str) ? $str : mb_convert_encoding($str, "html-entities");
    }
    
    public static function decodeEmoji($str) {
        return empty($str) ? $str : html_entity_decode($str);
    }
    
    public static function getDataFormate($date,$format='') {
        return empty($date) ? $date : \Yii::$app->formatter->asDatetime($date, !empty($format)?$format:self::GET_DATA_FORMAT);
    }
    
}
