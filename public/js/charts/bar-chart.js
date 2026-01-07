

projects.forEach((p,i)=>{
    

    // 1️⃣ Project Progress — مع تلوين ديناميكي
    new Chart(document.getElementById(`chart_project_${i}`),{
        type:'bar',
        data:{
            labels:[p.name],
            datasets:[{
                label:"Progress %",
                data:[p.progress],
                backgroundColor:p.color,
                borderWidth:2
            }]
        },
        options:{scales:{yAxes:[{ticks:{beginAtZero:true,max:100}}]}}
    });

    // 2️⃣ Tasks Progress chart
    new Chart(document.getElementById(`chart_tasks_${i}`),{
        type:'horizontalBar',
        data:{
            labels: p.tasks.map(t => t.name),
            datasets:[{
                label:"Task Progress %",
                data: p.tasks.map(t => t.progress),
                backgroundColor: p.tasks.map(t =>
                    t.isLate ? 'rgba(255,80,80,.6)' : 'rgba(70,130,180,.6)'
                ),
                borderWidth:2
            }]
        },
        options:{scales:{xAxes:[{ticks:{beginAtZero:true,max:100}}]}}
    });

    // Utility: لون ثابت لكل مهمة (يمكن تحسينه باستخدام palette)
    function colorForIndex(idx) {
        const hue = Math.round((idx * 47) % 360);
        return `hsl(${hue} 70% 45% / 0.9)`; // صيغة CSS الحديثة، أو استخدم rgba
    }

    // 3️⃣ Timeline متعدد الخطوط — نكوّن datasets ديناميكيًا
    const labels = p.timelineProgress.dates; // المحور X (تواريخ)
    const datasets = [];

    // خط متوسط المشروع
    datasets.push({
        label: `Project Average`,
        data: p.timelineProgress.values,
        fill: false,
        borderColor: p.color,
        borderWidth: 3,
        tension: 0.3,
        pointRadius: 3,
        spanGaps: true
    });

    // خطوط كل مهمة
    p.tasksTimeline.forEach((task, idx) => {
        datasets.push({
            label: task.task_name,
            data: task.values, // مصفوفة متوافقة مع labels
            fill: false,
            borderWidth: 2,
            borderColor: task.isLate ? 'rgba(255,80,80,0.9)' : colorForIndex(idx),
            pointRadius: 3,
            tension: 0.25,
            spanGaps: true // يملأ الفواصل إن استخدمنا forward-fill أو يتخطاها إن كانت null
        });
    });

    const ctx = document.getElementById(`chart_timeline_${i}`);
    new Chart(ctx, {
        type: 'line',
        data: { labels, datasets },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: { autoSkip: true, maxRotation: 0 },
                }],
                xAxes: [{
                    ticks: { beginAtZero: true, max: 100 }

                }]
            },
            tooltips: {
                mode: 'index',
                intersect: false
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            legend: {
                display: true,
                position: 'top'
            }
        }
    });

    // 4️⃣ Stacked Tasks chart
    new Chart(document.getElementById(`chart_stacked_${i}`),{
        type:'bar',
        data:{
            labels:["Completed","In Progress","Pending"],
            datasets:[{
                label:"Tasks Breakdown",
                data:[p.stacked.completed, p.stacked.inprogress, p.stacked.pending],
                backgroundColor:[
                    'rgba(70,200,90,.7)',
                    'rgba(70,140,220,.7)',
                    'rgba(200,200,70,.7)',
                ],
                borderWidth:2
            }]
        },
        options:{scales:{yAxes:[{ticks:{beginAtZero:true}}]}}
    });

});
