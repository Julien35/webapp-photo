{
    class UploadImagesService {

        constructor($http) {
            'ngInject';
            this.$http = $http;
        }

        upLoad(files, uploadUrl) {
            console.log(files);
            console.log(uploadUrl);

            return this.$http(
                {
                    method: 'POST',
                    url: uploadUrl,
                    data: {
                        files: files
                    },
                    "headers": {
                        'Content-Type': undefined // important
                    }
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
