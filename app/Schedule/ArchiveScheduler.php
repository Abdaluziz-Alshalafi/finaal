<?php

namespace App;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class ArchiveScheduler extends Command
{
    /**
     * اسم الأمر.
     *
     * @var string
     */
    protected $signature = 'archive:scheduler'; // اسم الأمر الذي سيظهر في الجدولة

    /**
     * وصف الأمر.
     *
     * @var string
     */
    protected $description = 'أرشفة وحذف البيانات القديمة من جدول login_logs';

    /**
     * إنشاء الكائن الجديد.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * تنفيذ الأمر.
     *
     * @return void
     */
    public function handle()
    {
        // تحديد التاريخ الذي مر عليه أكثر من شهر
        $dateLimit = Carbon::now()->subMonth();

        // حذف السجلات من جدول login_logs التي مر عليها أكثر من شهر
        DB::table('login_logs')
            ->where('created_at', '<', $dateLimit)  // تحقق من السجلات التي مر عليها أكثر من شهر
            ->delete();  // حذف السجلات القديمة

        // طباعة رسالة تأكيد
        $this->info('تم حذف السجلات القديمة بنجاح!');
    }
}
