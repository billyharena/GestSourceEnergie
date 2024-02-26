@extends('template.app')
@section('page-content')
    <div class="text-center p-4 p-lg-5" style="margin: 100px;">
        @if (session()->has('message'))
            <div class="alert alert-info">{{ session()->get('message') }}</div>
        @endif

        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Heure</th>
                        <th>Solaire</th>
                        <th>Jirama</th>
                        <th>Groupe</th>
                        <th>Consommation</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{$heure}}</td>
                        <td>{{number_format($prodP, 2)}}</td>
                        <td>{{number_format($prodJ, 2)}}</td>
                        <td>{{number_format($prodG, 2)}}</td>
                        <td>{{number_format($cons, 2)}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
