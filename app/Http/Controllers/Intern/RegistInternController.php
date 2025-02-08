<?php

namespace App\Http\Controllers\Intern;

use Carbon\Carbon;
use App\Models\Internship;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RegistInternController extends Controller
{
    public function index()
    {
        $data = Internship::with('user')->find(Auth::user()->internship->id);
        if (!$data) return redirect()->route('dashboard')->with('lu belum daftar magang nyet');
        return view('intern.index', ['type_menu' => 'magang-user', 'data' => $data]);
    }

    public function create()
    {
        return view('intern.create', ['type_menu' => 'dashboard']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_telp' => 'required|numeric',
            'no_induk' => 'required',
            'asal_institusi' => 'required',
            'jurusan' => 'required',
            'bidang_diambil' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'surat_pengantar' => 'required|mimes:pdf|max:5000',
        ], [
            'no_telp.required' => 'Nomor telepon tidak boleh kosong',
            'no_telp.numeric' => 'Nomor telepon harus berisi angka saja',
            'no_induk.required' => 'Nomor induk tidak boleh kosong',
            'asal_institusi.required' => 'Asal institusi tidak boleh kosong',
            'jurusan.required' => 'Jurusan tidak boleh kosong',
            'bidang_diambil.required' => 'Bidang tidak boleh kosong',
            'surat_pengantar.required' => 'Surat pengantar wajib di input',
            'surat_pengantar.mimes' => 'Masukkan file berjenis PDF',
            'surat_pengantar.max' => 'Maksimum file berukuran 5 MB',
        ]);
        // dd($validated);
        // menambahkan data user_id yg diambil dari id user yg sedang login
        $validated['user_id'] = $request->user()->id;

        // membuat tanggal dengan class Carbon
        $validated['tanggal_awal_magang'] = Carbon::createFromFormat('m/d/Y', $validated['start_date']);
        $validated['tanggal_akhir_magang'] = Carbon::createFromFormat('m/d/Y', $validated['end_date']);

        // memastikan bahwa tanggal awal magang tidak lebih akhir dari tanggal akhir magang
        if ($validated['tanggal_awal_magang']->gt($validated['tanggal_akhir_magang'])) {
            return redirect()->back()->with('error', 'tanggal mulai nggak boleh lebih akhir dari tanggal akhir nyet');
        }

        // menyimpan file surat pengantar
        $file = $request->file('surat_pengantar');
        $namaFile =  Str::slug($request->user()->name . Str::random(5)) . $file->hashName();
        $file->storeAs('surat pengantar', $namaFile, 'public');
        $validated['surat_pengantar'] = $namaFile;

        if (Internship::create($validated)) {
            return redirect()->route('dashboard')->with('success', 'Sukes daftar magang');
        } else {
            return redirect()->route('dashboard')->with('error', 'Gagal mengirim form registrasi!');
        }
    }

    public function edit()
    {
        // $data = Internship::with('user')->where('user_id', '=', Auth::user()->id);
        $data = Internship::with('user')->find(Auth::user()->internship->id);
        if (!$data) return redirect()->back()->with('lu belum daftar magang nyet');
        return view('intern.edit', ['type_menu' => 'magang-user', 'data' => $data]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'no_telp' => 'required|numeric',
            'no_induk' => 'required',
            'asal_institusi' => 'required',
            'jurusan' => 'required',
            'bidang_diambil' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'surat_pengantar' => ['nullable', 'mimes:pdf', 'max:5000'],
        ], [
            'no_telp.required' => 'Nomor telepon tidak boleh kosong',
            'no_telp.numeric' => 'Nomor telepon harus berisi angka saja',
            'no_induk.required' => 'Nomor induk tidak boleh kosong',
            'asal_institusi.required' => 'Asal institusi tidak boleh kosong',
            'jurusan.required' => 'Jurusan tidak boleh kosong',
            'bidang_diambil.required' => 'Bidang tidak boleh kosong',
            'surat_pengantar.required' => 'Surat pengantar wajib di input',
            'surat_pengantar.mimes' => 'Masukkan file berjenis PDF',
            'surat_pengantar.max' => 'Maksimum file berukuran 5 MB',
        ]);

        // dd($validated);
        $validated['tanggal_awal_magang'] = Carbon::createFromFormat('m/d/Y', $validated['start_date']);
        $validated['tanggal_akhir_magang'] = Carbon::createFromFormat('m/d/Y', $validated['end_date']);

        // memastikan bahwa tanggal awal magang tidak lebih akhir dari tanggal akhir magang
        if ($validated['tanggal_awal_magang']->gt($validated['tanggal_akhir_magang'])) {
            return redirect()->back()->with('error', 'tanggal mulai nggak boleh lebih akhir dari tanggal akhir nyet');
        }

        $data = Internship::with('user')->find($request->user()->internship->id);

        if (!$data) {
            return redirect()->back()->with('error', 'lu belum daftar magang nyet');
        }

        if ($request->file('surat_pengantar')) {
            if (file_exists("storage/surat pengantar/{$data['surat_pengantar']}")) {
                Storage::disk('public')->delete('surat pengantar/' . $data['surat_pengantar']);
            } else {
                return 'file tidak ada';
            }

            $file = $request->file('surat_pengantar');
            $namaFile =  Str::slug($data->user->name . Str::random(5)) . $file->hashName();
            $file->storeAs('surat pengantar', $namaFile, 'public');
            $validated['surat_pengantar'] = $namaFile;
        } else {
            $validated['surat_pengantar'] = $data['surat_pengantar'];
        }


        $data->update([
            'no_induk' => $validated['no_induk'],
            'tanggal_awal_magang' => $validated['tanggal_awal_magang'],
            'tanggal_akhir_magang' => $validated['tanggal_akhir_magang'],
            'surat_pengantar' => $validated['surat_pengantar']
        ]);

        return redirect()->route('intern')->with('success', 'Sukes Mengubah Data Magang Anda');
    }

    public function download($namaFile)
    {
        $filePath = "nilai magang/{$namaFile}";
        if (Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->download($filePath, $namaFile);
            // return response()->download($filePath, $namaFile, ['Content-Type' => 'application/pdf']);
        } else {
            return abort(404, 'File Not Found');
        }
    }
}
