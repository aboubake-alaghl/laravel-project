<?php

namespace App\Mixins;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Response;

class ResponseMixin
{
    public function ok()
    {
        return function ($data, $message = 'success', $code = 200) {
            return Response::json([
                'message' => $message,
                'data' => $data,
            ], $code);
        };
    }

    public function created()
    {
        return function ($data, $message = 'resource successfully created', $code = 201) {
            return Response::json([
                'message' => $message,
                'data' => $data,
            ], $code);
        };
    }

    public function updated()
    {
        return function ($data, $message = 'resource successfully updated', $code = 204) {
            return Response::json([
                'message' => $message,
                'data' => $data,
            ], $code);
        };
    }

    public function deleted()
    {
        return function ($data, $message = 'resource successfully deleted', $code = 200) {
            return Response::json([
                'message' => $message,
                'data' => $data,
            ], $code);
        };
    }

    public function unauthorised()
    {
        return function (array $data = ['unauthorised'], $message = 'unauthorised', $code = 401) {
            return Response::json([
                'message' => $message,
                'data' => $data,
            ], $code);
        };
    }

    public function unprocessable()
    {
        return function (MessageBag $data, $message = 'unprocessable', $code = 422) {
            return Response::json([
                'message' => $message,
                'data' => $data,
            ], $code);
        };
    }

    public function forbidden()
    {
        return function (array $data = ['forbidden'], $message = 'forbidden',  $code = 403) {
            return Response::json([
                'message' => $message,
                'data' => $data,
            ], $code);
        };
    }

    public function tooManyRequests()
    {
        return function (array $data = ['too many requests'], $message = 'too many requests',  $code = 429) {
            return Response::json([
                'message' => $message,
                'data' => $data,
            ], $code);
        };
    }

    public function error()
    {
        return function (array $data = ['client error'], $message = 'client error',  $code = 400) {
            return Response::json([
                'message' => $message,
                'data' => $data,
            ], $code);
        };
    }

    public function exception()
    {
        return function (object | string $exception) {
            return Response::json([
                'message' => getType($exception) === 'string' ? $exception : $exception->getMessage(),
                'data' => $exception,
            ], 500);
        };
    }
}
