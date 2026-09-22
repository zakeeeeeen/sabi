<?php

namespace App\Http\Controllers\Admin;

use App\Models\StudentSubmission;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends AdminController
{
    public function index(Request $request)
    {
        $search = $request->query('q');

        $query = User::where('is_admin', 0)->withCount('submissions');

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'search' => $search,
        ]);
    }

    public function resetProgress($id)
    {
        $user = User::where('is_admin', 0)->findOrFail($id);
        StudentSubmission::where('user_id', $user->id)->delete();

        return back()->with('status', "Progres belajar untuk siswa '{$user->name}' berhasil direset.");
    }

    public function destroy($id)
    {
        $user = User::where('is_admin', 0)->findOrFail($id);
        StudentSubmission::where('user_id', $user->id)->delete();
        $user->delete();

        return back()->with('status', "Data siswa '{$user->name}' berhasil dihapus.");
    }
}
