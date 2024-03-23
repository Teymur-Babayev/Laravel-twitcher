import React, { useEffect, useRef } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, usePage, useForm } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";
import Spinner from "@/Components/Spinner";

export default function Paypal({
    auth,
    tokenPack,
    paypalEmail,
    paypalUrl,
    sale,
}) {
    const { currency_symbol, currency_code } = usePage().props;

    const form = useRef(0);

    useEffect(() => {
        submit();
    }, []);

    const submit = (e) => {
        form.current.submit();
    };

    return (
        <AuthenticatedLayout auth={auth}>
            <Head title={__("PayPal - Purchase Tokens")} />

            <div className="p-4 sm:p-8 bg-white max-w-3xl mx-auto dark:bg-zinc-900 shadow sm:rounded-lg">
                <div className="flex justify-center items-center">
                    <div className="mr-2">
                        <Spinner />
                    </div>
                    <div>
                        <h3 className="text-3xl font-semibold dark:text-white text-center">
                            {__("PayPal")}
                        </h3>
                    </div>
                </div>

                <h3 className="mt-5 text-2xl font-semibold dark:text-white text-center">
                    {__(
                        "You are purchasing :tokensAmount tokens for :moneyAmount",
                        {
                            tokensAmount: tokenPack.tokensFormatted,
                            moneyAmount: `${currency_symbol}${tokenPack.price}`,
                        }
                    )}
                </h3>

                <div className="mx-auto justify-center text-center"></div>

                <div className="mt-5 justify-center mx-auto text-center">
                    <form action={paypalUrl} method="POST" ref={form}>
                        <input
                            type="hidden"
                            name="business"
                            value={paypalEmail}
                        />
                        <input
                            type="hidden"
                            name="return"
                            value={route("paypal.redirect-to-processing")}
                        />
                        <input
                            type="hidden"
                            name="cancel_return"
                            value={route("token.packages")}
                        />
                        <input
                            type="hidden"
                            name="notify_url"
                            value={route("paypal.ipn")}
                        />
                        <input
                            type="hidden"
                            name="currency_code"
                            value={currency_code}
                        />
                        <input
                            type="hidden"
                            name="amount"
                            value={sale.amount}
                        />
                        <input
                            type="hidden"
                            name="item_name"
                            value={`${sale.tokens} tokens`}
                        />
                        <input type="hidden" name="custom" value={sale.id} />
                        <input type="hidden" name="cmd" value="_xclick" />
                        <input type="hidden" name="rm" value="2" />
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
