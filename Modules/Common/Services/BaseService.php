<?php

/**
 * @Name  服务基类
 * @Description
 * @Auther 孙向成
 */

namespace Modules\Common\Services;


use Modules\Common\Exceptions\ApiException;
use Modules\Common\Exceptions\CodeData;
use Modules\Common\Exceptions\MessageData;
use Modules\Common\Exceptions\StatusData;

class BaseService
{
    public function __construct()
    {
    }

    /**
     * @name 查询条件
     * @description
     * @author 孙向成
     * @method  GET
     * @param model Model 模型
     * @param params Array 查询参数
     * @param key String 模糊查询参数
     * @return Object
     **/
    function queryCondition(object $model, array $params, string $key = "username"): Object
    {
        if (!empty($params['created_at'])) {
            $model = $model->whereBetween('created_at', $params['created_at']);
        }
        if (!empty($params['updated_at'])) {
            $model = $model->whereBetween('updated_at', $params['updated_at']);
        }
        if (!empty($params[$key])) {
            $model = $model->where($key, 'like', '%' . $params[$key] . '%');
        }
        if (isset($params['status']) && $params['status'] != '') {
            $model = $model->where('status', $params['status']);
        }
        return $model;
    }
    /**
     * @name  成功返回
     * @description  用于所有的接口返回
     * @author 孙向成
     * @param status Int 自定义状态码
     * @param message String 提示信息
     * @param data Array 返回信息
     * @return JSON
     **/
    public function apiSuccess(string $message = '', array $data = array(), int $status = StatusData::Ok)
    {
        if ($message == '') {
            $message = MessageData::Ok;
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], CodeData::OK);
    }

    /**
     * @name 失败返回
     * @description 用于所有的接口返回
     * @author 孙向成
     * @param status Int 自定义状态码
     * @param message String 提示信息
     * @return JSON
     **/
    public function apiError(string $message = MessageData::API_ERROR_EXCEPTION, int $status = StatusData::BAD_REQUEST)
    {
        throw new ApiException([
            'status' => $status,
            'message' => $message
        ]);
    }
    /**
     * @name 添加公共方法
     * @description
     * @author 孙向成
     * @param model Model  当前模型
     * @param data array 添加数据
     * @param successMessage string 成功返回数据
     * @param errorMessage string 失败返回数据
     * @return JSON
     **/
    public function commonCreate($model, array $data = [], string $successMessage = MessageData::ADD_API_SUCCESS, string $errorMessage = MessageData::ADD_API_ERROR)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($model->insert($data)) {
            return $this->apiSuccess($successMessage);
        }
        $this->apiError($errorMessage);
    }
    /**
     * @name 编辑公共方法
     * @description
     * @author 孙向成
     * @param model Model  当前模型
     * @param id   Int  修改id
     * @param data array 添加数据
     * @param successMessage string 成功返回数据
     * @param errorMessage string 失败返回数据
     * @return JSON
     **/
    public function commonUpdate($model, $id, array $data = [], string $successMessage = MessageData::UPDATE_API_SUCCESS, string $errorMessage = MessageData::UPDATE_API_ERROR)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        if ($model->where('id', $id)->update($data)) {
            return $this->apiSuccess($successMessage);
        }
        $this->apiError($errorMessage);
    }
    /**
     * @name 调整公共方法
     * @description
     * @author 孙向成
     * @param model Model  当前模型
     * @param id   Int  修改id
     * @param data array 添加数据
     * @param successMessage string 成功返回数据
     * @param errorMessage string 失败返回数据
     * @return JSON
     **/
    public function commonStatusUpdate($model, $id, array $data = [], string $successMessage = MessageData::STATUS_API_SUCCESS, string $errorMessage = MessageData::STATUS_API_ERROR)
    {
        if ($model->where('id', $id)->update($data)) {
            return $this->apiSuccess($successMessage);
        }
        $this->apiError($errorMessage);
    }
    /**
     * @name 排序公共方法
     * @description
     * @author 孙向成
     * @param model Model  当前模型
     * @param id   Int  修改id
     * @param data array 添加数据
     * @param successMessage string 成功返回数据
     * @param errorMessage string 失败返回数据
     * @return JSON
     **/
    public function commonSortsUpdate($model, $id, array $data = [], string $successMessage = MessageData::STATUS_API_SUCCESS, string $errorMessage = MessageData::STATUS_API_ERROR)
    {
        if ($model->where('id', $id)->update($data) !== false) {
            return $this->apiSuccess($successMessage);
        }
        $this->apiError($errorMessage);
    }
    /**
     * @name 真删除公共方法
     * @description
     * @author 孙向成
     * @param model Model  当前模型
     * @param ArrId Array  删除id
     * @param successMessage string 成功返回数据
     * @param errorMessage string 失败返回数据
     * @return JSON
     **/
    public function commonDestroy($model, array $ArrId, string $successMessage = MessageData::DELETE_API_SUCCESS, string $errorMessage = MessageData::DELETE_API_ERROR)
    {
        if ($model->whereIn('id', $ArrId)->delete()) {
            return $this->apiSuccess($successMessage);
        }
        $this->apiError($errorMessage);
    }
    /**
     * @name 假删除公共方法
     * @description
     * @author 孙向成
     * @param model Model  当前模型
     * @param idArr Array  删除id
     * @param successMessage string 成功返回数据
     * @param errorMessage string 失败返回数据
     * @return JSON
     **/
    public function commonIsDelete($model, array $idArr, string $successMessage = MessageData::DELETE_API_SUCCESS, string $errorMessage = MessageData::DELETE_API_ERROR)
    {
        if ($model->whereIn('id', $idArr)->update(['is_delete' => 1, 'deleted_at' => date('Y-m-d H:i:s')])) {
            return $this->apiSuccess($successMessage);
        }
        $this->apiError($errorMessage);
    }
    /**
     * @name 假删除恢复公共方法
     * @description
     * @author 孙向成
     * @param model Model  当前模型
     * @param idArr Array  删除id
     * @param successMessage string 成功返回数据
     * @param errorMessage string 失败返回数据
     * @return JSON
     **/
    public function commonRecycleIsDelete($model, array $idArr, string $successMessage = MessageData::DELETE_RECYCLE_API_SUCCESS, string $errorMessage = MessageData::DELETE_RECYCLE_API_ERROR)
    {
        if ($model->whereIn('id', $idArr)->update(['is_delete' => 0])) {
            return $this->apiSuccess($successMessage);
        }
        $this->apiError($errorMessage);
    }
    /**
     * @name 获取当前域名
     * @description
     * @author 孙向成
     * @return String
     **/
    public function getHttp(): String
    {
        $http = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
        return $http . $_SERVER['HTTP_HOST'];
    }
    /**
     * @name 将编辑器的content的图片转换为相对路径
     * @description
     * @author 孙向成
     * @param content String 内容
     * @return string
     **/
    public function getRemvePicUrl(string $content = ''): String
    {
        $con = $this->getHttp();
        if ($content) {
            //提取图片路径的src的正则表达式 并把结果存入$matches中
            preg_match_all("/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/", $content, $matches);
            $img = "";
            if (!empty($matches)) {
                //注意，上面的正则表达式说明src的值是放在数组的第三个中
                $img = $matches[1];
            } else {
                $img = "";
            }
            if (!empty($img)) {
                $patterns = array();
                $replacements = array();
                //$default = config('filesystems.disks.qiniu.domains.default');
                foreach ($img as $imgItem) {
                    //if (strpos($imgItem, $default) !== false) {
                    //    $final_imgUrl = $imgItem;
                    // } else {
                    $final_imgUrl = str_replace($con, "", $imgItem);
                    //}
                    $replacements[] = $final_imgUrl;
                    $img_new = "/" . preg_replace("/\//i", "\/", $imgItem) . "/";
                    $patterns[] = $img_new;
                }
                //让数组按照key来排序
                ksort($patterns);
                ksort($replacements);
                //替换内容
                $content = preg_replace($patterns, $replacements, $content);
            }
        }
        return $content;
    }
    /**
     * @name 将编辑器的content的图片转换为绝对路径
     * @description
     * @author 孙向成
     * @param  content string 内容
     * @return String
     **/
    public function getReplacePicUrl(string $content = ''): String
    {
        $con = $this->getHttp();
        if ($content) {
            //提取图片路径的src的正则表达式 并把结果存入$matches中
            preg_match_all("/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/", $content, $matches);
            $img = "";
            if (!empty($matches)) {
                //注意，上面的正则表达式说明src的值是放在数组的第三个中
                $img = $matches[1];
            } else {
                $img = "";
            }
            if (!empty($img)) {
                $patterns = array();
                $replacements = array();
                //$default = config('filesystems.disks.qiniu.domains.default');
                foreach ($img as $imgItem) {
                    //if (strpos($imgItem, $default) !== false) {
                    //    $final_imgUrl = $imgItem;
                    //} else {
                    $final_imgUrl = $con . $imgItem;
                    //}
                    $replacements[] = $final_imgUrl;
                    $img_new = "/" . preg_replace("/\//i", "\/", $imgItem) . "/";
                    $patterns[] = $img_new;
                }
                //让数组按照key来排序
                ksort($patterns);
                ksort($replacements);
                //替换内容
                $content = preg_replace($patterns, $replacements, $content);
            }
        }
        return $content;
    }
    /**
     * @name 生成随机字符串
     * @description
     * @author 孙向成
     * @param length Int 生成字符串长度
     * @return String
     **/
    public function GetRandStr(int $length = 11): String
    {
        //字符组合
        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $len = strlen($str) - 1;
        $randstr = '';
        for ($i = 0; $i < $length; $i++) {
            $num = mt_rand(0, $len);
            $randstr .= $str[$num];
        }
        return $randstr;
    }
    /**
     * @name  处理二维数组转为json字符串乱码问题
     * @description
     * @author 孙向成
     * @param data Array  需要转为json字符串的数组
     * @return String
     **/
    public function setJsonEncodes($data): String
    {
        $count = count($data);
        for ($k = 0; $k < $count; $k++) {
            foreach ($data[$k] as $key => $value) {
                $data[$k][$key] = urlencode($value);
            }
        }
        return urldecode(json_encode($data));
    }

    /**
     * @name 传入时间戳,计算距离现在的时间
     * @description
     * @author 孙向成
     * @param theTime Int 时间戳
     * @return String
     **/
    public function format_time(int $theTime = 0): String
    {
        $nowTime = time();
        $dur = $nowTime - $theTime;
        if ($dur < 0) {
            return $theTime;
        } else {
            if ($dur < 60) {
                return $dur . '秒前';
            } else {
                if ($dur < 3600) {
                    return floor($dur / 60) . '分钟前';
                } else {
                    if ($dur < 86400) {
                        return floor($dur / 3600) . '小时前';
                    } else { //昨天
                        //获取今天凌晨的时间戳
                        $day = strtotime(date('Y-m-d', time()));
                        //获取昨天凌晨的时间戳
                        $pday = strtotime(date('Y-m-d', strtotime('-1 day')));
                        if ($theTime > $pday && $theTime < $day) { //是否昨天
                            return $t = '昨天 ' . date('H:i', $theTime);
                        } else {
                            if ($dur < 172800) {
                                return floor($dur / 86400) . '天前';
                            } else {
                                return date('Y-m-d H:i', $theTime);
                            }
                        }
                    }
                }
            }
        }
    }
    /**
     * @name 处理递归数据
     * @description
     * @author 孙向成
     * @param array Array  总数据
     * @param pid Int  父级id
     * @return Array
     **/
    public function tree(array $array, int $pid = 0): array
    {
        $tree = array();
        foreach ($array as $key => $value) {
            if ($value['pid'] == $pid) {
                $value['children'] = $this->tree($array, $value['id']);
                if (!$value['children']) {
                    unset($value['children']);
                }
                $tree[] = $value;
            }
        }
        return $tree;
    }
    /**
     * @name 获取用户真实 ip
     * @description
     * @author 孙向成
     * @return array|false|mixed|string
     **/
    public function getClientIp()
    {
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        }
        if (getenv('HTTP_X_REAL_IP')) {
            $ip = getenv('HTTP_X_REAL_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
            $ips = explode(',', $ip);
            $ip = $ips[0];
        } elseif (getenv('REMOTE_ADDR')) {
            $ip = getenv('REMOTE_ADDR');
        } else {
            $ip = '0.0.0.0';
        }
        if (!$ip) {
            return '';
        }
        return $ip;
    }
    /**
     * @name PHP格式化字节大小
     * @description
     * @author 孙向成
     * @param size Int  字节数
     * @param delimiter string  数字和单位分隔符
     * @return String 格式化后的带单位的大小
     **/
    public function formatBytes(int $size, string $delimiter = ''): String
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
        for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
        return round($size, 2) . $delimiter . $units[$i];
    }
}
