// php/dashboard/career_progress_tracking/research/js/kra2_criterion_a.js
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

    // For Sole Authorship
    function addDefaultSoleAuthorshipRows(tableBody) {
        const requestId = document.getElementById('request_id')?.value.trim() || '0';
        // Create, for example, 3 default blank rows
        for (let i = 1; i <= 3; i++) {
            const row = document.createElement('tr');
            row.setAttribute('data-sole-id', '0');
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
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[new_${Date.now()}][journal_publisher]" placeholder="Journal/Publisher"></td>
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[new_${Date.now()}][reviewer]" placeholder="Reviewer"></td>
                <td>
                    <select class="form-select" name="kra2_a_sole_authorship[new_${Date.now()}][international]">
                        <option value="">SELECT OPTION</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </td>
                <td><input type="date" class="form-control" name="kra2_a_sole_authorship[new_${Date.now()}][date_published]"></td>
                <td><input type="number" class="form-control score-input" name="kra2_a_sole_authorship[new_${Date.now()}][score]" placeholder="0" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn"
                        data-subcriterion="sole" data-record-id="0" data-file-path="">
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

    // For Co-Authorship
    function addDefaultCoAuthorshipRows(tableBody) {
        const requestId = document.getElementById('request_id')?.value.trim() || '0';
        for (let i = 1; i <= 3; i++) {
            const row = document.createElement('tr');
            row.setAttribute('data-co-id', '0');
            row.innerHTML = `
                <td>${i}</td>
                <td><input type="text" class="form-control" name="kra2_a_co_authorship[new_${Date.now()}][title]" placeholder="Title of Research Output"></td>
                <td>
                    <select class="form-select" name="kra2_a_co_authorship[new_${Date.now()}][type]">
                        <option value="">SELECT OPTION</option>
                        <option value="Book">Book</option>
                        <option value="Journal Article">Journal Article</option>
                        <option value="Book Chapter">Book Chapter</option>
                        <option value="Monograph">Monograph</option>
                        <option value="Other Peer-Reviewed Output">Other Peer-Reviewed Output</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra2_a_co_authorship[new_${Date.now()}][journal_publisher]" placeholder="Journal/Publisher"></td>
                <td><input type="text" class="form-control" name="kra2_a_co_authorship[new_${Date.now()}][reviewer]" placeholder="Reviewer"></td>
                <td>
                    <select class="form-select" name="kra2_a_co_authorship[new_${Date.now()}][international]">
                        <option value="">SELECT OPTION</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </td>
                <td><input type="date" class="form-control" name="kra2_a_co_authorship[new_${Date.now()}][date_published]"></td>
                <td><input type="number" class="form-control" name="kra2_a_co_authorship[new_${Date.now()}][contribution_percentage]" placeholder="0.00"></td>
                <td><input type="number" class="form-control score-input" name="kra2_a_co_authorship[new_${Date.now()}][score]" placeholder="0" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn"
                        data-subcriterion="co" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra2_a_co_authorship[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
            `;
            tableBody.appendChild(row);
        }
    }

    // For Lead Researcher
    function addDefaultLeadResearcherRows(tableBody) {
        const requestId = document.getElementById('request_id')?.value.trim() || '0';
        for (let i = 1; i <= 3; i++) {
            const row = document.createElement('tr');
            row.setAttribute('data-lead-id', '0');
            row.innerHTML = `
                <td>${i}</td>
                <td><input type="text" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][title]" placeholder="Title of Research"></td>
                <td><input type="date" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][date_completed]"></td>
                <td><input type="text" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][project_name]" placeholder="Name of Project, Policy or Product"></td>
                <td><input type="text" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][funding_source]" placeholder="Funding Source"></td>
                <td><input type="date" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][date_implemented]"></td>
                <td><input type="number" class="form-control score-input" name="kra2_a_lead_researcher[new_${Date.now()}][score]" placeholder="0" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn"
                        data-subcriterion="lead" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra2_a_lead_researcher[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
            `;
            tableBody.appendChild(row);
        }
    }

    // For Contributor
    function addDefaultContributorRows(tableBody) {
        const requestId = document.getElementById('request_id')?.value.trim() || '0';
        for (let i = 1; i <= 3; i++) {
            const row = document.createElement('tr');
            row.setAttribute('data-contributor-id', '0');
            row.innerHTML = `
                <td>${i}</td>
                <td><input type="text" class="form-control" name="kra2_a_contributor[new_${Date.now()}][title]" placeholder="Title of Research"></td>
                <td><input type="date" class="form-control" name="kra2_a_contributor[new_${Date.now()}][date_completed]"></td>
                <td><input type="text" class="form-control" name="kra2_a_contributor[new_${Date.now()}][project_name]" placeholder="Name of Project, Policy or Product"></td>
                <td><input type="text" class="form-control" name="kra2_a_contributor[new_${Date.now()}][funding_source]" placeholder="Funding Source"></td>
                <td><input type="date" class="form-control" name="kra2_a_contributor[new_${Date.now()}][date_implemented]"></td>
                <td><input type="number" class="form-control" name="kra2_a_contributor[new_${Date.now()}][contribution_percentage]" placeholder="0.00"></td>
                <td><input type="number" class="form-control score-input" name="kra2_a_contributor[new_${Date.now()}][score]" placeholder="0" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn"
                        data-subcriterion="contributor" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra2_a_contributor[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
            `;
            tableBody.appendChild(row);
        }
    }

    // For Local Authors
    function addDefaultLocalAuthorsRows(tableBody) {
        const requestId = document.getElementById('request_id')?.value.trim() || '0';
        for (let i = 1; i <= 3; i++) {
            const row = document.createElement('tr');
            row.setAttribute('data-local-id', '0');
            row.innerHTML = `
                <td>${i}</td>
                <td><input type="text" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][title]" placeholder="Title of Journal Article"></td>
                <td><input type="date" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][date_published]"></td>
                <td><input type="text" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][journal_name]" placeholder="Name of Journal"></td>
                <td><input type="number" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][citation_count]" placeholder="0"></td>
                <td><input type="text" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][citation_index]" placeholder="Citation Index"></td>
                <td><input type="number" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][citation_year]" placeholder="Year"></td>
                <td><input type="number" class="form-control score-input" name="kra2_a_local_authors[new_${Date.now()}][score]" placeholder="0" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn"
                        data-subcriterion="local" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra2_a_local_authors[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
            `;
            tableBody.appendChild(row);
        }
    }

    // For International Authors
    function addDefaultInternationalAuthorsRows(tableBody) {
        const requestId = document.getElementById('request_id')?.value.trim() || '0';
        for (let i = 1; i <= 3; i++) {
            const row = document.createElement('tr');
            row.setAttribute('data-international-id', '0');
            row.innerHTML = `
                <td>${i}</td>
                <td><input type="text" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][title]" placeholder="Title of Journal Article"></td>
                <td><input type="date" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][date_published]"></td>
                <td><input type="text" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][journal_name]" placeholder="Name of Journal"></td>
                <td><input type="number" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][citation_count]" placeholder="0"></td>
                <td><input type="text" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][citation_index]" placeholder="Citation Index"></td>
                <td><input type="number" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][citation_year]" placeholder="Year"></td>
                <td><input type="number" class="form-control score-input" name="kra2_a_international_authors[new_${Date.now()}][score]" placeholder="0" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn"
                        data-subcriterion="international" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra2_a_international_authors[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
            `;
            tableBody.appendChild(row);
        }
    }

    function showMessage(message) {
        $('#messageModal .modal-body').html(message);
        var messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
        messageModal.show();
    }
    
    window.showMessage = showMessage; 

    // === POPULATE TABLES ===
    // A.1 Sole Authorship
    function populateSoleAuthorship(soleData) {
        var tableBody = document.querySelector('#sole-authorship-table tbody');
        var requestId = document.getElementById('request_id').value.trim();
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
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[${index}][title]" value="${escapeHTML(item.title)}"></td>
                <td>
                    <select class="form-select" name="kra2_a_sole_authorship[${index}][type]">
                        <option value="">SELECT OPTION</option>
                        <option value="Book" ${item.type === 'Book' ? 'selected' : ''}>Book</option>
                        <option value="Journal Article" ${item.type === 'Journal Article' ? 'selected' : ''}>Journal Article</option>
                        <option value="Book Chapter" ${item.type === 'Book Chapter' ? 'selected' : ''}>Book Chapter</option>
                        <option value="Monograph" ${item.type === 'Monograph' ? 'selected' : ''}>Monograph</option>
                        <option value="Other Peer-Reviewed Output" ${item.type === 'Other Peer-Reviewed Output' ? 'selected' : ''}>Other Peer-Reviewed Output</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[${index}][journal_publisher]" value="${escapeHTML(item.journal_publisher || '')}"></td>
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[${index}][reviewer]" value="${escapeHTML(item.reviewer || '')}"></td>
                <td>
                    <select class="form-select" name="kra2_a_sole_authorship[${index}][international]">
                        <option value="">SELECT OPTION</option>
                        <option value="Yes" ${item.international === 'Yes' ? 'selected' : ''}>Yes</option>
                        <option value="No" ${item.international === 'No' ? 'selected' : ''}>No</option>
                    </select>
                </td>
                <td><input type="date" class="form-control" name="kra2_a_sole_authorship[${index}][date_published]" value="${item.date_published || ''}"></td>
                <td><input type="number" class="form-control score-input" name="kra2_a_sole_authorship[${index}][score]" value="${item.score || ''}" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                        data-subcriterion="sole" 
                        data-record-id="${item.sole_authorship_id}" 
                        data-file-path="${escapeHTML(item.evidence_file || '')}">
                        ${evidenceButtonLabel}
                    </button>
                    <input type="hidden" name="kra2_a_sole_authorship[${index}][evidence_file]" value="${escapeHTML(item.evidence_file || '')}">
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

    // A.2 Co-authorship
    function populateCoAuthorship(coData) {
        var tableBody = document.querySelector('#co-authorship-table tbody');
        var requestId = document.getElementById('request_id').value.trim();
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
                <td><input type="text" class="form-control" name="kra2_a_co_authorship[${index}][title]" value="${escapeHTML(item.title)}"></td>
                <td>
                    <select class="form-select" name="kra2_a_co_authorship[${index}][type]">
                        <option value="">SELECT OPTION</option>
                        <option value="Book" ${item.type === 'Book' ? 'selected' : ''}>Book</option>
                        <option value="Journal Article" ${item.type === 'Journal Article' ? 'selected' : ''}>Journal Article</option>
                        <option value="Book Chapter" ${item.type === 'Book Chapter' ? 'selected' : ''}>Book Chapter</option>
                        <option value="Monograph" ${item.type === 'Monograph' ? 'selected' : ''}>Monograph</option>
                        <option value="Other Peer-Reviewed Output" ${item.type === 'Other Peer-Reviewed Output' ? 'selected' : ''}>Other Peer-Reviewed Output</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra2_a_co_authorship[${index}][journal_publisher]" value="${escapeHTML(item.journal_publisher || '')}"></td>
                <td><input type="text" class="form-control" name="kra2_a_co_authorship[${index}][reviewer]" value="${escapeHTML(item.reviewer || '')}"></td>
                <td>
                    <select class="form-select" name="kra2_a_co_authorship[${index}][international]">
                        <option value="">SELECT OPTION</option>
                        <option value="Yes" ${item.international === 'Yes' ? 'selected' : ''}>Yes</option>
                        <option value="No" ${item.international === 'No' ? 'selected' : ''}>No</option>
                    </select>
                </td>
                <td><input type="date" class="form-control" name="kra2_a_co_authorship[${index}][date_published]" value="${item.date_published || ''}"></td>
                <td><input type="number" class="form-control" name="kra2_a_co_authorship[${index}][contribution_percentage]" value="${item.contribution_percentage || ''}"></td>
                <td><input type="number" class="form-control score-input" name="kra2_a_co_authorship[${index}][score]" value="${item.score || ''}" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                        data-subcriterion="co" 
                        data-record-id="${item.co_authorship_id}" 
                        data-file-path="${escapeHTML(item.evidence_file || '')}">
                        ${evidenceButtonLabel}
                    </button>
                    <input type="hidden" name="kra2_a_co_authorship[${index}][evidence_file]" value="${escapeHTML(item.evidence_file || '')}">
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

    // A.3 Lead Researcher
    function populateLeadResearcher(leadData) {
        var tableBody = document.querySelector('#lead-researcher-table tbody');
        var requestId = document.getElementById('request_id').value.trim();
        tableBody.innerHTML = '';

        if (!leadData || leadData.length === 0) {
            addDefaultLeadResearcherRows(tableBody);
            return;
        }

        leadData.forEach(function (item, index) {
            var tr = document.createElement('tr');
            tr.setAttribute('data-lead-id', item.lead_researcher_id);

            var evidenceButtonLabel = item.evidence_file ? 'Change Evidence' : 'Upload Evidence';

            var rowHTML = `
                <td>${index + 1}</td>
                <td><input type="text" class="form-control" name="kra2_a_lead_researcher[${index}][title]" value="${escapeHTML(item.title)}"></td>
                <td><input type="date" class="form-control" name="kra2_a_lead_researcher[${index}][date_completed]" value="${item.date_completed || ''}"></td>
                <td><input type="text" class="form-control" name="kra2_a_lead_researcher[${index}][project_name]" value="${escapeHTML(item.project_name || '')}"></td>
                <td><input type="text" class="form-control" name="kra2_a_lead_researcher[${index}][funding_source]" value="${escapeHTML(item.funding_source || '')}"></td>
                <td><input type="date" class="form-control" name="kra2_a_lead_researcher[${index}][date_implemented]" value="${item.date_implemented || ''}"></td>
                <td><input type="number" class="form-control score-input" name="kra2_a_lead_researcher[${index}][score]" value="${item.score || ''}" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                        data-subcriterion="lead" 
                        data-record-id="${item.lead_researcher_id}" 
                        data-file-path="${escapeHTML(item.evidence_file || '')}">
                        ${evidenceButtonLabel}
                    </button>
                    <input type="hidden" name="kra2_a_lead_researcher[${index}][evidence_file]" value="${escapeHTML(item.evidence_file || '')}">
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

    // A.4 Contributor
    function populateContributor(contributorData) {
        var tableBody = document.querySelector('#contributor-table tbody');
        var requestId = document.getElementById('request_id').value.trim();
        tableBody.innerHTML = '';

        if (!contributorData || contributorData.length === 0) {
            addDefaultContributorRows(tableBody);
            return;
        }

        contributorData.forEach(function (item, index) {
            var tr = document.createElement('tr');
            tr.setAttribute('data-contributor-id', item.contributor_id);

            var evidenceButtonLabel = item.evidence_file ? 'Change Evidence' : 'Upload Evidence';

            var rowHTML = `
                <td>${index + 1}</td>
                <td><input type="text" class="form-control" name="kra2_a_contributor[${index}][title]" value="${escapeHTML(item.title)}"></td>
                <td><input type="date" class="form-control" name="kra2_a_contributor[${index}][date_completed]" value="${item.date_completed || ''}"></td>
                <td><input type="text" class="form-control" name="kra2_a_contributor[${index}][project_name]" value="${escapeHTML(item.project_name || '')}"></td>
                <td><input type="text" class="form-control" name="kra2_a_contributor[${index}][funding_source]" value="${escapeHTML(item.funding_source || '')}"></td>
                <td><input type="date" class="form-control" name="kra2_a_contributor[${index}][date_implemented]" value="${item.date_implemented || ''}"></td>
                <td><input type="number" class="form-control" name="kra2_a_contributor[${index}][contribution_percentage]" value="${item.contribution_percentage || ''}"></td>
                <td><input type="number" class="form-control score-input" name="kra2_a_contributor[${index}][score]" value="${item.score || ''}" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                        data-subcriterion="contributor" 
                        data-record-id="${item.contributor_id}" 
                        data-file-path="${escapeHTML(item.evidence_file || '')}">
                        ${evidenceButtonLabel}
                    </button>
                    <input type="hidden" name="kra2_a_contributor[${index}][evidence_file]" value="${escapeHTML(item.evidence_file || '')}">
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

    // A.5 Local Authors
    function populateLocalAuthors(localData) {
        var tableBody = document.querySelector('#local-authors-table tbody');
        var requestId = document.getElementById('request_id').value.trim();
        tableBody.innerHTML = '';

        if (!localData || localData.length === 0) {
            addDefaultLocalAuthorsRows(tableBody);
            return;
        }

        localData.forEach(function (item, index) {
            var tr = document.createElement('tr');
            tr.setAttribute('data-local-id', item.local_author_id);

            var evidenceButtonLabel = item.evidence_file ? 'Change Evidence' : 'Upload Evidence';

            var rowHTML = `
                <td>${index + 1}</td>
                <td><input type="text" class="form-control" name="kra2_a_local_authors[${index}][title]" value="${escapeHTML(item.title)}"></td>
                <td><input type="date" class="form-control" name="kra2_a_local_authors[${index}][date_published]" value="${item.date_published || ''}"></td>
                <td><input type="text" class="form-control" name="kra2_a_local_authors[${index}][journal_name]" value="${escapeHTML(item.journal_name || '')}"></td>
                <td><input type="number" class="form-control" name="kra2_a_local_authors[${index}][citation_count]" value="${item.citation_count || ''}"></td>
                <td><input type="text" class="form-control" name="kra2_a_local_authors[${index}][citation_index]" value="${escapeHTML(item.citation_index || '')}"></td>
                <td><input type="number" class="form-control" name="kra2_a_local_authors[${index}][citation_year]" value="${item.citation_year || ''}"></td>
                <td><input type="number" class="form-control score-input" name="kra2_a_local_authors[${index}][score]" value="${item.score || ''}" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                        data-subcriterion="local" 
                        data-record-id="${item.local_author_id}" 
                        data-file-path="${escapeHTML(item.evidence_file || '')}">
                        ${evidenceButtonLabel}
                    </button>
                    <input type="hidden" name="kra2_a_local_authors[${index}][evidence_file]" value="${escapeHTML(item.evidence_file || '')}">
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

    // A.6 International Authors
    function populateInternationalAuthors(internationalData) {
        var tableBody = document.querySelector('#international-authors-table tbody');
        var requestId = document.getElementById('request_id').value.trim();
        tableBody.innerHTML = '';

        if (!internationalData || internationalData.length === 0) {
            addDefaultInternationalAuthorsRows(tableBody);
            return;
        }

        internationalData.forEach(function (item, index) {
            var tr = document.createElement('tr');
            tr.setAttribute('data-international-id', item.international_author_id);

            var evidenceButtonLabel = item.evidence_file ? 'Change Evidence' : 'Upload Evidence';

            var rowHTML = `
            <td>${index + 1}</td>
            <td><input type="text" class="form-control" name="kra2_a_international_authors[${index}][title]" value="${escapeHTML(item.title)}"></td>
            <td><input type="date" class="form-control" name="kra2_a_international_authors[${index}][date_published]" value="${item.date_published || ''}"></td>
            <td><input type="text" class="form-control" name="kra2_a_international_authors[${index}][journal_name]" value="${escapeHTML(item.journal_name || '')}"></td>
            <td><input type="number" class="form-control" name="kra2_a_international_authors[${index}][citation_count]" value="${item.citation_count || ''}"></td>
            <td><input type="text" class="form-control" name="kra2_a_international_authors[${index}][citation_index]" value="${escapeHTML(item.citation_index || '')}"></td>
            <td><input type="number" class="form-control" name="kra2_a_international_authors[${index}][citation_year]" value="${item.citation_year || ''}"></td>
            <td><input type="number" class="form-control score-input" name="kra2_a_international_authors[${index}][score]" value="${item.score || ''}" readonly></td>
            <td>
                <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                    data-subcriterion="international" 
                    data-record-id="${item.international_author_id}" 
                    data-file-path="${escapeHTML(item.evidence_file || '')}">
                    ${evidenceButtonLabel}
                </button>
                <input type="hidden" name="kra2_a_international_authors[${index}][evidence_file]" value="${escapeHTML(item.evidence_file || '')}">
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
    if (!metadata) {
        // Check if each element exists before setting its value
        if (document.getElementById('kra2_a_sole_authorship_total')) {
            document.getElementById('kra2_a_sole_authorship_total').value = '';
        }
        if (document.getElementById('kra2_a_co_authorship_total')) {
            document.getElementById('kra2_a_co_authorship_total').value = '';
        }
        if (document.getElementById('kra2_a_lead_researcher_total')) {
            document.getElementById('kra2_a_lead_researcher_total').value = '';
        }
        if (document.getElementById('kra2_a_contributor_total')) {
            document.getElementById('kra2_a_contributor_total').value = '';
        }
        if (document.getElementById('kra2_a_local_authors_total')) {
            document.getElementById('kra2_a_local_authors_total').value = '';
        }
        if (document.getElementById('kra2_a_international_authors_total')) {
            document.getElementById('kra2_a_international_authors_total').value = '';
        }
        return;
    }

    // Check if each element exists before setting its value (for the metadata case)
    if (document.getElementById('kra2_a_sole_authorship_total')) {
        document.getElementById('kra2_a_sole_authorship_total').value = metadata.sole_authorship_total || '';
    }
    if (document.getElementById('kra2_a_co_authorship_total')) {
        document.getElementById('kra2_a_co_authorship_total').value = metadata.co_authorship_total || '';
    }
    if (document.getElementById('kra2_a_lead_researcher_total')) {
        document.getElementById('kra2_a_lead_researcher_total').value = metadata.lead_researcher_total || '';
    }
    if (document.getElementById('kra2_a_contributor_total')) {
        document.getElementById('kra2_a_contributor_total').value = metadata.contributor_total || '';
    }
    if (document.getElementById('kra2_a_local_authors_total')) {
        document.getElementById('kra2_a_local_authors_total').value = metadata.local_authors_total || '';
    }
    if (document.getElementById('kra2_a_international_authors_total')) {
        document.getElementById('kra2_a_international_authors_total').value = metadata.international_authors_total || '';
    }
}

// === MAIN FETCH FUNCTION ===
CriterionA.fetchCriterionA = function (requestId) {
    return fetch(`../../includes/career_progress_tracking/research/kra2_fetch_criterion_a.php?request_id=${requestId}`)
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            if (data.success) {
                // Populate each sub-criterion table
                populateSoleAuthorship(data.sole_authorship || []);
                populateCoAuthorship(data.co_authorship || []);
                populateLeadResearcher(data.lead_researcher || []);
                populateContributor(data.contributor || []);
                populateLocalAuthors(data.local_authors || []);
                populateInternationalAuthors(data.international_authors || []);
                populateMetadata(data.metadata);
                return data;
            } else {
                console.error('Error:', data.error);
                showMessage('Failed to fetch Criterion A data: ' + data.error);
            }
        })
        .catch(function (error) {
            console.error('Error fetching data:', error);
            showMessage('Failed to fetch Criterion A data. Check console for details.');
        });
};

// === INIT FUNCTION ===
CriterionA.init = function () {
    var form = document.getElementById('criterion-a-form');
    var saveBtn = document.getElementById('save-criterion-a');
    var deleteRowModal = new bootstrap.Modal(document.getElementById('deleteRowModal'));
    var deleteSuccessModal = new bootstrap.Modal(document.getElementById('deleteSuccessModal'));
    var uploadSingleEvidenceModal = new bootstrap.Modal(document.getElementById('uploadSingleEvidenceModalA'));

    // Track deleted records
    var deletedRecords = {
        sole: [],
        co: [],
        lead: [],
        contributor: [],
        local: [],
        international: []
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
    function getSoleAuthorshipScore(type, international) {
        if (type === 'Book' || type === 'Monograph') {
            return 100;
        } else if (type === 'Journal Article') {
            return international === 'Yes' ? 50 : 0;
        } else if (type === 'Book Chapter') {
            return 35;
        } else if (type === 'Other Peer-Reviewed Output') {
            return 10;
        } else {
            return 0;
        }
    }

    function getCoAuthorshipScore(type, international, contribution) {
        let baseScore = 0;
        if (type === 'Book' || type === 'Monograph') {
            baseScore = 100;
        } else if (type === 'Journal Article') {
            baseScore = international === 'Yes' ? 50 : 0;
        } else if (type === 'Book Chapter') {
            baseScore = 35;
        } else if (type === 'Other Peer-Reviewed Output') {
            baseScore = 10;
        }
        return baseScore * (contribution / 100);
    }
    
    function getLeadResearcherScore(title, dateCompleted, projectName, fundingSource, dateImplemented) {
        if (title && dateCompleted && projectName && fundingSource && dateImplemented) {
            return 35;
        } else {
            return 0;
        }
    }
    
    function getContributorScore(title, dateCompleted, projectName, fundingSource, dateImplemented, contribution) {
        if (title && dateCompleted && projectName && fundingSource && dateImplemented) {
            return 35 * (contribution / 100);
        } else {
            return 0;
        }
    }
    
    function getLocalAuthorsScore(citationCount) {
        return citationCount * 5;
    }
    
    function getInternationalAuthorsScore(citationCount) {
        return citationCount * 10;
    }

    // 2) Compute & Set the Row's "score" in Real Time
    function computeRowScore(row, tableId) {
        const scoreInput = row.querySelector('input[name*="[score]"]');
        if (!scoreInput) return;

        let computedScore = 0;
        if (tableId === 'sole-authorship-table') {
            const materialType = row.querySelector('select[name*="[type]"]')?.value || '';
            const isInternational = row.querySelector('select[name*="[international]"]')?.value || '';
            computedScore = getSoleAuthorshipScore(materialType, isInternational);

        } else if (tableId === 'co-authorship-table') {
            const materialType = row.querySelector('select[name*="[type]"]')?.value || '';
            const isInternational = row.querySelector('select[name*="[international]"]')?.value || '';
            const contrib = parseFloat(row.querySelector('input[name*="[contribution_percentage]"]')?.value || 0);
            computedScore = getCoAuthorshipScore(materialType, isInternational, contrib);

        } else if (tableId === 'lead-researcher-table') {
            const title = row.querySelector('input[name*="[title]"]')?.value || '';
            const dateCompleted = row.querySelector('input[name*="[date_completed]"]')?.value || '';
            const projectName = row.querySelector('input[name*="[project_name]"]')?.value || '';
            const fundingSource = row.querySelector('input[name*="[funding_source]"]')?.value || '';
            const dateImplemented = row.querySelector('input[name*="[date_implemented]"]')?.value || '';
            computedScore = getLeadResearcherScore(title, dateCompleted, projectName, fundingSource, dateImplemented);

        } else if (tableId === 'contributor-table') {
            const title = row.querySelector('input[name*="[title]"]')?.value || '';
            const dateCompleted = row.querySelector('input[name*="[date_completed]"]')?.value || '';
            const projectName = row.querySelector('input[name*="[project_name]"]')?.value || '';
            const fundingSource = row.querySelector('input[name*="[funding_source]"]')?.value || '';
            const dateImplemented = row.querySelector('input[name*="[date_implemented]"]')?.value || '';
            const contribution = parseFloat(row.querySelector('input[name*="[contribution_percentage]"]')?.value || 0);
            computedScore = getContributorScore(title, dateCompleted, projectName, fundingSource, dateImplemented, contribution);

        } else if (tableId === 'local-authors-table') {
            const citationCount = parseInt(row.querySelector('input[name*="[citation_count]"]')?.value || 0, 10);
            computedScore = getLocalAuthorsScore(citationCount);

        } else if (tableId === 'international-authors-table') {
            const citationCount = parseInt(row.querySelector('input[name*="[citation_count]"]')?.value || 0, 10);
            computedScore = getInternationalAuthorsScore(citationCount);
        }

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
        $('#kra2_a_sole_authorship_total').val(total.toFixed(2));
    }

    function recalcCoAuthorship() {
        let total = 0;
        $('#co-authorship-table tbody tr').each(function () {
            const score = parseFloat($(this).find('input[name*="[score]"]').val()) || 0;
            total += score;
        });
        $('#kra2_a_co_authorship_total').val(total.toFixed(2));
    }

    function recalcLeadResearcher() {
        let total = 0;
        $('#lead-researcher-table tbody tr').each(function () {
            const score = parseFloat($(this).find('input[name*="[score]"]').val()) || 0;
            total += score;
        });
        $('#kra2_a_lead_researcher_total').val(total.toFixed(2));
    }

    function recalcContributor() {
        let total = 0;
        $('#contributor-table tbody tr').each(function () {
            const score = parseFloat($(this).find('input[name*="[score]"]').val()) || 0;
            total += score;
        });
        $('#kra2_a_contributor_total').val(total.toFixed(2));
    }

    function recalcLocalAuthors() {
        let total = 0;
        $('#local-authors-table tbody tr').each(function () {
            const score = parseFloat($(this).find('input[name*="[score]"]').val()) || 0;
            total += score;
        });
        $('#kra2_a_local_authors_total').val(total.toFixed(2));
    }

    function recalcInternationalAuthors() {
        let total = 0;
        $('#international-authors-table tbody tr').each(function () {
            const score = parseFloat($(this).find('input[name*="[score]"]').val()) || 0;
            total += score;
        });
        $('#kra2_a_international_authors_total').val(total.toFixed(2));
    }

    // 4) Recalc All Tables and Mark Form Dirty
    function recalcAll() {
        recalcSoleAuthorship();
        recalcCoAuthorship();
        recalcLeadResearcher();
        recalcContributor();
        recalcLocalAuthors();
        recalcInternationalAuthors();
        markFormAsDirty();
    }

    // 5) Hook Up Event Listeners for Any Input/Select Changes
    $(document).on('input change',
        '#sole-authorship-table select, #sole-authorship-table input, ' +
        '#co-authorship-table select, #co-authorship-table input, ' +
        '#lead-researcher-table input, ' +
        '#contributor-table input, ' +
        '#local-authors-table input, ' +
        '#international-authors-table input',
        function (e) {
            const row = e.target.closest('tr');
            const tableId = row.closest('table').id;
            computeRowScore(row, tableId);
            recalcAll();
        }
    );

    // === SINGLE-FILE UPLOAD LOGIC ===
    $(document).on('click', '.upload-evidence-btn', function () {
        var button = $(this);
        var recordId = button.data('record-id');
        var subcriterion = button.data('subcriterion'); // 'sole', 'co', 'lead', etc.
        var filePath = button.data('file-path');
        var requestId = $('#request_id').val();

        if (!requestId) {
            showMessage('No valid Request ID found. Please select an evaluation first.');
            return;
        }
        if (recordId === '0' || !recordId) {
            showMessage('Please save the row before uploading evidence (row must have a valid ID).');
            return;
        }

        // Store data in hidden fields inside the modal
        $('#a_modal_request_id').val(requestId);
        $('#a_modal_subcriterion').val(subcriterion);
        $('#a_modal_record_id').val(recordId);
        $('#a_existing_file_path').val(filePath || '');

        // Reset the file input and set filename
        $('#singleAFileInput').val('');
        $('#singleAFileName').text(filePath ? filePath.split('/').pop() : '');

        uploadSingleEvidenceModal.show();
    });

    // Show filename when changed
    $('#singleAFileInput').on('change', function () {
        $('#singleAFileName').text(this.files[0] ? this.files[0].name : '');
    });

    // Confirm Upload
    $('#a_uploadSingleEvidenceBtn').on('click', function () {
        var formData = new FormData($('#a_singleEvidenceUploadForm')[0]);
        var fileInput = $('#singleAFileInput')[0].files[0];
        if (!fileInput) {
            showMessage('Please select a file to upload.');
            return;
        }

        $.ajax({
            url: '../kra2_upload_evidence_criterion_a.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    var subcriterion = $('#a_modal_subcriterion').val();
                    var recordId = $('#a_modal_record_id').val();
                    var filePath = response.path;

                    // Find the matching row
                    var tableSelector = '';
                    if (subcriterion === 'sole') {
                        tableSelector = '#sole-authorship-table';
                    } else if (subcriterion === 'co') {
                        tableSelector = '#co-authorship-table';
                    } else if (subcriterion === 'lead') {
                        tableSelector = '#lead-researcher-table';
                    } else if (subcriterion === 'contributor') {
                        tableSelector = '#contributor-table';
                    } else if (subcriterion === 'local') {
                        tableSelector = '#local-authors-table';
                    } else if (subcriterion === 'international') {
                        tableSelector = '#international-authors-table';
                    }
                    var row = $(tableSelector).find(`tr[data-${subcriterion}-id="${recordId}"]`);
                    row.find('input[name*="[evidence_file]"]').val(filePath);
                    row.find('.upload-evidence-btn').data('file-path', filePath).text('Change Evidence');

                    uploadSingleEvidenceModal.hide();
                    markFormAsDirty();
                    showMessage('File uploaded successfully!');

                    CriterionA.fetchCriterionA($('#request_id').val());
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

    // === DELETE FILE LOGIC ===
    $('#deleteFileBtn').on('click', function () {
        var subcriterion = $('#modal_subcriterion').val();
        var recordId = $('#modal_record_id').val();
        var requestId = $('#modal_request_id').val();

        if (!confirm('Are you sure you want to delete this evidence file?')) {
            return;
        }

        $.ajax({
            url: '../kra2_delete_evidence_criterion_a.php',
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
                    } else if (subcriterion === 'lead') {
                        tableSelector = '#lead-researcher-table';
                    } else if (subcriterion === 'contributor') {
                        tableSelector = '#contributor-table';
                    } else if (subcriterion === 'local') {
                        tableSelector = '#local-authors-table';
                    } else if (subcriterion === 'international') {
                        tableSelector = '#international-authors-table';
                    }
                    var row = $(tableSelector).find(`tr[data-${subcriterion}-id="${recordId}"]`);
                    row.find('input[name*="[evidence_file]"]').val('');
                    row.find('.upload-evidence-btn').data('file-path', '').text('Upload Evidence');

                    showMessage('Evidence file deleted successfully.');
                    uploadSingleEvidenceModal.hide();
                    markFormAsDirty();

                    var requestId = $('#request_id').val();
                    CriterionA.fetchCriterionA(requestId);
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
                    : rowToDelete.hasAttribute('data-lead-id') ? 'lead'
                    : rowToDelete.hasAttribute('data-contributor-id') ? 'contributor'
                    : rowToDelete.hasAttribute('data-local-id') ? 'local'
                    : rowToDelete.hasAttribute('data-international-id') ? 'international'
                    : null;

            recordIdToDelete = rowToDelete.getAttribute(`data-${subcriterionToDelete}-id`) || '0';
            deleteRowModal.show();
        }
    });

    document.getElementById('confirm-delete-row').addEventListener('click', function () {
        if (rowToDelete) {
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

    // === VIEW REMARKS HANDLER ===
    $(document).on('click', '.view-remarks', function () {
        showMessage('No remarks to display.'); // Placeholder
    });

    // === ADD ROW LOGIC FOR EACH SUB-CRITERION ===
    // Sole Authorship
    $('.add-sole-authorship-row').on('click', function () {
        var tableId = $(this).data('table-id');
        var tableBody = document.querySelector(`#${tableId} tbody`);
        var newRow = document.createElement('tr');
        var rowCount = tableBody.querySelectorAll('tr').length + 1;
        newRow.setAttribute('data-sole-id', '0');

        newRow.innerHTML = `
            <td>${rowCount}</td>
            <td><input type="text" class="form-control" name="kra2_a_sole_authorship[new_${Date.now()}][title]"></td>
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
            <td><input type="text" class="form-control" name="kra2_a_sole_authorship[new_${Date.now()}][journal_publisher]"></td>
            <td><input type="text" class="form-control" name="kra2_a_sole_authorship[new_${Date.now()}][reviewer]"></td>
            <td>
                <select class="form-select" name="kra2_a_sole_authorship[new_${Date.now()}][international]">
                    <option value="">SELECT OPTION</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </td>
            <td><input type="date" class="form-control" name="kra2_a_sole_authorship[new_${Date.now()}][date_published]"></td>
            <td><input type="number" class="form-control score-input" name="kra2_a_sole_authorship[new_${Date.now()}][score]" readonly></td>
            <td>
                <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                    data-subcriterion="sole" data-record-id="0" data-file-path="">
                    Upload Evidence
                </button>
                <input type="hidden" name="kra2_a_sole_authorship[new_${Date.now()}][evidence_file]" value="">
            </td>
            <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
            <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
        `;
        tableBody.appendChild(newRow);
        markFormAsDirty();
    });

    // Co-authorship
    $('.add-co-authorship-row').on('click', function () {
        var tableId = $(this).data('table-id');
        var tableBody = document.querySelector(`#${tableId} tbody`);
        var newRow = document.createElement('tr');
        var rowCount = tableBody.querySelectorAll('tr').length + 1;
        newRow.setAttribute('data-co-id', '0');

        newRow.innerHTML = `
            <td>${rowCount}</td>
            <td><input type="text" class="form-control" name="kra2_a_co_authorship[new_${Date.now()}][title]"></td>
            <td>
                <select class="form-select" name="kra2_a_co_authorship[new_${Date.now()}][type]">
                    <option value="">SELECT OPTION</option>
                    <option value="Book">Book</option>
                    <option value="Journal Article">Journal Article</option>
                    <option value="Book Chapter">Book Chapter</option>
                    <option value="Monograph">Monograph</option>
                    <option value="Other Peer-Reviewed Output">Other Peer-Reviewed Output</option>
                </select>
            </td>
            <td><input type="text" class="form-control" name="kra2_a_co_authorship[new_${Date.now()}][journal_publisher]"></td>
            <td><input type="text" class="form-control" name="kra2_a_co_authorship[new_${Date.now()}][reviewer]"></td>
            <td>
                <select class="form-select" name="kra2_a_co_authorship[new_${Date.now()}][international]">
                    <option value="">SELECT OPTION</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </td>
            <td><input type="date" class="form-control" name="kra2_a_co_authorship[new_${Date.now()}][date_published]"></td>
            <td><input type="number" class="form-control" name="kra2_a_co_authorship[new_${Date.now()}][contribution_percentage]"></td>
            <td><input type="number" class="form-control score-input" name="kra2_a_co_authorship[new_${Date.now()}][score]" readonly></td>
            <td>
                <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                    data-subcriterion="co" data-record-id="0" data-file-path="">
                    Upload Evidence
                </button>
                <input type="hidden" name="kra2_a_co_authorship[new_${Date.now()}][evidence_file]" value="">
            </td>
            <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
            <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
        `;
        tableBody.appendChild(newRow);
        markFormAsDirty();
    });

    // Lead Researcher
    $('.add-lead-researcher-row').on('click', function () {
        var tableId = $(this).data('table-id');
        var tableBody = document.querySelector(`#${tableId} tbody`);
        var newRow = document.createElement('tr');
        var rowCount = tableBody.querySelectorAll('tr').length + 1;
        newRow.setAttribute('data-lead-id', '0');

        newRow.innerHTML = `
            <td>${rowCount}</td>
            <td><input type="text" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][title]"></td>
            <td><input type="date" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][date_completed]"></td>
            <td><input type="text" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][project_name]"></td>
            <td><input type="text" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][funding_source]"></td>
            <td><input type="date" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][date_implemented]"></td>
            <td><input type="number" class="form-control score-input" name="kra2_a_lead_researcher[new_${Date.now()}][score]" readonly></td>
            <td>
                <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                    data-subcriterion="lead" data-record-id="0" data-file-path="">
                    Upload Evidence
                </button>
                <input type="hidden" name="kra2_a_lead_researcher[new_${Date.now()}][evidence_file]" value="">
            </td>
            <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
            <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
        `;
        tableBody.appendChild(newRow);
        markFormAsDirty();
    });

    // Contributor
    $('.add-contributor-row').on('click', function () {
        var tableId = $(this).data('table-id');
        var tableBody = document.querySelector(`#${tableId} tbody`);
        var newRow = document.createElement('tr');
        var rowCount = tableBody.querySelectorAll('tr').length + 1;
        newRow.setAttribute('data-contributor-id', '0');

        newRow.innerHTML = `
            <td>${rowCount}</td>
            <td><input type="text" class="form-control" name="kra2_a_contributor[new_${Date.now()}][title]"></td>
            <td><input type="date" class="form-control" name="kra2_a_contributor[new_${Date.now()}][date_completed]"></td>
            <td><input type="text" class="form-control" name="kra2_a_contributor[new_${Date.now()}][project_name]"></td>
            <td><input type="text" class="form-control" name="kra2_a_contributor[new_${Date.now()}][funding_source]"></td>
            <td><input type="date" class="form-control" name="kra2_a_contributor[new_${Date.now()}][date_implemented]"></td>
            <td><input type="number" class="form-control" name="kra2_a_contributor[new_${Date.now()}][contribution_percentage]"></td>
            <td><input type="number" class="form-control score-input" name="kra2_a_contributor[new_${Date.now()}][score]" readonly></td>
            <td>
                <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                    data-subcriterion="contributor" data-record-id="0" data-file-path="">
                    Upload Evidence
                </button>
                <input type="hidden" name="kra2_a_contributor[new_${Date.now()}][evidence_file]" value="">
            </td>
            <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
            <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
        `;
        tableBody.appendChild(newRow);
        markFormAsDirty();
    });

    // Local Authors
    $('.add-local-authors-row').on('click', function () {
        var tableId = $(this).data('table-id');
        var tableBody = document.querySelector(`#${tableId} tbody`);
        var newRow = document.createElement('tr');
        var rowCount = tableBody.querySelectorAll('tr').length + 1;
        newRow.setAttribute('data-local-id', '0');

        newRow.innerHTML = `
            <td>${rowCount}</td>
            <td><input type="text" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][title]"></td>
            <td><input type="date" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][date_published]"></td>
            <td><input type="text" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][journal_name]"></td>
            <td><input type="number" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][citation_count]"></td>
            <td><input type="text" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][citation_index]"></td>
            <td><input type="number" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][citation_year]"></td>
                            <td><input type="number" class="form-control score-input" name="kra2_a_local_authors[new_${Date.now()}][score]" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                        data-subcriterion="local" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra2_a_local_authors[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
            `;
            tableBody.appendChild(newRow);
            markFormAsDirty();
        });

        // International Authors
        $('.add-international-authors-row').on('click', function () {
            var tableId = $(this).data('table-id');
            var tableBody = document.querySelector(`#${tableId} tbody`);
            var newRow = document.createElement('tr');
            var rowCount = tableBody.querySelectorAll('tr').length + 1;
            newRow.setAttribute('data-international-id', '0');

            newRow.innerHTML = `
                <td>${rowCount}</td>
                <td><input type="text" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][title]"></td>
                <td><input type="date" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][date_published]"></td>
                <td><input type="text" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][journal_name]"></td>
                <td><input type="number" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][citation_count]"></td>
                <td><input type="text" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][citation_index]"></td>
                <td><input type="number" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][citation_year]"></td>
                <td><input type="number" class="form-control score-input" name="kra2_a_international_authors[new_${Date.now()}][score]" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                        data-subcriterion="international" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra2_a_international_authors[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
            `;
            tableBody.appendChild(newRow);
            markFormAsDirty();
        });

        // === SAVE PROCESS ===
        function gatherPayload() {
            var requestId = parseInt(document.getElementById('request_id').value.trim(), 10) || 0;

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
                    journal_publisher: inputs.filter('[name*="[journal_publisher]"]').val() || '',
                    reviewer: inputs.filter('[name*="[reviewer]"]').val() || '',
                    international: inputs.filter('[name*="[international]"]').val() || '',
                    date_published: inputs.filter('[name*="[date_published]"]').val() || '',
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
                    journal_publisher: inputs.filter('[name*="[journal_publisher]"]').val() || '',
                    reviewer: inputs.filter('[name*="[reviewer]"]').val() || '',
                    international: inputs.filter('[name*="[international]"]').val() || '',
                    date_published: inputs.filter('[name*="[date_published]"]').val() || '',
                    contribution_percentage: parseFloat(inputs.filter('[name*="[contribution_percentage]"]').val()) || 0,
                    score: parseFloat(inputs.filter('[name*="[score]"]').val()) || 0,
                    evidence_file: inputs.filter('[name*="[evidence_file]"]').val() || ''
                };
                coRows.push(rowData);
            });

            // Lead Researcher
            var leadRows = [];
            $('#lead-researcher-table tbody tr').each(function () {
                var row = $(this);
                var recordId = row.attr('data-lead-id') || '0';

                var inputs = row.find('input, select');
                var rowData = {
                    lead_researcher_id: recordId,
                    title: inputs.filter('[name*="[title]"]').val() || '',
                    date_completed: inputs.filter('[name*="[date_completed]"]').val() || '',
                    project_name: inputs.filter('[name*="[project_name]"]').val() || '',
                    funding_source: inputs.filter('[name*="[funding_source]"]').val() || '',
                    date_implemented: inputs.filter('[name*="[date_implemented]"]').val() || '',
                    score: parseFloat(inputs.filter('[name*="[score]"]').val()) || 0,
                    evidence_file: inputs.filter('[name*="[evidence_file]"]').val() || ''
                };
                leadRows.push(rowData);
            });

            // Contributor
            var contributorRows = [];
            $('#contributor-table tbody tr').each(function () {
                var row = $(this);
                var recordId = row.attr('data-contributor-id') || '0';

                var inputs = row.find('input, select');
                var rowData = {
                    contributor_id: recordId,
                    title: inputs.filter('[name*="[title]"]').val() || '',
                    date_completed: inputs.filter('[name*="[date_completed]"]').val() || '',
                    project_name: inputs.filter('[name*="[project_name]"]').val() || '',
                    funding_source: inputs.filter('[name*="[funding_source]"]').val() || '',
                    date_implemented: inputs.filter('[name*="[date_implemented]"]').val() || '',
                    contribution_percentage: parseFloat(inputs.filter('[name*="[contribution_percentage]"]').val()) || 0,
                    score: parseFloat(inputs.filter('[name*="[score]"]').val()) || 0,
                    evidence_file: inputs.filter('[name*="[evidence_file]"]').val() || ''
                };
                contributorRows.push(rowData);
            });

            // Local Authors
            var localRows = [];
            $('#local-authors-table tbody tr').each(function () {
                var row = $(this);
                var recordId = row.attr('data-local-id') || '0';

                var inputs = row.find('input, select');
                var rowData = {
                    local_author_id: recordId,
                    title: inputs.filter('[name*="[title]"]').val() || '',
                    date_published: inputs.filter('[name*="[date_published]"]').val() || '',
                    journal_name: inputs.filter('[name*="[journal_name]"]').val() || '',
                    citation_count: parseInt(inputs.filter('[name*="[citation_count]"]').val(), 10) || 0,
                    citation_index: inputs.filter('[name*="[citation_index]"]').val() || '',
                    citation_year: inputs.filter('[name*="[citation_year]"]').val() || '',
                    score: parseFloat(inputs.filter('[name*="[score]"]').val()) || 0,
                    evidence_file: inputs.filter('[name*="[evidence_file]"]').val() || ''
                };
                localRows.push(rowData);
            });

            // International Authors
            var internationalRows = [];
            $('#international-authors-table tbody tr').each(function () {
                var row = $(this);
                var recordId = row.attr('data-international-id') || '0';

                var inputs = row.find('input, select');
                var rowData = {
                    international_author_id: recordId,
                    title: inputs.filter('[name*="[title]"]').val() || '',
                    date_published: inputs.filter('[name*="[date_published]"]').val() || '',
                    journal_name: inputs.filter('[name*="[journal_name]"]').val() || '',
                    citation_count: parseInt(inputs.filter('[name*="[citation_count]"]').val(), 10) || 0,
                    citation_index: inputs.filter('[name*="[citation_index]"]').val() || '',
                    citation_year: inputs.filter('[name*="[citation_year]"]').val() || '',
                    score: parseFloat(inputs.filter('[name*="[score]"]').val()) || 0,
                    evidence_file: inputs.filter('[name*="[evidence_file]"]').val() || ''
                };
                internationalRows.push(rowData);
            });

            // Totals (Metadata)
            var sole_total = parseFloat($('#kra2_a_sole_authorship_total').val()) || 0;
            var co_total = parseFloat($('#kra2_a_co_authorship_total').val()) || 0;
            var lead_total = parseFloat($('#kra2_a_lead_researcher_total').val()) || 0;
            var contributor_total = parseFloat($('#kra2_a_contributor_total').val()) || 0;
            var local_total = parseFloat($('#kra2_a_local_authors_total').val()) || 0;
            var international_total = parseFloat($('#kra2_a_international_authors_total').val()) || 0;

            return {
                request_id: requestId,
                sole_authorship: soleRows,
                co_authorship: coRows,
                lead_researcher: leadRows,
                contributor: contributorRows,
                local_authors: localRows,
                international_authors: internationalRows,
                metadata: {
                    sole_authorship_total: sole_total,
                    co_authorship_total: co_total,
                    lead_researcher_total: lead_total,
                    contributor_total: contributor_total,
                    local_authors_total: local_total,
                    international_authors_total: international_total
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
                showMessage('Please select a valid evaluation ID before saving Criterion A.');
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
                    showMessage('Criterion A data saved successfully!');
                    // Reset deleted arrays
                    deletedRecords.sole = [];
                    deletedRecords.co = [];
                    deletedRecords.lead = [];
                    deletedRecords.contributor = [];
                    deletedRecords.local = [];
                    deletedRecords.international = [];
                    markFormAsClean();
                    CriterionA.fetchCriterionA(requestId);
                } else {
                    showMessage(data.error || 'An error occurred while saving Criterion A.');
                }
            })
            .catch(function (error) {
                console.error('Error:', error);
                showMessage('Failed to save Criterion A data. Please check the console for details.');
            });
        }

        // Attach save event
        saveBtn.addEventListener('click', function () {
            saveCriterionA();
        });

        // Mark form as clean on initial load
        markFormAsClean();
    };

    // On DOM load, initialize everything for Criterion A
    document.addEventListener('DOMContentLoaded', function () {
        CriterionA.init();
    });

    // Expose the namespace
    window.CriterionA = CriterionA;

}(window, document, jQuery));