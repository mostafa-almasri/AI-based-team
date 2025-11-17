@extends('member.home')
@section('content')
<div class="normal-table-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="normal-table-list mg-t-30">
                        <div class="basic-tb-hd">
                            <h2>Team</h2>
                            @if(session('status'))
                            <h6 class="alert alert-success" style="text-align: center;">
                                {{session('status')}}
                            </h6>
                        @endif
                        </div>
                        <div class="bsc-tbl-hvr">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Project name</th>
                                        <th>Project goal</th>
                                        <th>Deadline</th>
                                        <th>Skills</th>
                                        <th>Show member team</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($group as $row)
                                    <tr>
                                        <td>{{$row->project_name}}</td>
                                        <td>{{$row->project_field}}</td>
                                        <td>{{$row->time_frame}}</td>
                                        <td>
                                            <?php
                                                // فك التشفير الأول (لإزالة علامات الاقتباس الخارجية)
                                                $decoded_once = json_decode($row->project_skill, true);

                                                // التحقق مما إذا كانت النتيجة سلسلة نصية JSON
                                                if (is_string($decoded_once)) {
                                                    // فك التشفير الثاني للحصول على مصفوفة فعلية
                                                    $skills = json_decode($decoded_once, true);
                                                } else {
                                                    $skills = $decoded_once;
                                                }

                                                // التحقق مما إذا كانت البيانات مصفوفة وعرضها
                                                if (is_array($skills)) {
                                                    echo implode(', ', $skills);
                                                } else {
                                                    echo "No skills assigned";
                                                }
                                            ?>
                                        </td>

                                                                          
                                        </td>
                                      
                                        <td><a href="{{route('member.table.team', ['id'=>$row->id])}}" class="btn btn-info">Show</a></td>

                                    </tr>
                                    @endforeach
                        
                               
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection