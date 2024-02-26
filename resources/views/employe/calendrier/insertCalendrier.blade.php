@extends('template.app')
@section('page-content')
    <div class="text-center p-4 p-lg-5" style="margin: 100px;">
        <form class="form-control" method="POST" action="{{route('insertCalendrier')}}">
            @csrf
            @method('POST')
            <input type="date" class="form-control" name="datecalendrier" placeholder="DATE">
            <p>
                Site : <select name="idsite" class="form-control">
                    @foreach($listeSites as $listeSites)
                        <option value="{{ $listeSites->idsite }}">{{ $listeSites->nomsite }}</option>
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
            <input type="submit" value="INSERER" class="form-control">
        </form>
    </div>
@endsection
