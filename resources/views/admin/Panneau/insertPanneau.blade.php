@extends('template.app')
@section('page-content')
    <div class="text-center p-4 p-lg-5" style="margin: 100px;">
        <form class="form-control" method="POST" action="{{route('insertPanneau')}}">
            @csrf
            @method('POST')
            <p>Puissance : <input type="text" name="puissance" class="form-control"></p>
            <p>Tarif : <input type="text" name="tarif" class="form-control"></p>
            <p>8h-11h : <input type="number" name="1" class="form-control"></p>
            <p>11h-14h : <input type="number" name="2" class="form-control"></p>
            <p>14h-17h : <input type="number" name="3" class="form-control"></p>
            <input type="submit" value="INSERER" class="form-control">
        </form>
    </div>
@endsection
