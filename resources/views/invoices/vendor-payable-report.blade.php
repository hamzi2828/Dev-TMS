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
        <th>#</th>
        <th align="left">Account Head</th>
        <th align="left">Opening Balance</th>
        <th align="left">Debit</th>
        <th align="left">Credit</th>
        <th align="left">Balance</th>
    </tr>
    </thead>
    <tbody>
    @php
        $net_debit = 0;
        $net_credit = 0;
        $netRB = 0;
        $netOB = 0;
    @endphp
    @if(count ($account_heads) > 0)
        @foreach($account_heads as $account_head)
            @php
                $net_debit          += $account_head -> totalDebit;
                $net_credit         += $account_head -> totalCredit;
                $opening_balance    = (new \App\Services\GeneralLedgerService()) -> get_opening_balance_previous_than_searched_start_date(request ('start-date'), $account_head -> id);
                $running_balance    = (new \App\Services\GeneralLedgerService()) -> calculate_running_balance($opening_balance, $account_head -> totalCredit, $account_head -> totalDebit, $account_head);
                $netRB              += $running_balance;
                $netOB              += $opening_balance;
            @endphp
            
            <tr>
                <td align="center">{{ $loop -> iteration }}</td>
                <td align="left">{{ $account_head -> name }}</td>
                <td align="left">{{ number_format ($opening_balance, 2) }}</td>
                <td align="left">{{ number_format ($account_head -> totalDebit, 2) }}</td>
                <td align="left">{{ number_format ($account_head -> totalCredit, 2) }}</td>
                <td align="left">{{ number_format ($running_balance, 2) }}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2"></td>
        <td>
            <strong>{{ number_format ($netOB, 2) }}</strong>
        </td>
        <td>
            <strong>{{ number_format ($net_debit, 2) }}</strong>
        </td>
        <td>
            <strong>{{ number_format ($net_credit, 2) }}</strong>
        </td>
        <td>
            <strong>{{ number_format (($netOB + $net_credit - $net_debit), 2) }}</strong>
        </td>
    </tr>
    </tfoot>
</table>
</body>
</html>