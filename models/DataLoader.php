<?php

namespace app\models;

use Yii;

class DataLoader {
    
    private $rawData = null;
 
    public static function post() {
        return Yii::$app->request->post();
    }
    
    public static function uuid() {
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = "-";
        $uuid =
        substr($charid, 0, 8).$hyphen
        .substr($charid, 8, 4).$hyphen
        .substr($charid,12, 4).$hyphen
        .substr($charid,16, 4).$hyphen
        .substr($charid,20,12);
        return $uuid;
    }
    
    public function getPost() {
        //接收post数据
        $this->rawData = Yii::$app->request->post();
    }
    
    //  直接获取未处理数据
    public function getRaw() {
       
        return  $this->rawData;
    }
    
    // 将$src中包含的所有以$keys的所有元素为键的键值对取出
    public static function exportFromArray( $keys , $src  ) {
        $ret = array();
        foreach ( $keys as $key ) {
            if( array_key_exists( $key , $src) ) {
                $ret[ $key ] = $src[ $key ];
            } else {
                return null;
            }
        }
        return $ret;
    }
    
    // 将$src中包含的所有以$keys的所有元素为键的存在的键值对取出
    public static function exportFromArrayExist( $keys , $src  ) {
        $ret = array();
        foreach ( $keys as $key ) {
            if( array_key_exists( $key , $src) ) {
                $ret[ $key ] = $src[ $key ];
            } 
        }
        return $ret;
    } 
    
    // 将$src中除$keys以外的元素取出
    public static function exportFromArrayExce( $keys , $src ) {
        foreach ( $keys as $key ) {
            unset( $src[ $key ] );
        }
        return $src;
    }

    // 如果$src中存在不为空的$key列，则将其值取出
    public static function exportColumn( $key , $src ) {
        if( isset( $src[ $key ] ) ) {
            return $src[ $key ];
        } else {
            return null;
        }
    }
    
}