@extends('layouts.app')

@section('content')
    {{-- <small class="float-right">last update: 25/02/2019 18:24</small> --}}

    <section id="home">

        <h2 style="font-size: 1.2rem; margin: 5px;">Breaking News</h2>
        <v-section :data="{{$breakingnews}}"

            @if (Auth::check() && Auth::User()->level()->first()->permission >= 770)

                edit="{{route('newArticle')}}"

            @endif

        ></v-section>
        {{-- title="breaking news" --}}

        <h2 style="font-size: 1.2rem; margin: 5px;">Top News</h2>
        <v-section :data="{{$topnews}}"

        @if (Auth::check() && Auth::User()->level()->first()->permission >= 770)

            edit="{{route('newArticle')}}"

        @endif        
        
        ></v-section>
        {{-- title="top news" --}}

    </section> 

    @foreach ($articles as $article)

        @if ($article[0]['category_layout'] < 6)

        <v-section :data="{{$article}}" name="{{$article[0]['category']}}" layout="{{$article[0]['layout']}}"

            @if (Auth::check() && Auth::User()->level()->first()->permission >= 770)

                edit="{{route('newArticle')}}"

            @endif>        

            <div class="w-100 m-2">
                <a href="{{route('openCategory', $article[0]['category'])}}">
                    <button class="btn btn-primary d-flex mx-auto">more of {{ $article[0]['category'] }}</button>
                </a>
            </div>            

        @elseif($article[0]['category_layout'] == 6)

            <section>
                <v-carousel :data="{{$article}}"></v-carousel>
            </section>
            
        @endif            
        
        </v-section>
        
    @endforeach
@endsection

{{-- <style>
.section h2{
    font-size: 0.9rem;
    text-transform: uppercase;
    font-weight: bold;
}    
</style> --}}
