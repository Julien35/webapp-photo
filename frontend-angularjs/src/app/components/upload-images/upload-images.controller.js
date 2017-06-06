{
    class UploadImagesController {

        constructor(UploadImagesService) {
            this.UploadImagesService = UploadImagesService;
            // this.upLoadUrl = 'http://workspace-web.local/webapp-photo/backend-symfony/web/app_dev.php';
            this.upLoadUrl = 'http://localhost:8000';
            this.allowedTypes = ['png', 'jpg', 'jpeg', 'gif'];
            this.filesInput = document.getElementById('input-file');
            this.prev = document.getElementById('prev');

            this.filesInput.onchange = this.imagesOnChange.bind(this);
        }


        createThumbnail(file) {
            self = this;

            let reader = new FileReader();

            reader.onload = function () {

                let imgElement = document.createElement('img');
                imgElement.style.maxWidth = '150px';
                imgElement.style.maxHeight = '150px';
                imgElement.src = this.result;
                self.prev.appendChild(imgElement);

            };

            reader.readAsDataURL(file);

        }

        imagesOnChange() {
            let reader = new FileReader();

            reader.onloadend = function () {

                let files = this.filesInput.files;
                let filesLen = files.length;
                let imgType;

                for (let i = 0; i < filesLen; i++) {

                    imgType = files[i].name.split('.');
                    imgType = imgType[imgType.length - 1].toLowerCase();

                    if (this.allowedTypes.indexOf(imgType) != -1) {
                        this.createThumbnail(files[i]);
                    }

                }

            }.bind(this);

            reader.onloadend();
        }

        upLoad() {
            console.log('this dans upload(): ', this);
            let test = this.UploadImagesService.upLoad(this.filesInput.files, this.upLoadUrl);
            console.log(test);
        }

    }

    angular
        .module('app')
        .controller('UploadImagesController', UploadImagesController);
}
