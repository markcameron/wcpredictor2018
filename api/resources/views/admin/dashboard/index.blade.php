@extends('layouts.app')

@section('content')

  <div class="container">

    <div class="card">
      <div class="card-body">

        <h5 class="card-title">Tools</h5>

        <a href="{{ route('admin.dashboard.matches_can_predict_false') }}" class="btn btn-info">
          All Match can predict FALSE
        </a>

        <a href="{{ route('admin.dashboard.matches_can_predict_true') }}" class="btn btn-info">
          All Match can predict TRUE
        </a>

      </div>

      <div class="card-body">

        <a href="{{ route('admin.dashboard.users_can_predict_false') }}" class="btn btn-info">
          All Users can predict FALSE
        </a>

        <a href="{{ route('admin.dashboard.users_can_predict_true') }}" class="btn btn-info">
          All Users can predict TRUE
        </a>

      </div>

    </div>
  </div>

@endsection
