<?php

namespace App\AdminAction;

use App\Models\PendingRequest;
use App\Models\User;
use App\Uuid\CustomUuid;

class CreateAction implements ActionInterface
{
    public function execute(PendingRequest $pendingRequest)
    {
        $user = User::create([
            'first_name' => $pendingRequest->first_name,
            'last_name' => $pendingRequest->last_name,
            'email' => $pendingRequest->email,
            'password' => $pendingRequest->password,
            'uuid' => CustomUuid::generateUuid('User')
        ]);
        return $user;
    }
}