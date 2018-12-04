@extends('layouts.app')

@section('content')
<div style="background: linear-gradient(to right top, #051937, #004d7a, #008793, #00bf72, #a8eb12); color: white" class="jumbotron">
    <div class="container text-center">
        <h1 class="display-3">Wer zahlt wem</h1>
        <p>
            Genug vom Ausrechnen wer wem was schuldet? <br>
            Dann bist du hier richtig!.
        </p>
        <p>
            <a class="btn btn-success btn-lg" href="/home" role="button">Meine Gruppen</a>
        </p>
    </div>
</div>

<div class="section section-kitty-description">
    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                <h2>Teile Kosten unter Family and Friends</h2>
                <p class="lead">
                    Mit Wzw müsst ihr nie wieder rätseln und diskutieren wie ihr eure Kosten aufteilt.
                    Wzw listet alle eure Ausgaben auf und zeigt euch, wer wem wie viel schuldet.
                    Einfach, übersichtlich und fair.
                </p>
            </div>
            <div class="col-xs-6">
                <img src="/img/kassenbon.jpg" width="95%" style="border-radius: 50%">
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-6">
                <img src="/img/reise.jpg" width="95%" style="border-radius: 50%">
            </div>
            <div class="col-xs-6">
                <h2>Reise nach...</h2>
                <p class="lead">
                    Alice, Bob und Eve machen eine Reise ins Ausland. Alice bezahlt die Flugtickets,
                    Bob das Hotel und Eve die Verpflegung.
                </p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-6">
                <h2>Wer schuldet wem was?</h2>
                <p class="lead">
                    Bob erstellt für den Urlaub eine Gruppe in Wzw und gibt die Kosten für das Hotel ein.
                    Er verschickt einen Link der Gruppe an Alice und Eve. Diese können nun ebenfalls ihre Ausgaben eintragen.
                </p>
            </div>
            <div class="col-xs-6">
                <img src="/img/rechner.jpg" width="90%" style="border-radius: 50%">
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-6">
                <img src="/img/begleichen.jpg" width="90%" style="border-radius: 50%">
            </div>
            <div class="col-xs-6">
                <h2>Schulden begleichen</h2>
                <p class="lead">
                    Jeder sieht mit Wzw wer wem wieviel schuldet. Somit können die Schulden schnell bezahlt werden und
                    keiner muss sich mehr um die lästigen Berechnungen kümmern.</p>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
