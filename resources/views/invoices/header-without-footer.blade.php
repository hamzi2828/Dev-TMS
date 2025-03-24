@php $settings = \App\Models\SiteSetting::first(); @endphp
<!--mpdf
<htmlpageheader name="myheader">
<table width="100%" style="border-bottom: 1px solid #e3e3e3">
    <tbody>
        <tr>
            <td align="left" width="50%" style="color:#000; text-align: left">
                <img src="{{ $settings -> settings ?-> logo }}" height="90px">
            </td>
            <td align="right" width="50%" style="color:#000; text-align: right">
                <span style="font-size: 22; margin: 0; padding: 0">
                    <strong>{{ $settings -> settings -> title }}</strong>
                </span> <br /> <br />
                @if(!empty(trim ($settings -> settings -> email)))
                    <span style="font-size: 12px;">&#x2709; {{ $settings -> settings -> email }}</span><br />
                @endif
                @if(!empty(trim ($settings -> settings -> phone)))
                    <span style="font-size: 12px;">&#x260E; {{ $settings -> settings -> phone }}</span><br />
                @endif
                @if(!empty(trim ($settings -> settings -> address)))
                    <span style="font-size: 12px;">{{ $settings -> settings -> address }}</span><br />
                @endif
            </td>
        </tr>
    </tbody>
</table>
</htmlpageheader>

<htmlpagefooter name="myfooter"></htmlpagefooter>

<sethtmlpageheader name="myheader" page="all" value="on" show-this-page="1"/>
<sethtmlpagefooter name="myfooter" page="all" value="on"/>
mpdf-->