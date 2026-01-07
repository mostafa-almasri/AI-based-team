@extends('member.home')
@section('content')
<div class="normal-table-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="normal-table-list mg-t-30">
                        <div class="basic-tb-hd">
                            <h2 class="text-center">Management tasks</h2>
                        </div>
                        <div class="bsc-tbl-hvr">
                        @if($task->count()>0)

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Project name</th>
                                        <th>Task name</th>
                                        <th>Task duration</th>
                                        <th>Start date</th>
                                        <th>Finish date</th>
                                        <th>Status</th>
                                        <th>Progress</th>

                                        <th> Upload report</th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($task as $row)
                                @php
                                    $now = \Carbon\Carbon::now(); // الحصول على الوقت الحالي
                                    $finishDate = \Carbon\Carbon::parse($row->finish_date); // تحويل finish_date إلى كائن Carbon
                                    $startDate = \Carbon\Carbon::parse($row->start_date);

                                @endphp
                                
                                    <tr>
                                    <td>{{$row->team->project_name}}</td>
                                        <td>{{$row->task_name}}</td>
                                        <td>{{$row->task_duration}}</td>
                                        <td>{{$row->start_date}}</td>
                                        <td>{{$row->finish_date}}</td>
                                        <td>
                                            @if($now->greaterThan($finishDate) && $row->status == 'In progress')
                                                @php
                                                    $row->status = 'Not implemented';
                                                    $row->save();
                                                @endphp
                                            @endif
                                            {{$row->status}}
                                        </td>
                                        <td>{{$row->progress}} %</td>


                                        <td>
                                        @if($now->between($startDate, $finishDate))
                                            <a href="{{ route('member.add.document', ['id' => $row->id]) }}" class="btn btn-danger">
                                                Add report
                                            </a>
                                        @else
                                            <a class="btn btn-danger disabled" aria-disabled="true">
                                                Add report
                                            </a>
                                        @endif
                                         
                                        </td>

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