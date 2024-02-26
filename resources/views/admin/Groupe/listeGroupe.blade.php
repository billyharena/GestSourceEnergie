@extends('template.app')
@section('page-content')
    <div class="text-center p-4 p-lg-5" style="margin: 100px;">
        @if (session()->has('message'))
            <div class="alert alert-info">{{ session()->get('message') }}</div>
        @endif

        @if ($liste->isNotEmpty())
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Capacite max</th>
                            <th>Réservoir</th>
                            <th>Consommation</th>
                            <th>Prix litre</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($liste as $groupe)
                            <tr>
                                <td>{{ $groupe->capacitemax }}</td>
                                <td>{{ $groupe->reservoir }}</td>
                                <td>{{ $groupe->consommation }}</td>
                                <td>{{ $groupe->prixlitre }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#updateModal{{ $groupe->idgroupe }}">VOIR</button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $groupe->idgroupe }}">SUPPRIMER</button>
                                </td>
                            </tr>

                            <!-- Modal -->
                            @include('admin.Groupe.updateGroupe', ['$groupe' => $groupe])
                            @include('admin.Groupe.deleteGroupe', ['$groupe' => $groupe])

                        @empty
                            <tr>
                                <td colspan="5">Aucun paramètre sur le groupe.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Horaire</th>
                            <th>Production</th>
                        </tr>
                        </thead>
                        <tbody>
                        @for($i = 8; $i <= 16; $i++)
                            <tr>
                                <td>{{ $i . 'h' }}</td>
                                <td>
                                    @if (isset($tauxHoraire[$i - 8]))
                                        {{ number_format($tauxHoraire[$i - 8], 2) }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        @endfor
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Total</th>
                            <td>{{ number_format($total, 2) }}</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        @else
            <div class="card-header">
                <a href="/admin/groupe/chargeGroupe" class="link-primary">Insérer un paramètre</a>
            </div>
        @endif
    </div>
@endsection
