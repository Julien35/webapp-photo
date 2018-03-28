<template>

    <form-wizard @on-complete="onComplete"
                 shape="tab"
                 color="#9b59b6">
        <tab-content title="Photos à télécharger"
                     icon="fa fa-user-o">

        <upload-images/>

        </tab-content>
        <tab-content title="Adresse"
                     icon="fa fa-cogs">

            formulaire d'adresse

        </tab-content>
        <tab-content title="Last step"
                     icon="fa fa-check">

            formulaire de paiement

        </tab-content>
    </form-wizard>

</template>

<script>

    import {FormWizard, TabContent} from 'vue-form-wizard'
    import 'vue-form-wizard/src/assets/wizard.scss'
    import UploadImages from '../components/upload-images'

    export default {
        name: "WizardForm",
        components: {
            FormWizard,
            TabContent,
            UploadImages
        },

        data() {
            return {
                step: 1,
                registration: {
                    name: null,
                    email: null,
                    street: null,
                    city: null,
                    state: null
                }
            }
        },
        methods: {
            onComplete: function () {
                alert('Yay. Done!');
            }
        }
    }

</script>

<style scoped>

</style>