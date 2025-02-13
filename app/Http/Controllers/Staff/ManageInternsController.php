<?php

namespace App\Http\Controllers\Staff;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Internship;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use App\Exports\InternshipsExport;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class ManageInternsController extends Controller
{
    // method untuk masuk ke halaman data-data magang
    public function index()
    {
        if (request()->ajax()) {
            $data = Internship::with('user');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tanggal_awal_magang', function ($row) {
                    return $row['tanggal_awal_magang']->format('d M Y');
                })
                ->editColumn('tanggal_akhir_magang', function ($row) {
                    return $row['tanggal_akhir_magang']->format('d M Y');
                })
                ->editColumn('nilai_magang', function ($row) {
                    $nilaiMagang = $row['nilai_magang'] ?
                        '<a href="' . Storage::url('nilai magang/' . $row['nilai_magang']) . '" target="_blank">' . $row['nilai_magang'] . '</a>'
                        :
                        'Kosong';
                    return $nilaiMagang;
                })
                ->editColumn('surat_pengantar', function ($row) {
                    return '<a href="' . Storage::url('surat pengantar/' . $row['surat_pengantar']) . '" target="_blank"> ' . Str::limit($row['surat_pengantar'], 10) . ' </a>';
                })
                ->addColumn('name', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('action', function ($row) {
                    return '
                        <form action="' . route('magang.destroy', $row['id']) . '" method="POST">
                            ' . csrf_field() . '
                            ' . method_field('delete') . '

                            <a href="' . route('magang.edit', $row['id']) . '" class="btn btn-sm btn-light">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                              </svg>
                            </a>
                            <a href="' . route('pdf-single-data', $row['id']) . '" class="btn btn-sm btn-light">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                              </svg>
                            </a>

                          <button type="submit" class="btn btn-sm btn-light" onclick=" return confirm(\'Apakah anda Yakin?\') ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                              <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                            </svg>
                          </button>
                        </form>
                        ';
                })
                ->rawColumns(['action', 'surat_pengantar', 'approve_magang', 'nilai_magang'])
                ->make();
        }

        return view('staff.manage-interns.index', ['type_menu' => 'internship']);
    }

    // method untuk masuk ke halaman menambahkan peserta magang
    public function create()
    {
        return view('staff.manage-interns.create', ['type_menu' => 'internship']);
    }

    // method untuk menyimpan data peserta magang
    public function store(Request $request)
    {
        // dd($request);
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
            'no_telp' => 'required|numeric',
            'no_induk' => 'required',
            'asal_institusi' => 'required',
            'jurusan' => 'required',
            'bidang_diambil' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'surat_pengantar' => 'required|mimes:pdf|max:5000',
        ], [
            'name.required' => 'Nama tidak boleh kosong!',
            'validation.min.string' => 'Panjang password minimal 8 karakter',
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

        // membuat tanggal dengan class Carbon
        $validated['tanggal_awal_magang'] = Carbon::createFromFormat('m/d/Y', $validated['start_date']);
        $validated['tanggal_akhir_magang'] = Carbon::createFromFormat('m/d/Y', $validated['end_date']);

        // menyimpan file surat pengantar
        $file = $request->file('surat_pengantar');
        $namaFile =  Str::slug($validated['name'] . Str::random(5)) . $file->hashName();
        $file->storeAs('surat pengantar', $namaFile, 'public');
        $validated['surat_pengantar'] = $namaFile;

        // try {
        $user = new User();
        $user['name'] = $validated['name'];
        $user['username'] = $validated['username'];
        $user['password'] = bcrypt($validated['password']);
        $user['role'] = 'intern';

        $user->save();

        $internship = new Internship();
        $internship['user_id'] = $user->id;
        $internship['no_telp'] = $validated['no_telp'];
        $internship['no_induk'] = $validated['no_induk'];
        $internship['asal_institusi'] = $validated['asal_institusi'];
        $internship['jurusan'] =  $validated['jurusan'];
        $internship['bidang_diambil'] = $validated['bidang_diambil'];
        $internship['surat_pengantar'] = $validated['surat_pengantar'];
        $internship['tanggal_awal_magang'] = $validated['tanggal_awal_magang'];
        $internship['tanggal_akhir_magang'] = $validated['tanggal_akhir_magang'];

        $internship->save();

        return redirect()->route('magang.index')->with('success', 'Sukses menambahkan peserta');
        // } catch (Exception $e) {
        // Storage::disk('public')->delete('surat pengantar/' . $validated['surat_pengantar']);
        // return redirect()->route('magang.index')->with('error', 'Gagal menambahkan peserta');
        // }
    }

    public function show($id) {}
    // method untuk menuju halaman edit data magang, edit disini hanya pada approve magang dan nilai magang
    public function edit($id)
    {
        // $data = Internship::with('user')->where('id', '=', $id)->get();
        $data = Internship::with('user')->find($id);
        if (!$data) return redirect()->route('magang')->with('error', 'Data tidak ditemukan!');
        return view('staff.manage-interns.edit', ['type_menu' => 'internship', 'data' => $data]);
    }
    // method untuk melakukan penyimpanan setelah merubah data
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class)->ignore($request['user_id']),],
            'password' => ['confirmed'],
            'no_telp' => 'required|numeric',
            'no_induk' => 'required',
            'asal_institusi' => 'required',
            'jurusan' => 'required',
            'bidang_diambil' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'surat_pengantar' => 'nullable|mimes:pdf,doc,docx|max:5000',
            'nilai_magang' => 'nullable|mimes:pdf,doc,docx|max:5000',
        ], [
            'name.required' => 'Nama tidak boleh kosong!',
            'validation.min.string' => 'Panjang password minimal 8 karakter',
            'no_telp.required' => 'Nomor telepon tidak boleh kosong',
            'no_telp.numeric' => 'Nomor telepon harus berisi angka saja',
            'no_induk.required' => 'Nomor induk tidak boleh kosong',
            'asal_institusi.required' => 'Asal institusi tidak boleh kosong',
            'jurusan.required' => 'Jurusan tidak boleh kosong',
            'bidang_diambil.required' => 'Bidang tidak boleh kosong',
            'surat_pengantar.required' => 'Surat pengantar wajib di input',
            'surat_pengantar.mimes' => 'Masukkan file berjenis PDF,doc, atau docx',
            'nilai_magang.mimes' => 'Masukkan file berjenis PDF,doc, atau docx',
            'surat_pengantar.max' => 'Maksimum file berukuran 5 MB',
            'nilai_magang.max' => 'Maksimum file berukuran 5 MB',
        ]);

        // dd($validated);
        $internship = Internship::find($id);

        if (!$internship) {
            return redirect()->route('magang.index')->with('error', 'Data tidak ditemukan, Gagal mengubah!');
        }

        if ($request->file('nilai_magang')) {
            // dd($request->file('nilai_magang'));
            // hapus file nilai terdahulu jika ada
            if (Storage::fileExists('nilai magang/' . $internship['nilai_magang'])) {
                Storage::delete('nilai magang/' . $internship['nilai_magang']);
            }

            $file = $request->file('nilai_magang');
            $namaFile = 'nilai-' . $internship->user->name . ' ' . Date::now()->format('d M Y') . '.pdf';
            $file->storeAs('nilai magang', $namaFile, 'public');
            $internship['nilai_magang'] = $namaFile;
        }

        if ($request->file('surat_pengantar')) {
            Storage::disk('public')->delete('surat pengantar/' . $internship->surat_pengantar);
            // menyimpan file surat pengantar
            $file = $request->file('surat_pengantar');
            $namaFile =  Str::slug($validated['name'] . Str::random(5)) . $file->hashName();
            $file->storeAs('surat pengantar', $namaFile, 'public');
            $internship->surat_pengantar = $namaFile;
        }

        // mengupdate data-data yang ada
        $internship['tanggal_awal_magang'] = Carbon::createFromFormat('m/d/Y', $validated['start_date']);
        $internship['tanggal_akhir_magang'] = Carbon::createFromFormat('m/d/Y', $validated['end_date']);
        $internship['no_telp'] = $validated['no_telp'];
        $internship['no_induk'] = $validated['no_induk'];
        $internship['asal_institusi'] = $validated['asal_institusi'];
        $internship['jurusan'] = $validated['jurusan'];
        $internship['bidang_diambil'] = $validated['bidang_diambil'];

        $user = User::find($internship->user->id);
        $user['name'] = $validated['name'];
        $user['username'] = $validated['username'];
        if ($validated['password']) {
            $user['password'] = bcrypt($validated['password']);
        }

        $user->save();
        $internship->save();
        return redirect()->route('magang.index')->with('success', 'Sukses mengubah data');
    }

    //method untuk menghapus data magang sekaligus menghapus hal-hal yg berkaitan dengannya
    public function destroy($id)
    {
        $data = Internship::find($id);
        $user = User::find($data->user->id);
        if (!$data) return redirect()->back()->with('error', 'Data tidak ditemukan!');

        Storage::disk('public')->delete('surat pengantar/' . $data->surat_pengantar);

        if (Storage::disk('public')->exists('nilai magang/' . $data->nilai_magang)) {
            Storage::disk('public')->delete('nilai magang/' . $data->nilai_magang);
        }

        if (Storage::disk('public')->exists('foto profil/' . $user->photo_profile)) {
            Storage::disk('public')->delete('foto profil/' . $user->photo_profile);
        }

        $reports = $data->reportWeeks;

        foreach ($reports as $report) {
            Storage::disk('public')->delete($report->foto);
            $report->delete();
        }
        $data->delete();
        $user->delete();
        return redirect()->route('magang.index')->with('success', 'Sukses menghapus dara magang!');
    }

    // method untuk mendowload file surat pengantar, masih bingung apakah digunakan atau tidak
    public function download($namaFile)
    {
        $filePath = "surat pengantar/{$namaFile}";
        if (Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->download($filePath, $namaFile);
            // return response()->download($filePath, $namaFile, ['Content-Type' => 'application/pdf']);
        } else {
            return abort(404, 'File Not Found');
        }
    }

    public function exportToExcel()
    {
        $tahun = request('tahun');
        if($tahun){
            return Excel::download(new InternshipsExport($tahun), 'data-pendaftaran-magang-' . Date::now()->format('d-M-Y') . '.xlsx');
        } else{
            return Excel::download(new InternshipsExport(), 'data-pendaftaran-magang-' . Date::now()->format('d-M-Y') . '.xlsx');
        }
    }

    public function exportToPDFWithDOMPDF()
    {
        $tahun = request('tahun');
        $datas = Internship::query();
        if($tahun) $datas->whereYear('created_at', $tahun);
        $datas = $datas->get();

        $pdf = Pdf::loadView('staff.manage-interns.pdf', ['datas' => $datas]);

        return $pdf->download('data-magang-all.pdf');
    }

    public function exportDataToPDF($id)
    {
        $internship = Internship::find($id);
        if (!$internship) return redirect()->route('manage-magang');

        $pdf = Pdf::loadView('staff.manage-interns.pdf-single', ['data' => $internship]);
        $pdf->setPaper('a4');
        return $pdf->download('data-magang-' . $internship->user->name . '.pdf');
    }
}
