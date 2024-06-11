@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h2 class="text-center">{{ __('Welcome Admin') }}</h2>
        <div>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
        </div>   
        <div class="mt-3 d-flex gap-2">
            <button type="button" class="btn btn-primary " data-toggle="modal" >
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register User') }}     </a>
            </button>

            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#csvUploadModal">
                Upload CSV
            </button>
       

        </div>

    </div>
</div>

<!-- CSV Upload Modal -->
<div class="modal fade" id="csvUploadModal" tabindex="-1" role="dialog" aria-labelledby="csvUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="csvUploadModalLabel">Upload CSV</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('addpayment') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="csv">CSV File</label>
                        <input type="file" class="form-control-file" id="csv" name="csv" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <h1 class="mt-5">All Employees</h1>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td class="actions">
                    <button class="btn btn-primary" onclick="openUpdateModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}')">Update</button>
                    <button class="btn btn-danger" onclick="deleteUser({{ $user->id }})">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateUserForm">
                    <input type="hidden" id="updateUserId">
                    <div class="form-group">
                        <label for="updateUserName">Name</label>
                        <input type="text" class="form-control" id="updateUserName" required>
                    </div>
                    <div class="form-group">
                        <label for="updateUserEmail">Email</label>
                        <input type="email" class="form-control" id="updateUserEmail" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
  <!-- Include SweetAlert -->


<script>
    // Your jQuery code goes here
    function openUpdateModal(id, name, email) {
        $('#updateUserId').val(id);
        $('#updateUserName').val(name);
        $('#updateUserEmail').val(email);
        $('#updateModal').modal('show');
    }
$(document).ready(function() {
    $('#updateUserForm').on('submit', function(event) {
        event.preventDefault();
        const id = $('#updateUserId').val();
        const name = $('#updateUserName').val();
        const email = $('#updateUserEmail').val();
        $.ajax({
            url: `/users/${id}`, // Use template literals for the URL
            type: 'PUT',
            data: { name, email },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Get CSRF token from meta tag
            },
            success: function(response) {
                if (response.success) {
                    $('#updateModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'User updated successfully',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to update user',
                        text: 'An error occurred while updating the user.',
                    });
                }
            }
        });
    });
});

 function deleteUser(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/users/${id}`, // Use backticks (`) for template literals
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'User deleted successfully',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed to delete user',
                            text: 'An error occurred while deleting the user.',
                        });
                    }
                }
            });
        }
    });
}

</script>
@endsection
