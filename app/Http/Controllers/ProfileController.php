<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use HttpResponses;

    /**
     * Dislay the profile page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('profile', [
            'user' => auth()->user()
        ]);
    }

    /**
     * Update profile info in storage
     *
     * @param Request $requset
     * @return Renderable
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'currency' => 'required'
        ]);

        $user = User::find(auth()->id());
        $user->name = $request['name'];
        $user->currency = $request['currency'];

        $updated = $user->update();
        if ($updated) {
            return back()->with('success', __('profile.update.success'));
        }

        return back()->with('error', __('common.process.error'));
    }

    /**
     * Update password in storage
     *
     * @param Request $requset
     * @return Renderable
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'min:8', 'confirmed']
        ]);

        $user = User::find(auth()->id());
        $user->password = bcrypt($request['password']);

        $user->update();

        $updated = $user->update();
        if ($updated) {
            return back()->with('success', __('profile.password.success'));
        }

        return back()->with('error', __('common.process.error'));
    }

    /**
     * Update profile avatar in storage
     *
     * @param Request $requset
     * @return Renderable
     */
    public function updateAvatar(Request $request)
    {
        $folderPath = public_path('upload/avatar/');

        $image_parts = explode(";base64,", $request->image);
        $image_base64 = base64_decode($image_parts[1]);

        $imageName = uniqid() . '.png';

        $imageFullPath = $folderPath . $imageName;


        if (!is_dir($folderPath)) {
            mkdir($folderPath);
        }

        file_put_contents($imageFullPath, $image_base64);

        $user = User::find(auth()->id());
        $previousAvatar = $user->avatar;
        $user->avatar = $imageName;

        $updated = $user->update();
        if (!$updated) {
            return $this->error(null, __('common.process.error'));
        }

        // Delete previous avatar
        $prevImagePath = public_path() . $previousAvatar;
        if ($previousAvatar != '/assets/images/no-image.png') {
            unlink($prevImagePath);
        }

        return $this->successWithReload(null, __('profile.picture.success'));
    }
}
