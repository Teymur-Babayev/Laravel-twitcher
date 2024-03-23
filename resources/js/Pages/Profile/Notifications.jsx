import React from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm, usePage } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";
import { BsCheckAll, BsCheckCircleFill } from "react-icons/bs";
import { AiOutlineBell } from "react-icons/ai";
import { ImFilesEmpty } from "react-icons/im";
import nl2br from "react-nl2br";
import { FaPiggyBank } from "react-icons/fa";
import AccountNavi from "../Channel/Partials/AccountNavi";

export default function Edit({ notifications }) {
    const { post, processing } = useForm();
    const { auth, currency_symbol } = usePage().props;

    const markAsRead = (n) => {
        post(route("notifications.markAsRead", { notification: n.id }));
    };

    const markAllRead = () => {
        post(route("notifications.markAllRead"));
    };

    const RenderNotification = ({ n }) => {
        switch (n.type) {
            case "App\\Notifications\\PaymentRequestProcessed":
                return (
                    <>
                        <div className="flex justify-between">
                            <div className="flex-grow flex items-center">
                                <FaPiggyBank className="mr-2 w-8 h-8 text-teal-500" />
                                {__(
                                    "Your payout request of :amount made on :date was processed!",
                                    {
                                        amount:
                                            currency_symbol +
                                            "" +
                                            n.data.amount,
                                        date: n.data.date,
                                    }
                                )}
                            </div>
                            <div>
                                {n.read_at === null ? (
                                    <button
                                        onClick={(e) => markAsRead(n)}
                                        className="inline-flex items-center space-x-3 text-sky-500 hover:text-sky-600"
                                    >
                                        <BsCheckAll />
                                        {__("Mark as Read")}
                                    </button>
                                ) : (
                                    <BsCheckCircleFill />
                                )}
                            </div>
                        </div>
                    </>
                );
                break;
            case "App\\Notifications\\NewFollower":
                return (
                    <>
                        <div className="flex justify-between">
                            <div className="flex items-center space-x-2">
                                <div className="flex-shrink-0">
                                    <img
                                        src={n.data.profile_picture}
                                        alt=""
                                        className="rounded-full h-14 border-zinc-200 dark:border-indigo-200 border"
                                    />
                                </div>
                                <div>
                                    <span className="text-sky-500">
                                        @{n.data.username}
                                    </span>

                                    <br />
                                    <span className="text-gray-600 dark:text-gray-100">
                                        {__("just followed you")}
                                    </span>
                                </div>
                            </div>
                            <div>
                                {n.read_at === null ? (
                                    <button
                                        onClick={(e) => markAsRead(n)}
                                        className="inline-flex items-center space-x-3 text-sky-500 hover:text-sky-600"
                                    >
                                        <BsCheckAll />
                                        {__("Mark as Read")}
                                    </button>
                                ) : (
                                    <BsCheckCircleFill />
                                )}
                            </div>
                        </div>
                    </>
                );
                break;
            case "App\\Notifications\\NewSubscriber":
                return (
                    <div className="flex flex-wrap justify-between">
                        <div className="flex items-center space-x-2">
                            <div className="flex-shrink-0">
                                <Link
                                    href={`${
                                        n.data.isStreamer === "yes"
                                            ? route("channel", {
                                                  user: n.data.username,
                                              })
                                            : ""
                                    }`}
                                >
                                    <img
                                        src={n.data.profilePicture}
                                        alt=""
                                        className="rounded-full h-14 w-14 border-zinc-200 dark:border-indigo-200 border"
                                    />
                                </Link>
                            </div>
                            <div>
                                <Link
                                    href={`${
                                        n.data.isStreamer === "yes"
                                            ? route("channel", {
                                                  user: n.data.username,
                                              })
                                            : ""
                                    }`}
                                    className="text-sky-500"
                                >
                                    @{n.data.username}
                                </Link>
                                <br />
                                <span className="text-gray-600 dark:text-gray-100">
                                    {__(
                                        "just subscribed to your tier :tierName for :tokensAmount tokens till :renewalDate",
                                        {
                                            tierName: n.data.tierName,
                                            tokensAmount: n.data.tokens,
                                            renewalDate: n.data.renewalDate,
                                        }
                                    )}
                                </span>
                            </div>
                        </div>
                        <div>
                            {n.read_at === null ? (
                                <button
                                    onClick={(e) => markAsRead(n)}
                                    className="inline-flex items-center space-x-3 text-sky-500 hover:text-sky-600"
                                >
                                    <BsCheckAll />
                                    {__("Mark as Read")}
                                </button>
                            ) : (
                                <BsCheckCircleFill />
                            )}
                        </div>
                    </div>
                );
                break;
            case "App\\Notifications\\ThanksNotification":
                return (
                    <div className="flex justify-between">
                        <div className="flex items-start space-x-2">
                            <div className="flex-shrink-0">
                                <Link
                                    href={route("channel", {
                                        user: n.data.username,
                                    })}
                                >
                                    <img
                                        src={n.data.profile_picture}
                                        alt=""
                                        className="rounded-full h-14 border-zinc-200 dark:border-indigo-200 border"
                                    />
                                </Link>
                            </div>
                            <div>
                                <Link
                                    href={route("channel", {
                                        user: n.data.username,
                                    })}
                                    className="text-sky-500"
                                >
                                    @{n.data.username}
                                </Link>{" "}
                                <span className="text-gray-700 dark:text-gray-100">
                                    {__("just thanked for your subscription")},
                                </span>
                                <br />
                                <blockquote className="italic text-gray-600 dark:text-gray-100">
                                    {nl2br(n.data.thanks_message)}
                                </blockquote>
                            </div>
                        </div>
                        <div>
                            {n.read_at === null ? (
                                <button
                                    onClick={(e) => markAsRead(n)}
                                    className="inline-flex items-center space-x-3 text-sky-500 hover:text-sky-600"
                                >
                                    <BsCheckAll />
                                    {__("Mark as Read")}
                                </button>
                            ) : (
                                <BsCheckCircleFill />
                            )}
                        </div>
                    </div>
                );
                break;

            case "App\\Notifications\\NewVideoSale":
                return (
                    <div className="flex flex-wrap justify-between">
                        <div className="flex items-center space-x-2">
                            <div className="flex-shrink-0">
                                <Link
                                    href={`${
                                        n.data.is_streamer === "yes"
                                            ? route("channel", {
                                                  user: n.data.username,
                                              })
                                            : ""
                                    }`}
                                >
                                    <img
                                        src={n.data.profile_picture}
                                        alt=""
                                        className="rounded-full h-14 w-14 border-zinc-200 dark:border-indigo-200 border"
                                    />
                                </Link>
                            </div>
                            <div>
                                <Link
                                    href={`${
                                        n.data.is_streamer === "yes"
                                            ? route("channel", {
                                                  user: n.data.username,
                                              })
                                            : ""
                                    }`}
                                    className="text-sky-500"
                                >
                                    @{n.data.username}
                                </Link>
                                <br />
                                <span className="text-gray-600 dark:text-gray-100">
                                    {__(
                                        'just bought your video ":videoTitle" for :tokensAmount tokens',
                                        {
                                            videoTitle: n.data.video.title,
                                            tokensAmount: n.data.price,
                                        }
                                    )}
                                </span>
                            </div>
                        </div>
                        <div>
                            {n.read_at === null ? (
                                <button
                                    onClick={(e) => markAsRead(n)}
                                    className="inline-flex items-center space-x-3 text-sky-500 hover:text-sky-600"
                                >
                                    <BsCheckAll />
                                    {__("Mark as Read")}
                                </button>
                            ) : (
                                <BsCheckCircleFill />
                            )}
                        </div>
                    </div>
                );

                break;
            default:
                return `NOTIFICATION_TYPE: ${n.type}`;
                break;
        }
    };
    return (
        <AuthenticatedLayout auth={auth}>
            <Head title={__("Notifications")} />

            <div className="lg:flex lg:space-x-10 w-full">
                <AccountNavi active={"notifications"} />

                <div className="bg-white rounded-lg w-full shadow dark:bg-zinc-900 p-4 sm:p-8">
                    <div className="flex justify-between">
                        <div className="flex items-center space-x-2 flex-wrap">
                            <AiOutlineBell className="w-8 h-8 text-gray-600 dark:text-gray-100" />
                            <h2 className="text-lg md:text-xl font-medium text-gray-600 dark:text-gray-100">
                                {__("Notifications")}
                            </h2>
                        </div>
                        <div>
                            {notifications.data.length &&
                                auth.unreadNotifications > 0 && (
                                    <button
                                        onClick={(e) => markAllRead()}
                                        className="inline-flex items-center space-x-3 border-2 border-sky-500 rounded-lg p-2 font-semibold text-sm text-sky-500 hover:text-sky-600 hover:border-sky-600"
                                    >
                                        <BsCheckAll />
                                        {__("Mark All As Read")}
                                    </button>
                                )}
                        </div>
                    </div>

                    {notifications.data.length === 0 && (
                        <div className="mt-10 p-4 sm:p-8 bg-slate-50 dark:bg-zinc-900 shadow sm:rounded-lg text-gray-600 text-center dark:text-white">
                            <center>
                                <ImFilesEmpty className="h-16 w-16 mb-3" />
                            </center>
                            <h3 className="text-xl">
                                {__("No notifications")}
                            </h3>
                        </div>
                    )}

                    {notifications.data.map((n) => (
                        <div
                            key={n.id}
                            className={`mt-10 px-4 py-2.5 bg-slate-50 dark:bg-zinc-900 sm:rounded-lg dark:text-white ${
                                n.read_at
                                    ? ""
                                    : "border border-slate-200 dark:border-gray-700"
                            }`}
                        >
                            <RenderNotification n={n} />
                        </div>
                    ))}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
