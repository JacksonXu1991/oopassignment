<?php

namespace app\models;

use app\models\Status;
use app\models\DataValidater;

class Table {
    
    private static $funcSetAttribute = "setAttribute"; // 回调函数名: 设置单个属性
    private static $funcAttributes = "attributes"; // 回调函数名: 获得所有属性
    private static $funcAll = "all"; // 回调函数名: 获得所有查询结果集
    private static $funcAsArray = "asArray"; // 回调函数名: 将结果集按数组方式返回
    
    private static $funcCount = "count"; // 回调函数名：统计数量
    
    private static $funcDelete = "delete"; // 回调函数名: 删除记录
    
    private static $funcFind = "find"; // 回调函数名: 查询记录
    private static $funcFindOne = "findOne" ; // // 回调函数名: 根据主键查找一个记录
    
    private static $funcGetAttribute = "getAttribute"; // 回调函数名：获得指定属性
    private static $funcGetAttributes = "getAttributes";  // 回调函数名: 获得所有属性
    private static $funcGetPrimaryKey = "getPrimaryKey"; // 回调函数名: 获得所有主键
    
    private static $funcInsert = "insert"; // 回调函数名: 插入记录
    
    private static $funcJoinWith = "joinWith"; // 回调函数名：连接表
    
    private static $funcLimit = "limit"; // 回调函数名:设置结果集数量
    
    private static $funcOrderBy = "orderBy"; // 回调函数名：设置排序列
    private static $funcOne = "one";    // 回调函数名：返回单个结果集
    private static $funcOffset = "offset"; // 回调函数名: 设置偏移量
    
    private static $funcPrimaryKey = "primaryKey";   // 回调函数名: 主键

    private static $funcSelect = "select"; // 回调函数名：选择列
    private static $funcSave = "save"; // 回调函数名:写入数据库
    
    private static $funcTableName = "tableName"; // 回调函数名：获得表名
    
    private static $funcWhere = "where"; // 回调函数名：条件查询
    private static $funcWith = "with"; // 回调函数名：联合查询
    
    
    // 在表中新建空记录并获得其主键的值
    public static function addBlankOne( $arObj  , &$retDataContainer ) {     
        // 插入空记录    
        if( self::insert( $arObj , null ) != false && ( $retDataContainer = self::getPrimaryKeyVal($arObj) ) != null ) {
            return Status::RET_SUCCESSFUL;
        } else {
            return Status::RET_INSERT_ERROR;
        }
    }
    
    // 在表中新建记录并获得其主键的值
    // $duplicative默认为True
    // $duplicative = true :允许插入重复的$dataToAdd; 
    // $duplicative = false :会检查$dataToAdd,如果其中的内容已存在，则不会插入，且$retDataContainer保存已存在的记录主键
    // 如果$dataToAdd为null,则无论$duplicative是否为true，都会被插入
    public static function addOne( $arObj , $dataToAdd , &$retDataContainer , $duplicative = true ) {
        $status = Status::RET_SUCCESSFUL;
        if( $dataToAdd == null ) {
            $status = self::addBlankOne( $arObj , $retDataContainer ); // 空记录
        } else {
            // 检查字段   
            if( !DataValidater::isAllExist( array_keys( $dataToAdd ) , self::getAttributesWithoutPK($arObj) ) ) { // 检查$dataToAdd中是否存在不应当插入的字段
                return Status::RET_INVALID_INPUT_PARAM_FORMAT;
            }
            if( $duplicative ) {
                $status = self::insert( $arObj , $dataToAdd );
            } else {
                $dupOne = self::findOneByCond( $arObj , $dataToAdd );
                if( $dupOne != null ) { // 存在重复记录
                    $retDataContainer = self::getPrimaryKeyVal( $dupOne );
                    $status = Status::RET_SUCCESSFUL;
                    $arObj = $dupOne;
                    
                } else { // 不存在，插入该记录
                    $status = self::insert( $arObj , $dataToAdd );
                }
            }
        }
       
        if( $status === false ) {   // 插入失败
            return Status::RET_INSERT_ERROR;
        }
        if( ( $retDataContainer = self::getPrimaryKeyVal( $arObj ) ) != null ) {
            return Status::RET_SUCCESSFUL; // 成功
        }
        return Status::RET_SERVER_ERROR; // 未获取到主键
    }
    
    // 获得总的记录数
    public static function countTotal( $arObj ) {
        $findRet = self::findAll( $arObj );
        return count( $findRet );
    }
    
    
    // 根据主键更新一条记录
    public static function updateOneByPrimaryKey( $arObj , $pkVal , $dataToUp , $allowModifyPK = false ) {
        return self::updateOne( self::findOneByPrimaryKey( $arObj , $pkVal ) , $dataToUp , $allowModifyPK );
    }
    
    // 根据条件更新一条记录
    public static function updateOneByCond( $arObj , $cond , $dataToUp , $allowModifyPK = false ) {
        return self::updateOne( self::findOneByCond( $arObj , $cond ) , $dataToUp , $allowModifyPK );
    }
    
    // 通过已获得的destObj更新一条记录
    private static function updateOne(  $destObj , $dataToUp , $allowModifyPK = false  ) {
        if( $destObj == null ) {
            return Status::RET_DEST_NOT_FOUND;
        }
        $attrToUpName = array_keys( $dataToUp ); // 待更新的字段名
        if( $allowModifyPK == false ) { // 不允许更新主键
            $checkList = self::getAttributesWithoutPK($destObj); // 不含主键
        } else {
            $checkList = self::getAttributes($destObj); // 含主键
        }
        if( !DataValidater::isAllExist( array_keys( $dataToUp ) , self::getAttributesWithoutPK($destObj) ) ) { // 检查$dataToUp中是否存在不应当更新的字段
            return Status::RET_INVALID_INPUT_PARAM_FORMAT;
        }
        if( self::setAttributes($destObj, $dataToUp , array_keys( $dataToUp ) ) != true ) { // 设置属性失败
            return Status::RET_INSERT_ERROR;
        }
        if( self::save($destObj) != true ) {  // 保存失败
            return Status::RET_SERVER_ERROR;
        }
        return Status::RET_SUCCESSFUL;
    }

    // 获得一条记录
    private static function retrieveOne( $destObj , &$retDataContainer ) {
        if( $destObj == null ) {
            return Status::RET_DEST_NOT_FOUND;
        }
        $attr = self::getAttributes( $destObj );
        if( $attr != null ) {
            $retDataContainer = $attr;
            return Status::RET_SUCCESSFUL;
        } else {
            return Status::RET_SERVER_ERROR;
        }        
    }
    
    // 根据物理主键获得一条记录
    public static function retrieveOneByPrimaryKey( $arObj , $pkVal , &$retDataContainer ) {
        return self::retrieveOne( self::findOneByPrimaryKey( $arObj , $pkVal ) , $retDataContainer );
    }
    
    // 根据条件获得一条记录
    public static function retrieveOneByCond( $arObj , $cond , &$retDataContainer ) {
        return self::retrieveOne( self::findOneByCond( $arObj , $cond ) , $retDataContainer );
    }
    
    // 将一条记录的除主键外和例外的字段外所有字段设为NULL
    private static function setOneAllAttrNull( $destObj , $except = null ) {
        if( $destObj == null ) {
            return Status::RET_DEST_NOT_FOUND;
        }
        $dataSet = self::getAttributesWithoutPK($destObj);
        if( $except != null ) { // 去除例外字段
            foreach ( $except as $eachExc ) {
                if( isset( $dataSet[ $eachExc ] ) ) {
                    unset( $dataSet[ $eachExc ] );
                }
            }
        }
        foreach ( $dataSet as $key => $val ) {
            $dataSet[ $key ] = "";
        }
        if( self::setAttributes( $destObj , $dataSet , array_keys( $dataSet ) ) != true ) { // 设置属性失败
            return Status::RET_INSERT_ERROR;
        }
        if( self::save( $destObj ) != true ) { // 保存失败
            return Status::RET_SERVER_ERROR;
        }
        return Status::RET_SUCCESSFUL;
    }
    
    // 根据主键，将一条记录的除主键外和例外的字段外所有字段设为NULL
    public static function setOneAllAttrNullByPrimaryKey( $arObj , $pkVal , $except = null ) {
        $destObj = self::findOneByPrimaryKey( $arObj , $pkVal ); // 目标AR的实例
        return self::setOneAllAttrNull( $destObj , $except );
    }
    
    // 根据主键，将一条记录的的除主键和例外的字段外所有字段设为NULL
    public static  function setOneAllAttrNullByCond( $arObj , $cond , $except = null ) {
        $destObj = self::findOneByCond( $arObj , $cond );
        return self::setOneAllAttrNull( $destObj , $except );
    }

    // 根据主键的值删除表中记录
    // FIXME:函数名不合适
    public static function deleteFromTable( $arObj , $pkVal ){
        
        // 根据主键的值找到目标实例
        $dest = call_user_func( array( $arObj , self::$funcFindOne ) , $pkVal  );
        
        if( $dest == null ) {
            return Status::RET_DEST_NOT_FOUND;
        }
        
        if( self::delete( $dest ) != false ) {
            return Status::RET_SUCCESSFUL;
        }
        return Status::RET_DELETE_ERROR;
    }
    
    // 根据主键的值删除表中记录
    public static function deleteFromTableByPrimaryKey(  $arObj , $pkVal  ) {
        // 根据主键的值找到目标实例
        $dest = call_user_func( array( $arObj , self::$funcFindOne ) , $pkVal  );
        
        if( $dest == null ) {
            return Status::RET_DEST_NOT_FOUND;
        }
        
        if( self::delete( $dest ) != false ) {
            return Status::RET_SUCCESSFUL;
        }
        return Status::RET_DELETE_ERROR;
    }
    
    // 根据条件删除表中记录
    public static function deleteFromTableByCond( $arObj , $cond ) {
        $findRet = call_user_func( array( $arObj , self::$funcFind ) );
        $whereRet = call_user_func( array( $findRet , self::$funcWhere  ) , $cond );
        $allRet = call_user_func( array( $whereRet , self::$funcAll ) );
        $delStatus = Status::RET_SUCCESSFUL;
        foreach ( $allRet as $eachObj ) {
            if( !call_user_func( array( $eachObj , self::$funcDelete ) ) ) {
                $delStatus = Status::RET_DELETE_ERROR;
            }
        }
        return $delStatus;
    }
    
    // 推送表中数据

    // 根据条件推送
    public static function pushByCond( $arObj , $cond , $data , &$retDataContainer ) {
        return self::push( self::findOneByCond( $arObj , $cond ), $data, $retDataContainer );
    }
    
    // TODO: 优化对attributes()和getAttributes()的分别调用
    private static function push( $arObj , $data , &$retDataContainer ) {

        $tableAttr = array_keys( self::getAttributesWithoutPK($arObj) ); // 获得待推送表的所有字段名
        // TODO: $tableAttr验证
    
        // 检查字段是否都存在
        if( !DataValidater::isAllExist(  $tableAttr , $data ) ) {
            return Status::RET_INVALID_INPUT_PARAM_FORMAT;
        }
    
        // 获得目标AR的实例
        $dest = $arObj; 
        
        // 未找到
        if( $dest == null ) {
            return Status::RET_DEST_NOT_FOUND;
        }
        // 获取服务器当前数据
        $currSrvData = self::getAttributes( $dest );  // $dest->getAttributes();
        // TODO: $currSrvData验证

        // 冲突处理
        if( DataValidater::isConflictive( $data , $currSrvData ) ) { // 发生冲突
            $retDataContainer = array();
            // 将服务器数据插入$srvData
            foreach ( $currSrvData as $key => $val ) {
                $retDataContainer[ $key ] = $val;
            }
            return  Status::RET_CONFLICTIVE_DATA;
        }

        // 将数据写入
        if( self::setAttributes( $dest , $data , $tableAttr ) && self::save( $dest ) ) { // 成功,$dest->save()
            return Status::RET_SUCCESSFUL;
        } else { // 失败
            return Status::RET_INSERT_ERROR;
        }
    
    }
    
    // 拉取表中数据
    // TODO: 降耦、状态判断
    public static function pull( $arObj , $start , $length , &$retDataContainer , $search = null , $orderCol = null , $orderDir = null , $cond = null , $joinWith = null  ) {
        // $arObj->find()->offset( $start )->limit( $length )->asArray()->all();
        
        // 结果是$findRet
        $findRet = call_user_func( array( $arObj , self::$funcFind ) ); // arObj->find()
        
        
        // 结果是$joinRet
        if( $joinWith != null ) { // 联合查询
            $joinRet = call_user_func( array( $findRet , self::$funcJoinWith ) , $joinWith );
        } else {
            $joinRet = $findRet;
        }
        
        
        // 结果是$condRet
        if( $cond != null ) { // 条件查询
            $condRet = call_user_func( array( $joinRet , self::$funcWhere ) , $cond );
        } else { // 无条件
            $condRet = $joinRet;
        }
        
        // 结果是$searchRet
        if( $search != null && $orderCol != null ) { // 搜索
            $tmpCond = array(
                "like",
                self::tableName( $arObj ) . "." . $orderCol ,
                $search
            );  
            $searchRet = call_user_func( array( $condRet , self::$funcWhere ) , $tmpCond );
        } else { // 无搜索
            $searchRet = $condRet;
        }
        
        // 结果是$orderRet
        if( $orderCol != null && $orderDir != null ) { // 排序
           
            $tmpCond = self::tableName($arObj) . "." . $orderCol . " " . $orderDir;
	
            $orderRet = call_user_func( array( $searchRet , self::$funcOrderBy ) , $tmpCond );
        } else {
            $orderRet = $searchRet;
        }
        
        $offsetRet = call_user_func( array( $orderRet , self::$funcOffset ) , $start ); // ->offset( $start )
        
        if( $length >= 0 ) {
            $limitRet = call_user_func( array( $offsetRet , self::$funcLimit ) , $length ); // ->limit( $length )            
        } else {
            $limitRet = $offsetRet;
        }
        $asArrRet = call_user_func( array( $limitRet , self::$funcAsArray ) ); // ->asArray()
        $allRet = call_user_func( array( $asArrRet , self::$funcAll ) ); // ->all()
        $retDataContainer = $allRet;
        return Status::RET_SUCCESSFUL;
    }    
    
    // 获得所有操作数据库的实例
    private static function findAll( $arObj ) {
        $findRet = call_user_func( array( $arObj , self::$funcFind )  );
        $allRet = call_user_func( array( $findRet , self::$funcAll  ) );
        return $allRet;
    }
    
    // 通过主键的值获取一个操作数据库的实例
    public static function findOneByPrimaryKey( $arObj , $pkVal ) {
        return call_user_func( array( $arObj , self::$funcFindOne ) , $pkVal );
    }

    // 通过条件获取一个目标操作数据库的实例
    public static function findOneByCond( $arObj , $cond ) {
        // $arObj->find()->where( $cond )->one();
        $findRet = call_user_func( array( $arObj , self::$funcFind ) );
        $whereRet = call_user_func( array( $findRet , self::$funcWhere) , $cond );
        $oneRet = call_user_func( array( $whereRet , self::$funcOne ) );
        return $oneRet;
    }
    
    // 获得以pkVal的值为主键的记录的某个属性的值
    public static function getAttributeByPrimaryKey( $arObj , $pkVal , $attr , &$retContainer ) {
        $dest = self::findOneByPrimaryKey( $arObj , $pkVal );
        if( $dest == null ) {
            return Status::RET_DEST_NOT_FOUND;
        }
        $retContainer = call_user_func( array( $dest , self::$funcGetAttribute ) , $attr );
        if( $retContainer === false ) {
            return Status::RET_SERVER_ERROR;
        }
        return Status::RET_SUCCESSFUL;
    }
    
    // 通过操作数据库的实例获取表名
    private static function tableName( $arObj ) {
        return call_user_func( array( $arObj , self::$funcTableName ) );
    }
    
    // 获取所有属性名
    private static function attributes( $arObj ) {
        return call_user_func( array( $arObj , self::$funcAttributes ) ); // $arObj->attributes()
    }

    // 获取不含主键的属性名
    // FIXME:仅支持单主键
    private static function attributesWithoutPK( $arObj ) {
        $tableAttr = self::attributes($arObj); // 获得表的所有字段名
        $pkAttrName = self::getPrimaryKeyName($arObj); // 获得主键字段名
        $ret = array(); // 用于存放待插入表的所有字段名（不含主键字段名)
        foreach ( $tableAttr as $key ) {
            if( $key != $pkAttrName ) {
                $ret[] = $key;    // 将非主键字段名加入
            }
        }
        return $ret;
    }
    
    // 删除数据库操作实例的对应记录
    private static function delete( $arObj ) {
        return call_user_func( array( $arObj , self::$funcDelete ) ); // $arObj->delete()
    }
    
    // 获取所有属性
    public static function getAttributes( $arObj ) {
        return call_user_func( array( $arObj , self::$funcGetAttributes ) );
    }
    
    // 获取不含主键的属性
    // FIXME: 仅支持单主键
    private static function getAttributesWithoutPK( $arObj ) {
        $tableAttr = self::getAttributes($arObj); // 获得表的所有属性
        $pkAttrName = self::getPrimaryKeyName($arObj); // 获得主键字段名
        $ret = array(); // 用于存放待插入表的所有字段（不含主键字段)
        foreach ( $tableAttr as $key => $val ) {
            if( $key != $pkAttrName ) {    
                $ret[ $key ] = $val;// 将非主键字段加入
            }
        }
        return $ret;
    }

    // 获取表中主键的关联数组
    private static function getPrimaryKey( $arObj ) {
        return call_user_func( array( $arObj , self::$funcGetPrimaryKey ) , true ); // $arObj->getPrimaryKey( true )， 获取主键，返回数
    }
    
    // 获取表中主键的名称
    private static function getPrimaryKeyName( $arObj , $pkPos = 0 ) {
        $pkArr = self::getPrimaryKey($arObj);
        $pkNameArr = array_keys( $pkArr ); // 获得所有键名
        // FIXME: 下标验证
        return $pkNameArr[ $pkPos ];
    }
    
    // 插入记录
    private static function insert( $arObj , $attributes ) {

        if( $attributes == null ) {
            return call_user_func( array( $arObj , self::$funcInsert ) ); // 插入空记录
        }
        // 添加非空记录
        if( self::setAttributes($arObj, $attributes , array_keys($attributes) ) && self::save( $arObj ) ) {
            return Status::RET_SUCCESSFUL;
        } else {
            return Status::RET_INSERT_ERROR;
        }
    }
    
    // 获取表中主键的值
    private static function getPrimaryKeyVal( $arObj , $pkPos = 0 ) {
        
        $pkArr = self::getPrimaryKey( $arObj ); // 获得主键关联数组
        $pkName = self::getPrimaryKeyName( $arObj , $pkPos ); // 获得指定位置主键名
        return $pkArr[ $pkName ]; // 获取值
    }
    
    // 保存数据
    private static function save( $arObj ) {
        return call_user_func( array( $arObj , self::$funcSave ) );
    }
    
    // 设置表中字段的值,因为$dataArr中可能存在其它信息，所以只能遍历设置
    private static function setAttributes( $arObj , $dataArr , $attrSet   ) {             
        // 设置各个字段
        foreach( $attrSet as $attr ) {
            $val = $dataArr[ $attr ];
            // 将空串视为null
            if( $val === "" ) {
                $val = null;
            }
            if( call_user_func( array( $arObj , self::$funcSetAttribute ) , $attr  , $val ) === false ) {                
                return false;
            }   
        }
        return true;
    }

}