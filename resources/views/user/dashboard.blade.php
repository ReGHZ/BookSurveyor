@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="assets/css/pages/datatables.css">
@endsection
@section('content')
    <div class="container" id="App">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <button type="button" class="btn btn-outline-success mb-2" data-bs-toggle="modal"
                    data-bs-target="#storeBook">
                    Create
                </button>
                <div id="success_message"></div>
                <div class="card">
                    <div class="card-body">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Book Title</th>
                                    <th>Book Code</th>
                                    <th>Book Author</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('user.create')
        @include('user.edit')
        @include('user.delete')
    </div>
@endsection
@push('scripts')
    <script src="assets/extensions/jquery/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script src="assets/js/pages/datatables.js"></script>


    <script>
        $(document).ready(function() {

            // datatable
            var table = $('#table1').DataTable({
                processing: true,
                serverSide: true,
                "bDestroy": true,
                ajax: "{{ url('/user-page') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'author',
                        name: 'author'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $(document).on('click', '.store', function(e) {

                e.preventDefault();

                $.ajax({
                    url: '{{ url('/store-book') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        user_id: $('input[name=user_id]').val(),
                        title: $('input[name=title]').val(),
                        code: $('input[name=code]').val(),
                        author: $('input[name=author]').val(),
                        description: $('textarea[name=description]').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 400) {
                            $('#saveform_errlist').html("");
                            $('#saveform_errlist').addClass('alert alert-danger');
                            $.each(response.errors, function(key, err_value) {
                                $('#saveform_errlist').append('<li>' + err_value +
                                    '</li>');
                            });
                        } else {
                            $('#saveform_errlist').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').html(response.message);
                            $('#storeBook').modal('hide');
                            $('#storeBook').find('input').val("");
                            table.draw();

                        }
                    }

                });
            });

            $(document).on('click', '.edit', function(e) {

                e.preventDefault();
                var book_id = $(this).data('id');
                $("#editBook").modal('show');

                $.ajax({
                    type: "GET",
                    url: "{{ url('/edit-book') }}/" + book_id,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 400) {
                            $('#success_message').html('');
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                        } else {
                            $('input[name=book_id]').val(response.book.id);
                            $('input[name=title]').val(response.book.title);
                            $('input[name=code]').val(response.book.code);
                            $('input[name=author]').val(response.book.author);
                            $('textarea[name=description]').val(response.book.description);
                        }
                    }
                });
            });

            $(document).on('click', '.update', function(e) {
                e.preventDefault();
                var book_id = $('#book_id').val();
                $(this).text('Updating...');
                $.ajax({
                    type: "PUT",
                    url: "{{ url('/update-book') }}/" + book_id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        user_id: $('#edit_user_id').val(),
                        title: $('#edit_title').val(),
                        code: $('#edit_code').val(),
                        author: $('#edit_author').val(),
                        description: $('#edit_description').val()
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 400) {

                            $('#updateform_errlist').html("");
                            $('#updateform_errlist').addClass('alert alert-danger');
                            $.each(response.errors, function(key, err_value) {
                                $('#updateform_errlist').append('<li>' + err_value +
                                    '</li>');
                            });
                            $('.update').text('Update');

                        } else {

                            $('#updateform_errlist').html("");
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('.update').text('Update');
                            $('#editBook').modal('hide');
                            table.draw();
                        }
                    }
                });
            });

            $(document).on('click', '.btndelete', function(e) {
                e.preventDefault();
                var book_id = $(this).data('id');

                $('#delbook_id').val(book_id);
                $('#deleteBook').modal('show');
            });

            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                var book_id = $('#delbook_id').val();

                $.ajax({
                    type: "DELETE",
                    url: "{{ url('/delete-book') }}/" + book_id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status == 400) {
                            $('#success_message').html('');
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                        } else {
                            $('#success_message').html('');
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#deleteBook').modal('hide');
                            table.draw();
                        }
                    }
                });

            });
        });
    </script>
@endpush
