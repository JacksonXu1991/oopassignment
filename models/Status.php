<?php

namespace app\models;

class Status {
    
    // 服务器返回值状态列表
    // 不要删除此数字：当前服务器可用数字从13开始,可用数字于1023(含)结束
    // 格式： RET_<自定义名称> = ?
    // 例： RET_ACTION_NOT_DEFINED = 8 未定义操作
    
    const RET_ACTION_NOT_DEFINED = 8; // 未定义操作
    const RET_ACTION_DEST_NOT_DEFINED = 9; // 未定义操作对象
    
    const RET_CONFLICTIVE_DATA = 6; // 冲突数据

    const RET_DELETE_ERROR = 6; // 数据删除错误
    const RET_DEST_NOT_FOUND = 4;   // 目标未找到
    const RET_DUPLICATED_OBJ = 12; // 重复的对象

    const RET_INSERT_ERROR = 5;  // 数据插入错误    
    const RET_INVALID_INPUT_PARAM_FORMAT = 2; // 传入参数格式错误
    const RET_INVALID_INPUT_PARAM_DATA = 3; // 传入参数数据错误
    const RET_INVALID_ACTION = 11; // 不支持的操作类型    
   
    const RET_SUCCESSFUL = 0;   // 成功
    const RET_SUCCESSFUL_WITH_WARNING = 1; // 警告，注意返回数据中单条的状态信息    
    const RET_SERVER_ERROR = 7; // 服务器未知错误

    const RET_UPDATE_ERROR = 10; // 数据更新错误
    
    // app自定义状态列表
    // 不要删除此数字：当前APP可用数字从1024开始,可用数字于2047(含)结束
    // 格式： APP_<自定义名称> = ?
    // 例： APP_CUSTOM_STATUS = 1024 自定义状态
    

}