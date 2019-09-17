<template>
    <section>

        <select v-model="selected" @change="updateChange">
            <option v-for="option in options" v-bind:value="option.value">
                {{ option.text }}
            </option>
        </select>
        <span>Sélectionné : {{ selected }}  €</span>


        <!--finition field-->
        <!--        <fieldset class="col-lg-4 col-md-4 col-sm-5 col-6">-->
        <!--            <h4>Finition</h4>-->
        <!--            <div class="form-check">-->
        <!--                <label class="form-check-label">-->
        <!--                    <input class="form-check-input" type="radio">-->
        <!--                    Finition 1-->
        <!--                </label>-->
        <!--            </div>-->
        <!--        </fieldset>-->

    </section>

</template>

<script>
    export default {
        name: "PrintingSupport",

        data() {
            return {
                supportChoice: '',
                finitionChoice: '',
                selected: '0',
                options: [
                    {text: 'default', value: '0'}
                ]
            }
        },

        methods: {

            updateChange(e) {
                if (e.target.options.selectedIndex > -1) {
                    this.$store.commit('imageModule/updateFilesSupport',
                        e.target.options[e.target.options.selectedIndex]);
                }
            },

            loadSupportData() {
                // init image limit
                this.$store.dispatch('imageModule/fetchInitParams').then(() => {
                    let supportData = this.$store.getters["imageModule/getSupport"];

                    // clear default value & add new support data
                    this.options = [];
                    for (let i = 0; i < supportData.length; i++) {
                        this.options.push(
                            {text: supportData[i].type, value: supportData[i].price}
                        );
                    }
                    this.selected = this.options[0].value;

                });
            }
        },
        mounted() {
            setTimeout(()=> {
                this.loadSupportData();
            }, 3000);
        }
    }
</script>

<style scoped></style>
