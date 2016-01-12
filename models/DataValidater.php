<?php

namespace app\models;

class DataValidater {
    
    // 检查$mode中的字段是否都已经被$dest所设置
    public static function isAllSet( $mode , $dest ) {
        foreach ( $mode as $attr ) {
            if( !isset( $dest[ $attr ] ) ) {
                return false;
            }
        }
        return true;
    }   
    // 检查$mode中的元素是否都作为key存在于$dest中
    // 注意$mode不为关联数组，$dest为关联数组
    public static function isAllExist( $mode , $dest ) {
        foreach ( $mode as $attr ) {
            if( !array_key_exists( $attr , $dest ) ){
                echo "$attr" . " not found" . "\n";
                return false;
            }
        }
        return true;
    }
    // 检查本地数据$local是否与服务器数据$srv冲突
    public static function isConflictive( $local , $srv , $cretAttr = "update_time" ) {
        if( isset( $srv[ $cretAttr ] ) ) {
            $localDate = $local[ $cretAttr ];
            $srvDate = $srv[ $cretAttr ];
            foreach ( $srv as $key => $srvVal ) {
                if( // 冲突
                    $key != $cretAttr && // 保存时间字段的异同不是冲突的依据
                    !is_null( $srvVal ) && // 服务器数据非null
                    !is_null($srvDate ) && // 服务器保存时间非null
                    !( $srvVal === $local[ $key ] ) && // 服务器数据和本地数据不同
                    $localDate < $srvDate   // 本地保存时间 < 服务器保存时间
                ) {
                    return true;
                }
            }
            return false;
        }
        return false;
    }
} 