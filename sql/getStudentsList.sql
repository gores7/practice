SELECT s.first_name, s.last_name, g.group_name
FROM students s
JOIN student_group sg ON s.studid = sg.student_id
JOIN groups g ON sg.group_id = g.grid
WHERE g.group_name = ?