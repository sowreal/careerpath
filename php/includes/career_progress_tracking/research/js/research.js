// php/includes/career_progress_tracking/research/js/research.js
document.addEventListener('DOMContentLoaded', function () {
    // --- Evaluation Selection Handler ---
    document.getElementById('select-evaluation-btn').addEventListener('click', function () {
        const modalBody = document.querySelector('#evaluationModal .modal-body');
        modalBody.innerHTML = '<p>Loading evaluations...</p>'; // Show loading message

        // Fetch evaluations via AJAX
        fetch('../../includes/career_progress_tracking/research/fetch_kra2_evaluations.php', { method: 'POST' })
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
                            <input class="form-check-input" type="radio" name="evaluation-research" id="eval-research-${evalItem.request_id}" value="${evalItem.request_id}">
                            <label class="form-check-label" for="eval-research-${evalItem.request_id}">
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

    // --- Modal Button Handler for Selecting Evaluation Number ---
    document.getElementById('confirm-selection-research').addEventListener('click', function () {
        const selectedEvaluation = document.querySelector('input[name="evaluation-research"]:checked');
        if (selectedEvaluation) {
            const requestId = selectedEvaluation.value;

            // Update the header
            document.getElementById('evaluation-number-research').textContent = `Evaluation #: ${requestId}`;

            // Set the input field value for Criterion A
            const requestIdInput = document.getElementById('request_id');
            if (requestIdInput) {
                requestIdInput.value = requestId;
                console.log('request_id set to:', requestId);
            } else {
                console.error('Input field with id "request_id" not found.');
            }

            // Set the input field value for Criterion B
            // const requestIdInputB = document.getElementById('request_id_b');
            // if (requestIdInputB) {
            //     requestIdInputB.value = requestId;
            //     console.log('request_id_b set to:', requestId);
            // } else {
            //     console.error('Input field with id "request_id_b" not found.');
            // }

            // Set the input field value for Criterion C
            // const requestIdInputC = document.getElementById('request_id_c');
            // if (requestIdInputC) {
            //     requestIdInputC.value = requestId;
            //     console.log('request_id_c set to:', requestId);
            // } else {
            //     console.error('Input field with id "request_id_c" not found.');
            // }

            // Fetch data for the selected evaluation for Criterion A
            // if (window.KRA2CriterionA && typeof KRA2CriterionA.fetchCriterionA === 'function') {
            //     KRA2CriterionA.fetchCriterionA(requestId);
            // } else {
            //     console.error('KRA2CriterionA.fetchCriterionA function is not defined.');
            // }

            // Fetch data for the selected evaluation for Criterion B
            // if (window.KRA2CriterionB && typeof KRA2CriterionB.fetchCriterionB === 'function') {
            //     KRA2CriterionB.fetchCriterionB(requestId);
            // } else {
            //     console.error('KRA2CriterionB.fetchCriterionB function is not defined.');
            // }

            // Fetch data for the selected evaluation for Criterion C
            // if (window.KRA2CriterionC && typeof KRA2CriterionC.fetchCriterionC === 'function') {
            //     KRA2CriterionC.fetchCriterionC(requestId);
            // } else {
            //     console.error('KRA2CriterionC.fetchCriterionC function is not defined.');
            // }

            // Hide the modal
            const evaluationModal = bootstrap.Modal.getInstance(document.getElementById('evaluationModal'));
            evaluationModal.hide();
        } else {
            // Show error modal
            const errorModal = new bootstrap.Modal(document.getElementById('messageModal'));
            document.getElementById('messageModalLabel').textContent = 'Selection Failed';
            document.querySelector('#messageModal .modal-body').textContent = 'Please select an evaluation.';
            errorModal.show();
        }
    });
});