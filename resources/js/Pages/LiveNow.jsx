import React from "react";
import { Head, usePage } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";
import SecondaryButton from "@/Components/SecondaryButton";
import { RiLiveLine } from "react-icons/ri";
import { Inertia } from "@inertiajs/inertia";
import ChannelsLoop from "@/Components/ChannelsLoop";
import Front from "@/Layouts/Front";

export default function LiveNow({ channels }) {
    const { categories } = usePage().props;

    return (
        <Front containerClass="w-full">
            <Head title={__("Channels Streaming Live Now")} />

            <div className="p-2">
                <div className="flex items-center flex-wrap">
                    <div>
                        <RiLiveLine className="text-2xl text-pink-600 mr-1 h-6 w-6" />
                    </div>
                    <div className="ml-2">
                        <h3 className="text-2xl font-medium text-gray-600 dark:text-white">
                            {__("Channels Live Streaming Right Now")}
                        </h3>
                    </div>
                </div>

                {channels.total === 0 && (
                    <div className="flex items-center">
                        <img
                            src="/images/channels-offline.png"
                            alt=""
                            className="h-8"
                        />
                        <h3 className="ml-3 text-lg text-gray-600 font-light dark:text-gray-400">
                            {__("No one is live streaming at the moment.")}
                        </h3>
                    </div>
                )}

                <div className="mt-5">
                    <ChannelsLoop channels={channels.data} />

                    {channels.last_page > 1 && (
                        <>
                            <div className="flex text-gray-600 mt-10 mb-5 text-sm">
                                {__("Page: :pageNumber of :lastPage", {
                                    pageNumber: channels.current_page,
                                    lastPage: channels.last_page,
                                })}
                            </div>

                            <SecondaryButton
                                processing={
                                    channels.prev_page_url ? false : true
                                }
                                className="mr-3"
                                onClick={(e) =>
                                    Inertia.visit(channels.prev_page_url)
                                }
                            >
                                {__("Previous")}
                            </SecondaryButton>

                            <SecondaryButton
                                processing={
                                    channels.next_page_url ? false : true
                                }
                                onClick={(e) =>
                                    Inertia.visit(channels.next_page_url)
                                }
                            >
                                {__("Next")}
                            </SecondaryButton>
                        </>
                    )}
                </div>
            </div>
        </Front>
    );
}
