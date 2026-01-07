@extends('manger.home')
@section('content')
<div class="form-example-area">
<h2 class="text-center">Management Projects</h2>
        <div class="container">
  
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-example-wrap mg-t-30">
                        <div class="cmp-tb-hd cmp-int-hd">
                            <h2>Edit project</h2>
                        </div>
                        <form action="{{route('manger.update.group')}}" method="post">
                            @method('PUT')
                            @csrf
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
                        <input type="hidden" name="id" value="{{$group->id}}">
                       
                        <div class="form-example-int form-horizental">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                                        <label class="hrzn-fm">Project name</label>
                                    </div>
                                    <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                        <div class="nk-int-st">
                                            <input type="text" class="form-control input-sm" value="{{$group->project_name}}" name="project_name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-example-int form-horizental">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                                        <label class="hrzn-fm">Project goal</label>
                                    </div>
                                    <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                        <div class="nk-int-st">
                                            <input type="text" class="form-control input-sm" value="{{$group->project_field}}" name="project_field">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-example-int form-horizental">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                                        <label class="hrzn-fm">Total number of members</label>
                                    </div>
                                    <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                        <div class="nk-int-st">
                                            <input type="integer" class="form-control input-sm" value="{{$group->count_team}}"  name="count_team">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-example-int form-horizental">
    <div class="form-group">
        <div class="row">
            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                <label class="hrzn-fm">Skills</label>
            </div>
            <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                <div class="nk-int-st">
                    <div class="checkbox-group">
                        <label style="color:green">Programming & Software Development</label>
                        
                        <!-- Programming & Software Development -->
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Programming & Software Development - Java" 
                                   @if(in_array('Programming & Software Development - Java', json_decode($group->project_skill))) checked @endif> Java
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Programming & Software Development - Python" 
                                   @if(in_array('Programming & Software Development - Python', json_decode($group->project_skill))) checked @endif> Python
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Programming & Software Development - C++" 
                                   @if(in_array('Programming & Software Development - C++', json_decode($group->project_skill))) checked @endif> C++
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Programming & Software Development - C#" 
                                   @if(in_array('Programming & Software Development - C#', json_decode($group->project_skill))) checked @endif> C#
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Programming & Software Development - Web Development (HTML, CSS, JS, React)" 
                                   @if(in_array('Programming & Software Development - Web Development (HTML, CSS, JS, React)', json_decode($group->project_skill))) checked @endif> Web Development (HTML, CSS, JS, React)
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Programming & Software Development - Mobile Development (Android, iOS)" 
                                   @if(in_array('Programming & Software Development - Mobile Development (Android, iOS)', json_decode($group->project_skill))) checked @endif> Mobile Development (Android, iOS)
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Programming & Software Development - Embedded Systems" 
                                   @if(in_array('Programming & Software Development - Embedded Systems', json_decode($group->project_skill))) checked @endif> Embedded Systems
                        </div>

                        <label style="color:green">Database Management</label>

                        <!-- Database Management -->
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Database Management - SQL (MySQL, PostgreSQL)" 
                                   @if(in_array('Database Management - SQL (MySQL, PostgreSQL)', json_decode($group->project_skill))) checked @endif> SQL (MySQL, PostgreSQL)
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Database Management - NoSQL (MongoDB)" 
                                   @if(in_array('Database Management - NoSQL (MongoDB)', json_decode($group->project_skill))) checked @endif> NoSQL (MongoDB)
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Database Management - Big Data (Hadoop, Spark)" 
                                   @if(in_array('Database Management - Big Data (Hadoop, Spark)', json_decode($group->project_skill))) checked @endif> Big Data (Hadoop, Spark)
                        </div>

                        <label style="color:green">Networking & Cybersecurity</label>

                        <!-- Networking & Cybersecurity -->
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Networking & Cybersecurity - Computer Networks (TCP/IP, LAN, WAN)" 
                                   @if(in_array('Networking & Cybersecurity - Computer Networks (TCP/IP, LAN, WAN)', json_decode($group->project_skill))) checked @endif> Computer Networks (TCP/IP, LAN, WAN)
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Networking & Cybersecurity - Security Tools (Firewalls, VPN, IDS/IPS)" 
                                   @if(in_array('Networking & Cybersecurity - Security Tools (Firewalls, VPN, IDS/IPS)', json_decode($group->project_skill))) checked @endif> Security Tools (Firewalls, VPN, IDS/IPS)
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Networking & Cybersecurity - Data Encryption & Identity Management" 
                                   @if(in_array('Networking & Cybersecurity - Data Encryption & Identity Management', json_decode($group->project_skill))) checked @endif> Data Encryption & Identity Management
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Networking & Cybersecurity - Penetration Testing & Vulnerability Analysis" 
                                   @if(in_array('Networking & Cybersecurity - Penetration Testing & Vulnerability Analysis', json_decode($group->project_skill))) checked @endif> Penetration Testing & Vulnerability Analysis
                        </div>

                        <label style="color:green">Operating Systems</label>

                        <!-- Operating Systems -->
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Operating Systems - Windows Administration" 
                                   @if(in_array('Operating Systems - Windows Administration', json_decode($group->project_skill))) checked @endif> Windows Administration
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Operating Systems - Linux/Unix Administration" 
                                   @if(in_array('Operating Systems - Linux/Unix Administration', json_decode($group->project_skill))) checked @endif> Linux/Unix Administration
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Operating Systems - Cloud Systems (AWS, Azure, Google Cloud)" 
                                   @if(in_array('Operating Systems - Cloud Systems (AWS, Azure, Google Cloud)', json_decode($group->project_skill))) checked @endif> Cloud Systems (AWS, Azure, Google Cloud)
                        </div>

                        <label style="color:green">Project Management</label>

                        <!-- Project Management -->
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Project Management - Project Planning & Execution" 
                                   @if(in_array('Project Management - Project Planning & Execution', json_decode($group->project_skill))) checked @endif> Project Planning & Execution
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Project Management - Project Management Tools (JIRA, Trello, Asana)" 
                                   @if(in_array('Project Management - Project Management Tools (JIRA, Trello, Asana)', json_decode($group->project_skill))) checked @endif> Project Management Tools (JIRA, Trello, Asana)
                        </div>

                        <label style="color:green">Data Analysis & AI</label>

                        <!-- Data Analysis & AI -->
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Data Analysis & AI - Data Analysis (Excel, Power BI)" 
                                   @if(in_array('Data Analysis & AI - Data Analysis (Excel, Power BI)', json_decode($group->project_skill))) checked @endif> Data Analysis (Excel, Power BI)
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Data Analysis & AI - Artificial Intelligence & Machine Learning" 
                                   @if(in_array('Data Analysis & AI - Artificial Intelligence & Machine Learning', json_decode($group->project_skill))) checked @endif> Artificial Intelligence & Machine Learning
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

                        <div class="form-example-int form-horizental">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                                        <label class="hrzn-fm">Deadline</label>
                                    </div>
                                    <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                        <div class="nk-int-st">
                                            <input type="date"  id="deadline" class="form-control input-sm" value="{{$group->time_frame}}" name="time_frame">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                            // تحديد تاريخ اليوم بصيغة YYYY-MM-DD
                            const today = new Date().toISOString().split('T')[0];
                            document.getElementById('deadline').setAttribute('min', today);
                        </script>
                        </div>
                        <div class="form-example-int mg-t-15">
                            <div class="row">
                                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                                </div>
                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                    <button class="btn btn-primary notika-btn-primary">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection