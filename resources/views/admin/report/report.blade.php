
<style>
    *{
        font-family: DejaVu Sans;
    }
    td, th{
        padding: 10px;
        border: 1px solid #000;
    }
    .table{
        border: 1px solid #000;
    }
    .container{
        margin-right: auto;
        margin-left: auto;
    }
</style>
<body>
    <div class="container">
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th>Tên máy</th>
                    <th>Phòng</th>
                    <th>Trạng thái</th>
                    <th>Mô tả</th>
                </tr>
                @foreach($data as $value)
                <tr>
                    <td>{{$value->computer_name}}</td>
                    <td>{{$value->roomname}}</td>
                    @if($value->activity == 0)
                        <td>Hỏng</td>
                    @else
                        <td>đã sửa</td>
                    @endif
                    @if($value->description != null)
                        <td>{{$value->description}}</td>
                    @else
                        <td>Không có mô tả</td>
                    @endif
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</body>