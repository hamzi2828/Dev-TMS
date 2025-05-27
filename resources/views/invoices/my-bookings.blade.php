<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fly Jinnah | Ticket Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fff;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 30px;
        }
        .logo {
            text-align: right;
        }
        .logo img {
            width: 150px;
        }
        .title {
            font-size: 22px;
            font-weight: bold;
            color: #0a71b9;
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 18px;
            margin: 30px 0 10px;
            font-weight: bold;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="{{ $data['booking']->airline->file }}" alt="{{ $data['booking']->airline->title }} Logo" style="max-height: 80px;">
        </div>

        <div class="title">Electronic Ticket Reservation</div>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 10px;">
            <tr>
                <td style="padding: 2px 0; font-weight: bold;">Booking Reference Number (PNR)</td>
                <td style="padding: 2px 0;">{{ $data['booking']->pnr }}</td>
            </tr>
            <tr>
                <td style="padding: 2px 0; font-weight: bold;">Booking ID</td>
                <td style="padding: 2px 0;">{{ $data['booking']->id }}</td>
            </tr>
            <tr>
                <td style="padding: 2px 0; font-weight: bold;">Issued By</td>
                <td style="padding: 2px 0;">n/a</td>
            </tr>
            <tr>
                <td style="padding: 2px 0; font-weight: bold;">Agent Name</td>
                <td style="padding: 2px 0;">n/a</td>
            </tr>
            <tr>
                <td style="padding: 2px 0; font-weight: bold;">Contact</td>
                <td style="padding: 2px 0;">n/a</td>
            </tr>
        </table>

@php
    $segments = $data['airlineGroup']->segments;
@endphp

@foreach($segments as $index => $segment)
@php
    $originCity = \App\Models\City::find($segment->origin);
    $destinationCity = \App\Models\City::find($segment->destination);
    $route = ($originCity ? $originCity->title . ' (' . $originCity->code . ')' : 'N/A') .
             ' to ' .
             ($destinationCity ? $destinationCity->title . ' (' . $destinationCity->code . ')' : 'N/A');
@endphp

<div style="color: #808080; font-size: 16px; font-weight: bold; margin: 15px 0 5px 0;">
    Flight {{ $index + 1 }} - {{ $route }}
</div>

<table style="width: 100%; border: 1px solid #ccc; border-collapse: collapse; font-size: 12px; margin-bottom: 20px;">
    <tr style="background-color: #f2f2f2; border-bottom: 1px solid #ccc;">
        <th style="text-align: left; padding: 8px; font-weight: bold;">AIRLINE</th>
        <th style="text-align: left; padding: 8px; font-weight: bold;">FLIGHT #</th>
        <th style="text-align: left; padding: 8px; font-weight: bold;">DEPARTURE</th>
        <th style="width: 50px;"></th>
        <th style="text-align: left; padding: 8px; font-weight: bold;">ARRIVAL</th>
    </tr>
    <tr style="border-bottom: 1px solid #f2f2f2;">
        <td style="padding: 10px 8px;">{{ $data['booking']->airline->title }}</td>
        <td style="padding: 10px 8px;">{{ $segment->flight_number }}</td>
        <td style="padding: 10px 8px;">
            <strong>{{ \Carbon\Carbon::parse($segment->departure_time)->format('H:i') }}</strong><br>
            {{ $originCity->title ?? 'N/A' }} ({{ $originCity->code ?? 'N/A' }})<br>
            <span style="color: #666;">{{ \Carbon\Carbon::parse($segment->departure_date)->format('D d M Y') }}</span>
        </td>
        <td style="text-align: center; padding: 10px 8px;"><img src="{{ asset('assets/flt2.png') }}" alt="flight" style="width: 24px; height: 24px; transform: rotate(180deg);"></td>
        <td style="padding: 10px 8px;">
            <strong>{{ \Carbon\Carbon::parse($segment->arrival_time)->format('H:i') }}</strong><br>
            {{ $destinationCity->title ?? 'N/A' }} ({{ $destinationCity->code ?? 'N/A' }})<br>
            <span style="color: #666;">{{ \Carbon\Carbon::parse($segment->arrival_date ?? $segment->departure_date)->format('D d M Y') }}</span>
        </td>
    </tr>
    @if($segment->baggage)
    <tr>
        <td colspan="5" style="padding: 8px; background-color: #f9f9f9;">
            <strong>Baggage:</strong> {{ $segment->baggage }}
        </td>
    </tr>
    @endif
</table>
@endforeach

        <div class="section-title">Passenger Information</div>
        <table style="width: 100%; border: 1px solid #ccc; border-collapse: collapse; font-size: 12px; margin-bottom: 20px;">
            <tr style="background-color: #f2f2f2; border-bottom: 1px solid #ccc;">
                <th style="padding: 8px; text-align: left; font-weight: bold;">Sr #</th>
                <th style="padding: 8px; text-align: left; font-weight: bold;">Passenger Name</th>
                <th style="padding: 8px; text-align: left; font-weight: bold;">Passport #</th>
                <th style="padding: 8px; text-align: left; font-weight: bold;">Type</th>
                <th style="padding: 8px; text-align: left; font-weight: bold;">DOB</th>
                <th style="padding: 8px; text-align: left; font-weight: bold;">Passport Expiry</th>
            </tr>
            @foreach($data['booking']->passengers as $index => $passenger)
            <tr style="border-bottom: 1px solid #f2f2f2;">
                <td style="padding: 10px 8px;">{{ $index + 1 }}</td>
                <td style="padding: 10px 8px;">{{ $passenger->title }} {{ $passenger->given_name }} {{ $passenger->surname }}</td>
                <td style="padding: 10px 8px;">{{ $passenger->passport }}</td>
                <td style="padding: 10px 8px; text-transform: capitalize;">{{ $passenger->passenger_type }}</td>
                <td style="padding: 10px 8px;">{{ \Carbon\Carbon::parse($passenger->dob)->format('d M Y') }}</td>
                <td style="padding: 10px 8px;">{{ \Carbon\Carbon::parse($passenger->passport_expiry)->format('d M Y') }}</td>
            </tr>
            @endforeach
        </table>

        <div class="footer">
            <p><strong>Terms & Conditions</strong></p>
            <p>1- Passenger should report at check-in counter at least 04:00 hours prior to flight.</p>
            <p>2- Tickets are non-refundable and non-changeable any time.</p>
        </div>
    </div>
</body>
</html>
