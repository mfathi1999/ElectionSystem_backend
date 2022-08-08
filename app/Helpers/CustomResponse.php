<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Response;

class CustomResponse extends Response
{

    public static function json($data = null, string $message = null,$status =200 ,$headers=[])
    {

        $data = [
            "message" => $message,
            "data" => $data&&isset($data->resource)&&method_exists($data->resource,'total')?$data->resource:$data ,
        ];

        return response()->json($data,$status,$headers);

    }


}
