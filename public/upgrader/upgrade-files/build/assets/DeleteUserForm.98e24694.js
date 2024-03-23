import{r as l,u as x,j as t,a as e}from"./app.70eb7c5f.js";import{D as c}from"./DangerButton.dc51b525.js";import{I as g}from"./InputError.afc03b2f.js";import{I as N}from"./InputLabel.b913582c.js";import{M as D}from"./Modal.ea61d8f0.js";import{S as k}from"./SecondaryButton.d42a89f3.js";import{T as v}from"./TextInput.9faad775.js";import"./transition.a700d2e8.js";function B({className:d}){const[i,a]=l.exports.useState(!1),o=l.exports.useRef(),{data:m,setData:u,delete:p,processing:f,reset:n,errors:y}=x({password:""}),h=()=>{a(!0)},w=s=>{s.preventDefault(),p(route("profile.destroy"),{preserveScroll:!0,onSuccess:()=>r(),onError:()=>o.current.focus(),onFinish:()=>n()})},r=()=>{a(!1),n()};return t("section",{className:`space-y-6 ${d}`,children:[t("header",{children:[e("h2",{className:"text-lg font-medium text-gray-900 dark:text-gray-100",children:"Delete Account"}),e("p",{className:"mt-1 text-sm text-gray-600 dark:text-gray-400",children:"Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain."})]}),e(c,{onClick:h,children:"Delete Account"}),e(D,{show:i,onClose:r,children:t("form",{onSubmit:w,className:"p-6",children:[e("h2",{className:"text-lg font-medium text-gray-900 dark:text-gray-100",children:"Are you sure your want to delete your account?"}),e("p",{className:"mt-1 text-sm text-gray-600 dark:text-gray-400",children:"Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account."}),t("div",{className:"mt-6",children:[e(N,{for:"password",value:"Password",className:"sr-only"}),e(v,{id:"password",type:"password",name:"password",ref:o,value:m.password,handleChange:s=>u("password",s.target.value),className:"mt-1 block w-3/4",isFocused:!0,placeholder:"Password"}),e(g,{message:y.password,className:"mt-2"})]}),t("div",{className:"mt-6 flex justify-end",children:[e(k,{onClick:r,children:"Cancel"}),e(c,{className:"ml-3",processing:f,children:"Delete Account"})]})]})})]})}export{B as default};