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

            <a href="{{ route('clients.export') }}" class="btn btn-primary btn-lg mb-4">

                <i class="icon-sm me-2" data-feather="download"></i>
                تحميل
            </a>

        </div>

        <h6 class="card-title">بيانات العملاء</h6>

        <div class="table-responsive">
          <table id="dataTableExample" class="table ">
            <thead>
              <tr class="fs-3 bold">

                  <th>مرجعنا</th>
                  <th>مرجعكم</th>
                  <th>Ice</th>
                  <th>الهاتف</th>
                  <th>العنوان</th>
                  <th>تعديلات</th>

              </tr>
            </thead>
            <tbody>

            @foreach(  $clients as $client)
                <tr id="{{$client->nReference}}">


                    <td>{{$client->nReference}}</td>
                    <td>{{$client->vReference}}</td>

                    <td>{{$client->ice}}</td>

                    <td>{{$client->telephone}}</td>
                    <td>{{$client->adresse}}</td>
                    <td>
                        <div class="dropdown mb-2 mb">
                            <button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                @canany(['all','editClient'])
                                    <a class="dropdown-item d-flex align-items-center" href="show-client/{{$client->id}}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">مشاهدة</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="edit-client/{{$client->id}}"><i data-feather="edit" class="icon-sm me-2"></i> <span class="">تعديل</span></a>
                                @endcanany
                                @canany(['all','Clients'])
                                    <a class="dropdown-item d-flex align-items-center" href="history-client/{{$client->id}}"><i data-feather="archive" class="icon-sm me-2"></i> <span class="">الارشيف</span></a>
                                @endcanany
                                @canany(['all','deleteClient'])
                                    <a class="dropdown-item d-flex align-items-center" href="delete-client/{{$client->id}}"><i data-feather="delete" class="icon-sm me-2"></i> <span class="">حدف</span></a>
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
  </div>


@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
@endpush
