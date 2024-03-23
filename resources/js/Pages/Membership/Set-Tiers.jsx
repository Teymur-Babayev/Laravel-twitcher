import React, { useState } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm, usePage } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import Textarea from "@/Components/Textarea";
import PrimaryButton from "@/Components/PrimaryButton";
import Modal from "@/Components/Modal";
import nl2br from "react-nl2br";
import DangerButton from "@/Components/DangerButton";
import SecondaryButton from "@/Components/SecondaryButton";
import { RiDeleteBin5Line } from "react-icons/ri";
import { AiOutlineEdit } from "react-icons/ai";
import { Inertia } from "@inertiajs/inertia";
import AccountNavi from "../Channel/Partials/AccountNavi";
import { FaGrinStars } from "react-icons/fa";

export default function SetTiers({ auth, tiers, thanksMsg }) {
    const { currency_symbol } = usePage().props;

    const [showAddModal, setShowAddModal] = useState(false);
    const [showThanksModal, setShowThanksModal] = useState(false);
    const [showDeleteConfirmation, setShowDeleteConfirmation] = useState(false);
    const [deleteId, setDeleteId] = useState(0);
    const [thanks, setThanks] = useState(thanksMsg);

    const { data, setData, post, processing, errors, reset } = useForm({
        tier_name: "",
        perks: "",
        tier_price: "",
        six_months_discount: 10,
        one_year_discount: 20,
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

        post(route("membership.add-tier"), {
            onSuccess: () => {
                setShowAddModal(false), reset();
            },
        });
    };

    const saveThanks = (e) => {
        e.preventDefault();

        Inertia.visit(
            route("membership.save-thanks", { thanks_message: thanks }),
            {
                method: "POST",
            }
        );
    };

    const confirmDelete = (e, id) => {
        e.preventDefault();

        setShowDeleteConfirmation(true);
        setDeleteId(id);
    };

    const deleteTier = () => {
        console.log("Will delete #" + deleteId);

        Inertia.visit(route("membership.delete-tier"), {
            method: "POST",
            data: { tier: deleteId },
            preserveState: false,
        });
    };

    return (
        <AuthenticatedLayout auth={auth}>
            <Head title={__("Channel Membership Tiers")} />

            <div className="lg:flex lg:space-x-10">
                <AccountNavi active={"tiers"} />

                <div className="p-4 flex-shrink sm:p-8 bg-white dark:bg-zinc-900 shadow sm:rounded-lg">
                    <header>
                        <h2 className="text-lg inline-flex items-center md:text-xl font-medium text-gray-600 dark:text-gray-100">
                            <FaGrinStars className="mr-2" />
                            {__("Channel Membership Tiers")}
                        </h2>

                        <p className="mt-1 mb-2 text-sm text-gray-600 dark:text-gray-400">
                            {__(
                                "Set the subscription prices and perks for your channel"
                            )}
                        </p>

                        <PrimaryButton onClick={(e) => setShowAddModal(true)}>
                            {__("+Add Tier")}
                        </PrimaryButton>
                        <SecondaryButton
                            className="ml-2"
                            onClick={(e) => setShowThanksModal(true)}
                        >
                            {__("Configure Thanks Message")}
                        </SecondaryButton>
                    </header>

                    <hr className="my-5" />

                    <Modal
                        show={showThanksModal}
                        onClose={(e) => setShowThanksModal(false)}
                    >
                        <div className="p-5 text-gray-600 dark:text-gray-100 text-lg text-center">
                            {__(
                                "Here you can configure a thanks message which will be sent as a notification to users which just subscribed to any of your tiers"
                            )}
                            <form onSubmit={saveThanks}>
                                <div className="my-4">
                                    <Textarea
                                        name="thanks_message"
                                        value={thanks}
                                        handleChange={(e) => {
                                            setThanks(e.target.value);
                                        }}
                                        required
                                        className="mt-1 block w-full"
                                    />

                                    <InputError
                                        message={errors.thanks_message}
                                        className="mt-2"
                                    />

                                    <PrimaryButton
                                        processing={processing}
                                        className="mt-4"
                                    >
                                        {__("Save")}
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </Modal>

                    <Modal
                        show={showAddModal}
                        onClose={(e) => setShowAddModal(false)}
                    >
                        <div className="p-5">
                            <form onSubmit={submit}>
                                <div className="mb-4">
                                    <InputLabel
                                        for="tier_name"
                                        value={__("Tier Name")}
                                    />

                                    <TextInput
                                        name="tier_name"
                                        value={data.tier_name}
                                        handleChange={onHandleChange}
                                        required
                                        className="mt-1 block w-full"
                                    />

                                    <InputError
                                        message={errors.tier_name}
                                        className="mt-2"
                                    />
                                </div>

                                <div className="flex flex-col md:flex-row md:justify-between">
                                    <div className="mb-4">
                                        <InputLabel
                                            for="tier_price"
                                            value={__("Tier Price (Tokens)")}
                                        />

                                        <div className="flex items-center">
                                            <TextInput
                                                name="tier_price"
                                                value={data.tier_price}
                                                handleChange={onHandleChange}
                                                required
                                                className="mt-1 block w-24"
                                            />
                                            <div className="ml-1 dark:text-white text-gray-700">
                                                {__(" tokens/month")}
                                            </div>
                                        </div>

                                        <InputError
                                            message={errors.tier_price}
                                            className="mt-2"
                                        />
                                    </div>

                                    <div className="mb-4">
                                        <InputLabel
                                            for="six_months_discount"
                                            value={__(
                                                "6 Months Discount Percentage"
                                            )}
                                        />

                                        <div className="flex items-center">
                                            <TextInput
                                                name="six_months_discount"
                                                value={data.six_months_discount}
                                                handleChange={onHandleChange}
                                                required
                                                className="mt-1 block w-24"
                                            />
                                            <div className="ml-1 dark:text-white text-gray-700">
                                                {__("%")}
                                            </div>
                                        </div>

                                        <InputError
                                            message={errors.six_months_discount}
                                            className="mt-2"
                                        />
                                    </div>

                                    <div className="mb-4">
                                        <InputLabel
                                            for="one_year_discount"
                                            value={__(
                                                "1 Year Discount Percentage"
                                            )}
                                        />

                                        <div className="flex items-center">
                                            <TextInput
                                                name="one_year_discount"
                                                value={data.one_year_discount}
                                                handleChange={onHandleChange}
                                                required
                                                className="mt-1 block w-24"
                                            />
                                            <div className="ml-1 dark:text-white text-gray-700">
                                                {__("%")}
                                            </div>
                                        </div>

                                        <InputError
                                            message={errors.one_year_discount}
                                            className="mt-2"
                                        />
                                    </div>
                                </div>

                                <div className="mb-4">
                                    <InputLabel
                                        for=""
                                        value={__("Perks & Benefits")}
                                    />

                                    <Textarea
                                        name="perks"
                                        value={data.perks}
                                        handleChange={onHandleChange}
                                        required
                                        className="mt-1 block w-full"
                                    />

                                    <InputError
                                        message={errors.perks}
                                        className="mt-2"
                                    />
                                </div>

                                <div className="flex justify-between items-center">
                                    <PrimaryButton processing={processing}>
                                        {__("Save Tier")}
                                    </PrimaryButton>

                                    <a
                                        className="cursor-pointer ml-2 text-sm text-rose-600 hover:text-rose-800"
                                        onClick={(e) => setShowAddModal(false)}
                                    >
                                        {__("Cancel")}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </Modal>

                    <Modal
                        show={showDeleteConfirmation}
                        onClose={(e) => setShowDeleteConfirmation(false)}
                    >
                        <div className="px-5 py-10 text-center">
                            <h3 className="text-xl mb-3 text-zinc-700 dark:text-white">
                                {__(
                                    "Are you sure you want to remove this Tier?"
                                )}
                            </h3>
                            <DangerButton onClick={(e) => deleteTier()}>
                                {__("Yes")}
                            </DangerButton>
                            <SecondaryButton
                                className="ml-3"
                                onClick={(e) =>
                                    setShowDeleteConfirmation(false)
                                }
                            >
                                {__("No")}
                            </SecondaryButton>
                        </div>
                    </Modal>

                    <span className="text-gray-600">
                        {!tiers.length &&
                            __("You did't create any membership tiers yet.")}
                    </span>

                    {tiers.length && (
                        <div className="relative overflow-x-auto mt-5">
                            <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-zinc-800 dark:text-gray-400">
                                    <tr>
                                        <th className="px-6 py-3">
                                            {__("Tier")}
                                        </th>
                                        <th className="px-6 py-3">
                                            {__("Price (Tokens)")}
                                        </th>
                                        <th className="px-6 py-3">
                                            {__("6 Mths %")}
                                        </th>
                                        <th className="px-6 py-3">
                                            {__("1 Yr %")}
                                        </th>
                                        <th className="px-6 py-3">
                                            {__("Perks")}
                                        </th>
                                        <th className="px-6 py-3">
                                            {__("Members")}
                                        </th>
                                        <th className="px-6 py-3">-</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {tiers.map((t) => (
                                        <tr
                                            key={t.id}
                                            className="bg-white border-b dark:bg-zinc-900 dark:border-zinc-700"
                                        >
                                            <td className="px-6 py-4 text-lg font-semibold">
                                                {t.tier_name}
                                            </td>
                                            <td className="px-6 py-4">
                                                <span className="px-2 flex py-1 rounded-lg bg-sky-500 text-white">
                                                    {__(":tokensPrice tokens", {
                                                        tokensPrice: t.price,
                                                    })}
                                                </span>
                                            </td>

                                            <td className="px-6 py-4">
                                                <span className="px-2 py-1 rounded-lg bg-teal-500 text-white">
                                                    {t.six_months_discount}%
                                                </span>
                                            </td>
                                            <td className="px-6 py-4">
                                                <span className="px-2 py-1 rounded-lg bg-fuchsia-500 text-white">
                                                    {t.one_year_discount}%
                                                </span>
                                            </td>

                                            <td className="px-6 py-4">
                                                {nl2br(t.perks)}
                                            </td>
                                            <td className="px-6 py-4">
                                                <span className="px-2 py-1 rounded-lg bg-neutral-300 text-neutral-700">
                                                    {t.subscribers_count}
                                                </span>
                                            </td>
                                            <td className="px-6 py-4">
                                                <div className="flex items-center">
                                                    <Link
                                                        href={route(
                                                            "membership.edit-tier",
                                                            { tier: t.id }
                                                        )}
                                                    >
                                                        <AiOutlineEdit className="w-6 h-6 mr-2 text-sky-600" />
                                                    </Link>
                                                    <button
                                                        onClick={(e) =>
                                                            confirmDelete(
                                                                e,
                                                                t.id
                                                            )
                                                        }
                                                    >
                                                        <RiDeleteBin5Line className="text-red-600 w-5 h-5" />
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
