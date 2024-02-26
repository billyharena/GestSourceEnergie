@extends('template.app')
@section('page-content')
    <div class="text-center p-4 p-lg-5" style="margin: 100px;">
        <form class="form-control" method="POST" action="{{route('insertJirama')}}">
            @csrf
            @method('POST')
            <p>Capacité max : <input class="form-control" type="number" name="capacitemax" class="form-control"></p>
            <p>Jirama : <input class="form-control" type="number" name="tarifjirama"></p>
            <input type="submit" value="INSERER" class="form-control">
        </form>
    </div>
@endsection
