import __ from "@/Functions/Translate";

export default function HomepageHeader() {
    return (
        <>
            <div className="homepage-header-bg dark:bg-none">
                <div className="max-w-7xl mx-auto pt-10 lg:flex items-center justify-between">
                    <div className="w-full homepage-text-container px-4 lg:w-96">
                        <h1 className="font-extrabold text-5xl lg:text-6xl heading-gradient px-4">
                            {__("Live Streaming at your fingertips")}
                        </h1>
                        <h2 className="text-3xl mt-10  dark:text-zinc-200 px-4">
                            {__(
                                "Stream & watch live video streams directly from your browser"
                            )}
                        </h2>
                    </div>
                    <div className="max-w-3xl">
                        <img src="/images/homepage-icon.png" alt="" />
                    </div>
                </div>
            </div>
            <div className="bg-slate-50 dark:bg-black">
                <div className="w-full bg-slate-100 dark:bg-black py-10">
                    <div className="max-w-7xl mx-auto px-4">
                        <h2 className="text-indigo-900  dark:text-zinc-200 text-4xl text-center font-bold">
                            {__("Learn why Creators love our platform")}
                        </h2>
                    </div>
                </div>
                <div className="max-w-7xl mx-auto">
                    <div className="md:flex md:flex-wrap">
                        <div className="lg:flex md:w-1/2 items-center py-10 px-5">
                            <div className="mr-5 w-48 flex-shrink-0">
                                <img
                                    src="/images/streaming-service.png"
                                    alt="live streaming"
                                    className="w-full"
                                />
                            </div>
                            <div>
                                <h3 className="text-indigo-900 dark:text-zinc-200 text-4xl font-semibold mt-5 lg:mt-0">
                                    {__("Live Streaming")}
                                </h3>
                                <h4 className="text-indigo-900 dark:text-zinc-100 text-xl mt-5">
                                    {__(
                                        "Stream directly from your browser. No additional complicated software to install. All you need is your computer & a camera."
                                    )}
                                </h4>
                            </div>
                        </div>
                        {/* ./lg:flex (zero commissions )*/}
                        {/*no-commissions*/}
                        <div className="lg:flex md:w-1/2 items-center py-10 px-5">
                            <div className="mr-5 w-48 flex-shrink-0">
                                <img
                                    src="/images/chat-service.png"
                                    alt="chat"
                                    className="w-full"
                                />
                            </div>
                            <div>
                                <h3 className="text-indigo-900 dark:text-zinc-200 text-4xl font-semibold mt-5 lg:mt-0">
                                    {__("Live Chat")}
                                </h3>
                                <h4 className="text-indigo-900 dark:text-zinc-100 text-xl mt-5">
                                    {__(
                                        "What would be a live stream without interaction? Your audience can interact with you and each other."
                                    )}
                                </h4>
                            </div>
                        </div>
                        {/* ./lg-flex (donations) */}
                        <div className="lg:flex md:w-1/2 items-center py-10 px-5">
                            <div className="mr-5 md:w-48 flex-shrink-0 w-40">
                                <img
                                    src="/images/sub-service.png"
                                    alt="goals"
                                    className="w-full"
                                />
                            </div>
                            <div>
                                <h3 className="text-indigo-900 dark:text-zinc-200 text-4xl font-semibold mt-5 lg:mt-0">
                                    {__("Subscription Tiers")}
                                </h3>
                                <h4 className="text-indigo-900 dark:text-zinc-100 text-xl mt-5">
                                    {__(
                                        "Get recurring revenue from your fan base via membership tiers. You can offer 1, 6 and 12 months with discounts option."
                                    )}
                                </h4>
                            </div>
                        </div>
                        {/* ./lg:flex => memberships*/}
                        <div className="lg:flex md:w-1/2 items-center py-10 px-5">
                            <div className="mr-5 w-48 flex-shrink-0">
                                <img
                                    src="/images/tips-service.png"
                                    alt="tips"
                                    className="w-full"
                                />
                            </div>
                            <div>
                                <h3 className="text-indigo-900 dark:text-zinc-200 text-4xl font-semibold">
                                    {__("Tips")}
                                </h3>
                                <h4 className="text-indigo-900 dark:text-zinc-100 text-xl mt-5">
                                    {__(
                                        "Every creator has it's fans - the moment you get your first rewarding is an incredible appreciation sign for your hard work"
                                    )}
                                </h4>
                            </div>
                        </div>
                        {/* ./lg:flex => sell-products */}
                    </div>
                    {/* second row of info icons */}
                </div>
            </div>
        </>
    );
}
