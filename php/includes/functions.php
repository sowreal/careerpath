<?php
/**
 * Logs changes to the profile_change_logs table.
 *
 * @param PDO $conn Database connection.
 * @param int $userId ID of the user whose profile was changed.
 * @param int $changedBy ID of the user who made the change.
 * @param array $changedFields Associative array of changed fields.
 * @param string $action Description of the action.
 *
 * @return void
 */
function logChange($conn, $userId, $changedBy, $changedFields, $action = 'Updated') {
    // Prepare the changed_fields JSON
    $log_fields = [
        'action' => $action,
        'fields' => $changedFields
    ];
    $changed_fields_json = json_encode($log_fields);

    // Insert into profile_change_logs
    $sql = "INSERT INTO profile_change_logs (user_id, changed_by, changed_fields) VALUES (:user_id, :changed_by, :changed_fields)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':changed_by', $changedBy, PDO::PARAM_INT);
    $stmt->bindParam(':changed_fields', $changed_fields_json, PDO::PARAM_STR);
    $stmt->execute();
}

