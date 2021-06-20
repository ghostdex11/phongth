
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
            <table class="table ">
                <thead>
                    <tr class="">
                        <th class="">Tên khu</th>
                        <th class="">Tên phòng</th>
                        <th class="">Tên thiết bị</th>
                        <th class="">Ms</th>
                        <th class="">SĐT</th>
                        <th class="">Buổi</th>
                        <th class="">ngày đặt</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $his)
                    <tr>
                        <td class="">{{\App\Models\Zone::getNameZone($his->id_zone)}}</td>
                        <td class="">{{\App\Models\Room::getNameRoom($his->id_room)}}</td>
                        <td class="">
                            @foreach(explode(",", $his->id_device) as $deviceId)
                            {{ Str::of(\App\Models\Device::getDeviceUser($deviceId) . ', ')->rtrim('.') }}
                            @endforeach
                        </td>
                        <td class="">{{$his->ms}}</td>
                        <td class="">{{$his->phone}}</td>
                        <td class="">
                            @if($his->session == 1)
                                Chiều
                            @else
                                Sáng
                            @endif
                        </td>
                        <td class="">{{$his->date_time}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>