import Modal from "@/Components/Modal";
import { useState } from "react";
import SecondaryButton from "@/Components/SecondaryButton";
import __ from "@/Functions/Translate";
import { FaGrinStars } from "react-icons/fa";
import axios from "axios";
import { toast } from "react-toastify";
import Spinner from "@/Components/Spinner";
import nl2br from "react-nl2br";
import { MdGeneratingTokens } from "react-icons/md";
import { AiOutlineArrowRight } from "react-icons/ai";
import { Link, usePage } from "@inertiajs/inertia-react";
import { Inertia } from "@inertiajs/inertia";

export default function SubscribePopup({ user, userIsSubscribed }) {
    const [show, setShow] = useState(false);
    const [tiers, setTiers] = useState([{}]);
    const [loading, setLoading] = useState(true);

    const getTiers = () => {
        axios
            .get(route("streaming.getTiers", { user: user.id }))
            .then((resp) => {
                setTiers(resp.data);
                setLoading(false);
            })
            .catch((Err) => toast.error(Err.response?.data?.message));
    };

    const showSubscribe = (e) => {
        e.preventDefault();
        setShow(true);
        getTiers();
    };

    return (
        <>
            {!userIsSubscribed ? (
                <SecondaryButton onClick={(e) => showSubscribe(e)}>
                    <FaGrinStars className="mr-1" />
                    {__("Subscribe")}
                </SecondaryButton>
            ) : (
                <SecondaryButton
                    onClick={(e) => Inertia.visit(route("mySubscriptions"))}
                >
                    <FaGrinStars className="mr-1" />
                    {__("Subscriptions")}
                </SecondaryButton>
            )}
            <Modal show={show} onClose={(e) => setShow(false)} maxWidth="xs">
                <div className="text-center bg-white">
                    <div className="relative">
                        <img
                            src={user.cover_picture}
                            alt=""
                            className="h-24 rounded-tr rounded-tl w-full"
                        />
                        <div className="absolute top-5 left-0 bg-indigo-800 text-white font-bold text-sm uppercase rounded-tr rounded-br px-2 py-1">
                            {__("Select Tier")}
                        </div>
                    </div>
                    <div className="mx-auto border-2 border-white bg-white  shadow rounded-full mt-[-50px] w-20 h-20 z-10 relative">
                        <img
                            src={user.profile_picture}
                            alt=""
                            className="w-full rounded-full"
                        />
                    </div>
                    <center>{loading && <Spinner />}</center>

                    <div className="py-3">
                        {tiers.length === 0 &&
                            __(
                                "Streamer did not set any membership options yet."
                            )}
                        {tiers.map((tier) => (
                            <div key={`tier-${tier.id}`} className="mb-4">
                                <h3 className="text-indigo-800 text-lg">
                                    {tier.tier_name}
                                </h3>
                                <span className="text-indigo-800 text-sm px-1.5 py-1 rounded font-bold">
                                    <MdGeneratingTokens className="h-4 w-4 inline-flex mr-1 mb-1" />
                                    {__(":tierPrice Tokens / Month", {
                                        tierPrice: tier.price,
                                    })}
                                </span>
                                <div className="text-gray-600 mt-1 px-2">
                                    {nl2br(tier.perks)}
                                </div>
                                <Link
                                    href={route("subscribe", {
                                        channel: user.username,
                                        tier: tier.id || 123,
                                    })}
                                    className="py-1 text-sm px-3 mt-2 inline-flex border-2 rounded-md border-gray-700 text-gray-700 items-center hover:border-indigo-600 hover:text-indigo-600"
                                >
                                    <FaGrinStars className="mr-2" />
                                    <span>{__("Subscribe")}</span>
                                    <AiOutlineArrowRight className="ml-1" />
                                </Link>
                            </div>
                        ))}
                    </div>
                </div>
            </Modal>
        </>
    );
}
