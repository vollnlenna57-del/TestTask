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

        $dept_filter = $_GET['department'] ?? '';
        $pos_filter = $_GET['position'] ?? '';
        $search_query = $_GET['search'] ?? '';

        $sql = "SELECT 
                    e.id,
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
                JOIN positions p ON e.position_id = p.id";

        $where = [];
        if ($dept_filter) $where[] = "e.department_id = " . (int)$dept_filter;
        if ($pos_filter) $where[] = "e.position_id = " . (int)$pos_filter;

        if ($search_query) {
            $search_condition = "CONCAT(e.last_name, ' ', e.first_name, ' ', e.middle_name) LIKE ?";
            $where[] = $search_condition;
        }

        if ($where) $sql .= " WHERE " . implode(" AND ", $where);

        $sql .= " ORDER BY e.last_name, e.first_name";

        $stmt = $conn->prepare($sql);

        if ($search_query) {
            $search_param = "%" . $search_query . "%";
            $stmt->bind_param("s", $search_param);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        ?>

        <div class="filters">
            <form method="GET" class="filter-form">
                <div class="search-group">
                <input type="text" 
                   name="search" 
                   class="search-input" 
                   placeholder="Поиск сотрудника по ФИО..." 
                   value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                </div>
                <select name="department" class="filter-select">
                    <option value="">Все отделы</option>
                    <?php 
                    $depts = $conn->query("SELECT id, name FROM departments ORDER BY name");
                    while($dept = $depts->fetch_assoc()): ?>
                        <option value="<?php echo $dept['id']; ?>" 
                            <?php echo $dept_filter == $dept['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($dept['name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <select name="position" class="filter-select">
                    <option value="">Все должности</option>
                    <?php 
                    $positions = $conn->query("SELECT id, title FROM positions ORDER BY title");
                    while($pos = $positions->fetch_assoc()): ?>
                        <option value="<?php echo $pos['id']; ?>" 
                            <?php echo $pos_filter == $pos['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($pos['title']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <button type="submit" class="filter-btn">Фильтровать</button>
                <a href="?" class="reset-btn">Сбросить</a>
            </form>
        </div>

        <?php
        if ($result && $result->num_rows > 0) {
        ?>
        <a href="employee_form.php" class="btn-add">Добавить сотрудника</a>
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
                    <td> <a href="employee_form.php?id=<?php echo $row['id']; ?>" class="btn-edit">Редактировать</a> </td>
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