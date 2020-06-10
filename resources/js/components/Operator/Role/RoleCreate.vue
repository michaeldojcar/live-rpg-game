<template>
    <div class="container-fluid mt-3">
        <h4>Nová postava</h4>


        <div class="form-group">
            <label>Jméno postavy</label>
            <input type="text" class="form-control" v-model="name">
        </div>

        <div class="form-group">
        <label>Skutečné jméno</label>
        <input type="text" class="form-control" v-model="real_name">
        </div>

        <p @click="submit">Odeslat</p>
    </div>
</template>

<script>
    export default {
        name: "RoleCreate",

        data: () => {
            return {
                name: null,
                real_name: null
            }
        },

        mounted() {

        },

        methods: {
            submit() {
                console.log('Storing role.');

                axios
                    .post('/api/roles', {
                        name: this.name,
                        real_name: this.real_name
                    })
                    .then(response => {
                        console.log("Successfully created.");
                    });
            }
        }

    }
</script>

<style scoped>

</style>
