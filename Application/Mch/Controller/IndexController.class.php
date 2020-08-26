<?php

namespace Mch\Controller;

use Think\Controller;

class IndexController extends AdminController
{
    public function index()
    {
        // 入口，已登录调到首页，未登录跳转到登陆

        if (session('?mch'))

            redirect(U('Admin/welcome'));
        else
            redirect(U('Index/login'));
    }

    // 登录
    public function login()
    {
        if (IS_POST) {
            if (empty($_POST['user']) || empty($_POST['pass'])) {
                $this->assign('errmsg', '账号密码不能为空！');
            } else {
                $mch = M('member')->where(array("username" => $_POST['user']))->find();
                if (!empty($mch)) {
                    if ($mch['status'] != 1) {
                        $this->assign('errmsg', '账号已被禁用');
                    } else {
                        if (xmd5($_POST['pass']) == $mch['password']) {
                            session('mch', $mch);
                            redirect(U('Admin/welcome'));
                            exit;
                        } else {
                            $this->assign('errmsg', '密码不对');
                        }
                    }

                } else {
                    $this->assign('errmsg', '账号不存在！');
                }

            }
        }
        $this->display();
    }

    // 注册
    public function signUp()
    {
        if (IS_POST) {
            if (empty($_POST['user']) || empty($_POST['pass'])) {
                $this->assign('errmsg', '账号密码不能为空！');
            }
        }
        if(M('member')->where(array('mobile'=>$_POST['mobile']))->find()){
            $this->error('代理手机号码已被添加');
            exit;
        }
        $data['salt'] = Salt();
        $_POST['imei'] = xmd5($_POST['salt']);
        $_POST['create_time'] = NOW_TIME;

        $qrcode = $this->qrcode($_POST['imei']);
        $_POST['url'] = $qrcode['url'];
        $_POST['qrcode'] = $qrcode['qrcode'];
        $_POST['password'] = xmd5($_POST['tpassword']);

        print_r(Salt());die;
        M('member')->add($_POST);

        $this->display();
    }

    //  退出
    public function logout()
    {
        session('mch', null);
        redirect(U('login'));
    }

}