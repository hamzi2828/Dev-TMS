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
        }
    </style>
</head>
<body>
@include('invoices.header-footer')
<table width="100%" border="0" cellpadding="8px">
    <tbody>
    <tr>
        <td align="center">
            <h2>{{ $title }}</h2>
        </td>
    </tr>
    </tbody>
</table>

<table width="100%" border="1" style="font-size: 9pt; border-collapse: collapse;" cellpadding="8px" cellspacing="0">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th align="left"> Trans. ID</th>
        <th align="left"> Invoice/Sale ID</th>
        <th align="left"> Chq/Trans. No</th>
        <th align="left"> Voucher No.</th>
        <th align="left"> Date</th>
        <th align="left"> Description</th>
        <th align="left"> Debit</th>
        <th align="left"> Credit</th>
        <th align="left"> Running Balance</th>
    </tr>
    </thead>
    <tbody>
    {!! $ledgers['html'] !!}
    </tbody>
    <tfoot>
    <tr>
        <td></td>
        <td colspan="8" align="right">
            <strong style="font-size: 12pt; color: #000000;">Net Closing</strong>
        </td>
        <td>
            <strong style="font-size: 12pt; color: #000000;">
                {{ number_format ( $ledgers[ 'net_closing' ], 2 ) }}
            </strong>
        </td>
    </tr>
    </tfoot>
</table>
</body>
</html>