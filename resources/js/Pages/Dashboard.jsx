import React from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/inertia-react";
import __ from "../Functions/Translate";

export default function Dashboard(props) {
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {__("Dashboard")}
                </h2>
            }
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="px-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            {__("You're logged in!")}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
