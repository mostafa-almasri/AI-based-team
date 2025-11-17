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
                        @if($group->count()>0)

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Project name</th>
                                        <th>Project goal</th>
                                        <th>Total number of members</th>
                                        <th>Deadline</th>
                                        <th>Skills</th>       
                                        <th>Add task</th>                                 
                                        <th>Delete group</th>
                                        <th>Edit group</th>
                                        <th>Show team members</th>
                                        <th>Show task</th>
                                        <th>Generate report</th>

                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($group as $row)
                                    <tr>
                                        <td>{{$row->project_name}}</td>
                                        <td>{{$row->project_field}}</td>
                                        <td>{{$row->count_team}}</td>
                                        <td>{{$row->time_frame}}</td>
                                        <td> 
                                            <?php
                                            // فك تشفير JSON إلى مصفوفة أو كائن
                                            $skills = json_decode($row->project_skill);
                                            
                                            // التحقق مما إذا كانت البيانات موجودة
                                            if ($skills) {
                                                // إذا كانت المصفوفة تحتوي على عناصر، اعرضها
                                                echo implode(', ', $skills);
                                            } else {
                                                echo "No skills assigned";
                                            }
                                            ?>
                                        </td>
                                        <td><a href="{{route('manger.add.task' , ['id'=>$row->id])}}" class="btn btn-info">Add task</a></td>
                                        <td><form action="{{route('manger.delete.group' , ['id'=>$row->id])}}" method="post">
                                            <button class="btn btn-danger">Delete</button>
                                            @csrf
                                            @method('delete')
                                            </form>
                                        </td>                                        
                                        <td><a href="{{route('manger.edit.group' , ['id'=>$row->id])}}" class="btn btn-primary">Edit</a></td>
                                        <td><a href="{{route('manger.show.team', ['id'=>$row->id])}}" class="btn btn-info">Show team</a></td>
                                        <td><a href="{{route('manger.show.task', ['id'=>$row->id])}}" class="btn btn-warning">Show task</a></td>
                                        <td>
                                        
                                                <button class="btn btn-success">Generate</button>
                                            </form>
                                        </td>

                                    </tr>
                                    

                                    @if($row->report && $row->report->team_id == $row->id )
                                    <tr>
    <td colspan="10" style="text-align: center;">
        <h4>Report</h4>
    </td>
</tr>
<tr>
<td colspan="10" style="text-align: center;">
<div style="display: flex; justify-content: center; align-items: center; gap: 50px;">

        <!-- Overall Performance -->
        <div style="text-align: center;">
            <strong>Overall performance</strong><br>
            {{$row->report->overall_performance}}
        </div>

        <!-- Download Report -->
        <div style="text-align: center;">
            <strong>Download final report</strong><br>
            <?php
            $file_path = asset($row->report->report_path);
            $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);
            ?>
            <?php if (in_array($file_extension, ['pdf', 'docx', 'pptx'])): ?>
                <div class="breadcomb-report">
                    <a href="<?php echo $file_path; ?>" data-toggle="tooltip" data-placement="right" title="Download Report" class="btn">
                        <i class="notika-icon notika-sent"></i>
                    </a>
                </div>
            <?php else: ?>
                <p>File type not supported</p>
            <?php endif; ?>
        </div>
            </div>
    </td>
</tr>

                                    @endif
                                    @endforeach
                               
                                </tbody>
                            </table>
                            @else
                            <h3 class="text-center">No group yet</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection