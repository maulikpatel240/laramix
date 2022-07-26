<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./font/stylesheet.css">
    <title>Voucher</title>
    <style type="text/css">
        body {
            margin: 0;
            background-color: #cccccc;
            font-family: 'Abhaya Libre';
        }

        p {
            font-family: 'Abhaya Libre';
        }

        table {
            border-spacing: 0;
        }

        td {
            padding: 0;
        }

        img {
            border: 0;
        }

        .main {
            background-color: #ffffff;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            border-spacing: 0;
            padding: 30px 40px;
            color: #4a4a4a;
            font-family: sans-serif;

        }

        @media (max-width: 600px) {
            .two_column {
                text-align: center;
            }

        }

        @media (max-width: 583px) {
            td {
                text-align: center;
            }
        }

    </style>
</head>

<body>
    <table class="main" width="100%">
        <tr>
            <td>
                <p style="font-size: 40px; line-height: 46px; color: #000; font-weight: 700; margin: 0;">
                    {{ $data['voucherModal']['name'] }}
                </p>
            </td>
            <td>
                <img src={{ $data['business_logo'] }} alt="logo">
            </td>
        </tr>
        <tr>
            <td>
                <p style="font-size: 26px; font-weight: 400; margin: 0;">${{ $data['voucherModal']['amount'] }}</p>
                <p style="font-size: 22px; font-weight: 400; margin: 0;">{{ $data['voucherModal']['description'] }}
                </p>
            </td>
        </tr>
        <tr>
            <td style="padding-top: 50px;">
                <p style="margin: 0; font-size: 14px; line-height: 21px; font-weight: 500;">To</p>
                <p style="margin: 0;">{{ $data['recipient_name'] }}</p>
            </td>

        </tr>
        <tr>
            <td style="padding-top: 20px;">
                <p style="margin: 0; font-size: 14px; line-height: 21px; font-weight: 500;">From</p>
                <p style="margin: 0;">{{ $data['sender_name'] }}</p>
            </td>
        </tr>
        <tr>
            <td style="padding-top: 20px;">
                <p style="margin: 0; padding-bottom: 5px; font-size: 14px; line-height: 21px; font-weight: 500;">Note
                </p>
                <p style="margin: 0; font-size: 20px; line-height: 25px;">{{ $data['message'] }}</p>
            </td>
        </tr>

        <tr>
            <td style="padding-top: 20px;">
                <p style="margin: 0; padding-bottom: 5px; font-size: 14px; line-height: 21px; font-weight: 500;">Expiry
                </p>
                <p style="margin: 0;  font-size: 20px; line-height: 25px;">Valid for
                    {{ $data['voucherModal']['valid'] }} month(s)</p>
            </td>
        </tr>
        <tr>
            <td style="padding-top: 20px;">
                <p style="margin: 0; padding-bottom: 5px; font-size: 14px; line-height: 21px; font-weight: 500;">Voucher
                    code:</p>
                <p style="margin: 0;  font-size: 20px; line-height: 25px;">{{ $data['voucherModal']['code'] }}</p>
            </td>
        </tr>
        <tr>
            <td style="padding-top: 20px;">
                <p style="margin: 0; padding-bottom: 5px; font-size: 14px; line-height: 21px; font-weight: 500;">Redeem
                    on:</p>
                <p style="margin: 0;">---</p>
            </td>
        </tr>
        <tr>
            <td style="padding-top: 20px;">
                <p style="font-size: 22px; color: #374151; font-weight: 600; margin: 0; padding-bottom: 5px;">
                    {{ $data['business_name'] }}</p>
                <p style="font-size: 18px;
                 margin: 0;">{{ $data['business_address'] }}</p>
            </td>
        </tr>
        <tr>
            <td style="padding-top: 20px;">
                <p style="margin: 0; font-size: 13px;
                line-height: 20px; color: rgba(0,0,0,.8);">{{ $data['voucherModal']['terms_and_conditions'] }}</p>
            </td>
        </tr>
    </table>

</body>

</html>
