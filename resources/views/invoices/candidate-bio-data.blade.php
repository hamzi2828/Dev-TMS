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

<sethtmlpageheader name="myheader" page="all" value="on" show-this-page="1"/>
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

<table width="100%" border="0" cellpadding="2"
       style="margin-top: 20px; font-size: 9pt; border-collapse: collapse; vertical-align: top;">
    <tbody>
    <tr>
        <td align="left" style="font-size: 11pt" width="35%">
            Sr.No: <strong><u>{{ env ('APP_NAME') . '-' . $candidate -> sr_no }}</u></strong> <br />
            Applied For: <strong><u>{{ $candidate -> job ?-> title }}</u></strong><br />
            Selected For :  _____________________<br />
            Transaction No:<strong><u>{{ $candidate -> transaction_no }}</u></strong><br />
            Date Added :<strong><u>{{ $candidate -> createdAt() }}</u></strong>
        </td>
        
        <td align="left" width="40%">
            <h3 style="text-decoration: underline; text-transform: uppercase">Candidate Bio-Data Form</h3>
        </td>
        
        <td width="20%" align="right">
            @if($candidate -> document && !empty(trim ($candidate -> document ?-> picture)))
                <img src="{{ $candidate -> document ?-> picture }}"
                     style="width: 80px; border: 1px solid #000000"
                     alt="{{ $candidate -> document ?-> picture }}">
            @endif
        </td>
    </tr>
    </tbody>
</table>
<hr />

<table width="100%" border="0"
       style="font-size: 10pt; border-collapse: collapse; table-layout: auto; vertical-align: top">
    <tbody>
    <tr>
        <td width="100%">
            <table width="100%" cellpadding="5px">
                <tbody>
                <tr>
                    <td width="22%"><strong>First Name</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> first_name }}</td>
                    
                    <td width="25%" style="padding-left: 15px"><strong>Age</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> age . ' Years' }}</td>
                </tr>
                
                <tr>
                    <td width="22%"><strong>Last Name</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> last_name }}</td>
                    
                    <td width="25%" style="padding-left: 15px"><strong>Mobile No.</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> mobile }}</td>
                </tr>
                
                <tr>
                    <td width="22%"><strong>Father Name</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> father_name }}</td>
                    
                    <td width="25%" style="padding-left: 15px"><strong>Alternate No.</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> alt_no }}</td>
                </tr>
                
                <tr>
                    <td width="22%"><strong>Mother Name</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> mother_name }}</td>
                    
                    <td width="25%" style="padding-left: 15px"><strong>Marital Status</strong></td>
                    <td align="left"
                        style="border-bottom: 1px solid #000">{{ str () -> title ($candidate -> marital_status) }}</td>
                </tr>
                
                <tr>
                    <td width="22%"><strong>CNIC No.</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> cnic }}</td>
                    
                    <td width="25%" style="padding-left: 15px"><strong>Religion</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> religion }}</td>
                </tr>
                
                <tr>
                    <td width="22%"><strong>Place of Birth</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> city ?-> title }}</td>

                </tr>
                
                 <tr>
                    <td width="22%"><strong>Passport No.</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> passport }}</td>
                    
                    <td width="25%" style="padding-left: 15px"><strong>passport Expiry Date</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate ->passport_expiry_date }}</td>
                </tr>
                
                           
                
                <tr>
                    <td width="22%"><strong>Next of Kin</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> next_of_kin }}</td>
                    
                    <td width="25%" style="padding-left: 15px"><strong>Kin Relation</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> kin_relationship }}</td>
                </tr>
                <tr>
                    <td width="22%"><strong>Kin Contact No.</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> contact_no }}</td>
                    
                    <td width="25%" style="padding-left: 15px"><strong>Shirt Size</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> shirt_size }}</td>
                </tr>
                
                <tr>
                    <td width="22%"><strong>Trouser Size</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> trouser_size }}</td>
                    
                    <td width="25%" style="padding-left: 15px"><strong>Shoes Size</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> shoes_size }}</td>
                </tr>
                
                <tr>
                    <td width="22%"><strong>Weight</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> weight }}kg</td>
                    
                    <td width="25%" style="padding-left: 15px"><strong>Height</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> height }}ft,in</td>
                </tr>
                
                <tr>
                    <td width="22%"><strong>Qualification</strong></td>
                    <td align="left"
                        style="border-bottom: 1px solid #000">{{ $candidate -> qualification ?-> title }}</td>
                    
                    <td width="25%" style="padding-left: 15px"><strong>Email Address</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> email }}</td>
                </tr>
                
                <tr>
                    <td width="22%"><strong>Bank</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> bank ?-> title }}</td>
                    
                    <td width="25%" style="padding-left: 15px"><strong>Account No</strong></td>
                    <td align="left" style="border-bottom: 1px solid #000">{{ $candidate -> account_no }}</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>

<table width="100%" border="1" cellpadding="15px"
       style="margin-top: 45px; font-size: 12pt; border-collapse: collapse; direction: rtl;">
    <tbody>
    <tr>
        <td align="center">
            <p>
                نوٹ: ویزہ آنے کے صرف سات دنوں تک کمپنی ٹکٹ کی ذمہ دار ہے۔ اسکے بعد کمپنی ٹکٹ کی ذمہ دار نہیں۔ ٹکٹ کراچی،
                لاہور، اسلام آباد، سیالکوٹ، فیصل آباد، ملتان، پشاور کے ائیر پورٹ سے ہو سکتی ہے۔
            </p>
        </td>
    </tr>
    </tbody>
</table>

<table width="100%" border="0" cellpadding="8px"
       style="margin-top: 100px; font-size: 9pt; border-collapse: collapse;">
    <tbody>
    <tr>
        <td align="right">
            _____________________ <br /><br />
            <p>Candidate Signature</p>
        </td>
    </tr>
    </tbody>
</table>



<htmlpagefooter name="myfooter">
    
        <table width="100%" border="0" cellpadding="8px"
       style="margin-top: 100px; font-size: 9pt; border-collapse: collapse;">
    <tbody>
    <tr>
        <td align="right">
           
            <strong> Sr.No: <u>{{ env ('APP_NAME') . '-' . $candidate -> sr_no }}</u></strong> <br />
           <strong> Applied For: <u>{{ $candidate -> job ?-> title }}</u></strong><br />
        </td>
    </tr>
    </tbody>
</table>


<table width="100%" style="border-top: 1px solid #e3e3e3; font-size: 9pt;">
    <tr>
        <td align="center">
            Disclaimer: I solemnly affirm and declare that the above information provided
            by me is true and correct to the best of my knowledge and belief, and
            nothing has been concealed therefrom.
        </td>
    </tr>
</table>
</htmlpagefooter>

<sethtmlpagefooter name="myfooter" page="all" value="on" show-this-page="1"/>




</body>
</html>