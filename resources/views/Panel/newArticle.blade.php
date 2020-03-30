@extends('layouts.app')

@section('content')
<section id="home">
  <form class="" method="POST">

    @csrf

      <div class="form-row">
        <div class="col-md-7 mb-3">
          <label for="title">Title</label>
          <input type="text" class="form-control" value="{{$data['title'] ?? ''}}" name="title" required placeholder="title" minlength="4" maxlength="250">
        </div>
        <div class="col-md-3 mb-3">
          <label for="category_id">Category</label>
          <v-select name="category_id" value="{{$data['category_id'] ?? 1}}" :data="{{$categorys ?? '[]'}}"></v-select>
        </div>  
        <div class="col-md-2 mb-3 m-auto">
          <button type="button" class="btn btn-outline-primary mx-auto d-flex" 
                  data-toggle="collapse" data-target="#details" aria-expanded="false">Details</button>             
        </div>
      </div>
      <div class="collapse" id="details">
        <div class="form-row">
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
      </div>
      <div class="form-row">
          <div class="col-md-12 mb-3">
              <label for="content">Content</label>
              <tinymce name="content" data="{{$data['content'] ?? ''}}"></tinymce>
          </div>
      </div>

      {{-- <div class="form-row">
        <v-blog-sumary name="sumary" value="{{$data['sumary'] ?? ''}}"></v-blog-sumary>
      </div> --}}

      @isset($data->id)

        <div class="form-row">
          <div class="col-md-3 mb-3">
            <label>Create by</label>
            <input type="text" class="form-control" name="user_name" value="{{$data['user_name']}}" disabled />
          </div> 
          <div class="col-md-3 mb-3">
            <label>Created at</label>
            <input type="text" class="form-control" name="created_at" value="{{$data['created_at']}}" disabled />
          </div>               
        </div>
      
        <input type="hidden" name="id" value="{{$data->id}}" />

      @endisset

      <button class="btn btn-primary d-flex ml-auto" type="submit">Save</button>
    </form>
</section>
@endsection