@extends('template.app')
@section('page-content')
    <div class="text-center p-4 p-lg-5" style="margin: 100px;">
        @if (session()->has('message'))
            <div class="alert alert-info">{{ session()->get('message') }}</div>
        @endif
        <div class="card-header">
            <a href="{{route('chargeDelestage')}}" class="link-primary">Insérer délestage</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Début</th>
                        <th>Fin</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($liste as $delestage)
                        <tr>
                            <td>{{ $delestage->deb }}</td>
                            <td>{{ $delestage->fin }}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#updateModal{{ $delestage->iddelestage }}">VOIR</button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $delestage->iddelestage }}">SUPPRIMER</button>
                            </td>
                        </tr>

                        <!-- Modal -->
                        @include('admin.Delestage.updateDelestage', ['$delestage' => $delestage])
                        @include('admin.Delestage.deleteDelestage', ['$delestage' => $delestage])

                    @empty
                        <tr>
                            <td colspan="5">Aucun delestage.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
