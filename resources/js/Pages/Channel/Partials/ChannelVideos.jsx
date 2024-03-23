import { useState, useEffect } from "react";
import __ from "@/Functions/Translate";
import axios from "axios";
import { toast } from "react-toastify";
import Spinner from "@/Components/Spinner";
import { MdGeneratingTokens } from "react-icons/md";
import { Link } from "@inertiajs/inertia-react";
import { Tooltip } from "react-tooltip";
import "react-tooltip/dist/react-tooltip.css";
import { AiOutlineEye } from "react-icons/ai";
import SecondaryButton from "@/Components/SecondaryButton";
import Modal from "@/Components/Modal";
import SingleVideo from "@/Pages/Videos/SingleVideo";

export default function ChannelVideos({ streamUser }) {
    const [videos, setVideos] = useState({});
    const [loading, setLoading] = useState(true);
    const [playVideo, setPlayVideo] = useState(false);
    const [modal, setModal] = useState(false);

    const playModal = (e, video) => {
        e.preventDefault();
        setPlayVideo(video);
        setModal(true);
    };

    useEffect(() => {
        getVideos(1);
    }, []);

    const getVideos = (page) => {
        axios
            .get(
                `${route("channel.videos", {
                    user: streamUser.id,
                })}?page=${page}`
            )
            .then((resp) => {
                setVideos(resp.data);
                setLoading(false);
            })
            .catch((Err) => toast.error(Err.response?.data?.message));
    };

    return (
        <div className="mt-5">
            {loading && (
                <div className="my-3">
                    <Spinner />
                </div>
            )}

            <Modal show={modal} onClose={(e) => setModal(false)}>
                {playVideo && <SingleVideo video={playVideo} inModal={true} />}
            </Modal>

            <div className="grid grid-cols-1 gap-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4">
                {videos.data &&
                    videos.data.map((v) => (
                        <div
                            className="mb-4 pb-2 w-full bg-white dark:bg-zinc-900 shadow rounded-lg"
                            key={`video-${v.id}`}
                        >
                            <div className="relative">
                                <button onClick={(e) => playModal(e, v)}>
                                    <img
                                        src={v.thumbnail}
                                        className="rounded-t-lg mb-3 "
                                        alt=""
                                    />
                                </button>
                                <div className="absolute top-5 left-0 bg-indigo-800 text-white font-bold text-sm uppercase rounded-tr rounded-br px-2 py-1">
                                    {v.price < 1 ? (
                                        __("Free")
                                    ) : (
                                        <div className="flex items-center">
                                            <MdGeneratingTokens className="h-4 w-4 mr-1" />
                                            {v.price}
                                        </div>
                                    )}
                                </div>
                            </div>
                            <div className="inline-flex items-start px-2">
                                <div className="w-10 flex-shrink-0 mr-2">
                                    <Link
                                        href={route("channel", {
                                            user: v.streamer.username,
                                        })}
                                    >
                                        <img
                                            src={v.streamer.profile_picture}
                                            className="w-10 h-10 rounded-full"
                                        />
                                    </Link>
                                </div>
                                <div>
                                    <div className="h-5 overflow-hidden">
                                        <a
                                            data-tooltip-content={v.title}
                                            data-tooltip-id={`tooltip-btn-${v.id}`}
                                            onClick={(e) => playModal(e, v)}
                                            className="cursor-pointer font-semibold inline  dark:text-gray-100 hover:text-gray-800 text-gray-600 dark:hover:text-gray-400"
                                        >
                                            {v.title}
                                        </a>
                                    </div>
                                    <div className="mt-1.5 flex items-center text-xs text-gray-500 dark:text-gray-200">
                                        <div>
                                            <Link
                                                href={route("channel", {
                                                    user: v.streamer.username,
                                                })}
                                            >
                                                @{v.streamer.username}
                                            </Link>

                                            <Tooltip anchorSelect="a" />
                                        </div>
                                        <div className="ml-2 inline-flex items-center">
                                            <AiOutlineEye className="w-4 h-4 mr-0.5" />
                                            {v.views === 1
                                                ? __("1 view")
                                                : __(":viewsCount views", {
                                                      viewsCount: v.views,
                                                  })}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ))}
            </div>

            {videos.total > 9 && (
                <>
                    <SecondaryButton
                        className="mr-2"
                        processing={videos.prev_page_url ? false : true}
                        onClick={(e) => getVideos(videos.current_page - 1)}
                    >
                        {__("Prev")}
                    </SecondaryButton>

                    <SecondaryButton
                        processing={videos.next_page_url ? false : true}
                        onClick={(e) => getVideos(videos.current_page + 1)}
                    >
                        {__("Next")}
                    </SecondaryButton>
                </>
            )}
            {videos.total === 0 && (
                <div className="dark:text-white dark:bg-zinc-900 rounded-lg px-3 py-5 text-gray-600 bg-white shadow">
                    {__("No videos uploaded by :streamer", {
                        streamer: streamUser.username,
                    })}
                </div>
            )}
        </div>
    );
}
