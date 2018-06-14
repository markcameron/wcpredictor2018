@extends('layouts.app')

@section('content')

  <div class="container">

    <div class="card">

      <div class="card-body">

        <h5 class="card-title">Matches</h5>

        <table class="table table-hover">
          <tbody>
            @foreach ($matches as $match)

              <tr>
                <td>{{ $match->home_team }}</td>
                <td>{{ $match->away_team }}</td>
                <td>{{ $match->score_home }} - {{ $match->score_away }}</td>
                <td class="text-right">
                  <a class="btn btn-info" href="{{ route('admin.matches.edit', $match->id) }}">
                    Edit
                  </a>
                  @if ($match->can_predict)
                    <a class="btn btn-success" href="{{ route('admin.matches.deny_prediction', $match->id) }}">
                      Deny
                    </a>
                  @else
                    <a class="btn btn-danger" href="{{ route('admin.matches.allow_prediction', $match->id) }}">
                      Allow
                    </a>
                  @endif
                </td>
              </tr>

            @endforeach
          </tbody>
        </table>

      </div>

    </div>

  </div>

@endsection
