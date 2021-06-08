@extends('user/index')
@section('User', 'listrooms')
@section('content')
<div class="container-fluid">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title" style="float: left;margin-right: 15px;padding: 7px 0px;">Room List</h5>
                <button type="button" class="btn btn-primary" onclick="openModalAdd()">
                    Room Registration
                </button>
                <div class="table-responsive">
                    <form action="/" method="get">
                        @csrf
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Name zone</th>
                                    <th>Name Room</th>
                                    <th>Name device</th>
                                    <th>description</th>
                                    <th>clean up</th>
                                    <th>approve</th>
                                    <th>function</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($home['history'] as $ro)
                                <tr>
                                    <td>{{$ro->nameuser}}</td>
                                    <td>{{$ro->namezone}}</td>
                                    <td>{{$ro->nameroom}}</td>
                                    <td> @foreach(explode(",", $ro->id_device) as $deviceId)
                                            {{ Str::of(\App\Models\Device::getDeviceUser($deviceId) . ', ')->rtrim(',') }}
                                        @endforeach</td>
                                    <td>{{$ro->description}}
                                    @if($ro->description == null)
                                        k có mô tả
                                        @else
                                        $ro->description
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
                                        @if($ro->admincheck == 1)
                                        Đang được sử dụng
                                        @else
                                        Không được sử dụng
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
                <h5 class="modal-title" id="tt">Room Registration</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <div class="form-title">Name Zone:</div>
                        <select class="form-control" name="zone" id="Zone">
                            @foreach($home['zone'] as $zo)
                            <option value="{{$zo->id}}">{{$zo->name}}</option>
                            @endforeach
                        </select>
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Name Room:</div>
                        <select class="form-control" name="room" id="Room">
                            @foreach($home['room'] as $ro)
                            <option value="{{$ro->id}}">{{$ro->name}}</option>
                            @endforeach
                        </select>
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Name Device:</div>
                        @foreach($home['device'] as $de)
                        <input type="checkbox"  value="{{$de->id}}" name="device[]"> :{{$de->name}}
                        @endforeach
                        <span class="error-slide"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="addRoom()" class="btn btn-primary">Thêm</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editroom" tabindex="-1" role="dialog" aria-labelledby="editroom" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editroom">Edit room</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <input type="text" id="id" name="id" hidden>
                    <div class="form-group">
                        <div class="form-title">Name Zone:</div>
                        <select class="form-control" name="zone" id="zone">
                            @foreach($home['zone'] as $zo)
                                <option value="{{$zo->id}}">{{$zo->name}}</option>
                            @endforeach
                        </select>
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Name Room:</div>
                        <select class="form-control" name="room" id="room">
                            @foreach($home['room'] as $ro)
                                <option value="{{$ro->id}}">{{$ro->name}}</option>
                            @endforeach
                        </select>
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Name Device:</div>
                        @foreach($home['device'] as $de)
                            <input type="checkbox" id="device" value="{{$de->id}}"  name="device[]"> :{{$de->name}}
                        @endforeach
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
                url: 'regisroom/addroom',
                method: 'POST',
                data: new FormData($("#addroom form")[0]),
                contentType: false,
                processData: false,
                success:function(data){
                    window.location.reload(1000);
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
                url: 'regisroom/detailroom/'+id,
                method: 'GET',
                contentType: false,
                processData: false,
                success:function(data){
                    console.log(data);
                    $("#id").val(data.id);
                    $("#zone").val(data.id_zone);
                    $("#room").val(data.id_room);
                    $("#device").val(data.id_device);
                }
            });
        }
        function deleteRoom(id){
            event.preventDefault();
            if(confirm("Bạn có chắc muốn xóa phòng này?")){
                $.ajax({
                    url: 'regisroom/deleteroom/'+id,
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
                url: 'regisroom/editroom',
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
<script>
    $(document).ready(function (){
           $("#Zone").change(function (){
            var id_zone = $(this).val();
            $.get("ajax/room/"+id_zone,function (data){
                $("#Room").html(data);
            });
           });
        });
</script>
<script>
    $(document).ready(function (){
            $("#Room").change(function (){
                var room = $(this).val();
                $.get("ajax/floor/"+room,function (data){
                    $("#Floor").html(data);
                });
            });
        });
</script>
<script>
    $(document).ready(function (){
        $("#zone").change(function (){
            var id_zone = $(this).val();
            $.get("ajax/editroom/"+id_zone,function (data){
                $("#room").html(data);
            });
        });
    });
</script>
@endsection
