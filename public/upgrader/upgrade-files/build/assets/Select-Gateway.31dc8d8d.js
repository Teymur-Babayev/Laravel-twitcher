import{b as u,j as t,a as e,H as k,L as s}from"./app.70eb7c5f.js";import{A as f}from"./AuthenticatedLayout.37d9e013.js";import{_ as a}from"./Translate.dc83ae5b.js";import"./Front.5dab1473.js";import"./index.esm.dc99be0f.js";import"./iconBase.19c775b5.js";import"./index.esm.b743b834.js";import"./index.esm.b47aa8e1.js";import"./transition.a700d2e8.js";import"./Modal.ea61d8f0.js";import"./react-toastify.esm.b9d392e3.js";import"./TextInput.9faad775.js";import"./index.esm.80e20a61.js";function G({auth:i,tokenPack:r,paypalEnabled:c,stripeEnabled:l,bankEnabled:o,ccbillEnabled:n,paypalImg:m,ccbillImg:d,stripeImg:h,bankImg:p}){const{currency_symbol:x,currency_code:y}=u().props;return t(f,{auth:i,children:[e(k,{title:a("Select Gateway - Purchase Tokens")}),t("div",{className:"p-4 sm:p-8 bg-white max-w-3xl mx-auto dark:bg-zinc-900 shadow sm:rounded-lg",children:[e("h3",{className:"text-3xl font-semibold dark:text-white text-center",children:a("Select Payment Gateway")}),e("h3",{className:"mt-5 text-2xl font-semibold dark:text-white text-center",children:a("You are purchasing :tokensAmount tokens for :moneyAmount",{tokensAmount:r.tokensFormatted,moneyAmount:`${x}${r.price}`})}),t("div",{className:"mt-10 flex items-center justify-center flex-col space-y-5",children:[t("div",{children:[e("span",{className:"block text-center text-gray-700 font-bold dark:text-white text-lg",children:a("Pay via PayPal")}),c=="Yes"&&e(s,{href:route("paypal.purchaseTokens",{tokenPack:r.id}),children:e("img",{src:m,alt:"paypal",className:"h-24 mx-auto"})})]}),l=="Yes"&&t("div",{children:[e("span",{className:"block text-center mb-3 text-gray-700 font-bold dark:text-white text-lg",children:a("Credit Card (Stripe)")}),e(s,{href:route("stripe.purchaseTokens",{tokenPack:r.id}),children:e("img",{src:h,alt:"stripe",className:"h-14 mx-auto"})})]}),n=="Yes"&&t("div",{className:"pt-5",children:[e("span",{className:"block text-center text-gray-700 font-bold dark:text-white text-lg",children:a("CCBill (Credit Card)")}),e("a",{href:route("ccbill.purchaseTokens",{tokenPack:r.id}),children:e("img",{src:d,alt:"stripe",className:"h-14 mx-auto"})})]}),o=="Yes"&&t("div",{className:"mt-10",children:[e("span",{className:"block text-center text-gray-700 font-bold dark:text-white text-lg",children:a("Pay via Bank Transfer")}),e(s,{href:route("bank.purchaseTokens",{tokenPack:r.id}),children:e("img",{src:p,alt:"stripe",className:"h-14 mx-auto"})})]})]})]})]})}export{G as default};