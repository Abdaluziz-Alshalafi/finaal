<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إشعار تحديث حالة البحث</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: rtl;
            text-align: right;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #2c3e50;
            text-align: center;
        }h4 {
            color: #2c3e50;
            text-align:right;
        }
         p{

            text-align: right;
        }

        li {
            margin-bottom: 5px;
            font-weight: bold;
            background-color: #e0e0e0;
            padding: 8px;
            border-radius: 5px;
            text-align: right;

        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
            text-align: center;
        }




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

        .research-item { background: #eef5ff; padding: 12px; margin: 8px 0; border-radius: 8px; text-align: right; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }

    </style>
</head>
<body>

<div class="container">
    <h2>📢 إشعار تحديث حالة المشروع</h2>

    <h4>عزيزي الباحث</h4>
    @if($status == 'accepted')
        <p>يسعدنا إبلاغك بأن الطالب (<strong>{{ $studentName }}</strong>)
             لقد وافق على الانضمام إلى فريقك في المشروع التالي </p>
        <ul class="research-item"  dir="rtl">
            @foreach ($researchTitles as $title)
                <li> 📌{{ $title }}</li>
            @endforeach
        </ul>
        <p>نتمنى لكم جميعًا التوفيق في رحلتكم البحثية والتعاون المثمر</p>
        <center>
            @if (is_integer($counts) == 0)
            <p >
                تمت الموافقه من جميع الطلاب علئ الانضمام الئ مشروعك
                قم بارساله الي مشرف الجامعه للموافقه عليها  </p>
                {{-- <button type="button" class="btn btn-success btn-lg action-btn accept-btn"  ></button> --}}
                <center>    <a href='http://yourwebsite.com/confirm?student_id={$student->id}' style='display:inline-block; padding:10px 20px; background-color:#4CAF50; color:white; text-decoration:none; border-radius:5px;'> ارسال </a>
                </center>
            @else
                <p style="text-align: center;">عدد المقاعد المتبقية في فريق المشروع: <strong>{{ $counts }}</strong></p>
            @endif
    @else
    @if (is_integer($counts) > 0 )
    <p>نأسف لإبلاغك بأن الطالب (<strong>{{ $studentName }}</strong>) لم يوافق على الانضمام إلى فريقك في المشروع التالي</p>
        <ul class="research-item" dir="rtl">
            @foreach ($researchTitles as $title)
                <li>❌{{ $title }}</li>
            @endforeach
        </ul>
    @elseif ($counts === 'وافق علئ مشروع أخر')
        {{-- <h4 style="text-align: center;">{{ $studentName }}</h4> --}}
         <p> نأسف لإبلاغك بأن الطالب <strong>{{ $status }}
            قد وافق علئ مشروع أخر
            *ملاحظة <strong style="color: rgb(154, 60, 60)"> سيتم حذف المشروع الخاص بك بعد فتره معينه اذ لم تضيف طالب </strong></strong></p>
        <ul class="research-item" dir="rtl">
            @foreach ($researchTitles as $title)
                <li>📌{{ $title }}</li>
            @endforeach
        </ul>
    @else
        <p>نأسف لإبلاغك بأن الطلاب  لم يوافقو جميعاّّ على الانضمام إلى فريقك في المشروع التالي</p>
            <ul class="research-item" dir="rtl">
                @foreach ($researchTitles as $title)
                    <li>❌ {{ $title }}</li>
                @endforeach
            </ul>
            <p>
        <strong style="color: rgb(154, 60, 60)"> {{$status}}
        </strong></p>
    @endif
    <p>يمكنك البحث عن أعضاء آخرين أو التقدم بمشروع جديد</p>
    @endif
    </center>
    <p>:للتواصل معنا، يمكنك إرسال بريد إلكتروني إلى</p>
    <div style="background: #eef5ff; padding: 12px; border-radius: 8px; text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05); font-size: 16px; font-weight: bold;">
    📧 :البريد الإلكتروني
    <code style="direction: ltr; unicode-bidi: bidi-override; font-size: 16px; color: #333;">
        email@example.com
    </code>
</div>
    <p class="footer">📩 مع أطيب التحيات،<br>
    فريق إدارة الأبحاث</p>
</div>

</body>
</html>
