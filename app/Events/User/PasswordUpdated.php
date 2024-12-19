<?php

declare(strict_types=1);

namespace App\Events\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PasswordUpdated implements ShouldDispatchAfterCommit, ShouldQueue
{
    use Dispatchable;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public User $user) {}
}
