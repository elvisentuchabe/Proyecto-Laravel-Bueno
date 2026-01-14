<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideojuegoController extends Controller
{
    //
    public function create()
{
    return view('videojuegos.create');
}

}
