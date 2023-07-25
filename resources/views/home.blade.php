@extends('layouts.app')

@section('content')
<style>
    .error {
        color: #dc3545;
        font-size: 14px;
    }

    .hide {
        display: none;
    }

    #valid-msg {
        color: #00c900;
    }

    #error-msg {
        color: red;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">

<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script> <!-- <script src="js/intlTelInput.js"></script> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Record') }}</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <a class="btn btn-success mb-3" href="javascript:void(0)" id="createNewProduct"> Add New User</a>

                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Country</th>
                                <th>State</th>
                                <th>City</th>
                                <th>Profile</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                        </tbody>
                    </table>
                    <!-- {{ __('You are logged in!') }} -->
                </div>
            </div>
            <div class=" modal fade " data-bs-backdrop=" static" data-bs-keyboard="false" id="ajaxModel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modelHeading"></h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger print-error-msg" style="display:none">

                                <ul></ul>

                            </div>
                            <div class="success" style="display: none;"></div>
                            <form id="form" name="productForm" enctype="multipart/form-data" class="form-horizontal">
                                @csrf()
                                <input type="hidden" name="product_id" id="product_id">
                                <div class="form-group">

                                    <label for="name" class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-12">
                                        <input id="email" name="email" required="" placeholder="Enter Email" class="form-control"></input>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Phone</label>
                                    <div class="col-lg-12">
                                        <input type="tel" id="phone" name="phone" oninput="this.value = this.value.replace(/\D+/g, '')" class="form-control"></input>
                                        <span id="valid-msg" class="hide">✓ Valid</span>
                                        <span id="error-msg" class="hide">X </span>
                                        <!-- <input type="text" id="phone" class="form-control" placeholder="Phone Number" name="phone"> -->
                                    </div>
                                    <span class="error text-danger d-none"></span> <!-- <input id="fullNumber" type="text" name="fullNumber"> -->
                                </div>

                                <!-- Country Dropdown -->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Country</label>
                                    <div class="col-sm-12">
                                        <select id="country-dropdown" class="form-control" id="country" name="country">
                                            <option value="">-- Select Country --</option>

                                            @foreach ($country['countries'] as $data)

                                            <option value="{{$data->id}}">

                                                {{$data->name}}

                                            </option>

                                            @endforeach
                                            <!-- <option value="1">India</option> -->
                                        </select>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">States</label>
                                    <div class="col-sm-12">
                                        <select id="state-dropdown" class="form-control" id="state" name="state">
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" id="city" name="city">City</label>
                                    <div class="col-sm-12">
                                        <select id="city-dropdown" class="form-control" name="city">
                                        </select>
                                    </div>

                                </div>
                                <!-- Country Dropdown End -->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Avatar</label>
                                    <div class="col-sm-12">
                                        <input type="file" name="avatar" id="avatar" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" id="saveBtn" name="submit" class="btn btn-primary" value="create">Save </button>
                                    <button type="submit" class="btn btn-secondary mr-5" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        $('#createNewProduct').click(function() {
            $('#saveBtn').val("create-product");
            $('#product_id').val('');
            $('#productForm').trigger("reset");
            $('#modelHeading').html("Create New Product");
            $('#ajaxModel').modal('show');
        });
        // Datatable 
        $(document).ready(function() {
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('get-users.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'country',
                            name: 'country'
                        },
                        {
                            data: 'state',
                            name: 'state'
                        },
                        {
                            data: 'city',
                            name: 'city'
                        },
                        {
                            data: 'profile',
                            name: 'profile'
                        },


                    ]

                });



                // Datatable End 

                // Country Code 
                const input = document.querySelector("#phone");
                const errorMsg = document.querySelector("#error-msg");
                const validMsg = document.querySelector("#valid-msg");
                const errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
                const iti = window.intlTelInput(input, {
                    separateDialCode: true,
                    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js"
                });
                var erer = window.intlTelInputGlobals.getInstance(input);
                // input.addEventListener('input', function() {
                //     var fullNumber = iti.getNumber();
                //     document.getElementById('fullNumber').value = fullNumber;
                // });
                const reset = () => {
                    input.classList.remove("error");
                    errorMsg.innerHTML = "";
                    errorMsg.classList.add("hide");
                    validMsg.classList.add("hide");
                };
                input.addEventListener('blur', () => {
                    reset();
                    if (input.value.trim()) {
                        if (iti.isValidNumber()) {
                            validMsg.classList.remove("hide");

                        } else {
                            input.classList.add("error");
                            const errorCode = iti.getValidationError();
                            errorMsg.innerHTML = errorMap[errorCode];
                            errorMsg.classList.remove("hide");
                        }
                    }
                });
                input.addEventListener('change', reset);
                input.addEventListener('keyup', reset);

                //end country code


                if ($("#form").length > 0) {
                    $('#form').validate({
                        rules: {
                            name: {
                                required: true,
                                maxlength: 20,
                            },
                            email: {
                                required: true,
                                email: true,
                                maxlength: 50
                            },
                            phone: {
                                required: true,
                                number: true
                            },
                            country: {
                                required: true,
                            },
                            state: {
                                required: true,
                            },
                            city: {
                                required: true,
                            },
                            avatar: {
                                required: true,
                            }
                        },

                        messages: {
                            name: {
                                required: " Name is required",
                                maxlength: "First name cannot be more than 20 characters"
                            },
                            email: {
                                required: "Email is required",
                                email: "Email must be a valid email address",
                                maxlength: "Email cannot be more than 50 characters",
                            },
                            phone: {
                                required: "Phone number is required",
                                minlength: "Phone number must be of 10 digits"
                            },
                            country: {
                                required: "Country is required"
                            },
                            state: {
                                required: "Please Select is state"
                            },
                            city: {
                                required: "Please select the city"
                            },

                            avatar: {
                                required: "Please Select Image",
                            }
                        },
                        submitHandler: function(form) {
                            form.submit();
                        }
                    });
                }
                $('#saveBtn').click(function(e) {
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    if ($("#form").validate().form()) {
                        $("#saveBtn").html('Waiting..');
                        // var formData = new FormData(this);
                        var formData = new FormData($('#form')[0]);

                        $.ajax({
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            url: "{{ route('users.create') }}",
                            type: "POST",
                            dataType: 'json',
                            success: function(data) {
                                // var table = "";
                                // $('#tbody').load(document.URL + ' #tbody');
                                table.ajax.reload();
                                if ($.isEmptyObject(data.error)) {
                                    // alert(data.success);
                                    swal("Success", "Record Saved Successfully", "success", {
                                        button: "Ok",
                                    })
                                    // console.log(data.error);
                                    // $('div.success').html('Status changed').delay(1000).fadeOut();
                                    $('#form').trigger("reset");
                                    $('#ajaxModel').modal('hide');
                                    table.draw();
                                } else {
                                    // alert('dfs');
                                    // console.log(data.error);
                                    printErrorMsg(data.error);
                                }
                                // $('#form').trigger("reset");
                                // $('#ajaxModel').modal('hide');
                                // table.draw();
                            },
                            error: function(data) {
                                // console.log('Error:', data);
                                $('#saveBtn').html('Waiting');

                            }
                        });

                        function printErrorMsg(msg) {

                            $(".print-error-msg").find("ul").html('');

                            $(".print-error-msg").css('display', 'block');

                            $.each(msg, function(key, value) {
                                console.log(value);

                                // $('.' + key + '_err').text(value);


                                $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
                                // $.each(msg, function(key, value) {});
                            });

                        }
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#country-dropdown').on('change', function() {
                var idCountry = this.value;
                // alert('hrer');
                $("#state-dropdown").html('');
                $.ajax({
                    url: "{{url('admin/fetch-states')}}",
                    type: "POST",
                    data: {
                        country_id: idCountry,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#state-dropdown').html('<option value="">-- Select State --</option>');
                        $.each(result.states, function(key, value) {
                            $("#state-dropdown").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                        $('#city-dropdown').html('<option value="">-- Select City --</option>');
                    }
                });
            });
            /*-State Dropdown Change Event*/
            $('#state-dropdown').on('change', function() {
                var idState = this.value;
                $("#city-dropdown").html('');
                $.ajax({
                    url: "{{url('admin/fetch-cities')}}",
                    type: "POST",
                    data: {
                        state_id: idState,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function(res) {
                        $('#city-dropdown').html('<option value="">-- Select City --</option>');
                        $.each(res.cities, function(key, value) {
                            $("#city-dropdown").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>


</div>
@endsection