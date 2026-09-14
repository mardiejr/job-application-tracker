<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\Company;
use App\Models\Resume;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index()
    {
        $applications = JobApplication::where('user_id', auth()->id())
            ->with('company')
            ->latest()
            ->get();

        return view('applications.index', compact('applications'));
    }

    public function create()
    {
        $companies = Company::all();
        $resumes = Resume::where('user_id', auth()->id())->get();

        return view('applications.create', compact('companies', 'resumes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'resume_id' => 'nullable|exists:resumes,id',
            'position' => 'required|string|max:255',
            'status' => 'required|in:applied,interviewing,offer,rejected,withdrawn',
            'applied_date' => 'nullable|date',
        ]);

        $validated['user_id'] = auth()->id();

        JobApplication::create($validated);

        return redirect()->route('applications.index')
            ->with('success', 'Application added successfully.');
    }

    public function show(JobApplication $application)
    {
        $application->load('company', 'resume', 'notes');

        return view('applications.show', compact('application'));
    }

    public function edit(JobApplication $application)
    {
        $companies = Company::all();
        $resumes = Resume::where('user_id', auth()->id())->get();

        return view('applications.edit', compact('application', 'companies', 'resumes'));
    }

    public function update(Request $request, JobApplication $application)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'resume_id' => 'nullable|exists:resumes,id',
            'position' => 'required|string|max:255',
            'status' => 'required|in:applied,interviewing,offer,rejected,withdrawn',
            'applied_date' => 'nullable|date',
        ]);

        $application->update($validated);

        return redirect()->route('applications.index')
            ->with('success', 'Application updated successfully.');
    }

    public function destroy(JobApplication $application)
    {
        $application->delete();

        return redirect()->route('applications.index')
            ->with('success', 'Application deleted.');
    }
}