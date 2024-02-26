@extends('template.app')
@section('page-content')
    <div class="text-center p-4 p-lg-5" style="margin: 100px;">
        @if (session()->has('message'))
            <div class="alert alert-info">{{ session()->get('message') }}</div>
        @endif

        <div class="card-body">
            <div>
                <h2>Tableau coût total par jour</h2>
                <a href="{{route('genererPDF')}}">Générer PDF</a>
                <a href="{{route('exportCSVPrice')}}">Générer CSV</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Horaire</th>
                        <th>Solaire</th>
                        <th>Jirama</th>
                        <th>Groupe</th>
                        <th>Total</th>
                        {{--                            <th>Différence</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @for($i = 8; $i <= 16; $i++)
                        <tr>
                            <td>{{ $i . 'h' }}</td>
                            <td>
                                @if (isset($listeS[$i - 8]))
                                    {{ number_format($listeS[$i - 8], 2) }} W
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if (isset($listeJ[$i - 8]))
                                    {{ number_format($listeJ[$i - 8], 2) }} W
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if (isset($listeG[$i - 8]))
                                    {{ number_format($listeG[$i - 8], 2) }} W
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if (isset($tabProd[$i - 8]))
                                    {{ number_format($tabProd[$i - 8], 2) }} W
                                @else
                                    N/A
                                @endif
                            </td>
                            {{--                                <td>--}}
                            {{--                                    @if (isset($diffProdCons[$i - 8]))--}}
                            {{--                                        {{ $diffProdCons[$i - 8] }}--}}
                            {{--                                    @else--}}
                            {{--                                        N/A--}}
                            {{--                                    @endif--}}
                            {{--                                </td>--}}
                        </tr>
                    @endfor
                    </tbody>
                    <tfoot>
                    <th>Coût total</th>
                    <td>{{ number_format($priceS, 2) }} AR</td>
                    <td>{{ number_format($priceJ, 2) }} AR</td>
                    <td>{{ number_format($priceG, 2) }} AR</td>
                    <td>{{ number_format($total, 2) }} AR</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
