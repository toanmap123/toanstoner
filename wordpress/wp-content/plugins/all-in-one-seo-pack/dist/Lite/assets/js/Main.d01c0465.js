import{k as d}from"./links.4c32e7b9.js";import{R as l,a as f}from"./RequiresUpdate.8fe5c8b3.js";import{a as h}from"./addons.2b4a9919.js";import{C as g}from"./Index.affc2cb2.js";import{o as e,c as n,r as x,b as _,w as $,y as v}from"./vue.runtime.esm-bundler.ba5c08e0.js";import{_ as o}from"./_plugin-vue_export-helper.80405f63.js";import b from"./Redirects.74582804.js";import"./default-i18n.3881921e.js";import"./isArrayLikeObject.ab8f4241.js";import"./RequiresUpdate.6ee6f69b.js";import"./upperFirst.7faab9f8.js";import"./_stringToArray.4de3b1f3.js";import"./toString.7b877a36.js";import"./license.afc1306d.js";import"./allowed.ee78f9d1.js";/* empty css             */import"./params.f0608262.js";import"./Ellipse.9a695889.js";import"./index.df267eaa.js";import"./Caret.da0d1a59.js";import"./Header.4cff56dc.js";import"./ScrollAndHighlight.a51cda51.js";import"./LogoGear.9c6591e9.js";import"./AnimatedNumber.99a7d9bc.js";import"./numbers.c7cb4085.js";import"./Logo.b89d9cd6.js";import"./Support.b0ee140f.js";import"./Tabs.914ea6bd.js";import"./TruSeoScore.b474bf15.js";import"./Information.07ac38db.js";import"./Slide.3af65e43.js";import"./Url.7af60fc4.js";import"./Date.ceef1b3d.js";import"./constants.238e5b7b.js";import"./Exclamation.8e89b656.js";import"./Gear.29c1fe07.js";import"./Redirects.652b427f.js";import"./Index.d4232dd9.js";import"./JsonValues.870a4901.js";import"./strings.da852d37.js";import"./isString.b49e85a4.js";import"./ProBadge.a2777953.js";import"./External.b6186288.js";import"./Checkbox.5408a8ad.js";import"./Checkmark.fe7f082b.js";import"./Row.76881ed1.js";import"./Tooltip.d28f6bf4.js";import"./Plus.3b9712cb.js";import"./Blur.36d19f95.js";import"./Card.95fd844a.js";import"./Table.9ae5bcf6.js";import"./Index.f352280d.js";import"./RequiredPlans.cbedd1ac.js";import"./AddonConditions.50466020.js";const y={};function S(t,r){return e(),n("div")}const R=o(y,[["render",S]]),w={};function A(t,r){return e(),n("div")}const B=o(w,[["render",A]]),C={};function k(t,r){return e(),n("div")}const E=o(C,[["render",k]]),L={};function T(t,r){return e(),n("div")}const M=o(L,[["render",T]]),U={};function q(t,r){return e(),n("div")}const N=o(U,[["render",q]]);const D={setup(){return{redirectsStore:d()}},components:{CoreMain:g,FullSiteRedirect:R,ImportExport:B,Logs:E,Logs404:M,Redirects:b,Settings:N},mixins:[l,f],data(){return{strings:{pageName:this.$t.__("Redirects",this.$td)}}},computed:{showSaveButton(){return this.$route.name!=="redirects"&&this.$route.name!=="groups"&&this.$route.name!=="logs-404"&&this.$route.name!=="logs"&&this.$route.name!=="import-export"},excludeTabs(){var r,m,a,s,i,c,p,u;const t=h.isActive("aioseo-redirects")?this.getExcludedUpdateTabs("aioseo-redirects"):this.getExcludedActivationTabs("aioseo-redirects");return(a=(m=(r=this.redirectsStore.options)==null?void 0:r.logs)==null?void 0:m.log404)!=null&&a.enabled||t.push("logs-404"),(!((c=(i=(s=this.redirectsStore.options)==null?void 0:s.logs)==null?void 0:i.redirects)!=null&&c.enabled)||((u=(p=this.redirectsStore.options)==null?void 0:p.main)==null?void 0:u.method)==="server")&&t.push("logs"),t}}};function F(t,r,m,a,s,i){const c=x("core-main");return e(),_(c,{"page-name":s.strings.pageName,"show-save-button":i.showSaveButton,"exclude-tabs":i.excludeTabs},{default:$(()=>[(e(),_(v(t.$route.name)))]),_:1},8,["page-name","show-save-button","exclude-tabs"])}const It=o(D,[["render",F]]);export{It as default};
