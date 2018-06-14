@extends('layouts.app')

@section('content')

  <div class="container">

    <div class="card">

      <div class="card-body">

        <h5 class="card-title">Users</h5>

        <table class="table table-hover">
          <tbody>
            @foreach ($users as $user)

              <tr>
                <td>{{ $user->full_name }}</td>
                <td>{{ $user->predictions->count() }} / {{ $match_count }}</td>
                <td class="text-right">
                  @if ($user->can_predict)
                    <a class="btn btn-success" href="{{ route('admin.users.deny_prediction', $user->id) }}">
                      Deny
                    </a>
                  @else
                    <a class="btn btn-danger" href="{{ route('admin.users.allow_prediction', $user->id) }}">
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
