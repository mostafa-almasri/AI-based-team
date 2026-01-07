@extends('member.home')
@section('content')
<div class="normal-table-area">
        <div class="container">
        <a href="{{route('member.add.skill')}}" class="btn btn-info" style="margin-top:10px">+ Add skill</a>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="normal-table-list mg-t-30">
                    <h2 class="text-center">Management skills</h2>

                        <div class="basic-tb-hd">
                            <h2>Skills</h2>
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
                        @if($skill->count()>0)

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Skill</th>
                                        <th>Performance</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($skill as $row)
                                    <tr>
                                        <td>{{$row->skill}}</td>
                                        <td>{{$row->previous_record}}</td>
                                        <td><a href="{{route('member.edit.skill' , ['id'=>$row->id])}}" class="btn btn-primary">Edit</a></td>
                                        <td><form action="{{route('member.delete.skill' , ['id'=>$row->id])}}" method="post">
                                            <button class="btn btn-danger">Delete</button>
                                            @csrf
                                            @method('delete')
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach

                                  
                                </tbody>
                            </table>
                            @else
                            <h3 class="text-center" style="color: black;">No skill yet</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection