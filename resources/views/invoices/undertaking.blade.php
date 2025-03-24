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
            font-size   : 12pt;
            line-height : 18pt;
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
<table width="100%">
    <tbody>
        <tr>
            <td align="left" width="100%" style="color:#0000BB; text-align: left">
                <img src="{{ asset ('/assets/img/header_undertaking.png') }}" width="100%" height="120px">
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
                <img src="{{ asset ('/assets/img/footer_undertaking.png') }}" width="100%" height="120px">
            </td>
        </tr>
    </tbody>
</table>
</htmlpagefooter>

<sethtmlpageheader name="myheader" page="all" value="on" show-this-page="1"/>
<sethtmlpagefooter name="myfooter" page="all" value="on"/>
mpdf-->

<table width="100%" border="0" cellpadding="5px" cellspacing="0">
    <tbody>
    <tr>
        <td width="100%" align="left">
            I Mr. <u>ISSAM BAIG</u>, Proprietor of M/S <u>JMS HR CONSULTANTS</u> Rawalpindi, Overseas Employment
            Promotors License No. <u>4395</u> /RWP, do hereby undertake that the documents and Visas in respect of the
            following emigrants whose cases have been submitted for registration are genuine.
        </td>
    </tr>
    </tbody>
</table>
<br /><br />
<table width="100%" border="0" cellpadding="5px" cellspacing="0">
    <thead>
    <tr>
        <th width="25%" align="left">Name</th>
        <th width="25%" align="left">F.Name</th>
        <th width="25%" align="left">Passport #.</th>
        <th width="25%" align="left">ID Number</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{ $candidate -> fullName() }}</td>
        <td>{{ $candidate -> father_name }}</td>
        <td>{{ $candidate -> passport }}</td>
        <td>{{ $candidate -> cnic }}</td>
    </tr>
    </tbody>
</table>

<table width="100%" border="0" cellpadding="5px" cellspacing="0">
    <tbody>
    <tr>
        <td width="100%" align="left">
            <br /><br />
            I <u>Mr. ISSAM BAIG</u>, Proprietor of M/S <u>JMS HR CONSULTANTS</u> Rawalpindi, Overseas Employment
            Promotors License No. <u>4395</u> /RWP, do hereby further UNDERTAKE that a suitable and qualified person
            have been selected in accordance with the employer’s requirements mentioned in demand letter as required
            under Rule (20) & (21) (i).
            <br /><br />
            I UNDERTAKE that I have explained to above mentioned persons that contents of the agreement in their own
            language and the person fully understand the terms and condition of service contained in the agreement and
            have voluntarily offered themselves for employment abroad as required Rule (21) of the Emigration Ordinance
            1979 and Emigration Rules made thereunder.
            <br /><br />
            I UNDERTAKE that in case the documents / Visas are found forged or bogus I shall be held responsible and
            liable for punitive action under the relevant law.
            I further declare that Emigrants mentioned above are confide Pakistani national/s
            <br /><br />
        </td>
    </tr>
    <tr>
        <td width="100%" align="center">
            <strong>UNDERTAKING “B”</strong>
        </td>
    </tr>
    <tr>
        <td width="100%" align="left">
            It is further certified that the receipt of actual expenses incurred on air ticketing, medical, work permit,
            levy, visa and documentation of the emigrants under rule 15-A have been issued to the emigrants selected
            against permissions/s referred in out letter No.
            <br /><br />
            ___________ Dated. _____
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>