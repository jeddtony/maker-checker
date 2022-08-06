<?php

namespace App\AdminAction;

use App\Models\PendingRequest;
use App\Models\User;

class DeleteAction implements ActionInterface
{
    public function execute(PendingRequest $pendingRequest)
    {
        $user = User::where('uuid', $pendingRequest->user_uuid)->first();
        $user->delete();
    }
}