@extends('template.app')
@section('page-content')
    <div class="text-center p-4 p-lg-5" style="margin: 100px;">
        @if (session()->has('message'))
            <div class="alert alert-info">{{ session()->get('message') }}</div>
        @endif

            <div class="card-body">
                <div class="table-responsive">
                    <p style="color:black; background-color: red">Insuffisant</p>
                    <p style="color:black; background-color: green">Supérieur</p>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Horaire</th>
                            <th>Production</th>
                            <th>Consommation</th>
                        </tr>
                        </thead>
                        <tbody>
                        @for($i = 8; $i <= 16; $i++)
                            <tr>
                                <td>{{ $i . 'h' }}</td>
                                <td>
                                    @if (isset($tabProd[$i - 8]))
                                        @if($tabProd[$i - 8] < $listeConso[$i - 8])
                                            <a href="/admin/details/{{ $i - 8 }}/detailsP" style="color: black; background-color: red">{{ number_format($tabProd[$i - 8], 2) }} W</a>
                                        @elseif($tabProd[$i - 8] > $listeConso[$i - 8])
                                            <a href="/admin/details/{{ $i - 8 }}/detailsP" style="color:black; background-color: green">{{ number_format($tabProd[$i - 8], 2) }} W</a>
                                        @else
                                            <a href="/admin/details/{{ $i - 8 }}/detailsP">{{ number_format($tabProd[$i - 8], 2) }} W</a>
                                        @endif
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if (isset($listeConso[$i - 8]))
                                        @if($tabProd[$i - 8] < $listeConso[$i - 8])
                                            <a href="/admin/details/{{ $i - 8 }}/detailsP" style="color:black; background-color: green">{{ number_format($listeConso[$i - 8], 2) }} W</a>
                                        @elseif($tabProd[$i - 8] > $listeConso[$i - 8])
                                            <a href="/admin/details/{{ $i - 8 }}/detailsP" style="color: black; background-color: red">{{ number_format($listeConso[$i - 8], 2) }} W</a>
                                        @else
                                            <a href="/admin/details/{{ $i - 8 }}/detailsP">{{ number_format($listeConso[$i - 8], 2) }} W</a>
                                        @endif
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
                    </table>
                </div>
            </div>
    </div>
@endsection
