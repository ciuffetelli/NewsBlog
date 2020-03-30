<template>
    <div class="menu" id="menu">
        <nav class="navbar p-0 mx-auto">
            <ul class="nav nav-tabs align-middle">
                <!-- <li class="nav-item menuBurger">
                    <a class="nav-link">
                        <i class="fas fa-bars"></i>
                    </a>
                </li> -->
                <!-- <li class="nav-item">
                    <a :class="activeClass('home')" :href="getHome" title="home" id="menu_home">
                        <i class="fas fa-home"></i>
                        <span>home</span>
                    </a>
                </li> -->
                <li class="nav-item" :key="key" v-for="(item, key) in dataIn">
                    <a :class="activeClass(item.name)" @click="open(item.url)" :title="item.name" :id="`menu_${item.name}`">
                        <i :class="item.icon" v-if="item.icon"></i>
                        <span>{{item.name}}</span>
                    </a>
                </li>                          
                <!-- <li class="nav-item">
                    <a class="nav-link border-bottom-0" @click="scrollAnchor('#search')" title="search" id="menuSearch">
                        <i class="fas fa-search"></i>
                        <span>search</span>
                    </a>
                </li>    -->
                <template v-if="auth">        
                    <li class="nav-item">
                        <a class="nav-link border-bottom-0" style="background-color: #e0e0e0; color:#666" :href="auth" title="Panel">
                            <i class="fas fa-users-cog"></i>
                            <span>panel</span>
                        </a>
                    </li>                        
                    <!-- <li class="nav-item text-center" id="access">
                        <a class="nav-link" href="#" aria-label="log out" type="button" title="log out">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>log out</span>
                        </a>
                    </li>    -->
                </template> 
                <template v-else>   
                    <li class="nav-item text-center align-middle" id="access">
                        <a class="nav-link" href="#" aria-label="log in" type="button" data-toggle="modal" data-target="#modalLogin" title="log in">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>log in</span>
                        </a>
                    </li>                
                </template>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default {
        props: ['data', 'auth', 'active', 'home'],
        data: () => ({
            dataIn: undefined,
            positions: [],
            topPosition: 0,
        }),
        computed: {
            getHome(){
                if(this.home){
                    return this.home;
                }else if(config.root){
                    return config.root;
                }else return '#';
            }
        },
        methods: {
            setData(){
                let data = (this.data || []);

                //home
                data.unshift({
                    'name': 'home',
                    'url': this.getHome,
                    'icon': 'fas fa-home',
                    'color': 'rgb(51, 51, 51)'
                });

                //Default Icon
                data.push({
                    'name': 'search',
                    'url': '#search',
                    'icon': 'fas fa-search',
                });

                this.dataIn = data;
            },
            activeClass(name) {
                let active = (this.active || 'home');

                if (name == active) return 'nav-link active';
                return 'nav-link';
            },
            clearActive(){
                let element = menu.getElementsByClassName('nav-link active')[0];
                
                if(element) element.classList.remove('active');
            },
            // setActive(index, id = null){
            setActive(index){

                let item = this.dataIn[index];

                let menuItem = document.getElementById(`menu_${item.name}`);

                this.setColor(index);
                this.clearActive();
                menuItem.classList.add('active');
            },
            setColor(index){
                if(this.dataIn[index].color){
                    menu.style.background = this.dataIn[index].color;
                }else{
                    menu.style.background = '#000';
                }
            },
            setPositions() {

                const main = document.getElementsByTagName('main')[0];
                this.positions = [];
                this.topPosition = main.offsetTop;

                this.dataIn.map( (item) => {

                    let section = document.getElementById(item.name);

                    if(section){

                        this.positions.push(
                            section.offsetTop
                        );
                    }else{
                        this.positions.push(0);
                    }
                });
            },
            autoActive(position) {              

                let active = (this.active || 'home');
                let homeSection = undefined;

                //menu default
                if(position <= this.topPosition){

                     menu.classList.remove("fixed");

                     menu.style.background = '#F5EFEB';
                     this.clearActive();

                     if(document.getElementById(`menu_${active}`))
                        document.getElementById(`menu_${active}`).classList.add('active');
                    
                //menu fixed
                }else if(position > this.topPosition){

                    menu.classList.add("fixed");

                    let index = 0;  let i = 0;
                    this.positions.map( sectionPosition => {
                        
                        if(sectionPosition != 0 && position + this.topPosition >= sectionPosition) index = i;
                        i++
                    });

                    this.setActive(index);                

                }
            },
            open(url){
                
                if(url.indexOf('#') == -1){
                    window.location.href = url;
                    return undefined;
                } 

                const targetID = url.replace('#', '');
                const targetTop = document.getElementById(targetID).offsetTop;
                const main = document.getElementsByTagName('main')[0];

                window.scroll({
                    'top': targetTop - (main.offsetTop),
                    'behavior': 'smooth'
                });
            }
        },
        mounted() {

            this.setData();
            this.setPositions();

            window.addEventListener('scroll', (e) => {
                this.autoActive(Math.round($(document).scrollTop()));
            });
        }
    }
</script>
<style scoped>
    header .menu{
        display: flex;   
        width: 100vw;
        /* margin-left: auto; */
        /* border-bottom: solid 1px #dee2e6; */
        border-bottom: 1px solid #dee2e6;
        padding-top: 5px;
        padding: 3px 0 -5px 0px;
    }
    header .nav-tabs{
        overflow: hidden;
        border-bottom: none !important;
        /* margin-bottom: -10px !important; */
        height: 40px;
        text-transform: capitalize;
        text-align: center;
    }
    header .nav-item a{
        color: #444444;
    }
    .menu .active{
        color: #666;
    }
    .fixed{
        position: fixed;
        top: 0;
        z-index: 9999;
        background-color: #F5EFEB;
        box-shadow: 2px 2px 10px #666;
        transition: 1s;
    }
    .fixed .nav-item a:not(.active){
        color: #F5EFEB;
    }
    .nav-link {
        transition: 1s;
        text-align: center;
        cursor: pointer;
    }
    .menuBurger{
        display: none;
    }

    @media only screen and (max-width: 600px) {
        header .nav-tabs{        
            height: 55px;
        }
        header .nav-item span{
            display: block;
        }
    }       
</style>