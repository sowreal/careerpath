// Encapsulate Criterion C logic in a namespace to avoid conflicts.
(function (window, document, $) {
    'use strict';

    // Create a namespace object
    var CriterionC = {};

    // === HELPER FUNCTIONS ===
    function escapeHTML(str) {
        if (!str) return '';
        return str.replace(/&/g, "&amp;")
                  .replace(/</g, "&lt;")
                  .replace(/>/g, "&gt;")
                  .replace(/"/g, "&quot;")
                  .replace(/'/g, "&#039;");
    }

    function addDefaultAdviserRows(tableBody) {
        const adviserRequirements = [
            { name: "SPECIAL/CAPSTONE PROJECT", multiplier: 3 },
            { name: "UNDERGRADUATE THESIS", multiplier: 5 },
            { name: "MASTER'S THESIS", multiplier: 8 },
            { name: "DISSERTATION", multiplier: 10 }
        ];
        const requestId = document.getElementById('request_id_c').value.trim();
        adviserRequirements.forEach((item, index) => {
            const row = document.createElement('tr');
            row.setAttribute('data-adviser-id', '0');
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>${escapeHTML(item.name)}</td>
                <td><input type="number" class="form-control ay-input" name="kra1_c_adviser[${index}][ay_2019]" placeholder="0" min="0"></td>
                <td><input type="number" class="form-control ay-input" name="kra1_c_adviser[${index}][ay_2020]" placeholder="0" min="0"></td>
                <td><input type="number" class="form-control ay-input" name="kra1_c_adviser[${index}][ay_2021]" placeholder="0" min="0"></td>
                <td><input type="number" class="form-control ay-input" name="kra1_c_adviser[${index}][ay_2022]" placeholder="0" min="0"></td>
                <td><input type="text" class="form-control score-input" name="kra1_c_adviser[${index}][score]" placeholder="0.00" readonly></td>
                <td>
                    <input type="text" class="form-control evidence-link" name="kra1_c_adviser[${index}][evidence_link]" placeholder="Link to Evidence">
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-sm view-remarks-c">View Remarks</button>
                </td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
            `;
            tableBody.appendChild(row);
        });
    }

    function addDefaultPanelRows(tableBody) {
        const panelRequirements = [
            { name: "Requirement 1", multiplier: 1 },
            { name: "Requirement 2", multiplier: 1 },
            { name: "Requirement 3", multiplier: 2 },
            { name: "Requirement 4", multiplier: 2 }
        ];
        const requestId = document.getElementById('request_id_c').value.trim();
        panelRequirements.forEach((item, index) => {
            const row = document.createElement('tr');
            row.setAttribute('data-panel-id', '0');
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>${escapeHTML(item.name)}</td>
                <td><input type="number" class="form-control ay-input" name="kra1_c_panel[${index}][ay_2019]" placeholder="0" min="0"></td>
                <td><input type="number" class="form-control ay-input" name="kra1_c_panel[${index}][ay_2020]" placeholder="0" min="0"></td>
                <td><input type="number" class="form-control ay-input" name="kra1_c_panel[${index}][ay_2021]" placeholder="0" min="0"></td>
                <td><input type="number" class="form-control ay-input" name="kra1_c_panel[${index}][ay_2022]" placeholder="0" min="0"></td>
                <td><input type="text" class="form-control score-input" name="kra1_c_panel[${index}][score]" placeholder="0.00" readonly></td>
                <td>
                    <input type="text" class="form-control evidence-link" name="kra1_c_panel[${index}][evidence_link]" placeholder="Link to Evidence">
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-sm view-remarks-c">View Remarks</button>
                </td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
            `;
            tableBody.appendChild(row);
        });
    }

    function addDefaultMentorRows(tableBody) {
        const requestId = document.getElementById('request_id_c').value.trim();
        for (let i = 1; i <= 3; i++) {
            const row = document.createElement('tr');
            row.setAttribute('data-mentor-id', '0');
            row.innerHTML = `
                <td>${i}</td>
                <td><input type="text" class="form-control" name="kra1_c_mentor[${i}][competition]" required></td>
                <td><input type="text" class="form-control" name="kra1_c_mentor[${i}][organization]" required></td>
                <td><input type="text" class="form-control" name="kra1_c_mentor[${i}][award]" required></td>
                <td><input type="date" class="form-control" name="kra1_c_mentor[${i}][date_awarded]" required></td>
                <td><input type="text" class="form-control score-input" name="kra1_c_mentor[${i}][score]" placeholder="0" readonly></td>
                <td>
                    <input type="text" class="form-control evidence-link" name="kra1_c_mentor[${i}][evidence_link]" placeholder="Link to Evidence">
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-sm view-remarks-c">View Remarks</button>
                </td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
            `;
            tableBody.appendChild(row);
        }
    }

    function populateAdviserTable(adviserData) {
        const tableBody = document.querySelector('#adviser-table tbody');
        const requestId = document.getElementById('request_id_c').value.trim();
        tableBody.innerHTML = '';

        if (!adviserData || adviserData.length === 0) {
            addDefaultAdviserRows(tableBody);
            return;
        }

        adviserData.forEach((item, index) => {
            const tr = document.createElement('tr');
            tr.setAttribute('data-adviser-id', item.adviser_id);

            tr.innerHTML = `
                <td>${index + 1}</td>
                <td>${escapeHTML(item.requirement)}</td>
                <td><input type="number" class="form-control ay-input" name="kra1_c_adviser[${index}][ay_2019]" value="${item.ay_2019}" placeholder="0" min="0"></td>
                <td><input type="number" class="form-control ay-input" name="kra1_c_adviser[${index}][ay_2020]" value="${item.ay_2020}" placeholder="0" min="0"></td>
                <td><input type="number" class="form-control ay-input" name="kra1_c_adviser[${index}][ay_2021]" value="${item.ay_2021}" placeholder="0" min="0"></td>
                <td><input type="number" class="form-control ay-input" name="kra1_c_adviser[${index}][ay_2022]" value="${item.ay_2022}" placeholder="0" min="0"></td>
                <td><input type="text" class="form-control score-input" name="kra1_c_adviser[${index}][score]" value="${item.score}" placeholder="0.00" readonly></td>
                <td>
                    <input type="text" class="form-control evidence-link" name="kra1_c_adviser[${index}][evidence_link]" value="${escapeHTML(item.evidence_file || '')}" placeholder="Link to Evidence">
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-sm view-remarks-c" data-remarks="${escapeHTML(item.remarks || '')}">View Remarks</button>
                </td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
            `;

            tableBody.appendChild(tr);
        });
    }

    function populatePanelTable(panelData) {
        const tableBody = document.querySelector('#panel-table tbody');
        const requestId = document.getElementById('request_id_c').value.trim();
        tableBody.innerHTML = '';

        if (!panelData || panelData.length === 0) {
            addDefaultPanelRows(tableBody);
            return;
        }

        panelData.forEach((item, index) => {
            const tr = document.createElement('tr');
            tr.setAttribute('data-panel-id', item.panel_id);

            tr.innerHTML = `
                <td>${index + 1}</td>
                <td>${escapeHTML(item.requirement)}</td>
                <td><input type="number" class="form-control ay-input" name="kra1_c_panel[${index}][ay_2019]" value="${item.ay_2019}" placeholder="0" min="0"></td>
                <td><input type="number" class="form-control ay-input" name="kra1_c_panel[${index}][ay_2020]" value="${item.ay_2020}" placeholder="0" min="0"></td>
                <td><input type="number" class="form-control ay-input" name="kra1_c_panel[${index}][ay_2021]" value="${item.ay_2021}" placeholder="0" min="0"></td>
                <td><input type="number" class="form-control ay-input" name="kra1_c_panel[${index}][ay_2022]" value="${item.ay_2022}" placeholder="0" min="0"></td>
                <td><input type="text" class="form-control score-input" name="kra1_c_panel[${index}][score]" value="${item.score}" placeholder="0.00" readonly></td>
                <td>
                    <input type="text" class="form-control evidence-link" name="kra1_c_panel[${index}][evidence_link]" value="${escapeHTML(item.evidence_file || '')}" placeholder="Link to Evidence">
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-sm view-remarks-c" data-remarks="${escapeHTML(item.remarks || '')}">View Remarks</button>
                </td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
            `;

            tableBody.appendChild(tr);
        });
    }

    function populateMentorTable(mentorData) {
        const tableBody = document.querySelector('#mentor-table tbody');
        const requestId = document.getElementById('request_id_c').value.trim();
        tableBody.innerHTML = '';

        if (!mentorData || mentorData.length === 0) {
            addDefaultMentorRows(tableBody);
            return;
        }

        mentorData.forEach((item, index) => {
            const tr = document.createElement('tr');
            tr.setAttribute('data-mentor-id', item.mentor_id);

            tr.innerHTML = `
                <td>${index + 1}</td>
                <td><input type="text" class="form-control" name="kra1_c_mentor[${index}][competition]" value="${escapeHTML(item.competition || '')}" required></td>
                <td><input type="text" class="form-control" name="kra1_c_mentor[${index}][organization]" value="${escapeHTML(item.organization || '')}" required></td>
                <td><input type="text" class="form-control" name="kra1_c_mentor[${index}][award]" value="${escapeHTML(item.award || '')}" required></td>
                <td><input type="date" class="form-control" name="kra1_c_mentor[${index}][date_awarded]" value="${item.date_awarded || ''}" required></td>
                <td><input type="text" class="form-control score-input" name="kra1_c_mentor[${index}][score]" value="${item.score}" placeholder="0" readonly></td>
                <td>
                    <input type="text" class="form-control evidence-link" name="kra1_c_mentor[${index}][evidence_link]" value="${escapeHTML(item.evidence_file || '')}" placeholder="Link to Evidence">
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-sm view-remarks-c" data-remarks="${escapeHTML(item.remarks || '')}">View Remarks</button>
                </td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
            `;

            tableBody.appendChild(tr);
        });
    }

    function populateMetadata(metadata) {
        if (!metadata) {
            // Reset to defaults if no metadata
            setElementValue('kra1_c_adviser_total', '0.00');
            setElementValue('kra1_c_panel_total', '0.00');
            setElementValue('kra1_c_mentor_total', '0.00');
            return;
        }
    
        // Debugging logs
        console.log('Adviser Total:', metadata.adviser_total, typeof metadata.adviser_total);
        console.log('Panel Total:', metadata.panel_total, typeof metadata.panel_total);
        console.log('Mentor Total:', metadata.mentor_total, typeof metadata.mentor_total);
        
        // Helper function to safely format numbers
        function formatTotal(total) {
            var num = Number(total);
            if (isNaN(num)) {
                console.warn(`Invalid total for ${total}. Defaulting to 0.00.`);
                return '0.00';
            }
            return num.toFixed(2);
        }
    
        // Populate the overall scores with safe formatting
        setElementValue('kra1_c_adviser_total', formatTotal(metadata.adviser_total));
        setElementValue('kra1_c_panel_total', formatTotal(metadata.panel_total));
        setElementValue('kra1_c_mentor_total', formatTotal(metadata.mentor_total));
    }

    function setElementValue(elementId, value) {
        const element = document.getElementById(elementId);
        if (element) {
            element.value = value;
        } else {
            console.warn(`Element with ID '${elementId}' not found.`);
        }
    }

    // Expose a fetch function that will be called to load Criterion C data
    CriterionC.fetchCriterionC = function (requestId) {
        return fetch(`../../includes/career_progress_tracking/teaching/fetch_criterion_c.php?request_id=${requestId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    populateAdviserTable(data.adviser);
                    populatePanelTable(data.panel);
                    populateMentorTable(data.mentor);
                    populateMetadata(data.metadata);
                    return data;
                } else {
                    console.error('Error:', data.error);
                    showMessage('Failed to fetch data: ' + data.error);
                    addDefaultAdviserRows(document.querySelector('#adviser-table tbody'));
                    addDefaultPanelRows(document.querySelector('#panel-table tbody'));
                    addDefaultMentorRows(document.querySelector('#mentor-table tbody'));
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                showMessage('Failed to fetch data. Please check the console for details.');
                addDefaultAdviserRows(document.querySelector('#adviser-table tbody'));
                addDefaultPanelRows(document.querySelector('#panel-table tbody'));
                addDefaultMentorRows(document.querySelector('#mentor-table tbody'));
            });
    };

    // We'll set up everything on DOMContentLoaded within CriterionC.init
    CriterionC.init = function() {
        const form = document.getElementById('criterion-c-form');
        const saveBtn = document.getElementById('save-criterion-c');
        const saveErrorModal = new bootstrap.Modal(document.getElementById('saveErrorModal'));
        const messageModal = new bootstrap.Modal(document.getElementById('messageModal')); // For displaying messages

        function showMessage(message) {
            $('#messageModalBody').text(message);
            messageModal.show();
        }
        window.showMessage = showMessage; // Make it accessible if needed by other scripts

        // === DELETION TRACKING AND DIRTY FLAG START ===
        let deletedAdvisers = [];
        let deletedPanels = [];
        let deletedMentors = [];
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

        // === DELETE ROW FUNCTION START ===
        let rowToDelete = null;
        let evaluationIdToDelete = null;
        let tableToDeleteFrom = null;

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-row')) {
                rowToDelete = e.target.closest('tr');
                if (rowToDelete.hasAttribute('data-adviser-id')) {
                    evaluationIdToDelete = rowToDelete.getAttribute('data-adviser-id');
                    tableToDeleteFrom = 'adviser';
                } else if (rowToDelete.hasAttribute('data-panel-id')) {
                    evaluationIdToDelete = rowToDelete.getAttribute('data-panel-id');
                    tableToDeleteFrom = 'panel';
                } else if (rowToDelete.hasAttribute('data-mentor-id')) {
                    evaluationIdToDelete = rowToDelete.getAttribute('data-mentor-id');
                    tableToDeleteFrom = 'mentor';
                } else {
                    evaluationIdToDelete = '0';
                    tableToDeleteFrom = null;
                }

                const deleteModal = new bootstrap.Modal(document.getElementById('deleteRowModal'));
                deleteModal.show();
            }
        });

        document.getElementById('deleteRowModal').addEventListener('click', function() {
            if (rowToDelete) {
                const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteRowModal'));
                deleteModal.hide();

                if (evaluationIdToDelete !== '0' && tableToDeleteFrom) {
                    if (tableToDeleteFrom === 'adviser') {
                        deletedAdvisers.push(evaluationIdToDelete);
                    } else if (tableToDeleteFrom === 'panel') {
                        deletedPanels.push(evaluationIdToDelete);
                    } else if (tableToDeleteFrom === 'mentor') {
                        deletedMentors.push(evaluationIdToDelete);
                    }
                }
                rowToDelete.remove();
                rowToDelete = null;
                evaluationIdToDelete = null;
                tableToDeleteFrom = null;

                calculateOverallScores();
                markFormAsDirty();

                const successModal = new bootstrap.Modal(document.getElementById('deleteSuccessModal'));
                successModal.show();
            }
        });
        // === DELETE ROW FUNCTION END ===

        // === REMARKS HANDLER START ===
        $(document).on('click', '.view-remarks-c', function() {
            const button = $(this);
            const remarks = button.data('remarks');
            $('#remarksModalBody').text(remarks || 'No remarks provided.');

            const remarksModal = new bootstrap.Modal(document.getElementById('remarksModal'));
            remarksModal.show();
        });
        // === REMARKS HANDLER END ===

        // === CALCULATION START ===
        function calculateOverallScores() {
            // Adviser Calculations
            const adviserTable = document.getElementById('adviser-table');
            const adviserRows = adviserTable.querySelectorAll('tbody tr');
            let adviserTotal = 0;
            adviserRows.forEach(row => {
                const ayInputs = row.querySelectorAll('.ay-input');
                let sum = 0;
                ayInputs.forEach(input => {
                    sum += parseInt(input.value, 10) || 0;
                });
                const multiplier = getMultiplier(row.querySelector('td:nth-child(2)').textContent.trim());
                const score = sum * multiplier;
                row.querySelector('.score-input').value = score.toFixed(2);
                adviserTotal += score;
            });
            document.getElementById('kra1_c_adviser_total').value = adviserTotal.toFixed(2);

            // Panel Calculations
            const panelTable = document.getElementById('panel-table');
            const panelRows = panelTable.querySelectorAll('tbody tr');
            let panelTotal = 0;
            panelRows.forEach(row => {
                const ayInputs = row.querySelectorAll('.ay-input');
                let sum = 0;
                ayInputs.forEach(input => {
                    sum += parseInt(input.value, 10) || 0;
                });
                const multiplier = getPanelMultiplier(row.querySelector('td:nth-child(2)').textContent.trim(), panelRows.length);
                const score = sum * multiplier;
                row.querySelector('.score-input').value = score.toFixed(2);
                panelTotal += score;
            });
            document.getElementById('kra1_c_panel_total').value = panelTotal.toFixed(2);

            // Mentor Calculations
            const mentorTable = document.getElementById('mentor-table');
            const mentorRows = mentorTable.querySelectorAll('tbody tr');
            let mentorTotal = 0;
            mentorRows.forEach(row => {
                const competition = row.querySelector('input[name^="kra1_c_mentor"][name$="[competition]"]').value.trim();
                const organization = row.querySelector('input[name^="kra1_c_mentor"][name$="[organization]"]').value.trim();
                const award = row.querySelector('input[name^="kra1_c_mentor"][name$="[award]"]').value.trim();
                const dateAwarded = row.querySelector('input[name^="kra1_c_mentor"][name$="[date_awarded]"]').value.trim();

                let score = 0;
                if (competition && organization && award && dateAwarded) {
                    score = 3; // Example score logic
                }
                row.querySelector('.score-input').value = score;
                mentorTotal += score;
            });
            document.getElementById('kra1_c_mentor_total').value = mentorTotal.toFixed(2);
            markFormAsDirty();
        }

        function getMultiplier(requirement) {
            const multipliers = {
                "SPECIAL/CAPSTONE PROJECT": 3,
                "UNDERGRADUATE THESIS": 5,
                "MASTER'S THESIS": 8,
                "DISSERTATION": 10
            };
            return multipliers[requirement.toUpperCase()] || 1;
        }

        function getPanelMultiplier(requirement, totalRows) {
            // Assuming first two requirements have multiplier 1, next two have multiplier 2
            const panelRequirements = [
                "Requirement 1",
                "Requirement 2",
                "Requirement 3",
                "Requirement 4"
            ];
            const index = panelRequirements.indexOf(requirement);
            if (index < 2) return 1;
            else return 2;
        }

        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('ay-input')) {
                calculateOverallScores();
                markFormAsDirty();
            }
        });

        // === CALCULATION END ===

        // === ADD ROWS START ===
        document.querySelectorAll('#criterion-c-form .add-row').forEach(addBtn => {
            addBtn.addEventListener('click', function() {
                const tableId = this.getAttribute('data-table-id'); // adviser-table, panel-table, mentor-table
                const tableBody = document.querySelector(`#${tableId} tbody`);
                const requestId = document.getElementById('request_id_c').value.trim();

                let newRow;
                if (tableId === 'adviser-table') {
                    const adviserRequirements = [
                        { name: "SPECIAL/CAPSTONE PROJECT", multiplier: 3 },
                        { name: "UNDERGRADUATE THESIS", multiplier: 5 },
                        { name: "MASTER'S THESIS", multiplier: 8 },
                        { name: "DISSERTATION", multiplier: 10 }
                    ];
                    const index = tableBody.querySelectorAll('tr').length;
                    const requirement = adviserRequirements[index % adviserRequirements.length].name;
                    const multiplier = adviserRequirements[index % adviserRequirements.length].multiplier;

                    const newRowId = 'new_' + Date.now();
                    newRow = document.createElement('tr');
                    newRow.setAttribute('data-adviser-id', '0');
                    newRow.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${escapeHTML(requirement)}</td>
                        <td><input type="number" class="form-control ay-input" name="kra1_c_adviser[${index}][ay_2019]" placeholder="0" min="0"></td>
                        <td><input type="number" class="form-control ay-input" name="kra1_c_adviser[${index}][ay_2020]" placeholder="0" min="0"></td>
                        <td><input type="number" class="form-control ay-input" name="kra1_c_adviser[${index}][ay_2021]" placeholder="0" min="0"></td>
                        <td><input type="number" class="form-control ay-input" name="kra1_c_adviser[${index}][ay_2022]" placeholder="0" min="0"></td>
                        <td><input type="text" class="form-control score-input" name="kra1_c_adviser[${index}][score]" placeholder="0.00" readonly></td>
                        <td>
                            <input type="text" class="form-control evidence-link" name="kra1_c_adviser[${index}][evidence_link]" placeholder="Link to Evidence">
                        </td>
                        <td>
                            <button type="button" class="btn btn-success btn-sm view-remarks-c">View Remarks</button>
                        </td>
                        <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                    `;
                } else if (tableId === 'panel-table') {
                    const panelRequirements = [
                        { name: "Requirement 1", multiplier: 1 },
                        { name: "Requirement 2", multiplier: 1 },
                        { name: "Requirement 3", multiplier: 2 },
                        { name: "Requirement 4", multiplier: 2 }
                    ];
                    const index = tableBody.querySelectorAll('tr').length;
                    const requirement = panelRequirements[index % panelRequirements.length].name;
                    const multiplier = panelRequirements[index % panelRequirements.length].multiplier;

                    const newRowId = 'new_' + Date.now();
                    newRow = document.createElement('tr');
                    newRow.setAttribute('data-panel-id', '0');
                    newRow.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${escapeHTML(requirement)}</td>
                        <td><input type="number" class="form-control ay-input" name="kra1_c_panel[${index}][ay_2019]" placeholder="0" min="0"></td>
                        <td><input type="number" class="form-control ay-input" name="kra1_c_panel[${index}][ay_2020]" placeholder="0" min="0"></td>
                        <td><input type="number" class="form-control ay-input" name="kra1_c_panel[${index}][ay_2021]" placeholder="0" min="0"></td>
                        <td><input type="number" class="form-control ay-input" name="kra1_c_panel[${index}][ay_2022]" placeholder="0" min="0"></td>
                        <td><input type="text" class="form-control score-input" name="kra1_c_panel[${index}][score]" placeholder="0.00" readonly></td>
                        <td>
                            <input type="text" class="form-control evidence-link" name="kra1_c_panel[${index}][evidence_link]" placeholder="Link to Evidence">
                        </td>
                        <td>
                            <button type="button" class="btn btn-success btn-sm view-remarks-c">View Remarks</button>
                        </td>
                        <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                    `;
                } else if (tableId === 'mentor-table') {
                    const index = tableBody.querySelectorAll('tr').length + 1;
                    const newRowId = 'new_' + Date.now();
                    newRow = document.createElement('tr');
                    newRow.setAttribute('data-mentor-id', '0');
                    newRow.innerHTML = `
                        <td>${index}</td>
                        <td><input type="text" class="form-control" name="kra1_c_mentor[${index}][competition]" placeholder="Competition Name" required></td>
                        <td><input type="text" class="form-control" name="kra1_c_mentor[${index}][organization]" placeholder="Organization Name" required></td>
                        <td><input type="text" class="form-control" name="kra1_c_mentor[${index}][award]" placeholder="Award Received" required></td>
                        <td><input type="date" class="form-control" name="kra1_c_mentor[${index}][date_awarded]" required></td>
                        <td><input type="text" class="form-control score-input" name="kra1_c_mentor[${index}][score]" placeholder="0" readonly></td>
                        <td>
                            <input type="text" class="form-control evidence-link" name="kra1_c_mentor[${index}][evidence_link]" placeholder="Link to Evidence">
                        </td>
                        <td>
                            <button type="button" class="btn btn-success btn-sm view-remarks-c">View Remarks</button>
                        </td>
                        <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                    `;
                }

                tableBody.appendChild(newRow);
                calculateOverallScores();
                markFormAsDirty();
            });
        });
        // === ADD ROWS END ===

        // === SAVING PROCESS START ===
        function gatherPayload(requestId) {
            const advisers = [];
            const panels = [];
            const mentors = [];

            // Gather Adviser Data
            document.querySelectorAll('#adviser-table tbody tr').forEach(row => {
                const adviser_id = row.getAttribute('data-adviser-id') || '0';
                const requirement = row.querySelector('td:nth-child(2)').textContent.trim();
                const ay_2019 = parseInt(row.querySelector('input[name^="kra1_c_adviser"][name$="[ay_2019]"]').value, 10) || 0;
                const ay_2020 = parseInt(row.querySelector('input[name^="kra1_c_adviser"][name$="[ay_2020]"]').value, 10) || 0;
                const ay_2021 = parseInt(row.querySelector('input[name^="kra1_c_adviser"][name$="[ay_2021]"]').value, 10) || 0;
                const ay_2022 = parseInt(row.querySelector('input[name^="kra1_c_adviser"][name$="[ay_2022]"]').value, 10) || 0;
                const score = parseFloat(row.querySelector('input[name^="kra1_c_adviser"][name$="[score]"]').value) || 0;
                const evidence_link = row.querySelector('input[name^="kra1_c_adviser"][name$="[evidence_link]"]').value.trim();
                const remarks = row.querySelector('.view-remarks-c').getAttribute('data-remarks') || '';

                advisers.push({
                    adviser_id: parseInt(adviser_id, 10),
                    requirement,
                    ay_2019,
                    ay_2020,
                    ay_2021,
                    ay_2022,
                    score,
                    evidence_file: evidence_link,
                    remarks
                });
            });

            // Gather Panel Data
            document.querySelectorAll('#panel-table tbody tr').forEach(row => {
                const panel_id = row.getAttribute('data-panel-id') || '0';
                const requirement = row.querySelector('td:nth-child(2)').textContent.trim();
                const ay_2019 = parseInt(row.querySelector('input[name^="kra1_c_panel"][name$="[ay_2019]"]').value, 10) || 0;
                const ay_2020 = parseInt(row.querySelector('input[name^="kra1_c_panel"][name$="[ay_2020]"]').value, 10) || 0;
                const ay_2021 = parseInt(row.querySelector('input[name^="kra1_c_panel"][name$="[ay_2021]"]').value, 10) || 0;
                const ay_2022 = parseInt(row.querySelector('input[name^="kra1_c_panel"][name$="[ay_2022]"]').value, 10) || 0;
                const score = parseFloat(row.querySelector('input[name^="kra1_c_panel"][name$="[score]"]').value) || 0;
                const evidence_link = row.querySelector('input[name^="kra1_c_panel"][name$="[evidence_link]"]').value.trim();
                const remarks = row.querySelector('.view-remarks-c').getAttribute('data-remarks') || '';

                panels.push({
                    panel_id: parseInt(panel_id, 10),
                    requirement,
                    ay_2019,
                    ay_2020,
                    ay_2021,
                    ay_2022,
                    score,
                    evidence_file: evidence_link,
                    remarks
                });
            });

            // Gather Mentor Data
            document.querySelectorAll('#mentor-table tbody tr').forEach(row => {
                const mentor_id = row.getAttribute('data-mentor-id') || '0';
                const competition = row.querySelector('input[name^="kra1_c_mentor"][name$="[competition]"]').value.trim();
                const organization = row.querySelector('input[name^="kra1_c_mentor"][name$="[organization]"]').value.trim();
                const award = row.querySelector('input[name^="kra1_c_mentor"][name$="[award]"]').value.trim();
                const date_awarded = row.querySelector('input[name^="kra1_c_mentor"][name$="[date_awarded]"]').value.trim();
                const score = parseFloat(row.querySelector('input[name^="kra1_c_mentor"][name$="[score]"]').value) || 0;
                const evidence_link = row.querySelector('input[name^="kra1_c_mentor"][name$="[evidence_link]"]').value.trim();
                const remarks = row.querySelector('.view-remarks-c').getAttribute('data-remarks') || '';

                mentors.push({
                    mentor_id: parseInt(mentor_id, 10),
                    competition,
                    organization,
                    award,
                    date_awarded,
                    score,
                    evidence_file: evidence_link,
                    remarks
                });
            });

            const adviser_total = parseFloat(document.getElementById('kra1_c_adviser_total').value) || 0;
            const panel_total = parseFloat(document.getElementById('kra1_c_panel_total').value) || 0;
            const mentor_total = parseFloat(document.getElementById('kra1_c_mentor_total').value) || 0;

            return {
                request_id: parseInt(requestId, 10),
                advisers,
                panels,
                mentors,
                adviser_total,
                panel_total,
                mentor_total,
                deletedAdvisers,
                deletedPanels,
                deletedMentors
            };
        }

        function saveCriterionC() {
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }

            calculateOverallScores();
            const requestId = document.getElementById('request_id_c').value.trim();
            if (!requestId || parseInt(requestId) <= 0) {
                showMessage('Please select a valid evaluation ID.');
                return;
            }

            const payload = gatherPayload(requestId);
            fetch('../../includes/career_progress_tracking/teaching/save_criterion_c.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(payload)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('Criterion C data saved successfully!');
                    deletedAdvisers = [];
                    deletedPanels = [];
                    deletedMentors = [];
                    markFormAsClean();
                    CriterionC.fetchCriterionC(requestId);
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
            saveCriterionC();
        });
        // === SAVING PROCESS END ===

        // === UNSAVED CHANGES PROMPT START ===
        //
        // === UNSAVED CHANGES PROMPT END ===

        calculateOverallScores();
        markFormAsClean(); // Mark the form clean on initial load
    };

    // On DOM load, initialize everything
    document.addEventListener('DOMContentLoaded', function () {
        CriterionC.init();
    });

    // Expose the namespace
    window.CriterionC = CriterionC;
}(window, document, jQuery));
