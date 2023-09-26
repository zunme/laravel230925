/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
import moment from 'moment';
window.moment = moment;

import axios from 'axios';
window.axios = axios;
window.hiddenAxios = axios.create({});

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axios.interceptors.request.use((function(config) {
    config.headers.Accept = 'application/json'
    config.responseType = 'json'
    config.responseEncoding = 'utf8'
    app.preloader.show()
    return config
}));

window.axios.interceptors.response.use((t=>(app.preloader.hide(),
t)), (t=>{
    app.preloader.hide();
    const e = t.response;
    var text ='잠시후에 이용해주세요';
    // V2 
    if (e.status == 401 ){
        gotoLogin()
        return;
    }
    if (420 == e.status && e.data && e.data.data && e.data.data.alert) {
        let t = `<div>${e.data.data.alert.text ?? e.data.message ?? "잠시후에 이용해주세요"}</div>`
        , o = "";
        return e.data.data.alert.desc && e.data.data.alert.desc.map((t=>{
            o += `<div class="alert-desc-item">${t}</div>`
        }
        )),
        o && (o = `<div class="alert-desc-wrap">${o}</div>`),
        t += o,
        void app.dialog.alert(t, e.data.data.alert.title ?? "")
    }
    if( e.data && e.data.message ) text =  e.data.message;
    else if ("object" == typeof e.data && "object" == typeof e.data.errors)
        for (key in e.data.errors) {
            text = e.data.errors[key],
            "object" == typeof text && (text = text[0]);
            break
        }
    else
        text = e.data.message ? e.data.message : "잠시후에 이용해주세요";
    return app.toast.create({
        text: text,
        position: "center",
        closeTimeout: 5000
    }).open(),
    Promise.reject(t.response)
}
));
