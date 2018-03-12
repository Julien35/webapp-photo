<template>
    <header>

        <section class="navbar-component">
            <nav class="container navbar navbar-expand-lg navbar-light">
                <!-- Logo -->
                <a href="#" class="brand">
                    <img src="../../assets/images/logo-ludo.jpg">
                </a>

                <!--collapse icon-->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                        aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!--items list-->
                <div class="collapse navbar-collapse" id="navigation">
                    <div class="navbar-nav">
                        <a class="item -link" href="#">Accueil <span class="sr-only">(current)</span></a>
                        <a class="item -link" href="#">Qui sommes-nous ?</a>
                        <a class="item -link" href="#">Contact</a>
                        <a class="item -link" href="#">Panier</a>
                    </div>
                </div>

            </nav>
        </section>

        <section class="container">
            <div class="jumbotron-fluid">
                <h2>{{ title }}</h2>
                <p>Plein de photos à vendre :) (Mettre un texte de présentation)</p>
            </div>
        </section>

    </header>
</template>

<script>
    export default {
        name: 'MainHeader',
        data() {
            return {
                title: 'Web App Photo',
            }
        }
    }
</script>

<style lang="scss" src="./main-header.scss" scoped></style>
