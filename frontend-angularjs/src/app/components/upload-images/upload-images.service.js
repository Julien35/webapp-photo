{
    class UploadImagesService {

        toString() {
            return 'UploadImagesService';
        }

        upLoad() {
            return 'upload file ...';
        }
    }

    angular
        .module('app')
        .service('UploadImagesService', UploadImagesService);
}
