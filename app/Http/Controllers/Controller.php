<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function responseSuccess($msg, $arr = null, $status)
    {
        $res = [
            'status' => true,
            'message' => ($msg == "") ? "Sukses" : $msg,
        ];
        
        if($arr) {
            $res['data'] = $arr;
        }

        return response()->json($res, $status);
    }

    protected function responseFailed($msg = null, $arr = null, $status = 500)
    {
        $res = [
            'status' => false,
            'message' => (!$msg) ? "Gagal" : $msg,
        ];
        
        if($arr) {
            $res['data'] = $arr;
        }

        return response()->json($res, $status);
    }

}
