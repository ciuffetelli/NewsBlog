<template>
    <div class="card panelCard">
        <div class="card-body" @click="open('main')">
            <h5 class="card-title">{{title}}</h5>
            <i :class="`${icon} fa-3x`"></i>
            <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
        </div>
        <ul class="list-group list-group-flush" v-if="links">
            <template v-for="(value, index) in links">
                <li :key="index" class="list-group-item" @click="open(index)" v-if="index !== 'main'">{{index}}</li>
            </template>
        </ul>
    </div>    
</template>
<script>
export default {
    props: ['title', 'icon', 'links'],
    methods: {
        open(name){
            if(this.links && this.links[name]){
                window.location.href = this.links[name];
            }
        }
    },
    
}
</script>
<style>
.panelCard:hover .list-group{
    display: inline;
}
.panelCard .card-body{
    text-align: center;
    cursor: pointer;
    transition: 1s;
}
.panelCard .card-body:hover{
    box-shadow: 3px 3px 3px #666;
}
.panelCard .list-group{
    display: none;
    border: 1px solid #00000020;
}
.panelCard .list-group-item{
    text-transform: capitalize;
    cursor: pointer;
    transition: 1s;
}
.panelCard .list-group-item:hover{
    font-weight: bold;
    box-shadow: 3px 3px 3px #666;
}
</style>