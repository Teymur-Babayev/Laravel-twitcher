import React from "react";
import { Head } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";
import Front from "@/Layouts/Front";

export default function BankTransferProcessing({ bankImg }) {
    return (
        <Front>
            <Head title={__("Bank Transfer - Request Processing")} />

            <div className="p-4 sm:p-8 bg-white max-w-3xl mx-auto dark:bg-zinc-900 shadow sm:rounded-lg">
                <div className="flex justify-center items-center">
                    <div className="mr-2">
                        <img src={bankImg} alt="bank img" className="h-14" />
                    </div>
                    <div>
                        <h3 className="text-3xl font-semibold dark:text-white text-center">
                            {__("Bank Transfer - Request Processing")}
                        </h3>
                    </div>
                </div>

                <h3 className="mt-10 text-xl dark:text-white text-center">
                    {__(
                        "Your request has been sent and is processing. Once the platform admin verifies your payment your balance will be adjusted accordingly."
                    )}
                </h3>
            </div>
        </Front>
    );
}
