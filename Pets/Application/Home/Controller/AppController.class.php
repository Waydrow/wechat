<?php
namespace Home\Controller;
use Think\Controller;

class AppController extends Controller {
    public function test() {
        $id = I('id');
        $user = M('user');
        $data = $user->where('id=%d', $id)->select();
        $this->ajaxReturn($data, 'json');
    }
}