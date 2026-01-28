<?php

namespace App\Http\Controllers;

use App\Models\LetterOutgoing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class OutgoingController extends Controller
{
    /* =============================
       INDEX
    ============================== */
    public function index(Request $request)
    {
        $letterdate   = $request->letterdate;
        $letterstatus = $request->letterstatus;

        $query = LetterOutgoing::query();

        /* Filter Tanggal */
        if ($letterdate) {

            $range = explode(' - ', $letterdate);

            if (count($range) == 2) {

                $start = Carbon::parse($range[0])->format('Y-m-d');
                $end   = Carbon::parse($range[1])->format('Y-m-d');

                $query->whereBetween('letterdate', [$start, $end]);
            }

        } else {

            $query->whereDate('letterdate', now());
        }

        /* Filter Status */
        if ($letterstatus) {
            $query->where('letterstatus', $letterstatus);
        }

        /* Pending */
        $pendingCount = LetterOutgoing::where('is_tindak', 0)->count();

        $letters = $query
                    ->orderBy('letterdate', 'desc')
                    ->get();

        return view('archive.letters.outgoing.index', [
            'title'         => 'Arsip Surat Keluar',
            'letters'       => $letters,
            'letterdate'    => $letterdate,
            'letterstatus'  => $letterstatus,
            'pendingCount'  => $pendingCount,
        ]);
    }

    /* =============================
       ADD FORM
    ============================== */
    public function create()
    {
        return view('archive.letters.outgoing.add', [
            'title' => 'Tambah Arsip Surat Keluar'
        ]);
    }


    /* =============================
       STORE
    ============================== */
    public function store(Request $request)
    {
        $request->validate([
            'letterdate'        => 'required|date',
            'letternumber'      => 'required',
            'letterdestination'=> 'required',
            'lettersubject'     => 'required',
            'letterstatus'      => 'required',
            'letterfile'        => 'required|file|mimes:pdf,xls,xlsx,xlsm,doc,docx',
        ]);

        /* Upload File */
        $fileName = null;

        if ($request->hasFile('letterfile')) {

            $fileName = $request->file('letterfile')
                        ->store('letters/outgoing', 'public');
        }

        LetterOutgoing::create([

            'letterdate'        => $request->letterdate,
            'letternumber'      => $request->letternumber,
            'letterdestination'=> $request->letterdestination,
            'lettersubject'     => $request->lettersubject,
            'letterstatus'      => $request->letterstatus,
            'letterdescription'=> $request->letterdescription,
            'letterfile'        => $fileName,
        ]);

        return response()->json([
            'status'  => 'OK',
            'message' => 'Berhasil menambah surat keluar'
        ]);
    }


    /* =============================
       EDIT FORM
    ============================== */
    public function edit($id)
    {
        $letter = LetterOutgoing::findOrFail($id);

        return view('archive.letters.outgoing.edit', [
            'title'  => 'Ubah Arsip Surat Keluar',
            'letter' => $letter
        ]);
    }


    /* =============================
       UPDATE
    ============================== */
    public function update(Request $request, $id)
    {
        $letter = LetterOutgoing::findOrFail($id);

        $request->validate([
            'letterdate'        => 'required|date',
            'letternumber'      => 'required',
            'letterdestination'=> 'required',
            'lettersubject'     => 'required',
            'letterstatus'      => 'required',
            'letterfile'        => 'nullable|file|mimes:pdf,xls,xlsx,xlsm,doc,docx',
        ]);

        $data = $request->only([
            'letterdate',
            'letternumber',
            'letterdestination',
            'lettersubject',
            'letterstatus',
            'letterdescription'
        ]);

        /* Jika Upload Baru */
        if ($request->hasFile('letterfile')) {

            if ($letter->letterfile) {
                Storage::disk('public')->delete($letter->letterfile);
            }

            $data['letterfile'] = $request
                                ->file('letterfile')
                                ->store('letters/outgoing', 'public');
        }

        $letter->update($data);

        return response()->json([
            'status'  => 'OK',
            'message' => 'Berhasil mengubah surat keluar'
        ]);
    }


    /* =============================
       REALISASI
    ============================== */
    public function realis(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        LetterOutgoing::where('id', $request->id)
            ->update(['is_realis' => 1]);

        return response()->json([
            'status'  => 'OK',
            'message' => 'Berhasil direalisasi'
        ]);
    }


    /* =============================
       TINDAK
    ============================== */
    public function tindak(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        LetterOutgoing::where('id', $request->id)
            ->update([
                'is_tindak'    => 1,
                'information' => $request->information
                    ?? 'Surat sudah ditindaklanjuti otomatis'
            ]);

        return response()->json([
            'status'  => 'OK',
            'message' => 'Surat berhasil ditindaklanjuti'
        ]);
    }


    /* =============================
       DELETE
    ============================== */
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $letter = LetterOutgoing::find($request->id);

        if (!$letter) {

            return response()->json([
                'status'  => 'FAILED',
                'message' => 'Data tidak ditemukan'
            ]);
        }

        /* Hapus File */
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