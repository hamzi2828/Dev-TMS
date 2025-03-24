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
        
        @page {
            size   : auto;
            header : myheader;
            footer : myfooter;
        }
        
        body, h1, h2, td strong, p, th, span, td {
            font-family : 'AR One Sans', sans-serif;
            font-size   : 8pt;
        }
        
        table {
            border-collapse : collapse;
            width           : 100%;
            padding         : 0;
        }
        
        .template, figure {
            margin-top : 5px;
        }
        
        .table table td {
            padding : 0 !important;
        }
        
        .table table tr td, .table table tr th {
            text-align : left;
        }
        
        .table table tr th {
            background : #f5f5f5;
        }
        
        .table table tr td, .table table tr th {
            text-align : left;
            border     : 1px solid #000000;
        }
    </style>
</head>
<body>

<!--mpdf
<htmlpageheader name="myheader">
<table width="100%">
    <tbody>
        <tr>
            <td align="left" width="100%" style="color:#0000BB; text-align: left">
                <img src="{{ $document_ready -> agreement ?-> principal ?-> file }}" height="130px">
            </td>
        </tr>
    </tbody>
</table>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<table  style="width: 100%; margin: 0 auto" border="0" cellpadding="0">
    <tbody>
        <tr>
            <td align="left" width="100%" style="color:#0000BB; text-align: left">
                <img src="{{ $document_ready -> agreement ?-> principal ?-> footer }}" width="100%">
            </td>
        </tr>
    </tbody>
</table>
</htmlpagefooter>

<sethtmlpageheader name="myheader" page="all" value="on" show-this-page="1"/>
<sethtmlpagefooter name="myfooter" page="all" value="on"/>
mpdf-->

<table style="width: 85%; margin: 0 auto" border="0" cellpadding="0">
    <tbody>
    <tr>
        <td align="left">
            Date:
            {{ (new \App\Http\Helpers\GeneralHelper()) -> format_date ($document_ready -> created_at) }}
        </td>
    </tr>
    <tr>
        <td align="left">
            <br />
            Full Name:
            {{ $candidate -> fullName() }}
        </td>
    </tr>
    <tr>
        <td align="left">
            Nationality:
            {{ $candidate -> country ?-> title }}
        </td>
    </tr>
    <tr>
        <td align="left">
            Passport:
            {{ $candidate -> passport }}
        </td>
    </tr>
    <tr>
        <td align="left">
            <br />
            REF: TG/EC/Initials/Month/Year/Sl.No.
        </td>
    </tr>
    <tr>
        <td align="left">
            <br />
            Dear {{ $candidate -> fullName() }},
        </td>
    </tr>
    <tr>
        <td align="left">
            <br />
            We are pleased to offer you employment with
            <strong>{{ $document_ready -> agreement ?-> principal ?-> name }}</strong>,
            in the role of <strong>{{ $document_ready ?-> agreement ?-> title }}.</strong>
        </td>
    </tr>
    </tbody>
</table>

<div class="template" style="width: 85%; margin: 0 auto">
    {!! $document_ready -> agreement ?-> template !!}
    <table style="width: 100%; margin: 0 auto" border="0" cellpadding="0">
        <tbody>
        <tr>
            <td width="50%" align="left">
                <strong>Yours Sincerely,</strong>
            </td>
            <td width="50%" align="right">
                <strong>Candidate Signature: ______________________</strong>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
<style>
    
    .table table td {
        padding : 0 !important;
    }
    
    .table table tr td, .table table tr th {
        padding : 3px;
    }
</style>
</html>