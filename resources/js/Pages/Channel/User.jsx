import React from "react";
import { Head } from "@inertiajs/inertia-react";
import Front from "@/Layouts/Front";
import __ from "@/Functions/Translate";
import { useState } from "react";
import axios from "axios";
import PrimaryButton from "@/Components/PrimaryButton";
import { toast } from "react-toastify";
import { FaHandSparkles } from "react-icons/fa";
import ProfileTabs from "./Partials/ProfileTabs";
import { Inertia } from "@inertiajs/inertia";
import SubscribePopup from "./Partials/SubscribePopup";

export default function StartStream({
    user,
    streamUser,
    userFollowsChannel,
    userIsSubscribed,
}) {
    const [activeTab, setActiveTab] = useState("Videos");

    const coverBg = {
        backgroundImage: `url(${streamUser.cover_picture})`,
    };

    const followUser = () => {
        if (!user) {
            toast.error(__("Please login to follow this channel"));
        } else {
            axios
                .get(route("follow", { user: streamUser.id }))
                .then((apiRes) => {
                    console.log(
                        Inertia.reload({
                            only: ["userFollowsChannel", "streamUser"],
                        })
                    );
                })
                .catch((Error) => toast.error(Error.response?.data?.error));
        }
    };

    return (
        <Front>
            {/* STREAMING CENTER CONTENTS */}
            <div className="-mt-[60px] max-w-5xl mx-auto">
                <Head
                    title={__(":channelName's channel (:handle)", {
                        channelName: streamUser.name,
                        handle: `@${streamUser.username}`,
                    })}
                >
                    <meta property="og:title" content="The Rock" />
                    <meta
                        property="og:url"
                        content="https://www.imdb.com/title/tt0117500/"
                    />
                    <meta
                        property="og:image"
                        content="https://ia.media-imdb.com/images/rock.jpg"
                    />
                </Head>

                <div className="coverPic" style={coverBg}></div>

                <div className="flex items-center flex-wrap justify-between bg-white dark:bg-zinc-900 text-gray-700 -mt-2 rounded-b-lg px-3 pt-5 pb-4 shadow">
                    <div className="flex items-center">
                        <div className="relative">
                            <div className="border-4 border-white shadow rounded-full -mt-[63px] z-10 ml-2">
                                <img
                                    src={streamUser.profile_picture}
                                    alt=""
                                    className="cursor-pointer rounded-full w-24 h-24 dark:border-red-100"
                                />
                            </div>
                        </div>
                        <div className="ml-3 pb-2">
                            <h3 className="dark:text-white text-xl lg:text-2xl text-indigo-700 font-bold">
                                {streamUser.name}
                            </h3>

                            <p className="text-indigo-800 dark:text-white">
                                @{streamUser.username}
                            </p>
                        </div>
                    </div>
                    <div className="flex flex-col md:flex-row md:items-center space-y-2 md:space-y-0 md:space-x-2">
                        <PrimaryButton onClick={(e) => followUser()}>
                            <FaHandSparkles className="mr-1" />
                            {userFollowsChannel ? __("Unfollow") : __("Follow")}
                        </PrimaryButton>
                        <SubscribePopup
                            user={streamUser}
                            userIsSubscribed={userIsSubscribed}
                        />
                    </div>
                </div>

                <ProfileTabs
                    streamUser={streamUser}
                    activeTab={activeTab}
                    setActiveTab={setActiveTab}
                />
            </div>
        </Front>
    );
}
