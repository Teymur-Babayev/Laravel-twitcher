import{b as l,u as p,r as u,j as t,a as e,H as g}from"./app.9e598114.js";import{A as f}from"./AuthenticatedLayout.e817ad62.js";import{_ as r}from"./Translate.dc83ae5b.js";import{H as h}from"./index.esm.12370a64.js";import{I as y}from"./InputLabel.b1adb635.js";import{P as b}from"./PrimaryButton.683939b2.js";import"./TextInput.b942e667.js";import{I as x}from"./InputError.4d53dcfa.js";import"./Front.167c3130.js";import"./index.esm.04772378.js";import"./iconBase.4930b98a.js";import"./index.esm.c83823d4.js";import"./index.esm.98b0ee44.js";import"./transition.955527f9.js";import"./Modal.81f47e62.js";import"./react-toastify.esm.d2e42348.js";import"./index.esm.487ec2bb.js";function C(){const{auth:s}=l().props,{data:v,setData:m,errors:a,processing:n,post:c,progress:o}=p({document:""});u.exports.useEffect(()=>{console.log(a)},[a]);const d=i=>{i.preventDefault(),c(route("streamer.submitVerification"))};return t(f,{auth:s,children:[e(g,{title:r("Verify Identity To Start Streaming")}),e("div",{className:"ml-0",children:t("div",{className:"p-4 sm:p-8 bg-gray-100 dark:bg-zinc-900 dark:text-white shadow sm:rounded-lg",children:[t("div",{className:"flex items-center",children:[e("div",{children:e(h,{className:"h-12 w-12 mr-2"})}),t("div",{children:[e("h2",{className:"text-xl font-semibold text-gray-900 dark:text-gray-100",children:r("Verify Identity to Start Streaming")}),e("p",{className:"dark:text-white text-sm",children:r("In order to start streaming, you need to send your gov. issued ID/passport to verify the account name matches to the document.")})]})]}),t("div",{className:"mt-5",children:[t("form",{onSubmit:d,children:[e(y,{value:r("Document (PNG or JPG)")}),e("input",{className:"p-1 block w-full text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-300 focus:outline-none dark:bg-zinc-800 dark:border-gray-600 dark:placeholder-zinc-900",id:"document",type:"file",required:!0,accept:"image/jpg,image/png",onChange:i=>m("document",i.target.files[0])}),e(x,{className:"mt-2",message:a.document}),e(b,{className:"mt-5",processing:n,children:r("Submit Request")})]}),o&&t("progress",{value:o.percentage,max:"100",children:[o.percentage,"%"]})]})]})})]})}export{C as default};