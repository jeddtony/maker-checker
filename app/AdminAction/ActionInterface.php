<?php

namespace App\AdminAction;

use App\Models\PendingRequest;

interface ActionInterface
{
    public function execute(PendingRequest $pendingRequest);
}