// php/includes/career_progress_tracking/research/js/research.js
document.addEventListener('DOMContentLoaded', function () {
    // --- Evaluation Selection Handler ---
    document.getElementById('select-evaluation-btn').addEventListener('click', function () {
        const modalBody = document.querySelector('#evaluationModal .modal-body');

        // Clear previous content and show loading message
        modalBody.innerHTML = '<p>Loading evaluations...</p>';

        // Fetch evaluations via AJAX
        fetch('../../includes/career_progress_tracking/research/kra2_fetch_evaluations.php', { method: 'POST' })
        .then(response => {
            if (!response.ok) throw new Error('Failed to fetch evaluations');
            return response.json();
        })
        .then(data => {
            if (data.length > 0) {
                // Dynamically create radio buttons for each evaluation
                modalBody.innerHTML = data.map(evalItem => {
                    const createdDate = new Date(evalItem.created_at);
                    const options = { year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric' };
                    const formattedDate = createdDate.toLocaleDateString(undefined, options);
                    const evaluationNumber = `Evaluation #: ${evalItem.request_id}`;

                    return `
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="evaluation-research" id="eval-research-${evalItem.request_id}" value="${evalItem.request_id}">
                            <label class="form-check-label" for="eval-research-${evalItem.request_id}">
                                ${evaluationNumber} (Created: ${formattedDate})
                            </label>
                        </div>`;
                }).join('');
            } else {
                // No evaluations found message with a link
                modalBody.innerHTML = '<p>No evaluations found.</p><p>Click <a href="career_progress_request.php">HERE</a> to create a new one.</p>';
            }
        })
        .catch(err => {
            console.error(err);
            modalBody.innerHTML = '<p>Error loading evaluations. Please try again later.</p>';
        });
    });

    // --- Modal Button Handler for Selecting Evaluation Number ---
    document.getElementById('confirm-selection-research').addEventListener('click', function() {
        const selectedEvaluation = document.querySelector('input[name="evaluation-research"]:checked');
        if (selectedEvaluation) {
            const requestId = selectedEvaluation.value;

            // Update the header 
            const evaluationNumberHeader = document.getElementById('evaluation-number'); 
            evaluationNumberHeader.innerHTML = `Evaluation #: ${requestId}`; 

            // Set the input field value for Criterion A
            const requestIdInput = document.getElementById('request_id');
            if (requestIdInput) {
                requestIdInput.value = requestId;
                console.log('request_id set to:', requestId);

                // Fetch data for Criterion A using the selected requestId
                if (window.CriterionA && typeof CriterionA.fetchCriterionA === 'function') {
                    CriterionA.fetchCriterionA(requestId);
                } else {
                    console.error('CriterionA.fetchCriterionA function is not defined.');
                }
            } else {
                console.error('Input field with id "request_id" not found.');
            }

            // Hide the modal
            const evaluationModal = bootstrap.Modal.getInstance(document.getElementById('evaluationModal'));
            evaluationModal.hide();

        } else {
            // Show error modal
            var messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
            document.getElementById('messageModalLabel').textContent = 'Selection Failed';
            document.querySelector('#messageModal .modal-body').textContent = 'Please select an evaluation.';
            messageModal.show();
        }
    });

    // JavaScript for tabs styling
    const tabs = document.querySelectorAll('#kra-tabs .nav-link');
    if (tabs.length > 0) {
        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                tabs.forEach(t => t.classList.remove('bg-success', 'text-white'));
                this.classList.add('bg-success', 'text-white');
            });
        });
    }
});