import { AiOutlineMenuUnfold } from "react-icons/ai";
import { RiLoginBoxLine } from "react-icons/ri";
import { BiUserPlus, BiSearchAlt } from "react-icons/bi";
import {
    MdDarkMode,
    MdGeneratingTokens,
    MdOutlineVideoLibrary,
} from "react-icons/md";
import { BsFillSunFill, BsSlashSquare } from "react-icons/bs";
import { BiUserCircle } from "react-icons/bi";
import { Link } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";
import { usePage } from "@inertiajs/inertia-react";
import { useState, useEffect } from "react";
import Dropdown from "@/Components/Dropdown";
import Modal from "@/Components/Modal";
import { toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import debounce from "lodash.debounce";
import axios from "axios";
import TextInput from "./TextInput";
import { FaChromecast } from "react-icons/fa";
import { RxCaretDown } from "react-icons/rx";

export default function TopNavi({ children }) {
    const { logo, logo_day, auth, pages } = usePage().props;

    const [isDarkMode, setIsDarkMode] = useState("no");
    const [showSearch, setShowSearch] = useState(false);

    const [results, setResults] = useState([]);

    const { flash } = usePage().props;

    useEffect(() => {
        if (flash?.message) {
            toast(flash.message);
        }
    }, [flash]);

    useEffect(() => {
        if (localStorage.getItem("is-dark-mode")) {
            setIsDarkMode(localStorage.getItem("is-dark-mode"));
        }

        if (isDarkMode == "yes") {
            document.body.classList.add("dark");
            document.body.classList.add("bg-black");
            document.body.classList.remove("bg-slate-50");
        } else {
            document.body.classList.remove("dark");
            document.body.classList.remove("bg-black");
            document.body.classList.add("bg-slate-50");
        }
    }, [isDarkMode]);

    const switchDarkMode = () => {
        if (isDarkMode == "no") {
            document.body.classList.add("dark");
            localStorage.setItem("is-dark-mode", "yes");
            setIsDarkMode("yes");
        } else {
            document.body.classList.remove("dark");
            document.body.classList.remove("bg-black");
            localStorage.setItem("is-dark-mode", "no");
            setIsDarkMode("no");
        }
    };

    const updateTerm = debounce((e) => {
        console.log(`debounced term updated to: ${e.target.value}`);

        if (e.target.value.length > 2) {
            axios
                .get(route("channel.search"), {
                    params: { term: e.target.value },
                })
                .then((resp) => setResults(resp.data))
                .catch((Error) => toast(Error.response?.data?.message));
        } else {
            setResults([]);
        }
    }, 500);

    return (
        <div className="fixed inset-x-0 z-10 bg-violet-800 border-b-2 border-violet-800 dark:bg-zinc-900 dark:border-b-2 dark:border-zinc-800">
            <Modal
                show={showSearch}
                closeable={true}
                onClose={(e) => setShowSearch(false)}
            >
                <div className="p-3">
                    <TextInput
                        className={"w-full mb-5"}
                        handleChange={(e) => updateTerm(e)}
                        type="text"
                        placeholder={__("Search Channels")}
                        isFocused={true}
                    />
                    {results.length === 0 && (
                        <div className="dark:text-white">
                            {__("No results")}
                        </div>
                    )}

                    {results.map((sr) => {
                        return (
                            <div
                                key={`sr-${sr.id}`}
                                className="flex items-center mt-2 space-x-2"
                            >
                                <div>
                                    <Link
                                        href={route("channel", {
                                            user: sr.username,
                                        })}
                                    >
                                        <img
                                            src={sr.profile_picture}
                                            alt=""
                                            className="rounded-full h-14 border-zinc-200 dark:border-indigo-200 border"
                                        />
                                    </Link>
                                </div>
                                <div className="grow">
                                    <Link
                                        className="block text-gray-600 dark:text-gray-300 font-semibold mt-1 ml-1"
                                        href={route("channel", {
                                            user: sr.username,
                                        })}
                                    >
                                        {sr.name}
                                    </Link>
                                    <Link
                                        className="block text-sky-500 hover:text-sky-600 font-semibold mt-1 ml-1"
                                        href={route("channel", {
                                            user: sr.username,
                                        })}
                                    >
                                        @{sr.username}
                                    </Link>
                                </div>
                            </div>
                        );
                    })}
                </div>
            </Modal>

            <div className="h-[58px] flex justify-between items-center px-2 py-4 max-w-7xl mx-auto">
                <div className="flex items-center">
                    <Link href={route("home")}>
                        <img src={logo} alt="logo" className="h-8 mr-1 mt-1" />
                    </Link>
                </div>

                <div className="flex items-center">
                    <Link
                        href={route("home")}
                        className="hidden md:inline-flex items-center text-white text-lg hover:text-indigo-200 font-semibold"
                    >
                        <BsSlashSquare className="mr-1" />
                        {__("Home")}
                    </Link>
                    <Link
                        href={route("channels.browse")}
                        className="ml-5 hidden md:inline-flex items-center text-white text-lg hover:text-indigo-200 font-semibold"
                    >
                        <span>
                            <FaChromecast className="mr-1" />
                        </span>
                        <span>{__("Channels")}</span>
                    </Link>
                    <Link
                        href={route("videos.browse")}
                        className="ml-5 hidden md:inline-flex items-center text-white text-lg hover:text-indigo-200 font-semibold"
                    >
                        <span>
                            <MdOutlineVideoLibrary className="mr-1" />
                        </span>
                        <span>{__("Videos")}</span>
                    </Link>
                    <Link
                        href={route("token.packages")}
                        className="ml-5 hidden md:inline-flex items-center text-white text-lg hover:text-indigo-200 font-semibold"
                    >
                        <span>
                            <MdGeneratingTokens className="h-6 w-6 mr-1" />
                        </span>
                        <span>{__("Token Packs")}</span>
                    </Link>

                    {!auth.user ? (
                        <>
                            <Link
                                className="ml-4 hidden md:block text-white hover:text-indigo-200 border border-white hover:border-indigo-200 p-1 rounded-lg px-4 font-semibold"
                                href={route("login")}
                            >
                                {__("Login")}
                            </Link>
                            <Link
                                href={route("signup")}
                                className="hidden md:block bg-violet-600 p-1.5 rounded-lg border-violet-600 font-semibold px-4 text-zinc-200 ml-2 hover:bg-violet-500"
                            >
                                {__("Signup")}
                            </Link>
                            <Link href={route("login")} className="md:hidden">
                                <RiLoginBoxLine className="md:hidden mr-1 w-6 h-6  text-white cursor-pointer hover:bg-indigo-900 hover:text-white hover:rounded" />
                            </Link>
                            <Link href={route("signup")}>
                                <BiUserPlus className="md:hidden mr-1 w-6 h-6  text-white cursor-pointer hover:bg-indigo-900 hover:text-white hover:rounded " />
                            </Link>
                        </>
                    ) : (
                        <>
                            <Dropdown>
                                <Dropdown.Trigger>
                                    <div className="relative inline-flex mt-1 ml-2">
                                        <BiUserCircle className="mr-1 w-6 h-6 text-white cursor-pointer hover:text-indigo-400" />
                                        <div className="absolute inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-white bg-red-500 rounded-full -top-1 -left-1">
                                            {auth.unreadNotifications}
                                        </div>
                                        <div className="hidden md:inline-flex items-center cursor-pointer text-white font-semibold hover:text-indigo-400 pt-0.5">
                                            {__(auth.user.firstName)}
                                            <RxCaretDown />
                                        </div>
                                    </div>
                                </Dropdown.Trigger>

                                <Dropdown.Content>
                                    <Dropdown.Link
                                        href={`${
                                            auth.user.is_streamer === "yes"
                                                ? route("payout.withdraw")
                                                : route("profile.myTokens")
                                        }`}
                                    >
                                        <span className="flex items-center bg-green-100 text-green-700 text-xs font-bold justify-center py-1 rounded-lg">
                                            <MdGeneratingTokens className="h-5 w-5" />
                                            {auth.user.tokens}
                                        </span>
                                    </Dropdown.Link>
                                    {auth.user.is_streamer === "yes" && (
                                        <Dropdown.Link
                                            href={route("channel", {
                                                user: auth.user.username,
                                            })}
                                        >
                                            {__("My Channel")}
                                        </Dropdown.Link>
                                    )}
                                    {auth.user.is_streamer === "yes" && (
                                        <Dropdown.Link
                                            href={route("channel.settings")}
                                        >
                                            {__("Channel Settings")}
                                        </Dropdown.Link>
                                    )}

                                    <Dropdown.Link
                                        href={route("notifications.inbox")}
                                    >
                                        {__("Notifications")}
                                        <span className="bg-red-100 text-red-500 text-xs font-medium ml-2 px-1.5 py-0.5 rounded-full dark:bg-red-500 dark:text-red-100">
                                            {__(
                                                ":unreadNotificationsCount new",
                                                {
                                                    unreadNotificationsCount:
                                                        auth.unreadNotifications,
                                                }
                                            )}
                                        </span>
                                    </Dropdown.Link>
                                    {auth.user.is_streamer === "yes" && (
                                        <Dropdown.Link
                                            href={route("payout.withdraw")}
                                        >
                                            {__("Withdraw")}
                                        </Dropdown.Link>
                                    )}

                                    {auth.user.is_streamer === "yes" && (
                                        <Dropdown.Link
                                            href={route("membership.set-tiers")}
                                        >
                                            {__("Membership Tiers")}
                                        </Dropdown.Link>
                                    )}

                                    {auth.user.is_streamer === "yes" && (
                                        <Dropdown.Link
                                            href={route("videos.list")}
                                        >
                                            {__("Upload Videos")}
                                        </Dropdown.Link>
                                    )}

                                    <Dropdown.Link
                                        href={route("videos.ordered")}
                                    >
                                        {__("My Videos")}
                                    </Dropdown.Link>

                                    {auth.user.is_streamer === "yes" && (
                                        <Dropdown.Link
                                            href={route("channel.followers", {
                                                user: auth.user.username,
                                            })}
                                        >
                                            {__("My Followers")}
                                        </Dropdown.Link>
                                    )}

                                    {auth.user.is_streamer === "yes" && (
                                        <Dropdown.Link
                                            href={route("mySubscribers")}
                                        >
                                            {__("My Subscribers")}
                                        </Dropdown.Link>
                                    )}

                                    <Dropdown.Link
                                        href={route("profile.followings")}
                                    >
                                        {__("My Followings")}
                                    </Dropdown.Link>
                                    <Dropdown.Link
                                        href={route("mySubscriptions")}
                                    >
                                        {__("My Subscriptions")}
                                    </Dropdown.Link>

                                    <Dropdown.Link href={route("profile.edit")}>
                                        {__("My Account")}
                                    </Dropdown.Link>

                                    <Dropdown.Link
                                        href={route("logout")}
                                        method="post"
                                        as="button"
                                    >
                                        {__("Logout")}
                                    </Dropdown.Link>
                                </Dropdown.Content>
                            </Dropdown>
                        </>
                    )}

                    <Dropdown>
                        <Dropdown.Trigger>
                            <AiOutlineMenuUnfold
                                className={`ml-2 w-6 h-6 text-white cursor-pointer hover:text-indigo-200 md:hidden`}
                            />
                        </Dropdown.Trigger>
                        <Dropdown.Content>
                            <div className="flex pl-4 pt-2 text-gray-500 dark:text-white font-bold">
                                {__("Menu")}
                            </div>
                            <Dropdown.Link href={route("home")}>
                                {__("Home")}
                            </Dropdown.Link>
                            <Dropdown.Link href={route("token.packages")}>
                                <div className="flex items-center justify-between">
                                    <div>{__("Get Tokens")}</div>
                                    <div>
                                        <MdGeneratingTokens className="h-6 w-6" />
                                    </div>
                                </div>
                            </Dropdown.Link>

                            <Dropdown.Link href={route("videos.browse")}>
                                {__("Browse Videos")}
                            </Dropdown.Link>
                            <Dropdown.Link href={route("channels.browse")}>
                                {__("Discover Channels")}
                            </Dropdown.Link>
                            <div className="flex pl-4 pt-2 text-gray-500 dark:text-white font-bold">
                                {__("General")}
                            </div>
                            <Dropdown.Link href={route("contact.form")}>
                                {__("Get In Touch")}
                            </Dropdown.Link>

                            {pages.map((p) => (
                                <Dropdown.Link
                                    key={`page-${p.id}`}
                                    href={route("page", { page: p.page_slug })}
                                >
                                    {p.page_title}
                                </Dropdown.Link>
                            ))}
                        </Dropdown.Content>
                    </Dropdown>

                    {isDarkMode == "no" ? (
                        <MdDarkMode
                            className="ml-2 w-6 h-6  text-white hover:text-indigo-200 cursor-pointer"
                            onClick={switchDarkMode}
                        />
                    ) : (
                        <BsFillSunFill
                            className="ml-2 w-6 h-6  text-white cursor-pointer hover:text-orange-400 hover:rounded "
                            onClick={switchDarkMode}
                        />
                    )}
                </div>
            </div>
        </div>
    );
}
