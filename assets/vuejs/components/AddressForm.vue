<template>
    <section @change="updateIsFormValid">
        <div class="form-group row">
            <label for="name" class="col-md-4 d-sm-none d-md-block d-none col-form-label">Nom : </label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="name" placeholder="Nom"
                       v-model="registration.name" v-on:input="$v.registration.name.$touch"
                       v-bind:class="{error: $v.registration.name.$error,
                   valid: $v.registration.name.$dirty && !$v.registration.name.$invalid}">
            </div>
        </div>

        <div class="form-group row">
            <label for="firstname" class="col-md-4 d-sm-none d-md-block d-none col-form-label">Prénom : </label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="firstname" placeholder="Prénom"
                       v-model="registration.firstname" v-on:input="$v.registration.firstname.$touch"
                       v-bind:class="{error: $v.registration.firstname.$error,
                   valid: $v.registration.firstname.$dirty && !$v.registration.firstname.$invalid}">
            </div>
        </div>

        <div class="form-group row">
            <label for="address1" class="col-md-4 d-sm-none d-md-block d-none col-form-label">Adresse 1 : </label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="address1" placeholder="Adresse 1"
                       v-model="registration.address1" v-on:input="$v.registration.address1.$touch"
                       v-bind:class="{error: $v.registration.address1.$error,
                   valid: $v.registration.address1.$dirty && !$v.registration.address1.$invalid}">
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
                       v-model="registration.postal" v-on:input="$v.registration.postal.$touch"
                       v-bind:class="{error: $v.registration.postal.$error,
                   valid: $v.registration.postal.$dirty && !$v.registration.postal.$invalid}">
            </div>
        </div>

        <div class="form-group row">
            <label for="city" class="col-md-4 d-sm-none d-md-block d-none col-form-label">Ville : </label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="city" placeholder="Ville"
                       v-model="registration.city" v-on:input="$v.registration.city.$touch"
                       v-bind:class="{error: $v.registration.city.$error,
                   valid: $v.registration.city.$dirty && !$v.registration.city.$invalid}">
            </div>
        </div>

        <div class="form-group row">
            <label for="state" class="col-md-4 d-sm-none d-md-block d-none col-form-label">Etat / Département
                : </label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="state" placeholder="Etat / Département"
                       v-model="registration.state">
            </div>
        </div>

        <div class="form-group row">
            <label for="country" class="col-md-4 d-sm-none d-md-block d-none col-form-label">Pays : </label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="country" placeholder="Pays"
                       v-model="registration.country" v-on:input="$v.registration.country.$touch"
                       v-bind:class="{error: $v.registration.country.$error,
                   valid: $v.registration.country.$dirty && !$v.registration.country.$invalid}">
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
                       v-model="registration.email" v-on:input="$v.registration.email.$touch"
                       v-bind:class="{error: $v.registration.email.$error,
                   valid: $v.registration.email.$dirty && !$v.registration.email.$invalid}">
            </div>
        </div>

    </section>
</template>

<script>

    import {required, minLength, email, numeric} from 'vuelidate/lib/validators';

    export default {
        name: 'AddressForm',
        data() {
            return {}
        },
        props: {
            registration: {
                type: Object,
                required: true,
                default: {
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
                }
            }
        },

        validations: {
            registration: {
                name: {
                    required,
                    minLength:
                        minLength(1)
                }
                ,
                firstname: {
                    required,
                    minLength:
                        minLength(1)
                }
                ,
                address1: {
                    required,
                    minLength:
                        minLength(1)
                }
                ,
                address2: {}
                ,
                postal: {
                    required,
                    numeric
                }
                ,
                city: {
                    required
                }
                ,
                state: {}
                ,
                country: {
                    required
                }
                ,
                phone: {}
                ,
                email: {
                    required,
                    email
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
                this.$eventBus.$emit('change-register-validation', !this.$v.$invalid);
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