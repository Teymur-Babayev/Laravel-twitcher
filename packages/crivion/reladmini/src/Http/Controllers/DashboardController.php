<?php
namespace Crivion\Reladmini\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;

class DashboardController extends Controller {

    public function dashboard() {
        return Inertia::render('Reladmini/Dashboard/Dashboard');
    }

}