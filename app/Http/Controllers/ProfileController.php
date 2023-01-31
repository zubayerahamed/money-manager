<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function showProfilePage(){

        return view('profile', [
            'user' => auth()->user()
        ]);

    }

    public function updateProfile(Request $request){

        $incomingFields = $request->validate([
            'name' => 'required',
        ]);

        $user = User::find(auth()->user()->id);

        $user->name = $incomingFields['name'];
        $user->update();

        return redirect('/profile')->with('success', "Profile updated successfully");
    }

    public function updatePassword(Request $request){

        $incomingFields = $request->validate([
            'password' => ['required', 'min:8', 'confirmed']
        ]);

        $user = User::find(auth()->user()->id);

        $incomingFields['password'] = bcrypt($incomingFields['password']);
        $user->password = $incomingFields['password'];
        $user->update();

        return redirect('/profile')->with('success', "Password updated successfully");
    }

    public function updateAvatar(Request $request){
        $folderPath = public_path('upload/avatar/');
 
        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
 
        $imageName = uniqid() . '.png';
 
        $imageFullPath = $folderPath.$imageName;
 

        if (!is_dir($folderPath)) {
            mkdir($folderPath);
        }

        file_put_contents($imageFullPath, $image_base64);
 
        $user = User::find(auth()->user()->id);
        $previousAvatar = $user->avatar;
        $user->avatar = $imageName;
        $user->update();

        // Delete previous avatar
        $prevImagePath = public_path().$previousAvatar;
        if($previousAvatar != '/assets/images/demo/users/face11.jpg'){
            unlink($prevImagePath);
        }
    
        return response()->json(['success'=>$prevImagePath]);
    }
}
