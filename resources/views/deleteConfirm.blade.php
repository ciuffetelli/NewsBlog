@extends('layouts.app')

@section('content')
    <div class="col-6 p-3 mx-auto text-center bg-danger text-light">
        <h1>Delete Confirm</h1>
        <p>Do you need to confirm for conclude this operation</p>
        <p>this will be irreversible</p>

        <div class="d-flex mx-auto justify-content-center">
            <form method="post" action="{{$action ?? route('home')}}">
                @csrf
                <input type="hidden" value="{{$id ?? 0}}" name="id" />

                    <button type="submit" class="btn btn-secondary mt-2 mr-2">Delete</button>
                    <button type="button" class="btn btn-success mt-2" onclick="window.location.href = '{{url()->previous()}}'">Cancell</button>
            </form>
        </div>
        
    </div>
@endsection