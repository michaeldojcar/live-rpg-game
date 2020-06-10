<template>
    <tbody>
        <tr>
            <td>{{log.created_at}}</td>
            <td v-if="log.action === 'player_logged'">
                hráč
                <router-link to="">{{log.player.name}}</router-link>
                přihlášen u
                <router-link :to="'/roles/' + log.role.id + '/edit'">{{log.role.name}}</router-link>
            </td>
        </tr>
    </tbody>
</template>

<script>
    export default {
        name: "LogDetail",

        props: ['log']
    }
</script>

<style scoped>

</style>
