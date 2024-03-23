import React from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";
import ChannelForm from "./Partials/ChannelForm";
import SetSchedule from "./Partials/SetSchedule";
import AccountNavi from "./Partials/AccountNavi";

export default function Settings({ auth, mustVerifyEmail, status }) {
    return (
        <AuthenticatedLayout auth={auth}>
            <Head title={__("Channel Settings")} />

            <div className="lg:flex lg:space-x-10 w-full">
                <AccountNavi active={"channel-settings"} />

                <div className="p-4 sm:p-8 bg-white dark:bg-zinc-900 shadow sm:rounded-lg">
                    <ChannelForm
                        mustVerifyEmail={mustVerifyEmail}
                        status={status}
                        className="max-w-xl"
                    />

                    <SetSchedule />
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
