import React, { useEffect } from "react";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { Head, Link, useForm, usePage } from "@inertiajs/inertia-react";
import Front from "@/Layouts/Front";
import __ from "@/Functions/Translate";
import { toast } from "react-toastify";

export default function Register() {
    const routeName = route().current();

    const { data, setData, post, processing, errors, reset } = useForm({
        username: "",
        category: "",
        is_streamer: routeName == "streamer.signup" ? "yes" : "no",
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
    });

    useEffect(() => {
        return () => {
            reset("password", "password_confirmation");
        };
    }, []);

    const onHandleChange = (event) => {
        setData(
            event.target.name,
            event.target.type === "checkbox"
                ? event.target.checked
                : event.target.value
        );
    };

    const submit = (e) => {
        e.preventDefault();

        post(route("register"));
    };

    const influencerIcon = "/images/streamer-icon.png";
    const userIcon = "/images/user-signup-icon.png";

    const { categories, flash } = usePage().props;

    useEffect(() => {
        if (flash?.message) {
            toast(flash.message);
        }

        if (Object.keys(errors).length !== 0) {
            Object.keys(errors).map((key, index) => {
                toast(errors[key]);
            });
        }
    }, [flash, errors]);

    return (
        <Front>
            <Head title={__("Register")} />

            <div className="flex items-center flex-col md:flex-row md:space-x-10 bg-white rounded-lg px-5 pb-6 dark:bg-zinc-900 shadow max-w-5xl mx-auto">
                <div className="w-full">
                    <h2 className="my-5 text-3xl text-gray-600 dark:text-zinc-200 font-semibold text-center">
                        {routeName === "streamer.signup"
                            ? __("Join as a Streamer")
                            : __("Join as an User")}
                    </h2>
                    {routeName === "streamer.signup" && (
                        <img
                            src={influencerIcon}
                            alt="influencer signup"
                            className="max-h-96 rounded-full mx-auto border-zinc-200 dark:border-indigo-200 border-4"
                        />
                    )}
                    {routeName === "register" && (
                        <img
                            src={userIcon}
                            alt="user signup"
                            className="max-h-96 rounded-full mx-auto border-zinc-200 dark:border-indigo-200 border-4"
                        />
                    )}
                </div>

                <div className="flex-grow pt-10 w-full">
                    <form onSubmit={submit}>
                        <input
                            type="hidden"
                            name="is_streamer"
                            value={data.is_streamer}
                        />

                        <div className="mb-4">
                            <InputLabel
                                forInput="username"
                                value={__("Username")}
                            />

                            <TextInput
                                name="username"
                                value={data.username}
                                className="mt-1 block w-full"
                                autoComplete="username"
                                handleChange={onHandleChange}
                                isFocused={true}
                                required
                            />

                            <InputError
                                message={errors.username}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel forInput="name" value={__("Name")} />

                            <TextInput
                                name="name"
                                value={data.name}
                                className="mt-1 block w-full"
                                autoComplete="name"
                                handleChange={onHandleChange}
                                required
                            />

                            <InputError
                                message={errors.name}
                                className="mt-2"
                            />
                        </div>

                        <div className="mt-4">
                            <InputLabel forInput="email" value={__("Email")} />

                            <TextInput
                                type="email"
                                name="email"
                                value={data.email}
                                className="mt-1 block w-full"
                                autoComplete="username"
                                handleChange={onHandleChange}
                                required
                            />

                            <InputError
                                message={errors.email}
                                className="mt-2"
                            />
                        </div>

                        <div className="mt-4">
                            <InputLabel
                                forInput="password"
                                value={__("Password")}
                            />

                            <TextInput
                                type="password"
                                name="password"
                                value={data.password}
                                className="mt-1 block w-full"
                                autoComplete="new-password"
                                handleChange={onHandleChange}
                                required
                            />

                            <InputError
                                message={errors.password}
                                className="mt-2"
                            />
                        </div>

                        <div className="mt-4">
                            <InputLabel
                                forInput="password_confirmation"
                                value={__("Confirm Password")}
                            />

                            <TextInput
                                type="password"
                                name="password_confirmation"
                                value={data.password_confirmation}
                                className="mt-1 block w-full"
                                handleChange={onHandleChange}
                                required
                            />

                            <InputError
                                message={errors.password_confirmation}
                                className="mt-2"
                            />
                        </div>

                        {routeName === "streamer.signup" && (
                            <div className="mt-4">
                                <InputLabel
                                    forInput="category"
                                    value={__("Category")}
                                />

                                <select
                                    name="category"
                                    onChange={(e) => onHandleChange(e)}
                                    required
                                    className={`mt-1 block w-full border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm `}
                                >
                                    <option value={""}>
                                        {__("- Select -")}
                                    </option>
                                    {categories.map((c, cIndex) => {
                                        return (
                                            <option value={c.id} key={c.id}>
                                                {c.category}
                                            </option>
                                        );
                                    })}
                                </select>

                                <InputError
                                    message={errors.category}
                                    className="mt-2"
                                />
                            </div>
                        )}

                        <div className="flex items-center justify-end mt-4">
                            <PrimaryButton
                                className="ml-4"
                                processing={processing}
                            >
                                {__("Register")}
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </Front>
    );
}
