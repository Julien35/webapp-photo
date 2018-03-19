<template>
    <!--UPLOAD-->
    <!--<form enctype="multipart/form-data" novalidate v-if="isInitial || isSaving">-->
    <form enctype="multipart/form-data" novalidate>
        <h2>Images to upload</h2>

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

        <progress-bar :percentage="uploadPercentage"/>

        <div v-for="(file, key) in files" class="file-listing">
            <img class="preview" v-bind:ref="'preview'+parseInt( key )"/>
            {{ file.name }}
            <div class="remove-container">
                <a class="remove" v-on:click="removeFile( key )">Remove</a>
            </div>
        </div>

        <a class="btn btn-success btn-block" v-on:click="submitFiles()" v-show="files.length > 0">Next</a>
    </form>

</template>

<script>

    import * as axios from 'axios';
    import ProgressBar from '../progress-bar'

    const STATUS_INITIAL = 0, STATUS_SAVING = 1, STATUS_SUCCESS = 2, STATUS_FAILED = 3;

    export default {
        name: 'UploadImages',
        components: {
            ProgressBar
        },

        data() {
            return {
                files: [],
                uploadedFiles: [],
                uploadError: null,
                currentStatus: null,
                uploadFieldName: 'photos',
                uploadPercentage: 0
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
                this.files = [];
                this.images = [];
            },

            filesChange(fieldName, fileList) {
                if (!fileList.length) return;

                for (let i = 0; i < fileList.length; i++) {
                    this.files.push(fileList[i]);
                    // Preview
                    this.getImagePreviews();
                }
            },

            getImagePreviews() {
                /*
                  Iterate over all of the files and generate an image preview for each one.
                */
                for (let i = 0; i < this.files.length; i++) {
                    /*
                      Ensure the file is an image file
                    */
                    if (/\.(jpe?g|png|gif)$/i.test(this.files[i].name)) {
                        /*
                          Create a new FileReader object
                        */
                        let reader = new FileReader();

                        /*
                          Add an event listener for when the file has been loaded
                          to update the src on the file preview.
                        */
                        reader.addEventListener("load", function () {

                            this.$refs['preview' + parseInt(i)][0].src = reader.result;
                        }.bind(this), false);

                        /*
                          Read the data for the file in through the reader. When it has
                          been loaded, we listen to the event propagated and set the image
                          src to what was loaded from the reader.
                        */
                        reader.readAsDataURL(this.files[i]);
                    } else {
                        /*
                          We do the next tick so the reference is bound and we can access it.
                        */
                        this.$nextTick(function () {
                            this.$refs['preview' + parseInt(i)][0].src = '/images/file.png';
                        });
                    }
                }
            },

            removeFile(key) {
                this.files.splice(key, 1);
            },

            submitFiles() {
                const vm = this;
                this.currentStatus = STATUS_SAVING;
                /*
                  Initialize the form data
                */
                let formData = new FormData();

                /*
                  Iteate over any file sent over appending the files
                  to the form data.
                */
                for (let i = 0; i < this.files.length; i++) {
                    let file = this.files[i];

                    formData.append('files[' + i + ']', file);
                }

                axios
                    .post('http://127.0.0.1:8000/photos/upload',
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            },
                            onUploadProgress: function (progressEvent) {
                                this.uploadPercentage = parseInt(Math.round((progressEvent.loaded * 100) / progressEvent.total));
                            }.bind(this)
                        }
                    )
                    .then(function () {
                        console.log('SUCCESS!!');
                        vm.currentStatus = STATUS_SUCCESS;
                    })
                    .catch(function () {
                        console.log('FAILURE!!');
                        vm.currentStatus = STATUS_FAILED;
                    });
            },

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
        &:hover {
            background: lightblue; /* when mouse over to the drop zone, change color */
        }
        .input-file {
            opacity: 0; /* invisible but it's there! */
            width: 100%;
            height: 200px;
            position: absolute;
        }
        p {
            font-size: 1.2em;
            text-align: center;
            padding: 50px 0;
        }
    }

    .file-listing {
        width: 400px;
        margin: auto;
        padding: 10px;
        border-bottom: 1px solid #ddd;

        img {
            height: 100px;
        }

        .remove-container {
            text-align: center;
            a {
                color: red;
                cursor: pointer;
            }
        }
    }
</style>