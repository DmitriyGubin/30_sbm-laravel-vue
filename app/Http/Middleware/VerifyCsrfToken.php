<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
        'rent-form',
        'registr',
        'go_out',
        'auth_user',
        'call-order-form',
        'file',
        'check_this_cod',
        'update_this_cod'
    ];
}
