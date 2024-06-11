@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif
        <div class="p-3"><h2 class="text-center ">Salary Slip Details According to Month</h2></div>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Employee code</th>
                    <th>Designation</th>
                    <th>Department</th>
                    <th>Month</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->employee_code }}</td>
                    <td>{{ $employee->designation }}</td>
                    <td>{{ $employee->department }}</td>
                   <td>{{ \Carbon\Carbon::parse($employee->created_at)->format('d-m-Y') }}</td>
                   <td>
                    <form action="{{ route('send.employee.email') }}" method="POST" style="display: inline;">
                        @csrf
                        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                        <input type="hidden" name="created_at" value="{{ $employee->created_at }}">
                        <button type="submit" class="btn btn-primary">Send Mail</button>
                    </form>

                    <form action="{{ route('downloadPdf') }}" method="POST" style="display: inline;">
                        @csrf
                        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                        <input type="hidden" name="created_at" value="{{ $employee->created_at }}">
                        <button type="submit" class="btn btn-success">Download</button>
                    </form>
                </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
