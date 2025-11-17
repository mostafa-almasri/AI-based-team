@extends('manger.home')
@section('content')
<div class="form-example-area">
                <div class="container">
                  <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <div class="form-example-wrap mg-t-30">
                              <div class="cmp-tb-hd cmp-int-hd">
                                  <h2>Progress tasks</h2>
                              </div>
                              <div class="hd-message-info hd-task-info">
                                @if($task->count()>0)
                                        <div class="skill">
                                          @foreach($task as $row)
                                            <div class="progress">
                                                <div class="lead-content">
                                                    <p>Name task :{{$row->task_name}} // <span style="color:green">Name member : {{$row->name}}</span> // <span style="color:grey">Name project : {{$row->project_name}}</span> </p>
                                                </div>                            
                                                <div class="progress-bar wow fadeInLeft" data-progress="{{$row->progress}}" style="width: {{$row->progress}}%;" data-wow-duration="1.5s" data-wow-delay="1.2s"> <span>{{$row->progress}}%</span>
                                                </div>
                                            </div>
                                          @endforeach
                                        </div>
                                @else
                                <h4>No tasks yet</h4>
                                @endif
                              </div>
                              
                          </div>
                      </div>
                  </div>
                </div>
              </div>
@endsection