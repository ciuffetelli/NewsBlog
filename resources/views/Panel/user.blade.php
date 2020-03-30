@extends('layouts.app')

@section('content')
    <section id="user">
        <v-table :data="{{$user}}" :convert="{{$userConvert}}" :route="{{$userRoute}}" setid="email"></v-table>
    </section>
@endsection
