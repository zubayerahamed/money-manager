<?php

namespace App\Http\Controllers;

use App\Models\Dream;
use App\Models\Wallet;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DreamController extends Controller
{

    use HttpResponses;

    /**
     * Dislay the dream list page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $dreams = Dream::with('wallet')->orderBy('name', 'asc')->get();

        return view('dreams', [
            'dreams' => $dreams
        ]);
    }

    /**
     * Open dream create form in modal
     *
     * @return Renderable
     */
    public function create()
    {
        return view('layouts.dreams.dream-form', [
            'dream' => new Dream(),
            'wallets' => Wallet::orderBy('name', 'asc')->get()
        ]);
    }

    /**
     * Store new dream in storage
     *
     * @param Request $requset
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', Rule::unique('dreams', 'name')],
            'target_year' => ['required'],
            'amount_needed' => ['required', 'numeric', 'min:0']
        ]);

        $dream = Dream::create($request->only([
            'name',
            'target_year',
            'amount_needed',
            'user_id',
            'note',
            'wallet_id'
        ]));

        if ($dream) {
            return $this->successWithReloadSections(null, __('dream.save.success', ['name' => $dream->name]), 200, [
                ['dreams-accordion', route('dream.section.accordion')]
            ]);
        }

        return $this->error(null, __('common.process.error'));
    }

    /**
     * Open dream edit form in modal
     *
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $dreams = Dream::where('id', '=', $id)->get();
        if ($dreams->isEmpty()) return $this->error(null, __('dream.not.found'), 400);

        return view('layouts.dreams.dream-form', [
            'dream' => $dreams->get(0),
            'wallets' => Wallet::orderBy('name', 'asc')->get()
        ]);
    }

    /**
     * Update existing dream in storage
     *
     * @param int $id
     * @param Request $requset
     * @return Renderable
     */
    public function update($id, Request $request)
    {
        $dreams = Dream::where('id', '=', $id)->get();
        if ($dreams->isEmpty()) return $this->error(null, __('dream.not.found'), 400);

        $dream = $dreams->get(0);

        $request->validate([
            'name' => ['required', Rule::unique('dreams', 'name')->ignore($id)],
            'target_year' => ['required'],
            'amount_needed' =>  ['required', 'numeric', 'min:0']
        ]);

        $updated = $dream->update($request->only([
            'name',
            'target_year',
            'amount_needed',
            'user_id',
            'note',
            'wallet_id'
        ]));

        if ($updated) {
            return $this->successWithReloadSections(null, __('dream.update.success', ['name' => $dream->name]), 200, [
                ['dreams-accordion', route('dream.section.accordion')]
            ]);
        }

        return $this->error(null, __('common.process.error'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $dreams = Dream::where('id', '=', $id)->get();
        if ($dreams->isEmpty()) return $this->error(null, __('dream.not.found'), 400);

        $dream = $dreams->get(0);

        // Delete previous avatar
        $previousAvatar = $dream->image;
        $prevImagePath = public_path() . $previousAvatar;
        if ($previousAvatar != '/assets/images/no-image.png') {
            unlink($prevImagePath);
        }

        $deleted = $dream->delete();

        if ($deleted) {
            return $this->successWithReloadSections(null, __('dream.delete.success', ['name' => $dream->name]), 200, [
                ['dreams-accordion', route('dream.section.accordion')]
            ]);
        }

        return $this->error(null, __('common.process.error'));
    }

    /**
     * Update dream image
     *
     * @param int $id
     * @return Renderable
     */
    public function updateImage($id, Request $request)
    {
        $dreams = Dream::where('id', '=', $id)->get();
        if ($dreams->isEmpty()) return $this->error(null, __('dream.not.found'), 400);

        $dream = $dreams->get(0);

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

        return $this->successWithReloadSections(null, __('dream.update.image.success', ['name' => $dream->name]), 200, [
            ['dreams-accordion', route('dream.section.accordion')]
        ]);
    }

    /**
     * Dream page accordion section
     *
     * @return Renderable
     */
    public function accordion()
    {
        $dreams = Dream::with('wallet')->orderBy('name', 'asc')->get();

        return view('layouts.dreams.dreams-accordion', [
            'dreams' => $dreams
        ]);
    }
}
