import{k as u,s as n,C as d,o as p,d as k}from"./app-t0wYczK6.js";const i=["value"],h={__name:"Checkbox",props:{checked:{type:[Array,Boolean],default:!1},value:{type:String,default:null}},emits:["update:checked"],setup(e,{emit:c}){const s=c,l=e,t=u({get(){return l.checked},set(a){s("update:checked",a)}});return(a,o)=>n((p(),k("input",{"onUpdate:modelValue":o[0]||(o[0]=r=>t.value=r),type:"checkbox",value:e.value,class:"rounded border-gray-300 text-black shadow-sm focus:ring-black"},null,8,i)),[[d,t.value]])}};export{h as _};