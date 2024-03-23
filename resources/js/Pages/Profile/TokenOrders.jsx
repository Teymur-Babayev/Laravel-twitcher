import __ from "@/Functions/Translate";
import { Link, Head, usePage } from "@inertiajs/inertia-react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { FiUserMinus } from "react-icons/fi";
import { MdGeneratingTokens } from "react-icons/md";
import { GoCalendar } from "react-icons/go";
import SecondaryButton from "@/Components/SecondaryButton";
import { Inertia } from "@inertiajs/inertia";

export default function TokenOrders({ orders }) {
    const { auth, currency_symbol } = usePage().props;

    return (
        <AuthenticatedLayout>
            <Head title={__("Token Order History")} />

            <div className="ml-0">
                <div className="mt-5 p-4 sm:p-8 bg-gray-100 dark:bg-zinc-900 shadow sm:rounded-lg">
                    <header>
                        <div className="flex items-start space-x-3">
                            <div>
                                <MdGeneratingTokens className="w-8 h-8 dark:text-white" />
                            </div>
                            <div className="flex justify-between items-center w-full flex-wrap">
                                <h2 className="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {__("Token Order History")}
                                </h2>
                                {__("Balance: :balance", {
                                    balance: auth.user.tokens,
                                })}
                            </div>
                        </div>
                    </header>

                    <hr className="my-5" />

                    {orders.total === 0 && (
                        <div className="text-xl dark:text-white text-gray-700 flex items-center space-x-4">
                            <FiUserMinus className="w-10 h-10" />
                            <div>
                                {__("You haven't ordered any tokens yet.")}
                            </div>
                        </div>
                    )}

                    <div className="relative overflow-x-auto">
                        <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" className="px-6 py-3">
                                        {__("ID")}
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        {__("Tokens")}
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        {__("Price")}
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        {__("Gateway")}
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        {__("Date")}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {orders.data?.map((t, index) => (
                                    <tr
                                        key={index}
                                        className="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                    >
                                        <th
                                            scope="row"
                                            className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            {t.id}
                                        </th>
                                        <td className="px-6 py-4">
                                            {t.tokens}
                                        </td>
                                        <td className="px-6 py-4">
                                            {`${currency_symbol}${t.amount}`}
                                        </td>
                                        <td className="px-6 py-4">
                                            {t.gateway}
                                        </td>
                                        <td className="px-6 py-4">
                                            {t.created_at_human}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>

                {orders.last_page > 1 && (
                    <>
                        <div className="mt-10 flex text-gray-600 dark:text-gray-100 my-3 text-sm">
                            {__("Page: :pageNumber of :lastPage", {
                                pageNumber: orders.current_page,
                                lastPage: orders.last_page,
                            })}
                        </div>

                        <SecondaryButton
                            processing={orders.prev_page_url ? false : true}
                            className="mr-3"
                            onClick={(e) => Inertia.visit(orders.prev_page_url)}
                        >
                            {__("Previous")}
                        </SecondaryButton>

                        <SecondaryButton
                            processing={orders.next_page_url ? false : true}
                            onClick={(e) => Inertia.visit(orders.next_page_url)}
                        >
                            {__("Next")}
                        </SecondaryButton>
                    </>
                )}
            </div>
        </AuthenticatedLayout>
    );
}
