// Encapsulate Criterion B logic in a namespace to avoid conflicts.
(function (window, document, $) {
    'use strict';

    // Create a namespace object
    var CriterionB = {};

    // === HELPER FUNCTIONS ===
    function escapeHTML(str) {
        if (!str) return '';
        return str.replace(/&/g, "&amp;")
                  .replace(/</g, "&lt;")
                  .replace(/>/g, "&gt;")
                  .replace(/"/g, "&quot;")
                  .replace(/'/g, "&#039;");
    }

    // --- Table Population Functions ---
    function addDefaultSoleAuthorshipRows(tableBody) {
        const defaultCount = 3; // Criterion B starts with 3 rows
        const requestId = document.getElementById('request_id_b').value.trim(); 
        for (let i = 1; i <= defaultCount; i++) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${i}</td>
                <td><input type="text" class="form-control" name="kra1_b_sole_authorship[${i}][title]"></td>
                <td>
                    <select class="form-select" name="kra1_b_sole_authorship[${i}][type]">
                        <option value="">SELECT OPTION</option>
                        <option value="Textbook">Textbook</option>
                        <option value="Textbook Chapter">Textbook Chapter</option>
                        <option value="Manual/Module">Manual/Module</option>
                        <option value="Multimedia Teaching Material">Multimedia Teaching Material</option>
                        <option value="Testing Material">Testing Material</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra1_b_sole_authorship[${i}][reviewer]"></td>
                <td><input type="text" class="form-control" name="kra1_b_sole_authorship[${i}][publisher]"></td>
                <td><input type="date" class="form-control" name="kra1_b_sole_authorship[${i}][date_published]"></td>
                <td><input type="date" class="form-control" name="kra1_b_sole_authorship[${i}][date_approved]"></td>
                <td><input type="number" class="form-control score-input" name="kra1_b_sole_authorship[${i}][score]"></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="sole_authorship_${i}">Upload Evidence</button>
                    <input type="hidden" name="kra1_b_sole_authorship[${i}][evidence_file]" value="">
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                </td>
            `;
            tableBody.appendChild(row);
        }
    }

    function addDefaultCoAuthorshipRows(tableBody) {
        const defaultCount = 3; // Criterion B starts with 3 rows
        const requestId = document.getElementById('request_id_b').value.trim();
        for (let i = 1; i <= defaultCount; i++) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${i}</td>
                <td><input type="text" class="form-control" name="kra1_b_co_authorship[${i}][title]"></td>
                <td>
                    <select class="form-select" name="kra1_b_co_authorship[${i}][type]">
                        <option value="">SELECT OPTION</option>
                        <option value="Textbook">Textbook</option>
                        <option value="Textbook Chapter">Textbook Chapter</option>
                        <option value="Manual/Module">Manual/Module</option>
                        <option value="Multimedia Teaching Material">Multimedia Teaching Material</option>
                        <option value="Testing Material">Testing Material</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra1_b_co_authorship[${i}][reviewer]"></td>
                <td><input type="text" class="form-control" name="kra1_b_co_authorship[${i}][publisher]"></td>
                <td><input type="date" class="form-control" name="kra1_b_co_authorship[${i}][date_published]"></td>
                <td><input type="date" class="form-control" name="kra1_b_co_authorship[${i}][date_approved]"></td>
                <td><input type="number" step="0.01" class="form-control" name="kra1_b_co_authorship[${i}][contribution_percentage]"></td>
                <td><input type="number" class="form-control score-input" name="kra1_b_co_authorship[${i}][score]"></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="co_authorship_${i}">Upload Evidence</button>
                    <input type="hidden" name="kra1_b_co_authorship[${i}][evidence_file]" value="">
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                </td>
            `;
            tableBody.appendChild(row);
        }
    }

    function addDefaultAcademicProgramsRows(tableBody) {
        const defaultCount = 3; // Criterion B starts with 3 rows
        const requestId = document.getElementById('request_id_b').value.trim();
        const currentYear = new Date().getFullYear();
        for (let i = 1; i <= defaultCount; i++) {
            const row = document.createElement('tr');
            let yearOptions = '';
            for (let year = currentYear; year >= currentYear - 4; year--) {
                const yearRange = year + '-' + (year + 1);
                yearOptions += `<option value="${yearRange}">${yearRange}</option>`;
            }
            row.innerHTML = `
                <td>${i}</td>
                <td><input type="text" class="form-control" name="kra1_b_academic_programs[${i}][program_name]"></td>
                <td>
                    <select class="form-select" name="kra1_b_academic_programs[${i}][program_type]">
                        <option value="">SELECT OPTION</option>
                        <option value="New Program">New Program</option>
                        <option value="Revised Program">Revised Program</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra1_b_academic_programs[${i}][board_approval]"></td>
                <td>
                    <select class="form-select" name="kra1_b_academic_programs[${i}][academic_year]">
                        <option value="">SELECT OPTION</option>
                        ${yearOptions}
                    </select>
                </td>
                <td>
                    <select class="form-select" name="kra1_b_academic_programs[${i}][role]">
                        <option value="">SELECT OPTION</option>
                        <option value="Lead">Lead</option>
                        <option value="Contributor">Contributor</option>
                    </select>
                </td>
                <td><input type="number" class="form-control score-input" name="kra1_b_academic_programs[${i}][score]"></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="academic_programs_${i}">Upload Evidence</button>
                    <input type="hidden" name="kra1_b_academic_programs[${i}][evidence_file]" value="">
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                </td>
            `;
            tableBody.appendChild(row);
        }
    }

    function populateSoleAuthorshipTable(soleAuthorshipData) {
        const tableBody = document.querySelector('#sole-authorship-table tbody');
        const requestId = document.getElementById('request_id_b').value.trim();
        tableBody.innerHTML = '';

        if (!soleAuthorshipData || soleAuthorshipData.length === 0) {
            addDefaultSoleAuthorshipRows(tableBody);
            return;
        }
        soleAuthorshipData.forEach((item, index) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${index + 1}</td>
                <td><input type="text" class="form-control" name="kra1_b_sole_authorship[${index + 1}][title]" value="${escapeHTML(item.title || '')}"></td>
                <td>
                    <select class="form-select" name="kra1_b_sole_authorship[${index + 1}][type]">
                        <option value="">SELECT OPTION</option>
                        <option value="Textbook" ${item.type === 'Textbook' ? 'selected' : ''}>Textbook</option>
                        <option value="Textbook Chapter" ${item.type === 'Textbook Chapter' ? 'selected' : ''}>Textbook Chapter</option>
                        <option value="Manual/Module" ${item.type === 'Manual/Module' ? 'selected' : ''}>Manual/Module</option>
                        <option value="Multimedia Teaching Material" ${item.type === 'Multimedia Teaching Material' ? 'selected' : ''}>Multimedia Teaching Material</option>
                        <option value="Testing Material" ${item.type === 'Testing Material' ? 'selected' : ''}>Testing Material</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra1_b_sole_authorship[${index + 1}][reviewer]" value="${escapeHTML(item.reviewer || '')}"></td>
                <td><input type="text" class="form-control" name="kra1_b_sole_authorship[${index + 1}][publisher]" value="${escapeHTML(item.publisher || '')}"></td>
                <td><input type="date" class="form-control" name="kra1_b_sole_authorship[${index + 1}][date_published]" value="${item.date_published || ''}"></td>
                <td><input type="date" class="form-control" name="kra1_b_sole_authorship[${index + 1}][date_approved]" value="${item.date_approved || ''}"></td>
                <td><input type="number" class="form-control score-input" name="kra1_b_sole_authorship[${index + 1}][score]" value="${item.score || ''}"></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="sole_authorship_${index + 1}">
                        ${item.evidence_file ? 'Change Evidence' : 'Upload Evidence'}
                    </button>
                    <input type="hidden" name="kra1_b_sole_authorship[${index + 1}][evidence_file]" value="${item.evidence_file || ''}">
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                </td>
            `;
            tableBody.appendChild(tr);
        });
    }

    function populateCoAuthorshipTable(coAuthorshipData) {
        const tableBody = document.querySelector('#co-authorship-table tbody');
        const requestId = document.getElementById('request_id_b').value.trim();
        tableBody.innerHTML = '';

        if (!coAuthorshipData || coAuthorshipData.length === 0) {
            addDefaultCoAuthorshipRows(tableBody);
            return;
        }
        coAuthorshipData.forEach((item, index) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${index + 1}</td>
                <td><input type="text" class="form-control" name="kra1_b_co_authorship[${index + 1}][title]" value="${escapeHTML(item.title || '')}"></td>
                <td>
                    <select class="form-select" name="kra1_b_co_authorship[${index + 1}][type]">
                        <option value="">SELECT OPTION</option>
                        <option value="Textbook" ${item.type === 'Textbook' ? 'selected' : ''}>Textbook</option>
                        <option value="Textbook Chapter" ${item.type === 'Textbook Chapter' ? 'selected' : ''}>Textbook Chapter</option>
                        <option value="Manual/Module" ${item.type === 'Manual/Module' ? 'selected' : ''}>Manual/Module</option>
                        <option value="Multimedia Teaching Material" ${item.type === 'Multimedia Teaching Material' ? 'selected' : ''}>Multimedia Teaching Material</option>
                        <option value="Testing Material" ${item.type === 'Testing Material' ? 'selected' : ''}>Testing Material</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra1_b_co_authorship[${index + 1}][reviewer]" value="${escapeHTML(item.reviewer || '')}"></td>
                <td><input type="text" class="form-control" name="kra1_b_co_authorship[${index + 1}][publisher]" value="${escapeHTML(item.publisher || '')}"></td>
                <td><input type="date" class="form-control" name="kra1_b_co_authorship[${index + 1}][date_published]" value="${item.date_published || ''}"></td>
                <td><input type="date" class="form-control" name="kra1_b_co_authorship[${index + 1}][date_approved]" value="${item.date_approved || ''}"></td>
                <td><input type="number" step="0.01" class="form-control" name="kra1_b_co_authorship[${index + 1}][contribution_percentage]" value="${item.contribution_percentage || ''}"></td>
                <td><input type="number" class="form-control score-input" name="kra1_b_co_authorship[${index + 1}][score]" value="${item.score || ''}"></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="co_authorship_${index + 1}">
                        ${item.evidence_file ? 'Change Evidence' : 'Upload Evidence'}
                    </button>
                    <input type="hidden" name="kra1_b_co_authorship[${index + 1}][evidence_file]" value="${item.evidence_file || ''}">
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                </td>
            `;
            tableBody.appendChild(tr);
        });
    }

    function populateAcademicProgramsTable(academicProgramsData) {
        const tableBody = document.querySelector('#academic-programs-table tbody');
        const requestId = document.getElementById('request_id_b').value.trim();
        tableBody.innerHTML = '';

        if (!academicProgramsData || academicProgramsData.length === 0) {
            addDefaultAcademicProgramsRows(tableBody);
            return;
        }
        academicProgramsData.forEach((item, index) => {
            const tr = document.createElement('tr');
            const currentYear = new Date().getFullYear();
            let yearOptions = '';
            for (let year = currentYear; year >= currentYear - 4; year--) {
                const yearRange = year + '-' + (year + 1);
                yearOptions += `<option value="${yearRange}" ${item.academic_year === yearRange ? 'selected' : ''}>${yearRange}</option>`;
            }
            tr.innerHTML = `
                <td>${index + 1}</td>
                <td><input type="text" class="form-control" name="kra1_b_academic_programs[${index + 1}][program_name]" value="${escapeHTML(item.program_name || '')}"></td>
                <td>
                    <select class="form-select" name="kra1_b_academic_programs[${index + 1}][program_type]">
                        <option value="">SELECT OPTION</option>
                        <option value="New Program" ${item.program_type === 'New Program' ? 'selected' : ''}>New Program</option>
                        <option value="Revised Program" ${item.program_type === 'Revised Program' ? 'selected' : ''}>Revised Program</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra1_b_academic_programs[${index + 1}][board_approval]" value="${escapeHTML(item.board_approval || '')}"></td>
                <td>
                    <select class="form-select" name="kra1_b_academic_programs[${index + 1}][academic_year]">
                        <option value="">SELECT OPTION</option>
                        ${yearOptions}
                    </select>
                </td>
                <td>
                    <select class="form-select" name="kra1_b_academic_programs[${index + 1}][role]">
                        <option value="">SELECT OPTION</option>
                        <option value="Lead" ${item.role === 'Lead' ? 'selected' : ''}>Lead</option>
                        <option value="Contributor" ${item.role === 'Contributor' ? 'selected' : ''}>Contributor</option>
                    </select>
                </td>
                <td><input type="number" class="form-control score-input" name="kra1_b_academic_programs[${index + 1}][score]" value="${item.score || ''}"></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="academic_programs_${index + 1}">
                        ${item.evidence_file ? 'Change Evidence' : 'Upload Evidence'}
                    </button>
                    <input type="hidden" name="kra1_b_academic_programs[${index + 1}][evidence_file]" value="${item.evidence_file || ''}">
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                </td>
            `;
            tableBody.appendChild(tr);
        });
    }

    function populateMetadata(metadata) {
        if (!metadata) {
            // Reset to defaults if no metadata
            setElementValue('kra1_b_sole_authorship_total', 0);
            setElementValue('kra1_b_co_authorship_total', 0);
            setElementValue('kra1_b_academic_programs_total', 0);
            return;
        }
        // Populate metadata fields
        setElementValue('kra1_b_sole_authorship_total', metadata.sole_authorship_total || 0);
        setElementValue('kra1_b_co_authorship_total', metadata.co_authorship_total || 0);
        setElementValue('kra1_b_academic_programs_total', metadata.academic_programs_total || 0);
    }

    function setElementValue(elementId, value) {
        const element = document.getElementById(elementId);
        if (element) {
            element.value = value;
        } else {
            console.warn(`Element with ID '${elementId}' not found.`);
        }
    }

    // Expose a fetch function that teaching.js calls
    CriterionB.fetchCriterionB = function (requestId) {
        return fetch(`../../includes/career_progress_tracking/teaching/fetch_criterion_b.php?request_id=${requestId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    populateSoleAuthorshipTable(data.sole_authorship);
                    populateCoAuthorshipTable(data.co_authorship);
                    populateAcademicProgramsTable(data.academic_programs);
                    populateMetadata(data.metadata);
                } else {
                    console.error('Error:', data.error);
                    showMessage('Failed to fetch data: ' + data.error);
                    addDefaultSoleAuthorshipRows(document.querySelector('#sole-authorship-table tbody'));
                    addDefaultCoAuthorshipRows(document.querySelector('#co-authorship-table tbody'));
                    addDefaultAcademicProgramsRows(document.querySelector('#academic-programs-table tbody'));
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                showMessage('Failed to fetch data. Please check the console for details.');
                addDefaultSoleAuthorshipRows(document.querySelector('#sole-authorship-table tbody'));
                addDefaultCoAuthorshipRows(document.querySelector('#co-authorship-table tbody'));
                addDefaultAcademicProgramsRows(document.querySelector('#academic-programs-table tbody'));
            });
    };

// We'll set up everything on DOMContentLoaded within CriterionB.init
CriterionB.init = function() {
    const form = document.getElementById('criterion-b-form');
    const saveBtn = document.getElementById('save-criterion-b');
    const saveErrorModal = new bootstrap.Modal(document.getElementById('saveErrorModal'));
    const messageModal = new bootstrap.Modal(document.getElementById('messageModal')); // For displaying messages
    const uploadEvidenceModal = new bootstrap.Modal(document.getElementById('uploadEvidenceModal'));

    function showMessage(message) {
        $('#messageModalBody').text(message);
        messageModal.show();
    }
    window.showMessage = showMessage; // Make it accessible if needed by other scripts

    // === DELETION TRACKING AND DIRTY FLAG START ===
    let deletedRows = {
        sole_authorship: [],
        co_authorship: [],
        academic_programs: []
    };
    let isFormDirty = false;

    function markFormAsDirty() {
        isFormDirty = true;
        saveBtn.classList.add('btn-warning');
    }
    function markFormAsClean() {
        isFormDirty = false;
        saveBtn.classList.remove('btn-warning');
    }
    // === DELETION TRACKING AND DIRTY FLAG END ===

    // === UPLOAD EVIDENCE HANDLERS (Event Delegation) START ===
    $('#sole-authorship-table, #co-authorship-table, #academic-programs-table').on('click', '.upload-evidence-btn', function() {
        const button = $(this);
        const requestID = $('#request_id_b').val();
        const subcriterionId = button.data('subcriterion-id');
        const row = button.closest('tr');
        const tableId = row.closest('table').attr('id'); // Get the table ID dynamically
        const tableType = tableId.replace('-table', ''); // Extract the table type from the table ID

        // Determine row index based on the number of preceding <tr> elements
        const rowIndex = row.prevAll('tr').length + 1; // +1 because we want the ordinal number, not the zero-based index

        // Construct the input name based on the table type
        let inputName = `kra1_b_${tableType}[${rowIndex}][evidence_file]`;
        const existingFile = row.find(`input[name="${inputName}"]`).val();

        $('#modal_request_id').val(requestID);
        $('#modal_subcriterion_id').val(subcriterionId);
        $('#modal_table_type').val(tableType);
        $('#modal_row_index').val(rowIndex);

        $('#evidenceFile').val('');

        $('#evidenceFilename').text(existingFile ? existingFile.split('/').pop() : '');

        uploadEvidenceModal.show();
    });

    $('#evidenceFile').on('change', function() {
        $('#evidenceFilename').text(this.files[0] ? this.files[0].name : '');
    });

    $('#uploadEvidenceBtn').on('click', function() {
        const formData = new FormData($('#evidenceUploadForm')[0]);
        const evidenceFile = $('#evidenceFile')[0].files[0];

        if (!evidenceFile) {
            showMessage('Please select a file to upload.');
            return;
        }

        const validFileTypes = [
            'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'image/jpeg', 'image/png', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];

        if (!validFileTypes.includes(evidenceFile.type)) {
            showMessage('Invalid file type. Allowed types: PDF, DOC, DOCX, JPG, JPEG, PNG, XLSX, XLS');
            return;
        }

        $.ajax({
            url: '../../includes/career_progress_tracking/teaching/upload_evidence_criterion_b.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const subcriterionId = $('#modal_subcriterion_id').val();
                    const tableType = $('#modal_table_type').val();
                    const rowIndex = parseInt($('#modal_row_index').val()); // Get the row index as an integer
                    const table = $(`#${tableType}-table`);

                    // Construct the input name based on the table type and row index
                    let inputName = `kra1_b_${tableType}[${rowIndex}][evidence_file]`;

                    // Find the specific row using the input name
                    const row = table.find(`input[name="${inputName}"]`).closest('tr');

                    // Update the hidden input field with the new file path
                    row.find(`input[name="${inputName}"]`).val(response.path);

                    const newContent = `
                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                                data-subcriterion-id="${subcriterionId}">
                            Change Evidence
                        </button>`;
                    row.find('td:eq(8)').html(newContent); // Assuming evidence column is the 9th column (index 8)

                    uploadEvidenceModal.hide();
                    markFormAsDirty();
                    showMessage('File uploaded successfully!');

                    // Refresh table data
                    const requestId = $('#request_id_b').val();
                    CriterionB.fetchCriterionB(requestId);
                } else {
                    showMessage('Upload failed: ' + response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                showMessage('An error occurred during the upload.');
            }
        });
    });

    $('#deleteFile').on('click', function() {
        const rowIndex = parseInt($('#modal_row_index').val());
        const tableType = $('#modal_table_type').val();
        const requestID = $('#modal_request_id').val();
        const subcriterionId = $('#modal_subcriterion_id').val();
        const table = $(`#${tableType}-table`);

        // Construct the input name based on the table type and row index
        let inputName = `kra1_b_${tableType}[${rowIndex}][evidence_file]`;

        // Find the specific row using the input name
        const row = table.find(`input[name="${inputName}"]`).closest('tr');

        if (!confirm(`Are you sure you want to delete the evidence file?`)) {
            return;
        }

        $.ajax({
            url: '../../includes/career_progress_tracking/teaching/delete_evidence_b.php', 
            type: 'POST',
            data: {
                request_id: requestID,
                subcriterion_id: subcriterionId,
                table_type: tableType,
                row_index: rowIndex
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    row.find(`input[name="${inputName}"]`).val('');

                    const newContent = `
                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                                data-subcriterion-id="${subcriterionId}">
                            Upload Evidence
                        </button>`;
                    row.find('td:eq(8)').html(newContent); // Assuming evidence column is the 9th column (index 8)

                    $('#evidenceFilename').text('');
                    showMessage(`Evidence file deleted successfully.`);
                    setTimeout(function() {
                        $('#messageModal').modal('hide');
                    }, 2000);

                    uploadEvidenceModal.hide();
                    markFormAsDirty();

                    const requestId = $('#request_id_b').val();
                    CriterionB.fetchCriterionB(requestId);
                } else {
                    showMessage('Error deleting file: ' + response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                showMessage('An error occurred during the deletion.');
            }
        });
    });
    // === UPLOAD EVIDENCE HANDLERS END ===

     // === DELETE ROW FUNCTION START ===
     document.addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-row')) {
            const rowToDelete = e.target.closest('tr');
            const rowIndex = rowToDelete.rowIndex;

            const table = e.target.closest('table');
            let tableType;

            if (table.id === 'sole-authorship-table') {
                tableType = 'sole_authorship';
            } else if (table.id === 'co-authorship-table') {
                tableType = 'co_authorship';
            } else if (table.id === 'academic-programs-table') {
                tableType = 'academic_programs';
            } else {
                tableType = null;
            }
            
            if (rowIndex > 0 && tableType) {
                deletedRows[tableType].push(rowIndex);
            }
            
            rowToDelete.remove();

            // Re-enumerate rows
            let currentNum = 1;
            table.querySelectorAll('tbody tr').forEach(tr => {
                tr.querySelector('td:first-child').textContent = currentNum;
                currentNum++;
            });
            
            calculateTotalScores(tableType);
            markFormAsDirty();

            const successModal = new bootstrap.Modal(document.getElementById('deleteSuccessModal'));
            successModal.show();
        }
    });
    // === DELETE ROW FUNCTION END ===

    // === REMARKS HANDLER START ===
    $(document).on('click', '.view-remarks', function() {
        const button = $(this);
        const firstSemesterRemark = button.data('first-remark');
        const secondSemesterRemark = button.data('second-remark');
        $('#first-semester-remark').text(firstSemesterRemark);
        $('#second-semester-remark').text(secondSemesterRemark);

        const remarksModal = new bootstrap.Modal(document.getElementById('remarksModal'));
        remarksModal.show();
    });
    // === REMARKS HANDLER END ===

        // === CALCULATION START ===
    function calculateTotalScores(tableType) {
        let totalScore = 0;
        const table = document.getElementById(`${tableType}-table`);
        const scoreInputs = table.querySelectorAll('.score-input');

        scoreInputs.forEach(input => {
            const score = parseFloat(input.value) || 0;
            totalScore += score;
        });

        const totalScoreInput = document.getElementById(`kra1_b_${tableType}_total`);
        if (totalScoreInput) {
            totalScoreInput.value = totalScore.toFixed(2);
        }
    }

    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('score-input')) {
            const table = e.target.closest('table');
            let tableType;

            if (table.id === 'sole-authorship-table') {
                tableType = 'sole_authorship';
            } else if (table.id === 'co-authorship-table') {
                tableType = 'co_authorship';
            } else if (table.id === 'academic-programs-table') {
                tableType = 'academic_programs';
            }

            if (tableType) {
                calculateTotalScores(tableType);
                markFormAsDirty();
            }
        }
    });
    // === CALCULATION END ===

    // === ADD ROWS START ===
    // Sole Authorship
    document.querySelectorAll('#criterion-b-form .add-sole-authorship-row').forEach(addBtn => {
        addBtn.addEventListener('click', function() {
            const tableId = this.getAttribute('data-table-id');
            const tableBody = document.querySelector(`#${tableId} tbody`);
            const numRows = tableBody.querySelectorAll('tr').length;
            const newRowIndex = numRows + 1;

            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${newRowIndex}</td>
                <td><input type="text" class="form-control" name="kra1_b_sole_authorship[${newRowIndex}][title]"></td>
                <td>
                    <select class="form-select" name="kra1_b_sole_authorship[${newRowIndex}][type]">
                        <option value="">SELECT OPTION</option>
                        <option value="Textbook">Textbook</option>
                        <option value="Textbook Chapter">Textbook Chapter</option>
                        <option value="Manual/Module">Manual/Module</option>
                        <option value="Multimedia Teaching Material">Multimedia Teaching Material</option>
                        <option value="Testing Material">Testing Material</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra1_b_sole_authorship[${newRowIndex}][reviewer]"></td>
                <td><input type="text" class="form-control" name="kra1_b_sole_authorship[${newRowIndex}][publisher]"></td>
                <td><input type="date" class="form-control" name="kra1_b_sole_authorship[${newRowIndex}][date_published]"></td>
                <td><input type="date" class="form-control" name="kra1_b_sole_authorship[${newRowIndex}][date_approved]"></td>
                <td><input type="number" class="form-control score-input" name="kra1_b_sole_authorship[${newRowIndex}][score]"></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="sole_authorship_${newRowIndex}">Upload Evidence</button>
                    <input type="hidden" name="kra1_b_sole_authorship[${newRowIndex}][evidence_file]" value="">
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                </td>
            `;

            tableBody.appendChild(newRow);
            calculateTotalScores('sole_authorship');
            markFormAsDirty();
        });
    });

    // Co-authorship
    document.querySelectorAll('#criterion-b-form .add-co-authorship-row').forEach(addBtn => {
        addBtn.addEventListener('click', function() {
            const tableId = this.getAttribute('data-table-id');
            const tableBody = document.querySelector(`#${tableId} tbody`);
            const numRows = tableBody.querySelectorAll('tr').length;
            const newRowIndex = numRows + 1;

            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${newRowIndex}</td>
                <td><input type="text" class="form-control" name="kra1_b_co_authorship[${newRowIndex}][title]"></td>
                <td>
                    <select class="form-select" name="kra1_b_co_authorship[${newRowIndex}][type]">
                        <option value="">SELECT OPTION</option>
                        <option value="Textbook">Textbook</option>
                        <option value="Textbook Chapter">Textbook Chapter</option>
                        <option value="Manual/Module">Manual/Module</option>
                        <option value="Multimedia Teaching Material">Multimedia Teaching Material</option>
                        <option value="Testing Material">Testing Material</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra1_b_co_authorship[${newRowIndex}][reviewer]"></td>
                <td><input type="text" class="form-control" name="kra1_b_co_authorship[${newRowIndex}][publisher]"></td>
                <td><input type="date" class="form-control" name="kra1_b_co_authorship[${newRowIndex}][date_published]"></td>
                <td><input type="date" class="form-control" name="kra1_b_co_authorship[${newRowIndex}][date_approved]"></td>
                <td><input type="number" step="0.01" class="form-control" name="kra1_b_co_authorship[${newRowIndex}][contribution_percentage]"></td>
                <td><input type="number" class="form-control score-input" name="kra1_b_co_authorship[${newRowIndex}][score]"></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="co_authorship_${newRowIndex}">Upload Evidence</button>
                    <input type="hidden" name="kra1_b_co_authorship[${newRowIndex}][evidence_file]" value="">
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                </td>
            `;

            tableBody.appendChild(newRow);
            calculateTotalScores('co_authorship');
            markFormAsDirty();
        });
    });

    // Academic Programs
    document.querySelectorAll('#criterion-b-form .add-academic-programs-row').forEach(addBtn => {
        addBtn.addEventListener('click', function() {
            const tableId = this.getAttribute('data-table-id');
            const tableBody = document.querySelector(`#${tableId} tbody`);
            const numRows = tableBody.querySelectorAll('tr').length;
            const newRowIndex = numRows + 1;

            const newRow = document.createElement('tr');
            const currentYear = new Date().getFullYear();
            let yearOptions = '';
            for (let year = currentYear; year >= currentYear - 4; year--) {
                const yearRange = year + '-' + (year + 1);
                yearOptions += `<option value="${yearRange}">${yearRange}</option>`;
            }
            newRow.innerHTML = `
                <td>${newRowIndex}</td>
                <td><input type="text" class="form-control" name="kra1_b_academic_programs[${newRowIndex}][program_name]"></td>
                <td>
                    <select class="form-select" name="kra1_b_academic_programs[${newRowIndex}][program_type]">
                        <option value="">SELECT OPTION</option>
                        <option value="New Program">New Program</option>
                        <option value="Revised Program">Revised Program</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra1_b_academic_programs[${newRowIndex}][board_approval]"></td>
                <td>
                    <select class="form-select" name="kra1_b_academic_programs[${newRowIndex}][academic_year]">
                        <option value="">SELECT OPTION</option>
                        ${yearOptions}
                    </select>
                </td>
                <td>
                    <select class="form-select" name="kra1_b_academic_programs[${newRowIndex}][role]">
                        <option value="">SELECT OPTION</option>
                        <option value="Lead">Lead</option>
                        <option value="Contributor">Contributor</option>
                    </select>
                </td>
                <td><input type="number" class="form-control score-input" name="kra1_b_academic_programs[${newRowIndex}][score]"></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="academic_programs_${newRowIndex}">Upload Evidence</button>
                    <input type="hidden" name="kra1_b_academic_programs[${newRowIndex}][evidence_file]" value="">
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                </td>
            `;

            tableBody.appendChild(newRow);
            calculateTotalScores('academic_programs');
            markFormAsDirty();
        });
    });
    // === ADD ROWS END ===

    // === SAVING PROCESS START ===
    function gatherPayload(requestId) {
        const soleAuthorshipData = [];
        const coAuthorshipData = [];
        const academicProgramsData = [];

        document.querySelectorAll('#sole-authorship-table tbody tr').forEach(row => {
            const rowIndex = row.rowIndex;
            const title = row.querySelector(`input[name="kra1_b_sole_authorship[${rowIndex}][title]"]`).value;
            const type = row.querySelector(`select[name="kra1_b_sole_authorship[${rowIndex}][type]"]`).value;
            const reviewer = row.querySelector(`input[name="kra1_b_sole_authorship[${rowIndex}][reviewer]"]`).value;
            const publisher = row.querySelector(`input[name="kra1_b_sole_authorship[${rowIndex}][publisher]"]`).value;
            const datePublished = row.querySelector(`input[name="kra1_b_sole_authorship[${rowIndex}][date_published]"]`).value;
            const dateApproved = row.querySelector(`input[name="kra1_b_sole_authorship[${rowIndex}][date_approved]"]`).value;
            const score = parseFloat(row.querySelector(`input[name="kra1_b_sole_authorship[${rowIndex}][score]"]`).value) || 0;
            const evidenceFile = row.querySelector(`input[name="kra1_b_sole_authorship[${rowIndex}][evidence_file]"]`).value;

            soleAuthorshipData.push({
                title,
                type,
                reviewer,
                publisher,
                date_published: datePublished,
                date_approved: dateApproved,
                score,
                evidence_file: evidenceFile
            });
        });

        document.querySelectorAll('#co-authorship-table tbody tr').forEach(row => {
            const rowIndex = row.rowIndex;
            const title = row.querySelector(`input[name="kra1_b_co_authorship[${rowIndex}][title]"]`).value;
            const type = row.querySelector(`select[name="kra1_b_co_authorship[${rowIndex}][type]"]`).value;
            const reviewer = row.querySelector(`input[name="kra1_b_co_authorship[${rowIndex}][reviewer]"]`).value;
            const publisher = row.querySelector(`input[name="kra1_b_co_authorship[${rowIndex}][publisher]"]`).value;
            const datePublished = row.querySelector(`input[name="kra1_b_co_authorship[${rowIndex}][date_published]"]`).value;
            const dateApproved = row.querySelector(`input[name="kra1_b_co_authorship[${rowIndex}][date_approved]"]`).value;
            const contributionPercentage = parseFloat(row.querySelector(`input[name="kra1_b_co_authorship[${rowIndex}][contribution_percentage]"]`).value) || 0;
            const score = parseFloat(row.querySelector(`input[name="kra1_b_co_authorship[${rowIndex}][score]"]`).value) || 0;
            const evidenceFile = row.querySelector(`input[name="kra1_b_co_authorship[${rowIndex}][evidence_file]"]`).value;

            coAuthorshipData.push({
                title,
                type,
                reviewer,
                publisher,
                date_published: datePublished,
                date_approved: dateApproved,
                contribution_percentage: contributionPercentage,
                score,
                evidence_file: evidenceFile
            });
        });

        document.querySelectorAll('#academic-programs-table tbody tr').forEach(row => {
            const rowIndex = row.rowIndex;
            const programName = row.querySelector(`input[name="kra1_b_academic_programs[${rowIndex}][program_name]"]`).value;
            const programType = row.querySelector(`select[name="kra1_b_academic_programs[${rowIndex}][program_type]"]`).value;
            const boardApproval = row.querySelector(`input[name="kra1_b_academic_programs[${rowIndex}][board_approval]"]`).value;
            const academicYear = row.querySelector(`select[name="kra1_b_academic_programs[${rowIndex}][academic_year]"]`).value;
            const role = row.querySelector(`select[name="kra1_b_academic_programs[${rowIndex}][role]"]`).value;
            const score = parseFloat(row.querySelector(`input[name="kra1_b_academic_programs[${rowIndex}][score]"]`).value) || 0;
            const evidenceFile = row.querySelector(`input[name="kra1_b_academic_programs[${rowIndex}][evidence_file]"]`).value;

            academicProgramsData.push({
                program_name: programName,
                program_type: programType,
                board_approval: boardApproval,
                academic_year: academicYear,
                role,
                score,
                evidence_file: evidenceFile
            });
        });

        const soleAuthorshipTotal = parseFloat(document.getElementById('kra1_b_sole_authorship_total').value) || 0;
        const coAuthorshipTotal = parseFloat(document.getElementById('kra1_b_co_authorship_total').value) || 0;
        const academicProgramsTotal = parseFloat(document.getElementById('kra1_b_academic_programs_total').value) || 0;

        return {
            request_id: parseInt(requestId, 10),
            sole_authorship: soleAuthorshipData,
            co_authorship: coAuthorshipData,
            academic_programs: academicProgramsData,
            sole_authorship_total: soleAuthorshipTotal,
            co_authorship_total: coAuthorshipTotal,
            academic_programs_total: academicProgramsTotal,
            deleted_rows: deletedRows
        };
    }

    function saveCriterionB() {
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }

        const requestId = document.getElementById('request_id_b').value.trim();
        if (!requestId || parseInt(requestId) <= 0) {
            showMessage('Please select a valid evaluation ID.');
            return;
        }

        const payload = gatherPayload(requestId);
        fetch('../../includes/career_progress_tracking/teaching/save_criterion_b.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('Criterion B data saved successfully!');
                deletedRows = { sole_authorship: [], co_authorship: [], academic_programs: [] };
                markFormAsClean();
                CriterionB.fetchCriterionB(requestId);
            } else {
                showMessage(data.error || 'An error occurred while saving.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Failed to save data. Please check the console for details.');
        });
    }

    saveBtn.addEventListener('click', function () {
        saveCriterionB();
    });
    // === SAVING PROCESS END ===

    // === UNSAVED CHANGES PROMPT START ===
    let intendedNavigationURL = null;
    document.getElementById('confirm-navigation').addEventListener('click', function() {
        if (intendedNavigationURL) {
            markFormAsClean();
            window.location.href = intendedNavigationURL;
            intendedNavigationURL = null;
        }
    });

    function isRealNavigation(linkElement) {
        if (!linkElement) return false;
        const href = linkElement.getAttribute('href');
        return href && href !== '#' && !href.startsWith('javascript:');
    }

    document.addEventListener('click', function(e) {
        const link = e.target.closest('a[data-navigation="true"]');
        const button = e.target.closest('button[data-action="navigate"]');

        if (link) {
            if (isFormDirty) {
                e.preventDefault();
                intendedNavigationURL = link.href;
                const unsavedChangesModal = new bootstrap.Modal(document.getElementById('unsavedChangesModal'));
                unsavedChangesModal.show();
            }
        } else if (button && button.getAttribute('data-action') === 'navigate') {
            if (isFormDirty) {
                e.preventDefault();
                intendedNavigationURL = button.getAttribute('data-href');
                const unsavedChangesModal = new bootstrap.Modal(document.getElementById('unsavedChangesModal'));
                unsavedChangesModal.show();
            }
        }
    });
    // === UNSAVED CHANGES PROMPT END ===

    markFormAsClean(); // Mark the form clean on initial load
    };

    // On DOM load, initialize everything
    document.addEventListener('DOMContentLoaded', function () {
        CriterionB.init();
    });

    // Expose the namespace
    window.CriterionB = CriterionB;
}(window, document, jQuery));