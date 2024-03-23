import{b as u,r as x,j as r,a as t,H as g}from"./app.9e598114.js";import{A as f}from"./AuthenticatedLayout.e817ad62.js";import{_ as o}from"./Translate.dc83ae5b.js";import w from"./History.c86e394d.js";import v from"./Settings.5a083775.js";import y from"./Request.bf31e062.js";import _ from"./AccountNavi.07617d98.js";import"./Front.167c3130.js";import"./index.esm.04772378.js";import"./iconBase.4930b98a.js";import"./index.esm.c83823d4.js";import"./index.esm.98b0ee44.js";import"./transition.955527f9.js";import"./Modal.81f47e62.js";import"./react-toastify.esm.d2e42348.js";import"./TextInput.b942e667.js";import"./index.esm.487ec2bb.js";import"./Spinner.b056f180.js";import"./InputLabel.b1adb635.js";import"./InputError.4d53dcfa.js";import"./PrimaryButton.683939b2.js";import"./Textarea.ca4513c0.js";import"./index.esm.bac58b4a.js";import"./WithdrawForm.415deba2.js";function U({auth:e,pendingCount:d,withdrawals:l,payoutSettings:n}){const{currency_symbol:p,currency_code:k,token_value:h,min_withdraw:b}=u().props,[i,a]=x.exports.useState("Withdraw"),s="text-xl font-bold mr-2 md:mr-4 text-indigo-800 dark:text-indigo-500 border-b-2 border-indigo-800",m="text-xl font-bold mr-2 md:mr-4 hover:text-indigo-800 dark:text-white dark:hover:text-indigo-500";return r(f,{auth:e,children:[t(g,{title:o("Withdraw")}),r("div",{className:"lg:flex lg:space-x-10 w-full",children:[t(_,{active:"withdraw"}),r("div",{className:"flex-grow",children:[r("div",{className:"mb-5",children:[t("button",{className:i=="Withdraw"?s:m,onClick:c=>a("Withdraw"),children:o("Withdraw")}),t("button",{className:i=="History"?s:m,onClick:c=>a("History"),children:o("History")}),t("button",{className:i=="Settings"?s:m,onClick:c=>a("Settings"),children:o("Settings")})]}),i=="Withdraw"&&t(y,{token_value:h,currency_symbol:p,tokens:e.user.tokens,money_balance:e.user.moneyBalance,min_withdraw:b,pending_count:d,payout_settings:n}),i=="Settings"&&t(v,{payoutSettings:n}),i=="History"&&t(w,{withdrawals:l})]})]})]})}export{U as default};