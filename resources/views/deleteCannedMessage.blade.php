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

    <h3>Are you sure you want to delete canned message {{ $cannedMessage->id }}?</h3>

    <br>

    <table class="table table-sm table-bordered col-md-8 offset-2">
      <tr>
        <th class="table-dark">Message</th>
        <td>
          <h4>{{ $cannedMessage->message }}</h4>
        </td>
      </tr>
      <tr>
        <th class="table-dark">Responses</th>
        <td>
          <h5>{{ $cannedMessage->possible_responses }}</h5>
        </td>
      </tr>
    </table>

    <br>

    <form method="post">
      @csrf
      <input type="hidden" name="canned_message_id" value="{{ $cannedMessage->id }}">
      <button class="btn btn-danger btn-lg" type="submit" name="button">Delete Message</button>
    </form>
  </div>

</div>

@endsection
