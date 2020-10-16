<?php

namespace ApiCommon\Controller;

class ApiCommonController extends BaseController
{

    public function getBookList()
    {
        $member_id = isset($_REQUEST['member_id']) ? $_REQUEST['member_id'] : '';

        if (empty($member_id)) {
            $this->response(200, '', []);
        }

        $mhcate = [];

        $where['member_id'] = array('eq', $member_id);

        if (!empty($_REQUEST['title'])) {
            $where['title'] = array('like', '%' . trim($_REQUEST['title']) . '%');
        }

        foreach ($this->_w_opus as $k => $v) {
            if ($v['show'] == 2 && $v['isshow']) {
                $mh_list            = M('mh_list')->field('*,2 as flag')->where($where)->order('sort desc')->select();
                $book_list          = M('book')->field('*,1 as flag')->where($where)->order('sort desc')->select();
                $mhcate[$k]['name'] = $v['name'];
                $mhcate[$k]['sort'] = $v['sort'];
                $mhcate[$k]['list'] = array_merge($mh_list, $book_list);
            }
        }

        $this->response(200, '', $mhcate);

    }

}

?>