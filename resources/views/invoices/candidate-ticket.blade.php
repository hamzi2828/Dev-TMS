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

<table width="100%" border="0" cellpadding="2" style="font-size: 9pt; border-collapse: collapse;">
    <tbody>
    <tr>
        <td width="100%" style="height: 100%">
            <strong>{{ env ('APP_NAME') . '-' . $candidate -> sr_no }}</strong>
        </td>
    </tr>
    
    <tr>
        <td width="100%" style="height: 100%">
            <strong>{{ $candidate -> fullName() }}</strong>
        </td>
    </tr>
    
    @if(!empty(trim ($candidate -> job)))
        <tr>
            <td width="100%" style="height: 100%">
                <strong>{{ $candidate -> job ?-> title }}</strong>
            </td>
        </tr>
    @endif
    
    @if(!empty(trim ($candidate -> passport)))
        <tr>
            <td width="100%" style="height: 100%">
                <strong>{{ $candidate -> passport }}</strong>
            </td>
        </tr>
    @endif
    
    <tr>
        <td width="100%" style="height: 100%">
            <strong>{{ $candidate -> createdAt() }}</strong>
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>