<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Topup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function topup(Request $request)
    {
        DB::table('topups')->insert([
            'id_user' => auth()->id(),
            'saldo' => $request->saldo
        ]);

        session()->flash('success', 'Berhasil mengajukan topup. Silahkan tunggu konfirmasi admin.');
        return redirect('/');
    }

    public function admin()
    {
        $user = Topup::all();
        return view('user.admin', compact('user'));
    }

    public function konfirmasi($id_topup)
    {
        $topup = Topup::where('id_topup', $id_topup)->first();
        $id_user = $topup->id_user;

        // Menambahkan saldo pada tabel users
        User::where('id_user', $id_user)->increment('saldo', $topup->saldo);

        // Mengubah status pada tabel topups
        Topup::where('id_topup', $id_topup)->update(['status' => 1]);

        session()->flash('success', 'Berhasil konfirmasi saldo.');
        return redirect()->back();
    }
}
