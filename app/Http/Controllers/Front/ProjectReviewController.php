<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProjectReview;
use App\Models\Project;
use Auth;

class ProjectReviewController extends Controller
{
    public function store(Request $request, $projectId)
    {
        $request->validate([
            'professionalism' => 'required|integer|min:1|max:5',
            'communication' => 'required|integer|min:1|max:5',
            'quality' => 'required|integer|min:1|max:5',
            'expertise' => 'required|integer|min:1|max:5',
            'timeliness' => 'required|integer|min:1|max:5',
            'would_work_again' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $project = Project::findOrFail($projectId);

         // التأكد من أن التقييم لم يُقدّم مسبقاً
         $existingReview = ProjectReview::where('project_id', $projectId)
         ->where('client_id', Auth::id())
         ->first();

        if ($existingReview) {
            return response()->json(['message' => 'لقد قمت بتقييم هذا المشروع مسبقاً.'], 400);
        }


        ProjectReview::create([
            'project_id' => $projectId,
            'user_id' => $project->bids->first()->user_id, // المستخدم الذي تم تقييمه
            'client_id' => auth()->id(), // صاحب المشروع
            'professionalism' => $request->professionalism,
            'communication' => $request->communication,
            'quality' => $request->quality,
            'expertise' => $request->expertise,
            'timeliness' => $request->timeliness,
            'would_work_again' => $request->would_work_again,
            'comment' => $request->comment,
        ]);

        return response()->json(['message' => 'تم إضافة التقييم بنجاح!']);

    }


    // عرض التقييمات للمشروع
    public function show($projectId)
    {
        $project = Project::findOrFail($projectId);

        $reviews = $project->reviews()->with('user')->get();

        return response()->json(ProjectReviewResource::collection($reviews));
    }
}
