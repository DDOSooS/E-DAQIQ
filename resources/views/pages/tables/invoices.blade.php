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


            <h6 class="card-title">بيانات الفواتير</h6>


        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            <thead>
             <tr class="fs-3 bold">

                  <th>رقم الفاتورة</th>
                  <th>العميل</th>
                  <th>المبلغ الإجمالي</th>
                  <th>المبلغ المدقدم</th>
                  <th>المبلغ المتبقي</th>
                  <th>حالةالفاتورة</th>
                  <th>تعديلات</th>

              </tr>
            </thead>
            <tbody>


                @foreach( $invoices as $invoice)



                    <tr id="{{$invoice->nom}}">

                    <td>{{$invoice->numNote}}</td>
                    <td>{{$invoice->nom}}</td>
                    <td>{{$invoice->totalAmount ."  درهم "}}</td>
                    <td>{{$invoice->givenAmount}}</td>
                    <td>{{($invoice->totalAmount - $invoice->givenAmount)>0?$invoice->totalAmount - $invoice->givenAmount : 0}}</td>
                    <td>{{$invoice->establishNote }}</td>
                    <td>
                        <div class="dropdown mb-2 mb">
                            <button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item d-flex align-items-center" href="{{url('/view-invoice',$invoice->dossier_id)}}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">معاينة</span></a>
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
  </div>
</div>


@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/invoices-table.js') }}"></script>
@endpush
