{
    class UploadImagesController {

        constructor(UploadImagesService) {
            this.UploadImagesService = UploadImagesService;
            this.toto = this.upLoad();
        }

        upLoad() {
            console.log(this.UploadImagesService.upLoad());
            return this.UploadImagesService.upLoad();
        }

    }

    angular
        .module('app')
        .controller('UploadImagesController', UploadImagesController);
}
