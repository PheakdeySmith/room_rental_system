<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PriceOverrideController extends Controller
{
    public function index()
    {
        // Logic to list all price overrides for a specific room type
        return view('backends.dashboard.properties.price-override');
    }
}
