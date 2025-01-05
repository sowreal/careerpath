document.addEventListener('DOMContentLoaded', function () {
    // Evaluation Selection Handler
    document.getElementById('select-evaluation-btn').addEventListener('click', function () {
        const modalBody = document.querySelector('#evaluationModal .modal-body');
        modalBody.innerHTML = '<p>Loading evaluations...</p>'; // Show loading message while fetching data

        // Fetch evaluations via AJAX
        fetch('../../includes/career_progress_tracking/teaching/fetch_evaluations.php', { method: 'POST' })
        .then(response => {
            if (!response.ok) throw new Error('Failed to fetch evaluations');
            return response.json();
        })
        .then(data => {
            if (data.length > 0) {
                modalBody.innerHTML = data.map(evalItem => {
                    const createdDate = new Date(evalItem.created_at);
                    const options = { year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric' };
                    const formattedDate = createdDate.toLocaleDateString(undefined, options);
                    const evaluationNumber = `Evaluation #: ${evalItem.request_id}`;

                    return `
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="evaluation" id="eval-${evalItem.request_id}" value="${evalItem.request_id}">
                            <label class="form-check-label" for="eval-${evalItem.request_id}">
                                ${evaluationNumber} (Created: ${formattedDate})
                            </label>
                        </div>`;
                }).join('');
            } else {
                modalBody.innerHTML = '<p>No evaluations found.</p><p>Click <a href="career_progress_request.php">HERE</a> to create a new one.</p>';
            }
        })
        .catch(err => {
            console.error(err);
            modalBody.innerHTML = '<p>Error loading evaluations. Please try again later.</p>';
        });
    });

    // Modal button handler for selecting evaluation number
    document.getElementById('confirm-selection').addEventListener('click', function () {
        const selectedEvaluation = document.querySelector('input[name="evaluation"]:checked');
        if (selectedEvaluation) {
            const requestId = selectedEvaluation.value;

            // Update the header
            document.getElementById('evaluation-number').textContent = `Evaluation #: ${requestId}`;

            // Set the input field value
            const requestIdInput = document.getElementById('request_id');
            if (requestIdInput) {
                requestIdInput.value = requestId;
                console.log('request_id set to:', requestId);
            } else {
                console.error('Input field with id "request_id" not found.');
            }

            // Fetch data for the selected evaluation by calling Criterion A's fetch function
            if (typeof fetchCriterionA === 'function') {
                fetchCriterionA(requestId);
            } else {
                console.error('fetchCriterionA function is not defined.');
            }

            // Hide the modal
            const evaluationModal = bootstrap.Modal.getInstance(document.getElementById('evaluationModal'));
            evaluationModal.hide();
            

        } else {
            // Show error modal instead of alert
            const errorModal = new bootstrap.Modal(document.getElementById('saveErrorModal'));
            document.getElementById('saveErrorModalLabel').textContent = 'Selection Failed';
            document.querySelector('#saveErrorModal .modal-body').textContent = 'Please select an evaluation.';
            errorModal.show();
        }
    });

    // Visualization: Doughnut Chart for Overall Performance (Optional)
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

    // JavaScript for tabs styling
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