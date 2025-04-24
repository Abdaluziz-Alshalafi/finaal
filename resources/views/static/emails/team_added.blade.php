<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إشعار الانضمام إلى الفريق</title>
    <style>
        body { font-family: 'Tajawal', Arial, sans-serif; direction: rtl; text-align: right; background-color: #f4f4f4; padding: 30px; }
        .container { max-width: 600px; margin: auto; background: #ffffff; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; }
        .header { font-size: 22px; font-weight: bold; color: #007bff; margin-bottom: 15px; }
        .content { font-size: 18px; color: #333; text-align: center; }
        .research-list { margin-top: 15px; padding: 0; list-style: none; text-align: center; }
        .research-item { background: #eef5ff; padding: 12px; margin: 8px 0; border-radius: 8px; text-align: right; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .research-title { font-weight: bold; color: #0056b3; font-size: 18px; }
        .research-description { font-size: 16px; color: #444; margin-top: 5px; }
        .footer { margin-top: 20px; font-size: 14px; color: #777; border-top: 1px solid #ddd; padding-top: 10px; }
        .message-box { background: #fff3cd; padding: 12px; border-radius: 8px; margin-top: 15px; color: #856404; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">🎉 تهانينا، {{ $studentName }}!</div>
        <div class="content">
            <p> لقد تمت دعوتك لتكوين فريق مع الطالب : <strong>{{ $teamName }}</strong></p>

            <div><strong>📝 :قائمة الأبحاث المخصصة </strong></div>
            <ul class="research-list" dir="rtl">
                @foreach($researchTitle as $index => $title)
                <li class="research-item">
                    <div class="research-title">📌 {{ $title }}</div>
                    <div class="research-description">📄 {{ $researchdescription[$index] ?? 'لا يوجد وصف' }}</div>
                </li>
            @endforeach



            <a href="{{ route('researcher.accepted', ['requestId' => $requestId]) }}"
                class="btn btn-primary"
                style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">
                ✅ قبول الطلب
             </a>
             <a href="{{ route('researcher.rejected', ['requestId' => $requestId]) }}"
                class="btn btn-danger"
                style="display: inline-block; padding: 10px 20px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 5px; margin-left: 10px;">
                ❌ رفض الطلب
             </a>
            </ul>

            @if($additionalMessage)
                <div class="message-box">
                    <p><strong>📢 رسالة إضافية:</strong> {{ $additionalMessage }}</p>
                </div>
            @endif
        </div>

        <div class="footer">
            🤖 هذه رسالة تلقائية، لا ترد عليها.<br>
            📧 لأي استفسارات، يرجى التواصل مع المشرف.
        </div>
    </div>
</body>
</html>
