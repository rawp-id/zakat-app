<?php

namespace App\Http\Controllers;

use App\Models\Zakat;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ZakatController extends Controller
{
    public function index()
    {
        $zakats = Zakat::latest()->paginate(10);
        return view('zakats.index', compact('zakats'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->zakat()->count() > 0 && !$user->is_admin) {
            $zakat = $user->zakat()->first();
            return view('zakats.create', compact('zakat'));
        }
        return view('zakats.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'amount' => 'required|integer|min:0',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'part_of_zakat' => 'nullable|array',
            'image' => 'nullable|image|max:2048',
            // 'status' => 'required|in:pending,approved,rejected',
        ]);

        $user = Auth::user();

        if ($user->zakat()->count() > 0 && !$user->is_admin) {
            return redirect()->route('zakats.create')->with('error', 'Anda sudah mengajukan zakat.');
        }

        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }
        $data['part_of_zakat'] = json_encode($request->part_of_zakat);

        if (!$user->is_admin) {
            $data = array_merge($data, [
                'user_id' => $user->id,
            ]);
            // dd($data);
            Zakat::create($data);
            return redirect()->route('zakats.create')->with('success', 'Zakat berhasil ditambahkan.');
        }

        Zakat::create($data);

        return redirect()->route('zakats.index')->with('success', 'Zakat berhasil ditambahkan.');
    }

    public function show(Zakat $zakat)
    {
        return view('zakats.show', compact('zakat'));
    }

    public function edit(Zakat $zakat)
    {
        return view('zakats.edit', compact('zakat'));
    }

    public function update(Request $request, Zakat $zakat)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'amount' => 'required|integer|min:0',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'part_of_zakat' => 'nullable|array',
            'image' => 'nullable|image|max:2048',
            // 'status' => 'required|in:pending,approved,rejected',
        ]);

        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }
        $data['part_of_zakat'] = json_encode($request->part_of_zakat);

        $zakat->update($data);

        return redirect()->route('zakats.index')->with('success', 'Zakat berhasil diperbarui.');
    }

    public function destroy(Zakat $zakat)
    {
        $zakat->delete();
        return redirect()->route('zakats.index')->with('success', 'Zakat berhasil dihapus.');
    }

    // Menampilkan daftar zakat yang masih pending
    public function confirm()
    {
        $pendingZakats = Zakat::where('status', 'pending')->paginate(10);
        return view('zakats.confirm', compact('pendingZakats'));
    }

    // Proses ACC zakat
    public function approve($id)
    {
        $zakat = Zakat::findOrFail($id);
        $zakat->update(['status' => 'approved']);

        return redirect()->route('zakats.confirm')->with('success', 'Zakat telah disetujui.');
    }
}
