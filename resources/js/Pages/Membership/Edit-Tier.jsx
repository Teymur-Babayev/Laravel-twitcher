import __ from "@/Functions/Translate";
import InputLabel from "@/Components/InputLabel";
import InputError from "@/Components/InputError";
import TextInput from "@/Components/TextInput";
import Textarea from "@/Components/Textarea";
import PrimaryButton from "@/Components/PrimaryButton";
import { usePage, useForm, Head, Link } from "@inertiajs/inertia-react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import SecondaryButton from "@/Components/SecondaryButton";
import AccountNavi from "../Channel/Partials/AccountNavi";

export default function EditTier({ tier }) {
    const { currency_symbol } = usePage().props;

    const { data, setData, post, processing, errors, reset } = useForm({
        tier_name: tier.tier_name,
        perks: tier.perks,
        tier_price: tier.price,
        six_months_discount: tier.six_months_discount,
        one_year_discount: tier.one_year_discount,
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

        post(route("membership.update-tier", { tier: tier.id }));
    };

    return (
        <AuthenticatedLayout>
            <Head title={__("Channel Membership Tiers")} />

            <div className="lg:flex lg:space-x-10 w-full">
                <AccountNavi active={"tiers"} />
                <div className="p-4 sm:p-8 bg-white w-full dark:bg-zinc-900 shadow sm:rounded-lg">
                    <header>
                        <h2 className="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {__("Update Tier")}
                        </h2>

                        <p className="mt-1 mb-2 text-sm text-gray-600 dark:text-gray-400">
                            {__(
                                "Update the subscription prices and perks for this tier"
                            )}
                        </p>

                        <Link href={route("membership.set-tiers")}>
                            <SecondaryButton>{__("<< Back")}</SecondaryButton>
                        </Link>
                    </header>

                    <hr className="my-5" />
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
                                    value={__("Tier Price")}
                                />

                                <div className="flex items-center">
                                    <TextInput
                                        name="tier_price"
                                        value={data.tier_price}
                                        handleChange={onHandleChange}
                                        required
                                        className="mt-1 block w-24"
                                    />
                                    <div className="ml-1 dark:text-white text-gray-600">
                                        {__("tokens / month")}
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
                                    value={__("6 Months Discount Percentage")}
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
                                    value={__("1 Year Discount Percentage")}
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
                            <InputLabel for="" value={__("Perks & Benefits")} />

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
                                {__("Update Tier")}
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
