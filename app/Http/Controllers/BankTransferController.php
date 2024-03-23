<?php

namespace App\Http\Controllers;

use App\Models\TokenPack;
use App\Models\User;
use App\Notifications\NewBankTransferNotification;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BankTransferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function purchase(TokenPack $tokenPack)
    {
        $bankImg = asset('images/bank-transfer.png');
        $bankInstructions = nl2br(opt('bankInstructions'));

        return Inertia::render('Tokens/BankTransfer', compact('tokenPack', 'bankImg', 'bankInstructions'));
    }

    public function confirmPurchase(TokenPack $tokenPack, Request $request)
    {
        $request->validate([
            'proofDetails' => 'required|min:2',
            'proofImage' => 'required|mimes:jpg,png'
        ]);

        // upload proof
        $image = $request->file('proofImage')->store('bt-p-proofs');

        // find admin & notify
        $admin = User::where('is_admin', 'yes')->firstOrFail();
        $admin->notify(new NewBankTransferNotification($request->user(), $image, $request->proofDetails, $tokenPack->id));

        return to_route('bank.requestProcessing');
    }

    public function requestProcessing()
    {
        $bankImg = asset('images/bank-transfer.png');
        return Inertia::render('Tokens/BankTransferProcessing', compact('bankImg'));
    }
}
