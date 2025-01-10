// careerpath/php/includes/career_progress_tracking/research/kra2_criterion_a.js
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

    // === MESSAGE MODAL HANDLER ===
    function showMessage(message) {
        $('#messageModalBody').text(message);
        var messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
        messageModal.show();
    }
    window.showMessage = showMessage; // Make it accessible if needed by other scripts

    // Define markFormAsClean function
    CriterionA.markFormAsClean = function () {
        console.log(' No unsaved changes.');
        // Example: Remove a 'dirty' class or indicator
        $('#save-criterion-a').removeClass('btn-warning');
        // You can add more logic here as needed
    };

    // Define markFormAsDirty function
    CriterionA.markFormAsDirty = function () {
        console.log('Unsaved changes present.');
        // Example: Add a 'dirty' class or indicator
        $('#save-criterion-a').addClass('btn-warning');
        // You can add more logic here as needed
    };

    // === POPULATE TABLES ===
    // A.1 Sole Authorship
    function populateSoleAuthorship(soleData) {
        var tableBody = document.querySelector('#sole-authorship-table tbody');
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
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[${index}][title]" value="${escapeHTML(item.title)}" required></td>
                <td>
                    <select class="form-select" name="kra2_a_sole_authorship[${index}][type]" required>
                        <option value="">SELECT OPTION</option>
                        <option value="Book" ${item.type === 'Book' ? 'selected' : ''}>Book</option>
                        <option value="Journal Article" ${item.type === 'Journal Article' ? 'selected' : ''}>Journal Article</option>
                        <option value="Book Chapter" ${item.type === 'Book Chapter' ? 'selected' : ''}>Book Chapter</option>
                        <option value="Monograph" ${item.type === 'Monograph' ? 'selected' : ''}>Monograph</option>
                        <option value="Other Peer-Reviewed Output" ${item.type === 'Other Peer-Reviewed Output' ? 'selected' : ''}>Other Peer-Reviewed Output</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[${index}][journal_publisher]" value="${escapeHTML(item.journal_publisher || '')}" required></td>
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[${index}][reviewer]" value="${escapeHTML(item.reviewer || '')}" required></td>
                <td>
                    <select class="form-select" name="kra2_a_sole_authorship[${index}][international]">
                        <option value="">SELECT OPTION</option>
                        <option value="Yes" ${item.international === 'Yes' ? 'selected' : ''}>Yes</option>
                        <option value="No" ${item.international === 'No' ? 'selected' : ''}>No</option>
                    </select>
                </td>
                <td><input type="date" class="form-control" name="kra2_a_sole_authorship[${index}][date_published]" value="${item.date_published || ''}" required></td>
                <td><input type="text" class="form-control score-input" name="kra2_a_sole_authorship[${index}][score]" value="${item.score || ''}" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
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

    // A.2 Co-Authorship
    function populateCoAuthorship(coData) {
        var tableBody = document.querySelector('#co-authorship-table tbody');
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
                <td><input type="text" class="form-control" name="kra2_a_co_authorship[${index}][title]" value="${escapeHTML(item.title)}" required></td>
                <td>
                    <select class="form-select" name="kra2_a_co_authorship[${index}][type]" required>
                        <option value="">SELECT OPTION</option>
                        <option value="Book" ${item.type === 'Book' ? 'selected' : ''}>Book</option>
                        <option value="Journal Article" ${item.type === 'Journal Article' ? 'selected' : ''}>Journal Article</option>
                        <option value="Book Chapter" ${item.type === 'Book Chapter' ? 'selected' : ''}>Book Chapter</option>
                        <option value="Monograph" ${item.type === 'Monograph' ? 'selected' : ''}>Monograph</option>
                        <option value="Other Peer-Reviewed Output" ${item.type === 'Other Peer-Reviewed Output' ? 'selected' : ''}>Other Peer-Reviewed Output</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra2_a_co_authorship[${index}][journal_publisher]" value="${escapeHTML(item.journal_publisher || '')}" required></td>
                <td><input type="text" class="form-control" name="kra2_a_co_authorship[${index}][reviewer]" value="${escapeHTML(item.reviewer || '')}" required></td>
                <td>
                    <select class="form-select" name="kra2_a_co_authorship[${index}][international]">
                        <option value="">SELECT OPTION</option>
                        <option value="Yes" ${item.international === 'Yes' ? 'selected' : ''}>Yes</option>
                        <option value="No" ${item.international === 'No' ? 'selected' : ''}>No</option>
                    </select>
                </td>
                <td><input type="date" class="form-control" name="kra2_a_co_authorship[${index}][date_published]" value="${item.date_published || ''}" required></td>
                <td><input type="number" class="form-control" name="kra2_a_co_authorship[${index}][contribution_percentage]" value="${item.contribution_percentage || ''}" placeholder="0" min="0" max="100" required></td>
                <td><input type="text" class="form-control score-input" name="kra2_a_co_authorship[${index}][score]" value="${item.score || ''}" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
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
                <td><input type="text" class="form-control" name="kra2_a_lead_researcher[${index}][title]" value="${escapeHTML(item.title)}" required></td>
                <td><input type="date" class="form-control" name="kra2_a_lead_researcher[${index}][date_completed]" value="${item.date_completed || ''}" required></td>
                <td><input type="text" class="form-control" name="kra2_a_lead_researcher[${index}][project_name]" value="${escapeHTML(item.project_name || '')}" required></td>
                <td><input type="text" class="form-control" name="kra2_a_lead_researcher[${index}][funding_source]" value="${escapeHTML(item.funding_source || '')}" required></td>
                <td><input type="date" class="form-control" name="kra2_a_lead_researcher[${index}][date_implemented]" value="${item.date_implemented || ''}" required></td>
                <td><input type="text" class="form-control score-input" name="kra2_a_lead_researcher[${index}][score]" value="${item.score || ''}" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
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
    function populateContributor(contribData) {
        var tableBody = document.querySelector('#contributor-table tbody');
        tableBody.innerHTML = '';

        if (!contribData || contribData.length === 0) {
            addDefaultContributorRows(tableBody);
            return;
        }

        contribData.forEach(function (item, index) {
            var tr = document.createElement('tr');
            tr.setAttribute('data-contrib-id', item.contributor_id);

            var evidenceButtonLabel = item.evidence_file ? 'Change Evidence' : 'Upload Evidence';

            var rowHTML = `
                <td>${index + 1}</td>
                <td><input type="text" class="form-control" name="kra2_a_contributor[${index}][title]" value="${escapeHTML(item.title)}" required></td>
                <td><input type="date" class="form-control" name="kra2_a_contributor[${index}][date_completed]" value="${item.date_completed || ''}" required></td>
                <td><input type="text" class="form-control" name="kra2_a_contributor[${index}][project_name]" value="${escapeHTML(item.project_name || '')}" required></td>
                <td><input type="text" class="form-control" name="kra2_a_contributor[${index}][funding_source]" value="${escapeHTML(item.funding_source || '')}" required></td>
                <td><input type="date" class="form-control" name="kra2_a_contributor[${index}][date_implemented]" value="${item.date_implemented || ''}" required></td>
                <td><input type="number" class="form-control" name="kra2_a_contributor[${index}][contribution_percentage]" value="${item.contribution_percentage || ''}" placeholder="0" min="0" max="100" required></td>
                <td><input type="text" class="form-control score-input" name="kra2_a_contributor[${index}][score]" value="${item.score || ''}" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
                        data-subcriterion="contrib" 
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
                <td><input type="text" class="form-control" name="kra2_a_local_authors[${index}][title]" value="${escapeHTML(item.title)}" required></td>
                <td><input type="date" class="form-control" name="kra2_a_local_authors[${index}][date_published]" value="${item.date_published || ''}" required></td>
                <td><input type="text" class="form-control" name="kra2_a_local_authors[${index}][journal_name]" value="${escapeHTML(item.journal_name)}" required></td>
                <td><input type="number" class="form-control" name="kra2_a_local_authors[${index}][citation_count]" value="${item.citation_count || ''}" placeholder="No. of Citation" min="0" required></td>
                <td><input type="text" class="form-control" name="kra2_a_local_authors[${index}][citation_index]" value="${escapeHTML(item.citation_index || '')}" required></td>
                <td><input type="date" class="form-control" name="kra2_a_local_authors[${index}][citation_year]" value="${item.citation_year || ''}" required></td>
                <td><input type="text" class="form-control score-input" name="kra2_a_local_authors[${index}][score]" value="${item.score || ''}" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
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
                <td><input type="text" class="form-control" name="kra2_a_international_authors[${index}][title]" value="${escapeHTML(item.title)}" required></td>
                <td><input type="date" class="form-control" name="kra2_a_international_authors[${index}][date_published]" value="${item.date_published || ''}" required></td>
                <td><input type="text" class="form-control" name="kra2_a_international_authors[${index}][journal_name]" value="${escapeHTML(item.journal_name)}" required></td>
                <td><input type="number" class="form-control" name="kra2_a_international_authors[${index}][citation_count]" value="${item.citation_count || ''}" placeholder="No. of Citation" min="0" required></td>
                <td><input type="text" class="form-control" name="kra2_a_international_authors[${index}][citation_index]" value="${escapeHTML(item.citation_index || '')}" required></td>
                <td><input type="date" class="form-control" name="kra2_a_international_authors[${index}][citation_year]" value="${item.citation_year || ''}" required></td>
                <td><input type="text" class="form-control score-input" name="kra2_a_international_authors[${index}][score]" value="${item.score || ''}" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
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

    // === ADD DEFAULT ROWS FUNCTION ===
    function addDefaultSoleAuthorshipRows(tableBody) {
        for (let i = 1; i <= 3; i++) {
            var row = document.createElement('tr');
            row.setAttribute('data-sole-id', '0');
            row.innerHTML = `
                <td>${i}</td>
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[new_${Date.now()}][title]" placeholder="Title of Research Output" required></td>
                <td>
                    <select class="form-select" name="kra2_a_sole_authorship[new_${Date.now()}][type]" required>
                        <option value="">SELECT OPTION</option>
                        <option value="Book">Book</option>
                        <option value="Journal Article">Journal Article</option>
                        <option value="Book Chapter">Book Chapter</option>
                        <option value="Monograph">Monograph</option>
                        <option value="Other Peer-Reviewed Output">Other Peer-Reviewed Output</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[new_${Date.now()}][journal_publisher]" placeholder="Name of Journal / Publisher" required></td>
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[new_${Date.now()}][reviewer]" placeholder="Reviewer or Its Equivalent" required></td>
                <td>
                    <select class="form-select" name="kra2_a_sole_authorship[new_${Date.now()}][international]">
                        <option value="">SELECT OPTION</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </td>
                <td><input type="date" class="form-control" name="kra2_a_sole_authorship[new_${Date.now()}][date_published]" required></td>
                <td><input type="text" class="form-control score-input" name="kra2_a_sole_authorship[new_${Date.now()}][score]" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
                        data-subcriterion="sole" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra2_a_sole_authorship[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
            `;
            tableBody.appendChild(row);
        }
    }

    function addDefaultCoAuthorshipRows(tableBody) {
        for (let i = 1; i <= 3; i++) {
            var row = document.createElement('tr');
            row.setAttribute('data-co-id', '0');
            row.innerHTML = `
                <td>${i}</td>
                <td><input type="text" class="form-control" name="kra2_a_co_authorship[new_${Date.now()}][title]" placeholder="Title of Research Output" required></td>
                <td>
                    <select class="form-select" name="kra2_a_co_authorship[new_${Date.now()}][type]" required>
                        <option value="">SELECT OPTION</option>
                        <option value="Book">Book</option>
                        <option value="Journal Article">Journal Article</option>
                        <option value="Book Chapter">Book Chapter</option>
                        <option value="Monograph">Monograph</option>
                        <option value="Other Peer-Reviewed Output">Other Peer-Reviewed Output</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra2_a_co_authorship[new_${Date.now()}][journal_publisher]" placeholder="Name of Journal / Publisher" required></td>
                <td><input type="text" class="form-control" name="kra2_a_co_authorship[new_${Date.now()}][reviewer]" placeholder="Reviewer or Its Equivalent" required></td>
                <td>
                    <select class="form-select" name="kra2_a_co_authorship[new_${Date.now()}][international]">
                        <option value="">SELECT OPTION</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </td>
                <td><input type="date" class="form-control" name="kra2_a_co_authorship[new_${Date.now()}][date_published]" required></td>
                <td><input type="number" class="form-control" name="kra2_a_co_authorship[new_${Date.now()}][contribution_percentage]" placeholder="0" min="0" max="100" required></td>
                <td><input type="text" class="form-control score-input" name="kra2_a_co_authorship[new_${Date.now()}][score]" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
                        data-subcriterion="co" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra2_a_co_authorship[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
            `;
            tableBody.appendChild(row);
        }
    }

    function addDefaultLeadResearcherRows(tableBody) {
        for (let i = 1; i <= 3; i++) {
            var row = document.createElement('tr');
            row.setAttribute('data-lead-id', '0');
            row.innerHTML = `
                <td>${i}</td>
                <td><input type="text" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][title]" placeholder="Title of Research" required></td>
                <td><input type="date" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][date_completed]" required></td>
                <td><input type="text" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][project_name]" placeholder="Name of Project, Policy or Product" required></td>
                <td><input type="text" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][funding_source]" placeholder="Funding Source" required></td>
                <td><input type="date" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][date_implemented]" required></td>
                <td><input type="text" class="form-control score-input" name="kra2_a_lead_researcher[new_${Date.now()}][score]" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
                        data-subcriterion="lead" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra2_a_lead_researcher[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
            `;
            tableBody.appendChild(row);
        }
    }

    function addDefaultContributorRows(tableBody) {
        for (let i = 1; i <= 3; i++) {
            var row = document.createElement('tr');
            row.setAttribute('data-contrib-id', '0');
            row.innerHTML = `
                <td>${i}</td>
                <td><input type="text" class="form-control" name="kra2_a_contributor[new_${Date.now()}][title]" placeholder="Title of Research" required></td>
                <td><input type="date" class="form-control" name="kra2_a_contributor[new_${Date.now()}][date_completed]" required></td>
                <td><input type="text" class="form-control" name="kra2_a_contributor[new_${Date.now()}][project_name]" placeholder="Name of Project, Policy or Product" required></td>
                <td><input type="text" class="form-control" name="kra2_a_contributor[new_${Date.now()}][funding_source]" placeholder="Funding Source" required></td>
                <td><input type="date" class="form-control" name="kra2_a_contributor[new_${Date.now()}][date_implemented]" required></td>
                <td><input type="number" class="form-control" name="kra2_a_contributor[new_${Date.now()}][contribution_percentage]" placeholder="0" min="0" max="100" required></td>
                <td><input type="text" class="form-control score-input" name="kra2_a_contributor[new_${Date.now()}][score]" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
                        data-subcriterion="contrib" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra2_a_contributor[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
            `;
            tableBody.appendChild(row);
        }
    }

    function addDefaultLocalAuthorsRows(tableBody) {
        for (let i = 1; i <= 3; i++) {
            var row = document.createElement('tr');
            row.setAttribute('data-local-id', '0');
            row.innerHTML = `
                <td>${i}</td>
                <td><input type="text" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][title]" placeholder="Title of Journal Article" required></td>
                <td><input type="date" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][date_published]" required></td>
                <td><input type="text" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][journal_name]" placeholder="Name of Journal" required></td>
                <td><input type="number" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][citation_count]" placeholder="No. of Citation" min="0" required></td>
                <td><input type="text" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][citation_index]" placeholder="Citation Index" required></td>
                <td><input type="date" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][citation_year]" required></td>
                <td><input type="text" class="form-control score-input" name="kra2_a_local_authors[new_${Date.now()}][score]" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
                        data-subcriterion="local" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra2_a_local_authors[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
            `;
            tableBody.appendChild(row);
        }
    }

    function addDefaultInternationalAuthorsRows(tableBody) {
        for (let i = 1; i <= 3; i++) {
            var row = document.createElement('tr');
            row.setAttribute('data-international-id', '0');
            row.innerHTML = `
                <td>${i}</td>
                <td><input type="text" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][title]" placeholder="Title of Journal Article" required></td>
                <td><input type="date" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][date_published]" required></td>
                <td><input type="text" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][journal_name]" placeholder="Name of Journal" required></td>
                <td><input type="number" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][citation_count]" placeholder="No. of Citation" min="0" required></td>
                <td><input type="text" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][citation_index]" placeholder="Citation Index" required></td>
                <td><input type="date" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][citation_year]" required></td>
                <td><input type="text" class="form-control score-input" name="kra2_a_international_authors[new_${Date.now()}][score]" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
                        data-subcriterion="international" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra2_a_international_authors[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
            `;
            tableBody.appendChild(row);
        }
    }

    // === CALCULATION FUNCTIONS ===
    // Define scoring logic based on Criterion A's rules

    // A.1 Sole Authorship Scoring
    function getSoleAuthorshipScore(row) {
        const title = row.querySelector('input[name*="[title]"]').value.trim();
        const journalPublisher = row.querySelector('input[name*="[journal_publisher]"]').value.trim();
        const reviewer = row.querySelector('input[name*="[reviewer]"]').value.trim();
        const datePublished = row.querySelector('input[name*="[date_published]"]').value.trim();
        const type = row.querySelector('select[name*="[type]"]').value;
        const international = row.querySelector('select[name*="[international]"]').value;

        // Check if required fields are filled
        if (!title || !journalPublisher || !reviewer || !datePublished) {
            return 0;
        }

        // Scoring based on Type
        switch (type) {
            case 'Book':
                return 100;
            case 'Journal Article':
                return international ? 50 : 0; // Only if "International" is filled
            case 'Book Chapter':
                return 35;
            case 'Monograph':
                return 100;
            case 'Other Peer-Reviewed Output':
                return 10;
            default:
                return 0;
        }
    }

    // A.2 Co-Authorship Scoring
    function getCoAuthorshipScore(row) {
        const title = row.querySelector('input[name*="[title]"]').value.trim();
        const datePublished = row.querySelector('input[name*="[date_published]"]').value.trim();
        const type = row.querySelector('select[name*="[type]"]').value;
        const international = row.querySelector('select[name*="[international]"]').value;

        // Check if required fields are filled
        if (!title || !datePublished) {
            return 0;
        }

        // Scoring based on Type
        switch (type) {
            case 'Book':
                return 100;
            case 'Journal Article':
                return (international === '') ? 50 : 0; // Only if "International" is NOT blank
            case 'Book Chapter':
                return 35;
            case 'Monograph':
                return 100;
            case 'Other Peer-Reviewed Output':
                return 10;
            default:
                return 0;
        }
    }

    // A.3 Lead Researcher Scoring
    function getLeadResearcherScore(row) {
        const title = row.querySelector('input[name*="[title]"]').value.trim();
        const dateCompleted = row.querySelector('input[name*="[date_completed]"]').value.trim();
        const projectName = row.querySelector('input[name*="[project_name]"]').value.trim();
        const fundingSource = row.querySelector('input[name*="[funding_source]"]').value.trim();
        const dateImplemented = row.querySelector('input[name*="[date_implemented]"]').value.trim();

        // Check if required fields are filled
        if (!title || !dateCompleted || !projectName || !fundingSource || !dateImplemented) {
            return 0;
        }

        // All required fields filled
        return 35;
    }

    // A.4 Contributor Scoring
    function getContributorScore(row) {
        const title = row.querySelector('input[name*="[title]"]').value.trim();
        const dateCompleted = row.querySelector('input[name*="[date_completed]"]').value.trim();
        const projectName = row.querySelector('input[name*="[project_name]"]').value.trim();
        const fundingSource = row.querySelector('input[name*="[funding_source]"]').value.trim();
        const dateImplemented = row.querySelector('input[name*="[date_implemented]"]').value.trim();
        const contributionPercentage = parseFloat(row.querySelector('input[name*="[contribution_percentage]"]').value) || 0;

        // Check if required fields are filled
        if (!title || !dateCompleted || !projectName || !fundingSource || !dateImplemented) {
            return 0;
        }

        // All required fields filled
        return 35 * (contributionPercentage / 100);
    }

    // A.5 Local Authors Scoring
    function getLocalAuthorsScore(row) {
        const citationCount = parseInt(row.querySelector('input[name*="[citation_count]"]').value, 10) || 0;
        return citationCount * 5;
    }

    // A.6 International Authors Scoring
    function getInternationalAuthorsScore(row) {
        const citationCount = parseInt(row.querySelector('input[name*="[citation_count]"]').value, 10) || 0;
        return citationCount * 10;
    }

    // Compute the row's score based on the table it belongs to
    function computeRowScore(row, tableId) {
        let computedScore = 0;

        if (tableId === 'sole-authorship-table') {
            computedScore = getSoleAuthorshipScore(row);
        } else if (tableId === 'co-authorship-table') {
            computedScore = getCoAuthorshipScore(row);
        } else if (tableId === 'lead-researcher-table') {
            computedScore = getLeadResearcherScore(row);
        } else if (tableId === 'contributor-table') {
            computedScore = getContributorScore(row);
        } else if (tableId === 'local-authors-table') {
            computedScore = getLocalAuthorsScore(row);
        } else if (tableId === 'international-authors-table') {
            computedScore = getInternationalAuthorsScore(row);
        }

        // Update the score input
        const scoreInput = row.querySelector('input[name*="[score]"]');
        if (scoreInput) {
            scoreInput.value = computedScore.toFixed(2);
        }
    }

    // Recalculate totals for each sub-criterion
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

    // Recalculate all totals
    function recalcAll() {
        recalcSoleAuthorship();
        recalcCoAuthorship();
        recalcLeadResearcher();
        recalcContributor();
        recalcLocalAuthors();
        recalcInternationalAuthors();
    }

    // === FETCH DATA FUNCTION ===
    CriterionA.fetchCriterionA = function (requestId) {
        return fetch(`../../includes/career_progress_tracking/research/kra2_fetch_criterion_a.php?request_id=${requestId}`)
            .then(function (response) {
                if (!response.ok) { // Ensure the response is OK (status in the range 200-299)
                    throw new Error('Network response was not ok');
                }
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
                    recalcAll();
                    // markFormAsClean();
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

    // === POPULATE METADATA ===
    function populateMetadata(metadata) {
        if (!metadata) {
            $('#kra2_a_sole_authorship_total').val('');
            $('#kra2_a_co_authorship_total').val('');
            $('#kra2_a_lead_researcher_total').val('');
            $('#kra2_a_contributor_total').val('');
            $('#kra2_a_local_authors_total').val('');
            $('#kra2_a_international_authors_total').val('');
            return;
        }
        $('#kra2_a_sole_authorship_total').val(metadata.sole_authorship_total || '0.00');
        $('#kra2_a_co_authorship_total').val(metadata.co_authorship_total || '0.00');
        $('#kra2_a_lead_researcher_total').val(metadata.lead_researcher_total || '0.00');
        $('#kra2_a_contributor_total').val(metadata.contributor_total || '0.00');
        $('#kra2_a_local_authors_total').val(metadata.local_authors_total || '0.00');
        $('#kra2_a_international_authors_total').val(metadata.international_authors_total || '0.00');
    }

    // === INIT FUNCTION ===
    CriterionA.init = function () {
        var form = document.getElementById('criterion-a-form');
        var saveBtn = document.getElementById('save-criterion-a');

        // Track deleted records
        var deletedRecords = {
            sole: [],
            co: [],
            lead: [],
            contrib: [],
            local: [],
            international: []
        };

        // Dirty flag
        var isFormDirty = false;
        function markFormAsDirty() {
            if (!isFormDirty) {
                isFormDirty = true;
                saveBtn.classList.add('btn-warning');
            }
        }
        function markFormAsClean() {
            isFormDirty = false;
            saveBtn.classList.remove('btn-warning');
        }

        // Event Listeners for input/select changes to compute scores
        $(document).on('input change',
            '#sole-authorship-table input, #sole-authorship-table select, ' +
            '#co-authorship-table input, #co-authorship-table select, ' +
            '#lead-researcher-table input, #lead-researcher-table select, ' +
            '#contributor-table input, #contributor-table select, ' +
            '#local-authors-table input, #local-authors-table select, ' +
            '#international-authors-table input, #international-authors-table select',
            function (e) {
                const row = e.target.closest('tr');
                const tableId = row.closest('table').id;
                computeRowScore(row, tableId);
                recalcAll();
                markFormAsDirty();
            }
        );

        // === SINGLE-FILE UPLOAD LOGIC ===
        $(document).on('click', '.upload-evidence-btn-a', function () {
            var button = $(this);
            var recordId = button.data('record-id');
            var subcriterion = button.data('subcriterion'); // 'sole', 'co', 'lead', 'contrib', 'local', 'international'
            var filePath = button.data('file-path'); // existing file if any
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

            // Reset the file input
            $('#singleAFileInput').val('');
            $('#singleAFileName').text(filePath ? filePath.split('/').pop() : '');

            uploadSingleEvidenceModalA.show();
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
            // Validate file type, size, etc., if needed
            $.ajax({
                url: '../../includes/career_progress_tracking/research/upload_evidence_criterion_a.php',
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

                        // Determine the table selector based on subcriterion
                        var tableSelector = '';
                        switch (subcriterion) {
                            case 'sole':
                                tableSelector = '#sole-authorship-table';
                                break;
                            case 'co':
                                tableSelector = '#co-authorship-table';
                                break;
                            case 'lead':
                                tableSelector = '#lead-researcher-table';
                                break;
                            case 'contrib':
                                tableSelector = '#contributor-table';
                                break;
                            case 'local':
                                tableSelector = '#local-authors-table';
                                break;
                            case 'international':
                                tableSelector = '#international-authors-table';
                                break;
                            default:
                                tableSelector = '';
                        }

                        if (tableSelector) {
                            var row = $(tableSelector).find(`tr[data-${subcriterion}-id="${recordId}"]`);
                            row.find('input[name*="[evidence_file]"]').val(filePath);
                            row.find('.upload-evidence-btn-a').data('file-path', filePath).text('Change Evidence');
                        }

                        uploadSingleEvidenceModalA.hide();
                        markFormAsDirty();
                        showMessage('File uploaded successfully!');

                        // Optionally, re-fetch data if needed
                        // CriterionA.fetchCriterionA($('#request_id').val());
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
        $('#deleteFileBtnA').on('click', function () {
            var subcriterion = $('#a_modal_subcriterion').val();
            var recordId = $('#a_modal_record_id').val();
            var requestId = $('#a_modal_request_id').val();

            if (!confirm('Are you sure you want to delete this evidence file?')) {
                return;
            }
            $.ajax({
                url: '../../includes/career_progress_tracking/research/delete_evidence_criterion_a.php',
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
                        switch (subcriterion) {
                            case 'sole':
                                tableSelector = '#sole-authorship-table';
                                break;
                            case 'co':
                                tableSelector = '#co-authorship-table';
                                break;
                            case 'lead':
                                tableSelector = '#lead-researcher-table';
                                break;
                            case 'contrib':
                                tableSelector = '#contributor-table';
                                break;
                            case 'local':
                                tableSelector = '#local-authors-table';
                                break;
                            case 'international':
                                tableSelector = '#international-authors-table';
                                break;
                            default:
                                tableSelector = '';
                        }

                        if (tableSelector) {
                            var row = $(tableSelector).find(`tr[data-${subcriterion}-id="${recordId}"]`);
                            row.find('input[name*="[evidence_file]"]').val('');
                            row.find('.upload-evidence-btn-a').data('file-path', '').text('Upload Evidence');
                        }

                        showMessage('Evidence file deleted successfully.');
                        uploadSingleEvidenceModalA.hide();
                        markFormAsDirty();

                        // Optionally, re-fetch data if needed
                        // CriterionA.fetchCriterionA(requestId);
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
                if (rowToDelete.hasAttribute('data-sole-id')) {
                    subcriterionToDelete = 'sole';
                } else if (rowToDelete.hasAttribute('data-co-id')) {
                    subcriterionToDelete = 'co';
                } else if (rowToDelete.hasAttribute('data-lead-id')) {
                    subcriterionToDelete = 'lead';
                } else if (rowToDelete.hasAttribute('data-contrib-id')) {
                    subcriterionToDelete = 'contrib';
                } else if (rowToDelete.hasAttribute('data-local-id')) {
                    subcriterionToDelete = 'local';
                } else if (rowToDelete.hasAttribute('data-international-id')) {
                    subcriterionToDelete = 'international';
                } else {
                    subcriterionToDelete = null;
                }

                recordIdToDelete = rowToDelete.getAttribute(`data-${subcriterionToDelete}-id`) || '0';
                deleteRowModalA.show();
            }
        });

        document.getElementById('confirm-delete-row-a').addEventListener('click', function () {
            if (rowToDelete) {
                // Hide the delete confirmation modal *before* any further actions
                deleteRowModalA.hide();

                if (recordIdToDelete !== '0' && subcriterionToDelete) {
                    deletedRecords[subcriterionToDelete].push(recordIdToDelete);
                }

                rowToDelete.remove();
                rowToDelete = null;
                recordIdToDelete = null;
                subcriterionToDelete = null;

                markFormAsDirty();
                recalcAll();
            }
        });

        // === VIEW REMARKS HANDLER ===
        $(document).on('click', '.view-remarks', function () {
            var row = $(this).closest('tr');
            var recordId = '';
            var subcriterion = '';

            if (row.attr('data-sole-id')) {
                recordId = row.attr('data-sole-id');
                subcriterion = 'sole';
            } else if (row.attr('data-co-id')) {
                recordId = row.attr('data-co-id');
                subcriterion = 'co';
            } else if (row.attr('data-lead-id')) {
                recordId = row.attr('data-lead-id');
                subcriterion = 'lead';
            } else if (row.attr('data-contrib-id')) {
                recordId = row.attr('data-contrib-id');
                subcriterion = 'contrib';
            } else if (row.attr('data-local-id')) {
                recordId = row.attr('data-local-id');
                subcriterion = 'local';
            } else if (row.attr('data-international-id')) {
                recordId = row.attr('data-international-id');
                subcriterion = 'international';
            }

            if (recordId && subcriterion) {
                // Fetch remarks via AJAX
                $.ajax({
                    url: '../../includes/career_progress_tracking/research/fetch_remarks.php',
                    type: 'POST',
                    data: {
                        request_id: $('#request_id').val(),
                        subcriterion: subcriterion,
                        record_id: recordId
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            $('#remarksModalBody').text(response.remarks || 'No remarks available.');
                            var remarksModal = new bootstrap.Modal(document.getElementById('remarksModal'));
                            remarksModal.show();
                        } else {
                            showMessage('Failed to fetch remarks: ' + response.error);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        showMessage('An error occurred while fetching remarks.');
                    }
                });
            } else {
                showMessage('Unable to determine the sub-criterion and record ID for remarks.');
            }
        });

        // === ADD ROW LOGIC FOR EACH SUB-CRITERION ===
        // Sole Authorship
        $('.add-sole-authorship-row').on('click', function () {
            var tableId = $(this).data('table-id'); // #sole-authorship-table
            var tableBody = document.querySelector(`#${tableId} tbody`);
            var newRow = document.createElement('tr');
            var rowCount = tableBody.querySelectorAll('tr').length + 1;
            newRow.setAttribute('data-sole-id', '0');

            newRow.innerHTML = `
                <td>${rowCount}</td>
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[new_${Date.now()}][title]" placeholder="Title of Research Output" required></td>
                <td>
                    <select class="form-select" name="kra2_a_sole_authorship[new_${Date.now()}][type]" required>
                        <option value="">SELECT OPTION</option>
                        <option value="Book">Book</option>
                        <option value="Journal Article">Journal Article</option>
                        <option value="Book Chapter">Book Chapter</option>
                        <option value="Monograph">Monograph</option>
                        <option value="Other Peer-Reviewed Output">Other Peer-Reviewed Output</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[new_${Date.now()}][journal_publisher]" placeholder="Name of Journal / Publisher" required></td>
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[new_${Date.now()}][reviewer]" placeholder="Reviewer or Its Equivalent" required></td>
                <td>
                    <select class="form-select" name="kra2_a_sole_authorship[new_${Date.now()}][international]">
                        <option value="">SELECT OPTION</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </td>
                <td><input type="date" class="form-control" name="kra2_a_sole_authorship[new_${Date.now()}][date_published]" required></td>
                <td><input type="text" class="form-control score-input" name="kra2_a_sole_authorship[new_${Date.now()}][score]" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
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
            var tableId = $(this).data('table-id'); // #co-authorship-table
            var tableBody = document.querySelector(`#${tableId} tbody`);
            var newRow = document.createElement('tr');
            var rowCount = tableBody.querySelectorAll('tr').length + 1;
            newRow.setAttribute('data-co-id', '0');

            newRow.innerHTML = `
                <td>${rowCount}</td>
                <td><input type="text" class="form-control" name="kra2_a_co_authorship[new_${Date.now()}][title]" placeholder="Title of Research Output" required></td>
                <td>
                    <select class="form-select" name="kra2_a_co_authorship[new_${Date.now()}][type]" required>
                        <option value="">SELECT OPTION</option>
                        <option value="Book">Book</option>
                        <option value="Journal Article">Journal Article</option>
                        <option value="Book Chapter">Book Chapter</option>
                        <option value="Monograph">Monograph</option>
                        <option value="Other Peer-Reviewed Output">Other Peer-Reviewed Output</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra2_a_co_authorship[new_${Date.now()}][journal_publisher]" placeholder="Name of Journal / Publisher" required></td>
                <td><input type="text" class="form-control" name="kra2_a_co_authorship[new_${Date.now()}][reviewer]" placeholder="Reviewer or Its Equivalent" required></td>
                <td>
                    <select class="form-select" name="kra2_a_co_authorship[new_${Date.now()}][international]">
                        <option value="">SELECT OPTION</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </td>
                <td><input type="date" class="form-control" name="kra2_a_co_authorship[new_${Date.now()}][date_published]" required></td>
                <td><input type="number" class="form-control" name="kra2_a_co_authorship[new_${Date.now()}][contribution_percentage]" placeholder="0" min="0" max="100" required></td>
                <td><input type="text" class="form-control score-input" name="kra2_a_co_authorship[new_${Date.now()}][score]" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
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
            var tableId = $(this).data('table-id'); // #lead-researcher-table
            var tableBody = document.querySelector(`#${tableId} tbody`);
            var newRow = document.createElement('tr');
            var rowCount = tableBody.querySelectorAll('tr').length + 1;
            newRow.setAttribute('data-lead-id', '0');

            newRow.innerHTML = `
                <td>${rowCount}</td>
                <td><input type="text" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][title]" placeholder="Title of Research" required></td>
                <td><input type="date" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][date_completed]" required></td>
                <td><input type="text" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][project_name]" placeholder="Name of Project, Policy or Product" required></td>
                <td><input type="text" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][funding_source]" placeholder="Funding Source" required></td>
                <td><input type="date" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][date_implemented]" required></td>
                <td><input type="text" class="form-control score-input" name="kra2_a_lead_researcher[new_${Date.now()}][score]" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
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
            var tableId = $(this).data('table-id'); // #contributor-table
            var tableBody = document.querySelector(`#${tableId} tbody`);
            var newRow = document.createElement('tr');
            var rowCount = tableBody.querySelectorAll('tr').length + 1;
            newRow.setAttribute('data-contrib-id', '0');

            newRow.innerHTML = `
                <td>${rowCount}</td>
                <td><input type="text" class="form-control" name="kra2_a_contributor[new_${Date.now()}][title]" placeholder="Title of Research" required></td>
                <td><input type="date" class="form-control" name="kra2_a_contributor[new_${Date.now()}][date_completed]" required></td>
                <td><input type="text" class="form-control" name="kra2_a_contributor[new_${Date.now()}][project_name]" placeholder="Name of Project, Policy or Product" required></td>
                <td><input type="text" class="form-control" name="kra2_a_contributor[new_${Date.now()}][funding_source]" placeholder="Funding Source" required></td>
                <td><input type="date" class="form-control" name="kra2_a_contributor[new_${Date.now()}][date_implemented]" required></td>
                <td><input type="number" class="form-control" name="kra2_a_contributor[new_${Date.now()}][contribution_percentage]" placeholder="0" min="0" max="100" required></td>
                <td><input type="text" class="form-control score-input" name="kra2_a_contributor[new_${Date.now()}][score]" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
                        data-subcriterion="contrib" data-record-id="0" data-file-path="">
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
            var tableId = $(this).data('table-id'); // #local-authors-table
            var tableBody = document.querySelector(`#${tableId} tbody`);
            var newRow = document.createElement('tr');
            var rowCount = tableBody.querySelectorAll('tr').length + 1;
            newRow.setAttribute('data-local-id', '0');

            newRow.innerHTML = `
                <td>${rowCount}</td>
                <td><input type="text" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][title]" placeholder="Title of Journal Article" required></td>
                <td><input type="date" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][date_published]" required></td>
                <td><input type="text" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][journal_name]" placeholder="Name of Journal" required></td>
                <td><input type="number" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][citation_count]" placeholder="No. of Citation" min="0" required></td>
                <td><input type="text" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][citation_index]" placeholder="Citation Index" required></td>
                <td><input type="date" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][citation_year]" required></td>
                <td><input type="text" class="form-control score-input" name="kra2_a_local_authors[new_${Date.now()}][score]" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
                        data-subcriterion="local" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra2_a_local_authors[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
            `;
            tableBody.appendChild(row);
            markFormAsDirty();
        });

        // International Authors
        $('.add-international-authors-row').on('click', function () {
            var tableId = $(this).data('table-id'); // #international-authors-table
            var tableBody = document.querySelector(`#${tableId} tbody`);
            var newRow = document.createElement('tr');
            var rowCount = tableBody.querySelectorAll('tr').length + 1;
            newRow.setAttribute('data-international-id', '0');

            newRow.innerHTML = `
                <td>${rowCount}</td>
                <td><input type="text" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][title]" placeholder="Title of Journal Article" required></td>
                <td><input type="date" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][date_published]" required></td>
                <td><input type="text" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][journal_name]" placeholder="Name of Journal" required></td>
                <td><input type="number" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][citation_count]" placeholder="No. of Citation" min="0" required></td>
                <td><input type="text" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][citation_index]" placeholder="Citation Index" required></td>
                <td><input type="date" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][citation_year]" required></td>
                <td><input type="text" class="form-control score-input" name="kra2_a_international_authors[new_${Date.now()}][score]" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn-a" 
                        data-subcriterion="international" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra2_a_international_authors[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
            `;
            tableBody.appendChild(row);
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
                    title: inputs.filter('[name*="[title]"]').val().trim(),
                    type: inputs.filter('[name*="[type]"]').val(),
                    journal_publisher: inputs.filter('[name*="[journal_publisher]"]').val().trim(),
                    reviewer: inputs.filter('[name*="[reviewer]"]').val().trim(),
                    international: inputs.filter('[name*="[international]"]').val(),
                    date_published: inputs.filter('[name*="[date_published]"]').val(),
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
                    title: inputs.filter('[name*="[title]"]').val().trim(),
                    type: inputs.filter('[name*="[type]"]').val(),
                    journal_publisher: inputs.filter('[name*="[journal_publisher]"]').val().trim(),
                    reviewer: inputs.filter('[name*="[reviewer]"]').val().trim(),
                    international: inputs.filter('[name*="[international]"]').val(),
                    date_published: inputs.filter('[name*="[date_published]"]').val(),
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
                    title: inputs.filter('[name*="[title]"]').val().trim(),
                    date_completed: inputs.filter('[name*="[date_completed]"]').val(),
                    project_name: inputs.filter('[name*="[project_name]"]').val().trim(),
                    funding_source: inputs.filter('[name*="[funding_source]"]').val().trim(),
                    date_implemented: inputs.filter('[name*="[date_implemented]"]').val(),
                    score: parseFloat(inputs.filter('[name*="[score]"]').val()) || 0,
                    evidence_file: inputs.filter('[name*="[evidence_file]"]').val() || ''
                };
                leadRows.push(rowData);
            });

            // Contributor
            var contribRows = [];
            $('#contributor-table tbody tr').each(function () {
                var row = $(this);
                var recordId = row.attr('data-contrib-id') || '0';

                var inputs = row.find('input, select');
                var rowData = {
                    contributor_id: recordId,
                    title: inputs.filter('[name*="[title]"]').val().trim(),
                    date_completed: inputs.filter('[name*="[date_completed]"]').val(),
                    project_name: inputs.filter('[name*="[project_name]"]').val().trim(),
                    funding_source: inputs.filter('[name*="[funding_source]"]').val().trim(),
                    date_implemented: inputs.filter('[name*="[date_implemented]"]').val(),
                    contribution_percentage: parseFloat(inputs.filter('[name*="[contribution_percentage]"]').val()) || 0,
                    score: parseFloat(inputs.filter('[name*="[score]"]').val()) || 0,
                    evidence_file: inputs.filter('[name*="[evidence_file]"]').val() || ''
                };
                contribRows.push(rowData);
            });

            // Local Authors
            var localRows = [];
            $('#local-authors-table tbody tr').each(function () {
                var row = $(this);
                var recordId = row.attr('data-local-id') || '0';

                var inputs = row.find('input, select');
                var rowData = {
                    local_author_id: recordId,
                    title: inputs.filter('[name*="[title]"]').val().trim(),
                    date_published: inputs.filter('[name*="[date_published]"]').val(),
                    journal_name: inputs.filter('[name*="[journal_name]"]').val().trim(),
                    citation_count: parseInt(inputs.filter('[name*="[citation_count]"]').val(), 10) || 0,
                    citation_index: inputs.filter('[name*="[citation_index]"]').val().trim(),
                    citation_year: inputs.filter('[name*="[citation_year]"]').val(),
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
                    title: inputs.filter('[name*="[title]"]').val().trim(),
                    date_published: inputs.filter('[name*="[date_published]"]').val(),
                    journal_name: inputs.filter('[name*="[journal_name]"]').val().trim(),
                    citation_count: parseInt(inputs.filter('[name*="[citation_count]"]').val(), 10) || 0,
                    citation_index: inputs.filter('[name*="[citation_index]"]').val().trim(),
                    citation_year: inputs.filter('[name*="[citation_year]"]').val(),
                    score: parseFloat(inputs.filter('[name*="[score]"]').val()) || 0,
                    evidence_file: inputs.filter('[name*="[evidence_file]"]').val() || ''
                };
                internationalRows.push(rowData);
            });

            // Totals (Metadata)
            var sole_total = parseFloat($('#kra2_a_sole_authorship_total').val()) || 0;
            var co_total = parseFloat($('#kra2_a_co_authorship_total').val()) || 0;
            var lead_total = parseFloat($('#kra2_a_lead_researcher_total').val()) || 0;
            var contrib_total = parseFloat($('#kra2_a_contributor_total').val()) || 0;
            var local_total = parseFloat($('#kra2_a_local_authors_total').val()) || 0;
            var international_total = parseFloat($('#kra2_a_international_authors_total').val()) || 0;

            return {
                request_id: requestId,
                sole_authorship: soleRows,
                co_authorship: coRows,
                lead_researcher: leadRows,
                contributor: contribRows,
                local_authors: localRows,
                international_authors: internationalRows,
                metadata: {
                    sole_authorship_total: sole_total,
                    co_authorship_total: co_total,
                    lead_researcher_total: lead_total,
                    contributor_total: contrib_total,
                    local_authors_total: local_total,
                    international_authors_total: international_total
                },
                deleted_records: deletedRecords
            };
        }

        function saveCriterionA() {
            // if (!form.checkValidity()) {
            //     form.classList.add('was-validated');
            //     showMessage('Please fill in all required fields.');
            //     return;
            // }
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
                        deletedRecords.contrib = [];
                        deletedRecords.local = [];
                        deletedRecords.international = [];
                        // markFormAsClean();
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

        // === UNSAVED CHANGES PROMPT ===
        // Implement if needed, similar to Criterion B

        // Mark form as clean on initial load
        // markFormAsClean();
    };

    // === INITIATE CRITERION A ON DOM LOAD ===
    document.addEventListener('DOMContentLoaded', function () {
        CriterionA.init();
    });

    // === EXPOSE THE NAMESPACE ===
    window.CriterionA = CriterionA;

}(window, document, jQuery));
