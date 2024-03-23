import React, { useState } from "react";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { Link, useForm, usePage } from "@inertiajs/inertia-react";
import { Transition } from "@headlessui/react";
import __ from "@/Functions/Translate";

export default function UpdateProfileInformation({
    mustVerifyEmail,
    status,
    className,
}) {
    const user = usePage().props.auth.user;

    const [previewProfile, setPreviewProfile] = useState(user.profile_picture);

    const { data, setData, post, errors, processing, recentlySuccessful } =
        useForm({
            name: user.name,
            email: user.email,
            username: user.username,
        });

    const submit = (e) => {
        e.preventDefault();

        post(route("profile.update"), { preserveState: false });
    };

    const changeProfilePicture = (file) => {
        setData("profilePicture", file);
        setPreviewProfile((window.URL ? URL : webkitURL).createObjectURL(file));
    };

    return (
        <section className={className}>
            <header>
                <h2 className="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {__("Profile Information")}
                </h2>

                <p className="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {__(
                        "Update your account's profile information and email address."
                    )}
                </p>
            </header>

            <form onSubmit={submit} className="mt-6 space-y-6">
                <div>
                    <InputLabel for="username" value={__("Username")} />

                    <TextInput
                        id="username"
                        className="mt-1 block w-full"
                        value={data.username}
                        handleChange={(e) =>
                            setData("username", e.target.value)
                        }
                        required
                        autofocus
                    />

                    <InputError className="mt-2" message={errors.username} />
                </div>

                <div>
                    <InputLabel for="name" value="Name" />

                    <TextInput
                        id="name"
                        className="mt-1 block w-full"
                        value={data.name}
                        handleChange={(e) => setData("name", e.target.value)}
                        required
                        autofocus
                        autocomplete="name"
                    />

                    <InputError className="mt-2" message={errors.name} />
                </div>

                <div>
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        className="mt-1 block w-full"
                        value={data.email}
                        handleChange={(e) => setData("email", e.target.value)}
                        required
                        autocomplete="email"
                    />

                    <InputError className="mt-2" message={errors.email} />
                </div>

                <div>
                    <InputLabel
                        for="profilePicture"
                        value={__("Profile Picture - 80x80 recommended")}
                    />

                    <TextInput
                        className="p-1 block w-full text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-300 focus:outline-none dark:bg-zinc-800 dark:border-gray-600 dark:placeholder-zinc-900"
                        id="profilePicture"
                        type="file"
                        handleChange={(e) =>
                            changeProfilePicture(e.target.files[0])
                        }
                    />

                    <InputError
                        className="mt-2"
                        message={errors.profilePicture}
                    />
                    <img
                        src={previewProfile}
                        alt="profile picture"
                        className="h-20 rounded-full mt-2 border-white border-2 dark:border-indigo-200"
                    />
                </div>

                {mustVerifyEmail && user.email_verified_at === null && (
                    <div>
                        <p className="text-sm mt-2 text-gray-800 dark:text-gray-200">
                            {__("Your email address is unverified.")}
                            <Link
                                href={route("verification.send")}
                                method="post"
                                as="button"
                                className="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                            >
                                {__(
                                    "Click here to re-send the verification email."
                                )}
                            </Link>
                        </p>

                        {status === "verification-link-sent" && (
                            <div className="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                {__(
                                    "A new verification link has been sent to your email address."
                                )}
                            </div>
                        )}
                    </div>
                )}

                <div className="flex items-center gap-4">
                    <PrimaryButton processing={processing}>
                        {__("Save")}
                    </PrimaryButton>

                    <Transition
                        show={recentlySuccessful}
                        enterFrom="opacity-0"
                        leaveTo="opacity-0"
                        className="transition ease-in-out"
                    >
                        <p className="text-sm text-gray-600 dark:text-gray-400">
                            {__("Saved")}.
                        </p>
                    </Transition>
                </div>
            </form>
        </section>
    );
}
