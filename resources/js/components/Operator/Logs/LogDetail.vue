<template>
    <tbody>
        <tr>
            <td>{{log.created_at}}</td>
            <td v-if="log.action === 'player_logged'">
                hráč
                <player-link :player="log.player" />
                přihlášen u
                <router-link :to="'/roles/' + log.role.id">{{log.role.name}}</router-link>
            </td>
        </tr>
    </tbody>
</template>

<script>
    import PlayerLink from "../Components/PlayerLink";
    export default {
        name: "LogDetail",
        components: {PlayerLink},
        props: ['log']
    }
</script>

<style scoped>

</style>
