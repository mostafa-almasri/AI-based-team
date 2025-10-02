@extends('member.home')
@section('content')
<div class="normal-table-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="normal-table-list mg-t-30">
                        <div class="basic-tb-hd">
                            <h2>Team</h2>
                            @if(session('status'))
                            <h6 class="alert alert-success" style="text-align: center;">
                                {{session('status')}}
                            </h6>
                        @endif
                        </div>
                        <div class="bsc-tbl-hvr">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Team name</th>
                                        <th>Project name</th>
                                        <th>Project goal</th>
                                        <th>Deadline</th>
                                        <th>Skills</th>
                                        <th>Show member team</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>team1</td>
                                        <td>project1</td>
                                        <td>java</td>
                                        <td>12/3/2026</td>
                                        <td>
                                            
                                       java
                                        </td>

                                                                          
                                        </td>
                                      
                                        <td><a href="" class="btn btn-info">Show</a></td>

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