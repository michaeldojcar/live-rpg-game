<template>
    <div class="container-fluid mt-3">
        <h4>Nový hráč</h4>

        <div class="form-group">
            <label>Jméno</label>
            <input type="text" class="form-control" v-model="name">
        </div>

        <div class="form-group">
            <label>Věk</label>
            <input type="date" class="form-control" v-model="birth_date">
        </div>

        <div class="form-group">
            <label>Barva 1</label>
            <input class="form-control" v-model="color_1">
        </div>

        <div class="form-group">
            <label>Barva 2</label>
            <input class="form-control" v-model="color_2">
        </div>

        <div class="form-group">
            <label>Barva 3</label>
            <input class="form-control" v-model="color_3">
        </div>

        <p @click="submit">Odeslat</p>
        <table class="w-50 table table-bordered">
            <tr>
                <th>Jméno</th>
                <th>Reálné jméno</th>
            </tr>
            <tr v-for="role in roles" :key="role.id">
                <td>
                    <router-link to="#">{{role.name}}</router-link>
                </td>
                <td>{{role.real_name}}</td>
            </tr>
        </table>
    </div>
</template>

<script>
    export default {
        name: "RoleCreate",

        data: () => {
            return {
                roles: [],
            }
        },

        mounted() {
            this.refresh();
        },

        methods: {
            refresh() {
                axios
                    .get('/api/roles')
                    .then(response => {
                        console.log(response.data);

                        this.roles = response.data;
                    });
            }
        }
    }
</script>

<style scoped>

</style>
