import Vue from 'vue'
import Vuex from 'vuex'
import contact from './modules/forms/contact'
// import cart from './modules/cart'
// import products from './modules/products'

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        contactModule: contact
        // cart,
        // products
    },
    strict: debug
});
