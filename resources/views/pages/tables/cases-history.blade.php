@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')


    <div class="row mt-2">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                <h6 class="card-title mt-3"> تفاصيل تاريخ تفاصيل تاريخ الحالة</h6>

                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                        <tr>

                            <th>التاريخ</th>
                            <th>تفاصيل التغييرات</th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach(  $dossierHistorique as $item)
                            <tr>

                                <td>{{$item->created_at->format('Y-m-d')}}</td>

                                <td>{{$item->description}}</td>

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


