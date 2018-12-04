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
                Teilnehmer ({{ count($allMembers) }})
            </div>

            <div class="panel-body">
                @if(count($allMembers))
                <table class="table table-bordered table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Zahlt(-) / bekommt</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($allMembers as $member)
                        <tr>
                            <td>{{ $member['tn_name'] }}</td>
                            <td>{{ $member['mussZahlen'] }} €</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @else
                    <p>Bisher sind keine Teilnehmer vorhanden.</p>
                @endif
                <p>
                    <a href="/group/{{ $group->title }}/addmember" class="btn btn-success">Neuer Teilnehmer</a>
                </p>
            </div>
        </div>
    </div>

    @if(isset($wzw))
    <div class="col-md-6">
        <div class="panel panel-danger">
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
    @endif
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Ausgaben
            </div>

            <div class="panel-body">
                @if(count($paid))
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
                    @foreach($paid as $pay)
                        <tr>
                            <td>{{ $pay['wer'] }}</td>
                            <td>
                                <?php  $involved = implode(", ", $pay['beteiligte']); ?> {{ $involved }}
                            </td>
                            <td>{{ $pay['was'] }}</td>
                            <td>{{ $pay['preis'] }} €</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @else
                    <p>Bisher sind keine Ausgaben vorhanden.</p>
                @endif
                <p>
                    <a href="/group/{{ $group->title }}/addexpenditure" class="btn btn-success">Neue Ausgabe</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
