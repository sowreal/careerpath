<!-- careerpath/php/includes/career_progress_tracking/teaching/criterion_b.php -->
<div class="tab-pane fade <?php echo ($current_criterion === 'criterion-b') ? 'show active' : ''; ?>" id="criterion-b" role="tabpanel" aria-labelledby="tab-criterion-b">
    <!-- Criterion Header -->
    <h4 class="mb-3 pb-2 border-bottom border-3 border-success">
        CRITERION B: Research and Innovation (Max = 80 Points) <!-- 📝 Change Criterion Letter, Title, and Points -->
    </h4>
    <p>
        <strong>RESEARCH PERFORMANCE:</strong> Detail your research activities and achievements.<br>  
        Include publications, projects, and other research-related metrics.
    </p>

    <div class="row">
        <!-- Student Evaluation Section -->
        <div class="col-12 mt-4">
            <!-- Section Header -->
            <h5 class="mb-3 pb-1 border-bottom border-2 border-success">
                2.1 Research Evaluation (60%) <!-- 📝 Change Section Number, Title, and Percentage -->
            </h5>

            <!-- Divisor Selection -->
            <div class="row g-3 align-items-center mb-3">
                <!-- Number of Semesters to Deduct -->
                <div class="col-md-6">
                    <label for="student-divisor-b" class="form-label">
                        Number of Semesters to Deduct from Divisor (if applicable):
                    </label>
                    <select class="form-select" id="student-divisor-b">
                        <?php for ($i = 0; $i <= 8; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <!-- Reason for Reducing the Divisor -->
                <div class="col-md-6">
                    <label for="student-reason-b" class="form-label">Reason for Reducing the Divisor:</label>
                    <select class="form-select" id="student-reason-b" required>
                        <option value="">Select Option</option>
                        <option value="not_applicable">Not Applicable</option>
                        <option value="on_approved_study_leave">On Approved Study Leave</option>
                        <option value="on_approved_sabbatical_leave">On Approved Sabbatical Leave</option>
                        <option value="on_approved_maternity_leave">On Approved Maternity Leave</option>
                    </select>
                </div>
            </div>

            <!-- Responsive Table -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle" data-criterion="b"> <!-- 📝 Change data-criterion -->
                    <thead class="table-light">
                        <tr>
                            <th>Evaluation Period</th> <!-- 📝 Modify Column Headers as Needed -->
                            <th>Number of Publications</th>
                            <th>Research Projects</th>
                            <th>Grants Received</th>
                            <th>Innovations</th>
                            <th>Link to Evidence</th>
                            <th>Remarks</th> <!-- Remove or Add Columns as Needed -->
                            <th>Actions</th> <!-- 📝 Keep for Add/Delete Buttons -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $evaluationPeriods = ["AY 2019-2020", "AY 2020-2021", "AY 2021-2022"];
                            foreach ($evaluationPeriods as $period): 
                        ?>
                            <tr>
                                <td><?php echo $period; ?></td>
                                <td>
                                    <input type="number" class="form-control" placeholder="0" step="1" min="0">
                                </td>
                                <td>
                                    <input type="number" class="form-control" placeholder="0" step="1" min="0">
                                </td>
                                <td>
                                    <input type="number" class="form-control" placeholder="0" step="1" min="0">
                                </td>
                                <td>
                                    <input type="number" class="form-control" placeholder="0" step="1" min="0">
                                </td>
                                <td>
                                    <a href="#" target="_blank">Link to Evidence</a>
                                </td>
                                <td>
                                    <button class="btn btn-link text-decoration-none" data-bs-toggle="modal" data-bs-target="#remarksModal" 
                                            data-remarks1="Outstanding number of publications in <?php echo $period; ?>."
                                            data-remarks2="Significant contributions to research projects in <?php echo $period; ?>.">
                                        View Remarks
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Add Row Button -->
            <button type="button" class="btn btn-primary mt-3 add-row" data-criterion="b">Add Row</button> <!-- 📝 Ensure data-criterion matches table -->

            <!-- Overall Scores -->
            <div class="mt-4">
                <div class="row g-3 justify-content-end">
                    <div class="col-md-4">
                        <label for="student-overall-score-b" class="form-label">Overall Average Rating:</label>
                        <input type="number" class="form-control" id="student-overall-score-b" value="" disabled>
                    </div>
                    <div class="col-md-4">
                        <label for="faculty-overall-score-b" class="form-label">Faculty Score:</label>
                        <input type="number" class="form-control" id="faculty-overall-score-b" value="" disabled>
                    </div>
                </div>
            </div>
        </div>

        <!-- Supervisor's Evaluation Section -->
        <div class="col-12 mt-5">
            <!-- Section Header -->
            <h5 class="mb-3 pb-2 border-bottom border-2 border-success">
                2.2 Supervisor's Evaluation (40%) <!-- 📝 Change Section Number, Title, and Percentage -->
            </h5>

            <!-- Divisor Selection -->
            <div class="row g-3 align-items-center mb-3">
                <!-- Number of Semesters to Deduct -->
                <div class="col-md-6">
                    <label for="supervisor-divisor-b" class="form-label">
                        Number of Semesters to Deduct from Divisor (if applicable):
                    </label>
                    <select class="form-select" id="supervisor-divisor-b">
                        <?php for ($i = 0; $i <= 8; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <!-- Reason for Reducing the Divisor -->
                <div class="col-md-6">
                    <label for="supervisor-reason-b" class="form-label">Reason for Reducing the Divisor:</label>
                    <select class="form-select" id="supervisor-reason-b" required>
                        <option value="">Select Option</option>
                        <option value="not_applicable">Not Applicable</option>
                        <option value="on_approved_study_leave">On Approved Study Leave</option>
                        <option value="on_approved_sabbatical_leave">On Approved Sabbatical Leave</option>
                        <option value="on_approved_maternity_leave">On Approved Maternity Leave</option>
                    </select>
                </div>
            </div>

            <!-- Responsive Table -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle" data-criterion="b"> <!-- 📝 Change data-criterion -->
                    <thead class="table-light">
                        <tr>
                            <th>Evaluation Period</th> <!-- 📝 Modify Column Headers as Needed -->
                            <th>Number of Publications</th>
                            <th>Research Projects</th>
                            <th>Grants Received</th>
                            <th>Innovations</th>
                            <th>Link to Evidence</th>
                            <th>Remarks</th> <!-- Remove or Add Columns as Needed -->
                            <th>Actions</th> <!-- 📝 Keep for Add/Delete Buttons -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($evaluationPeriods as $period): ?> <!-- 📝 Ensure $evaluationPeriods is defined -->
                            <tr>
                                <td><?php echo $period; ?></td>
                                <td>
                                    <input type="number" class="form-control" placeholder="0" step="1" min="0">
                                </td>
                                <td>
                                    <input type="number" class="form-control" placeholder="0" step="1" min="0">
                                </td>
                                <td>
                                    <input type="number" class="form-control" placeholder="0" step="1" min="0">
                                </td>
                                <td>
                                    <input type="number" class="form-control" placeholder="0" step="1" min="0">
                                </td>
                                <td>
                                    <a href="#" target="_blank">Link to Evidence</a>
                                </td>
                                <td>
                                    <button class="btn btn-link text-decoration-none" data-bs-toggle="modal" data-bs-target="#remarksModal" 
                                            data-remarks1="Outstanding number of publications in <?php echo $period; ?>."
                                            data-remarks2="Significant contributions to research projects in <?php echo $period; ?>.">
                                        View Remarks
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Add Row Button -->
            <button type="button" class="btn btn-primary mt-3 add-row" data-criterion="b">Add Row</button> <!-- 📝 Ensure data-criterion matches table -->

            <!-- Overall Scores -->
            <div class="mt-4">
                <div class="row g-3 justify-content-end">
                    <div class="col-md-4">
                        <label for="supervisor-overall-score-b" class="form-label">Overall Average Rating:</label>
                        <input type="number" class="form-control" id="supervisor-overall-score-b" value="" disabled>
                    </div>
                    <div class="col-md-4">
                        <label for="supervisor-faculty-overall-score-b" class="form-label">Faculty Score:</label>
                        <input type="number" class="form-control" id="supervisor-faculty-overall-score-b" value="" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="d-flex justify-content-end mt-4">
        <button type="button" class="btn btn-success" id="save-criterion-b">Save Criterion B</button> <!-- 📝 Change ID and Button Text -->
    </div>

    <!-- Remarks Modal (Single Modal for All Criteria) -->
    <div class="modal fade" id="remarksModal" tabindex="-1" aria-labelledby="remarksModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Semester Remarks</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>1st Semester Remarks:</h6>
                    <p id="remarks1Content"></p>
                    <hr>
                    <h6>2nd Semester Remarks:</h6>
                    <p id="remarks2Content"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Dynamic Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Handle Add Row
            document.querySelectorAll('.add-row').forEach(button => {
                button.addEventListener('click', () => {
                    const criterion = button.getAttribute('data-criterion');
                    const table = document.querySelector(`table[data-criterion="${criterion}"] tbody`);
                    const columns = table.previousElementSibling.querySelector('tr').children.length;

                    const newRow = document.createElement('tr');

                    for (let i = 0; i < columns - 1; i++) { // Exclude Actions column
                        const td = document.createElement('td');
                        if (i === 0) {
                            const input = document.createElement('input');
                            input.type = 'text';
                            input.className = 'form-control';
                            input.placeholder = 'AY XXXX-XXXX'; // 📝 Change Placeholder as Needed
                            td.appendChild(input);
                        } else if (i === columns - 2) { // Link to Evidence
                            const link = document.createElement('a');
                            link.href = '#';
                            link.target = '_blank';
                            link.textContent = 'Link to Evidence'; // 📝 Change Link Text as Needed
                            td.appendChild(link);
                        } else if (i === columns - 3 && criterion === 'a') { // Remarks for Criterion A
                            const button = document.createElement('button');
                            button.className = 'btn btn-link text-decoration-none';
                            button.setAttribute('data-bs-toggle', 'modal');
                            button.setAttribute('data-bs-target', '#remarksModal');
                            button.setAttribute('data-remarks1', '');
                            button.setAttribute('data-remarks2', '');
                            button.textContent = 'View Remarks';
                            td.appendChild(button);
                        } else {
                            const input = document.createElement('input');
                            input.type = 'number';
                            input.className = 'form-control';
                            input.placeholder = '0.00'; // 📝 Change Placeholder as Needed
                            input.step = '0.01';
                            input.min = '0';
                            td.appendChild(input);
                        }
                        newRow.appendChild(td);
                    }

                    // Actions column
                    const actionTd = document.createElement('td');
                    const deleteBtn = document.createElement('button');
                    deleteBtn.type = 'button';
                    deleteBtn.className = 'btn btn-danger btn-sm delete-row';
                    deleteBtn.textContent = 'Delete';
                    actionTd.appendChild(deleteBtn);
                    newRow.appendChild(actionTd);

                    table.appendChild(newRow);
                });
            });

            // Handle Delete Row
            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('delete-row')) {
                    e.target.closest('tr').remove();
                }
            });

            // Handle Remarks Modal
            document.addEventListener('click', (e) => {
                if (e.target.matches('button[data-bs-toggle="modal"]')) {
                    const remarks1 = e.target.getAttribute('data-remarks1');
                    const remarks2 = e.target.getAttribute('data-remarks2');
                    document.getElementById('remarks1Content').textContent = remarks1;
                    document.getElementById('remarks2Content').textContent = remarks2;
                }
            });

            // Optional: Hide Criterion Sections Initially if Evaluation Not Selected
            // 📝 Implement based on your evaluation selection mechanism
            /*
            const evaluationSelected = checkEvaluationSelected(); // Implement this function
            if (!evaluationSelected) {
                document.getElementById('criterion-a').style.display = 'none';
                // Show a message indicating selection is needed
            }
            */
        });
    </script>
</div>
