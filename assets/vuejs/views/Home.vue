<template>
    <div class="home">

        <section class="container">
            <div class="jumbotron-fluid">
                <h2>{{ title }}</h2>
                <p>Plein de photos à vendre :) (Mettre un texte de présentation)</p>
            </div>
        </section>

        <wizard-form class="container"/>

    </div>
</template>

<script>
    import WizardForm from '../components/WizardForm'

    export default {
        name: 'home',

        data() {
            return {
                title: 'Web App Photo',
            }
        },

        components: {
            WizardForm
        }
    }
</script>
