import Spinner from "@/Components/Spinner";
import __ from "@/Functions/Translate";
import axios from "axios";
import { useState, useEffect } from "react";
import { toast } from "react-toastify";
import { FaGrinStars } from "react-icons/fa";
import nl2br from "react-nl2br";
import { MdGeneratingTokens } from "react-icons/md";
import { AiOutlineArrowRight } from "react-icons/ai";
import { Inertia } from "@inertiajs/inertia";

export default function TiersTab({ user }) {
    const [loading, setLoading] = useState(true);
    const [tiers, setTiers] = useState([]);
    const [tierSubscribed, setTierSubscribed] = useState(0);

    const getTiers = () => {
        axios
            .get(route("streaming.getTiers", { user: user.id }))
            .then((resp) => {
                setTiers(resp.data);
                setLoading(false);
            })
            .catch((Err) => toast.error(Err.response?.data?.message));
    };

    const getSubscriptionStatus = () => {
        setLoading(true);
        axios
            .get(route("subscription.isSubscribed", { user: user.id }))
            .then((resp) => {
                setLoading(false);
                setTierSubscribed(resp.data);
            });
    };

    useEffect(() => {
        getTiers();
        getSubscriptionStatus();
    }, []);

    if (loading) return <Spinner />;

    return (
        <>
            <div className={`dark:text-zinc-200 mt-5`}>
                {tiers.length === 0 &&
                    __("Streamer did not set any membership options yet.")}
                {tiers.map((tier) => (
                    <div
                        key={`tier-${tier.id}`}
                        className={`flex flex-col md:items-center md:flex-row md:space-x-10 border-b py-5 bg-white dark:bg-zinc-900 dark:border-b-zinc-800 rounded-lg shadow-sm mb-5 px-5  ${
                            tier.id === tierSubscribed &&
                            "bg-gray-200 dark:bg-gray-900 rounded"
                        } ${tierSubscribed !== 0 && "px-2"}`}
                    >
                        <div className="text-indigo-800 dark:text-indigo-200 font-bold text-lg w-32">
                            {tier.tier_name}
                        </div>
                        <div className="text-indigo-800  w-full md:w-56 dark:text-indigo-200  rounded font-bold">
                            <MdGeneratingTokens className="h-6 w-6 inline-flex mr-1" />
                            {__(":tierPrice Tokens / Month", {
                                tierPrice: tier.price,
                            })}
                        </div>
                        <div className="text-gray-600 dark:text-white flex-grow">
                            {nl2br(tier.perks)}
                        </div>
                        <div>
                            {tierSubscribed === tier.id &&
                                __("You are subscribed to this tier")}
                            {tierSubscribed === 0 && (
                                <button
                                    className="py-1 h-8 w-32 text-sm px-3 mt-2 border-2 rounded-md border-gray-700 dark:border-gray-100 dark:text-gray-200 dark:hover:border-indigo-300 dark:hover:text-indigo-300 text-gray-700 hover:border-indigo-600 hover:text-indigo-600"
                                    onClick={(e) =>
                                        Inertia.visit(
                                            route("subscribe", {
                                                channel: user.username,
                                                tier: tier.id,
                                            })
                                        )
                                    }
                                >
                                    <div className="flex items-center">
                                        <FaGrinStars className="mr-2" />
                                        <span>{__("Subscribe")}</span>
                                        <AiOutlineArrowRight className="ml-1" />
                                    </div>
                                </button>
                            )}
                        </div>
                    </div>
                ))}
            </div>
        </>
    );
}
