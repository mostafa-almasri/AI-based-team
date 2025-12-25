<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Project Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1, h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; font-size: 13px; }
        th { background: #eee; }
        .section-title { margin-top: 25px; font-size: 18px; font-weight: bold; }
    </style>
</head>
<body>

<h1>Project Report</h1>
<h2>{{ $team->project_name }}</h2>

<p><strong>Field:</strong> {{ $team->project_field }}</p>
<p><strong>Start Date:</strong> {{ $team->tasks->min('start_date') }}</p>
<p><strong>Deadline:</strong> {{ $team->time_frame }}</p>
<p><strong>Total Members:</strong> {{ $members->count() }}</p>
<p><strong>Total Tasks:</strong> {{ $team->totalTasks() }}</p>
<p><strong>Completed Tasks:</strong> {{ $team->completedTasks() }}</p>
<p><strong>Project Progress:</strong> {{ $team->projectProgress() }}%</p>

@if(is_array($team->project_skill))
    <p><strong>Project Skills:</strong></p>
    <ul>
        @foreach($team->project_skill as $skill)
            <li>{{ $skill }}</li>
        @endforeach
    </ul>
@endif

<hr>

<div class="section-title">Team Members</div>
<table>
    <tr>
        <th>Name</th>
        <th>Job</th>
        <th>Active Tasks</th>
    </tr>

    @foreach($members as $m)
    <tr>
        <td>{{ $m->name }}</td>
        <td>{{ $m->job }}</td>
        <td>{{ $m->tasks->count() }}</td>
    </tr>
    @endforeach
</table>

<hr>

<div class="section-title">Tasks Details</div>
<table>
    <tr>
        <th>Task Name</th>
        <th>Assigned To</th>
        <th>Start</th>
        <th>Finish</th>
        <th>Status</th>
        <th>Progress</th>
    </tr>

    @foreach($tasks as $t)
    <tr>
        <td>{{ $t->task_name }}</td>
        <td>{{ optional($t->member)->name }}</td>
        <td>{{ $t->start_date }}</td>
        <td>{{ $t->finish_date }}</td>
        <td>{{ $t->status }}</td>
        <td>{{ $t->progress }}%</td>
    </tr>
    @endforeach
</table>

<hr>

<div class="section-title">Delayed Tasks</div>

@php
    $lateTasks = $tasks->filter(fn($x) => $x->isLate());
@endphp

@if($lateTasks->count() == 0)
    <p>No late tasks 🎉</p>
@else
<table>
    <tr>
        <th>Task</th>
        <th>Member</th>
        <th>Deadline</th>
        <th>Progress</th>
    </tr>
    @foreach($lateTasks as $t)
    <tr>
        <td>{{ $t->task_name }}</td>
        <td>{{ optional($t->member)->name }}</td>
        <td>{{ $t->finish_date }}</td>
        <td>{{ $t->progress }}%</td>
    </tr>
    @endforeach
</table>
@endif

</body>
</html>