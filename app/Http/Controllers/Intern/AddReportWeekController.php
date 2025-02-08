<?php

namespace App\Http\Controllers\Intern;

use App\Models\ReportWeek;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\returnSelf;
use PATHINFO_MIME_TYPE;

class AddReportWeekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $reportWeek = ReportWeek::where('internship_id', Auth::user()->internship->id)->get();

            return DataTables::of($reportWeek)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d-M-Y');
                })
                ->editColumn('foto', function ($row) {
                    return '<img src="storage/' . $row->foto . '" style="width: 100px;object-fit:center;"/>';
                })
                ->addColumn('action', function ($row) {
                    return '
                    <form action="' . route('report-weeks.destroy', $row['id']) . '" method="POST">
                    ' . csrf_field() . ' ' . method_field('delete') . '
                     <a href="' . route('report-weeks.edit', $row['id']) . '" class="btn btn-sm btn-light">
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
                    </form>';
                })
                ->rawColumns(['action', 'foto', 'deskripsi'])
                ->make();
        }
        return view('intern.report_weeks.index', ['type_menu' => 'laporan']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('intern.report_weeks.create', ['type_menu' => 'laporan']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'deskripsi' => ['required'],
            'foto' => ['required', 'file', 'image', 'mimes:png,jpg,jpeg']
        ]);

        $user = $request->user();
        $foto = $request->file('foto');
        if ($foto) {
            if (!Storage::disk('public')->exists('laporan/' . $user->username)) {
                Storage::disk('public')->makeDirectory('laporan/' . $user->username);
            }

            $namaFoto = Str::random(5) . $foto->hashName();
            $foto->storeAs('laporan/' . $user->username, $namaFoto, 'public');
            $validated['foto'] = 'laporan/' . $user->username . '/' . $namaFoto;
        } else {
            return redirect()->back();
        }
        $validated['internship_id'] = $user->internship->id;

        $reportWeek = ReportWeek::create($validated);
        if ($reportWeek) {
            return redirect()->route('report-weeks.index')->with('success', 'Sukses menambahkan laporan');
        } else {
            return redirect()->route('report-weeks.index')->with('success', 'Gagal menambahkan laporan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $reportWeek = ReportWeek::find($id);

        if (!$reportWeek) return redirect()->route('report-weeks.index')->with('error', 'Data tidak ditemukan');

        return view('intern.report_weeks.edit', ['type_menu' => 'laporan', 'report' => $reportWeek]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'deskripsi' => ['required'],
            'foto' => ['file', 'image', 'mimes:png,jpg,jpeg,heic']
        ]);

        $reportWeek = ReportWeek::find($id);
        if (!$reportWeek) return redirect()->route('report-weeks.index')->with('error', 'Gagal mengedit laporan');
        $user = $request->user();
        $foto = $request->file('foto');
        if ($foto) {
            if (!Storage::disk('public')->exists('laporan/' . $user->username)) {
                Storage::disk('public')->makeDirectory('laporan/' . $user->username);
            }

            $namaFoto = Str::random(5) . $foto->hashName();
            $foto->storeAs('laporan/' . $user->username, $namaFoto, 'public');
            $validated['foto'] = 'laporan/' . $user->username . '/' . $namaFoto;
            Storage::disk('public')->delete($reportWeek->foto);
        } else {
            $validated['foto'] = $reportWeek->foto;
        }

        $reportWeek->update($validated);
        return redirect()->route('report-weeks.index')->with('success', 'Sukses mengedit laporan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reportWeek = ReportWeek::find($id);

        if (!$reportWeek) redirect()->route('report-weeks.index')->with('error', 'Laporan tidak ditemukan');

        if (Storage::disk('public')->exists($reportWeek->foto)) {
            Storage::disk('public')->delete($reportWeek->foto);
        }

        $reportWeek->delete();

        return redirect()->route('report-weeks.index')->with('success', 'Sukses menghapus');
    }

    public function exportToPDF()
    {
        $reportWeek = ReportWeek::all();
        // dd(base64_encode(Storage::url($reportWeek[0]->foto)));
        $report = array();
        foreach ($reportWeek as $data) {

            $path = $data->foto; // Path relatif terhadap storage/app/public
            $type = Storage::disk('public')->mimeType($path);
            $dataFoto = Storage::disk('public')->get($path);
            $base64 = base64_encode($dataFoto);
            $image = 'data:' . $type . ';base64,' . $base64;

            // dd($image);
            $data->foto = $image;
        }

        // dd($reportWeek);
        $pdf = Pdf::loadView('intern.report_weeks.pdf', ['datas' => $reportWeek]);

        return $pdf->stream('data.pdf');
    }

    public function exportToExcel() {
        return 'fitur belum ada';
    }
}
