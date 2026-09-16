<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResumeController extends Controller
{
    public function index()
    {
        $resumes = Resume::where('user_id', auth()->id())->latest()->get();

        return view('resumes.index', compact('resumes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $path = $request->file('file')->store('resumes', 'public');

        Resume::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'file_path' => $path,
        ]);

        return redirect()->route('resumes.index')
            ->with('success', 'Resume uploaded.');
    }

    public function destroy(Resume $resume)
    {
        Storage::disk('public')->delete($resume->file_path);
        $resume->delete();

        return redirect()->route('resumes.index')
            ->with('success', 'Resume deleted.');
    }
}
