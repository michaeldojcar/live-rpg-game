<template>
    <div class="div">
        <navbar/>

        <router-view/>
    </div>
</template>

<script>
    import Navbar from "./Navbar";
    import Map from "./RoleMap";

    export default {
        name: "OperatorLayout",
        components: {Map, Navbar}
    }
</script>

<style scoped>

</style>
