@extends('member.home')
@section('content')
<div class="form-example-area">
        <div class="container">
  
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-example-wrap mg-t-30">
                    <h2 class="text-center">Management skills</h2>

                        <div class="cmp-tb-hd cmp-int-hd">
                            <h2>Add skill</h2>
                        </div>
                        <form action="{{route('member.store.skill')}}" method="post">
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
                                                    <option value="Programming & Software Development - Java">Java</option>
                                                    <option value="Programming & Software Development - Python">Python</option>
                                                    <option value="Programming & Software Development - C++">C++</option>
                                                    <option value="Programming & Software Development - C#">C#</option>
                                                    <option value="Programming & Software Development - Web Development (HTML, CSS, JS, React)">Web Development (HTML, CSS, JS, React)</option>
                                                    <option value="Programming & Software Development - Mobile Development (Android, iOS)">Mobile Development (Android, iOS)</option>
                                                    <option value="Programming & Software Development - Embedded Systems">Embedded Systems</option>
                                                </optgroup>
                                                <optgroup label="Database Management">
                                                    <option value="Database Management - SQL (MySQL, PostgreSQL)">SQL (MySQL, PostgreSQL)</option>
                                                    <option value="Database Management - NoSQL (MongoDB)">NoSQL (MongoDB)</option>
                                                    <option value="Database Management - Big Data (Hadoop, Spark)">Big Data (Hadoop, Spark)</option>
                                                </optgroup>
                                                <optgroup label="Networking & Cybersecurity">
                                                    <option value="Networking & Cybersecurity - Computer Networks (TCP/IP, LAN, WAN)">Computer Networks (TCP/IP, LAN, WAN)</option>
                                                    <option value="Networking & Cybersecurity - Security Tools (Firewalls, VPN, IDS/IPS)">Security Tools (Firewalls, VPN, IDS/IPS)</option>
                                                    <option value="Networking & Cybersecurity - Data Encryption & Identity Management">Data Encryption & Identity Management</option>
                                                    <option value="Networking & Cybersecurity - Penetration Testing & Vulnerability Analysis">Penetration Testing & Vulnerability Analysis</option>
                                                </optgroup>
                                                <optgroup label="Operating Systems">
                                                    <option value="Operating Systems - Windows Administration">Windows Administration</option>
                                                    <option value="Operating Systems - Linux/Unix Administration">Linux/Unix Administration</option>
                                                    <option value="Operating Systems - Cloud Systems (AWS, Azure, Google Cloud)">Cloud Systems (AWS, Azure, Google Cloud)</option>
                                                </optgroup>
                                                <optgroup label="Project Management">
                                                    <option value="Project Management - Project Planning & Execution">Project Planning & Execution</option>
                                                    <option value="Project Management - Project Management Tools (JIRA, Trello, Asana)">Project Management Tools (JIRA, Trello, Asana)</option>
                                                </optgroup>
                                                <optgroup label="Data Analysis & AI">
                                                    <option value="Data Analysis & AI - Data Analysis (Excel, Power BI)">Data Analysis (Excel, Power BI)</option>
                                                    <option value="Data Analysis & AI - Artificial Intelligence & Machine Learning">Artificial Intelligence & Machine Learning</option>
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
                                                <option value="">Select performance</option>
                                                <option value="Normal">Normal</option>
                                                <option value="Good">Good</option>
                                                <option value="Very Good">Very Good</option>
                                                <option value="Excellent">Excellent</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-example-int mg-t-15">
                            <div class="row">
                                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                                </div>
                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                    <button class="btn btn-primary notika-btn-primary">Add</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection