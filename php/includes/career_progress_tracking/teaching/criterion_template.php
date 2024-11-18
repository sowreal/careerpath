<!-- Template for Criterion Pages -->
<div class="tab-pane fade <?php echo ($current_criterion === 'criterion-a') ? 'show active' : ''; ?>" id="criterion-a" role="tabpanel" aria-labelledby="tab-criterion-a">
    <!-- Criterion Header -->
    <h4 class="mb-3 pb-2 border-bottom border-3 border-success">
        CRITERION A: Teaching Effectiveness (Max = 60 Points) <!-- 📝 Change Criterion Letter, Title, and Points -->
    </h4>
    <p>
        <strong>FACULTY PERFORMANCE:</strong> Enter the average rating received by the faculty per semester.<br>  
        For newly appointed faculty from private HEI, LUCs, TESDA/DepEd schools who decide to proceed with the evaluation, enter "0" for semesters without student and supervisor evaluations.
    </p>

    <div class="row">
        <!-- Student Evaluation Section -->
        <div class="col-12 mt-4">
            <!-- Section Header -->
            <h5 class="mb-3 pb-1 border-bottom border-2 border-success">
                1.1 Student Evaluation (60%) <!-- 📝 Change Section Number, Title, and Percentage -->
            </h5>

            <!-- Divisor Selection -->
            <div class="row g-3 align-items-center mb-3">
                <!-- Number of Semesters to Deduct -->
                <div class="col-md-6">
                    <label for="student-divisor" class="form-label">
                        Number of Semesters to Deduct from Divisor (if applicable):
                    </label>
                    <select class="form-select" id="student-divisor">
                        <?php for ($i = 0; $i <= 8; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <!-- Reason for Reducing the Divisor -->
                <div class="col-md-6">
                    <label for="student-reason" class="form-label">Reason for Reducing the Divisor:</label>
                    <select class="form-select" id="student-reason" required>
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
                <table class="table table-bordered align-middle" data-criterion="a"> <!-- 📝 Change data-criterion -->
                    <thead class="table-light">
                        <tr>
                            <th>Evaluation Period</th> <!-- 📝 Modify Column Headers as Needed -->
                            <th>1st Semester Rating</th>
                            <th>2nd Semester Rating</th>
                            <th>Link to Evidence</th>
                            <th>Remarks</th> <!-- Remove or Add Columns as Needed -->
                            <th>Actions</th> <!-- 📝 Keep for Add/Delete Buttons -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample Rows -->
                        <?php 
                            $evaluationPeriods = ["AY 2019-2020", "AY 2020-2021", "AY 2021-2022", "AY 2022-2023"]; // 📝 Update Evaluation Periods
                            foreach ($evaluationPeriods as $period): 
                        ?>
                            <tr>
                                <td><?php echo $period; ?></td>
                                <td>
                                    <input type="number" class="form-control" placeholder="0.00" step="0.01" min="0">
                                </td>
                                <td>
                                    <input type="number" class="form-control" placeholder="0.00" step="0.01" min="0">
                                </td>
                                <td>
                                    <a href="#" target="_blank">Link to Evidence</a>
                                </td>
                                <td>
                                    <button class="btn btn-link text-decoration-none" data-bs-toggle="modal" data-bs-target="#remarksModal" 
                                            data-remarks1="Excellent performance in 1st semester of <?php echo $period; ?>."
                                            data-remarks2="Good progress in 2nd semester of <?php echo $period; ?>.">
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
            <button type="button" class="btn btn-primary mt-3 add-row" data-criterion="a">Add Row</button> <!-- 📝 Ensure data-criterion matches table -->

            <!-- Overall Scores -->
            <div class="mt-4">
                <div class="row g-3 justify-content-end">
                    <div class="col-md-4">
                        <label for="student-overall-score" class="form-label">Overall Average Rating:</label>
                        <input type="number" class="form-control" id="student-overall-score" value="" disabled>
                    </div>
                    <div class="col-md-4">
                        <label for="faculty-overall-score" class="form-label">Faculty Score:</label>
                        <input type="number" class="form-control" id="faculty-overall-score" value="" disabled>
                    </div>
                </div>
            </div>
        </div>

        <!-- Supervisor's Evaluation Section -->
        <div class="col-12 mt-5">
            <!-- Section Header -->
            <h5 class="mb-3 pb-2 border-bottom border-2 border-success">
                1.2 Supervisor's Evaluation (40%) <!-- 📝 Change Section Number, Title, and Percentage -->
            </h5>

            <!-- Divisor Selection -->
            <div class="row g-3 align-items-center mb-3">
                <!-- Number of Semesters to Deduct -->
                <div class="col-md-6">
                    <label for="supervisor-divisor" class="form-label">
                        Number of Semesters to Deduct from Divisor (if applicable):
                    </label>
                    <select class="form-select" id="supervisor-divisor">
                        <?php for ($i = 0; $i <= 8; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <!-- Reason for Reducing the Divisor -->
                <div class="col-md-6">
                    <label for="supervisor-reason" class="form-label">Reason for Reducing the Divisor:</label>
                    <select class="form-select" id="supervisor-reason" required>
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
                <table class="table table-bordered align-middle" data-criterion="a"> <!-- 📝 Change data-criterion -->
                    <thead class="table-light">
                        <tr>
                            <th>Evaluation Period</th> <!-- 📝 Modify Column Headers as Needed -->
                            <th>1st Semester Rating</th>
                            <th>2nd Semester Rating</th>
                            <th>Link to Evidence</th>
                            <th>Actions</th> <!-- 📝 Keep for Add/Delete Buttons -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($evaluationPeriods as $period): ?> <!-- 📝 Ensure $evaluationPeriods is defined -->
                            <tr>
                                <td><?php echo $period; ?></td>
                                <td>
                                    <input type="number" class="form-control" placeholder="0.00" step="0.01" min="0">
                                </td>
                                <td>
                                    <input type="number" class="form-control" placeholder="0.00" step="0.01" min="0">
                                </td>
                                <td>
                                    <a href="#" target="_blank">Link to Evidence</a>
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
            <button type="button" class="btn btn-primary mt-3 add-row" data-criterion="a">Add Row</button> <!-- 📝 Ensure data-criterion matches table -->

            <!-- Overall Scores -->
            <div class="mt-4">
                <div class="row g-3 justify-content-end">
                    <div class="col-md-4">
                        <label for="supervisor-overall-score" class="form-label">Overall Average Rating:</label>
                        <input type="number" class="form-control" id="supervisor-overall-score" value="" disabled>
                    </div>
                    <div class="col-md-4">
                        <label for="supervisor-faculty-overall-score" class="form-label">Faculty Score:</label>
                        <input type="number" class="form-control" id="supervisor-faculty-overall-score" value="" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="d-flex justify-content-end mt-4">
        <button type="button" class="btn btn-success" id="save-criterion-a">Save Criterion A</button> <!-- 📝 Change ID and Button Text -->
    </div>

    <!-- Remarks Modal -->
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

            // Hide Criterion Sections Initially if Evaluation Not Selected
            // 📝 Add logic here based on your evaluation selection mechanism
            // Example:
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
