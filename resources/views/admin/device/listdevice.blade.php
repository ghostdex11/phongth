@extends('admin/layouts/index')
@section('Admin', 'listrooms')
@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" style="float: left;margin-right: 15px;padding: 7px 0px;">List device</h5>
                    <button type="button" class="btn btn-primary" onclick="openModalAdd()">
                        Add device
                    </button>
                    <div class="table-responsive">
                        <form action="/" method="get">
                            @csrf
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Name device</th>
                                    <th>Type device</th>
                                    <th>Activity</th>
                                    <th>Status</th>
                                    <th>function</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($typedevice['device'] as $de)
                                    <tr>
                                        <td>{{$de->name}}</td>
                                        <td>{{$de->typename}}</td>
                                        <td>
                                            @if($de->activity == 1)
                                                Sử dụng được
                                            @else
                                                hỏng
                                            @endif
                                        </td>
                                        <td>
                                            @if($de->status == 1)
                                                Đang được sử dụng
                                            @else
                                                Chưa được sử dụng
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-white" onclick="detailDevice({{$de->id}})">
                                                <i class="fas fa-edit"></i></button>
                                            <button type="button" class="btn btn-white" onclick="deleteDevice({{$de->id}})"><i
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
    <div class="modal fade" id="adddevice" tabindex="-1" role="dialog" aria-labelledby="adddevice" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tt">Add device</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <div class="form-title">Name Device:</div>
                            <input type="text" name="name" class="form-control">
                            <span class="error-slide"></span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-title">Type Device:</div>
                            <select class="form-control" name="typedevice">
                                @foreach($typedevice['typedevice'] as $td)
                                    <option  value="{{$td->id}}">{{$td->name}}</option>
                                @endforeach
                            </select>
                            <span class="error-slide"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="addDevice()" class="btn btn-primary">Thêm</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editdevice" tabindex="-1" role="dialog" aria-labelledby="editdevice" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editdevice">Edit device</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="text" id="id" name="id" hidden>
                        <div class="form-group">
                            <div class="form-title">Name Device:</div>
                            <input type="text" name="name" id="namedevice" class="form-control">
                            <span class="error-slide"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Type Device:</div>
                            <select class="form-control" name="id_type_device" id="typedevice">
                                @foreach($typedevice['typedevice'] as $td)
                                    <option  value="{{$td->id}}">{{$td->name}}</option>
                                @endforeach
                            </select>
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
                        <div class="form-group">
                            <div class="form-title">Status:</div>
                            <select class="form-control" name="status" id="status">
                                <option value="1">Đang được sử dụng</option>
                                <option value="0" selected>Chưa được sử dụng</option>
                            </select>
                            <span class="error-slide"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="submitEditDevice()" class="btn btn-primary">Sửa</button>
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
            $("#adddevice").modal('show');
        }
        function openModalEdit(){
            $("#editdevice").modal('show');
        }
        function addDevice(){
            event.preventDefault();
            $.ajax({
                url: 'device/adddevice',
                method: 'POST',
                data: new FormData($("#adddevice form")[0]),
                contentType: false,
                processData: false,
                success:function(data){
                    window.location.reload(1000);
                }
            });
        }
        function detailDevice(id){
            event.preventDefault();
            openModalEdit();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'device/detaildevice/'+id,
                method: 'GET',
                contentType: false,
                processData: false,
                success:function(data){
                    console.log(data);
                    $("#id").val(data.id);
                    $("#namedevice").val(data.name);
                    $("#activity").val(data.activity);
                    $("#status").val(data.status);
                }
            });
        }
        function deleteDevice(id){
            event.preventDefault();
            if(confirm("Bạn có chắc muốn xóa sản phẩm này?")){
                $.ajax({
                    url: 'device/deletedevice/'+id,
                    method: 'GET',
                    contentType: false,
                    processData: false,
                    success:function(data){

                        window.location.reload(1000);
                    }
                });
            }
        }
        function submitEditDevice(){
            event.preventDefault();
            $.ajax({
                url: 'device/editdevice',
                method: 'POST',
                data: new FormData($("#editdevice form")[0]),
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
