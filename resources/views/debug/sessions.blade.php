@extends('layouts.catalog')

@section('title', 'Débogage des Sessions')

@section('content')
<h1>Débogage des Sessions</h1>

<div class="alert alert-info">
    <strong>Session ID actuelle:</strong> {{ $currentSessionId }}
</div>

<div class="accordion" id="sessionsAccordion">
    @foreach($sessions as $fileName => $session)
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button {{ $session['is_current'] ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->index }}" aria-expanded="{{ $session['is_current'] ? 'true' : 'false' }}" aria-controls="collapse{{ $loop->index }}">
                {{ $fileName }} {{ $session['is_current'] ? '(Session courante)' : '' }}
            </button>
        </h2>
        <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse {{ $session['is_current'] ? 'show' : '' }}" data-bs-parent="#sessionsAccordion">
            <div class="accordion-body">
                <div class="card mb-3">
                    <div class="card-header">Contenu brut</div>
                    <div class="card-body">
                        <pre class="bg-light p-3"><code>{{ $session['content'] }}</code></pre>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Contenu décodé</div>
                    <div class="card-body">
                        <pre class="bg-light p-3"><code>{{ print_r($session['decoded'], true) }}</code></pre>
                    </div>
                </div>

                @if(is_array($session['decoded']) && isset($session['decoded']['cart']))
                <div class="card mt-3">
                    <div class="card-header bg-primary text-white">Contenu du Panier</div>
                    <div class="card-body">
                        <pre class="bg-light p-3"><code>{{ print_r($session['decoded']['cart'], true) }}</code></pre>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
