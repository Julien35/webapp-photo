<template>

    <form-wizard @on-complete="onComplete" @on-loading="setLoading"
                 shape="tab" color="#9b59b6" title="" subtitle=""
                 next-button-text="Etape suivante" back-button-text="Précédent"
                 finish-button-text="Paiement">

        <tab-content title="Photos à télécharger" icon="far fa-images" :before-change="isPhotos">

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
                                    <label for="name">
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

        </tab-content>


        <tab-content title="Adresse" icon="far fa-address-card">

            <div class="form-group row">
                <label for="name" class="col-md-4 d-sm-none d-md-block d-none col-form-label">Nom : </label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="name" placeholder="Nom"
                           v-model="registration.name">
                </div>
            </div>

            <div class="form-group row">
                <label for="firstname" class="col-md-4 d-sm-none d-md-block d-none col-form-label">Prénom : </label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="firstname" placeholder="Prénom"
                           v-model="registration.firstname">
                </div>
            </div>

            <div class="form-group row">
                <label for="address1" class="col-md-4 d-sm-none d-md-block d-none col-form-label">Adresse 1 : </label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="address1" placeholder="Adresse 1"
                           v-model="registration.address1">
                </div>
            </div>

            <div class="form-group row">
                <label for="address2" class="col-md-4 d-sm-none d-md-block d-none col-form-label">Adresse 2 : </label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="address2" placeholder="Adresse 2"
                           v-model="registration.address2">
                </div>
            </div>

            <div class="form-group row">
                <label for="postal" class="col-md-4 d-sm-none d-md-block d-none col-form-label">Code Postal : </label>
                <div class="col-md-8">
                    <input type="number" class="form-control" id="postal" placeholder="Code Postal"
                           v-model="registration.postal">
                </div>
            </div>

            <div class="form-group row">
                <label for="city" class="col-md-4 d-sm-none d-md-block d-none col-form-label">Ville : </label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="city" placeholder="Ville"
                           v-model="registration.city">
                </div>
            </div>

            <div class="form-group row">
                <label for="state" class="col-md-4 d-sm-none d-md-block d-none col-form-label">Etat / Département : </label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="state" placeholder="Etat / Département"
                           v-model="registration.state">
                </div>
            </div>

            <div class="form-group row">
                <label for="country" class="col-md-4 d-sm-none d-md-block d-none col-form-label">Pays : </label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="country" placeholder="Pays"
                           v-model="registration.country">
                </div>
            </div>

            <div class="form-group row">
                <label for="phone" class="col-md-4 d-sm-none d-md-block d-none col-form-label">Téléphone : </label>
                <div class="col-md-8">
                    <input type="tel" class="form-control" id="phone" placeholder="Téléphone : "
                           v-model="registration.phone">
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-4 d-sm-none d-md-block d-none col-form-label">E-mail : </label>
                <div class="col-md-8">
                    <input type="email" class="form-control" id="email" placeholder="E-mail"
                           v-model="registration.email">
                </div>
            </div>

        </tab-content>

        <tab-content title="Commande" icon="fas fa-shopping-cart">

            Récapitulatif de commande

            <!--todo: make table-->
            <p v-for="file in files">
                {{file.name}}</p>

            <p>{{registration}}</p>

        </tab-content>


        <tab-content title="Paiement" icon="fa fa-check">

            formulaire de paiement

        </tab-content>

    </form-wizard>

</template>

<script>

    import {FormWizard, TabContent} from 'vue-form-wizard'
    import 'vue-form-wizard/src/assets/wizard.scss'



    import {HTTP} from '../http-common';
    import ProgressBar from './progress-bar'

    const STATUS_INITIAL = 0, STATUS_SAVING = 1, STATUS_SUCCESS = 2, STATUS_FAILED = 3;

    export default {
        name: "UploadWizardForm",
        components: {
            FormWizard,
            TabContent,
            ProgressBar
        },

        data() {
            return {
                step: 1,
                files: [],
                registration: {
                    name: null,
                    firstname: null,
                    address1: null,
                    address2: null,
                    postal: null,
                    city: null,
                    state: null,
                    country: null,
                    phone: null,
                    email: null
                },
                uploadedFiles: [],
                uploadError: null,
                currentStatus: null,
                uploadPercentage: 0,
                loadingWizard: false,
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
            isPhotos: function () {
                // for test
                return true;
                return this.files.length > 0;
            },

            onComplete: function () {
                console.log('oncomplete');
                // Envoyer les photos et l'adresse dans le backend

                // Déclencher le paiement
            },
            setLoading: function (value) {
                this.loadingWizard = value
            },

            reset() {
                // reset form to initial state
                this.currentStatus = STATUS_INITIAL;
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
                this.getImagePreviews();
            },

            /**
             * Submit photos to backend
             * @returns Promise
             */
            submitFiles: function () {
                if (!(this.files.length > 0)) {
                    return false;
                }

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
                    let fileData = JSON.stringify(file);
                    formData.append('photosFiles[' + i + ']', file);
                    formData.append('photosData[' + i + ']', fileData);

                }

                return HTTP
                    .post('/image/upload',
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
                    .then((response) => {
                        console.log('SUCCESS!!', response);
                        setTimeout(() => {
                            this.currentStatus = STATUS_SUCCESS;
                        }, 2000);
                        return true;
                    })
                    .catch((response) => {
                        console.log('FAILURE!!', response);
                        this.currentStatus = STATUS_FAILED;
                        return false;
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
</style>