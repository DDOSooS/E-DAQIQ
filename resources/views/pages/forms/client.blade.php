@extends('layout.master')

@section('content')



    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between  end align-items-center flex-row-reverse mb-4">
                        <a href="{{ url('/') }}" class="btn btn-primary btn-lg">
                            <i class="icon-sm me-2" data-feather="chevrons-left"></i>
                            الصفحة السابقة
                        </a>
                    </div>

                    <h6 class="card-title fs-4"> - المدعي</h6>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="{{url('store-client')}}">
                        @method("post")
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label"><span class="text-danger"> *</span> مرجعكم</label>
                                    <input type="text" class="form-control"  name="vref" placeholder="مثال 1220/2023"  value="{{ (old('vref')!== null)?old('vref'):(isset($oldValues)?$oldValues['vref']:'') }}" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label"> <span class="text-danger"> *</span> مرجعنا</label>
                                    <input type="text" class="form-control"  name="nref" placeholder="مرجعنا"  value="{{  $nreference }}"  readonly>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label"><span class="text-danger"> *</span>Ice </label>
                                    <input type="text" class="form-control" name="ice" placeholder=" Ice"  value="{{ (old('ice')!== null)?old('ice'):(isset($oldValues)?$oldValues['ice']:'') }}"  minlength="15" maxlength="15" required>

                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label"><span class="text-danger"> *</span> العنوان</label>
                                    <input type="text" class="form-control" name="adresse"   placeholder=" العنوان"   value="{{ (old('adresse')!== null)?old('adresse'):(isset($oldValues)?$oldValues['adresse']:'') }}"  required>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label"><span class="text-danger"> *</span> الهاتف</label>
                                    <input type="numer" class="form-control" name="telephone"  placeholder="الهاتف"   value="{{ (old('telephone')!== null)?old('telephone'):(isset($oldValues)?$oldValues['telephone']:'') }}"  required maxlength="10">
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                        <div>
                            <label class="form-label fa-4x"><span class="text-danger"> *</span>نوع العميل</label>
                            <select class="form-select form-select-lg mb-2"  required name="typeClient"  id="mySelect">
                                <option value="1" {{ (isset($oldValues) and $oldValues['typeClient']  === '1') ? 'selected' : '' }}>شخص</option>
                                <option value="2"  {{ (isset($oldValues) and $oldValues['typeClient']  === '2') ? 'selected' : ''  }}>شركة</option>
                            </select>
                        </div>
                        <div class="row" id="physique" style="display: none;">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Cin <span class="text-danger"> *</span> </label>
                                    <input type="text" class="form-control" name="cin" placeholder="Cin"   value="{{ (old('cin')!== null)?old('cin'):(isset($oldValues)?$oldValues['cin']:'') }}"    >
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label"> <span class="text-danger"> *</span> النسب</label>
                                    <input type="text" class="form-control" name="nom" placeholder="النسب"  value="{{ (old('nom')!== null)?old('nom'):(isset($oldValues)?$oldValues['nom']:'') }}"  >
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label"> <span class="text-danger"> *</span> الاسم</label>
                                    <input type="text" class="form-control" name="prenom" placeholder="الاسم"  value="{{ (old('prenom')!== null)?old('prenom'):(isset($oldValues)?$oldValues['prenom']:'') }}"  >
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                            <div class="row" id="societe" style="display: none;">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label"><span class="text-danger"> *</span>RC </label>
                                    <input type="text" class="form-control" name="rc" placeholder="RC"  value="{{ (old('rc')!== null)?old('rc'):(isset($oldValues)?$oldValues['rc']:'') }}"  >
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label"> <span class="text-danger"> *</span> اسم الشركة </label>
                                    <input type="text" class="form-control" name="ste" placeholder="اسم الشركة"  value="{{ (old('ste')!== null)?old('ste'):(isset($oldValues)?$oldValues['ste']:'') }}"  >
                                </div>
                            </div><!-- Col -->

                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label"> <span class="text-danger"> *</span> المسير</label>
                                    <input type="text" class="form-control"  name="gerant" placeholder="المسير"   value="{{ (old('gerant')!== null)?old('gerant'):(isset($oldValues)?$oldValues['gerant']:'') }}"  >
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label"><span class="text-danger"> *</span> المقر الرئيسي للشركة </label>
                                    <input type="text" class="form-control"  name="siege" placeholder="المقر الرئيسي للشركة"  value="{{ (old('siege')!== null)?old('siege'):(isset($oldValues)?$oldValues['siege']:'') }}"   >
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                        <h6 class="card-title bold fs-4 pt-2">- المدعى عليه</h6>


                        <div class="mb-3">
                            <div class=" " style="display: flex; flex-shrink: 1; gap:5px">

                                <input type="text" name="terme" id="type-input"  placeholder=" نسب المدعى عليه" class="form-control w-50 mx-auto" autocomplete="off"><br>

                            </div>
                            <div id="search-results" class="search-results w-50 mx-auto "></div>
                        </div>

                        @if(isset($oldValues) && isset($oldValues['condition']) && !isset($adversaire))
                        <div class="alert alert-danger">
                            <ul>

                                    <li>
                                        يجب عليك تسجيل هذا المستخدم لأنه غير موجود
                                    </li>

                            </ul>
                        </div>
                        @endif



                        <div class="row" >
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label"> <span class="text-danger"> *</span> الاسم</label>
                                    <input type="text" class="form-control" id="prenomadv" name="prenomadv" placeholder="الاسم" value="{{ (old('prenomadv')!== null)?old('prenomadv'):(isset($adversaire)?$adversaire->prenom :(isset($oldValues)?$oldValues['prenomadv'] :'')) }}" required>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label"> <span class="text-danger"> *</span> النسب </label>
                                    <input type="text" class="form-control" name="nomadv" id="nomadv" placeholder="النسب" value="{{ (old('nomadv')!== null)?old('nomadv'):(isset($adversaire)?$adversaire->nom :(isset($oldValues)?$oldValues['nomadv'] :'')) }}" required>
                                </div>
                            </div><!-- Col -->

                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label"> <span class="text-danger"> *</span> العنوان 1</label>
                                    <input type="text" class="form-control"  id="adresse1"  name="adresse1" placeholder="العنوان 1" value="{{ (old('adresse1')!== null)?old('adresse1'):(isset($adversaire)?$adversaire->adresse1 :(isset($oldValues)?$oldValues['adresse1'] :'')) }}" required >
                                </div>
                            </div><!-- Col --> <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">العنوان 2</label>
                                    <input type="text" class="form-control"  id="adresse2"  name="adresse2" placeholder="العنوان 2"   value="{{ (old('adresse2')!== null)?old('adresse2'):(isset($adversaire)?$adversaire->adresse2 :(isset($oldValues)?$oldValues['adresse2'] :'')) }}"  >
                                </div>
                            </div><!-- Col --> <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">العنوان 3</label>
                                    <input type="text" class="form-control"  id="adresse3" name="adresse3" placeholder="العنوان 3" value="{{ (old('adresse3')!== null )?old('adresse3'):(isset($adversaire)?$adversaire->adresse3 :(isset($oldValues)?$oldValues['adresse3'] :'')) }}" >
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
                        url: '/searchAdversaire',
                        dataType: 'json',
                        data: {
                            term: term
                        },
                        success: function(data) {
                            var results = '';
                            if (data.length > 0) {
                                console.log(data);

                                $.each(data, function(index, value) {
                                    results += '<div class="search-result" data-value=\'' + JSON.stringify(value) + '\'>' + value.nom +' '+ value.prenom + '</div>';
                                    console.log(results); // Step 1: Check the generated HTML
                                    console.log(JSON.stringify(value)); // Step 2: Check the generated JSON string
                                });
                            } else {
                                results = '<div class="no-resultUncaught SyntaxError: JSON.parse: unexpected character at">No results found</div>';
                                $('#nomadv').val('');
                                $('#prenomadv').val('');
                                $('#adresse1').val('');
                                $('#adresse2').val('');
                                $('#adresse3').val('');
                            }
                            $('#search-results').html(results);
                        } ,
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText); // Step 4: Check for any other JavaScript errors or conflicts
                        }
                    });
                } else {
                    $('#search-results').empty();
                }
            });

            $(document).on('click', '.search-result', function() {
                var selectedDataValue = $(this).data('value');
                var selectedData = JSON.parse(JSON.stringify(selectedDataValue));

                $('#type-input').val(selectedData.nom +' '+selectedData.prenom);
                $('#nomadv').val(selectedData.nom);
                $('#prenomadv').val(selectedData.prenom);
                $('#adresse1').val(selectedData.adresse1);
                $('#adresse2').val(selectedData.adresse2);
                $('#adresse3').val(selectedData.adresse3);
                $('#search-results').empty();
            });

        });

    </script>
    <script language="javascript" >
        document.getElementById("mySelect").addEventListener("change", function() {
            var selectedValue = this.value;
            console.log(selectedValue)

            if (selectedValue === "1") {
                document.getElementById("physique").style.display = "";
                document.getElementById("societe").style.display = "none";
            } else if (selectedValue === "2") {
                document.getElementById("physique").style.display = "none";
                document.getElementById("societe").style.display = "";
            }
        });

    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function searchAdversaire() {
            var searchValue = document.getElementById("searchInput").value;

            // Make an AJAX request to fetch the adversaire data based on the search input
            // Replace the URL below with the actual endpoint that handles the search request
            var url = "/search-adversaire?name=" + searchValue;
            var xhr = new XMLHttpRequest();
            xhr.open("GET", url, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var adversaire = JSON.parse(xhr.responseText);
                    console.log(adversaire);

                    if (searchValue === '') {
                        // Clear the input fields
                        document.getElementById("prenomadv").value = '';
                        document.getElementById("nomadv").value = '';
                        document.getElementById("adresse1").value = '';
                        document.getElementById("adresse2").value = '';
                        document.getElementById("adresse3").value = '';
                        adversaire = null; // Set adversaire data to null
                    } else if (adversaire == null) {
                        // Clear the input fields
                        document.getElementById("prenomadv").value = '';
                        document.getElementById("nomadv").value = '';
                        document.getElementById("adresse1").value = '';
                        document.getElementById("adresse2").value = '';
                        document.getElementById("adresse3").value = '';
                    } else {
                        // Update the adversaire data in the form
                        document.getElementById("prenomadv").value = adversaire.prenom || '';
                        document.getElementById("nomadv").value = adversaire.nom || '';
                        document.getElementById("adresse1").value = adversaire.adresse1 || '';
                        document.getElementById("adresse2").value = adversaire.adresse2 || '';
                        document.getElementById("adresse3").value = adversaire.adresse3 || '';
                    }
                    // Update other fields as needed


                }
            };
            xhr.send();
        }


    </script>

@endsection
