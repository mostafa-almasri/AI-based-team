@extends('manger.home')
@section('content')
<div class="normal-table-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="normal-table-list mg-t-30">
                        <div class="basic-tb-hd">
                            <h2>My tasks</h2>
                        </div>
                        <div class="bsc-tbl-hvr">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Task name</th>
                                        <th>Task duration</th>
                                        <th>Start date</th>
                                        <th>Finish date</th>
                                        <th>Name member</th>
                                        <th>Status</th>
                                        <th>Progress</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>task1</td>
                                        <td>3</td>
                                        <td>8/10/2025</td>
                                        <td>18/10/2025</td>
                                        <td>member1</td>
                                        <td>in progress</td>
                                        <td>40%</td>
                                        <td><a href="{{route('manger.edit.task')}}" class="btn btn-warning">Edit task</a></td>



                                    </tr>
                                  
                                </tbody>
                            </table>
                       
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection