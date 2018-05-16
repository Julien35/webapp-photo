<template>
    <section class="container">

        <h2>Formulaire de contact</h2>

        <div class="form-group row">
            <label for="name" class="col-md-4 d-sm-none d-md-block d-none col-form-label">Nom : </label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="name" placeholder="Nom"
                       v-model="contact.name" v-on:input="$v.contact.name.$touch"
                       v-bind:class="{error: $v.contact.name.$error,
                   valid: $v.contact.name.$dirty && !$v.contact.name.$invalid}">
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-md-4 d-sm-none d-md-block d-none col-form-label">E-mail : </label>
            <div class="col-md-8">
                <input type="email" class="form-control" id="email" placeholder="E-mail"
                       v-model="contact.email" v-on:input="$v.contact.email.$touch"
                       v-bind:class="{error: $v.contact.email.$error,
                   valid: $v.contact.email.$dirty && !$v.contact.email.$invalid}">
            </div>
        </div>

        <div class="form-group row">
            <label for="message" class="col-md-4 d-sm-none d-md-block d-none col-form-label">Message : </label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="message" placeholder="Message"
                       v-model="contact.message" v-on:input="$v.contact.message.$touch"
                       v-bind:class="{error: $v.contact.message.$error,
                   valid: $v.contact.message.$dirty && !$v.contact.message.$invalid}">
            </div>
        </div>

    </section>
</template>

<script>
    import {required, minLength, email} from 'vuelidate/lib/validators';

    export default {
        name: 'Contact',

        data() {
            return {
                contact: {
                    type: Object,
                    required: true,
                    default: {
                        name: null,
                        email: null,
                        message: null
                    }
                }
            }
        },

        validations: {
            contact: {
                message: {
                    required,
                    minLength:
                        minLength(1)
                },
                email: {
                    required,
                    email
                },
                name: {
                    required,
                    minLength:
                        minLength(1)
                }


            }
        },

        mounted() {
            if (!this.$v.$invalid) {
                this.updateIsFormValid();
            }
        },

        methods: {
            updateIsFormValid() {
                // emit to EventBus
                // this.$eventBus.$emit('change-register-validation', !this.$v.$invalid);
                // this.$eventBus.$emit('change-register', this.registration);
            }
        }

    }
</script>

<style scoped>
    .error {
        border-color: red;
        background: #FDD;
    }

    .error:focus {
        outline-color: #F99;
    }

    .valid {
        border-color: #5A5;
        background: #EFE;
    }

    .valid:focus {
        outline-color: #8E8;
    }
</style>