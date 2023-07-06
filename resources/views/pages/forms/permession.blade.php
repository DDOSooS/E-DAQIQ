@extends('layout.master')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title text-center fs-4" id=""> <i data-feather="lock" class="icon-sm me-2 bold fs-1 "></i>إدارة الصلاحيات</h6>

                    <div class="table-responsive pt-3">
                        <form method="post" action="{{url('/add-permission',$assisatant_id)}}">
                            @method("post")
                            @csrf
                            <hr>

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
                                        <input type="checkbox" name="permissions[]"  value="Clients" class="form-check-input permission-checkbox"   @if(in_array('Clients', explode(',', $member->permissions))) checked @endif id="checkDefault1">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="permissions[]"  value="addClient" class="form-check-input permission-checkbox"  @if(in_array('addClient', explode(',', $member->permissions))) checked @endif id="checkDefault2">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="permissions[]"  value="editClient" class="form-check-input permission-checkbox" @if(in_array('editClient', explode(',', $member->permissions))) checked @endif id="checkDefault3">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="permissions[]"  value="deleteClient" class="form-check-input permission-checkbox" @if(in_array('deleteClient', explode(',', $member->permissions))) checked @endif id="checkDefault4">
                                    </td>
                                </tr>
                                <tr>
                                    <td>الملفات</td>
                                    <td>
                                        <input type="checkbox" name="permissions[]"  value="Cases" class="form-check-input permission-checkbox" @if(in_array('Cases', explode(',', $member->permissions))) checked @endif id="checkDefault5">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="permissions[]"  value="addCase" class="form-check-input permission-checkbox" @if(in_array('addCase', explode(',', $member->permissions))) checked @endif id="checkDefault6">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="permissions[]"  value="editCase" class="form-check-input permission-checkbox"  @if(in_array('editCase', explode(',', $member->permissions))) checked @endif id="checkDefault7">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="permissions[]"  value="deleteCase" class="form-check-input permission-checkbox"  @if(in_array('deleteCase', explode(',', $member->permissions))) checked @endif id="checkDefault8">
                                    </td>
                                </tr>
                                <tr>
                                    <td>الفواتير</td>
                                    <td>
                                        <input type="checkbox" name="permissions[]"  value="Invoices" class="form-check-input permission-checkbox"  @if(in_array('Invoices', explode(',', $member->permissions))) checked @endif id="checkDefault9">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="permissions[]"  value="addInvoice" class="form-check-input permission-checkbox"  @if(in_array('addInvoice', explode(',', $member->permissions))) checked @endif id="checkDefault10">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="permissions[]"  value="editInvoice" class="form-check-input permission-checkbox"  @if(in_array('editInvoice', explode(',', $member->permissions))) checked @endif id="checkDefault11">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="permissions[]" value="deleteInvoice"  class="form-check-input permission-checkbox" @if(in_array('deleteInvoice', explode(',', $member->permissions))) checked @endif id="checkDefault12">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                                    <button type="submit" name="submit" class="btn btn-primary submit mt-2">مصادقة</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
