@extends('backend.layouts.master')
@section('main-content')
    <div class="container-fluid">
        @if (isset($_GET['type']) && $_GET['type'] == 'image')
            <iframe src="/filemanager?type=image"
                style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
        @else
            <iframe src="/laravel-filemanager" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
        @endif

    </div>
@endsection
