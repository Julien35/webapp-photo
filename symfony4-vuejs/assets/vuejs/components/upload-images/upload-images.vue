<template>
    <section class="container">
        <div class="">
            <!--UPLOAD-->
            <form enctype="multipart/form-data" novalidate v-if="isInitial || isSaving">
                <h2>Images to download</h2>

                <div class="dropbox">
                    <input type="file" multiple :name="uploadFieldName" :disabled="isSaving"
                           @change="filesChange($event.target.name, $event.target.files);
                           fileCount = $event.target.files.length"
                           accept="image/*" class="input-file">

                    <p v-if="isInitial">
                        Drag your file(s) here to begin<br> or click to browse
                    </p>
                    <p v-if="isSaving">
                        Uploading {{ fileCount }} files...
                    </p>
                </div>

                <div id="preview">
                    <h2>Preview photo</h2>
                </div>
                <!--<button class="btn btn-success btn-block" @click="save($event.target.files)">Upload</button>-->
            </form>

        </div>

    </section>

</template>

<script>

    // swap as you need
    import {upload} from './file-upload.fake.service'; // fake service
    // import { upload } from './file-upload.service';   // real service

    const STATUS_INITIAL = 0, STATUS_SAVING = 1, STATUS_SUCCESS = 2, STATUS_FAILED = 3;

    export default {
        name: 'UploadImages',
        data() {
            return {
                images: [],
                uploadedFiles: [],
                uploadError: null,
                currentStatus: null,
                uploadFieldName: 'photos'
            }
        },
        computed: {
            isInitial() {
                return this.currentStatus === STATUS_INITIAL;
            },
            isSaving() {
                return this.currentStatus === STATUS_SAVING;
            },
            isSuccess() {
                return this.currentStatus === STATUS_SUCCESS;
            },
            isFailed() {
                return this.currentStatus === STATUS_FAILED;
            }
        },
        methods: {
            reset() {
                // reset form to initial state
                this.currentStatus = STATUS_INITIAL;
                this.uploadedFiles = [];
                this.uploadError = null;
            },
            save(fileList) {

                // handle file changes
                const formData = new FormData();

                // append the files to FormData
                Array
                    .from(Array(fileList.length).keys())
                    .map(x => {
                        formData.append(fieldName, fileList[x], fileList[x].name);
                    });

                // upload data to the server
                this.currentStatus = STATUS_SAVING;

                upload(formData)
                    .then(x => {
                        console.log(x);
                        this.uploadedFiles = [].concat(x);
                        this.currentStatus = STATUS_SUCCESS;
                    })
                    .catch(err => {
                        console.log(err);
                        this.uploadError = err.response;
                        this.currentStatus = STATUS_FAILED;
                    });
            },
            filesChange(fieldName, fileList) {
                if (!fileList.length) return;

                // Preview
                this.createImages(fileList);
            },


            /**
             *
             * @param fileList
             */
            createImages(fileList) {
                if (fileList) {
                    [].forEach.call(fileList, this.readAndPreview);
                }
            },

            readAndPreview(file) {
                let preview = document.querySelector('#preview');

                // Veillez à ce que `file.name` corresponde à nos critères d’extension
                if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
                    let reader = new FileReader();

                    reader.addEventListener("load", function () {
                        let image = new Image();
                        image.height = 100;
                        image.title = file.name;
                        image.src = this.result;
                        preview.appendChild(image);
                    }, false);

                    reader.readAsDataURL(file);
                }

            }

        },
        mounted() {
            this.reset();
        },
    }
</script>

<style lang="scss" scoped>
    .dropbox {
        outline-offset: -10px;
        background: #ffffff;
        color: dimgray;
        padding: 10px 10px;
        min-height: 200px; /* minimum height */
        position: relative;
    }

    .input-file {
        opacity: 0; /* invisible but it's there! */
        width: 100%;
        height: 200px;
        position: absolute;
    }

    .dropbox:hover {
        background: lightblue; /* when mouse over to the drop zone, change color */
    }

    .dropbox p {
        font-size: 1.2em;
        text-align: center;
        padding: 50px 0;
    }
</style>