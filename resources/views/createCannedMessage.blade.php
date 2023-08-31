@extends('layouts.app')

@section('content')

<div class="row">

  <div class="col-md-4 p-3">

    <h3>
      {{ isset($_GET['msg']) ? 'Editing' : 'Create' }} Canned Message {{ isset($_GET['msg']) ? $_GET['msg'] : '' }}
      @if(isset($_GET['msg']))
        <a class="btn btn-sm btn-danger float-right ml-1" href="{{ '/delete-canned-message/' . $_GET['msg'] }}"><i class="fas fa-trash-alt"></i></a>
      @endif
    </h3>

    <hr>

    <form method="post" class="admin-form" autocomplete="off">
      <div class="form-group">
        @csrf
        <label for="name">
          <div class="float-left">Message</div>
          @if($errors->has('message'))
              <div class="float-right invalid-submission">{{ $errors->first('message') }}</div>
          @endif
        </label>
        <textarea class="form-control" name="message" rows="3">@if(isset($_GET['msg'])){{ $messageToEdit->message }}@endif</textarea>

      </div>
      <div class="form-group">
        <label for="email">
          <div class="float-left">Possible Responses</div>
          @if($errors->has('possible_responses'))
              <div class="float-right invalid-submission">{{ $errors->first('possible_responses') }}</div>
          @endif
        </label>
        <textarea
          class="form-control"
          name="possible_responses"
          rows="2"
          placeholder="Example: Response 1, Response 2, Response 3">@if(isset($_GET['msg'])){{ str_replace(['"','[',']'],'',$messageToEdit->possible_responses) }}@endif</textarea>
      </div><button type="submit" class="btn btn-primary btn-block">Submit</button>
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

    <h3>All Canned Messages</h3>

    <hr>

    <table class="table table-sm table-hover table-striped">
      <thead>
        <tr>
          <th class="border-top-0" scope="col">ID</th>
          <th class="border-top-0" scope="col">Message</th>
          <th class="border-top-0" scope="col">Possible Responses</th>
          <th class="border-top-0" scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($cannedMessages as $message)
          <tr style="{{ (isset($_GET['msg']) && $_GET['msg'] == $message->id) ? 'background-color: rgb(52, 144, 220); color: #fff;' : '' }}">
            <td>{{ $message->id }}</td>
            <td>{{ $message->message }}</td>
            <td>
              <ul class="m-0 p-0" style="list-style-type: none;">
                @foreach($message->possible_responses as $response)
                  <li>- {{ $response }}</li>
                @endforeach
              </ul>
            </td>
            <td>
              @if(isset($_GET['msg']) && $_GET['msg'] == $message->id)
                <a class="btn btn-sm btn-light float-right text-primary" href="{{ preg_replace('/&msg=\d+/', '', $_SERVER['REQUEST_URI']) }}"><i class="fas fa-edit"></i></a>
              @else
                <a class="btn btn-sm btn-primary float-right" href="{{ preg_replace('/&msg=\d+/', '', $_SERVER['REQUEST_URI']) . '&msg=' . $message->id }}"><i class="fas fa-edit"></i></a>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="">
      {{ $cannedMessages->links() }}
    </div>
  </div>

</div>

@endsection
