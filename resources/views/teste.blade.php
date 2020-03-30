@extends('layouts.app')

@section('content')

    <div id="table">

        <v-table :data="{{$drawings}}"></v-table>

    </div>


</table>

@endsection