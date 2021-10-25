<?php

namespace App\Http\Controllers;

use App\Models\Excuses;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function exhibit(Request $request){
        $res = Excuses::exhibit($request);
        return $res ?
            json_success('操作成功!', $res, 200) :
            json_fail('操作失败!', null, 100);
    }
    public function approve(Request $request){
        $res = Excuses::approve($request);
        return $res ?
            json_success('操作成功!', null, 200) :
            json_fail('操作失败!', null, 100);
    }
    public function cassette(Request $request){
        $res = Excuses::cassette($request);
        return $res ?
            json_success('操作成功!', $res, 200) :
            json_fail('操作失败!', null, 100);
    }
    public function notpass(Request $request){
        $res = Excuses::notpass($request);
        return $res ?
            json_success('操作成功!', null, 200) :
            json_fail('操作失败!', null, 100);
    }
}
