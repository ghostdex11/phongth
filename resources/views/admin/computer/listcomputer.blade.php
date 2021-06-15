@extends('admin/layouts/index')
@section('Admin', 'Computer')
@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" style="float: left;margin-right: 15px;padding: 7px 0px;">List computer</h5>
                    <button type="button" class="btn btn-primary" onclick="openModalAdd()">
                        Add computer
                    </button>
                    <div class="table-responsive">
                        <form action="/" method="get">
                            @csrf
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Name computer</th>
                                    <th>Room</th>
                                    <th>Mouse</th>
                                    <th>keyboard</th>
                                    <th>Description</th>
                                    <th>Activity</th>
                                    <th>function</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($computer['computer'] as $de)
                                    <tr>
                                        <td>{{$de->name}}</td>
                                        <td>{{$de->roomname}}</td>
                                        <td>
                                            @if($de->mouse == 1)
                                                Sử dụng được
                                            @else
                                                hỏng
                                            @endif
                                         </td>
                                        <td>
                                            @if($de->keyboard == 1)
                                            Sử dụng được
                                            @else
                                                hỏng
                                            @endif
                                        </td>
                                        <td>
                                            @if($de->description == null)
                                                Không có mô tả
                                            @else
                                                {{$de->description}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($de->activity == 1)
                                                Sử dụng được
                                            @else
                                                hỏng
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-white" onclick="detailComputer({{$de->id}})">
                                                <i class="fas fa-edit"></i></button>
                                            <button type="button" class="btn btn-white" onclick="deleteComputer({{$de->id}})"><i
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
    <div class="modal fade" id="addcomputer" tabindex="-1" role="dialog" aria-labelledby="addcomputer" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tt">Add computer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <div class="form-title">Name computer:</div>
                            <input type="text" name="name" class="form-control">
                            <span class="text-danger error-text name_error"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-title">Room:</div>
                            <select class="form-control" name="id_room">
                                @foreach($computer['room'] as $td)
                                    <option  value="{{$td->id}}">{{$td->name}}</option>
                                @endforeach
                            </select>
                            <span class="error-slide"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="addComputer()" class="btn btn-primary">Thêm</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editcomputer" tabindex="-1" role="dialog" aria-labelledby="editcomputer" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit computer</h5>
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
                            <select class="form-control" name="id_room">
                                @foreach($computer['room'] as $td)
                                    <option  value="{{$td->id}}">{{$td->name}}</option>
                                @endforeach
                            </select>
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
                            <button type="button" onclick="submitEditComputer()" class="btn btn-primary">Sửa</button>
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
            $("#addcomputer").modal('show');
        }
        function openModalEdit(){
            $("#editcomputer").modal('show');
        }
        function addComputer(){
            event.preventDefault();
            $.ajax({
                url: 'computer/addcomputer',
                method: 'POST',
                data: new FormData($("#addcomputer form")[0]),
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
                            //    $('#addcomputer')[0].reset();
                            //    alert(data.msg);
                            window.location.reload(1000);
                        }
                        
                    },
            });
        }
        function detailComputer(id){
            event.preventDefault();
            openModalEdit();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'computer/detailcomputer/'+id,
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
        function deleteComputer(id){
            event.preventDefault();
            if(confirm("Bạn có chắc muốn xóa sản phẩm này?")){
                $.ajax({
                    url: 'computer/deletecomputer/'+id,
                    method: 'GET',
                    contentType: false,
                    processData: false,
                    success:function(data){

                        window.location.reload(1000);
                    }
                });
            }
        }
        function submitEditComputer(){
            event.preventDefault();
            $.ajax({
                url: 'computer/editcomputer',
                method: 'POST',
                data: new FormData($("#editcomputer form")[0]),
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
