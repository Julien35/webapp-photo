import ImageService from '../../services/imageService'

const getDefaultState = () => {
    return {
        initParams: {
            limit: [],
            dimensionFormat: [],
            support: []
        },

        files: {
            supportType: {},
            photos: [],
        },
        isSubmit: false
    }
};

export default {
    namespaced: true,

    state: getDefaultState(),

    getters: {
        initParams: state => {
            return state.initParams;
        },

        getSupport: state => {
            return state.initParams.support;
        },

        getSupportType: state => {
            return state.files.supportType;
        }
    },

    mutations: {
        addPhoto(state, photo) {
            state.files.photos.push(photo);
        },

        updateFilesSupport(state, support) {
            let supportData = {
                'type': support.text,
                'price': support.value
            };
            state.files.supportType.type = support.text;
            state.files.supportType.price = support.value;
        },

        updateFiles(state, files) {
            state.files = files;
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

        fetchInitParams({commit}) {
            return ImageService.getImageLimit().then(response => {

                let initParams = {
                    limit: [],
                    dimensionFormat: [],
                    support: []
                };
                initParams.limit = response.data.conf;
                initParams.support = response.data.supportImage;

                let files = {
                    supportType: {},
                    photos: [],
                };
                files.supportType = initParams.support[0];

                commit('setInitParams', initParams);
                commit('updateFiles', files);
            });
        }
    }
}
