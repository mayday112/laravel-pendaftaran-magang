<?php

namespace App\Http\Controllers\Staff;

use App\Models\Internship;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Exports\InternshipsExport;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Container\Attributes\Storage;

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
                    return '<a href="' . Storage::url('surat pengantar/' . $row['surat_pengantar']) . '" target="_blank"> ' . Str::limit($row['surat_pengantar'], 5) . ' </a>';
                })
                ->editColumn('approve_magang', function ($row) {

                    // return '<form action="'. route('edit-magang', $row['id']).'">'.csrf_field(). method_field('PUT')
                    //     .'<select name="" class="badge badge-primary">'
                    //     . '<option value="'.$row['approve_magang'].'">'.$row['approve_magang'].'</option>'
                    //     . '<option value="diterima">Terima</option>'
                    //     . '<option value="ditolak">Tolak</option>'
                    //     .'</select>'
                    //     .'</form>';
                    if ($row['approve_magang'] === 'diproses') {
                        return '<div class="badge badge-primary">' . $row['approve_magang'] . '</div>';
                    } else if ($row['approve_magang'] == 'diterima') {
                        return '<div class="badge badge-success">' . $row['approve_magang'] . '</div>';
                    } else if ($row['approve_magang'] == 'ditolak') {
                        return '<div class="badge badge-danger">' . $row['approve_magang'] . '</div>';
                    }
                })
                ->addColumn('name', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('action', function ($row) {
                    return '
                        <form action="' . route('delete-magang', $row['id']) . '" method="POST">
                            ' . csrf_field() . '
                            ' . method_field('delete') . '

                            <a href="' . route('edit-magang', $row['id']) . '" class="btn btn-sm btn-light">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
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
    // method untuk menuju halaman edit data magang, edit disini hanya pada approve magang dan nilai magang
    public function edit($id)
    {
        // $data = Internship::with('user')->where('id', '=', $id)->get();
        $data = Internship::with('user')->find($id);
        if (!$data) return redirect()->route('manage-magang')->with('error', 'Data tidak ditemukan!');
        return view('staff.manage-interns.edit', ['type_menu' => 'internship', 'data' => $data]);
    }
    // method untuk melakukan penyimpanan setelah merubah data
    public function update(Request $request, $id)
    {
        $validateData =  $request->validate([
            'approve_magang' => ['nullable'],
            'nilai_magang' => ['nullable', 'file', 'mimes:pdf']
        ]);

        $data = Internship::find($id);

        if (!$data) {
            return redirect()->route('manage-magang')->with('error', 'Data tidak ditemukan, Gagal mengubah!');
        }

        if ($request->file('nilai_magang')) {
            // dd($request->file('nilai_magang'));
            // hapus file nilai terdahulu jika ada
            if (Storage::fileExists('nilai magang/' . $data['nilai_magang'])) {
                Storage::delete('nilai magang/' . $data['nilai_magang']);
            }

            $file = $request->file('nilai_magang');
            $namaFile =  $data->user->name . ' ' . Date::now()->format('d M Y') . '.pdf';
            $file->storeAs('nilai magang', $namaFile, 'public');
            $data['nilai_magang'] = $namaFile;
        }

        if ($request['approve_magang']) {
            $data['approve_magang'] = $validateData['approve_magang'];
        }

        $data->save();
        return redirect()->route('manage-magang')->with('success', 'Sukses mengubah data');
    }
    //method untuk menghapus data magang sekaligus menghapus hal-hal yg berkaitan dengannya
    public function destroy($id)
    {
        $data = Internship::find($id);

        if (!$data) return redirect()->back()->with('error', 'Data tidak ditemukan!');

        Storage::disk('public')->delete('surat pengantar/' . $data->surat_pengantar);

        if (Storage::disk('public')->exists('nilai magang/' . $data->nilai_magang)) {
            Storage::disk('public')->delete('nilai magang/' . $data->nilai_magang);
        }

        $data->delete();

        return redirect()->route('manage-magang')->with('success', 'Sukses menghapus dara magang!');
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
        return Excel::download(new InternshipsExport, 'data-pendaftaran-magang-' . Date::now()->format('d-M-Y') . '.xlsx');
    }

    public function exportToPDF()
    {
        return Excel::download(new InternshipsExport, 'data.pdf',  \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function exportToPDFWithDOMPDF()
    {
        $datas = Internship::all();
        $pdf = Pdf::loadView('staff.manage-interns.pdf', ['datas' => $datas]);

        return $pdf->stream('data.pdf');
    }

    public function exportDataToPDF($id)
    {
        $internship = Internship::find($id);
        if (!$internship) return redirect()->route('manage-magang');

        $pdf = Pdf::loadView('', ['data' => $internship]);
    }
}
