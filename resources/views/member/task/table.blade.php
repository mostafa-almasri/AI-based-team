@extends('member.home')
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
                                        <th>Project name</th>
                                        <th>Task name</th>
                                        <th>Task duration</th>
                                        <th>Start date</th>
                                        <th>Finish date</th>
                                        <th>Status</th>
                                        <th>Progress</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <td>project1</td>
                                        <td>task1</td>
                                        <td>2</td>
                                        <td>12/12/2025</td>
                                        <td>22/12/2025</td>
                                        <td>Not implemented</td>
                                        <td>30 %</td>


                         

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