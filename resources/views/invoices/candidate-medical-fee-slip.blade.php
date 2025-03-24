<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{!! $title !!}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=AR+One+Sans:wght@500&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Kalam:wght@300&display=swap');
        
        @media print {
            body, h1, h2, h3, h4, h5, h6, p, span, label, td, th {
                color       : #000000 !important;
                text-shadow : 0 0 0 #000000 !important;
            }
            
            @media print and (-webkit-min-device-pixel-ratio : 0) {
                body {
                    color                      : #000000 !important;
                    -webkit-print-color-adjust : exact !important;
                }
            }
        }
        
        @page {
            size : auto;
        }
        
        body {
            background : #525659;
        }
        
        body, h1, h2, td strong, p, th, span, td {
            font-family : 'AR One Sans', sans-serif;
        }
    </style>
</head>
<body>

<div class="content" style="width: 450px; height: auto; margin: 0 auto; background: #FFFFFF">
    <table width="100%" style="border-bottom: 1px solid #e3e3e3">
        <tbody>
        <tr>
            <td align="left" width="30%">
                <img src="{{ $candidate ?-> medical ?-> vendor ?-> left_logo }}" height="90px" alt="">
            </td>
            <td align="right">
                <h1 style="margin-top: 0; font-size: 32pt">{{ $candidate ?-> medical ?-> vendor ?-> title }}</h1>
                <p style="font-size: 12pt">{{ $candidate ?-> medical ?-> vendor ?-> address }}</p>
                <p style="font-size: 12pt">{{ $candidate ?-> medical ?-> vendor ?-> contact }}</p>
            </td>
        </tr>
        </tbody>
    </table>
    <p style="text-align: center; font-size: 18pt; margin-top: 0;">
        پاسپورٹ کی کاپی، شناختی کارڈ کی کاپی، 2 عدد تصویریں ( سفید بیک گراؤنڈ) ہمراہ لائیں
    </p>
    <p style="text-align: center; font-size: 14pt; margin-top: 0;">
        <strong>Non Refundable</strong>
    </p>
    <table width="100%" border="0" cellpadding="5px"
           style="font-size: 14pt; border-collapse: collapse; table-layout: auto; vertical-align: center">
        <tbody>
        <tr>
            <td width="20%">Sr.No</td>
            <td colspan="3"
                style="border-bottom: 1px solid #000000">
                {{ sprintf("%03d", $candidate -> medical -> id) }}
                @if(!empty(trim ($medical -> transaction_no)))
                    ({{ $medical -> transaction_no }})
                @endif
            </td>
        </tr>
        <tr>
            <td width="20%">JMS.No</td>
            <td colspan="3"
                style="border-bottom: 1px solid #000000">{{ env ('APP_NAME') . '-' . $candidate -> sr_no }}</td>
        </tr>
        <tr>
            <td width="20%">Name</td>
            <td colspan="3" style="border-bottom: 1px solid #000000">{{ $candidate -> fullName() }}</td>
        </tr>
        <tr>
            <td width="20%">Son of</td>
            <td colspan="3" style="border-bottom: 1px solid #000000">{{ $candidate -> father_name }}</td>
        </tr>
        <tr>
            <td width="20%">Age/Sex</td>
            <td style="border-bottom: 1px solid #000000">
                {{ $candidate -> age . ' Years / ' . str () -> title ($candidate -> gender) }}
            </td>
            <td width="20%" align="right">Date</td>
            <td style="border-bottom: 1px solid #000000">
                {{ (new \App\Http\Helpers\GeneralHelper()) -> format_date ($candidate -> medical -> created_at) }}
            </td>
        </tr>
        <tr>
            <td width="20%">Passport</td>
            <td colspan="3" style="border-bottom: 1px solid #000000">
                {{ $candidate -> passport }}
            </td>
        </tr>
        <tr>
            <td width="20%">CNIC</td>
            <td colspan="3" style="border-bottom: 1px solid #000000">
                {{ $candidate -> cnic }}
            </td>
        </tr>
        <tr>
            <td width="20%">Trade</td>
            <td style="border-bottom: 1px solid #000000">
                {{ $candidate -> job ?-> title }}
            </td>
            
            <td width="20%">Country</td>
            <td style="border-bottom: 1px solid #000000">
                {{ $candidate -> country ?-> title }}
            </td>
        </tr>
        <tr>
            <td width="20%">Ref By</td>
            <td style="border-bottom: 1px solid #000000"></td>
            
            <td width="20%">Lab#</td>
            <td style="border-bottom: 1px solid #000000"></td>
        </tr>
        </tbody>
    </table>
    
    <table width="100%" style="margin-top: 30px; font-size: 14pt;">
        <tbody>
        <tr>
            <td align="left" width="60%">
                Rs. {{ number_format ($medical -> amount, 2) }}
            </td>
            <td align="right">
                _____________ <br />
                Signature
            </td>
        </tr>
        </tbody>
    </table>
    
    <table width="100%" style="margin-top: 10px; font-size: 8pt;">
        <tbody>
        <tr>
            <td align="center" width="100%">
                Generated By:
                <u>{{ auth () -> user () -> fullName() }}</u>
            </td>
        </tr>
        </tbody>
    </table>
    
{{--     <br /> --}}
{{--      --}}
{{--     <img src="{{ asset ('assets/img/medical-slip-map-1-black.jpg') }}" alt="Medical Receipt Map" --}}
{{--          style="height: 150px; width: 100%"> --}}
</div>

</body>
</html>