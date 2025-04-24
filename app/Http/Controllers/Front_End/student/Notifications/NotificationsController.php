<?php

namespace App\Http\Controllers\Front_End\student\Notifications;


use App\Http\Controllers\Controller;
use App\Mail\RequestAcceptedMail;
use App\Models\Project_supervisors;
use Illuminate\Http\Request;
use App\Models\Request as ModelsRequest;
use App\Models\Student;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
 use App\Mail\RequestStatusMail;
use App\Models\Topic;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Jobs\DeleteTeamsAfterDelay;
use Carbon\Carbon;







class NotificationsController extends Controller
{
    //
    public function index22(Request $request, $id){


        return $id;


    }

    public function index()
    {
        $currentUser = Auth::guard('students')->user();
        $modelrequest = ModelsRequest::where('student_id', $currentUser->id)->get();

        // $modelrequest = ModelsRequest::where('student_id', $currentUser->id)
        // ->with(['topics', 'supervisors.teacher'])
        // ->get();

        return view('content.students.Notifications.Notification_student', compact('modelrequest'));
    }



    //     return redirect()->back()->withErrors(['' => 'لم يتم العثور على الطالب']);


    public function update_request_status(Request $request, $id)
    {



        $requestModel = ModelsRequest::findOrFail($id);

        $student = $requestModel->student;

        $studentId = Team::where('id', $requestModel->team_id)->value('id_student');
        $studentEmail = Student::where('id', $studentId)->value('email');
        $topics = $requestModel->topics;

                            $researchTitless = $topics->isNotEmpty() ? $topics->pluck('sub1') : ["غير متوفر"];

                            // $studentsNotAcceptedCount = ModelsRequest::where('team_id', $requestModel->team_id)
                            // ->where('status', '==', 'pending') // الطلاب الذين لم يتم قبولهم
                            // ->count();



        if ($request->action === 'accepted') {

            if ($requestModel->status === 'pending') {

                $status = 'accepted';




                $existingProject = Team::where('id_student', $requestModel->student_id)->exists();

                // $ers = ModelsRequest::where('student_id', $requestModel->student_id)->
                // where('team_id','!=',$requestModel->team_id)->
                // value('team_id');


                if ($existingProject) {


                    // $team = Team::findOrFail($id);
                     $teamIds = Team::where('id_student', $requestModel->student_id)->pluck('id');

                    Topic::whereIn('team_id', $teamIds)->delete();
                    Project_supervisors::whereIn('team_id', $teamIds)->delete();
                    ModelsRequest::whereIn('team_id', $teamIds)->delete();
                     Team::whereIn('id', $teamIds)->delete();
                }

                $requestModel->status = $status;
                $requestModel->save();

                $teamIdsss = ModelsRequest::where('student_id', $requestModel->student_id)
                ->where('team_id','!=',$requestModel->team_id)
                ->pluck('team_id')
                ->unique();

                ModelsRequest::where('student_id', $requestModel->student_id)
                ->where('id', '!=', $requestModel->id)
                ->update(['status' => 'rejected']);


                $teamIdsToDelete = [];
                foreach ($teamIdsss as $teamIdas) {
                                 $coun_requst=ModelsRequest::where('team_id', $teamIdas)->count();

                    if ($coun_requst === 1) {
                        $teamIdsToDelete[] = $teamIdas;

                    }
                    elseif($coun_requst > 1){
                        ModelsRequest::where('student_id', $requestModel->student_id)
                ->where('id', '!=', $requestModel->id)
                ->delete();

                    }
                }

                if (!empty($teamIdsToDelete)) {
                    // تمرير مجموعة team_id
                    $this->alrte_email($teamIdsToDelete);

                    // DeleteTeamsAfterDelay::dispatch($teamIdsToDelete)->delay(now()->addMinutes(1));


                    // $team = Team::with('student')->find($teamIdsToDelete);


                    //     // $topics = $team->topics;
                //     // $researchTitler = $topics->isNotEmpty() ? $topics->pluck('sub1') : ["غير متوفر"];
                    // $red = ' ا '.$studentas->name .'قد وافق علئ مشروع أخر سيتم حذف المشروع بعد 48 ساعه اذ لم تضيف طالب ';

                // // Mail::to($studentas->email)->queue(new RequestStatusMail($student->name, $researchTitler, $red,'وافق علئ مشروع أخر'));

                        // if ($team && $team->id_student) {
                                // $studentas = Student::find($team->pluck('id_student'));



                                $teams = Team::with('requests.tea.student', 'topics')->find($teamIdsToDelete);

                                foreach ($teams as $team) {
                                    $researchTitles = $team->topics->pluck('sub1');
                                    $researchTitles = $researchTitles->isNotEmpty() ? $researchTitles : ['غير متوفر'];

                                    foreach ($team->requests as $request) {
                                        $student = optional($request->tea)->student;

                                        if (!$student) {
                                            continue;
                                        }

                                        $studentNamess  = $request->student->name;
                                        $studentEmailss = $student->email;

                                        $message =$studentNamess ;

                                        Mail::to($studentEmailss)->queue(new RequestStatusMail(
                                            $studentNamess,
                                            $researchTitles,
                                            $message,
                                            'وافق علئ مشروع أخر'
                                        ));
                                    }
                                }



                            // if ($studentas && $studentas->email) {



                                // Log::info("📧 تم إرسال إيميل إلى الطالب:", [
                                //     'name' => $student->name,
                                //     'email' => $student->email,
                                //     'team_id' => $teamIdas
                                // ]);
                            // }

                        // }

}










                    // Mail::to('com775527735@gmail.com')->queue(new RequestStatusMail($student->name, $researchTitless, 'accepted'));
                //  $status = 'accepted'; // مثال على الحالة
                $studentsNotAcceptedCount = ModelsRequest::where('team_id', $requestModel->team_id)
                ->where('status', '!=', 'accepted') // الطلاب الذين لم يتم قبولهم
                ->count();
                // إرسال البريد باستخدام Queue
                Mail::to($studentEmail)->queue(new RequestStatusMail($studentNamess, $researchTitless, $status,$studentsNotAcceptedCount));


                   return response()->json(['message' => 'تم قبول البحث وحذف الطلبات الأخرى!']);
            }
            else {
                return response()->json(['message' => 'يوجد خطأ في البيانات!'], 400);
            }
        }
        elseif ($request->action === 'rejected') {
            if ($requestModel->status !== 'rejected') {
                $requestModel->status = 'rejected';
                $requestModel->save();



                $studentsNotAccepted = ModelsRequest::where('team_id', $requestModel->team_id)
                ->whereIn('status', ['pending', 'accepted']) // يجلب الطلاب الذين حالتهم "pending" أو "accepted"
                ->count();


                if($studentsNotAccepted === 0){
                    $cont ='';
                    // $teamIds = Team::where('id', $requestModel->team_id)->value('id');
                    // $teamIds = Team::where('id_student', $requestModel->student_id)->pluck('id');

                     $this->alrte_email($requestModel->team_id);

                    // جدولة الحذف بعد 48 ساعة (يومين)
                    // DeleteTeamsAfterDelay::dispatch($teamIds)->delay(now()->addHours(1));
                    // DeleteTeamsAfterDelay::dispatch($teamIds)->delay(Carbon::now()->addHours(1));
                    // DeleteTeamsAfterDelay::dispatch($teamIds)->delay(now()->addMinutes(3));

                    // DeleteTeamsAfterDelay::dispatch($teamIds)->delay(now()->addMinutes(1));

                    // DeleteTeamsAfterDelay::dispatch($requestModel->team_id);


                    $cont = ' سيتم حذف المشروع بعد 48 ساعه اذ لم تضيف طالب ';
                }
                else{
                    $cont ='مرفوض';
                    }
                     Mail::to($studentEmail)->queue(new RequestStatusMail($student->name, $researchTitless, $cont , $studentsNotAccepted));

                return response()->json(['message' => 'لقد قمت برفض المشاركة في المشروع!']);
            } else {
                return response()->json(['message' => 'يوجد خطأ في البيانات!'], 400);
            }
        }
        return response()->json([
            'message' => 'لم يتم تنفيذ أي عملية.'
        ], 400);

     }
            /**
         * ترسل Job لحذف الفريق (أو مجموعة فرق) بعد وقت معين
         *
         * @param int|array $team_id
         */
        public function alrte_email($team_id)
        {
            DeleteTeamsAfterDelay::dispatch($team_id)->delay(now()->addMinutes(1));
        }





        public function show_create_student_project()
        {
            // جلب الطلبات مع بيانات الطالب، البحث، والمشرفين
            $modelrequest = ModelsRequest::with(['tea.student', 'topic', 'supervisors.teacher'])->get();
            return view('content.students.Operations.pg_create_project', compact('modelrequest'));
        }
}

