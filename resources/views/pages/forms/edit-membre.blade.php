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

                        <form method="post" action="{{url('/edit-member',$member->id)}}">
                        @method("put")
                        @csrf

                        <div class="row mx-auto m-lg-3 mb-5" >
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label"><span class="text-danger"> *</span> الاسم</label>
                                    <input type="text" class="form-control"  id="prenom" name="prenom"   value="{{ (old('prenom')!== null)?old('prenom'):(isset($oldValues)?$oldValues['prenom']: $member->name) }}"   required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label"> <span class="text-danger"> *</span> النسب</label>
                                    <input type="text" class="form-control"   id="nom" name="nom"  value=" {{ (old('nom')!== null)?old('nom'):(isset($oldValues)?$oldValues['nom']:$member->lastname )}}"   required>
                                </div>
                            </div><!-- Col -->

                        </div>
                        <div class="row mx-auto m-lg-3 mb-5" >
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label"><span class="text-danger"> *</span> البريد الإلكتروني</label>
                                    <input type="text" class="form-control"  id="email" name="email"   value="{{ (old('email')!== null)?old('email'):(isset($oldValues)?$oldValues['email']:$member->email) }}"   required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label"> <span class="text-danger"> *</span> كلمة المرور</label>
                                    <input type="text" class="form-control"   id="password" name="password"  value=" {{ (old('password')!== null)?old('password'):(isset($oldValues)?$oldValues['password']:$member->original_password) }}"   required>
                                </div>
                            </div><!-- Col -->

                        </div>
                            <div class="row mx-auto m-lg-3 mb-5" >
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label"> العنوان</label>
                                    <input type="text" class="form-control"  id="adresse" name="adresse"   value="{{ (old('adresse')!== null)?old('adresse'):(isset($oldValues)?$oldValues['adresse']:$member->adresse) }}"   >
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label"> الهاتف <span class="text-danger"> *</span></label>
                                    <input type="text" class="form-control"   id="telephone" name="telephone"  value=" {{ (old('telephone')!== null)?old('telephone'):(isset($oldValues)?$oldValues['telephone']:$member->phone) }}"   required >
                                </div>
                            </div><!-- Col -->

                        </div>
                            <div class="form-check form-switch mb-2">
                                <input type="checkbox" class="form-check-input" id="formSwitch1">
                                <label class="form-check-label" for="formSwitch1"> كافة الصلاحيات</label>
                            </div>
                            <hr>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>صلاحيات الوحدات</th>
                                    <th>الولوج</th>
                                    <th class="h-100">اضافة</th>
                                    <th>تعديل</th>
                                    <th>حدف</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>العملاء</td>
                                    <td>
                                        <input type="checkbox" name="permissions[]"  value="Clients" class="form-check-input permission-checkbox"   @if(in_array('Clients', explode(',', $member->member->permissions))) checked @endif id="checkDefault1">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="permissions[]"  value="addClient" class="form-check-input permission-checkbox"  @if(in_array('addClient', explode(',', $member->member->permissions))) checked @endif id="checkDefault2">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="permissions[]"  value="editClient" class="form-check-input permission-checkbox" @if(in_array('editClient', explode(',', $member->member->permissions))) checked @endif id="checkDefault3">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="permissions[]"  value="deleteClient" class="form-check-input permission-checkbox" @if(in_array('deleteClient', explode(',', $member->member->permissions))) checked @endif id="checkDefault4">
                                    </td>
                                </tr>
                                <tr>
                                    <td>الملفات</td>
                                    <td>
                                        <input type="checkbox" name="permissions[]"  value="Cases" class="form-check-input permission-checkbox" @if(in_array('Cases', explode(',', $member->member->permissions))) checked @endif id="checkDefault5">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="permissions[]"  value="addCase" class="form-check-input permission-checkbox" @if(in_array('addCase', explode(',', $member->member->permissions))) checked @endif id="checkDefault6">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="permissions[]"  value="editCase" class="form-check-input permission-checkbox"  @if(in_array('editCase', explode(',', $member->member->permissions))) checked @endif id="checkDefault7">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="permissions[]"  value="deleteCase" class="form-check-input permission-checkbox"  @if(in_array('deleteCase', explode(',', $member->member->permissions))) checked @endif id="checkDefault8">
                                    </td>
                                </tr>
                                <tr>
                                    <td>الفواتير</td>
                                    <td>
                                        <input type="checkbox" name="permissions[]"  value="Invoices" class="form-check-input permission-checkbox"  @if(in_array('Invoices', explode(',', $member->member->permissions))) checked @endif id="checkDefault9">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="permissions[]"  value="addInvoice" class="form-check-input permission-checkbox"  @if(in_array('addInvoice', explode(',', $member->member->permissions))) checked @endif id="checkDefault10">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="permissions[]"  value="editInvoice" class="form-check-input permission-checkbox"  @if(in_array('editInvoice', explode(',', $member->member->permissions))) checked @endif id="checkDefault11">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="permissions[]" value="deleteInvoice"  class="form-check-input permission-checkbox" @if(in_array('deleteInvoice', explode(',', $member->member->permissions))) checked @endif id="checkDefault12">
                                    </td>
                                </tr>
                                </tbody>
                            </table>


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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Check all checkboxes when the "كافة الصلاحيات" checkbox is clicked
            $('#formSwitch1').click(function() {
                var isChecked = this.checked;
                $('input.permission-checkbox').prop('checked', isChecked);
            });

            // Handle checkbox change
            $('input.permission-checkbox').change(function() {
                // Uncheck the "كافة الصلاحيات" checkbox if any checkbox is unchecked
                if (!$(this).is(':checked')) {
                    $('#formSwitch1').prop('checked', false);
                } else {
                    // Check if all permission checkboxes are checked
                    var allChecked = $('input.permission-checkbox:checked').length === $('input.permission-checkbox').length;
                    $('#formSwitch1').prop('checked', allChecked);
                }
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
