@extends('manger.home')
@section('content')
<div class="normal-table-area">
        <div class="container">
        <a href="{{route('manger.add.group')}}" class="btn btn-info">+ Create group</a>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="normal-table-list mg-t-30">
                        <div class="basic-tb-hd">
                            <h2>My groups</h2>
                        </div>
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif    
                        @if(session('status'))
                            <h6 class="alert alert-success" style="text-align: center;">
                                {{session('status')}}
                            </h6>
                        @endif
                        <div class="bsc-tbl-hvr">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Team name</th>
                                        <th>Project name</th>
                                        <th>Project goal</th>
                                        <th>Number of member</th>
                                        <th>Deadline</th>
                                        <th>Skills</th>                                        
                                        <th>Delete group</th>
                                        <th>Edit group</th>
                                        <th>Show member team</th>
                                        <th>Show task</th>
                                        <th>Generate report</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>team1</td>
                                        <td>project1</td>
                                        <td>programming</td>
                                        <td>3</td>
                                        <td>12/12/2026</td>
                                        <td>java - python </td>
                                        <td>
                                            <button class="btn btn-danger">Delete</button>
                                       
                                        </td>                                        
                                        <td><a href="{{route('manger.edit.group' )}}" class="btn btn-primary">Edit</a></td>
                                        <td><a href="{{route('manger.show.team')}}" class="btn btn-info">Show team</a></td>
                                        <td><a href="{{route('manger.show.task')}}" class="btn btn-warning">Show task</a></td>
                                        <td>
                                         
                                                <button class="btn btn-success">Generate</button>
                                            
                                        </td>

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