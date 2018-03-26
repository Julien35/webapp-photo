<template>
    <header>
        <section class="navbar-component">
            <nav class="container navbar navbar-expand-lg navbar-light">
                <!-- Logo -->
                <router-link :to="{name: 'home'}" class="brand">
                    <img src="../../assets/images/logo-ludo.jpg">
                </router-link>

                <!--collapse icon-->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                        aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!--items list-->
                <div class="collapse navbar-collapse" id="navigation">
                    <div class="navbar-nav">
                        <router-link :to="{name: 'home'}" class="item -link">Accueil <span
                                class="sr-only">(current)</span></router-link>
                        <router-link :to="{name: 'about'}" class="item -link" href="#">Qui sommes-nous ?</router-link>
                        <router-link :to="{name: 'contact'}" class="item -link" href="#">Contact</router-link>
                        <router-link :to="{name: 'cart'}" class="item -link" href="#">Panier</router-link>
                    </div>
                </div>

            </nav>
        </section>

    </header>
</template>

<script>
    export default {
        name: 'MainHeader',
        data() {
            return {
                title: 'Home Page',
            }
        }
    }
</script>

<style lang="scss" src="./main-header.scss" scoped></style>
