<?php

namespace App\Http\Controllers;

use App\Models\MsInhabitant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InhabitantController extends Controller
{
    /**
     * List data penduduk
     */
    public function index()
    {
        $inhabitants = MsInhabitant::orderBy('createddate', 'desc')->get();

        return view('master.inhabitant.index', [
            'title'      => 'Data Penduduk',
            'inhabitant' => $inhabitants,
        ]);
    }

    /**
     * Form tambah
     */
    public function create()
    {
        return view('master.inhabitant.add', [
            'title' => 'Tambah Data Penduduk',
        ]);
    }

    /**
     * Simpan data baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik'                => 'required|numeric|digits:16|unique:ms_inhabitants,nik',
            'no_kk'              => 'required|numeric|digits:16',
            'name'               => 'required',
            'address'            => 'nullable',
            'rt'                 => 'required',
            'rw'                 => 'required',
            'postalcode'         => 'required|numeric|digits:5',
            'gender'             => 'required',
            'bloodtype'          => 'required',
            'birthplace'         => 'required',
            'birthdate'          => 'required|date',
            'religion'           => 'required',
            'education'          => 'required',
            'work'               => 'required',
            'marialstatus'       => 'required',
            'relationshipstatus' => 'required',
            'citizenship'        => 'required',
            'kbacceptor'         => 'required',
            'status'             => 'required',
        ], [
            'nik.unique' => 'NIK sudah terdaftar. Mohon gunakan NIK lain',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => $validator->errors()->first(),
            ]);
        }

        MsInhabitant::create([
            'nik'                => $request->nik,
            'kk'                 => $request->no_kk,
            'name'               => $request->name,
            'address'            => $request->address,
            'rt'                 => $request->rt,
            'rw'                 => $request->rw,
            'postalcode'         => $request->postalcode,
            'gender'             => $request->gender,
            'bloodtype'          => $request->bloodtype,
            'placeofbirth'       => $request->birthplace,
            'dateofbirth'        => $request->birthdate,
            'religion'           => $request->religion,
            'education'          => $request->education,
            'work'               => $request->work,
            'maritalstatus'      => $request->marialstatus,
            'relationshipstatus' => $request->relationshipstatus,
            'citizenship'        => $request->citizenship,
            'kbacceptor'         => $request->kbacceptor,
            'status'             => $request->status,
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
        $inhabitant = MsInhabitant::find($id);

        if (!$inhabitant) {
            return redirect()->route('inhabitant.index');
        }

        return view('master.inhabitant.edit', [
            'title'      => 'Ubah Data Penduduk',
            'inhabitant' => $inhabitant,
        ]);
    }

    /**
     * Update data
     */
    public function update(Request $request, $id)
    {
        $inhabitant = MsInhabitant::find($id);

        if (!$inhabitant) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => 'Data tidak ditemukan',
            ]);
        }

        $validator = Validator::make($request->all(), [
            'nik'        => 'required|numeric|digits:16|unique:ms_inhabitants,nik,' . $id,
            'no_kk'      => 'required|numeric|digits:16',
            'name'       => 'required',
            'rt'         => 'required',
            'rw'         => 'required',
            'postalcode' => 'required|numeric|digits:5',
            'birthplace' => 'required',
        ], [
            'nik.unique' => 'NIK sudah terdaftar. Mohon gunakan NIK lain',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => $validator->errors()->first(),
            ]);
        }

        $inhabitant->update([
            'nik'                => $request->nik,
            'kk'                 => $request->no_kk,
            'name'               => $request->name,
            'address'            => $request->address,
            'rt'                 => $request->rt,
            'rw'                 => $request->rw,
            'postalcode'         => $request->postalcode,
            'gender'             => $request->gender,
            'bloodtype'          => $request->bloodtype,
            'placeofbirth'       => $request->birthplace,
            'dateofbirth'        => $request->birthdate,
            'religion'           => $request->religion,
            'education'          => $request->education,
            'work'               => $request->work,
            'maritalstatus'      => $request->marialstatus,
            'relationshipstatus' => $request->relationshipstatus,
            'citizenship'        => $request->citizenship,
            'kbacceptor'         => $request->kbacceptor,
            'status'             => $request->status,
        ]);

        return response()->json([
            'status'  => 'OK',
            'message' => 'Data berhasil diubah',
        ]);
    }

    /**
     * Hapus data
     */
    public function destroy(Request $request)
    {
        if (empty($request->id)) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => 'ID tidak ditemukan',
            ]);
        }

        $inhabitant = MsInhabitant::find($request->id);

        if (!$inhabitant) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => 'Data tidak ditemukan',
            ]);
        }

        $inhabitant->delete();

        return response()->json([
            'status'  => 'OK',
            'message' => 'Data berhasil dihapus',
        ]);
    }
}