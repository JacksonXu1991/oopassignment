<?php

namespace app\models;

use app\models\interfaces\CRUDBasic;
use app\models\Users;


class UserManager extends Manager implements CRUDBasic {
    
    // 后台管理：查看用户
    public function adminBrowse( $logicPKVal , &$retDataContainer )
    {
        if( $logicPKVal != null ) {
            return $this->crudRetrieveOneByLogicalPrimaryKey( $logicPKVal , $retDataContainer );
        } else {
            return Status::RET_INVALID_INPUT_PARAM_FORMAT;
        }
    }
    
    // 后台管理：删除用户
    public function adminDelete($logicPKVal)
    {
        if( $logicPKVal != null ) {
            return $this->crudDeleteOneByLogicalPrimaryKey($logicPKVal);
        } else {
            return Status::RET_INVALID_INPUT_PARAM_FORMAT;
        }
    }
    
    // 后台管理：添加用户
    public function adminInsert($srcData, &$logicPKValContainer)
    {

        if( !DataValidater::isAllExist( array( "user_name" , "password" ,"status_id"), $srcData) ) {
            return Status::RET_INVALID_INPUT_PARAM_FORMAT;
        }
        $uuid = null;
        $addRet = $this->crudAddOne( $srcData , $uuid );
        if( $addRet != Status::RET_SUCCESSFUL ) {
            $logicPKValContainer = null;
        }
        $logicPKValContainer = array(
            "usr_uuid" => $uuid,
        );
        return $addRet;
    }
    
    // 后台管理：用户列表
    public function adminList( $listCond , &$retDataContainer)
    {
        // 列表的必须字段
        if( !DataValidater::isAllExist( array( "start" , "length" ),  $listCond ) ) {
            return Status::RET_INVALID_INPUT_PARAM_FORMAT;
        }
    
        // 获得数据
        $start =  $listCond[ "start" ];
        $length =  $listCond[ "length" ];
    
        // 非空可选项
        $order = DataLoader::exportColumn( "order" ,  $listCond );
        $orderCol = $orderDir = null;
        if( $order != null ) {
            $orderCol = DataLoader::exportColumn( "column" , $order[ 0 ] );
            $orderDir = DataLoader::exportColumn( "dir" , $order[0] );
        }
    
        $search = DataLoader::exportColumn( "search" ,  $listCond );
        if( $search != null ) {
            $search = DataLoader::exportColumn( "value" , $search );
        }
    
        /*$where = array();
    
        $orgType = DataLoader::exportColumn( "org_type",  $listCond );
        if( $orgType != null ) {
        $where[ "org_type" ] = $orgType;
        }
    
        $orgDistrId = DataLoader::exportColumn( "org_distr_uuid",  $listCond );
        if( $orgDistrId != null ) {
        $where[ "org_distr_uuid" ] = $orgDistrId;
        }*/
    
        return Table::pull( new Users() , $start, $length, $retDataContainer , $search , $orderCol , $orderDir );
    }
    
    // 后台管理：编辑用户
    public function adminUpdate($logicPKVal, $srcData )
    {
        return $this->crudUpdateOneByLogicalPrimaryKey($logicPKVal , $srcData );
    }    
	
    // 添加一个新的用户
    public function crudAddOne( $srcData , &$uuidContainer) {
        // $uuid = DataLoader::uuid();
        // $srcData[ "usr_uuid" ] = $uuid;
        $idContainer = null; // 物理主键的id,暂时没用
        $addRet = Table::addOne( new Users() , $srcData , $idContainer );
        if( $addRet != Status::RET_SUCCESSFUL ) {
            $uuidContainer = null;
        } else {
            // $uuidContainer = $uuid;
            $uuidContainer = null;
        }
        return $addRet;
    }
    
    // 通过条件删除一条记录
    public function crudDeleteOneByCond($cond) {
        // return Table::setOneAllAttrNullByCond( new User() , $cond , array( "usr_uuid" ) );
        return Table::deleteFromTableByCond( new Users() , $cond );
    }
    
    // 根据逻辑主键删除一条记录
    public function crudDeleteOneByLogicalPrimaryKey($pkVal) {
        // 当前删除行为是将所有字段置为NULL
        return Table::deleteFromTableByPrimaryKey( new Users(), $pkVal );
    }

    // 根据条件更新一条记录
    public function crudUpdateOneByCond( $cond , $data ) {
        return Table::updateOneByCond( new Users() , $cond , $data );
    }
    
    // 根据逻辑主键更新一条记录
    public function crudUpdateOneByLogicalPrimaryKey( $pkVal , $data ) {
        return Table::updateOneByCond( new Users() , array( "uid" => $pkVal ) , $data);
    }
    
    // 根据逻辑主键主键读取一条记录
    public function crudRetrieveOneByLogicalPrimaryKey( $pkVal , &$retContainer ) {
        return Table::retrieveOneByPrimaryKey( new Users() , array( "uid" => $pkVal )  , $retContainer );
    }
    
    // 根据条件读取一条记录
    public function crudRetrieveOneByCond( $cond , &$retContainer ){
        return Table::retrieveOneByCond( new Users() , $cond  , $retContainer );
    }  

    // 根据条件获得记录
    public function crudRetrieveByCond($cond, &$retContainer) {

    }

}