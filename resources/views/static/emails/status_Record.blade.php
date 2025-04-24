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
        ul {
            list-style-type: none;
            padding: 0;
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
            <h3><p>لقد تم<strong>{{ $status_Record }}</strong></p></h3>
            @if($studentnamess)
                <ul class="research-item" dir="rtl">
                    <li> 📌 {{ $studentnamess }}</li>
                </ul>
            @endif
<ln>
    <ln>

        <p class="footer">📩 مع أطيب التحيات،<br>
    فريق إدارة الأبحاث</p>


<pre>للتواصل معنا، يمكنك إرسال بريد إلكتروني إلى:</pre>
<div style="background: #eef5ff; padding: 12px; border-radius: 8px; text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05); font-size: 16px; font-weight: bold;">
    📧 البريد الإلكتروني:
    <code style="direction: ltr; unicode-bidi: bidi-override; font-size: 16px; color: #333;">
        email@example.com
    </code>
</div>
{{-- <p>نتمنى لكم جميعًا التوفيق في رحلتكم البحثية والتعاون المثمر</p> --}}
</div>


</body>
</html>
