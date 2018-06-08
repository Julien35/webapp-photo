import Vue from 'vue'
import App from './App'
import store from './store'
import router from './router'
import Vuelidate from 'vuelidate'

if (document.querySelector('#app')) {

    Vue.use(Vuelidate);
    // Global event bus
    Vue.prototype.$eventBus = new Vue();

    new Vue({
        router,
        store,
        render: h => h(App)
    }).$mount('#app');
}
