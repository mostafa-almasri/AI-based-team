@extends('manger.home')
@section('content')
<div class="contact-info-area mg-t-30">
    <h2 class="text-center">Management members accounts</h2>
<a href="{{route('manger.add.member')}}" class="btn btn-info" style="margin:10px 0;">+ Create Account</a>

        <div class="container">
            <div class="row">
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

                @if($user->count()>0)
                    @foreach($user as $row)
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <div class="widget-tabs-int sm-res-mg-t-30 tb-res-mg-t-30 tb-res-ds-n dk-res-ds">
                                <div class="contact-hd tm-activity">
                                    <h2>{{$row->name}}</h2>
                                </div>
                                <div class="widget-tabs-list">
                                    <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#home{{$row->id}}">Information</a></li>
                                    <li><a data-toggle="tab" href="#skills{{$row->id}}">Skills</a></li>
                                    <li><a data-toggle="tab" href="#tasks{{$row->id}}">Tasks</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="home{{$row->id}}" class="tab-pane fade in active" >
                                            <div class="tab-wd-img" style="padding: 0 85px;">
                                            @if($row->image == NULL)
                                            <img src="{{url('profile.png')}}" alt="" width="150px" height="150px" >

                                            @else
                                            <img src="{{url('uploads/profile/'.$row->image)}}" alt="" >
                                            @endif
                                            </div>
                                            <div class="tab-ctn" style="text-align: center;">
                                                <ul class="tab-ctn-list" >
                                                    <li><i class="notika-icon notika-mail"></i> {{$row->email}}</li>
                                                    <li><i class="notika-icon notika-phone"></i> {{$row->phone}}</li>
                                                    <li><i class="notika-icon notika-paperclip"></i> {{$row->job}}</li>
                                                    <li> @if($row->availability->is_available == 1)
                                                        <i class="notika-icon notika-avable" style="color:green"></i> Available
                                                    @else
                                                    <i class="notika-icon notika-avable" style="color:red"></i> Busy
                                                    @endif

                                                    </li>
                                                    <li><form action="{{route('admin.delete.user' , ['id'=>$row->id])}}" method="post">
                                            <button class="btn btn-danger"><i class="notika-icon notika-trash"></i> </button>
                                            @csrf
                                            @method('delete')
                                            </form></li>

                                                </ul>
                                            </div>
                                        </div>
                                        <div id="skills{{$row->id}}" class="tab-pane fade">
                                     
                                            <div class="tab-ctn">
                                                <h3>Skills</h3>
                                                <ul class="tab-ctn-list">
                                                    
                                                        @forelse($row->skills as $skill)
                                                            <li><i class="notika-icon notika-next"></i> {{ $skill->skill }}</li>
                                                        @empty
                                                            <li>No skills registered</li>
                                                        @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                        <div id="tasks{{$row->id}}" class="tab-pane fade">
                                 
                                            <div class="tab-ctn">
                                                <h3>Tasks</h3>
                                                <ul class="tab-ctn-list">
                                                @forelse($row->tasks as $task)
                                                    <li> <i class="notika-icon notika-next"></i>
                                                        <strong>{{ $task->task_name }}</strong>
                                                        (Project: <span style="color:blue">{{ $task->team->project_name }}</span>)
                                                        – Progress: {{ $task->progress }}%
                                                    </li>
                                                @empty
                                                    <li>No tasks assigned</li>
                                                @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach  
                @else
                    <h3 class="text-center">No account yet</h3>
                @endif
            </div>
        </div>
    </div>

@endsection