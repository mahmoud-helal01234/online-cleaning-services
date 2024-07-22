<?php

namespace App\Http\Traits;


trait ResponsesTrait {

    public function apiResponse($data = null, $status = true, $message = null,$statusCode = 200) {

        return response()->json(['status' => $status, 'data' => $data, 'message' => $message],$statusCode);
    }

}
