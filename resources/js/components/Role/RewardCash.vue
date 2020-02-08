<template>
    <p>
        <span>{{ gold }} zl 💰</span>
        <span>{{silver}} stř.</span>
    </p>
</template>

<script>
    export default {
        name: "RewardCash",

        props: ['cash'],

        computed: {
            gold: function () {
                return Math.floor(this.cash / 5);
            },

            silver: function () {
                return this.cash % 5;
            }
        }
    }
</script>

<style scoped>

</style>
