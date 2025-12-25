@extends('admin.home')
@section('content')
<div class="contact-info-area mg-t-30">
    <h2 class="text-center">Management manager account</h2>
<a href="{{route('admin.add.user')}}" class="btn btn-info" style="margin:10px 0;">+ Create Account</a>

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
                                    <p>Details</p>
                            
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
                                                    <li><form action="{{route('admin.delete.user' , ['id'=>$row->id])}}" method="post">
                                                    <button class="btn btn-danger"><i class="notika-icon notika-trash"></i> </button>
                                                    @csrf
                                                    @method('delete')
                                                    </form></li>

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