import React from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, usePage } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";
import { MdGeneratingTokens } from "react-icons/md";
import { Inertia } from "@inertiajs/inertia";

export default function SelectGateway({
    auth,
    tokenPack,
    paypalEnabled,
    stripeEnabled,
    bankEnabled,
    ccbillEnabled,
    paypalImg,
    ccbillImg,
    stripeImg,
    bankImg,
}) {
    const { currency_symbol, currency_code } = usePage().props;
    return (
        <AuthenticatedLayout auth={auth}>
            <Head title={__("Select Gateway - Purchase Tokens")} />

            <div className="p-4 sm:p-8 bg-white max-w-3xl mx-auto dark:bg-zinc-900 shadow sm:rounded-lg">
                <h3 className="text-3xl font-semibold dark:text-white text-center">
                    {__("Select Payment Gateway")}
                </h3>

                <h3 className="mt-5 text-2xl font-semibold dark:text-white text-center">
                    {__(
                        "You are purchasing :tokensAmount tokens for :moneyAmount",
                        {
                            tokensAmount: tokenPack.tokensFormatted,
                            moneyAmount: `${currency_symbol}${tokenPack.price}`,
                        }
                    )}
                </h3>

                <div className="mt-10 flex items-center justify-center flex-col space-y-5">
                    <div>
                        <span className="block text-center text-gray-700 font-bold dark:text-white text-lg">
                            {__("Pay via PayPal")}
                        </span>
                        {paypalEnabled == "Yes" && (
                            <Link
                                href={route("paypal.purchaseTokens", {
                                    tokenPack: tokenPack.id,
                                })}
                            >
                                <img
                                    src={paypalImg}
                                    alt="paypal"
                                    className="h-24 mx-auto"
                                />
                            </Link>
                        )}
                    </div>
                    {stripeEnabled == "Yes" && (
                        <div>
                            <span className="block text-center mb-3 text-gray-700 font-bold dark:text-white text-lg">
                                {__("Credit Card (Stripe)")}
                            </span>
                            <Link
                                href={route("stripe.purchaseTokens", {
                                    tokenPack: tokenPack.id,
                                })}
                            >
                                <img
                                    src={stripeImg}
                                    alt="stripe"
                                    className="h-14 mx-auto"
                                />
                            </Link>
                        </div>
                    )}
                    {ccbillEnabled == "Yes" && (
                        <div className="pt-5">
                            <span className="block text-center text-gray-700 font-bold dark:text-white text-lg">
                                {__("CCBill (Credit Card)")}
                            </span>
                            <a
                                href={route("ccbill.purchaseTokens", {
                                    tokenPack: tokenPack.id,
                                })}
                            >
                                <img
                                    src={ccbillImg}
                                    alt="stripe"
                                    className="h-14 mx-auto"
                                />
                            </a>
                        </div>
                    )}
                    {bankEnabled == "Yes" && (
                        <div className="mt-10">
                            <span className="block text-center text-gray-700 font-bold dark:text-white text-lg">
                                {__("Pay via Bank Transfer")}
                            </span>
                            <Link
                                href={route("bank.purchaseTokens", {
                                    tokenPack: tokenPack.id,
                                })}
                            >
                                <img
                                    src={bankImg}
                                    alt="stripe"
                                    className="h-14 mx-auto"
                                />
                            </Link>
                        </div>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
