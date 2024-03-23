import React from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";
import { BsTagFill } from "react-icons/bs";
import { AiOutlineEye } from "react-icons/ai";
import { FcUnlock } from "react-icons/fc";
import PrimaryButton from "@/Components/PrimaryButton";
import { MdGeneratingTokens } from "react-icons/md";
import axios from "axios";
import { FaGrinStars } from "react-icons/fa";
import { Inertia } from "@inertiajs/inertia";

const VideoComponent = ({ video, inModal }) => {
    const increaseViews = () => {
        axios.post(route("video.increaseViews", { video: video.id }));
    };

    return (
        <div className={`justify-center w-full ${inModal ? "p-3" : "p-0"}`}>
            <div className="flex items-start">
                <div className="mr-5 flex flex-col items-center flex-shrink-0">
                    <Link
                        href={route("channel", {
                            user: video.streamer.username,
                        })}
                    >
                        <img
                            src={video.streamer.profile_picture}
                            className="w-14 h-14 rounded-full"
                        />
                    </Link>
                </div>
                <div>
                    <h3 className="text-lg md:text-2xl font-light text-gray-600 dark:text-white">
                        {video.title}
                    </h3>

                    <div className="flex items-center flex-wrap md:space-x-2 mt-1">
                        <Link
                            href={route("channel", {
                                user: video.streamer.username,
                            })}
                            className="text-sm text-gray-600 mr-2  dark:text-white"
                        >
                            @{video.streamer.username}
                        </Link>

                        <Link
                            href={route("videos.browse", {
                                videocategory: video.category.id,
                                slug: `-${video.category.slug}`,
                            })}
                            className="text-gray-600 mr-2  inline-flex items-center space-x-1 dark:text-zinc-100 text-sm"
                        >
                            <BsTagFill className="w-3" />
                            <span>{video.category.category}</span>
                        </Link>

                        <span className="text-gray-600 inline-flex items-center space-x-1 dark:text-zinc-100 text-sm mr-2   ">
                            <AiOutlineEye className="w-5 h-5 mr-1" />
                            {video.views === 1
                                ? __("1 view")
                                : __(":viewsCount views", {
                                      viewsCount: video.views,
                                  })}
                        </span>

                        {video.free_for_subs === "yes" && video.price !== 0 && (
                            <div className="mt-1 md:mt-0 inline-flex items-center text-sm bg-gray-100 rounded px-2 py-1 text-gray-500 dark:text-gray-600">
                                <FaGrinStars className="w-4 h-4 mr-1" />
                                {__("Free For Subscribers")}
                            </div>
                        )}
                    </div>
                </div>
            </div>

            <div className="mt-5">
                {video.canBePlayed ? (
                    <video
                        className="w-full aspect-video"
                        controls
                        disablePictureInPicture
                        controlsList="nodownload"
                        onPlay={(e) => increaseViews()}
                    >
                        <source src={`${video.videoUrl}#t`} type="video/mp4" />
                    </video>
                ) : (
                    <div className="flex flex-col items-center  md:flex-row space-y-5 md:space-y-0 md:space-x-5">
                        <div className="relative">
                            <img
                                src={video.thumbnail}
                                alt=""
                                className="rounded-lg w-full"
                            />

                            <div className="absolute top-0 left-0 text-center bg-gray-700 w-full h-full bg-opacity-25 rounded-lg ">
                                <div className="relative top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex flex-col justify-center">
                                    <div className="w-full">
                                        <div className="bg-white inline-flex bg-opacity-25 rounded-full p-2">
                                            <FcUnlock className="w-12 h-12" />
                                        </div>
                                    </div>

                                    <div>
                                        <PrimaryButton
                                            className="h-12 mt-5 inline-flex"
                                            onClick={(e) =>
                                                Inertia.visit(
                                                    route("video.unlock", {
                                                        video: video.id,
                                                    })
                                                )
                                            }
                                        >
                                            <MdGeneratingTokens className="mr-2 w-6 h-6 md:w-8 md:h-8" />
                                            {__("Unlock with :tokens tokens", {
                                                tokens: video.price,
                                            })}
                                        </PrimaryButton>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </div>
    );
};

export default function SingleVideo({ video, inModal = false }) {
    if (inModal) {
        return <VideoComponent video={video} inModal={true} />;
    } else {
        return (
            <AuthenticatedLayout>
                <Head title={video.title} />
                <VideoComponent video={video} inModal={false} />
            </AuthenticatedLayout>
        );
    }
}
