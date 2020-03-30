@extends('layouts.app')

@section('content')
<section id="{{$category['name']}}">
    
    <h1 class="mt-2" style="text-transform: capitalize;">{{$article['title']}}</h1>

    <header class="row w-100">
        <div class="resume col">
            <p>Writer: <b>{{$article->user()->first()->name}}</b></p>
            <p>Category: <b>{{$article->category()->first()->name}}</b></p>
            <p>Created: <b>{{date('m-d-Y H:i', strtotime($article->created_at))}}</b></p>
            <p>Views: <b>{{$article->view}}</b></p>
        </div>
        <div class="seetoo col">
            <p><b>See too</b></p>

            @foreach ($seeToo as $seeArticle)

            <p class="w-100"><a href="{{route('viewArticle')}}/{{$seeArticle->id}}">{{$seeArticle->title}}</a></p>
                
            @endforeach

        </div>
    </header>
    
    @if (Auth::User()->level()->first()->permission >= 770)
        <button type="button" onclick="window.location.href='{{route('newArticle')}}/{{$article->id}}'" class="btn btn-info text-white">
            <i class="fas fa-edit"></i>
            <span>Edit</span>
        </button>        
    @endif


    <v-article content="{{$article['content']}}"></v-article>
</section>
@endsection
<style>
    section h1{
        width: 100%;
        color: #3490dc;
    }
    section header{
        padding: 3px;
        margin: 5px;
        /* background-color: #F5EFEB; */
    }
    section .resume p{
        margin: 0px;
        text-transform: capitalize;
    }
    section .seetoo p{
        margin: 0px;
        text-transform: capitalize;
    }
    .seetoo a{
        text-decoration: underline;
    }
</style>