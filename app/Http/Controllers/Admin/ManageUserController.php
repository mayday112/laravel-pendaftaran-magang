<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ManageUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = User::where('id', '!=', Auth::user()->id);

            return DataTables::of($data)
                ->editColumn('updated_at', function ($row) {
                    return $row['updated_at']->format('D, d/m/Y H:i:s');
                })->editColumn('foto', function ($row) {
                    $foto = $row->photo_path ? Storage::url("foto profil/{$row->photo_path}") : asset('img/avatar/avatar-3.png');
                    return '<div style="width:30px;height:30px;overflow:hidden;border-radius:50%"><img src="' . $foto . '" alt=""  style="width:30px;height:30px;object-fit:cover;"></div>';
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                        <div class="d-flex">
                        <form action="' . route('reset-password', $row['id']) . '" method="POST">
                        ' . csrf_field() . '

                            <button type="submit" class="btn btn-sm btn-light" onclick=" return confirm(\'Apakah anda Yakin?\') ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                  <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z"/>
                                  <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466"/>
                                </svg>
                            </button>
                        </form>

                        <a href="' . route('manage-user.edit', $row['id']) . '" class="btn btn-sm btn-light">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                          </svg>
                        </a>

                        <form action="' . route('manage-user.destroy', $row['id']) . '" method="POST">
                            ' . csrf_field() . '
                            ' . method_field('delete') . '

                          <button type="submit" class="btn btn-sm btn-light" onclick=" return confirm(\'Apakah anda Yakin?\') ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                              <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                            </svg>
                          </button>
                        </form>
                        </div>';
                })
                ->rawColumns(['action', 'foto'])
                ->make();
        }

        return view('admin.manage-user.index', ['type_menu' => 'manage-user']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.manage-user.form', ['type_menu' => 'manage-user']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // 'foto' => 'nullable|file|image|mimes:png,jpg|max:2048',
            'username' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required'
        ]);

        try {
            if (!User::create($validateData)) {
                return redirect()->route('manage-user.index')->with('error', 'Gagal menambah Pengguna');
            }

            return redirect()->route('manage-user.index')->with('success', 'Sukses menambah Pengguna');
        } catch (Exception $e) {
            return redirect()->route('manage-user.index')->with('error', 'Terjadi Kesalahan<br/>' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return redirect()->route('manage-user.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('manage-user.index')->with('error', 'Pengguna Tidak ditemukan');
        }
        return view('admin.manage-user.form', ['type_menu' => 'manage-user', 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $user = User::find($id);
        if (!$user) return redirect()->route('user.index')->with('error', 'Gagal mengubah data Pengguna');

        $validateData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // 'foto' => 'nullable|file|image|mimes:png,jpg|max:2048',
            // 'foto' => ['nullable', 'file', 'image', 'mimes:png,jpg', 'max:2048'],
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required'
        ]);

        // $validateData['password'] = $validateData['password'] != '' ? bcrypt($validateData['password']) : $user->password;

        try {

            // if($request->file('foto')){


            //     $foto = $request->file('foto');

            //     $namaFoto = Str::slug($validateData['name'] . " " . Str::random(4));
            //     $namaFoto .= $namaFoto . "." . $foto->getClientOriginalExtension();


            //     $foto->move('img/avatar', $namaFoto);

            //     //hapus old image
            //     Storage::disk('me')->delete('img/avatar/'.$user['foto']);

            //     $validateData['foto'] = $namaFoto;
            // }


            if (!$user->update($validateData)) {
                return redirect()->route('manage-user.index')->with('error', 'Gagal mengubah data Pengguna');
            }

            return redirect()->route('manage-user.index')->with('success', 'Sukses mengubah data Pengguna');
        } catch (Exception $e) {
            return redirect()->route('manage-user.index')->with('error', 'Terjadi Kesalahan<br/>' . $e->getMessage());
        }
    }

    // method untuk menyamakan password user dan username nua
    public function resetPassword($id)
    {
        try {
            $user = User::find($id);
            if (!$user) return redirect()->route('manage-user.index')->with('error', 'Pengguna Tidak ditemukan');
            $user->password = Hash::make($user['username']);
            $user->save();

            return redirect()->route('manage-user.index')->with('success', 'Reset Password Sukses');
        } catch (Exception $e) {
            return redirect()->route('manage-user.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);
            if (!$user) return redirect()->route('manage-user.index')->with('error', 'User tidak ditemukan');
            // hapus foto profil user
            if (Storage::disk('public')->exists('foto profil/' . $user['foto'])) {
                Storage::disk('public')->delete('foto profil/' . $user['foto']);
            }

            // hapus file surat pengantar dan file nilai magang jika ada
            if ($user->internship) {
                Storage::disk('public')->delete('surat pengantar/' . $user->internship->surat_pengantar);

                if (Storage::disk('public')->exists('nilai magang/' . $user->internship->nilai_magang)) {
                    Storage::disk('public')->delete('nilai magang/' . $user->internship->nilai_magang);
                }
            }

            $user->delete();

            return redirect()->route('manage-user.index')->with('success', 'Sukses menghapus');
        } catch (Exception $e) {
            return redirect()->route('manage-user.index')->with('error', 'Terjadi Kesalahan<br/>' . $e->getMessage());
        }
    }
}
