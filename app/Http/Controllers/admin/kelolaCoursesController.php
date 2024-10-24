<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class kelolaCoursesController extends Controller
{
    public function kelolacourses()
    {
        $courses = Course::all();
        return view('admin.kelolacourses', compact('courses'));
    }

    /**
     * Simpan course baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'course' => 'required|string|max:255',
        ]);

        Course::create([
            'course' => $request->course,
        ]);

        return redirect()->route('kelolacourses')->with('success', 'Course berhasil ditambahkan.');
    }

    /**
     * Update course
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'course' => 'required|string|max:255',
        ]);

        $course = Course::findOrFail($id);
        $course->update([
            'course' => $request->course,
        ]);

        return redirect()->route('kelolacourses')->with('success', 'Course berhasil diupdate.');
    }

    /**
     * Hapus course
     */
    public function delete($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('kelolacourses')->with('success', 'Course berhasil dihapus.');
    }
}
