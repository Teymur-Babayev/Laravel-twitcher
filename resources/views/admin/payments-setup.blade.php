@extends('admin.base')

@section('section_title')
<strong>{{ __('Payments Configuration') }}</strong>
@endsection

@section('section_body')

@include('admin.configuration-navi')

<div class="bg-white rounded p-3 text-stone-600">
	<form method="POST">
		@csrf

		<div class="flex flex-col md:flex-row md:justify-between">
			<div class="my-5 md:w-1/3 w-full">
				<label class="font-semibold text-stone-600 block">{{ __('Streamer Token Value') }}</label>
				<small class="text-xs">{{ __("When streamers request withdrawing, tokens will be converted to Money
					using the
					multiplier you set below. Example: 100 tokens * 0.75 = $75") }}</small>
				<x-input type="text" name="token_value" value="{{ opt('token_value') }}" class="w-full" />

				<label class="mt-3 font-semibold text-stone-600 block">{{ __('Min. Withdraw (Tokens)') }}</label>
				<x-input type="text" name="min_withdraw" value="{{ opt('min_withdraw') }}" class="w-full" />

				<label class="mt-3 font-semibold text-stone-600 block">{{ __('Currency Symbol') }}</label>
				<x-input type="text" name="payment-settings.currency_symbol"
					value="{{ opt('payment-settings.currency_symbol') }}" class="w-full" />

				<label class="mt-3 font-semibold text-stone-600 block">{{ __('Currency Code') }}
					<a target="_blank" href="https://www.xe.com/iso4217.php"
						class="text-sm text-cyan-600 hover:underline">https://www.xe.com/iso4217.php</a>
				</label>
				<x-input type="text" name="payment-settings.currency_code"
					value="{{ opt('payment-settings.currency_code') }}" class="w-full" />

			</div>

			<div class="my-5 md:w-1/3 w-full md:pr-10">
				<label class="mt-3 font-semibold text-stone-600 block">{{ __('Enable PayPal Payments?') }}</label>
				<x-select name="paypalEnable" class="md:w-1/4 w-full">
					<option value="Yes" @if(opt('paypalEnable', 'No' )=='Yes' ) selected @endif>
						{{ __("Yes") }}
					</option>
					<option value="No" @if(opt('paypalEnable', 'No' )=='No' ) selected @endif>
						{{ __("No") }}
					</option>
				</x-select>

				<label class="font-semibold mt-3 block text-stone-600">{{ __('PayPal Email') }}</label>
				<x-input type="text" name="paypal_email" value="{{ opt('paypal_email') }}" class="w-full" />

				<label class="mt-5 font-semibold text-stone-600 block">{{ __('Enable Bank Transfer?') }}</label>
				<x-select name="bankEnable" class="md:w-1/4 w-full">
					<option value="Yes" @if(opt('bankEnable', 'No' )=='Yes' ) selected @endif>
						{{ __("Yes") }}
					</option>
					<option value="No" @if(opt('bankEnable', 'No' )=='No' ) selected @endif>
						{{ __("No") }}
					</option>
				</x-select>

				<label class="font-semibold mt-3 block text-stone-600">{{ __('Bank Transfer Instructions') }}</label>
				<x-textarea row="6" name="bankInstructions" class="w-full">{{ opt('bankInstructions')
					}}</x-textarea>
			</div>
		</div>

		<hr class="my-5" />

		<div class="flex md:justify-between flex-col md:flex-row">
			<div class="my-5 md:w-1/3 w-full">
				<label class="font-semibold text-stone-600 block">{{ __('Enable Stripe?') }}</label>
				<x-select name="stripeEnable" class="md:w-1/4 w-full">
					<option value="Yes" @if(opt('stripeEnable', 'No' )=='Yes' ) selected @endif>
						{{ __("Yes") }}
					</option>
					<option value="No" @if(opt('stripeEnable', 'No' )=='No' ) selected @endif>
						{{ __("No") }}
					</option>
				</x-select>

				<label class="font-semibold mt-3 block text-stone-600">{{ __('Stripe Public Key') }}</label>
				<x-input type="text" name="STRIPE_PUBLIC_KEY" value="{{ opt('STRIPE_PUBLIC_KEY') }}" class="w-full" />

				<label class="font-semibold mt-3 block text-stone-600">{{ __('Stripe Secret Key') }}</label>
				<x-input type="text" name="STRIPE_SECRET_KEY" value="{{ opt('STRIPE_SECRET_KEY') }}" class="w-full" />
			</div>

			<hr class="my-5" />

			<div class="my-5 md:w-1/3 w-full md:pr-10">
				<label class="font-semibold text-stone-600 block">{{ __('Enable CCBill?') }}</label>
				<x-select name="ccbillEnable" class="md:w-1/4 w-full">
					<option value="Yes" @if(opt('ccbillEnable', 'No' )=='Yes' ) selected @endif>
						{{ __("Yes") }}
					</option>
					<option value="No" @if(opt('ccbillEnable', 'No' )=='No' ) selected @endif>
						{{ __("No") }}
					</option>
				</x-select>

				<label class="font-semibold mt-3 block text-stone-600">{{ __('CCBill Account Number') }}</label>
				<x-input type="text" name="CCBILL_ACC_NO" value="{{ opt('CCBILL_ACC_NO') }}" class="w-full" />

				<label class="font-semibold mt-3 block text-stone-600">{{ __('CCBill Subaccount Number') }}</label>
				<x-input type="text" name="CCBILL_SUBACC_NO" value="{{ opt('CCBILL_SUBACC_NO') }}" class="w-full" />

				<label class="font-semibold mt-3 block text-stone-600">{{ __('CCBill Salt Key') }}</label>
				<x-input type="text" name="CCBILL_SALT_KEY" value="{{ opt('CCBILL_SALT_KEY') }}" class="w-full" />

				<label class="font-semibold mt-3 block text-stone-600">{{ __('CCBill Flex Form ID') }}</label>
				<x-input type="text" name="CCBILL_FLEX_FORM_ID" value="{{ opt('CCBILL_FLEX_FORM_ID') }}"
					class="w-full" />
			</div>
		</div>

		<hr class="my-5" />

		<div class="flex w-full my-5">
			<x-button>{{ __('Save Settings') }}</x-button>
		</div>
	</form>


</div><!-- ./row -->
@endsection