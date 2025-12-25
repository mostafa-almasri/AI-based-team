@extends('member.home')
@section('content')


                                        
<div class="inbox-area">
        <div class="container">
            <div class="row">
            <h2 class="text-center" style="margin-top:10px">Browse Projects</h2>

                <div class="basic-tb-hd">
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
                @if($group->count()>0)
                    @foreach($group as $row)
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <div class="inbox-left-sd">
                            <div class="compose-ml">
                                <h3>{{$row->project_name}}</h3>
                            </div>
                            <div class="inbox-status">
                                <ul class="inbox-st-nav inbox-ft">
                                    <li><a href="#">Details:</a></li>
                                    <li> <p>Field project : <span style="font-weight: bold;">{{$row->project_field}}</span> </p> </li>
                                    <li> <p>Total number of member : <span style="font-weight: bold;">{{$row->count_team}}</span> </p> </li>
                                    <li> <p>Deadline : <span style="font-weight: bold;">{{$row->time_frame}}</span> </p> </li>
                                 
                                </ul>
                            </div>
                            <hr>
                            <div class="inbox-status">
                                <div class="accordion-stn sm-res-mg-t-30">
                                    <div class="panel-group" data-collapse-color="nk-green" id="accordion{{$row->id}}skill" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-collapse notika-accrodion-cus">
                                            <div class="panel-heading" role="tab">
                                                <h4 class="panel-title">
                                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion{{$row->id}}skill" href="#accordionRed-{{$row->id}}skill" aria-expanded="false">
															Skills
														</a>
                                                </h4>
                                            </div>
                                            <div id="accordionRed-{{$row->id}}skill" class="collapse" role="tabpanel">
                                                <div class="panel-body">
                                          
                                                <?php
                                                    $decoded_once = json_decode($row->project_skill);
                                                    if (is_string($decoded_once)) {
                                                        // فك التشفير الثاني للحصول على مصفوفة فعلية
                                                        $skills = json_decode($decoded_once, true);
                                                    } else {
                                                        $skills = $decoded_once;
                                                    }
    

                                                    if ($skills && is_array($skills)) {
                                                        echo '<ol style="padding-left: 25px;">';
                                                        foreach ($skills as $skill) {
                                                            echo "<li>$skill</li>";
                                                        }
                                                        echo "</ol>";
                                                    } else {
                                                        echo "<p>No skills assigned</p>";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="inbox-status">
                                <ul class="inbox-st-nav inbox-ft">
                                <li><a href="#">Action:</a></li>
                                    <li><a href="{{route('member.table.team' , ['id'=>$row->id])}}"><i class="notika-icon notika-support"></i><span style="font-weight: bold;"> Show members</span>  </a></li>
                                    <li><a href="{{route('member.table.task', ['id'=>$row->id])}}"><i class="notika-icon notika-success"></i><span style="font-weight: bold;"> Show tasks</span>  </a></li>
                                </ul>
                                  
                            </div> 

                  
                           
                        </div>
                    </div>
                    @endforeach
                @else
                    <h3 class="text-center">No project joined yet</h3>
                @endif

            </div>
        </div>
</div>
@endsection