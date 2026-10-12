<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    /**
     * Display a listing of system audit logs.
     */
    public function index(Request $request): View
    {
        $logs = AuditLog::with('user')
            ->latest()
            ->paginate(25);

        return view('admin.audit.index', [
            'logs' => $logs,
        ]);
    }
}
