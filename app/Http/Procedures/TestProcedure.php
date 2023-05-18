<?php

namespace App\Http\Procedures;

use App\Events\TestEvent;

class TestProcedure
{
    public function sendEvent()
    {
        $user = \Auth::user();
        broadcast(new TestEvent($user->id));
    }
}
