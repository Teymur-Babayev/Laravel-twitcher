<?php

namespace App\Http\Controllers;

use App\Models\TokenPack;
use App\Models\TokenSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class PayPalController extends Controller
{
    // auth
    public function __construct()
    {
        $this->middleware('auth')->except(['ipn', 'redirect']);
    }

    // purchase
    public function purchase(TokenPack $tokenPack, Request $request)
    {
        $sale = TokenSale::create([
                    'user_id' => $request->user()->id,
                    'tokens' => $tokenPack->tokens,
                    'amount' => $tokenPack->price,
                    'status' => 'pending',
                    'gateway' => 'PayPal'
                ]);

        $paypalEmail = opt('paypal_email');
        $paypalUrl = env('PAYPAL_URL');

        return Inertia::render('Tokens/Paypal', compact('tokenPack', 'paypalEmail', 'sale', 'paypalUrl'));
    }

    // redirect to processing
    public function redirect()
    {
        return redirect(route('paypal.processing'));
    }

    // processing
    public function processing()
    {
        $paypalImg = asset('images/paypal-btn.png');
        return Inertia::render('Tokens/PayPalProcessing', compact('paypalImg'));
    }

    // ipn processing
    public function ipn(Request $r)
    {
        $r->validate(['custom' => 'required|exists:token_sales,id']);

        // STEP 1: read POST data
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);

        $myPost = [];

        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2) {
                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
        }

        // read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
        $req = 'cmd=_notify-validate';

        // build req
        foreach ($myPost as $key => $value) {
            $value = urlencode($value);
            $req .= '& ' . trim(strip_tags($key)) . '=' . trim(strip_tags($value));
        }

        // STEP 2: POST IPN data back to PayPal to validate
        $ch = curl_init(env('PAYPAL_IPN_URL'));
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Connection: Close']);

        // error?
        if (!($res = curl_exec($ch))) {
            Log::info('route(paypal.ipn)');
            Log::error('Got ' . curl_error($ch) . ' when processing IPN data');
            curl_close($ch);
            exit();
        } else {
            Log::info('IPN_POSTED_SUCCESSFULLY');
        }
        curl_close($ch);


        // STEP 3: Inspect IPN validation result and act accordingly
        if (preg_match('/VERIFIED/i', $res)) {
            // check if payment status is completed
            if ($r->payment_status != 'Completed') {
                exit();
            }

            // find this order
            $order = TokenSale::findOrFail($r->custom);

            switch ($r->txn_type) {
                case 'web_accept':
                    // update order status
                    $order->status = 'paid';
                    $order->save();

                    // increase user balance
                    $order->user->increment('tokens', $order->tokens);

                    break;
            }
        }
    }
}
