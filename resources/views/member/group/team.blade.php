@extends('member.home')
@section('content')
<div class="normal-table-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="normal-table-list mg-t-30">
                        <div class="basic-tb-hd">
                            <h2>Team</h2>
                        </div>
                        <div class="bsc-tbl-hvr">
                        @if($member->count()>0)
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Full name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>job ID</th>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($member as $row)
                                    <tr>
                                        <td>{{$row->name}}</td>
                                        <td>{{$row->email}}</td>
                                        <td>{{$row->phone}}</td>
                                        <td>{{$row->job}}</td>

                                    </tr>
                                @endforeach
                               
                                </tbody>
                            </table>
                            @else
                            <h3 class="text-center">No member added yet</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection