import{_ as n}from"./Translate.dc83ae5b.js";import{F as m}from"./Front.5dab1473.js";import{a,j as r,H as t}from"./app.70eb7c5f.js";import{a as o}from"./index.esm.80e20a61.js";import"./index.esm.dc99be0f.js";import"./iconBase.19c775b5.js";import"./index.esm.b743b834.js";import"./index.esm.b47aa8e1.js";import"./transition.a700d2e8.js";import"./Modal.ea61d8f0.js";import"./react-toastify.esm.b9d392e3.js";import"./TextInput.9faad775.js";function g({streamUser:e}){return a(m,{children:r("div",{className:"max-w-xl mx-auto",children:[a(t,{title:n("Banned from :channelName's channel (:handle)",{channelName:e.name,handle:`@${e.username}`})}),r("div",{className:"bg-white dark:bg-zinc-900 dark:text-white shadow sm:rounded-lg p-4 sm:p-8",children:[a(o,{className:"h-36 w-36 mx-auto mb-4 text-rose-600"}),r("div",{className:"flex mx-auto items-center",children:[a("img",{src:e.profile_picture,className:"rounded-full w-20 border-2 border-indigo-100"}),a("h2",{className:"text-2xl text-center font-semibold text-gray-900 dark:text-gray-100",children:n("You have been banned from :handle's live",{channelName:e.name,handle:`@${e.username}`})})]})]})]})})}export{g as default};