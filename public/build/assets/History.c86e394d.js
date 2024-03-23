import{b as p,u as m,r as h,j as s,a as e,F as x}from"./app.9e598114.js";import{_ as a}from"./Translate.dc83ae5b.js";import{d as y}from"./index.esm.98b0ee44.js";import{S as u}from"./Spinner.b056f180.js";import{Q as g}from"./react-toastify.esm.d2e42348.js";import"./iconBase.4930b98a.js";function C({withdrawals:c}){const{currency_symbol:l,currency_code:N}=p().props,{data:b,setData:f,post:n,processing:d,errors:r}=m(),i=t=>{switch(t){case"Pending":return"bg-yellow-500 text-white px-2 py-1 rounded-lg";case"Paid":return"bg-green-500 text-white px-2 py-1 rounded-lg";case"Canceled":return"bg-red-100 text-red-600 px-2 py-1 rounded-lg"}};h.exports.useEffect(()=>{Object.keys(r).length&&Object.keys(r).map(t=>{g.error(r[t])})},[r]);const o=t=>{n(route("payout.cancelRequest",{withdrawal_id:t}))};return s("div",{className:"p-4 sm:p-8 bg-white dark:bg-zinc-900 shadow sm:rounded-lg",children:[s("div",{className:"flex items-center space-x-4",children:[e("div",{children:d?e(u,{}):e(y,{className:"w-12 h-12 text-green-600"})}),s("div",{children:[e("h3",{className:"text-2xl font-semibold dark:text-white",children:a("Payout History")}),e("p",{className:"mt-1 text-gray-600 dark:text-gray-400",children:a("History of payments made to you")})]})]}),e("div",{className:"mt-4",children:c.length?e(x,{children:e("div",{className:"relative overflow-x-auto mt-5",children:s("table",{className:"w-full text-sm text-left text-gray-500 dark:text-gray-400",children:[e("thead",{className:"text-xs text-gray-700 uppercase bg-gray-50 dark:bg-zinc-800 dark:text-gray-400",children:s("tr",{children:[e("th",{className:"px-6 py-3",children:a("ID")}),e("th",{className:"px-6 py-3",children:a("Tokens")}),e("th",{className:"px-6 py-3",children:a("Amount")}),e("th",{className:"px-6 py-3",children:a("Status")}),e("th",{className:"px-6 py-3",children:a("Date")}),e("th",{className:"px-6 py-3",children:"-"})]})}),e("tbody",{children:c.map(t=>s("tr",{className:"bg-white border-b dark:bg-zinc-900 dark:border-zinc-700",children:[s("td",{className:"px-6 py-4 font-bold",children:["#",t.id]}),e("td",{className:"px-6 py-4",children:e("span",{className:"px-2 py-1 rounded-lg bg-neutral-300 text-neutral-700",children:t.tokens})}),e("td",{className:"px-6 py-4",children:e("span",{className:"px-2 py-1 rounded-lg bg-sky-500 text-white",children:`${l}${t.amount}`})}),e("td",{className:"px-6 py-4",children:e("span",{className:i(t.status),children:t.status})}),e("td",{className:"px-6 py-4",children:t.created_at_human}),e("td",{className:"px-6 py-4",children:t.status=="Pending"&&e("button",{disabled:d,onClick:k=>o(t.id),className:"text-sky-500 hover:text-sky-700",children:a("Cancel")})})]},t.id))})]})})}):e("span",{className:"text-2xl text-gray-700",children:a("You made no withdrawals yet")})})]})}export{C as default};