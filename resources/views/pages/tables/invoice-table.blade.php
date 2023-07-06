@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
@section('content')

    <button id="print">Print</button>
    <main class="px-2 " id="content">
        <div class="row justify-content-center mb-5">
            <div class="col-6 text-end order-sm-1">
                <div class="col-6 order-sm-1 mx-auto">
                        <div >
                            <address class="fs-5">
                                <strong>SERVICE FINANCIER DEVPUB</strong><BR>
                                Rue: 370 Central Avenue
                                Fes,Maroc
                            </address>
                        </div>

                </div>
            </div>
        </div>

        <div class="row ">
            <div class="col-4 text-end order-sm-2">

                <div class="d-flex flex-column">



                    <div class=" col" >
                        <h4><strong>A Monsieur le Directeur de la Direction des  Affaires Juridiques de {{ $ClientData->nomSte }}</strong></h4> <br>

                    </div>
                    <div class=" col">
                        <p class="fs-5">
                            {{ $ClientData->siege }}
                        </p>
                    </div>
                    <div class=" col">
                        <p class="fs-5">
                            <strong>ICE</strong>  {{$client->ice}}
                        </p>
                    </div>

                </div>

            </div>
            <div class="col-4 order-sm-1">


            </div>
            <div class="col-4 order-sm-0">
                <div class="d-flex flex-column">



                    <div class="p-1 col" >
                        <p class="fs-4 bold"><strong>Note de Frais et/ou Honoraires</strong></p><br>
                    </div>
                    <br>
                    <div class="p-1 col">
                        <p class="fs-5 p-2"> في ،فاس {{$currentDate}}   Fès, le</p>

                    </div>
                    <br>
                    <div class="p-1 col">
                        <p class="fs-5">
                            <strong>Note N° </strong>{{$note->numNote}}
                        </p>
                    </div>

                </div>


            </div>
        </div>

        <div class="card pt-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">

                        <tbody>
                        <tr class="">
                            <td class="col-md-4 col border-top-0">مرجعكم</td>
                            <td class="col-sm-5 col border-top-0">{{$dossier->votreReference}}</td>
                            <td class="col-md-5 col border-top-0 text-left">ICE :{{$client->ice}}</td>
                        </tr>
                        <tr class="">
                            <td class="col-md-4 col border-top-0">مرجعنا</td>
                            <td class="col-sm-5 col border-top-0">{{$dossier->id}}</td>
                            <td class="col-md-5 col border-top-0 text-left">N. Ref</td>
                        </tr>
                        <tr class="">
                            <td class="col-md-4 col border-top-0">قضيتكم، ضد</td>
                            <td class="col-sm-5 col border-top-0">{{$nom}}</td>
                            <td class="col-md-5 col border-top-0 text-left">Votre affaire contre</td>
                        </tr>
                        <tr class="">
                            <td class="col-md-4 col border-top-0">المحكمة</td>
                            <td class="col-sm-5 col border-top-0">{{$dossier->sectionJuridiction ."  ب".$dossier->villeJuridiction}}</td>
                            <td class="col-md-5 col border-top-0 text-left"> Juridiction / Ville</td>
                        </tr>
                        <tr class="">
                            <td class="col-md-4 col border-top-0">نوع القضية بالمكتب</td>
                            <td class="col-sm-5 col border-top-0"></td>
                            <td class="col-md-5 col border-top-0 text-left">Nature Dossier Cabinet</td>
                        </tr>
                        <tr class="">
                            <td class="col-md-4 col border-top-0">ملف عدد</td>
                            <td class="col-sm-5 col border-top-0">{{$dossier->numJuridiction}}</td>
                            <td class="col-md-5 col border-top-0 text-left">N° Dossier Juridiction</td>
                        </tr>
                        <tr class="">
                            <td class="col-md-4 col border-top-0"></td>
                            <td class="col-sm-5 col border-top-0">{{$dossier->etatProcedurale}}</td>
                            <td class="col-md-5 col border-top-0 text-left">Etat Procédural</td>
                        </tr>
                        <tr class="">
                            <td class="col-md-4 col border-top-0">حكم / قرار</td>
                            <td class="col-sm-5 col border-top-0">{{$dossier->numDecision ."/". $dossier->dateDecision}}</td>
                            <td class="col-md-5 col border-top-0 text-left">N° Décision</td>
                        </tr> <tr class="">
                            <td class="col-md-4 col border-top-0">بتاريخ</td>
                            <td class="col-sm-5 col border-top-0">{{$dossier->dateEtatProcedurale}}</td>
                            <td class="col-md-5 col border-top-0 text-left">Date</td>
                        </tr>
                        <tr class="bg-light">
                            <td class="col-md-4 col border-top-0 text-center"><strong> بيان </strong></td>
                            <td class="col-sm-5 col border-top-0 text-center"><strong>Montant en DH <br>المبالغ بالدرهم</strong></td>
                            <td class="col-md-5 col border-top-0 text-center"><strong>Relevé</strong></td>
                        </tr>
                        @foreach($honoraires as $honoraire)
                        <tr class="">
                            <td class="col-md-4 col border-top-0 text-center">نوعية الأتعاب</td>
                            <td class="col-sm-5 col border-top-0 text-center">{{$honoraire->amounInFigure}}</td>
                            <td class="col-md-5 col border-top-0 text-center">{{$honoraire->type->typeHonoraire}}</td>
                        </tr>
                        @endforeach
                        <tr class="bg-light">
                            <td class="col-md-4 col border-top-0 text-center"><strong>  20% الضريبة عن القيمة المضافة </strong></td>
                            <td class="col-sm-5 col border-top-0 text-center"><strong>{{$tva}} درهم</strong></td>
                            <td class="col-md-5 col border-top-0 text-center"><strong>TVA 20%</strong></td>
                        </tr>
                        @foreach($frais as $frai)
                            <tr class="">
                                <td class="col-md-4 col border-top-0 text-center"> نوع الصائر</td>
                                <td class="col-sm-5 col border-top-0 text-center">{{$frai->amountInFigure}}</td>
                                <td class="col-md-5 col border-top-0 text-center">{{$frai->natureFrais->titleFrais}}</td>
                            </tr>
                @endforeach
                        <tr class="bg-light">
                            <td class="col-md-4 col border-top-0 text-center"><strong> Total </strong></td>
                            <td class="col-sm-5 col border-top-0 text-center"><strong> {{$totalAmount}}درهم </strong></td>
                            <td class="col-md-5 col border-top-0 text-center"><strong>المجموع</strong></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <div class="table-responsive d-print-none">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <div class="row ">

                         <div class="col-4 text-end order-sm-2">

                            <div class="d-flex flex-column">
                                <div class="p-1 col" >
                                    <hr>
                                </div>
                                <div class="p-1 col" >
                                    <hr>
                                </div>
                                <div class="p-1 col" >
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 text-end order-sm-2">

                            <div class="d-flex flex-column">
                                <div class="p-1 col" >
                                    <hr>
                                </div>
                                <div class="p-1 col" >
                                    <hr>
                                </div>
                                <div class="p-1 col" >
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 text-end order-sm-2">

                            <div class="d-flex flex-column">
                                <div class="p-1 col" >
                                    <hr>
                                </div>
                                <div class="p-1 col" >
                                    <hr>
                                </div>
                                <div class="p-1 col text-right" >
                                    <span class="text-right bold fs-4"> التوقيع</span>   <hr>
                                </div>
                            </div>
                        </div>

                    </div>

                </tr>
                <tr class="border border-dark">
                    <div class="row">
                        <div class="col-12 text-end order-sm-2">

                            <b>PATENTE</b> ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,/<b>TVA</b> ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,/<b>Identification Fiscale</b> ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,, <b> CNSS</b>,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,   <b>N° Compte Bancaire</b> ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,, <b>ICE</b> ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,

                        </div>
                    </div>
                </tr>
                </tbody>
            </table>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        function convertBladeToPdf(html) {
            // Create a new PDF document
            var pdf = new jsPDF();

            // Set the document's page size and margins
            pdf.setPageSize('A4', 'portrait');
            pdf.setMargins(20, 20, 20, 20);

            // Write the HTML to the PDF document
            pdf.writeHTML(html, function(type, annots) {
                if (type === 'text') {
                    // Check if the text is Arabic
                    if (/[ء-ي]/.test(text)) {
                        // Set the font for Arabic text
                        pdf.setFont('Scheherazade', 'normal');
                    } else {
                        // Set the font for non-Arabic text
                        pdf.setFont('Helvetica', 'normal');
                    }
                }
            });

            // Save the PDF document
            pdf.save('my_document.pdf');
        }

        // Get the HTML from the Blade template
        var html = $("#content").html();

        // Add a "Print" button
        $("button#print").on("click", function() {
            // Convert the HTML to PDF
            convertBladeToPdf(html);
        });

    </script>

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/data-table-1.js') }}"></script>
@endpush
