<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($_GET['id']) ? 'Редактировать' : 'Добавить'; ?> сотрудника</title>
    <link rel="stylesheet" href="css/styles.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const passportInput = document.querySelector('input[name="passport"]');
            const phoneInput = document.querySelector('input[name="phone"]');

            passportInput.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '').slice(0, 10);
                if (this.value.length > 4)
                    this.value = this.value.slice(0, 4) + ' ' + this.value.slice(4);
            });

            phoneInput.addEventListener('input', function() {
                let x = this.value.replace(/\D/g, '').slice(0, 11);
                let formatted = '+7 ';
                if (x.length > 1) formatted += '(' + x.slice(1, 4);
                if (x.length >= 4) formatted += ') ' + x.slice(4, 7);
                if (x.length >= 7) formatted += '-' + x.slice(7, 9);
                if (x.length >= 9) formatted += '-' + x.slice(9, 11);
                this.value = formatted;
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <?php
        require_once 'config/db.php';
        $employee = null;
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $sql = "SELECT * FROM employees WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $employee = $stmt->get_result()->fetch_assoc();
        }
        ?>
        
        <form action="save_employee.php" method="POST" class="employee-form">
            <?php if ($employee): ?>
                <input type="hidden" name="id" value="<?php echo $employee['id']; ?>">
            <?php endif; ?>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Фамилия</label>
                    <input type="text" name="last_name" value="<?php echo $employee['last_name'] ?? ''; ?>" required>
                </div>
                <div class="form-group">
                    <label>Имя</label>
                    <input type="text" name="first_name" value="<?php echo $employee['first_name'] ?? ''; ?>" required>
                </div>
                <div class="form-group">
                    <label>Отчество</label>
                    <input type="text" name="middle_name" value="<?php echo $employee['middle_name'] ?? ''; ?>">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Дата рождения</label>
                    <input type="date" name="birth_date" value="<?php echo $employee['birth_date'] ?? ''; ?>" required>
                </div>
                <div class="form-group">
                    <label>Паспорт (серия номер)</label>
                    <input type="text" name="passport" pattern="\d{4}\s?\d{6}" 
                    title="Введите все 10 цифр серии и номера паспорта"
                           value="<?php echo $employee['passport'] ?? ''; ?>" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Телефон</label>
                    <input type="text" name="phone" pattern="\+7\s?\(?\d{3}\)?\s?\d{3}-?\d{2}-?\d{2}" 
                    title="Введите полностью номер телефона сотрудника"
                           value="<?php echo $employee['phone'] ?? ''; ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo $employee['email'] ?? ''; ?>" placeholder="ivanov@company.ru">
                </div>
            </div>
            
            <div class="form-group">
                <label>Адрес</label>
                <textarea name="address" required><?php echo $employee['address'] ?? ''; ?></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Отдел</label>
                    <select name="department_id" required>
                        <option value="">Выберите отдел</option>
                        <?php
                        $depts = $conn->query("SELECT id, name FROM departments ORDER BY name");
                        while($dept = $depts->fetch_assoc()): ?>
                            <option value="<?php echo $dept['id']; ?>" 
                                <?php echo ($employee['department_id'] ?? '') == $dept['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($dept['name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Должность</label>
                    <select name="position_id" required>
                        <option value="">Выберите должность</option>
                        <?php
                        $positions = $conn->query("SELECT id, title FROM positions ORDER BY title");
                        while($pos = $positions->fetch_assoc()): ?>
                            <option value="<?php echo $pos['id']; ?>" 
                                <?php echo ($employee['position_id'] ?? '') == $pos['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($pos['title']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Зарплата</label>
                    <input type="number" name="salary" value="<?php echo $employee['salary'] ?? ''; ?>" required min="0" step="1000">
                </div>
                <div class="form-group">
                    <label>Дата приема</label>
                    <input type="date" name="hire_date" value="<?php echo $employee['hire_date'] ?? ''; ?>" required>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-save">Сохранить</button>
                <a href="index.php" class="btn-back">Назад</a>
            </div>
        </form>
    </div>
</body>
</html>