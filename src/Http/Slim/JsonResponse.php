<?php declare(strict_types=1);

namespace Http\Slim;

use Fig\Http\Message\StatusCodeInterface;
use InvalidArgumentException;
use Slim\Psr7\Response;

class JsonResponse extends Response
{
    /**
     * @param null|string|array $data
     */
    public function __construct($data, int $status = StatusCodeInterface::STATUS_OK)
    {
        if ($data !== null && ! is_array($data) && ! is_string($data)) {
            throw new InvalidArgumentException('Invalid $data passed to ' . __CLASS__);
        }

        parent::__construct($status);

        if ($data !== null) {
            $this->getBody()->write(json_encode($data, JSON_THROW_ON_ERROR));
        }
    }
}