import React from "react";
import Front from "@/Layouts/Front";
import { Head, usePage } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";

export default function Page({ page }) {
    const { currency_symbol, currency_code } = usePage().props;
    return (
        <Front>
            <Head title={page.page_title} />

            <div className="p-4 sm:p-8 bg-white max-w-3xl mx-auto dark:bg-zinc-900 shadow sm:rounded-lg">
                <h3 className="text-2xl font-semibold dark:text-white text-center border-b pb-5 mb-5">
                    {page.page_title}
                </h3>

                <div
                    className="static-page dark:text-white"
                    dangerouslySetInnerHTML={{
                        __html: page.page_content,
                    }}
                />
            </div>
        </Front>
    );
}
