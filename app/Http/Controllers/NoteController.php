<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function store(Request $request, JobApplication $application)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        $application->notes()->create($validated);

        return redirect()->route('applications.show', $application)
            ->with('success', 'Note added.');
    }

    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->back()
            ->with('success', 'Note deleted.');
    }
}
