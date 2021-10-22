<?php

namespace App\Http\Controllers;

use App\Models\Excuses;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function fillin(Request $request){
        $res = Excuses::fillin($request);
        return $res ?
            json_success('操作成功!', null, 200) :
            json_fail('操作失败!', null, 100);
    }//学生填报
    public function record(Request $request){
        $res = Excuses::record($request);
        return $res ?
            json_success('操作成功!', $res, 200) :
            json_fail('操作失败!', null, 100);
    }//历史记录
    public function details(Request $request){
        $res = Excuses::details($request);
        return $res ?
            json_success('操作成功!', $res, 200) :
            json_fail('操作失败!', null, 100);
    }
}
