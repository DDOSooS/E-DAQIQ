@extends('layout.master')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Forms</a></li>
            <li class="breadcrumb-item active" aria-current="page">Basic Elements</li>
        </ol>
    </nav>


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
                        <div id="alert" class="alert alert-danger" style="display:none;">
                            <ul>
                                <li>
                                    يجب عليك أولاً العثور على العميل من خلال مرجعنا
                                </li>
                            </ul>
                        </div>
                        <form method="post" action="{{url('edit-case',$dossier->id)}}">
                        @method("put")
                        @csrf

                        <input id="searchInput" name="condition" type="text" class="form-control w-50 px-2 mx-auto"  value="{{$client->nReference}}" placeholder="يمكنك البحث عن العميل عن طريق مرجعنا" onkeyup="searchClient()">
                        <div class="row mb-5" >
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">* مرجعكم</label>
                                    <input type="text" class="form-control"  id="vref" name="vref"   value="{{ (old('vref')!== null)?old('vref'):(isset($oldValues)?$oldValues['vref']:$client->vReference) }}"  readonly required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label"> * مرجعنا</label>
                                    <input type="text" class="form-control"   id="nref" name="nref"  value=" {{ (old('nref')!== null)?old('nref'):(isset($oldValues)?$oldValues['vref']:$client->nReference) }}"  readonly required>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">* Ice </label>
                                    <input type="text" class="form-control"  id="ice" name="ice"  value="{{ (old('ice')!== null)?old('ice'):(isset($oldValues)?$oldValues['ice']:$client->ice) }}"  minlength="15" maxlength="15" readonly required>

                                </div>
                            </div><!-- Col -->


                        </div><!-- Row -->
                        <div class="row mb-5">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label bold">الاختصاص القضائي</label>
                                    <div class=" " style="display: flex; flex-shrink: 1; gap:5px">
                                        <div>
                                            <label class="form-label">* النوع</label>
                                            <select class="form-select form-select-lg mb-2"  required name="typeJuridiction"  id="mySelect">
                                                <option value="محكمة" {{ (isset($dossier) and $dossier->typeJuridiction  === 'محكمة') ? 'selected' : '' }}>محكمة</option>
                                                <option value="محكمة الاستئناف"  {{ (isset($dossier) and $dossier->typeJuridiction  === 'محكمة الاستئناف') ? 'selected' : '' }}>محكمة الاستئناف</option>
                                                <option value="محكمة النقض" {{ (isset($dossier) and $dossier->typeJuridiction  === 'محكمة النقض') ? 'selected' : '' }}>محكمة النقض</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="form-label">* القسم</label>
                                            <select class="form-select form-select-lg mb-2"  required name="sectionJuridiction"  id="mySelect">
                                                <option value="الابتدائية" {{ (isset($dossier) and $dossier->sectionJuridiction  === 'الابتدائية') ? 'selected' : '' }}> الابتدائية </option>
                                                <option value="الإدارية"  {{ (isset($dossier) and $dossier->sectionJuridiction  === 'الإدارية') ? 'selected' : '' }}>الإدارية </option>
                                                <option value="الأسرية/الاجتماعية"  {{ (isset($dossier) and $dossier->sectionJuridiction  === 'الأسرية/الاجتماعية') ? 'selected' : '' }}>الأسرية/الاجتماعية</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="form-label">* المدينة</label>

                                            <select class="form-select  form-select-lg mb-2"  required name="villeJuridiction"  id="mySelect">
                                                 @foreach($villes as $ville)
                                                        <option value="{{$ville}}" {{ (isset($dossier) and $dossier->villeJuridiction  === $ville) ? 'selected' : '' }}>{{$ville}}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                    </div>
                                    </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label bold"> رقم الملف الاختصاص القضائي</label>
                                    <div class=" flex-shrink-1" style="display: flex; gap:5px">
                                        <div>
                                            <label class="form-label"> رقم ° <label>
                                            <input type="text" class="form-control"  name="numberCase" placeholder="رقم"   value="{{ (old('numberCase')!== null)?old('numberCase'):(isset($oldValues)?$oldValues['numberCase']:$numJuridiction[0])}}" >
                                        </div>
                                        <div>
                                            <label class="form-label">رقم ملف التخصص <label>
                                            <input type="text" class="form-control"  name="codeCase" placeholder="رقم ملف التخصص"  value="{{ (old('codeCase')!== null)?old('codeCase'):(isset($oldValues)?$oldValues['codeCase']:$numJuridiction[1])}}"  >
                                        </div>
                                        <div>
                                            <label class="form-label">السنة<label>
                                            <input type="text" class="form-control"  name="yearCase" placeholder="السنة"  value="{{ (old('yearCase')!== null)?old('yearCase'):(isset($oldValues)?$oldValues['yearCase']:$numJuridiction[2])}}" minlength="4" maxlength="4"  >
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row mb-5">
                            <div class="col-sm-5">
                                <div>
                                    <label class="form-label">الحالة الإجرائية</label>
                                    <select class="form-select form-select-lg mb-2"  required name="etatProcedurale"  id="mySelect">
                                        <option value="جلسة استماع" {{ (isset($dossier) and $dossier->etatProcedurale === 'جلسة استماع') ? 'selected' : '' }}>جلسة استماع</option>
                                        <option value="المداولة"  {{ (isset($dossier) and $dossier->etatProcedurale   === 'المداولة') ? 'selected' : ''  }}>المداولة</option>
                                        <option value="الرقابة"  {{ (isset($dossier) and $dossier->etatProcedurale   === 'الرقابة') ? 'selected' : ''  }}>الرقابة</option>
                                    </select>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-5">
                                <div class="mb-3">
                                    <label class="form-label">* التاريخ</label>
                                    <input type="date" class="form-control" name="dateEtatProcedurale"   placeholder=" التاريخ"   value="{{ (old('dateEtatProcedurale')!== null)?old('dateEtatProcedurale'):(isset($oldValues)?$oldValues['dateEtatProcedurale']:$dossier->dateEtatProcedurale) }}"   required>
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
        .search-result {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            cursor: pointer;

        }

        .search-result:last-child {
            border-bottom: none;
        }

        .no-results {
            padding: 10px;
            color: #888;
        }
        .search-results {
            max-height: 430px; /* Set the maximum height for the search results */
            overflow-y: auto; /* Enable vertical scroll if needed */
            border: 1px solid #ccc;
            background-color: #fff;
            border-radius: 10px;

        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
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

            $(document).on('click', '.search-result', function() {
                var selectedValue = $(this).text();
                $('#type-input').val(selectedValue);
                $('#search-results').empty();
            });
        });

    </script>






    <script>



        function searchClient() {
            var searchValue = document.getElementById("searchInput").value;

            // Make an AJAX request to fetch the adversaire data based on the search input
            // Replace the URL below with the actual endpoint that handles the search request
            var url = "/search-client?name=" + searchValue;
            var xhr = new XMLHttpRequest();
            xhr.open("GET", url, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var client = JSON.parse(xhr.responseText);

                    if (searchValue === '') {
                        // Clear the input fields
                        document.getElementById("nref").value = '';
                        document.getElementById("vref").value = '';
                        document.getElementById("ice").value = '';

                        client = null; // Set adversaire data to null
                        var alert = document.getElementById("alert");
                        alert.style.display = "block";
                        console.log(client,"2222222222");


                    } else if (Object.keys(client).length === 0) {
                        // Clear the input fields
                        document.getElementById("nref").value = '';
                        document.getElementById("vref").value = '';
                        document.getElementById("ice").value = '';
                        console.log(client,"222222222wwww2");

                        var alert = document.getElementById("alert");
                        alert.style.display = "block";


                    } else {
                        // Update the adversaire data in the form
                        document.getElementById("nref").value = client.nReference || '';
                        document.getElementById("vref").value = client.vReference || '';
                        document.getElementById("ice").value = client.ice || '';
                        console.log(client,"222222wwwwwwq2332222");

                        var alert = document.getElementById("alert");
                        alert.style.display = "none";
                    }
                    // Update other fields as needed


                }
            };
            xhr.send();
        }

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
