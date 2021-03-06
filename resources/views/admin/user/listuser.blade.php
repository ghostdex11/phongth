@extends('admin/layouts/index')
@section('Admin', 'Computer')
@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" style="float: left;margin-right: 15px;padding: 7px 0px;">Danh sách người dùng</h5>
                    <button type="button" class="btn btn-primary" onclick="openModalAdd()">
                        Thêm người dùng
                    </button>
                    <div class="table-responsive">
                        <form action="/" method="get">
                            @csrf
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Tên</th>
                                    <th>Mã số</th>
                                    <th>Lớp</th>
                                    <th>Khoa</th>
                                    <th>Email</th>
                                    <th>Loại</th>
                                    <th>Chức năng</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($user as $us)
                                    <tr>
                                        <td>{{$us->name}}</td>
                                        <td>{{$us->msv}}</td>
                                        <td>{{$us->class}}</td>
                                        <td>{{$us->faculty}}</td>
                                        <td>{{$us->email}}</td>
                                        <td>
                                            @if($us->type == 1)
                                                Admin
                                            @else
                                                user
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-white" onclick="detailUser({{$us->id}})">
                                                <i class="fas fa-edit"></i></button>
                                            <button type="button" class="btn btn-white" onclick="deleteUser({{$us->id}})"><i
                                                    class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="adduser" tabindex="-1" role="dialog" aria-labelledby="adduser" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tt">Thêm người dùng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <div class="form-title">Tên:</div>
                            <input type="text" name="name" class="form-control">
                            <span class="text-danger text-error name_error"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Mã số:</div>
                            <input type="text" name="msv" class="form-control">
                            <span class="text-danger text-error msv_error"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Lớp:</div>
                            <input type="text" name="class" class="form-control">
                            <span class="text-danger text-error class_error"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Khoa:</div>
                            <input type="text" name="faculty" class="form-control">
                            <span class="text-danger text-error faculty_error"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Email:</div>
                            <input type="text" name="email" class="form-control">
                            <span class="text-danger text-error email_error"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Mật khẩu:</div>
                            <input type="password" name="password" class="form-control">
                            <span class="text-danger text-error password_error"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Nhập lại mật khẩu:</div>
                            <input type="password" name="passwordagain" class="form-control">
                            <span class="text-danger text-error passwordagain_error"></span>
                        </div>
                        <div class="form-group">
                            <label>Loại:</label>
                            <label class="radio-inline">
                                <input name="type" value="0" checked="" type="radio">:User
                            </label>
                            <label class="radio-inline">
                                <input name="type" value="1" type="radio">:Admin
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="addUser()" class="btn btn-primary">Thêm</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edituser" tabindex="-1" role="dialog" aria-labelledby="edituser" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chỉnh sửa người dùng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @if(count($errors)>0)
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $err)
                            {{$err}}<br>
                        @endforeach
                    </div>
                @endif

                @if(session('thongbao'))
                    <div class="alert alert-success">
                        {{session('thongbao')}}
                    </div>
                @endif
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="text" id="id" name="id" hidden>
                        <div class="form-group">
                            <div class="form-title">Tên:</div>
                            <input type="text" id="name"  name="name" class="form-control">
                            <span class="error-slide"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Mã số:</div>
                            <input type="text" name="msv" id="msv" class="form-control">
                            <span class="error-slide"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Lớp:</div>
                            <input type="text" name="class" id="class" class="form-control">
                            <span class="error-slide"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Khoa:</div>
                            <input type="text" name="faculty" id="faculty" class="form-control">
                            <span class="error-slide"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Email:</div>
                            <input type="text" name="email" id="email" readonly="" class="form-control">
                            <span class="error-slide"></span>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" id="changePassword" name="changePassword">
                            <label>Đổi mật khẩu</label>
                            <input type="password" name="password" class="form-control password" disabled="" >
                            <span class="text-danger text-error password_error"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Đổi lại mật khẩu:</div>
                            <input type="password" name="passwordagain" class="form-control password" disabled="" >
                            <span class="text-danger text-error password_error"></span>
                        </div>
                        <div class="form-group">
                            <label>Loại:</label>
                            <label class="radio-inline">
                                <input name="type" value="0" checked="" id="type"  type="radio">:User
                            </label>
                            <label class="radio-inline">
                                <input name="type" value="1" id="type" type="radio">:Admin
                            </label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="submitEditUser()" class="btn btn-primary">Sửa</button>
                            <button type="button" data-dismiss="modal" class="btn btn-danger">Hủy</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery-3.5.1.min.js') }}" language="JavaScript" type="text/javascript"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/3.5.1/js/toastr.min.js">
    </script>
    <script>

        function openModalAdd(){
            $("#adduser").modal('show');
        }
        function openModalEdit(){
            $("#edituser").modal('show');
        }
        function addUser(){
            event.preventDefault();
            $.ajax({
                url: 'user/adduser',
                method: 'POST',
                data: new FormData($("#adduser form")[0]),
                contentType: false,
                processData: false,
                beforeSend:function (){
                        $(document).find('span.error-text').text('');        
                },
                    success:function(data){
                        if(data.status == 0){
                            $.each(data.error,function(prefix, val){
                                   $('span.'+prefix+'_error').text(val[0]); 
                            });
                        }else{
                            //    $('#adduser')[0].reset();
                            //    alert(data.msg);
                            window.location.reload(1000);
                        }
                        
                    }
            });
        }
        function detailUser(id){
            event.preventDefault();
            openModalEdit();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'user/detailuser/'+id,
                method: 'GET',
                contentType: false,
                processData: false,
                beforeSend:function (){
                        $(document).find('span.error-text').text('');        
                },
                success:function(data){
                    console.log(data);
                    $("#id").val(data.id);
                    $("#name").val(data.name);
                    $("#msv").val(data.msv);
                    $("#class").val(data.class);
                    $("#faculty").val(data.faculty);
                    $("#email").val(data.email);
                    $("#type").val(data.type);
                    // if(data.status == 0){
                    //         $.each(data.error,function(prefix, val){
                    //                $('span.'+prefix+'_error').text(val[0]); 
                    //         });
                    //     }else{
                    //         //    $('#edituser')[0].reset();
                    //         //    alert(data.msg);
                    //         // window.location.reload(1000);
                    //     }
                }
            });
        }
        function deleteUser(id){
            event.preventDefault();
            if(confirm("Bạn có chắc muốn xóa sản phẩm này?")){
                $.ajax({
                    url: 'user/deleteuser/'+id,
                    method: 'GET',
                    contentType: false,
                    processData: false,
                    success:function(data){

                        window.location.reload(1000);
                    }
                });
            }
        }
        function submitEditUser(){
            event.preventDefault();
            $.ajax({
                url: 'user/edituser',
                method: 'POST',
                data: new FormData($("#edituser form")[0]),
                contentType: false,
                processData: false,
                success:function(data){

                    window.location.reload(1000);
                }
            });
        }
    </script>
    <script>
        $(document).ready(function (){
            $("#changePassword").change(function (){
                if($(this).is(":checked"))
                {
                    $(".password").removeAttr('disabled');
                }
                else
                {
                    $(".password").attr('disabled','');
                }
            });
        });
    </script>
@endsection
@section('script')
@endsection
