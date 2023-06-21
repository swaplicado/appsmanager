@extends('layouts.principal')

@section('content')
  <div>
    <div class="row">
        <div class="col-12">
            <table class="table table-striped table-inverse table-responsive" id="user_apps_table">
                <thead class="thead-inverse">
                    <tr>
                        <th>Usuario</th>
                        @foreach ($lApps as $app)
                            <th>{{ $app->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lUsers as $user)
                        <tr>
                            <td scope="row">{{ $user->username }}</td>
                            @foreach ($lApps as $app)
                                <th style="text-align: center;">
                                    <input class="form-check-input" type="checkbox" {{ $user->{$app->id_app} ? "checked" : "" }}>
                                </th>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
  </div>
@endsection

@section('footerScripts')

@endsection
