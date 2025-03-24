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
            size : auto;
        }
        
        body, h1, h2, td strong, p, th, span, td {
            font-family : 'AR One Sans', sans-serif;
        }
        
        table {
            border-collapse : collapse;
            table-layout    : fixed
        }
    </style>
</head>
<body>

<!--mpdf
<htmlpageheader name="myheader">
<table width="100%" style="border-bottom: 1px solid #e3e3e3">
    <tbody>
        <tr>
            <td>
                <img src="{{ asset ('/assets/img/foreign-services-contract-header.png') }}" width="100%">
            </td>
        </tr>
    </tbody>
</table>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<table width="93%" style="margin: 0 auto 30px auto; font-size: 7pt" cellpadding="5px">
    <tbody>
        <tr>
            <td width="50%" align="left">
                <strong>Signature & Seal of O.E.P on behalf of employer</strong>
            </td>
            <td width="50%" align="right">
                <strong>Signature & Thumb of emigrant_______________</strong>
            </td>
        </tr>
        <tr>
            <td width="100%" colspan="2" align="center">
                Certified that both parties mentioned above have agreed with the contents of this contract which has been registered vide number as below.
            </td>
        </tr>
    </tbody>
</table>
<table width="92%" style="margin: 0 auto; font-size: 10pt">
    <tbody>
        <tr>
            <td align="left">
                <strong>Registration No.________________________</strong>
            </td>
            <td align="right">
                <strong>Date:  _________________</strong>
            </td>
            <td align="right">
                <strong>Signature & Seal of P.E_____________________</strong>
            </td>
        </tr>
    </tbody>
</table>
<table width="100%">
    <tbody>
        <tr>
            <td>
                <img src="{{ asset ('/assets/img/foreign-services-contract-footer.png') }}" width="100%">
            </td>
        </tr>
    </tbody>
</table>
</htmlpagefooter>

<sethtmlpageheader name="myheader" page="all" value="on" show-this-page="1"/>
<sethtmlpagefooter name="myfooter" page="all" value="on"/>
mpdf-->

<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td align="center">
            <h2 style="text-transform: uppercase">Foreign Service Contract</h2>
        </td>
    </tr>
    </tbody>
</table>

<table width="90%" border="0" cellpadding="0" cellspacing="0"
       style="margin: 10px auto 0 auto; font-size: 8pt">
    <tbody>
    <tr>
        <td width="85%" align="left">
            This agreement has been executed between emigrant (employment) and the O.E.P on behalf of the employer as
            per Power of Attorney <br /><br /> <br />
            
            <h2>PARTICULARS OF THE OVERSEAS EMPLOYMENT PROMOTER (O.E.P)</h2>
            <h2>Title of O.E.P SOCIAL AGE SERVICES LICENCE NO 3724 MPD RWP</h2>
            <h2>PARTICULARS OF EMPLOYER</h2>
        </td>
        <td width="15%" align="right">
            @if($candidate -> document && !empty(trim ($candidate -> document -> picture)))
                <img src="{{ $candidate -> document ?-> picture }}" alt="{{ $candidate -> fullName() }}" height="120px"
                     style="border: 1px solid #000000">
            @endif
        </td>
    </tr>
    </tbody>
</table>

<table width="93%" border="1" cellpadding="8px" cellspacing="0"
       style="margin: 10px auto 0 auto; font-size: 8pt">
    <tbody>
    <tr>
        <td align="left" width="15%" style="border: 0">Name of Employer</td>
        <td align="left"
            width="30%">{{ $candidate -> document_ready ?-> agreement ?-> principal ?-> name }}</td>
        
        <td align="left" width="15%" style="border: 0">City</td>
        <td align="left" width="30%">{{ $candidate -> document_ready ?-> agreement ?-> principal ?-> city ?-> title }}</td>
    </tr>
    <tr>
        <td align="left" width="15%" style="border: 0">Address</td>
        <td align="left" width="30%">{{ $candidate -> document_ready ?-> agreement ?-> principal ?-> address }}</td>
        
        <td align="left" width="15%" style="border: 0">Country</td>
        <td align="left" width="30%">{{ $candidate -> document_ready ?-> agreement ?-> principal ?-> city ?-> country ?-> title }}</td>
    </tr>
    </tbody>
</table>

<table width="100%" border="0" cellpadding="8px" cellspacing="0"
       style="margin: 10px auto 0 auto; font-size: 8pt">
    <tbody>
    <tr>
        <td align="center">
            <h2>PARTICULARS OF EMIGRANT (EMPLOYEE)</h2>
        </td>
    </tr>
    </tbody>
</table>

<table width="93%" border="1" cellpadding="8px" cellspacing="0"
       style="margin: 10px auto 0 auto; font-size: 8pt">
    <tbody>
    <tr>
        <td align="left" width="15%" style="border: 0">Name</td>
        <td align="left" width="30%">{{ $candidate -> fullName() }}</td>
        
        <td align="left" width="15%" style="border: 0">Province</td>
        <td align="left" width="30%">{{ $candidate -> province ?-> title }}</td>
    </tr>
    <tr>
        <td align="left" width="15%" style="border: 0">Father Name</td>
        <td align="left" width="30%">{{ $candidate -> father_name }}</td>
        
        <td align="left" width="15%" style="border: 0">Address (in Pakistan)</td>
        <td align="left" width="30%">
            {{ $candidate -> city ?-> title }}, {{ $candidate -> city ?-> country ?-> title }}
        </td>
    </tr>
    <tr>
        <td align="left" width="15%" style="border: 0">Passport</td>
        <td align="left" width="30%">{{ $candidate -> passport }}</td>
        
        <td align="left" width="15%" style="border: 0">TEHSILE AND DISRTICT</td>
        <td align="left" width="30%">{{ $candidate -> district ?-> title }}</td>
    </tr>
    <tr>
        <td align="left" width="15%" style="border: 0">DATE OF BIRTH</td>
        <td align="left" width="30%">
            {{ (new \App\Http\Helpers\GeneralHelper()) -> format_date ($candidate -> dob) }}
        </td>
        
        <td align="left" width="15%" style="border: 0">PLACE OF ISSUE</td>
        <td align="left" width="30%">{{ $candidate -> issue_place ?-> title }}</td>
    </tr>
    <tr>
        <td align="left" width="15%" style="border: 0">DATE OF ISSUE</td>
        <td align="left" width="30%">
            {{ !empty(trim ($candidate -> passport_issue_date)) ? (new \App\Services\GeneralService()) -> only_date_formatter ($candidate -> passport_issue_date) : '-' }}
        </td>
    </tr>
    </tbody>
</table>

<table width="100%" border="0" cellpadding="8px" cellspacing="0"
       style="margin-top: 10px; font-size: 8pt">
    <tbody>
    <tr>
        <td align="center">
            <h2>PARTICULARS OF NEXT OF KIN</h2>
        </td>
    </tr>
    </tbody>
</table>

<table width="93%" border="1" cellpadding="8px" cellspacing="0"
       style="margin: 10px auto 0 auto; font-size: 8pt">
    <tbody>
    <tr>
        <td align="left" width="15%" style="border: 0">Name</td>
        <td align="left" width="30%">{{ $candidate -> next_of_kin }}</td>
        
        <td align="left" width="15%" style="border: 0">CNIC</td>
        <td align="left" width="30%">{{ $candidate -> next_of_kin_cnic }}</td>
    </tr>
    </tbody>
</table>

<table width="93%" border="0" cellpadding="8px" cellspacing="0"
       style="margin: 10px auto 0 auto; font-size: 8pt">
    <tbody>
    <tr>
        <td align="left">
            <h4>TERMS AND CONDITION OF THE CONTRACT</h4>
        </td>
    </tr>
    </tbody>
</table>

<table width="93%" border="1" cellpadding="8px" cellspacing="0"
       style="margin: 10px auto 0 auto; font-size: 8pt">
    <tbody>
    <tr>
        <td align="left" width="15%" style="border: 0">Job Title</td>
        <td align="left" width="30%">{{ $candidate -> job ?-> title }}</td>
        
        <td align="left" width="15%" style="border: 0">Period of contract</td>
        <td align="left" width="30%">{{ $candidate -> contract_period }} Years</td>
    </tr>
    <tr>
        <td align="left" width="15%" style="border: 0">Accommodation</td>
        <td align="left" width="30%">
            <strong>{{ str () -> title (str_replace ('-', ' ', $candidate -> accommodation)) }}</strong>
        </td>
        
        <td align="left" width="15%" style="border: 0">Food</td>
        <td align="left" width="30%">
            <strong>{{ str () -> title (str_replace ('-', ' ', $candidate -> accommodation)) }}</strong>
        </td>
    </tr>
    <tr>
        <td align="left" width="15%" style="border: 0">Salary</td>
        <td align="left" width="30%"><strong>{{ $candidate -> salary }} AED</strong></td>
    </tr>
    </tbody>
</table>

<table width="93%" border="0" cellpadding="8px" cellspacing="0"
       style="margin: 10px auto 0 auto; font-size: 8pt">
    <tbody>
    <tr>
        <td align="left">
            Promotion period/ working hour’s overtime, Medical, Passage/ Repatriation of dead body, leave vacation other
            fringe benefits, social security and service benefits etc or Cancellation of Contract.
            <strong><u>As per local labor law</u></strong>
        </td>
    </tr>
    <tr>
        <td align="left">
            Certified that the above named emigrant has been engaged or
            ____________________________________________
            I agree for the employment on the terms and Employment abroad as per details given above and he has
            ____________________________________________
            conditions mentioned above which have been made to understand about the terms and conditions of service.
            ____________________________________________
            explained to me and I have fully endorsed.
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>