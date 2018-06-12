@extends('layouts.app')

@section('content')

  <div class="container goals-admin">

    <div class="matches">

      <table class="table table-hover">
        <tbody>
          @foreach ($users as $user)

            <tr>
              <td>{{ $user->full_name }}</td>
              <td>{{ $user->predictions->count() }} / {{ $match_count }}</td>
            </tr>

          @endforeach
        </tbody>
      </table>

    </div>

  </div>

@endsection
