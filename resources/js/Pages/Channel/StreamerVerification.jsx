import React, { useEffect } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, usePage, useForm } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";
import { HiIdentification } from "react-icons/hi";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";

export default function StreamerVerification() {
    const { auth } = usePage().props;

    const { data, setData, errors, processing, post, progress } = useForm({
        document: "",
    });

    useEffect(() => {
        console.log(errors);
    }, [errors]);

    const submit = (e) => {
        e.preventDefault();

        post(route("streamer.submitVerification"));
    };

    return (
        <AuthenticatedLayout auth={auth}>
            <Head title={__("Verify Identity To Start Streaming")} />

            <div className="ml-0">
                <div className="p-4 sm:p-8 bg-gray-100 dark:bg-zinc-900 dark:text-white shadow sm:rounded-lg">
                    <div className="flex items-center">
                        <div>
                            <HiIdentification className="h-12 w-12 mr-2" />
                        </div>
                        <div>
                            <h2 className="text-xl font-semibold text-gray-900 dark:text-gray-100">
                                {__("Verify Identity to Start Streaming")}
                            </h2>
                            <p className="dark:text-white text-sm">
                                {__(
                                    "In order to start streaming, you need to send your gov. issued ID/passport to verify the account name matches to the document."
                                )}
                            </p>
                        </div>
                    </div>

                    <div className="mt-5">
                        <form onSubmit={submit}>
                            <InputLabel value={__("Document (PNG or JPG)")} />

                            <input
                                className="p-1 block w-full text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-300 focus:outline-none dark:bg-zinc-800 dark:border-gray-600 dark:placeholder-zinc-900"
                                id="document"
                                type="file"
                                required
                                accept="image/jpg,image/png"
                                onChange={(e) =>
                                    setData("document", e.target.files[0])
                                }
                            />

                            <InputError
                                className="mt-2"
                                message={errors.document}
                            />

                            <PrimaryButton
                                className="mt-5"
                                processing={processing}
                            >
                                {__("Submit Request")}
                            </PrimaryButton>
                        </form>

                        {progress && (
                            <progress value={progress.percentage} max="100">
                                {progress.percentage}%
                            </progress>
                        )}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
