@extends('admin/layouts/index')
@section('Admin', 'listrooms')
@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" style="float: left;margin-right: 15px;padding: 7px 0px;">List room</h5>
                    <button type="button" class="btn btn-primary" onclick="openModalAdd()">
                        Thêm phòng
                    </button>
                    <div class="table-responsive">
                        <form action="/" method="get">
                            @csrf
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Phòng</th>
                                    <th>Khu</th>
                                    <th>Tầng</th>
                                    <th>Mô tả</th>
                                    <th>Dọn dẹp</th>                                    
                                    <th>Trạng thái</th>
                                    <th>Hoạt động</th>
                                    <th>Chức năng</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($room['room'] as $ro)
                                    <tr>
                                        <td>{{$ro->room_name}}</td>
                                        <td>{{$ro->namezone}}</td>
                                        <td>{{$ro->floor}}</td>
                                        <td>
                                            @if($ro->description == null)
                                                Không có mô tả
                                            @else
                                                {{$ro->description}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($ro->clean_up == 1)
                                                Đã dọn dẹp
                                            @else
                                                Chưa dọn dẹp
                                            @endif
                                        </td>
                                        <td>
                                            @if($ro->activity == 1)
                                                Sử dụng được
                                            @else
                                                Đang sửa
                                            @endif
                                        </td>
                                        <td>
                                            @if($ro->status == 1)
                                                Đang sử dụng
                                            @else
                                                Chưa sử dụng
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-white" onclick="detailRoom({{$ro->id}})">
                                                <i class="fas fa-edit"></i></button>
                                            <button type="button" class="btn btn-white" onclick="deleteRoom({{$ro->id}})"><i
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
    <div class="modal fade" id="addroom" tabindex="-1" role="dialog" aria-labelledby="addroom" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tt">Thêm phòng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <div class="form-title">Phòng:</div>
                            <input type="text" name="name" class="form-control">
                            <span class="text-danger text-error name_error"></span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-title">Khu:</div>
                            <select class="form-control" name="zone">
                                @foreach($room['zone'] as $zo)
                                    <option  value="{{$zo->id}}">{{$zo->name}}</option>
                                @endforeach
                            </select>
                            <span class="error-slide"></span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-title">Tầng:</div>
                            <input type="text" name="floor" class="form-control">
                            <span class="text-danger text-error floor_error"></span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-title">Mô tả:</div>
                            <textarea name="description"  cols="40" rows="5"></textarea>
                            <span class="error-slide"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="addRoom()" class="btn btn-primary">Thêm</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editroom" tabindex="-1" role="dialog" aria-labelledby="editroom" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editroom">Chỉnh sửa phòng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="text" id="id" name="id" hidden>
                        <div class="form-group">
                            <div class="form-title">Phòng:</div>
                            <input type="text" name="name" id="nameroom" class="form-control">
                            <span class="error-slide"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Khu:</div>
                            <select class="form-control" name="id_zone" id="namezone">
                                @foreach($room['zone'] as $ro)
                                    <option  value="{{$ro->id}}">{{$ro->name}}</option>
                                @endforeach
                            </select>
                            <span class="error-slide"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Tầng:</div>
                            <input type="text" name="floor" id="floor" class="form-control">
                            <span class="error-slide"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Dọn dẹp:</div>
                            <select class="form-control" name="clean_up" id="clean_up">
                                <option value="1">Đã dọn dẹp</option>
                                <option value="0">Chưa dọn dẹp</option>
                            </select>
                            <span class="error-slide"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Trạng thái:</div>
                            <select class="form-control" name="activity" id="activity">
                                <option value="1"selected>Sử dụng được</option>
                                <option value="0">Hỏng</option>
                            </select>
                            <span class="error-slide"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Hoạt động:</div>
                            <select class="form-control" name="status" id="status">
                                <option value="1">Đang sử dụng</option>
                                <option value="0">Chưa sử dụng</option>
                            </select>
                            <span class="error-slide"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Mô tả:</div>
                            <textarea name="description" id="description" cols="40" rows="5"></textarea>
                            <span class="error-slide"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="submitEditRoom()" class="btn btn-primary">Sửa</button>
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
            $("#addroom").modal('show');
        }
        function openModalEdit(){
            $("#editroom").modal('show');
        }
        function addRoom(){
            event.preventDefault();
            $.ajax({
                url: 'room/addroom',
                method: 'POST',
                data: new FormData($("#addroom form")[0]),
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
                            //    $('#addroom')[0].reset();
                            //    alert(data.msg);
                            window.location.reload(1000);
                        }
                        
                    }
            });
        }
        function detailRoom(id){
            event.preventDefault();
            openModalEdit();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'room/detailroom/'+id,
                method: 'GET',
                contentType: false,
                processData: false,
                success:function(data){
                    console.log(data);
                    $("#id").val(data.id);
                    $("#nameroom").val(data.room_name);
                    $("#namezone").val(data.id_zone);
                    $("#floor").val(data.floor);
                    $("#clean_up").val(data.clean_up);
                    $("#activity").val(data.activity);
                    $("#status").val(data.status);
                    $("#editcomputer textarea[name=description]").val(data.description);
                }
            });
        }
        function deleteRoom(id){
            event.preventDefault();
            if(confirm("Bạn có chắc muốn xóa sản phẩm này?")){
                $.ajax({
                    url: 'room/deleteroom/'+id,
                    method: 'GET',
                    contentType: false,
                    processData: false,
                    success:function(data){

                        window.location.reload(1000);
                    }
                });
            }
        }
        function submitEditRoom(){
            event.preventDefault();
            $.ajax({
                url: 'room/editroom',
                method: 'POST',
                data: new FormData($("#editroom form")[0]),
                contentType: false,
                processData: false,
                success:function(data){

                    window.location.reload(1000);
                }
            });
        }
    </script>
@endsection
@section('script')
@endsection
