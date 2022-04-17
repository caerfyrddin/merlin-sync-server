<?php

namespace Caerfyrddin\MerlinSyncServer\Shared\Application\Action\User;

use Caerfyrddin\MerlinSyncServer\Core\Action\Action;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\UserId;

final class RetrieveUserAction extends Action
{

    private UserId $id;

    public function __construct(UserId $id)
    {
        $this->id = $id;
    }

    public function id(): UserId
    {
        return $this->id;
    }
}
