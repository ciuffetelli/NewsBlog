<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}
        @isset($title)
             | {{$title}}
        @endisset
    </title>

    <!-- Scripts -->
    {{-- <script src="https://cdn.jsdelivr.net/remarkable/1.7.1/remarkable.min.js"></script> --}}

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script>
        const config = {
            root : '{{ config("APP_URL", "http://127.0.0.1:8000")}}',
            csrf: '{{ csrf_token() }}',
            asset: '{{ asset('')}}'
        }       

        const dd = (value) => {
            console.log(value);
        }
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <header>
            {{-- <div class="float-right mr-4">
                @guest
                    <a href="#" aria-label="log in" type="button" data-toggle="modal" data-target="#modalLogin"><i class="fas fa-sign-in-alt mr-2"></i>log in</a>
                @else
                    <a href="{{ route('logout') }}"
                       aria-label="log out" 
                       type="button"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                       
                       <i class="fas fa-sign-out-alt mr-2"></i>log out</a>
                       <p><small>{{Auth::user()->name}}</small></p>

                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest
            </div>             --}}
            <div class="float-left w-100">
                <img src="{{ asset('image/logoBig.png')}}" alt="logo" class="d-flex mx-auto" />
            </div>
            <v-menu :data="{{$menu['menu'] ?? '[]'}}" 
                active="{{$menu['active'] ?? 'home'}}" 
                home="{{$menu['home'] ?? ''}}"

                @auth
                    :auth="'{{ route('admin')}}'"    
                @endauth
                
            ></v-menu>
        </header>

            <div class="container mt-2 mb-2"><!-- ERRORS -->

                @if($errors->any())
                    {!! implode('', $errors->all('<v-alert type="error"><strong>:message</strong></v-alert>')) !!}
                @endif
                @empty(!session()->get('success'))
                    <v-alert type="success">{{session()->get('success')}}</v-alert>
                @endisset

            </div>
        
        <main class="container justify-content-center bg-light p-2">
            {{-- <div class="m-2 w-100"> --}}
                @yield('content')
            {{-- </div> --}}
        </main>

        @empty(Auth::user())
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
        @endempty          
    </div>
    <section id="search">
        <div class="conatiner row mt-2">
            <div class="col mt-1 border-top pt-2 mb-3">
                <form class="d-flex" action="{{ route('search') }}">
                    <div class="col-2"></div>
                    <input type="text" name="search" value="{{$search ?? ''}}" class="form-control col-6" placeholder="search">
                    <button type="submit" class="btn btn-primary col-2 ml-3">go</button>
                    <div class="col-2"></div>
                </form> 
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>    
    <script>
    </script>
</body>
</html>
