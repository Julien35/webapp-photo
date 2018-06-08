import {Contact} from "../../../Models/Contact";

const getDefaultState = () => {
    return {
        contact: new Contact(
            {name: 'Julien', email: 'julien@mail.com', message: 'Kikou'}
        ),
        isSubmit: false
    }
};

export default {
    namespaced: true,

    state: getDefaultState(),

    getters: {
        get: state => {
            return state.contact;
        }
    },

    mutations: {
        update(state, payload) {
            // state.contact
        },

        submit(state, status) {
            state.isSubmit = status;
        },

        resetState(state) {
            Object.assign(state, getDefaultState())
        }
    },

    actions: {
        reset({commit}) {
            commit('resetState');
        }
    }
}
