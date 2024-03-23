import { usePage } from "@inertiajs/inertia-react";
import { Link } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";
import { MdGeneratingTokens } from "react-icons/md";

export default function AccountNavi({ active }) {
    const { auth } = usePage().props;
    return (
        <div className="lg:w-80 hidden lg:block lg:flex-shrink-0">
            <div className=" bg-white rounded shadow dark:bg-zinc-900">
                <Link
                    className="block"
                    href={`${auth.user.is_streamer === "yes"
                        ? route("payout.withdraw")
                        : route("profile.myTokens")
                        }`}
                >
                    <span className="flex items-center bg-indigo-100 text-indigo-700 text-sm font-bold justify-center py-5 mb-3 rounded-t">
                        <MdGeneratingTokens className="h-5 w-5 mr-1" />
                        {__(":tokensCount tokens", {
                            tokensCount: auth.user.tokens,
                        })}
                    </span>
                </Link>
                {auth.user.is_streamer === "yes" && (
                    <Link
                        className={`block font-bold ${active == "account"
                            ? "text-indigo-900"
                            : "text-indigo-600"
                            } hover:text-indigo-800 py-2 dark:text-white dark:hover:text-indigo-300  dark:border-zinc-800 border-b border-indigo-100 my-2 px-5`}
                        href={route("channel", {
                            user: auth.user.username,
                        })}
                    >
                        {__("My Channel")}
                    </Link>
                )}
                {auth.user.is_streamer === "yes" && (
                    <Link
                        className={`block font-bold ${active == "channel-settings"
                            ? "text-indigo-900"
                            : "text-indigo-600"
                            } hover:text-indigo-800 py-2 dark:text-white dark:hover:text-indigo-300  dark:border-zinc-800 border-b border-indigo-100 my-2 px-5`}
                        href={route("channel.settings")}
                    >
                        {__("Channel Settings")}
                    </Link>
                )}
                <Link
                    className={`block font-bold ${active == "notifications"
                        ? "text-indigo-900"
                        : "text-indigo-600"
                        } hover:text-indigo-800 py-2 dark:text-white dark:hover:text-indigo-300  dark:border-zinc-800 border-b border-indigo-100 my-2 px-5`}
                    href={route("notifications.inbox")}
                >
                    {__("Notifications")}
                    <span className="bg-red-100 text-red-500 text-xs font-medium ml-2 px-1.5 py-0.5 rounded-full dark:bg-red-500 dark:text-red-100">
                        {__(":unreadNotificationsCount new", {
                            unreadNotificationsCount: auth.unreadNotifications,
                        })}
                    </span>
                </Link>
                {auth.user.is_streamer === "yes" && (
                    <Link
                        className={`block font-bold ${active == "withdraw"
                            ? "text-indigo-900"
                            : "text-indigo-600"
                            } hover:text-indigo-800 py-2 dark:text-white dark:hover:text-indigo-300  dark:border-zinc-800 border-b border-indigo-100 my-2 px-5`}
                        href={route("payout.withdraw")}
                    >
                        {__("Withdraw")}
                    </Link>
                )}
                {auth.user.is_streamer === "yes" && (
                    <Link
                        className={`block font-bold ${active == "tiers"
                            ? "text-indigo-900"
                            : "text-indigo-600"
                            } hover:text-indigo-800 py-2 dark:text-white dark:hover:text-indigo-300  dark:border-zinc-800 border-b border-indigo-100 my-2 px-5`}
                        href={route("membership.set-tiers")}
                    >
                        {__("Membership Tiers")}
                    </Link>
                )}
                {auth.user.is_streamer === "yes" && (
                    <Link
                        className={`block font-bold ${active == "upload-videos"
                            ? "text-indigo-900"
                            : "text-indigo-600"
                            } hover:text-indigo-800 py-2 dark:text-white dark:hover:text-indigo-300  dark:border-zinc-800 border-b border-indigo-100 my-2 px-5`}
                        href={route("videos.list")}
                    >
                        {__("Upload Videos")}
                    </Link>
                )}
                <Link
                    className={`block font-bold ${active == "videos"
                        ? "text-indigo-900"
                        : "text-indigo-600"
                        } hover:text-indigo-800 py-2 dark:text-white dark:hover:text-indigo-300  dark:border-zinc-800 border-b border-indigo-100 my-2 px-5`}
                    href={route("videos.ordered")}
                >
                    {__("My Videos")}
                </Link>
                {auth.user.is_streamer === "yes" && (
                    <Link
                        className={`block font-bold ${active == "followers"
                            ? "text-indigo-900"
                            : "text-indigo-600"
                            } hover:text-indigo-800 py-2 dark:text-white dark:hover:text-indigo-300  dark:border-zinc-800 border-b border-indigo-100 my-2 px-5`}
                        href={route("channel.followers", {
                            user: auth.user.username,
                        })}
                    >
                        {__("My Followers")}
                    </Link>
                )}
                {auth.user.is_streamer === "yes" && (
                    <Link
                        className={`block font-bold ${active == "my-subscribers"
                            ? "text-indigo-900"
                            : "text-indigo-600"
                            } hover:text-indigo-800 py-2 dark:text-white dark:hover:text-indigo-300  dark:border-zinc-800 border-b border-indigo-100 my-2 px-5`}
                        href={route("mySubscribers")}
                    >
                        {__("My Subscribers")}
                    </Link>
                )}
                <Link
                    className={`block font-bold ${active == "following"
                        ? "text-indigo-900"
                        : "text-indigo-600"
                        } hover:text-indigo-800 py-2 dark:text-white dark:hover:text-indigo-300  dark:border-zinc-800 border-b border-indigo-100 my-2 px-5`}
                    href={route("profile.followings")}
                >
                    {__("My Followings")}
                </Link>
                <Link
                    className={`block font-bold ${active == "my-subscriptions"
                        ? "text-indigo-900"
                        : "text-indigo-600"
                        } hover:text-indigo-800 py-2 dark:text-white dark:hover:text-indigo-300  dark:border-zinc-800 border-b border-indigo-100 my-2 px-5`}
                    href={route("mySubscriptions")}
                >
                    {__("My Subscriptions")}
                </Link>
                {auth.user.is_streamer === "yes" && (
                    <Link
                        className={`block font-bold ${active == "channel-settings"
                            ? "text-indigo-900"
                            : "text-indigo-600"
                            } hover:text-indigo-800 py-2 dark:text-white dark:hover:text-indigo-300  dark:border-zinc-800 border-b border-indigo-100 my-2 px-5`}
                        href={route("channel.bannedUsers")}
                    >
                        {__("Banned Users")}
                    </Link>
                )}
                <Link
                    className={`block font-bold ${active == "account"
                        ? "text-indigo-900"
                        : "text-indigo-600"
                        } hover:text-indigo-800 py-2 dark:text-white dark:hover:text-indigo-300  dark:border-zinc-800 border-b border-indigo-100 my-2 px-5`}
                    href={route("profile.edit")}
                >
                    {__("My Account")}
                </Link>
            </div>
        </div>
    );
}
