import { Head, usePage, Link } from "@inertiajs/inertia-react";
import Front from "@/Layouts/Front";
import __ from "@/Functions/Translate";
import { MdOutlinePeople, MdVideoLibrary } from "react-icons/md";
import ChannelsLoop from "@/Components/ChannelsLoop";
import { RiLiveLine } from "react-icons/ri";
import VideosLoop from "./Videos/Partials/VideosLoop";
import { useEffect } from "react";
import { Inertia } from "@inertiajs/inertia";
import { BiUserPlus } from "react-icons/bi";

export default function Homepage({
    channels,
    livenow,
    videos,
    meta_title,
    meta_keys,
    meta_description,
    hide_live_channels,
}) {
    const { flash } = usePage().props;

    const influencerIcon = "/images/streamer-icon.png";
    const userIcon = "/images/user-signup-icon.png";

    useEffect(() => {
        // listen for live streaming events
        window.Echo.channel("LiveStreamRefresh").listen(
            ".livestreams.refresh",
            (data) => {
                console.log(`refresh livestreams`);
                Inertia.reload();
            }
        );
    }, []);

    return (
        <Front containerClass="w-full" headerShow={true}>
            <Head>
                <title>{meta_title}</title>
                <meta name="description" content={meta_description} />
                <meta name="keywords" content={meta_keys} />
            </Head>

            {livenow.length > 0 && (
                <div className="mb-20">
                    <div
                        className={`flex justify-center items-center mt-20 mb-8`}
                    >
                        <RiLiveLine className="text-pink-600 text-4xl mr-1" />
                        <h2 className="text-indigo-900 text-center dark:text-zinc-200 text-4xl font-bold">
                            {__("Live Channels")}
                        </h2>
                    </div>

                    <ChannelsLoop channels={livenow} />
                </div>
            )}

            <div className={`flex justify-center items-center mt-10 mb-8`}>
                <MdOutlinePeople className="text-pink-600 text-4xl mr-1" />
                <h2 className="text-indigo-900 text-center dark:text-zinc-200 text-4xl font-semibold">
                    {__("Discover Channels")}
                </h2>
            </div>

            {channels.length < 1 && (
                <div className="text-center text-xl font-medium dark:text-white text-gray-700">
                    {__("No channels to show")}
                </div>
            )}
            <ChannelsLoop channels={channels} />

            {channels.length > 0 && (
                <div className="mx-auto text-center mt-10">
                    <Link
                        href={route("channels.browse")}
                        className="px-8 bg-violet-700 hover:bg-violet-500 dark:bg-zinc-800 dark:hover:bg-zinc-900 text-white font-semibold text-lg py-2.5 rounded-lg"
                    >
                        {__("View All Channels")}
                    </Link>
                </div>
            )}

            <div className={`flex justify-center items-center mt-20 mb-8`}>
                <MdVideoLibrary className="text-pink-600 text-4xl mr-1" />
                <h2 className="text-indigo-900 text-center dark:text-zinc-200 text-4xl font-semibold">
                    {__("Latest Videos")}
                </h2>
            </div>

            <div className="mb-8">
                {videos.length < 1 && (
                    <div className="text-center text-xl font-medium dark:text-white text-gray-700">
                        {__("No videos to show")}
                    </div>
                )}
                <VideosLoop videos={videos} />
            </div>

            {videos.length > 0 && (
                <div className="mx-auto text-center mt-10">
                    <Link
                        href={route("videos.browse")}
                        className="px-8 bg-violet-700 hover:bg-violet-500 dark:bg-zinc-800 dark:hover:bg-zinc-900 text-white font-semibold text-lg py-2.5 rounded-lg"
                    >
                        {__("View All Videos")}
                    </Link>
                </div>
            )}

            <div className="mt-20 flex items-center flex-col lg:flex-row flex-wrap border-t px-5 dark:border-zinc-800">
                <div
                    className={`flex flex-col justify-center items-center mb-8`}
                >
                    <BiUserPlus className="text-pink-600 text-4xl mr-1" />
                    <h2 className="text-indigo-900 text-center dark:text-zinc-200 text-4xl font-semibold">
                        {__("Join Our Platform")}
                    </h2>
                    <p className="text-lg mt-2 text-gray-600 font-medium dark:text-white">
                        {__("We are welcoming both Streamers and Users")}
                    </p>
                    <p className="text-lg text-gray-600 font-medium dark:text-white">
                        {__(
                            "It's completely free to join both as an user or as a streamer"
                        )}
                    </p>
                </div>

                <div className="max-w-lg mx-auto">
                    <div className="grid grid-cols-2 mt-10 gap-5">
                        <div className="col text-center">
                            <Link href={route("streamer.signup")}>
                                <img
                                    src={influencerIcon}
                                    alt=""
                                    className="max-h-96 rounded-full mx-auto border-zinc-200 dark:border-indigo-200 border-4"
                                />
                            </Link>
                            <Link
                                href={route("streamer.signup")}
                                className="bg-pink-600  text-white font-bold py-2 px-4 rounded mb-4 hover:bg-pink-500 mt-5 inline-block"
                            >
                                {__("I'm a Streamer")}
                            </Link>
                        </div>
                        <div className="col text-center">
                            <Link href={route("register")}>
                                <img
                                    src={userIcon}
                                    alt=""
                                    className="max-h-96 rounded-full mx-auto border-zinc-200  dark:border-indigo-200 border-4"
                                />
                            </Link>
                            <Link
                                href={route("register")}
                                className="bg-indigo-700 inline-block mt-5 text-white font-bold py-2 px-4 rounded mb-4 hover:bg-indigo-600"
                            >
                                {__("I am an User")}
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </Front>
    );
}
