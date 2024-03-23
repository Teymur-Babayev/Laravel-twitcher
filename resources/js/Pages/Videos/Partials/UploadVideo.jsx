import InputLabel from "@/Components/InputLabel";
import InputError from "@/Components/InputError";
import TextInput from "@/Components/TextInput";
import Textarea from "@/Components/Textarea";
import PrimaryButton from "@/Components/PrimaryButton";
import __ from "@/Functions/Translate";
import { toast } from "react-toastify";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { usePage, useForm, Head, Link } from "@inertiajs/inertia-react";
import { Inertia } from "@inertiajs/inertia";
import { useEffect, useState } from "react";
import axios from "axios";
import Spinner from "@/Components/Spinner";
import { MdVideoLibrary } from "react-icons/md";
import AccountNavi from "@/Pages/Channel/Partials/AccountNavi";

export default function UploadVideo({ video, categories }) {
    const { data, setData, post, processing, errors, progress } = useForm({
        title: video.title,
        category_id: video.category_id,
        price: video.price,
        free_for_subs: video.free_for_subs,
        thumbnail: "",
        video_file: "",
    });

    const [videoFile, setVideoFile] = useState("");
    const [chunks, setChunks] = useState([]);
    const [spinner, setSpinner] = useState(false);
    const [videoId, setVideoId] = useState(2);
    const [uploaded, setUploaded] = useState(0);

    useEffect(() => {
        if (Object.keys(errors).length) {
            Object.keys(errors).map((key) => {
                toast.error(errors.key);
            });
        }
    }, [errors]);

    useEffect(() => {
        if (chunks.length > 0) {
            uploadChunks();
        }
    }, [chunks]);

    const onHandleChange = (event) => {
        setData(
            event.target.name,
            event.target.type === "checkbox"
                ? event.target.checked
                : event.target.value
        );
    };

    const createChunks = () => {
        setChunks([]);

        // 8 mb chunks
        let size = 1024 * 1024 * 8;
        let chunksCount = Math.ceil(videoFile.size / size);

        for (let i = 0; i < chunksCount; i++) {
            setChunks((chunks) => [
                ...chunks,
                videoFile.slice(
                    i * size,
                    Math.min(i * size + size, videoFile.size),
                    videoFile.type
                ),
            ]);
        }
    };

    const uploadChunks = () => {
        setSpinner(true);

        // compute the form data
        const postData = new FormData();

        // append media_type request
        postData.append("media_type", "video");
        postData.append("is_last", chunks.length === 1);
        postData.append("video", videoId);
        postData.set("file", chunks[0], `${videoFile.name}.part`);

        // send the request
        axios
            .post(route("video.uploadChunks"), postData, {
                onUploadProgress: (event) => {
                    setUploaded(uploaded + event.loaded);
                },
            })
            .then(function (response) {
                if (chunks.length <= 1) {
                    // setVideoFile(null);
                    setChunks([]);
                    setUploaded(0);

                    // set video
                    data.video_file = response.data.result;

                    console.log(response.data.result);

                    console.log(`Chunks.length <= 1, posting data`);
                    console.log(data);

                    if (video.id === null) {
                        post(route("videos.save"));
                    } else {
                        updateVideo();
                    }
                }

                // remove this chunk
                let chunksArray = [...chunks];
                chunksArray.splice(0, 1);

                // update state
                setChunks(chunksArray);
            })
            .catch(function (error) {
                setUploaded(0);
                toast.error(error.response?.data?.message);
            })
            .then(function () {
                setSpinner(false);
            });
    };

    const submit = (e) => {
        e.preventDefault();

        if (videoFile) {
            createChunks();
        } else if (videoFile === "" && video.id !== null) {
            updateVideo();
        }
    };

    const updateVideo = () => {
        post(route("videos.update", { video: video.id }));
    };

    return (
        <AuthenticatedLayout>
            <Head title={__("Upload Video")} />
            <div className="lg:flex lg:space-x-10">
                <AccountNavi active="upload-videos" />
                <div className="p-4 sm:p-8 bg-white w-full dark:bg-zinc-900 shadow sm:rounded-lg">
                    <header className="mb-5">
                        <h2 className="text-lg inline-flex items-center md:text-xl font-medium text-gray-600 dark:text-gray-100">
                            <MdVideoLibrary className="mr-2" />
                            {video.id === null
                                ? __("Upload Video")
                                : __("Edit Video")}
                        </h2>

                        <p className="mt-1 mb-2 text-sm text-gray-600 dark:text-gray-400">
                            {__("Upload a new video")}
                        </p>

                        <PrimaryButton
                            onClick={(e) => Inertia.visit(route("videos.list"))}
                        >
                            {__("<< Back to Videos")}
                        </PrimaryButton>
                    </header>

                    <hr className="my-5" />
                    <form onSubmit={submit} encType="multipart/form-data">
                        <div className="mb-5">
                            <InputLabel for="title" value={__("Title")} />

                            <TextInput
                                name="title"
                                value={data.title}
                                handleChange={onHandleChange}
                                required
                                className="mt-1 block w-full md:w-1/2"
                            />

                            <InputError
                                message={errors.title}
                                className="mt-2"
                            />
                        </div>

                        <div className="mb-5">
                            <InputLabel for="category" value={__("Category")} />

                            <select
                                name="category_id"
                                value={data.category_id}
                                onChange={onHandleChange}
                                required
                                className={`mt-1 block w-full md:w-1/2 border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm `}
                            >
                                <option value="">{__("--Select--")}</option>
                                {categories.map((c) => (
                                    <option
                                        key={`category-${c.id}`}
                                        value={c.id}
                                    >
                                        {c.category}
                                    </option>
                                ))}
                            </select>

                            <InputError
                                message={errors.category_id}
                                className="mt-2"
                            />
                        </div>

                        <div className="flex w-full md:w-1/2 flex-col md:flex-row md:items-center md:space-x-10 md:justify-between">
                            <div className="mb-5">
                                <InputLabel for="price" value={__("Price")} />

                                <div className="flex items-center">
                                    <TextInput
                                        type="number"
                                        name="price"
                                        value={data.price}
                                        handleChange={onHandleChange}
                                        required
                                        className="mt-1  w-32"
                                    />
                                    <div className="ml-1 dark:text-white text-gray-700">
                                        {__("tokens")}
                                    </div>
                                </div>

                                <InputError
                                    message={errors.price}
                                    className="mt-2"
                                />
                            </div>
                            <div className="mb-5">
                                <InputLabel
                                    for="free_for_subs"
                                    value={__("Free for subscribers?")}
                                />

                                <select
                                    name="free_for_subs"
                                    value={data.free_for_subs}
                                    onChange={onHandleChange}
                                    required
                                    className={`mt-1 block w-32 border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm `}
                                >
                                    <option value="yes">{__("Yes")}</option>
                                    <option value="no">{__("No")}</option>
                                </select>

                                <InputError
                                    message={errors.free_for_subs}
                                    className="mt-2"
                                />
                            </div>
                        </div>

                        <div className="mb-5">
                            <InputLabel
                                for="thumbnail"
                                value={__(
                                    "Thumbnail - helps to attract sales (will be resized to 640x320px)"
                                )}
                            />

                            <TextInput
                                className="p-1 block w-full md:w-1/2 text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-300 focus:outline-none dark:bg-zinc-800 dark:border-gray-600 dark:placeholder-zinc-900"
                                type="file"
                                name="thumbnail"
                                handleChange={(e) =>
                                    setData("thumbnail", e.target.files[0])
                                }
                                required={video.id === null}
                            />

                            <InputError
                                message={errors.thumbnail}
                                className="mt-2"
                            />
                        </div>

                        <div className="mb-5">
                            <InputLabel for="video" value={__("Video")} />

                            <TextInput
                                className="p-1 block w-full md:w-1/2 text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-300 focus:outline-none dark:bg-zinc-800 dark:border-gray-600 dark:placeholder-zinc-900"
                                type="file"
                                name="video"
                                accept="video/mp4,video/webm,video/ogg,video/quicktime,video/qt,video/mov"
                                handleChange={(e) =>
                                    setVideoFile(e.target.files[0])
                                }
                                required={video.id === null}
                            />

                            <InputError
                                message={errors.video_file}
                                className="mt-2"
                            />
                        </div>

                        <div className="flex justify-between items-center">
                            <PrimaryButton processing={processing || spinner}>
                                {video.id === null
                                    ? __("Save Video")
                                    : __("Update Video")}
                            </PrimaryButton>
                        </div>

                        {spinner && (
                            <div className="my-3">
                                <Spinner />
                            </div>
                        )}

                        {progress && (
                            <progress
                                className="mt-5"
                                value={progress.percentage}
                                max="100"
                            >
                                {progress.percentage}%
                            </progress>
                        )}
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
