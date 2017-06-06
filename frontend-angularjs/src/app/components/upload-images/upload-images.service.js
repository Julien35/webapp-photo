{
    class UploadImagesService {

        constructor($http) {
            'ngInject';
            this.$http = $http;
        }

        toString() {
            return 'UploadImagesService';
        }

        upLoad(files, uploadUrl) {
            console.log(files);
            console.log(uploadUrl);

            this.$http({
                method: 'POST',
                url: uploadUrl + '/'
            }).then(function successCallback(response) {
                // this callback will be called asynchronously
                // when the response is available
                console.log(response);
            }, function errorCallback(response) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
                console.log(response);
            });


            return 'upload files ...';


        }
    }

    angular
        .module('app')
        .service('UploadImagesService', UploadImagesService);
}
