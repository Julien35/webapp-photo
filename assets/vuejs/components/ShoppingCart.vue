<template>

    <section>
        <article>
            <h3>Résumée de la commande</h3>
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
                <tr v-for="(file, key) in files" @change="getImagePreviews()">
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
                            <input type="number" min="1" class="form-control text-center" v-on:click="updateCart"
                                   v-model:value="file.quantity">
                        </label>
                    </td>

                    <td class="text-center">{{ file.quantity * 1.99}}</td>

                    <td>
                        <a class="btn btn-danger" v-on:click="removeFile( key )">Supprimer</a>
                    </td>
                </tr>
                </tbody>

                <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-center"><strong>Total {{Number.parseFloat(total).toFixed(2)}}</strong></td>
                    <td></td>
                </tr>
                </tfoot>
            </table>
        </article>

        <article>
            <h3>Adresse de livraison</h3>

            <address>
                <div>{{registration.firstname}}  {{registration.name}}</div>
                <div>{{registration.address1}}</div>
                <div>{{registration.address2}}</div>
                <div>{{registration.postal}}</div>
                <div>{{registration.city}}</div>
                <div>{{registration.state}}</div>
                <div>{{registration.country}}</div>
                <div>{{registration.phone}}</div>
                <div>{{registration.email}}</div>
            </address>

        </article>

    </section>

</template>

<script>

    export default {
        name: 'ShoppingCart',

        data() {
            return {
                files: [],
                total: 0,
                price: 1.99
            }
        },

        props: {
            registration: {
                type: Object,
                required: true
            },
        },

        created() {
            this.$eventBus.$on('change-files', files => {
                this.files = files;
                this.subTotal();
                this.totalCart();
                this.$forceUpdate();
                this.getImagePreviews();
            });
        },

        beforeDestroy() {
            this.$eventBus.$off('change-files');
        },

        methods: {
            updateCart() {
                // emit to EventBus
                this.$eventBus.$emit('change-files', this.files);
            },


            subTotal(file) {
                this.files.forEach((file) => {
                    file.subtotal = (file.quantity * this.price);
                });
            },

            totalCart() {
                this.total = 0;
                this.files.forEach((file) => {
                    this.total = (this.total + file.subtotal);
                });
                this.$eventBus.$emit('change-total-cart', this.total);
            },

            getImagePreviews() {
                /*
                  Iterate over all of the files and generate an image preview for each one.
                */
                for (let i = 0; i < this.files.length; i++) {
                    /*
                      Ensure the file is an image file
                    */
                    if (/\.(jpe?g|png|gif)$/i.test(this.files[i].name)) {
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
                        reader.readAsDataURL(this.files[i]);
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
                this.getImagePreviews();
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>