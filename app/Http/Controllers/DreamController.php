<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Dream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DreamController extends Controller
{
    public function dreams()
    {

        $dreams = Dream::where('user_id', '=', auth()->user()->id)->get()->sortDesc();

        $totalSavingAmount = DB::table('account_tracking_histories')
            ->selectRaw("SUM(amount * row_sign) as totalSavingAmount")
            ->where('user_id', '=', auth()->user()->id)
            ->get();

        return view('dreams', [
            'dreams' => $dreams,
            'totalSavingAmount' => $totalSavingAmount[0]->totalSavingAmount == null ? 0 : $totalSavingAmount[0]->totalSavingAmount,
        ]);
    }

    public function showCreateDreamPage()
    {
        return view('dream-create');
    }

    public function createDream(Request $request)
    {

        //dd($request->all());

        $incomingFields = $request->validate([
            'name' => 'required',
            'target_year' => ['required'],
            'amount_needed' => ['required', 'min:0']
        ]);

        $incomingFields['user_id'] = auth()->user()->id;

        $dream = Dream::create($incomingFields);

        if ($dream) return redirect('/dream/' . $dream->id . '/edit')->with('success', $dream->name . ' dream created successfully');

        return redirect('/dream')->with('error', "Can't create dream");
    }

    public function showEditDreamPage(Dream $dream)
    {
        return view('dream-update', ['dream' => $dream]);
    }

    public function updateDream(Dream $dream, Request $request)
    {

        $incomingFields = $request->validate([
            'name' => ['required'],
            'target_year' => ['required'],
            'amount_needed' =>  ['required', 'min:0']
        ]);

        $udream = $dream->update($incomingFields);

        if ($udream) return redirect('/dream/' . $dream->id . '/edit')->with('success', $dream->name . ' dream updated successfully');

        return redirect('/dream/' . $dream->id . '/edit')->with('error', $dream->name . ' dream update failed');
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
        if ($previousAvatar != '/assets/images/demo/users/face11.jpg') {
            unlink($prevImagePath);
        }

        return response()->json(['success' => 'Image updated sucessfully']);
    }

    public function deleteDream(Dream $dream)
    {
        $dreamName = $dream->name;

        // Delete previous avatar
        $previousAvatar = $dream->image;
        $prevImagePath = public_path() . $previousAvatar;
        if ($previousAvatar != '/assets/images/demo/users/face11.jpg') {
            unlink($prevImagePath);
        }
        $deleted = $dream->delete();

        if ($deleted) return redirect('/dream/all')->with('success', $dreamName . ' dream deleted successfully');

        return redirect('/dream/all')->with('error', "Can't delete dream");
    }
}
