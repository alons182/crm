<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/clients/comments',
        '/clients/comments/delete',
        '/clients/comments/update',
        '/clients/abonos',
        '/clients/abonos/delete',
        '/clients/abonos/update'
    ];
}
