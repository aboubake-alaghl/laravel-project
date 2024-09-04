<?php

namespace App\Pipes;

use Closure;
use Exception;
use App\Services\OrderService;

class UploadOrderProofImage
{
    protected $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();
    }

    public function handle($request, Closure $next)
    {
        try {
            $this->orderService->uploadProofImage($request->id, $request->file('image'));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $next($request);
    }
}
