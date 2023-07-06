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

            <div class="d-flex justify-content-between align-items-center mb-4">
                @canany(['addCase','all'])
                    <a href="/add-case-file/{{$dossier_id}}" class="btn btn-primary btn-lg">
                        <i class="icon-sm me-2" data-feather="file-plus"></i>
                        إضافة وثيقة
                    </a>
                @endcanany
                <a href="{{ url('/cases') }}" class="btn btn-secondary btn-lg">
                    <i class="icon-sm me-2" data-feather="chevrons-left"></i>
                    الصفحة السابقة
                </a>


            </div>

            <h6 class="card-title fs-4  bold">
                <i class="icon-sm me-2 fs-1" data-feather="chevrons-left"></i>
                بيانات الوثائق </h6>

                <div class="row mb-5">
                    @foreach ($files as $file)
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                            <div class="card">
                                <div class="card-body">

                                    <h5 class="card-title fs-4">{{ $file->title }}</h5>
                                    <a href="{{ Storage::url($file->path) }}" class="btn btn-primary">
                                        <i class="icon-sm me-2" data-feather="download"></i>
                                        تحميل</a>
                                    <a href="{{ url("/delete_file",$file->id) }}" class="btn btn-danger">
                                        <i class="icon-sm me-2" data-feather="delete"></i>
                                        حدف</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
  <script src="{{ asset('assets/js/cases-table.js') }}"></script>
@endpush
