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

<table width="100%" border="0" cellpadding="8px" cellspacing="0">
    <tbody>
    <tr>
        <td width="20%" align="left">
            <img src="{{ asset ('/assets/img/allied-bank.jpg') }}" alt="Bank logo" height="60px">
        </td>
        <td width="80%" align="center">
            <h2>REQUEST FOR ISSUANCE OF FORM -7</h2>
            <p>(Under Emigration Rules-1979)</p>
        </td>
    </tr>
    <tr>
        <td width="100%" colspan="2" align="center">
            <p>I/We request for issuance of Form-7 (under Emigration Rules 1979) as per appended details</p>
        </td>
    </tr>
    </tbody>
</table>

<p style="margin-bottom: 2px; margin-top: 10px; font-size: 9pt">A. Depositor Detail</p>
<table width="100%" border="1" cellpadding="8px" cellspacing="0" style="margin-top: 0; font-size: 9pt">
    <thead>
    <tr>
        <th align="center">Name</th>
        <th align="center">S/O D/O W/O</th>
        <th align="center">Contact Number</th>
        <th align="center">CNIC Number</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td align="center">NABEEL BANI</td>
        <td align="center">HANIF MASIH</td>
        <td align="center">0341-5229499</td>
        <td align="center">61101-2214924-9</td>
    </tr>
    </tbody>
</table>

<p style="margin-bottom: 2px; margin-top: 25px; font-size: 9pt">
    B. Intending Emigrant(s) Details (List attached for more than one intending Emigrant
</p>
<table width="100%" border="1" cellpadding="8px" cellspacing="0" style="margin-top: 0; font-size: 9pt">
    <tbody>
    <tr>
        <td align="left" width="20%">
            <strong>Name</strong>
        </td>
        <td align="left">
            {{ $candidate -> fullName() }}
        </td>
    </tr>
    <tr>
        <td align="left" width="20%">
            <strong>S/O D/O W/O</strong>
        </td>
        <td align="left">
            {{ $candidate -> father_name }}
        </td>
    </tr>
    <tr>
        <td align="left" width="20%">
            <strong>Contact Number</strong>
        </td>
        <td align="left">
            {{ $candidate -> mobile }}
        </td>
    </tr>
    <tr>
        <td align="left" width="20%">
            <strong>Date of Birth</strong>
        </td>
        <td align="left">
            {{ (new \App\Http\Helpers\GeneralHelper()) -> format_date ($candidate -> dob) }}
        </td>
    </tr>
    <tr>
        <td align="left" width="20%">
            <strong>CNIC Number</strong>
        </td>
        <td align="left">
            {{ $candidate -> cnic }}
        </td>
    </tr>
    <tr>
        <td align="left" width="20%">
            <strong>Passport Number</strong>
        </td>
        <td align="left">
            {{ $candidate -> passport }}
        </td>
    </tr>
    <tr>
        <td align="left" width="20%">
            <strong>Passport Expiry</strong>
        </td>
        <td align="left">
            {{ (new \App\Http\Helpers\GeneralHelper()) -> format_date ($candidate -> passport_expiry_date) }}
        </td>
    </tr>
    <tr>
        <td align="left" width="20%">
            <strong>Address</strong>
        </td>
        <td align="left">
            {{ $candidate -> address . ', ' . $candidate -> city ?-> title . ', ' . $candidate -> city ?-> country ?-> title }}
        </td>
    </tr>
    </tbody>
</table>

<table width="100%" border="1" cellpadding="8px" cellspacing="0" style="margin-top: 25px; font-size: 9pt">
    <tbody>
    <tr>
        <td align="left" width="20%">
            <strong>Name</strong>
        </td>
        <td align="left">JMS HR CONSULTANTS</td>
    </tr>
    <tr>
        <td align="left" width="20%">
            <strong>Address</strong>
        </td>
        <td align="left">OFFICE\SF7,MERIDIAN MALL NEAR PASSPORT OFFICE RAWALPINDI</td>
    </tr>
    <tr>
        <td align="left" width="20%">
            <strong>O.E.P license Number</strong>
        </td>
        <td align="left">4395/RWP</td>
    </tr>
    </tbody>
</table>

<table width="100%" border="0" cellpadding="2px" cellspacing="0" style="margin-top: 35px; font-size: 10pt">
    <tbody>
    <tr>
        <td align="left" width="20%">
            <strong>Account no.</strong>
        </td>
        <td align="left">0010001979660084</td>
    </tr>
    <tr>
        <td align="left" width="20%">
            <strong>Amount in figure</strong>
        </td>
        <td align="left">15000/-</td>
    </tr>
    <tr>
        <td align="left" width="20%">
            <strong>Amount in words</strong>
        </td>
        <td align="left">Fifteen Thousand Only</td>
    </tr>
    </tbody>
</table>

<table width="100%" border="0" cellpadding="2px" cellspacing="0" style="margin-top: 35px; font-size: 9pt">
    <tbody>
    <tr>
        <td align="left">
            I/We understand that this deposit this governed by Emigration rule 1979 and refund against Form shall only
            made to the depositor.
        </td>
    </tr>
    <tr>
        <td align="left">
            <br />
            All Claim against any Form 7 will only be processed after endorsement by concerned protector of Emigrant,
            bureau of Emigrant & overseas employment (BE&OE) Ministry of overseas Pakistanis & Human Resource
            Development Government of Pakistan.
        </td>
    </tr>
    <tr>
        <td align="left">
            <br /><br /><br /><br /><br /><br />
            (Signature of the Depositor)
        </td>
    </tr>
    </tbody>
</table>

<table width="100%" border="1" cellpadding="2px" cellspacing="0" style="margin-top: 35px; font-size: 9pt">
    <tbody>
    <tr>
        <td align="center">FOR BANK USE ONLY</td>
    </tr>
    <tr>
        <td align="center" style="border: 0">
            <br /><br />
            <strong>
                Form / Issued from serial No.________________ to serial No.________________________________
            </strong>
        </td>
    </tr>
    <tr>
        <td align="left" style="border: 0">
            <br /><br />
            <strong>
                Total Form issued__________________________________________
            </strong>
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>