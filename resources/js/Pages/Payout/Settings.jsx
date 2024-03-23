import React from "react";
import { usePage, useForm } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";
import { TbBuildingBank } from "react-icons/tb";
import InputLabel from "@/Components/InputLabel";
import InputError from "@/Components/InputError";
import PrimaryButton from "@/Components/PrimaryButton";
import Textarea from "@/Components/Textarea";
import TextInput from "@/Components/TextInput";

export default function Settings({ payoutSettings }) {
    const { currency_symbol, currency_code, auth } = usePage().props;

    const { data, setData, post, processing, errors, reset } = useForm({
        payout_destination: payoutSettings.destination ?? "",
        payout_details: payoutSettings.details ?? "",
    });

    const submit = (e) => {
        e.preventDefault();

        post(route("payout.saveSettings"));
    };

    return (
        <div className="p-4 sm:p-8 bg-white dark:bg-zinc-900 shadow sm:rounded-lg">
            <div className="flex items-center space-x-4">
                <div>
                    <TbBuildingBank className="w-12 h-12 text-green-600" />
                </div>
                <div>
                    <h3 className="text-2xl font-semibold dark:text-white">
                        {__("Payout Settings")}
                    </h3>
                    <p className="mt-1 text-gray-600 dark:text-gray-400">
                        {__("Set your payout destination settings")}
                    </p>
                </div>
            </div>

            <div className="mt-3 max-w-sm">
                <form onSubmit={submit}>
                    <div className="mt-4">
                        <InputLabel
                            forInput="category"
                            value={__("Payout Destination")}
                        />

                        <select
                            name="payout_destination"
                            onChange={(e) =>
                                setData("payout_destination", e.target.value)
                            }
                            required
                            className={`mt-1 block w-full border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm `}
                            defaultValue={data.payout_destination}
                        >
                            <option value={""}>{__("- Select -")}</option>
                            <option value={"PayPal"}>{__("PayPal")}</option>
                            <option value={"Bank Transfer"}>
                                {__("Bank Transfer")}
                            </option>
                        </select>

                        <InputError
                            message={errors.payout_destination}
                            className="mt-2"
                        />

                        {data.payout_destination == "PayPal" && (
                            <>
                                <InputLabel
                                    className="mt-3"
                                    forInput="payout_details"
                                    value="PayPal Email"
                                />
                                <TextInput
                                    value={data.payout_details}
                                    className="w-full"
                                    handleChange={(e) =>
                                        setData(
                                            "payout_details",
                                            e.target.value
                                        )
                                    }
                                    required
                                />
                            </>
                        )}
                        {data.payout_destination == "Bank Transfer" && (
                            <>
                                <InputLabel
                                    forInput="payout_details"
                                    className="mt-3"
                                    value="Bank Account Details"
                                />

                                <Textarea
                                    value={data.payout_details}
                                    name="payout_details"
                                    className="w-full"
                                    handleChange={(e) =>
                                        setData(
                                            "payout_details",
                                            e.target.value
                                        )
                                    }
                                    required
                                />
                            </>
                        )}

                        <InputError
                            message={errors.payout_details}
                            className="mt-2"
                        />

                        <PrimaryButton processing={processing} className="mt-3">
                            {__("Save Settings")}
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    );
}
