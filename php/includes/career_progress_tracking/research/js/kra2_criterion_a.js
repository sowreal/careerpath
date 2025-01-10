$(document).ready(function() {
    // Function to calculate and update total scores
    function updateTotalScores() {
        // Sole Authorship
        let soleAuthorshipTotal = 0;
        $('#sole-authorship-table tbody tr').each(function() {
            const score = parseFloat($(this).find('input[name*="[score]"]').val()) || 0;
            soleAuthorshipTotal += score;
        });
        $('#kra2_a_sole_authorship_total').val(soleAuthorshipTotal.toFixed(2));

        // Co-Authorship
        let coAuthorshipTotal = 0;
        $('#co-authorship-table tbody tr').each(function() {
            const score = parseFloat($(this).find('input[name*="[score]"]').val()) || 0;
            coAuthorshipTotal += score;
        });
        $('#kra2_a_co_authorship_total').val(coAuthorshipTotal.toFixed(2));

        // Lead Researcher
        let leadResearcherTotal = 0;
        $('#lead-researcher-table tbody tr').each(function() {
            const score = parseFloat($(this).find('input[name*="[score]"]').val()) || 0;
            leadResearcherTotal += score;
        });
        $('#kra1_a_lead_researcher_total').val(leadResearcherTotal.toFixed(2));

        // Contributor
        let contributorTotal = 0;
        $('#contributor-table tbody tr').each(function() {
            const score = parseFloat($(this).find('input[name*="[score]"]').val()) || 0;
            contributorTotal += score;
        });
        $('#kra1_a_contributor_total').val(contributorTotal.toFixed(2));

        // Local Authors
        let localAuthorsTotal = 0;
        $('#local-authors-table tbody tr').each(function() {
            const score = parseFloat($(this).find('input[name*="[score]"]').val()) || 0;
            localAuthorsTotal += score;
        });
        $('#kra1_a_local_authors_total').val(localAuthorsTotal.toFixed(2));

        // International Authors
        let internationalAuthorsTotal = 0;
        $('#international-authors-table tbody tr').each(function() {
            const score = parseFloat($(this).find('input[name*="[score]"]').val()) || 0;
            internationalAuthorsTotal += score;
        });
        $('#kra1_a_international_authors_total').val(internationalAuthorsTotal.toFixed(2));
    }

    // Event listener for input changes in Sole Authorship table
    $('#sole-authorship-table').on('input', 'input, select', function() {
        const row = $(this).closest('tr');
        const title = row.find('input[name*="[title]"]').val();
        const journalPublisher = row.find('input[name*="[journal_publisher]"]').val();
        const reviewer = row.find('input[name*="[reviewer]"]').val();
        const datePublished = row.find('input[name*="[date_published]"]').val();
        const type = row.find('select[name*="[type]"]').val();
        const international = row.find('select[name*="[international]"]').val();

        let score = 0;
        if (title && journalPublisher && reviewer && datePublished) {
            if (type === 'Book' || type === 'Monograph') {
                score = 100;
            } else if (type === 'Journal Article' && international) {
                score = 50;
            } else if (type === 'Book Chapter') {
                score = 35;
            } else if (type === 'Other Peer-Reviewed Output') {
                score = 10;
            }
        }

        row.find('input[name*="[score]"]').val(score.toFixed(2));
        updateTotalScores();
    });

    // Event listener for input changes in Co-Authorship table
    $('#co-authorship-table').on('input', 'input, select', function() {
        const row = $(this).closest('tr');
        const title = row.find('input[name*="[title]"]').val();
        const datePublished = row.find('input[name*="[date_published]"]').val();
        const type = row.find('select[name*="[type]"]').val();
        const international = row.find('select[name*="[international]"]').val();
        const contribution = parseFloat(row.find('input[name*="[contribution_percentage]"]').val()) || 0;

        let score = 0;
        if (title && datePublished) {
            if (type === 'Book' || type === 'Monograph') {
                score = 100;
            } else if (type === 'Journal Article' && international) {
                score = 50;
            } else if (type === 'Book Chapter') {
                score = 35;
            } else if (type === 'Other Peer-Reviewed Output') {
                score = 10;
            }
        }

        score = score * (contribution / 100);
        row.find('input[name*="[score]"]').val(score.toFixed(2));
        updateTotalScores();
    });

    // Event listener for input changes in Lead Researcher table
    $('#lead-researcher-table').on('input', 'input, select', function() {
        const row = $(this).closest('tr');
        const title = row.find('input[name*="[title]"]').val();
        const dateCompleted = row.find('input[name*="[date_completed]"]').val();
        const projectName = row.find('input[name*="[project_name]"]').val();
        const fundingSource = row.find('input[name*="[funding_source]"]').val();
        const dateImplemented = row.find('input[name*="[date_implemented]"]').val();

        let score = 0;
        if (title && dateCompleted && projectName && fundingSource && dateImplemented) {
            score = 35;
        }

        row.find('input[name*="[score]"]').val(score.toFixed(2));
        updateTotalScores();
    });

    // Event listener for input changes in Contributor table
    $('#contributor-table').on('input', 'input, select', function() {
        const row = $(this).closest('tr');
        const title = row.find('input[name*="[title]"]').val();
        const dateCompleted = row.find('input[name*="[date_completed]"]').val();
        const projectName = row.find('input[name*="[project_name]"]').val();
        const fundingSource = row.find('input[name*="[funding_source]"]').val();
        const dateImplemented = row.find('input[name*="[date_implemented]"]').val();
        const contribution = parseFloat(row.find('input[name*="[contribution_percentage]"]').val()) || 0;

        let score = 0;
        if (title && dateCompleted && projectName && fundingSource && dateImplemented) {
            score = 35;
        }

        score = score * (contribution / 100);
        row.find('input[name*="[score]"]').val(score.toFixed(2));
        updateTotalScores();
    });

    // Event listener for input changes in Local Authors table
    $('#local-authors-table').on('input', 'input, select', function() {
        const row = $(this).closest('tr');
        const citationCount = parseFloat(row.find('input[name*="[citation_count]"]').val()) || 0;
        const score = citationCount * 5;

        row.find('input[name*="[score]"]').val(score.toFixed(2));
        updateTotalScores();
    });

    // Event listener for input changes in International Authors table
    $('#international-authors-table').on('input', 'input, select', function() {
        const row = $(this).closest('tr');
        const citationCount = parseFloat(row.find('input[name*="[citation_count]"]').val()) || 0;
        const score = citationCount * 10;

        row.find('input[name*="[score]"]').val(score.toFixed(2));
        updateTotalScores();
    });

    // Function to add a new row to a table
    function addNewRow(tableId) {
        const table = $(`#${tableId}`);
        const lastRow = table.find('tbody tr:last');
        const newRow = lastRow.clone();

        // Increment the index for each input element in the new row
        newRow.find('input, select, button').each(function() {
            const name = $(this).attr('name');
            if (name) {
                const matches = name.match(/\[(\d+)\]/);
                if (matches && matches.length > 1) {
                    const newIndex = parseInt(matches[1]) + 1;
                    const newName = name.replace(/\[\d+\]/, `[${newIndex}]`);
                    $(this).attr('name', newName);
                }
            }

            if ($(this).is('input:not([type="button"])')) {
                if ($(this).attr('type') !== 'hidden') {
                    $(this).val('');
                }
            } else if ($(this).is('select')) {
                $(this).prop('selectedIndex', 0);
            }
        });

        // Update and append the new row
        newRow.find('.upload-evidence-btn').attr('data-subcriterion-id', `${tableId.replace('-table', '')}_${newRow.index() + 1}`);
        table.find('tbody').append(newRow);
        updateTotalScores();
    }

    // Add row buttons
    $('.add-sole-authorship-row').click(function() {
        addNewRow('sole-authorship-table');
    });

    $('.add-co-authorship-row').click(function() {
        addNewRow('co-authorship-table');
    });

    $('.add-lead-researcher-row').click(function() {
        addNewRow('lead-researcher-table');
    });

    $('.add-contributor-row').click(function() {
        addNewRow('contributor-table');
    });

    $('.add-local-authors-row').click(function() {
        addNewRow('local-authors-table');
    });

    $('.add-international-authors-row').click(function() {
        addNewRow('international-authors-table');
    });

    // Delete row
    $('table').on('click', '.delete-row', function() {
        $(this).closest('tr').remove();
        updateTotalScores();
    });

    // Function to handle file uploads
    function handleFileUpload(formData, table, row_id) {
        $.ajax({
            url: '../../includes/career_progress_tracking/research/kra2_upload_evidence_criterion_a.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    alert(data.message);

                    // Update the hidden input field for evidence_file
                    var inputName = '';
                    switch (table) {
                        case 'kra2_a_sole_authorship':
                            inputName = `kra2_a_sole_authorship[${row_id}][evidence_file]`;
                            break;
                        case 'kra2_a_co_authorship':
                            inputName = `kra2_a_co_authorship[${row_id}][evidence_file]`;
                            break;
                        case 'kra2_a_lead_researcher':
                            inputName = `kra1_a_lead_researcher[${row_id}][evidence_file]`;
                            break;
                        case 'kra2_a_contributor':
                            inputName = `kra1_a_contributor[${row_id}][evidence_file]`;
                            break;
                        case 'kra2_a_local_authors':
                            inputName = `kra1_a_local_authors[${row_id}][evidence_file]`;
                            break;
                        case 'kra2_a_international_authors':
                            inputName = `kra1_a_international_authors[${row_id}][evidence_file]`;
                            break;
                    }

                    $(`input[name="${inputName}"]`).val(data.file_path);
                } else {
                    alert('Failed to upload file: ' + data.message);
                }
            },
            error: function() {
                alert('An error occurred during the file upload.');
            }
        });
    }

    // Click event for 'Upload Evidence' buttons
    $('#criterion-a-form').on('click', '.upload-evidence-btn', function() {
        var subcriterionId = $(this).data('subcriterion-id');
        var row = $(this).closest('tr');
        var index = row.index() + 1;

        // Determine the table based on the button's context
        var table;
        if (row.closest('table').is('#sole-authorship-table')) {
            table = 'kra2_a_sole_authorship';
        } else if (row.closest('table').is('#co-authorship-table')) {
            table = 'kra2_a_co_authorship';
        } else if (row.closest('table').is('#lead-researcher-table')) {
            table = 'kra2_a_lead_researcher';
        } else if (row.closest('table').is('#contributor-table')) {
            table = 'kra2_a_contributor';
        } else if (row.closest('table').is('#local-authors-table')) {
            table = 'kra2_a_local_authors';
        } else if (row.closest('table').is('#international-authors-table')) {
            table = 'kra2_a_international_authors';
        }

        // Open file input dialog
        var fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.style.display = 'none';
        document.body.appendChild(fileInput);

        fileInput.addEventListener('change', function(e) {
            var file = e.target.files[0];
            if (file) {
                var formData = new FormData();
                formData.append('evidence_file', file);
                formData.append('request_id', $('#request_id').val()); // Hidden input field
                formData.append('table', table); // Table identifier
                formData.append('row_id', index); // Unique identifier for the row

                handleFileUpload(formData, table, index);
            }
            document.body.removeChild(fileInput);
        });

        fileInput.click();
    });

    // Saving data
    $('#save-criterion-a').click(function() {
        const formData = new FormData(document.getElementById('criterion-a-form'));
        // Append the request_id to the formData
        formData.append('request_id', $('#request_id').val());

        $.ajax({
            url: '../../includes/career_progress_tracking/research/kra2_save_criterion_a.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                const data = JSON.parse(response);
                if (data.status === 'success') {
                    $('#successModal').modal('show');
                } else {
                    $('#errorModal').modal('show');
                }
            },
            error: function() {
                $('#errorModal').modal('show');
            }
        });
    });

    // Function to populate form fields
    function populateForm(data) {
        // Helper function to set values in a table
        function setTableData(tableId, dataArray) {
            const table = $(`#${tableId}`);
            dataArray.forEach((item, index) => {
                let row;
                if (index === 0) {
                    row = table.find('tbody tr:first');
                } else {
                    addNewRow(tableId);
                    row = table.find('tbody tr').eq(index);
                }

                for (const key in item) {
                    row.find(`[name*="[${key}]"]`).val(item[key]);
                }
            });
        }

        // Set values for each table
        setTableData('sole-authorship-table', data.sole_authorship);
        setTableData('co-authorship-table', data.co_authorship);
        setTableData('lead-researcher-table', data.lead_researcher);
        setTableData('contributor-table', data.contributor);
        setTableData('local-authors-table', data.local_authors);
        setTableData('international-authors-table', data.international_authors);

        // Set overall scores
        if (data.metadata) {
            $('#kra2_a_sole_authorship_total').val(data.metadata.sole_authorship_total);
            $('#kra2_a_co_authorship_total').val(data.metadata.co_authorship_total);
            $('#kra1_a_lead_researcher_total').val(data.metadata.lead_researcher_total);
            $('#kra1_a_contributor_total').val(data.metadata.contributor_total);
            $('#kra1_a_local_authors_total').val(data.metadata.local_authors_total);
            $('#kra1_a_international_authors_total').val(data.metadata.international_authors_total);
        }
        updateTotalScores();
    }

    // Fetch and populate form data when request_id is updated
    // Function to fetch and populate form data
    function fetchAndPopulateCriterionA(requestId) {
        $.ajax({
            url: 'kra2_fetch_criterion_a.php', // Ensure this path is correct
            type: 'GET',
            data: {
                request_id: requestId
            },
            success: function(response) {
                const data = JSON.parse(response);
                if (!data.error) {
                    // Populate the form with the fetched data
                    window.CriterionA.populateForm(data);
                } else {
                    console.error("Error fetching data:", data.error);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });
    }

    // Listen for changes to the request_id input
    $('#request_id').on('change', function() {
        const request_id = $(this).val();
        if (request_id) {
            fetchFormData(request_id);
        }
    });
});

// Add this to your global scope or another appropriate location
window.CriterionA = {
    fetchCriterionA: function(requestId) {
        // Set the input field value for Criterion A
        const requestIdInput = document.getElementById('request_id');
        if (requestIdInput) {
            requestIdInput.value = requestId;
            $(requestIdInput).trigger('change'); // Trigger the change event
        } else {
            console.error('Input field with id "request_id" not found.');
        }
    }
};