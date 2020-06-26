<template>
    <div class="container-fluid mt-3">
        <h3>Nová skupina</h3>

        <div class="row">
            <div class="col-md-8">
                <div class="alert alert-primary">Skupiny jsou celky, do kterých lze seskupit hráče.
                    Každý hráč hraje za stejnou skupinu.
                </div>

                <div class="card">
                    <div class="card-header">Informace o skupině</div>
                    <div class="card-body">
                        <label>Jméno</label>
                        <input type="text"
                               class="form-control" v-model="name">

                        <a class="btn btn-primary float-right mt-3" @click="submit">Uložit skupinu</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "RoleCreate",

        data: () => {
            return {
                name: null
            }
        },

        methods: {
            submit() {
                axios
                    .post('/api/groups', {
                        name: this.name,
                    })
                    .then(response => {
                        console.log("Successfully created.");

                        this.$router.push('/groups/' + response.data.id)
                    });
            }
        }
    }
</script>

<style scoped>

</style>
