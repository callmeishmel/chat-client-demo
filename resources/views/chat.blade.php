@extends('layouts.app')

@section('content')

<div id="chat-panel-wrapper" class="row">
  <div class="col-4 col-lg-2 chat-sidebar">
    <chat-contacts
      :user="{{ Auth::user() }}"
      :contact-notifications-prop="{{ $contactNotifications }}"
    ></chat-contacts>
  </div>

  <div class="col-8 col-lg-10 p-0 chat-content">

    <div class="chat-messages" style="height:calc(100vh - 124px);">
      <chat-messages
        v-on:messagesent="addMessage"
        :messages="messages"
        :user="{{ Auth::user() }}"
      ></chat-messages>
    </div>

    <div
      class="chat-message-form p-3"
      style="height: auto; position: absolute; width: 100%; border-top: 1px solid rgba(0,0,0,.05);">
      <chat-form
          v-on:messagesent="addMessage"
          :user="{{ Auth::user() }}"
          :canned-messages="{{ $cannedMessages }}"
      ></chat-form>
    </div>

  </div>
</div>

@endsection
