import {HTTP} from '../http-common';


const getDefaultState = () => {
    return {
        initParams: {
            limit: {
                limit1: 100,
                limit2: 10,
            },
            dimensionFormat: '10*10',
            support: 'papier'
        },

        files: [],
        isSubmit: false
    }
};

export default {
    getImageLimit() {
        return HTTP.get('image/env');
    }
}
