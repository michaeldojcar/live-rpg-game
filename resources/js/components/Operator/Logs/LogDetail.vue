<template>
    <tbody>
        <tr>
            <td>{{log.created_at}}</td>
            <td v-if="log.action === 'player_logged'">
                hráč
                <player-link :player="log.player" />
                přihlášen u
                <role-link :role="log.role" />
            </td>
        </tr>
    </tbody>
</template>

<script>
    import PlayerLink from "../Components/PlayerLink";
    import RoleLink from "../Components/RoleLink";
    export default {
        name: "LogDetail",
        components: {RoleLink, PlayerLink},
        props: ['log']
    }
</script>

<style scoped>

</style>
