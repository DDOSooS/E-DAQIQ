@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
@section('content')

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">

                <div class="card-body">

                    <a href="{{ route('cases.export') }}" class="btn btn-primary btn-lg mb-4">
                        <i class="icon-sm me-2" data-feather="download"></i>
                        تحميل
                    </a>


                    <h6 class="card-title">بيانات القضايا</h6>


                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr class="fs-3 bold">
                                <th>ملف عدد</th>
                                <th>المدينة</th>
                                <th>القسم</th>
                                <th>النوع</th>
                                <th>رقم القرار</th>
                                <th>وضع القضية</th>
                                <th>تعديلات</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($dossiers as $dossier)
                                <tr id="{{ $dossier->numJuridiction }}">
                                    <td>{{ $dossier->numJuridiction }}</td>
                                    <td>{{ $dossier->villeJuridiction }}</td>
                                    <td>{{ $dossier->sectionJuridiction }}</td>
                                    <td>{{ $dossier->typeJuridiction }}</td>
                                    <td>{{ $dossier->numDecision . " / " . $dossier->dateDecision }}</td>
                                    <td>
                                        @if($dossier->status == 0)
                                            <div class="progress h-100 align-items-center">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning h-100" role="progressbar" style="width: 90%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="p-2 fs-5">جارية</span>
                                                </div>
                                                <button type="button" id="edit" class="btn btn-warning btn-icon m-lg-1 " onclick="showSwal('{{ $dossier->id }}', '{{ $dossier->status }}')">
                                                    <i data-feather="edit"></i>
                                                </button>

                                            </div>
                                        @elseif($dossier->status == 1)
                                            <div class="progress h-100 align-items-center">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success h-100" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="p-2 fs-5">مغلقة</span>
                                                </div>
                                                <button type="button" id="edit" class="btn btn-success btn-icon  m-lg-1" onclick="showSwal('{{ $dossier->id }}', '{{ $dossier->status }}')">
                                                    <i data-feather="edit"></i>
                                                </button>
                                            </div>
                                        @elseif($dossier->status == 2)
                                            <div class="progress h-100 align-items-center">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger h-100" role="progressbar" style="width: 100%; " aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="p-2 fs-5">معلقة</span>
                                                </div>
                                                <button type="button" id="edit" class="btn btn-danger btn-icon m-lg-1" onclick="showSwal('{{ $dossier->id }}', '{{ $dossier->status }}')">
                                                    <i data-feather="edit"></i>

                                                </button>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown mb-2 mb">
                                            <button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @canany(['all','Cases'])
                                                    <a class="dropdown-item d-flex align-items-center" href="invoice-case/{{ $dossier->id }}"><i data-feather="file-text" class="icon-sm me-2"></i> <span class="">الفاتورة</span></a>
                                                    <a class="dropdown-item d-flex align-items-center" href="upload-case/{{ $dossier->id }}"><i data-feather="file-minus" class="icon-sm me-2"></i> <span class="">الوثائق المصاحبة</span></a>
                                                    <a class="dropdown-item d-flex align-items-center" href="history-case/{{ $dossier->id }}"><i data-feather="archive" class="icon-sm me-2"></i> <span class="">الارشيف</span></a>
                                                @endcanany
                                                @canany(['all','editCase'])
                                                    <a class="dropdown-item d-flex align-items-center" href="edit-case/{{ $dossier->id }}"><i data-feather="edit" class="icon-sm me-2"></i> <span class="">تعديل</span></a>
                                                @endcanany
                                                @canany(['all','deleteCase'])
                                                    <a class="dropdown-item d-flex align-items-center" href="delete-case/{{ $dossier->id }}"><i data-feather="delete" class="icon-sm me-2"></i> <span class="">حدف</span></a>
                                                @endcanany
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

<<style>
    .flex-button-container {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .flex-button {
        display: flex;
        align-items: center;
        justify-content: space-evenly;
        width: 100px;
        height: 50px;
        background-color: #007bff;
        color: #fff;
        cursor: pointer;
        border-radius: 5px;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.js"></script>

<script>
    function showSwal(dossierId, status) {
        Swal.fire({
            html: `
            <div class="card">
                <div class="card-body flex-button-container">
                <a href="/update-status/${dossierId}/0">
                    <div id="0" class="flex-button div1"  ${status == 0 ? 'style="display: none;"' : ''}>
                        قضية جارية
                    </div>
                </a>
                <a href="/edit-case-status/${dossierId}">
                    <div id="1" class="flex-button div2"  ${status == 1 ? 'style="display: none;"' : ''}>
                        قضيةمغلقة
                    </div>
                </a>
                <a href="/update-status/${dossierId}/2">
                     <div id="2" class="flex-button div2"  ${status == 2 ? 'style="display: none;"' : ''}>
                               قضية معلقة
                    </div>
                </a>
                </div>
            </div>
        `,
            showCancelButton: true,
            cancelButtonText: "Annuler",
            focusConfirm: false,
        });
    }
</script>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/cases-table.js') }}"></script>
@endpush
