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
                modalBody.innerHTML = data.map(eval => {
                    const createdDate = new Date(eval.created_at);
                    const options = { year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric' };
                    const formattedDate = createdDate.toLocaleDateString(undefined, options);
                    const evaluationNumber = `Evaluation #:${eval.request_id}`;

                    return `
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="evaluation" id="eval-${eval.request_id}" value="${eval.request_id}">
                            <label class="form-check-label" for="eval-${eval.request_id}">
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

            // Store request_id and enable fields
            document.getElementById('hidden-request-id').value = requestId;
            enableFields();

            // Fetch data for the selected evaluation
            fetchEvaluationData(requestId);

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

    // Generic Fetch Evaluation Data Function (if needed later)
    function fetchEvaluationData(requestId) {
        fetch(`../../includes/career_progress_tracking/teaching/fetch_criterion_data.php?request_id=${requestId}`)
            .then(response => response.text())
            .then(text => {
                console.log('Response text:', text);
                try {
                    const data = JSON.parse(text);
                    console.log('Parsed data:', data);
                    if (data.success) {
                        populateFields(data.criterion_data);
                    } else {
                        console.log('No data found for this evaluation. Ready for new entries.');
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                }
            })
            .catch(err => console.error('Error fetching data:', err));
    }

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

    function ajaxPost(url, data) {
        return $.ajax({
            type: 'POST',
            url: url,
            data: data,
            dataType: 'json'
        });
    }
    
    function ajaxGet(url, params) {
        return $.ajax({
            type: 'GET',
            url: url,
            data: params,
            dataType: 'json'
        });
    }
});
