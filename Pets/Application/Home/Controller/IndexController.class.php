<?php
namespace Home\Controller;

use Think\Controller;
use Think\Exception;

class IndexController extends Controller
{

    // 自动运行方法,判断是否登录
    public function _initialize() {
        //当前为登录页时不执行该操作
        if (ACTION_NAME != "login") {
            //判断session['adminaccount']是否为空，是的话跳转到登陆界面
            if (!isset($_SESSION['adminaccount'])) {
                echo "<script>alert('用户未登录或登陆超时');</script>";
                $this->redirect("/Home/Index/login");
            } else {
                //显示登录的管理员帐号
                $adminaccount = $_SESSION['adminaccount'];
                $admin = M('admin')->where("adminaccount='" . $adminaccount . "'")->select();
                $name = $admin[0]['adminname'];
                $this->assign("name", $name);
            }
        }
    }

    // 主页
    public function index()
    {
        $vo = M('user')->order('id')->select();
        $this->assign("list", $vo);
        $this->display();
    }

    //登录页
    public function login() {
        //不加载模板页
        C('LAYOUT_ON', FALSE);
        $this->display();
        if (IS_POST) {
            $admin = M('admin');
            $adminaccount = $_POST['adminaccount'];
            $password = $_POST['password'];
            //这里使用md5加密
            $password = md5($password);
            if ($adminaccount == "" || $password == "") {
                echo "<script>alert('请输入用户名和密码！');history.go(-1);</script>";
            } else {
                $result = $admin->where('adminaccount="%s" and adminpassword="%s"', $adminaccount, $password)->select();
                if ($result) {
                    //将用户账号存入session
                    $_SESSION['adminaccount'] = $adminaccount;
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo "<script>alert('登陆成功');</script>";
                    $this->redirect("/Home/Index");
                } else {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo "<script>alert('登录失败');location.href='" . $_SERVER["HTTP_REFERER"] . "';</script>";
                }
            }
        }
    }

    // 房间列表
    public function rooms() {
        $room = M('room');
        $vo = $room->select();
        $this->assign('list', $vo);
        $this->display();
    }

    // 添加或修改房间
    public function room() {
        $id = I('request.id');
        if($id) {  // 修改操作
            $room = M('room');
            $vo = $room->where("id=" . $id)->select();
            $this->assign("list", $vo);
            $this->display();
            if(IS_POST) {
                if(isset($_POST['save'])) {
                    $room = M("room");
                    $room->id = $id;
                    $room->name = $_POST['name'];
                    $room->capacity = $_POST['capacity'];

					//修改容量不能小于当前容纳数量
					$pet=M('pet');
					$temp=$pet->where("roomid=" . $id)->select();

					if(count($temp)>$room->capacity){
						echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                        echo "<script>alert('房间容量不能小于当前房间已有宠物数量');</script>";
						return;
					}

                    $result = $room->save();
                    if($result) {
                        echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                        echo "<script>alert('修改成功');</script>";
                        $this->redirect("/Home/Index/rooms");
                    } else {
                        echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                        echo '<script type="text/javascript">alert("修改失败")</script>';
                    }
                }
            }
        } else {    // 新增操作
            $this->display();
            if (IS_POST) {
                if (isset($_POST['save'])) {
                    $room = M("room");
                    $room->name = $_POST['name'];
                    $room->capacity = $_POST['capacity'];
                    $room->nownum = 0;
                    // 查询房间名是否存在
                    $temp_room = M('room');
                    $repeat_room = $temp_room->where("name='%s'", $room->name)->find();
                    if($repeat_room) {
                        echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                        echo '<script type="text/javascript">alert("房间名已存在")</script>';
                    } else {
                        $result = $room->add();
                        if ($result) {
                            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                            echo '<script type="text/javascript">alert("新增成功")</script>';
                            $this->redirect("/Home/Index/rooms");
                        } else {
                            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                            echo '<script type="text/javascript">alert("新增失败")</script>';
                        }
                    }
                }
            }
        }
    }

    //删除房间
    public function deleteroom() {
        $id = I('request.id');
        $room = M('room');
        $result = $room->delete($id);
        if ($result) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('删除成功');location.href='" . $_SERVER["HTTP_REFERER"] . "';</script>";
        } else {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('删除失败');location.href='" . $_SERVER["HTTP_REFERER"] . "';</script>";
        }
    }


    // 宠物列表
    public function petslist() {
        // 未被领养的宠物
        $data = M()->field('pet.id, petname, breed, age, sex,
         entertime, room.name roomname')
            ->table('pet pet, room room')
            ->where("room.id=pet.roomid AND pet.istaken=0")
            ->order('roomname')
            ->select();

        $this->assign("list", $data);
        $this->display();
    }

    // 添加/修改宠物
    public function pet(){
        $id = I('request.id');
        if($id) { // 修改宠物
            $pet = M('pet')->where("id=%d", $id)->select();
            $old_roomid = $pet[0]['roomid'];
            $mod2 = M('room')->where("nownum<capacity")->select();
            $care_mod = M('careworker')->select();
            $care_ids = M('lookafter')->where("petid=%d", $id)->select();


			if($pet[0]['sex'] == 'm') {
                $pet[0]['male'] = 'selected="true"';
            } else {
                $pet[0]['female'] = 'selected="true"';
            }
			 // 绑定宠物基本信息
			$this->assign("list", $pet);

            // 绑定房间
            foreach ($mod2 as &$item) {
                if($item['id'] == $old_roomid) {
                    $item['se'] = 'selected="true"';
                }
            }
            $this->assign("classify", $mod2);
            foreach ($care_mod as &$item) {
                foreach ($care_ids as $care_id) {
                    if($item['id'] == $care_id['careworkerid']) {
                        $item['check'] = 'checked="checked"';
                    }
                }
            }
            $this->assign("cares", $care_mod);
            $this->display();

            if(IS_POST) {
                $pet = M('pet');
                $pet_data['img'] = I('pp');
                $pet_data['petname'] = I('petsname');
                $pet_data['roomid'] = I('roomsclassify');
                $pet_data['breed'] = I('category');
                $pet_data['age'] = I('age');
				$pet_data['character']=I('character');
                $pet_data['sex'] = I('sex');
                $pet_data['entertime'] = I('entertime');
                $careworkers = I('careworkers');

                // 开启事务
                $User = M();
                $User->startTrans();
                try {
                    $resultForPet = $pet->where('id=%d', $id)->save($pet_data);
                    if($old_roomid != $pet_data['roomid']) { // 更换房间
                        // 原房间nownum - 1
                        $old_room = M('room')->where("id=%d", $old_roomid)->setDec('nownum', 1);
                        // 新房间nownum + 1
                        $new_room = M('room')->where("id=%d", $pet_data['roomid'])->setInc('nownum', 1);
                    }
                    // 先删除原来的护工-宠物关系数据
                    $lookafter = M('lookafter')->where("petid=%d", $id)->delete();
                    // 添加新的数据
                    foreach ($careworkers as $careworker) {
                        $lookafter = M('lookafter');
                        $lookafter->careworkerid = $careworker;
                        $lookafter->petid = $id;
                        $lookafter->add();
                    }
                    // 提交事务
                    $User->commit();
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo "<script>alert('修改成功');</script>";
                    $this->redirect("/Home/Index/petslist");
                } catch(Exception $e) {
                    // 事务回滚
                    $User->rollback();
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo "<script>alert('修改失败');</script>";
                }
            }
        } else { // 新增宠物
            // 查询当前未满的房间
            $mod2 = M('room')->where("nownum<capacity")->select();
            // 查询护工列表
            $care_mod = M('careworker')->select();
            $this->assign("classify", $mod2);
            $this->assign("cares", $care_mod);
            $this->display();
            if(IS_POST) {
                $pet = M('pet');
                $pet_data['img'] = I('pp');
                $pet_data['petname'] = I('petsname');
                $pet_data['roomid'] = I('roomsclassify');
                $pet_data['breed'] = I('category');
                $pet_data['age'] = I('age');
				$pet_data['character']=I('character');
                $pet_data['sex'] = I('sex');
                $pet_data['entertime'] = I('entertime');
                $careworkers = I('careworkers');

                // 开启事务
                $User = M();
                $User->startTrans();
                try {
                    $result = $pet->add($pet_data);
                    // 在对应的room表中, nownum + 1
                    $room = M('room')->where("id=%d", $pet_data['roomid'])->setInc('nownum', 1);
                    $pet_id = $result;
                    foreach ($careworkers as $careworker) {
                        $lookafter = M('lookafter');
                        $lookafter->careworkerid = $careworker;
                        $lookafter->petid = $pet_id;
                        $lookafter->add();
                    }

                    // 提交事务
                    $User->commit();
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo "<script>alert('添加成功');</script>";
                    $this->redirect("/Home/Index/petslist");
                } catch(Exception $e) {
                    // 事务回滚
                    $User->rollback();
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo "<script>alert('添加失败');</script>";
                }
            }
        }
    }

    // 删除宠物
    public function deletepet() {
        $id = I('request.id');
        $Pet = M();
        $Pet->startTrans();
        try{
            // 房间nownum - 1
            $roomid = M('pet')->where("id=%d", $id)->getField('roomid');
            $room = M('room')->where("id=%d", $roomid)->setDec('nownum', 1);
            $pet = M('pet');
            $result = $pet->delete($id);

            $Pet->commit();
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('删除成功');location.href='" . $_SERVER["HTTP_REFERER"] . "';</script>";
        } catch(Exception $e) {
            $Pet->rollback();
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('删除失败');location.href='" . $_SERVER["HTTP_REFERER"] . "';</script>";
        }
    }

    // 照料列表
    public function lookafter() {
        $data = M()->field('lookafter.id, careworker.name careworker_name, pet.petname pet_name')
            ->table('pet pet, careworker careworker, lookafter lookafter')
            ->where('pet.id=lookafter.petid AND careworker.id=lookafter.careworkerid')
            ->order('careworker_name')
            ->select();
        $this->assign("list", $data);
        $this->display();
    }

    // 删除照料关系
    public function deletelookafter() {
        $id = I('request.id');
        $lookafter = M('lookafter');
        $result = $lookafter->where('id=%d', $id)->delete();
        if($result === false) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('删除失败');</script>";
        } else if($result === 0) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('没有删除任何记录');</script>";
        } else {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('删除成功');</script>";
            $this->redirect("/Home/Index/lookafter");
        }
    }

    // 领养记录
    public function petsUser() {
        $data = M()->field('pet.id pet_id, petname, breed, age, sex, leavetime, apply.userid')
            ->table('pet pet, application apply')
            ->where('pet.istaken=1 AND pet.id=apply.petid AND ispass=1')
            ->select();
        foreach ($data as &$item) {
            $userid = $item['userid'];
            $realname = M('user')->where("id=%d", $userid)->getField('realname');
            $username = M('user')->where("id=%d", $userid)->getField('username');
            $item['realname'] = $realname;
            $item['username'] = $username;
        }

        $this->assign("list_taken", $data);
        $this->display();
    }


    // 护工列表
    public function careworkers() {
        $careworkers = M('careworker');
        $vo = $careworkers->select();
        foreach ($vo as &$item) {
            if($item['sex'] == 'm') {
                $item['sex'] = '男';
            } else {
                $item['sex'] = '女';
            }
        }
        $this->assign("list", $vo);
        $this->display();
    }

    // 添加/修改护工
    public function careworker() {
        $id = I('request.id');
        if($id) { // 修改护工信息
            $careworker = M('careworker');
            $vo = $careworker->where('id=%d', $id)->find();
            if($vo['sex'] == 'm') {
                $vo['male'] = 'selected="true"';
            } else {
                $vo['female'] = 'selected="true"';
            }
            $this->assign("list", $vo);
            $this->display();
            if(IS_POST) {
                if(isset($_POST['save'])) {
                    $careworker = M('careworker');
                    $careworker->id = $id;
                    $careworker->name = $_POST['name'];
                    $careworker->sex = $_POST['sex'];
                    $careworker->phone = $_POST['phone'];
                    $careworker->idcard = $_POST['idcard'];
                    $careworker->address = $_POST['address'];

                    $test = M('careworker')->where("idcard='%s' AND id<>%d", $careworker->idcard, $id)->find();
                    if(count($test)) {
                        echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                        echo "<script>alert('身份证重复');</script>";
                        return;
                    }
                    $result = $careworker->save();
                    if($result !== false) {
                        echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                        echo "<script>alert('修改成功');</script>";
                        $this->redirect("/Home/Index/careworkers");
                    } else {
                        echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                        echo "<script>alert('修改失败');</script>";
                    }
                }
            }
        } else {    // 添加护工信息
            $this->display();
            if(isset($_POST['save'])) {
                $careworker = M('careworker');
                $careworker->name = $_POST['name'];
                $careworker->sex = $_POST['sex'];
                $careworker->phone = $_POST['phone'];
                $careworker->idcard = $_POST['idcard'];
                $careworker->address = $_POST['address'];

                $test = M('careworker')->where("idcard='%s'", $careworker->idcard)->find();
                if(count($test)) {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo "<script>alert('身份证重复');</script>";
                    return;
                }
                $result = $careworker->add();
                if($result) {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo "<script>alert('添加成功');</script>";
                    $this->redirect("/Home/Index/careworkers");
                } else {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo "<script>alert('添加失败');</script>";
                }
            }
        }
    }

    // 删除护工信息
    public function deletecareworker() {
        $id = I('request.id');
        $careworker = M('careworker');
        $result = $careworker->delete($id);

        if ($result) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('删除成功');location.href='" . $_SERVER["HTTP_REFERER"] . "';</script>";
        } else {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('删除失败');location.href='" . $_SERVER["HTTP_REFERER"] . "';</script>";
        }
    }

    // 用户列表
    public function users() {
        $user = M('user');
        $vo = $user->select();
        foreach ($vo as &$item) {
            if($item['sex'] == 'm') {
                $item['sex'] = '男';
            } else {
                $item['sex'] = '女';
            }
        }
        $this->assign("list", $vo);
        $this->display();
    }

    // 修改用户信息
/*    public function user() {
        $id = I('request.id');
        $users = M('user');
        $vo = $users->where('id=' . $id)->select();
        $this->assign("list", $vo);
        $this->display();
        if (IS_POST) {
            if (isset($_POST['save'])) {
                $user = M('user');
                $user->id = $id;
                $user->username = $_POST['username'];
                $user->password = md5($_POST['password']);
                $user->realname = $_POST['realname'];
                $user->sex = $_POST['sex'];
                $user->idcard = $_POST['idcard'];
                $user->phone = $_POST['phone'];
                $user->address = $_POST['address'];
                $result = $user->save();
                if ($result) {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo "<script>alert('修改成功');</script>";
                    $this->redirect("/Home/Index/users");
                } else {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo '<script type="text/javascript">alert("修改失败")</script>';
                }
            }
        }
    }*/

    //删除用户
    public function deleteuser() {
        $id = I('request.id');
        $user = M('user');
        $result = $user->delete($id);
        if ($result) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('删除成功');location.href='" . $_SERVER["HTTP_REFERER"] . "';</script>";
        } else {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('删除失败');location.href='" . $_SERVER["HTTP_REFERER"] . "';</script>";
        }
    }

    // 申请列表
    public function apply() {
        // 查找待处理申请信息
        $data = M()->field('apply.id apply_id, realname, username, petid, petname')
            ->table('application apply, user user, pet pet')
            ->where('apply.userid=user.id AND apply.petid=pet.id AND ispass=0')
            ->select();
        $this->assign("list", $data);

        // 查找已处理信息
        $data1 = M()->field('apply.id apply_id, realname, username, petid, petname, ispass')
            ->table('application apply, user user, pet pet')
            ->where('apply.userid=user.id AND apply.petid=pet.id AND ispass<>0')
            ->order('ispass desc')
            ->select();
        foreach ($data1 as &$item) {
            if($item['ispass'] == 1) {
                $item['state'] = '审核通过';
            } else {
                $item['state'] = '审核拒绝';
            }
        }
        $this->assign("list_take", $data1);
        $this->display();
    }

    // 申请通过
    public function applysuccess() {
        $id = I('request.id');
        $apply = M('application');
        // 开启事务
        $apply->startTrans();
        try {
            // 设ispass标志位为1
            $apply->where('id=%d', $id)->lock(true)->setField('ispass', 1);
            // 设宠物istaken标志位为1
            $time_now = time();
            $date_now = date("Y-m-d", $time_now);
            $data = array('istaken'=>1, 'leavetime'=>$date_now);
            $petid = M('application')->where('id=%d', $id)->getField('petid');
            $pet = M('pet')->where('id=%d', $petid)
                ->setField($data);
            // 其余申请这只宠物待审核的记录自动设为拒绝
            $apply->where('petid=%d AND ispass=0', $petid)->setField('ispass', -1);
            // 删除lookafter表中对应的宠物记录
            $lookafter = M('lookafter')->where('petid=%d', $petid)->delete();
            // 房间nownum - 1
            $roomid = M('pet')->where("id=%d", $petid)->getField('roomid');
            $old_room = M('room')->where("id=%d", $roomid)->setDec('nownum', 1);
            // 提交事务
            $apply->commit();
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('审核通过成功');</script>";
        } catch(Exception $e) {
            // 回滚事务
            $apply->rollback();
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo '<script>alert("审核通过失败")</script>';
        }
        $this->redirect("/Home/Index/apply");
    }

    // 申请拒绝
    public function applydeny() {
        $id = I('request.id');
        $apply = M('application');
        $result = $apply->where('id=%d', $id)->lock(true)->setField('ispass', -1);
        if ($result) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('审核拒绝成功');</script>";
        } else {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('审核拒绝失败');</script>";
        }
        $this->redirect("/Home/Index/apply");
    }

    // 管理员列表
    public function admins() {
        $admin = M('admin');
        $vo = $admin->select();
        $this->assign("list", $vo);
        $this->display();
    }

    //管理员信息
    public function admin() {
        $adminaccount = $_SESSION['adminaccount'];
        $admin = M('admin')->where("adminaccount='" . $adminaccount . "'")->select();
        if (true) {
            $id = I('request.id');
            $admin = M('admin');
            $vo = $admin->where('id=' . $id)->select();
            $this->assign("list", $vo);
            $this->assign("id", $id);
            $this->display();
            if (IS_POST) {
                if(isset($_POST['save'])) {
                    $admin = M('admin');
                    $admin->id = $id;
                    $admin->adminname = $_POST['name'];
                    $admin->adminaccount = $_POST['account'];
                    $password = $_POST['password'];
                    //采用md5加密
                    $admin->adminpassword = md5($password);
                    $result = $admin->save();
                    if ($result !== false) {
                        echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                        echo "<script>alert('修改成功');</script>";
                        $this->redirect("/Home/Index/admins");
                    } else {
                        echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                        echo '<script type="text/javascript">alert("修改失败")</script>';
                    }
                }
            }
        }
    }

}