<template>
    <section :id="name" class="clearfix w-100 justify-content-center m-1">
        
        <h2 v-if="title" class="title">{{title}}</h2>

        <div class="container-fluid row section">
            
            <template v-if="data">

                <v-article
                    :key="index" v-for="(data, index) in data" 
                    :data="data"
                    :edit="edit || ''"
                >
                </v-article>

            </template>

            <slot></slot>
        </div>
        <div class="border w-100 d-flex mx-auto"></div>
    </section>
</template>
<script>
export default {
    props: {
        name: {
            default: 'section'
        },
        title: undefined,
        data: undefined,
        edit: undefined
        },
    data() {
        return {
        }
    },
    computed: {      
        getCategory(){
            if(this.data && this.data.category) return this.data.category;
            return undefined;
        },
        getColor(){
            if(this.data && this.data.color) return this.data.color;
            return undefined;
        },
        getReadMore(){
            if(this.data && this.data.readmore) return true;
            return undefined;  
        }
    },
    mounted() {
        // dd(
        //     this.data
        // )
    }
}
</script>
<style>
    section .title{
        font-size: 1.2rem;
    }
    section .border{
        /* padding: 1px 0px 5px 0px; */
        border-bottom: 1px solid #dee2e6;
        /* margin-bottom: 5px; */
    }
</style>