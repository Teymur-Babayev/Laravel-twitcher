import __ from "@/Functions/Translate";
import Front from "@/Layouts/Front";
import { Head } from "@inertiajs/inertia-react";
import { FaBan } from "react-icons/fa";

export default function Subscribe({ streamUser }) {

    return (
        <Front>
            {/* STREAMING CENTER CONTENTS */}
            <div className="max-w-xl mx-auto">
                <Head
                    title={__("Banned from :channelName's channel (:handle)", {
                        channelName: streamUser.name,
                        handle: `@${streamUser.username}`,
                    })}
                />

                <div className="bg-white dark:bg-zinc-900 dark:text-white shadow sm:rounded-lg p-4 sm:p-8">
                    <FaBan className="h-36 w-36 mx-auto mb-4 text-rose-600" />
                    <div className="flex mx-auto items-center">
                        <img src={streamUser.profile_picture} className="rounded-full w-20 border-2 border-indigo-100" />
                        <h2 className="text-2xl text-center font-semibold text-gray-900 dark:text-gray-100">
                            {__("You have been banned from :handle's live", {
                                channelName: streamUser.name,
                                handle: `@${streamUser.username}`,
                            })}
                        </h2>
                    </div>
                </div>
            </div>
        </Front>
    );
}
