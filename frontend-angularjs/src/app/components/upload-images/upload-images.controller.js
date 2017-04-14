{
    class UploadImagesController {

        constructor(UploadImagesService) {
            this.UploadImagesService = UploadImagesService;

            this.UploadImagesService.upload();
        }
    }

    angular
        .module('app')
        .controller('UploadImagesController', UploadImagesController);
}
