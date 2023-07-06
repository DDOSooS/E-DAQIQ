@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
@section('content')


<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="d-flex justify-content-between  end align-items-center flex-row-reverse mb-4">
            <a href="{{ url()->previous() }}" class="btn btn-primary btn-lg">
                <i class="icon-sm me-2" data-feather="chevrons-left"></i>
                الصفحة السابقة
            </a>
        </div>
        <div class="card-body">

            <h6 class="card-title fs-4">
                <i class="icon-sm me-2" data-feather="chevrons-left"></i>
                بيانات التكاليف
            </h6>

        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            <thead>
             <tr class="fs-3 bold">

                  <th>نوع الصائر</th>
                  <th>المبلغ بالأرقام</th>
                  <th>المبلغ بالكلمات</th>
                  <th>التفاصيل</th>
                  <th>التاريخ</th>
                  <th>تعديلات</th>

              </tr>
            </thead>
            <tbody>


                @foreach( $costs as $cost)



                    <tr id="{{$cost->nature}}">

                    <td>{{$cost->nature}}</td>
                    <td>{{$cost->amountInFigure."  درهم "}}</td>
                    <td>{{$cost->amountInWorld ."  درهم "}}</td>
                    <td>{{$cost->detail}}</td>
                    <td>{{ \Carbon\Carbon::parse($cost->updated_at)->format('d/m/Y') }}</td>

                    <td>
                        <div class="dropdown mb-2 mb">
                            <button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item d-flex align-items-center" href="{{url('/edit-cost',$cost->id)}}"><i data-feather="edit" class="icon-sm me-2"></i> <span class="">تعديل</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="{{url('/delete-cost',$cost->id)}}"><i data-feather="delete" class="icon-sm me-2"></i> <span class="">حدف</span></a>
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
  <script src="{{ asset('assets/js/invoices-table1.js') }}"></script>
@endpush
