{
    class UploadImagesService {

        constructor($http) {
            'ngInject';
            this.$http = $http;
        }

        /** Send one file to the backend
         * new FormData
         * @param file
         * @param uploadUrl
         */
        upLoad(file, uploadUrl) {

            let payload = new FormData();
            payload.append('file', file);

            return this.$http(
                {
                    method: 'POST',
                    url: uploadUrl,
                    data: payload,
                    transformRequest: angular.identity,
                    headers: {'Content-Type': undefined}
                }
            ).then(this.handleSuccess)
                .catch(this.handleError);

        }

        handleSuccess(response) {
            // use response
            // response: { data, status, statusText, headers, config }
            console.log("success");
            return response.data;
        }

        handleError(response) {
            // handle errors
            console.log("error");
        }
    }

    angular
        .module('app')
        .service('UploadImagesService', UploadImagesService);
}
