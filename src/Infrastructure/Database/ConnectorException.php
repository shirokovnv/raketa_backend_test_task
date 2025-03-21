<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Infrastructure\Database;

class ConnectorException extends \Exception
{
    public function __toString(): string
    {
        return sprintf(
            '[%s] %s in %s on line %d',
            $this->getCode(),
            $this->getMessage(),
        );
    }
}
