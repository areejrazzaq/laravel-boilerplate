<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;

// use Illuminate\Http\Response;

class AppBaseController extends Controller
{
    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 400)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }

    public function sendSuccess($message, $code = 200)
    {
        return Response::json([
            'success' => true,
            'message' => $message
        ], $code);
    }

    public function sendResponse_v2($result, $message)
    {
        $data = [
            'items' => $result->items(),
            'pagination' => [
                'current_page' => $result->currentPage(),
                'last_page' => $result->lastPage(),
                'per_page' => (int)$result->perPage(),
                'total' => $result->total(),
            ]
        ];

        $response = [
            'success' => true,
            'data'    => $data,
            'message' => $message
        ];
        return Response::json($response);
    }

    public function sendError_v2($title, $error, $code = 400)
    {
        return response(
            [
                'success' => false,
                'message' => 'Validation failed',
                'error' => [
                    $title => $error,
                ],
            ],
            $code,
        );
    }

    public function verifyParams($required_params, $request)
    {
        foreach ($required_params as $param) {
            if (!isset($request->$param)) {
                return $this->sendError($param . ' is missing');
            }
        }
        return 'true';
    }

}

class ResponseUtil
{
    /**
     * @param string $message
     * @param mixed  $data
     *
     * @return array
     */
    public static function makeResponse($message, $data)
    {
        return [
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ];
    }

    /**
     * @param string $message
     * @param array  $data
     *
     * @return array
     */
    public static function makeError($message, array $data = [])
    {
        $res = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($data)) {
            $res['data'] = $data;
        }

        return $res;
    }
}
