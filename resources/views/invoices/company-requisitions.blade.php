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
        <th align="left">MRF. No</th>
        <th align="left">Principal</th>
        <th align="left">Profession</th>
        <th align="left">Demand</th>
        <th align="left">Used</th>
        <th align="left">Remaining</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td></td>
        <td>{{ env ('MRF_NO') . $requisition -> id }}</td>
        <td colspan="5" style="font-size: 12pt; color: #ff0000">
            <strong>{{ $requisition -> principal ?-> name }}</strong>
        </td>
    </tr>
    @if(count ($requisition -> jobs) > 0)
        @foreach($requisition -> jobs as $job)
            @php $allocatedQuota = (new \App\Services\CandidateCompanyRequisitionJobService()) -> count_allocated_quota($job -> id); @endphp
            <tr>
                <td align="center">{{ $loop -> iteration }}</td>
                <td colspan="2"></td>
                <td>{{ $job -> job ?-> title }}</td>
                <td>{{ $job -> quota }}</td>
                <td>
                    {{ $allocatedQuota }}
                </td>
                <td>
                    {{ $job -> quota - $allocatedQuota }}
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
</body>
</html>