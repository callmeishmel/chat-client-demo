<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\CannedMessage;

class AdminController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
  * Show create user page
  *
  * @return view
  */
  public function createUserPage()
  {

    if (Auth::user()->position === 'RM') {
      return redirect('/');
    }

    // Ugly ass hack to make laravel pagination work with other $_GET variables
    if(!isset($_GET['page'])) {
      return redirect('users?page=1');
    }

    if(isset($_GET['usr'])) {
      $userToEdit = User::where('id', '=', $_GET['usr'])->first();
    } else {
      $userToEdit = null;
    }

    $users = User::orderBy('position', 'ASC')->orderBy('name', 'ASC')->paginate(15);

    return view('createUser', compact(['users','userToEdit']));

  }

  /**
  * Handle create user page POST submissions
  *
  */
  public function createUserPost(Request $request)
  {

    if (Auth::user()->position === 'RM') {
      return redirect('/');
    }

    // Validate form data
    // NOTE Some fields require different rules for editing or creating users

    $validationRules = [
      'name' => 'required|string',
      'portfolio' => 'string|nullable',
      'team' => 'string|nullable',
      'position' => 'required|string',

    ];

    if(isset($_GET['usr'])) {
      $validationRules['email'] = 'required|email';
      $validationRules['password'] = 'nullable|min:6|same:password_confirmation';
    } else {
      $validationRules['email'] = 'required|email|unique:users,email';
      $validationRules['password'] = 'required|min:6|same:password_confirmation';
    }

    $validatedData = $request->validate($validationRules);

    try {

      $post = $request->all();

      if(isset($_GET['usr'])) {
        if($this->editUser($_GET['usr'], $request->all())) {
          return redirect()->back()->with('message-success', 'User ' . $post['name'] . ' successfully edited');
        }
      } else {
        if($this->createUser($request->all())) {
          return redirect()->back()->with('message-success', 'User ' . $post['name'] . ' creation successful');
        }
      }

    } catch (\Illuminate\Database\QueryException $e) {
        // something went wrong with the transaction, rollback
        return redirect()->back()->with('message-failure', 'User ' . $post['name'] . ' creation failed: ' . $e->getMessage());
    } catch (\Exception $e) {
        // something went wrong elsewhere, handle gracefully
        return redirect()->back()->with('message-failure', 'User ' . $post['name'] . ' creation failed: ' . $e->getMessage());
    }

  }

  public function editUser($usrId, $post)
  {

    $user = User::where('id', '=', $usrId)->first();

    $user->name = $post['name'];
    $user->email = $post['email'];
    $user->api_token = Str::random(60);
    $user->portfolio = $post['portfolio'];
    $user->team = $post['team'];
    $user->position = $post['position'];

    if(!empty($post['password'])) {
      $user->password = Hash::make($post['password']);
    }

    $user->save();

    return $user;

  }

  public function createUser($post)
  {
    $newUser = User::create([
      'name' => $post['name'],
      'email' => $post['email'],
      'password' => Hash::make($post['password']),
      'api_token' => Str::random(60),
      'portfolio' => $post['portfolio'],
      'team' => $post['team'],
      'position' => $post['position']
    ]);

    return $newUser;
  }

  public function deleteUserPage($userId)
  {
    $user = User::where('id', '=', $userId)->first();

    return view('deleteUser', compact('user'));
  }

  public function deleteUserPagePost($userId)
  {

    try {

      $user = User::where('id', '=', $userId)->first();

      if($user->delete()) {
        return redirect('/users?page=1')->with('message-success', 'User successfully deleted');
      }

      return view('deleteUser', compact('user'));

    } catch (\Illuminate\Database\QueryException $e) {
        // something went wrong with the transaction, rollback
        return redirect()->back()->with('message-failure', 'User deletion failed: ' . $e->getMessage());
    } catch (\Exception $e) {
        // something went wrong elsewhere, handle gracefully
        return redirect()->back()->with('message-failure', 'User deletion failed: ' . $e->getMessage());
    }

  }

  /**
  * Show create canned message page
  *
  * @return view
  */
  public function cannedMessagesPage()
  {

    if (Auth::user()->position === 'RM') {
      return redirect('/');
    }

    // Ugly ass hack to make laravel pagination work with other $_GET variables
    if(!isset($_GET['page'])) {
      return redirect('canned-messages?page=1');
    }

    $messageToEdit = null;

    if(isset($_GET['msg'])) {
      $messageToEdit = CannedMessage::where('id', '=', $_GET['msg'])->first();
    }

    $cannedMessages = CannedMessage::paginate(10);

    foreach($cannedMessages as $message) {
      $message->possible_responses = explode(',',substr($message->possible_responses, 1, -1));
    }

    return view('createCannedMessage', compact(['cannedMessages', 'messageToEdit']));

  }

  /**
  * Handle create canned message page POST submissions
  *
  */
  public function cannedMessagesPagePost(Request $request)
  {

    if (Auth::user()->position === 'RM') {
      return redirect('/');
    }

    // Validate form data
    $validatedData = $request->validate([
        'message' => 'required|string',
        'possible_responses' => 'required|string'
    ]);

    try {

      if(isset($_GET['msg'])) {
        if($this->editCannedMessage($_GET['msg'], $request->all())) {
          return redirect()->back()->with('message-success', 'Canned message ' . $_GET['msg'] . ' successfully edited');
        }
      } else {
        if($this->createCannedMessage($request->all())) {
          return redirect()->back()->with('message-success', 'Canned message creation successful');
        }
      }

    } catch (\Illuminate\Database\QueryException $e) {
        // something went wrong with the transaction, rollback
        return redirect()->back()->with('message-failure', 'Canned message creation failed: ' . $e->getMessage());
    } catch (\Exception $e) {
        // something went wrong elsewhere, handle gracefully
        return redirect()->back()->with('message-failure', 'Canned message creation failed: ' . $e->getMessage());
    }

  }

  public function createCannedMessage($post)
  {

    $newCannedMessage = CannedMessage::create([
      'message' => $post['message'],
      'possible_responses' => $this->convertPossibleResponsesString(explode(',', $post['possible_responses'])),
      'created_by' => Auth::user()->id,
      'updated_by' => '0'
    ]);

    return $newCannedMessage;


  }

  public function editCannedMessage($msgId, $post)
  {
    $cannedMessage = CannedMessage::where('id', '=', $msgId)->first();

    $cannedMessage->message = $post['message'];
    $cannedMessage->possible_responses = $this->convertPossibleResponsesString(explode(',', $post['possible_responses']));

    $cannedMessage->save();

    return $cannedMessage;
  }

  public function deleteCannedMessagePage($cannedMessageId)
  {

    $cannedMessage = CannedMessage::where('id', '=', $cannedMessageId)->first();

    return view('deleteCannedMessage', compact('cannedMessage'));

  }

  public function deleteCannedMessagePagePost($cannedMessageId)
  {

    try {

      $cannedMessage = CannedMessage::where('id', '=', $cannedMessageId)->first();

      if($cannedMessage->delete()) {
        return redirect('/canned-messages?page=1')->with('message-success', 'Canned message ' . $cannedMessageId . ' successfully deleted');
      }

      return view('deleteCannedMessage', compact('cannedMessage'));

    } catch (\Illuminate\Database\QueryException $e) {
        // something went wrong with the transaction, rollback
        return redirect()->back()->with('message-failure', 'Canned message deletion failed: ' . $e->getMessage());
    } catch (\Exception $e) {
        // something went wrong elsewhere, handle gracefully
        return redirect()->back()->with('message-failure', 'Canned message deletion failed: ' . $e->getMessage());
    }

  }

  // Messy way to convert the comma separated string into the array type
  // string needed in DB
  public function convertPossibleResponsesString($responsesStringSubmitted)
  {

    $possibleResponsesString = '[';

    foreach($responsesStringSubmitted as $response) {
      $possibleResponsesString .= '"' . $response . '"';

      if($response !== end($responsesStringSubmitted)) {
        $possibleResponsesString .= ',';
      }
    }

    $possibleResponsesString .= ']';

    return $possibleResponsesString;
  }


}
