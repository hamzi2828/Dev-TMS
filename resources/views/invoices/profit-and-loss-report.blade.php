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
@php
    $a = 0;
    $b = 0;
    $c = 0;
    $d = 0;
    $e = 0;
    $f = 0;
    $g = 0;
    $h = 0;
    $i = 0;
    $j = 0;
    $k = 0;
@endphp
<table width="100%" border="1" style="font-size: 9pt; border-collapse: collapse;" cellpadding="8px" cellspacing="0">
    <thead>
    <tr>
        <th align="left">Account Head</th>
        <th align="left">Net Cash</th>
    </tr>
    </thead>
    <tbody>
    
    {!! $sales['items'] !!}
    @php
        $a += $sales['net'];
    @endphp
    
    <tr>
        <td>
            Sales Refund
        </td>
        <td>
            {{ number_format ($sales_refund['net'], 2) }}
            @php
                $b += $sales_refund['net'];
            @endphp
        </td>
    </tr>
    {!! $sale_discounts['items'] !!}
    @php
        $c += $sale_discounts['net'];
        $e = ($a - $b - $c);
    @endphp
    
    <tr>
        <td class="text-danger font-medium-3 fw-bolder">
            <strong>Net Sale</strong>
        </td>
        <td class="text-danger font-medium-3 fw-bolder">
            {{ number_format ($e, 2) }}
        </td>
    </tr>
    
    {!! $direct_costs['items'] !!}
    @php
        $f += $direct_costs['net'];
        $g += $e - $f;
    @endphp
    <tr>
        <td class="text-danger font-medium-3 fw-bolder">
            <strong>Gross Profit/Loss</strong>
        </td>
        <td class="text-danger font-medium-3 fw-bolder">
            {{ number_format ($g, 2) }}
        </td>
    </tr>
    
    {!! $general_admin_expenses['items'] !!}
    @php
        $h += $general_admin_expenses['net'];
        $i = $g - $h;
    @endphp
    <tr>
        <td class="text-danger font-medium-3 fw-bolder">
            <strong>G.Total</strong>
        </td>
        <td class="text-danger font-medium-3 fw-bolder">
            {{ number_format ($h, 2) }}
        </td>
    </tr>
    
    {!! $income['items'] !!}
    
    <tr>
        <td class="text-danger font-medium-3 fw-bolder">
            <strong>Net Profit/Loss (Without Tax)</strong>
        </td>
        <td class="text-danger font-medium-3 fw-bolder">
            @php $i += $income['net'] @endphp
            {{ number_format ($i, 2) }}
        </td>
    </tr>
    
    {!! $taxes['items'] !!}
    @php
        $j += $taxes['net'];
        $k = $i > 0 ? $i - $j : $i + $j;
    @endphp
    
    <tr>
        <td class="text-danger font-medium-3 fw-bolder">
            <strong>Net Profit/Loss (With Tax)</strong>
        </td>
        <td class="text-danger font-medium-3 fw-bolder">
            {{ number_format ($k, 2) }}
        </td>
    </tr>
    
    </tbody>
</table>
</body>
</html>