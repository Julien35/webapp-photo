import Vue from 'vue'
import App from './App'
import store from './store'
import router from './router'
import Vuelidate from 'vuelidate'

if (document.querySelector('#app')) {

    Vue.use(Vuelidate);
    // Global event bus
    Vue.prototype.$eventBus = new Vue();
    // Debug log
    Vue.prototype.$log = console.log;

    new Vue({
        router,
        store,
        render: h => h(App)
    }).$mount('#app');
}
