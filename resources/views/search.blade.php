@extends('layouts.app')

@section('content')
    <v-section name="search">
        <h1>Search result:</h1>

        @if(!$categorys->isEmpty())

            <div class="container categorys border-secondary border-bottom mb-3">

                <h3>Categorys</h3>

                <ul class="list-inline text-capitalize p-2">

                    @foreach ($categorys as $category)
                        <li class="list-inline-item" style="background: {{$category->color}}">
                            <a href="{{ route('openCategory', $category->name) }}" class="text-capitalize">
                                {{$category->name}}
                            </a>
                        </li>    
                    @endforeach
                </ul>
            </div>              
        @endif

        @if(!$users->isEmpty())

            <div class="container categorys border-secondary border-bottom mb-3">

                <h3>Publishers</h3>

                <ul class="list-inline p-2">

                    @foreach ($users as $user)
                        <li class="list-inline-item bg-primary">
                            <a href="{{ route('openUser', $user->name) }}" class="text-capitalize">
                                {{$user->name}}
                            </a>
                        </li>    
                    @endforeach
                </ul>
            </div>              
        @endif        
        
        @if(!$articles->isEmpty())
            <div class="container">

                <h3>Articles</h3>

                @foreach ($articles as $article)

                    <v-article :data="{{json_encode($article) ?? ''}}"></v-article>

                @endforeach
            </div>
        @endif
    </v-section>
@endsection

<style>
.categorys a{
    padding: 2px;
    margin: 2px;
    color: #fff;
    text-transform: lowercase;
}
.categorys a:hover{
    text-decoration: none;
    color: #fff;
    box-shadow: 3px 3px 3px #666;
}
</style>