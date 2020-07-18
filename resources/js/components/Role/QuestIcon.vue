<template>
    <div class="quest">
        <table>
            <tr>
                <td>
                    <span></span>
                </td>
                <td>{{quest.name}}</td>
                <td>
                    -
                    <span v-if="quest.pivot.status === 3"
                          class="text-success font-weight-bold text-uppercase">probíhá</span>
                    <span v-if="quest.pivot.status === 2"
                          class="text-primary font-weight-bold text-uppercase">k dispozici</span>
                </td>
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
