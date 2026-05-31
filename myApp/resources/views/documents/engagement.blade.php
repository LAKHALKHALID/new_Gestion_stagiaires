


@extends('layout.app')

@section('content')

    <style>
        /* Base styles for viewing on screen */
        body {
            font-family: 'Arial', 'Traditional Arabic', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            color: #212529;
            line-height: 1.8;
            max-width: 100%;
        }

        .pv-container-wrapper {
            max-width: 800px;
            margin: 0 auto;
        }

        .document-container {
            background-color: #ffffff;
            padding: 50px 60px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-radius: 4px;
            direction: rtl; /* تفعيل الاتجاه من اليمين لليسار على المتصفح */
        }

        /* Document Headers & Structure */
        .doc-date {
            text-align: right; 
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 40px;
        }

        .doc-title {
            text-align: center; 
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 40px;
            text-decoration: underline;
        }

        /* Trainee Profile Details Section */
        .profile-details {
            margin-bottom: 35px;
            font-size: 1.15rem;
            text-align: right; 
        }

        .profile-item {
            margin-bottom: 12px;
            font-weight: bold;
        }

        /* Main Content Paragraphs */
        .doc-body {
            font-size: 1.15rem;
            text-align: right; 
            margin-bottom: 25px;
        }

        .text-underline {
            text-decoration: underline;
            font-weight: bold;
        }

        /* Blank lines for writing the infractions manually */
        .dotted-lines {
            margin: 25px 0;
        }

        .line {
            border-bottom: 2px dotted #888888;
            height: 35px;
            margin-bottom: 5px;
        }

        /* Signature Section */
        .signature-section {
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
            margin-top: 50px;
            margin-bottom: 20px;
        }

        /* Footer Note */
        .footer-note {
            font-size: 1rem;
            font-weight: bold;
            border-top: 1px solid #dee2e6;
            padding-top: 15px;
            margin-top: 30px;
            text-align: right; 
        }

        /* High-quality print adjustments for paper (A4 standard) */
        @media print {
            body {
                background-color: #ffffff;
                padding: 0;
                margin: 0;
            }
            .document-container {
                box-shadow: none;
                padding: 30px 40px;
                max-width: 100%;
                margin: 0;
            }
            .line {
                border-bottom: 2px dotted #000000;
            }
        }
    </style>

<div class="pv-container-wrapper">
    <button onclick="printCommitment('printSection')" class="btn btn-primary my-3">
        <i class="bi bi-printer"></i>  Print
    </button>

    <div class="document-container" id="printSection">

        <div class="doc-date">فاس في : {{ date('Y/m/d') }}</div>

        <div class="doc-title">التزام المتدرب(ة)</div>
        
        @php
            $fullName = $stagiaire->nom_arabe.' '.$stagiaire->prenom_arabe;
        @endphp
        
        <div class="profile-details">
            <div class="profile-item">§ المتدرب(ة) : {{ $fullName }}</div>
            <div class="profile-item">§ المسجل بشعبة : {{ $stagiaire->filieres[0]->nom_filiere_francais ?? '' }}</div>
            <div class="profile-item">§ الحامل لبطاقة التعريف الوطنية رقم : {{ $stagiaire->cin }}</div>
        </div>

        <p class="doc-body">
            <span class="text-underline">أقر وأعترف</span> بارتكابي للأفعال المنسوبة إلي والمنافية <span class="text-underline">للقانون الداخلي للمؤسسة</span> والمتمثلة في ما يلي :
        </p>

        <div class="dotted-lines">
            <div class="line"></div>
            <div class="line"></div>
            {{-- <div class="line"></div>
            <div class="line"></div> --}}
        </div>

        <p class="doc-body">
            وإذ أقدم أسفي واعتذاري للطاقم الساهر على تسيير المعهد لما تسببت فيه من إخلال بالنظام والسير العادي للمؤسسة، فإنني <span class="text-underline">ألتزم بعدم العودة</span> لتكرار ما ارتكبته من أعمال غير قانونية واحترامي الكامل والمطلق لكل بنود <span class="text-underline">القانون الداخلي للمؤسسة.</span>وعليه، وإدراكا مني أن الإدارة قد استنفذت معي كل الوسائل الممكنة، فإنه وفي <span class="text-underline">حالة</span> ارتكابي ما من شأنه <span class="text-underline">الإخلال بالنظام</span> فإنني أترك لإدارة المؤسسة <span class="text-underline">صلاحية اتخاذ ما تراه مناسبا</span> في حقي من <span class="text-underline">إجراءات تأديبية</span> بما في ذلك <span class="text-underline">الطرد من المؤسسة</span> وذلك طبقا للقانون الجاري به العمل. 
        </p>

        <div class="signature-section">
            الإمضاء المعني بالأمر مصادق عليه 
        </div>

        <div class="footer-note">
            ملحوظة : يجب إرجاع هذا الالتزام إلى الحراسة العامة في أجل أقصاه 48 ساعة من التاريخ أعلاه 
        </div>

    </div>
</div>

<script>
function printCommitment(divId) {
    const printContents = document.getElementById(divId).innerHTML;
    const iframe = document.createElement('iframe');
    
    iframe.style.position = 'absolute';
    iframe.style.width = '0px';
    iframe.style.height = '0px';
    iframe.style.border = 'none';
    
    document.body.appendChild(iframe);
    
    const doc = iframe.contentWindow.document;
    
    doc.open();
    doc.write(`
        <!DOCTYPE html>
        <html lang="ar" dir="rtl">
        <head>
            <title>طباعة الالتزام</title>
            <style>
                body { 
                    font-family: 'Arial', sans-serif; 
                    margin: 40px; 
                    color: #000; 
                    direction: rtl; 
                    line-height: 1.8;
                }
                .doc-date { text-align: right; font-weight: bold; margin-bottom: 30px; font-size: 18px; }
                .doc-title { text-align: center; font-weight: bold; margin-bottom: 40px; font-size: 26px; text-decoration: underline; }
                .profile-details { margin-bottom: 35px; font-size: 19px; text-align: right; }
                .profile-item { margin-bottom: 12px; font-weight: bold; }
                .doc-body { font-size: 19px; text-align: right; margin-bottom: 25px; }
                .text-underline { text-decoration: underline; font-weight: bold; }
                .dotted-lines { margin: 25px 0; }
                .line { border-bottom: 2px dotted #000; height: 40px; margin-bottom: 5px; }
                .signature-section { text-align: center; font-size: 20px; font-weight: bold; margin-top: 60px; margin-bottom: 140px; }
                .footer-note { font-size: 16px; font-weight: bold; border-top: 1px solid #000; padding-top: 15px; margin-top: 40px; text-align: right; }
                @media print { body { margin: 20px; } }
            </style>
        </head>
        <body>
            ${printContents}
        </body>
        </html>
    `);
    doc.close();
    
    setTimeout(() => {
        iframe.contentWindow.focus();
        iframe.contentWindow.print();
        document.body.removeChild(iframe);
    }, 400);
}
</script>

@endsection