@extends('layouts.app')

@section('content')
<section id="home">
    <form method="POST" onmousemove="setExample();">
        {{-- action="{{route('newCategory')}}" --}}
        @csrf

        <div class="form-row">
        <div class="col-md-12 mb-3">
            <label for="title">Name</label>
            <input type="text" class="form-control" value="{{$data['name'] ?? ''}}" name="name" placeholder="name" required minlength="4" maxlength="250" onkeyup="setExample()" id="name">
        </div>             
        </div>
        <div class="form-row">
            <div class="col-md-1 mb-3">
                <label for="color">Icon</label>
                <div style="padding: 0.375rem 0.75rem; transition: 2s" id="iconDisplay">
                </div>
            </div>         
            <div class="col-md-3 mb-3">
                <label for="visibility">
                    <a href="https://fontawesome.com/icons" target="_new" id="iconLink">
                        Font Awesome
                    </a>
                    <a href="{{route('help')}}#icon" target="_new">
                        <i class="fas fa-question-circle" title="help"></i>
                    </a>                
                </label>
                <input type="text" class="form-control" value="{{$data['icon'] ?? ''}}" name="icon" id="icon" placeholder="fas fa-icons" onchange="setExample()">
            </div>            
            <div class="col-md-3 mb-3">
                <label for="layout_id">Layout 
                    <a href="{{route('help')}}#layout" target="_new">
                        <i class="fas fa-question-circle" title="help"></i>
                    </a>
                </label>
                <v-select name="layout_id" value="{{$data['layout_id'] ?? ''}}" :data="{{$layout ?? '[]'}}"><v-select/>
            </div> 
            <div class="col-md-3 mb-3">
                <label for="visibility_id">Visibility
                    <a href="{{route('help')}}#visibility" target="_new">
                        <i class="fas fa-question-circle" title="help"></i>
                    </a>  
                </label>
                <v-select name="visibility_id" value="{{$data['visibility_id'] ?? ''}}" :data="{{$visibility ?? '[]'}}"></v-select>
            </div>  
        </div>
        <div class="form-row">   
            <div class="col-md-2 mb-3">
                <label><a href="{{route('help')}}#category" target="_new">
                    <i class="fas fa-question-circle" title="help"></i>
                </a></label>
                <v-checkbox name="isMenu" checked="{{$data['isMenu'] ?? 1}}"></v-checkbox>
            </div>

            <div class="col-md-1 mb-3">
                <label for="color">color
                    <a href="{{route('help')}}#category" target="_new">
                        <i class="fas fa-question-circle" title="help"></i>
                    </a>
                </label>
                <input type="color" class="form-control" value="{{$data['color'] ?? '#f6b73c'}}" name="color" required onchange="setExample()" id="color">
            </div>                    
            <div class="col-md-2 mb-3 h-10">
                <label>Example</label>
                <p class="example" id="example" onclick="color.click()">#example</p>
            </div>
            
            @isset($data->id)

                <div class="col-md-3 mb-3">
                    <label>Create by</label>
                    <input type="text" class="form-control" name="user_name" value="{{$data['user_name']}}" disabled />
                </div> 
                <div class="col-md-3 mb-3">
                    <label>Create at</label>
                    <input type="text" class="form-control" name="created_at" value="{{$data['created_at']}}" disabled />
                </div>               
                
                <input type="hidden" name="id" value="{{$data->id}}" />

            @endisset        
                
        </div>         
        <button class="btn btn-primary d-flex ml-auto" type="submit">Save</button>
  </form>
</section>
@endsection
<script>
    function setExample(){
        let example = document.getElementById('example');

        let name = '#example';
        let color = '#f6b73c';

        if(document.getElementById('name')) name = (document.getElementById('name').value || 'example');
        if(document.getElementById('color')) color = document.getElementById('color').value;

        if(example){

            example.innerHTML = `#${name}`;
            example.style.background = color;
            // example.style.color = `${color}128`;
            example.style.border = `1px solid ${color}80`;
        }

        setIcon();
    }

    function setIcon(){
        let icon = document.getElementById('icon');
        let iconName = undefined;

        if(icon.value.indexOf('"') !== -1){
            iconName = icon.value.split('"');

            iconName = iconName[1];
            icon.value = iconName;

        }else if(icon.value){
            iconName = icon.value;
        }

        if(iconName && document.getElementById('iconDisplay')){
            document.getElementById('iconDisplay').innerHTML = `<i class="${iconName} fa-2x"></i>`;
        }        

        if(document.getElementById('name')) name = (document.getElementById('name').value);

        if(document.getElementById('iconLink')){
            if(name){
                document.getElementById('iconLink').href = `https://fontawesome.com/icons?d=gallery&q=${name}`;
            }else{
                document.getElementById('iconLink').href = 'https://fontawesome.com/icons';
            }
        }        
        
    }
</script>
<style>
    .example{
        color: #fff; 
        padding: 5px; 
        text-align: center; 
        /* background: #f6b73c; */
        /* border: 1px solid #f6b73c80; */
        overflow: hidden;
        text-overflow: ellipsis;
        box-shadow: 1px 1px 3px #666;
        transition: 1s;
    }
    .example:hover{
        cursor: pointer;
        box-shadow: 1px 1px 5px #000;
    }
    .no-form-control{
        display: block;
        height: calc(1.6em + 0.75rem + 2px);
        padding: 0.375rem 0.75rem;
        font-size: 0.9rem;
        font-weight: 400;
        line-height: 1.6;
        color: #495057;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        user-select: none;
    }
</style>