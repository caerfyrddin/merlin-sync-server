<?php

namespace Caerfyrddin\MerlinSyncServer\Shared\Infrastructure\Delivery\Rest\User;

use Caerfyrddin\MerlinSyncServer\Core\Api\ApiEndpoint;
use Caerfyrddin\MerlinSyncServer\Core\Http\HttpRequest;
use Caerfyrddin\MerlinSyncServer\Core\Http\HttpResponse;
use Caerfyrddin\MerlinSyncServer\Shared\Application\Action\User\RetrieveUserAction;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\UserId;

class RetrieveUserEndpoint extends ApiEndpoint
{

    public function __invoke(mixed $id): HttpResponse
    {
        return $this->act(new RetrieveUserAction(UserId::from($id)));
    }
}