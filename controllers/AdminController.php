<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Status;
use app\models\DataLoader;
use app\models\DataValidater;

class AdminController extends Controller
{
    
    public $enableCsrfValidation = false;
    private $rawData = null;
    

    public function init(){
        $this->enableCsrfValidation = false;
    }
    
    // 工具方法：准备初始数据
    private function initData() {
        // 载入输入
        $this->rawData = DataLoader::post();
    
        if( !is_array( $this->rawData) ) {
            Status::RET_INVALID_INPUT_PARAM_FORMAT;
        }
        return Status::RET_SUCCESSFUL;
    }
    
    // 工具方法：请求处理
    // $spData不为null说明未使用通用接口格式传入数据
    private function requestIterator( $actionName  , $actionDest , $mustCheckMetaList , $spData = null ) {
        $retSet = array(); // 返回数据
        $retStatus = Status::RET_SUCCESSFUL;    // 返回状态
        $retCnt = 0; // 返回数目
        if( $spData != null ) { // 未使用通用接口格式
            $this->rawData = $spData;
            $initStatus = Status::RET_SUCCESSFUL;
        } else {
            $initStatus = $this->initData(); // 使用通用接口格式，初始化
        }
    
        if(  $initStatus == Status::RET_SUCCESSFUL ) { // 初始化成功
            $raw = $this->rawData;
            foreach ( $raw as $singleRequest ) {
                $singleStatus = Status::RET_SUCCESSFUL;
                // 验证每项请求必要字段的完整性
                if( DataValidater::isAllSet( array( "meta_data" , "src_data" ) , $singleRequest ) && // 检查是否设置meta_data
                    DataValidater::isAllSet( $mustCheckMetaList , $singleRequest[ "meta_data" ]  ) // 检查meta_data中是否包含必要字段
                ) {
                    $metaData = $singleRequest[ "meta_data" ];
                    $srcData = $singleRequest[ "src_data" ];
                    $mgr = null;
                    switch ( $actionDest ) { // 选择操作的对象
                        case "user":
                            
                            break;

                        default:
                            // 操作对象不符合的返回状态
                            $singleStatus = Status::RET_ACTION_DEST_NOT_DEFINED;
                            break;
                    }
                    // 操作对象不存在
                    if( $singleStatus != Status::RET_SUCCESSFUL ) {
    
                        $retStatus = Status::RET_SUCCESSFUL_WITH_WARNING;
                        // 构造单条返回
                        $retSet[] = $this->generateSingleReturn( $metaData , null , $singleStatus , $retCnt );
                        continue;
                    }
                    // mgr未实例化
                    if( $mgr == null ) {
                        $retStatus = Status::RET_SERVER_ERROR;
                        // 构造单条返回
                        $retSet[] = $this->generateSingleReturn( $metaData , null , $singleStatus , $retCnt );
                        continue;
                    }
                    $retContainer = array(); // 返回数据容器，目前是一个array
                    switch ( $actionName ) { // 选择操作
                        case "add":          // 添加
                            $singleStatus = $this->doAdd( $mgr, $metaData , $srcData , $retContainer );
                            break;
                       
                        default:            // 不存在的操作
                            $singleStatus = Status::RET_ACTION_NOT_DEFINED;
                            break;
                    }
                    // 单条返回数据
                    // 单条不成功，总状态为警告
                    if( $singleStatus  != Status::RET_SUCCESSFUL ) {
                        $retStatus = Status::RET_SUCCESSFUL_WITH_WARNING;
                    }
                    // 构造单条返回
                    $retSet[] = $this->generateSingleReturn( $metaData , $retContainer , $singleStatus, $retCnt );
    
                } else {
                    // 数据不完整的返回状态
                    $retStatus = Status::RET_SUCCESSFUL_WITH_WARNING;
                    $retSet[] = $this->generateSingleReturn( array() , null , Status::RET_INVALID_INPUT_PARAM_FORMAT , $retCnt );
                }
            }
        } else { // 初始化失败
            $retStatus = $initStatus;
        }
    
        return json_encode( array(
            "status" => $retStatus,
            "count" => $retCnt,
            "ret_set" => $retSet,
        ) );
    }
    
    // 工具方法：构造单条返回数据
    private function generateSingleReturn( $metaData , $retData , $status , &$genTime ) {
        $genTime++;
        $lineCnt = count( $retData );
        $metaData[ "single_status" ] = $status; // 在meta_data中加入状态
        $metaData[ "line_count" ] = $lineCnt;
        return array(
            "meta_data" => $metaData,
            "ret_data" => $retData,
        );
    }
    
    // 工具方法：执行添加
    private function doAdd( $mgr , $metaData , $srcData , &$retDataContainer ) {
        return $mgr->adminInsert( $srcData , $retDataContainer );
    }
    
    // 工具方法：执行列表
    private function doList( $mgr , $metaData , $srcData , &$retDataContainer ) {
        return $mgr->adminList( $srcData , $retDataContainer  );
    }
    
    // 工具方法： 执行删除
    private function doDelete( $mgr , $metaData , $srcData , &$retDataContainer ) {
        // 这里未用到retDataContainer
        if( isset( $metaData[ "logic_pkval" ] ) ) {
            return $mgr->adminDelete( $metaData[ "logic_pkval" ] );
        } else {
            return Status::RET_INVALID_INPUT_PARAM_FORMAT;
        }
    }
    
    // 工具方法：执行编辑
    private function doModify( $mgr , $metaData , $srcData , $retContainer ) {
        // 这里未用到retDataContainer
        if( isset( $metaData[ "logic_pkval" ] ) ) {
            $logicPKVal = $metaData[ "logic_pkval" ];
            return $mgr->adminUpdate( $logicPKVal , $srcData );
        } else {
            return Status::RET_INVALID_INPUT_PARAM_FORMAT;
        }
    }
    
    // 工具方法：执行查看
    private function doBrowse( $mgr , $metaData , $srcData , &$retContainer ) {
        if( isset( $metaData[ "logic_pkval" ] ) ) {
            $logicPKVal = $metaData[ "logic_pkval" ];
            return $mgr->adminBrowse( $logicPKVal , $retContainer );
        } else {
            return Status::RET_INVALID_INPUT_PARAM_FORMAT;
        }
    }
    
    
    // 可定义统一入口的操作列表：BEGIN
    
    // 以下操作均可由所传输的数据内容来选择操作
    // 可在合适的时候进行数据解析、选择操作，避免因添加一个操作而额外添加一个函数
    // 例如将所有的添加操作合并为一个操作actionAdd()
    
    // 操作：添加用户
    public function actionUserAdd() {
        return $this->requestIterator( "add", "user" , [] );
    }
    
    // 操作：删除用户
    public function actionUserDelete() {
        return $this->requestIterator( "delete", "user" , [] );
    }
    
    // 操作：查看用户
    public function actionUserBrowse() {
        return $this->requestIterator( "browse", "user", [] );
    }
    
    // 操作：编辑用户
    public function actionUserModify() {
        return $this->requestIterator( "modify", "user" , [] );
    }
    
    // 操作：用户列表
    public function actionUserList() {
        return $this->requestIterator( "list", "user" , [] );
    }

    //可定义统一入口的操作列表:END
    
    

}
