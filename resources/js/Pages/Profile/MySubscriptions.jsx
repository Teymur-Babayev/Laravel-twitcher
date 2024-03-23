import __ from "@/Functions/Translate";
import { Link, Head, usePage } from "@inertiajs/inertia-react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { FiUserMinus } from "react-icons/fi";
import { MdOutlineSubscriptions } from "react-icons/md";
import { GoCalendar } from "react-icons/go";
import SecondaryButton from "@/Components/SecondaryButton";
import { Inertia } from "@inertiajs/inertia";
import AccountNavi from "../Channel/Partials/AccountNavi";

export default function MySubscribers({ subs }) {
    const { auth } = usePage().props;

    console.log(subs);

    // active tab class
    const activeTabClass =
        "text-xl font-bold mr-2 md:mr-4 text-indigo-800 dark:text-indigo-500 border-b-2 border-indigo-800";
    const inactiveTabClass =
        "text-xl font-bold mr-2 md:mr-4 hover:text-indigo-800 dark:text-white dark:hover:text-indigo-500";

    return (
        <AuthenticatedLayout>
            <Head title={__("My Subscriptions")} />

            <div className="lg:flex lg:space-x-10">
                <AccountNavi active={"my-subscriptions"} />

                <div className="ml-0 w-full">
                    {auth.user.is_streamer === "yes" && (
                        <>
                            <Link
                                href={route("mySubscribers", {
                                    user: auth.user.username,
                                })}
                                className={inactiveTabClass}
                            >
                                {__("My Subscribers")}
                            </Link>
                            <Link
                                href={route("mySubscriptions")}
                                className={activeTabClass}
                            >
                                {__("My Subscriptions")}
                            </Link>
                        </>
                    )}

                    <div className="mt-5 p-4 sm:p-8 bg-white dark:bg-zinc-900 shadow sm:rounded-lg">
                        <header>
                            <div className="flex items-start space-x-3">
                                <div>
                                    <MdOutlineSubscriptions className="w-8 text-gray-600 h-8 dark:text-white" />
                                </div>
                                <div>
                                    <h2 className="text-lg md:text-xl font-medium text-gray-600 dark:text-gray-100">
                                        {__("My Subscriptions")} ({subs.total})
                                    </h2>

                                    <p className="mt-1 mb-2 text-sm text-gray-600 dark:text-gray-400">
                                        {__(
                                            "These are the channels you are subscribed to"
                                        )}
                                    </p>
                                </div>
                            </div>
                        </header>

                        <hr className="my-5" />

                        {subs.total === 0 && (
                            <div className="text-xl dark:text-white text-gray-700 flex items-center space-x-4">
                                <FiUserMinus className="w-10 h-10" />
                                <div>
                                    {__(
                                        "You haven't subscribed to any channel."
                                    )}
                                </div>
                            </div>
                        )}

                        <div className="flex flex-col md:flex-row flex-wrap items-center">
                            {subs.data?.map((user, index) => (
                                <div
                                    key={index}
                                    className="flex items-center space-x-2  mr-5 mb-5"
                                >
                                    <div>
                                        <Link
                                            href={route("channel", {
                                                user: user.streamer.username,
                                            })}
                                        >
                                            <img
                                                src={
                                                    user.streamer
                                                        .profile_picture
                                                }
                                                alt=""
                                                className="rounded-full h-14 border-zinc-200 dark:border-indigo-200 border"
                                            />
                                        </Link>
                                    </div>
                                    <div>
                                        <Link
                                            className="block text-gray-600 dark:text-gray-300 text-lg font-semibold mt-1"
                                            href={route("channel", {
                                                user: user.streamer.username,
                                            })}
                                        >
                                            {user.streamer.name}
                                        </Link>
                                        <Link
                                            className="block text-sky-500 hover:text-sky-700 font-semibold text-sm"
                                            href={route("channel", {
                                                user: user.streamer.username,
                                            })}
                                        >
                                            @{user.streamer.username}
                                        </Link>
                                        <span className="mt-1 inline-flex items-center space-x-2 rounded px-1.5 py-0.5 bg-gray-500 text-gray-100 text-xs">
                                            <GoCalendar className="dark:text-white mr-1" />
                                            {user.expires_human}
                                        </span>
                                    </div>
                                </div>
                            ))}
                        </div>

                        {subs.last_page > 1 && (
                            <>
                                <hr className="my-5" />

                                <div className="flex text-gray-600 dark:text-gray-100 my-3 text-sm">
                                    {__("Page: :pageNumber of :lastPage", {
                                        pageNumber: subs.current_page,
                                        lastPage: subs.last_page,
                                    })}
                                </div>

                                <SecondaryButton
                                    processing={
                                        subs.prev_page_url ? false : true
                                    }
                                    className="mr-3"
                                    onClick={(e) =>
                                        Inertia.visit(subs.prev_page_url)
                                    }
                                >
                                    {__("Previous")}
                                </SecondaryButton>

                                <SecondaryButton
                                    processing={
                                        subs.next_page_url ? false : true
                                    }
                                    onClick={(e) =>
                                        Inertia.visit(subs.next_page_url)
                                    }
                                >
                                    {__("Next")}
                                </SecondaryButton>
                            </>
                        )}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
