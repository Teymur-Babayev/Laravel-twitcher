import React from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, usePage, useForm } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";
import { MdGeneratingTokens } from "react-icons/md";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import Textarea from "@/Components/Textarea";
import PrimaryButton from "@/Components/PrimaryButton";
import InputError from "@/Components/InputError";

export default function BankTransfer({
    auth,
    tokenPack,
    bankImg,
    bankInstructions,
}) {
    const { currency_symbol, currency_code } = usePage().props;

    const { data, setData, post, processing, errors, reset } = useForm({
        proofDetails: "",
        proofImage: "",
    });

    const submit = (e) => {
        e.preventDefault();

        post(route("bank.confirmPurchase", { tokenPack: tokenPack.id }));
    };

    return (
        <AuthenticatedLayout auth={auth}>
            <Head title={__("Bank Transfer - Purchase Tokens")} />

            <div className="p-4 sm:p-8 bg-white max-w-3xl mx-auto dark:bg-zinc-900 shadow sm:rounded-lg">
                <div className="flex justify-center items-center">
                    <div className="mr-2">
                        <img src={bankImg} alt="bank img" className="h-14" />
                    </div>
                    <div>
                        <h3 className="text-3xl font-semibold dark:text-white text-center">
                            {__("Bank Transfer")}
                        </h3>
                    </div>
                </div>

                <h3 className="mt-5 text-2xl font-semibold dark:text-white text-center">
                    {__(
                        "You are purchasing :tokensAmount tokens for :moneyAmount",
                        {
                            tokensAmount: tokenPack.tokensFormatted,
                            moneyAmount: `${currency_symbol}${tokenPack.price}`,
                        }
                    )}
                </h3>

                <div
                    className="text-center mt-5 dark:text-white"
                    dangerouslySetInnerHTML={{ __html: bankInstructions }}
                />

                <div className="mt-5 justify-center mx-auto text-center">
                    <form onSubmit={submit}>
                        <InputLabel
                            className={"font-bold text-lg"}
                            value={__("Enter your payment proof details")}
                        />
                        <Textarea
                            value={data.proofDetails}
                            handleChange={(e) =>
                                setData("proofDetails", e.target.value)
                            }
                            rows="6"
                            required
                            className="w-full mt-3"
                        />
                        <InputError message={errors.proofDetails} />

                        <InputLabel
                            className={"mt-5 font-bold text-lg"}
                            value={__("Payment Proof Image")}
                        />

                        <TextInput
                            className="p-1 block w-full text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-300 focus:outline-none dark:bg-zinc-800 dark:border-gray-600 dark:placeholder-zinc-900"
                            id="proof_image"
                            type="file"
                            accept="image/jpeg,image/png"
                            required
                            handleChange={(e) =>
                                setData("proofImage", e.target.files[0])
                            }
                        />
                        <InputError message={errors.proofImage} />

                        <PrimaryButton
                            className="mt-5 py-4"
                            processing={processing}
                        >
                            {__("Send Request")}
                        </PrimaryButton>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
