import{T as u,o as f,c as _,B as v,w as t,b as o,f as n,u as m,n as g,a as s,t as c}from"./app-t0wYczK6.js";import{_ as h}from"./ActionMessage-B35CWR3r.js";import{_ as b}from"./FormSection-CA88rXHO.js";import{_ as w,a as x}from"./TextInput-BwVmy27a.js";import{_ as l}from"./InputLabel-BawRvqsJ.js";import{_ as N}from"./PrimaryButton-XLQpkPYB.js";import"./SectionTitle-DD7CVgK-.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const T={class:"col-span-6"},y={class:"flex items-center mt-2"},S=["src","alt"],V={class:"ms-4 leading-tight"},$={class:"text-gray-900"},B={class:"text-gray-700 text-sm"},k={class:"col-span-6 sm:col-span-4"},E={__name:"UpdateTeamNameForm",props:{team:Object,permissions:Object},setup(e){const r=e,a=u({name:r.team.name}),d=()=>{a.put(route("teams.update",r.team),{errorBag:"updateTeamName",preserveScroll:!0})};return(U,i)=>(f(),_(b,{onSubmitted:d},v({title:t(()=>[n(" App Name ")]),description:t(()=>[n(" The app's name and owner information. ")]),form:t(()=>[s("div",T,[o(l,{value:"App Owner"}),s("div",y,[s("img",{class:"w-12 h-12 rounded-full object-cover",src:e.team.owner.profile_photo_url,alt:e.team.owner.name},null,8,S),s("div",V,[s("div",$,c(e.team.owner.name),1),s("div",B,c(e.team.owner.email),1)])])]),s("div",k,[o(l,{for:"name",value:"App Name"}),o(w,{id:"name",modelValue:m(a).name,"onUpdate:modelValue":i[0]||(i[0]=p=>m(a).name=p),type:"text",class:"mt-1 block w-full",disabled:!e.permissions.canUpdateTeam},null,8,["modelValue","disabled"]),o(x,{message:m(a).errors.name,class:"mt-2"},null,8,["message"])])]),_:2},[e.permissions.canUpdateTeam?{name:"actions",fn:t(()=>[o(h,{on:m(a).recentlySuccessful,class:"me-3"},{default:t(()=>[n(" Saved. ")]),_:1},8,["on"]),o(N,{class:g({"opacity-25":m(a).processing}),disabled:m(a).processing},{default:t(()=>[n(" Save ")]),_:1},8,["class","disabled"])]),key:"0"}:void 0]),1024))}};export{E as default};