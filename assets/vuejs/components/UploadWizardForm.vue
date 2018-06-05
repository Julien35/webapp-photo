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

        <tab-content title="Commande" icon="fas fa-shopping-cart"
                     :before-change="submitFiles">
            <shopping-cart v-bind:registration="registration"/>
        </tab-content>


        <tab-content title="Paiement" icon="fa fa-check">
            <checkout/>
        </tab-content>

        <template slot="footer" slot-scope="props">
            <div class="wizard-footer-left">
                <wizard-button v-if="props.activeTabIndex > 0 && !props.isLastStep" @click.native="props.prevTab()"
                               :style="props.fillButtonStyle">Précédent
                </wizard-button>
            </div>
            <div class="wizard-footer-right">
                <wizard-button v-if="!props.isLastStep" @click.native="props.nextTab()" class="wizard-footer-right"
                               :style="props.fillButtonStyle">Etape suivante
                </wizard-button>

                <wizard-button v-else @click.native="onComplete" class="wizard-footer-right finish-button"
                               :style="props.fillButtonStyle"> {{props.isLastStep ? 'Paiement' : 'Etape suivante'}}
                </wizard-button>
            </div>
        </template>

    </form-wizard>

</template>

<script>
    import {FormWizard, TabContent, WizardButton} from 'vue-form-wizard/src/index'
    import 'vue-form-wizard/src/assets/wizard.scss'


    import {HTTP} from '../http-common';
    import ProgressBar from './progress-bar'
    import UploadImage from './UploadImage'
    import AddressForm from './AddressForm'
    import ShoppingCart from './ShoppingCart'
    import Checkout from './Checkout'

    const STATUS_INITIAL = 0, STATUS_SAVING = 1, STATUS_SUCCESS = 2, STATUS_FAILED = 3;

    export default {
        name: "UploadWizardForm",
        components: {
            FormWizard,
            TabContent,
            WizardButton,
            ProgressBar,
            UploadImage,
            AddressForm,
            ShoppingCart,
            Checkout

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
            this.$eventBus.$on('change-register-validation', this.updateIsValidForm);
            this.$eventBus.$on('change-register', function (registration) {
                this.registration = registration;
            });
        },

        beforeDestroy() {
            this.$eventBus.$off('change-files');
            this.$eventBus.$off('change-register-validation');
            this.$eventBus.$off('change-register');
        },

        methods: {
            changefile(files) {
                this.files = files;
                if (this.currentStatus === STATUS_SUCCESS) {
                    this.currentStatus = STATUS_SAVING;
                }
            },

            updateIsValidForm(isValid) {
                this.isFormValid = isValid;
            },

            isValidRegister() {
                return this.isFormValid;
            },

            hasPhotos() {
                return this.files.length > 0;
            },

            onComplete: function () {
                // Déclencher le paiement
                this.$eventBus.$emit('tokenize');
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

                this.$eventBus.$emit('loading', {
                    state: true,
                    message: 'Transfert de vos images'
                });

                if (this.currentStatus === STATUS_SUCCESS) {
                    return true;
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
                    formData.append('registration[' + i + ']', JSON.stringify(this.registration));
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
                        if (response.data.fileUploaded) {

                            this.$eventBus.$emit('client-cart', response.data.clientCart);

                            setTimeout(() => {
                                this.currentStatus = STATUS_SUCCESS;
                            }, 2000);

                            return true;
                        } else {
                            this.currentStatus = STATUS_FAILED;
                            return false;
                        }

                    })
                    .catch((response) => {
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