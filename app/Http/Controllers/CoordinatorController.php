<?php
namespace App\Http\Controllers;
use App\Models\Report;
use App\Models\School;
use App\Models\Sppg;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class CoordinatorController extends Controller
{
    public function dashboard() {
        $stats = [
            'total' => Report::count(),
            'pending' => Report::where('status','belum_diperiksa')->count(),
            'reviewed' => Report::where('status','diperiksa')->count(),
            'users' => User::where('role','user')->count(),
            'admins' => User::where('role','admin')->count(),
        ];
        $reports = Report::with(['user','school','sppg'])->latest()->paginate(8);
        return view('dashboard.coordinator', compact('stats','reports'));
    }
    public function users() { $users = User::orderBy('name')->paginate(15); return view('coordinator.users', compact('users')); }
    public function updateRole(Request $request, User $user) {
        abort_if($request->user()->is($user), 403, 'Anda tidak dapat mengubah role akun sendiri.');
        $data = $request->validate(['role' => ['required', Rule::in(['user','admin','coordinator'])]]);
        $user->update($data);
        return back()->with('success', 'Role akun berhasil diperbarui.');
    }
    public function distributions() {
        $schools = School::with('sppgs')->orderBy('name')->get();
        $sppgs = Sppg::orderBy('name')->get();
        return view('coordinator.distributions', compact('schools','sppgs'));
    }
    public function storeSchool(Request $request) {
        $data = $request->validate(['name'=>['required','string','max:255','unique:schools,name'],'address'=>['nullable','string','max:255']]);
        School::create($data); return back()->with('success','Sekolah berhasil ditambahkan.');
    }
    public function storeSppg(Request $request) {
        $data = $request->validate(['name'=>['required','string','max:255'],'code'=>['nullable','string','max:100','unique:sppgs,code'],'address'=>['nullable','string','max:255']]);
        Sppg::create($data); return back()->with('success','SPPG berhasil ditambahkan.');
    }
    public function syncDistribution(Request $request, School $school) {
        $data = $request->validate(['sppg_ids'=>['nullable','array'],'sppg_ids.*'=>['integer','exists:sppgs,id']]);
        $school->sppgs()->sync($data['sppg_ids'] ?? []);
        return back()->with('success','Daftar SPPG untuk sekolah berhasil diperbarui.');
    }
}
