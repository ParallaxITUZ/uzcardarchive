<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Travel policy</title>
    <style>
        body, html {
            height: 100%;
            padding: 0 20px 20px;
            margin: 0;
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }
        table {
            margin: auto;
            border-collapse: collapse;
            width: 500px;
        }
        td, th {
            border: 1px solid #222;
            text-align: left;
            padding: 5px;
        }
        th {
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
        .vertical-th {
            width: 40px;
            position: relative;
        }
        .vertical-th span {
            transform: rotate(-90deg);
            left: 0;
            white-space: nowrap;
            position: absolute;
            width: 100%;
            height: auto;
        }
        .vertical-th.v1 span {
            top: 50px;
        }
        .vertical-th.v2 span {
            top: 80px;
        }
        .vertical-th.v3 span {
            top: 150px;
        }
        .vertical-th.v4 span {
            top: 80px;
        }
        img {
            width: 140px;
            height: auto;
        }
        .header {
            margin: auto;
            display: block;
            height: 70px;
            width: 500px;
        }
        .header .img {
            display: inline-block;
            float:left;
            width: 50%;
        }
        .header h2 {
            display: inline-block;
            float: right;
            width: 50%;
            text-align: right;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="img">
        <img src="data:image/svg+xml;base64,{{$base64}}" alt="Kafolat logo">
    </div>
    <h2>
        Серия {{$contract_policy->series}} <br>
        № {{str_pad($contract_policy->number, 7, '0', STR_PAD_LEFT)}}
    </h2>
</div>
<div class="text-center">

    <table>
        <!-- POLICY HOLDER Information -->
        <tr>
            <th rowspan="5" class="vertical-th v1">
            <span>
                POLICY HOLDER <br>
                Страхователь
            </span>
            </th>
            <th colspan="2">NAME / Наименование (Ф.И.О.)</th>
        </tr>
        <tr>
            <td colspan="2">{{$client->individual->first_name}} {{$client->individual->last_name}}</td>
        </tr>
        <tr>
            <th colspan="2">ADDRESS /Адрес</th>
        </tr>
        <tr>
            <td colspan="2">{{$client->address}}</td>
        </tr>
        <tr>
            <th>PHONE / № телефона</th>
            <td>{{$client->phone_number}}</td>
        </tr>
    </table>
    <table>
        <!-- INSURANCE OBJECT Information -->
        <tr>
            <th rowspan="7" class="vertical-th v2">
            <span>
                INSURED PERSON <br>
                Застрахованные лица
            </span>
            </th>
            <td class="text-center">
                <b>LAST NAME, FIRST NAME</b><br>
                Фамилия, Имя
            </td>
            <td class="text-center">
                <b>PASSPORT#</b><br>
                № Паспорта
            </td>
            <td class="text-center">
                <b>DATE OF BIRTHDAY</b><br>
                Дата рождения
            </td>
        </tr>
        @foreach($contract->objects as $object)
        <tr>
            <td>{{$object['first_name']}} {{$object['last_name']}}</td>
            <td>{{$object['pass_seria']}} {{$object['pass_number']}}</td>
            <td>{{$object['birthdays']}}</td>
        </tr>
        @endforeach
        @for($i = count($contract->objects); $i < 6; $i++)
            <tr>
                <td>-------------------------</td>
                <td>--------------</td>
                <td>--------------</td>
            </tr>
        @endfor

    </table>
    <table>
        <!-- INSURANCE POLICY CONFIGURATIONS Information -->
        <tr>
            <th rowspan="10" class="vertical-th v3">
            <span>
                TRAVEL INSURANCE POLICY <br>
                Страхование лиц, выезжающих за рубеж
            </span>
            </th>
            <td colspan="2" class="text-center">
                <b>HOST COUNTRY / Страна поездки</b>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                @foreach($countries as $country)
                <b>{{$country->display_name}}</b>
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-center"><b>SPECIAL CONDITION / Особые условия</b></td>
        </tr>
        <tr>
            <td colspan="2"><b>{{$contract->tariff->name}}</b></td>
        </tr>
        <tr>
            <td>
                <b>SUM INSURED</b><br>
                Страховая сумма
            </td>
            <td class="text-center"><b>&euro;{{ number_format($summ, 2) }}</b></td>
        </tr>
        <tr>
            <td>
                <b>NUMBER OF DAYS</b><br>
                Количество дней
            </td>
            <td class="text-center"><b>{{$contract->configurations['days']}}</b></td>
        </tr>
        <tr>
            <td colspan="2" class="text-center"><b>PERIOD OF INSURANCE/Период страхования</b></td>
        </tr>
        <tr>
            <td><b>from/с {{$contract->configurations['begin_date']}}</b></td>
            <td><b>to/по {{$contract->configurations['end_date']}} </b></td>
        </tr>
        <tr>
            <td>
                <b>INSURANCE PREMIUM</b><br>
                Страховая премия
            </td>
            <td class="text-center"><b>{{number_format($invoice->amount, 2, '.', ' ')}} UZS</b></td>
        </tr>
        <tr>
            <td><b>DATA OF ISSUE/ Дата выдачи</b></td>
            <td class="text-center"><b>{{$contract->configurations['end_date']}}</b></td>
        </tr>
        <!-- INSURANCE POLICY SIGNATURES Information -->
        <tr>
            <th rowspan="4" class="vertical-th v4">
            <span>
                SIGNATURE / QR code <br>
                Подпись / QR код
            </span>
            </th>
            <td>
                <b>POLICY HOLDER<br>
                    Страхователь</b>
            </td>
            <td rowspan="4" class="text-center"><span style="display: inline-block">{!! DNS2D::getBarcodeHTML($root."/storage/files/".$fname, 'QRCODE', 4,4) !!}</span></td>
        </tr>
        <tr>
            <td><b>√</b></td>
        </tr>
        <tr>
            <td><b>INSURER/Страховщик</b></td>
        </tr>
        <tr>
            <td><b>&nbsp;</b></td>
        </tr>
    </table>
    <table>
        <!-- INSURANCE POLICY FRANSHIZA Information -->
        <tr>
            <td class="text-center">
                <b>I hereby declare that I have read and agreed with the insurance rules.</b> <br>
                Настоящим заявляю, что с правилами страхования ознакомлен и согласен. <br>
                <b>FRANCHISE 50 (FIFTY) USD / ФРАНШИЗА 50 (ПЯТЬДЕСЯТ) USD</b>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
