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
        <th align="left">Account Head</th>
        <th align="left">Closing Balance</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="2">
            <strong>
                {{ \App\Models\Account::find(config ('constants.current_assets')) -> name }}
            </strong>
        </td>
    </tr>
    {!! $current_assets['html'] !!}
    <tr>
        <td></td>
        <td>
            <strong style="font-size: 16px; color: #FF0000">
                {{ number_format ($current_assets['net'], 2) }}
            </strong>
        </td>
    </tr>
    
    <tr>
        <td colspan="2">
            <strong>
                {{ \App\Models\Account::find(config ('constants.non_current_assets')) -> name }}
            </strong>
        </td>
    </tr>
    {!! $non_current_assets['html'] !!}
    <tr>
        <td></td>
        <td>
            <strong style="font-size: 16px; color: #FF0000">
                {{ number_format ($non_current_assets['net'], 2) }}
            </strong>
        </td>
    </tr>
    
    <tr>
        <td align="right">
            <strong>
                Total Assets
            </strong>
        </td>
        <td>
            <strong style="font-size: 16px; color: #FF0000">
                {{ number_format (($current_assets['net'] + $non_current_assets['net']), 2) }}
            </strong>
        </td>
    </tr>
    
    <tr>
        <td colspan="2">
            <strong>
                {{ \App\Models\Account::find(config ('constants.liabilities')) -> name }}
            </strong>
        </td>
    </tr>
    {!! $liabilities['html'] !!}
    <tr>
        <td align="right">
            <strong>
                Total Liabilities
            </strong>
        </td>
        <td>
            <strong style="font-size: 16px; color: #FF0000">
                {{ number_format ($liabilities['net'], 2) }}
            </strong>
        </td>
    </tr>
    
    <tr>
        <td colspan="2">
            <strong style="font-size: 16px; color:#FF0000">
                Shareholder's Equity
            </strong>
        </td>
    </tr>
    
    <tr>
        <td colspan="2">
            <strong>
                {{ \App\Models\Account::find(config ('constants.capital')) -> name }}
            </strong>
        </td>
    </tr>
    {!! $capital['html'] !!}
    <tr>
        <td></td>
        <td>
            <strong style="font-size: 16px; color: #FF0000">
                {{ number_format ($capital['net'], 2) }}
            </strong>
        </td>
    </tr>
    
    <tr>
        <td>
            <strong>Net Profit (P&L)</strong>
        </td>
        <td>
            <strong style="font-size: 16px; color: #FF0000">
                {{ number_format ($profit, 2) }}
            </strong>
        </td>
    </tr>
    
    <tr>
        <td align="right">
            <strong>
                Total Equity
            </strong>
        </td>
        <td>
            <strong style="font-size: 16px; color: #FF0000">
                {{ number_format (abs ($capital['net']) + $profit, 2) }}
            </strong>
        </td>
    </tr>
    
    <tr>
        <td>
            <strong style="font-size: 16px; color: #000000">
                Total Assets = Total Liabilities + Total Capital
            </strong>
        </td>
        <td>
            <strong style="font-size: 16px; color: #FF0000">
                {{ number_format (($current_assets['net'] + $non_current_assets['net']), 2) }}
                =
                {{ number_format (($liabilities['net'] + abs ($capital['net']) + $profit), 2) }}
            </strong>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>