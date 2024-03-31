<?php

namespace Framework\Http\Exceptions;

class HttpException extends \Exception
{
    private int $statusCode = 404;

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }
}