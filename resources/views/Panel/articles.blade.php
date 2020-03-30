@extends('layouts.app')

@section('content')
    <section id="Articles">
        <v-table :data="{{$data ?? '[]'}}" :route="{{$route ?? '[]'}}" :convert="{{$convert ?? '[]'}}"></v-table>
    </section>
@endsection