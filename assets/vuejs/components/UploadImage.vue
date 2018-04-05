<template>
    <div v-if="isInitial || isSaving">

        <div class="row">
            <section class="col">
                <h2>Photos à télécharger</h2>
                <article class="dropbox">
                    <input name="photosDropZone[]" type="file" multiple :disabled="isSaving"
                           @change="filesChange($event.target.files)
                           fileCount = $event.target.files.length"
                           accept="image/*" class="input-file">

                    <p v-if="isInitial">
                        <!--Drag your photo(s) here to begin<br> or click to browse-->
                        Glisser vos photo(s) ici pour démarrer<br> ou cliquer pour naviguer
                    </p>
                    <p v-if="isSaving">
                        <!--Uploading {{ fileCount }} photo(s)...-->
                        Envoi de {{ fileCount }} photo(s)...
                    </p>
                </article>
            </section>
        </div> <!-- row 1-->

        <progress-bar v-bind:percentage="uploadPercentage" class="mt-3 mb-3"/>

        <section class="row" v-for="(file, key) in files">

            <article class="col-lg-4 col-sm-5 col-12 input-group">
                <div class="thumbnail">
                    <img src="" class="preview img-thumbnail" v-bind:ref="'preview'+parseInt( key )"/>
                    <div class="caption d-md-flex justify-content-md-between">
                        <div>
                            <label v-bind:for="file.nameText + '_' + parseInt(key)">
                                <input class="input-group-text" type="text" id="nameText"
                                       v-bind:name="file.nameText + '_' + parseInt(key)"
                                       v-model="files[key].nameText"/>
                            </label>
                        </div>
                        <div>
                            <a class="btn btn-danger" v-on:click="removeFile( key )">Supprimer</a>
                        </div>
                    </div>
                </div>
            </article>

            <article class="col-lg-8 col-sm-7 col-12">

                <div class="row">
                    <!--format field-->
                    <fieldset class="col-lg-8 col-md-8 col-sm-7 col-6">
                        <h4>Format</h4>
                        <div class="form-check">
                            <label class="form-check-label" v-bind:for="file.format + parseInt(key)">
                                <input class="form-check-input" type="radio"
                                       v-bind:name="file.format + '_' + parseInt(key)"
                                       value="format40" v-model="files[key].format" checked>
                                40 x 40 cm 15.8 x 15.8 inch
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" v-bind:for="file.format + parseInt(key)">
                                <input class="form-check-input" type="radio"
                                       v-bind:name="file.format + '_' + parseInt(key)"
                                       value="format60" v-model="files[key].format">
                                60 x 60 cm 23.8 x 23.8 inch
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" v-bind:for="file.format + parseInt(key)">
                                <input class="form-check-input" type="radio"
                                       v-bind:name="file.format + '_' + parseInt(key)"
                                       value="format100" v-model="files[key].format">
                                100 x 100 cm 39.7 x 39.7 inch
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" v-bind:for="file.format + parseInt(key)">
                                <input class="form-check-input" type="radio"
                                       v-bind:name="file.format + '_' + parseInt(key)"
                                       value="surmesure" v-model="files[key].format">
                                Sur Mesure
                            </label>
                        </div>
                    </fieldset>

                    <!--finition field-->
                    <fieldset class="col-lg-4 col-md-4 col-sm-5 col-6">
                        <h4>Finition</h4>
                        <div class="form-check">
                            <label class="form-check-label" v-bind:for="file.finition + parseInt(key)">
                                <input class="form-check-input" type="radio"
                                       v-bind:name="file.finition + '_' + parseInt(key)"
                                       value="finition1" v-model="files[key].finition" checked>
                                Finition 1
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" v-bind:for="file.finition + parseInt(key)">
                                <input class="form-check-input" type="radio"
                                       v-bind:name="file.finition + '_' + parseInt(key)"
                                       value="finition2" v-model="files[key].finition">
                                Finition 2
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" v-bind:for="file.finition + parseInt(key)">
                                <input class="form-check-input" type="radio"
                                       v-bind:name="file.finition + '_' + parseInt(key)"
                                       value="finition4" v-model="files[key].finition">
                                Finition 3
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" v-bind:for="file.finition + parseInt(key)">
                                <input class="form-check-input" type="radio"
                                       v-bind:name="file.finition + '_' + parseInt(key)"
                                       value="finition4" v-model="files[key].finition">
                                Finition 4
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" v-bind:for="file.finition + parseInt(key)">
                                <input class="form-check-input" type="radio"
                                       v-bind:name="file.finition + '_' + parseInt(key)"
                                       value="finition5" v-model="files[key].finition">
                                Finition 5
                            </label>
                        </div>
                    </fieldset>

                </div>

            </article>

        </section>

    </div>

</template>

<script>
    import ProgressBar from './progress-bar'

    const STATUS_INITIAL = 0, STATUS_SAVING = 1, STATUS_SUCCESS = 2, STATUS_FAILED = 3;

    export default {
        name: 'UploadImage',
        components: {ProgressBar},
        component: {
            ProgressBar
        },
        props: {
            currentStatus: {
                type: Number,
                required: true
            }
        },
        data() {
            return {
                step: 1,
                files: [],
                uploadedFiles: [],
                uploadError: null,
                uploadPercentage: 0,
                loadingWizard: false,
            }
        },

        created() {
            // this.$eventBus.$on('change-name', this.changeName);
            // this.$eventBus.$on('change-files', this.changefile);
        },

        beforeDestroy() {
            // this.$eventBus.$off('change-name');
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
                // this.currentStatus = STATUS_INITIAL;
                this.uploadedFiles = [];
                this.uploadError = null;
                this.files = [];
                this.images = [];
            },

            filesChange(fileList) {
                if (!fileList.length) return;

                for (let i = 0; i < fileList.length; i++) {
                    fileList[i].nameText = this.removeExtension(fileList[i].name);
                    fileList[i].format = 'format40';
                    fileList[i].finition = 'finition1';
                    this.files.push(fileList[i]);
                }

                // emit data files to EventBus
                this.$eventBus.$emit('change-files', this.files);

                // Preview
                this.getImagePreviews();
            },

            removeExtension(filenameFull) {
                return filenameFull.replace(/\.[^/.]+$/, "");
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
                this.$eventBus.$emit('change-files', this.files);
                this.getImagePreviews();
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
</style>