@extends('admin/layouts/index')
@section('Admin', 'listrooms')
@section('content')
<div class="container-fluid">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title" style="float: left;margin-right: 15px;padding: 7px 0px;">Danh sách Phòng</h5>
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addroom">
					Thêm Phòng
				</button>
				<div class="table-responsive">
					<form action="/" method="get">
						@csrf
						<table id="zero_config" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Tên phòng</th>
									<th>Tên khu vực</th>
									<th>Tầng</th>
									<th>Dọn dẹp</th>
									<th>Trạng thái</th>
									<th>Tình trạng hoạt động</th>
									<th>Mô tả</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td>
									<button type="button" class="btn btn-white" onclick="" data-toggle="modal"
										data-target="#editnews"><i class="fas fa-edit"></i></button>
									<button type="button" class="btn btn-white" onclick=""><i
											class="fas fa-trash"></i></button>
								</td>
							</tbody>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="addroom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Thêm phòng</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" enctype="multipart/form-data">
				<div class="modal-body">
					@csrf
					<div class="form-group">
						<div class="form-title">Tên phòng:</div>
						<input type="text" name="news_title" class="form-control">
						<span class="error-slide"></span>
					</div>
					<div class="form-group">
						<div class="form-title">Khu vực:</div>
						<select class="form-control" name="type_news_id">
							<option value="">A17</option>
							<option value="">T</option>
						</select>
						<span class="error-slide"></span>
					</div>
					<div class="form-group">
						<div class="form-title">Tầng:</div>
						<select class="form-control" name="type_news_id">
							<option value="">1</option>
							<option value="">2</option>
						</select>
						<span class="error-slide"></span>
					</div>
					<div class="form-group">
						<div class="form-title">Dọn dẹp:</div>
						<select class="form-control" name="type_news_id">
							<option value="0">Chưa dọn dẹp</option>
							<option value="1">Đã dọn dẹp</option>
						</select>
						<span class="error-slide"></span>
					</div>
					<div class="form-group">
						<div class="form-title">Trạng thái:</div>
						<select class="form-control" name="type_news_id">
							<option value="0">Chưa sử dụng</option>
							<option value="1">Đang sử dụng</option>
						</select>
						<span class="error-slide"></span>
					</div>
					<div class="form-group">
						<div class="form-title">Tình trạng hoạt động:</div>
						<select class="form-control" name="type_news_id">
							<option value="0">Không sử dụng được</option>
							<option value="1">Sử dụng được</option>
						</select>
						<span class="error-slide"></span>
					</div>
					<div class="form-group">
						<div class="form-title">Mô tả:</div>
						<input type="text" name="" class="form-control">
						<span class="error-slide"></span>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="" class="btn btn-primary">Thêm</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="editroom" tabindex="-1" role="dialog" aria-labelledby="editnew" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit news</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" enctype="multipart/form-data">
				@csrf
				<div class="form-group">
					<div class="form-title">Tên phòng:</div>
					<input type="text" name="news_title" class="form-control">
					<span class="error-slide"></span>
				</div>
				<div class="form-group">
					<div class="form-title">Khu vực:</div>
					<select class="form-control" name="type_news_id">
						<option value="">A17</option>
						<option value="">T</option>
					</select>
					<span class="error-slide"></span>
				</div>
				<div class="form-group">
					<div class="form-title">Tầng:</div>
					<select class="form-control" name="type_news_id">
						<option value="">1</option>
						<option value="">2</option>
					</select>
					<span class="error-slide"></span>
				</div>
				<div class="form-group">
					<div class="form-title">Dọn dẹp:</div>
					<select class="form-control" name="type_news_id">
						<option value="0">Chưa dọn dẹp</option>
						<option value="1">Đã dọn dẹp</option>
					</select>
					<span class="error-slide"></span>
				</div>
				<div class="form-group">
					<div class="form-title">Trạng thái:</div>
					<select class="form-control" name="type_news_id">
						<option value="0">Chưa sử dụng</option>
						<option value="1">Đang sử dụng</option>
					</select>
					<span class="error-slide"></span>
				</div>
				<div class="form-group">
					<div class="form-title">Tình trạng hoạt động:</div>
					<select class="form-control" name="type_news_id">
						<option value="0">Không sử dụng được</option>
						<option value="1">Sử dụng được</option>
					</select>
					<span class="error-slide"></span>
				</div>
				<div class="form-group">
					<div class="form-title">Mô tả:</div>
					<input type="text" name="" class="form-control">
					<span class="error-slide"></span>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="" class="btn btn-primary">Sửa</button>
					<button type="button" data-dismiss="modal" class="btn btn-danger">Hủy</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
@section('script')
@endsection
