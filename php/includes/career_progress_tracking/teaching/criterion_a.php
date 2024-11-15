<div class="tab-pane fade show active" id="criterion-a" role="tabpanel" aria-labelledby="tab-criterion-a">
    <h4>CRITERION A: Teaching Effectiveness (Max = 60 Points)</h4>
    <p>FACULTY PERFORMANCE. Enter average rating received by the faculty/semester.<br>  
        For newly appointed faculty from private HEI, LUCs, TESDA/DepEd schools 
        who still decided to proceed with the evaluation, put "0" in semesters with no student and supervisor's evaluation.</p>
    <div class="row">
        <!-- Student Evaluation Section -->
        <div class="col-md-12 mt-4">
            <h5>1.1 Student Evaluation (60%)</h5>
            <div class="mb-3 d-flex align-items-center">
                <label for="student-divisor" class="form-label me-2 mb-0 align-self-center">Number of Semesters to Deduct from Divisor (if applicable):</label>
                <select class="form-select col-auto w-auto" id="student-divisor">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                </select>
            </div>
            <div class="mb-3 d-flex align-items-center">
                <label for="student-reason" class="form-label me-2 mb-0 align-self-center">Reason for Reducing the Divisor:</label>
                <select class="form-select col-auto w-auto" id="student-reason">
                    <option value="">Select Option</option>
                    <option value="not_applicable">Not Applicable</option>
                    <option value="on_approved_study_leave">On Approved Study Leave</option>
                    <option value="on_approved_sabbatical_leave">On Approved Sabbatical Leave</option>
                    <option value="on_approved_maternity_leave">On Approved Maternity Leave</option>
                </select>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Evaluation Period</th>
                        <th>1st Semester Rating</th>
                        <th>2nd Semester Rating</th>
                        <th>Link to Evidence</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>AY 2019-2020</td>
                        <td><input type="number" class="form-control" value="0.00"></td>
                        <td><input type="number" class="form-control" value="0.00"></td>
                        <td><a href="#" target="_blank">Link to Evidence</a></td>
                        <td>
                            <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#remarksModal" 
                                    data-remarks1="Excellent performance in 1st semester of AY 2019-2020."
                                    data-remarks2="Good progress in 2nd semester of AY 2019-2020.">
                                View Remarks
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>AY 2020-2021</td>
                        <td><input type="number" class="form-control" value="0.00"></td>
                        <td><input type="number" class="form-control" value="0.00"></td>
                        <td><a href="#" target="_blank">Link to Evidence</a></td>
                        <td>
                            <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#remarksModal" 
                                    data-remarks1="Solid foundation in 1st semester of AY 2020-2021."
                                    data-remarks2="Significant improvement in 2nd semester of AY 2020-2021.">
                                View Remarks
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>AY 2021-2022</td>
                        <td><input type="number" class="form-control" value="0.00"></td>
                        <td><input type="number" class="form-control" value="0.00"></td>
                        <td><a href="#" target="_blank">Link to Evidence</a></td>
                        <td>
                            <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#remarksModal" 
                                    data-remarks1="Strong performance in 1st semester of AY 2021-2022."
                                    data-remarks2="Exceptional progress in 2nd semester of AY 2021-2022.">
                                View Remarks
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>AY 2022-2023</td>
                        <td><input type="number" class="form-control" value="0.00"></td>
                        <td><input type="number" class="form-control" value="0.00"></td>
                        <td><a href="#" target="_blank">Link to Evidence</a></td>
                        <td>
                            <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#remarksModal" 
                                    data-remarks1="Good start in 1st semester of AY 2022-2023."
                                    data-remarks2="Continued success in 2nd semester of AY 2022-2023.">
                                View Remarks
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Modal for Viewing Remarks -->
            <div class="modal fade" id="remarksModal" tabindex="-1" aria-labelledby="remarksModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="remarksModalLabel">Semester Remarks</h5>
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


            <div class="container-fluid">
                <div class="d-flex flex-column align-items-end">
                    <div class="mb-3 d-flex align-items-center">
                        <label for="student-overall-score" class="form-label me-2 mb-0 align-self-center">Overall Average Rating:</label>
                        <input type="number" class="form-control w-auto" id="student-overall-score" value="0.00">
                    </div>
                    <div class="mb-3 d-flex align-items-center">
                        <label for="faculty-overall-score" class="form-label me-2 mb-0 align-self-center">Faculty Score:</label>
                        <input type="number" class="form-control w-auto" id="faculty-overall-score" value="0.00">
                    </div>
                </div>
            </div>



        </div>
        <!-- Supervisor's Evaluation Section -->
        <div class="col-md-12 mt-4">
            <h5>1.2 Supervisor's Evaluation (40%)</h5>
            <div class="mb-3 d-flex align-items-center">
                <label for="supervisor-divisor" class="form-label me-2 mb-0 align-self-center">Number of Semesters to Deduct from Divisor (if applicable):</label>
                <select class="form-select col-auto w-auto" id="supervisor-divisor">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                </select>
            </div>
            <div class="mb-3 d-flex align-items-center">
                <label for="supervisor-reason" class="form-label me-2 mb-0 align-self-center">Reason for Reducing the Divisor:</label>
                <select class="form-control col-auto w-auto" id="supervisor-reason">
                    <option value="">Select Option</option>
                    <option value="not_applicable">Not Applicable</option>
                    <option value="on_approved_study_leave">On Approved Study Leave</option>
                    <option value="on_approved_sabbatical_leave">On Approved Sabbatical Leave</option>
                    <option value="on_approved_maternity_leave">On Approved Maternity Leave</option>
                </select>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Evaluation Period</th>
                        <th>1st Semester Rating</th>
                        <th>2nd Semester Rating</th>
                        <th>Link to Evidence</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>AY 2019-2020</td>
                        <td><input type="number" class="form-control" value="0.00"></td>
                        <td><input type="number" class="form-control" value="0.00"></td>
                        <td><a href="#" target="_blank">Link to Evidence</a></td>
                    </tr>
                    <tr>
                        <td>AY 2020-2021</td>
                        <td><input type="number" class="form-control" value="0.00"></td>
                        <td><input type="number" class="form-control" value="0.00"></td>
                        <td><a href="#" target="_blank">Link to Evidence</a></td>
                    </tr>
                    <tr>
                        <td>AY 2021-2022</td>
                        <td><input type="number" class="form-control" value="0.00"></td>
                        <td><input type="number" class="form-control" value="0.00"></td>
                        <td><a href="#" target="_blank">Link to Evidence</a></td>
                    </tr>
                    <tr>
                        <td>AY 2022-2023</td>
                        <td><input type="number" class="form-control" value="0.00"></td>
                        <td><input type="number" class="form-control" value="0.00"></td>
                        <td><a href="#" target="_blank">Link to Evidence</a></td>
                    </tr>
                </tbody>
            </table>
            <div class="container-fluid">
                <div class="d-flex flex-column align-items-end">
                    <div class="mb-3 d-flex align-items-center">
                        <label for="supervisor-overall-score" class="form-label me-2 mb-0 align-self-center">Overall Average Rating:</label>
                        <input type="number" class="form-control w-auto" id="supervisor-overall-score" value="0.00">
                    </div>
                    <div class="mb-3 d-flex align-items-center">
                        <label for="faculty-overall-score" class="form-label me-2 mb-0 align-self-center">Faculty Score:</label>
                        <input type="number" class="form-control w-auto" id="supervisor-faculty-overall-score" value="0.00">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="d-flex justify-content-end mt-3">
        <button type="button" class="btn btn-success" id="save-criterion-a">Save Criterion A</button>
    </div>
</div>