import React, { useEffect } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, usePage } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";
import { HiIdentification } from "react-icons/hi";

export default function StreamerVerification() {
    const { auth } = usePage().props;

    return (
        <AuthenticatedLayout auth={auth}>
            <Head title={__("Pending Verification")} />

            <div className="ml-0">
                <div className="p-4 sm:p-8 bg-gray-100 dark:bg-zinc-900 dark:text-white shadow sm:rounded-lg">
                    <div className="flex items-center">
                        <div>
                            <HiIdentification className="h-12 w-12 mr-2" />
                        </div>
                        <div>
                            <h2 className="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                {__("Pending Verification")}
                            </h2>
                        </div>
                    </div>
                    <p className="dark:text-white text-lg">
                        {__(
                            "We have received your identity verification request and will analyse it as soon as possible."
                        )}
                    </p>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
