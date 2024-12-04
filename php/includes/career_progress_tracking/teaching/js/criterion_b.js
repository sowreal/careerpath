document.addEventListener('DOMContentLoaded', function () {
    // Save Criterion B Handler
    document.getElementById('save-criterion-b').addEventListener('click', function () {
        const form = document.getElementById('criterion-b-form');
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }

        // Perform any necessary calculations before saving
        updateSoleAuthorshipTotal();
        updateCoAuthorshipTotal();
        updateAcademicProgramsTotal();

        const requestId = document.getElementById('request_id').value;

        // Gather Sole Authorship Entries
        const soleAuthorship = [];
        const soleRows = document.querySelectorAll('#sole-authorship-table tbody tr');
        soleRows.forEach(row => {
            const entry_id = row.getAttribute('data-entry-id') || 0;
            const title = row.querySelector('input[name="sole_title[]"]').value;
            const type = row.querySelector('select[name="sole_type[]"]').value;
            const reviewer_repository = row.querySelector('input[name="sole_reviewer[]"]').value;
            const date_published = row.querySelector('input[name="sole_date_published[]"]').value;
            const date_approved = row.querySelector('input[name="sole_date_approved[]"]').value;
            const faculty_score = parseFloat(row.querySelector('input[name="sole_faculty_score[]"]').value) || 0;
            const evidence_link = row.querySelector('input[name="sole_evidence_link[]"]').value;

            soleAuthorship.push({
                entry_id: parseInt(entry_id),
                title,
                type,
                reviewer_repository,
                date_published,
                date_approved,
                faculty_score,
                evidence_link
            });
        });

        // Gather Co-Authorship Entries
        const coAuthorship = [];
        const coRows = document.querySelectorAll('#co-authorship-table tbody tr');
        coRows.forEach(row => {
            const entry_id = row.getAttribute('data-entry-id') || 0;
            const title = row.querySelector('input[name="co_title[]"]').value;
            const type = row.querySelector('select[name="co_type[]"]').value;
            const reviewer_repository = row.querySelector('input[name="co_reviewer[]"]').value;
            const date_published = row.querySelector('input[name="co_date_published[]"]').value;
            const date_approved = row.querySelector('input[name="co_date_approved[]"]').value;
            const contribution_percentage = parseFloat(row.querySelector('input[name="co_contribution[]"]').value) || 0;
            const faculty_score = parseFloat(row.querySelector('input[name="co_faculty_score[]"]').value) || 0;
            const evidence_link = row.querySelector('input[name="co_evidence_link[]"]').value;

            coAuthorship.push({
                entry_id: parseInt(entry_id),
                title,
                type,
                reviewer_repository,
                date_published,
                date_approved,
                contribution_percentage,
                faculty_score,
                evidence_link
            });
        });

        // Gather Academic Programs Entries
        const academicPrograms = [];
        const programRows = document.querySelectorAll('#academic-programs-table tbody tr');
        programRows.forEach(row => {
            const entry_id = row.getAttribute('data-entry-id') || 0;
            const program_name = row.querySelector('input[name="program_name[]"]').value;
            const program_type = row.querySelector('select[name="program_type[]"]').value;
            const board_approval = row.querySelector('input[name="program_approval[]"]').value;
            const year_implemented = row.querySelector('select[name="program_year[]"]').value;
            const role = row.querySelector('select[name="program_role[]"]').value;
            const faculty_score = parseFloat(row.querySelector('input[name="program_faculty_score[]"]').value) || 0;
            const evidence_link = row.querySelector('input[name="program_evidence_link[]"]').value;

            academicPrograms.push({
                entry_id: parseInt(entry_id),
                program_name,
                program_type,
                board_approval,
                year_implemented,
                role,
                faculty_score,
                evidence_link
            });
        });

        const payload = {
            request_id: parseInt(requestId),
            sole_authorship: soleAuthorship,
            co_authorship: coAuthorship,
            academic_programs: academicPrograms
        };

        console.log('Payload:', payload); // For debugging purposes

        fetch('../../includes/career_progress_tracking/teaching/save_criterion_b.php', {
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

    // Functions to update totals
    function updateSoleAuthorshipTotal() {
        let total = 0;
        document.querySelectorAll('input[name="sole_faculty_score[]"]').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById('sole-authorship-total').value = total.toFixed(2);
    }

    function updateCoAuthorshipTotal() {
        let total = 0;
        document.querySelectorAll('input[name="co_faculty_score[]"]').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById('co-authorship-total').value = total.toFixed(2);
    }

    function updateAcademicProgramsTotal() {
        let total = 0;
        document.querySelectorAll('input[name="program_faculty_score[]"]').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById('academic-programs-total').value = total.toFixed(2);
    }

    // Event listeners for calculating totals when inputs change
    document.querySelectorAll('input[name="sole_faculty_score[]"]').forEach(input => {
        input.addEventListener('input', updateSoleAuthorshipTotal);
    });

    document.querySelectorAll('input[name="co_faculty_score[]"]').forEach(input => {
        input.addEventListener('input', updateCoAuthorshipTotal);
    });

    document.querySelectorAll('input[name="program_faculty_score[]"]').forEach(input => {
        input.addEventListener('input', updateAcademicProgramsTotal);
    });

    // Initial calculation
    updateSoleAuthorshipTotal();
    updateCoAuthorshipTotal();
    updateAcademicProgramsTotal();

    // Add Row functionality
    document.querySelectorAll('.add-row').forEach(button => {
        button.addEventListener('click', function () {
            const tableId = this.getAttribute('data-table-id');
            const tableBody = document.querySelector(`#${tableId} tbody`);
            const newRow = tableBody.querySelector('tr').cloneNode(true);

            // Clear input values in the new row
            newRow.querySelectorAll('input, select').forEach(input => {
                if (input.tagName.toLowerCase() === 'select') {
                    input.selectedIndex = 0;
                } else {
                    input.value = '';
                }
            });

            // Remove data-entry-id attribute for new entries
            newRow.removeAttribute('data-entry-id');

            // Append the new row
            tableBody.appendChild(newRow);

            // Re-attach event listeners for the new row
            newRow.querySelector('input[name="sole_faculty_score[]"]').addEventListener('input', updateSoleAuthorshipTotal);
            newRow.querySelector('input[name="co_faculty_score[]"]').addEventListener('input', updateCoAuthorshipTotal);
            newRow.querySelector('input[name="program_faculty_score[]"]').addEventListener('input', updateAcademicProgramsTotal);

            // Attach delete event listener to the delete button
            newRow.querySelector('.delete-row').addEventListener('click', function () {
                const row = this.closest('tr');
                row.remove();
                updateSoleAuthorshipTotal();
                updateCoAuthorshipTotal();
                updateAcademicProgramsTotal();
            });
        });
    });

    // Delete Row functionality
    document.querySelectorAll('.delete-row').forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            row.remove();
            updateSoleAuthorshipTotal();
            updateCoAuthorshipTotal();
            updateAcademicProgramsTotal();
        });
    });
});
