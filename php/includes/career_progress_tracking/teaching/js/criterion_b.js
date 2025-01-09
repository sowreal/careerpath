// careerpath/php/includes/career_progress_tracking/teaching/criterion_b.js
// Encapsulate Criterion B logic in a namespace to avoid conflicts.
(function (window, document, $) {
    'use strict';

    // Create a namespace object
    var CriterionB = {};

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

    // For Sole Authorship
    function addDefaultSoleAuthorshipRows(tableBody) {
        const requestIdB = document.getElementById('request_id_b')?.value.trim() || '0';
        // Create, for example, 3 default blank rows
        for (let i = 1; i <= 3; i++) {
            const row = document.createElement('tr');
            row.setAttribute('data-sole-id', '0');
            row.innerHTML = `
                <td>${i}</td>
                <td><input type="text" class="form-control" name="kra1_b_sole_authorship[new_${Date.now()}][title]" placeholder="Title of IM"></td>
                <td>
                    <select class="form-select" name="kra1_b_sole_authorship[new_${Date.now()}][type]">
                        <option value="">SELECT OPTION</option>
                        <option value="Textbook">Textbook</option>
                        <option value="Textbook Chapter">Textbook Chapter</option>
                        <option value="Manual/Module">Manual/Module</option>
                        <option value="Multimedia Teaching Material">Multimedia Teaching Material</option>
                        <option value="Testing Material">Testing Material</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra1_b_sole_authorship[new_${Date.now()}][reviewer]" placeholder="Reviewer"></td>
                <td><input type="text" class="form-control" name="kra1_b_sole_authorship[new_${Date.now()}][publisher]" placeholder="Publisher/Repo"></td>
                <td><input type="date" class="form-control" name="kra1_b_sole_authorship[new_${Date.now()}][date_published]"></td>
                <td><input type="date" class="form-control" name="kra1_b_sole_authorship[new_${Date.now()}][date_approved]"></td>
                <td><input type="number" class="form-control score-input" name="kra1_b_sole_authorship[new_${Date.now()}][score]" placeholder="0" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn"
                        data-subcriterion="sole" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra1_b_sole_authorship[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
            `;
            tableBody.appendChild(row);
        }
    }

    // For Co-Authorship
    function addDefaultCoAuthorshipRows(tableBody) {
        const requestIdB = document.getElementById('request_id_b')?.value.trim() || '0';
        for (let i = 1; i <= 3; i++) {
            const row = document.createElement('tr');
            row.setAttribute('data-co-id', '0');
            row.innerHTML = `
                <td>${i}</td>
                <td><input type="text" class="form-control" name="kra1_b_co_authorship[new_${Date.now()}][title]" placeholder="Title of IM"></td>
                <td>
                    <select class="form-select" name="kra1_b_co_authorship[new_${Date.now()}][type]">
                        <option value="">SELECT OPTION</option>
                        <option value="Textbook">Textbook</option>
                        <option value="Textbook Chapter">Textbook Chapter</option>
                        <option value="Manual/Module">Manual/Module</option>
                        <option value="Multimedia Teaching Material">Multimedia Teaching Material</option>
                        <option value="Testing Material">Testing Material</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra1_b_co_authorship[new_${Date.now()}][reviewer]" placeholder="Reviewer"></td>
                <td><input type="text" class="form-control" name="kra1_b_co_authorship[new_${Date.now()}][publisher]" placeholder="Publisher/Repo"></td>
                <td><input type="date" class="form-control" name="kra1_b_co_authorship[new_${Date.now()}][date_published]"></td>
                <td><input type="date" class="form-control" name="kra1_b_co_authorship[new_${Date.now()}][date_approved]"></td>
                <td><input type="number" class="form-control" name="kra1_b_co_authorship[new_${Date.now()}][contribution_percentage]" placeholder="0.00"></td>
                <td><input type="number" class="form-control score-input" name="kra1_b_co_authorship[new_${Date.now()}][score]" placeholder="0" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn"
                        data-subcriterion="co" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra1_b_co_authorship[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
            `;
            tableBody.appendChild(row);
        }
    }

    // For Academic Programs
    function addDefaultAcademicProgramsRows(tableBody) {
        const requestIdB = document.getElementById('request_id_b')?.value.trim() || '0';
        for (let i = 1; i <= 3; i++) {
            const row = document.createElement('tr');
            row.setAttribute('data-acad-id', '0');
            row.innerHTML = `
                <td>${i}</td>
                <td><input type="text" class="form-control" name="kra1_b_academic_programs[new_${Date.now()}][program_name]" placeholder="Name of Program"></td>
                <td>
                    <select class="form-select" name="kra1_b_academic_programs[new_${Date.now()}][program_type]">
                        <option value="">SELECT OPTION</option>
                        <option value="New Program">New Program</option>
                        <option value="Revised Program">Revised Program</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra1_b_academic_programs[new_${Date.now()}][board_approval]" placeholder="Board Res. No."></td>
                <td><input type="text" class="form-control" name="kra1_b_academic_programs[new_${Date.now()}][academic_year]" placeholder="e.g. 2020-2021"></td>
                <td>
                    <select class="form-select" name="kra1_b_academic_programs[new_${Date.now()}][role]">
                        <option value="">SELECT OPTION</option>
                        <option value="Lead">Lead</option>
                        <option value="Contributor">Contributor</option>
                    </select>
                </td>
                <td><input type="number" class="form-control score-input" name="kra1_b_academic_programs[new_${Date.now()}][score]" placeholder="0" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn"
                        data-subcriterion="acad" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra1_b_academic_programs[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
            `;
            tableBody.appendChild(row);
        }
    }


    function showMessage(message) {
        // Reuse or adapt your existing modal (messageModal) from the A script
        $('#messageModalBody').text(message);
        var messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
        messageModal.show();
    }
    window.showMessage = showMessage; // Make it accessible if needed by other scripts

    // === POPULATE TABLES ===
    // B.1 Sole Authorship
    function populateSoleAuthorship(soleData) {
        var tableBody = document.querySelector('#sole-authorship-table tbody');
        var requestId = document.getElementById('request_id_b').value.trim();
        tableBody.innerHTML = '';

        if (!soleData || soleData.length === 0) {
            addDefaultSoleAuthorshipRows(tableBody);
            return;
        }

        soleData.forEach(function (item, index) {
            var tr = document.createElement('tr');
            tr.setAttribute('data-sole-id', item.sole_authorship_id);

            var evidenceButtonLabel = item.evidence_file ? 'Change Evidence' : 'Upload Evidence';

            var rowHTML = `
                <td>${index + 1}</td>
                <td><input type="text" class="form-control" name="kra1_b_sole_authorship[${index}][title]" value="${escapeHTML(item.title)}"></td>
                <td>
                    <select class="form-select" name="kra1_b_sole_authorship[${index}][type]">
                        <option value="">SELECT OPTION</option>
                        <option value="Textbook" ${item.type === 'Textbook' ? 'selected' : ''}>Textbook</option>
                        <option value="Textbook Chapter" ${item.type === 'Textbook Chapter' ? 'selected' : ''}>Textbook Chapter</option>
                        <option value="Manual/Module" ${item.type === 'Manual/Module' ? 'selected' : ''}>Manual/Module</option>
                        <option value="Multimedia Teaching Material" ${item.type === 'Multimedia Teaching Material' ? 'selected' : ''}>Multimedia Teaching Material</option>
                        <option value="Testing Material" ${item.type === 'Testing Material' ? 'selected' : ''}>Testing Material</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra1_b_sole_authorship[${index}][reviewer]" value="${escapeHTML(item.reviewer || '')}"></td>
                <td><input type="text" class="form-control" name="kra1_b_sole_authorship[${index}][publisher]" value="${escapeHTML(item.publisher || '')}"></td>
                <td><input type="date" class="form-control" name="kra1_b_sole_authorship[${index}][date_published]" value="${item.date_published || ''}"></td>
                <td><input type="date" class="form-control" name="kra1_b_sole_authorship[${index}][date_approved]" value="${item.date_approved || ''}"></td>
                <td><input type="number" class="form-control score-input" name="kra1_b_sole_authorship[${index}][score]" value="${item.score || ''}" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                        data-subcriterion="sole" 
                        data-record-id="${item.sole_authorship_id}" 
                        data-file-path="${escapeHTML(item.evidence_file || '')}">
                        ${evidenceButtonLabel}
                    </button>
                    <input type="hidden" name="kra1_b_sole_authorship[${index}][evidence_file]" value="${escapeHTML(item.evidence_file || '')}">
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button>
                </td>
            `;
            tr.innerHTML = rowHTML;
            tableBody.appendChild(tr);
        });
    }

    // B.2 Co-authorship
    function populateCoAuthorship(coData) {
        var tableBody = document.querySelector('#co-authorship-table tbody');
        var requestId = document.getElementById('request_id_b').value.trim();
        tableBody.innerHTML = '';

        if (!coData || coData.length === 0) {
            addDefaultCoAuthorshipRows(tableBody);
            return;
        }

        coData.forEach(function (item, index) {
            var tr = document.createElement('tr');
            tr.setAttribute('data-co-id', item.co_authorship_id);

            var evidenceButtonLabel = item.evidence_file ? 'Change Evidence' : 'Upload Evidence';

            var rowHTML = `
                <td>${index + 1}</td>
                <td><input type="text" class="form-control" name="kra1_b_co_authorship[${index}][title]" value="${escapeHTML(item.title)}"></td>
                <td>
                    <select class="form-select" name="kra1_b_co_authorship[${index}][type]">
                        <option value="">SELECT OPTION</option>
                        <option value="Textbook" ${item.type === 'Textbook' ? 'selected' : ''}>Textbook</option>
                        <option value="Textbook Chapter" ${item.type === 'Textbook Chapter' ? 'selected' : ''}>Textbook Chapter</option>
                        <option value="Manual/Module" ${item.type === 'Manual/Module' ? 'selected' : ''}>Manual/Module</option>
                        <option value="Multimedia Teaching Material" ${item.type === 'Multimedia Teaching Material' ? 'selected' : ''}>Multimedia Teaching Material</option>
                        <option value="Testing Material" ${item.type === 'Testing Material' ? 'selected' : ''}>Testing Material</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra1_b_co_authorship[${index}][reviewer]" value="${escapeHTML(item.reviewer || '')}"></td>
                <td><input type="text" class="form-control" name="kra1_b_co_authorship[${index}][publisher]" value="${escapeHTML(item.publisher || '')}"></td>
                <td><input type="date" class="form-control" name="kra1_b_co_authorship[${index}][date_published]" value="${item.date_published || ''}"></td>
                <td><input type="date" class="form-control" name="kra1_b_co_authorship[${index}][date_approved]" value="${item.date_approved || ''}"></td>
                <td><input type="number" class="form-control" name="kra1_b_co_authorship[${index}][contribution_percentage]" value="${item.contribution_percentage || ''}"></td>
                <td><input type="number" class="form-control score-input" name="kra1_b_co_authorship[${index}][score]" value="${item.score || ''}" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                        data-subcriterion="co" 
                        data-record-id="${item.co_authorship_id}" 
                        data-file-path="${escapeHTML(item.evidence_file || '')}">
                        ${evidenceButtonLabel}
                    </button>
                    <input type="hidden" name="kra1_b_co_authorship[${index}][evidence_file]" value="${escapeHTML(item.evidence_file || '')}">
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button>
                </td>
            `;
            tr.innerHTML = rowHTML;
            tableBody.appendChild(tr);
        });
    }

    // B.3 Academic Programs
    function populateAcademicPrograms(programData) {
        var tableBody = document.querySelector('#academic-programs-table tbody');
        var requestId = document.getElementById('request_id_b').value.trim();
        tableBody.innerHTML = '';

        if (!programData || programData.length === 0) {
            addDefaultAcademicProgramsRows(tableBody);
            return;
        }

        programData.forEach(function (item, index) {
            var tr = document.createElement('tr');
            tr.setAttribute('data-acad-id', item.academic_prog_id);

            var evidenceButtonLabel = item.evidence_file ? 'Change Evidence' : 'Upload Evidence';

            var rowHTML = `
                <td>${index + 1}</td>
                <td><input type="text" class="form-control" name="kra1_b_academic_programs[${index}][program_name]" value="${escapeHTML(item.program_name)}"></td>
                <td>
                    <select class="form-select" name="kra1_b_academic_programs[${index}][program_type]">
                        <option value="">SELECT OPTION</option>
                        <option value="New Program" ${item.program_type === 'New Program' ? 'selected' : ''}>New Program</option>
                        <option value="Revised Program" ${item.program_type === 'Revised Program' ? 'selected' : ''}>Revised Program</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra1_b_academic_programs[${index}][board_approval]" value="${escapeHTML(item.board_approval || '')}"></td>
                <td><input type="text" class="form-control" name="kra1_b_academic_programs[${index}][academic_year]" value="${escapeHTML(item.academic_year || '')}"></td>
                <td>
                    <select class="form-select" name="kra1_b_academic_programs[${index}][role]">
                        <option value="">SELECT OPTION</option>
                        <option value="Lead" ${item.role === 'Lead' ? 'selected' : ''}>Lead</option>
                        <option value="Contributor" ${item.role === 'Contributor' ? 'selected' : ''}>Contributor</option>
                    </select>
                </td>
                <td><input type="number" class="form-control score-input" name="kra1_b_academic_programs[${index}][score]" value="${item.score || ''}" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                        data-subcriterion="acad" 
                        data-record-id="${item.academic_prog_id}" 
                        data-file-path="${escapeHTML(item.evidence_file || '')}">
                        ${evidenceButtonLabel}
                    </button>
                    <input type="hidden" name="kra1_b_academic_programs[${index}][evidence_file]" value="${escapeHTML(item.evidence_file || '')}">
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button>
                </td>
            `;
            tr.innerHTML = rowHTML;
            tableBody.appendChild(tr);
        });
    }

    // Populate totals from metadata (if any)
    function populateMetadata(metadata) {
        // If your B metadata table has total fields, put them here.
        // Example placeholders:
        if (!metadata) {
            document.getElementById('kra1_b_sole_authorship_total').value = '';
            document.getElementById('kra1_b_co_authorship_total').value = '';
            document.getElementById('kra1_b_academic_programs_total').value = '';
            return;
        }
        document.getElementById('kra1_b_sole_authorship_total').value = metadata.sole_authorship_total || '';
        document.getElementById('kra1_b_co_authorship_total').value = metadata.co_authorship_total || '';
        document.getElementById('kra1_b_academic_programs_total').value = metadata.academic_programs_total || '';
    }

    // === MAIN FETCH FUNCTION (similar to Criterion A) ===
    CriterionB.fetchCriterionB = function (requestId) {
        return fetch(`../../includes/career_progress_tracking/teaching/fetch_criterion_b.php?request_id=${requestId}`)
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (data.success) {
                    // Populate each sub-criterion table
                    populateSoleAuthorship(data.sole_authorship || []);
                    populateCoAuthorship(data.co_authorship || []);
                    populateAcademicPrograms(data.academic_programs || []);
                    populateMetadata(data.metadata);
                    return data;
                } else {
                    console.error('Error:', data.error);
                    showMessage('Failed to fetch Criterion B data: ' + data.error);
                }
            })
            .catch(function (error) {
                console.error('Error fetching data:', error);
                showMessage('Failed to fetch Criterion B data. Check console for details.');
            });
    };

    // === INIT FUNCTION ===
    CriterionB.init = function () {
        var form = document.getElementById('criterion-b-form');
        var saveBtn = document.getElementById('save-criterion-b');
        var deleteRowModal = new bootstrap.Modal(document.getElementById('deleteRowModal'));
        var deleteSuccessModal = new bootstrap.Modal(document.getElementById('deleteSuccessModal'));
        var uploadSingleEvidenceModal = new bootstrap.Modal(document.getElementById('uploadSingleEvidenceModalB'));

        // Track deleted records
        var deletedRecords = {
            sole: [],
            co: [],
            acad: []
        };

        // Dirty flag
        var isFormDirty = false;
        function markFormAsDirty() {
            isFormDirty = true;
            saveBtn.classList.add('btn-warning');
        }
        function markFormAsClean() {
            isFormDirty = false;
            saveBtn.classList.remove('btn-warning');
        }

        // CALCULATION HELPER FUNCTIONS
        // 1) Row-by-Row Calculation Helper Functions
        function getSoleAuthorshipScore(type) {
            switch (type) {
                case 'Textbook':                     return 30;
                case 'Textbook Chapter':             return 10;
                case 'Manual/Module':                return 16;
                case 'Multimedia Teaching Material': return 16;
                case 'Testing Material':             return 10;
                default:                             return 0;
            }
        }
        function getCoAuthorshipScore(type, contribution) {
            return getSoleAuthorshipScore(type) * (contribution || 0);
        }
        function getAcademicProgramScore(role) {
            switch (role) {
                case 'Lead':        return 10;
                case 'Contributor': return 5;
                default:            return 0;
            }
        }
        // 2) Compute & Set the Row's "score" in Real Time
        function computeRowScore(row, tableId) {
            // Find the row's "score" input (which should be readonly)
            const scoreInput = row.querySelector('input[name*="[score]"]');
            if (!scoreInput) return;

            let computedScore = 0;
            if (tableId === 'sole-authorship-table') {
                // For Sole Authorship: based on "type"
                const materialType = row.querySelector('select[name*="[type]"]')?.value || '';
                computedScore = getSoleAuthorshipScore(materialType);
                markFormAsDirty();

            } else if (tableId === 'co-authorship-table') {
                // For Co-Authorship: material type + contribution
                const materialType = row.querySelector('select[name*="[type]"]')?.value || '';
                const contrib      = parseFloat(row.querySelector('input[name*="[contribution"]')?.value || 0);
                computedScore = getCoAuthorshipScore(materialType, contrib);
                markFormAsDirty();

            } else if (tableId === 'academic-programs-table') {
                // For Academic Programs: role
                const role = row.querySelector('select[name*="[role]"]')?.value || '';
                computedScore = getAcademicProgramScore(role);
                markFormAsDirty();
            }

            // Write the computed score into the row's score input (readonly)
            scoreInput.value = computedScore.toFixed(2);
            markFormAsDirty();
        }
        // 3) Sum Each Table and Update the "Totals"
        function recalcSoleAuthorship() {
            let total = 0;
            $('#sole-authorship-table tbody tr').each(function () {
                const score = parseFloat($(this).find('input[name*="[score]"]').val()) || 0;
                total += score;
            });
            $('#kra1_b_sole_authorship_total').val(total.toFixed(2));
        }
        function recalcCoAuthorship() {
            let total = 0;
            $('#co-authorship-table tbody tr').each(function () {
                const score = parseFloat($(this).find('input[name*="[score]"]').val()) || 0;
                total += score;
            });
            $('#kra1_b_co_authorship_total').val(total.toFixed(2));
        }
        function recalcAcademicPrograms() {
            let total = 0;
            $('#academic-programs-table tbody tr').each(function () {
                const score = parseFloat($(this).find('input[name*="[score]"]').val()) || 0;
                total += score;
            });
            $('#kra1_b_academic_programs_total').val(total.toFixed(2));
        }
        // 4) Recalc All Tables and Mark Form Dirty
        function recalcAll() {
            recalcSoleAuthorship();
            recalcCoAuthorship();
            recalcAcademicPrograms();
            markFormAsDirty(); // ensure markFormAsDirty() is defined in the same scope
        }
        // 5) Hook Up Event Listeners for Any Input/Select Changes
        $(document).on('input change',
        '#sole-authorship-table select, #co-authorship-table select, ' +
        '#co-authorship-table input[name*="[contribution]"], ' +
        '#academic-programs-table select',
        function(e) {
            // 1) Compute the row's score
            const row = e.target.closest('tr');
            const tableId = row.closest('table').id;
            computeRowScore(row, tableId);

            // 2) Then recalc totals across all tables
            recalcAll();
        }
        );
        /**
         * If you want to recalc only the table the row belongs to (instead of all),
         * replace recalcAll() with an if-check:
         *   if (tableId==='sole-authorship-table') recalcSoleAuthorship();
         *   else if (...) ...
         *   markFormAsDirty();
         */


        // === SINGLE-FILE UPLOAD LOGIC ===
        $(document).on('click', '.upload-evidence-btn', function () {
            var button = $(this);
            var recordId = button.data('record-id');
            var subcriterion = button.data('subcriterion'); // 'sole', 'co', or 'acad'
            var filePath = button.data('file-path'); // existing file if any
            var requestId = $('#request_id_b').val();

            if (!requestId) {
                showMessage('No valid Request ID found. Please select an evaluation first.');
                return;
            }
            if (recordId === '0' || !recordId) {
                showMessage('Please save the row before uploading evidence (row must have a valid ID).');
                return;
            }

            // Store data in hidden fields inside the modal
            $('#b_modal_request_id').val(requestId);
            $('#b_modal_subcriterion').val(subcriterion);
            $('#b_modal_record_id').val(recordId);
            $('#b_existing_file_path').val(filePath || '');

            // Reset the file input
            $('#singleBFileInput').val('');
            $('#singleBFileName').text(filePath ? filePath.split('/').pop() : '');

            uploadSingleEvidenceModal.show();
        });

        // Show filename when changed
        $('#singleBFileInput').on('change', function () {
            $('#singleBFileName').text(this.files[0] ? this.files[0].name : '');
        });

        // Confirm Upload
        $('#b_uploadSingleEvidenceBtn').on('click', function () {
            var formData = new FormData($('#b_singleEvidenceUploadForm')[0]);
            var fileInput = $('#singleBFileInput')[0].files[0];
            if (!fileInput) {
                showMessage('Please select a file to upload.');
                return;
            }
            // Validate file type, size, etc., if needed
            $.ajax({
                url: '../../includes/career_progress_tracking/teaching/upload_evidence_criterion_b.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        // Update the button data attribute and hidden input in the row
                        var subcriterion = $('#b_modal_subcriterion').val();
                        var recordId = $('#b_modal_record_id').val();
                        var filePath = response.path;

                        // Find the matching row
                        var tableSelector = '';
                        if (subcriterion === 'sole') {
                            tableSelector = '#sole-authorship-table';
                        } else if (subcriterion === 'co') {
                            tableSelector = '#co-authorship-table';
                        } else if (subcriterion === 'acad') {
                            tableSelector = '#academic-programs-table';
                        }
                        var row = $(tableSelector).find(`tr[data-${subcriterion}-id="${recordId}"]`);
                        row.find('input[name*="[evidence_file]"]').val(filePath);
                        row.find('.upload-evidence-btn').data('file-path', filePath).text('Change Evidence');

                        uploadSingleEvidenceModal.hide();
                        markFormAsDirty();
                        showMessage('File uploaded successfully!');

                        // Optionally, re-fetch data if needed
                        CriterionB.fetchCriterionB($('#request_id_b').val());
                    } else {
                        showMessage('Upload failed: ' + response.error);
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    showMessage('An error occurred during the upload.');
                }
            });
        });

        // === DELETE FILE LOGIC (if needed, adapt from A) ===
        $('#deleteFileBtn').on('click', function () {
            var subcriterion = $('#modal_subcriterion').val();
            var recordId = $('#modal_record_id').val();
            var requestId = $('#modal_request_id').val();

            if (!confirm('Are you sure you want to delete this evidence file?')) {
                return;
            }
            $.ajax({
                url: '../../includes/career_progress_tracking/teaching/delete_evidence_criterion_b.php',
                type: 'POST',
                data: {
                    request_id: requestId,
                    record_id: recordId,
                    subcriterion: subcriterion
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        // Update row
                        var tableSelector = '';
                        if (subcriterion === 'sole') {
                            tableSelector = '#sole-authorship-table';
                        } else if (subcriterion === 'co') {
                            tableSelector = '#co-authorship-table';
                        } else if (subcriterion === 'acad') {
                            tableSelector = '#academic-programs-table';
                        }
                        var row = $(tableSelector).find(`tr[data-${subcriterion}-id="${recordId}"]`);
                        row.find('input[name*="[evidence_file]"]').val('');
                        row.find('.upload-evidence-btn').data('file-path', '').text('Upload Evidence');

                        showMessage('Evidence file deleted successfully.');
                        uploadSingleEvidenceModal.hide();
                        markFormAsDirty();

                        var requestId = $('#request_id_b').val();
                        CriterionB.fetchCriterionB(requestId);
                    } else {
                        showMessage('Error deleting file: ' + response.error);
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    showMessage('An error occurred during the deletion.');
                }
            });
        });

        // === DELETE ROW LOGIC ===
        var rowToDelete = null;
        var recordIdToDelete = null;
        var subcriterionToDelete = null;

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('delete-row')) {
                rowToDelete = e.target.closest('tr');
                subcriterionToDelete = rowToDelete.hasAttribute('data-sole-id') ? 'sole'
                    : rowToDelete.hasAttribute('data-co-id') ? 'co'
                        : rowToDelete.hasAttribute('data-acad-id') ? 'acad'
                            : null;

                recordIdToDelete = rowToDelete.getAttribute(`data-${subcriterionToDelete}-id`) || '0';
                deleteRowModal.show();
            }
        });

        document.getElementById('confirm-delete-row').addEventListener('click', function () {
            if (rowToDelete) {
                // Hide the delete confirmation modal *before* any further actions
                deleteRowModal.hide(); 

                if (recordIdToDelete !== '0' && subcriterionToDelete) {
                    deletedRecords[subcriterionToDelete].push(recordIdToDelete);
                }

                rowToDelete.remove();
                rowToDelete = null;
                recordIdToDelete = null;
                subcriterionToDelete = null;

                markFormAsDirty();
            }
        });

        // === VIEW REMARKS HANDLER (if needed) ===
        $(document).on('click', '.view-remarks', function () {
            // If you track remarks for these rows, adapt similarly to Criterion A
            showMessage('No remarks to display.');
        });

        // === ADD ROW LOGIC FOR EACH SUB-CRITERION ===
        // Sole Authorship
        $('.add-sole-authorship-row').on('click', function () {
            var tableId = $(this).data('table-id'); // #sole-authorship-table
            var tableBody = document.querySelector(`#${tableId} tbody`);
            var newRow = document.createElement('tr');
            var rowCount = tableBody.querySelectorAll('tr').length + 1;
            newRow.setAttribute('data-sole-id', '0');

            // Create minimal empty row
            newRow.innerHTML = `
                <td>${rowCount}</td>
                <td><input type="text" class="form-control" name="kra1_b_sole_authorship[new_${Date.now()}][title]"></td>
                <td>
                    <select class="form-select" name="kra1_b_sole_authorship[new_${Date.now()}][type]">
                        <option value="">SELECT OPTION</option>
                        <option value="Textbook">Textbook</option>
                        <option value="Textbook Chapter">Textbook Chapter</option>
                        <option value="Manual/Module">Manual/Module</option>
                        <option value="Multimedia Teaching Material">Multimedia Teaching Material</option>
                        <option value="Testing Material">Testing Material</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra1_b_sole_authorship[new_${Date.now()}][reviewer]"></td>
                <td><input type="text" class="form-control" name="kra1_b_sole_authorship[new_${Date.now()}][publisher]"></td>
                <td><input type="date" class="form-control" name="kra1_b_sole_authorship[new_${Date.now()}][date_published]"></td>
                <td><input type="date" class="form-control" name="kra1_b_sole_authorship[new_${Date.now()}][date_approved]"></td>
                <td><input type="number" class="form-control score-input" name="kra1_b_sole_authorship[new_${Date.now()}][score]" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                        data-subcriterion="sole" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra1_b_sole_authorship[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
            `;
            tableBody.appendChild(newRow);
            markFormAsDirty();
        });

        // Co-authorship
        $('.add-co-authorship-row').on('click', function () {
            var tableId = $(this).data('table-id'); // #co-authorship-table
            var tableBody = document.querySelector(`#${tableId} tbody`);
            var newRow = document.createElement('tr');
            var rowCount = tableBody.querySelectorAll('tr').length + 1;
            newRow.setAttribute('data-co-id', '0');

            newRow.innerHTML = `
                <td>${rowCount}</td>
                <td><input type="text" class="form-control" name="kra1_b_co_authorship[new_${Date.now()}][title]"></td>
                <td>
                    <select class="form-select" name="kra1_b_co_authorship[new_${Date.now()}][type]">
                        <option value="">SELECT OPTION</option>
                        <option value="Textbook">Textbook</option>
                        <option value="Textbook Chapter">Textbook Chapter</option>
                        <option value="Manual/Module">Manual/Module</option>
                        <option value="Multimedia Teaching Material">Multimedia Teaching Material</option>
                        <option value="Testing Material">Testing Material</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra1_b_co_authorship[new_${Date.now()}][reviewer]"></td>
                <td><input type="text" class="form-control" name="kra1_b_co_authorship[new_${Date.now()}][publisher]"></td>
                <td><input type="date" class="form-control" name="kra1_b_co_authorship[new_${Date.now()}][date_published]"></td>
                <td><input type="date" class="form-control" name="kra1_b_co_authorship[new_${Date.now()}][date_approved]"></td>
                <td><input type="number" class="form-control" name="kra1_b_co_authorship[new_${Date.now()}][contribution_percentage]"></td>
                <td><input type="number" class="form-control score-input" name="kra1_b_co_authorship[new_${Date.now()}][score]" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                        data-subcriterion="co" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra1_b_co_authorship[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
            `;
            tableBody.appendChild(newRow);
            markFormAsDirty();
        });

        // Academic Programs
        $('.add-academic-programs-row').on('click', function () {
            var tableId = $(this).data('table-id'); // #academic-programs-table
            var tableBody = document.querySelector(`#${tableId} tbody`);
            var newRow = document.createElement('tr');
            var rowCount = tableBody.querySelectorAll('tr').length + 1;
            newRow.setAttribute('data-acad-id', '0');

            newRow.innerHTML = `
                <td>${rowCount}</td>
                <td><input type="text" class="form-control" name="kra1_b_academic_programs[new_${Date.now()}][program_name]"></td>
                <td>
                    <select class="form-select" name="kra1_b_academic_programs[new_${Date.now()}][program_type]">
                        <option value="">SELECT OPTION</option>
                        <option value="New Program">New Program</option>
                        <option value="Revised Program">Revised Program</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra1_b_academic_programs[new_${Date.now()}][board_approval]"></td>
                <td><input type="text" class="form-control" name="kra1_b_academic_programs[new_${Date.now()}][academic_year]"></td>
                <td>
                    <select class="form-select" name="kra1_b_academic_programs[new_${Date.now()}][role]">
                        <option value="">SELECT OPTION</option>
                        <option value="Lead">Lead</option>
                        <option value="Contributor">Contributor</option>
                    </select>
                </td>
                <td><input type="number" class="form-control score-input" name="kra1_b_academic_programs[new_${Date.now()}][score]" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                        data-subcriterion="acad" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra1_b_academic_programs[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
            `;
            tableBody.appendChild(newRow);
            markFormAsDirty();
        });

        // === SAVE PROCESS ===
        function gatherPayload() {
            var requestId = parseInt(document.getElementById('request_id_b').value.trim(), 10) || 0;

            // Sole Authorship
            var soleRows = [];
            $('#sole-authorship-table tbody tr').each(function () {
                var row = $(this);
                var recordId = row.attr('data-sole-id') || '0';

                var inputs = row.find('input, select');
                var rowData = {
                    sole_authorship_id: recordId,
                    title: inputs.filter('[name*="[title]"]').val() || '',
                    type: inputs.filter('[name*="[type]"]').val() || '',
                    reviewer: inputs.filter('[name*="[reviewer]"]').val() || '',
                    publisher: inputs.filter('[name*="[publisher]"]').val() || '',
                    date_published: inputs.filter('[name*="[date_published]"]').val() || '',
                    date_approved: inputs.filter('[name*="[date_approved]"]').val() || '',
                    score: parseFloat(inputs.filter('[name*="[score]"]').val()) || 0,
                    evidence_file: inputs.filter('[name*="[evidence_file]"]').val() || ''
                };
                soleRows.push(rowData);
            });

            // Co Authorship
            var coRows = [];
            $('#co-authorship-table tbody tr').each(function () {
                var row = $(this);
                var recordId = row.attr('data-co-id') || '0';

                var inputs = row.find('input, select');
                var rowData = {
                    co_authorship_id: recordId,
                    title: inputs.filter('[name*="[title]"]').val() || '',
                    type: inputs.filter('[name*="[type]"]').val() || '',
                    reviewer: inputs.filter('[name*="[reviewer]"]').val() || '',
                    publisher: inputs.filter('[name*="[publisher]"]').val() || '',
                    date_published: inputs.filter('[name*="[date_published]"]').val() || '',
                    date_approved: inputs.filter('[name*="[date_approved]"]').val() || '',
                    contribution_percentage: parseFloat(inputs.filter('[name*="[contribution_percentage]"]').val()) || 0,
                    score: parseFloat(inputs.filter('[name*="[score]"]').val()) || 0,
                    evidence_file: inputs.filter('[name*="[evidence_file]"]').val() || ''
                };
                coRows.push(rowData);
            });

            // Academic Programs
            var acadRows = [];
            $('#academic-programs-table tbody tr').each(function () {
                var row = $(this);
                var recordId = row.attr('data-acad-id') || '0';

                var inputs = row.find('input, select');
                var rowData = {
                    academic_prog_id: recordId,
                    program_name: inputs.filter('[name*="[program_name]"]').val() || '',
                    program_type: inputs.filter('[name*="[program_type]"]').val() || '',
                    board_approval: inputs.filter('[name*="[board_approval]"]').val() || '',
                    academic_year: inputs.filter('[name*="[academic_year]"]').val() || '',
                    role: inputs.filter('[name*="[role]"]').val() || '',
                    score: parseFloat(inputs.filter('[name*="[score]"]').val()) || 0,
                    evidence_file: inputs.filter('[name*="[evidence_file]"]').val() || ''
                };
                acadRows.push(rowData);
            });

            // Totals (Metadata)
            var sole_total = parseFloat($('#kra1_b_sole_authorship_total').val()) || 0;
            var co_total = parseFloat($('#kra1_b_co_authorship_total').val()) || 0;
            var acad_total = parseFloat($('#kra1_b_academic_programs_total').val()) || 0;

            return {
                request_id: requestId,
                sole_authorship: soleRows,
                co_authorship: coRows,
                academic_programs: acadRows,
                metadata: {
                    sole_authorship_total: sole_total,
                    co_authorship_total: co_total,
                    academic_programs_total: acad_total
                },
                deleted_records: deletedRecords
            };
        }

        function saveCriterionB() {
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }
            var requestId = parseInt(document.getElementById('request_id_b').value.trim(), 10);
            if (!requestId) {
                showMessage('Please select a valid evaluation ID before saving Criterion B.');
                return;
            }

            var payload = gatherPayload();
            fetch('../../includes/career_progress_tracking/teaching/save_criterion_b.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (data.success) {
                    showMessage('Criterion B data saved successfully!');
                    // Reset deleted arrays
                    deletedRecords.sole = [];
                    deletedRecords.co = [];
                    deletedRecords.acad = [];
                    markFormAsClean();
                    CriterionB.fetchCriterionB(requestId);
                } else {
                    showMessage(data.error || 'An error occurred while saving Criterion B.');
                }
            })
            .catch(function (error) {
                console.error('Error:', error);
                showMessage('Failed to save Criterion B data. Please check the console for details.');
            });
        }

        // Attach save event
        saveBtn.addEventListener('click', function () {
            saveCriterionB();
        });

        // === UNSAVED CHANGES PROMPT START ===
        
        // === UNSAVED CHANGES PROMPT END ===

        // Mark form as clean on initial load
        markFormAsClean();
    };

    // On DOM load, initialize everything for Criterion B
    document.addEventListener('DOMContentLoaded', function () {
        CriterionB.init();
    });

    // Expose the namespace
    window.CriterionB = CriterionB;

}(window, document, jQuery));
