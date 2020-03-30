@extends('layouts.app')

@section('content')
    <section id="Categorys">
        <v-table :data="{{$data ?? '[]'}}" :route="{{$route ?? '[]'}}" :convert="{{$convert ?? '[]'}}"></v-table>
    </section>  
@endsection
