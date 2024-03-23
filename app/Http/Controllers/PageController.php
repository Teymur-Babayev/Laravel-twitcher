<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function __invoke(Page $page)
    {
        return Inertia::render('Page', compact('page'));
    }
}
