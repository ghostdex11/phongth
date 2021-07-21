@extends('admin/layouts/index')
@section('Admin', 'type device')
@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" style="float: left;margin-right: 15px;padding: 7px 0px;">List Type Device</h5>
                    <button type="button" class="btn btn-primary" onclick="openModalAdd()">
                        Add type device
                    </button>
                    <div class="table-responsive">
                        <form action="/" method="get">
                            @csrf
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Tên loại thiết bị</th>
                                    <th>Chức năng</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($typedevice as $tyd)
                                    <tr>
                                        <td>{{$tyd->name}}</td>
                                        <td>
                                            <button type="button" class="btn btn-white" onclick="detailTypedevice({{$tyd->id}})">
                                                <i class="fas fa-edit"></i></button>
                                            <button type="button" class="btn btn-white" onclick="deleteTypedevice({{$tyd->id}})"><i
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
    <div class="modal fade" id="addtypedevice" tabindex="-1" role="dialog" aria-labelledby="addtypedevice" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tt">Add type device</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <div class="form-title">Name Type device:</div>
                            <input type="text" name="name" class="form-control">
                            <span class="text-danger text-error name_error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="addTypedevice()" class="btn btn-primary">Thêm</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edittypedevice" tabindex="-1" role="dialog" aria-labelledby="edittypedevice" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edittypedevice">Edit type device</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="text" id="id" name="id" hidden>
                        <div class="form-group">
                            <div class="form-title">Name Type device:</div>
                            <input type="text" name="name" id="nametypedevice" class="form-control">
                            <span class="error-slide"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="submitEditTypedevice()" class="btn btn-primary">Sửa</button>
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
            $("#addtypedevice").modal('show');
        }
        function openModalEdit(){
            $("#edittypedevice").modal('show');
        }
        function addTypedevice(){
            event.preventDefault();
            $.ajax({
                url: 'typedevice/addtypedevice',
                method: 'POST',
                data: new FormData($("#addtypedevice form")[0]),
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
                            //    $('#addtypepdevice')[0].reset();
                            //    alert(data.msg);
                            window.location.reload(1000);
                        }
                        
                    }
            });
        }
        function detailTypedevice(id){
            event.preventDefault();
            openModalEdit();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'typedevice/detailtypedevice/'+id,
                method: 'GET',
                contentType: false,
                processData: false,
                success:function(data){
                    console.log(data);
                    $("#id").val(data.id);
                    $("#nametypedevice").val(data.name);

                }
            });
        }
        function deleteTypedevice(id){
            event.preventDefault();
            if(confirm("Bạn có chắc muốn xóa sản phẩm này?")){
                $.ajax({
                    url: 'typedevice/deletetypedevice/'+id,
                    method: 'GET',
                    contentType: false,
                    processData: false,
                    success:function(data){

                        window.location.reload(1000);
                    }
                });
            }
        }
        function submitEditTypedevice(){
            event.preventDefault();
            $.ajax({
                url: 'typedevice/edittypedevice',
                method: 'POST',
                data: new FormData($("#edittypedevice form")[0]),
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
