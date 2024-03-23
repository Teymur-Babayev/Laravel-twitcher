import React from "react";
import { Head } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";
import Front from "@/Layouts/Front";

export default function PayPalProcessing({ paypalImg }) {
    return (
        <Front>
            <Head title={__("PayPal - Payment Processing")} />

            <div className="p-4 sm:p-8 bg-gray-100 dark:bg-zinc-900 shadow sm:rounded-lg">
                <div className="flex justify-center items-center">
                    <div className="mr-2">
                        <img src={paypalImg} alt="bank img" className="h-14" />
                    </div>
                    <div>
                        <h3 className="text-3xl font-semibold dark:text-white text-center">
                            {__("PayPal Payment - Processing")}
                        </h3>
                    </div>
                </div>

                <h3 className="mt-10 text-xl dark:text-white text-center">
                    {__(
                        "Your payment is processing. If the payment succeeeds, your balance will be adjusted accordingly within a few minutes."
                    )}
                </h3>
            </div>
        </Front>
    );
}
