<?php

namespace App\Http\Controllers\Front_End\admin_teacher\Operations;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Request as RequestModel;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Team;
use App\Models\Cache;
use DB;

class ProjectController extends Controller
{
    public function index()
    {
        $topics = Topic::where('status', 'pending')->get()->groupBy('team_id');
        $acceptedTopics = Topic::where('status', 'accepted')->get()->groupBy('team_id');
        $rejectedTopics = Topic::where('status', 'rejected')->get()->groupBy('team_id');

        return view('content.admin.admin_teacher.Operations.projects', compact('topics', 'acceptedTopics', 'rejectedTopics'));
    }

    public function accept(Request $request)
    {
        $project = Topic::find($request->id);
        $project->status = 'accepted';
        $project->save();

        Topic::where('team_id', $project->team_id)
            ->where('id', '!=', $project->id)
            ->delete();

        return response()->json(['success' => true]);
    }

    public function reject(Request $request)
    {
        $project = Topic::find($request->id);
        $teamProjects = Topic::where('team_id', $project->team_id)->get();

        if ($teamProjects->count() == 1 && $request->has('reason')) {
            $project->status = 'rejected';
            $project->save();

            Cache::create([
                'team_id' => $project->team_id,
                'reason' => $request->reason
            ]);

            return response()->json(['rejected' => true]);
        }

        $project->status = 'rejected';
        $project->save();

        return response()->json(['rejected' => true]);
    }

    public function revert(Request $request)
    {
        $project = Topic::find($request->id);
        $project->status = 'pending';
        $project->save();

        return response()->json(['reverted' => true]);
    }
}