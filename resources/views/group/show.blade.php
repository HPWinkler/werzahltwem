@extends('layouts.app')

@section('content')

    <div style="background: linear-gradient(to right top, #051937, #004d7a, #008793, #00bf72, #a8eb12); color: white" class="jumbotron">
        <div class="container text-center">
            <h1 class="display-3">Übersicht</h1>
            <p>
                Gucke dir hier genauere Details <br>
                der Gruppe <b>{{ $group->title }}</b> an. <br>
                <span style="font-size: 60%">(erstellt von {{ $group->user->name }})</span>
            </p>
            <p>
                <a class="btn btn-success btn-lg" href="/home" role="button">Meine Gruppen</a>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Teilnehmer ({{ count($teilnehmer) }})
                </div>

                <div class="panel-body">
                    <table class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Zu zahlen</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($teilnehmer as $tn)
                            <tr>
                                <td>{{ $tn['tn_name'] }}</td>
                                <td>{{ $tn['mussZahlen'] }} €</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <p>
                        <a href="/group/{{ $group->title }}/addteilnehmer" class="btn btn-success">Neuer Teilnehmer</a>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    Endabrechnung
                </div>

                <div class="panel-body">
                    <ul class="list-group">
                        @foreach($wzw as $e)
                            <li class="list-group-item"><span class="glyphicon glyphicon-share-alt"></span> &emsp;{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Ausgaben
                </div>

                <div class="panel-body">

                    <table class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th>Wer</th>
                                <th>Beteiligte</th>
                                <th>Was</th>
                                <th>Preis</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($zuzahlen as $zn)
                            <tr>
                                <td>{{ $zn['wer'] }}</td>
                                <td>
                                    <?php  $beteiligte = implode(", ", $zn['beteiligte']); ?> {{ $beteiligte }}
                                </td>
                                <td>{{ $zn['was'] }}</td>
                                <td>{{ $zn['preis'] }} €</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <p>
                        <a href="/group/{{ $group->title }}/addzahlung" class="btn btn-success">Neue Ausgabe</a>
                    </p>
                </div>
            </div>
        </div>
    </div>





@endsection