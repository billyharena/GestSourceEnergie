@extends('template.app')
@section('page-content')
    <div class="text-center p-4 p-lg-5" style="margin: 100px;">
        <form class="form-control" method="POST" action="{{route('insertMedaille')}}">
            @csrf
            @method('POST')
            <p>
                Pays : <select name="idpays" class="form-control">
                    @foreach($listePays as $listePays)
                        <option value="{{ $listePays->idpays }}">{{ $listePays->pays }}</option>
                    @endforeach
                </select>
            </p>
            <p>
                Discipline : <select name="iddiscipline" class="form-control">
                    @foreach($listeDiscipline as $listeDiscipline)
                        <option value="{{ $listeDiscipline->iddiscipline }}">{{ $listeDiscipline->discipline }}</option>
                    @endforeach
                </select>
            </p>
            <p>Rang : <input class="form-control" type="number" name="rang"></p>
            <input type="submit" value="INSERER" class="form-control">
        </form>
    </div>
@endsection
