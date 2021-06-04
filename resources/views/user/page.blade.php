@extends('user/index')
@section('Admin', 'listrooms')
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
                                    <th>Floor</th>
                                   <th>Name Room</th>
                                    <th>Name device</th>
                                    <th>function</th>
                                </tr>
                                </thead>
{{--                                <tbody>--}}
{{--                                @foreach($room['room'] as $ro)--}}
{{--                                    <tr>--}}
{{--                                        <td>{{$ro->name}}</td>--}}
{{--                                        <td>{{$ro->namezone}}</td>--}}
{{--                                        <td>{{$ro->floor}}</td>--}}
{{--                                        <td>{{$ro->description}}</td>--}}
{{--                                        <td>--}}
{{--                                            @if($ro->clean_up == 1)--}}
{{--                                                Đã dọn dẹp--}}
{{--                                            @else--}}
{{--                                                Chưa dọn dẹp--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            @if($ro->status == 1)--}}
{{--                                                Đang được sử dụng--}}
{{--                                            @else--}}
{{--                                                Không được sử dụng--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            @if($ro->activity == 1)--}}
{{--                                                Sử dụng được--}}
{{--                                            @else--}}
{{--                                                Không sử dụng được--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            <button type="button" class="btn btn-white" onclick="detailRoom({{$ro->id}})">--}}
{{--                                                <i class="fas fa-edit"></i></button>--}}
{{--                                            <button type="button" class="btn btn-white" onclick="deleteRoom({{$ro->id}})"><i--}}
{{--                                                    class="fas fa-trash"></i></button>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
{{--                                </tbody>--}}
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
                                            <option  value="{{$zo->id}}">{{$zo->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error-slide"></span>
                                </div>
                            <div class="form-group">
                                <div class="form-title">Name Room:</div>
                                <select class="form-control" name="room" id="Room">
                                    @foreach($home['room'] as $ro)
                                        <option  value="{{$ro->id}}">{{$ro->name}}</option>
                                    @endforeach
                                </select>
                                <span class="error-slide"></span>
                            </div>
                                <div class="form-group">
                                    <div class="form-title">Floor:</div>
                                    <select class="form-control" name="floor" id="Floor">
                                        @foreach($home['room'] as $ro)
                                            <option  value="{{$ro->id}}">{{$ro->floor}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error-slide"></span>
                                </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-title">Name Device:</div>
                                @foreach($home['device'] as $de)
                                <input type="checkbox" id="changePassword" value="{{$de->id}}" name="device">:{{$de->name}}</input>
                                @endforeach
                            <span class="error-slide"></span>
                            </div>
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
                            <div class="form-title">Name Room:</div>
                            <input type="text" name="name" id="nameroom" class="form-control">
                            <span class="error-slide"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Name zone:</div>
{{--                            <select class="form-control" name="id_zone" id="namezone">--}}
{{--                                @foreach($room['zone'] as $ro)--}}
{{--                                    <option  value="{{$ro->id}}">{{$ro->name}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
                            <span class="error-slide"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Floor:</div>
                            <input type="text" name="floor" id="floor" class="form-control">
                            <span class="error-slide"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Clean_up:</div>
                            <select class="form-control" name="clean_up" id="clean_up">
                                <option value="1">Đã dọn dẹp</option>
                                <option value="0">Chưa dọn dẹp</option>
                            </select>
                            <span class="error-slide"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Activity:</div>
                            <select class="form-control" name="activity" id="activity">
                                <option value="1">Sử dụng được</option>
                                <option value="0">Không sử dụng được</option>
                            </select>
                            <span class="error-slide"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Status:</div>
                            <select class="form-control" name="status" id="status">
                                <option value="1">Đang được sử dụng</option>
                                <option value="0" selected>Không được sử dụng</option>
                            </select>
                            <span class="error-slide"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Description:</div>
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
                url: 'dangky',
                method: 'POST',
                data: new FormData($("#addroom form")[0]),
                contentType: false,
                processData: false,
                success:function(data){
                    // window.location.reload(1000);
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
                    $("#nameroom").val(data.name);
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
@endsection
