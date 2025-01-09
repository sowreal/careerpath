// php/includes/career_progress_tracking/research/js/kra2_criterion_a.js
(function (window, document, $) {
    'use strict';

    // NAMESPACE
    var KRA2CriterionA = {};

    // === HELPER FUNCTIONS ===
    function escapeHTML(str) {
        if (!str) return '';
        return str.replace(/&/g, "&amp;")
                  .replace(/</g, "&lt;")
                  .replace(/>/g, "&gt;")
                  .replace(/"/g, "&quot;")
                  .replace(/'/g, "&#039;");
    }

    // --- ADD DEFAULT ROWS ---
    function addDefaultSoleAuthorshipRows(tableBody) {
        const requestId = document.getElementById('request_id')?.value.trim() || '0';
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
                        <option value="Monograph">Monograph Outputs</option>
                        <option value="Other Peer-Reviewed Output">Other Peer-Reviewed Output</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[new_${Date.now()}][journal_publisher]" placeholder="Journal / Publisher"></td>
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
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion="sole_authorship" data-record-id="0" data-file-path="">
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
                        <option value="Monograph">Monograph Outputs</option>
                        <option value="Other Peer-Reviewed Output">Other Peer-Reviewed Output</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="kra2_a_co_authorship[new_${Date.now()}][journal_publisher]" placeholder="Journal / Publisher"></td>
                <td><input type="text" class="form-control" name="kra2_a_co_authorship[new_${Date.now()}][reviewer]" placeholder="Reviewer"></td>
                <td>
                    <select class="form-select" name="kra2_a_co_authorship[new_${Date.now()}][international]">
                        <option value="">SELECT OPTION</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </td>
                <td><input type="date" class="form-control" name="kra2_a_co_authorship[new_${Date.now()}][date_published]"></td>
                <td><input type="number" class="form-control" name="kra2_a_co_authorship[new_${Date.now()}][contribution_percentage]" placeholder="0" min="0" max="100"></td>
                <td><input type="number" class="form-control score-input" name="kra2_a_co_authorship[new_${Date.now()}][score]" placeholder="0" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion="co_authorship" data-record-id="0" data-file-path="">
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

    function addDefaultLeadResearcherRows(tableBody) {
        const requestId = document.getElementById('request_id')?.value.trim() || '0';
        for (let i = 1; i <= 3; i++) {
            const row = document.createElement('tr');
            row.setAttribute('data-lead-id', '0');
            row.innerHTML = `
                <td>${i}</td>
                <td><input type="text" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][title]" placeholder="Title of Research"></td>
                <td><input type="date" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][date_completed]"></td>
                <td><input type="text" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][project_name]" placeholder="Project, Policy, or Product"></td>
                <td><input type="text" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][funding_source]" placeholder="Funding Source"></td>
                <td><input type="date" class="form-control" name="kra2_a_lead_researcher[new_${Date.now()}][date_implemented]"></td>
                <td><input type="number" class="form-control score-input" name="kra2_a_lead_researcher[new_${Date.now()}][score]" placeholder="0" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion="lead_researcher" data-record-id="0" data-file-path="">
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

    function addDefaultContributorRows(tableBody) {
        const requestId = document.getElementById('request_id')?.value.trim() || '0';
        for (let i = 1; i <= 3; i++) {
            const row = document.createElement('tr');
            row.setAttribute('data-contributor-id', '0');
            row.innerHTML = `
                <td>${i}</td>
                <td><input type="text" class="form-control" name="kra2_a_contributor[new_${Date.now()}][title]" placeholder="Title of Research"></td>
                <td><input type="date" class="form-control" name="kra2_a_contributor[new_${Date.now()}][date_completed]"></td>
                <td><input type="text" class="form-control" name="kra2_a_contributor[new_${Date.now()}][project_name]" placeholder="Project, Policy, or Product"></td>
                <td><input type="text" class="form-control" name="kra2_a_contributor[new_${Date.now()}][funding_source]" placeholder="Funding Source"></td>
                <td><input type="date" class="form-control" name="kra2_a_contributor[new_${Date.now()}][date_implemented]"></td>
                <td><input type="number" class="form-control" name="kra2_a_contributor[new_${Date.now()}][contribution_percentage]" placeholder="0" min="0" max="100"></td>
                <td><input type="number" class="form-control score-input" name="kra2_a_contributor[new_${Date.now()}][score]" placeholder="0" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion="contributor" data-record-id="0" data-file-path="">
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
                <td><input type="date" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][citation_year]"></td>
                <td><input type="number" class="form-control score-input" name="kra2_a_local_authors[new_${Date.now()}][score]" placeholder="0" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion="local_authors" data-record-id="0" data-file-path="">
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
                <td><input type="date" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][citation_year]"></td>
                <td><input type="number" class="form-control score-input" name="kra2_a_international_authors[new_${Date.now()}][score]" placeholder="0" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion="international_authors" data-record-id="0" data-file-path="">
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

    // --- SHOW MODAL MESSAGE ---
    function showMessage(message) {
        $('#messageModalBody').text(message);
        var messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
        messageModal.show();
    }
    window.showMessage = showMessage;

    // --- POPULATE TABLES ---
    // B.1 Sole Authorship
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
                <td><input type="text" class="form-control" name="kra2_a_sole_authorship[${index}][title]" value="${escapeHTML(item.title)}"></td>
                <td>
                    <select class="form-select" name="kra2_a_sole_authorship[${index}][type]">
                        <option value="">SELECT OPTION</option>
                        <option value="scholarly_paper" ${item.type === 'scholarly_paper' ? 'selected' : ''}>Scholarly Paper</option>
                        <option value="educational_article" ${item.type === 'educational_article' ? 'selected' : ''}>Educational Article</option>
                        <option value="technical_article" ${item.type === 'technical_article' ? 'selected' : ''}>Technical Article</option>
                        <option value="other_output" ${item.type === 'other_output' ? 'selected' : ''}>Other Outputs</option>
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
                        data-subcriterion="sole_authorship" 
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

    // B.2 Co-authorship
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
                <td><input type="text" class="form-control" name="kra2_a_co_authorship[${index}][title]" value="${escapeHTML(item.title)}"></td>
                <td>
                    <select class="form-select" name="kra2_a_co_authorship[${index}][type]">
                        <option value="">SELECT OPTION</option>
                        <option value="scholarly_paper" ${item.type === 'scholarly_paper' ? 'selected' : ''}>Scholarly Paper</option>
                        <option value="educational_article" ${item.type === 'educational_article' ? 'selected' : ''}>Educational Article</option>
                        <option value="technical_article" ${item.type === 'technical_article' ? 'selected' : ''}>Technical Article</option>
                        <option value="other_output" ${item.type === 'other_output' ? 'selected' : ''}>Other Outputs</option>
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
                        data-subcriterion="co_authorship" 
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

    // B.3 Lead Researcher
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
                <td><input type="text" class="form-control" name="kra2_a_lead_researcher[${index}][title]" value="${escapeHTML(item.title)}"></td>
                <td><input type="date" class="form-control" name="kra2_a_lead_researcher[${index}][date_completed]" value="${item.date_completed || ''}"></td>
                <td><input type="text" class="form-control" name="kra2_a_lead_researcher[${index}][project_name]" value="${escapeHTML(item.project_name || '')}"></td>
                <td><input type="text" class="form-control" name="kra2_a_lead_researcher[${index}][funding_source]" value="${escapeHTML(item.funding_source || '')}"></td>
                <td><input type="date" class="form-control" name="kra2_a_lead_researcher[${index}][date_implemented]" value="${item.date_implemented || ''}"></td>
                <td><input type="number" class="form-control score-input" name="kra2_a_lead_researcher[${index}][score]" value="${item.score || ''}" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                        data-subcriterion="lead_researcher" 
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

    // B.4 Contributor
    function populateContributor(contributorData) {
        var tableBody = document.querySelector('#contributor-table tbody');
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

    // B.5 Local Authors
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
                <td><input type="text" class="form-control" name="kra2_a_local_authors[${index}][title]" value="${escapeHTML(item.title)}"></td>
                <td><input type="date" class="form-control" name="kra2_a_local_authors[${index}][date_published]" value="${item.date_published || ''}"></td>
                <td><input type="text" class="form-control" name="kra2_a_local_authors[${index}][journal_name]" value="${escapeHTML(item.journal_name || '')}"></td>
                <td><input type="number" class="form-control" name="kra2_a_local_authors[${index}][citation_count]" value="${item.citation_count || ''}"></td>
                <td><input type="text" class="form-control" name="kra2_a_local_authors[${index}][citation_index]" value="${escapeHTML(item.citation_index || '')}"></td>
                <td><input type="date" class="form-control" name="kra2_a_local_authors[${index}][citation_year]" value="${item.citation_year || ''}"></td>
                <td><input type="number" class="form-control score-input" name="kra2_a_local_authors[${index}][score]" value="${item.score || ''}" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                        data-subcriterion="local_authors" 
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

    // B.6 International Authors
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
                <td><input type="text" class="form-control" name="kra2_a_international_authors[${index}][title]" value="${escapeHTML(item.title)}"></td>
                <td><input type="date" class="form-control" name="kra2_a_international_authors[${index}][date_published]" value="${item.date_published || ''}"></td>
                <td><input type="text" class="form-control" name="kra2_a_international_authors[${index}][journal_name]" value="${escapeHTML(item.journal_name || '')}"></td>
                <td><input type="number" class="form-control" name="kra2_a_international_authors[${index}][citation_count]" value="${item.citation_count || ''}"></td>
                <td><input type="text" class="form-control" name="kra2_a_international_authors[${index}][citation_index]" value="${escapeHTML(item.citation_index || '')}"></td>
                <td><input type="date" class="form-control" name="kra2_a_international_authors[${index}][citation_year]" value="${item.citation_year || ''}"></td>
                <td><input type="number" class="form-control score-input" name="kra2_a_international_authors[${index}][score]" value="${item.score || ''}" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                        data-subcriterion="international_authors" 
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

    // --- POPULATE TOTALS FROM METADATA ---
    function populateMetadata(metadata) {
        if (!metadata) {
            document.getElementById('kra2_a_sole_authorship_total').value = '';
            document.getElementById('kra2_a_co_authorship_total').value = '';
            document.getElementById('kra2_a_lead_researcher_total').value = '';
            document.getElementById('kra2_a_contributor_total').value = '';
            document.getElementById('kra2_a_local_authors_total').value = '';
            document.getElementById('kra2_a_international_authors_total').value = '';
            return;
        }
        document.getElementById('kra2_a_sole_authorship_total').value = metadata.sole_authorship_total || '';
        document.getElementById('kra2_a_co_authorship_total').value = metadata.co_authorship_total || '';
        document.getElementById('kra2_a_lead_researcher_total').value = metadata.lead_researcher_total || '';
        document.getElementById('kra2_a_contributor_total').value = metadata.contributor_total || '';
        document.getElementById('kra2_a_local_authors_total').value = metadata.local_authors_total || '';
        document.getElementById('kra2_a_international_authors_total').value = metadata.international_authors_total || '';
    }

    // === MAIN FETCH FUNCTION ===
    KRA2CriterionA.fetchCriterionA = function (requestId) {
        return fetch(`../../includes/career_progress_tracking/research/fetch_kra2_criterion_a.php?request_id=${requestId}`)
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(function (data) {
                if (data.success) {
                    // Populate each sub-criterion table (using the populate... functions)
                    populateSoleAuthorship(data.sole_authorship);
                    populateCoAuthorship(data.co_authorship);
                    populateLeadResearcher(data.lead_researcher);
                    populateContributor(data.contributor);
                    populateLocalAuthors(data.local_authors);
                    populateInternationalAuthors(data.international_authors);
                    populateMetadata(data.metadata);
                    return data; // You can return the data if needed by the caller
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

    // === Array to temporarily store selected files ===
    var selectedFiles = [];

    // === GATHER PAYLOAD FUNCTION ===
    function gatherPayload() {
        var requestId = parseInt(document.getElementById('request_id').value.trim(), 10) || 0;

        // --- Sole Authorship ---
        var soleRows = [];
        $('#sole-authorship-table tbody tr').each(function () {
            var row = $(this);
            var recordId = row.attr('data-sole-id') || '0';

            var inputs = row.find('input, select');
            var rowData = {
                sole_authorship_id: recordId,
                title: inputs.filter('[name*="[title]"]').val(),
                type: inputs.filter('[name*="[type]"]').val(),
                journal_publisher: inputs.filter('[name*="[journal_publisher]"]').val(),
                reviewer: inputs.filter('[name*="[reviewer]"]').val(),
                international: inputs.filter('[name*="[international]"]').val(),
                date_published: inputs.filter('[name*="[date_published]"]').val(),
                score: parseFloat(inputs.filter('[name*="[score]"]').val()) || 0,
                evidence_file: inputs.filter('[name*="[evidence_file]"]').val() // This will be the index in selectedFiles
            };
            soleRows.push(rowData);
        });

        // --- Co Authorship ---
        var coRows = [];
        $('#co-authorship-table tbody tr').each(function () {
            var row = $(this);
            var recordId = row.attr('data-co-id') || '0';

            var inputs = row.find('input, select');
            var rowData = {
                co_authorship_id: recordId,
                title: inputs.filter('[name*="[title]"]').val(),
                type: inputs.filter('[name*="[type]"]').val(),
                journal_publisher: inputs.filter('[name*="[journal_publisher]"]').val(),
                reviewer: inputs.filter('[name*="[reviewer]"]').val(),
                international: inputs.filter('[name*="[international]"]').val(),
                date_published: inputs.filter('[name*="[date_published]"]').val(),
                contribution_percentage: parseFloat(inputs.filter('[name*="[contribution_percentage]"]').val()),
                score: parseFloat(inputs.filter('[name*="[score]"]').val()) || 0,
                evidence_file: inputs.filter('[name*="[evidence_file]"]').val() // Index in selectedFiles
            };
            coRows.push(rowData);
        });

        // --- Lead Researcher ---
        var leadRows = [];
        $('#lead-researcher-table tbody tr').each(function () {
            var row = $(this);
            var recordId = row.attr('data-lead-id') || '0';

            var inputs = row.find('input, select');
            var rowData = {
                lead_researcher_id: recordId,
                title: inputs.filter('[name*="[title]"]').val(),
                date_completed: inputs.filter('[name*="[date_completed]"]').val(),
                project_name: inputs.filter('[name*="[project_name]"]').val(),
                funding_source: inputs.filter('[name*="[funding_source]"]').val(),
                date_implemented: inputs.filter('[name*="[date_implemented]"]').val(),
                score: parseFloat(inputs.filter('[name*="[score]"]').val()) || 0,
                evidence_file: inputs.filter('[name*="[evidence_file]"]').val() // Index in selectedFiles
            };
            leadRows.push(rowData);
        });

        // --- Contributor ---
        var contributorRows = [];
        $('#contributor-table tbody tr').each(function () {
            var row = $(this);
            var recordId = row.attr('data-contributor-id') || '0';

            var inputs = row.find('input, select');
            var rowData = {
                contributor_id: recordId,
                title: inputs.filter('[name*="[title]"]').val(),
                date_completed: inputs.filter('[name*="[date_completed]"]').val(),
                project_name: inputs.filter('[name*="[project_name]"]').val(),
                funding_source: inputs.filter('[name*="[funding_source]"]').val(),
                date_implemented: inputs.filter('[name*="[date_implemented]"]').val(),
                contribution_percentage: parseFloat(inputs.filter('[name*="[contribution_percentage]"]').val()),
                score: parseFloat(inputs.filter('[name*="[score]"]').val()) || 0,
                evidence_file: inputs.filter('[name*="[evidence_file]"]').val() // Index in selectedFiles
            };
            contributorRows.push(rowData);
        });

        // --- Local Authors ---
        var localRows = [];
        $('#local-authors-table tbody tr').each(function () {
            var row = $(this);
            var recordId = row.attr('data-local-id') || '0';

            var inputs = row.find('input, select');
            var rowData = {
                local_author_id: recordId,
                title: inputs.filter('[name*="[title]"]').val(),
                date_published: inputs.filter('[name*="[date_published]"]').val(),
                journal_name: inputs.filter('[name*="[journal_name]"]').val(),
                citation_count: parseInt(inputs.filter('[name*="[citation_count]"]').val()),
                citation_index: inputs.filter('[name*="[citation_index]"]').val(),
                citation_year: inputs.filter('[name*="[citation_year]"]').val(),
                score: parseFloat(inputs.filter('[name*="[score]"]').val()) || 0,
                evidence_file: inputs.filter('[name*="[evidence_file]"]').val() // Index in selectedFiles
            };
            localRows.push(rowData);
        });

        // --- International Authors ---
        var internationalRows = [];
        $('#international-authors-table tbody tr').each(function () {
            var row = $(this);
            var recordId = row.attr('data-international-id') || '0';

            var inputs = row.find('input, select');
            var rowData = {
                international_author_id: recordId,
                title: inputs.filter('[name*="[title]"]').val(),
                date_published: inputs.filter('[name*="[date_published]"]').val(),
                journal_name: inputs.filter('[name*="[journal_name]"]').val(),
                citation_count: parseInt(inputs.filter('[name*="[citation_count]"]').val()),
                citation_index: inputs.filter('[name*="[citation_index]"]').val(),
                citation_year: inputs.filter('[name*="[citation_year]"]').val(),
                score: parseFloat(inputs.filter('[name*="[score]"]').val()) || 0,
                evidence_file: inputs.filter('[name*="[evidence_file]"]').val() // Index in selectedFiles
            };
            internationalRows.push(rowData);
        });

        // --- Totals (Metadata) ---
        var sole_total = parseFloat($('#kra2_a_sole_authorship_total').val()) || 0;
        var co_total = parseFloat($('#kra2_a_co_authorship_total').val()) || 0;
        var lead_total = parseFloat($('#kra2_a_lead_researcher_total').val()) || 0;
        var contributor_total = parseFloat($('#kra2_a_contributor_total').val()) || 0;
        var local_total = parseFloat($('#kra2_a_local_authors_total').val()) || 0;
        var international_total = parseFloat($('#kra2_a_international_authors_total').val()) || 0;

        // --- Files to Upload ---
        var filesToUpload = [];
        for (var i = 0; i < selectedFiles.length; i++) {
            if (selectedFiles[i]) {
                filesToUpload.push(selectedFiles[i]);
            }
        }

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
            // deleted_records: deletedRecords,
            filesToUpload: filesToUpload
        };
    }
    // === END OF GATHER PAYLOAD FUNCTION ===

    // === INIT FUNCTION ===
    KRA2CriterionA.init = function () {
        var form = document.getElementById('criterion-a-form'); // make sure this ID matches your form
        var saveBtn = document.getElementById('save-criterion-a');
        var deleteRowModal = new bootstrap.Modal(document.getElementById('deleteRowModal'));
        var uploadSingleEvidenceModal = new bootstrap.Modal(document.getElementById('uploadSingleEvidenceModalA'));

        // Track deleted records
        var deletedRecords = {
            sole_authorship: [],
            co_authorship: [],
            lead_researcher: [],
            contributor: [],
            local_authors: [],
            international_authors: []
        };

        // Dirty flag for form changes
        var isFormDirty = false;
        function markFormAsDirty() {
            isFormDirty = true;
            saveBtn.classList.add('btn-warning');
        }
        function markFormAsClean() {
            isFormDirty = false;
            saveBtn.classList.remove('btn-warning');
        }

        // === CALCULATION HELPER FUNCTIONS ===
        // (These functions remain unchanged)
        // 1) Row-by-Row Calculations
        function getSoleAuthorshipScore(type, international) {
            if (type === 'Book' || type === 'Monograph') {
                return 100;
            } else if (type === 'Journal Article' && international === 'Yes') {
                return 50;
            } else if (type === 'Journal Article' && international === 'No') {
                return 0; // No points for non-international Journal Article
            } else if (type === 'Book Chapter') {
                return 35;
            } else if (type === 'Other Peer-Reviewed Output') {
                return 10;
            } else {
                return 0; // Default: no points
            }
        }

        function getCoAuthorshipScore(type, international, contribution) {
            // Same point system as Sole Authorship, but multiplied by contribution
            const baseScore = getSoleAuthorshipScore(type, international);
            return baseScore * (contribution / 100);
        }

        function getLeadResearcherScore() {
            return 35; // Fixed score
        }

        function getContributorScore(contribution) {
            return 35 * (contribution / 100); // Score is based on contribution
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
                const type = row.querySelector('select[name*="[type]"]')?.value;
                const international = row.querySelector('select[name*="[international]"]')?.value;
                computedScore = getSoleAuthorshipScore(type, international);

            } else if (tableId === 'co-authorship-table') {
                const type = row.querySelector('select[name*="[type]"]')?.value;
                const international = row.querySelector('select[name*="[international]"]')?.value;
                const contribution = parseFloat(row.querySelector('input[name*="[contribution_percentage]"]').value) || 0;
                computedScore = getCoAuthorshipScore(type, international, contribution);

            } else if (tableId === 'lead-researcher-table') {
                computedScore = getLeadResearcherScore();

            } else if (tableId === 'contributor-table') {
                const contribution = parseFloat(row.querySelector('input[name*="[contribution_percentage]"]').value) || 0;
                computedScore = getContributorScore(contribution);

            } else if (tableId === 'local-authors-table') {
                const citationCount = parseInt(row.querySelector('input[name*="[citation_count]"]').value) || 0;
                computedScore = getLocalAuthorsScore(citationCount);

            } else if (tableId === 'international-authors-table') {
                const citationCount = parseInt(row.querySelector('input[name*="[citation_count]"]').value) || 0;
                computedScore = getInternationalAuthorsScore(citationCount);
            }

            scoreInput.value = computedScore.toFixed(2);
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

        // 5) Hook Up Event Listeners for Score Calculation
        $(document).on('input change',
            '#sole-authorship-table select, #co-authorship-table select, ' +
            '#co-authorship-table input[name*="[contribution_percentage]"], ' +
            '#lead-researcher-table input, #contributor-table input, ' +
            '#local-authors-table input, #international-authors-table input',
            function (e) {
                const row = e.target.closest('tr');
                const tableId = row.closest('table').id;
                computeRowScore(row, tableId);
                recalcAll();
            }
        );

        // === FILE SELECTION LOGIC ===
        $(document).on('click', '.upload-evidence-btn', function () {
            var button = $(this);
            var recordId = button.data('record-id');
            var subcriterion = button.data('subcriterion');
            var filePath = button.data('file-path'); // Might be empty initially
            var requestId = $('#request_id').val();

            // Validation
            if (!requestId) {
                showMessage('No valid Request ID found. Please select an evaluation first.');
                return;
            }
            if (recordId === '0' || !recordId) {
                showMessage('Please save the row before uploading evidence (row must have a valid ID).');
                return;
            }

            // Set data in the modal's hidden inputs
            $('#a_modal_request_id').val(requestId);
            $('#a_modal_subcriterion').val(subcriterion);
            $('#a_modal_record_id').val(recordId);
            $('#a_existing_file_path').val(filePath || '');

            // Reset file input and display filename
            $('#singleAFileInput').val('');
            $('#singleAFileName').text(filePath ? filePath.split('/').pop() : '');

            uploadSingleEvidenceModal.show();
        });

        // Display filename when a file is selected
        $('#singleAFileInput').on('change', function () {
            $('#singleAFileName').text(this.files[0] ? this.files[0].name : '');
        });

        // Select File Button (in the modal)
        $('#a_uploadSingleEvidenceBtn').on('click', function () {
            var fileInput = $('#singleAFileInput')[0];
            if (!fileInput.files.length) {
                showMessage('Please select a file.');
                return;
            }

            var file = fileInput.files[0];
            var subcriterion = $('#a_modal_subcriterion').val();
            var recordId = $('#a_modal_record_id').val();

            // Store the selected file data temporarily using the index
            var fileIndex = selectedFiles.length;
            selectedFiles.push({
                file: file,
                subcriterion: subcriterion,
                record_id: recordId,
                fileIndex: fileIndex
            });

            // Find the correct row and update the hidden input with the file index
            var tableSelector = `#${subcriterion.replace(/_/g, '-')}-table`;
            var row = $(tableSelector).find(`tr[data-${subcriterion.split('_')[0]}-id="${recordId}"]`);
            row.find('input[name*="[evidence_file]"]').val(fileIndex); // Store the index

            // Update the button text
            row.find('.upload-evidence-btn').text('Change Evidence');

            uploadSingleEvidenceModal.hide();
        });
        // === END OF FILE SELECTION LOGIC ===

        // === DELETE FILE LOGIC (Placeholder) ===
        $(document).on('click', '.delete-evidence-btn', function () {
            // We will implement this later
        });

        // === DELETE ROW LOGIC ===
        var rowToDelete = null;
        var recordIdToDelete = null;
        var subcriterionToDelete = null;

        $(document).on('click', '.delete-row', function () {
            rowToDelete = $(this).closest('tr');
            subcriterionToDelete = rowToDelete.data('sole-id') !== undefined ? 'sole_authorship'
                : rowToDelete.data('co-id') !== undefined ? 'co_authorship'
                    : rowToDelete.data('lead-id') !== undefined ? 'lead_researcher'
                        : rowToDelete.data('contributor-id') !== undefined ? 'contributor'
                            : rowToDelete.data('local-id') !== undefined ? 'local_authors'
                                : rowToDelete.data('international-id') !== undefined ? 'international_authors'
                                    : null;

            recordIdToDelete = rowToDelete.data(`${subcriterionToDelete.split('_')[0]}-id`) || '0';
            deleteRowModal.show();
        });

        $('#confirm-delete-row').on('click', function () {
            if (rowToDelete) {
                deleteRowModal.hide();

                if (recordIdToDelete !== '0' && subcriterionToDelete) {
                    deletedRecords[subcriterionToDelete].push(recordIdToDelete);
                }

                rowToDelete.remove();
                rowToDelete = null;
                recordIdToDelete = null;
                subcriterionToDelete = null;

                recalcAll();
                markFormAsDirty();
            }
        });

        // === VIEW REMARKS HANDLER ===
        $(document).on('click', '.view-remarks', function () {
            // If you track remarks for these rows, adapt similarly to Criterion A
            showMessage('No remarks to display.');
        });

        // === ADD ROW LOGIC FOR EACH SUB-CRITERION ===
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
                        data-subcriterion="sole_authorship" data-record-id="0" data-file-path="">
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
                        data-subcriterion="co_authorship" data-record-id="0" data-file-path="">
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

        $('.add-lead-researcher-row').on('click', function() {
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
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion="lead_researcher" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra2_a_lead_researcher[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
            `;
            tableBody.appendChild(newRow);
            markFormAsDirty();
        });

        $('.add-contributor-row').on('click', function() {
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
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion="contributor" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra2_a_contributor[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
            `;
            tableBody.appendChild(newRow);
            markFormAsDirty();
        });

        $('.add-local-authors-row').on('click', function() {
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
                <td><input type="date" class="form-control" name="kra2_a_local_authors[new_${Date.now()}][citation_year]"></td>
                <td><input type="number" class="form-control score-input" name="kra2_a_local_authors[new_${Date.now()}][score]" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion="local_authors" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra2_a_local_authors[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
            `;
            tableBody.appendChild(newRow);
            markFormAsDirty();
        });

        $('.add-international-authors-row').on('click', function() {
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
                <td><input type="date" class="form-control" name="kra2_a_international_authors[new_${Date.now()}][citation_year]"></td>
                <td><input type="number" class="form-control score-input" name="kra2_a_international_authors[new_${Date.now()}][score]" readonly></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion="international_authors" data-record-id="0" data-file-path="">
                        Upload Evidence
                    </button>
                    <input type="hidden" name="kra2_a_international_authors[new_${Date.now()}][evidence_file]" value="">
                </td>
                <td><button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
            `;
            tableBody.appendChild(newRow);
            markFormAsDirty();
        });

        // === SAVE PROCESS ===
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
            fetch('../../includes/career_progress_tracking/research/save_kra2_criterion_a.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'save',
                    ...payload
                })
            })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(function (data) {
                if (data.success) {
                    showMessage('Criterion A data saved successfully!');
                    // Reset deleted arrays and selectedFiles
                    deletedRecords.sole_authorship = [];
                    deletedRecords.co_authorship = [];
                    deletedRecords.lead_researcher = [];
                    deletedRecords.contributor = [];
                    deletedRecords.local_authors = [];
                    deletedRecords.international_authors = [];
                    selectedFiles = []; // Clear the selected files array

                    markFormAsClean();
                    KRA2CriterionA.fetchCriterionA(requestId);
                } else {
                    showMessage(data.error || 'An error occurred while saving Criterion A.');
                }
            })
            .catch(function (error) {
                console.error('Error:', error);
                showMessage('Failed to save Criterion A data. Please check the console for details.');
            });
        }
        // === END OF SAVE PROCESS ===

        // Attach save event to button
        saveBtn.addEventListener('click', function () {
            saveCriterionA();
        });

        // Mark form as clean on initial load
        markFormAsClean();
    };

    // === On DOM load, initialize everything for Criterion A ===
    document.addEventListener('DOMContentLoaded', function () {
        KRA2CriterionA.init();
    });

    // Expose the namespace to the global scope
    window.KRA2CriterionA = KRA2CriterionA;

}(window, document, jQuery));