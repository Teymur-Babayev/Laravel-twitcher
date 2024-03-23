import React, { useEffect } from "react";
import { Link, Head, usePage } from "@inertiajs/inertia-react";
import Front from "@/Layouts/Front";
import __ from "@/Functions/Translate";
import { toast } from "react-toastify";

export default function Signup({ props }) {
    const influencerIcon = "/images/streamer-icon.png";
    const userIcon = "/images/user-signup-icon.png";

    const { flash } = usePage().props;

    useEffect(() => {
        if (flash?.message) {
            toast(flash.message);
        }
    }, [flash]);

    return (
        <Front>
            <div className="bg-white mx-auto dark:bg-zinc-900 rounded-lg shadow py-5 max-w-5xl text-center">
                <h2 className="text-3xl text-gray-600 dark:text-zinc-200 font-semibold text-center">
                    {__("Join Our Platform")}
                </h2>
                <p className="text-center mb-8 text-xl text-gray-600 dark:text-zinc-200 mt-1">
                    {__(
                        "We are welcoming both streamers and users to our platform to get connected to each other."
                    )}
                </p>
                <div className="grid grid-cols-2 mt-10 gap-2">
                    <div className="col text-center">
                        <Link href={route("streamer.signup")}>
                            <img
                                src={influencerIcon}
                                alt=""
                                className="max-h-96 rounded-full mx-auto border-zinc-200 dark:border-indigo-200 border-4"
                            />
                        </Link>
                        <Link
                            href={route("streamer.signup")}
                            className="bg-pink-600  text-white font-bold py-2 px-4 rounded mb-4 hover:bg-pink-500 mt-5 inline-block"
                        >
                            {__("I'm a Streamer")}
                        </Link>
                    </div>
                    <div className="col text-center">
                        <Link href={route("register")}>
                            <img
                                src={userIcon}
                                alt=""
                                className="max-h-96 rounded-full mx-auto border-zinc-200  dark:border-indigo-200 border-4"
                            />
                        </Link>
                        <Link
                            href={route("register")}
                            className="bg-indigo-700 inline-block mt-5 text-white font-bold py-2 px-4 rounded mb-4 hover:bg-indigo-600"
                        >
                            {__("I am an User")}
                        </Link>
                    </div>
                </div>
            </div>
        </Front>
    );
}
