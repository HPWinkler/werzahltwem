@extends('layouts.app')

@section('content')

    <div style="background: linear-gradient(to right top, #051937, #004d7a, #008793, #00bf72, #a8eb12); color: white" class="jumbotron">
        <div class="container text-center">
            <h1 class="display-3">Neue Ausgabe</h1>
            <p>
                der Gruppe {{ $group->title }}
            </p>
            <p>
                <a class="btn btn-success btn-lg" href="/group/{{ $group->id }}/teilnehmer" role="button">Zurück</a>
            </p>
        </div>
    </div>

    <br>

    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                {!! Form::open(['action' => ['GroupController@updateZahlung', $group->title], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

                <div class="form-group">
                    {{Form::label('title', 'Gruppe')}}
                    {{Form::text('title', $group->title, ['class' => 'form-control', 'placeholder' => 'Name', 'readonly'])}}
                </div>

                <div class="form-group">
                    {{ Form::label('wer', 'Name') }}
                    <select name="wer" class="form-control">
                        @foreach($teilnehmer as $tn)
                            <option value="{{ $tn['tn_name'] }}" >
                                {{ $tn['tn_name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    {{ Form::label('beteiligte', 'Beteiligte') }} (halte Strg gedrückt  um mehrere Teilnehmer auszuwählen)
                    <select name="beteiligte[]" class="form-control" multiple>
                        @foreach($teilnehmer as $tn)
                            <option value="{{ $tn['tn_name'] }}" >
                                {{ $tn['tn_name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    {{ Form::label('was', 'Beschreibung') }}
                    {{ Form::text('was', '', ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('preis', 'Preis') }}
                    {{ Form::number('preis', '', ['class' => 'form-control', 'step' => 0.01]) }}
                </div>

                {{Form::hidden('_method', 'PUT')}}
                {{Form::submit('Speichern', ['class'=>'btn btn-primary'])}}

                {!! Form::close() !!}
            </div>
            <div class="col-xs-6">
                <br>
                <img src="/img/my-image.jpg" width="95%" style="border-radius: 10%">
            </div>
        </div>
    </div>


@endsection
