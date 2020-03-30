<template>
<div>
    <div v-if="getLayout == 1">
        Daniel
    </div>
    <div v-else-if="getLayout == 6">
        Barroso
    </div>
</div>
</template>
<script>
export default {
    props: {
        data: undefined,
        layout: 1,
    },
    computed:{
        getLayout(){
            let layoutDefault = [1,2,3,4,5];

            if(layoutDefault.indexOf(this.layout)) return 1;

        return this.layout;
        },
    }
}
</script>