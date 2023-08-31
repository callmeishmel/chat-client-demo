@extends('layouts.app')

@section('content')

<div class="row">

  <div class="col-md-12 p-3 text-center">

    @if(session()->has('message-failure'))
      <div class="col-md-8 offset-2 alert alert-danger text-center">
        {{ session()->get('message-failure') }}
      </div>
    @endif

    <br>

    <h3>Are you sure you want to delete {{ $user->name }}?</h3>

    <br>

    <table class="table table-sm table-bordered col-md-8 offset-2">
      <tr>
        <th class="table-dark">Name</th>
        <td>
          <h4>{{ $user->name }}</h4>
        </td>
      </tr>
      <tr>
        <th class="table-dark">Email</th>
        <td>
          <h5>{{ $user->email }}</h5>
        </td>
      </tr>
      <tr>
        <th class="table-dark">Portfolio</th>
        <td>
          <h5>{{ $user->portfolio }}</h5>
        </td>
      </tr>
      <tr>
        <th class="table-dark">Team</th>
        <td>
          <h5>{{ $user->team }}</h5>
        </td>
      </tr>
      <tr>
        <th class="table-dark">Position</th>
        <td>
          <h5>{{ $user->position }}</h5>
        </td>
      </tr>
    </table>

    <br>

    <form method="post">
      @csrf
      <input type="hidden" name="user_id" value="{{ $user->id }}">
      <button class="btn btn-danger btn-lg" type="submit" name="button">Delete User</button>
    </form>
  </div>

</div>

@endsection
