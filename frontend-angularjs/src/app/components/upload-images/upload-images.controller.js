{
    class UploadImagesController {

        constructor(UploadImagesService) {
            this.UploadImagesService = UploadImagesService;
            this.upLoadUrl = 'http://workspace-web.local/webapp-photo/backend-symfony/web/app_dev.php';
            this.allowedTypes = ['png', 'jpg', 'jpeg', 'gif'];
            this.filesInput = document.getElementById('input-file');
            this.prev = document.getElementById('prev');

            this.filesInput.addEventListener('change', this.imagesOnChange, false);
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
            console.log('imagesOnChange');
            self = this;

            let reader = new FileReader();
            reader.onloadend = function () {

                console.log(reader);

                let files = self.filesInput.files,
                    filesLen = files.length,
                    imgType;

                for (let i = 0; i < filesLen; i++) {

                    imgType = files[i].name.split('.');
                    imgType = imgType[imgType.length - 1].toLowerCase();

                    if (self.allowedTypes.indexOf(imgType) != -1) {
                        self.createThumbnail(files[i]);

                    }

                }

            };
        }

        upLoad() {
            console.log('upLoad()');
        }

    }

    angular
        .module('app')
        .controller('UploadImagesController', UploadImagesController);
}
