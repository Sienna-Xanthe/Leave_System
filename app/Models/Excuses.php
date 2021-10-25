<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Excuses extends Model
{
    protected $table = "excuses";
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $guarded = [];

    public static function fillin($request){
        try{
            $res = Excuses::create(
                [
                    'ecs_no' => 1,
                    'ecs_stu_no' => $request['ecs_stu_no'],
                    'ecs_submit_date' => $request['ecs_submit_date'],
                    'ecs_begin_date' => $request['ecs_begin_date'],
                    'ecs_end_date' => $request['ecs_end_date'],
                    'ecs_end_time' => $request['ecs_end_time'],
                    'ecs_is_outed' => $request['ecs_is_outed'],
                    'ecs_origin' => $request['ecs_origin'],
                    'ecs_brief_reason' => $request['ecs_brief_reason'],
                    'ecs_instructor' => $request['ecs_instructor']
                ]
            );
            return $res ?
                $res :
                false;
        }catch (\Exception $e) {
            logError('操作错误', [$e->getMessage()]);
            return false;
        }
    }//学生填报
    public static  function record($request){
        try{
            $res = Excuses::where('ecs_stu_no','=',$request['ecs_stu_no'])
                ->select('id','ecs_no')
                ->get();
            return $res ?
                $res :
                false;
        }catch (\Exception $e) {
            logError('操作错误', [$e->getMessage()]);
            return false;
        }
    }//历史记录

    public static function details($request){
        try{
            $res = Excuses::where('id','=',$request['id'])
                ->select('ecs_no','ecs_stu_no','id','ecs_submit_date','ecs_begin_date','ecs_end_date','ecs_end_time','ecs_is_outed','ecs_origin','ecs_brief_reason')
                ->get();
            return $res ?
                $res :
                false;
        }catch (\Exception $e) {
            logError('操作错误', [$e->getMessage()]);
            return false;
        }
    }//详情

    public static function exhibit($request){
        try{
            $res = Excuses::where('ecs_instructor','=',$request['ecs_instructor'])
                ->select('ecs_stu_no','id','ecs_begin_date','ecs_no')
                ->get();
            return $res ?
                $res :
                false;
        }catch (\Exception $e) {
            logError('操作错误', [$e->getMessage()]);
            return false;
        }
    }//老师数据展示
    public static function approve($request){
        try{
            $res = Excuses::where('id','=',$request['id'])
                ->update(['ecs_no' => 2]);
            return $res ?
                $res :
                false;
        }catch (\Exception $e) {
            logError('操作错误', [$e->getMessage()]);
            return false;
        }
    }//假条审批
    public static function cassette($request){
        try{
            if($request['stu_grd_no'] == 0){
                try{
                    $res = Excuses::where('ecs_instructor','=',$request['ecs_instructor'])
                        ->select('ecs_stu_no','id','ecs_begin_date','ecs_no')
                        ->get();
                    return $res ?
                        $res :
                        false;
                }catch (\Exception $e) {
                    logError('操作错误', [$e->getMessage()]);
                    return false;
                }
            }else{
                if ($request['stu_clsno'] == 0){
                    try{
                        $res = Excuses::join('students','students.stu_no','=','excuses.ecs_stu_no')
                            ->where([
                                ['excuses.ecs_instructor','=',$request['ecs_instructor']],
                                ['students.stu_grd_no','=',$request['stu_grd_no']]
                            ])
                            ->select('excuses.ecs_stu_no','excuses.id','excuses.ecs_begin_date')
                            ->get();
                        return $res ?
                            $res :
                            false;
                    }catch (\Exception $e) {
                        logError('操作错误', [$e->getMessage()]);
                        return false;
                    }
                }else{
                    $res = Excuses::join('students','students.stu_no','=','excuses.ecs_stu_no')
                        ->where([
                            ['excuses.ecs_instructor','=',$request['ecs_instructor']],
                            ['students.stu_grd_no','=',$request['stu_grd_no']],
                            ['students.stu_clsno','=',$request['stu_clsno']]
                        ])
                        ->select('excuses.ecs_stu_no','excuses.id','excuses.ecs_begin_date')
                        ->get();
                    return $res ?
                        $res :
                        false;
                }
            }
        }catch (\Exception $e) {
            logError('操作错误', [$e->getMessage()]);
            return false;
        }
    }//历史记录

    public static function data(){
        try{
            $res = Excuses::where([

                ['ecs_end_time','>=',5],
                ['ecs_no','=',2]
            ])
                ->select('ecs_stu_no','id','ecs_begin_date')
                ->get();
            return $res ?
                $res :
                false;
        }catch (\Exception $e) {
            logError('操作错误', [$e->getMessage()]);
            return false;
        }
    }//数据展示
    public static function audit($request){
        try{
            $res = Excuses::where('id','=',$request['id'])
                ->update(['ecs_no' => 3]);
            return $res ?
                $res :
                false;
        }catch (\Exception $e) {
            logError('操作错误', [$e->getMessage()]);
            return false;
        }
    }//审批

    public static function leave($request){
        try{
            if($request['stu_grd_no'] == 0){
                try{
                    $res = Excuses::select('ecs_stu_no','id','ecs_begin_date','ecs_no')
                        ->get();
                    return $res ?
                        $res :
                        false;
                }catch (\Exception $e) {
                    logError('操作错误', [$e->getMessage()]);
                    return false;
                }
            }else{
                if ($request['stu_clsno'] == 0){
                    try{
                        $res = Excuses::join('students','students.stu_no','=','excuses.ecs_stu_no')
                            ->where([
                                ['students.stu_grd_no','=',$request['stu_grd_no']]
                            ])
                            ->select('excuses.ecs_stu_no','excuses.id','excuses.ecs_begin_date')
                            ->get();
                        return $res ?
                            $res :
                            false;
                    }catch (\Exception $e) {
                        logError('操作错误', [$e->getMessage()]);
                        return false;
                    }
                }else{
                    $res = Excuses::join('students','students.stu_no','=','excuses.ecs_stu_no')
                        ->where([
                            ['students.stu_grd_no','=',$request['stu_grd_no']],
                            ['students.stu_clsno','=',$request['stu_clsno']]
                        ])
                        ->select('excuses.ecs_stu_no','excuses.id','excuses.ecs_begin_date')
                        ->get();
                    return $res ?
                        $res :
                        false;
                }
            }
        }catch (\Exception $e) {
            logError('操作错误', [$e->getMessage()]);
            return false;
        }
    }
    public static function search($request){
        try{
            $res = Excuses::where('id','=',$request['id'])
                ->select('ecs_stu_no','id','ecs_begin_date','ecs_no')
                ->get();
            return $res ?
                $res :
                false;
        }catch (\Exception $e) {
            logError('操作错误', [$e->getMessage()]);
            return false;
        }
    }
    public static function notpass($request){
        try{
            $res = Excuses::where('id','=',$request['id'])
                ->update(['ecs_no' => 0]);
            return $res ?
                $res :
                false;
        }catch (\Exception $e) {
            logError('操作错误', [$e->getMessage()]);
            return false;
        }
    }
}
