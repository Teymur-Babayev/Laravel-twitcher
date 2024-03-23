import __ from "@/Functions/Translate";
import { Link, Head, usePage } from "@inertiajs/inertia-react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import {
    MdGeneratingTokens,
    MdOutlineAccountBalanceWallet,
} from "react-icons/md";
import { useState } from "react";
import { Inertia } from "@inertiajs/inertia";
import Spinner from "@/Components/Spinner";

export default function Subscribe({ video }) {
    const { auth } = usePage().props;

    const [processing, setProcessing] = useState(false);

    const confirmPurchase = (e) => {
        e.preventDefault();

        Inertia.visit(
            route("video.purchase", {
                video: video.id,
            }),
            {
                method: "POST",
                onBefore: (visit) => {
                    setProcessing(true);
                },
                onFinish: (visit) => {
                    setProcessing(false);
                },
            }
        );
    };

    return (
        <AuthenticatedLayout>
            <Head
                title={__("Unlock Video: :videoTitle", {
                    video: video.title,
                })}
            />

            <div className="ml-0">
                <div className="p-4 sm:p-8 bg-gray-100 dark:bg-zinc-900 shadow sm:rounded-lg">
                    <header>
                        <div className="justify-center flex items-center space-x-2 flex-wrap">
                            <div>
                                <Link
                                    href={route("channel", {
                                        user: video.streamer.username,
                                    })}
                                >
                                    <img
                                        src={video.streamer.profile_picture}
                                        alt=""
                                        className="rounded-full h-14 border-zinc-200 dark:border-indigo-200 border"
                                    />
                                </Link>
                            </div>
                            <div>
                                <Link
                                    href={route("channel", {
                                        user: video.streamer.username,
                                    })}
                                >
                                    <h2 className="text-center text-2xl font-medium text-gray-800 dark:text-gray-100">
                                        {__("Unlock :videoTitle", {
                                            videoTitle: video.title,
                                        })}
                                    </h2>
                                </Link>
                                <p className="mt-1 text-sm text-gray-600 dark:text-gray-400 text-center">
                                    {__("Confirm your purchase")}
                                </p>
                            </div>
                        </div>
                    </header>

                    <div className="border-t pt-5 text-xl text-center font-light mt-8 dark:text-white">
                        <p className="bg-white shadow text-gray-800 font-semibold inline-flex rounded-lg p-2">
                            <MdGeneratingTokens className="h-6 w-6" />{" "}
                            {__("Price: :price tokens", { price: video.price })}
                        </p>
                        <br />
                        <p className="mt-3 bg-white shadow text-gray-800 text-sm font-semibold inline-flex rounded-lg p-2">
                            {" "}
                            <MdOutlineAccountBalanceWallet className="w-4 h-4" />{" "}
                            {__("Your Balance: :userBalance tokens", {
                                userBalance: auth.user.tokens,
                            })}
                        </p>

                        <div className="mt-5 border-t pt-5">
                            {video.price <= auth.user.tokens ? (
                                <>
                                    <button
                                        onClick={(e) => confirmPurchase(e)}
                                        className="py-2 px-3 mt-2 mb-3 inline-flex rounded-md items-center bg-pink-500 text-white font-semibold hover:bg-pink-600 disabled:bg-gray-300 disabled:text-gray-700"
                                        disabled={processing}
                                    >
                                        <MdGeneratingTokens className="h-6 w-6 mr-2" />
                                        <div>{__("Purchase Video")}</div>
                                    </button>
                                    <br />
                                    {processing && (
                                        <center>
                                            <Spinner />
                                        </center>
                                    )}
                                </>
                            ) : (
                                <div className="text-gray-700 dark:text-white text-base">
                                    {__(
                                        "You need to charge your token balance to be able to unlock this video"
                                    )}
                                    <br />
                                    <Link
                                        href={route("token.packages")}
                                        className="py-1.5 px-3 mt-2 inline-flex border-2 rounded-md hover:border-gray-700 hover:text-gray-700 items-center border-indigo-600 text-indigo-600 dark:border-white dark:text-white dark:hover:border-indigo-200 dark:hover:text-indigo-200"
                                    >
                                        <MdGeneratingTokens className="h-6 w-6 mr-2" />
                                        <div>{__("Token Packages")}</div>
                                    </Link>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
