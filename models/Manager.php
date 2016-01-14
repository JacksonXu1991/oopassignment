<?php

namespace app\models;

use app\models\interfaces\CRUDBasic;

class Manager implements CRUDBasic {
	
    // 添加一条记录，返回其逻辑主键的值
    public function crudAddOne( $srcData , &$uuidContainer ) {
        
    }
    
    // 根据逻辑主键更新一条记录
    public function crudUpdateOneByLogicalPrimaryKey( $pkVal , $data ) {
        
    }
    // 根据条件更新一条记录
    public function crudUpdateOneByCond( $cond , $data ) {
        
    }
    
    // 通过逻辑主键删除一条记录
    public function crudDeleteOneByLogicalPrimaryKey( $pkVal ) {
        
    }
    // 通过条件删除一条记录
    public function crudDeleteOneByCond( $cond ) {
        
    }
    
    // 根据逻辑主键读取一条记录
    public function crudRetrieveOneByLogicalPrimaryKey( $pkVal , &$retContainer ) {
        
    }
    // 根据条件读取一条记录
    public function crudRetrieveOneByCond( $cond , &$retContainer ) {
        
    }
    
    // 根据条件读取多条记录
    public function crudRetrieveByCond( $cond , &$retContainer ) {
        
    }

}