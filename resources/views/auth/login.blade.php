@extends('layouts.app')

@section('content')
    <div class="mx-auto col-6">
        <v-login :route="{
                login: '{{route('login')}}',
                register: '{{route('register')}}',
            }"
                :data="{
                    name: '{{old('name')}}',
                    email: '{{old('email')}}',
                }"

                redirect="{{session()->get('redirect') ?? ''}}"
            ></v-login>
    </div>
@endsection
