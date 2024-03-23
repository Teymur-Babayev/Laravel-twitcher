import React, { useState } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, usePage } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";
import History from "./History";
import Settings from "./Settings";
import Request from "./Request";
import AccountNavi from "../Channel/Partials/AccountNavi";

export default function Withdraw({
    auth,
    pendingCount,
    withdrawals,
    payoutSettings,
}) {
    const { currency_symbol, currency_code, token_value, min_withdraw } =
        usePage().props;
    const [activeTab, setActiveTab] = useState("Withdraw");

    // active tab class
    const activeTabClass =
        "text-xl font-bold mr-2 md:mr-4 text-indigo-800 dark:text-indigo-500 border-b-2 border-indigo-800";
    const inactiveTabClass =
        "text-xl font-bold mr-2 md:mr-4 hover:text-indigo-800 dark:text-white dark:hover:text-indigo-500";

    return (
        <AuthenticatedLayout auth={auth}>
            <Head title={__("Withdraw")} />

            <div className="lg:flex lg:space-x-10 w-full">
                <AccountNavi active={"withdraw"} />

                <div className="flex-grow">
                    <div className="mb-5">
                        <button
                            className={
                                activeTab == "Withdraw"
                                    ? activeTabClass
                                    : inactiveTabClass
                            }
                            onClick={(e) => setActiveTab("Withdraw")}
                        >
                            {__("Withdraw")}
                        </button>
                        <button
                            className={
                                activeTab == "History"
                                    ? activeTabClass
                                    : inactiveTabClass
                            }
                            onClick={(e) => setActiveTab("History")}
                        >
                            {__("History")}
                        </button>
                        <button
                            className={
                                activeTab == "Settings"
                                    ? activeTabClass
                                    : inactiveTabClass
                            }
                            onClick={(e) => setActiveTab("Settings")}
                        >
                            {__("Settings")}
                        </button>
                    </div>
                    {/* Withdraw Tab */}
                    {activeTab == "Withdraw" && (
                        <Request
                            token_value={token_value}
                            currency_symbol={currency_symbol}
                            tokens={auth.user.tokens}
                            money_balance={auth.user.moneyBalance}
                            min_withdraw={min_withdraw}
                            pending_count={pendingCount}
                            payout_settings={payoutSettings}
                        />
                    )}

                    {/* Withdraw Tab */}
                    {activeTab == "Settings" && (
                        <Settings payoutSettings={payoutSettings} />
                    )}

                    {/* Withdraw Tab */}
                    {activeTab == "History" && (
                        <History withdrawals={withdrawals} />
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
