// careerpath/php/includes/career_progress_tracking/teaching/criterion_a.js
// Encapsulate Criterion A logic in a namespace to avoid conflicts.
(function (window, document, $) {
    'use strict';

    // Create a namespace object
    var CriterionA = {};

    // === HELPER FUNCTIONS ===
    function escapeHTML(str) {
        if (!str) return '';
        return str
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
    
    function addDefaultStudentRows(tableBody) {
        const defaultPeriods = ["AY 2019 - 2020", "AY 2020 - 2021", "AY 2021 - 2022", "AY 2022 - 2023"];
        const requestId = document.getElementById('request_id').value.trim();
        defaultPeriods.forEach(period => {
            const row = document.createElement('tr');
            row.setAttribute('data-evaluation-id', '0');
            row.innerHTML = `
                <td><input type="text" class="form-control" name="student_evaluation_period[]" value="${escapeHTML(period)}" required></td>
                <td><input type="number" class="form-control rating-input" name="student_rating_1[]" placeholder="0.00" required></td>
                <td><input type="number" class="form-control rating-input" name="student_rating_2[]" placeholder="0.00" required></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
                            data-request-id="${requestId}"
                            data-table-type="student">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="evidence_file_1[]" value="">
                    <input type="hidden" name="evidence_file_2[]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks" data-first-remark="" data-second-remark="">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
            `;
            tableBody.appendChild(row);
        });
    }

    function addDefaultSupervisorRows(tableBody) {
        const defaultPeriods = ["AY 2019 - 2020", "AY 2020 - 2021", "AY 2021 - 2022", "AY 2022 - 2023"];
        const requestId = document.getElementById('request_id').value.trim();
        defaultPeriods.forEach(period => {
            const row = document.createElement('tr');
            row.setAttribute('data-evaluation-id', '0');
            row.innerHTML = `
                <td><input type="text" class="form-control" name="supervisor_evaluation_period[]" value="${escapeHTML(period)}" required></td>
                <td><input type="number" class="form-control rating-input" name="supervisor_rating_1[]" placeholder="0.00" required></td>
                <td><input type="number" class="form-control rating-input" name="supervisor_rating_2[]" placeholder="0.00" required></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
                            data-request-id="${requestId}"
                            data-table-type="supervisor">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="evidence_file_1[]" value="">
                    <input type="hidden" name="evidence_file_2[]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks" data-first-remark="" data-second-remark="">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
            `;
            tableBody.appendChild(row);
        });
    }

    function populateStudentTable(studentData) {
        const tableBody = document.querySelector('#student-evaluation-table tbody');
        const requestId = document.getElementById('request_id').value.trim();
        tableBody.innerHTML = '';

        if (!studentData || studentData.length === 0) {
            addDefaultStudentRows(tableBody);
            return;
        }

        studentData.forEach(item => {
            const tr = document.createElement('tr');
            tr.setAttribute('data-evaluation-id', item.evaluation_id);

            let evidenceCellContent = `
                <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
                        data-request-id="${requestId}"
                        data-evaluation-id="${item.evaluation_id}"
                        data-table-type="student">
                    ${item.evidence_file_1 || item.evidence_file_2 ? 'Change Evidence' : 'Upload Evidence'}
                </button>
                <input type="hidden" name="evaluation_id[]" value="${item.evaluation_id}">
                <input type="hidden" name="evidence_file_1[]" value="${item.evidence_file_1 || ''}">
                <input type="hidden" name="evidence_file_2[]" value="${item.evidence_file_2 || ''}">
            `;

            tr.innerHTML = `
                <td><input type="text" class="form-control" name="student_evaluation_period[]" value="${escapeHTML(item.evaluation_period || '')}" required></td>
                <td><input type="number" class="form-control rating-input" name="student_rating_1[]" value="${item.first_semester_rating || ''}" placeholder="0.00" required></td>
                <td><input type="number" class="form-control rating-input" name="student_rating_2[]" value="${item.second_semester_rating || ''}" placeholder="0.00" required></td>
                <td>
                    ${evidenceCellContent}
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks" data-first-remark="${escapeHTML(item.remarks_first || '')}" data-second-remark="${escapeHTML(item.remarks_second || '')}">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
            `;

            tableBody.appendChild(tr);
        });
    }

    function populateSupervisorTable(supervisorData) {
        const tableBody = document.querySelector('#supervisor-evaluation-table tbody');
        const requestId = document.getElementById('request_id').value.trim();
        tableBody.innerHTML = '';

        if (!supervisorData || supervisorData.length === 0) {
            addDefaultSupervisorRows(tableBody);
            return;
        }

        supervisorData.forEach(item => {
            const tr = document.createElement('tr');
            tr.setAttribute('data-evaluation-id', item.evaluation_id);

            let evidenceCellContent = `
                <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
                        data-request-id="${requestId}"
                        data-evaluation-id="${item.evaluation_id}"
                        data-table-type="supervisor">
                    ${item.evidence_file_1 || item.evidence_file_2 ? 'Change Evidence' : 'Upload Evidence'}
                </button>
                <input type="hidden" name="evaluation_id[]" value="${item.evaluation_id}">
                <input type="hidden" name="evidence_file_1[]" value="${item.evidence_file_1 || ''}">
                <input type="hidden" name="evidence_file_2[]" value="${item.evidence_file_2 || ''}">
            `;

            tr.innerHTML = `
                <td><input type="text" class="form-control" name="supervisor_evaluation_period[]" value="${escapeHTML(item.evaluation_period || '')}" required></td>
                <td><input type="number" class="form-control rating-input" name="supervisor_rating_1[]" value="${item.first_semester_rating || ''}" placeholder="0.00" required></td>
                <td><input type="number" class="form-control rating-input" name="supervisor_rating_2[]" value="${item.second_semester_rating || ''}" placeholder="0.00" required></td>
                <td>
                    ${evidenceCellContent}
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

        // Populate the overall/faculty ratings
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

    // Expose a fetch function that teaching.js calls
    CriterionA.fetchCriterionA = function (requestId) {
        return fetch(`../../includes/career_progress_tracking/teaching/fetch_criterion_a.php?request_id=${requestId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    populateStudentTable(data.student_evaluations);
                    populateSupervisorTable(data.supervisor_evaluations);
                    populateMetadata(data.metadata);
                    return data;
                } else {
                    console.error('Error:', data.error);
                    showMessage('Failed to fetch data: ' + data.error);
                    addDefaultStudentRows(document.querySelector('#student-evaluation-table tbody'));
                    addDefaultSupervisorRows(document.querySelector('#supervisor-evaluation-table tbody'));
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                showMessage('Failed to fetch data. Please check the console for details.');
                addDefaultStudentRows(document.querySelector('#student-evaluation-table tbody'));
                addDefaultSupervisorRows(document.querySelector('#supervisor-evaluation-table tbody'));
            });
    };

    // We'll set up everything on DOMContentLoaded within CriterionA.init
    CriterionA.init = function() {
        const form = document.getElementById('criterion-a-form');
        const saveBtn = document.getElementById('save-criterion-a');

        // Moved the initialization of modals to a centralized location 
        // or within a DOMContentLoaded event listener at the end of the HTML.

        // === DELETION TRACKING AND DIRTY FLAG START ===
        let deletedEvaluations = {
            student: [],
            supervisor: []
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
        $('#student-evaluation-table, #supervisor-evaluation-table').on('click', '.upload-evidence-btn-a', function() {
            const button = $(this);
            const requestID = button.data('request-id');
            const evaluationID = button.data('evaluation-id');
            const tableType = button.data('table-type');
            const row = button.closest('tr');

            // Check if evaluation ID exists (not a new row)
           
            const existingFile1 = row.find('input[name="evidence_file_1[]"]').val();
            const existingFile2 = row.find('input[name="evidence_file_2[]"]').val();

            $('#modal_request_id').val(requestID);
            $('#modal_evaluation_id').val(evaluationID);
            $('#modal_table_type').val(tableType);

            $('#firstSemesterFile').val('');
            $('#secondSemesterFile').val('');

            const filename1 = existingFile1;
            const filename2 = existingFile2;
            $('#firstSemesterFilename').text(filename1 ? filename1.split('/').pop() : '');
            $('#secondSemesterFilename').text(filename2 ? filename2.split('/').pop() : '');

            uploadEvidenceModalA.show();
        });

        $('#firstSemesterFile').on('change', function() {
            $('#firstSemesterFilename').text(this.files[0] ? this.files[0].name : '');
        });
        $('#secondSemesterFile').on('change', function() {
            $('#secondSemesterFilename').text(this.files[0] ? this.files[0].name : '');
        });

        $('#uploadEvidenceBtn').on('click', function() {
            const formData = new FormData($('#evidenceUploadForm')[0]);
            const firstSemesterFile = $('#firstSemesterFile')[0].files[0];
            const secondSemesterFile = $('#secondSemesterFile')[0].files[0];

            if (!firstSemesterFile && !secondSemesterFile) {
                showMessage('Please select at least one file to upload.');
                return;
            }

            const validFileTypes = [
                'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'image/jpeg', 'image/png', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ];

            if (firstSemesterFile && !validFileTypes.includes(firstSemesterFile.type)) {
                showMessage('Invalid file type for 1st Semester. Allowed types: PDF, DOC, DOCX, JPG, JPEG, PNG, XLSX, XLS');
                return;
            }
            if (secondSemesterFile && !validFileTypes.includes(secondSemesterFile.type)) {
                showMessage('Invalid file type for 2nd Semester. Allowed types: PDF, DOC, DOCX, JPG, JPEG, PNG, XLSX, XLS');
                return;
            }

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

                        row.find('input[name="evidence_file_1[]"]').val(response.paths.sem1);
                        row.find('input[name="evidence_file_2[]"]').val(response.paths.sem2);

                        const newContent = `
                            <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
                                    data-request-id="${$('#modal_request_id').val()}"
                                    data-evaluation-id="${evaluationID}"
                                    data-table-type="${tableType}">
                                Change Evidence
                            </button>`;
                        row.find('td:eq(3)').html(newContent);

                        uploadEvidenceModalA.hide();
                        markFormAsDirty();
                        showMessage('Files uploaded successfully!');

                        // Refresh table data
                        const requestId = $('#request_id').val();
                        CriterionA.fetchCriterionA(requestId);
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

        $('#deleteFile1, #deleteFile2').on('click', function() {
            const semester = $(this).data('semester');
            const evaluationID = $('#modal_evaluation_id').val();
            const tableType = $('#modal_table_type').val();
            const requestID = $('#modal_request_id').val();
            const table = $(`#${tableType}-evaluation-table`);
            const row = table.find(`tr[data-evaluation-id="${evaluationID}"]`);

            if (!confirm(`Are you sure you want to delete the file for ${semester}?`)) {
                return;
            }

            $.ajax({
                url: '../../includes/career_progress_tracking/teaching/delete_evidence.php', 
                type: 'POST',
                data: {
                    request_id: requestID,
                    evaluation_id: evaluationID,
                    table_type: tableType,
                    semester: semester
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        row.find(`input[name="evidence_file_${semester.slice(-1)}[]"]`).val('');

                        const newContent = `
                            <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
                                    data-request-id="${requestID}"
                                    data-evaluation-id="${evaluationID}"
                                    data-table-type="${tableType}">
                                Upload Evidence
                            </button>`;
                        row.find('td:eq(3)').html(newContent);

                        $(`#${semester}Filename`).text('');
                        showMessage(`File for ${semester} deleted successfully.`);
                        setTimeout(function() {
                            $('#messageModal').modal('hide');
                        }, 2000);

                        uploadEvidenceModalA.hide();
                        markFormAsDirty();

                        const requestId = $('#request_id').val();
                        CriterionA.fetchCriterionA(requestId);
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
        let rowToDelete = null;
        let evaluationIdToDelete = null;
        let tableToDeleteFrom = null;

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-row')) {
                rowToDelete = e.target.closest('tr');
                evaluationIdToDelete = rowToDelete.getAttribute('data-evaluation-id') || '0';

                const table = e.target.closest('table');
                if (table.id === 'student-evaluation-table') {
                    tableToDeleteFrom = 'student';
                } else if (table.id === 'supervisor-evaluation-table') {
                    tableToDeleteFrom = 'supervisor';
                } else {
                    tableToDeleteFrom = null;
                }

                deleteRowModal.show();
            }
        });

        document.getElementById('confirm-delete-row').addEventListener('click', function() {
            if (rowToDelete) {
                deleteRowModal.hide();

                if (evaluationIdToDelete !== '0' && tableToDeleteFrom) {
                    deletedEvaluations[tableToDeleteFrom].push(evaluationIdToDelete);
                }
                rowToDelete.remove();
                rowToDelete = null;
                evaluationIdToDelete = null;
                tableToDeleteFrom = null;

                calculateOverallScores();
                markFormAsDirty();

                deleteSuccessModal.show();
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

            remarksModalA.show();
        });
        // === REMARKS HANDLER END ===

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

        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('rating-input')) {
                calculateOverallScores();
                markFormAsDirty();
            }
        });
        document.addEventListener('change', function(e) {
            if (e.target.matches('#student-divisor, #student-reason, #supervisor-divisor, #supervisor-reason')) {
                calculateOverallScores();
                markFormAsDirty();
            }
        });
        // === CALCULATION END ===

        // === ADD ROWS START ===
        document.querySelectorAll('#criterion-a-form .add-row').forEach(addBtn => { // Updated selector
            addBtn.addEventListener('click', function() {
                const tableId = this.getAttribute('data-table-id'); // Directly get table ID from the button
                const tableBody = document.querySelector(`#${tableId} tbody`);
                const requestId = document.getElementById('request_id').value.trim();

                const isStudent = tableId.includes('student');
                const periodName = isStudent ? 'student_evaluation_period[]' : 'supervisor_evaluation_period[]';
                const rating1Name = isStudent ? 'student_rating_1[]' : 'supervisor_rating_1[]';
                const rating2Name = isStudent ? 'student_rating_2[]' : 'supervisor_rating_2[]';
                const evidenceFile1Name = 'evidence_file_1[]';
                const evidenceFile2Name = 'evidence_file_2[]';

                const new_evaluation_id = requestId + '_new_' + Date.now();

                const newRow = document.createElement('tr');
                newRow.setAttribute('data-evaluation-id', '0');

                newRow.innerHTML = `
                    <td>
                        <input type="text" class="form-control" name="${periodName}" value="AY ${new Date().getFullYear()} - ${new Date().getFullYear() + 1}" required>
                    </td>
                    <td>
                        <input type="number" class="form-control rating-input" name="${rating1Name}" placeholder="0.00" required>
                    </td>
                    <td>
                        <input type="number" class="form-control rating-input" name="${rating2Name}" placeholder="0.00" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
                                data-request-id="${requestId}"
                                data-evaluation-id="${new_evaluation_id}"
                                data-table-type="${isStudent ? 'student' : 'supervisor'}">
                            Upload Evidence
                        </button>
                        <input type="hidden" name="${evidenceFile1Name}" value="">
                        <input type="hidden" name="${evidenceFile2Name}" value="">
                    </td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm view-remarks" data-first-remark="" data-second-remark="">View Remarks</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button>
                    </td>
                `;

                tableBody.appendChild(newRow);
                calculateOverallScores();
                markFormAsDirty();
            });
        });
        // === ADD ROWS END ===

        // === SAVING PROCESS START ===
        function gatherPayload(requestId) {
            const studentEvaluations = [];
            const domRowSelectors = {};

            document.querySelectorAll('#student-evaluation-table tbody tr').forEach(row => {
                const evaluation_id = row.getAttribute('data-evaluation-id');
                const evaluation_period = row.querySelector('input[name="student_evaluation_period[]"]').value.trim();
                const rating1Input = row.querySelector('input[name="student_rating_1[]"]');
                const rating2Input = row.querySelector('input[name="student_rating_2[]"]');
                const remarks_first = row.querySelector('.view-remarks').getAttribute('data-first-remark') || '';
                const remarks_second = row.querySelector('.view-remarks').getAttribute('data-second-remark') || '';
                const evidenceFile1 = row.querySelector('input[name="evidence_file_1[]"]').value;
                const evidenceFile2 = row.querySelector('input[name="evidence_file_2[]"]').value;

                let selector;
                if (evaluation_id === '0') {
                    selector = `tr[data-evaluation-id='${evaluation_id}']`;
                } else {
                    const prefix = requestId + '_' + evaluation_period.replace(/\s+/g, '') + '_student_';
                    selector = `tr[data-evaluation-id^='${prefix}']`;
                }

                domRowSelectors[selector] = {
                    evidence_file_1: evidenceFile1,
                    evidence_file_2: evidenceFile2
                };

                studentEvaluations.push({
                    evaluation_id,
                    evaluation_period,
                    first_semester_rating: parseFloat(rating1Input.value) || 0,
                    second_semester_rating: parseFloat(rating2Input.value) || 0,
                    remarks_first,
                    remarks_second
                });
            });

            const supervisorEvaluations = [];
            document.querySelectorAll('#supervisor-evaluation-table tbody tr').forEach(row => {
                const evaluation_id = row.getAttribute('data-evaluation-id');
                if (!evaluation_id) return;
                const evaluation_period = row.querySelector('input[name="supervisor_evaluation_period[]"]').value.trim();
                const rating1Input = row.querySelector('input[name="supervisor_rating_1[]"]');
                const rating2Input = row.querySelector('input[name="supervisor_rating_2[]"]');
                const remarks_first = row.querySelector('.view-remarks').getAttribute('data-first-remark') || '';
                const remarks_second = row.querySelector('.view-remarks').getAttribute('data-second-remark') || '';
                const evidenceFile1 = row.querySelector('input[name="evidence_file_1[]"]').value;
                const evidenceFile2 = row.querySelector('input[name="evidence_file_2[]"]').value;

                let selector;
                if (evaluation_id === '0') {
                    selector = `tr[data-evaluation-id='${evaluation_id}']`;
                } else {
                    const prefix = requestId + '_' + evaluation_period.replace(/\s+/g, '') + '_supervisor_';
                    selector = `tr[data-evaluation-id^='${prefix}']`;
                }

                domRowSelectors[selector] = {
                    evidence_file_1: evidenceFile1,
                    evidence_file_2: evidenceFile2
                };

                supervisorEvaluations.push({
                    evaluation_id,
                    evaluation_period,
                    first_semester_rating: parseFloat(rating1Input.value) || 0,
                    second_semester_rating: parseFloat(rating2Input.value) || 0,
                    remarks_first,
                    remarks_second
                });
            });

            const student_overall_rating = parseFloat(document.getElementById('student_overall_score').value) || 0;
            const student_faculty_rating = parseFloat(document.getElementById('student_faculty_overall_score').value) || 0;
            const supervisor_overall_rating = parseFloat(document.getElementById('supervisor-overall-score').value) || 0;
            const supervisor_faculty_rating = parseFloat(document.getElementById('supervisor-faculty-overall-score').value) || 0;

            return {
                request_id: parseInt(requestId, 10),
                student_divisor: parseInt(document.getElementById('student-divisor').value, 10) || 0,
                student_reason: document.getElementById('student-reason').value,
                supervisor_divisor: parseInt(document.getElementById('supervisor-divisor').value, 10) || 0,
                supervisor_reason: document.getElementById('supervisor-reason').value,
                student_evaluations: studentEvaluations,
                supervisor_evaluations: supervisorEvaluations,
                student_overall_rating,
                student_faculty_rating,
                supervisor_overall_rating,
                supervisor_faculty_rating,
                deleted_evaluations: deletedEvaluations,
                dom_row_selectors: domRowSelectors
            };
        }

        function saveCriterionA() {
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }

            calculateOverallScores();
            const requestId = document.getElementById('request_id').value.trim();
            if (!requestId || parseInt(requestId) <= 0) {
                showMessage('Please select a valid evaluation ID.');
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
                    showMessage('Criterion A data saved successfully!');
                    deletedEvaluations = { student: [], supervisor: [] };
                    markFormAsClean();
                    CriterionA.fetchCriterionA(requestId);
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
            saveCriterionA();
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
                    unsavedChangesModal.show();
                }
            } else if (button && button.getAttribute('data-action') === 'navigate') {
                if (isFormDirty) {
                    e.preventDefault();
                    intendedNavigationURL = button.getAttribute('data-href');
                    unsavedChangesModal.show();
                }
            }
        });
        // === UNSAVED CHANGES PROMPT END ===

        calculateOverallScores();
        markFormAsClean(); // Mark the form clean on initial load
    };

    // On DOM load, initialize everything
    document.addEventListener('DOMContentLoaded', function () {
        CriterionA.init();

        // Initialize Modals
        window.messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
        window.saveErrorModal = new bootstrap.Modal(document.getElementById('saveErrorModal'));
        window.uploadEvidenceModalA = new bootstrap.Modal(document.getElementById('uploadEvidenceModalA'));
        window.remarksModalA = new bootstrap.Modal(document.getElementById('remarksModalA'));
        window.deleteRowModal = new bootstrap.Modal(document.getElementById('deleteRowModal'));
        window.deleteSuccessModal = new bootstrap.Modal(document.getElementById('deleteSuccessModal'));
        window.unsavedChangesModal = new bootstrap.Modal(document.getElementById('unsavedChangesModal'));
        window.uploadSingleEvidenceModalB = new bootstrap.Modal(document.getElementById('uploadSingleEvidenceModalB'));
        document.getElementById('view-remarks-c').addEventListener('click', () => showModal('remarksModalC'));
    });

    // Expose the namespace
    window.CriterionA = CriterionA;
}(window, document, jQuery));