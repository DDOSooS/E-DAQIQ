@extends('layout.master')

@section('content')



    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between  end align-items-center flex-row-reverse mb-4">
                        <a href="{{ url('/') }}" class="btn btn-primary btn-lg align-left">
                            <i class="icon-sm me-2" data-feather="chevrons-left"></i>
                            الصفحة السابقة
                        </a>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <div id="alert" class="alert alert-danger" style="display: block;">
                            <ul>
                                <li>
                                    يجب عليك أولاً العثور على العميل من خلال مرجعنا
                                </li>
                            </ul>
                        </div>
                        <form method="post" action="{{url('store-case')}}">
                        @method("post")
                        @csrf

{{--                        <input id="searchInput" name="condition" type="text" class="form-control w-50 px-2 mx-auto"  placeholder="يمكنك البحث عن العميل عن طريق مرجعنا" onkeyup="searchAdversaire()">--}}
                            <div class=" " style="display: flex; flex-shrink: 1; gap:5px">

                                <input type="text" name="terme" id="search-input"  placeholder=" يمكنك البحث عن العميل عن طريق مرجعنا" class="form-control w-50 mx-auto" autocomplete="off" onchange="searchClient()"><br>

                            </div>
                            <div id="s-results" class="s-results mx-auto w-50"></div>
                        <div class="row mb-5" >
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label"><span class="text-danger"> *</span> مرجعكم</label>
                                    <input type="text" class="form-control"  id="vref" name="vref"   value="{{ (old('vref')!== null)?old('vref'):(isset($oldValues)?$oldValues['vref']:'') }}"  readonly required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label"> <span class="text-danger"> *</span> مرجعنا</label>
                                    <input type="text" class="form-control"  id="nref" name="nref"  value=" {{ (old('nref')!== null)?old('nref'):(isset($oldValues)?$oldValues['vref']:'') }}"  readonly required>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label"><span class="text-danger"> *</span> Ice </label>
                                    <input type="text" class="form-control"  id="ice" name="ice"  value="{{ (old('ice')!== null)?old('ice'):(isset($oldValues)?$oldValues['ice']:'') }}"  minlength="15" maxlength="15" readonly required>

                                </div>
                            </div><!-- Col -->


                        </div><!-- Row -->
                        <div class="row mb-5">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label bold"> <span class="text-danger"> *</span>الاختصاص القضائي</label>
                                    <div class=" " style="display: flex; flex-shrink: 1; gap:5px">
                                        <div>
                                            <label class="form-label">* النوع</label>
                                            <select class="form-select form-select-lg mb-2"  required name="typeJuridiction"  id="mySelect">
                                                <option value="محكمة" {{ (isset($oldValues) and $oldValues['typeJuridiction']  === 'محكمة') ? 'selected' : '' }}>محكمة</option>
                                                <option value="محكمة الاستئناف"  {{ (isset($oldValues) and $oldValues['typeJuridiction']  === 'محكمة الاستئناف') ? 'selected' : ''  }}>محكمة الاستئناف</option>
                                                <option value="محكمة النقض"  {{ (isset($oldValues) and $oldValues['typeJuridiction']  === 'محكمة النقض') ? 'selected' : ''  }}>محكمة النقض</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="form-label" >القسم</label>
                                            <select class="form-select form-select-lg mb-2"  required name="sectionJuridiction"  id="mySelect">
                                                <option value="الابتدائية" {{ (isset($oldValues) and $oldValues['sectionJuridiction']  === '1') ? 'selected' : '' }}> الابتدائية </option>
                                                <option value="الإدارية"  {{ (isset($oldValues) and $oldValues['sectionJuridiction']  === '2') ? 'selected' : ''  }}>الإدارية </option>
                                                <option value="الأسرية/الاجتماعية"  {{ (isset($oldValues) and $oldValues['sectionJuridiction']  === '3') ? 'selected' : ''  }}>الأسرية/الاجتماعية</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="form-label"> المدينة</label>

                                            <select class="form-select  form-select-lg mb-2"  required name="villeJuridiction"  id="mySelect">
                                                 @foreach($villes as $ville)
                                                        <option value="{{$ville}}" {{ (isset($oldValues) and $oldValues['ville']  === $ville) ? 'selected' : '' }}>{{$ville}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label bold"><span class="text-danger"> *</span> رقم الملف الاختصاص القضائي</label>
                                    <div class="" style="display: flex; flex-shrink: 1; gap:5px">
                                        <div>
                                            <label class="form-label"> رقم ° <label>
                                            <input type="text" class="form-control"  name="numberCase" placeholder="رقم"   value="{{ (old('numberCase')!== null)?old('numberCase'):(isset($oldValues)?$oldValues['numberCase']:'') }}" >
                                        </div>
                                        <div>
                                            <label class="form-label">رقم ملف التخصص <label>
                                            <input type="text" class="form-control"  name="codeCase" placeholder="رقم ملف التخصص"  value="{{ (old('codeCase')!== null)?old('codeCase'):(isset($oldValues)?$oldValues['codeCase']:'') }}" >
                                        </div>
                                        <div>
                                            <label class="form-label">السنة<label>
                                            <input type="text" class="form-control"  name="yearCase" placeholder="السنة"   value="{{ (old('yearCase')!== null)?old('yearCase'):(isset($oldValues)?$oldValues['yearCase']:'') }}" minlength="4" maxlength="4"  >
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="row mb-5">
                            <div class="col-sm-5">
                                <div>
                                    <label class="form-label">الحالة الإجرائية </label>
                                    <select class="form-select form-select-lg mb-2"   name="etatProcedurale"  id="mySelect">
                                        <option value="جلسة استماع" {{ (isset($oldValues) and $oldValues['etatProcedurale']  === 'جلسة استماع') ? 'selected' : '' }}>جلسة استماع</option>
                                        <option value="المداولة"  {{ (isset($oldValues) and $oldValues['etatProcedurale']  === 'المداولة') ? 'selected' : ''  }}>المداولة</option>
                                        <option value="الرقابة"  {{ (isset($oldValues) and $oldValues['etatProcedurale']  === 'الرقابة') ? 'selected' : ''  }}>الرقابة</option>
                                    </select>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-5">
                                <div class="mb-3">
                                    <label class="form-label"> التاريخ</label>
                                    <input type="date" class="form-control" name="dateEtatProcedurale"   placeholder=" التاريخ"   value="{{ (old('dateEtatProcedurale')!== null)?old('dateEtatProcedurale'):(isset($oldValues)?$oldValues['dateEtatProcedurale']:'') }}"   >
                                </div>
                            </div><!-- Col -->

                        </div><!-- Row -->


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

        function searchClient(){
           $(document).ready(function() {
            $('#type-input').on('input', function() {
                var term = $(this).val();

                if (term.length > 0) {
                    $.ajax({
                        url: '/search',
                        dataType: 'json',
                        data: {
                            term: term
                        },
                        success: function(data) {
                            var results = '';
                            if (data.length > 0) {
                                $.each(data, function(index, value) {
                                    results += '<div class="search-result">' + value + '</div>';
                                });
                            } else {
                                results = '<div class="no-results">No results found</div>';
                            }
                            $('#search-results').html(results);
                        }
                    });
                } else {
                    $('#search-results').empty();
                }
            });

        });
        }

            $(document).on('click', '.search-result', function() {
                var selectedValue = $(this).text();
                $('#type-input').val(selectedValue);
                $('#search-results').empty();
            });


    </script>






    <script>
            $(document).ready(function() {
                $('#search-input').on('input', function() {
                    var term = $(this).val();

                    if (term.length > 0) {
                        $.ajax({
                            url: '/searchClient',
                            dataType: 'json',
                            data: {
                                term: term
                            },
                            success: function(data) {
                                var results = '';
                                if (data.length > 0) {
                                    console.log(data);

                                    $.each(data, function(index, value) {
                                        console.log(data);
                                        results += '<div class="s-result" data-value=\'' + JSON.stringify(value) + '\'>' + value.nReference + '</div>';
                                    });
                                } else {
                                    document.getElementById('alert').style.display = 'block ';

                                    results = '<div class="n-results">No results found</div>';
                                    $('#nref').val('');
                                    $('#vref').val('');
                                    $('#ice').val('');
                                }
                                $('#s-results').html(results);
                            }
                        });
                    } else {
                        $('#s-results').empty();
                    }
                });

                $(document).on('click', '.s-result', function() {
                    var selectedDataValue = $(this).data('value');
                    var selectedData = JSON.parse(JSON.stringify(selectedDataValue));
                    document.getElementById('alert').style.display = 'none';
                    $('#search-input').val(selectedData.nReference);
                    $('#vref').val(selectedData.vReference);
                    $('#nref').val(selectedData.nReference);
                    $('#ice').val(selectedData.ice);

                    $('#s-results').empty();
                });


            });

    </script>



    @push('plugin-scripts')
        <script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/simplemde/simplemde.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/ace-builds/ace.js') }}"></script>
        <script src="{{ asset('assets/plugins/ace-builds/theme-chaos.js') }}"></script>
    @endpush

    @push('custom-scripts')
        <script src="{{ asset('assets/js/tinymce.js') }}"></script>
        <script src="{{ asset('assets/js/simplemde.js') }}"></script>
        <script src="{{ asset('assets/js/ace.js') }}"></script>
    @endpush
@endsection
