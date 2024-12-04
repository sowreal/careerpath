// /php/includes/career_progress_tracking/teaching/js/criterion_a.js

document.addEventListener('DOMContentLoaded', function () {
    // Save Criterion A Handler
    document.getElementById('save-criterion-a').addEventListener('click', function () {
        const form = document.getElementById('criterion-a-form');
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }

        calculateOverallScores();

        const requestId = document.getElementById('request_id').value;

        // Gather Student Evaluations
        const studentEvaluations = [];
        const studentRows = document.querySelectorAll('#student-evaluation-table tbody tr');
        studentRows.forEach(row => {
            const evaluation_id = row.getAttribute('data-evaluation-id') || 0;
            const evaluation_period = row.querySelector('input[name="student_evaluation_period[]"]').value;
            const rating1Input = row.querySelector('input[name="student_rating_1[]"]');
            const rating2Input = row.querySelector('input[name="student_rating_2[]"]');
            const evidence_link_first = row.querySelector('input[name="student_evidence_link[]"]').value;
            const evidence_link_second = evidence_link_first; // Assuming same link for both semesters
            const remarks_first = ''; // Handle as needed
            const remarks_second = ''; // Handle as needed
            const overall_average_rating = parseFloat(document.getElementById('student_overall_score').value) || 0;
            const faculty_rating = parseFloat(document.getElementById('student_faculty_overall_score').value) || 0;

            studentEvaluations.push({
                evaluation_id,
                evaluation_period,
                first_semester_rating: parseFloat(rating1Input.value) || 0,
                second_semester_rating: parseFloat(rating2Input.value) || 0,
                evidence_link_first,
                evidence_link_second,
                remarks_first,
                remarks_second,
                overall_average_rating,
                faculty_rating
            });
        });

        // Gather Supervisor Evaluations
        const supervisorEvaluations = [];
        const supervisorRows = document.querySelectorAll('#supervisor-evaluation-table tbody tr');
        supervisorRows.forEach(row => {
            const evaluation_id = row.getAttribute('data-evaluation-id') || 0;
            const evaluation_period = row.querySelector('input[name="supervisor_evaluation_period[]"]').value;
            const rating1Input = row.querySelector('input[name="supervisor_rating_1[]"]');
            const rating2Input = row.querySelector('input[name="supervisor_rating_2[]"]');
            const evidence_link_first = row.querySelector('input[name="supervisor_evidence_link[]"]').value;
            const evidence_link_second = evidence_link_first; // Assuming same link for both semesters
            const remarks_first = ''; // Handle as needed
            const remarks_second = ''; // Handle as needed
            const overall_average_rating = parseFloat(document.getElementById('supervisor-overall-score').value) || 0;
            const faculty_rating = parseFloat(document.getElementById('supervisor-faculty-overall-score').value) || 0;

            supervisorEvaluations.push({
                evaluation_id,
                evaluation_period,
                first_semester_rating: parseFloat(rating1Input.value) || 0,
                second_semester_rating: parseFloat(rating2Input.value) || 0,
                evidence_link_first,
                evidence_link_second,
                remarks_first,
                remarks_second,
                overall_average_rating,
                faculty_rating
            });
        });

        const payload = {
            request_id: parseInt(requestId),
            student_divisor: parseInt(document.getElementById('student-divisor').value),
            student_reason: document.getElementById('student-reason').value,
            student_evidence_link: document.getElementById('student-evidence-link').value,
            supervisor_divisor: parseInt(document.getElementById('supervisor-divisor').value),
            supervisor_reason: document.getElementById('supervisor-reason').value,
            supervisor_evidence_link: document.getElementById('supervisor-evidence-link').value,
            student_evaluations: studentEvaluations,
            supervisor_evaluations: supervisorEvaluations
        };

        console.log('Payload:', payload); // Debugging

        fetch('../../includes/career_progress_tracking/teaching/save_criterion_a.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const saveModal = new bootstrap.Modal(document.getElementById('saveConfirmationModal'));
                saveModal.show();
            } else {
                const errorModal = new bootstrap.Modal(document.getElementById('saveErrorModal'));
                document.querySelector('#saveErrorModal .modal-body').textContent = data.error || 'An error occurred.';
                errorModal.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const errorModal = new bootstrap.Modal(document.getElementById('saveErrorModal'));
            document.querySelector('#saveErrorModal .modal-body').textContent = 'Failed to save data.';
            errorModal.show();
        });
    });

});
