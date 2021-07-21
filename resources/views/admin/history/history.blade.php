@extends('admin/layouts/index')
@section('Admin', 'Approval')
@section('content')
<div class="container-fluid">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title" style="float: left;margin-right: 15px;padding: 7px 0px;">Danh sách Lịch sử</h5>
                <a class="btn btn-info" href="{{url('/admin/reporthistory')}}" target="_blank">In lịch sử</a>
                <div class="table-responsive" id="approval">
                    <form action="/" method="get">
                        @csrf
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr class="bg-primary">
                                    <th class="text-center text-white">Tên khu</th>
                                    <th class="text-center text-white">Tên phòng</th>
                                    <th class="text-center text-white">Tên thiết bị</th>
                                    <th class="text-center text-white">Ms</th>
                                    <th class="text-center text-white">SĐT</th>
                                    <th class="text-center text-white">Buổi</th>
                                    <th class="text-center text-white">ngày đặt</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($history['history'] as $his)
                                <tr>
                                    <td class="text-center">{{\App\Models\Zone::getNameZone($his->id_zone)}}</td>
                                    <td class="text-center">{{\App\Models\Room::getNameRoom($his->id_room)}}</td>
                                    <td class="text-center">
                                        @foreach(explode(",", $his->id_device) as $deviceId)
                                        {{ Str::of(\App\Models\Device::getDeviceUser($deviceId) . ', ')->rtrim('.') }}
                                        @endforeach
                                    </td>
                                    <td class="text-center">{{$his->ms}}</td>
                                    <td class="text-center">{{$his->phone}}</td>
                                    <td class="text-center">
                                        @if($his->session == 1)
                                            Chiều
                                        @else
                                            Sáng
                                        @endif
                                    </td>
                                    <td class="text-center">{{$his->date_time}}</td>
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
@endsection
