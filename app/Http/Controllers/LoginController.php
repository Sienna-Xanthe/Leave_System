<?php

namespace App\Http\Controllers;

use App\Http\Requests\StuloginRequest;
use App\Http\Requests\SturegisteredRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * 登录
     * @param Request $loginRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(StuloginRequest $loginRequest)
    {

        try {
            $credentials = self::credentials($loginRequest);
            if (!$token = auth('api')->attempt($credentials)) {
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
    public function registered(SturegisteredRequest $registeredRequest)
    {
        return Student::createUser(self::userHandle($registeredRequest)) ?
            json_success('注册成功!',null,200  ) :
            json_success('注册失败!',null,100  ) ;

    }
    protected function userHandle($request)
    {
        $registeredInfo = $request->except('password_confirmation');
        $registeredInfo['password'] = bcrypt($registeredInfo['password']);//密码
        $registeredInfo['stu_name'] = $registeredInfo['stu_name'];//姓名
        $registeredInfo['stu_phone'] = $registeredInfo['stu_phone'];//手机号
        $registeredInfo['stu_grd_no'] = $registeredInfo['stu_grd_no'];//年级编号
        $registeredInfo['stu_clsno'] = $registeredInfo['stu_clsno'];//班级编号
        $registeredInfo['stu_no'] = $registeredInfo['stu_no'];//学号



        return $registeredInfo;
    }




    protected function credentials($request)
    {
        return ['stu_phone' => $request['stu_phone'], 'password' => $request['password']];
    }
    protected function respondWithToken($token, $msg)
    {
        //$data = auth('api')->user();
        return json_success( $msg, array(
            'token' => $token,
            //设置权限  'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ),200);
    }
}
