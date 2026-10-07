<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title">Employee List</h3>
            <div class="card-tools">
                <a href="{{route('employee.create')}}" class="btn btn-primary">Add Employee</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="employee_table">
                <thead>
                    <tr>
                        <th>s.no</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                    <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$employee->name}}</td>
                    <td>{{$employee->email}}</td>
                    <td>{{$employee->phone_number}}</td>
                    <td>{{$employee->address}}</td>
                    <td>
                        <a href="{{route('employee.create', $employee->id)}}" class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-sm btn-danger" id="btn-delete" data-id="{{$employee->id}}">Delete</button>
                    </td>

                    @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet"
href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#employee_table').DataTable();
        })
        $('#btn-delete').click(function (e){
            e.preventDefault();

            swal.fire({
                title:'Are you sure?',
                icon:'warning',
                showCancelButton:true,
                confirmButtonText:'Yes, delete it!',
                cancelButtonText:'No, cancel!',
                reverseButtons:true
                }).then((result) => {

                var data = {
                    "_token": "{{csrf_token()}}",
                    "id": $(this).data('id')
                }

                $.ajax({
                    url: "{{route('employee.delete')}}",
                    method:'post',
                    dataType:'json',
                    data:data,
                    success: function (result){
                        if(result.success == true){
                            swal.fire(
                                'Deleted!',
                                result.msg,
                                'success'
                            ).then(() => {
                                location.reload();
                            })
                        } else {
                            swal.fire(
                                'Error!',
                                result.msg,
                                'error'
                            )
                        }
                    }
                })
            })
        })
    </script>
</body>
</html>