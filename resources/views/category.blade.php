@extends('layouts.app')

@section('content')
    
    <v-section name="{{$category->name ?? 'home'}}" :data="{{$articles}}"></v-section>
    
@endsection