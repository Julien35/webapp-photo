{
    class UploadImagesService {

        toString() {
            return 'UploadImagesService';
        }

        upLoad(file, uploadUrl) {
            console.log(file);
            console.log(uploadUrl);
            return 'upload file ...';
        }
    }

    angular
        .module('app')
        .service('UploadImagesService', UploadImagesService);
}
