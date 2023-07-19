<?php

namespace App\Http\Controllers\Dashboard\DRE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DREAnualController extends Controller
{
    public function home(Request $request)
    {
        return Inertia::render('Dashboard/DRE/Anual/Home');
    }
}
