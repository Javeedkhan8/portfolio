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
            <h3 class="card-title">
                {{$title}}
            </h3>
            <div class="card-tools">
                <a href="{{route('employee.index')}}" class="btn btn-secondary">Back</a>
            </div>
        </div>
        <form action="{{route('employee.save')}}" method="post" id="frm_employee" enctype="multipart/form-data">
            @csrf
            <div class="card-body p-3">
                <div class="form-group row mb-3">
                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                    </div>
                    <label for="phone_no" class="col-sm-2 col-form-label">Phone Number</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="phone_no" name="phone_no" placeholder="Enter phone number">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-4">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                    </div>
                    <label for="dob" class="col-sm-2 col-form-label">Date of Birth</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="dob" name="dob" placeholder="Enter date of birth">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="image" class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-4">
                        <input type="file" class="form-control" name="image" id="image">
                    </div>
                    <label for="address" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-4">
                        <textarea class="form-control" id="address" name="address" placeholder="Enter address"></textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button class="btn btn-success" id="btn-save">Save</button>
            </div>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        $('#btn-save').click(function (e) {
            e.preventDefault();
            var frm = $('#frm_employee');
            var data = new FormData(frm[0]);

            if($(frm).valid()){
                $(this).attr('disabled', true);
                $.ajax({
                    method:$(frm).attr('method'),
                    url:$(frm).attr('action'),
                    dataType:'json',
                    data:data,
                    processData:false,
                    contentType:false,
                    success:function (result){
                        if(result.success == true){
                           Toast.fire({
                            icon:'success',
                            title:result.msg
                           });
                           window.location.href = "{{route('employee.index')}}";
                        } else {
                            Toast.fire({
                                icon:'error',
                                title:result.msg
                            });
                        }
                    }
                })
            }
        });
    </script>
</body>
</html>