<?php

namespace App\Http\Controllers;

use App\Models\Opinion;
use Illuminate\Http\Request;

class OpinionController extends Controller
{
    public function index()
    {
        $opinions = Opinion::latest()->paginate(12);
        return view('opinions.index', compact('opinions'));
    }

    public function show(Opinion $opinion)
    {
        return view('opinions.show', compact('opinion'));
    }
}
