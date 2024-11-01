<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Report;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'reportable_type' => 'required|string',
            'reportable_id' => 'required|integer',
            'reason' => 'required|string|max:255',
        ]);

        Report::create([
            'user_id' => auth()->id(),
            'reportable_type' => $request->input('reportable_type'),
            'reportable_id' => $request->input('reportable_id'),
            'reason' => $request->input('reason'),
        ]);

        return back()->with('message', 'تم تقديم التبليغ بنجاح');
    }
}
