@extends('template.app')
@section('page-content')
    <div class="text-center p-4 p-lg-5" style="margin: 100px;">
        <form class="form-control" method="POST" action="{{route('insertAlea2')}}">
            @csrf
            @method('POST')
            <p>Heure début groupe : <input type="number" name="debgroup" class="form-control"></p>
            <p>Heure début jirama : <input type="number" name="debjir" class="form-control"></p>
            <p>Heure fin jirama : <input type="number" name="finjir" class="form-control"></p>
            <input type="submit" value="INSERER" class="form-control">
        </form>
    </div>
@endsection
