import __ from "@/Functions/Translate";
import { MdExplore } from "react-icons/md";
import { FaUsers, FaGrinStars } from "react-icons/fa";
import { AiFillThunderbolt } from "react-icons/ai";
import { Link } from "@inertiajs/inertia-react";
import { BsTagFill } from "react-icons/bs";
import { usePage } from "@inertiajs/inertia-react";

export default function LeftSidebar() {
    const { popular_channels, anyone_live } = usePage().props;

    return (
        <div className="hidden xl:fixed xl:flex xl:flex-col top-14 left-0 xl:w-64 h-full bg-gray-100 dark:bg-zinc-900 border-none z-10 sidebar">
            <div className="overflow-y-auto overflow-x-hidden flex flex-col flex-grow">
                <ul className="flex flex-col py-4 space-y-1">
                    <li className="px-3">
                        <div className="relative flex flex-row items-center pr-6">
                            <span className="">
                                <MdExplore className="w-9 h-9 dark:text-white" />
                            </span>
                            <h1 className="mt-1 ml-2 text-lg font-semibold flex items-center text-gray-900 dark:text-white gap-x-1">
                                {__("Explore")}
                            </h1>
                        </div>
                    </li>
                    {anyone_live && (
                        <li>
                            <Link
                                href={route("channels.live")}
                                className="text-zinc-700 dark:text-white block mb-1 ml-9 mt-2"
                            >
                                {__("Live Now")}
                            </Link>
                        </li>
                    )}

                    <li>
                        <Link
                            href={route("channels.browse")}
                            className="text-zinc-700 dark:text-white block mb-1 ml-9 mt-2"
                        >
                            {__("Discover Channels")}
                        </Link>
                    </li>
                    <li>
                        <Link
                            href={route("videos.browse")}
                            className="text-zinc-700 dark:text-white block mb-1 ml-9 mt-2"
                        >
                            {__("Browse Videos")}
                        </Link>
                    </li>
                    <li>
                        <h1 className="mt-5 ml-1 text-lg font-semibold flex items-center text-gray-900 dark:text-white">
                            <AiFillThunderbolt className="w-9" />
                            {__("Random Channels")}
                        </h1>
                    </li>
                    {popular_channels.length < 1 && (
                        <li className="px-10 dark:text-white">
                            {__("No channels to show")}
                        </li>
                    )}
                    {popular_channels.map((channel, chIndex) => {
                        return (
                            <li key={`chIndex-${chIndex}`}>
                                <div className="w-full flex items-center space-x-2 py-2 px-2 mt-1 flex-wrap hover:bg-gray-200 dark:hover:bg-black">
                                    <div className="w-14 h-14 flex-shrink-0">
                                        <Link
                                            href={route("channel", {
                                                user: channel.username,
                                            })}
                                        >
                                            <img
                                                src={channel.profile_picture}
                                                alt=""
                                                className="w-14 h-14 cursor-pointer rounded-full border-white border-2 dark:border-red-100"
                                            />
                                        </Link>
                                    </div>
                                    <div className="flex-grow">
                                        <Link
                                            href={route("channel", {
                                                user: channel.username,
                                            })}
                                            className="flex truncate text-gray-900 font-bold dark:text-white"
                                        >
                                            {channel.username}
                                        </Link>
                                        <Link
                                            href={route("channels.browse", {
                                                category:
                                                    channel.firstCategory.id,
                                                slug: `-${channel.firstCategory.slug}`,
                                            })}
                                            className="text-gray-600 -mt-0.5 flex items-center space-x-1 dark:text-zinc-100 text-sm"
                                        >
                                            <BsTagFill className="w-3" />
                                            <span>
                                                {channel.firstCategory.category}
                                            </span>
                                        </Link>
                                    </div>
                                </div>
                            </li>
                        );
                    })}
                </ul>
            </div>
        </div>
    );
}
