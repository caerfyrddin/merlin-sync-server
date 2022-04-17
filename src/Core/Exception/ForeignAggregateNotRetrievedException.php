<?php

namespace Caerfyrddin\MerlinSyncServer\Core\Exception;

use Exception;
use JetBrains\PhpStorm\Pure;
use ReturnTypeWillChange;
use RuntimeException;

class ForeignAggregateNotRetrievedException extends RuntimeException
{

    #[Pure]
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    #[ReturnTypeWillChange]
    public function __toString(): string
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}