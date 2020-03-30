<template>
    <div :class="`article ${getLayout} d-flex mx-auto`">
        <article>
            <h3 class="mt-2" style="font-size: initial; cursor:pointer;" v-if="getTitle"><a @click="open(getEndPoint)">
                {{getTitle}}
            </a></h3>

            <div class="w-100 d-flex flex-wrap">
                <small v-if="getCategory" class="categoryTag" :style="getCategoryStyle" @click="open(`category/${getCategory}`)">#{{getCategory}}</small>
                <small v-if="data && data.user" class="categoryTag bg-primary" @click="open(`by_user/${data.user}`)">@{{data.user}}</small>
                <small v-if="edit" class="categoryTag bg-secondary" @click="open(`${edit}/${data.id}`)"><i class="fas fa-edit mr-1"></i>EDIT</small>
            </div>

            <div class="article-content container p-0" :style="getStyle" v-html="getContent"></div>

            <div class="article-content container p-0">
                <slot></slot>
            </div>

            <!-- <div class="m-3 bg-secondary w-50">
                {{data}}
            </div> -->

            <div style="margin-top: 80px !important;" v-if="getReadMore">
                <div class="readmore">
                    <button type="button" @click="open(getEndPoint)" class="btn btn-outline-primary d-flex mx-auto">Read more</button>                  

                    <div class="border mt-3"></div>
                </div>                
            </div>

            <div class="border mt-3" v-else></div>
        </article>    
    </div>
</template>
<script>
export default {
    props: ['data', 'title', 'color', 'category', 'content', 'readmore', 'layout' , 'edit'],
    data(){
        return {
        }
    },
    computed: {
        getTitle(){
            if(this.title){
                return this.title
            }else if(this.data && this.data.title){
                return this.data.title;
            }

            return '';
        },
        getContent(){
            const content = (this.content || this.data.content);

            return (content || '');
        },
        getEndPoint(){
            let path = '';

            if(this.data && this.data.id){
                path = this.data.id;
            }else{
                path = this.title;
            }
            
            return `article/${path}`;
        },
        getStyle(){
            // if(this.readmore){

            // let style = [
            //     // 'height: 300px',
            //     // 'overflow: hidden'
            // ];

            //     return style.join('; ');
            // }
            return undefined;
        },
        getCategory(){
            if(this.category){

                return this.category;

            }else if(this.data && this.data.category) return this.data.category;

            return undefined;
        },
        getCategoryStyle(){
            let color = '#000';

            if(this.color){
                
                color = this.color;

            }else if(this.data && this.data.color) color = this.data.color;

            let style = [
                `background: ${color}`,
                `border: 1px solid ${color}80`
            ];
            
            return style.join('; ');
        },
        getLayout(){
            let layouts = {
                    3: 'p-0 m-0 col-6',
                    4: 'p-0 m-0 col-4',
                    4: 'p-0 m-0 col-3',
            };

                //CLASS     NAME     ID      SIZE
                //cols-6    col-6    3       500     
                //col-4     col-3    4       500 
                //cols-3    col-4    5       500

        // DB::table('sis_layout')->insert(['name'    => 'cols-2']);           //3
        // DB::table('sis_layout')->insert(['name'    => 'cols-3']);           //4
        // DB::table('sis_layout')->insert(['name'    => 'cols-4']);           //5
        // DB::table('sis_layout')->insert(['name'    => 'carousel']);         //6

            let layout = '';

            if(this.layout){
                layout = this.layout;
            }else if(this.data && this.data.layout){
                layout = layouts[this.data.layout];
            }

            return layout;
        },
        getReadMore(){
            if(this.data && this.data.visibility == 3){
                
                return true;

            }else if (this.data && this.data.readmore) return true;

            return false;
        },
    },
    methods: {
        open(endPoint){   
            
            if(endPoint.indexOf(config.root) == -1){

                window.location.href = `${config.root}/${endPoint}`;

            }else{

                window.location.href = endPoint;

            }
        }
    },
    mounted(){
        // dd(this.data);
    }
}
</script>
<style>
article {
    position: relative;
}
article .categoryTag{
    color: #fff;
    padding: 5px;
    text-align: center;
    overflow: hidden;
    text-overflow: ellipsis;
    font-size: 80%;
    min-width: 50px;
    max-width: 200px;
    box-shadow: 1px 1px 3px #666;
    cursor: pointer;
}
article .categoryTag:hover{
    text-shadow: 1px 1px 1px #000;
    box-shadow: 1px 1px 2px #000;
}
.article .border{
    display: flex;
    margin: 15px auto;
    width: 50%;
    height: 1px;
    border-bottom: 1px solid #dee2e6;
}
.article-content{
    margin-top: 10px;
}
.article-content h1, 
.article-content h2, 
.article-content h3{
    text-transform: capitalize;
    font-size: initial;
    font-size: 1rem !important;
    font-weight: 550;
}
.article-content img{
    margin: 4px;
}
article a{
    color: #3490dc !important;
}
article img{
    max-width: 100%;
}
article .readmore{
    position: absolute;
    width: 100%;
    bottom: 0;
    z-index: 100;
    background: linear-gradient(180deg,hsla(0,0%,100%,0) 0,#fcfcfc 50%,#f9f9f9);
}
article .readmore button{
    margin: 90px auto 10px;
}
</style>