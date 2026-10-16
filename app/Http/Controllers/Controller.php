<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    // Permite usar $this->authorize() con las Policies del proyecto.
    use AuthorizesRequests;
}
