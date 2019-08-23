import Vue from 'vue'
import Vuex from 'vuex'
import image from './modules/image'
import contact from './modules/forms/contact'

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        contactModule: contact,
        imageModule: image
    },
    strict: debug
});
