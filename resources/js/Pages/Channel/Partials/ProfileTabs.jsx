import __ from "@/Functions/Translate";
import sanitizeHtml from "sanitize-html-react";
import Tiers from "./TiersTab";
import ScheduleTab from "./ScheduleTab";
import ChannelVideos from "./ChannelVideos";
import { FaGrinStars, FaHandSparkles } from "react-icons/fa";
import { MdVideoLibrary } from "react-icons/md";
import { usePage } from "@inertiajs/inertia-react";
import { AiFillPlayCircle } from "react-icons/ai";
import { Link } from "@inertiajs/inertia-react";

export default function ProfileTabs({ streamUser, activeTab, setActiveTab }) {
    // active tab class
    const activeTabClass =
        "text-xl font-bold mr-2 md:mr-4 text-indigo-800 dark:text-indigo-500";
    const inactiveTabClass =
        "text-xl font-bold mr-2 md:mr-4 hover:text-indigo-800 dark:text-white dark:hover:text-indigo-500";

    const { auth } = usePage().props;

    const changeTab = (e, tabName) => {
        e.preventDefault();
        setActiveTab(tabName);
    };

    return (
        <>
            <div className="mt-4 bg-white dark:bg-zinc-900 rounded-lg shadow px-3 py-4 flex justify-between items-center flex-wrap">
                <div>
                    <button
                        className={
                            activeTab == "Videos"
                                ? activeTabClass
                                : inactiveTabClass
                        }
                        onClick={(e) => changeTab(e, "Videos")}
                    >
                        {__("Videos")}
                    </button>

                    <button
                        className={
                            activeTab == "Tiers"
                                ? activeTabClass
                                : inactiveTabClass
                        }
                        onClick={(e) => changeTab(e, "Tiers")}
                    >
                        {__("Tiers")}
                    </button>

                    <button
                        className={
                            activeTab == "Schedule"
                                ? activeTabClass
                                : inactiveTabClass
                        }
                        onClick={(e) => changeTab(e, "Schedule")}
                    >
                        {__("Schedule")}
                    </button>

                    <button
                        className={
                            activeTab == "About"
                                ? activeTabClass
                                : inactiveTabClass
                        }
                        onClick={(e) => changeTab(e, "About")}
                    >
                        {__("About")}
                    </button>
                </div>
                <div>
                    {auth.user?.username === streamUser.username && (
                        <Link
                            href={route("channel.livestream", {
                                user: streamUser.username,
                            })}
                            className="inline-flex items-center text-pink-600 hover:text-pink-500 dark:text-pink-500 dark:hover:text-pink-600 text-lg font-bold"
                        >
                            <AiFillPlayCircle className="mr-1" />
                            {__("Start Streaming")}
                        </Link>
                    )}
                    {auth.user?.username !== streamUser.username &&
                        streamUser.live_status === "online" && (
                            <Link
                                href={route("channel.livestream", {
                                    user: streamUser.username,
                                })}
                                className="inline-flex items-center text-pink-600 hover:text-pink-500 text-lg font-bold"
                            >
                                <AiFillPlayCircle className="mr-1" />
                                {__("Watch Stream")}
                            </Link>
                        )}
                </div>
            </div>

            {/* About Tab */}
            {activeTab == "About" && (
                <>
                    <div className="flex mt-4">
                        <div className="flex flex-col items-center mr-4">
                            <div className="shadow bg-white dark:bg-zinc-900 dark:text-white rounded-lg p-5 mb-5 w-full">
                                <h3 className="text-2xl justify-center flex items-center dark:text-white  text-gray-600">
                                    <FaHandSparkles className="w-10 h-10 mr-1" />
                                </h3>
                                <p className="mt-2 font-medium text-center dark:text-white text-gray-600">
                                    {streamUser.followers_count === 1
                                        ? __("1 Followers")
                                        : __(":count Followers", {
                                              count: streamUser.followers_count,
                                          })}
                                </p>
                            </div>
                            <div className="shadow bg-white dark:bg-zinc-900 rounded-lg p-5 mb-5 w-full">
                                <h3 className="text-2xl justify-center flex items-center dark:text-white  text-gray-600">
                                    <FaGrinStars className="w-10 h-10 mr-1" />
                                </h3>

                                <p className="mt-2 font-medium text-center dark:text-white text-gray-600">
                                    {streamUser.subscribers_count === 1
                                        ? __("1 Subscriber")
                                        : __(":count Subscribers", {
                                              count: streamUser.subscribers_count,
                                          })}
                                </p>
                            </div>
                            <div className="shadow bg-white dark:bg-zinc-900 rounded-lg p-5 w-full">
                                <h3 className="text-2xl justify-center flex items-center dark:text-white  text-gray-600">
                                    <MdVideoLibrary className="w-10 h-10 mr-1" />
                                </h3>
                                <p className="mt-2 font-medium text-center dark:text-white text-gray-700">
                                    {streamUser.videos_count === 1
                                        ? __("1 Video")
                                        : __(":count Videos", {
                                              count: streamUser.videos_count,
                                          })}
                                </p>
                            </div>
                        </div>
                        <div className=" flex-grow">
                            {streamUser?.about ? (
                                <div
                                    className="dark:text-zinc-200 dark:bg-zinc-900 bg-white rounded-lg shadow p-3"
                                    dangerouslySetInnerHTML={{
                                        __html: sanitizeHtml(streamUser.about, {
                                            allowedTags:
                                                sanitizeHtml.defaults.allowedTags.concat(
                                                    ["img", "br"]
                                                ),
                                        }),
                                    }}
                                />
                            ) : (
                                <div className="bg-white dark:bg-zinc-900 dark:text-white rounded-lg shadow px-3 py-5 text-gray-600">
                                    {__(
                                        "Add channel description in Channel Settings page."
                                    )}
                                </div>
                            )}
                        </div>
                    </div>
                </>
            )}

            {/* Videos Tab */}
            {activeTab == "Videos" && <ChannelVideos streamUser={streamUser} />}

            {/* Tiers Tab */}
            {activeTab == "Tiers" && <Tiers user={streamUser} />}

            {/* Schedule Tab */}
            {activeTab == "Schedule" && <ScheduleTab user={streamUser} />}
        </>
    );
}
