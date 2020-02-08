<template>
    <div class="quest">
        <table>
            <tr>
                <td>
                    <span></span>
                </td>
                <td>{{quest.name}}</td>
            </tr>
        </table>
    </div>
</template>

<script>
    export default {
        name: "QuestIcon",

        props: ['quest'],
    }
</script>

<style>
    .quest {
        padding: 10px 10px;
        width: 100%;

        border-radius: 4px;

        background-color: #ebeaeb;
        border: 1px solid #bdbdbd;
    }
</style>
