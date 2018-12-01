@extends('layouts.app')

@section('content')

    <div style="background: linear-gradient(to right top, #051937, #004d7a, #008793, #00bf72, #a8eb12); color: white" class="jumbotron">
        <div class="container text-center">
            <h1 class="display-3">Endabrechnung</h1>
            <p>
                der Gruppe {{ $group->title }}
            </p>
            <p>
                <a class="btn btn-primary btn-lg" href="/group/{{ $group->id }}/teilnehmer" role="button">Zurück</a>
            </p>
        </div>
    </div>

    <ul>
        @foreach($wzw as $e)
            <li>{{ $e }}</li>
        @endforeach
    </ul>


@endsection