<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }

    public function appLogin() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password = md5($password);

        $user = M("user");
        $data = $user->where("username='%s' AND password='%s'", $username, $password)->find();
        if($data) {
            echo $data['id'];
        } else {
            echo "0";
        }
    }

    // app用户注册
    public function appRegister(){
        $username = I('username');
        $password = I('password');
        $password = md5($password);
        $realname = I('realname');
        $sex = I('sex');
        if($sex == "男") {
            $sex = 'm';
        } else {
            $sex = 'f';
        }
        $idcard = I('idcard');
        $phone = I('phone');
        $address = I('address');

        $user = M('user');
        $result = $user->where("username='%s'", $username)->find();
        if($result) {
            echo "0";
            return; // 已存在该用户
        } else {
            $user->username = $username;
            $user->password = $password;
            $user->realname = $realname;
            $user->sex = $sex;
            $user->idcard = $idcard;
            $user->phone = $phone;
            $user->address = $address;
            //$user->badrecord="";

            $result = $user->add();
            // 返回用户id
            echo $result;
        }
    }

    /*
     * app查看用户信息接口: appUserInfo
     * 请求格式: 用户id => user_id
     * 返回格式: [{"id":"3","username":"test3","sex":"m"}]
     * */
    public function appUserInfo() {
        $userid = I('user_id');
        $user = M('user');
        $data = $user->where('id=%d', $userid)->find();
        $this->ajaxReturn($data, 'json');
    }

    // 通过 username 查找用户
    public function findUserByUserName() {
        $username = I('username');
        $user = M('user');
        $data = $user->where("username='%s'",$username)->find();
        $this->ajaxReturn($data, 'json');
    }

    /*
     * app用户修改密码接口: appChangePassword
     * 请求格式: 用户名 => username
     *          原密码 => old_password
     *          新密码 => new_password
     * 返回格式: -1 => 原密码错误
     *          0 => 修改失败, 请稍后重试
     *          1 => 修改成功
     * */
    public function appChangePassword() {
        $username = I('username');
        $old_password = md5(I('old_password'));
        $new_password = md5(I('new_password'));

        $user = M('user')
            ->where("username='%s' AND password='%s'", $username, $old_password)
            ->find();
        if(!$user) {
            // 原密码错误
            echo "-1";
            return;
        }
        $new_user = M('user')->where("username='%s'", $username)
            ->setField('password', $new_password);
        if($new_user === false) {
            // 修改失败, 请稍后重试
            echo "0";
        } else {
            // 修改成功
            echo "1";
        }
    }


    /*
     * app用户信息修改接口: appChangeUserInfo
     * 请求格式: 用户名   => username
     *          真实姓名 => realname
     *          性别    => sex
     *          身份证号 => idcard
     *          电话号码 => phone
     *          地址    => address
     * 返回格式: 0 => 修改失败
     *          1 => 修改成功
     * */
    public function appChangeUserInfo() {
        $username = I('username');
        $realname = I('realname');
        $sex = I('sex');
        $idcard = I('idcard');
        $phone = I('phone');
        $address = I('address');

        $new_user = M('user');
        $new_user->realname = $realname;
        $new_user->sex = $sex;
        $new_user->idcard = $idcard;
        $new_user->phone = $phone;
        $new_user->address = $address;

        $result = $new_user->where("username='%s'", $username)
            ->save();
        if($result === false) {
            // 修改失败
            echo "0";
        } else {
            // 修改成功
            echo "1";
        }
    }

    /*
     * 返回App宠物信息接口, 提供偏好查询
     * 请求格式: 种类 => breed
     *          性别 => sex
     *          性格 => character
     *          标志位 => query
     * */
    public function appGetPets(){
        $breed = I('breed');
        $sex = I('sex');
        $ch = I('character');
        $query = I('query');
        if($breed == '' && $sex == '' && $ch == '') {
            $pet = M('pet');
            // find 方法只会返回第一条记录
            $data = $pet->where('istaken=0')->select();
            $this->ajaxReturn($data,'json');
        } else {
            $pet = M('pet');
            $map['breed'] = array('like', '%'.$breed.'%');
            if($sex != '') {
                $map['sex'] = array('eq', $sex);
            }
            $map['character'] = array('like', '%'.$ch.'%');
            if($query == '0') {
                $map['_logic'] = 'OR';
                $where['_complex'] = $map;
                $where['istaken'] = array('eq', 0);
                $data = $pet->where($where)->select();
            } else { // $query == '1'
                $map['_logic'] = 'AND';
                $map['istaken'] = array('eq', 0);
                $data = $pet->where($map)->select();
            }
            $this->ajaxReturn($data, 'json');
        }
    }

    // deal with the application of getting a pet home
    // 处理用户申请领养宠物
    public function appDealApplication(){
        $userid = I('user_id');
        $petid = I('pet_id');
        $apply = M('application');

        $repeat = $apply->where('userid=%d AND petid=%d AND ispass<>-1', $userid, $petid)->select();
        if($repeat) {
            // 已申请待审核或者已经领养了该宠物
            echo "-1";
            return;
        }

        $repeat = $apply->where('userid=%d AND ispass=1', $userid, $petid)->select();
        if(count($repeat) >= 3) {
            // 同一用户不能同时领养超过3只宠物
            echo "-2";
            return;
        }

        $repeat = $apply->where('userid=%d AND ispass=0', $userid)->select();
        if(count($repeat) >= 5) {
            // 同一用户不能同时申请超过5只宠物
            echo "-3";
            return;
        }

        $apply = M('application');
        $apply->userid = $userid;
        $apply->petid = $petid;
        $result = $apply->add();
        if($result) {
            // 申请成功, 等待审核
            echo "1";
            return;
        }
    }

    // 处理wechat用户申请领养宠物
    public function appDealApplicationFromWechat(){
        $username = I('username');
        $petid = I('pet_id');
        $apply = M('application');

        $user = M('user');
        $userid = $user->where("username='%s'",$username)->getField('id');

        $repeat = $apply->where('userid=%d AND petid=%d AND ispass<>-1', $userid, $petid)->select();
        if($repeat) {
            // 已申请待审核或者已经领养了该宠物
            echo "-1";
            return;
        }

        $repeat = $apply->where('userid=%d AND ispass=1', $userid, $petid)->select();
        if(count($repeat) >= 3) {
            // 同一用户不能同时领养超过3只宠物
            echo "-2";
            return;
        }

        $repeat = $apply->where('userid=%d AND ispass=0', $userid)->select();
        if(count($repeat) >= 5) {
            // 同一用户不能同时申请超过5只宠物
            echo "-3";
            return;
        }

        $apply = M('application');
        $apply->userid = $userid;
        $apply->petid = $petid;
        $result = $apply->add();
        if($result) {
            // 申请成功, 等待审核
            echo "1";
            return;
        }
    }

    /* return the user's application
     查看用户的申请信息(包括已被审核的和未审核的)
     请求信息: user_id
     返回信息: 宠物信息 与 申请通过与否
    */
    public function appGetWaiting(){
        $userid = I('user_id');

        $data = M()->table('pet pet, application apply')
            ->where('userid=%d AND pet.id=apply.petid', $userid)
            ->select();

        $this->ajaxReturn($data, 'json');
    }

    // From wechat  查看用户的申请信息(包括已被审核的和未审核的)
    public function appGetWaitingFromWechat() {
        $username = I('username');

        $user = M('user');
        $userid = $user->where("username='%s'",$username)->getField('id');

        $data = M()->table('pet pet, application apply')
            ->where('userid=%d AND pet.id=apply.petid', $userid)
            ->select();

        $this->ajaxReturn($data, 'json');
    }

    // 根据app发送的id返回对应的宠物信息
    public function appGetPetById() {
        $id = I('pet_id');
        $pet = M('pet');

        $data = $pet->where("id='%d'", $id)->select();
        $this->ajaxReturn($data, "json");
    }


}