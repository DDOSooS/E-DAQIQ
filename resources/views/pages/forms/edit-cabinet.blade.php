@extends('layout.master')
@push('plugin-styles')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

@endpush
@section('content')


    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        @if(session('error'))
                            <div class="alert alert-danger">
                               <ul>
                                   <li>
                                       {{ session('error') }}
                                   </li>
                               </ul>
                            </div>
                        @endif

                        <form method="post" action="{{url('/edit-cabinet',$cabinet->id)}}" enctype="multipart/form-data">
                        @method("put")
                        @csrf
                            <h6 class="card-title fs-4">
                                <i data-feather="chevrons-left" class="icon-sm me-2"></i>
                                معلومات المحامي و المكتب
                            </h6>

                        <div class="row mb-5  pt-3" >
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label"><span class="text-danger"> *</span> الاسم</label>
                                    <input type="text" class="form-control"  id="prenom" name="prenom"   value="{{ (old('prenom')!== null)?old('prenom'):(isset($oldValues)?$oldValues['prenom']:$cabinet->name) }}"   required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label"> <span class="text-danger"> *</span> النسب</label>
                                    <input type="text" class="form-control"  id="nom" name="nom"  value=" {{ (old('nom')!== null)?old('nom'):(isset($oldValues)?$oldValues['nom']:$cabinet->lastname) }}"   required>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label"><span class="text-danger"> *</span>  العنوان </label>
                                    <input type="text" class="form-control"  id="adresse" name="adresse"  value="{{ (old('adresse')!== null)?old('adresse'):(isset($oldValues)?$oldValues['adresse']:$cabinet->adresse) }}"   required>

                                </div>
                            </div><!-- Col -->


                        </div><!-- Row -->
                            <div class="row mb-5" >
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label"><span class="text-danger"> *</span>  البريد الإلكتروني</label>
                                    <input type="text" class="form-control"  id="email" name="email"   value="{{ (old('email')!== null)?old('email'):(isset($oldValues)?$oldValues['email']:$cabinet->email) }}"   required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label"> <span class="text-danger"> *</span>  كلمة السر</label>
                                    <input type="text" class="form-control"  id="password" name="password"  value=" {{ (old('password')!== null)?old('password'):(isset($oldValues)?$oldValues['password']:$cabinet->original_password) }}"   required>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label"><span class="text-danger"> *</span> الهاتف </label>
                                    <input type="text" class="form-control"  id="telephone" name="telephone"  value="{{ (old('telephone')!== null)?old('telephone'):(isset($oldValues)?$oldValues['telephone']:$cabinet->phone) }}"  minlength="10" maxlength="10"  required>

                                </div>
                            </div><!-- Col -->


                        </div><!-- Row -->

                        <div class="row mb-5">
                            <div class="col-sm-4">
                                <div>
                                    <label class="form-label"><span class="text-danger"> *</span>اسم مكتب المحامي  </label>
                                    <input type="text" class="form-control" name="firmName"   placeholder=" اسم مكتب المحامي "   value="{{ (old('firmName')!== null)?old('firmName'):(isset($oldValues)?$oldValues['firmName']:$cabinet->nom) }}"  required >

                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label"> <span class="text-danger"> *</span>تاريخ التأسيس</label>
                                    <input type="date" class="form-control" name="dateCreation"   placeholder=" التاريخ"   value="{{ (old('dateCreation')!== null)?old('dateCreation'):(isset($oldValues)?$oldValues['dateCreation']:$cabinet->dateCreation) }}"   required>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label"> <span class="text-danger"> *</span>المقر الرئيسي للمكتب</label>
                                    <input type="text" class="form-control" name="siege"   placeholder=" المقر الرئيسي"   value="{{ (old('siege')!== null)?old('siege'):(isset($oldValues)?$oldValues['siege']:$cabinet->siege ) }}"   required>
                                </div>
                            </div><!-- Col -->


                        </div><!-- Row -->

                            <div class="row mx-auto">

                                <div class="col-md-6 stretch-card mx-auto">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title"><span class="text-danger"> *</span>الشعار</h6>
                                            <input type="file" name="logo" id="myDropify" accept="image/*" data-default-file="{{ $cabinet->logo ? Storage::url($cabinet->logo) : '' }}" />
                                            <input type="hidden" name="default_logo" id="defaultLogo" />
                                        </div>
                                    </div>
                                </div>
                            </div>


                        <button type="submit"  name="submit" class="btn btn-primary submit mt-2">مصادقة </button>

                    </form>

                </div>
            </div>
        </div>
    </div>
    <style>
        .search-result,.s-result {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            cursor: pointer;

        }

        .search-result:last-child ,.s-result:last-child {
            border-bottom: none;
        }

        .no-results,.n-results {
            padding: 10px;
            color: #888;
        }
        .search-results,.s-results {
            max-height: 430px; /* Set the maximum height for the search results */
            overflow-y: auto; /* Enable vertical scroll if needed */
            border: 1px solid #ccc;
            background-color: #fff;
            border-radius: 10px;

        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Get the value of data-default-file
        var defaultFile = document.getElementById('myDropify').getAttribute('data-default-file');

        // Assign the value to the hidden input field
        document.getElementById('defaultLogo').value = defaultFile;
    </script>




@endsection

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/typeahead-js/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/form-validation.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-maxlength.js') }}"></script>
    <script src="{{ asset('assets/js/inputmask.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/js/tags-input.js') }}"></script>
    <script src="{{ asset('assets/js/dropzone.js') }}"></script>
    <script src="{{ asset('assets/js/dropify.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-colorpicker.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/timepicker.js') }}"></script>
@endpush
