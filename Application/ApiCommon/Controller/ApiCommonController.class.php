<?php

namespace ApiCommon\Controller;

use Think\Controller;

class ApiCommonController extends Controller
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

    public function getBookList()
    {
        $member_id     = M('follow')->where(['user_id' => 1216])->select();
        $member_id_arr = [];
        $mhcate        = [];

        if (!empty($member_id)) {
            foreach ($member_id as $vm) {
                $member_id_arr[] = $vm['member_id'];
            }
            $where['member_id'] = array('in', $member_id_arr);

            if (!empty($_REQUEST['title'])) {
                $where['title'] = array('like', '%' . trim($_REQUEST['title']) . '%');
            }
            
            foreach ($this->_w_opus as $k => $v) {
                if ($v['show'] == 2 && $v['isshow']) {
                    $mh_list            = M('mh_list')->where($where)->order('sort desc')->select();
                    $book_list          = M('book')->where($where)->order('sort desc')->select();
                    $mhcate[$k]['name'] = $v['name'];
                    $mhcate[$k]['sort'] = $v['sort'];
                    $mhcate[$k]['list'] = array_merge($mh_list, $book_list);
                }
            }
        }

        $this->response(200, '', $mhcate);

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