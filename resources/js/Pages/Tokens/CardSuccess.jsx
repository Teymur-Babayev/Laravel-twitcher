import React from "react";
import { Head } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";
import Front from "@/Layouts/Front";
import { BsFillBagCheckFill } from "react-icons/bs";

export default function CardSuccess({ sale }) {
    return (
        <Front>
            <Head title={__("Payment Successful - Thank you")} />

            <div className="p-4 sm:p-8 bg-white max-w-3xl mx-auto dark:bg-zinc-900 shadow sm:rounded-lg">
                <div className="flex justify-center items-center">
                    <div className="mr-2">
                        <BsFillBagCheckFill />
                    </div>
                    <div>
                        <h3 className="text-3xl font-semibold dark:text-white text-center">
                            {__("Thank you for your payment")}
                        </h3>
                    </div>
                </div>

                <h3 className="mt-10 text-xl dark:text-white text-center">
                    {__(
                        "Thank you for your payment! :tokens tokens have been added to your balance!",
                        { tokens: sale.tokens }
                    )}
                </h3>
            </div>
        </Front>
    );
}
