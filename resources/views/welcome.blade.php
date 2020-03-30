@extends('layouts.app')

@section('content')
    <v-section name="home">

        @isset($breakingnews)

            <h2>breaking news</h2>
        
            <div class="row mb-5">

                @foreach ($breakingnews as $article)

                    <div class="col">

                    <v-article
                                title="{{$article['title']}}" 
                                color="{{$article['color']}}" 
                            category="{{$article['category']}}" 
                            content="{{$article['content']}}"
                            readmore="true">
                    </v-article>

                    </div>
                
                @endforeach          
            </div>
        @endisset

        @isset($breakingnews)

            <h2>top news</h2>
        
            <div class="row mb-5">

                @foreach ($topnews as $article)

                    <div class="col">

                    <v-article
                                title="{{$article['title']}}" 
                                color="{{$article['color']}}" 
                            category="{{$article['category']}}" 
                            content="{{$article['content']}}"
                            readmore="true">
                    </v-article>

                    </div>
                
                @endforeach          
            </div>
        @endisset        
    </v-section> 

    @foreach ($articles as $article)

        <v-section :data="{{$article}}"></v-section>
        
    @endforeach    

    <v-modal id="modalLogin">
        <v-login :route="{
            login: '{{route('login')}}',
            register: '{{route('register')}}',
        }"
            :data="{
                name: '{{old('name')}}',
                email: '{{old('email')}}',
            }"
        ></v-login>            
    </v-modal>
@endsection