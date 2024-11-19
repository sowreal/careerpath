document.addEventListener('DOMContentLoaded', function () {
    // For populating MODAL: Evaluation selection

    

    // Enable/Disable KRA Sections Based on Selection



    // Initially disable KRA sections until an evaluation is selected



    // Visualization: Doughnut Chart for Overall Performance
    const ctxDoughnut = document.getElementById('kraDoughnutChart');
    if (ctxDoughnut) {
        const kraDoughnutChart = new Chart(ctxDoughnut.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Teaching Effectiveness', 'Curriculum & Material Development', 'Thesis & Mentorship Services'],
                datasets: [{
                    label: 'Performance',
                    data: [85, 70, 90],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });
    }  
    
    // JavaScript to dynamically add and remove bg-success and text-white on tabs on 2nd container
    const tabs = document.querySelectorAll('#kra-tabs .nav-link');
    if (tabs.length > 0) {
        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                // Remove bg-success and text-white from all tabs
                tabs.forEach(t => t.classList.remove('bg-success', 'text-white'));

                // Add bg-success and text-white to the clicked tab
                this.classList.add('bg-success', 'text-white');
            });
        });
    }
});
