(function () {
    'use strict';

    function UploadController($scope, $log, UploadService) {

        this.test = 'test';
        $log.log(this);

        $scope.uploadedFile = function (element) {
            $scope.$apply(function ($scope) {
                $scope.files = element.files;
            });
        };

        $scope.addFile = function () {
            UploadService.uploadfile($scope.files,
                function (msg) // success
                {
                    console.log('uploaded');
                },
                function (msg) // error
                {
                    console.log('error');
                });
        };

    }


    function UploadService($http) {
        return {
            uploadfile: function (files, success, error) {

                var url = 'http://webapp-server.local/app_dev.php/image/upload';

                for (var i = 0; i < files.length; i++) {
                    var fd = new FormData();

                    fd.append("file", files[i]);

                    console.log(fd);

                    $http.post(url, fd, {

                        withCredentials: false,

                        headers: {
                            'Content-Type': undefined
                        },
                        transformRequest: angular.identity

                    })
                        .then(function (data) {
                            console.log(data);
                        })
                        .catch(function (data) {
                            console.log(data);
                        });
                }
            }
        }
    }


    angular
        .module('uploadtest', [])
        .controller('UploadController', UploadController)
        .factory('UploadService', UploadService);

})();