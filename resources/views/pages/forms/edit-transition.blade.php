@extends('layout.master')

@section('content')


    <div class="row mx-auto w-75 align-middle">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body w-auto d-flex align-items-center">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="d-flex justify-content-center w-100">
                        <!-- Wrap the form in d-flex justify-content-center -->
                        <form method="post" action="{{url('/edit-transition',$transition->id)}}" class="mx-auto w-100">
                            @method("put")
                            @csrf
                            <div class="input-container">
                                <div class="input-fields">
                                    <div class="row mx-auto m-lg-3 mb-5">
                                        <div class="p-3">
                                            <div class="mb-3">
                                                <label class="form-label"><span class="text-danger">*</span> المبلغ بالأرقام</label>
                                                <input type="number" class="form-control p-2" id="montantC" name="montantC" value="{{ (old('montantC')!== null)?old('montantC'):(isset($oldValues)?$oldValues['montantC']:$transition->amount) }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mx-auto m-lg-3 mb-5">
                                        <div class="">
                                            <div class="mb-3">
                                                <label class="form-label"><span class="text-danger">*</span> طريقة الدفع</label>
                                                <select class="form-select form-select-lg mb-2 p-2" name="typePaiment" id="mySelect" required>
                                                    <option value="Cheque" {{   $transition->type ==  "Cheque"   ? 'selected' : '' }}>
                                                        Cheque
                                                    </option>
                                                    <option value="Espece" {{ $transition->type   ==  "Espece"   ? 'selected' : '' }}>
                                                        Espece
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary submit mt-2">مصادقة</button>
                        </form>
                    </div> <!-- Close the d-flex div -->

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
    <script>
        var counter = 1; // Counter for unique identifiers

        function duplicateInputs() {
            var inputContainer = $('.input-container').first(); // Get the first input container
            var clone = inputContainer.clone();

            // Update the name and ID attributes of the cloned input fields
            clone.find('input[name="montantC[]"]').attr('name', 'montantC[' + counter + ']');
            clone.find('input[name="montantL[]"]').attr('name', 'montantL[' + counter + ']');
            clone.find('select[name="typeFrais[]"]').attr('name', 'typeFrais[' + counter + ']');
            clone.find('textarea[name="detail[]"]').attr('name', 'detail[' + counter + ']');

            clone.insertAfter(inputContainer);

            // Reset the values of the cloned input fields
            clone.find('input[name="montantC[]"]').val('');
            clone.find('input[name="montantL[]"]').val('');
            clone.find('select[name="typeFrais[]"]').prop('selectedIndex', 0);
            clone.find('textarea[name="detail[]"]').val('');

            counter++; // Increment the counter for the next set of input fields
        }
    </script>





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
        function searchAdversaire() {
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
