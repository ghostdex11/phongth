@extends('admin/layouts/index')
@section('Admin', 'broken')
@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" style="float: left;margin-right: 15px;padding: 7px 0px;">Danh sách máy hỏng</h5>
                    <button type="button" class="btn btn-primary" onclick="openModalAdd()">
                        Báo hỏng
                    </button>
                    <a class="btn btn-info" href="{{url('/admin/report')}}" target="_blank">In lỗi</a>
                    <div class="table-responsive">
                        <form action="/" method="get">
                            @csrf
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Tên phòng</th>
                                    <th>Tên khu</th>
                                    <th>Tên máy</th>
                                    <th>Trạng thái</th>
                                    <th>Mô tả</th>     
                                    <th></th>                              
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($room['broken'] as $ro)
                                    <tr>
                                        <td>{{$ro->nameroom}}</td>
                                        <td>{{$ro->namezone}}</td>
                                        <td>{{$ro->computer_name}}</td>
                                        <td>
                                            @if($ro->activity == 1)
                                                Sử dụng được
                                            @else
                                                Đang sửa
                                            @endif
                                        </td>
                                        <td>
                                            @if($ro->description == null)
                                                Không có mô tả
                                            @else
                                                {{$ro->description}}
                                            @endif
                                        <td>
                                            <button type="button" class="btn btn-white" onclick="detailBroken({{$ro->id}})">
                                                <i class="fas fa-edit"></i></button>
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
    <div class="modal fade" id="addbroken" tabindex="-1" role="dialog" aria-labelledby="addbroken" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tt">Báo hỏng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <div class="form-title">Tên khu:</div>
                            <select class="form-control" name="zone" id="zoneget">
                                <option value="">--Chọn khu vực--</option>
                                @foreach($room['zone'] as $zo)
                                    <option value="{{$zo->id}}">{{$zo->name}}</option>
                                @endforeach
                            </select>
                            <span class="error-slide"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Tên phòng:</div>
                            <select class="form-control" name="room" id="roomget">
                                <option value="">--Chọn phòng--</option>
                                @foreach($room['rooms'] as $ro)
                                    <option value="{{$ro->id}}">{{$ro->room_name}}</option>
                                @endforeach
                            </select>
                            <span class="error-slide"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Tên máy tính:</div>
                            <select class="form-control" name="computer" id="computerget">
                                <option value="">--Chọn computer--</option>
                                @foreach($room['computer'] as $ro)
                                    <option value="{{$ro->id}}">{{$ro->computer_name}}</option>
                                @endforeach
                            </select>
                            <span class="error-slide"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Mô tả:</div>
                            <textarea name="description"  cols="40" rows="5"></textarea>
                            <span class="error-slide"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="addBroken()" class="btn btn-primary">Thêm</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editbroken" tabindex="-1" role="dialog" aria-labelledby="editbroken" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editbroken">Sửa báo hỏng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="text" id="id" name="id" hidden>
                        <div class="form-group">
                            <div class="form-title">Tên máy:</div>
                            <input type="text" name="name" id="namecom" class="form-control" disabled>
                            <span class="error-slide"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Trạng thái:</div>
                            <select class="form-control" name="activity" id="activity">
                                <option value="1">Đã sửa</option>
                                <option value="0" selected>Đang hỏng</option>
                            </select>
                            <span class="error-slide"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Mô tả:</div>
                            <textarea name="description" id="description" cols="40" rows="5"></textarea>
                            <span class="error-slide"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="submitEditBroken()" class="btn btn-primary">Sửa</button>
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
            $("#addbroken").modal('show');
        }
        function openModalEdit(){
            $("#editbroken").modal('show');
        }
        function addBroken(){
            event.preventDefault();
            $.ajax({
                url: 'broken/addbroken',
                method: 'POST',
                data: new FormData($("#addbroken form")[0]),
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
        function detailBroken(id){
            event.preventDefault();
            openModalEdit();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'broken/detailbroken/'+id,
                method: 'GET',
                contentType: false,
                processData: false,
                success:function(data){
                    console.log(data);
                    $("#id").val(data.id);
                    $("#namecom").val(data.computer_name);
                    $("#editbroken textarea[name=description]").val(data.description);
                }
            });
        }
        function submitEditBroken(){
            event.preventDefault();
            $.ajax({
                url: 'broken/editbroken',
                method: 'POST',
                data: new FormData($("#editbroken form")[0]),
                contentType: false,
                processData: false,
                success:function(data){
                    window.location.reload(1000);
                }
            });
        }
        $(document).ready(function (){
            $("#zoneget").change(function (){
                var id_zone = $(this).val();
                $.get("ajax/addbroken/"+id_zone,function (data){
                    $("#roomget").html(data);
                });
            });
        });
    </script>
    <script>
        $(document).ready(function (){
            $("#roomget").change(function (){
                var id_room = $(this).val();
                $.get("ajax/addcomputer/"+id_room,function (data){
                    $("#computerget").html(data);
                });
            });
        });
    </script>
@endsection
@section('script')
@endsection
