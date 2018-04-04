<template>
    <section>
        <div class="form-group row">
            <label for="name" class="col-md-4 d-sm-none d-md-block d-none col-form-label">Nom : </label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="name" placeholder="Nom"
                       v-model="registration.name">
            </div>
        </div>

        <div class="form-group row">
            <label for="firstname" class="col-md-4 d-sm-none d-md-block d-none col-form-label">Prénom : </label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="firstname" placeholder="Prénom"
                       v-model="registration.firstname">
            </div>
        </div>

        <div class="form-group row">
            <label for="address1" class="col-md-4 d-sm-none d-md-block d-none col-form-label">Adresse 1 : </label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="address1" placeholder="Adresse 1"
                       v-model="registration.address1">
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
                       v-model="registration.postal">
            </div>
        </div>

        <div class="form-group row">
            <label for="city" class="col-md-4 d-sm-none d-md-block d-none col-form-label">Ville : </label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="city" placeholder="Ville"
                       v-model="registration.city">
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
                       v-model="registration.country">
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
                       v-model="registration.email" required>
            </div>
        </div>
    </section>
</template>

<script>
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

    }
</script>

<style scoped>

</style>