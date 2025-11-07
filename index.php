<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кадровый учет сотрудников организации</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Кадровый учет сотрудников организации</h1>

    <main class="container">
        <?php
        require_once 'config/db.php';

        $sql = "SELECT 
                    e.last_name,
                    e.first_name,
                    e.middle_name,
                    e.birth_date,
                    e.passport,
                    e.phone,
                    e.email,
                    e.address,
                    d.name as department_name,
                    p.title as position_title,
                    e.salary,
                    e.hire_date
                FROM employees e
                JOIN departments d ON e.department_id = d.id
                JOIN positions p ON e.position_id = p.id
                ORDER BY e.last_name, e.first_name";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
        ?>
        <table class="employees-table">
            <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Дата рождения</th>
                    <th>Паспорт</th>
                    <th>Контакты</th>
                    <th>Адрес</th>
                    <th>Отдел</th>
                    <th>Должность</th>
                    <th>Зарплата</th>
                    <th>Дата приема</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['last_name'] . ' ' . $row['first_name'] . ' ' . $row['middle_name']); ?></td>
                    <td><?php echo date('d.m.Y', strtotime($row['birth_date'])); ?></td>
                    <td class="passport">
                        <?php 
                        $passport = htmlspecialchars($row['passport']);
                        if (strlen($passport) >= 4) {
                            echo substr($passport, 0, 4) . ' ' . substr($passport, 4);
                        } else {
                            echo $passport;
                        }
                        ?>
                    </td>
                    <td class="contacts">
                        <div class="phone"><?php echo htmlspecialchars($row['phone']); ?></div>
                        <div class="email"><?php echo htmlspecialchars($row['email']); ?></div>
                    </td>
                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                    <td><?php echo htmlspecialchars($row['department_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['position_title']); ?></td>
                    <td class="salary"><?php echo number_format($row['salary'], 0, '', ' '); ?> ₽</td>
                    <td><?php echo date('d.m.Y', strtotime($row['hire_date'])); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php
        } else {
            echo '<p class="no-data">Нет данных о сотрудниках</p>';
        }
        ?>
    </main>
</body>
</html>