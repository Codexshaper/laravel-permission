<template>
    <div class="row">
        <div class="col-8">
            <h3>Nested draggable</h3>
            <nested-draggable :childrens="list" />
        </div>
    </div>
</template>

<script>
    import nestedDraggable from "./NestedDraggableMenu";
    export default {
        name: "nested-example",
        display: "Nested",
        order: 15,
        animation: 150,
        components: {
            nestedDraggable
        },
        props: ['menus'],
        data() {
            return {
                list: this.menus
            };
        },
        mounted() {
            console.log(this.list);
        }
    };
</script>
<style scoped></style>
