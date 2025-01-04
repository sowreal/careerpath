// === FETCHING AND POPULATE START ===
function escapeHTML(str) {
    if (!str) return '';
    return str.replace(/&/g, "&amp;")
              .replace(/</g, "&lt;")
              .replace(/>/g, "&gt;")
              .replace(/"/g, "&quot;")
              .replace(/'/g, "&#039;");
}

function addDefaultStudentRows(tableBody) {
    const defaultPeriods = ["AY 2019 - 2020", "AY 2020 - 2021", "AY 2021 - 2022", "AY 2022 - 2023"];
    const requestId = document.getElementById('request_id').value.trim(); // Get current request_id
    defaultPeriods.forEach((period, index) => {
        const evaluation_id = `${requestId}_${period}_student`;
        const row = document.createElement('tr');
        row.setAttribute('data-evaluation-id', evaluation_id);
        row.innerHTML = `
            <td><input type="text" class="form-control" name="student_evaluation_period[]" value="${escapeHTML(period)}" required></td>
            <td><input type="number" class="form-control rating-input" name="student_rating_1[]" placeholder="0.00" required></td>
            <td><input type="number" class="form-control rating-input" name="student_rating_2[]" placeholder="0.00" required></td>
            <td>
                <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                        data-request-id="${requestId}"
                        data-evaluation-id="${evaluation_id}"
                        data-table-type="student">
                    Upload Evidence
                </button>
                <input type="hidden" name="evaluation_id[]" value="${evaluation_id}">
            </td>
            <td><button type="button" class="btn btn-success btn-sm view-remarks" data-first-remark="" data-second-remark="">View Remarks</button></td>
            <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
        `;
        tableBody.appendChild(row);
    });
}

function addDefaultSupervisorRows(tableBody) {
    const defaultPeriods = ["AY 2019 - 2020", "AY 2020 - 2021", "AY 2021 - 2022", "AY 2022 - 2023"];
    const requestId = document.getElementById('request_id').value.trim(); // Get current request_id
    defaultPeriods.forEach((period, index) => {
        const evaluation_id = `${requestId}_${period}_supervisor`;
        const row = document.createElement('tr');
        row.setAttribute('data-evaluation-id', evaluation_id);
        row.innerHTML = `
            <td><input type="text" class="form-control" name="supervisor_evaluation_period[]" value="${escapeHTML(period)}" required></td>
            <td><input type="number" class="form-control rating-input" name="supervisor_rating_1[]" placeholder="0.00" required></td>
            <td><input type="number" class="form-control rating-input" name="supervisor_rating_2[]" placeholder="0.00" required></td>
            <td>
                <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                        data-request-id="${requestId}"
                        data-evaluation-id="${evaluation_id}"
                        data-table-type="supervisor">
                    Upload Evidence
                </button>
                <input type="hidden" name="evaluation_id[]" value="${evaluation_id}">
            </td>
            <td><button type="button" class="btn btn-success btn-sm view-remarks" data-first-remark="" data-second-remark="">View Remarks</button></td>
            <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
        `;
        tableBody.appendChild(row);
    });
}

function populateStudentTable(studentData) {
    const tableBody = document.querySelector('#student-evaluation-table tbody');
    const requestId = document.getElementById('request_id').value.trim(); // Get current request_id
    tableBody.innerHTML = ''; 

    if (!studentData || studentData.length === 0) {
        addDefaultStudentRows(tableBody);
        return;
    }

    studentData.forEach(item => {
        const tr = document.createElement('tr');
        tr.setAttribute('data-evaluation-id', item.evaluation_id);

        // Construct the cell content based on whether evidence exists
        let evidenceCellContent = '';
        if (item.evidence_file_1 || item.evidence_file_2) {
            // If evidence exists, display filenames (or other indicators)
            evidenceCellContent = `
                <span class="uploaded-evidence">
                    ${item.evidence_file_1 ? `<i class="fas fa-file-alt"></i> ${item.evidence_file_1.split('/').pop()}` : ''}
                    ${item.evidence_file_2 ? `<i class="fas fa-file-alt"></i> ${item.evidence_file_2.split('/').pop()}` : ''}
                </span>
                <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                        data-request-id="${requestId}"
                        data-evaluation-id="${item.evaluation_id}"
                        data-table-type="student">
                    Change Evidence
                </button>
            `;
        } else {
            // If no evidence, show the "Upload Evidence" button
            evidenceCellContent = `
                <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                        data-request-id="${requestId}"
                        data-evaluation-id="${item.evaluation_id}"
                        data-table-type="student">
                    Upload Evidence
                </button>
            `;
        }

        tr.innerHTML = `
            <td><input type="text" class="form-control" name="student_evaluation_period[]" value="${escapeHTML(item.evaluation_period || '')}" required></td>
            <td><input type="number" class="form-control rating-input" name="student_rating_1[]" value="${item.first_semester_rating || ''}" placeholder="0.00" required></td>
            <td><input type="number" class="form-control rating-input" name="student_rating_2[]" value="${item.second_semester_rating || ''}" placeholder="0.00" required></td>
            <td>
                ${evidenceCellContent}
                <input type="hidden" name="evaluation_id[]" value="${item.evaluation_id}">
            </td>
            <td><button type="button" class="btn btn-success btn-sm view-remarks" data-first-remark="${escapeHTML(item.remarks_first || '')}" data-second-remark="${escapeHTML(item.remarks_second || '')}">View Remarks</button></td>
            <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
        `;
        tableBody.appendChild(tr);
    });
}

function populateSupervisorTable(supervisorData) {
    const tableBody = document.querySelector('#supervisor-evaluation-table tbody');
    const requestId = document.getElementById('request_id').value.trim(); // Get current request_id
    tableBody.innerHTML = '';

    if (!supervisorData || supervisorData.length === 0) {
        addDefaultSupervisorRows(tableBody);
        return;
    }

    supervisorData.forEach(item => {
        const tr = document.createElement('tr');
        tr.setAttribute('data-evaluation-id', item.evaluation_id);

        // Construct the cell content based on whether evidence exists
        let evidenceCellContent = '';
        if (item.evidence_file_1 || item.evidence_file_2) {
            // If evidence exists, display filenames (or other indicators)
            evidenceCellContent = `
                <span class="uploaded-evidence">
                    ${item.evidence_file_1 ? `<i class="fas fa-file-alt"></i> ${item.evidence_file_1.split('/').pop()}` : ''}
                    ${item.evidence_file_2 ? `<i class="fas fa-file-alt"></i> ${item.evidence_file_2.split('/').pop()}` : ''}
                </span>
                <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                        data-request-id="${requestId}"
                        data-evaluation-id="${item.evaluation_id}"
                        data-table-type="supervisor">
                    Change Evidence
                </button>
            `;
        } else {
            // If no evidence, show the "Upload Evidence" button
            evidenceCellContent = `
                <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                        data-request-id="${requestId}"
                        data-evaluation-id="${item.evaluation_id}"
                        data-table-type="supervisor">
                    Upload Evidence
                </button>
            `;
        }

        tr.innerHTML = `
            <td><input type="text" class="form-control" name="supervisor_evaluation_period[]" value="${escapeHTML(item.evaluation_period || '')}" required></td>
            <td><input type="number" class="form-control rating-input" name="supervisor_rating_1[]" value="${item.first_semester_rating || ''}" placeholder="0.00" required></td>
            <td><input type="number" class="form-control rating-input" name="supervisor_rating_2[]" value="${item.second_semester_rating || ''}" placeholder="0.00" required></td>
            <td>
                ${evidenceCellContent}
                <input type="hidden" name="evaluation_id[]" value="${item.evaluation_id}">
            </td>
            <td><button type="button" class="btn btn-success btn-sm view-remarks" data-first-remark="${escapeHTML(item.remarks_first || '')}" data-second-remark="${escapeHTML(item.remarks_second || '')}">View Remarks</button></td>
            <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
        `;
        tableBody.appendChild(tr);
    });
}

function populateMetadata(metadata) {
    if (!metadata) {
        // Reset to defaults if no metadata
        setElementValue('student-divisor', 0);
        setElementValue('student-reason', '');
        setElementValue('supervisor-divisor', 0);
        setElementValue('supervisor-reason', '');

        // Reset overall/faculty scores
        setElementValue('student_overall_score', '');
        setElementValue('student_faculty_overall_score', '');
        setElementValue('supervisor-overall-score', '');
        setElementValue('supervisor-faculty-overall-score', '');
        return;
    }

    // Populate student metadata fields
    setElementValue('student-divisor', metadata.student_divisor || 0);
    setElementValue('student-reason', metadata.student_reason || '');

    // Populate supervisor metadata fields
    setElementValue('supervisor-divisor', metadata.supervisor_divisor || 0);
    setElementValue('supervisor-reason', metadata.supervisor_reason || '');

    // Populate the overall/faculty ratings from metadata
    setElementValue('student_overall_score', metadata.student_overall_rating || 0);
    setElementValue('student_faculty_overall_score', metadata.student_faculty_rating || 0);
    setElementValue('supervisor-overall-score', metadata.supervisor_overall_rating || 0);
    setElementValue('supervisor-faculty-overall-score', metadata.supervisor_faculty_rating || 0);
}

function setElementValue(elementId, value) {
    const element = document.getElementById(elementId);
    if (element) {
        element.value = value;
    } else {
        console.warn(`Element with ID '${elementId}' not found.`);
    }
}

function fetchCriterionA(requestId) {
    return fetch(`../../includes/career_progress_tracking/teaching/fetch_criterion_a.php?request_id=${requestId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const studentTableBody = document.querySelector('#student-evaluation-table tbody');
                const supervisorTableBody = document.querySelector('#supervisor-evaluation-table tbody');

                // Add default rows if no data
                if (!data.student_evaluations || data.student_evaluations.length === 0) {
                    addDefaultStudentRows(studentTableBody);
                } else {
                    populateStudentTable(data.student_evaluations);
                }

                if (!data.supervisor_evaluations || data.supervisor_evaluations.length === 0) {
                    addDefaultSupervisorRows(supervisorTableBody);
                } else {
                    populateSupervisorTable(data.supervisor_evaluations);
                }

                populateMetadata(data.metadata);
                return data;
            } else {
                throw new Error(data.error || 'Failed to fetch Criterion A data.');
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}
// === FETCHING AND POPULATE END ===

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('criterion-a-form');
    const saveBtn = document.getElementById('save-criterion-a');
    const saveSuccessModal = new bootstrap.Modal(document.getElementById('saveConfirmationModal'));
    const saveErrorModal = new bootstrap.Modal(document.getElementById('saveErrorModal'));

    // === MODAL AND AJAX START ===
    const uploadEvidenceModal = new bootstrap.Modal(document.getElementById('uploadEvidenceModal'));

    // Handle clicks on "Upload Evidence" buttons (using event delegation)
    $('#student-evaluation-table, #supervisor-evaluation-table').on('click', '.upload-evidence-btn', function() {
        const button = $(this);
        const requestID = button.data('request-id');
        const evaluationID = button.data('evaluation-id');
        const tableType = button.data('table-type');

        // These should log correctly now
        console.log("Button Request ID:", requestID);
        console.log("Button Evaluation ID:", evaluationID);
        console.log("Button Table Type:", tableType);

        // Set hidden input values in the modal
        $('#modal_request_id').val(requestID);
        $('#modal_evaluation_id').val(evaluationID);
        $('#modal_table_type').val(tableType);

        // Clear any previous file selections
        $('#firstSemesterFile').val('');
        $('#secondSemesterFile').val('');
        $('#firstSemesterFilename').text('');
        $('#secondSemesterFilename').text('');

        // Show the modal
        uploadEvidenceModal.show();
    });

    // Handle file selection in the modal (display filenames)
    $('#firstSemesterFile').on('change', function() {
        $('#firstSemesterFilename').text(this.files[0] ? this.files[0].name : '');
    });

    $('#secondSemesterFile').on('change', function() {
        $('#secondSemesterFilename').text(this.files[0] ? this.files[0].name : '');
    });

    // Handle "Upload" button click in the modal
    $('#uploadEvidenceBtn').on('click', function() {
        const formData = new FormData($('#evidenceUploadForm')[0]);

        $.ajax({
            url: '../../includes/career_progress_tracking/teaching/upload_evidence_criterion_a.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const evaluationID = $('#modal_evaluation_id').val();
                    const tableType = $('#modal_table_type').val();
                    const table = $(`#${tableType}-evaluation-table`);
                    const row = table.find(`tr[data-evaluation-id="${evaluationID}"]`);
                    const evidenceCell = row.find('td:eq(3)');

                    // Update the evidence cell content
                    let newEvidenceContent = `<span class="uploaded-evidence">`;
                    if (response.paths.sem1) {
                        newEvidenceContent += `<i class="fas fa-file-alt"></i> ${response.paths.sem1.split('/').pop()}<br>`;
                    }
                    if (response.paths.sem2) {
                        newEvidenceContent += `<i class="fas fa-file-alt"></i> ${response.paths.sem2.split('/').pop()}<br>`;
                    }
                    newEvidenceContent += `</span>
                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                                data-request-id="${$('#modal_request_id').val()}"
                                data-evaluation-id="${evaluationID}"
                                data-table-type="${tableType}">
                            Change Evidence
                        </button>`;
                    evidenceCell.html(newEvidenceContent);

                    uploadEvidenceModal.hide();
                    markFormAsDirty();
                } else {
                    alert('Upload failed: ' + response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('An error occurred during the upload.');
            }
        });
    });
    // === MODAL AND AJAX END ===

    // ... (Rest of the existing code)

    // === DELETION TRACKING AND DIRTY FLAG START ===
    // Initialize an object to track deleted evaluations
    let deletedEvaluations = {
        student: [],
        supervisor: []
    };

    // Initialize a flag to track if the form has unsaved changes
    let isFormDirty = false;

    function markFormAsDirty() {
        isFormDirty = true;
        // Optionally, add a visual indicator (e.g., change save button color)
        saveBtn.classList.add('btn-warning');
    }

    function markFormAsClean() {
        isFormDirty = false;
        // Remove visual indicators
        saveBtn.classList.remove('btn-warning');
    }
    // === DELETION TRACKING AND DIRTY FLAG END ===

    // === SAVING PROCESS START ===
    function saveCriterionA() {
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }

        calculateOverallScores();
        const requestId = document.getElementById('request_id').value.trim();

        if (!requestId || parseInt(requestId) <= 0) {
            showErrorModal('Please select a valid evaluation ID.');
            return;
        }

        const payload = gatherPayload(requestId);

        fetch('../../includes/career_progress_tracking/teaching/save_criterion_a.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                saveSuccessModal.show();
                // Reset the deletedEvaluations list
                deletedEvaluations = { student: [], supervisor: [] };
                markFormAsClean();
                // Re-fetch data if necessary
                fetchCriterionA(requestId);
            } else {
                showErrorModal(data.error || 'An error occurred.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showErrorModal('Failed to save data. Please check console for details.');
        });
    }

    saveBtn.addEventListener('click', function () {
        saveCriterionA();
    });

    function gatherPayload(requestId) {
        // Collect student evaluations
        const studentEvaluations = [];
        document.querySelectorAll('#student-evaluation-table tbody tr').forEach(row => {
            const evaluation_id = parseInt(row.getAttribute('data-evaluation-id') || 0, 10);
            const evaluation_period = row.querySelector('input[name="student_evaluation_period[]"]').value.trim();
            const rating1Input = row.querySelector('input[name="student_rating_1[]"]');
            const rating2Input = row.querySelector('input[name="student_rating_2[]"]');
            const evidence_link_first = row.querySelector('input[name="student_evidence_link[]"]').value.trim();
            const evidence_link_second = evidence_link_first; 
            const remarks_first = ''; 
            const remarks_second = ''; 

            studentEvaluations.push({
                evaluation_id,
                evaluation_period,
                first_semester_rating: parseFloat(rating1Input.value) || 0,
                second_semester_rating: parseFloat(rating2Input.value) || 0,
                evidence_link_first,
                evidence_link_second,
                remarks_first,
                remarks_second
            });
        });

        // Collect supervisor evaluations
        const supervisorEvaluations = [];
        document.querySelectorAll('#supervisor-evaluation-table tbody tr').forEach(row => {
            const evaluation_id = parseInt(row.getAttribute('data-evaluation-id') || 0, 10);
            const evaluation_period = row.querySelector('input[name="supervisor_evaluation_period[]"]').value.trim();
            const rating1Input = row.querySelector('input[name="supervisor_rating_1[]"]');
            const rating2Input = row.querySelector('input[name="supervisor_rating_2[]"]');
            const evidence_link_first = row.querySelector('input[name="supervisor_evidence_link[]"]').value.trim();
            const evidence_link_second = evidence_link_first;
            const remarks_first = '';
            const remarks_second = '';

            supervisorEvaluations.push({
                evaluation_id,
                evaluation_period,
                first_semester_rating: parseFloat(rating1Input.value) || 0,
                second_semester_rating: parseFloat(rating2Input.value) || 0,
                evidence_link_first,
                evidence_link_second,
                remarks_first,
                remarks_second
            });
        });

        // Now gather the metadata ratings from the top-level fields
        const student_overall_rating = parseFloat(document.getElementById('student_overall_score').value) || 0;
        const student_faculty_rating = parseFloat(document.getElementById('student_faculty_overall_score').value) || 0;
        const supervisor_overall_rating = parseFloat(document.getElementById('supervisor-overall-score').value) || 0;
        const supervisor_faculty_rating = parseFloat(document.getElementById('supervisor-faculty-overall-score').value) || 0;

        return {
            request_id: parseInt(requestId,10),
            student_divisor: parseInt(document.getElementById('student-divisor').value,10) || 0,
            student_reason: document.getElementById('student-reason').value,
            student_evidence_link: document.getElementById('student-evidence-link').value,
            supervisor_divisor: parseInt(document.getElementById('supervisor-divisor').value,10) || 0,
            supervisor_reason: document.getElementById('supervisor-reason').value,
            supervisor_evidence_link: document.getElementById('supervisor-evidence-link').value,
            student_evaluations: studentEvaluations,
            supervisor_evaluations: supervisorEvaluations,
            // Include new overall/faculty ratings in the payload as part of metadata
            student_overall_rating: student_overall_rating,
            student_faculty_rating: student_faculty_rating,
            supervisor_overall_rating: supervisor_overall_rating,
            supervisor_faculty_rating: supervisor_faculty_rating,
            // Include deleted evaluations
            deleted_evaluations: deletedEvaluations
        };
    }

    function showErrorModal(message) {
        document.querySelector('#saveErrorModal .modal-body').textContent = message;
        saveErrorModal.show();
    }
    // === SAVING PROCESS END ===

    // === ADD ROW FUNCTION START ===
    document.querySelectorAll('.add-row').forEach(addBtn => {
        addBtn.addEventListener('click', function() {
            const tableId = this.getAttribute('data-table-id');
            const tableBody = document.querySelector(`#${tableId} tbody`);
            const requestId = document.getElementById('request_id').value.trim(); // Get current request_id

            // Determine if this is student or supervisor
            const isStudent = tableId.includes('student');
            const periodName = isStudent ? 'student_evaluation_period[]' : 'supervisor_evaluation_period[]';
            const rating1Name = isStudent ? 'student_rating_1[]' : 'supervisor_rating_1[]';
            const rating2Name = isStudent ? 'student_rating_2[]' : 'supervisor_rating_2[]';

            // Generate a unique evaluation_id for the new row
            const new_evaluation_id = requestId + '_new_' + Date.now();

            // Create a new row similar to the default row
            const newRow = document.createElement('tr');
            newRow.setAttribute('data-evaluation-id', new_evaluation_id);

            newRow.innerHTML = `
                <td>
                    <input type="text" class="form-control" name="${periodName}" value="AY 2023 - 2024" required>
                </td>
                <td>
                    <input type="number" class="form-control rating-input" name="${rating1Name}" placeholder="0.00" required>
                </td>
                <td>
                    <input type="number" class="form-control rating-input" name="${rating2Name}" placeholder="0.00" required>
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                            data-request-id="${requestId}"
                            data-evaluation-id="${new_evaluation_id}"
                            data-table-type="${isStudent ? 'student' : 'supervisor'}">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="evaluation_id[]" value="${new_evaluation_id}">
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-sm view-remarks" data-first-remark="" data-second-remark="">View Remarks</button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button>
                </td>
            `;

            tableBody.appendChild(newRow);

            // Recalculate scores if needed
            calculateOverallScores();

            // Mark form as dirty
            markFormAsDirty();
        });
    });
    // === ADD ROW FUNCTION END ===

    // === DELETE ROW FUNCTION START ===
    let rowToDelete = null;
    let evaluationIdToDelete = null;
    let tableToDeleteFrom = null;

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-row')) {
            rowToDelete = e.target.closest('tr');
            evaluationIdToDelete = rowToDelete.getAttribute('data-evaluation-id') || '0';

            // Determine which table the row belongs to
            const table = e.target.closest('table');
            if (table.id === 'student-evaluation-table') {
                tableToDeleteFrom = 'student';
            } else if (table.id === 'supervisor-evaluation-table') {
                tableToDeleteFrom = 'supervisor';
            } else {
                tableToDeleteFrom = null;
            }

            // Show confirmation modal
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteRowModal'));
            deleteModal.show();
        }
    });

    document.getElementById('confirm-delete-row').addEventListener('click', function() {
        if (rowToDelete) {
            const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteRowModal'));
            deleteModal.hide();

            if (evaluationIdToDelete !== '0' && tableToDeleteFrom) {
                // Add the evaluation ID to the deleted list
                deletedEvaluations[tableToDeleteFrom].push(evaluationIdToDelete);
            }

            // Remove the row from the table
            rowToDelete.remove();
            rowToDelete = null;
            evaluationIdToDelete = null;
            tableToDeleteFrom = null;

            // Recalculate scores visually
            calculateOverallScores();

            // Mark form as dirty
            markFormAsDirty();

            // Show success message
            const successModal = new bootstrap.Modal(document.getElementById('deleteSuccessModal'));
            successModal.show();
        }
    });
    // === DELETE ROW FUNCTION END ===

    // === CALCULATION START ===
    function calculateOverallScores() {
        const calculateSectionScores = (divisorId, reasonId, overallScoreId, facultyScoreId, multiplier) => {
            const divisorSelect = document.getElementById(divisorId);
            let divisor = parseInt(divisorSelect.value, 10);
            if (isNaN(divisor) || divisor < 0 || divisor > 8) divisor = 0;
            const reasonSelect = document.getElementById(reasonId);
            const reason = reasonSelect.value;
            const sectionPrefix = divisorId.includes('student') ? 'student' : 'supervisor';
            const evaluationTable = document.getElementById(`${sectionPrefix}-evaluation-table`);
            const ratingInputs = evaluationTable.querySelectorAll(`input[name="${sectionPrefix}_rating_1[]"], input[name="${sectionPrefix}_rating_2[]"]`);

            let totalRating = 0;
            let ratingCount = 0;
            ratingInputs.forEach(input => {
                const val = parseFloat(input.value);
                if (!isNaN(val)) {
                    totalRating += val;
                    ratingCount++;
                }
            });

            let overallAverageRating = 0;
            if ((reason === '' || reason === 'not_applicable') || divisor === 0) {
                if (ratingCount > 0) overallAverageRating = totalRating / ratingCount;
            } else {
                const denominator = 8 - divisor;
                if (denominator > 0) overallAverageRating = totalRating / denominator;
            }

            const facultyScore = overallAverageRating * multiplier;
            document.getElementById(overallScoreId).value = overallAverageRating.toFixed(2);
            document.getElementById(facultyScoreId).value = facultyScore.toFixed(2);
        };

        calculateSectionScores('student-divisor','student-reason','student_overall_score','student_faculty_overall_score',0.36);
        calculateSectionScores('supervisor-divisor','supervisor-reason','supervisor-overall-score','supervisor-faculty-overall-score',0.24);
    }

    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('rating-input')) {
            calculateOverallScores();
            markFormAsDirty();
        }
    });

    document.addEventListener('change', function (e) {
        if (e.target.matches('#student-divisor, #student-reason, #supervisor-divisor, #supervisor-reason')) {
            calculateOverallScores();
            markFormAsDirty();
        }
    });

    // Initial calculation run
    calculateOverallScores();
    markFormAsClean();
    // === CALCULATION END ===

    // === UNSAVED CHANGES PROMPT START ===

    // Variable to store the intended navigation URL
    let intendedNavigationURL = null;

    // Function to handle navigation after confirmation
    function handleNavigation() {
        if (intendedNavigationURL) {
            // Prevent the beforeunload from triggering
            markFormAsClean();
            window.location.href = intendedNavigationURL;
            intendedNavigationURL = null;
        }
    }

    // Attach the navigation handler once
    document.getElementById('confirm-navigation').addEventListener('click', handleNavigation);

    // Function to determine if a link is a real navigation
    function isRealNavigation(linkElement) {
        if (!linkElement) return false;
        const href = linkElement.getAttribute('href');
        // Exclude links with href="#" or javascript:void(0); or similar
        return href && href !== '#' && !href.startsWith('javascript:');
    }

    // Listen for all click events on the document
    document.addEventListener('click', function(e) {
        // Check if the clicked element or any of its parents is an <a> tag with data-navigation="true"
        const link = e.target.closest('a[data-navigation="true"]');
        const button = e.target.closest('button[data-action="navigate"]');

        // Handle <a> tag clicks
        if (link) {
            if (isFormDirty) {
                e.preventDefault();
                intendedNavigationURL = link.href;

                // Show the unsaved changes modal
                const unsavedChangesModal = new bootstrap.Modal(document.getElementById('unsavedChangesModal'));
                unsavedChangesModal.show();
            }
        }
        // Handle buttons with data-action="navigate"
        else if (button && button.getAttribute('data-action') === 'navigate') {
            if (isFormDirty) {
                e.preventDefault();
                intendedNavigationURL = button.getAttribute('data-href');

                // Show the unsaved changes modal
                const unsavedChangesModal = new bootstrap.Modal(document.getElementById('unsavedChangesModal'));
                unsavedChangesModal.show();
            }
        }
    });
    // === UNSAVED CHANGES PROMPT END ===

});