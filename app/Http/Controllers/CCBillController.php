<?php

namespace App\Http\Controllers;

use App\Models\TokenPack;
use App\Models\TokenSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CCBillController extends Controller
{
    // auth
    public function purchase(TokenPack $tokenPack, Request $request)
    {
        // make amount a decimal
        $amount = number_format($tokenPack->price, 2);

        // set ccbill currency codes
        $ccbillCurrencyCodes = [];
        $ccbillCurrencyCodes["USD"] = 840;
        $ccbillCurrencyCodes["EUR"] = 978;
        $ccbillCurrencyCodes["AUD"] = 036;
        $ccbillCurrencyCodes["CAD"] = 124;
        $ccbillCurrencyCodes["GBP"] = 826;
        $ccbillCurrencyCodes["JPY"] = 392;

        // get site currencies
        $siteCurrency = strtoupper(opt('payment-settings.currency_code', 'USD'));

        // do we have this site currency on CCBill as well? if not, default to USD
        if (isset($ccbillCurrencyCodes[$siteCurrency])) {
            $currencyCode = $ccbillCurrencyCodes[$siteCurrency];
        } else {
            $currencyCode = 840;
        }

        // get salt
        $salt = opt('CCBILL_SALT_KEY');

        // set initial period
        $initialPeriod = 365;

        // generate hash: formPrice, formPeriod, currencyCode, salt
        $hash = md5($amount . $initialPeriod . $currencyCode . $salt);

        $sale = TokenSale::create([
            'user_id' => $request->user()->id,
            'tokens' => $tokenPack->tokens,
            'amount' => $tokenPack->price,
            'status' => 'pending',
            'gateway' => 'Credit Card (CCBill)'
        ]);

        // redirect to CCBill payment
        $ccBillParams['clientAccnum'] = opt('CCBILL_ACC_NO');
        $ccBillParams['clientSubacc'] = opt('CCBILL_SUBACC_NO');
        $ccBillParams['currencyCode'] = $currencyCode;
        $ccBillParams['formDigest'] = $hash;
        $ccBillParams['initialPrice'] = $amount;
        $ccBillParams['initialPeriod'] = $initialPeriod;
        $ccBillParams['sale'] = $sale->id;

        // set form id
        $formId = opt('CCBILL_FLEX_FORM_ID');

        // set base url for CCBill Gateway
        $baseURL = 'https://api.ccbill.com/wap-frontflex/flexforms/' . $formId;

        // build redirect url to CCbill Pay
        $urlParams = http_build_query($ccBillParams);
        $redirectUrl = $baseURL . '?' . $urlParams;

        return redirect($redirectUrl);
    }

    // handle CCBill webhooks
    public function webhooks(Request $r)
    {
        // validate event type
        $this->validate($r, [
            'eventType' => 'required',
            'eventGroupType' => 'required',
            'subscriptionId' => 'required',
            'subscriptionInitialPrice' => 'required',
            'dynamicPricingValidationDigest' => 'required',
            'X-sale' => 'required|numeric|exists:token_sales,id'
         ]);

        // set ccbill currency codes
        $ccbillCurrencyCodes = [];
        $ccbillCurrencyCodes["USD"] = 840;
        $ccbillCurrencyCodes["EUR"] = 978;
        $ccbillCurrencyCodes["AUD"] = 036;
        $ccbillCurrencyCodes["CAD"] = 124;
        $ccbillCurrencyCodes["GBP"] = 826;
        $ccbillCurrencyCodes["JPY"] = 392;

        // set amount
        $amount = $r->subscriptionInitialPrice;

        // get the hash
        $digest = $r->dynamicPricingValidationDigest;

        // get site currencies
        $siteCurrency = strtoupper(opt('payment-settings.currency_code', 'USD'));

        // do we have this site currency on CCBill as well? if not, default to USD
        if (isset($ccbillCurrencyCodes[$siteCurrency])) {
            $currencyCode = $ccbillCurrencyCodes[$siteCurrency];
        } else {
            $currencyCode = 840;
        }

        // get salt
        $salt = opt('CCBILL_SALT_KEY');

        // set initial period
        $initialPeriod = 365;

        // generate hash: formPrice, formPeriod, currencyCode, salt
        $hash = md5($amount . $initialPeriod . $currencyCode . $salt);

        // validate the hash
        if ($hash != $digest) {
            Log::info('CCBILL WEBHOOKS HASH MISMATCH:');
            Log::info('RECEIVED HASH: ' . $digest);
            Log::info('OUR HASH: ' . $hash);
            Log::info('FULL REQUEST BELOW');
            Log::info($r->all());

            // stop here.
            return response('HASH MISMATCH, TRANSACTION REJECTED');
        }


        // get event type
        switch($r->eventType) {
            case 'NewSaleSuccess':

                // find token sale
                $tokenSale = TokenSale::findOrFail($r->{"X-sale"});

                if ($tokenSale->status != 'paid') {
                    $tokenSale->status = 'paid';
                    $tokenSale->save();

                    // increase user balance
                    $tokenSale->user->increment('tokens', $tokenSale->tokens);
                }

                break;
        }


        return response('CCBill WebHook Handled');
    }
}
