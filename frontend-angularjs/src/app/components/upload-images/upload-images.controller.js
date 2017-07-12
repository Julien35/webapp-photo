{
    class UploadImagesController {

        constructor(UploadImagesService) {
            this.UploadImagesService = UploadImagesService;
            this.upLoadUrl = 'http://webapp-server.local/app_dev.php/image/upload';
            this.allowedTypes = ['png', 'jpg', 'jpeg', 'gif'];
            this.filesInput = document.getElementById('input-file');
            // this.form = document.getElementById('image-form');
            this.prev = document.getElementById('prev');

            this.images;
            this.filesInput.onchange = this.imagesOnChange.bind(this);
        }


        cancel() {
            // this.$state.go('root.home');
        }

        upload() {
            if (this.myForm.$valid) {

                let length = this.images.length;
                for (let i = 0; i < length; ++i) {
                    let image = this.images[i];
                    console.log(image);

                    // Todo: gérer une liste de prommesses
                    this.UploadImagesService
                        .upLoad(image, this.upLoadUrl)
                        .then(function (data) {
                            console.log('data :', data);
                        })
                        .catch(function (data) {
                            console.log('error');
                        });
                }

            }
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

    }

    angular
        .module('app')
        .controller('UploadImagesController', UploadImagesController);
}
