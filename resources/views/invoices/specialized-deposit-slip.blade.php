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
            font-size   : 10pt;
        }
        
        table {
            border-collapse : collapse;
            table-layout    : fixed
        }
    </style>
</head>
<body>

@include('invoices.specialized-deposit-slip-copies', ['copyName' => 'Depositor Copy'])
<br /><br />
@include('invoices.specialized-deposit-slip-copies', ['copyName' => 'Bank Copy'])

<pagebreak />
@include('invoices.specialized-deposit-slip-copies', ['copyName' => 'OPF Copy'])
<br /><br />
@include('invoices.specialized-deposit-slip-copies', ['copyName' => 'BE&OE Copy'])

</body>
</html>