import React from "react";
import __ from "@/Functions/Translate";
import { FcMoneyTransfer } from "react-icons/fc";
import WithdrawForm from "./WithdrawForm";

export default function Request({
    tokens,
    token_value,
    currency_symbol,
    money_balance,
    min_withdraw,
    pending_count,
    payout_settings,
}) {
    return (
        <div className="p-4 sm:p-8 bg-white dark:bg-zinc-900 shadow sm:rounded-lg">
            <div className="flex flex-wrap justify-between">
                <div className="flex items-center space-x-4">
                    <div>
                        <FcMoneyTransfer className="w-12 h-12" />
                    </div>
                    <div>
                        <h3 className="text-2xl font-semibold dark:text-white">
                            {__("Withdraw")}
                        </h3>
                        <p className="mt-1 text-gray-600 dark:text-gray-400">
                            {__("Request Payout")}
                        </p>
                    </div>
                </div>
                <div>
                    <h3 className="px-5 py-2.5 bg-gray-900 text-white dark:bg-gray-700 dark:text-white text-lg rounded-md font-bold">
                        {__(":tokenBalance tokens", { tokenBalance: tokens })}
                    </h3>
                </div>
            </div>
            <p className="dark:text-white mt-5 text-gray-600">
                {__(
                    "Minimum withdraw threshold before being able to request a payout:"
                )}{" "}
                <span className="px-2 py-0.5 ml-2 rounded-md bg-gray-900 text-white dark:bg-gray-700 dark:text-white font-semibold">
                    {__(":minWithdraw tokens", { minWithdraw: min_withdraw })}
                </span>
            </p>
            <hr className="my-2" />
            <p className="dark:text-white text-gray-600">
                {__("1 Token Value =")}
                <span className="px-2 py-0.5 ml-2 rounded-md bg-gray-900 text-white dark:bg-gray-700 dark:text-white font-semibold">
                    {currency_symbol}
                    {token_value}
                </span>
            </p>
            <hr className="my-2" />
            <p className="dark:text-white text-gray-600">
                {__("Your :tokenBalance tokens balance will be converted to", {
                    tokenBalance: tokens,
                })}
                <span className="px-2 py-0.5 ml-2 rounded-md bg-gray-900 text-white dark:bg-gray-700 dark:text-white font-semibold">
                    {currency_symbol}
                    {money_balance}
                </span>
            </p>

            {tokens >= min_withdraw && (
                <WithdrawForm
                    tokens={tokens}
                    money_balance={money_balance}
                    currency_symbol={currency_symbol}
                    pending_count={pending_count}
                    payout_settings={payout_settings}
                />
            )}
        </div>
    );
}
