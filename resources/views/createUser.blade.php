@extends('layouts.app')

@section('content')

<div class="row">

  <div class="col-md-4 p-3">

    <h3>
      {{ isset($_GET['usr']) ? 'Editing ' . $userToEdit->name : 'Create User' }}
      @if(isset($_GET['usr']))
        <a class="btn btn-sm btn-danger float-right ml-1" href="{{ '/delete-user/' . $_GET['usr'] }}"><i class="fas fa-trash-alt"></i></a>
      @endif
    </h3>

    <hr>

    <form method="post" class="admin-form" autocomplete="off">
      <div class="form-group">
        @csrf
        <label for="name" class="mb-0 align-bottom">
          <div class="float-left">Name</div>
          @if($errors->has('name'))
              <div class="float-right invalid-submission">{{ $errors->first('name') }}</div>
          @endif
        </label>
        <input
          type="text"
          class="form-control"
          name="name"
          value="{{ isset($_GET['usr']) ? $userToEdit->name : '' }}"/>
      </div>
      <div class="form-group">
        <label for="email" class="mb-0 align-bottom">
          <div class="float-left">Email</div>
          @if($errors->has('email'))
              <div class="float-right invalid-submission">{{ $errors->first('email') }}</div>
          @endif
        </label>
        <input
          type="text"
          class="form-control"
          name="email"
          value="{{ isset($_GET['usr']) ? $userToEdit->email : '' }}" />
      </div>
      <div class="form-group">
        <label for="password" class="mb-0 align-bottom">
          <div class="float-left">Password</div>
          @if($errors->has('password'))
              <div class="float-right invalid-submission">{{ $errors->first('password') }}</div>
          @endif
        </label>
        <input type="password" class="form-control" name="password" autocomplete="new-password" />
      </div>
      <div class="form-group">
        <label for="password_confirmation" class="mb-0 align-bottom">
          <div class="float-left">Verify Password</div>
          @if($errors->has('password_confirmation'))
              <div class="float-right invalid-submission">{{ $errors->first('password_confirmation') }}</div>
          @endif
        </label>
        <input type="password" class="form-control" name="password_confirmation" autocomplete="new-password"/>
      </div>
      <div class="form-group">
        <label for="portfolio" class="mb-0 align-bottom">
          <div class="float-left">Portfolio</div>
          @if($errors->has('portfolio'))
              <div class="float-right invalid-submission">{{ $errors->first('portfolio') }}</div>
          @endif
        </label>
        <input
          type="text"
          class="form-control"
          name="portfolio"
          value="{{ isset($_GET['usr']) ? $userToEdit->portfolio : '' }}" />
      </div>
      <div class="form-group">
        <label for="team" class="mb-0 align-bottom">
          <div class="float-left">Team</div>
          @if($errors->has('team'))
              <div class="float-right invalid-submission">{{ $errors->first('team') }}</div>
          @endif
        </label>
        <input
          type="text"
          class="form-control"
          name="team"
          value="{{ isset($_GET['usr']) ? $userToEdit->team : '' }}"/>
      </div>
      <div class="form-group">
        <label for="position" class="mb-0 align-bottom">
          <div class="float-left">Position</div>
          @if($errors->has('position'))
              <div class="float-right invalid-submission">{{ $errors->first('position') }}</div>
          @endif
        </label>
        <select class="form-control" name="position" >
          <option
            value="Admin"
            {{ !is_null($userToEdit) && $userToEdit->position === 'Admin' ? 'selected' : '' }}>
            Admin
          </option>
          <option
            value="RM"
            {{ !is_null($userToEdit) && $userToEdit->position === 'RM' ? 'selected' : '' }}>
            RM
          </option>
          <option
            value="TL"
            {{ !is_null($userToEdit) && $userToEdit->position === 'TL' ? 'selected' : '' }}>
            TL
          </option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary btn-block">Submit</button>
    </form>

    @if(session()->has('message-success'))
      <div class="alert alert-success text-center mt-3">
        {{ session()->get('message-success') }}
      </div>
    @endif

    @if(session()->has('message-failure'))
      <div class="alert alert-danger text-center mt-3">
        {{ session()->get('message-failure') }}
      </div>
    @endif

  </div>

  <div class="col-md-8 p-3">

    <h3>All Users</h3>

    <hr>

    <table class="table table-sm table-hover table-striped">
      <thead>
        <tr>
          <th class="border-top-0" scope="col">Name</th>
          <th class="border-top-0" scope="col">Email</th>
          <th class="border-top-0" scope="col">Portfolio</th>
          <th class="border-top-0" scope="col">Team</th>
          <th class="border-top-0" scope="col">Position</th>
          <th class="border-top-0" scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
          <tr style="{{ (isset($_GET['usr']) && $_GET['usr'] == $user->id) ? 'background-color: rgb(52, 144, 220); color: #fff;' : '' }}">
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->portfolio }}</td>
            <td>{{ $user->team }}</td>
            <td>{{ $user->position }}</td>
            <td>
              @if(isset($_GET['usr']) && $_GET['usr'] == $user->id)
                <a class="btn btn-sm btn-light float-right text-primary" href="{{ preg_replace('/&usr=\d+/', '', $_SERVER['REQUEST_URI']) }}"><i class="fas fa-edit"></i></a>
              @else
                <a class="btn btn-sm btn-primary float-right" href="{{ preg_replace('/&usr=\d+/', '', $_SERVER['REQUEST_URI']) . '&usr=' . $user->id }}"><i class="fas fa-edit"></i></a>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="">
      {{ $users->links() }}
    </div>

  </div>

</div>

@endsection
