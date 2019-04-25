<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Auth;
use App\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index()
    {
        $karma = Redis::zrangebyscore('karma', 0, 9, 'WITHSCORES');
        $users = array();

        foreach ( $karma as $user) {
            $user = DB::table('users')
                    ->select('id', 'name')
                    ->where('id', '=', $user(0))
                    ->get();


            //$user->karma = $user;
            array_push($users, $user);
        }
        return $users;
    }

    public function edit()
    {
        return view('users.edit');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'image' => 'image|nullable|max:1999|dimensions:ratio=1/1',
            'bio' => 'nullable'
        ]);


        if($request->hasFile('image')){
            $filename = uniqid();
            $extension = $request->file('image')->getClientOriginalExtension();
            $filenameToStore = $filename . '.'. $extension;
            $folderToStore = 'images/users/';
            $fullImagePath = $folderToStore . $filenameToStore;

            $path = $request->file('image')->storeAs( 'public/' . $folderToStore , $filenameToStore);
        }

        $user = User::find(auth()->id());
        $user->name = $request->name;
        $user->bio = $request->bio;
        if($request->hasFile('image')){
            $user->image = '/storage/' . $fullImagePath;
        }
        $user->save();

        return redirect()->route('showuser', ['id' => auth()->id() ] )->with('message', 'Profile Updated');
    }
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show')->withUser($user);
    }

    public function passwordResetPage() {
        return view('users.changepassword');
    }

    public function passwordResetSave(Request $request) {

        $this->validate($request, [
            'currentpassword' => 'required',
            'newpassword' => 'required|string|min:6|confirmed',
        ]);


        if (!(Hash::check($request->currentpassword, Auth::user()->password))) {
            return redirect()->back()->with("error","Current password is not correct");
        }

        if($request->currentpassword == $request->newpassword){
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        $user = Auth::user();
        $user->password = bcrypt($request->newpassword);
        $user->save();

        return redirect()->back()->with("message","Password changed!");
    }
}