function getUrlParams() {     
    var params = {};  		
    window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, 
        function(str, key, value) { 
            params[key] = value; 
        }
    );     
    return params; 
}
function logoutAdm() {
    axios.post("/djemals/logout").then((t=>{
        location.replace('/djemals')
    }))
}
function logoutPartner() {
    axios.post("/partner/logout").then((t=>{
        location.replace('/partner')
    }))
}
const simpleDateFormat = (created_at)=>{
    if (!created_at)
        return '';
    return moment().format('YY-MM-DD') == moment(created_at).format('YY-MM-DD') ? moment(created_at).format('HH:mm') : moment(created_at).format('YY-MM-DD')
}
const dateTimeFormat = (created_at)=>{
    if (!created_at)
        return '';
    return moment(created_at).format('YYYY-MM-DD HH:mm:ss')
}
const dateFormat = (created_at)=>{
    if (!created_at)
        return '';
    return moment(created_at).format('YYYY-MM-DD')
}
const changeRowColor=(e)=>{
    $$("tr.selectedRow").removeClass('selectedRow')
    $$(e.target).closest('tr').addClass('selectedRow')
    selectedRow = $$(e.target).closest('tr').attr('id')
}
const isset = (val, arr)=>{
    return typeof arr[val] =='boolean' ? true : false
}