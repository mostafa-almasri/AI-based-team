@extends('manger.home')
@section('content')
<div class="form-example-area">
        <div class="container">

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-example-wrap mg-t-30">
                        
                        <div class="bsc-tbl-hvr">
                            <div class="cmp-tb-hd cmp-int-hd">
                                <h4 class="text-center">A table containing some task ideas based on the required skills</h4>
                            </div>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Main Classification of skill</th>
                                        <th>Domain</th>
                                        <th>Task</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <!-- Programming & Software Development (7 Skills) -->
                                <tr>
                                    <td rowspan="7">Programming & Software Development</td>
                                    <td>Java</td>
                                    <td>
                                        Design Java Applications<br>
                                        Analyze Java Code<br>
                                        Write JUnit Tests
                                    </td>
                                </tr>
                                <tr>
                                    <td>Python</td>
                                    <td>
                                        Write Python Scripts<br>
                                        Data Analysis with Python<br>
                                        Build APIs using Flask/Django
                                    </td>
                                </tr>
                                <tr>
                                    <td>C++</td>
                                    <td>
                                        Develop C++ Applications<br>
                                        Optimize C++ Code
                                    </td>
                                </tr>
                                <tr>
                                    <td>C#</td>
                                    <td>
                                        Develop C# Applications<br>
                                        Database Management with C#
                                    </td>
                                </tr>
                                <tr>
                                    <td>Web Development (HTML, CSS, JS, React)</td>
                                    <td>
                                        Design Frontend with HTML/CSS<br>
                                        Build Interactive UI with React<br>
                                        Optimize Website Performance
                                    </td>
                                </tr>
                                <tr>
                                    <td>Mobile Development (Android, iOS)</td>
                                    <td>
                                        Design UI/UX for Mobile Apps<br>
                                        Develop Android/iOS Applications
                                    </td>
                                </tr>
                                <tr>
                                    <td>Embedded Systems</td>
                                    <td>
                                        Design Embedded Systems<br>
                                        Program Embedded Systems using C<br>
                                        Test Embedded Systems
                                    </td>
                                </tr>

                                <!-- Database Management (3 Skills) -->
                                <tr>
                                    <td rowspan="3">Database Management</td>
                                    <td>SQL (MySQL, PostgreSQL)</td>
                                    <td>
                                        Manage Databases with MySQL/PostgreSQL<br>
                                        Write Complex SQL Queries<br>
                                        Optimize Database Performance
                                    </td>
                                </tr>
                                <tr>
                                    <td>NoSQL (MongoDB)</td>
                                    <td>
                                        Manage NoSQL Databases (MongoDB)<br>
                                        Design NoSQL Databases
                                    </td>
                                </tr>
                                <tr>
                                    <td>Big Data (Hadoop, Spark)</td>
                                    <td>
                                        Set Up Big Data Environments<br>
                                        Use Hadoop/Spark for Data Processing
                                    </td>
                                </tr>

                                <!-- Networking & Cybersecurity (4 Skills) -->
                                <tr>
                                    <td rowspan="4">Networking & Cybersecurity</td>
                                    <td>Computer Networks (TCP/IP, LAN, WAN)</td>
                                    <td>
                                        Set up LAN/WAN Networks<br>
                                        Analyze TCP/IP Networks
                                    </td>
                                </tr>
                                <tr>
                                    <td>Security Tools (Firewalls, VPN, IDS/IPS)</td>
                                    <td>
                                        Configure Firewalls<br>
                                        Set Up VPN<br>
                                        Analyze IDS/IPS Logs
                                    </td>
                                </tr>
                                <tr>
                                    <td>Data Encryption & Identity Management</td>
                                    <td>
                                        Encrypt Data using SSL/TLS<br>
                                        Manage Identity and Access Management (IAM)
                                    </td>
                                </tr>
                                <tr>
                                    <td>Penetration Testing & Vulnerability Analysis</td>
                                    <td>
                                        Conduct Penetration Testing<br>
                                        Perform Vulnerability Analysis
                                    </td>
                                </tr>

                                <!-- Operating Systems (3 Skills) -->
                                <tr>
                                    <td rowspan="3">Operating Systems</td>
                                    <td>Windows Administration</td>
                                    <td>
                                        Set up and Maintain Windows Servers<br>
                                        Manage Active Directory
                                    </td>
                                </tr>
                                <tr>
                                    <td>Linux/Unix Administration</td>
                                    <td>
                                        Set up Linux/Unix Servers<br>
                                        Manage Linux/Unix Services
                                    </td>
                                </tr>
                                <tr>
                                    <td>Cloud Systems (AWS, Azure, Google Cloud)</td>
                                    <td>
                                        Set Up Cloud Environments with AWS/Azure/Google Cloud<br>
                                        Manage Cloud Services
                                    </td>
                                </tr>

                                <!-- Project Management (2 Skills) -->
                                <tr>
                                    <td rowspan="2">Project Management</td>
                                    <td>Project Planning & Execution</td>
                                    <td>
                                        Plan and Execute Projects<br>
                                        Create Project Timelines
                                    </td>
                                </tr>
                                <tr>
                                    <td>Project Management Tools (JIRA, Trello, Asana)</td>
                                    <td>
                                        Manage Projects with JIRA/Trello/Asana<br>
                                        Track Project Progress
                                    </td>
                                </tr>

                                <!-- Data Analysis & AI (2 Skills) -->
                                <tr>
                                    <td rowspan="2">Data Analysis & AI</td>
                                    <td>Data Analysis (Excel, Power BI)</td>
                                    <td>
                                        Analyze Data using Excel<br>
                                        Generate Reports with Power BI
                                    </td>
                                </tr>
                                <tr>
                                    <td>Artificial Intelligence & Machine Learning</td>
                                    <td>
                                        Build Machine Learning Models<br>
                                        Analyze Data using AI Algorithms
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="cmp-tb-hd cmp-int-hd">
                            <h2>Add task</h2>
                        </div>
                        <form action="{{route('manger.store.task')}}" method="post">
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
                        <input type="hidden" name="team" value="{{$team->id}}">
                      
                        <div class="form-example-int form-horizental">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                                        <label class="hrzn-fm">Task name</label>
                                    </div>
                                    <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                        <div class="nk-int-st">
                                            <input type="text" class="form-control input-sm" placeholder="Enter task name" name="name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-example-int form-horizental">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                                        <label class="hrzn-fm">Select member</label>
                                    </div>
                                    <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                        <div class="nk-int-st">
                                            <select name="member" id="" class="form-control input-sm">
                                                <option value="">Select member</option>
                                                @foreach($member as $row)
                                                <option value="{{$row->id}}">{{$row->name}} - {{$row->is_available ? 'Availaible' : 'Busy'}}</option>

                                                @endforeach
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
                                        <label class="hrzn-fm">Start date</label>
                                    </div>
                                    <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                        <div class="nk-int-st">
                                            
                                            <input type="date"  id="task_start" class="form-control input-sm"  name="start_date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                          <div class="form-example-int form-horizental">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                                        <label class="hrzn-fm">Finish date</label>
                                    </div>
                                    <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                        <div class="nk-int-st">
                                            
                                            <input type="date" id="task_end"  class="form-control input-sm"  name="finish_date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            // تاريخ اليوم
                            const today = new Date().toISOString().split('T')[0];

                            // تاريخ انتهاء المشروع من Laravel
                            const projectEnd = "{{ $team->time_frame }}";

                            const startInput = document.getElementById('task_start');
                            const endInput   = document.getElementById('task_end');

                            // حدود بداية المهمة
                            startInput.min = today;
                            startInput.max = projectEnd;

                            // حدود نهاية المهمة
                            endInput.min = today;
                            endInput.max = projectEnd;

                            // عند تغيير بداية المهمة يجب تعديل الحد الأدنى لنهايتها
                            startInput.addEventListener('change', () => {
                                endInput.min = startInput.value;   // يمنع أن تكون النهاية قبل البداية
                                if (endInput.value < startInput.value) {
                                    endInput.value = startInput.value;
                                }
                            });
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