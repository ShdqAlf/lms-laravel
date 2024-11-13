<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\JadwalKegiatan;
use Auth;

use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function dashboard()
    {
        $courses = Course::all();
        $user = auth()->user();

        // Modify query to include the user's name and role
        $eventsQuery = JadwalKegiatan::select(
            'deskripsi_kegiatan as title',
            'tanggal_kegiatan as start',
            'user_id'
        )->with('user:id,nama,role'); // Assuming 'nama' and 'role' fields exist in the 'users' table

        if ($user->role === 'guru') {
            $events = $eventsQuery->get()->map(function ($event) {
                // Assign color based on the user's role
                $event->color = $event->user->role === 'guru' ? 'blue' : 'green';
                return $event;
            })->toArray();
        } else {
            $events = $eventsQuery->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('user', function ($query) {
                        $query->where('role', 'guru');
                    });
            })->get()->map(function ($event) {
                // Assign color based on the user's role
                $event->color = $event->user->role === 'guru' ? 'blue' : 'green';
                return $event;
            })->toArray();
        }

        return view('dashboard.dashboard', compact('courses', 'events'));
    }



    public function storeEvent(Request $request)
    {
        // Validate the input
        $request->validate([
            'deskripsi_kegiatan' => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
        ]);

        // Store the new event
        JadwalKegiatan::create([
            'user_id' => auth()->id(), // Ensure the user is authenticated
            'deskripsi_kegiatan' => $request->deskripsi_kegiatan,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
        ]);

        // Redirect back with a success message
        return redirect()->route('dashboard')->with('success', 'Kegiatan berhasil ditambahkan.');
    }
}
