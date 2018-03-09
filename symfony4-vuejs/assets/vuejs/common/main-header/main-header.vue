<template>
    <header>
        <!-- Main component for a primary marketing message or call to action -->

        <div class="navbar-component">
            <div class="navbar area-container">
                <!-- Logo -->
                <a href="#" class="brand">
                    <img src="../../assets/images/logo-ludo.jpg">
                </a>

                <!-- List of links -->
                <nav role="navigation" id="navigation" class="list">
                    <a href="#" class="item -link">Accueil</a>
                    <a href="#" class="item -link">Qui sommes-nous ?</a>
                    <a href="#" class="item -link">Contact</a>
                    <a href="#" class="item -link">Panier</a>
                </nav>
                <!-- Button to toggle the display menu  -->
                <button data-collapse data-target="#navigation" class="toggle">
                    <!-- Hamburger icon -->
                    <span class="icon"></span>
                </button>
            </div>
        </div>

        <div class="area-container">
            <div class="">

                <div class="">
                    <h2>{{ title }}</h2>
                    <p>Plein de photos à vendre :)</p>
                </div>

            </div>
        </div>

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
