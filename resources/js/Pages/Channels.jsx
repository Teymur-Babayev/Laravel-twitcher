import React, { useRef, useState } from "react";
import { Head, usePage } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";
import SecondaryButton from "@/Components/SecondaryButton";
import { FcEmptyFilter } from "react-icons/fc";
import { Inertia } from "@inertiajs/inertia";
import ChannelsLoop from "@/Components/ChannelsLoop";
import Spinner from "@/Components/Spinner";
import Front from "@/Layouts/Front";
import TextInput from "@/Components/TextInput";
import { IoMdFunnel } from "react-icons/io";

export default function Channels({ channels, exploreImage }) {
    const { categories } = usePage().props;

    const filters = useRef();

    const [sort, setSort] = useState("Popularity");
    const [search, setSearch] = useState("");
    const [isLoading, setLoading] = useState(false);
    const [selectedCategories, setSelectedCategories] = useState([]);

    const submit = (e) => {
        e.preventDefault();

        Inertia.visit(
            route("channels.browse", {
                search,
                sort,
                selectedCategories,
            }),
            {
                only: ["channels"],
                preserveState: true,
                onBefore: () => setLoading(true),
                onFinish: () => setLoading(false),
            }
        );

        hideFilters();
    };

    const handleCategories = (event) => {
        const { value, checked } = event.target;
        if (checked) {
            setSelectedCategories((current) => [...current, value]);
        } else {
            setSelectedCategories((current) =>
                current.filter((v) => v !== value)
            );
        }
    };

    const showFilters = (e) => {
        e.preventDefault();

        const shown =
            "fixed inset-0 z-[9999] pt-5 px-2 overflow-scroll h-screen bg-white dark:bg-black  block w-2/3 flex-shrink-0 mr-5";

        filters.current.className = shown;
    };

    const hideFilters = (e) => {
        e?.preventDefault();
        const hidden = "hidden lg:block w-56 lg:flex-shrink-0 lg:mr-5";
        console.log(`hiding filters ${hidden}`);
        filters.current.className = hidden;
    };

    return (
        <Front
            containerClass="w-full"
            extraHeader={true}
            extraHeaderTitle={__("Discover Channels")}
            extraHeaderImage={exploreImage}
            extraHeaderText={""}
            extraImageHeight={"h-14"}
        >
            <Head title={__("Discover Channels")} />

            <div className="flex w-full -mt-16">
                <form onSubmit={submit}>
                    <div
                        ref={filters}
                        className="hidden lg:block w-56 lg:flex-shrink-0 lg:mr-5"
                    >
                        <h3 className="text-indigo-700 dark:text-white text-xl font-bold block p-3 bg-light-violet dark:bg-zinc-900 shadow rounded-t-lg">
                            {__("Search")}
                        </h3>
                        <div className="bg-white dark:bg-zinc-800 rounded-b-lg shadow p-3">
                            <TextInput
                                className="w-full"
                                name="search"
                                value={search}
                                handleChange={(e) => setSearch(e.target.value)}
                                placeholder={__("Search Channel")}
                            />
                        </div>

                        <h3 className="mt-5 text-indigo-700 dark:text-white text-xl font-bold block p-3 bg-light-violet dark:bg-zinc-900 shadow rounded-t-lg">
                            {__("Sort By")}
                        </h3>
                        <div className="bg-white dark:bg-zinc-800 rounded-b-lg shadow p-3">
                            <div className="flex items-center text-gray-600 dark:text-white">
                                <input
                                    type={"radio"}
                                    name="sort"
                                    value="Popularity"
                                    checked={sort === "Popularity"}
                                    className="mr-2"
                                    onChange={(e) => setSort(e.target.value)}
                                />
                                {__("Popularity")}
                            </div>
                            <div className="flex items-center text-gray-600 dark:text-white">
                                <input
                                    type={"radio"}
                                    name="sort"
                                    value="Recently Joined"
                                    checked={sort === "Recently Joined"}
                                    className="mr-2"
                                    onChange={(e) => setSort(e.target.value)}
                                />
                                {__("Recently Joined")}
                            </div>
                            <div className="flex items-center text-gray-600 dark:text-white">
                                <input
                                    type={"radio"}
                                    name="sort"
                                    checked={sort === "Followers"}
                                    value="Followers"
                                    className="mr-2"
                                    onChange={(e) => setSort(e.target.value)}
                                />
                                {__("Followers")}
                            </div>
                            <div className="flex items-center text-gray-600 dark:text-white">
                                <input
                                    type={"radio"}
                                    name="sort"
                                    checked={sort === "Alphabetically"}
                                    value="Alphabetically"
                                    className="mr-2"
                                    onChange={(e) => setSort(e.target.value)}
                                />
                                {__("Alphabetically")}
                            </div>
                        </div>

                        <h3 className="mt-5 text-indigo-700 dark:text-white text-xl font-bold block p-3 bg-light-violet dark:bg-zinc-900 shadow rounded-t-lg">
                            {__("Category")}
                        </h3>
                        <div className="bg-white dark:bg-zinc-800 rounded-b-lg shadow p-3">
                            {categories.map((cat) => {
                                return (
                                    <div
                                        key={`catFilter-${cat.id}`}
                                        className="flex items-center text-gray-600 dark:text-white"
                                    >
                                        <input
                                            type="checkbox"
                                            name="categories[]"
                                            className="mr-2"
                                            value={cat.id}
                                            onChange={handleCategories}
                                            checked={selectedCategories.includes(
                                                cat.id.toString()
                                            )}
                                        />
                                        {cat.category}
                                    </div>
                                );
                            })}
                        </div>

                        {isLoading ? (
                            <div className="my-3">
                                <Spinner />
                            </div>
                        ) : (
                            <button className="mt-5 bg-indigo-500 dark:bg-zinc-800 font-semibold text-white rounded-lg px-2 py-1.5 block w-full">
                                {__("Apply Filters")}
                            </button>
                        )}

                        <div className="lg:hidden text-center border-t dark:border-zinc-800 border-t-gray-300 py-5">
                            <SecondaryButton
                                className=""
                                onClick={(e) => hideFilters(e)}
                            >
                                {__("Close")}
                            </SecondaryButton>
                        </div>
                    </div>
                </form>

                <div className="flex-grow">
                    <button
                        onClick={(e) => showFilters(e)}
                        className="mb-7 px-3 -mt-1 py-1.5 bg-indigo-500 text-white rounded-lg lg:hidden flex items-center justify-end"
                    >
                        <IoMdFunnel className="mr-1" />
                        {__("Show Filters")}
                    </button>

                    {channels.total === 0 && (
                        <div className="text-xl bg-white dark:bg-zinc-900 rounded-lg shadow text-gray-600 dark:text-white font-light p-3 flex items-center">
                            <FcEmptyFilter className="w-12 h-12 mr-2" />
                            {__("No channels to show")}
                        </div>
                    )}

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
