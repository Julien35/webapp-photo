<template>
    <div class="home">

        <jumbotron v-bind:jumbotron-tile="title" class="container"/>
<!--        <upload-wizard-form v-show="!status.done" class="container"/>-->
        <UploadImage/>

        <article v-show="status.done" class="container">
            <div v-if="!status.error" class="text-info">
                La transaction est terminée, paiement Ok.
            </div>
            <div v-if="status.error" class="text-danger">
                La transaction a échoué, veuillez recommencer.
            </div>
        </article>

    </div>
</template>

<script>
    import UploadWizardForm from '../components/UploadWizardForm'
    import Jumbotron from '../components/Jumbotron'
    import UploadImage from "../components/UploadImage";

    export default {
        name: 'home',

        data() {
            return {
                title: 'Web App Photo',
                status: {
                    done: false,
                    error: false
                }
            }
        },

        components: {
            UploadImage,
            UploadWizardForm,
            Jumbotron
        },

        created() {
            this.$eventBus.$on('transaction-status', (status) => {
                this.status = status;
                setTimeout(() => {
                    this.$router.go();
                }, 5000);

            });
        },
    }
</script>
