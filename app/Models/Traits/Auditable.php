<?php

namespace App\Models\Traits;

use App\Observers\AuditObserver;

trait Auditable
{
    /**
     * O método "boot" da trait.
     * Isto irá automaticamente registar o observer para qualquer modelo que use esta trait.
     */
    public static function bootAuditable()
    {
        static::observe(AuditObserver::class);
    }
}
