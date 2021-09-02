<?php

namespace App\Contracts\Core\Services;

use Exception;

interface ApiResponseBaseInterfaceServices
{
    public function created($data = null, $message = 'Successfully created');
    public function error($data = null, $message = 'Error', $status = 400, $paramError = false);
    public function success($data = null, $message = 'Success');
    public function mountErrorResponse(Exception $exception);
}
