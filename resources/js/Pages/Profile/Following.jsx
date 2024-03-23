import __ from "@/Functions/Translate";
import { Link, Head, usePage } from "@inertiajs/inertia-react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { FiUserMinus } from "react-icons/fi";
import { AiOutlineUserSwitch } from "react-icons/ai";
import axios from "axios";
import { toast } from "react-toastify";
import { Inertia } from "@inertiajs/inertia";
import AccountNavi from "../Channel/Partials/AccountNavi";

export default function Following({ following }) {
    const { auth } = usePage().props;

    const unfollowUser = (e, userId) => {
        e.preventDefault();
        axios
            .get(route("follow", { user: userId }))
            .then((apiRes) => {
                console.log(Inertia.reload());
            })
            .catch((Error) => toast.error(Error.response?.data?.error));
    };

    // active tab class
    const activeTabClass =
        "text-xl font-bold mr-2 md:mr-4 text-indigo-800 dark:text-indigo-500 border-b-2 border-indigo-800";
    const inactiveTabClass =
        "text-xl font-bold mr-2 md:mr-4 hover:text-indigo-800 dark:text-white dark:hover:text-indigo-500";
    return (
        <AuthenticatedLayout>
            <Head title={__("Following")} />

            <div className="lg:flex lg:space-x-10">
                <AccountNavi active={"following"} />

                <div className="w-full">
                    {auth.user.is_streamer === "yes" && (
                        <>
                            <Link
                                href={route("channel.followers", {
                                    user: auth.user.username,
                                })}
                                className={inactiveTabClass}
                            >
                                {__("Followers")}
                            </Link>
                            <Link
                                href={route("profile.followings")}
                                className={activeTabClass}
                            >
                                {__("Following")}
                            </Link>
                        </>
                    )}

                    <div className="mt-5 p-4 sm:p-8 bg-white dark:bg-zinc-900 shadow sm:rounded-lg">
                        <header>
                            <div className="flex items-start space-x-3">
                                <div>
                                    <AiOutlineUserSwitch className="w-8 h-8 text-gray-600 dark:text-white" />
                                </div>
                                <div>
                                    <h2 className="text-lg md:text-xl font-medium text-gray-600 dark:text-gray-100">
                                        {__("My Followings")} (
                                        {following.length})
                                    </h2>

                                    <p className="mt-1 mb-2 text-sm text-gray-600 dark:text-gray-400">
                                        {__(
                                            "These are the channels that you are following"
                                        )}
                                    </p>
                                </div>
                            </div>
                        </header>

                        <hr className="my-5" />

                        {following.length === 0 && (
                            <div className="text-xl dark:text-white text-gray-700 flex items-center space-x-4">
                                <FiUserMinus className="w-10 h-10" />
                                <div>
                                    {__(
                                        "You are not following any channel yet"
                                    )}
                                </div>
                            </div>
                        )}

                        <div className="flex flex-col md:flex-row flex-wrap md:items-center">
                            {following.map((user, index) => (
                                <div
                                    key={index}
                                    className="flex items-center space-x-2  mr-5 mb-5"
                                >
                                    <div>
                                        <Link
                                            href={`${
                                                user.followable.is_streamer ===
                                                "yes"
                                                    ? route("channel", {
                                                          user: user.followable
                                                              .username,
                                                      })
                                                    : ""
                                            }`}
                                        >
                                            <img
                                                src={
                                                    user.followable
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
                                                user.followable.is_streamer ===
                                                "yes"
                                                    ? route("channel", {
                                                          user: user.followable
                                                              .username,
                                                      })
                                                    : ""
                                            }`}
                                        >
                                            {user.followable.name}
                                        </Link>
                                        <Link
                                            className="block text-sky-500 hover:text-sky-700 font-semibold text-sm"
                                            href={`${
                                                user.followable.is_streamer ===
                                                "yes"
                                                    ? route("channel", {
                                                          user: user.followable
                                                              .username,
                                                      })
                                                    : ""
                                            }`}
                                        >
                                            @{user.followable.username}
                                        </Link>
                                        <button
                                            className="text-xs text-rose-600 hover:text-rose-800"
                                            onClick={(e) =>
                                                unfollowUser(
                                                    e,
                                                    user.followable.id
                                                )
                                            }
                                        >
                                            {__("Unfollow")}
                                        </button>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
