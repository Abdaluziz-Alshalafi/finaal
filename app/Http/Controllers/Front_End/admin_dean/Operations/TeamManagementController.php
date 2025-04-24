<?php

namespace App\Http\Controllers\Front_End\admin_dean\Operations;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Topic;
use App\Models\Request as TeamRequest;
use App\Models\Project_supervisors;

class TeamManagementController extends Controller
{
    public function index()
    {
        $topics = Topic::where('status', 'acceptable')->get();
        $teachers = Teacher::all();
        return view('content.admin.admin_dean.Operations.teammanagement', compact('topics', 'teachers'));
    }

    public function search(Request $request)
    {
        $topics = Topic::where('status', 'acceptable')
            ->where('id', $request->search)
            ->get();
        return response()->json(['topics' => $topics]);
    }

    public function updateTopic(Request $request)
    {
        $topic = Topic::find($request->topic_id);
        $topic->sub1 = $request->sub1;
        $topic->describtion1 = $request->describtion1;
        $topic->save();
        return response()->json(['status' => 'success']);
    }

    public function deleteMember(Request $request)
    {
        TeamRequest::where('team_id', $request->team_id)
            ->where('student_id', $request->student_id)
            ->delete();
        return response()->json(['status' => 'deleted']);
    }

    public function addMember(Request $request)
    {
        $student = Student::where('Academic_number', $request->academic_number)->first();
        if (!$student) {
            return response()->json(['status' => 'not_found']);
        }

        TeamRequest::create([
            'student_id' => $student->id,
            'team_id' => $request->team_id,
            'status' => 'accepted',
        ]);

        return response()->json(['status' => 'added', 'student' => $student]);
    }

    public function updateSupervisor(Request $request)
    {
        Project_supervisors::updateOrCreate(
            ['team_id' => $request->team_id],
            ['id_teachers' => $request->teacher_id]
        );
        return response()->json(['status' => 'updated']);
    }

}