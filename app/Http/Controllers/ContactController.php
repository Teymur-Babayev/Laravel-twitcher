<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\ContactFormEmail;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    // form
    public function form()
    {
        // set random numbers
        $no1 = rand(1, 5);
        $no2 = rand(1, 5);

        // get total
        $total = $no1+$no2;

        // contact image
        $contact_image = asset('images/contact-image.png');

        // put in session
        session(['total' => $total]);

        return Inertia::render('Contact', compact('no1', 'no2', 'contact_image'));
    }

    // send notification
    public function processForm(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2',
            'email' => 'required|email',
            'subject' => 'required|min:2',
            'message' => 'required|min:5',
            'math' => 'required|numeric'
        ]);

        // check total
        if (!session('total')) {
            session()->flash('message', __("Captcha missing"));
            return back();
        }

        // check math answer
        if ($request->math != session('total')) {
            session()->flash('message', __("Your math answer is wrong"));
            return back();
        }

        // finally, all seems legit - notify admin via email
        $admin = User::where('is_admin', 'yes')->firstOrFail();
        $admin->notify(new ContactFormEmail($request));

        session()->flash('message', __("Thanks for your message, we will get back to you as soon as possible."));

        return to_route('home');
    }
}
