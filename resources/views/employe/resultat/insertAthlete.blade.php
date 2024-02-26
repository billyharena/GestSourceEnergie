@extends('template.app')
@section('page-content')
    <div class="text-center p-4 p-lg-5" style="margin: 100px;">
        <form class="form-control" method="POST" action="{{route('insertResultatIndividuel')}}">
            @csrf
            @method('POST')
            <p>
                Athlète : <select name="idathlete" class="form-control">
                    @foreach($listeAthlete as $listeAthlete)
                        <option value="{{ $listeAthlete->idathlete }}">{{ $listeAthlete->nom }} {{ $listeAthlete->prenom }}</option>
                    @endforeach
                </select>
            </p>
            <input class="form-control" type="hidden" name="idresultat" value="{{$idresultat}}">
            <input type="submit" value="INSERER" class="form-control">
        </form>
    </div>
@endsection
