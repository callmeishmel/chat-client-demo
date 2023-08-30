<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PresenceEvent;
use App\PusherWebhook;
use App\User;
use Pusher;

class PusherWebhookController extends Controller
{


  // Working Pusher API call prototype. For testing purposes only.
  public function pusherAPICall() {
    $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), array('cluster' => env('PUSHER_APP_CLUSTER')));

    return json_encode($pusher->get_users_info('presence-chat'));
  }


  // This catches Pusher's presence events to update user's online status
  // TODO Need to add Pusher Authentication
  public function presenceWebhook(Request $request) {

    try {

      $webhookEntry = PusherWebhook::create([
        'type' => 'presence',
        'post' => json_encode($request->all()),
        'remote_address' => $_SERVER['REMOTE_ADDR']
      ]);

      if($webhookEntry) {

        foreach($request->all()['events'] as $event) {

          switch ($event['name']) {

            case 'member_added':
              $user = User::find($event['user_id']);
              if($user) {
                $user->status = 'online';
                $user->save();
              }
              break;
            case 'member_removed':
              $user = User::find($event['user_id']);
              if($user) {
                $user->status = 'offline';
                $user->save();
              }
              break;
            default:
              break;
          }

          PresenceEvent::create([
            'user_id' => $event['user_id'],
            'type' => $event['name']
          ]);
        }

      }

    } catch (\Illuminate\Database\QueryException $e) {
      // something went wrong with the transaction, rollback
      PusherWebhook::create([
        'type' => 'presence',
        'post' => $e->getMessage()
      ]);
    } catch (\Exception $e) {
      // something went wrong elsewhere, handle gracefully
      PusherWebhook::create([
        'presence' => 'presence',
        'post' => $e->getMessage()
      ]);
    }
  }
}
