@extends('manger.home')
@section('content')
<div class="form-example-area">
        <div class="container">

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-example-wrap mg-t-30">
                        <div class="cmp-tb-hd cmp-int-hd">
                            <h2>Add group</h2>
                        </div>
                        <form action="{{route('manger.store.group')}}" method="post">
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
                                        <label class="hrzn-fm">Project name</label>
                                    </div>
                                    <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                        <div class="nk-int-st">
                                            <input type="text" class="form-control input-sm" placeholder="Enter project name" name="project_name">
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
                                            <input type="text" class="form-control input-sm" placeholder="Enter Project goal" name="project_field">
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
                                            <input type="integer" class="form-control input-sm" placeholder="Enter Number of member" name="count_team">
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
                            <input type="checkbox" name="skills[]" value="Programming & Software Development - Java"> Java
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Programming & Software Development - Python"> Python
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Programming & Software Development - C++"> C++
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Programming & Software Development - C#"> C#
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Programming & Software Development - Web Development (HTML, CSS, JS, React)"> Web Development (HTML, CSS, JS, React)
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Programming & Software Development - Mobile Development (Android, iOS)"> Mobile Development (Android, iOS)
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Programming & Software Development - Embedded Systems"> Embedded Systems
                        </div>
                        <label style="color:green">Database Management</label>

                        <!-- Database Management -->
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Database Management - SQL (MySQL, PostgreSQL)"> SQL (MySQL, PostgreSQL)
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Database Management - NoSQL (MongoDB)"> NoSQL (MongoDB)
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Database Management - Big Data (Hadoop, Spark)"> Big Data (Hadoop, Spark)
                        </div>
                        <label style="color:green">Networking & Cybersecurity</label>

                        <!-- Networking & Cybersecurity -->
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Networking & Cybersecurity - Computer Networks (TCP/IP, LAN, WAN)"> Computer Networks (TCP/IP, LAN, WAN)
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Networking & Cybersecurity - Security Tools (Firewalls, VPN, IDS/IPS)"> Security Tools (Firewalls, VPN, IDS/IPS)
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Networking & Cybersecurity - Data Encryption & Identity Management"> Data Encryption & Identity Management
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Networking & Cybersecurity - Penetration Testing & Vulnerability Analysis"> Penetration Testing & Vulnerability Analysis
                        </div>
                        <label style="color:green">Operating Systems</label>

                        <!-- Operating Systems -->
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Operating Systems - Windows Administration"> Windows Administration
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Operating Systems - Linux/Unix Administration"> Linux/Unix Administration
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Operating Systems - Cloud Systems (AWS, Azure, Google Cloud)"> Cloud Systems (AWS, Azure, Google Cloud)
                        </div>
                        <label style="color:green">Project Management</label>

                        <!-- Project Management -->
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Project Management - Project Planning & Execution"> Project Planning & Execution
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Project Management - Project Management Tools (JIRA, Trello, Asana)"> Project Management Tools (JIRA, Trello, Asana)
                        </div>
                        <label style="color:green">Data Analysis & AI</label>

                        <!-- Data Analysis & AI -->
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Data Analysis & AI - Data Analysis (Excel, Power BI)"> Data Analysis (Excel, Power BI)
                        </div>
                        <div class="fm-checkbox">
                            <input type="checkbox" name="skills[]" value="Data Analysis & AI - Artificial Intelligence & Machine Learning"> Artificial Intelligence & Machine Learning
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
                                            
                                            <input type="date"  id="deadline" class="form-control input-sm" placeholder="Enter Project goal" name="time_frame">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            // تحديد تاريخ اليوم بصيغة YYYY-MM-DD
                            const today = new Date().toISOString().split('T')[0];
                            document.getElementById('deadline').setAttribute('min', today);
                        </script>
                        <div class="form-example-int mg-t-15">
                            <div class="row">
                                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                                </div>
                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                    <button class="btn btn-success notika-btn-success">Add</button>
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