<?php

namespace App\Main\Helpers;

class  Response{
    const RESPONSE_STATUS_SUCCESS = 1;
    const RESPONSE_STATUS_FAIL = 0;

    const HTTP_CODE_SUCCESS = 200;
    const HTTP_CODE_UNAUTHORIZED = 401;

    function responseJsonSuccess($data = [], $message = '')
    {
        return response(
            [
                'status' => Response::RESPONSE_STATUS_SUCCESS,
                'message' => $message,
                'data' => $data
            ]
            ,
            Response::HTTP_CODE_SUCCESS,
        );
    }

    function responseJsonSuccessPaginate($data = [], $paginate = [],$message = '')
    {
        return response(
            [
                'status' => Response::RESPONSE_STATUS_SUCCESS,
                'message' => $message,
                'data' => $data,
                'paginate' => $paginate,

            ]
            ,
            Response::HTTP_CODE_SUCCESS,
        );
    }

    function responseJsonFail($message = '', $httpCode = Response::HTTP_CODE_SUCCESS, $errors = [])
    {
        return response(
            [
                'status' => Response::RESPONSE_STATUS_FAIL,
                'message' => $message,
            ]
            ,
            $httpCode
        );
    }

    function responseJsonFailMultipleErrors($errors = [], $message = '', $httpCode =Response:: HTTP_CODE_SUCCESS)
    {
        return response(
            [
                'status' => Response::RESPONSE_STATUS_FAIL,
                'message' => $message,
                'errors' => $errors,
            ]
            ,
            $httpCode
        );
    }

    function paginate(int $total, int|null $limit, int $page){
        $totalPage = !empty($limit) ? ceil($total/$limit) : 0;
        return [
            'total' => $total,
            'limit' => $limit,
            'total_page' => (int)$totalPage,
            'current_page' => $page
        ];
    }
}

