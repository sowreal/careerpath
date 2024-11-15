// For populating MODAL: Evaluation selection


// Enable/Disable KRA Sections Based on Selection


// Initially disable KRA sections until an evaluation is selected



// Visualization: Doughnut Chart for Overall Performance
var ctxDoughnut = document.getElementById('kraDoughnutChart').getContext('2d');
var kraDoughnutChart = new Chart(ctxDoughnut, {
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


// Event listener to load remarks into modal when triggered
document.addEventListener('DOMContentLoaded', function() {
    const remarksModal = document.getElementById('remarksModal');
    const remarks1Content = document.getElementById('remarks1Content');
    const remarks2Content = document.getElementById('remarks2Content');

    remarksModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const remarks1 = button.getAttribute('data-remarks1'); // 1st semester remarks
        const remarks2 = button.getAttribute('data-remarks2'); // 2nd semester remarks
        remarks1Content.textContent = remarks1; // Set 1st semester content
        remarks2Content.textContent = remarks2; // Set 2nd semester content
    });
});


// Save Button Functionality for each Criterion
document.getElementById('save-criterion-a').addEventListener('click', function() {
    // Save logic for Criterion A
    alert('Criterion A saved!');
});

document.getElementById('save-criterion-b').addEventListener('click', function() {
    // Save logic for Criterion B
    alert('Criterion B saved!');
});

document.getElementById('save-criterion-c').addEventListener('click', function() {
    // Save logic for Criterion C
    alert('Criterion C saved!');
});


// JavaScript to dynamically add and remove bg-success and text-white on tabs on 2nd container
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('#kra-tabs .nav-link');

    tabs.forEach(tab => {
        tab.addEventListener('show.bs.tab', function(event) {
            // Remove bg-success and text-white from all tabs
            tabs.forEach(t => t.classList.remove('bg-success', 'text-white'));

            // Add bg-success and text-white to the active tab
            event.target.classList.add('bg-success', 'text-white');
        });
    });
});