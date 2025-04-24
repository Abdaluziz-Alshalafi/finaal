<?php

namespace App\Http\Controllers\Front_End\student;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResearchRequest;
use App\Mail\RequestStatusMail;
use App\Mail\TeamAddedMail;
use App\Models\Project_supervisors;
use App\Models\Request as ModelsRequest;
use App\Models\Research;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Team;
use App\Models\Tempresearchs;
use App\Models\Topic;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB; // تأكد من استيراد واجهة DB
use PHPUnit\Framework\Constraint\Count;

use function Laravel\Prompts\alert;
use function Laravel\Prompts\error;
use function PHPUnit\Framework\isEmpty;

class temp_Add_projectController extends Controller
{
    // private $universityId = Auth::guard('students')->user();
    private $universityId;

    public function __construct()
    {
        // تخزين بيانات المستخدم المسجل في الخاصية
        $this->universityId = Auth::guard('students')->user();
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         //
    }
    // $academic = array_map(function($id){
    // return Student::where('Academic_number', $id)->first();
    // },$academicNumber);
    //  dd($academic);
    //  dump($academic);


    /**
     * Store a newly created resource in storage.
     */



    public function show_create()
    {
        $teachers = Teacher::where('id_university', Auth::guard('students')->user()->id_university)->get();

        // return response()->json(Auth::guard('students')->user());
        // dd(Auth::guard('students')->user()->id_university);
        return view('content.students.Operations.pg_create_project', compact('teachers'));
    }


    public function researcher_accepted(Request $request,$requestId){
        $researcher = ModelsRequest::where('id', $requestId)->firstOrFail();
        $researcher->status = 'accepted';
        $researcher->save();
        return redirect()->route('confirmation.page')->with('success', 'تم قبول الطلب بنجاح!');

    }
    public function researcher_rejected(Request $request,$requestId){
        $researcher = ModelsRequest::where('id', $requestId)->firstOrFail();
        $researcher->status = 'rejected';
        $researcher->save();
        return redirect()->route('confirmation.page')->with('success', 'تم رفض الطلب !');

    }


    public function store(Request $request)
    {
        // $request->validate([
        //     // 'name_admin' => 'required|exists:teacher,teacher.id_university',
        //     'name_admin' => 'required',


        //     'research_name' => 'required|string',
        //     'research_description' => 'required|string',
        //     'students.*.id_academic' => 'required|string',
        // ]);


        //     $team = Team::find($id); // استبدل $id بالمعرف الصحيح
        // $topics = $team->topics; // هذا سيعيد جميع المواضيع المرتبطة بالفريق


        // لتحسين الأداء، يمكنك استخدام التحميل المتقدم لتحميل المواضيع مع الفريق:

        // $teams = Team::with('topics')->get();



        $request->validate([
            'research_name' => 'required|array',
            'research_name.*' => 'string|max:255|distinct', // لا يسمح بتكرار اسم البحث
            'name_admin' => 'required|array', // تأكد من أن الحقل هو مصفوفة
            'name_admin.*' => 'exists:teachers,id', // تحقق من وجود المشرفين في قاعدة البيانات
            'students.*.name_student' => 'required|string|max:255',
            'research_description' => 'required|array',
            'research_description.*' => 'string|distinct', // لا يسمح بتكرار وصف البحث

            'students.*.id_academic' => 'required|numeric|digits:10|distinct', // لا يسمح بتكرار الرقم الأكاديمي
        ], [
            'research_name.*.distinct' => 'لا يمكنك تكرار نفس اسم البحث أكثر من مرة.',
            'research_description.*.distinct' => 'لا يمكنك تكرار نفس وصف البحث أكثر من مرة.',
            'students.*.id_academic.distinct' => 'لا يمكنك إدخال نفس الرقم الأكاديمي أكثر من مرة.',

            // 'name_admin' => 'required',

        ]);














        $randomGroupId = random_int(1000, 9999); // توليد رقم عشوائي بين 1000 و 9999



        $admin_number = $request->input('name_admin');
        $selectedAdmins = $request->input('name_admin'); // هذا سيكون مصفوفة تحتوي على IDs المشرفين

        $academicNumbers = $request->input('students.*.id_academic');

        $research_name = $request->input('research_name');
        //
        $research_description = $request->input('research_description');
        $missingAcademicNumbers = [];
        $students = [];
        $s = [];



        if(Count($academicNumbers) === 1){
            return response()->json([
                'status' => 'error',
                'message' =>' لايمكن ان تكون في المشروع بمفرك'
            ], 422);
            //  return redirect()->back()->withErrors(['id_academic' =>  ]);

        }
        $count_project= Team::where('id_student',$this->universityId->id)->count();


        if($count_project >= 1){
            return redirect()->back()->withErrors([$this->universityId->name . ' لايمكن ان يكون لديك اكثر من 1 مشاريع ']);


       }
        // dd($academicNumbers);

        // if($academicNumbers)


        if (!$this->universityId) {
            return redirect()->route('login_student')->withErrors(['error' => 'يجب تسجيل دخولك أولاً.']);
        }



        // dd($existingAcademicNumbers);


        // dd($academicNumbers);
        // dd($research_name);
        // dd($research_description);



        foreach ($selectedAdmins as $adminId) {
            $admin = Teacher::find($adminId); // احصل على معلومات المشرف
            // echo 'المشرف المختار: ' . $admin->name . '<br>';
            $ssss[] = $admin;

            // طباعة اسم المشرف
        }

        if (empty($ssss)) {
            return redirect()->back()->withErrors(['id_academic' => '. '  . ' اختر مشرف واحد علئ الاقل']);
        }



        // استخدام whereIn لجلب الطلاب الموجودين في الجامعة الحالية دفعة واحدة

        $allStudentsInUniversity = Student::where('id_university', $this->universityId->id_university)
        ->whereIn('Academic_number', $academicNumbers)
        ->get();
        $existingAcademicNumbers = $allStudentsInUniversity->pluck('Academic_number')->toArray();


        foreach ($academicNumbers as $id) {
            if (in_array($id, $existingAcademicNumbers)) {
                $students[] = $allStudentsInUniversity->where('Academic_number', $id)->first();
            } else {
                $missingAcademicNumbers[] = $id;
            }

            // dd($missingAcademicNumbers);
        }


//         // إذا كان هناك أرقام أكاديمية مفقودة في الجامعة الحالية
if (!empty($missingAcademicNumbers)) {
            // return redirect()->back()->withErrors(['id_academic' => 'الطلاب برقم أكاديمي: ' . implode(', ', $missingAcademicNumbers) . ' غير موجودين في جامعتك.']);
            return response()->json([
                'success' => false,
                'message' => 'الطالب ليس في نفس الجامعة.'
            ]);

        }


        // تحقق مما إذا كان الرقم الأكاديمي غير موجود في أي جامعة
        $allStudents = Student::whereIn('Academic_number', $academicNumbers)->get();
        $allExistingAcademicNumbers = $allStudents->pluck('Academic_number')->toArray();
        $nonExistentAcademicNumbers = array_diff($academicNumbers, $allExistingAcademicNumbers);

        // إذا كان هناك أرقام أكاديمية غير موجودة في أي جامعة
        if (!empty($nonExistentAcademicNumbers)) {
            // return redirect()->back()->withErrors(['id_academic' => 'الطلاب برقم أكاديمي: ' . implode(', ', $nonExistentAcademicNumbers) . ' غير موجودين في أي جامعة.']);
            return response()->json([
                'success' => false,
                'message' => 'الطالب غير موجود في قاعدة البيانات.'
            ]);
        }




        // تحقق من الأرقام الأكاديمية المفقودة


        // تأكد من أن $students هو مصفوفة
        // $studentsIds = array_column($students, 'id'); // استخدم array_column لجمع معرفات الطلاب

        // // تحقق من وجود مشاريع للطلاب
        // $studentsWithProjects = Tempresearchs::whereIn('id_student', $studentsIds)
        //                                       ->orWhereIn('id_student', Research::select('id_student')->whereIn('id_student', $studentsIds))
        //                                       ->get();

        // if ($studentsWithProjects->isNotEmpty()) {
        //     $studentsWithProjectNames = $studentsWithProjects->pluck('student_names')->toArray();
        //     return redirect()->back()->withErrors(['id_academic' => 'الطلاب: ' . implode(', ', $studentsWithProjectNames) . ' لديهم مشاريع بالفعل.']);
        // }
        // $cacheKey = 'temp_research_' . $student->id; // مفتاح التخزين المؤقت باستخدام الرقم العشوائي

        // إضافة الطلاب إلى التخزين المؤقت




        // $ss = [];
        // foreach ($students as $student) {
        //     // مفتاح التخزين المؤقت باستخدام الرقم العشوائي
        //     $tempResearch = Cache::get($student->id);

        //     if (!$tempResearch) { // إذا لم تكن البيانات موجودة في التخزين المؤقت

        //         $ss[] = $student;
        //      }
        //     else {

        //         $s[] = $student->name;
        //     }
        // }

        // if (!empty($s)) {
        //      return redirect()->back()->withErrors(['id_academic' => 'الطلاب: ' . implode(', ', $s) . ' لديهم مشاريع بالفعل.']);
        // }



        // foreach ($ss as $asa) {
        //     $cacheKey = $asa->id;

        //     Cache::put($cacheKey, [
        //         'id_student' => $asa->id,
        //         'research_name' => $research_name,
        //         'research_description' => $research_description,
        //         'approved' => 0, // 0 تعني "معلق"
        //         'group_id' => $randomGroupId, // إضافة رقم المجموعة
        //     ], 60 * 60 * 24 * 7); // التخزين المؤقت لمدة أسبوع

        //     // session()->flash('success', 'تمت العملية بنجاح!');

        // }




        // dd($research_description);




        $ss_accept = [];
        $s_student = [];
        $s_email=[];
        $s_user_de_AR =[];
        $without_user =[];
$missingAcademic = []; // تأكد من تهيئتها
$st = []; // تأكد من تهيئتها

foreach ($students as $student) {
    // الحصول على الطلبات المقبولة للطالب الحالي
    $tempResearch = ModelsRequest::where('student_id', $student->id)
        ->where('status', 'accepted')
        ->get();


    // الحصول على الحالة
    $existingAcademicNumbersss = $tempResearch->pluck('status')->toArray();

    // تحقق مما إذا كانت حالة الطالب موجودة في الطلبات المقبولة
    if (in_array('accepted', $existingAcademicNumbersss)) {
        // إذا كان هناك طلب مقبول، أضف إلى $st
        $ss_accept[] = $student->name; // أو أي معلومات أخرى تحتاجها
    } else {
        // إذا لم يكن هناك طلب مقبول، أضف إلى $missingAcademicNumbers
        $missingAcademic [] = $student->id; // أو أي معلومات أخرى تحتاجها
        $s_student[] = $student;
        $s_email[]=$student->email;
        $s_user_de_AR[] = $student;
    }


// إذا كان هناك أخطاء، ارجع برسالة








            // if (!$ss_accept) { // إذا لم تكن البيانات موجودة في التخزين المؤقت


            // }
            // else {

            //     $s_user_de_AR[] = $student->name;
            // }
        }
        // dd($ss_accept);
         if (!empty($ss_accept)) {
            return redirect()->back()->withErrors(['id_academic' => ' الطلاب: ' . implode(', ', $ss_accept) . ' لقد وافق علئ مشروع في فريق اّخر ']);
        }

        if (!empty($s_user_de_AR)) {
            array_shift($s_user_de_AR);
            $without_user =$s_user_de_AR;
        }
        else{
            return redirect()->back()->withErrors(['id_academic' => 'في تمرير الطلاب : ' . ' يوجد خطاء ']);

        }






        // dd($tempResearch);

        // dd($s);

        $researchTitless =[];


        if (!empty($s_student)) {
            DB::beginTransaction(); // بدء المعاملة
            try {
                // حاول إنشاء سجل في Team أولاً
                $team = Team::create([
                    'id_student' => $this->universityId->id,
                ]);

                $i = $team->id; // الآن $i يحتوي على معرف الفريق

                    // $team->users()->attach($q->id, ['id_team' => $i]);

                $teacher =[];
                foreach($ssss as $q){

                    $teacher[]=[
                        'id_teachers' => $q->id,
                        'team_id' => $i,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if (!empty($i)) {
                     $topics = [];
                    foreach ($research_name as $index => $name) {
                        $topics[] = [
                            'team_id' => $i,
                            'sub1' => $name,
                            'describtion1' => $request->input('research_description')[$index],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }

                     $reque = [];
                    foreach ($without_user as $asa) {
                        if (!empty($asa->id)) {
                            $reque[] = [
                                'student_id' => $asa->id,
                                'team_id' => $i,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                                        $researchTitless []=$request->input('research_description')[$index];
    }
                    }

                    ModelsRequest::insert($reque);
                     Project_supervisors::insert($teacher);
                    Topic::insert($topics);
                     DB::commit();

                    foreach($without_user as $q){

                        // dd($q);
                        $ids= ModelsRequest::where('student_id', $q->id)
                        ->where('team_id', '=',$i )
                        ->firstOrFail();
                                        //  Mail::to($q)->queue(new RequestStatusMail('Abdaulziz', $researchTitless, 'اشعار اضافه',1));
                                         Mail::to($q->email)->queue(new TeamAddedMail(
                                            $q->name,
                                            $this->universityId->name,

                                            $research_name,
                                            $research_description,
                                            null,$ids
                                        ));
                    }
                    return redirect()->back()->with('success', 'تم إنشاء الفريق والمواضيع بنجاح!');
                } else {
                    DB::rollBack();
                    return redirect()->back()->withErrors(['error' => 'يوجد خطأ في البيانات.']);
                }
            } catch (QueryException $e) {
                DB::rollBack();
                return redirect()->back()->withErrors(['error' => 'حدث خطأ أثناء حفظ البيانات: ' . $e->getMessage()]);
            }
        }


        // رسالة نجاح


        // رسالة نجاح

if (!empty($errors)) {
            return redirect()->back()->withInput($request->all())->withErrors($errors);
        }
        // عندما يوافق المشرف

            // session()->flash('success', 'تمت العملية بنجاح!');

        // رسالة نجاح
        return redirect()->back();




    }


    // function approveResearch($studentId)
    // {
    //     $cacheKey = 'temp_research_' . $studentId;
    //     $tempResearch = Cache::get($cacheKey);

    //     if ($tempResearch && $tempResearch['status'] === 1) { // إذا كانت القيمة 1
    //         // حفظ البيانات في جدول researchs
    //         Research::create([
    //             'id_student' => $studentId,
    //             'research_name' => $tempResearch['research_name'],
    //             'research_description' => $tempResearch['research_description'],
    //             'approved' => $tempResearch['approved'],
    //             'group_id' => $tempResearch['group_id'],
    //         ]);
    //         // حذف من التخزين المؤقت بعد الاعتماد
    //         Cache::forget($cacheKey);
    //     }
    // }

    // // عندما يرفض المشرف أو تنتهي المدة
    // function rejectOrExpireResearch($studentId)
    // {
    //     $cacheKey = 'temp_research_' . $studentId;
    //     $tempResearch = Cache::get($cacheKey);

    //     if ($tempResearch) {
    //         // إذا كانت القيمة 0 أو انتهت المدة (يمكن أن تضيف شرطاً للتحقق من الوقت)
    //         Cache::forget($cacheKey); // حذفها من التخزين المؤقت
    //     }
    // }

    // دالة إضافية لإعادة التحميل
    public function checkStudent(Request $request)
{
    try {
        $academicId = $request->input('id_academic');
        $universityId = $this->universityId->id_university; // معرف الجامعة الحالية
        $univdepart = $this->universityId->depart;
        if (!$academicId) {
            return response()->json(['error' => 'الرقم الأكاديمي مطلوب'], 400);
        }

        // البحث عن الطالب فقط داخل نفس الجامعة
        $student = Student::where('id_university', $universityId)
                          ->where('academic_number', $academicId)
                          ->first();


        if ($student) {

            $student_deprt= $student->depart === $univdepart;
            if($student_deprt){
                return response()->json([
                    'exists' => true,
                    'name' => $student->name
                ]);
            }
            // الطالب موجود في نفس الجامعة
            return response()->json([
                'exists' => false,
                'message' => 'الطالب في كليه أخرى'
            ]);
        } else {
            // لم يتم العثور على الطالب في هذه الجامعة
            return response()->json([
                'exists' => false,
                'message' => 'لا يوجد طالب بهذا الرقم الأكاديمي في جامعتك، قد يكون من جامعة أخرى.'
            ]);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


    public function getStudentData(Request $request)
    {
        $request->validate([
            'students.*.id_academic' => 'required|string|',
        ]);

        $idAcademic = $request->input('id_academic');
        $student = Student::where('Academic_number', $idAcademic)->first();

        if ($student) {

            return response()->json($student);
        }

        return response()->json(['message' => 'لا يوجد طالب بهذا الرقم الأكاديمي.'], 404);
    }
    /**
     * Display the specified resource.
     */
    public function show(Tempresearchs $temp_Research)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tempresearchs $temp_Research)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tempresearchs $temp_Research)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tempresearchs $temp_Research)
    {
        //
    }
}
