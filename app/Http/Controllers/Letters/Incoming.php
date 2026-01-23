<?php

namespace App\Http\Controllers;

use App\Models\LetterIncoming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class IncomingController extends Controller
{
    // List data
    public function index(Request $request)
    {
        $letterdate   = $request->get('letterdate');
        $letterstatus = $request->get('letterstatus');

        $query = LetterIncoming::query();

        // Filter tanggal
        if ($letterdate) {
            $explode = explode(' - ', $letterdate);

            if (count($explode) == 2) {
                $start = date('Y-m-d', strtotime($explode[0]));
                $end   = date('Y-m-d', strtotime($explode[1]));

                $query->whereBetween('letterdate', [$start, $end]);
            }
        } else {
            $query->whereDate('letterdate', date('Y-m-d'));
        }

        // Filter status
        if ($letterstatus) {
            $query->where('letterstatus', $letterstatus);
        }

        $letters = $query
            ->orderBy('letterdate', 'DESC')
            ->get();

        return view('archive.letters.incoming.index', [
            'title'        => 'Arsip Surat Masuk',
            'letters'      => $letters,
            'letterdate'   => $letterdate,
            'letterstatus' => $letterstatus,
        ]);
    }

    // Form tambah
    public function create()
    {
        return view('archive.letters.incoming.add', [
            'title' => 'Tambah Arsip Surat Masuk'
        ]);
    }

    // Simpan data
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'letterdate'        => 'required|date',
            'letternumber'      => 'required',
            'letterorigin'      => 'required',
            'lettersubject'     => 'required',
            'letterstatus'      => 'required',
            'letterdescription' => 'nullable',
            'letterfile'        => 'required|file|mimes:pdf,xls,xlsx,xlsm,doc,docx'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => $validator->errors()->first()
            ]);
        }

        // Upload file
        $fileName = null;

        if ($request->hasFile('letterfile')) {
            $fileName = $request->file('letterfile')
                ->store('uploads/letters/incoming', 'public');
        }

        LetterIncoming::create([
            'letterdate'        => date('Y-m-d', strtotime($request->letterdate)),
            'letternumber'      => $request->letternumber,
            'letterorigin'      => $request->letterorigin,
            'lettersubject'     => $request->lettersubject,
            'letterstatus'      => $request->letterstatus,
            'letterdescription' => $request->letterdescription,
            'letterfile'        => $fileName,
        ]);

        return response()->json([
            'status'  => 'OK',
            'message' => 'Data berhasil disimpan'
        ]);
    }

    // Form edit
    public function edit($id)
    {
        $letter = LetterIncoming::find($id);

        if (!$letter) {
            return redirect()->route('incoming.index');
        }

        return view('archive.letters.incoming.edit', [
            'title'  => 'Ubah Arsip Surat Masuk',
            'letter' => $letter
        ]);
    }

    // Update data
    public function update(Request $request, $id)
    {
        $letter = LetterIncoming::find($id);

        if (!$letter) {
            return response()->json([
                'status' => 'FAILED',
                'message' => 'Data tidak ditemukan'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'letterdate'        => 'required|date',
            'letternumber'      => 'required',
            'letterorigin'      => 'required',
            'lettersubject'     => 'required',
            'letterstatus'      => 'required',
            'letterdescription' => 'nullable',
            'letterfile'        => 'nullable|file|mimes:pdf,xls,xlsx,xlsm,doc,docx'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => $validator->errors()->first()
            ]);
        }

        // Upload baru
        if ($request->hasFile('letterfile')) {

            if ($letter->letterfile) {
                Storage::disk('public')->delete($letter->letterfile);
            }

            $newFile = $request->file('letterfile')
                ->store('uploads/letters/incoming', 'public');

            $letter->letterfile = $newFile;
        }

        $letter->update([
            'letterdate'        => date('Y-m-d', strtotime($request->letterdate)),
            'letternumber'      => $request->letternumber,
            'letterorigin'      => $request->letterorigin,
            'lettersubject'     => $request->lettersubject,
            'letterstatus'      => $request->letterstatus,
            'letterdescription' => $request->letterdescription,
        ]);

        return response()->json([
            'status'  => 'OK',
            'message' => 'Data berhasil disimpan'
        ]);
    }

    // Delete
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => $validator->errors()->first()
            ]);
        }

        $letter = LetterIncoming::find($request->id);

        if (!$letter) {
            return response()->json([
                'status' => 'FAILED',
                'message' => 'Data tidak ditemukan'
            ]);
        }

        if ($letter->letterfile) {
            Storage::disk('public')->delete($letter->letterfile);
        }

        $letter->delete();

        return response()->json([
            'status'  => 'OK',
            'message' => 'Data berhasil dihapus'
        ]);
    }
}