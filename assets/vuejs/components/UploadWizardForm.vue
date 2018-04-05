<template>

    <form-wizard @on-complete="onComplete" @on-loading="setLoading"
                 shape="tab" color="#9b59b6" title="" subtitle=""
                 next-button-text="Etape suivante" back-button-text="Précédent"
                 finish-button-text="Paiement">

        <tab-content title="Photos à télécharger" icon="far fa-images"
                     :before-change="hasPhotos">

            <upload-image v-bind:current-status="currentStatus"/>

        </tab-content>


        <tab-content title="Adresse" icon="far fa-address-card"
                     :before-change="isValidRegister">

            <address-form v-bind:registration="registration"/>

        </tab-content>

        <tab-content title="Commande" icon="fas fa-shopping-cart">

            Récapitulatif de commande

            <!--todo: make html table-->
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
    import UploadImage from './UploadImage'
    import AddressForm from './AddressForm'

    const STATUS_INITIAL = 0, STATUS_SAVING = 1, STATUS_SUCCESS = 2, STATUS_FAILED = 3;

    export default {
        name: "UploadWizardForm",
        components: {
            FormWizard,
            TabContent,
            ProgressBar,
            UploadImage,
            AddressForm
        },

        data: function () {
            return {
                step: 1,
                files: [],
                registration: {
                    name: 'Vincent',
                    firstname: 'Robert',
                    address1: 'rue de Paris',
                    address2: null,
                    postal: 75000,
                    city: 'Paris',
                    state: null,
                    country: 'France',
                    phone: null,
                    email: 'robert@yopmail.com'
                },
                isFormValid: false,
                uploadedFiles: [],
                uploadError: null,
                currentStatus: STATUS_INITIAL,
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

        created() {
            this.$eventBus.$on('change-files', this.changefile);
            this.$eventBus.$on('change-register-validation', this.updateIsValidForm)
        },

        beforeDestroy() {
            this.$eventBus.$off('change-files');
            this.$eventBus.$off('change-register-validation');
        },

        methods: {
            changefile(files) {
                this.files = files;
            },

            updateIsValidForm(isValid){
                this.isFormValid = isValid;
                return this.isFormValid;
            },

            isValidRegister() {
                return this.isFormValid;
            },

            hasPhotos() {
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
</style>