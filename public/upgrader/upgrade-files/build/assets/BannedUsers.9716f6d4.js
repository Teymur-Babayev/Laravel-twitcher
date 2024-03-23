import{_ as t}from"./Translate.dc83ae5b.js";import{b as m,j as s,a as e,H as d,L as a}from"./app.70eb7c5f.js";import{A as n}from"./AuthenticatedLayout.37d9e013.js";import{F as c}from"./index.esm.0e26725f.js";import{a as o}from"./index.esm.80e20a61.js";import h from"./AccountNavi.ce160f74.js";import"./Front.5dab1473.js";import"./index.esm.dc99be0f.js";import"./iconBase.19c775b5.js";import"./index.esm.b743b834.js";import"./index.esm.b47aa8e1.js";import"./transition.a700d2e8.js";import"./Modal.ea61d8f0.js";import"./react-toastify.esm.b9d392e3.js";import"./TextInput.9faad775.js";function A({roomBans:i}){return m().props,s(n,{children:[e(d,{title:t("Banned Users")}),s("div",{className:"lg:flex lg:space-x-10",children:[e(h,{active:"bans"}),e("div",{className:"w-full",children:s("div",{className:"mt-5 p-4 sm:p-8 bg-white w-full dark:bg-zinc-900 shadow sm:rounded-lg",children:[e("header",{children:s("div",{className:"flex items-start space-x-3",children:[e("div",{children:e(o,{className:"w-8 h-8 text-gray-600 dark:text-white"})}),s("div",{children:[s("h2",{className:"text-lg md:text-xl font-medium text-gray-600 dark:text-gray-100",children:[t("Banned Users")," (",i.length,")"]}),e("p",{className:"mt-1 mb-2 text-sm text-gray-600 dark:text-gray-400",children:t("These users can't view your live streams. To ban someone, simply click their username in the live chat.")})]})]})}),e("hr",{className:"my-5"}),i.length===0&&s("div",{className:"text-xl dark:text-white text-gray-700 flex items-center space-x-4",children:[e(c,{className:"w-10 h-10"}),e("div",{children:t("No one is banned from your live streams")})]}),e("div",{className:"flex flex-col md:flex-row flex-wrap md:items-center",children:i.map((r,l)=>s("div",{className:"flex items-center space-x-2  mr-5 mb-5",children:[e("div",{children:e(a,{href:`${r.user.is_streamer==="yes"?route("channel",{user:r.user.username}):""}`,children:e("img",{src:r.user.profile_picture,alt:"",className:"rounded-full h-14 border-zinc-200 dark:border-indigo-200 border"})})}),s("div",{children:[e(a,{className:"block text-gray-600 dark:text-gray-300 text-lg font-semibold mt-1",href:`${r.user.is_streamer==="yes"?route("channel",{user:r.user.username}):""}`,children:r.user.name}),s(a,{className:"block text-sky-500 hover:text-sky-700 font-semibold text-sm",href:`${r.user.is_streamer==="yes"?route("channel",{user:r.user.username}):""}`,children:["@",r.user.username]}),e("p",{className:"text-sm text-gray-600 dark:text-gray-400",children:t("Banned on :date",{date:r.banned_at_human})}),e(a,{href:route("channel.liftUserBan",{roomban:r.id}),className:"text-xs text-rose-600 hover:text-rose-800",children:t("Unban")})]})]},l))})]})})]})]})}export{A as default};