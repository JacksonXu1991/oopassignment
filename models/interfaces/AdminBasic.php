<?php

namespace app\models\interfaces;

interface AdminBasic {
    // 后台管理：删除行为
    public function adminDelete( $logicPKVal );
    
    // 后台管理:添加行为
    public function adminInsert( $srcData , &$logicPKValContainer );
    
    // 后台管理：更新行为
    public function adminUpdate( $logicPKVal , $srcData  );

    // 后台管理:列表行为
    public function adminList( $listCond , &$retDataContainer );
    
    // 后台管理：查看行为
    public function adminBrowse( $logicPKVal , &$retDataContainer );
}