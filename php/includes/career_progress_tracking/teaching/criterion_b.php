<?php
// careerpath/php/includes/career_progress_tracking/teaching/criterion_b.php

// Define Variables
$criterion_id = 'criterion-b';
$isActive = false;
$criterion_title = 'Curriculum & Material Development';
$max_points = 50;
$performance_label = 'CURRICULUM DEVELOPMENT';
$performance_description = 'Detail the development and improvement of course materials.';
$additional_instructions = 'Provide documentation for all approved curriculum changes.';
$evaluation_section_title = 'Student Evaluation';
$evaluation_percentage = 50;

// Table Columns (Different from Criterion A)
$table_columns = ["Evaluation Period", "Material Developed", "Impact", "Link to Evidence", "Remarks", "Additional Notes"];

// Evaluation Periods and Remarks
$evaluation_periods = [
    [
        'name' => 'AY 2019-2020',
        'ratings' => ['Course Syllabus', 'High'],
        'remarks1' => 'Developed comprehensive syllabi for all courses.',
        'remarks2' => 'Positive feedback from students.'
    ],
    // Add more periods as needed
];

$include_remarks = true;
$can_manage_rows = ($_SESSION['role'] === 'HR'); // Can handle rows

// Include Template
require_once 'criterion_template.php';
?>
