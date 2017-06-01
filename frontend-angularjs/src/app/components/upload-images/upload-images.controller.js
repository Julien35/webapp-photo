{
    class UploadImagesController {

        constructor(UploadImagesService) {
            this.UploadImagesService = UploadImagesService;
            this.upLoadUrl = 'http://workspace-web.local/webapp-photo/backend-symfony/web/app_dev.php';
            this.file = 'myFile';
        }

        upLoad() {
            let file = document.getElementById('input-file').files[0];
            let read = new FileReader();
            read.onloadend = function (evenement) {
                let data = evenement.target.result;
                //Traitez ici vos données binaires.
                // Vous pouvez par exemple les envoyer
                // à un autre niveau du framework
                // avec $http ou $ressource
                // let testService = this.UploadImagesService.upLoad(data, this.upLoadUrl);
            };
            read.readAsBinaryString(file);
        }

    }

    angular
        .module('app')
        .controller('UploadImagesController', UploadImagesController);
}
