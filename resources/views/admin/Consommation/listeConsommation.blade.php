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
                            <th>Nombre d'étudiant</th>
                            <th>Puissance laptop</th>
                            <th>Consommation fixe</th>
                            <th>Pourcentage</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($liste as $consommation)
                            <tr>
                                <td>{{ $consommation->nbetudiant }}</td>
                                <td>{{ number_format($consommation->puissancelaptop, 2) }}</td>
                                <td>{{ number_format($consommation->consofixe, 2) }}</td>
                                <td>{{ number_format($consommation->pourcentage, 2) }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#updateModal{{ $consommation->idconsommation }}">VOIR</button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $consommation->idconsommation }}">SUPPRIMER</button>
                                </td>
                            </tr>

                            <!-- Modal -->
                            @include('admin.Consommation.updateConsommation', ['$consommation' => $consommation])
                            @include('admin.Consommation.deleteConsommation', ['$consommation' => $consommation])

                        @empty
                            <tr>
                                <td colspan="5">Aucun paramètre sur le consommation.</td>
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
                            <td>{{ $total }}</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        @else
            <div class="card-header">
                <a href="{{route('Iconso')}}" class="link-primary">Insérer un paramètre</a>
            </div>
        @endif
    </div>
@endsection
