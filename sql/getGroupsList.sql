SELECT g.group_name, g.group_type, sg.is_main
FROM groups g
JOIN student_group sg ON g.grid = sg.group_id
JOIN students s ON sg.student_id = s.studid
WHERE s.first_name = ? AND s.last_name = ?