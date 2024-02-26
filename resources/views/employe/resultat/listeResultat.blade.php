@extends('template.app')
@section('page-content')
    <div class="text-center p-4 p-lg-5" style="margin: 100px;">
        @if (session()->has('message'))
            <div class="alert alert-info">{{ session()->get('message') }}</div>
        @endif
        <div class="card-header">
            <a href="{{route('CIMedaille')}}" class="link-primary">Insérer un résultat</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Pays</th>
                        <th>Drapeau</th>
                        <th>Or</th>
                        <th>Argent</th>
                        <th>Bronze</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($liste as $medaille)
                        <tr>
                            <td>{{ $medaille->pays }}</td>
                            <td>
                                <img src="{{asset('uploads/pays/'.$medaille->imgpays)}}" width="50px" height="50px" alt="img">
                            </td>
                            <td>{{ $medaille->medailles_or }}</td>
                            <td>{{ $medaille->medailles_argent }}</td>
                            <td>{{ $medaille->medailles_bronze }}</td>
                            <td>{{ $medaille->total_medailles }}</td>
                            <td><a href="/employe/resultat/{{$medaille->idpays}}/voirDetails">VOIR DETAILS</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Aucun résultat.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
