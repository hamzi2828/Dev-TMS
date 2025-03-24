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
                <img src="{{ asset ('/assets/logo.jpeg') }}" height="80px">
            </td>
            <td align="right">
                <h2><?php echo env ( 'APP_FULL_NAME' ) ?></h2> <br/>
                <p style="font-size: 8pt"><?php echo env ( 'ADDRESS' ) ?></p>
                <p style="font-size: 8pt"><?php echo env ( 'EMAIL' ) ?></p>
                <p style="font-size: 8pt"><?php echo env ( 'CONTACT' ) ?></p>
            </td>
        </tr>
    </tbody>
</table>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<table width="100%" border="0"
       style="font-size: 10pt; border-collapse: collapse; table-layout: auto;">
    <tbody>
    <tr>
        <td width="20%" align="center">
            {{ $candidate -> user ?-> fullName() }} <br />
            ____________________________ <br />
            <strong>Prepared By</strong>
        </td>
        
        <td width="20%" align="center">
            - <br />
            ____________________________ <br />
            <strong>Approved By</strong>
        </td>
        
        <td width="20%" align="center">
            - <br />
            ____________________________ <br />
            <strong>Verified By</strong>
        </td>
    </tr>
    </tbody>
</table>
</htmlpagefooter>

<sethtmlpageheader name="myheader" page="all" value="on" show-this-page="1"/>
<sethtmlpagefooter name="myfooter" page="all" value="on"/>
mpdf-->

<table width="100%" border="0" cellpadding="2" style="font-size: 9pt; border-collapse: collapse;">
    <tbody>
    <tr>
        <td align="center">
            <h2 style="text-decoration: underline; text-transform: uppercase">
                Human Resource & Management Consultants
            </h2>
        </td>
    </tr>
    </tbody>
</table>

<table width="100%" border="0" cellpadding="2" style="margin-top: 35px; font-size: 9pt; border-collapse: collapse;">
    <tbody>
    <tr>
        <td align="center">
            <h3 style="text-decoration: underline; text-transform: uppercase">Test Fee Invoice</h3>
        </td>
    </tr>
    </tbody>
</table>

<table width="100%" border="0"
       style="margin-top: 25px; font-size: 10pt; border-collapse: collapse; table-layout: auto;">
    <tbody>
    <tr>
        <td width="80%">
            <table width="100%" cellpadding="8px">
                <tbody>
                <tr>
                    <td width="22%"><strong>Serial</strong></td>
                    <td align="left"
                        style="border-bottom: 1px solid #000">{{ env ('APP_NAME') . '-' . $candidate -> sr_no }}</td>
                    
                    <td width="22%"><strong>Post Applied For</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> job ?-> title }}</td>
                </tr>
                
                <tr>
                    <td width="22%"><strong>First Name</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> first_name }}</td>
                    <td width="22%"><strong>Last Name</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> last_name }}</td>
                </tr>
                
                <tr>
                    <td width="22%"><strong>Mobile No.</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> mobile }}</td>
                    
                    <td width="22%"><strong>CNIC No.</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> cnic }}</td>
                </tr>
                
                <tr>
                    <td width="22%"><strong>Fee</strong></td>
                    <td align="left" colspan="3"
                        style="border-bottom: 1px solid #000">{{ $candidate -> free_candidate == '1' ? 'FREE' : number_format ($candidate -> amount, 2) }}</td>
                </tr>
                
                <tr>
                    <td width="22%"><strong>In Words</strong></td>
                    <td align="left" colspan="3" style="border-bottom: 1px solid #000">
                        @if($candidate -> free_candidate == '1')
                            FREE
                        @else
                            {{ (new NumberFormatter("en", NumberFormatter::SPELLOUT)) -> format ($candidate -> amount) }} only.
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
        <td width="22%" align="right">
            @if($candidate -> document && !empty(trim ($candidate -> document ?-> picture)))
                <img src="{{ $candidate -> document ?-> picture }}"
                     style="width: 120px; border: 1px solid #000000"
                     alt="{{ $candidate -> document ?-> picture }}">
            @endif
        </td>
    </tr>
    </tbody>
</table>

<pagebreak />

<table width="100%" border="0" cellpadding="2" style="font-size: 9pt; border-collapse: collapse;">
    <tbody>
    <tr>
        <td align="center">
            <h2 style="text-decoration: underline; text-transform: uppercase">
                Human Resource & Management Consultants
            </h2>
        </td>
    </tr>
    </tbody>
</table>

<table width="100%" border="0" cellpadding="2" style="margin-top: 35px; font-size: 9pt; border-collapse: collapse;">
    <tbody>
    <tr>
        <td align="center">
            <h3 style="text-decoration: underline; text-transform: uppercase">Test Fee Invoice</h3>
        </td>
    </tr>
    </tbody>
</table>

<table width="100%" border="0"
       style="margin-top: 25px; font-size: 10pt; border-collapse: collapse; table-layout: auto;">
    <tbody>
    <tr>
        <td width="80%">
            <table width="100%" cellpadding="8px">
                <tbody>
                <tr>
                    <td width="22%"><strong>Serial</strong></td>
                    <td align="left"
                        style="border-bottom: 1px solid #000">{{ env ('APP_NAME') . '-' . $candidate -> sr_no }}</td>
                    
                    <td width="22%"><strong>Post Applied For</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> job ?-> title }}</td>
                </tr>
                
                <tr>
                    <td width="22%"><strong>First Name</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> first_name }}</td>
                    <td width="22%"><strong>Last Name</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> last_name }}</td>
                </tr>
                
                <tr>
                    <td width="22%"><strong>Mobile No.</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> mobile }}</td>
                    
                    <td width="22%"><strong>CNIC No.</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> cnic }}</td>
                </tr>
                
                <tr>
                    <td width="22%"><strong>Fee</strong></td>
                    <td align="left" colspan="3"
                        style="border-bottom: 1px solid #000">{{ $candidate -> free_candidate == '1' ? 'FREE' : number_format ($candidate -> amount, 2) }}</td>
                </tr>
                
                <tr>
                    <td width="22%"><strong>In Words</strong></td>
                    <td align="left" colspan="3" style="border-bottom: 1px solid #000">
                        @if($candidate -> free_candidate == '1')
                            FREE
                        @else
                            {{ (new NumberFormatter("en", NumberFormatter::SPELLOUT)) -> format ($candidate -> amount) }} only.
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
        <td width="22%" align="right">
            @if($candidate -> document && !empty(trim ($candidate -> document ?-> picture)))
                <img src="{{ $candidate -> document ?-> picture }}"
                     style="width: 120px; border: 1px solid #000000"
                     alt="{{ $candidate -> document ?-> picture }}">
            @endif
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>