<template>
    <section>

        <select v-model="selected">
            <option v-for="option in options" v-bind:value="option.value">
                {{ option.text }}
            </option>
        </select>
        <span>Sélectionné : {{ selected }}</span>


        <!--finition field-->
        <fieldset class="col-lg-4 col-md-4 col-sm-5 col-6">
            <h4>Finition</h4>
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio">
                    Finition 1
                </label>
            </div>
        </fieldset>

    </section>

</template>

<script>
    export default {
        name: "PrintingSupport",

        data() {
            return {
                supportChoice: '',
                finitionChoice:'',
                selected: 'A',
                options: [
                    { text: 'Un', value: 'A' },
                    { text: 'Deux', value: 'B' },
                    { text: 'Trois', value: 'C' }
                ]
            }
        },

        methods: {}
    }
</script>

<style scoped></style>
