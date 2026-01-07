@extends('member.home')
@section('content')
<div class="contact-info-area mg-t-30">
    <h2 class="text-center">Team Members</h2>

        <div class="container">
            <div class="row">
                @if($member->count()>0)
                    @foreach($member as $row)
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <div class="widget-tabs-int sm-res-mg-t-30 tb-res-mg-t-30 tb-res-ds-n dk-res-ds">
                                <div class="contact-hd tm-activity">
                                    <h2>{{$row->name}}</h2>
                                </div>
                                <div class="widget-tabs-list">
                              
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
                                                   
                                                </ul>
                                            </div>
                                        </div>
                             
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach  
                @else
                    <h3 class="text-center">No Members added yet</h3>
                @endif
            </div>
        </div>
    </div>

@endsection
