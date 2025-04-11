<?php
require_once 'config/database.php';

// Adăugare task nou
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task'])) {
    $task = $_POST['task'];
    $stmt = $pdo->prepare("INSERT INTO todos (task) VALUES (?)");
    $stmt->execute([$task]);
    header("Location: index.php");
    exit();
}

// Marcare task ca completat
if (isset($_GET['complete']) && is_numeric($_GET['complete'])) {
    $id = $_GET['complete'];
    $stmt = $pdo->prepare("UPDATE todos SET status = 'completed' WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit();
}

// Ștergere task
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM todos WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit();
}

// Obținere toate task-urile
$stmt = $pdo->query("SELECT * FROM todos ORDER BY created_at DESC");
$todos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listă de Sarcini</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .todo-form {
            margin-bottom: 20px;
        }
        .todo-input {
            padding: 8px;
            width: 70%;
            margin-right: 10px;
        }
        .todo-button {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .todo-list {
            list-style: none;
            padding: 0;
        }
        .todo-item {
            padding: 10px;
            margin: 5px 0;
            background-color: #f9f9f9;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .completed {
            text-decoration: line-through;
            color: #888;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .delete-btn {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .complete-btn {
            background-color: #2196F3;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        /* Stilizare pentru pop-up */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1001;
            max-width: 400px;
            width: 90%;
        }

        .modal-title {
            font-size: 1.2em;
            margin-bottom: 15px;
            color: #333;
        }

        .modal-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .modal-button {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        .modal-cancel {
            background-color: #e0e0e0;
            color: #333;
        }

        .modal-confirm {
            background-color: #f44336;
            color: white;
        }

        .modal-button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <h1>Listă de Sarcini</h1>
    
    <form class="todo-form" method="POST">
        <input type="text" name="task" class="todo-input" placeholder="Adaugă o sarcină nouă..." required>
        <button type="submit" class="todo-button">Adaugă</button>
    </form>

    <ul class="todo-list">
        <?php foreach ($todos as $todo): ?>
            <li class="todo-item <?php echo $todo['status'] === 'completed' ? 'completed' : ''; ?>">
                <span><?php echo htmlspecialchars($todo['task']); ?></span>
                <div class="actions">
                    <?php if ($todo['status'] !== 'completed'): ?>
                        <a href="?complete=<?php echo $todo['id']; ?>" class="complete-btn">Completează</a>
                    <?php endif; ?>
                    <button onclick="showDeleteModal(<?php echo $todo['id']; ?>)" class="delete-btn">Șterge</button>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Pop-up de confirmare -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal">
            <div class="modal-title">Confirmare ștergere</div>
            <p>Sigur doriți să ștergeți această sarcină?</p>
            <div class="modal-buttons">
                <button class="modal-button modal-cancel" onclick="hideDeleteModal()">Anulează</button>
                <button class="modal-button modal-confirm" onclick="confirmDelete()">Șterge</button>
            </div>
        </div>
    </div>

    <script>
        let currentDeleteId = null;

        function showDeleteModal(id) {
            currentDeleteId = id;
            document.getElementById('deleteModal').style.display = 'block';
        }

        function hideDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
            currentDeleteId = null;
        }

        function confirmDelete() {
            if (currentDeleteId) {
                window.location.href = `?delete=${currentDeleteId}`;
            }
        }

        // Închide pop-up-ul când se face click în afara lui
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideDeleteModal();
            }
        });

        // Închide pop-up-ul când se apasă tasta Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hideDeleteModal();
            }
        });
    </script>
</body>
</html> 