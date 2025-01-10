// careerpath/php/includes/career_progress_tracking/research/js/kra2_criterion_a.js
(function (window, document, $) {
    'use strict';

    // Create a namespace object for Criterion A
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

    function showMessage(message) {
        $('#messageModal .modal-body').text(message); // Assuming you have a #messageModal
        $('#messageModal').modal('show');
    }

    // === MODAL IMPLEMENTATION ===
    // Message Modal
    var messageModal = new bootstrap.Modal(document.getElementById('messageModal'), {
        backdrop: 'static',
        keyboard: false
    });

    // Confirmation Modal
    var confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'), {
        backdrop: 'static',
        keyboard: false
    });

    // Function to show the confirmation modal
    function showConfirmationModal(title, message, confirmCallback, cancelCallback) {
        $('#confirmationModal .modal-title').text(title);
        $('#confirmationModal .modal-body').text(message);
        $('#confirmBtn').off('click').on('click', function () {
            if (typeof confirmCallback === 'function') {
                confirmCallback();
            }
            confirmationModal.hide();
        });
        $('#cancelBtn').off('click').on('click', function () {
            if (typeof cancelCallback === 'function') {
                cancelCallback();
            }
            confirmationModal.hide();
        });
        confirmationModal.show();
    }

    // Function to show the message modal
    function showMessageModal(message) {
        $('#messageModal .modal-body').text(message);
        messageModal.show();
    }

    // Attach these functions to the window object so they can be accessed globally
    window.showConfirmationModal = showConfirmationModal;
    window.showMessageModal = showMessageModal;

    // === SOLE AUTHORSHIP FUNCTIONS ===

    // Add default rows for Sole Authorship
    function addDefaultSoleAuthorshipRows(tableBody) {
        const requestId = document.getElementById('request_id')?.value.trim() || '0';
        for (let i = 1; i <= 3; i++) {
            const row = document.createElement('tr');
            row.setAttribute('data-sole-id', '0'); // Indicate this is a new, unsaved row
            row.innerHTML = `
                <td>${i}</td>
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[new_${Date.now()}][title]" placeholder="Title of Research Output"></td>
                <td>
                    <select class="form-select" name="kra2_a_sole_authorship[new_${Date.now()}][type]">
                        <option value="">SELECT OPTION</option>
                        <option value="Book">Book</option>
                        <option value="Journal Article">Journal Article</option>
                        <option value="Book Chapter">Book Chapter</option>
                        <option value="Monograph">Monograph</option>
                        <option value="Other Peer-Reviewed Output">Other Peer-Reviewed Output</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[new_${Date.now()}][journal_publisher]" placeholder="Name of Journal / Publisher"></td>
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[new_${Date.now()}][reviewer]" placeholder="Reviewer or Its Equivalent"></td>
                <td>
                    <select class="form-select" name="kra2_a_sole_authorship[new_${Date.now()}][international]">
                        <option value="">SELECT OPTION</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </td>
                <td><input type="date" class="form-control" name="kra2_a_sole_authorship[new_${Date.now()}][date_published]"></td>
                <td><input type="text" class="form-control score-input" name="kra2_a_sole_authorship[new_${Date.now()}][score]" placeholder="0" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn"
                        data-subcriterion="sole_authorship" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra2_a_sole_authorship[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
            `;
            tableBody.appendChild(row);
        }
    }

    // Populate Sole Authorship table
    function populateSoleAuthorship(soleData) {
        var tableBody = document.querySelector('#sole-authorship-table tbody');
        tableBody.innerHTML = ''; // Clear existing rows

        if (!soleData || soleData.length === 0) {
            // If no data, add default rows
            addDefaultSoleAuthorshipRows(tableBody);
            return;
        }

        // Populate with fetched data
        soleData.forEach(function (item, index) {
            var tr = document.createElement('tr');
            tr.setAttribute('data-sole-id', item.sole_authorship_id);

            var evidenceButtonLabel = item.evidence_file ? 'Change Evidence' : 'Upload Evidence';

            var rowHTML = `
                <td>${index + 1}</td>
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[${item.sole_authorship_id}][title]" value="${escapeHTML(item.title)}"></td>
                <td>
                    <select class="form-select" name="kra2_a_sole_authorship[${item.sole_authorship_id}][type]">
                        <option value="">SELECT OPTION</option>
                        <option value="Book" ${item.type === 'Book' ? 'selected' : ''}>Book</option>
                        <option value="Journal Article" ${item.type === 'Journal Article' ? 'selected' : ''}>Journal Article</option>
                        <option value="Book Chapter" ${item.type === 'Book Chapter' ? 'selected' : ''}>Book Chapter</option>
                        <option value="Monograph" ${item.type === 'Monograph' ? 'selected' : ''}>Monograph</option>
                        <option value="Other Peer-Reviewed Output" ${item.type === 'Other Peer-Reviewed Output' ? 'selected' : ''}>Other Peer-Reviewed Output</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[${item.sole_authorship_id}][journal_publisher]" value="${escapeHTML(item.journal_publisher || '')}"></td>
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[${item.sole_authorship_id}][reviewer]" value="${escapeHTML(item.reviewer || '')}"></td>
                <td>
                    <select class="form-select" name="kra2_a_sole_authorship[${item.sole_authorship_id}][international]">
                        <option value="">SELECT OPTION</option>
                        <option value="Yes" ${item.international === 'Yes' ? 'selected' : ''}>Yes</option>
                        <option value="No" ${item.international === 'No' ? 'selected' : ''}>No</option>
                    </select>
                </td>
                <td><input type="date" class="form-control" name="kra2_a_sole_authorship[${item.sole_authorship_id}][date_published]" value="${item.date_published || ''}"></td>
                <td><input type="text" class="form-control score-input" name="kra2_a_sole_authorship[${item.sole_authorship_id}][score]" value="${item.score || ''}" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn"
                        data-subcriterion="sole_authorship"
                        data-record-id="${item.sole_authorship_id}"
                        data-file-path="${escapeHTML(item.evidence_file || '')}">
                        ${evidenceButtonLabel}
                    </button>
                    <input type="hidden" name="kra2_a_sole_authorship[${item.sole_authorship_id}][evidence_file]" value="${escapeHTML(item.evidence_file || '')}">
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

    // === FETCH DATA FOR CRITERION A ===
    CriterionA.fetchCriterionA = function (requestId) {
        return fetch(`../../includes/career_progress_tracking/research/kra2_fetch_criterion_a.php?request_id=${requestId}`)
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(function (data) {
                if (data.success) {
                    populateSoleAuthorship(data.sole_authorship || []);
                    // ... populate other sub-criteria tables when implementing them
                    return data;
                } else {
                    console.error('Error:', data.error);
                    showErrorMessage('Failed to fetch Criterion A data: ' + data.error);
                }
            })
            .catch(function (error) {
                console.error('Error fetching data:', error);
                showErrorMessage('Failed to fetch Criterion A data. Check console for details.');
            });
    };

    // === INITIALIZATION ===
    CriterionA.init = function () {
        var form = document.getElementById('criterion-a-form');
        var saveBtn = document.getElementById('save-criterion-a');

        // Initialize Modals (assuming you've added them to your HTML)
        var messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
        var confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        var uploadSingleEvidenceModalA = new bootstrap.Modal(document.getElementById('uploadSingleEvidenceModalA'));
        var deleteRowModal = new bootstrap.Modal(document.getElementById('deleteRowModal'));
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        // Function to show a success message
        function showSuccessMessage(message) {
            $('#successModal .modal-body').text(message);
            successModal.show();
        }

        // Function to show an error message
        function showErrorMessage(message) {
            $('#errorModal .modal-body').text(message);
            errorModal.show();
        }

        // Track deleted records for each sub-criterion
        var deletedRecords = {
            sole: [],
            co: [],
            lead: [],
            contributor: [],
            local: [],
            international: []
        };

        // Dirty flag to track changes
        var isFormDirty = false;
        function markFormAsDirty() {
            isFormDirty = true;
            saveBtn.classList.add('btn-warning');
        }
        function markFormAsClean() {
            isFormDirty = false;
            saveBtn.classList.remove('btn-warning');
        }

        // === SCORING LOGIC (FOR SOLE AUTHORSHIP) ===
        function getSoleAuthorshipScore(type, international) {
            if (type === 'Book' || type === 'Monograph') {
                return 100;
            } else if (type === 'Journal Article' && international === 'Yes') {
                return 50;
            } else if (type === 'Book Chapter') {
                return 35;
            } else if (type === 'Other Peer-Reviewed Output') {
                return 10;
            } else {
                return 0;
            }
        }

        function computeRowScore(row, tableId) {
            const scoreInput = row.querySelector('input[name*="[score]"]');
            if (!scoreInput) return;

            let computedScore = 0;
            if (tableId === 'sole-authorship-table') {
                const type = row.querySelector('select[name*="[type]"]')?.value;
                const international = row.querySelector('select[name*="[international]"]')?.value;
                computedScore = getSoleAuthorshipScore(type, international);
            }
            // Add other table score computations here when implementing them

            scoreInput.value = computedScore.toFixed(2);
            markFormAsDirty();
        }

        function recalcSoleAuthorship() {
            let total = 0;
            $('#sole-authorship-table tbody tr').each(function () {
                const score = parseFloat($(this).find('input[name*="[score]"]').val()) || 0;
                total += score;
            });
            $('#kra2_a_sole_authorship_total').val(total.toFixed(2));
        }
        // ... other recalc functions for the other tables will be added here

        function recalcAll() {
            recalcSoleAuthorship();
            // ... call the other recalc functions when implementing them
            markFormAsDirty();
        }

        // Event listener for changes in Sole Authorship table
        $(document).on('change', '#sole-authorship-table select, #sole-authorship-table input', function () {
            const row = $(this).closest('tr')[0];
            computeRowScore(row, 'sole-authorship-table');
            recalcAll();
        });

        // === UPLOAD EVIDENCE LOGIC ===
        // (Similar to the single-file upload logic in criterion_b.js,
        // but adapted for Criterion A and the new modal structure)
        $(document).on('click', '.upload-evidence-btn', function () {
            var button = $(this);
            var recordId = button.data('record-id');
            var subcriterion = button.data('subcriterion');
            var filePath = button.data('file-path');
            var requestId = $('#request_id').val();

            if (!requestId) {
                showMessageModal('No valid Request ID found. Please select an evaluation first.');
                return;
            }

            if (recordId === '0' || !recordId) {
                showMessageModal('Please save the row before uploading evidence (row must have a valid ID).');
                return;
            }

            // Store data in hidden fields inside the modal
            $('#a_modal_request_id').val(requestId);
            $('#a_modal_subcriterion').val(subcriterion);
            $('#a_modal_record_id').val(recordId);
            $('#a_existing_file_path').val(filePath || '');

            // Reset the file input and display the filename
            $('#singleAFileInput').val('');
            $('#singleAFileName').text(filePath ? filePath.split('/').pop() : '');

            uploadSingleEvidenceModalA.show();
        });

        // Show filename in the modal when a file is selected
        $('#singleAFileInput').on('change', function () {
            $('#singleAFileName').text(this.files[0] ? this.files[0].name : '');
        });

        // Handle the evidence upload in the modal
        $('#a_uploadSingleEvidenceBtn').on('click', function () {
            var formData = new FormData($('#a_singleEvidenceUploadForm')[0]);
            var fileInput = $('#singleAFileInput')[0].files[0];

            if (!fileInput) {
                showMessageModal('Please select a file to upload.');
                return;
            }

            // You can add client-side validation for file type, size, etc. here

            $.ajax({
                url: '../../includes/career_progress_tracking/research/kra2_upload_evidence_criterion_a.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        // Update the button data attribute and hidden input in the row
                        var subcriterion = $('#a_modal_subcriterion').val();
                        var recordId = $('#a_modal_record_id').val();
                        var filePath = response.path;

                        // Find the matching row in the correct table
                        var tableSelector = `#${subcriterion.replace(/_/g, '-')}-table`;
                        var row = $(tableSelector).find(`tr[data-sole-id="${recordId}"]`); // Assuming data-sole-id for all subcriteria
                        row.find('input[name*="[evidence_file]"]').val(filePath);
                        row.find('.upload-evidence-btn').data('file-path', filePath).text('Change Evidence');

                        uploadSingleEvidenceModalA.hide();
                        markFormAsDirty();
                        showMessageModal('File uploaded successfully!');

                        // Optionally, re-fetch data to refresh the table
                        CriterionA.fetchCriterionA($('#request_id').val());
                    } else {
                        showMessageModal('Upload failed: ' + response.error);
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    showMessageModal('An error occurred during the upload.');
                }
            });
        });

        // === DELETE EVIDENCE LOGIC ===
        // Add this to your CriterionA.init function
        $('#deleteFileBtn').on('click', function () {
            var subcriterion = $('#a_modal_subcriterion').val();
            var recordId = $('#a_modal_record_id').val();
            var requestId = $('#a_modal_request_id').val();
        
            showConfirmationModal(
                'Confirm Delete',
                'Are you sure you want to delete this evidence file?',
                function () {
                    // Proceed with the deletion
                    $.ajax({
                        url: '../../includes/career_progress_tracking/research/kra2_delete_evidence_criterion_a.php',
                        type: 'POST',
                        data: {
                            request_id: requestId,
                            record_id: recordId,
                            subcriterion: subcriterion
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                // Update the row in the UI
                                var tableSelector = `#${subcriterion.replace(/_/g, '-')}-table`;
                                var row = $(tableSelector).find(`tr[data-sole-id="${recordId}"]`); // Assuming data-sole-id for all
                                row.find('input[name*="[evidence_file]"]').val('');
                                row.find('.upload-evidence-btn').data('file-path', '').text('Upload Evidence');
        
                                showSuccessMessage('Evidence file deleted successfully.');
                                uploadSingleEvidenceModalA.hide();
                                markFormAsDirty();
        
                            } else {
                                showErrorMessage('Error deleting file: ' + response.error);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                            showErrorMessage('An error occurred during the deletion.');
                        }
                    });
                },
                function () {
                    // Handle the cancellation
                    console.log('File deletion was cancelled.');
                }
            );
        });

        // === DELETE ROW LOGIC ===
        var rowToDelete = null;
        var recordIdToDelete = null;
        var subcriterionToDelete = null;

        // Event listener for clicking the delete button on a row
        $(document).on('click', '.delete-row', function () {
            rowToDelete = $(this).closest('tr');
            subcriterionToDelete = rowToDelete.data('subcriterion');
            recordIdToDelete = rowToDelete.data('sole-id');
        
            showConfirmationModal(
                'Confirm Delete',
                'Are you sure you want to delete this row?',
                function () {
                    // Proceed with row deletion
                    if (recordIdToDelete !== '0' && subcriterionToDelete) {
                        deletedRecords[subcriterionToDelete].push(recordIdToDelete);
                    }
        
                    rowToDelete.remove();
                    rowToDelete = null;
                    recordIdToDelete = null;
                    subcriterionToDelete = null;
        
                    markFormAsDirty();
                    recalcAll();
                },
                function () {
                    console.log('Row deletion was cancelled.');
                }
            );
        });
        

        // Handle the actual row deletion
        // $('#confirm-delete-row').on('click', function () {
        //     if (rowToDelete) {
        //         if (recordIdToDelete !== '0' && subcriterionToDelete) {
        //             deletedRecords[subcriterionToDelete].push(recordIdToDelete);
        //         }

        //         rowToDelete.remove();
        //         rowToDelete = null;
        //         recordIdToDelete = null;
        //         subcriterionToDelete = null;

        //         markFormAsDirty();
        //         recalcAll(); // Recalculate totals after deleting a row
        //     }
        // });

        // === VIEW REMARKS HANDLER ===
        $(document).on('click', '.view-remarks', function () {
            // Implementation depends on how remarks are stored and displayed
        });

        // === ADD ROW LOGIC ===
        $('.add-sole-authorship-row').on('click', function () {
            var tableId = $(this).data('table-id');
            var tableBody = document.querySelector(`#${tableId} tbody`);
            var newRow = document.createElement('tr');
            var rowCount = tableBody.querySelectorAll('tr').length + 1;
            newRow.setAttribute('data-sole-id', '0'); // New row, not yet saved

            newRow.innerHTML = `
                <td>${rowCount}</td>
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[new_${Date.now()}][title]" placeholder="Title of Research Output"></td>
                <td>
                    <select class="form-select" name="kra2_a_sole_authorship[new_${Date.now()}][type]">
                        <option value="">SELECT OPTION</option>
                        <option value="Book">Book</option>
                        <option value="Journal Article">Journal Article</option>
                        <option value="Book Chapter">Book Chapter</option>
                        <option value="Monograph">Monograph</option>
                        <option value="Other Peer-Reviewed Output">Other Peer-Reviewed Output</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[new_${Date.now()}][journal_publisher]" placeholder="Name of Journal / Publisher"></td>
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[new_${Date.now()}][reviewer]" placeholder="Reviewer or Its Equivalent"></td>
                <td>
                    <select class="form-select" name="kra2_a_sole_authorship[new_${Date.now()}][international]">
                        <option value="">SELECT OPTION</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </td>
                <td><input type="date" class="form-control" name="kra2_a_sole_authorship[new_${Date.now()}][date_published]"></td>
                <td><input type="text" class="form-control score-input" name="kra2_a_sole_authorship[new_${Date.now()}][score]" placeholder="0" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn"
                        data-subcriterion="sole_authorship" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra2_a_sole_authorship[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
            `;
            tableBody.appendChild(newRow);
            markFormAsDirty();
        });

        // === SAVE LOGIC ===
        function gatherPayload() {
            var requestId = parseInt(document.getElementById('request_id').value.trim(), 10) || 0;

            // Sole Authorship
            var soleRows = [];
            $('#sole-authorship-table tbody tr').each(function () {
                var row = $(this);
                var recordId = row.data('sole-id').toString();

                var inputs = row.find('input, select');
                var rowData = {
                    sole_authorship_id: recordId,
                    title: inputs.filter('[name*="[title]"]').val() || '',
                    type: inputs.filter('[name*="[type]"]').val() || '',
                    journal_publisher: inputs.filter('[name*="[journal_publisher]"]').val() || '',
                    reviewer: inputs.filter('[name*="[reviewer]"]').val() || '',
                    international: inputs.filter('[name*="[international]"]').val() || '',
                    date_published: inputs.filter('[name*="[date_published]"]').val() || '',
                    score: parseFloat(inputs.filter('[name*="[score]"]').val()) || 0,
                    evidence_file: inputs.filter('[name*="[evidence_file]"]').val() || ''
                    // remarks are not collected in this example
                };
                soleRows.push(rowData);
            });

            // Add other sub-criteria data gathering here when implementing them

            // Totals (Metadata)
            var sole_total = parseFloat($('#kra2_a_sole_authorship_total').val()) || 0;
            // ... other totals

            return {
                request_id: requestId,
                sole_authorship: soleRows,
                // ... other sub-criteria data
                metadata: {
                    sole_authorship_total: sole_total
                    // ... other totals
                },
                deleted_records: deletedRecords
            };
        }

        function saveCriterionA() {
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }
            var requestId = parseInt(document.getElementById('request_id').value.trim(), 10);
            if (!requestId) {
                showMessageModal('Please select a valid evaluation ID before saving Criterion A.');
                return;
            }

            var payload = gatherPayload();
            fetch('../../includes/career_progress_tracking/research/kra2_save_criterion_a.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            })
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    if (data.success) {
                        showSuccessMessage('Criterion A data saved successfully!');
                        // Reset deleted arrays
                        deletedRecords.sole = [];
                        // ... reset other sub-criteria arrays when implementing them
                        markFormAsClean();
                        CriterionA.fetchCriterionA(requestId); // Refresh data
                    } else {
                        showErrorMessage(data.error || 'An error occurred while saving Criterion A.');
                    }
                })
                .catch(function (error) {
                    console.error('Error:', error);
                    showErrorMessage('Failed to save Criterion A data. Please check the console for details.');
                });
        }

        // Attach save event to the save button
        saveBtn.addEventListener('click', function () {
            saveCriterionA();
        });

        markFormAsClean();
    };

    // Initialize Criterion A on DOMContentLoaded
    document.addEventListener('DOMContentLoaded', function () {
        CriterionA.init();
    });

    // Expose the namespace
    window.CriterionA = CriterionA;

}(window, document, jQuery));