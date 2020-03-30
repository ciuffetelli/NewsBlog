<template>
    <div class="custom-control custom-switch" @click="check()">
        <input type="checkbox" :name="name" v-model="value" class="custom-control-input">
        <label class="custom-control-label" for="autoSummary">is menu</label>
    </div>
</template>
<script>
export default {
    props: ['name', 'checked'],
    data(){
        return {
            value: false,
        }
    },
    methods:{
        check(){
            this.value = !this.value;
        }
    },
    mounted(){
        if(this.checked == 1) this.value = true;
    }
}
</script>