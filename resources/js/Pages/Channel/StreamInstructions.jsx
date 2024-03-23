import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import Textarea from "@/Components/Textarea";
import __ from "@/Functions/Translate";
import { usePage } from "@inertiajs/inertia-react";
import { useState } from "react";

export default function StreamInstructions({ streamKey, streamUser }) {
    const { auth, rtmp_url } = usePage().props;
    const [tab, setTab] = useState("desktop");

    if (auth?.user?.username !== streamUser) {
        return __("User offline!");
    }

    return (
        <div className="bg-white dark:bg-zinc-900 mr-10 p-5">
            <div className="my-5">
                <button
                    onClick={(e) => setTab("desktop")}
                    className={`text-xl font-bold hover:text-indigo-800 dark:hover:text-indigo-600 ${
                        tab === "desktop"
                            ? "text-indigo-700 dark:text-indigo-500 underline"
                            : "text-gray-700 dark:text-white"
                    }`}
                >
                    {__("Desktop Instructions")}
                </button>
                <button
                    onClick={(e) => setTab("mobile")}
                    className={`ml-3 text-xl font-bold hover:text-indigo-800 dark:hover:text-indigo-600 ${
                        tab === "mobile"
                            ? "text-indigo-700 dark:text-indigo-500 underline"
                            : "text-gray-700 dark:text-white"
                    }`}
                >
                    {__("Mobile Instructions")}
                </button>
            </div>

            <h2 className="text-2xl pb-2 mt-5 border-b dark:border-b-zinc-800 font-semibold dark:text-white text-gray-700">
                {__("RTMP Server URL")}
            </h2>
            <TextInput
                className="text-xl mt-3 w-full"
                value={
                    tab === "desktop" ? rtmp_url : `${rtmp_url}/${streamKey}`
                }
            />

            {tab == "desktop" ? (
                <>
                    <h2 className="text-xl pb-2 mt-5 border-b dark:border-b-zinc-800 font-semibold dark:text-white text-gray-700">
                        {__("RTMP Streaming Key")}
                    </h2>
                    <Textarea className="text-xl w-full" value={streamKey} />

                    <h2 className="mt-5 text-2xl pb-2 border-b dark:border-b-zinc-800 font-semibold dark:text-white text-gray-700">
                        {__("Download OBS - Open Broadcaster Software")}
                    </h2>
                    <a
                        className="flex dark:text-white text-xl hover:underline"
                        target="blank"
                        href="https://obsproject.com/"
                    >
                        https://obsproject.com
                    </a>

                    <h2 className="text-2xl pb-2 mt-5 border-b dark:border-b-zinc-800 font-semibold dark:text-white text-gray-700">
                        {__("Go to OBS->Settings->Stream")}
                    </h2>

                    <img src="/images/obs.png" alt="obs.png" />

                    <h2 className="text-2xl pb-2 mt-5 border-b dark:border-b-zinc-800 font-semibold dark:text-white text-gray-700">
                        {__("Happy Streaming!")}
                    </h2>
                </>
            ) : (
                <>
                    <h2 className="text-2xl pb-2 mt-5 border-b dark:border-b-zinc-800 font-semibold dark:text-white text-gray-700">
                        {__(
                            "Get a Mobile RTMP Ingesting App (ex. Larix Broadcaster)"
                        )}
                    </h2>

                    <a
                        className="flex my-5 dark:text-white text-xl hover:underline"
                        target="blank"
                        href="https://apps.apple.com/us/app/larix-broadcaster/id1042474385"
                    >
                        Larix Broadcaster iOS
                    </a>

                    <a
                        className="flex my-5 dark:text-white text-xl hover:underline"
                        target="blank"
                        href="https://play.google.com/store/apps/details?id=com.wmspanel.larix_broadcaster&hl=en&gl=US&pli=1"
                    >
                        Larix Broadcaster Android
                    </a>

                    <p className="dark:text-white text-gray-700">
                        {__(
                            "Click Settings Cog -> Connections -> New Connection"
                        )}
                    </p>

                    <a
                        href="https://www.youtube.com/watch?v=Dhj0_QbtfTw&t=24s"
                        target="_blank"
                    >
                        <img src="/images/larix.jpeg" alt="larix app" />
                    </a>
                </>
            )}
        </div>
    );
}
