@extends('template.app')
@section('page-content')
    <div class="text-center p-4 p-lg-5" style="margin: 100px;">
        @if (session()->has('message'))
            <div class="alert alert-info">{{ session()->get('message') }}</div>
        @endif

        @if (is_array(session('errorMessages')))
            <div class="alert alert-danger">
                <ul>
                    @foreach(session('errorMessages') as $errorMessage)
                        <li>{{ $errorMessage }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="form-control" method="POST" action="{{route('importCSV')}}" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <input type="file" name="filecsv" accept=".csv" class="form-control">
            <input type="submit" value="IMPORTER" class="form-control">
        </form>
    </div>
@endsection
