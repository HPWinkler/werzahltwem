@extends('layouts.app')

@section('content')

    <div style="background: linear-gradient(to right top, #051937, #004d7a, #008793, #00bf72, #a8eb12); color: white" class="jumbotron">
        <div class="container text-center">
            <h1 class="display-3">Neuer Teilnehmer</h1>
            <p>
                für die Gruppe {{ $group->title }}
            </p>
            <p>
                <a class="btn btn-success btn-lg" href="/group/{{ $group->title }}/view" role="button">Zurück</a>
            </p>
        </div>
    </div>

    <br>

    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                {!! Form::open(['action' => ['WzwController@storeMember', $group->title], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

                <div class="form-group">
                    {{Form::label('title', 'Gruppe')}}
                    {{Form::text('title', $group->title, ['class' => 'form-control', 'placeholder' => 'Name', 'readonly'])}}
                </div>

                <div class="form-group">
                    {{ Form::label('tn_name', 'Teilnehmer') }}
                    {{ Form::text('tn_name', '', ['class' => 'form-control']) }}
                </div>


                {{Form::hidden('_method', 'PUT')}}
                {{Form::submit('Speichern', ['class'=>'btn btn-primary'])}}

                {!! Form::close() !!}
            </div>
            <div class="col-xs-6">
                <img src="/img/teilnehmer.jpg" width="90%" style="border-radius: 10%">
            </div>
        </div>
    </div>


@endsection

