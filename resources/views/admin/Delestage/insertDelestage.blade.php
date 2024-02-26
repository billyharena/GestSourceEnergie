@extends('template.app')
@section('page-content')
    <div class="text-center p-4 p-lg-5" style="margin: 100px;">
        <form class="form-control" method="POST" action="{{route('insertDelestage')}}">
            @csrf
            @method('POST')
            <p>Début : <input class="form-control" type="number" step="any" name="deb"></p>
            <p>Fin : <input class="form-control" type="number" step="any" name="fin"></p>
            <input type="submit" value="INSERER" class="form-control">
        </form>
    </div>
@endsection
