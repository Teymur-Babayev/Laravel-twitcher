<?php

namespace App\Http\Controllers;

use App\Models\TokenPack;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TokensController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['getTokens']);
    }
    public function getTokens()
    {
        $packs = TokenPack::orderBy('price')->get();
        return Inertia::render('Tokens/Packages', compact('packs'));
    }

    public function selectGateway(TokenPack $tokenPack)
    {
        $paypalEnabled = opt('paypalEnable');
        $stripeEnabled = opt('stripeEnable');
        $bankEnabled = opt('bankEnable');
        $ccbillEnabled = opt('ccbillEnable');

        $paypalImg = asset('images/paypal-btn.png');
        $stripeImg = asset('images/stripe-cards.png');
        $ccbillImg = asset('images/ccbill-pay.png');
        $bankImg = asset('images/bank-transfer.png');

        return Inertia::render(
            'Tokens/Select-Gateway',
            compact(
                'tokenPack',
                'paypalEnabled',
                'stripeEnabled',
                'bankEnabled',
                'ccbillEnabled',
                'paypalImg',
                'stripeImg',
                'bankImg',
                'ccbillImg',
                'bankImg'
            )
        );
    }
}
