import React, { useState, useRef } from "react";
import Front from "@/Layouts/Front";
import { Head } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";
import SecondaryButton from "@/Components/SecondaryButton";
import { FcEmptyFilter } from "react-icons/fc";
import { Inertia } from "@inertiajs/inertia";
import Spinner from "@/Components/Spinner";
import VideosLoop from "./Partials/VideosLoop";
import Modal from "@/Components/Modal";
import SingleVideo from "./SingleVideo";
import TextInput from "@/Components/TextInput";
import debounce from "lodash.debounce";
import { IoMdFunnel } from "react-icons/io";

export default function BrowseVideos({
    videos,
    category,
    categories,
    exploreImage,
}) {
    const [sort, setSort] = useState("Most Viewed");
    const [search, setSearch] = useState("");
    const [isLoading, setLoading] = useState(false);
    const [playVideo, setPlayVideo] = useState(false);
    const [modal, setModal] = useState(false);

    const updateTerm = debounce((e) => {
        console.log(`debounced term updated to: ${e.target.value}`);

        if (e.target.value.length > 2) {
            setLoading(true);
            Inertia.reload({
                data: {
                    keyword: e.target.value,
                    sortBy: sort,
                },
                only: ["videos"],
                onFinish: () => setLoading(false),
            });
        } else {
            Inertia.reload({
                data: {
                    sortBy: sort,
                    keyword: "",
                },
                only: ["videos"],
                onFinish: () => setLoading(false),
            });
        }
    }, 500);

    const sortItems = (e, sortBy) => {
        setSort(sortBy);
        setLoading(true);

        Inertia.reload({
            data: {
                sortBy,
            },
            only: ["videos"],
            onFinish: () => setLoading(false),
        });
    };

    const playModal = (e, video) => {
        e.preventDefault();
        setPlayVideo(video);
        setModal(true);
    };

    const filters = useRef();

    const [selectedCategories, setSelectedCategories] = useState([]);

    const submit = (e) => {
        e.preventDefault();

        Inertia.visit(
            route("videos.browse", {
                search,
                sort,
                selectedCategories,
            }),
            {
                only: ["videos"],
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
            extraHeaderTitle={__("Browse Videos")}
            extraHeaderImage={exploreImage}
            extraHeaderText={""}
            extraImageHeight={"h-14"}
        >
            <Head
                title={`${
                    category !== null
                        ? __(":categoryName Videos", {
                              categoryName: category.category,
                          })
                        : __("Browse Videos")
                }`}
            />

            <Modal show={modal} onClose={(e) => setModal(false)}>
                {playVideo && <SingleVideo video={playVideo} inModal={true} />}
            </Modal>

            <div className="flex w-full -mt-16">
                <form onSubmit={submit}>
                    <div
                        ref={filters}
                        className="hidden lg:block w-56 lg:flex-shrink-0 lg:mr-5"
                    >
                        <h3 className="text-indigo-700 text-xl font-bold block p-3 bg-light-violet dark:bg-zinc-900 dark:text-white shadow rounded-t-lg">
                            {__("Search")}
                        </h3>
                        <div className="bg-white dark:bg-zinc-800 rounded-b-lg shadow p-3">
                            <TextInput
                                className="w-full"
                                name="search"
                                value={search}
                                handleChange={(e) => setSearch(e.target.value)}
                                placeholder={__("Search Video")}
                            />
                        </div>

                        <h3 className="mt-5 text-indigo-700 text-xl font-bold block p-3 bg-light-violet dark:bg-zinc-900 dark:text-white shadow rounded-t-lg">
                            {__("Sort By")}
                        </h3>
                        <div className="bg-white dark:bg-zinc-800 rounded-b-lg shadow p-3">
                            <div className="flex items-center text-gray-600 dark:text-white">
                                <input
                                    type={"radio"}
                                    name="sort"
                                    value="Most Viewed"
                                    checked={sort === "Most Viewed"}
                                    className="mr-2"
                                    onChange={(e) => setSort(e.target.value)}
                                />
                                {__("Most Viewed")}
                            </div>
                            <div className="flex items-center text-gray-600 dark:text-white">
                                <input
                                    type={"radio"}
                                    name="sort"
                                    value="Recently Uploaded"
                                    checked={sort === "Recently Uploaded"}
                                    className="mr-2"
                                    onChange={(e) => setSort(e.target.value)}
                                />
                                {__("Recently Uploaded")}
                            </div>
                            <div className="flex items-center text-gray-600 dark:text-white">
                                <input
                                    type={"radio"}
                                    name="sort"
                                    checked={sort === "Older"}
                                    value="Older"
                                    className="mr-2"
                                    onChange={(e) => setSort(e.target.value)}
                                />
                                {__("Older Videos")}
                            </div>
                            <div className="flex items-center text-gray-600 dark:text-white">
                                <input
                                    type={"radio"}
                                    name="sort"
                                    checked={sort === "Highest Price"}
                                    value="Highest Price"
                                    className="mr-2"
                                    onChange={(e) => setSort(e.target.value)}
                                />
                                {__("Highest Price")}
                            </div>
                            <div className="flex items-center text-gray-600 dark:text-white">
                                <input
                                    type={"radio"}
                                    name="sort"
                                    checked={sort === "Lowest Price"}
                                    value="Lowest Price"
                                    className="mr-2"
                                    onChange={(e) => setSort(e.target.value)}
                                />
                                {__("Lowest Price")}
                            </div>
                        </div>

                        <h3 className="mt-5 text-indigo-700 text-xl font-bold block p-3 bg-light-violet dark:bg-zinc-900  dark:text-white shadow rounded-t-lg">
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

                        <div className="lg:hidden text-center border-t border-t-gray-300 dark:border-gray-900 py-5">
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

                    {videos.total === 0 && (
                        <div className="text-xl bg-white rounded-lg shadow text-gray-600 dark:bg-zinc-900 dark:text-white font-light p-3 flex items-center">
                            <FcEmptyFilter className="w-12 h-12 mr-2" />
                            {__("No videos to show")}
                        </div>
                    )}

                    <VideosLoop videos={videos.data} />

                    {videos.last_page > 1 && (
                        <>
                            <div className="flex text-gray-600 mt-10 mb-5 text-sm">
                                {__("Page: :pageNumber of :lastPage", {
                                    pageNumber: videos.current_page,
                                    lastPage: videos.last_page,
                                })}
                            </div>

                            <SecondaryButton
                                processing={videos.prev_page_url ? false : true}
                                className="mr-3"
                                onClick={(e) =>
                                    Inertia.visit(videos.prev_page_url)
                                }
                            >
                                {__("Previous")}
                            </SecondaryButton>

                            <SecondaryButton
                                processing={videos.next_page_url ? false : true}
                                onClick={(e) =>
                                    Inertia.visit(videos.next_page_url)
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
