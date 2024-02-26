@extends('template.app')
@section('page-content')
    <div class="text-center p-4 p-lg-5" style="margin: 100px;">
        <form class="form-control" method="POST" action="{{route('insertConsommation')}}">
            @csrf
            @method('POST')
            <p>Nombre d'étudiant : <input class="form-control" type="number" step="any" name="nbetudiant"></p>
            <p>Puissance laptop : <input class="form-control" type="number" step="any" name="puissancelaptop"></p>
            <p>Consommation fixe : <input class="form-control" type="number" step="any" name="consofixe"></p>
            <p>Pourcentage restant : <input class="form-control" type="number" step="any" name="pourcentage"></p>
            <input type="submit" value="INSERER" class="form-control">
        </form>
    </div>
@endsection
