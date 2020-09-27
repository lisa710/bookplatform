<?php

namespace ApiCommon\Controller;

class LoginController extends BaseController
{

    public function checkSign()
    {
        $open_id   = isset($_POST['open_id']) ? $_POST['open_id'] : '';
        $member_id = isset($_POST['member_id']) ? $_POST['member_id'] : '';

        if (empty($open_id))
            $this->response(401, 'open_id不能为空');

        if (empty($member_id))
            $this->response(401, '作者id不能为空');

        $is_sign = M('user')->field('id')->where(['wx_open_id' => $open_id])->find();

        if (empty($is_sign)) {//自动注册
            $user_info = [
                'wx_open_id'  => $open_id,
                'create_time' => time(),
                'sub_time'    => time(),
                'sex'         => 0,
                'headimg'     => '/Public/home/mhimages/100.jpeg',
            ];

            $uid      = M('user')->add($user_info);
            $nickname = "u" . $uid . rand(100, 999);
            $userpwd  = "p" . rand(10000, 99999);
            M('user')->where(['id' => $uid])->save(['nickname' => $nickname, 'userpwd' => $userpwd, 'username' => $nickname]);
            M('follow')->add(['user_id' => $uid, 'member_id' => $member_id, 'create_time' => time()]);
        } else {
            $is_follow = M('follow')->where(['user_id' => $is_sign['id'], 'member_id' => $member_id])->find();
            if (empty($is_follow)) {//关注作者
                M('follow')->add(['user_id' => $is_sign['id'], 'member_id' => $member_id, 'create_time' => time()]);
            }
        }
        $this->response(200, '成功', ['user_id' => $is_sign['id']]);
    }

}

?>