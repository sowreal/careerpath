// /php/includes/career_progress_tracking/teaching/js/criterion_b.js

document.addEventListener('DOMContentLoaded', function () {
    // Save Criterion B Handler
    document.getElementById('save-criterion-b').addEventListener('click', function () {
        const form = document.getElementById('criterion-b-form');
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }

        calculateTotals();

        const requestId = document.getElementById('request_id').value;

        // Gather Sole Authorship Entries
        const soleAuthorship = [];
        const soleRows = document.querySelectorAll('#sole-authorship-table tbody tr');
        soleRows.forEach(row => {
            const entry_id = row.getAttribute('data-entry-id') || 0;
            soleAuthorship.push({
                entry_id,
                title: row.querySelector('input[name="sole_title[]"]').value,
                type: row.querySelector('select[name="sole_type[]"]').value,
                reviewer: row.querySelector('input[name="sole_reviewer[]"]').value,
                date_published: row.querySelector('input[name="sole_date_published[]"]').value,
                date_approved: row.querySelector('input[name="sole_date_approved[]"]').value,
                faculty_score: parseFloat(row.querySelector('input[name="sole_faculty_score[]"]').value) || 0,
                evidence_link: row.querySelector('input[name="sole_evidence_link[]"]').value
            });
        });

        // Gather Co-Authorship Entries
        const coAuthorship = [];
        const coRows = document.querySelectorAll('#co-authorship-table tbody tr');
        coRows.forEach(row => {
            const entry_id = row.getAttribute('data-entry-id') || 0;
            coAuthorship.push({
                entry_id,
                title: row.querySelector('input[name="co_title[]"]').value,
                type: row.querySelector('select[name="co_type[]"]').value,
                reviewer: row.querySelector('input[name="co_reviewer[]"]').value,
                date_published: row.querySelector('input[name="co_date_published[]"]').value,
                date_approved: row.querySelector('input[name="co_date_approved[]"]').value,
                contribution_percentage: parseFloat(row.querySelector('input[name="co_contribution[]"]').value) || 0,
                faculty_score: parseFloat(row.querySelector('input[name="co_faculty_score[]"]').value) || 0,
                evidence_link: row.querySelector('input[name="co_evidence_link[]"]').value
            });
        });

        // Gather Academic Programs Entries
        const academicPrograms = [];
        const programRows = document.querySelectorAll('#academic-programs-table tbody tr');
        programRows.forEach(row => {
            const entry_id = row.getAttribute('data-entry-id') || 0;
            academicPrograms.push({
                entry_id,
                program_name: row.querySelector('input[name="program_name[]"]').value,
                program_type: row.querySelector('select[name="program_type[]"]').value,
                board_approval: row.querySelector('input[name="program_approval[]"]').value,
                year_implemented: row.querySelector('select[name="program_year[]"]').value,
                role: row.querySelector('select[name="program_role[]"]').value,
                faculty_score: parseFloat(row.querySelector('input[name="program_faculty_score[]"]').value) || 0,
                evidence_link: row.querySelector('input[name="program_evidence_link[]"]').value
            });
        });

        const payload = {
            request_id: parseInt(requestId),
            sole_authorship: soleAuthorship,
            co_authorship: coAuthorship,
            academic_programs: academicPrograms
        };

        console.log('Payload:', payload); // Debugging

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

    // Calculate Totals for Criterion B
    function calculateTotals() {
        // Sole Authorship Total
        let soleTotal = 0;
        document.querySelectorAll('input[name="sole_faculty_score[]"]').forEach(input => {
            soleTotal += parseFloat(input.value) || 0;
        });
        document.getElementById('sole-authorship-total').value = soleTotal.toFixed(2);

        // Co-Authorship Total
        let coTotal = 0;
        document.querySelectorAll('input[name="co_faculty_score[]"]').forEach(input => {
            coTotal += parseFloat(input.value) || 0;
        });
        document.getElementById('co-authorship-total').value = coTotal.toFixed(2);

        // Academic Programs Total
        let programTotal = 0;
        document.querySelectorAll('input[name="program_faculty_score[]"]').forEach(input => {
            programTotal += parseFloat(input.value) || 0;
        });
        document.getElementById('academic-programs-total').value = programTotal.toFixed(2);

        // Overall Total (Optional if needed)
        // const overallTotal = soleTotal + coTotal + programTotal;
        // document.getElementById('overall-total').value = overallTotal.toFixed(2);
    }

    // Recalculate totals when any faculty score input changes
    document.addEventListener('input', function (e) {
        if (e.target.matches('input[name="sole_faculty_score[]"], input[name="co_faculty_score[]"], input[name="program_faculty_score[]"]')) {
            calculateTotals();
        }
    });

    // Add Row Functionality
    document.querySelectorAll('.add-row').forEach(button => {
        button.addEventListener('click', function () {
            const tableId = this.getAttribute('data-table-id');
            const tableBody = document.querySelector(`#${tableId} tbody`);
            const newRow = document.createElement('tr');
            newRow.setAttribute('data-entry-id', '0'); // New rows have entry_id = 0

            if (tableId === 'sole-authorship-table') {
                newRow.innerHTML = `
                    <td></td>
                    <td><input type="text" class="form-control" name="sole_title[]" required></td>
                    <td>
                        <select class="form-select" name="sole_type[]" required>
                            <option value="">SELECT OPTION</option>
                            <option value="Textbook">Textbook</option>
                            <option value="Textbook Chapter">Textbook Chapter</option>
                            <option value="Manual/Module">Manual/Module</option>
                            <option value="Multimedia Teaching Material">Multimedia Teaching Material</option>
                            <option value="Testing Material">Testing Material</option>
                        </select>
                    </td>
                    <td><input type="text" class="form-control" name="sole_reviewer[]" required></td>
                    <td><input type="date" class="form-control" name="sole_date_published[]" required></td>
                    <td><input type="date" class="form-control" name="sole_date_approved[]" required></td>
                    <td><input type="number" class="form-control" name="sole_faculty_score[]" step="0.01" min="0" required></td>
                    <td><input type="url" class="form-control" name="sole_evidence_link[]" placeholder="http://example.com/evidence" required></td>
                    <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                `;
            } else if (tableId === 'co-authorship-table') {
                newRow.innerHTML = `
                    <td></td>
                    <td><input type="text" class="form-control" name="co_title[]" required></td>
                    <td>
                        <select class="form-select" name="co_type[]" required>
                            <option value="">SELECT OPTION</option>
                            <option value="Textbook">Textbook</option>
                            <option value="Textbook Chapter">Textbook Chapter</option>
                            <option value="Manual/Module">Manual/Module</option>
                            <option value="Multimedia Teaching Material">Multimedia Teaching Material</option>
                            <option value="Testing Material">Testing Material</option>
                        </select>
                    </td>
                    <td><input type="text" class="form-control" name="co_reviewer[]" required></td>
                    <td><input type="date" class="form-control" name="co_date_published[]" required></td>
                    <td><input type="date" class="form-control" name="co_date_approved[]" required></td>
                    <td><input type="number" class="form-control" name="co_contribution[]" step="0.01" min="0" max="100" required></td>
                    <td><input type="number" class="form-control" name="co_faculty_score[]" step="0.01" min="0" required></td>
                    <td><input type="url" class="form-control" name="co_evidence_link[]" placeholder="http://example.com/evidence" required></td>
                    <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                `;
            } else if (tableId === 'academic-programs-table') {
                newRow.innerHTML = `
                    <td></td>
                    <td><input type="text" class="form-control" name="program_name[]" required></td>
                    <td>
                        <select class="form-select" name="program_type[]" required>
                            <option value="">SELECT OPTION</option>
                            <option value="New Program">New Program</option>
                            <option value="Revised Program">Revised Program</option>
                        </select>
                    </td>
                    <td><input type="text" class="form-control" name="program_approval[]" required></td>
                    <td>
                        <select class="form-select" name="program_year[]" required>
                            <option value="">SELECT OPTION</option>
                            <option value="2019-2020">2019-2020</option>
                            <option value="2020-2021">2020-2021</option>
                            <option value="2021-2022">2021-2022</option>
                            <option value="2022-2023">2022-2023</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-select" name="program_role[]" required>
                            <option value="">SELECT OPTION</option>
                            <option value="Lead">Lead</option>
                            <option value="Contributor">Contributor</option>
                        </select>
                    </td>
                    <td><input type="number" class="form-control" name="program_faculty_score[]" step="0.01" min="0" required></td>
                    <td><input type="url" class="form-control" name="program_evidence_link[]" placeholder="http://example.com/evidence" required></td>
                    <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                `;
            }

            tableBody.appendChild(newRow);
            updateRowNumbers(tableId);
            calculateTotals();
        });
    });

    // Delete Row Functionality
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('delete-row')) {
            const row = e.target.closest('tr');
            const entryId = row.getAttribute('data-entry-id') || '0';

            if (entryId !== '0') {
                // Send delete request to server
                const tableType = getTableTypeFromRow(row);
                const payload = {
                    entry_id: entryId,
                    table: tableType
                };

                fetch('../../includes/career_progress_tracking/teaching/delete_criterion_b.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            row.remove();
                            updateRowNumbers(getTableIdFromRow(row));
                            calculateTotals();
                        } else {
                            alert(data.error || 'Failed to delete entry.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An unexpected error occurred.');
                    });
            } else {
                // Simply remove the row
                row.remove();
                updateRowNumbers(getTableIdFromRow(row));
                calculateTotals();
            }
        }
    });

    // Helper Functions
    function updateRowNumbers(tableId) {
        const rows = document.querySelectorAll(`#${tableId} tbody tr`);
        rows.forEach((row, index) => {
            row.querySelector('td:first-child').textContent = index + 1;
        });
    }

    function getTableTypeFromRow(row) {
        const tableId = getTableIdFromRow(row);
        if (tableId === 'sole-authorship-table') return 'sole_authorship';
        if (tableId === 'co-authorship-table') return 'co_authorship';
        if (tableId === 'academic-programs-table') return 'academic_programs';
        return '';
    }

    function getTableIdFromRow(row) {
        return row.closest('table').id;
    }

    // Initial calculation on page load
    calculateTotals();

    // Expose fetchCriterionB and populateForm to global scope
    window.fetchCriterionB = function (requestId) {
        fetch(`../../includes/career_progress_tracking/teaching/fetch_criterion_b.php?request_id=${requestId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    populateForm(data);
                } else {
                    console.error(data.error || 'Failed to fetch Criterion B data.');
                }
            })
            .catch(error => console.error('Error fetching Criterion B:', error));
    };

    function populateForm(data) {
        // Populate Sole Authorship
        if (data.sole_authorship) {
            const soleTableBody = document.querySelector('#sole-authorship-table tbody');
            soleTableBody.innerHTML = ''; // Clear existing rows
            data.sole_authorship.forEach((entry, index) => {
                const row = document.createElement('tr');
                row.setAttribute('data-entry-id', entry.entry_id);
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td><input type="text" class="form-control" name="sole_title[]" value="${escapeHTML(entry.title)}" required></td>
                    <td>
                        <select class="form-select" name="sole_type[]" required>
                            ${getIMTypeOptions(entry.type)}
                        </select>
                    </td>
                    <td><input type="text" class="form-control" name="sole_reviewer[]" value="${escapeHTML(entry.reviewer)}" required></td>
                    <td><input type="date" class="form-control" name="sole_date_published[]" value="${entry.date_published}" required></td>
                    <td><input type="date" class="form-control" name="sole_date_approved[]" value="${entry.date_approved}" required></td>
                    <td><input type="number" class="form-control" name="sole_faculty_score[]" value="${entry.faculty_score}" step="0.01" min="0" required></td>
                    <td><input type="url" class="form-control" name="sole_evidence_link[]" value="${escapeHTML(entry.evidence_link)}" required></td>
                    <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                `;
                soleTableBody.appendChild(row);
            });
        }

        // Populate Co-Authorship
        if (data.co_authorship) {
            const coTableBody = document.querySelector('#co-authorship-table tbody');
            coTableBody.innerHTML = ''; // Clear existing rows
            data.co_authorship.forEach((entry, index) => {
                const row = document.createElement('tr');
                row.setAttribute('data-entry-id', entry.entry_id);
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td><input type="text" class="form-control" name="co_title[]" value="${escapeHTML(entry.title)}" required></td>
                    <td>
                        <select class="form-select" name="co_type[]" required>
                            ${getIMTypeOptions(entry.type)}
                        </select>
                    </td>
                    <td><input type="text" class="form-control" name="co_reviewer[]" value="${escapeHTML(entry.reviewer)}" required></td>
                    <td><input type="date" class="form-control" name="co_date_published[]" value="${entry.date_published}" required></td>
                    <td><input type="date" class="form-control" name="co_date_approved[]" value="${entry.date_approved}" required></td>
                    <td><input type="number" class="form-control" name="co_contribution[]" value="${entry.contribution_percentage}" step="0.01" min="0" max="100" required></td>
                    <td><input type="number" class="form-control" name="co_faculty_score[]" value="${entry.faculty_score}" step="0.01" min="0" required></td>
                    <td><input type="url" class="form-control" name="co_evidence_link[]" value="${escapeHTML(entry.evidence_link)}" required></td>
                    <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                `;
                coTableBody.appendChild(row);
            });
        }

        // Populate Academic Programs
        if (data.academic_programs) {
            const programTableBody = document.querySelector('#academic-programs-table tbody');
            programTableBody.innerHTML = ''; // Clear existing rows
            data.academic_programs.forEach((entry, index) => {
                const row = document.createElement('tr');
                row.setAttribute('data-entry-id', entry.entry_id);
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td><input type="text" class="form-control" name="program_name[]" value="${escapeHTML(entry.program_name)}" required></td>
                    <td>
                        <select class="form-select" name="program_type[]" required>
                            ${getProgramTypeOptions(entry.program_type)}
                        </select>
                    </td>
                    <td><input type="text" class="form-control" name="program_approval[]" value="${escapeHTML(entry.board_approval)}" required></td>
                    <td>
                        <select class="form-select" name="program_year[]" required>
                            ${getProgramYearOptions(entry.year_implemented)}
                        </select>
                    </td>
                    <td>
                        <select class="form-select" name="program_role[]" required>
                            ${getProgramRoleOptions(entry.role)}
                        </select>
                    </td>
                    <td><input type="number" class="form-control" name="program_faculty_score[]" value="${entry.faculty_score}" step="0.01" min="0" required></td>
                    <td><input type="url" class="form-control" name="program_evidence_link[]" value="${escapeHTML(entry.evidence_link)}" required></td>
                    <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                `;
                programTableBody.appendChild(row);
            });
        }

        calculateTotals();
    }

    // Helper functions to generate select options
    function getIMTypeOptions(selectedValue) {
        const options = [
            'Textbook',
            'Textbook Chapter',
            'Manual/Module',
            'Multimedia Teaching Material',
            'Testing Material'
        ];
        return options.map(option => `<option value="${option}" ${option === selectedValue ? 'selected' : ''}>${option}</option>`).join('');
    }

    function getProgramTypeOptions(selectedValue) {
        const options = ['New Program', 'Revised Program'];
        return options.map(option => `<option value="${option}" ${option === selectedValue ? 'selected' : ''}>${option}</option>`).join('');
    }

    function getProgramYearOptions(selectedValue) {
        const options = ['2019-2020', '2020-2021', '2021-2022', '2022-2023'];
        return options.map(option => `<option value="${option}" ${option === selectedValue ? 'selected' : ''}>${option}</option>`).join('');
    }

    function getProgramRoleOptions(selectedValue) {
        const options = ['Lead', 'Contributor'];
        return options.map(option => `<option value="${option}" ${option === selectedValue ? 'selected' : ''}>${option}</option>`).join('');
    }

    // Escape HTML to prevent XSS
    function escapeHTML(str) {
        if (!str) return '';
        return str.replace(/&/g, "&amp;")
                  .replace(/</g, "&lt;")
                  .replace(/>/g, "&gt;")
                  .replace(/"/g, "&quot;")
                  .replace(/'/g, "&#039;");
    }
});
