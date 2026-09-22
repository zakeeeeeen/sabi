<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    protected function authorizeAdmin(): void
    {
        // Protected by AdminMiddleware
    }
}
