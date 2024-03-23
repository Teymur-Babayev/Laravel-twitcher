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

export default function Subscribe({ channel, tier }) {
    const { auth } = usePage().props;

    const [plan, setPlan] = useState("Monthly");
    const [showPrice, setShowPrice] = useState(tier.price);
    const [processing, setProcessing] = useState(false);

    const updatePlan = (plan) => {
        setPlan(plan);

        switch (plan) {
            case "6 Months":
                console.log(
                    `Setting plan to ${plan} and price to ${tier.SixMonthsPrice}`
                );
                setShowPrice(tier.SixMonthsPrice);
                break;
            case "Monthly":
                console.log(
                    `Setting plan to ${plan} and price to ${tier.price}`
                );
                setShowPrice(tier.price);
                break;
            case "Yearly":
                console.log(
                    `Setting plan to ${plan} and price to ${tier.YearlyPrice}`
                );
                setShowPrice(tier.YearlyPrice);
                break;
        }
    };

    const confirmSubscription = (e) => {
        e.preventDefault();

        Inertia.visit(
            route("confirm-subscription", {
                user: channel.id,
                tier: tier.id,
                plan: plan,
            }),
            {
                onBefore: (visit) => {
                    setProcessing(true);
                },
                onFinish: (visit) => {
                    setProcessing(false);
                },
            }
        );

        // console.log(
        //     `Would subscribe to ${channel.id} => for plan ${plan} on tier ${tier.id}`
        // );
    };

    return (
        <AuthenticatedLayout>
            <Head
                title={__("Subscribe to :channel", {
                    channel: channel.username,
                })}
            />

            <div className="ml-0">
                <div className="p-4 sm:p-8 bg-gray-100 dark:bg-zinc-900 shadow sm:rounded-lg">
                    <header>
                        <div className="justify-center flex items-center space-x-2 flex-wrap">
                            <div>
                                <Link
                                    href={route("channel", {
                                        user: channel.username,
                                    })}
                                >
                                    <img
                                        src={channel.profile_picture}
                                        alt=""
                                        className="rounded-full h-14 border-zinc-200 dark:border-indigo-200 border"
                                    />
                                </Link>
                            </div>
                            <div>
                                <Link
                                    href={route("channel", {
                                        user: channel.username,
                                    })}
                                >
                                    <h2 className="text-center text-2xl font-medium text-gray-800 dark:text-gray-100">
                                        {__("Subscribe to @:channel", {
                                            channel: channel.username,
                                        })}
                                    </h2>
                                </Link>
                                <p className="mt-1 text-sm text-gray-600 dark:text-gray-400 text-center">
                                    {__(
                                        "Select subscription length & payment method"
                                    )}
                                </p>
                            </div>
                        </div>

                        <div className="flex flex-col md:flex-row md:justify-around items-center mt-10 space-y-5 md:space-y-0">
                            <button
                                onClick={(e) => updatePlan("6 Months")}
                                className={`relative w-52 rounded-lg p-3 shadow ${
                                    plan === "6 Months"
                                        ? "bg-indigo-600 text-white"
                                        : "bg-white text-gray-800"
                                }`}
                            >
                                <div className="absolute inline-flex items-center justify-center px-1.5 py-1 text-xs font-bold text-white bg-pink-500 rounded-full -top-2 right-0">
                                    {__(":discount% OFF", {
                                        discount: tier.six_months_discount,
                                    })}
                                </div>
                                {__("6 Months")}
                            </button>
                            <button
                                onClick={(e) => updatePlan("Monthly")}
                                className={`w-52 rounded-lg p-3 shadow ${
                                    plan === "Monthly"
                                        ? "bg-indigo-600 text-white"
                                        : "bg-white text-gray-800"
                                }`}
                            >
                                {__("1 Month")}
                            </button>
                            <button
                                onClick={(e) => updatePlan("Yearly")}
                                className={`relative w-52 rounded-lg p-3 shadow ${
                                    plan === "Yearly"
                                        ? "bg-indigo-600 text-white"
                                        : "bg-white text-gray-800"
                                }`}
                            >
                                <div className="absolute inline-flex items-center justify-center px-1.5 py-1 text-xs font-bold text-white bg-pink-500 rounded-full -top-2 right-0">
                                    {__(":discount% OFF", {
                                        discount: tier.one_year_discount,
                                    })}
                                </div>
                                {__("1 Year")}
                            </button>
                        </div>
                    </header>

                    <div className="border-t pt-5 text-xl text-center font-light mt-8 dark:text-white">
                        <p className="bg-white shadow text-gray-800 font-semibold inline-flex rounded-lg p-2">
                            <MdGeneratingTokens className="h-6 w-6" />{" "}
                            {__("Price: :price tokens", { price: showPrice })}
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
                            {showPrice <= auth.user.tokens ? (
                                <>
                                    <button
                                        onClick={(e) => confirmSubscription(e)}
                                        className="py-2 px-3 mt-2 mb-3 inline-flex rounded-md items-center bg-pink-500 text-white font-semibold hover:bg-pink-600 disabled:bg-gray-300 disabled:text-gray-700"
                                        disabled={processing}
                                    >
                                        <MdGeneratingTokens className="h-6 w-6 mr-2" />
                                        <div>{__("Confirm & Subscribe")}</div>
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
                                        "You need to charge your token balance for this plan"
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
