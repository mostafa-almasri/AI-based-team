@extends('member.home')
@section('content')
<div class="form-example-area">
        <div class="container">
  
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-example-wrap mg-t-30">
                    <h2 class="text-center">Management skills</h2>

                        <div class="cmp-tb-hd cmp-int-hd">
                            <h2>Edit skill</h2>
                        </div>
                        <form action="{{route('member.update.skill')}}" method="post">
                            @csrf
                            @method('PUT')
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
                        <input type="hidden" class="form-control input-sm" value="{{$skill->id}}" name="id">

                        <div class="form-example-int form-horizental">
    <div class="form-group">
        <div class="row">
            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                <label class="hrzn-fm">Skill</label>
            </div>
            <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                <div class="nk-int-st">
                    <select class="form-control input-sm" name="skill">
                        <optgroup label="Programming & Software Development">
                            <option value="Programming & Software Development - Java" {{ $skill->skill == 'Programming & Software Development - Java' ? 'selected' : '' }}>Java</option>
                            <option value="Programming & Software Development - Python" {{ $skill->skill == 'Programming & Software Development - Python' ? 'selected' : '' }}>Python</option>
                            <option value="Programming & Software Development - C++" {{ $skill->skill == 'Programming & Software Development - C++' ? 'selected' : '' }}>C++</option>
                            <option value="Programming & Software Development - C#" {{ $skill->skill == 'Programming & Software Development - C#' ? 'selected' : '' }}>C#</option>
                            <option value="Programming & Software Development - Web Development (HTML, CSS, JS, React)" {{ $skill->skill == 'Programming & Software Development - Web Development (HTML, CSS, JS, React)' ? 'selected' : '' }}>Web Development (HTML, CSS, JS, React)</option>
                            <option value="Programming & Software Development - Mobile Development (Android, iOS)" {{ $skill->skill == 'Programming & Software Development - Mobile Development (Android, iOS)' ? 'selected' : '' }}>Mobile Development (Android, iOS)</option>
                            <option value="Programming & Software Development - Embedded Systems" {{ $skill->skill == 'Programming & Software Development - Embedded Systems' ? 'selected' : '' }}>Embedded Systems</option>
                        </optgroup>
                        <optgroup label="Database Management">
                            <option value="Database Management - SQL (MySQL, PostgreSQL)" {{ $skill->skill == 'Database Management - SQL (MySQL, PostgreSQL)' ? 'selected' : '' }}>SQL (MySQL, PostgreSQL)</option>
                            <option value="Database Management - NoSQL (MongoDB)" {{ $skill->skill == 'Database Management - NoSQL (MongoDB)' ? 'selected' : '' }}>NoSQL (MongoDB)</option>
                            <option value="Database Management - Big Data (Hadoop, Spark)" {{ $skill->skill == 'Database Management - Big Data (Hadoop, Spark)' ? 'selected' : '' }}>Big Data (Hadoop, Spark)</option>
                        </optgroup>
                        <optgroup label="Networking & Cybersecurity">
                            <option value="Networking & Cybersecurity - Computer Networks (TCP/IP, LAN, WAN)" {{ $skill->skill == 'Networking & Cybersecurity - Computer Networks (TCP/IP, LAN, WAN)' ? 'selected' : '' }}>Computer Networks (TCP/IP, LAN, WAN)</option>
                            <option value="Networking & Cybersecurity - Security Tools (Firewalls, VPN, IDS/IPS)" {{ $skill->skill == 'Networking & Cybersecurity - Security Tools (Firewalls, VPN, IDS/IPS)' ? 'selected' : '' }}>Security Tools (Firewalls, VPN, IDS/IPS)</option>
                            <option value="Networking & Cybersecurity - Data Encryption & Identity Management" {{ $skill->skill == 'Networking & Cybersecurity - Data Encryption & Identity Management' ? 'selected' : '' }}>Data Encryption & Identity Management</option>
                            <option value="Networking & Cybersecurity - Penetration Testing & Vulnerability Analysis" {{ $skill->skill == 'Networking & Cybersecurity - Penetration Testing & Vulnerability Analysis' ? 'selected' : '' }}>Penetration Testing & Vulnerability Analysis</option>
                        </optgroup>
                        <optgroup label="Operating Systems">
                            <option value="Operating Systems - Windows Administration" {{ $skill->skill == 'Operating Systems - Windows Administration' ? 'selected' : '' }}>Windows Administration</option>
                            <option value="Operating Systems - Linux/Unix Administration" {{ $skill->skill == 'Operating Systems - Linux/Unix Administration' ? 'selected' : '' }}>Linux/Unix Administration</option>
                            <option value="Operating Systems - Cloud Systems (AWS, Azure, Google Cloud)" {{ $skill->skill == 'Operating Systems - Cloud Systems (AWS, Azure, Google Cloud)' ? 'selected' : '' }}>Cloud Systems (AWS, Azure, Google Cloud)</option>
                        </optgroup>
                        <optgroup label="Project Management">
                            <option value="Project Management - Project Planning & Execution" {{ $skill->skill == 'Project Management - Project Planning & Execution' ? 'selected' : '' }}>Project Planning & Execution</option>
                            <option value="Project Management - Project Management Tools (JIRA, Trello, Asana)" {{ $skill->skill == 'Project Management - Project Management Tools (JIRA, Trello, Asana)' ? 'selected' : '' }}>Project Management Tools (JIRA, Trello, Asana)</option>
                        </optgroup>
                        <optgroup label="Data Analysis & AI">
                            <option value="Data Analysis & AI - Data Analysis (Excel, Power BI)" {{ $skill->skill == 'Data Analysis & AI - Data Analysis (Excel, Power BI)' ? 'selected' : '' }}>Data Analysis (Excel, Power BI)</option>
                            <option value="Data Analysis & AI - Artificial Intelligence & Machine Learning" {{ $skill->skill == 'Data Analysis & AI - Artificial Intelligence & Machine Learning' ? 'selected' : '' }}>Artificial Intelligence & Machine Learning</option>
                        </optgroup>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

                        <div class="form-example-int form-horizental">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                                        <label class="hrzn-fm">performance</label>
                                    </div>
                                    <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                        <div class="nk-int-st">
                                        <select name="previous_record" id="" class="form-control input-sm">
                                                <option value="">{{$skill->previous_record}}</option>
                                                <option value="Normal">Normal</option>
                                                <option value="Good">Good</option>
                                                <option value="Very Good">Very Good</option>
                                                <option value="Excellent">Excellent</option>
                                            </select>                                        </div>
                                    </div>
                                </div>
                            </div>
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