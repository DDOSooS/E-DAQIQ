
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Invoice</title>

    <style>
        @font-face {
            font-family: "Inter";
            src: url("../../../fonts/Inter-Regular.ttf") format("truetype");
            font-weight: 400;
            font-style: normal;
        }

        @font-face {
            font-family: "Inter";
            src: url("../../../fonts/Inter-Medium.ttf") format("truetype");
            font-weight: 500;
            font-style: normal;
        }

        @font-face {
            font-family: "Inter";
            src: url("../../../fonts/Inter-Bold.ttf") format("truetype");
            font-weight: 700;
            font-style: normal;
        }

        @font-face {
            font-family: "Space Mono";
            src: url("../../../fonts/SpaceMono-Regular.ttf") format("truetype");
            font-weight: 400;
            font-style: normal;
        }

        body {
            font-size: 0.75rem;
            font-family: "Inter", sans-serif;
            font-weight: 400;
            color: #000000;
            margin: 0 auto;
            padding-top: .6rem;
            position: relative;
        }

        #pspdfkit-header {
            font-size: 0.625rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 400;
            color: #717885;
            margin-top: 2.5rem;
            margin-bottom: 2.5rem;
            width: 100%;
        }

        .header-columns {
            display: flex;
            justify-content: space-between;
            padding-left: 2.5rem;
            padding-right: 2.5rem;
        }

        .logo {
            height: 3.5rem;
            width: auto;
            margin-right: 1rem;
        }

        .logotype {
            display: flex;
            align-items: center;
            font-weight: 700;
        }

        h2 {
            font-family: "Space Mono", monospace;
            font-size: 1.25rem;
            font-weight: 400;
        }

        h4 {
            font-family: "Space Mono", monospace;
            font-size: 1rem;
            font-weight: 400;
        }

        .page {
            margin-left: 5rem;
            margin-right: 5rem;
        }

        .intro-table {
            display: flex;
            justify-content: space-between;
            margin: 1rem 0 1rem 0;
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
        }

        .intro-form {
            display: flex;
            flex-direction: column;
            border-right: 1px solid #000000;
            width: 50%;
        }

        .intro-form:last-child {
            border-right: none;
        }

        .intro-table-title {
            font-size: 0.625rem;
            margin: 0;
        }
        .title {
            font-size: 1.25rem;
            margin: 0;
        }

        .intro-form-item {
            padding: 1.25rem 1.5rem 1.25rem 1.5rem;
        }

        .intro-form-item:first-child {
            padding-left: 0;
        }

        .intro-form-item:last-child {
            padding-right: 0;
        }

        .intro-form-item-border {
            padding: 1.25rem 0 0.75rem 1.5rem;
            border-bottom: 1px solid #000000;
        }

        .intro-form-item-border:last-child {
            border-bottom: none;
        }

        .form {
            display: flex;
            flex-direction: column;
            margin-top: 6rem;
        }

        .no-border {
            border: none;
        }

        .border {
            border: 1px solid #000000;
        }

        .border-bottom {
            border: 1px solid #000000;
            border-top: none;
            border-left: none;
            border-right: none;
        }

        .signer {
            display: flex;
            justify-content: space-between;
            gap: 2.5rem;
        }

        .signer-item {
            flex-grow: 1;
        }

        input {
            color: #4537de;
            font-family: "Space Mono", monospace;
            text-align: center;
            margin-top: 1.5rem;
            height: 4rem;
            width: 100%;
            box-sizing: border-box;
        }

        input#date,
        input#notes {
            text-align: left;
        }

        input#signature {
            height: 8rem;
        }

        .intro-text {
            width: 60%;
        }

        .table-box table,
        .table-box1 table,
        .summary-box table {
            width: 100%;
            font-size: 0.625rem;
        }

        .table-box table , .table-box1 table{
            padding-top: 2rem;
        }
        .summary-box{
            border-top: 1px solid #000000;
            padding-top: .3rem;
        }

        .table-box td:first-child,
        .summary-box td:first-child {
            width: 50%;
        }
        .table-box1 td:first-child{
            width: 33.33%;
        }
        .table-box1{
            margin-top: 1.1rem;
        }
        .table-box1 td{
            text-align: left;
        }

        .table-box td:last-child,
        .summary-box td:last-child {
            text-align: right;
        }

        .table-box table tr.heading td {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
            height: 1.5rem;
        }

        .table-box table tr.item td,
        .table-box1 table tr.item td,
        .summary-box table tr.item td {
            border-bottom: 1px solid #d7dce4;
            height: 1.5rem;
        }

        .summary-box table tr.no-border-item td {
            border-bottom: none;
            height: 1.5rem;
        }

        .summary-box table tr.total td {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
            height: 1.5rem;
        }

        .summary-box table tr.item td:first-child,
        .summary-box table tr.total td:first-child {
            border: none;
            height: 1.5rem;
        }
        .right{
            text-align: right;
        }
        #pspdfkit-footer {
            font-size: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 500;
            color: #717885;
            margin-top: 2.5rem;
            bottom: 2.5rem;
            position: absolute;
            width: 100%;
        }

        .footer-columns {
            display: flex;
            justify-content: space-between;
            padding-left: 2.5rem;
            padding-right: 2.5rem;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <!-- html2pdf CDN link -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    ></script>
</head>

<body>
<button type="button" id="download-button"  class="btn btn-primary btn-sm">تنزيل كملف PDF</button>
<a href="{{url('/invoice-case',$dossier->id)}}">
    <button type="button" class="btn btn-info btn-sm"> الرجوع</button>
</a>
<div id="invoice">
    <div id="pspdfkit-header">
        <div class="header-columns">
            <div class="logotype">
                <img class="logo" src="{{ Storage::url($cabinet->logo)}}" alt="Logo">
                <p>SERVICE FINANCIER {{$cabinet->nom}}</p>
            </div>

            <div>
                <p>[{{$cabinet->siege}}]</p>
            </div>
        </div>
    </div>

    <div class="page" style="page-break-after: always">
        <div>
            <h2> {{$note->numNote}} فاتورة #</h2>
        </div>

        <div class="intro-table ">
            <div class="intro-form intro-form-item">
                <p class="title"> A Monsieur :</p>
                <p>
                    <span class="">
                        {{( $type==1)?"le Directeur de la Direction des  Affaires Juridiques de  ".$nomC:$nom}}
                    </span>
                    {{ $adresse }}
                    <br />
                    <strong>ICE:  </strong>  {{$client->ice}}
                </p>
            </div>

            <div class="intro-form">
                <div class="intro-form-item-border ">
                    <p class="intro-table-title fs-5">Note de Frais et/ou Honoraires:</p>
                    <p> في ،فاس {{$currentDate}}   Fès, le</p>
                </div>
            </div>
        </div>

        <div class="table-box">
            <table cellpadding="0" cellspacing="0">
                <tbody>

                <tr class="item">
                    <td>ICE :{{$client->ice}}</td>
                    <td>{{$dossier->votreReference}}</td>
                    <td>مرجعكم</td>

                </tr>

                <tr class="item">
                    <td>N. Ref</td>
                    <td>{{$dossier->id}}</td>
                    <td>مرجعنا</td>

                </tr>

                <tr class="item">
                    <td>Votre affaire contre</td>
                    <td>{{$nom}}</td>
                    <td>قضيتكم، ضد</td>
                </tr>

                <tr class="item">
                    <td> Juridiction / Ville</td>
                    <td>{{$dossier->sectionJuridiction ."  ب".$dossier->villeJuridiction}}</td>
                    <td>المحكمة</td>
                </tr>

                <tr class="item">
                    <td>N° Dossier Juridiction</td>
                    <td>{{$dossier->numJuridiction}}</td>
                    <td>ملف عدد</td>
                </tr>

                <tr class="item">
                    <td>Etat Procédural</td>
                    <td>{{$dossier->etatProcedurale}}</td>
                    <td> الحالة الإجرائية</td>
                </tr>
                <tr class="item">
                    <td>Date</td>
                    <td>{{$dossier->dateEtatProcedurale}}</td>
                    <td> بتاريخ</td>
                </tr>
                <tr class="heading">
                    <td>Relevé</td>
                    <td>Montant en DH <br>المبالغ    بالدرهم</td>
                    <td>بيان</td>
                </tr>
                @foreach($honoraires as $honoraire)
                    <tr class="item">
                        <td>{{$honoraire->type->typeHonoraire}}</td>
                        <td>{{$honoraire->amounInFigure}}</td>
                        <td> نوعية الأتعاب</td>
                    </tr>
                @endforeach

                @foreach($frais as $frai)
                    <tr class="item">
                        <td>{{$frai->natureFrais->titleFrais}}</td>
                    <td>{{$frai->amountInFigure}}</td>
                        <td>نوع الصائر</td>
                    </tr>
                @endforeach



                </tbody>
            </table>
        </div>

        <div class="summary-box">
            <table cellpadding="0" cellspacing="0">
                <tbody>
                <tr class="item">

                    <td></td>
                    <td>20%</td>
                    <td>معدل الضريبة</td>

                </tr>

                <tr class="item">
                    <td></td>

                    <td>{{ $tva}} </td>
                    <td>مجموع الضريبة</td>
                </tr>


                <tr class="no-border-item">
                    <td></td>

                    <td>{{ $totalAmount}}درهم</td>
                    <td>الاجمالي المستحق</td>
                </tr>

                <tr class="total">
                    <td></td>
                    <td>{{$note->givenAmount??0}}درهم</td>
                    <td>المبلغ المدفوع</td>

                </tr>
                </tbody>
            </table>
        </div>

        <div class="table-box1">
            <table cellpadding="0" cellspacing="0">
                <tbody>


                    <tr class="item">

                        <td>PATENTE :</td>
                        <td>TVA:</td>
                        <td>Identification Fiscale :</td>



                    </tr>    <tr class="item">

                        <td>CNSS :</td>
                        <td>N° Compte Bancaire :</td>
                        <td>ICE :</td>



                    </tr>




                </tbody>
            </table>
        </div>

        <div class="signer">
            <div class="form signer-item">
                <label for="date" class="label">Date:</label>
                <input
                    type="text"
                    id="date"
                    class="border-bottom"
                    value="{{$currentDate}} "
                />
            </div>

            <div class="form signer-item">
                <label for="signature"   class="label right">أصدرت من قبل:</label>
                <input
                    type="text"
                    id="signature"
                    class="border"
                    value="وقع هنا"
                />
            </div>
        </div>
    </div>

</div>



<script>
    function generatePDF() {
        // Choose the element that your content will be rendered to.
        const element = document.getElementById("invoice");

        // Set the direction of the PDF document to RTL.

        // Choose the element and save the PDF for your user.
        html2pdf().from(element).save('my_document.pdf');
    }

    // Add a button that will call the generatePDF() function
    document.getElementById("download-button").addEventListener("click", generatePDF);
</script>



</body>
</html>

