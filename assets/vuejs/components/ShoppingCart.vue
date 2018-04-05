<template>

    <section class="row">
        <h2>Récapitulatif de commande</h2>

        <article class="col">

            <!--todo: make html table-->
            <!--<p v-for="file in files">-->
            <!--{{file.name}}</p>-->

        </article>

        <article class="col">

            <!--<p>{{registration}}</p>-->

        </article>

    </section>

</template>

<script>
    export default {
        name: 'ShoppingCart',

        data() {
            return {}
        },

        props: {
            files: {
                type: Array,
                required: true
            },
            registration: {
                type: Object,
                required: true
            },
        },

        created() {
            // this.$eventBus.$on('change-files', this.changefile);
            // this.$eventBus.$on('change-register-validation', this.updateIsValidForm)
        },

        beforeDestroy() {
            // this.$eventBus.$off('change-files');
            // this.$eventBus.$off('change-register-validation');
        },

        methods: {
            updateCart() {

                // emit to EventBus
                this.$eventBus.$emit('change-files', this.files);
                this.$eventBus.$emit('change-register', this.registration);
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>