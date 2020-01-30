<?php declare(strict_types=1);

namespace Http\Slim;

use Fig\Http\Message\StatusCodeInterface;
use Slim\Psr7\Response;

class JsonResponse extends Response
{
    public function __construct($data, int $status = StatusCodeInterface::STATUS_OK)
    {
        parent::__construct($status);

        $this->getBody()->write(json_encode($data, JSON_THROW_ON_ERROR));
    }
}