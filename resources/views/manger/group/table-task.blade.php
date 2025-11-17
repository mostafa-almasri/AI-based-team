@extends('manger.home')
@section('content')
<div class="normal-table-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="normal-table-list mg-t-30">
                        <div class="basic-tb-hd">
                            <h2>My tasks</h2>
                        </div>
                        <div class="bsc-tbl-hvr">
                        @if($task->count()>0)
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Task name</th>
                                        <th>Task duration</th>
                                        <th>Start date</th>
                                        <th>Finish date</th>
                                        <th>Name member</th>
                                        <th>Status</th>
                                        <th>Progress</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($task as $row)
                                    <tr>
                                        <td>{{$row->task_name}}</td>
                                        <td>{{$row->task_duration}}</td>
                                        <td>{{$row->start_date}}</td>
                                        <td>{{$row->finish_date}}</td>
                                        <td>{{$row->member->name}}</td>
                                        <td>{{$row->status}}</td>
                                        <td>{{$row->progress}} %</td>
                                        <td><a href="{{route('manger.edit.task', ['id'=>$row->id])}}" class="btn btn-warning">Edit task</a></td>



                                    </tr>
                                    @if($row->document && $row->document->task_id == $row->id )
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                               
                                                    <td  style="display: flex; flex-direction: column;    align-content: center;    flex-wrap: wrap;    align-items: center;">
                                                        <strong>Download your report</strong> 
                                                        <?php
                                                        $file_path = asset('uploads/document/'.$row->document->document);
                                                        $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);
                                                        ?>
                                                        <?php if ($file_extension === 'pdf' || $file_extension === 'docx' || $file_extension === 'pptx'): ?>
                                                            <div class="breadcomb-report">
                                                                <a href="<?php echo $file_path; ?>" data-toggle="tooltip" data-placement="right" title="Download Report" class="btn"><i class="notika-icon notika-sent"></i></a>
                                                            </div>
                                                        <?php else: ?>
                                                            <p>File type not supported </p>
                                                        <?php endif; ?>
                                                       
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>

                                                </tr>
                                                @endif
                                @endforeach
                                </tbody>
                            </table>
                            @else
                            <h3 class="text-center">No task added yet</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection