import React, { useEffect } from "react";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { Head, useForm, usePage } from "@inertiajs/inertia-react";
import Front from "@/Layouts/Front";
import __ from "@/Functions/Translate";
import { toast } from "react-toastify";
import Textarea from "@/Components/Textarea";

export default function Contact({ no1, no2, contact_image }) {
    const routeName = route().current();

    const { data, setData, post, processing, errors, reset } = useForm({
        name: "",
        email: "",
        subject: "",
        math: "",
        message: "",
    });

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

        post(route("contact.process"));
    };

    const { flash } = usePage().props;

    useEffect(() => {
        if (flash?.resetForm) {
            console.log("reset me");
            reset();
        }
    }, [flash]);

    return (
        <Front>
            <Head title={__("Get in Touch")} />

            <div className="flex items-center flex-col md:flex-row md:space-x-10 bg-white rounded-lg px-5 pb-6 dark:bg-zinc-900 shadow max-w-5xl mx-auto">
                <div className="w-full">
                    <h2 className="mb-5 text-2xl font-semibold dark:text-zinc-200 text-center">
                        {__("Get in Touch")}
                    </h2>

                    <img
                        src={contact_image}
                        alt="contact image"
                        className="max-h-96 rounded-full mx-auto border-zinc-200 dark:border-indigo-200 "
                    />
                </div>

                <div className="flex-grow pt-10 w-full">
                    <form onSubmit={submit}>
                        <div className="mb-4">
                            <InputLabel forInput="name" value={__("Name")} />

                            <TextInput
                                name="name"
                                value={data.name}
                                className="mt-1 block w-full"
                                autoComplete="name"
                                handleChange={onHandleChange}
                                isFocused={true}
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
                                forInput="subject"
                                value={__("Subject")}
                            />

                            <TextInput
                                type="text"
                                name="subject"
                                value={data.subject}
                                className="mt-1 block w-full"
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
                                forInput="message"
                                value={__("Your message")}
                            />

                            <Textarea
                                name="message"
                                value={data.message}
                                className="mt-1 block w-full"
                                handleChange={onHandleChange}
                                required
                            />

                            <InputError
                                message={errors.message}
                                className="mt-2"
                            />
                        </div>

                        <div className="mt-4">
                            <InputLabel
                                forInput="math"
                                value={__(
                                    "What is the result of :no1 + :no2 ?",
                                    {
                                        no1,
                                        no2,
                                    }
                                )}
                            />

                            <TextInput
                                type="text"
                                name="math"
                                value={data.math}
                                className="mt-1 "
                                handleChange={onHandleChange}
                                required
                            />

                            <InputError
                                message={errors.math}
                                className="mt-2"
                            />
                        </div>

                        <div className="flex mt-4">
                            <PrimaryButton className="" processing={processing}>
                                {__("Send Inquiry")}
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </Front>
    );
}
