{
    class UploadImagesController {

        constructor(UploadImagesService) {
            this.UploadImagesService = UploadImagesService;
            this.upLoadUrl = 'http://workspace-web.local/webapp-photo/backend-symfony/web/app_dev.php';
            this.file = 'myFile';
        }

        upLoad() {
            let fd = new FormData(window.document.querySelector("form"));
            console.log(fd);
            let testService = this.UploadImagesService.upLoad(this.file, this.upLoadUrl);
            console.log(testService);
        }

    }

    angular
        .module('app')
        .controller('UploadImagesController', UploadImagesController);
}
