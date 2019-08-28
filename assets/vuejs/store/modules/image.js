import ImageService from '../../services/imageService'

const getDefaultState = () => {
    return {
        initParams: {
            limit: [],
            dimensionFormat: [],
            support: []
        },

        files: [],
        isSubmit: false
    }
};

export default {
    namespaced: true,

    state: getDefaultState(),

    getters: {
        initParams: state => {
            return state.initParams;
        }
    },

    mutations: {
        update(state) {
            state.initParams = {};
        },

        submit(state, status) {
            state.isSubmit = status;
        },

        resetState(state) {
            Object.assign(state, getDefaultState())
        },

        setInitParams(state, initParams) {
            state.initParams = initParams;
        }
    },

    actions: {
        reset({commit}) {
            commit('resetState');
        },

        fetchInitParams ({ commit }) {
            ImageService.getImageLimit().then(response => {

                let initParams = {
                    limit: [],
                    dimensionFormat: [],
                    support: []
                };

                initParams.limit = response.data.conf;
                initParams.support = response.data.supportImage;

                commit('setInitParams', initParams);
            });
        }
    }
}
