<?php

namespace App\Jobs;

use App\Mail\Delete_Or_SaveMail;
use App\Models\Team;
use App\Models\Topic;
use App\Models\Project_supervisors;
use App\Models\Request as ModelsRequest;
use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DeleteTeamsAfterDelay implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // protected $teamId;
    protected $teamId;
    // protected $status_Record;

    /**
     * إنشاء Job جديد
     */
    public function __construct($teamId)
    {
        $this->teamId = $teamId;
        // $this->status_Record = $status_Record;
    }


    public $tries = 3;

    /**
     * تنفيذ عملية الحذف بعد 48 ساعة
     */
    public function handle()

    {

        foreach ($this->teamId as $tmid) {
            $team = Team::with('requests.tea.student')->find($tmid);
            if (!$team) continue;

            $allRequestsBeforeDelete = $team->requests;

            // الطلبات اللي ما زالت موجودة بعد الحذف
            $remainingRequests = ModelsRequest::where('team_id', $tmid)->get();

            foreach ($allRequestsBeforeDelete as $request) {
                $student = optional($request->tea)->student;
                if (!$student) continue;

                $studentEmail = $student->email;
                $studentName  = $student->name;

                // الشرط الأول: الطلب لا يزال موجود؟
                // $requestStillExists = $remainingRequests->contains('id', $request->id);

                // الشرط الثاني: حالة الطلب pending أو accepted
                $statusValid = in_array($request->status, ['pending', 'accepted']);

                // الشرط النهائي: أحد الشرطين يكفي
                if (!$statusValid) {

    $status_Record = '  حذف مشروعك نظراً لعدم وجود طلب نشط أو حالة غير مؤهلة ';
                    $studentName = 'فارغ';
                    Topic::where('team_id', $tmid)->delete();
                    Project_supervisors::where('team_id', $tmid)->delete();
                    ModelsRequest::where('team_id', $tmid)->delete();
                    $team->delete();

                } else {
                    $status_Record = '  إلغاء عملية الحذف نظراً لانضمامك إلى مشروع الفريق ';
                    $requestStudent = optional($request->student);
                    $studentNameFromRequest = $requestStudent->name ?? 'طالب';


                 $studentName = $studentNameFromRequest;

                }
                 Mail::to($studentEmail)->queue(new Delete_Or_SaveMail($status_Record, $studentName));


            }

            }
            $this->deleteOldLoginLogs();
        }

    public function deleteOldLoginLogs()
{
    // حذف السجلات التي مر عليها أكثر من شهر
    // \App\Models\LoginLog::where('created_at', '<', \Carbon\Carbon::now()->subMonth())->delete();
    \App\Models\LoginLog::where('created_at', '<', \Carbon\Carbon::now()->subMinute())->delete();

}


    public function failed(\Exception $exception)
{
    Log::error("فشل تنفيذ المهمة: " . $exception->getMessage());
}
}
