import React from "react";
import { Link } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";
import { BsTagFill } from "react-icons/bs";
import { FaGrinStars, FaUsers } from "react-icons/fa";
import { MdVideoLibrary } from "react-icons/md";

export default function ChannelsLoop({ channels }) {
    return (
        <div className="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            {channels.map((channel) => (
                <div
                    className="border dark:border-zinc-800 shadow-sm rounded-lg pb-2 bg-white dark:bg-zinc-900"
                    key={channel.id}
                >
                    <div className="relative">
                        {channel.live_status === "online" && (
                            <div className="absolute top-3 left-0">
                                <span className="bg-pink-600 text-white font-bold px-2">
                                    {__("LIVE")}
                                </span>
                            </div>
                        )}
                        <Link
                            href={route("channel", { user: channel.username })}
                        >
                            <img
                                src={channel.cover_picture}
                                alt={channel.name}
                                className="cursor-pointer rounded-tr-lg rounded-tl-lg sm:w-auto"
                            />
                        </Link>
                        <div className="-mt-8 ml-2.5 absolute">
                            <Link
                                href={route("channel", {
                                    user: channel.username,
                                })}
                            >
                                <img
                                    src={channel.profile_picture}
                                    alt=""
                                    className="rounded-full h-16 border-white shadow-sm z-1 dark:border-indigo-200 border-2"
                                />
                            </Link>
                        </div>
                    </div>
                    <div className="mt-10 px-4">
                        <div className="flex items-center flex-wrap">
                            <div>
                                <Link
                                    className="text-indigo-600 hover:text-indigo-400 dark:text-indigo-500 dark:hover:text-indigo-600 font-black mt-1 text-lg"
                                    href={route("channel", {
                                        user: channel.username,
                                    })}
                                >
                                    {channel.name}
                                </Link>
                            </div>
                            <div>
                                <Link
                                    className="ml-2 text-indigo-600 hover:text-indigo-400 dark:text-indigo-500 dark:hover:text-indigo-600 font-light text-base"
                                    href={route("channel", {
                                        user: channel.username,
                                    })}
                                >
                                    @{channel.username}
                                </Link>
                            </div>
                        </div>
                        <div className="mt-1 flex items-center flex-wrap justify-between">
                            <div>
                                {channel.categories.map((category) => {
                                    return (
                                        <div
                                            className="mt-2 inline-flex items-center space-x-1 px-2 rounded-lg dark:bg-gray-700  bg-gray-100"
                                            key={`category-${category.id}`}
                                        >
                                            <BsTagFill className="w-3 text-gray-500 dark:text-gray-100 " />{" "}
                                            <Link
                                                href={route("channels.browse", {
                                                    category: category.id,
                                                    slug: `-${category.slug}`,
                                                })}
                                                className="text-gray-500 dark:text-gray-100 text-sm ml-1"
                                                key={`category-${category.id}`}
                                            >
                                                {category.category}
                                            </Link>
                                        </div>
                                    );
                                })}
                            </div>
                            <div>
                                <span className="flex items-center text-gray-500 dark:text-gray-300 text-sm">
                                    <MdVideoLibrary className="mr-1" />{" "}
                                    {channel.videos_count === 1
                                        ? __(":vidsCount video", {
                                              vidsCount: channel.videos_count,
                                          })
                                        : __(":vidsCount videos", {
                                              vidsCount: channel.videos_count,
                                          })}
                                </span>
                            </div>
                        </div>
                        <div className="flex  items-center justify-between">
                            <span className="ml-1 flex items-center text-gray-500 dark:text-gray-300 text-sm">
                                <FaUsers className="mr-1" />{" "}
                                {channel.followers_count === 1
                                    ? __(":followersCount follower", {
                                          followersCount:
                                              channel.followers_count,
                                      })
                                    : __(":followersCount followers", {
                                          followersCount:
                                              channel.followers_count,
                                      })}
                            </span>
                            <span className="flex items-center text-gray-500 dark:text-gray-300 text-sm">
                                <FaGrinStars className="mr-1" />{" "}
                                {channel.subscribers_count === 1
                                    ? __(":subsCount subscriber", {
                                          subsCount: channel.subscribers_count,
                                      })
                                    : __(":subsCount subscribers", {
                                          subsCount: channel.subscribers_count,
                                      })}
                            </span>
                        </div>
                    </div>
                </div>
            ))}
        </div>
    );
}
