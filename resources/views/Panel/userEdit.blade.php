@extends('layouts.app')

@section('content')
    <section id="user">
        <form method="POST">

            @csrf
    
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="title">Name</label>
                    <input type="text" 
                           class="form-control" 
                           value="{{$user['name'] ?? ''}}" 
                           name="name" 
                           placeholder="name" 
                           required 
                           minlength="4" 
                           maxlength="250"
                           @if(!$editFull) readonly @endif
                           >
                </div>             
                <div class="col-md-6 mb-3">
                    <label for="title">Email</label>
                    <input type="email" 
                           class="form-control" 
                           value="{{$user['email'] ?? ''}}" 
                           name="email" 
                           placeholder="email" 
                           required 
                           minlength="4" 
                           maxlength="250"
                           @if(!$editFull) readonly @endif
                           >
                </div>                
            </div>

            <div class="form-row">

            @if($editFull)
                    <div class="col-md-4 mb-3">
                        <label for="title">Password</label>
                        <input type="password" 
                            class="form-control" 
                            value="" 
                            name="password" 
                            >
                    </div>             
                    <div class="col-md-4 mb-3">
                        <label for="title">Confirm Password</label>
                        <input type="password" 
                            class="form-control" 
                            value="" 
                            name="password_confirmation"
                            >
                    </div>                                
            @endif

                <div class="col-md-4 mb-3">
                    <label for="level_id">Level
                        <a href="{{route('help')}}#user" target="_new">
                            <i class="fas fa-question-circle" title="help"></i>
                        </a>  
                    </label>
                    <v-select name="level_id" value="{{$user['level_id'] ?? ''}}" :data="{{$level ?? '[]'}}"></v-select>
                </div> 
            </div>

            <input type="hidden" name="id" value="{{$user['id']}}" />


            <div class="d-flex justify-content-end">

                @if (Auth::id() == $user['id'])
                
                    <div class="btn btn-danger mr-2" 
                            onclick="window.location.href='{{route('deleteConfirmed', $user['email'])}}'">Delete</div>

                @endif

                <button class="btn btn-primary" type="submit">Save</button>

            </div>
      </form>        
    </section>
@endsection
