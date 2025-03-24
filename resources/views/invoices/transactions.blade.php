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
        
        table {
            width           : 100%;
            border-collapse : collapse;
            border-spacing  : 0;
            margin-bottom   : 10px;
        }
        
        table th {
            padding       : 8px 10px;
            color         : #5D6975;
            background    : #F5F5F5;
            border-bottom : 1px solid #C1CED9;
            white-space   : nowrap;
            font-weight   : normal;
            font-size     : 1.1em;
        }
        
        table td {
            padding       : 8px 10px;
        }
        
        #header td {
            background : #FFFFFF;
            padding    : 0;
        }
    </style>
</head>
<body>
@include('invoices.header-without-footer')

<table width="100%" border="0" cellpadding="0" style="font-size: 9pt; border-collapse: collapse;">
    <tbody>
    <tr>
        <td colspan="4" align="right" width="100%" style="font-size: 22px; text-transform: uppercase">
            <strong>{{ ucwords (request ('voucher-no')) }}</strong>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="left" width="100%" style="padding: 0">
            <strong>Transaction Date:</strong>
            {{ (new \App\Services\GeneralService()) -> only_date_formatter($transactions[0] -> transaction_date) }}
        </td>
        <td colspan="2" align="right" width="100%" style="padding: 0">
            <strong>Payment Mode: </strong> {{ ucwords ($transactions[0] -> payment_mode) }}
        </td>
    </tr>
    <tr>
        <td colspan="2" align="left" width="100%" style="padding: 0">
            <strong>Transaction Performed:</strong>
            {{ (new \App\Services\GeneralService()) -> date_formatter($transactions[0] -> updated_at) }}
        </td>
        @if(!empty(trim ($transactions[0] -> transaction_no)))
            <td colspan="2" align="right" width="100%" style="padding: 0">
                <strong>Cheque/Transaction No: </strong> {{ ucwords ($transactions[0] -> transaction_no) }}
            </td>
        @endif
    </tr>
    </tbody>
</table>
<hr />
<table width="100%" border="0" cellpadding="8px">
    <tbody>
    <tr>
        <td align="center" width="100%">
            <h2>
                {{ (new \App\Http\Helpers\GeneralHelper()) -> get_voucher_title(request ('voucher-no')) }}
            </h2>
        </td>
    </tr>
    </tbody>
</table>

<table width="100%" border="1" style="font-size: 9pt; border-collapse: collapse;" cellpadding="8px" cellspacing="0">
    <thead>
    <tr>
        <th width="10%">Sr. No</th>
        <th align="left">Account Head</th>
        <th align="left">Debit</th>
        <th align="left">Credit</th>
    </tr>
    </thead>
    @php $credit = 0; $debit = 0; @endphp
    <tbody>
    @if(count ($transactions) > 0)
        @foreach($transactions as $transaction)
            @php
                $credit += $transaction -> credit;
                $debit += $transaction -> credit;
            @endphp
            <tr>
                <td align="center">{{ $loop -> iteration }}</td>
                <td>{{ $transaction -> account_head -> name }}</td>
                <td>{{ number_format ($transaction -> debit, 2) }}</td>
                <td>{{ number_format ($transaction -> credit, 2) }}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2" align="right"></td>
        <td>
            <strong>{{ number_format ($debit, 2) }}</strong>
        </td>
        <td>
            <strong>{{ number_format ($credit, 2) }}</strong>
        </td>
    </tr>
    </tfoot>
</table>

<table width="100%" border="0" style="font-size: 9pt; border-collapse: collapse; margin-top: 15px" cellpadding="0"
       cellspacing="0">
    <tbody>
    <tr>
        <td width="22%" style="padding-left: 0">
            <strong>Total Amount In Words:</strong>
        </td>
        <td style="text-transform: uppercase; text-decoration: underline; padding-left: 0">
            {{ (new NumberFormatter("en", NumberFormatter::SPELLOUT)) -> format ($credit) }} Only
        </td>
    </tr>
    </tbody>
</table>

@if(!empty(trim ($transactions[0] -> description)))
    <table width="100%" border="0" style="font-size: 9pt; border-collapse: collapse; margin-top: 0" cellpadding="0"
           cellspacing="0">
        <tbody>
        <tr>
            <td width="22%" style="padding: 0">
                <strong>Description:</strong>
            </td>
            <td style="padding: 0">
                {{ $transactions[0] -> description }}
            </td>
        </tr>
        </tbody>
    </table>
@endif
<hr />

<table width="100%" border="0" style="font-size: 9pt; border-collapse: collapse; margin-top: 100px" cellpadding="0"
       cellspacing="0">
    <tbody>
    <tr>
        <td width="25%" align="center" style="padding-left: 0">
            <strong>{{ \App\Models\User::find($transactions[0] -> user_id) ?-> fullName() }}</strong>
            _____________________________<br />
            Prepared By
        </td>
        
        <td width="25%" align="center" style="padding-left: 0">
            -<br />
            _____________________________<br />
            Verified By
        </td>
        
        <td width="25%" align="center" style="padding-left: 0">
            -<br />
            _____________________________<br />
            Received By
        </td>
        
        <td width="25%" align="center" style="padding-left: 0">
            -<br />
            _____________________________<br />
            Approved By
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>