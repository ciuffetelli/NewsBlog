<template>
    <div :class="getClass" role="alert">
        <slot>
            {{message}}
        </slot>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</template>

<script>
    export default {
        props: ['message', 'type'],
        computed:{
            getClass(){
                if(!this.type || this.type == 'error'){
                    return 'alert alert-danger alert-dismissible fade show';
                }else if(this.type == 'success'){
                    return 'alert alert-success alert-dismissible fade show';
                }else{
                    return 'alert alert-dark alert-dismissible fade show';   
                }
            },
        },
        mounted() {
        }
    }
</script>
