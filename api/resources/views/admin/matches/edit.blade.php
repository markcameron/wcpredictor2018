@extends('layouts.app')

@section('content')

  <div class="container goals-admin">

    <div class="card">

      <div class="card-header">
        <ul class="nav nav-pills card-header-pills">
          <li class="nav-item active">
            <a href="{{ url('admin/matches') }}" class="btn btn-info">< Match List</a>
          </li>
        </ul>
      </div>

      <div class="card-body">

        <div class="row">

        </div>

        <form method="POST" action="{{ route('admin.matches.update', $match->id) }}">

          <input type="hidden" name="_method" value="PUT">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <div class="row">
            <div class="col">
              <div class="form-group">
                <label>{{ $match->teamHome->name }}</label>
                <input type="number" class="form-control" name="score_home" value="{{ $match->score_home }}">
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label>{{ $match->teamAway->name }}</label>
                <input type="number" class="form-control" name="score_away" value="{{ $match->score_away }}">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <button class="btn btn-info">
                Save
              </button>
            </div>
          </div>

        </form>

        <div class="row">
          <div class="col-xs-6">
            @foreach ($match->goalsHome as $goal)
              <div class="col-xs-12">
                {{ $goal->minute }} - {{ $goal->scored_by }}{{ !empty($goal->link) ? ' - L' : '' }}
                <a href="{{ route('admin.goals.edit', $goal->id) }}" class="btn btn-action btn-sm">
                  Edit
                </a>
              </div>
            @endforeach
          </div>
          <div class="col-xs-6">
            @foreach ($match->goalsAway as $goal)
              <div class="col-xs-12">
                {{ $goal->minute }} - {{ $goal->scored_by }}{{ !empty($goal->link) ? ' - L' : '' }}
                <a href="{{ route('admin.goals.edit', $goal->id) }}" class="btn btn-action">
                  Edit
                </a>
              </div>
            @endforeach
          </div>
        </div>

        <div class="row">
          <div class="col-xs-6">
            <a class="btn btn-action" href="{{ route('admin.goals.create', ['team' => 'home', 'match_id' => $match->id]) }}">
              Add Home Goal
            </a>
          </div>
          <div class="col-xs-6">
            <a class="btn btn-action" href="{{ route('admin.goals.create', ['team' => 'away', 'match_id' => $match->id]) }}">
              Add Away Goal
            </a>
          </div>
        </div>

      </div>
    </div>

  </div>

@endsection
