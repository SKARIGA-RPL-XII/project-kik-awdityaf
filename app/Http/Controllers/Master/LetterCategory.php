<?php

namespace App\Http\Controllers;

use App\Models\MsLetterCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LetterCategoryController extends Controller
{
    /**
     * List kategori
     */
    public function index()
    {
        $categories = MsLetterCategory::orderBy('createddate', 'desc')->get();

        return view('master.lettercategory.index', [
            'title'          => 'Kategori Surat',
            'lettercategory' => $categories,
        ]);
    }

    /**
     * Load form add (AJAX)
     */
    public function create()
    {
        $html = view('master.lettercategory.add')->render();

        return response()->json([
            'RESULT'  => 'OK',
            'CONTENT' => $html,
        ]);
    }

    /**
     * Simpan data
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:ms_lettercategory,name',
        ], [
            'name.unique' => 'Nama kategori sudah terdaftar',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => $validator->errors()->first(),
            ]);
        }

        MsLetterCategory::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'status'  => 'OK',
            'message' => 'Data berhasil disimpan',
        ]);
    }

    /**
     * Load form edit (AJAX)
     */
    public function edit($id)
    {
        $category = MsLetterCategory::find($id);

        if (!$category) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => 'Data tidak ditemukan',
            ]);
        }

        $html = view('master.lettercategory.edit', [
            'letter' => $category,
        ])->render();

        return response()->json([
            'RESULT'  => 'OK',
            'CONTENT' => $html,
        ]);
    }

    /**
     * Update data
     */
    public function update(Request $request, $id)
    {
        $category = MsLetterCategory::find($id);

        if (!$category) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => 'Data tidak ditemukan',
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:ms_lettercategory,name,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => $validator->errors()->first(),
            ]);
        }

        $category->update([
            'name' => $request->name,
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

        $category = MsLetterCategory::find($request->id);

        if (!$category) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => 'Data tidak ditemukan',
            ]);
        }

        $category->delete();

        return response()->json([
            'status'  => 'OK',
            'message' => 'Data berhasil dihapus',
        ]);
    }
}