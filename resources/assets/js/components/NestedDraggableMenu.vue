<template>
    <draggable class="menus" tag="ul" :list="childrens" :group="{ name: 'g1' }" @start="drag=true" @end="drag=false">
        <transition-group type="transition" name="flip-list">
        <li class="menuList" v-for="el in childrens" :key="el.id">
            <div class="menuItem">{{ el.title }}</div>
            <nested-draggable :childrens="el.childrens" class="sub-menu" />
        </li>
        </transition-group>
    </draggable>
</template>
<script>
    import draggable from "vuedraggable";
    export default {
        animation: 500,
        delay: 200,
        props: {
            childrens: {
                required: true,
                type: Array
            }
        },
        components: {
            draggable
        },
        name: "nested-draggable"
    };
</script>
<style scoped>
    .dragArea {
    }
    ul {
        list-style-type: none;
        display: block;
        position: relative;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    ul ul {
        padding-left: 15px;
    }
     li {
        display: block;
        position: relative;
        overflow: hidden;
        margin: 5px 0px;
        padding: 0;
        min-height: 30px;
        font-size: 13px;
        line-height: 30px;
    }
    .menuItem {
        display: block;
        height: 30px;
        margin: 0;
        padding: 5px 10px;
        color: #333;
        text-decoration: none;
        font-weight: bold;
        border: 1px solid #ccc;
        background: #fafafa;
        -webkit-border-radius: 3px;
        border-radius: 3px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        font-size: 13px;
        line-height: 20px;
        overflow: hidden;
        -webkit-transition: all 0.3s ease;
        transition: all 0.3s ease;
    }
    .menuList.sortable-chosen .menuItem {
        border: 1px dotted blue;
        background-color: #ddd;
    }
</style>
