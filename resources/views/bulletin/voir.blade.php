@extends('layouts.app')

@section('content')
    <h3>👁 Bulletin enregistré</h3>

    <img src="{{ $bulletin->image_base64 }}" class="img-fluid border" />
@endsection
