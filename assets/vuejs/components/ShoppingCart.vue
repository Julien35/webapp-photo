<template>

    <section class="">
        <table id="cart" class="table table-hover table-condensed">

            <thead>
            <tr>
                <th>Produits</th>
                <th>Prix</th>
                <th>Quantités</th>
                <th class="text-center">SousTotal</th>
                <th></th>
            </tr>
            </thead>

            <tbody v-if="files.length > 0">
            <tr v-for="(file, key) in files" @change="getImagePreviews(files)">
                <td>
                    <div class="row">
                        <div class="col-4 thumbnail">
                            <img src="" class="preview img-thumbnail" v-bind:ref="'preview'+parseInt( key )"/>
                        </div>
                        <div class="col-8">
                            <div>{{file.nameText}}</div>
                            <div>{{file.format}}</div>
                            <div>{{file.finition}}</div>
                        </div>
                    </div>
                </td>

                <td>1.99€</td>

                <td>
                    <label>
                        <input type="number" class="form-control text-center" value="1">
                    </label>
                </td>

                <td class="text-center">1.99</td>

                <td>
                    <a class="btn btn-danger" v-on:click="removeFile( key )">Supprimer</a>
                </td>
            </tr>
            </tbody>

            <tfoot>
            <tr class="">
                <td></td>
                <td></td>
                <td></td>
                <td class="text-center"><strong>Total 1.99</strong></td>
                <td></td>
            </tr>
            </tfoot>
        </table>
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
            // this.getImagePreviews();
            this.$eventBus.$on('change-files', this.getImagePreviews);
            // this.$eventBus.$on('change-register-validation', this.updateIsValidForm)
        },

        beforeDestroy() {
            this.$eventBus.$off('change-files');
            // this.$eventBus.$off('change-register-validation');
        },

        methods: {
            updateCart() {

                // emit to EventBus
                this.$eventBus.$emit('change-files', this.files);
                this.$eventBus.$emit('change-register', this.registration);
            },

            getImagePreviews(files) {
                /*
                  Iterate over all of the files and generate an image preview for each one.
                */
                for (let i = 0; i < files.length; i++) {
                    /*
                      Ensure the file is an image file
                    */
                    if (/\.(jpe?g|png|gif)$/i.test(files[i].name)) {
                        /*
                          Create a new FileReader object
                        */
                        let reader = new FileReader();

                        /*
                          Add an event listener for when the file has been loaded
                          to update the src on the file preview.
                        */
                        reader.addEventListener("load", function () {

                            this.$refs['preview' + parseInt(i)][0].src = reader.result;
                        }.bind(this), false);

                        /*
                          Read the data for the file in through the reader. When it has
                          been loaded, we listen to the event propagated and set the image
                          src to what was loaded from the reader.
                        */
                        reader.readAsDataURL(files[i]);
                    } else {
                        /*
                          We do the next tick so the reference is bound and we can access it.
                        */
                        this.$nextTick(function () {
                            this.$refs['preview' + parseInt(i)][0].src = '/images/file.png';
                        });
                    }
                }
            },

            removeFile(key) {
                this.files.splice(key, 1);
                this.$eventBus.$emit('change-files', this.files);
                this.getImagePreviews(this.files);
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>