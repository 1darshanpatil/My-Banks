<?php
$home_dir = getenv('HOME') ?: '/tmp';
$data_file = $home_dir . "/family_data.json";
function load_data() {
    global $data_file;
    if (file_exists($data_file)) {
        $data = file_get_contents($data_file);
        return json_decode($data, true);
    }
    return [];
}
function save_data($data) {
    global $data_file;
    file_put_contents($data_file, json_encode($data, JSON_PRETTY_PRINT));
}


function add_user($name) {
    $data = load_data();
    $name = strtolower(trim($name)); 
    if (!isset($data[$name])) {
        $data[$name] = []; 
        save_data($data);
    }
}
function remove_user($name) {
    $data = load_data();
    $name = strtolower(trim($name)); 
    if (isset($data[$name])) {
        unset($data[$name]);
        save_data($data);
    }
}
function add_bank($user, $bank) {
    $data = load_data();
    $user = strtolower(trim($user));
    $bank = strtoupper(trim($bank)); 
    if (isset($data[$user])) {
        $data[$user][$bank] = 0; 
        save_data($data);
    }
}
function update_bank_name($user, $old_bank, $new_bank) {
    $data = load_data();
    $user = strtolower(trim($user));
    $old_bank = strtoupper(trim($old_bank)); 
    $new_bank = strtoupper(trim($new_bank)); 
    if (isset($data[$user][$old_bank])) {
        $data[$user][$new_bank] = $data[$user][$old_bank]; 
        unset($data[$user][$old_bank]); 
        save_data($data);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_banks') {
    $user = strtolower(trim($_GET['user'] ?? ''));
    $data = load_data();
    if (isset($data[$user])) {
        echo json_encode(array_keys($data[$user]));
    } else {
        echo json_encode([]);
    }
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'add_user') {
        add_user($_POST['person_name']);
    } elseif ($action === 'remove_user') {
        remove_user($_POST['person_name']);
    } elseif ($action === 'add_bank') {
        add_bank($_POST['person_name'], $_POST['bank_name']);
    } elseif ($action === 'update_bank_name') {
        update_bank_name($_POST['person_name'], $_POST['old_bank_name'], $_POST['new_bank_name']);
    }

    header("Location: user_script.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User and Bank Management</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function updateForm() {
            const action = document.getElementById("main_action").value;
            const addUserForm = document.getElementById("add_user_form");
            const addBankForm = document.getElementById("add_bank_form");
            const removeUserForm = document.getElementById("remove_user_form");
            const updateBankForm = document.getElementById("update_bank_form");
            addUserForm.style.display = "none";
            addBankForm.style.display = "none";
            removeUserForm.style.display = "none";
            updateBankForm.style.display = "none";
            if (action === "add_user") {
                addUserForm.style.display = "block";
            } else if (action === "add_bank") {
                addBankForm.style.display = "block";
            } else if (action === "remove_user") {
                removeUserForm.style.display = "block";
            } else if (action === "update_bank_name") {
                updateBankForm.style.display = "block";
            }
        }

        function loadBanks(userSelect, bankSelectId) {
            const user = userSelect.value;
            const bankDropdown = document.getElementById(bankSelectId);
            bankDropdown.innerHTML = '<option value="">Select Bank</option>'; 

            if (user) {
                fetch("user_script.php?action=get_banks&user=" + encodeURIComponent(user))
                    .then(response => response.json())
                    .then(banks => {
                        banks.forEach(bank => {
                            const option = document.createElement("option");
                            option.value = bank;
                            option.textContent = bank.charAt(0).toUpperCase() + bank.slice(1);
                            bankDropdown.appendChild(option);
                        });
                    });
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>User and Bank Management</h1>
        <div class="card">
            <h2>Select Action</h2>
            <select id="main_action" onchange="updateForm()" required>
                <option value="">Select Action</option>
                <option value="add_user">Add User</option>
                <option value="add_bank">Add Bank Name</option>
                <option value="remove_user">Remove User</option>
                <option value="update_bank_name">Update Bank Name</option>
            </select>
        </div>
        <div id="add_user_form" class="card" style="display: none;">
            <h2>Add User</h2>
            <form method="POST" action="user_script.php">
                <input type="hidden" name="action" value="add_user">
                <label for="person_name_add">User Name</label>
                <input type="text" id="person_name_add" name="person_name" required>
                <button type="submit" class="btn btn-success">Add User</button>
            </form>
        </div>
        <div id="add_bank_form" class="card" style="display: none;">
            <h2>Add Bank Name</h2>
            <form method="POST" action="user_script.php">
                <input type="hidden" name="action" value="add_bank">
                <label for="person_name_bank">Select User</label>
                <select id="person_name_bank" name="person_name" required>
                    <option value="">Select User</option>
                    <?php foreach (load_data() as $user => $banks): ?>
                        <option value="<?= htmlspecialchars($user) ?>"><?= ucwords($user) ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="bank_name_add">Bank Name</label>
                <input type="text" id="bank_name_add" name="bank_name" required>
                <button type="submit" class="btn">Add Bank</button>
            </form>
        </div>
        <div id="remove_user_form" class="card" style="display: none;">
            <h2>Remove User</h2>
            <form method="POST" action="user_script.php">
                <input type="hidden" name="action" value="remove_user">
                <label for="person_name_remove">Select User</label>
                <select id="person_name_remove" name="person_name" required>
                    <option value="">Select User</option>
                    <?php foreach (load_data() as $user => $banks): ?>
                        <option value="<?= htmlspecialchars($user) ?>"><?= ucwords($user) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-danger">Remove User</button>
            </form>
        </div>
        <div id="update_bank_form" class="card" style="display: none;">
            <h2>Update Bank Name</h2>
            <form method="POST" action="user_script.php">
                <input type="hidden" name="action" value="update_bank_name">
                <label for="person_name_update">Select User</label>
                <select id="person_name_update" name="person_name" onchange="loadBanks(this, 'old_bank_name')" required>
                    <option value="">Select User</option>
                    <?php foreach (load_data() as $user => $banks): ?>
                        <option value="<?= htmlspecialchars($user) ?>"><?= ucwords($user) ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="old_bank_name">Select Bank</label>
                <select id="old_bank_name" name="old_bank_name" required>
                    <option value="">Select Bank</option>
                </select>
                <label for="new_bank_name">New Bank Name</label>
                <input type="text" id="new_bank_name" name="new_bank_name" required>
                <button type="submit" class="btn btn-warning">Update Bank Name</button>
            </form>
        </div>
    </div>
</body>
</html>