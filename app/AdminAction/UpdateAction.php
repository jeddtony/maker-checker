<?php

namespace App\AdminAction;

use App\Models\PendingRequest;
use App\Models\User;

class UpdateAction implements ActionInterface
{
    public function execute(PendingRequest $pendingRequest)
    {
        $user = User::find($pendingRequest->user_id);
        $user->first_name = $pendingRequest->first_name;
        $user->last_name = $pendingRequest->last_name;
        $user->email = $pendingRequest->email;
        $user->save();
        return $user;
    }
}