@extends('manger.home')
@section('content')
<div class="normal-table-area">
        <div class="container">
            <div class="row">
            <a href="{{route('manger.add.member')}}" class="btn btn-info">+ Add Account</a>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="normal-table-list mg-t-30">
                        <div class="basic-tb-hd">
                            <h2>Account</h2>
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
                            @if($user->count()>0)
                            
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Job ID</th>
                                        <th>Age</th>
                                        <th>Phone</th>
                                        <th>Available</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($user as $row)
                                    <tr>
                                        <td>{{$row->name}}</td>
                                        <td>{{$row->email}}</td>
                                        <td>{{$row->job}}</td>
                                        <td>{{$row->age}}</td>
                                        <td>{{$row->phone}}</td>
                                        <td>{{ $row->is_available ? 'Availaible' : 'Busy' }}</td>
                                        <td><form action="{{route('admin.delete.user' , ['id'=>$row->id])}}" method="post">
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
                            <h3 class="text-center">No account yet</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection