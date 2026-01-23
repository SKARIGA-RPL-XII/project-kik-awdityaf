<?php

namespace App\Http\Controllers;

use App\Models\MsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * List user
     */
    public function index()
    {
        $users = MsUser::all();

        return view('master.admin.index', [
            'title' => 'Data User',
            'users' => $users,
        ]);
    }

    /**
     * Form tambah
     */
    public function create()
    {
        return view('master.admin.add', [
            'title' => 'Data User',
        ]);
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required',
            'phonenumber' => 'required',
            'username'    => 'required',
            'password'    => 'required|min:6',
            'job'         => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => $validator->errors()->first(),
            ]);
        }

        // Bersihkan spasi nomor
        $phone = preg_replace('/\s+/', '', $request->phonenumber);

        // Cek username
        if (MsUser::where('username', $request->username)->exists()) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => 'Username sudah terdaftar',
            ]);
        }

        MsUser::create([
            'name'        => $request->name,
            'phonenumber' => $phone,
            'username'    => $request->username,
            'job'         => $request->job,
            'password'    => Hash::make($request->password),
            'role'        => 'admin',
            'createddate' => now(),
            'createdby'   => 'admin',
        ]);

        return response()->json([
            'status'  => 'OK',
            'message' => 'Data berhasil disimpan',
        ]);
    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $user = MsUser::find($id);

        if (!$user) {
            return redirect()->route('admin.index');
        }

        return view('master.admin.edit', [
            'title' => 'Ubah User',
            'user'  => $user,
        ]);
    }

    /**
     * Update user
     */
    public function update(Request $request, $id)
    {
        $user = MsUser::find($id);

        if (!$user) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => 'Data tidak ditemukan',
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name'        => 'required',
            'phonenumber' => 'required',
            'username'    => 'required',
            'job'         => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => $validator->errors()->first(),
            ]);
        }

        // Cek username selain dirinya
        $exists = MsUser::where('id', '!=', $id)
            ->where('username', $request->username)
            ->exists();

        if ($exists) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => 'Username sudah digunakan',
            ]);
        }

        $data = [
            'name'        => $request->name,
            'phonenumber' => preg_replace('/\s+/', '', $request->phonenumber),
            'username'    => $request->username,
            'job'         => $request->job,
            'updateddate' => now(),
            'updatedby'   => 'admin',
        ];

        // Update password jika diisi
        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'status'  => 'OK',
            'message' => 'Data berhasil diupdate',
        ]);
    }

    /**
     * Hapus user
     */
    public function destroy(Request $request)
    {
        if (empty($request->id)) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => 'ID tidak ditemukan',
            ]);
        }

        $user = MsUser::find($request->id);

        if (!$user) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => 'Data tidak ditemukan',
            ]);
        }

        $user->delete();

        return response()->json([
            'status'  => 'OK',
            'message' => 'Data berhasil dihapus',
        ]);
    }
}