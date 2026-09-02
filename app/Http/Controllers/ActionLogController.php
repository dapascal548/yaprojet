<?php

namespace App\Http\Controllers;

use App\Models\ActionLog;
use Illuminate\Http\Request;

class ActionLogController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $logs = ActionLog::with('user')->latest()->paginate(20);
        return view('action-logs.index', compact('logs'));
    }
}
