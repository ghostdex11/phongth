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
                                    <th>Zone</th>
                                    <th>Room</th>
                                    <th>Device</th>
                                    <th>Clean_up</th>
                                    <th>Description</th>
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
                                    <td>
                                        @if($his->admin_check == 1)
                                        Đã duyệt
                                        @else
                                        Chưa duyệt
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-white" onclick="approval({{$his->id}})">
                                            Duyệt</button>
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
                        <div class="form-title">Name Zone:</div>
                        <select class="form-control" name="zone" id="Zone">
                            @foreach($history['zone'] as $zo)
                                <option value="{{$zo->id}}">{{$zo->name}}</option>
                            @endforeach
                        </select>
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Name Room:</div>
                        <select class="form-control" name="room" id="Room">
                            @foreach($history['room'] as $ro)
                                <option value="{{$ro->id}}">{{$ro->name}}</option>
                            @endforeach
                        </select>
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Name Device:</div>
                        @foreach($history['device'] as $de)
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
                        <div class="form-title">Name computer:</div>
                        <input type="text" name="name" id="name" class="form-control">
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Type Device:</div>
                        {{--                            <select class="form-control" name="id_room">--}}
                        {{--                                @foreach($computer['room'] as $td)--}}
                        {{--                                    <option  value="{{$td->id}}">{{$td->name}}</option>--}}
                        {{--                                @endforeach--}}
                        {{--                            </select>--}}
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Mouse:</div>
                        <select class="form-control" name="mouse" id="mouse">
                            <option value="1">Sử dụng được</option>
                            <option value="0">Hỏng</option>
                        </select>
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Keyboard:</div>
                        <select class="form-control" name="keyboard" id="keyboard">
                            <option value="1">Sử dụng được</option>
                            <option value="0">Hỏng</option>
                        </select>
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Description:</div>
                        <textarea name="description" id="description" cols="40" rows="5"></textarea>
                        <span class="error-slide"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-title">Activity:</div>
                        <select class="form-control" name="activity" id="activity">
                            <option value="1">Sử dụng được</option>
                            <option value="0">Hỏng</option>
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
                    $("#name").val(data.name);
                    $("#activity").val(data.activity);
                    $("#editcomputer textarea[name=description]").val(data.description);
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
</script>
@endsection
@section('script')
@endsection
