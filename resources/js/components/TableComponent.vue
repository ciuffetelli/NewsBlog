<template>
    <div class="v-table">
        <input class="form-control ml-auto mb-2 v-table-search" v-model="search" placeholder="search" />
        <table class="table table-striped">
            <thead>
                <th scope="col"># <i id="vTableTitleIco" class="fas fa-sort-numeric-down"></i></th>
                <th scope="col" class="v-table-title"
                    v-for="(key, keyIndex) in getKey" :key="key.id" :id="`vTableTitle${keyIndex}`" @click="setOrder(keyIndex)">

                        {{key}}

                </th>
            </thead>
            <tbody>
                <template v-for="(item, index) in dataInternal">
                    <tr :key="index">
                        <th>{{index}}</th>
                        <template v-for="(itemValue, itemIndex) in item">

                            <td :key="itemIndex" v-if="itemIndex != 'id'" v-html="proccessConvert(itemValue, itemIndex)"></td>

                        </template>
                        <div class="v-table-actions" v-if="checkAction">
                            <a :href="`${route.view}/${getIdValue(item)}`" target="_new" v-if="route.view"><i class="fas fa-eye text-primary" title="view"></i></a>
                            <a :href="`${route.edit}/${getIdValue(item)}`" v-if="route.edit"><i class="fas fa-edit text-success" title="edit"></i></a>
                            <a :href="`${route.delete}/${getIdValue(item)}`" v-if="route.delete"><i class="fas fa-trash-alt text-danger" title="delete"></i></a>
                        </div>                            
                    </tr>
                </template>
            </tbody>
        </table>
        <div class="w-100" v-if="paginate">
            <div class="spinner-border text-primary mx-auto d-flex" role="status" v-if="paginateLoadIco"><span class="sr-only">Loading...</span></div>    
            <button type="button" class="btn btn-outline-info mx-auto d-flex" @click="paginateAction()" v-else>
                <i class="fas fa-chevron-circle-down mr-2 mt-1"></i>
                load more
            </button>
                    
        </div>
    </div>
</template>

<script>
    export default {
        props: ['data', 'route', 'convert', 'setid'],
        data() {
            return {
            dataIn: this.data,
            dataInternal: this.getData,
            order: {
                index: 0,
                asc: true
            },
            search: undefined,
            paginate: undefined,
            paginateLoadIco: false,
            }
        },
        watch:{
            search(){this.setSearch()},
        },
        computed:{
            getKey() {
                if(this.getData[0]) return Object.keys(this.getData[0]).filter( key => key != 'id');
                return [];
            },
            getData(){
                let data = (this.dataIn || []);

                if(data.paginate && data.paginate.currentPage != data.paginate.lastPage){
                    this.paginate = data.paginate.nextPage;
                }else{
                    this.paginate = undefined;
                }
                if(data.data) data = data.data;

                this.dataInternal = data;
                return data;
            },            
            checkAction(){
                if(!this.route){
                    return false;
                } else if(this.route.view || this.route.edit || this.route.delete) return true;

                return false;
            }
        },
        methods:{
            proccessConvert(string, index){

                if(this.convert && this.convert[index]){
                    let newString = this.convert[index].split(':value');
                    return newString.join(string);
                }

                return string;
            },
            getIdValue(data){
                let idColunn = (this.setid || 'id');

                return (data[idColunn] || 0);
            },
            setOrder(index){

                let element = document.getElementById(`vTableTitle${index}`);
                let elementOrderIco = document.getElementById('vTableTitleIco');

                if(this.order.index === index){
                    this.order.asc = !this.order.asc;
                }else{
                    this.order.index = index;
                    this.order.asc = true;
                }

                //remove ico
                elementOrderIco.parentElement.removeChild(elementOrderIco);

                //set ico
                if(this.order.asc){
                    element.innerHTML += '<i id="vTableTitleIco" class="fas fa-sort-alpha-down"></i>';
                }else{
                    element.innerHTML += '<i id="vTableTitleIco" class="fas fa-sort-alpha-down-alt"></i>';
                }

                this.ordenation();
            },
            ordenation(data){

                data = (data || (this.dataInternal || []));

                let index = this.getKey[this.order.index];

                if(this.order.asc){
                    data.sort(function(a,b){
                        if(a[index] > b[index]){ return 1;}
                        if(a[index] < b[index]){ return -1;}
                        return 0;
                    });
                }else{
                    data.sort(function(a,b){
                        if(a[index] < b[index]){ return 1;}
                        if(a[index] > b[index]){ return -1;}
                        return 0;
                    });                    
                }//if sort  
                
                this.dataInternal = data;
            },
            setSearch(){
                let search = this.search.toLowerCase();
                let data = this.getData;

                data = data.filter( line => {

                    if(
                        Object.values(line).filter( string => {

                            if(typeof string != 'string'){
                                
                                return false;

                            }else if (string.toLowerCase().indexOf(search.toLowerCase()) === -1) return false;

                            return true;

                        }).length > 0) return true;
                        return false;
                });//filter 
                this.ordenation(data);
            },
            paginateAction(){

                self = this;
                this.paginateLoadIco = true;

                $.get(this.paginate).done(function (data){


                    if(data.paginate) self.dataIn.paginate = data.paginate;

                    data = (data.data || data);
                    self.dataIn.data = self.dataIn.data.concat(data);

                    self.search = '';
                    self.paginateLoadIco = false;

                }).fail(function (error){

                    self.paginateLoadIco = false;

                });


            }
        },
        mounted() {
        }
    }
</script>
<style scoped>
.v-table{
    text-transform: capitalize;
}
.v-table tr:hover{
    background-color: #979797;
    color: #000;
    font-weight: 500;
}
.v-table-title:hover{
    cursor: pointer;
}
.v-table-search{
    width: 150px;
    transition: 1s;
}
.v-table-search:hover{
    width: 350px;
}
.v-table-search:focus{
    width: 350px;
}
.v-table-actions{
    display: none;
    position: absolute;
    width: 80px;
    margin: 10px -85px;
    padding: 5px;
    background-color: #fff;
    text-align: center;
    border-radius: 2px;
    box-shadow: 1px 1px 2px #464646;
}
.v-table tr:hover .v-table-actions{
    display: table-cell;
}
.v-table-actions a:hover{
    text-shadow: 1px 1px 1px #000;
}
</style>

/******     DATA EXAMPLE    ******
    <v-table :data="[{
        id: '1',
        name: 'daniel',
        sobrenome: 'barroso',
        ultimonome: 'seufetelli'
    },{
        id: '2',
        name: 'lorenna',
        sobrenome: 'rocha',
        ultimonome: 'seufetelli'      
    },{
        id: '3',
        name: 'antonio',
        sobrenome: 'jose',
        ultimonome: 'seufetelli'
    }]"
    :route="{
        view: '{{route('home')}}',
        edit: '{{route('home')}}',
        delete: '{{route('home')}}',
    }"
    ></v-table>
*/