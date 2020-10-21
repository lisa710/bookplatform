<?php
namespace Mch\Controller;
use Think\Controller;
class ChargeController extends AdminController {
    // 通知列表
	public function index(){
		$where = $this -> _get_where();
        $member_id = session('mch.id');
        $where['member_id'] = $member_id;

        $model = M('buy_order as bo');
        $count = $model -> where($where) -> count();
        $page = new \Think\Page($count, 25);

        $list = $model->field('bo.*,SUM( bd.money ) total_money')
            ->join('vv_buy_detail bd ON bd.order_id = bo.id','left')
            -> where($where)
            -> limit($page -> firstRow . ',' . $page -> listRows )
            -> group('bo.id')
            -> order('bo.create_time DESC')
            -> select();

        $this -> data = array(
            'list' => $list,
            'page' => $page -> show(),
            'count' => $count
        );

		foreach ($list as $k=>$v){
			$list[$k]['nickname'] = M('user')->where(array('id'=>$v['user_id']))->getField('nickname');
		}
		$this->assign('list',$list);
		$this->assign('page',$this->data['page']);
		$this->display();
	}

	private function _get_where(){
		if(IS_POST){
			$_GET  = array_merge($_GET, $_POST);
			$_GET['p'] = 1; //如果是post的话回到第一页
		}

		if(!empty($_GET['user_id'])){
			$where['user_id'] = intval($_GET['user_id']);
		}

		if(!empty($_GET['time1']) && !empty($_GET['time2'])){
			$where['create_time'] = array(
				array('gt', $_GET['time1'].' 00:00:00'),
				array('lt', $_GET['time2'].' 23:59:59')
			);
		}
		elseif(!empty($_GET['time1'])){
			$where['create_time'] = array('gt', $_GET['time1']);
		}
		elseif(!empty($_GET['time2'])){
			$where['create_time'] = array('lt', $_GET['time2']);
		}

        return $where;
	}

}?>