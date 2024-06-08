import{T as w,o as i,d,b as a,u as s,w as m,F as b,Z as h,t as k,e as u,a as t,c as x,f as c,i as y,n as V,h as v}from"./app-t0wYczK6.js";import{A as $}from"./AuthenticationCard-CJmY4CvL.js";import{_ as B}from"./AuthenticationCardLogo-OC2r5_4f.js";import{_ as C}from"./Checkbox-6KTbD341.js";import{_ as f,a as p}from"./TextInput-BwVmy27a.js";import{_}from"./InputLabel-BawRvqsJ.js";import{_ as F}from"./PrimaryButton-XLQpkPYB.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const N={key:0,class:"mb-4 font-medium text-sm text-green-600"},q={class:"mt-4"},L={class:"block mt-4"},P={class:"flex items-center"},R=t("span",{class:"ms-2 text-sm text-gray-600"},"Remember me",-1),S={class:"flex items-center justify-end mt-4"},Z={__name:"Login",props:{canResetPassword:Boolean,status:String},setup(l){const e=w({email:"",password:"",remember:!1}),g=()=>{e.transform(n=>({...n,remember:e.remember?"on":""})).post(route("login"),{onFinish:()=>e.reset("password")})};return(n,o)=>(i(),d(b,null,[a(s(h),{title:"Log in"}),a($,null,{logo:m(()=>[a(B)]),default:m(()=>[l.status?(i(),d("div",N,k(l.status),1)):u("",!0),t("form",{onSubmit:v(g,["prevent"])},[t("div",null,[a(_,{for:"email",value:"Email"}),a(f,{id:"email",modelValue:s(e).email,"onUpdate:modelValue":o[0]||(o[0]=r=>s(e).email=r),type:"email",class:"mt-1 block w-full",required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),a(p,{class:"mt-2",message:s(e).errors.email},null,8,["message"])]),t("div",q,[a(_,{for:"password",value:"Password"}),a(f,{id:"password",modelValue:s(e).password,"onUpdate:modelValue":o[1]||(o[1]=r=>s(e).password=r),type:"password",class:"mt-1 block w-full",required:"",autocomplete:"current-password"},null,8,["modelValue"]),a(p,{class:"mt-2",message:s(e).errors.password},null,8,["message"])]),t("div",L,[t("label",P,[a(C,{checked:s(e).remember,"onUpdate:checked":o[2]||(o[2]=r=>s(e).remember=r),name:"remember"},null,8,["checked"]),R])]),t("div",S,[l.canResetPassword?(i(),x(s(y),{key:0,href:n.route("password.request"),class:"underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black"},{default:m(()=>[c(" Forgot your password? ")]),_:1},8,["href"])):u("",!0),a(F,{class:V(["ms-4",{"opacity-25":s(e).processing}]),disabled:s(e).processing},{default:m(()=>[c(" Log in ")]),_:1},8,["class","disabled"])])],32)]),_:1})],64))}};export{Z as default};