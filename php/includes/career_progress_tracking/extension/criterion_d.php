<!-- careerpath/php/includes/career_progress_tracking/extension/criterion_d.php -->
<div class="tab-pane fade" id="criterion-d" role="tabpanel" aria-labelledby="tab-criterion-d">
<h4 class="mb-4 pb-2 border-bottom border-3 border-success"><strong>CRITERION D - BONUS CRITERION (MAX = 20 POINTS)</strong></h4>
    
    <h5><strong>FOR ADMINISTRATIVE DESIGNATION</strong><br>  
    HIGHEST ADMINISTRATIVE DESIGNATION HELD FOR AT LEAST ONE YEAR WITH THE EVALUATION PERIOD
    </h5>

    <form id="criterion-d-form" enctype="multipart/form-data">
        <div class="row">
        <!-- Hidden Input for request_id -->
        <input type="hidden" id="request_id" name="request_id" value="" readonly>

                <!-- Responsive Table -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="administrative-designation-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" rowspan="2" class="align-middle text-center">No.</th>
                                <th scope="col" rowspan="2" class="align-middle text-center">Designation</th>
                                <th scope="col" rowspan="2" class="align-middle text-center">Effectivity Period<br>(mm/dd/yyyy to mm/dd/yyyy)</th>
                                <th scope="col" rowspan="2" class="align-middle text-center">Faculty Score</th>
                                <th scope="col" rowspan="2" class="align-middle text-center">Link to Evidence<br>from Google Drive</th>
                                <th scope="col" rowspan="2" class="align-middle text-center">Remarks</th>
                                <th scope="col" colspan="3" class="text-center">For Validator</th>
                            </tr>
                            <tr>
                                <th scope="col" class="text-center">Validation of Documents</th>
                                <th scope="col" class="text-center">Validated Score</th>
                                <th scope="col" class="text-center">Explanation for Non-Acceptance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Default Rows -->
                            <tr>
                                <td class="text-center">1</td>
                                <td>
                                    <select class="form-select" name="designation[]">
                                        <option value="President or OIC President">President or OIC President</option>
                                        <option value="Vice-President">Vice-President</option>
                                        <option value="Chancellor">Chancellor</option>
                                        <option value="Vice-Chancellor">Vice-Chancellor</option>
                                        <option value="Campus Director/Administrator/Head">Campus Director/Administrator/Head</option>
                                        <option value="Faculty Regent">Faculty Regent</option>
                                        <option value="Office Director">Office Director</option>
                                        <option value="University/College Secretary">University/College Secretary</option>
                                        <option value="Project Head">Project Head</option>
                                        <option value="Institution-level Committee Chair">Institution-level Committee Chair</option>
                                        <option value="Institution-level Committee Member">Institution-level Committee Member</option>
                                        <option value="Dean">Dean</option>
                                        <option value="Associate Dean">Associate Dean</option>
                                        <option value="College Secretary">College Secretary</option>
                                        <option value="Department Head">Department Head</option>
                                        <option value="Program Chair/Project Head">Program Chair/Project Head</option>
                                        <option value="Department-level Committee Chair">Department-level Committee Chair</option>
                                        <option value="Department-level Committee Member">Department-level Committee Member</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="effectivity_period[]" placeholder="mm/dd/yyyy to mm/dd/yyyy">
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="faculty_score[]" value="0.00" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="google_drive_link[]" placeholder="<Google Drive link>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="remarks[]" placeholder="">
                                </td>
                                <td>
                                    <select class="form-select" name="validation[]">
                                        <option value="ACCEPTABLE">ACCEPTABLE</option>
                                        <option value="NOT ACCEPTABLE">NOT ACCEPTABLE</option>
                                        <!-- Add more options as needed -->
                                    </select>
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="validated_score[]" value="0.00" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="explanation[]" placeholder="">
                                </td>
                            </tr>
                            <!-- You can add more rows similarly -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>TOTAL</strong></td>
                                <td>
                                    <input type="number" class="form-control" name="total_faculty_score" value="0.00" readonly>
                                </td>
                                <td colspan="2"></td>
                                <td></td>
                                <td>
                                    <input type="number" class="form-control" name="total_validated_score" value="0.00" readonly>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Add Row Button (if needed) -->
                <!-- <button type="button" class="btn btn-success mt-3 add-row" data-table-id="administrative-designation-table">Add Row</button> -->

            </div>
    <!-- Save Button -->
    <div class="d-flex justify-content-end mt-5">
        <button type="submit" class="btn btn-success" id="save-criterion-d">Save Criterion D</button>
    </div>
</div>

<!-- Delete Row Confirmation Modal (if needed) -->
<!-- Add other modals as required, similar to your existing code -->