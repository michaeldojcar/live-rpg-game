<template>
    <router-link :to="'/roles/'+role.id"
                 v-if="role">{{role.name}}
    </router-link>
    <span v-else><i>odstraněná postava</i></span>
</template>

<script>
    export default {
        name: "RoleLink",

        props: ['role']
    }
</script>

<style scoped>

</style>
