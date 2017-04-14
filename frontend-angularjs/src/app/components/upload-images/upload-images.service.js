{
    class UploadImagesService {

        toString() {
            return 'UploadImagesService';
        }

        upload() {
            return 'upload file ...';
        }
    }

    angular
        .module('app')
        .service('UploadImagesService', UploadImagesService);
}
