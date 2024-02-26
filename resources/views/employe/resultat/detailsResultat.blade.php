@extends('template.app')
@section('page-content')
    <div class="text-center p-4 p-lg-5" style="margin: 100px;">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Discipline</th>
                        <th>Or</th>
                        <th>Argent</th>
                        <th>Bronze</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($liste as $medaille)
                        <tr>
                            <td>{{ $medaille->discipline }}</td>
                            <td>{{ $medaille->medailles_or }}</td>
                            <td>{{ $medaille->medailles_argent }}</td>
                            <td>{{ $medaille->medailles_bronze }}</td>
                            <td>{{ $medaille->total_medailles }}</td>
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
