<template>
    <router-link :to="'/players/'+player.id"
                 v-if="player">{{player.name}}
    </router-link>
    <span v-else><i>odstraněný hráč</i></span>
</template>

<script>
    export default {
        name: "PlayerLink",

        props: ['player']
    }
</script>

<style scoped>

</style>
