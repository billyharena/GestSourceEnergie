@extends('template.app')
@section('page-content')
    <div class="text-center p-4 p-lg-5" style="margin: 100px;">
        <form class="form-control" method="POST" action="{{route('importCSV')}}" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <input type="file" name="filecsv" accept=".csv" class="form-control">
            <input type="submit" value="IMPORTER" class="form-control">
        </form>
    </div>
@endsection
