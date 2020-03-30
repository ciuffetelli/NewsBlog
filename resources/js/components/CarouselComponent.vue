<template>
    <div :id="getID" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div :class="`carousel-item ${checkActive(index)}`"
                 :key="index" 
                 @click="open(slide.id)"
                 v-for="(slide, index) in data">

                 <div class="carousel-title">
                    {{slide.title}} 
                 </div>

                 <div v-html="slide.content"></div>

                <!-- <div class="carousel-caption d-none d-md-block mt-auto">
                    <h5>{{slide.title}}</h5>
                    <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                </div> -->
            </div>
            <!-- <div class="carousel-item">
            <img src="https://picsum.photos/200" class="d-block w-100" alt="https://picsum.photos/200">
            <div class="carousel-caption d-none d-md-block">
                <h5>Second slide label</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
            </div>
            <div class="carousel-item">
            <img src="https://picsum.photos/200" class="d-block w-100" alt="https://picsum.photos/200">
            <div class="carousel-caption d-none d-md-block">
                <h5>Third slide label</h5>
                <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
            </div>
            </div> -->
        </div>        
        <a class="carousel-control-prev" :href="`#${getID}`" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" :href="`#${getID}`" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        <!-- <ol class="carousel-indicators">
            <li :data-target="`#${getID}`"
                :key="index"
                :data-slide-to="index" 
                :class="checkActive(index)" 
                v-for="(slide, index) in data">
            </li>
        </ol>         -->
    </div>    
</template>
<script>
export default {
    props: {
        data: {
            default: []
        }
    },
    data() {
        return {
            ID: 'carrousel',
        }
    },
    computed:{
        getID(){
            let idNumber = Math.floor((Math.random() * 1000) + 1);
            let newID = `carrousel_${idNumber}`;

            if(document.getElementById(newID)) this.getID;

            this.ID = newID;
            return newID;
        }
    },
    methods:{
        checkActive(index) {
            if(index === 0) return 'active';
            return '';
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
        open(path){   

            window.location.href = `${config.root}/article/${path}`;

        },        
    },
    mounted(){
    }
}
</script>
<style scoped>
.carousel .carousel-item{
    cursor: pointer;
}
.carousel .carousel-title{
    width: 100%;
    color: #666;
    text-align: center;
    font-size: 1.5rem;
    text-transform: capitalize;
}
</style>