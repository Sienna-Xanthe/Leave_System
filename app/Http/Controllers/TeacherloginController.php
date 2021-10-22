<?php

namespace App\Http\Controllers;

use App\Http\Requests\TealoginRequest;
use App\Http\Requests\TearegisteredRequest;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherloginController extends Controller
{
    /**
     * 登录
     * @param Request $loginRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(TealoginRequest $loginRequest)
    {

        try {
            $credentials = self::credentials($loginRequest);
            if (!$token = auth('tea')->attempt($credentials)) {
                return json_fail(100, '账号或者密码错误!', null);
            }

            return self::respondWithToken($token, '登录成功!');
        } catch (\Exception $e) {

            echo $e->getMessage();
            return json_fail(500, '登录失败!', null, 500);
        }
    }
    /**
     * 注销登录
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            auth()->logout();
        } catch (\Exception $e) {

        }
        return auth()->check() ?
            json_fail('注销登录失败!',null, 100 ) :
            json_success('注销登录成功!',null,  200);
    }
    /**
     * 注册
     * @param Request $registeredRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function registered(TearegisteredRequest $registeredRequest)
    {
        return Teacher::createUser(self::userHandle($registeredRequest)) ?
            json_success('注册成功!',null,200  ) :
            json_success('注册失败!',null,100  ) ;

    }
    protected function userHandle($request)
    {
        $registeredInfo = $request->except('password_confirmation');
        $registeredInfo['password'] = bcrypt($registeredInfo['password']);//密码
        $registeredInfo['te_no'] = $registeredInfo['te_no'];//教工号
        $registeredInfo['te_phone'] = $registeredInfo['te_phone'];//手机号
        $registeredInfo['te_authority'] = $registeredInfo['te_authority'];//权限
        $registeredInfo['te_ins_code'] = $registeredInfo['te_ins_code'];//学院编号





        return $registeredInfo;
    }




    protected function credentials($request)
    {
        return ['te_phone' => $request['te_phone'], 'password' => $request['password']];
    }
    protected function respondWithToken($token, $msg)
    {
        $data = auth('tea')->user()->te_authority;
        return json_success( $msg, array(
            'token' => $token,
            //设置权限  'token_type' => 'bearer',
            'authority' => $data,
            'expires_in' => auth('tea')->factory()->getTTL() * 60
        ),200);
    }
}
