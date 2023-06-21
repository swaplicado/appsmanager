@extends('layouts.principal')

@section('content')
  <div>
    <h3>Menú de aplicaciones</h3>
    <hr>
    <div class="row">
      @foreach ($lApps as $app)
      <div class="col-md-4 col-lg-3">
        <div class="card border-primary mr-3 mb-3">
            <h5 class="card-header">{{ $app->name }}</h5>
            <div class="card-body">
              <h5 class="card-title">{{ $app->name }}</h5>
              <p class="card-text">{{ $app->description }}</p>
              <a target="{{ $app->target }}" href="{{ $app->app_url }}" class="btn btn-primary">Ir al sitio</a>
            </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
@endsection
