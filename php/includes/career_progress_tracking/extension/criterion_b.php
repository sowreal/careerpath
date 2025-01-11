<<<<<<< Updated upstream
=======
<div class="tab-pane fade" id="criterion-b" role="tabpanel" aria-labelledby="tab-criterion-b">
    <h4 class="mb-4 pb-2 border-bottom border-3 border-success"><strong>CRITERION B - SERVICE TO THE COMMUNITY (MAX = 50 POINTS)</strong></h4>

    <form id="criterion-b-form">
        <input type="hidden" id="request_id_b" name="request_id" value="" readonly> 
        <div class="row">
            <!-- 1.1 QA Services -->
            <div class="col-12 mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">1.1 FOR SERVICES IN ACCREDITATION, EVALUATION, ASSESSMENT WORKS AND OTHER RELATED EDUCATION QA ACTIVITIES</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="qa-services-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Name of Agency/Organization</th>
                                <th scope="col">Appointment Period (Start)</th>
                                <th scope="col">Appointment Period (End)</th>
                                <th scope="col">QA-related Services Provided</th>
                                <th scope="col">Scope</th>
                                <th scope="col">No. of Deployment</th>
                                <th scope="col">Faculty Points</th>
                                <th scope="col">Link to Evidence from Google Drive</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <!-- Hidden input for qa_id -->
                                <td><input type="hidden" name="b1_1_qa_id_<?php echo $i; ?>" value="0" />
                                <input type="text" class="form-control" name="b1_1_qa_agency_<?php echo $i; ?>" /></td>
                                <td><input type="date" class="form-control" name="b1_1_qa_start_date_<?php echo $i; ?>" /></td>
                                <td><input type="date" class="form-control" name="b1_1_qa_end_date_<?php echo $i; ?>" /></td>
                                <td><input type="text" class="form-control" name="b1_1_qa_services_<?php echo $i; ?>" /></td>
                                <td>
                                    <select class="form-select" name="b1_1_qa_scope_<?php echo $i; ?>">
                                        <option value="">SELECT OPTION</option>
                                        <option value="Local">Local</option>
                                        <option value="International">International</option>
                                    </select>
                                </td>
                                <td><input type="number" class="form-control" name="b1_1_qa_deployment_<?php echo $i; ?>" /></td>
                                <td><input type="number" class="form-control" name="b1_1_qa_faculty_points_<?php echo $i; ?>" value="0.00" readonly /></td>
                                <td><input type="url" class="form-control" name="b1_1_qa_evidence_link_<?php echo $i; ?>" placeholder="https://drive.google.com/..." /></td>
                                <td><button type="button" class="btn btn-primary btn-sm view-remarks" data-first-remark="" data-second-remark="">View Remarks</button></td>
                                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6"></td>
                                <td><strong>Total Points:</strong></td>
                                <td>
                                    <input type="number" class="form-control" id="b1_1_total_points" name="b1_1_total_points" value="0.00" readonly>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <button type="button" class="btn btn-success mt-3 add-row" data-table-id="qa-services-table">Add Row</button>
                </div>
            </div>

            <!-- 1.2 Judge/Examiner Services -->
            <div class="col-12 mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">1.2 SERVICES AS JUDGE OR EXAMINER FOR LOCAL/INTERNATIONAL RESEARCH AWARDS AND ACADEMIC COMPETITIONS</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="judge-examiner-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Title of the Event/Activity</th>
                                <th scope="col">Organizer</th>
                                <th scope="col">Date of Event (mm/dd/yyyy)</th>
                                <th scope="col">Nature of the Award</th>
                                <th scope="col">Venue</th>
                                <th scope="col">Faculty Points</th>
                                <th scope="col">Link to Evidence from Google Drive</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <!-- Hidden input for judge_id -->
                                <td><input type="hidden" name="b1_2_judge_id_<?php echo $i; ?>" value="0" />
                                <input type="text" class="form-control" name="b1_2_judge_event_title_<?php echo $i; ?>" /></td>
                                <td><input type="text" class="form-control" name="b1_2_judge_organizer_<?php echo $i; ?>" /></td>
                                <td><input type="date" class="form-control" name="b1_2_judge_event_date_<?php echo $i; ?>" /></td>
                                <td>
                                    <select class="form-select" name="b1_2_judge_award_nature_<?php echo $i; ?>">
                                        <option value="">SELECT OPTION</option>
                                        <option value="Academic Competition">Academic Competition</option>
                                        <option value="Research Award">Research Award</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="b1_2_judge_venue_<?php echo $i; ?>" /></td>
                                <td><input type="number" class="form-control" name="b1_2_judge_faculty_points_<?php echo $i; ?>" value="0.00" readonly /></td>
                                <td><input type="url" class="form-control" name="b1_2_judge_evidence_link_<?php echo $i; ?>" placeholder="https://drive.google.com/..." /></td>
                                <td><button type="button" class="btn btn-primary btn-sm view-remarks" data-first-remark="" data-second-remark="">View Remarks</button></td>
                                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5"></td>
                                <td><strong>Total Points:</strong></td>
                                <td>
                                    <input type="number" class="form-control" id="b1_2_total_points" name="b1_2_total_points" value="0.00" readonly>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <button type="button" class="btn btn-success mt-3 add-row" data-table-id="judge-examiner-table">Add Row</button>
                </div>
            </div>

            <!-- 1.3 Consultant/Expert Services -->
            <div class="col-12 mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">1.3 FOR SERVICES AS A SHORT-TERM CONSULTANT/EXPERT</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="consultant-expert-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Title of the Project/Consultancy</th>
                                <th scope="col">Name of Organization</th>
                                <th scope="col">Period of Engagement (Start)</th>
                                <th scope="col">Period of Engagement (End)</th>
                                <th scope="col">Scope</th>
                                <th scope="col">Role</th>
                                <th scope="col">Faculty Points</th>
                                <th scope="col">Link to Evidence from Google Drive</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 7; $i++): ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <!-- Hidden input for consultant_id -->
                                <td><input type="hidden" name="b1_3_consultant_id_<?php echo $i; ?>" value="0" />
                                <input type="text" class="form-control" name="b1_3_consultant_project_title_<?php echo $i; ?>" /></td>
                                <td><input type="text" class="form-control" name="b1_3_consultant_organization_<?php echo $i; ?>" /></td>
                                <td><input type="date" class="form-control" name="b1_3_consultant_start_date_<?php echo $i; ?>" /></td>
                                <td><input type="date" class="form-control" name="b1_3_consultant_end_date_<?php echo $i; ?>" /></td>
                                <td>
                                    <select class="form-select" name="b1_3_consultant_scope_<?php echo $i; ?>">
                                        <option value="">SELECT OPTION</option>
                                        <option value="Local">Local</option>
                                        <option value="International">International</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="b1_3_consultant_role_<?php echo $i; ?>" /></td>
                                <td><input type="number" class="form-control" name="b1_3_consultant_faculty_points_<?php echo $i; ?>" value="0.00" readonly /></td>
                                <td><input type="url" class="form-control" name="b1_3_consultant_evidence_link_<?php echo $i; ?>" placeholder="https://drive.google.com/..." /></td>
                                <td><button type="button" class="btn btn-primary btn-sm view-remarks" data-first-remark="" data-second-remark="">View Remarks</button></td>
                                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6"></td>
                                <td><strong>Total Points:</strong></td>
                                <td>
                                    <input type="number" class="form-control" id="b1_3_total_points" name="b1_3_total_points" value="0.00" readonly>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <button type="button" class="btn btn-success mt-3 add-row" data-table-id="consultant-expert-table">Add Row</button>
                </div>
            </div>

            <!-- 1.4 Media Services -->
            <div class="col-12 mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">1.4 SERVICES THROUGH MEDIA AS:</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="media-services-table">
                        <!-- Table headers for 1.4.1 to 1.4.4 -->
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Name of Media</th>
                                <th scope="col">Title of Newspaper Column or TV/Radio Program</th>
                                <th scope="col">Period of Engagement (mm/dd/yyyy to mm/dd/yyyy)</th>
                                <th scope="col">No. of engagements</th>
                                <th scope="col">Faculty Points</th>
                                <th scope="col">Link to Evidence from Google Drive</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- 1.4.1 Writer of occasional newspaper column -->
                            <tr>
                                <td>1</td>
                                 <!-- Hidden input for media_id -->
                                 <td><input type="hidden" name="b1_4_media_id_1" value="0" />
                                <td>Writer of occasional newspaper column</td>
                                <td><input type="text" class="form-control" name="b1_4_media_occasional_media_name" /></td>
                                <td><input type="text" class="form-control" name="b1_4_media_occasional_column_title" /></td>
                                <td><input type="text" class="form-control" name="b1_4_media_occasional_engagement_period" placeholder="mm/dd/yyyy to mm/dd/yyyy" /></td>
                                <td><input type="number" class="form-control" name="b1_4_media_occasional_engagements" /></td>
                                <td><input type="number" class="form-control" name="b1_4_media_occasional_faculty_points" value="0.00" readonly /></td>
                                <td><input type="url" class="form-control" name="b1_4_media_occasional_evidence_link" placeholder="https://drive.google.com/..." /></td>
                                <td><button type="button" class="btn btn-primary btn-sm view-remarks" data-first-remark="" data-second-remark="">View Remarks</button></td>
                                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                            </tr>
                            <!-- 1.4.2 Writer of regular newspaper column -->
                            <tr>
                                <td>2</td>
                                <!-- Hidden input for media_id -->
                                <td><input type="hidden" name="b1_4_media_id_2" value="0" />
                                <td>Writer of regular newspaper column</td>
                                <td><input type="text" class="form-control" name="b1_4_media_regular_media_name" /></td>
                                <td><input type="text" class="form-control" name="b1_4_media_regular_column_title" /></td>
                                <td><input type="text" class="form-control" name="b1_4_media_regular_engagement_period" placeholder="mm/dd/yyyy to mm/dd/yyyy" /></td>
                                <td><input type="number" class="form-control" name="b1_4_media_regular_engagements" /></td>
                                <td><input type="number" class="form-control" name="b1_4_media_regular_faculty_points" value="0.00" readonly /></td>
                                <td><input type="url" class="form-control" name="b1_4_media_regular_evidence_link" placeholder="https://drive.google.com/..." /></td>
                                <td><button type="button" class="btn btn-primary btn-sm view-remarks" data-first-remark="" data-second-remark="">View Remarks</button></td>
                                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                            </tr>
                            <!-- 1.4.3 Host of TV/Radio Program -->
                            <tr>
                                <td>3</td>
                                <!-- Hidden input for media_id -->
                                <td><input type="hidden" name="b1_4_media_id_3" value="0" />
                                <td>Host of TV/Radio Program</td>
                                <td><input type="text" class="form-control" name="b1_4_media_host_media_name" /></td>
                                <td><input type="text" class="form-control" name="b1_4_media_host_program_title" /></td>
                                <td><input type="text" class="form-control" name="b1_4_media_host_engagement_period" placeholder="mm/dd/yyyy to mm/dd/yyyy" /></td>
                                <td><input type="number" class="form-control" name="b1_4_media_host_engagements" /></td>
                                <td><input type="number" class="form-control" name="b1_4_media_host_faculty_points" value="0.00" readonly /></td>
                                <td><input type="url" class="form-control" name="b1_4_media_host_evidence_link" placeholder="https://drive.google.com/..." /></td>
                                <td><button type="button" class="btn btn-primary btn-sm view-remarks" data-first-remark="" data-second-remark="">View Remarks</button></td>
                                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                            </tr>
                            <!-- 1.4.4 Guesting as technical expert -->
                            <tr>
                                <td>4</td>
                                <!-- Hidden input for media_id -->
                                <td><input type="hidden" name="b1_4_media_id_4" value="0" />
                                <td>Guesting as technical expert for TV or radio program/print media/online media</td>
                                <td><input type="text" class="form-control" name="b1_4_media_guest_media_name" /></td>
                                <td><input type="text" class="form-control" name="b1_4_media_guest_program_title" /></td>
                                <td><input type="text" class="form-control" name="b1_4_media_guest_engagement_period" placeholder="mm/dd/yyyy to mm/dd/yyyy" /></td>
                                <td><input type="number" class="form-control" name="b1_4_media_guest_engagements" /></td>
                                <td><input type="number" class="form-control" name="b1_4_media_guest_faculty_points" value="0.00" readonly /></td>
                                <td><input type="url" class="form-control" name="b1_4_media_guest_evidence_link" placeholder="https://drive.google.com/..." /></td>
                                <td><button type="button" class="btn btn-primary btn-sm view-remarks" data-first-remark="" data-second-remark="">View Remarks</button></td>
                                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5"></td>
                                <td><strong>Total Points:</strong></td>
                                <td>
                                    <input type="number" class="form-control" id="b1_4_total_points" name="b1_4_total_points" value="0.00" readonly>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <button type="button" class="btn btn-success mt-3 add-row" data-table-id="media-services-table">Add Row</button>
                </div>
            </div>

            <!-- 1.5 Training/Seminar/Workshop Participation -->
            <div class="col-12 mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">1.5 FOR EVERY HOUR OF TRAINING COURSE, SEMINAR, WORKSHOP CONDUCTED AS A RESOURCE PERSON, CONVENOR, FACILITATOR, MODERATOR, KEYNOTE/PLENARY SPEAKER OR PANELIST</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="training-participation-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Title of the Training</th>
                                <th scope="col">Type of Participation</th>
                                <th scope="col">Organizer</th>
                                <th scope="col">Period of Engagement (Start Date)</th>
                                <th scope="col">Period of Engagement (End Date)</th>
                                <th scope="col">Scope</th>
                                <th scope="col">Total No. of Hours</th>
                                <th scope="col">Faculty Points</th>
                                <th scope="col">Link to Evidence from Google Drive</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 9; $i++): ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <!-- Hidden input for training_id -->
                                <td><input type="hidden" name="b1_5_training_id_<?php echo $i; ?>" value="0" />
                                <input type="text" class="form-control" name="b1_5_training_title_<?php echo $i; ?>" /></td>
                                <td>
                                    <select class="form-select" name="b1_5_training_participation_type_<?php echo $i; ?>">
                                        <option value="">SELECT OPTION</option>
                                        <option value="Resource Person">Resource Person</option>
                                        <option value="Convenor">Convenor</option>
                                        <option value="Facilitator">Facilitator</option>
                                        <option value="Moderator">Moderator</option>
                                        <option value="Keynote/Plenary Speaker">Keynote/Plenary Speaker</option>
                                        <option value="Panelist">Panelist</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="b1_5_training_organizer_<?php echo $i; ?>" /></td>
                                <td><input type="date" class="form-control" name="b1_5_training_start_date_<?php echo $i; ?>" /></td>
                                <td><input type="date" class="form-control" name="b1_5_training_end_date_<?php echo $i; ?>" /></td>
                                <td>
                                    <select class="form-select" name="b1_5_training_scope_<?php echo $i; ?>">
                                        <option value="">SELECT OPTION</option>
                                        <option value="Local">Local</option>
                                        <option value="International">International</option>
                                        <!-- Add more options if needed -->
                                    </select>
                                </td>
                                <td><input type="number" class="form-control" name="b1_5_training_hours_<?php echo $i; ?>" /></td>
                                <td><input type="number" class="form-control" name="b1_5_training_faculty_points_<?php echo $i; ?>" value="0.00" readonly /></td>
                                <td><input type="url" class="form-control" name="b1_5_training_evidence_link_<?php echo $i; ?>" placeholder="https://drive.google.com/..." /></td>
                                <td><button type="button" class="btn btn-primary btn-sm view-remarks" data-first-remark="" data-second-remark="">View Remarks</button></td>
                                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7"></td>
                                <td><strong>Total Points:</strong></td>
                                <td>
                                    <input type="number" class="form-control" id="b1_5_total_points" name="b1_5_total_points" value="0.00" readonly>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <button type="button" class="btn btn-success mt-3 add-row" data-table-id="training-participation-table">Add Row</button>
                </div>
            </div>

            <!-- 2.1 Community Projects -->
            <div class="col-12 mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">2.1 FOR EVERY SERVICE-ORIENTED PROJECT IN THE COMMUNITY PARTICIPATED, INCLUDING ADVOCACY INITIATIVES</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="community-projects-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Name of Community Extension Activity</th>
                                <th scope="col">Name of Community</th>
                                <th scope="col">No. of Beneficiaries</th>
                                <th scope="col">Role</th>
                                <th scope="col">Activity Date (mm/dd/yyyy)</th>
                                <th scope="col">Faculty Points</th>
                                <th scope="col">Link to Evidence from Google Drive</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <!-- Hidden input for community_id -->
                                <td><input type="hidden" name="b2_1_community_id_<?php echo $i; ?>" value="0" />
                                <input type="text" class="form-control" name="b2_1_community_activity_name_<?php echo $i; ?>" /></td>
                                <td><input type="text" class="form-control" name="b2_1_community_name_<?php echo $i; ?>" /></td>
                                <td><input type="number" class="form-control" name="b2_1_community_beneficiaries_<?php echo $i; ?>" /></td>
                                <td>
                                    <select class="form-select" name="b2_1_community_role_<?php echo $i; ?>">
                                        <option value="">SELECT OPTION</option>
                                        <option value="Head">Head</option>
                                        <option value="Participant">Participant</option>
                                    </select>
                                </td>
                                <td><input type="date" class="form-control" name="b2_1_community_activity_date_<?php echo $i; ?>" /></td>
                                <td><input type="number" class="form-control" name="b2_1_community_faculty_points_<?php echo $i; ?>" value="0.00" readonly /></td>
                                <td><input type="url" class="form-control" name="b2_1_community_evidence_link_<?php echo $i; ?>" placeholder="https://drive.google.com/..." /></td>
                                <td><button type="button" class="btn btn-primary btn-sm view-remarks" data-first-remark="" data-second-remark="">View Remarks</button></td>
                                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5"></td>
                                <td><strong>Total Points:</strong></td>
                                <td>
                                    <input type="number" class="form-control" id="b2_1_total_points" name="b2_1_total_points" value="0.00" readonly>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <button type="button" class="btn btn-success mt-3 add-row" data-table-id="community-projects-table">Add Row</button>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="d-flex justify-content-end mt-5">
            <button type="button" class="btn btn-success" id="save-criterion-b">Save Criterion B</button>
        </div>
    </form>
     <!-- MODALS -->
        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteRowModal" tabindex="-1" aria-labelledby="deleteRowModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger" id="deleteRowModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this row? This action cannot be undone.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirm-delete-row">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Success Modal -->
        <div class="modal fade" id="deleteSuccessModal" tabindex="-1" aria-labelledby="deleteSuccessModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="deleteSuccessModalLabel">Deletion Successful</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        The row has been successfully deleted.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Error Modal -->
        <div class="modal fade" id="deleteErrorModal" tabindex="-1" aria-labelledby="deleteErrorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger" id="deleteErrorModalLabel">Deletion Failed</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Error message will be injected here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Confirmation Modal -->
        <div class="modal fade" id="saveConfirmationModal" tabindex="-1" aria-labelledby="saveConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="saveConfirmationModalLabel">Save Successful</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        KRA3 Criterion A has been saved successfully!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Error Modal -->
        <div class="modal fade" id="saveErrorModal" tabindex="-1" aria-labelledby="saveErrorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger" id="saveErrorModalLabel">Save Failed</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Dynamic error message will be inserted here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
</div>

<!-- Include KRA3 Criterion B-specific JS -->
<script src="<?php echo BASE_URL; ?>/php/includes/career_progress_tracking/extension/js/kra3_criterion_b.js"></script>
>>>>>>> Stashed changes
