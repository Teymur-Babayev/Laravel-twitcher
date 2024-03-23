import __ from "@/Functions/Translate";
import { Link, Head, usePage } from "@inertiajs/inertia-react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { FiUserMinus } from "react-icons/fi";
import { FaGrinStars } from "react-icons/fa";
import { GoCalendar } from "react-icons/go";
import SecondaryButton from "@/Components/SecondaryButton";
import { Inertia } from "@inertiajs/inertia";
import AccountNavi from "./Partials/AccountNavi";

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
            <Head title={__("My Subscribers")} />

            <div className="lg:flex lg:space-x-10">
                <AccountNavi active={"my-subscribers"} />
                <div className="ml-0 w-full">
                    {auth.user.is_streamer === "yes" && (
                        <>
                            <Link
                                href={route("mySubscribers", {
                                    user: auth.user.username,
                                })}
                                className={activeTabClass}
                            >
                                {__("My Subscribers")}
                            </Link>
                            <Link
                                href={route("mySubscriptions")}
                                className={inactiveTabClass}
                            >
                                {__("My Subscriptions")}
                            </Link>
                        </>
                    )}

                    <div className="mt-5 p-4 sm:p-8 bg-white dark:bg-zinc-900 shadow sm:rounded-lg">
                        <header>
                            <div className="flex items-start space-x-3">
                                <div>
                                    <FaGrinStars className="w-8 h-8 text-gray-600 dark:text-white" />
                                </div>
                                <div>
                                    <h2 className="text-lg md:text-xl font-medium text-gray-600 dark:text-gray-100">
                                        {__("My Subscribers")} ({subs.total})
                                    </h2>

                                    <p className="mt-1 mb-2 text-sm text-gray-600 dark:text-gray-400">
                                        {__(
                                            "These are the users that paid a for a tier on your channel"
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
                                        "No one is subscribed to your channel yet"
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
                                            href={`${
                                                user.subscriber.is_streamer ===
                                                "yes"
                                                    ? route("channel", {
                                                          user: user.subscriber
                                                              .username,
                                                      })
                                                    : ""
                                            }`}
                                        >
                                            <img
                                                src={
                                                    user.subscriber
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
                                            href={`${
                                                user.subscriber.is_streamer ===
                                                "yes"
                                                    ? route("channel", {
                                                          user: user.subscriber
                                                              .username,
                                                      })
                                                    : ""
                                            }`}
                                        >
                                            {user.subscriber.name}
                                        </Link>
                                        <Link
                                            className="block text-sky-500 hover:text-sky-700 font-semibold text-sm"
                                            href={`${
                                                user.subscriber.is_streamer ===
                                                "yes"
                                                    ? route("channel", {
                                                          user: user.subscriber
                                                              .username,
                                                      })
                                                    : ""
                                            }`}
                                        >
                                            @{user.subscriber.username}
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

                                <div className="flex text-gray-600 my-3 text-sm">
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
