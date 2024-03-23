import React, { useEffect, useState } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, usePage, useForm } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";
import { Elements } from "@stripe/react-stripe-js";
import { loadStripe } from "@stripe/stripe-js";
import PrimaryButton from "@/Components/PrimaryButton";
import {
    useStripe,
    useElements,
    PaymentElement,
} from "@stripe/react-stripe-js";
import { toast } from "react-toastify";

const CheckoutForm = ({ saleId }) => {
    const stripe = useStripe();
    const elements = useElements();

    const handleSubmit = async (event) => {
        event.preventDefault();

        if (!stripe || !elements) {
            // Stripe.js has not yet loaded.
            return;
        }

        const result = await stripe.confirmPayment({
            //`Elements` instance that was used to create the Payment Element
            elements,
            confirmParams: {
                return_url: route("stripe.processOrder", { tokenSale: saleId }),
            },
        });

        if (result.error) {
            // Show error to your customer (for example, payment details incomplete)
            toast.error(result.error.message);
        } else {
        }
    };
    return (
        <form onSubmit={handleSubmit}>
            <PaymentElement />
            <PrimaryButton className="mt-5" processing={!stripe}>
                {__("Submit Payment")}
            </PrimaryButton>
        </form>
    );
};

export default function BankTransfer({
    auth,
    tokenPack,
    stripeImg,
    publicKey,
    cs,
    saleId,
}) {
    const { currency_symbol, currency_code } = usePage().props;

    const stripePromise = loadStripe(publicKey);

    const options = {
        clientSecret: cs,
        appearance: {
            theme:
                localStorage.getItem("is-dark-mode") === "yes" ? "night" : "",
            labels: "floating",
        },
    };

    return (
        <AuthenticatedLayout auth={auth}>
            <Head title={__("Credit Card (Stripe)")} />

            <div className="p-4 sm:p-8 bg-white max-w-3xl mx-auto dark:bg-zinc-900 shadow sm:rounded-lg">
                <div className="flex justify-center items-center">
                    <div>
                        <h3 className="text-3xl font-semibold dark:text-white text-center">
                            {__("Credit Card")}
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

                <hr className="my-10" />
                <Elements stripe={stripePromise} options={options}>
                    <CheckoutForm saleId={saleId} />
                </Elements>
            </div>
        </AuthenticatedLayout>
    );
}
