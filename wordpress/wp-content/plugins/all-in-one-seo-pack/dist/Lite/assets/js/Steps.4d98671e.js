import{a as S,u as h,g as k}from"./links.4c32e7b9.js";import{s as C,_ as b}from"./default-i18n.3881921e.js";import{r as d,o as n,c as i,t,I as m,b as w,w as r,D as u,a,d as _,f as z,u as A}from"./vue.runtime.esm-bundler.ba5c08e0.js";import{_ as M}from"./_plugin-vue_export-helper.80405f63.js";import{u as x,a as T}from"./Wizard.55b35451.js";const W={setup(){const{strings:o}=x();return{optionsStore:S(),rootStore:h(),strings:o}},mixins:[T]},B={class:"aioseo-wizard-close-and-exit"},E=["href"],$={class:"aioseo-modal-body"},I=["innerHTML"],L={class:"actions"};function N(o,e,l,s,f,g){const y=d("svg-close"),p=d("base-button"),v=d("core-modal");return n(),i("div",B,[o.$isPro||s.optionsStore.options.advanced.usageTracking?(n(),i("a",{key:0,href:s.rootStore.aioseo.urls.aio.dashboard},t(s.strings.closeAndExit),9,E)):(n(),i("a",{key:1,href:"#",onClick:e[0]||(e[0]=m(c=>o.showModal=!0,["prevent"]))},t(s.strings.closeAndExit),1)),o.showModal&&!o.$isPro?(n(),w(v,{key:2,onClose:e[3]||(e[3]=c=>o.showModal=!1)},{header:r(()=>[u(t(s.strings.buildABetterAioseo)+" ",1),a("button",{class:"close",onClick:e[2]||(e[2]=m(c=>o.showModal=!1,["stop"]))},[_(y,{onClick:e[1]||(e[1]=c=>o.showModal=!1)})])]),body:r(()=>[a("div",$,[a("div",{class:"reset-description",innerHTML:s.strings.getImprovedFeatures},null,8,I),a("div",L,[_(p,{tag:"a",href:s.rootStore.aioseo.urls.aio.dashboard,type:"gray",size:"medium"},{default:r(()=>[u(t(s.strings.noThanks),1)]),_:1},8,["href"]),_(p,{type:"blue",size:"medium",loading:o.loading,onClick:o.processOptIn},{default:r(()=>[u(t(s.strings.yesCountMeIn),1)]),_:1},8,["loading","onClick"])])])]),_:1})):z("",!0)])}const U=M(W,[["render",N]]);const V={class:"aioseo-wizard-steps"},F={__name:"Steps",setup(o){const e="all-in-one-seo-pack",l=k(),s=C(b("Step %1$s of %2$s",e),l.getCurrentStageCount,l.getTotalStageCount);return(f,g)=>(n(),i("div",V,t(A(s)),1))}};export{U as W,F as _};
