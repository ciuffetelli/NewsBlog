@extends('layouts.app')

@section('content')
    <section class="row m-1" id="home">

        <div class="col">
            @if($user_level->permission > 770)
                <v-card title="articles"
                        icon="fas fa-newspaper"
                        :links="{
                            'main': '{{route('article')}}',
                            'view': '{{route('article')}}',
                            'new': '{{route('newArticle')}}'
                        }"
                ></v-card>
            @endif
        </div>
        <div class="col">
            @if($user_level->permission > 770)
                <v-card title="categorys"
                        icon="fas fa-book"
                        :links="{
                            'main': '{{route('category')}}',
                            'view': '{{route('category')}}',
                            'new': '{{route('newCategory')}}'
                        }"
                ></v-card>
            @endif
        </div>
        <div class="col">
            @if($user_level->permission > 770)
                <v-card title="help"
                        icon="fas fa-question-circle"
                        :links="{
                            'main': '{{route('help')}}'
                        }"
                ></v-card>
            @endif
        </div>
        <div class="col">
            <v-card title="user"
                    icon="fas fa-users"
                    :links="{
                        @if($user_level->permission > 770)
                        'main': '{{route('user')}}',
                        'manager': '{{route('user')}}',
                        @else
                        'main': '{{route('myUser', Auth::User()->email)}}',
                        @endif
                        'my user': '{{route('myUser', Auth::User()->email)}}',
                        'logout' : '{{route('logout')}}'
                    }"
            ></v-card>
        </div>

    </section>
@endsection