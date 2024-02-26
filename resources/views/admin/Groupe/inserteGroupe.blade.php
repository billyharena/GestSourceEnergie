@extends('template.app')
@section('page-content')
    <div class="text-center p-4 p-lg-5" style="margin: 100px;">
        <form class="form-control" method="POST" action="{{route('insertGroupe')}}">
            @csrf
            @method('POST')
            <p>Capacité max : <input type="number" name="capacitemax" class="form-control"></p>
            <p>Réservoir : <input type="number" name="reservoir" class="form-control"></p>
            <p>Consommation : <input type="number" name="consommation" class="form-control"></p>
            <p>Prix litre : <input type="number" name="prixlitre" class="form-control"></p>
            <input type="submit" value="INSERER" class="form-control">
        </form>
    </div>
@endsection
