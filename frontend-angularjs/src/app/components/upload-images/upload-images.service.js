{
    class UploadImagesService {

        toString() {
            return 'UploadImagesService';
        }

        upLoad(files, uploadUrl) {
            console.log(files);
            console.log(uploadUrl);
            return 'upload files ...';
        }
    }

    angular
        .module('app')
        .service('UploadImagesService', UploadImagesService);
}
