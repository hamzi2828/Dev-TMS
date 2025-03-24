<table width="100%" border="1" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td width="40%">
            <img src="{{ asset('/assets/img/national-bank-of-pakistan-nbp-vector-logo.png') }}" width="300px"
                 alt="NBP Logo">
        </td>
        <td width="60%">
            <table width="100%" border="1" cellpadding="6px">
                <tbody>
                <tr>
                    <td width="65%" style="font-size: 8pt" align="center">
                        <strong>SPECIALIZED DEPOSIT SLIP</strong>
                    </td>
                    <td width="35%" style="font-size: 8pt" align="center">
                        <strong>{{ $copyName }}</strong>
                    </td>
                </tr>
                <tr>
                    <td width="65%" style="font-size: 8pt" align="center">
                        <strong>On behalf of Bureau of Emigration & Overseas</strong>
                    </td>
                    <td width="35%" style="font-size: 8pt" align="center">
                        <strong>Deposit Slip No.</strong>
                    </td>
                </tr>
                <tr>
                    <td width="65%" style="font-size: 8pt" align="center">
                        <strong>Employment</strong>
                    </td>
                    <td width="35%" style="font-size: 8pt" align="center">
                        <strong>{{ $candidate ?-> cnic[5].$candidate ?-> cnic[6].$candidate ?-> cnic[7].$candidate ?-> cnic[8].$candidate ?-> cnic[9].$candidate ?-> cnic[10].$candidate ?-> cnic[11] }}</strong>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center" style="padding: 8px">
            <h4>EMIGRANT THROUGH OVERSEAS EMPLOYMENT PROMOTER (OEP)</h4>
        </td>
    </tr>
    <tr>
        <td align="left" style="padding: 8px" width="40%">
            <p>Collecting Branch Name</p>
        </td>
        <td width="60%">
            <table width="100%" border="1" cellpadding="8px">
                @php
                    $date = date("m-d-Y");
                    $dateArray = explode("-", $date);
                @endphp
                <tbody>
                <tr>
                    <td style="font-size: 8pt" align="center">B.CODE</td>
                    <td style="font-size: 8pt" align="center">DATE</td>
                    <td style="font-size: 8pt" align="center">
                        <strong>{{ $dateArray[0][0] }}</strong>
                    </td>
                    <td style="font-size: 8pt" align="center">
                        <strong>{{ $dateArray[0][1] }}</strong>
                    </td>
                    <td style="font-size: 8pt" align="center">-</td>
                    <td style="font-size: 8pt" align="center">
                        <strong>{{ $dateArray[1][0] }}</strong>
                    </td>
                    <td style="font-size: 8pt" align="center">
                        <strong>{{ $dateArray[1][1] }}</strong>
                    </td>
                    <td style="font-size: 8pt" align="center">-</td>
                    <td style="font-size: 8pt" align="center">
                        <strong>{{ $dateArray[2][0] }}</strong>
                    </td>
                    <td style="font-size: 8pt" align="center">
                        <strong>{{ $dateArray[2][1] }}</strong>
                    </td>
                    <td style="font-size: 8pt" align="center">
                        <strong>{{ $dateArray[2][2] }}</strong>
                    </td>
                    <td style="font-size: 8pt" align="center">
                        <strong>{{ $dateArray[2][3] }}</strong>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" style="padding: 8px" width="40%">
            <p style="font-size: 8pt">Emigrant Information</p>
        </td>
        <td width="60%">
            <table width="100%" border="1" cellpadding="10px">
                <tbody>
                <tr>
                    <td style="font-size: 8pt; border: 0" align="center"></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" style="padding: 8px" width="40%">
            <p style="font-size: 8pt">Emigrant Name: <strong>{{ $candidate -> fullName() }}</strong></p>
        </td>
        <td width="60%">
            <table width="100%" border="1" cellpadding="10px">
                <tbody>
                <tr>
                    <td style="font-size: 8pt" align="center">
                        <strong>{{ $candidate ?-> cnic[0] }}</strong>
                    </td>
                    <td style="font-size: 8pt" align="center">
                        <strong>{{ $candidate ?-> cnic[1] }}</strong>
                    </td>
                    <td style="font-size: 8pt" align="center">
                        <strong>{{ $candidate ?-> cnic[2] }}</strong>
                    </td>
                    <td style="font-size: 8pt" align="center">
                        <strong>{{ $candidate ?-> cnic[3] }}</strong>
                    </td>
                    <td style="font-size: 8pt" align="center">
                        <strong>{{ $candidate ?-> cnic[4] }}</strong>
                    </td>
                    <td style="font-size: 8pt" align="center">-</td>
                    <td style="font-size: 8pt" align="center">
                        <strong>{{ $candidate ?-> cnic[5] }}</strong>
                    </td>
                    <td style="font-size: 8pt" align="center">
                        <strong>{{ $candidate ?-> cnic[6] }}</strong>
                    </td>
                    <td style="font-size: 8pt" align="center">
                        <strong>{{ $candidate ?-> cnic[7] }}</strong>
                    </td>
                    <td style="font-size: 8pt" align="center">
                        <strong>{{ $candidate ?-> cnic[8] }}</strong>
                    </td>
                    <td style="font-size: 8pt" align="center">
                        <strong>{{ $candidate ?-> cnic[9] }}</strong>
                    </td>
                    <td style="font-size: 8pt" align="center">
                        <strong>{{ $candidate ?-> cnic[10] }}</strong>
                    </td>
                    <td style="font-size: 8pt" align="center">
                        <strong>{{ $candidate ?-> cnic[11] }}</strong>
                    </td>
                    <td style="font-size: 8pt" align="center">-</td>
                    <td style="font-size: 8pt" align="center">
                        <strong>{{ $candidate ?-> cnic[12] }}</strong>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" style="padding: 8px" width="40%">
            <p style="font-size: 8pt">Telephone (Mobile)</p>
        </td>
        <td width="50%" style="padding: 8px">{{ $candidate ?-> mobile }}</td>
    </tr>
    </tbody>
</table>

<table width="100%" border="1" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td align="left" style="padding: 8px" width="80%">
            <p style="font-size: 12px">
                Particulars of Payments - CREDIT TO BE MADE THROUGH TRANSACTION CODE "ZBOEOP"
            </p>
        </td>
        <td width="20%">
            <table width="100%" border="1" cellpadding="10px">
                <tbody>
                <tr>
                    <td style="font-size: 8pt; border: 0" align="center">Amount in Rs</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>

<table width="100%" border="1" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td align="center" style="padding: 10px" width="50%">
            <p style="font-size: 12px">
                "Payments made on behalf of Director General Bureau of Emigration & Overseas Employment"
            </p>
        </td>
        <td width="50%">
            <table width="100%" border="1" cellpadding="8px">
                <tbody>
                <tr>
                    <td style="font-size: 8pt;" align="center">OPF Welfare Fund</td>
                    <td style="font-size: 8pt;" align="center">Rs.4,000/-</td>
                </tr>
                <tr>
                    <td style="font-size: 8pt;" align="center">State Life Insurance Premium</td>
                    <td style="font-size: 8pt;" align="center">Rs. 2,500/-</td>
                </tr>
                <tr>
                    <td style="font-size: 8pt;" align="center">OEC Emigration Promotion FEE</td>
                    <td style="font-size: 8pt;" align="center">Rs. 200/-</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" style="padding: 8px" width="50%">
            <p style="font-size: 10px">Amount in words: <strong>Six thousand and seven hundred only/-</strong></p>
        </td>
        <td width="50%">
            <table width="100%" border="1" cellpadding="8px">
                <tbody>
                <tr>
                    <td style="font-size: 8pt;" align="right" width="69.8%">TOTAL</td>
                    <td style="font-size: 8pt;" align="center">Rs. 6,700/-</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>

<table width="100%" border="1" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td align="center" style="padding: 6px" width="33%">Received By</td>
        <td align="center" style="padding: 6px" width="33%">Authorized By</td>
        <td align="center" style="padding: 6px" width="33%">Depositor's Signature</td>
    </tr>
    <tr>
        <td align="center" style="padding: 0; font-size: 12px">
            <br /><br />
            Cashier's Stamp & Signature
        </td>
        <td align="center" style="padding: 0; font-size: 12px">
            <br /><br />
            Authorized Officer's Signature
        </td>
        <td style="padding: 8px; font-size: 12px">
            Name: <strong>JMS HR CONSULTANT</strong> <br/>
            Contact Number: <strong>051-4932012</strong> <br/> <br/>
            Signature:
        </td>
    </tr>
    <tr>
        <td align="center" style="padding: 0; font-size: 10px">Note: for branch use only</td>
        <td align="center" style="padding: 0; font-size: 10px">Only cash is acceptable</td>
        <td align="center" style="padding: 0; font-size: 10px">Separate slip for every individual</td>
    </tr>
    </tbody>
</table>