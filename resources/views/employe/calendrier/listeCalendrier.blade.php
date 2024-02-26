@extends('template.app')
@section('page-content')
    <div class="text-center p-4 p-lg-5" style="margin: 100px;">
        @if (session()->has('message'))
            <div class="alert alert-info">{{ session()->get('message') }}</div>
        @endif
        <div class="card-header">
            <a href="{{route('CICalendrier')}}" class="link-primary">Insérer un programme</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Discipline</th>
                        <th>Date</th>
                        <th>Lieu</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($liste as $calendrier)
                        <tr>
                            <td>{{ $calendrier->discipline }}</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $calendrier->datecalendrier )->locale('fr')->isoFormat('LL') }}</td>
                            <td>{{ $calendrier->nomsite }}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#updateModal{{ $calendrier->idcalendrier }}">VOIR</button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $calendrier->idcalendrier }}">SUPPRIMER</button>
                            </td>
                        </tr>

                        <!-- Modal -->
                        @include('employe.calendrier.updateCalendrier', ['$calendrier' => $calendrier])
                        @include('employe.calendrier.deleteCalendrier', ['$calendrier' => $calendrier])

                    @empty
                        <tr>
                            <td colspan="5">Aucun programme.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
