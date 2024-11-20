document.addEventListener('DOMContentLoaded', function () {
    
    // For selecting evaluation numbers
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
                    // Format the creation date
                    const createdDate = new Date(eval.created_at);
                    const options = { year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric' };
                    const formattedDate = createdDate.toLocaleDateString(undefined, options);
        
                    // Create the evaluation number in the format Eval-<request_id>
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
                modalBody.innerHTML = '<p>No evaluations found.</p>';
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

    // Enable all input fields in Criterion tabs
    function enableFields() {
        document.querySelectorAll('.criterion-tab input, .criterion-tab textarea, .criterion-tab select')
            .forEach(field => field.disabled = false);
    }
    
    // Fetch data when an evaluation is selected.
    function fetchEvaluationData(requestId) {
        fetch(`php/fetch_criterion_data.php?request_id=${requestId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Populate the fields in Criterion tabs with fetched data
                populateFields(data.criterion_data);
            } else {
                console.log('No data found for this evaluation. Ready for new entries.');
            }
        })
        .catch(err => console.error('Error fetching data:', err));
    }

    // Populate Criterion A tables if data exists
    function populateFields(data) {
        // Clear existing rows in the tables
        clearTables();

        // Populate student evaluations
        const studentEvaluations = data.student_evaluations;
        const studentTableBody = document.querySelector('#student-evaluation-table tbody');

        studentEvaluations.forEach(eval => {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>
                    <input type="text" class="form-control" name="evaluation_period[]" value="${eval.evaluation_period}" readonly>
                </td>
                <td>
                    <input type="number" class="form-control rating-input" name="student_rating_1[]" value="${eval.overall_average_rating}" step="0.01" min="0" max="5" required>
                </td>
                <td>
                    <input type="number" class="form-control rating-input" name="student_rating_2[]" value="${eval.overall_average_rating}" step="0.01" min="0" max="5" required>
                </td>
                <td>
                    <input type="url" class="form-control" name="student_evidence_link[]" value="${eval.evidence_link_first_semester}" pattern="https?://.+" required>
                </td>
                <td>
                    <input type="text" class="form-control" name="student_remarks[]" value="${eval.remarks_first_semester}">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button>
                </td>
            `;
            studentTableBody.appendChild(newRow);
        });

        // Populate supervisor evaluations
        const supervisorEvaluations = data.supervisor_evaluations;
        const supervisorTableBody = document.querySelector('#supervisor-evaluation-table tbody');

        supervisorEvaluations.forEach(eval => {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>
                    <input type="text" class="form-control" name="supervisor_evaluation_period[]" value="${eval.evaluation_period}" readonly>
                </td>
                <td>
                    <input type="number" class="form-control rating-input" name="supervisor_rating_1[]" value="${eval.overall_average_rating}" step="0.01" min="0" max="5" required>
                </td>
                <td>
                    <input type="number" class="form-control rating-input" name="supervisor_rating_2[]" value="${eval.overall_average_rating}" step="0.01" min="0" max="5" required>
                </td>
                <td>
                    <input type="url" class="form-control" name="supervisor_evidence_link[]" value="${eval.evidence_link_first_semester}" pattern="https?://.+" required>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button>
                </td>
            `;
            supervisorTableBody.appendChild(newRow);
        });

        // Recalculate scores
        calculateOverallScores();
    }

    function clearTables() {
        document.querySelector('#student-evaluation-table tbody').innerHTML = '';
        document.querySelector('#supervisor-evaluation-table tbody').innerHTML = '';
    }
    

    
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
