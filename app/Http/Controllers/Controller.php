<?php

namespace App\Http\Controllers;

// ESTE ES EL TRAIT CRÍTICO QUE NECESITAS
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    // Y DEBE ESTAR INCLUIDO AQUÍ
    use AuthorizesRequests, ValidatesRequests;
}
