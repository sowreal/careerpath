document.addEventListener('DOMContentLoaded', function () {
    // Evaluation Selection Handler
    document.getElementById('select-evaluation-btn').addEventListener('click', function () {
        const modalBody = document.querySelector('#evaluationModal .modal-body');
        modalBody.innerHTML = '<p>Loading evaluations...</p>';

        fetch('../../includes/career_progress_tracking/research/fetch_evaluations.php', { method: 'POST' })
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

            document.getElementById('evaluation-number').textContent = `Evaluation #: ${requestId}`;
            document.getElementById('request_id').value = requestId;
            document.getElementById('request_id_b').value = requestId;
            document.getElementById('request_id_c').value = requestId;

            if (window.CriterionA && typeof CriterionA.fetchCriterionA === 'function') {
                CriterionA.fetchCriterionA(requestId);
            } else {
                console.error('CriterionA.fetchCriterionA function is not defined.');
            }

            // Hide the modal
            const evaluationModal = bootstrap.Modal.getInstance(document.getElementById('evaluationModal'));
            evaluationModal.hide();
        } else {
            // Show error modal
            const errorModal = new bootstrap.Modal(document.getElementById('saveErrorModal'));
            document.getElementById('saveErrorModalLabel').textContent = 'Selection Failed';
            document.querySelector('#saveErrorModal .modal-body').textContent = 'Please select an evaluation.';
            errorModal.show();
        }
    });

    // JavaScript for tabs styling
    const tabs2 = document.querySelectorAll('#kra-2-tabs .nav-link');
    if (tabs2.length > 0) {
        tabs2.forEach(tab => {
            tab.addEventListener('click', function () {
                tabs2.forEach(t => t.classList.remove('bg-success', 'text-white'));
                console.log('Tab clicked:', this.id);
                this.classList.add('bg-success', 'text-white');
            });
        });
    }

    // Ensures Only One Modal is Open at a Time
    function showModal(modalId) {
        const currentlyOpenModals = document.querySelectorAll('.modal.show');
        currentlyOpenModals.forEach(modal => {
            const modalInstance = bootstrap.Modal.getInstance(modal);
            if (modalInstance) {
                modalInstance.hide();
            }
        });
        
        const modalElement = document.getElementById(modalId);
        if (modalElement) {
            const modalInstance = new bootstrap.Modal(modalElement);
            modalInstance.show();
        } else {
            console.error(`Modal with ID "${modalId}" not found.`);
        }
    }
});