@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
@section('content')


<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">

        <div class="card-body">



            <div class="d-flex justify-content-between  end align-items-center flex-row-reverse mb-4">
                <a href="{{ url('/cases') }}" class="btn btn-primary btn-lg">
                    <i class="icon-sm me-2" data-feather="chevrons-left"></i>
                    الصفحة السابقة
                </a>
                <div>
                    <div class="btn-group mb-4" role="group" aria-label="Button group with nested dropdown">

                        @canany(['all','addInvoice'])
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="fs-5">  إضافة الرسوم</span>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <a class="dropdown-item fs-5" href="{{url('/addFrais',$dossier_id)}}">تكاليف</a>
                                    <a class="dropdown-item fs-5" href="{{url('/addHonoraire',$dossier_id)}}"> مصاريف</a>
                                </div>

                            </div>
                        @endcanany
                    </div>
                    @canany(['all','addInvoice'])
                        <a href="{{ url('transition',$dossier_id) }}" class="btn btn-primary btn-lg mb-4 ">

                            <i class="icon-sm me-2" data-feather="credit-card"></i>
                            دفع الرسوم
                        </a>
                    @endcanany



                    @foreach( $notes as $note)

                        <a class="btn btn-primary btn-lg mb-4 " href="{{url('/view-invoice',$dossier_id)}}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">معاينة</span></a>
                    @endforeach
                </div>

            </div>

            <h6 class="card-title fs-4">

                بيانات الفواتير

                @foreach( $notes as $note)
                    <i class="icon-sm me-2" data-feather="chevrons-left"></i>

                    للعميل:
                    <span class="fs-3 text-danger">
                        {{ $note->nom}}
                    </span>

                @endforeach
            </h6>



        <div class="table-responsive">
          <table id="dataTableExample" class="table table-bordered">

            <thead>
              <tr class="fs-3 bold">

                  <th>رقم الفاتورة</th>
                  <th>المبلغ الإجمالي</th>
                  <th>المبلغ المدقدم</th>
                  <th>المبلغ المتبقي</th>
                  <th>التفاصيل</th>

              </tr>
            </thead>
            <tbody>

            @foreach( $notes as $note)
                <tr >


                    <td>{{$note->numNote}}</td>
                    <td>{{$note->totalAmount ."  درهم "}}</td>
                    <td>{{($note->givenAmount == 0)?" 0 درهم ":$note->givenAmount."  درهم "}}</td>
                    <td>{{($note->totalAmount - $note->givenAmount)>0?$note->totalAmount - $note->givenAmount ."  درهم " : abs($note->totalAmount - $note->givenAmount) ."  درهم  تسبيق "}}</td>
                    <td>
                        @canany(['all','editInvoice'])
                            <div class="dropdown mb-2 mb">
                                <button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item d-flex align-items-center" href="{{url('/view-frais',$note->id)}}"><i data-feather="tag" class="icon-sm me-2"></i> <span class="">التكاليف</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="{{url('/view-honoraire',$note->id)}}"><i data-feather="tag" class="icon-sm me-2"></i> <span class="">المصاريف</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="{{url('/view-transition',$note->id)}}"><i data-feather="dollar-sign" class="icon-sm me-2"></i> <span class="">الرسوم المدفوعة</span></a>
                                </div>
                            </div>
                        @elsecanany(['all','editInvoice'])

                            <i class="icon-sm me-2" data-feather="minus"></i>

                        @endcanany
                    </td>
                </tr>

            @endforeach

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/data-table-1.js') }}"></script>
@endpush
