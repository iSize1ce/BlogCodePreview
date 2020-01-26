<?php

namespace Slim;

use Fig\Http\Message\StatusCodeInterface;
use Slim\Psr7\Interfaces\HeadersInterface;
use Slim\Psr7\Response;

class JsonResponse extends Response
{
    public function __construct($data, int $status = StatusCodeInterface::STATUS_OK, ?HeadersInterface $headers = null)
    {
        parent::__construct($status, $headers);

        $this->getBody()->write(json_encode($data));
    }
}