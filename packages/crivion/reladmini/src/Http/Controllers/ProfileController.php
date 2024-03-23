<?php
namespace Crivion\Reladmini\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;

class ProfileController extends Controller {

    public function profile() {
        $user = auth()->user();

        return Inertia::render('Reladmini/Profile/Profile', compact('user'));
    }

}