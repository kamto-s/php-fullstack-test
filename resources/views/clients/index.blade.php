<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- fontawesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- datatable --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">

    <title>ASI - Fullsatack Developer</title>
</head>

<body>
    <div class="container-fluid my-5">
        <div class="card">
            <h5 class="card-header">Table Client</h5>
            <div class="card-body">

                <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal"
                    data-bs-target="#exampleModal" onclick="addModal()"> <i class="fa-solid fa-plus"></i>
                    Add Client
                </button>

                <table id="tableClient" class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">name</th>
                            <th scope="col">slug</th>
                            <th scope="col">is_project</th>
                            <th scope="col">self_capture</th>
                            <th scope="col">client_prefix</th>
                            <th scope="col">client_logo</th>
                            <th scope="col">address</th>
                            <th scope="col">phone_number</th>
                            <th scope="col">city</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('clients.modal')

    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    {{-- Bootstrap5 --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    {{-- sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- datatable --}}
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\ClientRequest', '#clientForm') !!}

    <script>
        let save_method;

        $(document).ready(function() {
            clientTable();
        });

        function clientTable() {
            $('#tableClient').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: 'client/datatable',
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                }, {
                    data: 'name',
                    name: 'name',
                }, {
                    data: 'slug',
                    name: 'slug',
                }, {
                    data: 'is_project',
                    name: 'is_project',
                }, {
                    data: 'self_capture',
                    name: 'self_capture',
                }, {
                    data: 'client_prefix',
                    name: 'client_prefix',
                }, {
                    data: 'client_logo',
                    name: 'client_logo',
                }, {
                    data: 'address',
                    name: 'address',
                }, {
                    data: 'phone_number',
                    name: 'phone_number',
                }, {
                    data: 'city',
                    name: 'city',
                }, {
                    data: 'action',
                    name: 'action',
                }, ],
            });
        }

        function resetValidation() {
            $('.is-invalid').removeClass('is-invalid');
            $('.is-valid').removeClass('is-valid');
            $('span.invalid-feedback').remove();
        }

        // addModal
        function addModal() {
            $('#clientForm')[0].reset();

            resetValidation();

            $('#clientModal').modal('show');

            save_method = 'add';

            $('.modal-title').text('Add New Client');
            $('.btnSubmit').text('Create');
        }

        // FORM - store/ update
        $('#clientForm').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this)

            var url, method;

            url = "clients";
            method = "POST";

            if (save_method == 'edit') {
                url = 'clients/' + $('#id').val();
                formData.append('_method', 'PUT')
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: method,
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#clientModal').modal('hide');
                    $('#tableClient').DataTable().ajax.reload();

                    Swal.fire({
                        title: response.title,
                        text: response.text,
                        icon: response.icon,
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.responseText);
                    // alert("Error: " + jqXHR.responseText);
                }
            });
        });

        // editModal
        function editModal(e) {
            let id = e.getAttribute('data-id');

            save_method = 'edit';

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: "clients/" + id,
                success: function(response) {
                    let result = response.data;

                    console.log(result);

                    $('#name').val(result.name)
                    $('#is_project').val(result.is_project)
                    $('#self_capture').val(result.self_capture)
                    $('#client_prefix').val(result.client_prefix)
                    $('#logo-preview').attr('src', 'storage/images/' + result.client_logo)
                    $('#address').val(result.address)
                    $('#phone_number').val(result.phone_number)
                    $('#city').val(result.city)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.responseText);
                    alert("Error displaying data: " + jqXHR.responseText);
                }
            });

            resetValidation();
            $('#clientModal').modal('show');

            $('.modal-title').text('Update Client');
            $('.btnSubmit').text('Update');
        }

        // delete
        function deleteModal(e) {
            let id = e.getAttribute('data-id');

            Swal.fire({
                title: "Delete?",
                text: "Are you sure you want to delete this client?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                confirmButtonColor: "#3085d6",
                cancelButtonText: "No, cancel!",
                cancelButtonColor: "#d33",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "DELETE",
                        url: "clients/" + id,
                        dataType: "json",
                        success: function(response) {
                            $('#clientModal').modal('hide');

                            $('#tableClient').DataTable().ajax.reload();

                            Swal.fire({
                                title: response.title,
                                text: response.text,
                                icon: response.icon,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR.responseText);
                            alert(jqXHR.responseText);
                        }
                    });
                }
            });
        }
    </script>
</body>

</html>
