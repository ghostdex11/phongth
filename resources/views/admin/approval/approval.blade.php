@extends('admin/layouts/index')
@section('Admin', 'Approval')
@section('content')
<div class="container-fluid">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title" style="float: left;margin-right: 15px;padding: 7px 0px;">Danh sách quản lý đặt phòng</h5>
                <button type="button" class="btn btn-primary" onclick="openModalAdd()">
                    Đặt phòng
                </button>
                <div class="table-responsive" id="approval">
                    <form action="/" method="get">
                        @csrf
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr class="bg-primary">
                                    <th class="text-center text-white">Tên khu</th>
                                    <th class="text-center text-white">Tên phòng</th>
                                    <th class="text-center text-white">Tên thiết bị</th>
                                    <th class="text-center text-white">Ms</th>
                                    <th class="text-center text-white">SĐT</th>
                                    <th class="text-center text-white">ngày đặt</th>
                                    <th class="text-center text-white">Buổi</th>
                                    <th class="text-center text-white">Đã duyệt</th>
                                    <th class="text-center text-white">Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($history['history'] as $his)
                                <tr>
                                    <td class="text-center">{{\App\Models\Zone::getNameZone($his->id_zone)}}</td>
                                    <td class="text-center">{{\App\Models\Room::getNameRoom($his->id_room)}}</td>
                                    @php
                                        $devices = explode(',', $his->id_device);
                                        $device = App\Models\Device::whereIn('id', $devices)->pluck('name')->implode(', ');
                                    @endphp
                                    <td class="text-center">
                                        {{$device}}
                                    </td>
                                    <td class="text-center">{{$his->ms}}</td>
                                    <td class="text-center">{{$his->phone}}</td>
                                    <td class="text-center">{{$his->date_time}}</td>
                                    <td class="text-center">
                                        @if($his->session == 1)
                                            Chiều
                                        @else
                                            Sáng
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($his->admin_check == 1)
                                        Đã duyệt
                                        @else
                                        Chưa duyệt
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($his->admin_check == 0)
                                            <button type="button" class="btn btn-white" onclick="approval({{$his->id}})">
                                            Duyệt</button>
                                        @else
                                        <button type="button" class="btn btn-primary" data-target="#apphistory{{$his->id}}" data-toggle="modal">
                                            Trả phòng
                                        </button>
                                        @endif
                                        <button type="button" class="btn btn-white"
                                            onclick="detailHistory({{$his->id}})">
                                            <i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-white"
                                            onclick="deleteHistory({{$his->id}})"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <!-- modal -->
                                <div class="modal fade" id="apphistory{{$his->id}}" role="dialog" tabindex="-1" aria-labelledby="apphistory" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Trả phòng</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="post" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    @csrf
                                                    <input type="text" id="id1" name="id" value="" hidden>
                                                    <input type="text" id="id_room1" name="id_room" value="" hidden>
                                                    <div class="form-group">
                                                        <div class="form-title">Phòng:</div>
                                                        <input type="text" name="roomname" id="roomname" class="form-control" disabled>
                                                        <span class="error-slide"></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="form-title">MS:</div>
                                                        <input type="text" name="ms" id="ms1" class="form-control" disabled>
                                                        <span class="error-slide"></span>
                                                    </div>
                                                    <!-- <div class="form-group">
                                                        <div class="form-title">Số điện thoại:</div>
                                                        <input type="text" name="phone" id="phone1" class="form-control" disabled>
                                                        <span class="error-slide"></span>
                                                    </div> -->
                                                    <div class="form-group">
                                                        <div class="form-title">Tên thiết bị:</div> 
                                                            <input type="text" id="device[]" value="{{$device}}"
                                                            class="form-control"  name="device[]" disabled>
                                                        <span class="error-slide"></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="form-title">Dọn dẹp:</div>
                                                        <select class="form-control" id="clean_up1" name="clean_up">
                                                            <option value="0">Chưa dọn</option>
                                                            <option value="1" selected>Đã dọn dẹp</option>
                                                        </select>
                                                        <span class="error-slide"></span>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" onclick="submitCheckOut()" class="btn btn-primary">Trả phòng</button>
                                                        <button type="button" data-dismiss="modal" class="btn btn-danger">Hủy</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
<div class="modal fade" id="addhistory" tabindex="-1" role="dialog" aria-labelledby="addhistory" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tt">Đặt phòng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <div class="form-title">MS:</div>
                        <input type="text" name="ms" class="form-control">
                        <span class="text-danger text-error ms_error"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Số điện thoại:</div>
                        <input type="text" name="phone" class="form-control">
                        <span class="text-danger text-error phone_error"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Ngày:</div>
                        <input type="date" name="date_time" id="datetime">
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Buổi:</div>
                        <select class="form-control" name="sesion" >
                            <option value="0">Sáng</option>
                            <option value="1">Chiều</option>
                        </select>
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Tên khu:</div>
                        <select class="form-control" name="zone" id="Zone">
                            <option value="">--Chọn khu vực--</option>
                            @foreach($history['zone'] as $zo)
                                <option value="{{$zo->id}}">{{$zo->name}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger text-error zone_error"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Tên phòng:</div>
                        <select class="form-control" name="room" id="Room">
                            <option value="">--Chọn phòng--</option>
                            @foreach($history['room'] as $ro)
                                <option value="{{$ro->id}}">{{$ro->room_name}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger text-error room_error"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Tên thiết bị:</div>
                        @foreach($history['device'] as $de)
                            <input type="checkbox"  value="{{$de->id}}" name="device[]"> :{{$de->name}}<br>
                        @endforeach
                        <span class="text-danger text-error device_error"></span>
                    </div>
                    {{-- <div class="form-group">
                        <div class="form-title">Admin_check:</div>
                        <select class="form-control" name="admincheck" >
                            <option value="0">Chưa duyệt</option>
                            <option value="1">Đã duyệt</option>
                        </select>
                        <span class="error-slide"></span>
                    </div> --}}
                    <div class="modal-footer">
                        <button type="button" onclick="addHistory()" class="btn btn-primary">Thêm</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="edithistory" tabindex="-1" role="dialog" aria-labelledby="edithistory" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">chỉnh sửa đặt phòng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <input type="text" id="id" name="id" hidden>
                    <div class="form-group">
                        <div class="form-title">MS:</div>
                        <input type="text" name="ms" id="ms" class="form-control">
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Số điện thoại:</div>
                        <input type="text" name="phone" id="phone" class="form-control">
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Ngày:</div>
                        <input type="date" name="date_time" id="date_time">
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Buổi:</div>
                        <select class="form-control" id="sesion" name="sesion" >
                            <option value="0">Sáng</option>
                            <option value="1">Chiều</option>
                        </select>
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Tên khu:</div>
                        <select class="form-control" name="zone" id="zone">
                            <option value="">--Chọn khu vực--</option>
                            @foreach($history['zone'] as $zo)
                                <option value="{{$zo->id}}">{{$zo->name}}</option>
                            @endforeach
                        </select>
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Tên phòng:</div>
                        <select class="form-control" name="room" id="room">
                            <option value="">--Chọn phòng--</option>
                            @foreach($history['room'] as $ro)
                                <option value="{{$ro->id}}">{{$ro->room_name}}</option>
                            @endforeach
                        </select>
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Tên thiết bị:</div>
                        @foreach($history['device'] as $de)
                            <input type="checkbox" id="device" value="{{$de->id}}" name="device[]"> :{{$de->name}}<br>
                        @endforeach
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Duyệt:</div>
                        <select class="form-control" name="admincheck" id="admin_check">
                            <option value="1">Đã duyệt</option>
                            <option value="0" selected>Chưa duyệt</option>
                        </select>
                        <span class="error-slide"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="submitEditHistory()" class="btn btn-primary">Sửa</button>
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
        $("#addhistory").modal('show');
    }
    function openModalEdit(){
        $("#edithistory").modal('show');
    }
    function openModalApp(){
        $("#apphistory").modal('show');
    }
    function addHistory(){
        event.preventDefault();
        $.ajax({
            url: 'approval/addapproval',
            method: 'POST',
            data: new FormData($("#addhistory form")[0]),
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
                            //    $('#addhistory')[0].reset();
                            //    alert(data.msg);
                            window.location.reload(1000);
                        }
                        
                    },
        });
    }
        function detailHistory(id){
            event.preventDefault();
            openModalEdit();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'approval/detailapproval/'+id,
                method: 'GET',
                contentType: false,
                processData: false,
                success:function(data){
                    console.log(data);
                    $("#id").val(data.id);
                    $("#nameuser").val(data.id_user);
                    $("#zone").val(data.id_zone);
                    $("#room").val(data.id_room);
                    $("#device").val(data.id_device);
                    $("#ms").val(data.ms);
                    $("#phone").val(data.phone);
                    $("#date_time").val(data.date_time)
                    $("#admin_check").val(data.admin_check);
                }
            });
        }
        function deleteHistory(id){
            event.preventDefault();
            if(confirm("Bạn có chắc muốn xóa sản phẩm này?")){
                $.ajax({
                    url: 'approval/deleteapproval/'+id,
                    method: 'GET',
                    contentType: false,
                    processData: false,
                    success:function(data){

                        window.location.reload(1000);
                    }
                });
            }
        }
        function submitEditHistory(){
            event.preventDefault();
            $.ajax({
                url: 'approval/editapproval',
                method: 'POST',
                data: new FormData($("#edithistory form")[0]),
                contentType: false,
                processData: false,
                success:function(data){

                    window.location.reload(1000);
                }
            });
        }
        function approval(id){
            event.preventDefault();
            if(confirm("Bạn có chắc muốn duyệt phòng này?")){
                $.ajax({
                    url: 'approval/approval/'+id,
                    method: 'POST',
                    data: new FormData($("#approval form")[0]),
                    contentType: false,
                    processData: false,
                    success:function(data){

                        window.location.reload(1000);
                    }
                });
            }
        }
        function checkout(id){
            openModalApp();
            event.preventDefault();
                $.ajax({
                    url: 'approval/detailcheckout/'+id,
                    method: 'GET',
                contentType: false,
                processData: false,
                success:function(data){
                    console.log(data);
                    $("#id1").val(data.id);
                    $("#id_room1").val(data.id_room);
                    $("#roomname").val(data.room_name);
                    $("#ms1").val(data.ms);
                    $("#phone1").val(data.phone); 
                    $("#device").val(data.id_device);
                }           
            });
        }

        function submitCheckOut(){
            event.preventDefault();
            if(confirm("Bạn có chắc muốn trả phòng này?")){
                $.ajax({
                    url: 'approval/checkout',
                    method: 'POST',
                    data: new FormData($("#apphistory form")[0]),
                    contentType: false,
                    processData: false,
                    success:function(data){

                        window.location.reload(1000);
                    }
                });
            }
        }
</script>
@endsection
@section('script')
    <script>
        $(document).ready(function (){
            $("#Zone").change(function (){
                var id_zone = $(this).val();
                $.get("ajax/addhistory/"+id_zone,function (data){
                    $("#Room").html(data);
                });
            });
        });
    </script>
    <script>
        $(document).ready(function (){
            $("#zone").change(function (){
                var id_zone = $(this).val();
                $.get("ajax/edithistory/"+id_zone,function (data){
                    $("#room").html(data);
                });
            });
        });
    </script>
@endsection
