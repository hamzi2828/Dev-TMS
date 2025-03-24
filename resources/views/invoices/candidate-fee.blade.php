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
            size: auto;
        }

        body, h1, h2, td strong, p, th, span, td {
            font-family: 'AR One Sans', sans-serif;
        }
    </style>
</head>
<body>

<!--mpdf
<htmlpageheader name="myheader">
<table width="100%" style="border-bottom: 1px solid #e3e3e3">
    <tbody>
        <tr>
            <td align="left" width="60%">
                <img src="{{ asset ('/assets/qj-logo.jpeg') }}" height="100px">
            </td>
            <td align="right">
                <img src="{{ asset ('/assets/qj-receipt.jpeg') }}" height="60px"> <br/><br/>
                <p style="font-size: 8pt"><?php echo env ( 'HOSPITAL_ADDRESS' ) ?></p>
                <p style="font-size: 8pt"><?php echo env ( 'HOSPITAL_CONTACT' ) ?></p>
            </td>
        </tr>
    </tbody>
</table>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<table width="100%">
    <tbody>
        <tr>
            <td align="left" width="60%">
                Rs. <?php echo number_format ($fee -> amount, 2) ?>
        </td>
        <td align="right">
            _____________ <br/>
            Signature
        </td>
    </tr>
</tbody>
</table>
</htmlpagefooter>

<sethtmlpageheader name="myheader" page="all" value="on" show-this-page="1"/>
<sethtmlpagefooter name="myfooter" page="all" value="on"/>
mpdf-->

<table width="100%" border="0" cellpadding="6px"
       style="font-size: 10pt; border-collapse: collapse; table-layout: auto; vertical-align: center">
    <tbody>
    <tr>
        <td width="20%">Sr.No</td>
        <td colspan="3" style="border-bottom: 1px solid #000000">{{ env ('APP_NAME') . '-' . $candidate -> sr_no }}</td>
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
        <td colspan="3" style="border-bottom: 1px solid #000000">
            {{ $candidate -> age . ' Years / ' . str () -> title ($candidate -> gender) }}
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
    
        <td width="20%">Lab</td>
        <td style="border-bottom: 1px solid #000000"></td>
    </tr>
    </tbody>
</table>

</body>
</html>