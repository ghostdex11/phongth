@extends('admin/layouts/index')
@section('Admin', 'Computer')
@section('content')
<div class="container-fluid">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title" style="float: left;margin-right: 15px;padding: 7px 0px;">List History</h5>
                <button type="button" class="btn btn-primary" onclick="openModalAdd()">
                    Room Registration
                </button>
                <div class="table-responsive" id="approval">
                    <form action="/" method="get">
                        @csrf
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Name user</th>
                                    <th>Name Zone</th>
                                    <th>Name Room</th>
                                    <th>Name Device</th>
                                    <th>Ms</th>
                                    <th>Phone</th>
                                    <th>Session</th>
                                    <th>Clean_up</th>
                                    <th>Description</th>
                                    <th>Registration Date</th>
                                    <th>admin_check</th>
                                    <th>function</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($history['history'] as $his)
                                <tr>
                                    <td>{{\App\Models\User::getNameUser($his->id_user)}}</td>
                                    <td>{{\App\Models\Zone::getNameZone($his->id_zone)}}</td>
                                    <td>{{\App\Models\Room::getNameRoom($his->id_room)}}</td>
                                    <td>
                                        @foreach(explode(",", $his->id_device) as $deviceId)
                                        {{ Str::of(\App\Models\Device::getDeviceUser($deviceId) . ', ')->rtrim('.') }}
                                        @endforeach
                                    </td>
                                    <td>{{$his->ms}}</td>
                                    <td>{{$his->phone}}</td>
                                    <td>
                                        @if($his->session == 1)
                                            Chiều
                                        @else
                                            Sáng
                                        @endif
                                    </td>
                                    <td>
                                        @if($his->clean_up == 1)
                                        Đã dọn dẹp
                                        @else
                                        Chưa dọn dẹp
                                        @endif
                                    </td>
                                    <td>
                                        @if($his->description == null)
                                        Không có mô tả
                                        @else
                                        {{$his->description}}
                                        @endif
                                    </td>
                                    <td>{{$his->created_at}}</td>
                                    <td>
                                        @if($his->admin_check == 1)
                                        Đã duyệt
                                        @else
                                        Chưa duyệt
                                        @endif
                                    </td>
                                    <td>
                                        @if($his->admin_check == 0)
                                            <button type="button" class="btn btn-white" onclick="approval({{$his->id}})">
                                            Duyệt</button>
                                        @else
                                        <button type="button" class="btn btn-white" onclick="checkout({{$his->id}})">
                                            Duyệt</button>
                                        @endif
                                        <button type="button" class="btn btn-white"
                                            onclick="detailHistory({{$his->id}})">
                                            <i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-white"
                                            onclick="deleteHistory({{$his->id}})"><i class="fas fa-trash"></i></button>
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
<div class="modal fade" id="addhistory" tabindex="-1" role="dialog" aria-labelledby="addhistory" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tt">Room Registration</h5>
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
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Phone:</div>
                        <input type="text" name="phone" class="form-control">
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Session:</div>
                        <select class="form-control" name="sesion" >
                            <option value="0">Sáng</option>
                            <option value="1">Chiều</option>
                        </select>
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Name Zone:</div>
                        <select class="form-control" name="zone" id="Zone">
                            <option value="">--Chọn khu vực--</option>
                            @foreach($history['zone'] as $zo)
                                <option value="{{$zo->id}}">{{$zo->name}}</option>
                            @endforeach
                        </select>
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Name Room:</div>
                        <select class="form-control" name="room" id="Room">
                            <option value="">--Chọn phòng--</option>
                            @foreach($history['room'] as $ro)
                                <option value="{{$ro->id}}">{{$ro->name}}</option>
                            @endforeach
                        </select>
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Name Device:</div>
                        @foreach($history['device'] as $de)
                            <input type="checkbox"  value="{{$de->id}}" name="device[]"> :{{$de->name}}<br>
                        @endforeach
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Admin_check:</div>
                        <select class="form-control" name="admincheck" >
                            <option value="0">Chưa duyệt</option>
                            <option value="1">Đã duyệt</option>
                        </select>
                        <span class="error-slide"></span>
                    </div>
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
                <h5 class="modal-title">Edit history</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <input type="text" id="id" name="id" hidden>
                    <div class="form-group">
                        <div class="form-title">User name:</div>
                        <input type="text" name="nameuser"   id="nameuser" class="form-control" disabled>
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">MS:</div>
                        <input type="text" name="ms" id="ms" class="form-control">
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Phone:</div>
                        <input type="text" name="phone" id="phone" class="form-control">
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Session:</div>
                        <select class="form-control" id="sesion" name="sesion" >
                            <option value="0">Sáng</option>
                            <option value="1">Chiều</option>
                        </select>
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Name Zone:</div>
                        <select class="form-control" name="zone" id="zone">
                            <option value="">--Chọn khu vực--</option>
                            @foreach($history['zone'] as $zo)
                                <option value="{{$zo->id}}">{{$zo->name}}</option>
                            @endforeach
                        </select>
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Name Room:</div>
                        <select class="form-control" name="room" id="room">
                            <option value="">--Chọn phòng--</option>
                            @foreach($history['room'] as $ro)
                                <option value="{{$ro->id}}">{{$ro->name}}</option>
                            @endforeach
                        </select>
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Name Device:</div>
                        @foreach($history   ['device'] as $de)
                            <input type="checkbox" id="device" value="{{$de->id}}"  name="device[]"> :{{$de->name}}
                        @endforeach
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Approval:</div>
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
    function addHistory(){
        event.preventDefault();
        $.ajax({
            url: 'history/addhistory',
            method: 'POST',
            data: new FormData($("#addhistory form")[0]),
            contentType: false,
            processData: false,
            success:function(data){
                window.location.reload(1000);
            }
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
                url: 'history/detailhistory/'+id,
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
                    $("#admin_check").val(data.admin_check);
                }
            });
        }
        function deleteHistory(id){
            event.preventDefault();
            if(confirm("Bạn có chắc muốn xóa sản phẩm này?")){
                $.ajax({
                    url: 'history/deletehistory/'+id,
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
                url: 'history/edithistory',
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
                    url: 'history/approval/'+id,
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
            event.preventDefault();
            if(confirm("Bạn có chắc muốn trả phòng này?")){
                $.ajax({
                    url: 'history/checkout/'+id,
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
