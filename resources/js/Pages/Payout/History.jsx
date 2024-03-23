import React, { useEffect } from "react";
import { usePage, useForm } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";
import { BsClockHistory } from "react-icons/bs";
import Spinner from "@/Components/Spinner";
import { toast } from "react-toastify";

export default function History({ withdrawals }) {
    const { currency_symbol, currency_code } = usePage().props;

    const { data, setData, post, processing, errors } = useForm();

    const statusBadge = (status) => {
        switch (status) {
            case "Pending":
                return "bg-yellow-500 text-white px-2 py-1 rounded-lg";
                break;
            case "Paid":
                return "bg-green-500 text-white px-2 py-1 rounded-lg";
                break;
            case "Canceled":
                return "bg-red-100 text-red-600 px-2 py-1 rounded-lg";
                break;
        }
    };

    useEffect(() => {
        if (Object.keys(errors).length) {
            Object.keys(errors).map((err) => {
                toast.error(errors[err]);
            });
        }
    }, [errors]);

    const cancelRequest = (id) => {
        // setData("withdrawal_id", id);
        post(route("payout.cancelRequest", { withdrawal_id: id }));
    };
    return (
        <div className="p-4 sm:p-8 bg-white dark:bg-zinc-900 shadow sm:rounded-lg">
            <div className="flex items-center space-x-4">
                <div>
                    {processing ? (
                        <Spinner />
                    ) : (
                        <BsClockHistory className="w-12 h-12 text-green-600" />
                    )}
                </div>
                <div>
                    <h3 className="text-2xl font-semibold dark:text-white">
                        {__("Payout History")}
                    </h3>
                    <p className="mt-1 text-gray-600 dark:text-gray-400">
                        {__("History of payments made to you")}
                    </p>
                </div>
            </div>
            <div className="mt-4">
                {withdrawals.length ? (
                    <>
                        <div className="relative overflow-x-auto mt-5">
                            <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-zinc-800 dark:text-gray-400">
                                    <tr>
                                        <th className="px-6 py-3">
                                            {__("ID")}
                                        </th>
                                        <th className="px-6 py-3">
                                            {__("Tokens")}
                                        </th>
                                        <th className="px-6 py-3">
                                            {__("Amount")}
                                        </th>
                                        <th className="px-6 py-3">
                                            {__("Status")}
                                        </th>
                                        <th className="px-6 py-3">
                                            {__("Date")}
                                        </th>
                                        <th className="px-6 py-3">-</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {withdrawals.map((w) => (
                                        <tr
                                            className="bg-white border-b dark:bg-zinc-900 dark:border-zinc-700"
                                            key={w.id}
                                        >
                                            <td className="px-6 py-4 font-bold">
                                                #{w.id}
                                            </td>
                                            <td className="px-6 py-4">
                                                <span className="px-2 py-1 rounded-lg bg-neutral-300 text-neutral-700">
                                                    {w.tokens}
                                                </span>
                                            </td>
                                            <td className="px-6 py-4">
                                                <span className="px-2 py-1 rounded-lg bg-sky-500 text-white">
                                                    {`${currency_symbol}${w.amount}`}
                                                </span>
                                            </td>
                                            <td className="px-6 py-4">
                                                <span
                                                    className={statusBadge(
                                                        w.status
                                                    )}
                                                >
                                                    {w.status}
                                                </span>
                                            </td>
                                            <td className="px-6 py-4">
                                                {w.created_at_human}
                                            </td>
                                            <td className="px-6 py-4">
                                                {w.status == "Pending" && (
                                                    <button
                                                        disabled={processing}
                                                        onClick={(e) =>
                                                            cancelRequest(w.id)
                                                        }
                                                        className={
                                                            "text-sky-500 hover:text-sky-700"
                                                        }
                                                    >
                                                        {__("Cancel")}
                                                    </button>
                                                )}
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </>
                ) : (
                    <span className="text-2xl text-gray-700">
                        {__("You made no withdrawals yet")}
                    </span>
                )}
            </div>
        </div>
    );
}
