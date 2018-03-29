<template>
    <div class="home">

        <jumbotron v-bind:jumbotron-tile="title" class="container"/>
        <upload-wizard-form class="container"/>

    </div>
</template>

<script>
    import UploadWizardForm from '../components/UploadWizardForm'
    import Jumbotron from '../components/Jumbotron'

    export default {
        name: 'home',

        data() {
            return {
                title: 'Web App Photo',
            }
        },

        components: {
            UploadWizardForm,
            Jumbotron
        }
    }
</script>
