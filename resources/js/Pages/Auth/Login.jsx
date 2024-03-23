import React, { useEffect } from "react";
import GuestLayout from "@/Layouts/GuestLayout";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { Link, useForm } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";
import Front from "@/Layouts/Front";

export default function Login({ status, canResetPassword, loginIcon }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: "",
        password: "",
        remember: "",
    });

    useEffect(() => {
        return () => {
            reset("password");
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

        post(route("login"));
    };

    return (
        <Front>
            <div className="p-5 md:p-10 mx-auto max-w-5xl bg-white dark:bg-zinc-900 shadow rounded-lg">
                <div className="flex items-center flex-col md:flex-row md:space-x-10">
                    <div className="w-full">
                        <img
                            src={loginIcon}
                            alt="user signup"
                            className="max-h-96 rounded-full mx-auto border-zinc-200 dark:border-indigo-200 border-4"
                        />
                    </div>

                    <div className="flex-grow pt-10 w-full">
                        <h2 className="text-3xl font-semibold text-gray-600 dark:text-zinc-200 text-center">
                            {__("Login to your account")}
                        </h2>
                        <p className="mb-5 mt-1 text-center text-sm text-gray-600 dark:text-white">
                            {__("Don't have an account?")}{" "}
                            <Link
                                className="dark:text-indigo-400 text-indigo-700 hover:underline"
                                href={route("signup")}
                            >
                                {__("Signup")}
                            </Link>
                        </p>
                        {status && (
                            <div className="mb-4 font-medium text-sm text-green-600">
                                {status}
                            </div>
                        )}

                        <form onSubmit={submit}>
                            <div>
                                <InputLabel forInput="email" value="Email" />

                                <TextInput
                                    type="email"
                                    name="email"
                                    value={data.email}
                                    className="mt-1 block w-full"
                                    autoComplete="username"
                                    isFocused={false}
                                    handleChange={onHandleChange}
                                />

                                <InputError
                                    message={errors.email}
                                    className="mt-2"
                                />
                            </div>

                            <div className="mt-4">
                                <InputLabel
                                    forInput="password"
                                    value="Password"
                                />

                                <TextInput
                                    type="password"
                                    name="password"
                                    value={data.password}
                                    className="mt-1 block w-full"
                                    autoComplete="current-password"
                                    handleChange={onHandleChange}
                                />

                                <InputError
                                    message={errors.password}
                                    className="mt-2"
                                />
                            </div>

                            <div className="flex items-center justify-end mt-4">
                                {canResetPassword && (
                                    <Link
                                        href={route("password.request")}
                                        className="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                    >
                                        {__("Forgot your password?")}
                                    </Link>
                                )}

                                <PrimaryButton
                                    className="ml-4"
                                    processing={processing}
                                >
                                    {__("Log in")}
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </Front>
    );
}
