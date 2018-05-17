<template>
    <section class="container">

        <article v-show="isSubmit" class="container">
            <div class="text-info">
                Le message est envoyé.
            </div>
        </article>

        <article v-show="!isSubmit">
            <h2>Formulaire de contact</h2>

            <div class="form-group">
                <label for="name">Nom : </label>
                <input type="text" class="form-control" id="name" placeholder="Nom"
                       v-model="contact.name" v-on:input="$v.contact.name.$touch"
                       v-bind:class="{error: $v.contact.name.$error,
                   valid: $v.contact.name.$dirty && !$v.contact.name.$invalid}">
            </div>

            <div class="form-group">
                <label for="email">E-mail : </label>
                <input type="email" class="form-control" id="email" placeholder="E-mail"
                       v-model="contact.email" v-on:input="$v.contact.email.$touch"
                       v-bind:class="{error: $v.contact.email.$error,
                   valid: $v.contact.email.$dirty && !$v.contact.email.$invalid}">
            </div>

            <div class="form-group">
                <label for="message">Message : </label>
                <textarea class="form-control" id="message" placeholder="Message"
                          v-model="contact.message" v-on:input="$v.contact.message.$touch"
                          v-bind:class="{error: $v.contact.message.$error,
                   valid: $v.contact.message.$dirty && !$v.contact.message.$invalid}">
            </textarea>
            </div>

            <button type="submit" class="btn btn-primary"
                    @click="submitContact" v-bind:disabled="$v.$invalid">Envoyer
            </button>
        </article>

    </section>
</template>

<script>
    import {required, minLength, email} from 'vuelidate/lib/validators';
    import {HTTP} from '../http-common';

    export default {
        name: 'Contact',

        data() {
            return {
                isSubmit: false,
                contact: {
                    name: 'Julien',
                    email: 'julien@mail.com',
                    message: 'Test'
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

        methods: {
            submitContact() {
                HTTP
                    .post('/contact',
                        this.contact
                    )
                    .then((response) => {

                        if (response) {
                            setTimeout(() => {
                                // this.isSubmit = true;
                            }, 2000);
                        } else {
                            // this.currentStatus = STATUS_FAILED;
                        }

                    })
                    .catch((response) => {
                        // this.currentStatus = STATUS_FAILED;
                        // return false;
                    });
            },
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