<?php
/**
 * Created by PhpStorm.
 * User: Waydrow
 * Date: 2016/12/6
 * Time: 16:54
 */
namespace Home\Model;
use Think\Model\ViewModel;

class PetsViewModel extends ViewModel {
    public $viewFields = array(
        'pet' => array('id', 'roomid', 'petname', 'img', 'breed', 'age', 'character', 'sex', 'entertime'),
        'room' => array('id' => 'room_id', 'name' => 'room_name', 'capacity', 'nownum', '_on'=>'pet.roomid=room.id'),
        'careworker' => array('id' => 'careworker_id', 'name' => 'careworker_name',
            'sex' => 'careworker_sex', 'phone')
    );

    public function addPet($petdata) {
        $pet = M('pet');
        //$room = M('room')->where("id=%d", $petdata['roomid'])->find();


    }
}