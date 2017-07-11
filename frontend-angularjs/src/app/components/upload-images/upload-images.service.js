{
    class UploadImagesService {

        constructor($http) {
            'ngInject';
            this.$http = $http;
        }

        /**
         * new FormData
         * @param files
         * @param uploadUrl
         */
        upLoad(files, uploadUrl) {

            let payload = new FormData();
            payload.append('files', files);

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
