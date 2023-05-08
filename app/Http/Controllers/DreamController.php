<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Dream;
use App\Models\Wallet;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DreamController extends Controller
{

    use HttpResponses;

    public function index()
    {
        $dreams = Dream::with('wallet')->where('user_id', '=', auth()->user()->id)->orderBy('name', 'asc')->get();

        return view('dreams', [
            'dreams' => $dreams
        ]);
    }

    public function create()
    {
        return view('layouts.dreams.dream-form', [
            'dream' => new Dream(),
            'wallets' => Wallet::where('user_id', '=', auth()->user()->id)->orderBy('name', 'asc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $incomingFields = $request->validate([
            'name' => 'required',
            'target_year' => ['required'],
            'amount_needed' => ['required', 'min:0']
        ]);

        $incomingFields['user_id'] = auth()->user()->id;
        $incomingFields['wallet_id'] = $request['wallet_id'];
        $incomingFields['note'] = $request['note'];

        $dream = Dream::create($incomingFields);

        if ($dream) {
            return $this->successWithReloadSections(null, $dream->name . ' dream created successfully', 200, [
                ['dreams-accordion', route('dream.section.accordion')]
            ]);
        }

        return $this->error(null, "Something went wrong, please try again later", 200);
    }

    public function accordion()
    {
        $dreams = Dream::with('wallet')->where('user_id', '=', auth()->user()->id)->orderBy('name', 'asc')->get();

        return view('layouts.dreams.dreams-accordion', [
            'dreams' => $dreams
        ]);
    }

    public function edit(Dream $dream)
    {
        return view('layouts.dreams.dream-form', [
            'dream' => $dream,
            'wallets' => Wallet::where('user_id', '=', auth()->user()->id)->orderBy('name', 'asc')->get()
        ]);
    }

    public function update(Dream $dream, Request $request)
    {
        $incomingFields = $request->validate([
            'name' => ['required'],
            'target_year' => ['required'],
            'amount_needed' =>  ['required', 'min:0']
        ]);

        $incomingFields['wallet_id'] = $request['wallet_id'];
        $incomingFields['note'] = $request['note'];

        $updated = $dream->update($incomingFields);

        if ($updated) {
            return $this->successWithReloadSections(null, $dream->name . ' dream updated successfully', 200, [
                ['dreams-accordion', route('dream.section.accordion')]
            ]);
        }

        return $this->error(null, "Something went wrong, please try again later", 200);
    }

    public function updateImage(Dream $dream, Request $request)
    {
        $folderPath = public_path('upload/dream/');

        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        $imageName = uniqid() . '.png';

        $imageFullPath = $folderPath . $imageName;


        if (!is_dir($folderPath)) {
            mkdir($folderPath);
        }

        file_put_contents($imageFullPath, $image_base64);

        $previousAvatar = $dream->image;
        $dream->image = $imageName;
        $dream->update();

        // Delete previous avatar
        $prevImagePath = public_path() . $previousAvatar;
        if ($previousAvatar != '/assets/images/no-image.png') {
            unlink($prevImagePath);
        }

        return $this->successWithReloadSections(null, $dream->name . ' dream deleted successfully', 200, [
            ['dreams-accordion', route('dream.section.accordion')]
        ]);
    }

    public function destroy(Dream $dream)
    {
        $dreamName = $dream->name;

        // Delete previous avatar
        $previousAvatar = $dream->image;
        $prevImagePath = public_path() . $previousAvatar;
        if ($previousAvatar != '/assets/images/no-image.png') {
            unlink($prevImagePath);
        }
        $deleted = $dream->delete();

        if ($deleted){
            return $this->successWithReloadSections(null, $dream->name . ' dream deleted successfully', 200, [
                ['dreams-accordion', route('dream.section.accordion')]
            ]);
        }

        return $this->error(null, "Something went wrong, please try again later", 200);
    }
}
