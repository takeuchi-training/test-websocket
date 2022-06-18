<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index() {
        $applications = Application::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('applications.index', [
            'applications' => $applications
        ]);
    }

    public function store(Request $request) {
        $newApplication = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        Application::create([
            'title' => $newApplication['title'],
            'content' => $newApplication['content'],
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('applications.index');
    }

    public function update(Request $request, $applicationId) {
        $newApplication = $request->Validate([
            'title' => 'nullable|string',
            'content' => 'nullable|string',
        ]);
        $currentApplication = Application::find($applicationId);

        $currentApplication->update([
            isset($newApplication['title']) ? $newApplication['title'] : $currentApplication->title,
            isset($newApplication['content']) ? $newApplication['content'] : $currentApplication->content,
        ]);

        return redirect()->route('applications.index');
    }

    public function destroy($applicationId) {
        Application::destroy($applicationId);
        return redirect()->route('applications.index');
    }
}
