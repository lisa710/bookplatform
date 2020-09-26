<?php

namespace ApiCommon\Controller;

use Think\Controller;

class BaseController extends Controller
{

    public function _initialize()
    {
        header('Content-Type: text/html; charset=utf-8');

        $config = M('config')->select();

        if (!is_array($config)) {
            die('请先在后台设置好各参数');
        }

        foreach ($config as $v) {
            $key              = '_' . $v['name'];
            $this->{$key}     = unserialize($v['value']);
            $_CFG[$v['name']] = $this->{$key};
        }
    }



    /**
     * 统一返回
     *
     * @param integer $code
     * @param string $message
     * @param array $data
     * @return void
     */
    public function response($code = 200, $message = '执行成功', $data = [])
    {
        header("Content-Type:application/json");
        echo json_encode(['code' => $code, 'message' => $message, 'data' => $data]);
        die;
    }
}

?>