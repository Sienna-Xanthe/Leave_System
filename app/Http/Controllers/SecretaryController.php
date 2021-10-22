<?php

namespace App\Http\Controllers;

use App\Models\Excuses;
use Illuminate\Http\Request;

class SecretaryController extends Controller
{
    public function data(){
        $res = Excuses::data();
        return $res ?
            json_success('操作成功!', $res, 200) :
            json_fail('操作失败!', null, 100);
    }
    public function audit(Request $request){
        $res = Excuses::audit($request);
        return $res ?
            json_success('操作成功!', null, 200) :
            json_fail('操作失败!', null, 100);
    }
    public function leave(Request $request){
        $res = Excuses::leave($request);
        return $res ?
            json_success('操作成功!', $res, 200) :
            json_fail('操作失败!', null, 100);
    }
    public function search(Request $request){
        $res = Excuses::search($request);
        return $res ?
            json_success('操作成功!', $res, 200) :
            json_fail('操作失败!', null, 100);
    }
}
