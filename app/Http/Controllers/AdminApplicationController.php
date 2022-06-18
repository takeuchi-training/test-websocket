<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminApplicationController extends Controller
{
    public function index() {
        $user = auth()->user();

        $applications = DB::table('departments')
            ->join('users', 'users.department_id', '=', 'departments.id')
            ->join('applications', 'applications.user_id', '=', 'users.id')
            ->selectRaw('applications.id, applications.title, applications.content, '
                    .'users.id as user_id, users.name as user_name, '
                    .'departments.id as department_id, departments.name as department_name, '
                    .'applications.status, applications.created_at')
            ->where('departments.id', $user->department_id)
            ->orderBy('applications.created_at', 'desc')
            ->get();

        return view('applications.admin.index', [
            'applications' => $applications
        ]);
    }

    public function show($applicationId) {
        $user = auth()->user();

        $application = DB::table('departments')
            ->join('users', 'users.department_id', '=', 'departments.id')
            ->join('applications', 'applications.user_id', '=', 'users.id')
            ->selectRaw('applications.id, applications.title, applications.content, '
                    .'users.id as user_id, users.name as user_name, '
                    .'departments.id as department_id, departments.name as department_name, '
                    .'applications.status, applications.created_at')
            ->where('departments.id', $user->department_id)
            ->where('applications.id', $applicationId)
            ->where('applications.status', 0)
            ->first();

        if ($application === null) {
            abort(403);
        }

        return view('applications.admin.show', [
            'application' => $application
        ]);
    }

    public function approve($applicationId) {
        $currentApplication = Application::find($applicationId);

        $currentApplication->update([
            'status' => 1
        ]);

        return redirect()->route('admin.applications.index');
    }

    public function deny($applicationId) {
        $currentApplication = Application::find($applicationId);

        $currentApplication->update([
            'status' => 2
        ]);

        return redirect()->route('admin.applications.index');
    }
}
