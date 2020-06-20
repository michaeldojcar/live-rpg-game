<template>
    <div class="container-fluid mt-3">
        <div class="card">
            <div class="card-body">
                <h4>Nový hráč</h4>

                <div class="form-group">
                    <label>Jméno</label>
                    <input type="text" class="form-control" v-model="name">
                </div>

                <div class="form-group">
                    <label>Datum narození</label>
                    <input type="date" class="form-control" v-model="birth_date">
                </div>

                <div class="text-right">
                    <p class="btn btn-primary" @click="submit">Odeslat</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PlayerCreate",

        data: () => {
            return {
                name: null,
                birth_date: null
            }
        },

        mounted() {

        },

        methods: {
            submit(){
                axios
                    .post('/api/players', {
                        name: this.name,
                        birth_date: this.birth_date,
                        last_seen: null
                    })
                    .then(response => {
                        console.log(response.data);
                    })
            }
        }
    }
</script>

<style scoped>

</style>
