@extends('layout.master')

@section('content')



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

                        <form method="post" action="{{url('/edit-cost',$frais->id)}}">
                        @method("put")
                        @csrf
                            <div class="input-container">
                                <div class="input-fields">
                                <div class="row mx-auto m-lg-3 mb-5" >
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label"><span class="text-danger"> *</span> المبلغ بالأرقام</label>
                                            <input type="number" class="form-control"  id="montantC" name="montantC"   value="{{ (old('montantC')!== null)?old('montantC'):(isset($oldValues)?$oldValues['montantC']:$frais->amountInFigure) }}"   required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label"> <span class="text-danger"> *</span> المبلغ بالحروف</label>
                                            <input type="text" class="form-control"   id="montantL" name="montantL"  value=" {{ (old('montantL')!== null)?old('montantL'):(isset($oldValues)?$oldValues['montantL']:$frais->amountInWorld) }}"    required>
                                        </div>
                                    </div><!-- Col -->

                                </div>
                                <div class="row mx-auto m-lg-3 mb-5" >
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label"><span class="text-danger"> *</span> طبيعة تكلفة </label>

                                            <select class="form-select form-select-lg mb-2"   name="typeFrais"  id="mySelect">
                                                @foreach($natures as $nature)
                                                    <option value="{{$nature->id}}" {{ ((isset($oldValues) and $oldValues['typeFrais']   ===  $nature->titleFrais ) or $frais->nature_id ==$nature->id) ? 'selected' : '' }}>
                                                        {{$nature->titleFrais}}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label"> <span class="text-danger"> *</span> التفاصيل</label>
                                            <textarea class="form-control" name="detail" >
                                                {{ $frais->detail }}
                                            </textarea>
                                        </div>
                                    </div><!-- Col -->

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
            $('#montantC').on('input', function() {
                var number = $(this).val();
                translateToArabic(number);
            });

            function translateToArabic(number) {
                // Perform an AJAX request to your Laravel route or controller method
                $.ajax({
                    url: '{{ route('translate.to.arabic') }}',
                    type: 'GET',
                    data: { number: number },
                    success: function(response) {
                        console.log(response);
                        $('#montantL').val(response.translation);
                    }
                });
            }
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
