<template>
    <select class="custom-select" :name="name">

        <option value="" selected disabled v-if="required">Select</option>

        <template v-for="option in data">
            <option :key="option.id" :value="option.value" selected v-if="checkSelected(option)">{{option.name || option.value}}</option>
            <option :key="option.id" :value="option.value" v-else>{{option.name || option.value}}</option>
        </template>
        <slot></slot>
    </select>
</template>

<script>
    export default {
        props: ['name', 'data', 'value', 'required'],
        computed:{
        },
        methods:{
            checkSelected(option){
                if(option.selected){
                    return true;
                }else if(this.value && option.value == this.value){
                    return true;
                }

                return false;
            }
        },
        mounted() {
        }
    }
</script>