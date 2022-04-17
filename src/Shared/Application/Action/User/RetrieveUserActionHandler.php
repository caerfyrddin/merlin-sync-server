<?php

namespace Caerfyrddin\MerlinSyncServer\Shared\Application\Action\User;

use Caerfyrddin\MerlinSyncServer\Core\Action\ActionHandler;
use Caerfyrddin\MerlinSyncServer\Core\Http\HttpResponse;
use Caerfyrddin\MerlinSyncServer\Shared\Infrastructure\Persistence\User\UserRepository;

final class RetrieveUserActionHandler extends ActionHandler
{

    private UserRepository $users;

    public function __construct()
    {
        $this->users = new UserRepository();
    }

    public function __invoke(RetrieveUserAction $action): HttpResponse
    {
        $user = $this->users->fromIdOrFail($action->id());

        return HttpResponse::json($user);
    }
}
