import{f as n}from"./fetch-b8ff0b47.js";import{s as c}from"./selectStudents-68a567db.js";import{C as S,f as d}from"./choices-b42e1b7a.js";import"./_commonjsHelpers-725317a4.js";const u=({method:s})=>{const e="selectClassroomSessions";return{selectClassroomSessions:{el:null,url:null,urlSearch:{},data:[]},async initSelectClassroomSessions(){this[e].el=new S(`form.${s} [name="classroom_session_id"]`,{silent:!0,allowHTML:!1,searchResultLimit:10,renderSelectedChoices:"always",searchPlaceholderValue:"Cari sesi kelas"}),this[e].url=this[e].el.passedElement.element.getAttribute("data-url"),this[e].urlSearch={},this[e].data=[],this.fetchClassroomSessions(),this[e].el.passedElement.element.addEventListener("search",async a=>{const o=a.detail.value;this[e].urlSearch={s_course:o,s_classroom:o,s_lecturer:o},this.fetchClassroomSessions()},!1),this[e].el.passedElement.element.addEventListener("showDropdown",async()=>{this[e].el.input.element.value=this[e].urlSearch.s_course??""},!1)},fetchClassroomSessions:async function(){return new Promise((a,o)=>{this[e].fetchTimeout&&(clearTimeout(this[e].fetchTimeout),a([])),this[e].fetchTimeout=setTimeout(()=>{let i=this[e].url;Object.keys(this[e].urlSearch).length>0&&(i+=`?${new URLSearchParams({...this[e].urlSearch}).toString()}`),n(i).then(h=>{const{data:m}=h,r=m.map(t=>{const f={year:"numeric",month:"long",day:"numeric",hour:"numeric",minute:"numeric",hour12:!0,timeZone:"Asia/Jakarta"};return{label:`${new Intl.DateTimeFormat("id-ID",f).format(new Date(t.start_datetime))} | ${t.classroom.course.name} ${t.classroom.name} ${t.season.name} | ${t.lecturer.user.name}`,value:t.id,selected:t.id==this.body.classroom_session_id}});this[e].data=r,this[e].el.setChoices(r,"value","label",!0),a(r)})},500)})},async fetchCurrentClassroomSession(){this[e].urlSearch={s_id:this.body.classroom_session_id},await this.fetchClassroomSessions()}}};window.editModal=b;function b(s){return{element:s,errors:null,body:{...l},editModalInit(){this.initSelectStudents(),this.initSelectClassroomSessions()},...d({method:"update"}),...c({method:"edit"}),...u({method:"edit"}),async editModalChangeHandler(e){e?(this.loading=!0,await this.fetchById(),await Promise.all([this.fetchCurrentStudent(),this.fetchCurrentClassroomSession()]),this.loading=!1):(this.loading=!1,this.body={...l})},updateSuccess(e){this.element.querySelector('button[aria-label="Close"]').click(),this.refreshTable()},async fetchById(){const e=await n(this.urlEdit);return this.body=e,e}}}const l={status:"",student_id:"",classroom_session_id:"1"};window.pageDashboard=y;function y(s){return{element:s,data_id:null,urlEdit:null,urlUpdate:null,loading:!1,initPageDashboard(){},refreshTable(){const e=document.querySelector('button[aria-label="Refresh Table"]');e&&e.click()}}}window.createModal=C;function C(s){return{element:s,errors:null,body:{...l},createModalInit(){this.initSelectStudents(),this.initSelectClassroomSessions()},...d({method:"store"}),...c({method:"create"}),...u({method:"create"}),storeSuccess(e){this.element.querySelector('button[aria-label="Close"]').click(),this.refreshTable()},createModalChangeHandler(e){this.body={...l}}}}window.pageDashboard=w;function w(s){return{element:s,data_id:null,urlEdit:null,urlUpdate:null,loading:!1,initPageDashboard(){},refreshTable(){const e=document.querySelector('button[aria-label="Refresh Table"]');e&&e.click()}}}