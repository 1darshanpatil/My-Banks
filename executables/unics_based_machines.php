#!/usr/bin/env php 
<?php
if (php_sapi_name() === 'cli-server') {
    return false; // Serve files directly if running under PHP built-in server
}

Phar::mapPhar('app.phar');

/*
Create a temporary directory to extract the contents of the Phar
*/
$tmpDir = sys_get_temp_dir() . '/app_phar_' . uniqid();
if (!file_exists($tmpDir)) {
    mkdir($tmpDir, 0777, true);
}

/*
Extract all contents from the Phar archive to the temporary directory
*/
$phar = new Phar('app.phar');
$phar->extractTo($tmpDir);

/*
Start the PHP built-in server
*/
echo "Starting web server at http://localhost:8000\n";
passthru("php -S localhost:8000 -t $tmpDir");

/*
Clean up the temporary directory when the script stops
*/
register_shutdown_function(function () use ($tmpDir) {
    if (file_exists($tmpDir)) {
        passthru("rm -rf " . escapeshellarg($tmpDir));
    }
});

__HALT_COMPILER(); ?>
U  (          app.phar    	   index.php  %�>g  ��Q�         build-phar.php;  %�>g;  eʐ�      	   README.md�  %�>g�  ��~&�         .gitattributesB   %�>gB   7�]ܤ      
   engine.php<	  %�>g<	  ��T��         phar-stub.phpg  %�>gg  ��.E�      
   styles.cssF  %�>gF  'C_��         user_script.php#!  %�>g#!  X8\A�         .git/descriptionI   %�>gI   7��      
   .git/index�  %�>g�  �O�5�         .git/config  %�>g  ��.֤         .git/refs/heads/main)   %�>g)   B˾ͤ         .git/refs/remotes/origin/HEAD   %�>g   D�Be�         .git/logs/refs/heads/main�   %�>g�   As!*�      "   .git/logs/refs/remotes/origin/HEAD�   %�>g�   As!*�         .git/logs/HEAD�   %�>g�   As!*�         .git/hooks/pre-rebase.sample"  %�>g"  ��XQ�      $   .git/hooks/fsmonitor-watchman.samplev  %�>gv  �|<y�      "   .git/hooks/push-to-checkout.sample�
  %�>g�
  ���          .git/hooks/applypatch-msg.sample�  %�>g�  �O�	�         .git/hooks/update.sampleB  %�>gB  ����         .git/hooks/commit-msg.sample�  %�>g�  ����      "   .git/hooks/pre-merge-commit.sample�  %�>g�  D?�^�         .git/hooks/pre-push.sample^  %�>g^  
��      $   .git/hooks/sendemail-validate.sample	  %�>g	  NݞK�          .git/hooks/pre-applypatch.sample�  %�>g�  ��L�         .git/hooks/post-update.sample�   %�>g�   ����      $   .git/hooks/prepare-commit-msg.sample�  %�>g�  �60�         .git/hooks/pre-commit.sampleq  %�>gq  �P�         .git/hooks/pre-receive.sample   %�>g   �����      	   .git/HEAD   %�>g   �cdW�         .git/packed-refsp   %�>gp   �ľӤ      D   .git/objects/pack/pack-521b83f56d478236c2f4175cb48f2a8d174ca310.pack�� %�>g�� �p�$      C   .git/objects/pack/pack-521b83f56d478236c2f4175cb48f2a8d174ca310.rev�   %�>g�   "c^($      C   .git/objects/pack/pack-521b83f56d478236c2f4175cb48f2a8d174ca310.idx  %�>g  ���$         .git/info/exclude�   %�>g�   w=�!�         view_balances.php�   %�>g�   U�Ɯ�         windows-executable.phar�2 %�>g�2 {���         LICENSE'�  %�>g'�  ʩ�U�         make-app.shB  %�>gB  �ݨ�      <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User and Bank Management</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        iframe {
            border: none;
            flex: 1; /* Each iframe will take equal space */
            height: 100%;
        }
        iframe.left {
            border-right: 1px solid #ccc; /* Optional: Add a separator between frames */
        }
    </style>
</head>
<body>
    <iframe class="right" src="view_balances.php"></iframe>
    <iframe class="left" src="user_script.php"></iframe>
</body>
</html><?php
$phar = new Phar('app.phar', FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME, 'app.phar');
$phar->buildFromDirectory(__DIR__); // Add all files from current directory
$phar->setStub(file_get_contents('phar-stub.php')); // Set the stub
echo "Phar archive created successfully.\n";
# **My-Banks: Simplify Family Bank Account Management**

**My-Banks** is a tool designed to help you effortlessly manage and keep track of all your family’s bank accounts in one place. 

Whether you're juggling multiple accounts across various banks or simply want a centralized way to monitor balances, **My-Banks** provides a streamlined solution. 

> **Note**: While you can delegate account tracking to other family members, such as your children, **My-Banks** is primarily intended for personal or family-level financial tracking.

---

## **How to Use**

### **Option 1: Run the Prebuilt Application (`app.phar`)**
1. **Make the File Executable**
   ```bash
   chmod +x app.phar
   ```

2. **Run the Application**
   ```bash
   ./app.phar
   ```

3. **Optional: Add to Global Path**
   For easier access, you can move `app.phar` to `/usr/local/bin` and rename it (e.g., `mybanks`):
   ```bash
   sudo mv app.phar /usr/local/bin/mybanks
   ```
   Now, you can run the app anywhere:
   ```bash
   mybanks
   ```

4. Open your browser and navigate to:
   ```
   http://localhost:8000
   ```

---

### **Option 2: Build the Application from Source**

If you’d prefer to build the Phar file yourself, the source files are included in the repository. Here's the directory structure:

```
.
├── build-phar.php   # Script to create app.phar
├── engine.php       # Backend logic
├── index.php        # Main entry point
├── phar-stub.php    # Stub file for Phar
├── styles.css       # Styling for the web app
├── user_script.php  # User management script
└── view_balances.php # Bank balance view
```

1. **Build the Phar**
   Run the `build-phar.php` script:
   ```bash
   php build-phar.php
   ```
   This will create the `app.phar` file.

2. **Follow the Steps to Run `app.phar`** (as shown above).

---

### **Option 3: Automate with `make-app.sh` (Unix-based Systems)**

A script named [make-app.sh](make-app.sh) is provided to streamline the Phar creation and execution process. Here’s the script structure:

    Note: You may have to uncomment & turn `Off` the `readonly` from `php ini` 


1. **Make the Script Executable**:
   ```bash
   chmod +x make-app.sh
   ```

2. **Run the Script**:
   ```bash
   ./make-app.sh
   ```

3. **Install Globally (Optional)**:
   To make the app globally accessible:
   ```bash
   ./make-app.sh --install
   ```

---

## **Features**

- **Account Overview**:
  - View all family members’ bank accounts and balances in a single interface.

- **Simple Account Management**:
  - Add, edit, or remove accounts quickly using the intuitive interface.

- **Portability**:
  - Self-contained Phar archive that can run on any system with PHP installed.

---

## **System Requirements**
- **PHP Version**: PHP 7.4 or higher.
- **Operating Systems**:
  - Linux
  - macOS
  - Windows (requires PHP setup).

---

## **Support**
For any issues or questions, feel free to contact us or check out the documentation in the project repository.# Auto detect text files and perform LF normalization
* text=auto
<?php
$home_dir = getenv('HOME') ?: '/tmp';
$data_file = $home_dir . "/family_bank_data.json";
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
    if (is_writable(dirname($data_file)) || !file_exists($data_file)) {
        file_put_contents($data_file, json_encode($data, JSON_PRETTY_PRINT));
    } else {
        echo "<p>Error: Cannot write to the file system. Please check permissions for the directory.</p>";
    }
}


function add_person($person_name) {
    $data = load_data();
    $person_name = strtolower(trim($person_name));
    if (!isset($data[$person_name])) {
        $data[$person_name] = []; 
        save_data($data);
    }
}


function add_account($person_name, $bank_name, $balance) {
    $data = load_data();
    $person_name = strtolower(trim($person_name));
    $bank_name = strtolower(trim($bank_name));
    if (!isset($data[$person_name])) {
        $data[$person_name] = [];
    }
    $data[$person_name][$bank_name] = $balance;
    save_data($data);
}


function update_bank_name($person_name, $old_bank_name, $new_bank_name) {
    $data = load_data();
    $person_name = strtolower(trim($person_name));
    $old_bank_name = strtolower(trim($old_bank_name));
    $new_bank_name = strtolower(trim($new_bank_name));
    if (isset($data[$person_name][$old_bank_name])) {
        $data[$person_name][$new_bank_name] = $data[$person_name][$old_bank_name];
        unset($data[$person_name][$old_bank_name]);
        save_data($data);
    }
}


function update_balance($person_name, $bank_name, $new_balance) {
    $data = load_data();
    $person_name = strtolower(trim($person_name));
    $bank_name = strtolower(trim($bank_name));
    if (isset($data[$person_name][$bank_name])) {
        $data[$person_name][$bank_name] = $new_balance;
        save_data($data);
    } else {
        echo "<p>Error: Person or bank does not exist.</p>";
    }
}


function get_total_balance() {
    $data = load_data();
    $total_balance = 0;
    foreach ($data as $accounts) {
        foreach ($accounts as $balance) {
            $total_balance += $balance;
        }
    }
    return $total_balance;
}


function get_all_data() {
    return load_data();
}
?>#!/usr/bin/env php 
<?php
if (php_sapi_name() === 'cli-server') {
    return false; // Serve files directly if running under PHP built-in server
}

Phar::mapPhar('app.phar');

/*
Create a temporary directory to extract the contents of the Phar
*/
$tmpDir = sys_get_temp_dir() . '/app_phar_' . uniqid();
if (!file_exists($tmpDir)) {
    mkdir($tmpDir, 0777, true);
}

/*
Extract all contents from the Phar archive to the temporary directory
*/
$phar = new Phar('app.phar');
$phar->extractTo($tmpDir);

/*
Start the PHP built-in server
*/
echo "Starting web server at http://localhost:8000\n";
passthru("php -S localhost:8000 -t $tmpDir");

/*
Clean up the temporary directory when the script stops
*/
register_shutdown_function(function () use ($tmpDir) {
    if (file_exists($tmpDir)) {
        passthru("rm -rf " . escapeshellarg($tmpDir));
    }
});

__HALT_COMPILER();body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #eef2f3; /* Softer background */
    color: #444;
}

.container {
    max-width: 800px;
    margin: 2em auto;
    padding: 1.5em;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.container:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

h1, h2 {
    text-align: center;
    margin-bottom: 1em;
    color: #007bff;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 1em;
    background-color: #ffffff;
    border-radius: 8px;
    overflow: hidden; /* Rounded corners */
}

th, td {
    padding: 0.75em;
    text-align: left;
    border: 1px solid #ddd;
}

th {
    background: linear-gradient(135deg, #007bff, #80bdff); /* Gradient for headers */
    color: white;
    font-weight: bold;
    text-transform: uppercase;
}

tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

tbody tr:nth-child(odd) {
    background-color: #ffffff;
}

tbody tr:hover {
    background-color: #eaf6ff; /* Light blue hover */
    transition: background-color 0.3s ease;
}

button {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    border: none;
    padding: 0.5em 1em;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    transition: background 0.3s ease, transform 0.2s ease;
}

button:hover {
    background: linear-gradient(135deg, #0056b3, #004080);
    transform: scale(1.05);
}

.btn-danger {
    background: linear-gradient(135deg, #dc3545, #a71d2a);
}

.btn-danger:hover {
    background: linear-gradient(135deg, #a71d2a, #6e121c);
}

.btn-success {
    background: linear-gradient(135deg, #28a745, #1e7e34);
}

.btn-success:hover {
    background: linear-gradient(135deg, #1e7e34, #155e25);
}

.btn-warning {
    background: linear-gradient(135deg, #ffc107, #e0a800);
}

.btn-warning:hover {
    background: linear-gradient(135deg, #e0a800, #c79100);
}

.form-inline {
    display: flex;
    align-items: center;
    gap: 0.5em;
    margin-bottom: 1em;
}

input[type="text"],
input[type="number"],
select {
    padding: 0.75em;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 100%;
    transition: border-color 0.3s ease;
}

input[type="text"]:focus,
input[type="number"]:focus,
select:focus {
    border-color: #007bff;
    outline: none;
}

.card {
    margin-bottom: 1em;
    padding: 1em;
    border: 1px solid #ddd;
    border-radius: 10px;
    background: #f9f9f9;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.update-section form {
    display: flex;
    flex-direction: column;
    gap: 1em;
}

.update-section form div {
    display: flex;
    gap: 1em;
    flex-wrap: wrap;
}

.update-section form button {
    align-self: flex-end;
}<?php
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
</html>Unnamed repository; edit this file 'description' to name the repository.
DIRC      g>��2�g>��2�  ��  ��  �  �   B��w$����PzP��;��N{ .gitattributes    g>��2�g>��2�  ��  ��  �  �  �'?�9���
q��rf�y� LICENSE   g>��2�g>��2�  ��  ��  �  �  �Ӟk�O�t����>�3�`e�� 	README.md g>��2�g>��2�  ��  ��  �  �  ;����ª:\�'ؼF�y� build-phar.php    g>��2�g>��2�  ��  ��  �  �  	<��ۀ"�Ჵc�d�ݢX�" 
engine.php        g>��2�g>��2�  ��  ��  �  �  �]7�5~.[���)$��M� 	index.php g>��2�g>��2�  ��  ��  �  �  B��e�J��r����UW��, make-app.sh       g>��2�g>��2�  ��  ��  �  �  gu=�)}qǅ�;����%�H phar-stub.php     g>��2�g>��2�  ��  ��  �  �  F����l�4�g�ĵ�|؏�� 
styles.css        g>��2�g>��2�  ��  ��  �  �  !#͎�	��f�q��Ŏ��I��S user_script.php   g>��2�g>��2�  ��  ��  �  �   ��A�=�2��|��M˽_�~�+ view_balances.php g>��2�g>��2�  ��  ��  �  � 2�`��W�B�b���޷\�QP� windows-executable.phar   TREE    12 0
qin�'��H(LK
/��4�
 9b���b�\���jJ_[core]
	repositoryformatversion = 0
	filemode = true
	bare = false
	logallrefupdates = true
[remote "origin"]
	url = git@github.com:1darshanpatil/My-Banks.git
	fetch = +refs/heads/*:refs/remotes/origin/*
[branch "main"]
	remote = origin
	merge = refs/heads/main
9663ade8051492c8a1820d5561c9ee7dc7319afa
ref: refs/remotes/origin/main
0000000000000000000000000000000000000000 9663ade8051492c8a1820d5561c9ee7dc7319afa 1darshanpatil <patildarshan417@gmail.com> 1732179205 +0530	clone: from github.com:1darshanpatil/My-Banks.git
0000000000000000000000000000000000000000 9663ade8051492c8a1820d5561c9ee7dc7319afa 1darshanpatil <patildarshan417@gmail.com> 1732179205 +0530	clone: from github.com:1darshanpatil/My-Banks.git
0000000000000000000000000000000000000000 9663ade8051492c8a1820d5561c9ee7dc7319afa 1darshanpatil <patildarshan417@gmail.com> 1732179205 +0530	clone: from github.com:1darshanpatil/My-Banks.git
#!/bin/sh
#
# Copyright (c) 2006, 2008 Junio C Hamano
#
# The "pre-rebase" hook is run just before "git rebase" starts doing
# its job, and can prevent the command from running by exiting with
# non-zero status.
#
# The hook is called with the following parameters:
#
# $1 -- the upstream the series was forked from.
# $2 -- the branch being rebased (or empty when rebasing the current branch).
#
# This sample shows how to prevent topic branches that are already
# merged to 'next' branch from getting rebased, because allowing it
# would result in rebasing already published history.

publish=next
basebranch="$1"
if test "$#" = 2
then
	topic="refs/heads/$2"
else
	topic=`git symbolic-ref HEAD` ||
	exit 0 ;# we do not interrupt rebasing detached HEAD
fi

case "$topic" in
refs/heads/??/*)
	;;
*)
	exit 0 ;# we do not interrupt others.
	;;
esac

# Now we are dealing with a topic branch being rebased
# on top of master.  Is it OK to rebase it?

# Does the topic really exist?
git show-ref -q "$topic" || {
	echo >&2 "No such branch $topic"
	exit 1
}

# Is topic fully merged to master?
not_in_master=`git rev-list --pretty=oneline ^master "$topic"`
if test -z "$not_in_master"
then
	echo >&2 "$topic is fully merged to master; better remove it."
	exit 1 ;# we could allow it, but there is no point.
fi

# Is topic ever merged to next?  If so you should not be rebasing it.
only_next_1=`git rev-list ^master "^$topic" ${publish} | sort`
only_next_2=`git rev-list ^master           ${publish} | sort`
if test "$only_next_1" = "$only_next_2"
then
	not_in_topic=`git rev-list "^$topic" master`
	if test -z "$not_in_topic"
	then
		echo >&2 "$topic is already up to date with master"
		exit 1 ;# we could allow it, but there is no point.
	else
		exit 0
	fi
else
	not_in_next=`git rev-list --pretty=oneline ^${publish} "$topic"`
	/usr/bin/perl -e '
		my $topic = $ARGV[0];
		my $msg = "* $topic has commits already merged to public branch:\n";
		my (%not_in_next) = map {
			/^([0-9a-f]+) /;
			($1 => 1);
		} split(/\n/, $ARGV[1]);
		for my $elem (map {
				/^([0-9a-f]+) (.*)$/;
				[$1 => $2];
			} split(/\n/, $ARGV[2])) {
			if (!exists $not_in_next{$elem->[0]}) {
				if ($msg) {
					print STDERR $msg;
					undef $msg;
				}
				print STDERR " $elem->[1]\n";
			}
		}
	' "$topic" "$not_in_next" "$not_in_master"
	exit 1
fi

<<\DOC_END

This sample hook safeguards topic branches that have been
published from being rewound.

The workflow assumed here is:

 * Once a topic branch forks from "master", "master" is never
   merged into it again (either directly or indirectly).

 * Once a topic branch is fully cooked and merged into "master",
   it is deleted.  If you need to build on top of it to correct
   earlier mistakes, a new topic branch is created by forking at
   the tip of the "master".  This is not strictly necessary, but
   it makes it easier to keep your history simple.

 * Whenever you need to test or publish your changes to topic
   branches, merge them into "next" branch.

The script, being an example, hardcodes the publish branch name
to be "next", but it is trivial to make it configurable via
$GIT_DIR/config mechanism.

With this workflow, you would want to know:

(1) ... if a topic branch has ever been merged to "next".  Young
    topic branches can have stupid mistakes you would rather
    clean up before publishing, and things that have not been
    merged into other branches can be easily rebased without
    affecting other people.  But once it is published, you would
    not want to rewind it.

(2) ... if a topic branch has been fully merged to "master".
    Then you can delete it.  More importantly, you should not
    build on top of it -- other people may already want to
    change things related to the topic as patches against your
    "master", so if you need further changes, it is better to
    fork the topic (perhaps with the same name) afresh from the
    tip of "master".

Let's look at this example:

		   o---o---o---o---o---o---o---o---o---o "next"
		  /       /           /           /
		 /   a---a---b A     /           /
		/   /               /           /
	       /   /   c---c---c---c B         /
	      /   /   /             \         /
	     /   /   /   b---b C     \       /
	    /   /   /   /             \     /
    ---o---o---o---o---o---o---o---o---o---o---o "master"


A, B and C are topic branches.

 * A has one fix since it was merged up to "next".

 * B has finished.  It has been fully merged up to "master" and "next",
   and is ready to be deleted.

 * C has not merged to "next" at all.

We would want to allow C to be rebased, refuse A, and encourage
B to be deleted.

To compute (1):

	git rev-list ^master ^topic next
	git rev-list ^master        next

	if these match, topic has not merged in next at all.

To compute (2):

	git rev-list master..topic

	if this is empty, it is fully merged to "master".

DOC_END
#!/usr/bin/perl

use strict;
use warnings;
use IPC::Open2;

# An example hook script to integrate Watchman
# (https://facebook.github.io/watchman/) with git to speed up detecting
# new and modified files.
#
# The hook is passed a version (currently 2) and last update token
# formatted as a string and outputs to stdout a new update token and
# all files that have been modified since the update token. Paths must
# be relative to the root of the working tree and separated by a single NUL.
#
# To enable this hook, rename this file to "query-watchman" and set
# 'git config core.fsmonitor .git/hooks/query-watchman'
#
my ($version, $last_update_token) = @ARGV;

# Uncomment for debugging
# print STDERR "$0 $version $last_update_token\n";

# Check the hook interface version
if ($version ne 2) {
	die "Unsupported query-fsmonitor hook version '$version'.\n" .
	    "Falling back to scanning...\n";
}

my $git_work_tree = get_working_dir();

my $retry = 1;

my $json_pkg;
eval {
	require JSON::XS;
	$json_pkg = "JSON::XS";
	1;
} or do {
	require JSON::PP;
	$json_pkg = "JSON::PP";
};

launch_watchman();

sub launch_watchman {
	my $o = watchman_query();
	if (is_work_tree_watched($o)) {
		output_result($o->{clock}, @{$o->{files}});
	}
}

sub output_result {
	my ($clockid, @files) = @_;

	# Uncomment for debugging watchman output
	# open (my $fh, ">", ".git/watchman-output.out");
	# binmode $fh, ":utf8";
	# print $fh "$clockid\n@files\n";
	# close $fh;

	binmode STDOUT, ":utf8";
	print $clockid;
	print "\0";
	local $, = "\0";
	print @files;
}

sub watchman_clock {
	my $response = qx/watchman clock "$git_work_tree"/;
	die "Failed to get clock id on '$git_work_tree'.\n" .
		"Falling back to scanning...\n" if $? != 0;

	return $json_pkg->new->utf8->decode($response);
}

sub watchman_query {
	my $pid = open2(\*CHLD_OUT, \*CHLD_IN, 'watchman -j --no-pretty')
	or die "open2() failed: $!\n" .
	"Falling back to scanning...\n";

	# In the query expression below we're asking for names of files that
	# changed since $last_update_token but not from the .git folder.
	#
	# To accomplish this, we're using the "since" generator to use the
	# recency index to select candidate nodes and "fields" to limit the
	# output to file names only. Then we're using the "expression" term to
	# further constrain the results.
	my $last_update_line = "";
	if (substr($last_update_token, 0, 1) eq "c") {
		$last_update_token = "\"$last_update_token\"";
		$last_update_line = qq[\n"since": $last_update_token,];
	}
	my $query = <<"	END";
		["query", "$git_work_tree", {$last_update_line
			"fields": ["name"],
			"expression": ["not", ["dirname", ".git"]]
		}]
	END

	# Uncomment for debugging the watchman query
	# open (my $fh, ">", ".git/watchman-query.json");
	# print $fh $query;
	# close $fh;

	print CHLD_IN $query;
	close CHLD_IN;
	my $response = do {local $/; <CHLD_OUT>};

	# Uncomment for debugging the watch response
	# open ($fh, ">", ".git/watchman-response.json");
	# print $fh $response;
	# close $fh;

	die "Watchman: command returned no output.\n" .
	"Falling back to scanning...\n" if $response eq "";
	die "Watchman: command returned invalid output: $response\n" .
	"Falling back to scanning...\n" unless $response =~ /^\{/;

	return $json_pkg->new->utf8->decode($response);
}

sub is_work_tree_watched {
	my ($output) = @_;
	my $error = $output->{error};
	if ($retry > 0 and $error and $error =~ m/unable to resolve root .* directory (.*) is not watched/) {
		$retry--;
		my $response = qx/watchman watch "$git_work_tree"/;
		die "Failed to make watchman watch '$git_work_tree'.\n" .
		    "Falling back to scanning...\n" if $? != 0;
		$output = $json_pkg->new->utf8->decode($response);
		$error = $output->{error};
		die "Watchman: $error.\n" .
		"Falling back to scanning...\n" if $error;

		# Uncomment for debugging watchman output
		# open (my $fh, ">", ".git/watchman-output.out");
		# close $fh;

		# Watchman will always return all files on the first query so
		# return the fast "everything is dirty" flag to git and do the
		# Watchman query just to get it over with now so we won't pay
		# the cost in git to look up each individual file.
		my $o = watchman_clock();
		$error = $output->{error};

		die "Watchman: $error.\n" .
		"Falling back to scanning...\n" if $error;

		output_result($o->{clock}, ("/"));
		$last_update_token = $o->{clock};

		eval { launch_watchman() };
		return 0;
	}

	die "Watchman: $error.\n" .
	"Falling back to scanning...\n" if $error;

	return 1;
}

sub get_working_dir {
	my $working_dir;
	if ($^O =~ 'msys' || $^O =~ 'cygwin') {
		$working_dir = Win32::GetCwd();
		$working_dir =~ tr/\\/\//;
	} else {
		require Cwd;
		$working_dir = Cwd::cwd();
	}

	return $working_dir;
}
#!/bin/sh

# An example hook script to update a checked-out tree on a git push.
#
# This hook is invoked by git-receive-pack(1) when it reacts to git
# push and updates reference(s) in its repository, and when the push
# tries to update the branch that is currently checked out and the
# receive.denyCurrentBranch configuration variable is set to
# updateInstead.
#
# By default, such a push is refused if the working tree and the index
# of the remote repository has any difference from the currently
# checked out commit; when both the working tree and the index match
# the current commit, they are updated to match the newly pushed tip
# of the branch. This hook is to be used to override the default
# behaviour; however the code below reimplements the default behaviour
# as a starting point for convenient modification.
#
# The hook receives the commit with which the tip of the current
# branch is going to be updated:
commit=$1

# It can exit with a non-zero status to refuse the push (when it does
# so, it must not modify the index or the working tree).
die () {
	echo >&2 "$*"
	exit 1
}

# Or it can make any necessary changes to the working tree and to the
# index to bring them to the desired state when the tip of the current
# branch is updated to the new commit, and exit with a zero status.
#
# For example, the hook can simply run git read-tree -u -m HEAD "$1"
# in order to emulate git fetch that is run in the reverse direction
# with git push, as the two-tree form of git read-tree -u -m is
# essentially the same as git switch or git checkout that switches
# branches while keeping the local changes in the working tree that do
# not interfere with the difference between the branches.

# The below is a more-or-less exact translation to shell of the C code
# for the default behaviour for git's push-to-checkout hook defined in
# the push_to_deploy() function in builtin/receive-pack.c.
#
# Note that the hook will be executed from the repository directory,
# not from the working tree, so if you want to perform operations on
# the working tree, you will have to adapt your code accordingly, e.g.
# by adding "cd .." or using relative paths.

if ! git update-index -q --ignore-submodules --refresh
then
	die "Up-to-date check failed"
fi

if ! git diff-files --quiet --ignore-submodules --
then
	die "Working directory has unstaged changes"
fi

# This is a rough translation of:
#
#   head_has_history() ? "HEAD" : EMPTY_TREE_SHA1_HEX
if git cat-file -e HEAD 2>/dev/null
then
	head=HEAD
else
	head=$(git hash-object -t tree --stdin </dev/null)
fi

if ! git diff-index --quiet --cached --ignore-submodules $head --
then
	die "Working directory has staged changes"
fi

if ! git read-tree -u -m "$commit"
then
	die "Could not update working tree to new HEAD"
fi
#!/bin/sh
#
# An example hook script to check the commit log message taken by
# applypatch from an e-mail message.
#
# The hook should exit with non-zero status after issuing an
# appropriate message if it wants to stop the commit.  The hook is
# allowed to edit the commit message file.
#
# To enable this hook, rename this file to "applypatch-msg".

. git-sh-setup
commitmsg="$(git rev-parse --git-path hooks/commit-msg)"
test -x "$commitmsg" && exec "$commitmsg" ${1+"$@"}
:
#!/bin/sh
#
# An example hook script to block unannotated tags from entering.
# Called by "git receive-pack" with arguments: refname sha1-old sha1-new
#
# To enable this hook, rename this file to "update".
#
# Config
# ------
# hooks.allowunannotated
#   This boolean sets whether unannotated tags will be allowed into the
#   repository.  By default they won't be.
# hooks.allowdeletetag
#   This boolean sets whether deleting tags will be allowed in the
#   repository.  By default they won't be.
# hooks.allowmodifytag
#   This boolean sets whether a tag may be modified after creation. By default
#   it won't be.
# hooks.allowdeletebranch
#   This boolean sets whether deleting branches will be allowed in the
#   repository.  By default they won't be.
# hooks.denycreatebranch
#   This boolean sets whether remotely creating branches will be denied
#   in the repository.  By default this is allowed.
#

# --- Command line
refname="$1"
oldrev="$2"
newrev="$3"

# --- Safety check
if [ -z "$GIT_DIR" ]; then
	echo "Don't run this script from the command line." >&2
	echo " (if you want, you could supply GIT_DIR then run" >&2
	echo "  $0 <ref> <oldrev> <newrev>)" >&2
	exit 1
fi

if [ -z "$refname" -o -z "$oldrev" -o -z "$newrev" ]; then
	echo "usage: $0 <ref> <oldrev> <newrev>" >&2
	exit 1
fi

# --- Config
allowunannotated=$(git config --type=bool hooks.allowunannotated)
allowdeletebranch=$(git config --type=bool hooks.allowdeletebranch)
denycreatebranch=$(git config --type=bool hooks.denycreatebranch)
allowdeletetag=$(git config --type=bool hooks.allowdeletetag)
allowmodifytag=$(git config --type=bool hooks.allowmodifytag)

# check for no description
projectdesc=$(sed -e '1q' "$GIT_DIR/description")
case "$projectdesc" in
"Unnamed repository"* | "")
	echo "*** Project description file hasn't been set" >&2
	exit 1
	;;
esac

# --- Check types
# if $newrev is 0000...0000, it's a commit to delete a ref.
zero=$(git hash-object --stdin </dev/null | tr '[0-9a-f]' '0')
if [ "$newrev" = "$zero" ]; then
	newrev_type=delete
else
	newrev_type=$(git cat-file -t $newrev)
fi

case "$refname","$newrev_type" in
	refs/tags/*,commit)
		# un-annotated tag
		short_refname=${refname##refs/tags/}
		if [ "$allowunannotated" != "true" ]; then
			echo "*** The un-annotated tag, $short_refname, is not allowed in this repository" >&2
			echo "*** Use 'git tag [ -a | -s ]' for tags you want to propagate." >&2
			exit 1
		fi
		;;
	refs/tags/*,delete)
		# delete tag
		if [ "$allowdeletetag" != "true" ]; then
			echo "*** Deleting a tag is not allowed in this repository" >&2
			exit 1
		fi
		;;
	refs/tags/*,tag)
		# annotated tag
		if [ "$allowmodifytag" != "true" ] && git rev-parse $refname > /dev/null 2>&1
		then
			echo "*** Tag '$refname' already exists." >&2
			echo "*** Modifying a tag is not allowed in this repository." >&2
			exit 1
		fi
		;;
	refs/heads/*,commit)
		# branch
		if [ "$oldrev" = "$zero" -a "$denycreatebranch" = "true" ]; then
			echo "*** Creating a branch is not allowed in this repository" >&2
			exit 1
		fi
		;;
	refs/heads/*,delete)
		# delete branch
		if [ "$allowdeletebranch" != "true" ]; then
			echo "*** Deleting a branch is not allowed in this repository" >&2
			exit 1
		fi
		;;
	refs/remotes/*,commit)
		# tracking branch
		;;
	refs/remotes/*,delete)
		# delete tracking branch
		if [ "$allowdeletebranch" != "true" ]; then
			echo "*** Deleting a tracking branch is not allowed in this repository" >&2
			exit 1
		fi
		;;
	*)
		# Anything else (is there anything else?)
		echo "*** Update hook: unknown type of update to ref $refname of type $newrev_type" >&2
		exit 1
		;;
esac

# --- Finished
exit 0
#!/bin/sh
#
# An example hook script to check the commit log message.
# Called by "git commit" with one argument, the name of the file
# that has the commit message.  The hook should exit with non-zero
# status after issuing an appropriate message if it wants to stop the
# commit.  The hook is allowed to edit the commit message file.
#
# To enable this hook, rename this file to "commit-msg".

# Uncomment the below to add a Signed-off-by line to the message.
# Doing this in a hook is a bad idea in general, but the prepare-commit-msg
# hook is more suited to it.
#
# SOB=$(git var GIT_AUTHOR_IDENT | sed -n 's/^\(.*>\).*$/Signed-off-by: \1/p')
# grep -qs "^$SOB" "$1" || echo "$SOB" >> "$1"

# This example catches duplicate Signed-off-by lines.

test "" = "$(grep '^Signed-off-by: ' "$1" |
	 sort | uniq -c | sed -e '/^[ 	]*1[ 	]/d')" || {
	echo >&2 Duplicate Signed-off-by lines.
	exit 1
}
#!/bin/sh
#
# An example hook script to verify what is about to be committed.
# Called by "git merge" with no arguments.  The hook should
# exit with non-zero status after issuing an appropriate message to
# stderr if it wants to stop the merge commit.
#
# To enable this hook, rename this file to "pre-merge-commit".

. git-sh-setup
test -x "$GIT_DIR/hooks/pre-commit" &&
        exec "$GIT_DIR/hooks/pre-commit"
:
#!/bin/sh

# An example hook script to verify what is about to be pushed.  Called by "git
# push" after it has checked the remote status, but before anything has been
# pushed.  If this script exits with a non-zero status nothing will be pushed.
#
# This hook is called with the following parameters:
#
# $1 -- Name of the remote to which the push is being done
# $2 -- URL to which the push is being done
#
# If pushing without using a named remote those arguments will be equal.
#
# Information about the commits which are being pushed is supplied as lines to
# the standard input in the form:
#
#   <local ref> <local oid> <remote ref> <remote oid>
#
# This sample shows how to prevent push of commits where the log message starts
# with "WIP" (work in progress).

remote="$1"
url="$2"

zero=$(git hash-object --stdin </dev/null | tr '[0-9a-f]' '0')

while read local_ref local_oid remote_ref remote_oid
do
	if test "$local_oid" = "$zero"
	then
		# Handle delete
		:
	else
		if test "$remote_oid" = "$zero"
		then
			# New branch, examine all commits
			range="$local_oid"
		else
			# Update to existing branch, examine new commits
			range="$remote_oid..$local_oid"
		fi

		# Check for WIP commit
		commit=$(git rev-list -n 1 --grep '^WIP' "$range")
		if test -n "$commit"
		then
			echo >&2 "Found WIP commit in $local_ref, not pushing"
			exit 1
		fi
	fi
done

exit 0
#!/bin/sh

# An example hook script to validate a patch (and/or patch series) before
# sending it via email.
#
# The hook should exit with non-zero status after issuing an appropriate
# message if it wants to prevent the email(s) from being sent.
#
# To enable this hook, rename this file to "sendemail-validate".
#
# By default, it will only check that the patch(es) can be applied on top of
# the default upstream branch without conflicts in a secondary worktree. After
# validation (successful or not) of the last patch of a series, the worktree
# will be deleted.
#
# The following config variables can be set to change the default remote and
# remote ref that are used to apply the patches against:
#
#   sendemail.validateRemote (default: origin)
#   sendemail.validateRemoteRef (default: HEAD)
#
# Replace the TODO placeholders with appropriate checks according to your
# needs.

validate_cover_letter () {
	file="$1"
	# TODO: Replace with appropriate checks (e.g. spell checking).
	true
}

validate_patch () {
	file="$1"
	# Ensure that the patch applies without conflicts.
	git am -3 "$file" || return
	# TODO: Replace with appropriate checks for this patch
	# (e.g. checkpatch.pl).
	true
}

validate_series () {
	# TODO: Replace with appropriate checks for the whole series
	# (e.g. quick build, coding style checks, etc.).
	true
}

# main -------------------------------------------------------------------------

if test "$GIT_SENDEMAIL_FILE_COUNTER" = 1
then
	remote=$(git config --default origin --get sendemail.validateRemote) &&
	ref=$(git config --default HEAD --get sendemail.validateRemoteRef) &&
	worktree=$(mktemp --tmpdir -d sendemail-validate.XXXXXXX) &&
	git worktree add -fd --checkout "$worktree" "refs/remotes/$remote/$ref" &&
	git config --replace-all sendemail.validateWorktree "$worktree"
else
	worktree=$(git config --get sendemail.validateWorktree)
fi || {
	echo "sendemail-validate: error: failed to prepare worktree" >&2
	exit 1
}

unset GIT_DIR GIT_WORK_TREE
cd "$worktree" &&

if grep -q "^diff --git " "$1"
then
	validate_patch "$1"
else
	validate_cover_letter "$1"
fi &&

if test "$GIT_SENDEMAIL_FILE_COUNTER" = "$GIT_SENDEMAIL_FILE_TOTAL"
then
	git config --unset-all sendemail.validateWorktree &&
	trap 'git worktree remove -ff "$worktree"' EXIT &&
	validate_series
fi
#!/bin/sh
#
# An example hook script to verify what is about to be committed
# by applypatch from an e-mail message.
#
# The hook should exit with non-zero status after issuing an
# appropriate message if it wants to stop the commit.
#
# To enable this hook, rename this file to "pre-applypatch".

. git-sh-setup
precommit="$(git rev-parse --git-path hooks/pre-commit)"
test -x "$precommit" && exec "$precommit" ${1+"$@"}
:
#!/bin/sh
#
# An example hook script to prepare a packed repository for use over
# dumb transports.
#
# To enable this hook, rename this file to "post-update".

exec git update-server-info
#!/bin/sh
#
# An example hook script to prepare the commit log message.
# Called by "git commit" with the name of the file that has the
# commit message, followed by the description of the commit
# message's source.  The hook's purpose is to edit the commit
# message file.  If the hook fails with a non-zero status,
# the commit is aborted.
#
# To enable this hook, rename this file to "prepare-commit-msg".

# This hook includes three examples. The first one removes the
# "# Please enter the commit message..." help message.
#
# The second includes the output of "git diff --name-status -r"
# into the message, just before the "git status" output.  It is
# commented because it doesn't cope with --amend or with squashed
# commits.
#
# The third example adds a Signed-off-by line to the message, that can
# still be edited.  This is rarely a good idea.

COMMIT_MSG_FILE=$1
COMMIT_SOURCE=$2
SHA1=$3

/usr/bin/perl -i.bak -ne 'print unless(m/^. Please enter the commit message/..m/^#$/)' "$COMMIT_MSG_FILE"

# case "$COMMIT_SOURCE,$SHA1" in
#  ,|template,)
#    /usr/bin/perl -i.bak -pe '
#       print "\n" . `git diff --cached --name-status -r`
# 	 if /^#/ && $first++ == 0' "$COMMIT_MSG_FILE" ;;
#  *) ;;
# esac

# SOB=$(git var GIT_COMMITTER_IDENT | sed -n 's/^\(.*>\).*$/Signed-off-by: \1/p')
# git interpret-trailers --in-place --trailer "$SOB" "$COMMIT_MSG_FILE"
# if test -z "$COMMIT_SOURCE"
# then
#   /usr/bin/perl -i.bak -pe 'print "\n" if !$first_line++' "$COMMIT_MSG_FILE"
# fi
#!/bin/sh
#
# An example hook script to verify what is about to be committed.
# Called by "git commit" with no arguments.  The hook should
# exit with non-zero status after issuing an appropriate message if
# it wants to stop the commit.
#
# To enable this hook, rename this file to "pre-commit".

if git rev-parse --verify HEAD >/dev/null 2>&1
then
	against=HEAD
else
	# Initial commit: diff against an empty tree object
	against=$(git hash-object -t tree /dev/null)
fi

# If you want to allow non-ASCII filenames set this variable to true.
allownonascii=$(git config --type=bool hooks.allownonascii)

# Redirect output to stderr.
exec 1>&2

# Cross platform projects tend to avoid non-ASCII filenames; prevent
# them from being added to the repository. We exploit the fact that the
# printable range starts at the space character and ends with tilde.
if [ "$allownonascii" != "true" ] &&
	# Note that the use of brackets around a tr range is ok here, (it's
	# even required, for portability to Solaris 10's /usr/bin/tr), since
	# the square bracket bytes happen to fall in the designated range.
	test $(git diff-index --cached --name-only --diff-filter=A -z $against |
	  LC_ALL=C tr -d '[ -~]\0' | wc -c) != 0
then
	cat <<\EOF
Error: Attempt to add a non-ASCII file name.

This can cause problems if you want to work with people on other platforms.

To be portable it is advisable to rename the file.

If you know what you are doing you can disable this check using:

  git config hooks.allownonascii true
EOF
	exit 1
fi

# If there are whitespace errors, print the offending file names and fail.
exec git diff-index --check --cached $against --
#!/bin/sh
#
# An example hook script to make use of push options.
# The example simply echoes all push options that start with 'echoback='
# and rejects all pushes when the "reject" push option is used.
#
# To enable this hook, rename this file to "pre-receive".

if test -n "$GIT_PUSH_OPTION_COUNT"
then
	i=0
	while test "$i" -lt "$GIT_PUSH_OPTION_COUNT"
	do
		eval "value=\$GIT_PUSH_OPTION_$i"
		case "$value" in
		echoback=*)
			echo "echo from the pre-receive-hook: ${value#*=}" >&2
			;;
		reject)
			exit 1
		esac
		i=$((i + 1))
	done
fi
ref: refs/heads/main
# pack-refs with: peeled fully-peeled sorted 
9663ade8051492c8a1820d5561c9ee7dc7319afa refs/remotes/origin/main
PACK      #�x���M�� @ὧp�J���0W)����3����o��fg�N�`�{����h��&�6H�X�BC^�ԹMɜ���.��)���Ü��RQ�"�(����N���6����������I�>��},��|>���:�+.�ؿ�r����:��A�u�s�Yk�^y�r�h>^C��Z[�x���K
�0 �}N��P2��"n=��IF[�����n��*�]�{6>��;�Q�@L%[�r��Z���4��3H���xD�R�4��H��mX���S���Y��u�<��4����uߤnݼTY_��9�a�./�EC@!b}2�:t[�?�j_���}��3ZV�x���K��0�:��#�eɁf;����������C��բ
�V�F���3��)�q@NY�n�ci�.>����L%CJΑ���!K#�x9DçN[��
ןy��z�&.��c�ug��_�zt�V��?�k����-w�3O��^\O�4�̪��[s��
�:�>��_�W"�x���Kn�  �=�`?jdp� �Fsv5D��޾9D�o�zc�Q�)܈p4^��@|�$�Af��R�kV{	�8Jc$�1�K��>L9(��|4��O��������qz�[Ι�J}Y������q]�ϥ�W򱽴	h�uN�Aݺ-��?��J�r�_�A��� �:XԜx����m� @�;Up_�#e�t�b$#��l�q���ן�Y`�d0�`�C_�`kA;�#0!�N�۔�� �s`(�W@a�bu�)&�!
��z��o��S�|���Ax�[ΕZ�Y����q.�ܷ��]�z�%����6N���@�[�:'�sV�<�`�G�^ϯRd����emU������]��x����J�0��{�"'/%�d3,��� ���Ifma��4E}{{�����jцx�6IvQ��9y�	�IȞ)`j�"S��!˱Mdm�WFr(��s{�p��,����E����|�>�=�\{�]֞���p;o�����"����j�q���^:�{���Q��C���[��d�����C����;�'o���kƬ~'�]f�x����j�  л_�}!�L��R詟1�c#$&���}�~C���z�,���&;y�#�`"#�i`uP��5g�p�'���c2�Q�E�fJ�MȤ�����F߉ڳT����q�ٗ�ՃzY߯S�9Խɱ�_�/q���hܬoơQ/�J��ϭ���Z��߯f��� Y ��4x�����Q��(5U���������<�� �<������$�$9%���8%���� ��$9yb���������� ZA���؀��3/�$31G!9?77�� _�x340031Q�K�,I,))�L*-I-f����Ee��������~�կ�������/ؕ���%c��s�
�)J{��R�*TI������^n
��y�g�����9����	���C%�d$1��|���M��Y�l'���ၪI*��I��*-`>%����C��bf�����v��:Tej^zf^*X��U���nښ,t%���E_���2�RR+��>ƚ0�Ӌf<������%�R���r�SuA�+�`8(�œ���੢��ٷ}_|J����T�*���$�y��?4k��r����F�]�K�cP�K*sR�����.���%g�ɻ��#[����������8�(�8�(��l�پo�[O��*l~z���=��W��J�2S��s��f�#�۳F���,k�=�7�m�"m ������+x� ������`��W�B�b���޷\�QP���C�U@�.x�����yB�ƹ6���f&&
�y)��ź��ɥ%�I9�k� 9E�x�SVp,-�WHI-IM.Q(I�(QH��I-VH�KQ(H-J�/�U�qS�҉9�U�%��y\Z`���@�\ 
�n��>x��}w|��8,#�bC,+�6��0$BR@D������β��|>��ņ"6Ŏbǆb���D��+>�wι�N������������d�s�=��{愁�q#���¹j�S�tDdi�H�����	�m����JH�̒+++�_P�6�h��ȒO�d����x4,���Vȹ�r3>�ZP5d�U}�`�#F��n��a���6�޸�eka�)͓��%Z^R"�Kf���D෌�
I�"UGU%�ʊSC=�D��:��euv,��br�C�}z8��c���oQ�+��"5ZT���n��]���`m0�2G�ȅI�pҶ�3�fi�L��2�զ�֌�������1��n9����-Ǣq:�#�k9xJ0h���!@Y��:4�,�K�NZ�+�]r2��i���݄�!�9�D�Rm���:t�E�púT/(+1�#����u��ЍXyY^^ީaW�Q#��g�����eg9;&s@\b;����tK��:�0=4|Q-���1Ĩ�{�Fی�x̯w���/���L��7T�\=�&��]m#�XK����h@v)��O��F�*�v�_u�'��U�����ki�n��詫mG��-�ԣG^�=�{�8 �_l��C�j�]��Ud��=z�?nD;~>����A?�g�llt�>�~���E���_������6�|�?_���V��`���Rq����yr٩U�)fĺ�(�����X+�\���rѪ7�#�3bq/�΁���6��n������fBmN���s^~���h}��?���*�b-��ҥ��9�ZL�Ţ�7S�Q=XK�,�>�}�� �2N]@k��7�Ϯ�s��JD3�{P��[R�����
����J~Q���hXAQ��T����
�yyť�Êو����^���[�[�#��}����������"����T��x�؈������ҏ���

��T�_((�/+Q_A�W-(.�/(�yĲ"��{	G#~>�����#��*p��"�@�P�y�Jq^���

�jY��H-��q<��	�o�O;bAi�<��;��k+) �
K�"%���W���JJK�W}����Co��ʹ#��s%�?�� ��a�aJiqaIai�,��8��/+�W�������:��1�4��D-Q��a~@]��-�+VZ(���F����j�9{�����������a�y�ޢ<�T)VV�_�/��}��
����<�����a��ŗ�.���@Y��R),��8Z�S|�ŪZ6LVP�+)*���5~�t�kEz�	�*��[�WPPV��{��%��������|��W
��Ek����w`�F,����� �>^��P-�/,.��޼Ҁr5_5~Ώ�*Ҏ��疩���a�#ޒ�R�_V����T?�W4�W�����F���/�2�jIn��˃�PU�ZZP�ST�QTo��1*�|��hja)?G�1�I;b ?��_X��+U�bo^�/�����[(�z��ȟs���]�+NO���>%�0PT�[
�NQ
 Io~iA����+*����;8�s�Y;
ٸ-�8X��~���'�w�h��z�:�����xc��\?0���o7h���j��_>P�<��2���`PFnH���:":�U&�@�����3Z/m�m;t}&��
i��ўc(�HP��.���/�-u�HT͎�^�Py?�a�~����E�A�~�
����T���R�_.������w1/�����e+~�����Ov��!�Qb��Z?���ϳ~=0�#��5Ы��p����;��������ݢ�q�p�SA=�e����g�*���1�����'돟�+�K71�����k8U�絽~yJtt%CR��	����?kF����7�{�=U����?�o$n�^��B������D�~�^�5���u���ݿ�K�F�%;�g�:T�L=.��W�s�~|'z.z'��,�Q�,:�����h���S�����8@�:L��w�������2�y��|P�|��+"v�ө�]m^%��}�]���@f����uKDcf���C*i`���kf�؆	�`��,����| Jj����#�rJHvÌ�m�*�4CG��4���'��h� �lZ�ڀ0�;l����hf
��ޡ�l��h��ͯ�t��ڙ&$32lM�N#��\��t�l�qV�m]QП�A5�D��c5s���`��$O�D7[��/i\sC}[cSmK���Է�V���f��f���Ȉ�hT����J8��d�4�i���2Gn�F�� G�hH3���z�Z��e�����i�I6T*~��3�Or��5�������hL�]j4,��s�,k�j�!g��Ѵd�r>�I�d�I"�]�����p��[D������Ģ�yRu0��đ���h3՚ۋ��^�Hu��q�6s�D��A��ab|b���u̘������X�nNȳ�$��LuN�۽�꜃�b��Z\4�S@*�ޙ17��bW�&lɵ�G��.v���sWl��-*w��i4�!�uՐ�˓���&�S������"�}�AU|2\Vyg��Cҙ��Sj���&��Md,Krvg���5+��SS���'�1|`MCu˔�Z�#
����öW�԰� p�1<���}J�����2:��e�[_�B�-�Gc.���tui�XG�_��|j6��5�44%�m���Z���'��i��:��@or�/������v5��e�Y[r=�0Q����	)�v-\.vQ�D@�i������	*��r ��v>�P���X�������|��f3��\��²�@�aC!Z q+�GD�:a��Q�
���j� �\!��k��x�.-�c�LUVg�A�3"
�ѐ�t��������(;��GfˆƬ|���#X�W��j�_Vd�8%��T�u�jX��;Hl��|��2
��Ƿ���T��Eӻd#�c��0
\#���)��x������\69���`L}�<������NnlU穖��܁��$�Ox�
�r�0y\<��yy��$W�nZ��Y�E_ʣ��*7�Xؼ�h`p"��[��}9�p��`�r�h{.,��S�vUȚ�T�XL��v��� �r�m�0`j�!��������ǳ䖡=h�,��Z�G�
�D�?GJ�^�iN� [���LhS�j�1���:>#�� )� �b"5pL����蠄G�`ORh�K��4r�$���C`��)�F0��ca�e|�W�=��%�	��(]J�ܭǣ�cl�lt��-*Y�M,-�1���5�~~�O�q8�8��4#��:=��X����V<�3 ݈Cخ(z��r��,"fpd=�>0���=��Aik2QP�*Č:B��`fC�u)�n��> ��.?�DD��� T��`���e�����B���7`	�N�0�~]�����Dp&<n|�닪5E��q���¥H�s6��W�ف�X�Í�:�NF"6��Dv ���3�vG���!T�`H`�FG�ۜB�5���pH��z"
$=Z�(u}������F����w`�1�p�0Ɗ%���7�i73�w���ɲ&����c�όʉ��a��0U;��0��m���=�E�1YG�S1f�Gt:�ѨJ���*��촎�qS$���� �8H�W����hN�Kv,�qz-�D��H����X��ʓ
!��5fF�X�l�w	��n�x7Ʒq	��i�:�r@���<b4Z���@2��'�d���2���O�@�л��[��l�ǰeR%�S�bet �esB�e���-1�o� �SPGPG����c��u��L�C�uu�T��Rf~���&|�p��"egd΁E0�B���Ԯu
����,G��n��p��9���N%sU4/gyb9�i��D��(�?u6(���%�Q��g`�Q�%��a�N��&��1�O�J��5]G-�r|�US yUT�g�W�!1f�w�]d`iğALEz�1w�<t=n�I20H�ܑh�����֬�i�/Fn��%���tO1y��h<,%/#�pc�O��L	@��jR�� �p��t�N\e: e&�O0!luا�"p8�aEC ��Ť&�69��33^�=�0�O���܄-���#��|�(*l2��2u�c�hO@�~0
A�Bf���` �}��)���-��x�!����v�L�Y���F�"6�w �d<�kc*�W�� f��D�D4��[F���u	�
������H�R�*�S���=q�@w�$ɂݍ�:�*!��I`�L����>����.�6"3�A�h�'�i)A�yL�(�	��t�:��x�o�ߢ�0p� �J����5,ݏ�Rg�#�h��	�0j0u��F78���$�Q頣٩k~F� � ���4����GbZ��p.A")��o���DB��s�1%ڝ�5�	�~Y�w\p#I��c.}`*q�Mk���`4g#,������Ҹt81�׏L������x%�>Ҍ�)�Fz[���iB�\U_#W7��xZ<���8/�Y�����Zl2���S�_q�
�s�Vg�f��)�!U�U��.;���.�יJ9m+�,7g-@�jHC$�1��Иi­��G����:�9�Bu}n��y&'�$�����7a���[n���] r]���;�����e)5.������ ^����6G��d�b"a�1D	˙�OT��J�e]��~���}$82@�с[�&�tK���7�0`=��	)�hǅ%P}L+���JNCZp�sq�$�4aW�6H���d_aC��ފ�Q%�|:�m�;G��q��t��9�fۆ��%�G��&��t+�p\���'2!+��G�

�)���cn�^�@b LG��� ��"i�t�?�Q�NZ8��A�ANpğ|���#8��g�l���q��yI0I�T��)*�Z��4tܳF�N$���
c�|Dr�LZ,Ǘ)ۙ
x�0�NE�Ly�"tڙ��I���#9J&m��Nf~���R�As' G�j"��9�3ϵs	��0Nχ����YC���@��X�@:CХ0�3-U!���u)I1��v5������`�4w=1�3�f��<�*������;k�iTE�|���#}�^G��pI�&"�Q3w��)lư&$*��*�k�!�� QnEh_�33w�9�Ena�ߴ3�l3�8�v��sN��	�ӆ}���Ud�x@m��`b��4�k1f!V�d��8��.�1���b�� 9��} Ik0� �e�!Z$��($i`��Sl�5�'6�f�.�8l�A���B�JF,2F�Ga"������F�S�|��uqS�Ύ�Z�N!�q�8�����b��~X��C��@�w|x�l���f�Ġ���6���D��G ��nC$;��!k��S�0���~�) zP%<�z;�<�[40(
���@�OaZ�9���;��It�}�bz�B�ŕvt��xz�Ђ�LSB:��,\Z6qV�^��5�y�*��\L:r�l������Vɔ��
I	�=�r��T����z�°1��� ���T�����H�v��M��i,!W�T���K��tƽY�:b���+W�-����L��>�����/'m4
�-�IF�@��@a��r!"�c#��pq��#��� 'U8�u52̈�S')s&X�jY|�L���5����3MpFy>�E!!�K��AwJd�@Ƹ�T���fz	N�ը0�Yi9�Y;8Eֱe��@��c
�Qh�e~>�rF�`'�sL"*��`PJp��Jf���	�<�xNk�Ħ�0�>�du�j�����IA.��)^���g���c�.�Z�(̀�8sb�CJ<���D#3��L	��X�H�	�T��֜M��M 2�e� 2�J���<�ڜOk�}�L�oS$L;�_K3T��D����w�=�{�v�"W�$�A�q��(]wX	a`*�-�0�Ռ��D��
Lk@B����vnI�S�����B	
(|�aaĒ��H!���e�;�(`�p�W�Txe.~;�j�p�Fr�EUq�����Ȭ���Il�]��<��|��g�C++ȑG)p�F+)�	p������x�
�x,�8�=��IrD7
?��Q�Ut��h��+��%����ԘpI���a��
h�� 7y<�B���aޒl�q����ٮ���h)Y6$��oo�$5��l$��J<rZC�!n��bx7�8�5x��@`��.0��U�2I��`�k,���&��N%��a�����	i�)�jr�\�n	0���-��-��rmڳv7�� �G
��&��;�C��c ������+�	��f�Ә�#�0>�����:`�d�9uY��a0�pG�b�D�y�E�+���a�-sǑ�RE�d2��aI� #ш�Ciz�vA��y36�aX�F!�.s�6�3n�>;�	�&������#A�U;�`���7}�|�;��7dZs���!vd���|d,�����2T��p�����d�աE���D��&޸�Ì����/B; 5|G��j��Cbȱh������L�"�)�|�
���8��#'������zv���#"�����(obv4��
�Uv5��~`���zݱy(J�D�(�A���b5&�b���u���ގ�lK��lN!8�r i$������ۣ1JX~�A�=�6�C�>����|nrA�\hy�{��a%x�$/�T�$"H���ɓ�@���5V�;`����ł�D.��,1�R��W�8�g��Ov�LH�ptE�!�1TP[�>����⑈،��R�e���}A���J(�&�E	2a8�V�t���,��N_�a�dDKG�ۮ�n�fǝ�T�����fpd��L�4)56i��rl�v��Ϫf5�⻛��eV(`�9�p�4L�H�M�) ���a���l:lD��gAY�[n,� 0:��)������U!�T��(a��g,�T�J�?�n	=(B=�4c6~n�c*mT���ZAFJ�] ��x�r���wt�>�
���o���>0h�ov�7��H�݃�P��UX翣0��j�T$$qp��`�#�RK�d�(������Nl�n�5�I�@{��=�I�*�6c�ͭ�l�*D'�{N1;�
�J�� ��(��0���4���]�����E�+�����ºmNƔDif� �XZ<���D��:1Ŋn౹���\m�Y�<).�9�N�]R����r\�0�BU�V!���j�����*ypD���4���˲r��K"�_Դ�m�8[���E��!�����s��j�LŊ�%��ERcn�yL�&�`��g��LD�܃���n��,J�F�|�ڕ�?�y'�k�$�n�'�"%T9d,�GQ�fǥ�Vm��J7��[F�aq���NX���2�������E��psɲ?S/̉;c���+�=����6�R����%��J��/��L��;�L�ga2���U�>2|Hg�;������ԡ�0���(�_�`�A8&�N7�����Y��'GޑC�!�� �W_DH�[��!���<1��n4����t����T�8Q B|�G
U�bK.��	㶚��B->fآԖ��K�T3�,+ p(Nz��<=Y��%��e�����=��dK�}����Y>M���mG��]{�b��� "�)���zPV�8��F�:%)Ʀd�H�$���_�V�z!8�@;٘E</�G,a�D���SX�+0�H�6�Kp��b fH��(���m��Ӽh�L�?mk��F�ܤ�"JX~%�%R����L[Qd<��gbt6 �`���� �%��Xa	y�h�_]�Z��0��2q}�����_u�J��nmM�����2a�*�R�flJ&s,1���P'0��1nd
)�E7�4��LJ�e�`*ӻ��2	o��8D\�J�|t���B��Ӄ[DHIs�R<��l �5��g�a�p��bN���1��X�/S-&�d+�����~T��aa��ֹ	bip��m��i]ڷ�gt�6,�y�d'�Z�Ю�)ALeUH���Tb�b��S�̘9�!u�`�c�eX������=�=5�L���Ǵ#�JX�PK��^���{�5FǙ�G?�̐���4�A��Ĝ}�YL�d��Զ]��s��E.2j�.ӗlr� vo5e�AFLP�z7W���,`�XJ/�	na�!���H�]wZRb�e���!�E��>�y�? ~�h��9�Y41����D.���&�A�&�Ƭ.JԷ�Ø7<;f*�U
��R�Q��X�0-v�M3�4#�H,�h첻���V87����Lc��P[��Ć)2�����̢͆Ú4��QӞ�8�#��"4��ҿ̔?�a!�BSQ3�RR	�]�H�36�Cp
u���We�6@�o�V�	��p���ml��M	f!�t2�9m ���A
��C�\��/I}��p8���̓�5�~g4%��Ґ�Ru#��.�&�)wЈ���AM��cf:I1�+J���L߁�c���̴��U�d)]�v�5������+Ò�"rl��I8��jpq��|�aJC�c$��� �P������"S{�xڟc�nɯǽ�@<H�R�u��у���S��E�<�vq�ƞA%n7X�r�l)Vh��e�Q��j)�!]QgYtX_B����fەw�[Bč��݆��e�: 
]��n�JxF@ɶH��N|�lD�	 ��	˲#�0��T#S�=r�Y�1�a`�"Yz
u�i�*�"�0p�a�t����� mi����m��F�!�ʄ���f {�S��"=�~�l�!X��7�H>Տ�7��3��j7C/c|�5�`�~�U'r"�|!5ŵ�d���s �HR���;�Fz�Nu��^!Ɉc���(fx�1����x�
��Ze<�Ĵ$�%�B��R�U��������Phӫ���!�x1�%��$QO�D'�J�+V0}n��t,�g��	�۴��c���i����ff��CELe;�<c$`��Z�~Hp�&����j��3U;�_Qcq-�m���)U%3�{�	�A��MxO8V��"�����H%W�W�۽���tg���y ���6==���:�a.�p��: ��@,�B��XP��n��J�I~�i��S➙nfw�JDw|@&;�&d�iKv�mvT��'g�)R��ه&=ꎔ�.�GDЬdˍ�:�ֱ1��-��IWnNJRzLj�v7(

� R$apu߯�[�,��8����`�L��L?�2�%C��"vo���,����x��x����Nٍ݇.���:���>O���Y`\!�>m�r��g���n&Qg�'�tY8��`�
�����3�>aXJL��+�.,G`�� ^C�B�Q ͈&�a�P��<��[Z���,#�2-�p��l�����H���� ��|�$���v�4��q؍
v	���*��U�سBn9Rj ��
�@�X�H�`11� 5��a�ܬ�Ơ6��4�du�#ˑ�a�g'��K��Ym$锔�K��-���9�fܖ_����	$Uފ'I���yc���R`AT*iG��]_���C0y�	 ���+H�ÜU�Rcp
���� ��<]&�4"����%ds����>C�Da��4T'�fV�.��]�F�Y��.���L�,+�@.)��'8St��1�����I9��(|(J=��7eއ5�ۊ�6�M��&
��؉qVTF$�a@�@s� W�-ad���J��icg�Q8Ӕ����	IdM���oa̋��hB�0}R"�Y8j�9���i~I"�c� D�yݔ̖h�)��+<6�3��i/,4��eVd�م9`�F�o1)�J������2Գ�j
3����/�����b�^;ٮ�M�֢Y�u�6M�
Q�\�U����l�k{��{h�a �Y~�Z�?6�o6���jHLT����g��S��N�6� ؚH��4� C&[����
V�{֘���
#�8�a��jΌK�	~kހ��0�
;�ꬕ�
��-�Y��ng�rgñ\9SܲM�F�y��N!��E���b���i�	�h@�:�mo�%'KJ9��.��i��5LȥD�y;�q��$��l��� ������%3��\;?��?1"3��r���L �S�7z�t�X�=�z� R�%���.�MaƢP89�B,���,� �n��n�T�΄O2�m�f����r���GN�]����T��"J��mAy�}Z[�<gd{���6�a7�p�:y�N:��>
���I@��6��J�,jf���f��䦔@� w*$���;�;����0��#����E����l�GO<Qn�P�u�������4#�Q�M1lF@��| H���_.�#�� x�r�@���a����h��T����
C�i���� ��������3���$���H���L5ʗs޲����*Z�j���۳��P:�Y�1�*��<,��R�Y������c�-)��w��N%��N�"Ƹ&�̚�,�jsU'*�2��ȿ��,�TBY@�{�ɡ�J0��U�KV��B��b�u�Vae�Vn\����(�c�����R�:����!�0\�'�I�	��N�}�D'�m���������5%-I���h�a[�����َkLOhQ�l�B�U��n����i)Fܧe�i�e�I��Z�|q`�F5�[hǯ�3> ��i83��s���4�99�[�:��1��W�@m��2"}Ü���I>�9B���i,�șs�y�E̾�6
pۮ��Xp��Rݬ�othY	�)e�˨� Ά��/BW�����(�e7��K��I{p��.s%J�Y�� &��sd$Y���>��������rH�|R�yB!.�I�4�M \������M��M�n�Ē�7�-u��' #�f'ҙ~�J����k�*���,GVp�v�EEKv[/�&8+ɡ3ά�î2$']0u� �+���p�t�Y�!�r��|�	W�k�.�h,_�&_��29O��VΨ�C�
>e��d��4&��"����Ǚ�
+�Bsq� �ˁX�Y��I��YמؽL����B���:���XUXv��'+��b�="dƜ�<�&+xe/��T0GY?��X��e݂�(�P�S<���61ʱ��"���J�1�1������:��΂D1V�R����m���e�`r�� �v��Z�\�7`�l�Π��~�E��0�+���XW�<q��e�45.P��q���RL�W�6Pg_�I�i`BuFJ|NI������ʟ)��@ S���fno#�IaB"�Ư��τ+�(���{:E�Q���}~��buݨޭy�L��б�[,�p����m_1�� �n��{*9��)��ͮA����T���>x�4����#^�)꼱Ű�V�ͤ��5�2�����C��Ľ^��p8����o����ȍ���(9f^G=��7	*#�)ӣKwR��	B�V��Q-�Ѫ�I�ؘ���y�VmB�"�HQ�`�i�Cm��3�8ZZ�p�h�Q*�o��%<��V��O�춒�������J�
R��o�BR`�<
�v�nP�¨�W¥��@"q���ݑ�a�D��%��p�PD��RӂD�'* ��(����Jo��ى��WZ�U���7R���oVb�p��:�(wL>Mg�!���jb&�:\jH����z��M	Sȯa����Ѡ�j�\'���q��6��$�44�ʅ�JZP^�%?�,۝N9;�V�V�b*����i�9���O��fL���
qE�'�s��I���{D��*�N��c�7~��tn���)�s�G%���fٹ�9I�U�E6_�V�ENzYC���Y{��,V��E��2�;w���va��5�Y�z��&�K���2;��*�)A}�2* 5�
2<�*���69ծ0�"�4b
Hf�t*�y��^��W�d�ۮH"��6ISHS���t�r1H13���Q[꫸ �f���9bud>������vfx�X+��(���Q�U���L�jA�%�m^�rYf�9��Α�=�H�if}lQzZ
��&�"��`����"
��I1��Ȭ�+
�H -�WA��,KI�m��D��%|.0vq0��J�ٓI�`��zhx��K�慦yPT���;�wAM��CPS;U+	��:7����������2�(\�Τ:�c|�o�U��d�ai\�ZЂ[��$ә��S�0"�����xMU@�T���B"�ׄM�h�ZE�?���dM�SP	�x���	.lF���Ź��+�)��G�p�T����Z���ʅ�G��=�M7cS��cq:V�Vg�b��n�⋑h�0�ڰ�zY��f`:	�I��b� 9�Q�[!9N�+Q80TqO)�����"O3hK��@�ǚ��A�$R�#���8�V�	�����<'�
(�U)xi�_�E�Yb>g+	5���%��t3�(in�j���8���%��xuӵ$;�$2|�N���7�,�L���;�,N�Ҿ~ӽ�J���YLx`�+�,�3�O5�yD��G0�C\�6O��l��)�J>?���	�bk�y�ԉ�.Ŵ�ݖ׽�L��Da��i"��C�emn?�����7�m�:d c$f��؄� ���q��)��LS�홓����六�r��U��#���Ƞ7s�������1���)�3�}H���T��3l��l�̳�0����̴|1E��[��o�Dq�󚾡�}s,����A0��7t^�@\-3�P<S�{bX�^Re.�K@�H7��SAK��q�䗷�8��3*~��*<QK<+&.nױwW��=�Pv�@�LS㱝Y�&d�RB*&���_W�|�&��5?|$�E,�&8Q<�,;S�9/�٫��`F��e�{)�Ђ�w�z��(�T(K��gr��%2��B9�<��SS�Vc����:��$�.�U��^|!��nL�d
�ۓ�((QǼB��d%�W+r����=X�[2o���S�,m�V�ߴ�L�%ؠ�x����v����I��'��w/%�GM��E�2[y�(��`#���1��to,�s��>��!��1�3�E�>��Ѣ�y��g-�^/2nJ�D��x�$H��a�3�)̗1��m�3	�ܰʨ�< 5�a�/�E8����/�L.�9�B4S�Y獮\I	�rq�.^�����{��uJ	�IM�;��'�+w��-���	!{D"�,G��n$�n��L���	�]'F�������1_�.�b�?��I��ѵ�v�6(fv7{�"<A3�x{e�ԩ:�g���!x���ǡ3�Lq�}9����)6�w%4��!l~���ꖹ�j;��س%����+���m�Ca��æ($�Kxk�'@�)2\H3`\�4'hY<�6h/�d̮8�Lg�4�'�37���V�4���䪦����)��&| 765�i����[��ړ[j�[��ڦ	����y������S]5��V����oN:����E�<��^n��'{�k��*�੗'7yZ<�ch���)M�1c[��u5�M�\��:ʍUM-��f�c������j�]�dO�؆�x�a42E﩯q˵���Ʀ��f  ��L �kᡧ����`qˣ`�����+�f-n	g�m���?���z,�Y5�S�|�k�F{Z�a
�]������Ijlmjlh�͑
a@x��y�+����Ze؅1&T�W��\�5K�M�\yJC+�Xw]�)��Z��vtmu�gR�[�4ͭj9��[`P���N���x����͵M�<Մ����*Ob����	Gi�gdT�Ò�̀G��Zf�)�v�Gk}b��vb+��DvR	�_5���m�	i� ��3	Cf��.��"�)@b��h�N8���j�4Kv� �-��Հ��x� ���VS5�jLm��2pN��e�-77�V{�x�P�PU�kŭ�/� r�1�����Qj���X/�����fZs'�\�Ќ(�T�T�1|����M���(:cU�խMpް� h�[�z��n�z�{�j$qȈnGWy�Z�	gn �D���`-���n��SU���&;��y,lŨZhVU3�CǑ�@z8N`u4�#����n|%�I��I�T����`z�lt��~o�`������Ա����*��f΅ct]��K��]��.��g
*I��6;�c�uv/�̦w$�������T8����k�Z�{
��M�Iw���NDXםY4)�L����O,����9�����NU�"���"R˧�ȫe�`�"H��>dtYo%����<B���N���:��č���n1b��&�u�G�L�q1-&9_���!z�&�F��$�/�oV5�K�6/I�17&U+�h���ꔩ���@��%�KC���!�4*vۂ��li��}-�㍘�_ܛi�j�,JL#�����{��od��L�ƅ�2w����:�_�sq��+��uSN\���_�x��?à�D|hoTSAQ��D�A�3�W%ZVfu�\�WP$�(Q�t-�5�"[ñ���k�{�ń�#�P�@�.�c�p���Oz��-��$���>�ne:o�f%4i`��|eUF��2B�ȊѢ*�4BS�0��b�K�<-�n[%*\��t��l�[�*3 q�]��"r��cQ,
�vr6��	u����l%�,\2+hTyxG,1�ss���r���=ڞ+�<rG DU����m�%M�x���f��Z��ߋ�a���Q"����Ȉ�����A���-��xɊ���$~6����*��acT��9��ł5���p>�ݝ�$�c��	�U���Z[j���
�K��r�s��+�6\�9�$�n5��0?��X���w�M�A�}:_��9:�:�#�]��l�tP�G0��9݉���/6;뿦qo�rC��3�m�H1�"�c�
a�Vpa>��c;�om ���Z�]�9x��.3M��L���YI��p��nL`��i��~j4�R�М��ޮFA.,x�
~	*�T:��7��cA�����9��"�2�����m��v8��p,�t��6{q0��b��"�{���v7�ƐL���T�k����:V��q��$l0�L�Dt\�{�֌<4�nG��>��_���%r�x:��[� B�0�+�Λ�YA��O��:t��������f/�:������H0�#
���H�:�L��A=�D�TÝ�c&�fd�#���X(�Q!�w���"S)[]rdW.+	׆rN3���Be�@�W��$3K>��D{P�X�U0-  g�_m�l`,F��<K��� �� m�He�w�0�s=�j�X���[�q�p�dk:uZ�4ς� ���~�YA� Tn��C1���������e
|x�[��pz� �ZVq�����_���^����c:�g�f���Y�����3@���iɘ�`@��l>KĊ��q����軁<Nz\�w@G�{����A��� �c��SY����Y�%�#�M�v�8D�ݡS�7nR���#V>��چx2��W0��/�_��
♉s�T�M�v���氻B������K�e�� �Ԇ��ڦ���mni�P�@M@QY)g��mɐ������L�̘��O�cݐ+"$F��g鶆uǧ�y�H9#�ܨtۼ�����`vh�t�ayĄN����� S�9X5��X�"�<B
�܆l���[K4[��g�Wi1f>��J)c�ciIژ�cL����
ƕ'�f�t��0���fI��ْYʮg�&�8�	 1;��@��Ng�X9:mc�������J9B>����eJc�L��K� �ܺҥ�]�����Cj���B�t����.s�!P�.�bb�K$�W��4��үb��l����
��n����<1TL��Tp��Q��&(a��,�e�Y[ʢ���J���F��¼Q5 �����ab��-	,_z�i�6���+�<!�NF�ZVuiT�ǟ��:`m�.aVN������qe8ծFǨMWV��5{2QL������l'q�1l�	p�s�j<�rh;sīs*��pXu%���Q{�����sq{�y��U���J���.��}3F�r"�$��t��_�ߘ�F)��~��T�,4�|�ۜ��I�oɜ%=�gd�"��M�
��ǟ�ap��ꔞ%�`5`L�]�]ǜ�q�#�hx�bl˄:+c8Oe��+]�lb��s����%,�)PPc�8�N�2�mU��e��.y�̔��&O���s���J�����L~����JFt�.����'l;���5���ɴ�]����cҶA>��=�t��,,�b� �!{�!�ΎU3yʻ�$��e�e���V��C6�=6�ˑ��x��D��`�ZП���{�K�,�{����+���\�\���n.��Z'�_����[,�=�#�<�Z�GR�~� l�q��v�wAB�=����.�a��t��Y�cD^ҝC15?���gJ�U~?�$�[]IPW�\=��=�og�#�X���@�J�� mgsak6�ȩ49�^&QP�Ⲡ)H��k5P=.V�҅긋�����ЕZ�!��tuh~?(�\_T���Ƀ�J��t�,�6��b�������'.B[�H,�׻�lo<C79�jĽ!-f����/ۈӭE;ٲn�[�8޳��t��|�m������X��n�朁0d��pK��m3����POt��J(�iw+�pČ`~@#�\�z�@YI�+�'�;�`�|�a�n��{,�AoE*p��R�m3�;�6z�{G�9�9������ݑL���S�,�[g�!���X�^����c����?t4�DV�Q�K�q�������ώF����u>�5�=>$��wH�����[v;��'�Tw������@Y��H�9��h؃vv盛���e_��8���5�J�ca���4���R��R��[*�or2�+�#��	��4	����r��*V��P�F6П`��������<�go���Ϳ��of{��}zP���'��������� rL� !��fA�r�,//2�9i��2	s竡���17�}t^�y�����,��곳�ůw��_>L(G۽Jf�[����g�
�n���C����v��G��pf{uؗ����5�����w�8���D�\��z����1�M�)���T1�d0,����,'��~>"-����K,Z�ud�Ȼ�	�Y�����޹/��K>�G]�Il
���J����������X���:�u�[�pP��l�&�Sq�������j��'�L?�R��/P���Oմ�L)�͛�;_-U����j���J���[�S� �ș��0ep������D�ٰ�!�y�ڕ���Ӝb�Sm�z����U��r����8->�o�T�8����]A���8#KsN�͌1]*[\�&2-��l����t⡰��)�Eu8��Vws��(~���~L�AgD�5���٠�@��ƍh�W��N���a�l3�����Y,��j٬���WW� ��&7Wn���m�7l��\�zcC��F RƲ��5��iխ�<�D��%�\��*$)w�TM�zV��K6���%�0MZT���/��Ґ\iP,���E�۠�@�a�9rF.Lچ��e���6K�c6%�9R�@f.Kh&���aWZZj��#�k9x
/@��%6@��]^'y���V��t�1EO�Gpd��&���tk�fL�	0:�Ӹ�:P����c�hyn.]��WS�C�;�8�mp��h<Ӆ���,;���1���T�1H�T���@�P�bTm�zh`�u�c�i��L3B	ۉ����6%e�&l#�!b)p������>%��X)���gfi����Vյ�U7Lh���6�L��&{��|�����8~��4������)�Q�2�"��c�AQ)�SGڡ~L�͡�iV��|7��l�B�w���_2F��e��BzX��7��$0c�����+��	�`D���]���HK���*���Xo=��x0��"S`�Z;+T+�7��Z��6�HQ�j5�Y$��_���M1]�#~߀� K{�s�k��7T��V�+�q�n���f�%Ǧ��z$��f�b�Ƿ�⥒4c��btH�dq��+�"ͅ���D�8]'�^�b=��5���|!�/��0hC�VWϿ��`��҃n��=Mb��9Җ+�l���?�/E���Q��7L�N�����{��ғl_&�i���	fU��ݦg .OUO�&��h\�m݃�k ���խMM��-mU�m���z�G7�sS�_;E����P�Sq`��h��5��e���x��ڲHT��9��4�����=�Pc̀���L�"1%��a^?���!`|��\�ŋ��9��O�"��Fu�� E8|t�I��ԍ�o}��إ!Բ�Ii�O��Ӥ�*�<���ވ�KW)�I����J��ҁ^�2T�	�����^��Yk6����k��W�R��-�N|S�m̩���8f�m�~�S:�>��{��������5V�۴��xk��-�:�ׅ[����l�y��Y��M^�}��;�vM����A�Ǝ��R߅r�!�:�ꁾg��J�:inը�&�y��=�����?z�?n������n�c�����O·��<i��qǜ�J�~��_�?�',iزzmǪ#뗮�y��5��=f���N�����w�]��W�^~�7�?�֯t�[��nX]���a��"����{���G�t��<E�&�xQ��?�������/��q�Cr�>��O�t��������g�{���>�1z�)�g�|��ww<2'��\=풵r��ߌ�n]�ܕC��2��������}ܹ7}Ր��y+������^y���;OX��U��}8뚟o[v�)�;[���?߶n�ag����;�Tt���曳_�yЄS�����O2ZΙ?�sW�#ѭ������W�8�'Vl>���ݛ/��e���-�=�9cゅ�w��l�M�-��f�%��oyh[������ʹ�k�����	c�Pߺ`��\ֹsV�\�R��Ւw��a~^��E��~��'˴S�-�鹼�'�w�j�y[o����KE�fʱg?]��=~}K���3�������e���{���v�m?qmw�5K����yѭ������vj��d�Mo��}m���|��ONx�Gϳ<#�9�żc/��eC�<�&���<�0�������Ŵ'y���]?���Wo�<��g��3��g�>�gθ���WgG����蓎��|��:j��7t]������T5}��?/xj�k�o|ƨ�o�������4h��A����~�?~w��߶���C�����E?��{_f��ן{yj?����#�Z�U�2W�̌/�}��߳���k�G�pƆA�^4v��ʎ���#z����_V��菞�.��c��?�Y01��[����wN̟�׺'O���['�~�k��g���'���댧���|��C�WY|j������8�kJ�]�[��������؃g�sڇ�����Ͼ�z½�kF����.ݯ��w����Z|�2�������?,s{y��[k~{�����Vߢ�5^q���!�	�=��?&�^x|u��'\��I��Q����
o��ya��[��;F������4��w�Ak�޽��(�՞��~|"���%�W����8�}�+�������W}�_�c����}�(�����.j�i�>dr��K�N���ûF,y��o��}�e��j{�������GfT6��?v��5eK�]�՜��u͵�_T���I��~w��:��ε��U����Ǟx�Y�n����E��㇍?y�c%��S^<��U�����U��9�`��߂��gN�B�~���c���	�<lA����|���Лe�S����փ��ix՘Σ/y��/�s��<2�ps�4���Q�gN��׌�&4���sOgݵ�Y����=��T�`���N�g��ӏ�����������xp�O>r_=��7^������<��-ӟ�1������HƧ?�����ny��/�z�������~�����u����]Pq\���������˹��_Ժv����oK�r�����=��e�/|d�e�X*��>�+�q�c��-;g���/���%��9g��%���f=�����~c�[��^8��_gy��|u��}7\��ĥ������Ͼ���=�׷�)��{��>c޺yVa���\�8��������3{�M�-8�Ӿ�����9g�{5���3d����Y�5~�y�+�o]�蜊�?�Ť��y��E7�({o�u�N�}R�׵w^�(���K�yͤ˖���+gn��������n��ߜ��mW��˺���'���苪~�\|�c�2gƀS��u����+�{hٍ�_�w���M��wلc�~�������<d�E;���zx�kJ��w/��.z�Ѭ!�9��?yi��o��މ?�θf��?�w�Gۯ}��Ӧ|{����>+4���1�of��⭋'ͩ����y��M��_���.z�}�e�W)��;xÄ����X�qJۇG��~KE��3ǟ�yƁ��Ԍ�>eq�w�����~��z�w�.+���Y�]U��F���<w��El�a��QG̟�g��@�Ȗ�S{�u���z����]�]�Ɗ���������7~���6G�ѧ�5����_}��r��}m^��m�:p�e[�_�����6�|����Eۧ�qּ_'-�C�m���f���$�c�~q莦����|��w�-z�#��38�sу���s#��|͑Rࡹ?=�9���˯�g��=�ڜ����t����z��;�%�n�xws�y�:>��Ƚ�{T�M�q����qvS�W3�8�\����_�η����٧�v��3�}���O��XU|Ӊ]��;�r�YeK��z���>���l��ܧ'�5��cal�~a}�/-�]�zؒ��/}�������~<��'_�ϸSk��qx���t�Y|�k����uS�ܭm���گ[b�_e_�)�ވ�??z[�ot���>O^:�p틯��vפ�n[�S��)��~P�]\�~������������v�;yf\ro��~���Eon�b���_r���_�pк܆�O|=��[G�|hy����>yw7��X<$tx�s/Z�����e�~�g��=��s�W�^�9���m7��y���c����B�a�{�3�}z���?mĻ���v�>�8}����q���;�[��֝ߴ_y����9㳭]��'�s�7��4v��#ǭ��ٴB���.��~˫3�i�q~�]�_�f?�[��ʰ�-J~�ↅs�i~���G.y�ꚩ�7���s�K��n���.m�}Ӊ_|Ο�^�w」��O�������sAN�7o\0w�:#�{`���oZܳ`�yM�Ͻƛ�r�)Oo��A��%�����y�U�ִ||�v���X�캆���;��uI���NYݿ������/i���C��'����V{��_m��S�<�,�[9��5k�[��uw�1𗚵y��:�߹c>;��c������׽�M��>\���g7κ�����>��薑+֟�������o�a�I�ck-4��Υ��ҭܲ�����Ec댇�{��1?����<V��c��8���\ϯ3�,y�F��ڗ�^��OWߴ}����o��[Xw`_�������u�W�xܚ��K;6|p�K����x��˻���ݽ=sc`֣gn�~����u�^y�o��?��w�9���9�����(X��۳O0���m��7u���l��.�j��^5Z�oLV+�'��r�璢�_���k_ڹ�gFlx�f�6��owʲӿ�ql��r����?<c��-�/���_��Z��E��Ox�齏�~qU�������f���G�?���i�+溗��D���榽l������E�ά��}~���?�U]]3zڐ�x�{���̙>6��'��}��������'/;x��O���~`���=��Oz�چ����3��a������%W������ު���/혮nj�?�˓o�4��?OY��Z���sG�s������疕'�|w��D�?o��ȇ�f��Qy�4��x�	_�+���g��w\�y�w�s_����֝�zх�_7���K��������K��g�)xxľ�n9�&�{D��?��]z���/��Uͳ�;o�y�Ο�p��s�t�m�o����O��������a%Oy+���kJ_=b�S7}���}����_=��3�����yf�ʎ{��v�i�O��p�Q�{=xhA������~h>���矿��Ň=4祩/\}���eU�P��Y'i놬��)*�:��秝�����?��>��]z�^�{��������#��w}�`ô�����^���b�a{����ʉ����{���S/�����]��\��,7��oz���_�����ԛNɼ:������憣Oɿp�}N=:딌7��8g�>u�+��{�;phxj�ޭ�Ꜽ��e��|�	M��tU����]������+����??���>��S9������?���~���w�J������{J��<O��}��}���z���1c{o��h\0蝅g�9���_�6���|���\�I�*�����|�w��W�;�����;ꮟ{��T�׽���^�B���᯦o���{�#���ɫ�{���G%�����ȧ��+n;~Ω�E;�y�y��ϕ~\9~}���w�y�a��]~�!G>��]�u+���=�0�s�����h�0�����>������=w��l����~�j#r��C��p܉��;瓹������d�Я�f�����������O�>�~��g����[�a�E�<5��>�jy�_^[��3�v��w���î�:�_�����ۼ�ν��U��f>����ڎ�\�}�k�~X���/{EJ�>0�󝫮QJ[��3ՏF����k�Q��y��ƫW��~Ϲ�����\w���WO��U�O?e��m�?��U񌪺[��{���~��ᷭ�6T���';��ݲ�I��)vv��#焎>i�^�&�<p�~d<��dA瀓g?����;����b�+��~8{�=RŦ��qw��_�w�C��8�xÌ��/�F��gw��Ϭz������8󣳾<�~�~x�'3Y�����KF��X����N���3�����ϭ�y�9�?�����>~ ��,O�ܯ'�y�=�x%�};�^9�w���6�X�=�t�����x���/�s��s���]E��&�u�mgd�D(\tfN�1�����@�7�����[nX��~�,��6����ox����Fz��x�����]���>/>���g�\>I}{G�>J��{}q�Q�u�_��2f�%]=����~z������ʢ�KV�q܉���rD�^�X��֎�w��׍.X��?���o�����7.*	�]{zV��������}�i�����앳��y�[��Ђ��o�k�6����^<=|�Uխ��~*}��O׿����>�쓷�/K�w<ܯ���oze��D���O?�w��S��W���ٽ������d������0�g���� 푍_�޷ꈦ�:ntq�3x˗�|uٝ��O�1�+煢���"�����\��!�Z���y�ׯ}�r@��a������^7>�Wx��[�͗��������G�U���}�>���/����{-�¶!,�'p�o���Ƒw1��M��qvl�_����c꾼���6���4I�~�]����O��xæ�����#_ع����>�����cN�{揥�����݌o�W��Ov���C�~���'�,��o��l��������[_wq�.�y�Gg��Woߟ���)���׿>�i���^V5���wn�����??3렒���u�1]��pb�#�M�p�'��.�:�����5�+j_ݷ`�}���=��a�%���v�<��ƟC]���x�G����Q�_�b����w�_U���۲�5 �xu�с%Ztlc�m۶m۶��c۶��c۶m�9�������ӝt�W��Z���'~�� �=����xw]q-�m�	�d�����g��fol�U/�l):z�v���DM�ԋ�Ta�G�3�.%-6�,����̎¹���hd{�pz}K/�3IT��z��7�ї>��4?�=a���X����ݬ,bd��)�첊�y���~B�6O��b5��g(�ݒ�N�L�	�E��M��9L�*Л%k݇<1�H��P+����`�����ݰm<O�����aySr}�Ɂ��o���j5�}^VBD�G���&�@p���W� 2m��L�mUT����p��[��5"#�F�T�~�x�i����k]Z�{���Z��)����q�	?�\�3�yJ��Y��U�*��y��>��{���Y	���\�k���<�|I55@3xQ��-�6&z�G'�j� �5��ob&����|�5腢?(�2UOjJ}�4$O������M�D�fHsӶ���<gy�6V�*l=Nd{h�x��N~)m|Ƕ�������|���4V���	�'�D�*�[��?+HQ�}�V�w���Z=p[]6����4l�"-��y�����`-	��#C��ڥ�Q�<9����S�R*���2rcЃ���
�H#x{HlO�?!�ُ�[��In��@�B��Id�S�j���& ݂_�.��`�'�d�������-ܔxD=��(	x`ϝ�3���y�\�1o	�U^�b��Ϗj�'��X�b�O�량h��{�Z����8�J�2TOAZu�H�/xk~<��D���(Uj�*�ߐ��(w���u����ɾ�J3�8c��e�e��+��-zKBHtՀ;eAL��1�8s��iMtj�w}�(K �I�z��
�����Df���<�&�m�p�^_w$�6���h�������.��<*,?k�N�XE}Ck���(��d����ǓtV �J���)I#|�sCP��iA]$�K~~әD��Ŋ��FR�|�2�Ǩ\pS�<�Ζf��|�ҭcK2t�g���m���!�x�����b�|�E6���ꣶ��Ͽ��X��V��c����L99q��BZ	p�V4���( a��gL�� ]�#��%8�A��T��}��RT.s��Q�H��J*؋/��V����P�M��הoE�w�V@���iwl�x�Ä�_��+�g�a�U�0�\i4��?�O����!��D�N� �<��F��W)r�A�ͧ)LVh�����r��J�Ld�3s;�����L�������3ɥ��6��m�E�ޫ��f���Y��j���ViX��[?��1:/���b����] ��v�_ ��{HЌ�}8f}ui/�z���R�<~�5�d�k�X:�,v@>�R�F�t��"q��ij���!��OӃ��دE5��d�A�=��nfjטW��:\g,2Zǆz�ZV���h�d���Cm`q�Ik� �:olD�C�Ū.N}cbW�:@���P@`ԙ8 Mt1��hF���8�=�H@'��3a�\�@0��n�9�Fr%c!4RbO1G̗5o+��uhc2Ŝ���L`��8]�(,[���D[<��t1�w|��P>�dR9�}2�mkΦ��}T��yg�TSYI;���@?S�d5(���S"T��G6v���z���OE4DX�V�Z���a�@�3�IphL��R��F+�S�k������A�����?�]�'U�y�Q
mvK2c�[=Z6yo�y��ꂮ�����yՂ���6��A�f���?��˸��]�Қ.]O��+��A�{���)�,K��ɗ���*s^1h�2Jr2qţO�{�0����g��f*,�=�c�S&<�l)�u���ba��y=F���S��i�e��ݳ���T��7�[�:��K	�v�[�.�1R����)�3��AwV��Bh�X��X��f�ޠ�:�T��{��Zč��
���j�]	Tϭ��2x8A3�a2�k�}HtAY��������� %J�z�j|��L���0�) 7i;��P;Nbض��S��ցyXƕ�:!	�ĥ�P��f�+D75��Sj��55�&�͌��؀S������m�dNR��ԝ}0T��#ع��?�����X�.[D�`Ƥ�T�:�sv(�1�r�_�_\D��� *��j<T^сn�2r\�V�523sH����w.����C�@i:��#Xlyv��'��ŵJ�Ɖ$���y���'n`X�nU��[����-���,z�Wd~��lv�*����3��F�3/<[�-@��[D��޸�/=~����I/UM�=��o���@p`��^59qňڌ����u��?� ����vs�V��ʘ7�����F{Kl���t�$�k5�1��8���w'\�Ai$��`Q5q�0�^�
U1qҪ9�9@�+P��;�6J?���8��vk��,�ucY��EgB's�TB+�����B�~��!��?x�on��t�_�5�rY�o��!�s�	e5'�
�i�Gp��>@?���K>�s	�2ٕ==���XGgL�4�`���-���VX#�^5E��j�����s�*G�>a�G'H}tm,��ݻG,�V�i�L�� T)����ߌZ�1MN��V)9U��4N%����!��]=�GM]�ߗ��: q��/� �����`�����_!�ı[�u�<u�Ϛ��dΤ��+���O��>���0��e���1Mԅ)�Q\�c���P(���Лvc�O�$�ԒvE�l+�v|5K�E�v���ǁ�n�􍇴ՠt*���*�@bD;�6)��� glD��y�v��94މ͚J��;�����N�����l���Ϧ�3g���/.�f��E��ҵc��H9�+�oIA�O6��H���^a���=.q~���m6�f1e�������k��T��ۥ��I��$�_QW��xy������;�M��@G�r��n�Z�꓎i�O�IwDQ���:��$�S�K�p��+O{H^6"��䪶���֯���4���Cy  %��\���УD�P��5�~ʧ\^�edM@�]Ѫ���R������zyS����2v"m�b��f���&|XcB�@����L�i����]����}�CWWm-�j�-��Zt�Ĝ��y� �	�(� Y(m�����0��`��[�#Z�hRF�L���ݰ��c�i�`�%GN 9B���x��7���|�
M�gp���]dSky9�	'�Na$
�X��r�c�n�5�@��NP�!O
�^Oa��'����`F�<sn�o�D��MXA����������r��i���Ọm�������H��_^?�o 0vZ�CS-2��w⇌�i�XD�����9�yV��-����2�G�@v�4F��~�E����1HNbt��A~�82�\v�SO䡑@e�2�wl��ŕ����P�BC���4��a0�ٶ�D���G��8��e4y`�e@�W{i��>j�J�e2@�p���!W�=�r���O����ş�c���XՅ�yq sE|��!�`�]���.�yc�UϤ����Ib�Μ���
��=�[�G!;��Da�v?�m�V�"�y�R�̿�+��+����0��=#?OWzlS�1����E���[��̎�w�_�YE�ƐAW��.&l?�Bh�Ա���p���5oA@�9@��r�q(�����mt�E3��7�˻{8�Ф.fn~��_$�?�GD��@}��V����	w��vtdܘꦥ�rY�N�{e/���dJxs �I
��h���r{[�M�1�c�\>��N��3s'�Dr��(�F*_2��-(�m��eU���t����]�B[��A�	�H+K���7w�j�
]�Â[�����=0O'��#���u�cJ0#�t�J�����	�v��M���×��&�iń��m�aE�sH{�}�@ə��]���RTn�$��Ǳ�(U�K�o�U#A�����v�� 6����d�i�>���ں�xIX��觧�����uZ\t�E�zv��b�e�I�(]�xI�t<.Y���[0�{����ʙ��)}�H��Ҩ�����h��8�uP�z�H� ��-���Zkq�|G����)��|ʒ��J���Bژ��D�( �7�2�t��uq����y�)hm���&���T\��.دir����%d����{�_Cb��q�@
dFk>��P��ƍ���P��4r�)dm�_Nȕ����$\I�H�khj,
��Sd�m7v�n���c3��{>��~�^���������D��{��f���e��|�^��L�H^ҍe���&��?+�yxE�W�ę�l`V��Ř�?�J��?oa[0�h�Ę��ڡ	i�0'N����=ϴ�
1ϫ�]���t�9+�3-�=�,�`a��B����a�,A)HC��E�0GWw���]�c*�����ɱVm_��D��q�=��G���Z�xP���C��R��C�=�Ii���Zw�1t茢v2�բ�t�׽��2MN`Mbzi����� >f�)l�uz�m�xGI�'j���o�6?���~f��*۔F_�7�[o�ebn�%�UkΦ\g�<�q]ٕ���ōNو�����+��X��i�u��kj/�O�����������a�m��?dl��e�����7�b��=��F��>�?*�<�p��"���Mu!���w��WyI��;qoa�?��� &������~���eUʴS�	�uK�)��)�xs}b��֊�K��Q-�Ю���1�~ρ� V�Lo�⃹�������k8�]�Q3bh�J��"�:� 7��?�*|��|[�s�����S�3��*<�;�G\{��;�
���5�)}P �@����W� �Ku����A:������oi{lwx��A<�q�������M���퉇�C�]֩�)E��Շ�Up&�9�dO~P��>n�U��p��a��&י�� ?��d��'ƨ�U�t꾻A��(�ܞ�*�ھ�B��ۢMؾ��`�|�ݹ�(��� b���LE���Ȧkߦ���繪� �N��?�A c����`�X�[�tVΈ��Ӿ�"@-Z�t��&d[!T.rJX8Fe���^�A�ɨ���R{�s�uf�Kx�l�h�Wr;6�;s���۔X��1�L�'�I�?��ݠ��*����v������%<P���Ђ�P�Aa��dߗA+�9�#g��>�_����#B�P��@�]|�˽���A_?��{�wK��rA�:�����V�O��D����o�J0����c�"��
	��� �)1�[�0l�영j�|�������å�W��h�n� �P�~� |��`_��X���r�S�@lAEe�᪹!���� �k~��H>����u���Dt	:bF��ؾ�2,1 tJOe�9�Z���\�	8���Ǯ"���F w�u���i��r="�"�IS�}p��e��F�c��o��vr@p��X�it��~~>�@
@q�r�r��q�wU�( ���:'� ��@��2�+���%>�ɰ2�����p��M��X�(�u�'�x+O׻�j@7*��SY�����P����)c_��d����|"᫨���ݩ�j��g�P|������!{���m����f�`���������'� �O��,%�{�?��z��o�o�`M������}����o;q�X�Fg%�����i�{gv�}>�t�~L�T���/�.��1=����5|3]��jsӅ�2��Z�=KRL+�g&�-���8��`�����C�%��Ŗ�RZ�������Ub���e}��U|e�#�y���.�?\;�K/��fK(�O�͘��֤��8U{�J�
z��Oo�B��>��eچ��M��2ܘf1�Pb�o�����z΃�q�Jj�9�{ح��-0S� �;�o����wMb0):q�����/j56nz�7���//(Z�5�gR����{ �)��0`��i[�^�?ۃ?_=�%����fo��s���hеN\}�R%+v�����y���1^1Tb���q�@!�f�/}��	�"�-Da�h-.�E֣�1[U%�X�)Uc=1@}�VU���E����VF��[=%ˑ��-r�+�/�2������	�ޝꟂCS2I.�SNpiD��(�-��Ks��������R��,"*�J�$��*�����>"�萂imj��Lu�+'[+�A6[����hi�~c�yܤs ��b���T]W���?��"�w-�u���[հ��;�Hy��}�ft��B��AG���_�y����^���� ����a��"<�ƤkcL��|B~���_�euL=�h�Bg��Ѿ=ßN~ Ym��Z��{�|Q���x�;���0��/�%�W��A��͎y���>�b����
"���ovi�Șƽ����%ʹ�&��==�6�l�g^���|� k��4��Kj�KKG4��4���q�WC����;�֗�ڑ}��|iظ�?f�J�-��Tv�Ĳf�G���NE2������B|�L���	�AF��1g�?a:�� �����m���̽���k���j{%T'y`�茀q�Ϭ<�*��3�DtM�� ��Y��v�qE>rU����6��Sf��6��_�j�����X�n.9^d�Wڋܩ(f/����c��`�gѲ�+�k�H�l-/� ��So��|}5H���3;��c�e+�u�$��͔��#��TaOHw�N�'�[�5��~h{h�\[����D~R����m
+w�UF;6�`�����y[���g�m��7~�l?�����R6��[@wnIj4�L�)0���]C�bklCX�3��1�?+�=d7\��*9s�2�����%Շ�牟�� 
�,S^�֭�+��F�;��W?_8�n�k����c�C�5F
f���\��a߀$D&D�X���qP�:�?`O;.$H�w���j)8��1ў����e�T�Y� �`EAv6qn� ��
����V�x���
"�ڦ�6�!��Z�Cⷑ!�=H�g��,'FPt�u�2��Ej4��ƈ�8S�*�߂�gД�������I���[��s�Ǘ�8�@�g1��bޖ�pQ::㳗o��ݒ��{Ɍ�dĨy�ő� ��b���_����"�{TS�0�㯫��#�D�*ؾ�0~��� �S�A����d����P�IV�R%��M ��e�l��j�J��磖��Ik#�?F�+�M}�[+���a�S��X<�w�)���N�Az2��g��L���A�q�8<׏�&O�A|~i�WE]���Ng�	��h��5'�[a�gFʐN�A�}�#��WV�|����A7}��1!�tJ��e��9�ۢ�"Ҵ��ڡk!�<�\g�g��<a���§��ٰm�3�\@L��/j��t�BIь�萢>�/�pcC��-�zճ+�5ƻ`A�W�Z̩��� C�(H�ŋ��5ϕ��?? ��/�;��ʞ�� ߦ�K>�噤e>KI�i=M��=^�Wq��WI=��6���X��2�K��*-�����l��cy�1C�(��F����Jh@�b��B�q����� S(�I�nӘ%�}�M�Z-��u���EZ��� ��Ve�n�(�Nr���(ɍO�� �����P"1(���X�W������:p�.+Oq(�Y�d�7��	gٶ���)�$SuNb�����/߬ӆ�Q@��b y��� wX��)=诌�/x>Ko'��N�@�͈���f�/61�^n�p����*z�d49a��[�eaKXL=��lQ��};2���&���+&֧�C���������5�r�0�j]��=N]�	��N��|8i�&q�Hq��dӈ������j�Btv��<6z�+(����N�B��b��,��:&���xc�L��}>>�å���seK��ˡ-ep��*�l�2���͒�:f�+�w��#ł�"SK�EجYE��ϲ�$��Ĳ�STܶ�e^��CAi�$Nb��⽅U�#o�;mgk�MѠf��x��%Th�LX��!E�A�2�S_
l���Wn���8�T����p&$�v}��m�v4�NP֦}��W�01�~� ��:�P�����h�rg4�dY�''{/�Z�з�1O�y6��A���I1�*Ǘ�����'B���cy3Y�����{�=�����p�fՁ�o�$��3���P3<��Au�C3ǧnvK�����Ic^��#1�Z�D360ê�cgM��<EE*U����7A��Y����|T'�y�p�I �p���$XZ�}$	���'Bdf/_ˉr���W=e����g}?M؁�m{W򆅆�Tu�/��������<O�|�|��=�����ݪ��3�>I���_�������^���>�m���Lx��������m_羦G��t�����W�e�~E��l�^�y=�Iw�`��<Q�~^��e[s�M�m|����}O�|m�K�q��g�q�����]��l}��<�M�|�[�<�~u����>۵�=���］��}��n���'��vc�8e�>�U�9��3$4-(���`� +_P?�9P@̢FA�u�,�������?d�����ھ��i�Z(v?|��J��~�[>� GCv I����XZ�L�B##2�_"m��U�6DB�;'6�U�&��C���/�`��n��+`Ft8k:x����U�ߎ������d�!�	�����A�F�[`����"G�o��g t�]b�ql�0�M@ăJ�3��	��t��Z�D�f�>鱇ܧ�put��w���и��ng���o�$u��gw�Wb�ܥS�}L�5���:/X;/$>�9�,aPQ>���X�L�����I�h.t�����.�ECp� B�LAA|h�1�ߚ���$6%���eҧ��8����4)�Ao܄x �/�#D ^�fb�}?yzh���h[�z�	�7���/���*��*�5��E�O�Ⱦ��u�Z'�����K��������e�����+o�ax��6����T���xvs�����UJmb7fny�*�/�;6���,�}��"�2�������5&r��,a�Fʱ�Zb��בLd�[h��/-pU�?pC!-�BVNd�����\���.�l���_:m3͏��Q8��^4�	^�8a����p�2�Q�ÏR\������ӟ�nt�xr�\I�-��>�*#H��փP�XIx���{ �}�rx�g�:� AP��������5�#\�C,y �\P�S��G�P��@|��b��H(Q��e ���x�ʨ�(��Te�`1�-F��s�C:�M�S��k��)���N���2Y]��h�$�"�^Ns�_�Z�-8�*J$���#Ȟ^���C*�f�w������Gb�?d�K�����r&�=J��y�:���A�����j��w��/�= �g$�~�6oAPv_@�V���bO�!�$��o��4E,9�u��N�<F�UBK;)c�n
d>^@:����{�bݯF&�ץ̠^�6	����h�l�r����YR�|�
��Zq;�Im��Mq�h@�&�s�y�k/\�r&�#;prA�C��?�cm�tLf��)=��H�1�ܵ��'�B�U����v$��������M��%�3�L�7�7�tka�O ]ߛT�R�?�(.�����!X� �J�R��
����`-�;TϿ��.s�sav(x�8hd����Q��� ���5$B
����b�^Eqm���/(j�o����1�	;���a��W ���Jvy!�qߑ�=NU�!�K#iW8�
��k!>�JB��'#E���&p��op����'Y��u_!�E����vNb��t�n�2s�$rS�5Q�8���j,���艕��o��M%��^�<��;���$� y;f��e�+��ꮂ-�\̿�]�v����ͪ�H����Z��n�3q�G��ʹ���Z�@�O|U:����h|k!/W�>vyH�R *���������b`���f�j\&?���d����_h̚�
o\qj��7Ƽ� �/�qg���9����J�^����ʔu��h	f�\���>䕗�����b,��]ǂ:�!��?���hFQ L�L�<<�޾1T��Trl�9w�a�]צ�U�ط/��1��\�afK�pбV��E����#��A�C8�n�()�Y��OqF�P&�m}�����`�'�}#���0F�����@��s�����OX O���?�u���hb���]�1(��<���Qu2M� ��R���K���R�/\�­�@�D��Q�Y��"�]�-�2��?���L6E�d�T��o��.uP��8no��P��K����D[�7�X;���nD.���� Xa��m	M�ƴ]�3�꫌̑~����W1o��}i���MKO�Ð"Gշ
�q�xs
+&te��]��Q�d&��z�O�Z��f��q`����&��SF�;#:勉M����*�#o��J��@*ٝ�,q?L�Ə��~��pT���ߜ�Q����,$:�-�`�G!(3�{'���m�����Q��+^H7�0G��b��\�7������B��w�ҳ/��3�׿ZH��<���H9�}�~Zd�v�b6�[�)}a2(��ǻ�����H��51j(�� T��C�A'ߖ��hY}�M� �T-e�Ǟ�'�ߢ��EL-�F�2rrA&{��T23_���aS@GB�Oql]s�*x��x;sG��)�����fFX3 ���4�y7�1�����ї%�M�����Z<"�L��A�EE��"��N���?��S<O�c�n�bCI�M�i�l���M�ES_�bf2̰Fe��J�zd�=s~l��/(�����xF����bU�-�?9�v�X�v�����,F9�2�g�p���0C��Nw� ���ǭzI'���2E��r���/�#\��=����k��V+��lW#/�ZB�<hu�u8�D��)������]�H�@����q{zq�@W���Vi���\4�J�؍����B����X ���˽~���Y�j�+
d�A�vy5�Ō��C_~����#��\`�.81N�h��~���cbu7B^���@�xR�#��P���#�:��Q�����-��cl�-x��B��̓#��{�{�;�2N�(�|�'eI�o���᰸N;c�l.��c׶(��zW
x�P���U�Q�B�_���c������ߔq����Q�g`5�g��gbP�������������1m���1Yx� � :|�k�[�Ŭ�YX[�[M�K����˩��|��jq���s3�	��ttq�sY��1(�jIQ��~�Rdz��x9a���ddcQ�&���6��xUi?�<�ȡ�Ta��e�[懕�����-���G�%���:��24�[��z�Z{ϩlb��i�K����Ҋ���k��A�LrT��%����W����H��;��G_��ה�糠d蚤G1,X�TK[1DU��C���֝j��"�JxǥG���������Y���-M`�j�<1u��%g���[jۓ��ة�b~��u��`2�.�����'�����l���[�^2��fB�&VNrRbR
,���Tl��,ڗ�Vc�����s�Cd@�y�Pj|LN���H^՞�fLM\�FB�V�\��\A|bR�FU|RJ�\�Fr�n\��Aix>�#]%�$��C[S?�%��Z�#��:N��=��2�3�bk3� �(Ō�D����h
�؍Q�d3������<���2V#6`��dZ��]:aT@?;,0ؑX(���v'�)��$���IZԨj!r1v������doĺ\��V@�XA��_l��lO���+��ew��Л�&-�"WL�t��$Z�!7�zU�yh����|0�o@�Mmw@Y�~��t��ɪ��j�O��в����6M�e�+nJ�CFS&��x|-m�쉲=���^���=>������	*(��"bIa܌�V��;U{��5��^�=��D��Z#}	>હT�56�=��3�9�}����� <$!��*ߠj��j����#�E4���+���}�7b������*�k����5��w��[�Uq��BT��n^��ǐ���f��9��Q�J/?C0�c�m�$qh%���|5%����!�����$t�k|�!M���R�QZyN10����|!�5��v���]�+Bg�3F�%tv�P[�>y���s=��f�3������׭"�~����[ִUB������A�W�{���w��9�k�h)� K���!�P�� �CrE�;L3�Bu�I��!�YR��4�29�b����?sw�ĐM:@t�FR��H�ɀM��N����p�����:`�IA��@{:���W�D�E����g�`1h�Lm�J��#���>�J���u�7 �$R&�\����8+�wI9��>9����-oLC��0ʢC�[G��,�a�̗��:7˓;���`Et28�g9��y�0�vؖ3|0q��+�r����#�`�i�/韓\6{�bZͺX�#�;v�cn藣��8�5G��P$��·�n�Uq���h֝�ݶE\O��lt�]w���vA��ڱ-0m�)���C��II���@Y��ؔn*3=�������1�Du��m��ʭ9[";ג��י�y5�u[{�r�0�W��)4�ȟ��>�����^F�0;�+DH)��� �,d������-����������3D�����=�v�w��j�R���Dj�*空�;;B�S̐�WvFh��yJǛ�������A�=�����*���U�����I��*F��|���)�e��`9�@��#�#1t4#`m^�~�L�p���)4d|A�z�:*Ҥ�I]�����{(
�qu�Y�/�I~W�m9e�����~�<C ��4�bӕV�r=���"p+DscT
p�i�L�~R��[m�>��!��)}zi2��ry���I|��9��J��ZR"��~!�8���}�G6�{�	}�4�I
��<�WfN�q��P��Ke����������I:������f��7��r��m�'RZ��F��8��U�� �52��|��
�����ԃ��Tm�Z��C��Bf;.z��)�}�2j���:��kx!�u&W^c`�
`b��Q������+kr�!��:������w(�00��q#�9t�"�������	��[�]�w>�W��f�Y��ָ��S�:r�([N�C�"���6��Aa����XtJ!�l��18kpU�_7�-�H��G�R믾YN�a\G�Pv;>�?�Mj
ܩ$%��D�y�0�z�\X0{�`a%U`���gU�����fUԯ�ٌ���st4C��K�L!(}$[��|��'���p:��^:�����:慉�ޫ��v/��J�Y��׳�bM�P2� ��1�s� ��؞����i�5#s���bP�,7��k�gݔ0�������q���}�Le����w}J�s��O#C�o_���d<=Yz�Z���F��ɠ���_���1��Ȃ�uu�Q Lb���!��1�	D�k؍Ze��!�ʺ�L�Y,�C����8x�d���S�kc��$z"Hf�C$6RVx%v��+�cG<��
`�X�lخE�{�}�.�b�f( ���RF,��bLҫ@�.��W�Ê�{�H���֊��[��CDeҫ�k��c��X
�b:S�t�4�#C�L�P,)=�qj�n:w���*!��»V��o��54�@�AwΫV�"��OX�5��-�;�^5ǫ����Yca���0sjU<�[ΔI�Y��9�&u��k5�C��k�um�v��lh-��O%�N\;@]F�b��؂�a"��ت��לN�+���hi^�K?{�ԫc���y�Ӿ][6da���%�	���.$�b8ݑ��H�P���s5<!��ш�g-#ie6�e����=�����j������Kms����H��k
RG�p4�a�Ay
#��R��sJ>C�d��W�Fd3tIl��8^e^�R��g��4#��	5ژ �y����(�U'��~�k<#,��r} )��=��4��6�zO�#�C0Ŋ%6:à.�RJ�dA=d+��z8]���
"o|��:����SE#��L�|ܦ�e�.��j���8��N��-8t�M&Mشo��}�yp]�.�c]�Yo��\�^�]P��4�'1�?�{��~�rH�}O<�A%������]�~,ܶ|�%�?9:OY']��*�:vn�X��L���t���QK�G�I��h���,��x�X��b���{�^'��܏VXuQo��?DE�"���E�r�4��|<w����3�.Ό��/ٲ��x�ۄ'�݉�L53+��	4	P�c"���:@�����W�@�d
9N�:�-�*EK` ��hՅ���Ԡ��hKx���U誢��*����o�;���pEq#2�F\����D,
��u��p:J�"�c6ےk�/�^y7�	;YT�ͩ�g�����^�$d��z�	�tpGv�O+�j�\?���	�O#���B��gb�5�
$ݞ�=�oϪ�:�����y��݅��}0�:x�Ik��Q��a�i"��h�>�����t���Za�/Tq�"�;� �e=C$`�m��]��L��ߤ���P��;�$���,���gϭ����I�%j�C��0�
���"��h�ߗ�/�����M�}�SR�BU�����0/�qS� ?�~J�0�K%��p�<5}��%|)��P��:F��hԺȻ�RY�Ҏ׹B�ű<fz4CcV�:L��:�b� �~�>��{���tPވ�ӥ�k:ѭ4�`&WԚҔ�� �����j���H�MG	=�+���k�����vd�̎ո`�qO-��kN��(��*��N���!��|��}ep�{�3W Db���w|��_��}e�#�f���d��g:��:ڧ=~Krbw˸�ꞇ�ז"%7Z�H�Y�V�1n�ū#@��^��|�ω2,���,�m1�Mr6}zo���E�$.A@	5��}[��)�w�^��J@Ȑ!÷M~k��%������`��xFo��9��E?zX���"�a�Y�D����}T�`3,�lE��É�/�Ns�-�V�yE*����ب�Q"4{c�t�4D �͜�У�m
��>���({�!�+�UP�z�X��˿��n�JP��A^��(�"}E�=1�F���h�r)�E.��l���h��LK�Հ۞�B\m����q9`���O��`��W�R���98Ү5�!�0���,���L,���""a�;��nM)gc& ��b)�wB�iKk$��p��Z�u<�ا��o����qTWES�k�]E�����
E�7<� �;S9���n�U�A��shyD�St���'^w��lv����Lђ/6c�Ne����L�LO�b­=�P��I�^��Ze��_�X_୰l@X�ib؛E|D�V��/n7�>~������m&�>�=���C�|�`����[Q]\�t5�V�1��Frg���bH��;*!Pp���F|�a������E1�ե���a5瘽Lzc�8C$4�V숪S+����>� ��^��0�{�aW�*�۽�.������B�1L +�����a�����/����B+����{�Ē�j��(`D��!���F��y��V��D� ��l�4%
��S�%�*�ͨ2��~F`�m)���CU��$��%p�rԐZ:	��Xk�!����h���|&���0�9'�w��Ro��T$���S�.���?�Ű4n��e,�3�h�I�F�]f�\?�����cP��9���wNb��d�a���	�'�'R=J����mܠ��p��nՄ��5]��N�}6���g!8]�x�B�z ��{4�%��h݊�A�;_�.��	����A(�Y��᭬�,��*1����i��L�Ғ�W{�|�d�Z-��T�"Y�Z�K�X���X��"od�d<U�q���彥-ӂ��[���dH+�c���m��!�yi%��J�)��iKz&:��*��\�@|�9�fWM�k����=����MԦ�iZvj�ۣ�ͻ��隶L�j��ZCɼ-t��'�l�U4���;��IY���$�6����"�MH���a��#�R�?��{=���������_8�D0u�3���'�+����聁��B�2�$X(����Wn�b�A�\gz���h�MD�_������=4~n�Zw~����?˿�v_w�o�x��O�{��bf�+���|-�.�~��~N�wZ��|��~(�,}Lt�-]��*���]�_�W�TϤ�e~�.-�l5��>����u��x6����:,��k�i�[J���`h�i�KRPB�����FR����3���y�����������0s��Z�\u�u/���X���+��>��/��8�պ��T���)��x��վ�:5�]�n�w�ME�,�:h)I�9�ʿU+ߪ�x�*8��5�y�Q�g8�t��>w�pDyitk���
����N��c�<���Ʈ�ܨ���8̑V.:LL�X\�{Q��٨�.6�t�D�l�42��Z������_��mS:�LU�Wy�Q���ry��%_ f�a����H�q�j�C����fG�ݰMwPO���	�7�J���dOSў�Z�lY��e�$��ɉ}��T��Y��͒hf�77�h*r����������T��y���M�<�L�[r%,߹��L�k�#�����p&}����*˼f�z�����.�a�-�{�DO8��A.�qL4�>�,��jN)8��b���Zv҃����Y�^�����Y�їε
�Ąpr��+�z�[��P��c�#���V�t���]Vb��m��f>\��W(C�g�]����&t:�'�w&DZ'��n�}��D2���ep��Ī��;�E֍nW�ޝEM�\�g뜍��D5����@�8�
%���W�f~˩��h���Lk��$�aS�s� az�T��c�rሊ7�:����R�m��X������	�8��e��w�~]&;�~t��6�dT�+���Q��
�6:����G�ys���rb�c�
�O�l�撟a��d����p�8I�_g�	�[u�78<A0���}���E��0�Q�M�h���'�Z�\j4k$6�#.��u����%�Q-"�W�͌9�u��^Y��j]��}��z�Hi��J�i���.�dG�����\}���k����}���YX�����\Y˹�?�p�w�
�c�O��zL��ϾS�����N/�a��M|E4Ტ5�9/=2ɽmB�sL�+m��e��w�D��m�{��T�����[w����b��6�%�d�����)볕O��"�n6l�Z�6�P4��BO6
~٭�`�F��x�n���[��R�u�{i�F�{!��_6J����(�2��\K��<i���������o��hu�џ|�xl���;�a��1H����y��ˮ`5'��������h8ճ��U�[eC���[Ev�I42�,�tA*k���'jg��(��K�E��m8�](x*G���D�8�\A(�D��Hё&���I@8�����D�9e��zZ�J<ّ���������	#�;bӢ�_��1���c�ԩ�ǹ�Q�D>�L���
o�	&/���:�_����~�E��@���T �Pq.�pi��{�.UC�Y���Z��~�#�o�G?Ć��iGs�:�e�K*ғ )m�΋cm~�OH���T|z�?�E)_�(zE[���Ĳ_W���
W�u^������T,��Y_	n9u�a��z�i�c�@��~C@�n[s '��37��[X櫀C�26�'��L���>7F�je؉һV:fM�Ք~��WF=���,��&���'�!�7�;ǬT�6�VfT79����t/����B�c�w[_�օ�?^m��v`_*��Կ�<��	�+� K�-�B	
4�͙���#��	o6]�Q5��Rb�J �L �&}zj�X����SJ<�x����P��ڡ������G����.7w�k���\�����8<W�hiJo����O��d���&��;�2-6:���x^�z���x��R���~)(ғA�tp���ՕeХ�E�ޛR;���\z��H%Y!���$�k�\˰�u0C��{)}�j���pb��_T:&*����v$�0��
mB��������{�vTB,�P�ԝ$]��mL[�/
�|�l���ח��(1��,�|��w�8�G�f"�N�f�2AM��pp��vҀ�2�o�p�O���K�.˧3�C.	p(��!;7�ͳ�pXY5�����"�������WQ�8:���f��G�Y���e��ڂq�yg��i�&2f��6?e*�^4_�]��b���!�"Z�U���^��t�k�A1��@�-;R�h����z��N*2~9�8����H�T,��>~/]��U���&�����XV��%Qc��2�й��T2�tz���Q�S��o��$}n1/'����"�+y�G���0氱d���%�:=�ۧ�ڕϩ�o�,
K
�#��s۽['N��zl>C�eE|?a����E.�4z�Ѡ�C�3���%�0e`X ����S\ ��]4��Q��F��*Wm�O^	<��I���h�V��֕M+�<�63��r�`�Ȯ~񤇦�+dEu����$����`+�;ɱ�e7FB��a���\��cK��pQ���7���������Џղ2O_2��8�!6m�0�c,�滪��VaZN���B4�QW�MrjY��W�����e!�d%	�ku�s*�����x�m��$�4���.5j��\+��hZ���3o���e�im�@߮��:���_Z�z��S�B�:@��Z��u�Br�i�i-.�\-�,��.��#c��]*�/0�>�ŧo��7x��C�&�j��>�»����@�0�P)�!F%֮�oQ5�E�j�ذWFx�8<E���d
wm�)JƃG�Ye��P��,%�D=�A�8O<hs�c������FcN�ٮ���������$��
�X5ŲyOC��A��/�T��F����o��:&>�9$UR���)I��CS@�ӷV��3ݖ�3�x rG{����ke����݇�l�{�i��a�˔�TV��� �_'��M�g�#3�Eӄ�����f�Ց�RlhV6ڢi�̞��ꀛ��5]S	����������4�r뜔���[8B�|�gfW\�_�@��z�R*ȵh�w��_�ŝ����E>�{T��M����ˏ��o��c�Ju��yUq�ߗ(�qJ}��&U��%�}��2�owb�Malx�VUβ�* ����-���S���>�"�@2}X.q3�[A�)�d����C��c|E�ڬ���aOM�o�C"Pz��"?�'~i�����6��<�����(l����3B�}�
 /^����wu3�>��nus���D%ԟ!�M&�p���l����O�#��.<r�y�*9���"�l�~ׄ��3�o|P��ĥ�����ڲ9#@}�S>��X�7���~B�X���=
�
�����JA\�#�b���)S�-���5�I�A���o�j3V���ׄ��v��Jp���|������O�"�ߌ%�8���Z ��`�ro���P��b+��(w�N��f�gY��u�K�,�4Q�X�6N��I�GswJ8+���,6��d|Cu���s}��f���p�h.�X��<f��'�l@�j-zU��N�}4Z����C�"N����� by�+S�-��=%F)�z4��8�kR��4';[������o�g9-�E?' ��A@� =�(�qڣ��Q�-^�Ys"�Us_�4Uݫ�W�d���^���`G�m�۞��%)�V�:�3���N�\ �`�w��2�i�{ޤ����X]�� �p�ۺ�i�Q�~���?�gY�"|D�dH����SwvoI��/���*�PH��{����-3	SK1�JM�-:c�-/���Pm(+��)����B��U��I��ݔh�#Yu[T���!�[���@��̴Ll�<5��}}�O�/A�E,f� �i��n[s��L��~Q�c��4!/ޱ�x�g����Z-�Sӿ{1'+�lsH��`_��>&�?�.������@��s~���FP_0���*k�w�Wģδ<�_p�B^`3|��V����\�D��P�z�wWB*d����|'lQ�є�bi��{jپxM>�ᮏ�/1�c�z�b�&���lU�M0�0I�
�Rn�N���,�}�1���x:/k\ZSڲ��E1�^�Ⓐ�^�~��6Do*������ob90�&v�,�e���B��H��w+f�<h���
�@%�ӑ_?��Ck���s%ԑk��LU�1 i��}�z� �c52?���]�������٨qfL�����c����y!G����-���X&�yD=�|Z2:�[���P��j��u	T2��u��}���$g��"&ޫ�v��}_@ݗ�Dٴ:ixS;o���RД3�~]-p��<�.�u�{@]�J�D�;y�DAP򃶜3���V�u��y��. ���~�-��-�TŞ����h^:��v���I���H޽+�f�}c-D��djY���N5�E�Uv 9�^���w1#ŭ�U�yn6}�/֙/��jw��j꜒_uz&�=BϽ\�#��d�*F||��ۥki�'���:#G�^�e��M�>�W!��*�=����B����9�HL��� ô�d�{�̶�S�kmA��Z��fm^�������#Ԃz%zEZ\5a���+������\�1�4�_T��" �[ٻt���\5u���ܳby�Kֳ�#�
U������4;�㗎�S����6�U�xIi�o��/�77j�� �8o ���js���Z��I� s��w���kdK��1l	;��w<J�>)�r�QrҲ�,_��������*K���ݿh�T:��Fƿ���c�n��8��7�9���AVn��$K���ޏ�,y���c� u�2;[�{,H������kb)r�"�x'�p�D�愈�V����Ȩ @ zgW��#8Q�����3�3�qj�U$:i�ң�F?��"�7N✰v��}�pJ�~�)���3	M�q��DOu���t�ӏ�)��¿mn�%^|IM��������BNЋ�V�|�� �2K�0�g�K�d�@	�.:��j��8\�H��_�����E)c}�)�'ٹ���ר1O���,5�f[����@`%�F�OR�?�1=�!�g����Ҫ��O����Z�"9�l6)-(�����V�������n0䦹H���xZ�<r]��hYl�ά!�yѲ�?�J���Y���� jh����ԝ������Lm���jЕ��:w���[�ٻ�]C�E_��g;�d�uΔ0s��&p��!����lU :�*R������KP>�\hZy�b\g:T���՛��]�~��D�C���x���j�Ⱥ�X�������n���Dp����'�\H�Ӡ(E@[�RΕ��EU���a�qau�����gS��]�=ڂ(�;������+�K��9(������MPR59�I,u{땢┚rE��[��y��8�zF�3��{�{_��|0��LQX���h9�f��ƅP�Y���|rq�1[��sK4�I
��j�OM�^�ѡ��U'�ʫ�ӕ+�$r�U����$7�/�DZ�J��<��9�*F�wjޝBړ5r[����(q���<� �����A�K��Ni�%�����_����%���c�p�x�I�9�}�߫�k���>�A��/Ќ$�E��Bq82@�R��9A_�x:������1JN���3M_B�O;���Q��D��^

�Q����6��JR��)����"z��ٻ��2��^�c6#_W&s*ɡ��k���i��Z�b:Ar�2��/��	�j)�(�����ĸ��Ix?N�>���tc�y��|���r'7	.�H��"��)|պ��u�(��-@�۶�?�Ě�d���{�XR�=~��Q��_�ڷ��dg�M��@���d�g�-��돸�!F��h�q	s�X�{�<�cVQȹ��L�i�rӲ"�TX��_	��L�)�nK�����)-[��C�X���Ÿk4#���dPIya2�
����#��蕄�%�L��Y�S�I#C���o=��]N<^2jz��:��dRWT�=���?���g�ks��gi;~��w���{g0�p��<��n)"g���@ļ��<Ǡ_��~K*^P��LדO�':zѨ
^�2���G$2��Z-��qH�Pw_�(���H�{�Q�(�o�l���Oy����S�A���v�3�h�t�h�B��E�,�|�����d�k���c/��=��RM�t.��}�<�E�Zt4�#���b��M��Λ�r����y~�0�5�Mm[��@��_e��m8\ ��/:҄�\\����\��~��_԰��Uğ�l�`��pw8����*��zr"�pJ"(Y*�۵�t��\�ܼxF��k;J7@����7��uu��ϰ���>��Γ��_Hm��;�)����ј�4�ye�Dok�˱�$x�46�Z o��
��,K��R�z�DKH`��*^w�i�<�З����}�/asܮ��1����YVM:#akp�{�v/��ˀ��%o��"u�z���h��@l�'��*37O��6"]��tS�1���|�+
zsk������-̌����/����]Cǩ�����!��-��) "��E�8G]��Hs}��M"�ūi��!�_�' *��9"��)���x�y߯Tۜ5[�-�A;�ه�n|��cƟiV�K���U8d�4{������YH�)X���&���+<�I��2ϯ���f:뱺��^�"�gFO��	lPK��H�a���b���}
�<w�՞m�Lf9�����A��U}I�-��$<�"�����7IJ�B2�^��7H��lK��b~��=j��e�#�u�<T
"�>��_뷀�t���.���TH���p�1k�2�ITL{G]x3Ľyw��hA��b���0�S�?�g	7��=OK�DWв{�-Z#�(��&��U93fK�,Ǟ1L4#!���aǿ@|G�"�)����Ir���1��v^A����Yf�jS>����f�^�T\7���R�<����+������5�OU9Kn����C���e'5��KLͥ�.E��_H)1ܙ�f��dX�?w%���w��f:�W7��Էu�H���w�qR��o%'Fl�Dq69ym��PI�(+��BZ ��'tw�q�in�D��q9d��W���|�������.g�[_��;�w&�Z�9BcsZ^f]B��L�+��ȿ,�HcK2LN��k6�^�$sh���d�e�g�Q�����A� 03�����:l����}_Ԫ^���Ӻ�>��ZM���m	[�����bdM�j�_U;��~OS�k�X�@t'��G�����?_C_:s��;���?Kq�}��oX-N���/P��)L����!�6�9D��V'��J���W����Z�pJ�h.jG{�Y�%ן��>����N�(�^��z0��R�1�M�#��LX#�yU�}������(�䆋8���_i惈�c�.�68�'��1X�cǆ�'��C_�.֕l�w��H�j���r�ӈ����.��}& p~g�5�Ն7�MJ�v��M�y6Uf�T�mcV��E�w���{2
�â�Ky���)���q��$���O�E;�K+]�zucgsZ�D�`��Fluw�F]��&
�*d��k+��;ּ\�|kj�	��4�H�0.N�>0�
��ټ����ɹ�b%�Ayݞ9��n|q@�^����0Ȋ_�ٷ�yD�3��#\�0.�L��Z�U2���4Ku�zr��?nn@��:����G�$-�4j�R�P�)6��� G���T�"�Ì/�Wڢꛢ�N�+"�P�b���-[I%�M��y�m�c����'`%�п~�|*��+��u@i���z0\���1z'u6D ��H�<_����))�k�����j.�:���@��m�EՑ�ҋ�7X�VSK�XAN"��C�le��՝��q��*��(#$Ula<Y�4^��`Na��\ ��ɘ�Η\��Y�f7$ k�o*ژS�-��]Tv���%���Al�?�j0�RG<�zF��ԝJ�"���?y�z�,%�sj��V��gk���մY{��_�-C�)�������ϙIZ
�P���F�����d]���N8X����K���s7uKQ���D�~=)  *��HF ��c�mZ��	�|l�l��+n�U���l 2DZ�#"؍��x}j3�U�����;����7R���$3оLq�ru���c�% �ߞ^�]���1<���#���:��<d\�V�^�!��>�Y����cq��G��FA�f��Wr{�_�Ɩ�G����?��b����$^��I|�{_C��u{�Gogic���b*rイ�ꈜRuV&�����q��@i&���R���V�V�g��(��`�6��M�Ybƒ3��a�^���(���b�o�ɼ�����M)�~L���,R���(�v��ZG�J��$��K�s���$Z��i�ד�`a��ː�E�}�i6���P�M�0EC8�X�J*\S(�A�iLI������ӊ�w�&��W�+�V�c�٦A<Gv�r_q�I
.�-!�Vk}������1����������\x��X���z�je;b#�@��!�M�x l�^�b� T���4�#��(�����g�����~6�����$���9׼�&���~鳰���c��g�磒dB[�N��y�"B37g��FOqH�cv��g��F@�>��B�,�{ًޔ��_y&9 �*((��!Uyl�J��tg��|�W�{���Z4�g�1��vD��w�o�N1Iɪ�n*����ʬB�O�)�e5K��,���ʌe�&˳�F*$�����_y�u�g�F���[�b�R����������cVׂ^��X��iYI���w֛n��*�����zy���(Y^�Q1��C
�ۼy`8��2�&��I9���TzN�&�d�ɻ�9ՌIM��K�e_A_�_M�Pj�k���������d����[�OV����(J~5i����������p3����Wwo���B")���w�`�TK�JW/�i� ����g�Iޛ�#q�ٸs���+CIk�vw�
��b�`���R���Y?j�	���׌ln�b���n�|js��v��e��������ͼn��G3�t����,��X�xTG3�M�sh�����x�u�
>*��!����𪏸����J5��p�-5�K,D�\��dB��o#�<���;N��?��L'$�k�Hfʭ.o|��M�}x`�h������DʚDwv�!9��ʹ%���Sۣ��"����&*�^�]�O�����hk��g��ޜ?j]��l�=>���7��e3�Ed��TyB*��X�%}���c�qA��#e��GRW���;ɾU�"Z��k��/��<�Fh���՚L۬�#Z�]WU��1�� >޻p~��p�8�K�Y�k�y���䰙k[�����ۍ�����c�`p�e�DH���bI�7O|Tҽ{2����:��P�sU�����n��msj��ʸ4�35�]�$d��Me�I�����Lg��"��}l��sk-�ф!$�0���oEQGe�t��7[ָ﹬)&˖ȫ��Z�����U�6�S�t�ʴ�s��d�njs� x�p����އ�tr�?���{���i�f-��cu��G��ls��U�Z����S?��Rg�R�����Q��4�|��:���;�ڳ����������N8\�.4�F����na���0�-�IRS'k`q�F��zi�Kfݽ�%����bT���[��p���I�y��^W��/�إ��i��L�\",)v��yFw�k��������|.<Y�|ґC��S�����q&��F����7-��O��6��_�T�$ݘ�ԋ�U��6_8�J5l�'�,l�Gvᕤ�i�\���S����m���߁ܜ���P����J�P�޷�/&���C����&�xO�s����XNP-����p�pOҒ�N$=�UhJ�m�O(��0
��Z�sÑڶ$|���i�xON3�8?��r2� Vʟ9��sѻ�&��D�=⫟�������6M���Έa�.T���l��7�A5��]4��px��n8V������:l� �V#	#�	�@4ʩ�z�:��P�.�6=xő��Q�bB�~�3�b?'f�� bɪ���4���Ï+~���/Ӎ��?θ
�u����٤��I�$���E,V�ȋ�=�9������Rc�B�C�eD4�x�!.�ْ���g��8��vͬ���1t����Կ�2��d��"OŔ�Zɵ��P����*+-8�l����[�A�Z-�P� Y�P+�"��/��Eo΁C�L��gvĉ�%�?��t���ˢ7 ���]+�fJ
8Gz����>�2�>]2z��2"EJ27�\ߢȎ ��{Q�>}�;����:q���^��5@�h�}��t��sLIK�Q�g��NQI��=+� i~�"���Y����C��O\c>k����J?@� z���8��_�¸�{"	S���uhԨ̼g�/���z�ݟ�����W���T��3W/��'�.cE���VƇ(�z����Q�;L��	Zp��6��pOË'G�Z���۶�{�eA�9�~ª�?���E!]f���߈����[�m�W2���f�=�#~�G�2*l��o$(�E�;�G1�t���[q�K7T�#FCN�i葶����s>Uܾ��в�o~B���4nS�ĵ.�L�}I��g����O�jW͏�]�O���o���@�7LD�:s�
8]��^�H~��K�k�l	�VS/&?�`��a�����-�w�t{�Ι�O�l9T�?3ҪZ��O��q���i����^T�[L0<��P��~����_����2�Fm��J��4�X�`��)V��E�DNC�{�d���ڵ���.�'��FNV#W�]l-b8Eʗ�s����3�c,=�p~!�i�����Q'%?{���V�S�ػ����.�Ϸ��lA)�,�h�vݕ�-�a�oY���yc4�Z�G;��� O�uC<Ǹͦ��Blh����C�ֺ�����5�SϾw�E�q-D�������d��8C��PZnȄ��e�%�F�[K�W$�R{�\D���.,Ff�\'ݵU�s�����yj7���T�ֽjPo�A��o���L�1b�ع�&\6�p�U�DXiǾ��y�-=Ue��Z��R ��'au7;,�z���g),Hq���2�uӔ�B�ƮR_�<��TW?&U���McT׽/G��f@�� F�H�"]V3����S�Jw�Pѐ+c�m�x4��Ls��t����§z��B�Ґn}�3�'�Yþ�z�?`���5��A��X�9M���&% �t�T�Q@5_r��-eUf� ygR��ΰ�<@4�,ݩU4ר��R�Z��~=������3j�M�V���)�<Mb\���������sƋ��G�s���Ny�^;ܥeY���XlҰ�1	����⊔��Jz��=�%8aKm���!�-6	[�,�ֻ?�1�iZ������Z�����7�ћ}���w��4^Wf���U7�����L���(����b�� y�<�tZ����y�S��<�7�~϶��dw�
˗#�^&%�jԢ;f���Y���n�R�~�QU�<+ҡ��*F�9ӟC��%=hSw0�8����:�1CW?Dx�9�����y�Xl'O�V��^�x�I?��0&��/r%b�g pi~ ��n�ۮw"��ق�&��(����{����!k�rU���Q����M�ݎŻ�.��Z��td����r.�v3�M�
y���_�����h�H���vJ>OAc��l�'��2S�ޭڴI�.[���XGQ���ݾQۣo����*Z�M0�OR!�H��n7���J���+��t�i
��4{T���=�Z�I��)ji����_N�5�ݐ䎜c	��9p��\�(b�-�ͼ7�3��jS�ü?�lÒɟ�)AB}�ԔN,G�6M�멍N�,#��z����[����(�6r���K�d>��K/�}�	j~P��I���WaB���s�k#7�S8�Au���Uvݵ�h�
��X��)��Q��S��
��I\s<W&ͦi�3��F�c����?��;�G��ǽ��tfBH2-�O�*ĉ��&f	���d��n�9ާ������
a��'^ʹ�ֶ�G���%�^�m_��oֶǵ��G܋^�G�G]%}Kx��$�i�ymx�������(s7��D������λWN�Y��s�a[O�~�gW��������f(������s�kc��;��î��E����\�jw�����mw<���&Y�Ǯ	��课W��~f5_���\/]8b}��9�_�!�'�>��nW��'w�/&j:�C���$ҒOf���t�� W��KJ�O����>G�q���~�{���\�o=|$~����N����{�9��;4�<�^v5����n����`��-�X~�&�٤��8C��{7J	�� b7�N�K�*�ˑ�L������^�[�����ӃO�'Z=ΛE��7���X
���Q��K{!(�ɻf�O����v���3��l�G��Q��oV>��]FG�TX��㝍7]�M���f�EбM�����/��)a&��A淴�<��ԸF���K������n"u_������/�>�B��zy7|����o��8�,��¨���M�y"(�����)��E�4�w=G`�|<��մ�&��eF���K�#3U�_��ȭ3k��Y�S�o��
y��U�1f!w(h�6����N~��]�S�OS�cƉ~�2�OL��İAL
��]��dr����{X|�Rm���������-�'�(5��[�Y9��s�C�m��\}&��[px3nrtZ\A��d󆘅:�I�92�KS���.���:��>��;
�BkM~����D4����(�*�i�9��!-��R��E��\v�"$7�ʅ���NQ<����79]M�	������m*���Βl�"�7��1�x��09uu�W;��#��u]�a���-��udxLQ��#�Įv|�o�T�U�"��Ip�m�V��W�6X����W�5�Z�n3wríRy����s�m�5ܤ���u�W�	�z���E�?|�E�5G	�qx�>��A>�a���*M���q��}CDV�[o��qG��x��4��+�ى�|��޲t�R^R����ME~��a�Z��~.��Ӂ����2c~�t��ew6C��5�Σa��9��_�[\Z:b:G�Q0�X�Sq}h��s7�l�=�|��MQ�7�M�g[}��O��������+��D�ڦWt���g:/�oE��1���Fa�*�U��e��r�a����.nt�0rW�r�s׽�s��D�>��b&04��T^YU�5�v-��v1��n�w?�_�ʿz�O@�p_��G�EH!���;x��ۥ���hM�ߴ6��N�lA+��!�<�$�x�"�ڥͿ�vn�:9�	��#n�,A��╉���su�޲�~[���f��g��=���>��ˋ�=C:.n��K;/�\��ɍ���8�]��3��=�O��r[?z��\�:�O��w.���_z|[�������ۄ�Q���](����BM�$��z����ŵ�&1�p�h�g$T�]7��	<0�q���n���d*۽h)��J��m�b���y�h^'��O��}q|�4�d�7߀ʀ��<ǰ��e?�=m��{�R�ud�79�O�����,2��+a%�������E�/_�I'����uY)TT,�'|���2��e���:�Q!�t1I��N-(b%�!����"~���T� ����#&��]۵�������1�9�mc����� +�,��ֻ�ڌ�A���R��Gj���+&���;���3���T���ҍ��x�>�7���8hC`����I�Pɟ�
Ex���Jw*=��i"Q6Rp:!Ӥ&�|��J�ZGW"M�1�4�/�l��>�������7ˡ]S!�9L�V��K���euW[�$t_S�$MN��ӊ�L�,����;{������S��N�8�9�bm���|�����Q���c����
hQF?��c�5`Z�+�̰��q�<�"��i��D��sJ�S�Pk4U_<oP����Wu�s;�p؉��T���(F�c���?u���0Gg�o�*��;��!����K8��p�ʎ��K͝A?��wl�����z��H��g���3+���c��^�7�>���q�n�Ӏ����Eۭ����V��z��u�x��n���[_���s�X�{kw�^�̘L����6{eq�rv�iZ- �k�ϡt���N_@�E������d��G^�+<鲗�HB$<�ʿ"���J�;k�J�o�)!��ߪ��\1�1�-�;�w�,�gO��B߉h�Xqi^<,�#f3 �e�`Ȳ7��Z�:�jG�^�1���" ��~4�^���
cZp1{8�g~)'ޙ�&�Ĉ�TD���n�\kDR�Ԅ@�j��'Ԕ�œ!��~����l��d�qL�{>4�qs^�s�)��[1���JS,�)�
s����!���M���W�u�dx�;#�
,�5I��3��#m�U��]��ƯYC�o��ǉ��wل�U�`��þ]m�i�~��/vH|�����4FD�6œ�F��w��Jl�$�`v0�V��Ԓu�C�.GO��)�����G�>���"9f�ui��uj�+!��N8�rs�(���c�./�Ҿ��ҁ�R\�o��@��}Vj��}c�3'�g��{���vd��^�_��枟�^K���}|C��*��Y�P�^�$�.�+��R���#è�{IlA � j�@����O.�u������9 ��- @0*���`a���A ll��� �����������A�*�a�t��s��d��p�� �@W����5��� t�@`W;T� prq���!��^ 0@�z�t��w��[<��- f ����� r8ZB5��
p���\� ����
��%�����8� ��s�������@#�?T���� f�|<Ϟ��y�y���������f< >.^^A���'�%� �� �@����yy�xX��'k 
��^
��vt9�{�"i�f�E/
�������~��`����D�������h�� ������۰��9��f��@nn>nK3~��3 '�9���%??�����y8y��PK��ǝ������w�� ��XY�z�`� 59563 d�G{h��@���V�tp�w�q�̀`; ������ �%T��(���l���`r��CX 0���G(�@;��� �K��  �`9��������j�e���#�M.XO�.A�� ,�6P�4Tf6`�5*��%�Pr :� [;:� �.6N`n�ڀ̟��;B��� ��XI
ho����Ɓ����8�Ŭ�`��@�aA����������� в������@�6(�f��8BU@����%�� 6�,@0 �eK'�+�J��4 a���qut�Y�j�m��6m�:a���c ���� ���C��B`��=�5�wa:X������(L�ol+jvT�͗��a(uC���P״��,�--٠a���3��� �s��
���8 �A��;��A.@{V���oSNО�� Au�����B7�����MMUIZFX�݁. Yy-��Zr�&��2*Z�W XS��cCFvfQC&vfZ����s�!�ltB! ؜! jcZ�jj 5-5��+ ����g��ǰXi�|�[��@Wh�B nN�6�D��тNOTW�@M��a|��`�� 1�1���@�����f��#���� �b����``z�郊� U�� ��ǁ�P�\���������\h�ќ	�����
� (@18� r@(�8��2hڨ�ycs����?�rqlݠ~��,a�{hȿB�4N�2�*��~�u4�M&��^�*t�[�b��Ö�V0���N��?,�����ہ���?��2����_Wh�A�ڮ���h���҃����tx��m�y x����i��^0���5�g����Z ��rpr�xX������;7���/2����]SP��u�C�'.�N6���]�`�������b��Q� OW����hru�@h�́��
�7$��H�gusA�֯��������b�������?g"0��0���<4��~�>-���Q�! ��<�#B��E���d�}f
�����#����f	����6���*�A��%�Zh:]ܜ\�h�0�����6���PtP(��WP�@L���	EH��o��~�� � �a��M��!)P���[�P�w��k�@�9�a�aC��� ylF�*�r�[�[��eA��o�М��?���!`вy��?~�7��V����oD��EPK�?6,�`&�)��(�P�1�����;[�Re�V�+�5�e���%������� ���.ؼ���E�����K�����A�
{��ppt���?��ɠ�Ca?;���4WP�`h�Ay	:^`5�/ߡ���/k����J�K͟� V�E�?uT�`{/��������o~h}���/���o�����'����?\����������濑�������YST��)s+跾�1u��	J؈zh��IG��0�ߔ�]QQ�	�}�������W �)P7��Ìt��?L_��?��%�������Пs���0�_	�R�{��������_Vxn������_Й�
�N��EA�0f4�d�Y�08`�(���%}�`���@��ߕ�������ã��(F�=�5��?*��N��D�[1��oʹ���������~��#�A �����`�M%�?���X���ݐ�NSKZFC�!�����-�D�ρ/��"M�k���OĠ���?�C��_��/���_X�PZU�DFE��C��K �d�t�������[��-�Ϙ|��9:^��0���.���B_`�wq?GE0T���>9`+�B�?�Y����-`|�
e�?Ulk��}�$�}�\���O8���>Y�w5s�ݻ]�3sv��l���������fg6{��^���z��=]�U�;;�7$!EG$�@Ď#��'�B|1�`���&Rb�;1���~߫zU�=3�w	�4����}��}������ޮG��� �"����D00���6n�w;D��!EC�pԾK�B^{��%4����$֙�$�#`����h]�%ﮏp�:�a�!yJ$�]�Ga l����rW!8�Y]��0~ALt�*F�`#�O
��!9�� V;>*�B�����X�se-ID�� �;{�`��؏��Մ�:Ƥ���q$6�i���ȹF�u;aW�fXM3D�%�����N��"j�G��M�]XPZ�A/�EOҗ�yDZ6�7��s	b�K7��&H��k��c-n�yw��we����:B��Ac2!D���i	?J���!�_���A7e���s�Nߧ�d�t��IE���$�[[��`��t�#�G��!�2� �\(̥�^�8+']�~.R�<-F�I5�EH TAI����Q�,GU&h�{Je�o#R�X����|�����<�X+�>�{�`S�dϑ8�0��z�,����t��9�4����Y��`A��{��+,u�E<��������P�@2�{�0΂��O�֎"#P!g�|(�&#e鲟�cՇ��
-������'t]��?��ܣ�==�:��������Q�5
�&����C��?u~�e�����kh��a�r-u��:d��~f�4v�TZ�� �k�啈��U��{�R�Z$�В#��I��<���XX�d����h��1/|D"�EDt���<�C�(�F�9�P�~A����	 
������pGޮ_:?6�6��pD��T7�xb@�P�� �[��B��:�IvMeN�5A�[�<�����82:���mՃ���|�Q�UaɸY����}
�9��DE�
ѳ�ϟ$�TՖ�b�|.aU	+/�RWSsͧ�4s&hb��N�����O	��Qɘ�rq��8���	�� ��B�4���0�T������h����Z����MW�W(�Jt�9��A��:�H���U���iT��:p ���U���'�Ћ�-����``"e����b�2�6j��G����l�����$�� K�!���I�~#��ajf����5�J�n躀�豚4�`7T�m~��z �V���þ��7/l*���������/�CKA�!�c�l�mwB��}����v�V����)ӆ����:Ů>�?�Q)֙M���LW:���q�e7,ϱ�M�q���F"u��P�8��(�qD�,k<��T�k~V�'�Dg�e*�6}Okg�٠�F	-�x5�*/]��M���N�Ɔ��N���W�rZD�HE�_Yݸܾ�qy���y����u��uVK�F�it]#a���`��p�W�s�Po�	0Hr��k�nBֈ:&�C
���U㊴������@�}9�G.���̛o%iu�ܘ�7x�9)�t*�0�K�u�n�!-�:�f�'p21�j��	�	���(
����S�,�mB��q�%;a=@���_on^�������N7G� xIo�)�n��o�%���
�����O�Q܀f�8�N�~{s{���"G[��IK�%N"o��9���q�&k����_���>�t�iw�
A�]{W�XR�Hɀ�e<v�~������;�=�?dyC��8��nv��������Q�%N%��u5QXG�4���ƀ�N���QQ�V�xJXk�P��T̞&�E���yI��bepDɅ�s�+�&�2�j�8�V$���[k<K�9'7�G���%�D}��E5���JS@ø�k\-�� �GE�2~���z��w�"dL�%��2R������t?��p_6.������K*4K2�*〷3�O��a?��=������p����צ���oacɡ�����V]�N �Id#V�E"�#���!e �:�K#6��@�F~�jn|�!��\O�Q�5"qA��*ARf�����ȀG��`�9��􃄃̭�O+�Ņr��M�$��$��۽T�F�d���p��S'Bo�E76v��a��@
���݀��0١u]����W��e���*6����:B]^k�^��Z���t�o)��;���5u�Qn�
b.h��Ν���y��.fe5��M��<�p�������e��؎V}?.)B����4E:��96���t�P�or|^�~�Ju���)iE�T4+�Qa{�km�T����rt5�6$6�%�Đ���[ �d��m�^@�ǌ�v��=ك�a���ٔt1s}��Z���5g$ӵO�����,L!�K�"8>������lZ�Ko*��1N[�5�� �`ʼ�ٛR�:V�%�@j}4,��]�ٴ�ZR�=�FV�Uu���}@j,�J���?\<�̿���X]{S�ܶ��[1�����P�˧�kk��&闥��s0(�؍@����>/Ke/I�q�� �!�k*/��q��5��ʻ�Ea����s����򢰧��Y�W�A�g(�܂��!��Te�R9]��Ĥ��]$�=�3VW�E�?]xT�f�)�^���oDfHK"S*���uu�8V��F�󃤵��i�_��Ɉ�6�AZPH���<��K�s���Ge�{#?:tͪ88P*[�F~���j�����e;��z%jj�o���<s쬿�]��|�#d������緛��:&�@�aI���ʆ���3J�n�|��C݀¬�x4�� �ʬ�	34ӭl ��4��K�ܹH���r(�琉�H��uF�b%���X�6�e�am��m��*�ei�It��Z�x�û��%��`�}���6�6�/o-�f�Vp�sl��#�ٺ�x�k�&��vX��}o4���"3��hG�20	�y�fJ�Wq6w��w+�.f�kK=vWv�a��QM���?���
,r�4�y����"�a�k޳SY.�YCD�.V���Ք��mf~�֕�uzq�Ir0 ��u��(�}��/���1��`w{ �IŜ��1��I��m�����������װ��D������b0f툊ÐB]�|�A:K%m�<�:�Waѹ������'���.��̞ .0��/�7	ZH
/w�Ա���+][�������K��]��>�v��6X�߸ZS�t����!��r�\-͂g0iPչ���F��DM �&�)A��B���T��e��1+}p��wd2[��	lcc��"`S�윲�F���=Bu�Ӕ!��ɼ�h桦������2r���`P4�:8�Gs��0i�]٤pyo��Y�wc����8],mi4j��L�E>�TF7�S�����n?7$��C#Q��	lRq-I����������jj���{��8��&��L0R<�줡�ݻE�!4nNX���x���L�B+gv���yK�8�SAFk��؀��2��T�ڹS��I���*��L�J�?���z�\�u�Re��#y:��M�w�W3�)W��B�p�J����cjQ��Ʋ:g������"��2��yM��i:e^����1v3-���#���~:��5%��Y>y�`��J=T3�p�AG������j�r�a�M��IE������s �R��|
~r�E_�]+j�U�nn�%���A�;���}�����?����Լi�Zc��k�W�������E�˅c�~S�)|՜�%|�^n�~q��1�.2��}$׀{�mş{��(���fJil@{��0�Bb���@g�"�<Eg�!��M%ǉ�
�rWpQr�^��MZ��$��b&m,��Ѿ5�ƈɠ�2� �㠌-�C�/9��ϙ�����(��=y�;tG^_�>f��zv�*'-�[�����T�c��d�-C����7���Wh���^�O�f�/����zd�+��=���0.c�<����V-6����_j6_򓵃�^�\��U5n�n�n@�)�0 !R��^x�lv4�#Ky��.u��Eb����9��5"|��Ӎ�x��'4s���ң!��UF��M�l`��(#�g�ޤ|��0!�(�x�*���}_oQI�n����غ�޼���yU�$͞c�Z(��1�������f���g�����cM	��G�����"L �ҧG�?����1��C1w�u�w�gqL
$Ij��њ��&U%Pg�{�erBa��lB?�a�IǏs���#�bM�	D���؀'4}�=-�*ǤlGQ�>�\F9q4���	9f�d�5�� B D��������lr��o�<�����mӏ8�/� ����kץ֊��6e��ԙS��>8�p����z�Q{~8�! %d���	Q�k�5�ޕ� p#�̃��Z�d,:��>�q��p�7�/���51�X��� �K##U�m-��P��򒕧&�Gݔ��n7>����h�S�q����@\�j�TD�x�Cs��{��m^�B:���K\�К_4��6o\_�K��K�����K��q�����%U嫲�&�W���OZ�F�N���U*`�g���aS�.��攪��MB��פ2NMFp�sas���d�`���,��r���1�9�L�6�}2ό|��j��;	yE*�F#��ߘ���G����c���yW��\�/�r�L0p���5O��	��S�ӂ9z;�;���ע)�zF(�	��g'.�z����7e� �ǳ;p��F��������5�����Pm�Ψ<rc?�a\���]u�U�HE7�܏����{�r���p��U�S��̶*�&�3��wPpa����Զ�����v��ݦ~���f2a)��@>�vsF��vs
��n���OU�?}��;��ˋ��ǐY|8�I@.d�75��K�����@�怈fNK2I5rX�i�R:{rɀ�d$�N�q���jy�z�s�:{�`a�'���x��B��/��V
L���#����>r7wNk��ҹR\��S�A�O��.e�Xc�uK��	a���2���P{�D`��gOg�1���?'���ﭘ�aХ�Y�~�ߜ���z�����)9����͍k��pR�{T�]��q�WW@s]�(�ӛ%�~�C�*�-����R�5X����*/�kP��g�ϼ��	�ux2(?�o�i	�aV���X`�]0�.���D=i���3��s��>#Rcɇo��[��8�e�XQ�BJ�TJ��^) D=��v�z:
� [j�b���8lV���ʴ�\Y0P�L}ou���c9U�*�3��"���"�f�a��E�q�X˥���	k�����]���;�;x/G;�]}��=xd�ƽ��/��J��D6@��d
���#���!�[�PfBo���9�fΚ � fԷ�(q싴���T��2U^&8d8v��uj
���',\D2�	�p;�'��ƛB�K�OF���|���z$��|��4w���q��1s9<�����o	���P� 8*�p��g<	'�h�J����$A���W����B3�j�O2B�DL ����1������yR�����ugYb5�������_���f�:usV�;��U>+��6Ǉ�	��������*l�̇��dV��#!P��44%��@zg���4G���cFԬk���8U��վZc�S��;TKEV=	D�}��G@�Z�ީ�8U�5褶��U+Z�G����K� �jO�R'~����qn��iD�9C���*�p��uM_~k�aٔ�#%
�g�ϳ�}I3��ҼcI�h��H���z����-#G�m5nM�[<����u��1����	�|���Θ�\��B/�����8p�AV�׌�̀�Y��|Z�q��#>v�F7gH�!y�v�D��?����2G��',,q��0�����uqԚ�ύZ3��9§�S�1��D.e�-$��њ�������0���D��.f�l_�w:l����4��lR�2y"!.�)��f|,�,�@���6�����X�R+�p�������4ʦK9��DOX�+��#��ĥ�k�<�����0e�H���U278f�֌��YW&��%4�O��$�lУ��[��9���7_Y��_�;L��~o�\P�Ԥ���&�ě� 6'y��/TK9�$q�쫎8p4`��\Dz\�/ H��!�ȫs�.E�`�.�R�#�cH��gl.'y��#nz�V@�:!���eS"�h�����7�Y�xI�f�=ި��� =����ƌ`���f�"7��;��D���O��b�i�·��!����Ҝ	��![���Bz9� ���@�D"K���		���|�����6��
����C��%0�Ԡ�a��&�oz	�������sz�"��B��P�(��/�Řmg}�� �I���c��uYZ�s�ĩ�C�L�a6}�Z�y$l.��&Pts�t���=�~��e����2	������{�$iuκ"7/G���mɎ��}���DG�	���OrW�s�$��Z7�i���,����8vR�5K&��Gy��qOH������Y#bغ�NPȷ�ฑ���F�Z]s����z	�Or��u�������\�FL/��]�7��LB&-߉t����S��������	��XQ3aʮ|:�"��e��ɍ�v�� S�5H���+�.O�)w_Μs܏U�r���?6�����E���p���U����SrX֚���'������D\������uŉ�U��p�%;��V57ZHǼ�%L8�M	�d���i�֘�u�Ӌ����MKg��Ɂ�׺LN��/����n�\NL˄����V�~����̱�ZAN�MV��.G} ��������#�h� Ѭ����?쇇82t�dl�׵�>i�f���ʟ-g�����3J�ե�<TVY\ӤL�䶯�KC�8s�����T=�|_�d�#������>�5�>w�~�����N��P�û�r�>҈��X
ឱ�����{�n���t��h�T�H~L����ӵqrJo�������7��;=�z6?�so�ɔl�75-�n���qgl4�;:�d�o<��ݽ�=�]߽M`���Rb��%ᨦZ�rm��|UJ0�K�/��,������]d��l��<�"���Du��IqC��~f�z��T4�D�tآ��6R,�k�u�ک�또�;��O�2���fff�����]yχ����������z�;�uf������ߤ6�����:�#��ɿ����z�������Շ3�D����CS���k�U��+yx?�_���������������v�3�����խu��O�W�/���G��ٷ7���~b�=���}߯��<��gf�M�������s������?���'8���y⇿c���������\������������ͼ���=/>�K���~���Wg�������w��O��|�g���=�_���r��w�MV. ����}���_z�y���<��s?�3���:?�?��λ�������^�g��v��ְ4�wj�������Uo����w������^��z��|�W���ɟ����gf�����;_������k�m����U���������w�G~��yi�a�$p���ݕ��b��?�g^5�(��w~�=���_�՛g>�K�������_�)�_q���<���'���'ͫ���=3�����g����{?�_~�G���䗶f���ԖHOcHp>������̫����������ť��w_�;�����[���ٙ?~?��;^��6�	�Pk�穙�E�8?��g���/T�;���瞽缱���g�����۟��ѧ/��o�Ͻ�\���<��ν@�J�{ᾯ�w)�ܯ�/m^Y/�Jm�r#���K��6kΖʺԕӐ�?j���Z.�F����7�j�!W$���
K�-�c���S[�W��{>�lj��1a�MQ�O�D�@�6���|���A���������>�?&�-�s�&�X�$��j��%Ͱ��������d��]߸�]�憗h���2LP����<ҋ�-�f�Oe04��@p���E�DI��LT!��/`���̖n4�FxN�T�f���L���s���/� ��#���^�b�հ<=�j�T���C��(�Z~0��<9w1u-B����}�[��`N��+2�a�#�b���~��ׯ�*__���[��+�ۗ6/���6��S$��i�[eA�|�ʕ���!�8f�܄瘎��hN?�Q/����L�����S��`mCM���ń�)[����-�x�?fθћ`����;�P��[��j)��d��vA����(�|\\�S�nq�T$
|!��+$9t.��2i�1�����G&*�VJ瞹�����k�j/���g�(���r���R�'4�
;��'� F��rnl_t?��_ɖ<�A����k9A7�k�Wt|�?Ԕ�C7���o-��$H�����n��=��:��x�!��C? Q�o9b��|lS��nK'����䕔�|���C\:�{�5����,�Ҏ�n��{G�*E�ْc�8�ኟ:�uI��?��Vr�dq@Ls2�L�&������:�=�'�e��5/�+ ���`0�K�W.��9}�KI9ΊF�9א/W�yX|��
ɔ���/�ɚ�ILHlrHV��ƕc�,��a u
��)���Z�0\6�������W�R�E��P��`�c&��dM������vݵ=
*e.G�gG�s�a$�t�!ʠtn'�jy��U���qˁ�{,DN&^��WxaL��6$R(FFy��[�����`i�-z)�a���*��we�B�1bX������~�a�)�w����to�MI�yP+
�ŭj���l��������!-�JW{f�Y�����]��I3h��h�*3��EiЪ��� 	�oL��s��tŸ�)�/+�4i�����0c�r�E~0�^�}��v��͢��ԈdfK>G��&{̖dI�ƿ�5�1�j����(I��$���e���#�K��}/�����������P�|M�4|�>�'=�(7^��j�����2��1nz�?Z�����EC�����Koϋ>iR�yf��L��s�㧲��;�e�V����d9�,kIw� %�㻌�Ł�c���?�{�y�M��_Y?z1����^�ͺ�j�t���)4�EE�r�t�O�zC9�G,��1�J&�4߹ :=�qۈ
�gZj���L}���{��& Q�:���䭣"��S��֭/yq��(�@Y\Y5�AlZ���� ��M�B�Nuܿ0�S{��p5�E�����������⢂��N"C9���sj(:2�)�n6N3{�>]��j��բ�������f��9�C�]�^e;1�X11�����.+�k�pH�Z�����8���F�n�Q�M5Ql)��񣶜ͩ�UM-U!�%m>O)f�W2Y�8�o��)+x�̚���9AJQ��L<K��Hep�\���l.���Ӣ"�I-@�U�⯔S5O$9&��{����N��A��v�Ş��%''"�>�22O�&�"`��Y����n�ry��m����
��;�T���/Ou�ǘ���\���]�:�
0
��
�5�����^���R��cS�]��yb���-�L�P�����쾟셤3�JU�&XS��>�-��MKp?W�?XV���v\#�N���]���dq���i6Lm2&鈂�A�������0Дz��#]�Y�&~���I��MY�\451���V@ew��=
������$Nz���¢z������1ÿ�QY��1�7���)��ܣ����Q!�s
fȺjV�<�B�G��	c�i��U~=%ar]S��>�$����	\���)mg�_�㖟`e���"�'�����+a+kq�^��(n����a�Y�/,N[��|��7in͎�r��:7ޔ��puaֲb��?&ćH������d�L$A��4��$�t��v�W6�>�	s����+��k��_V�[���y�`D�}��[<��dC)��3����$ǆߊ�L\we��9Og�{�*��1S���9j��p��Td�SZ��2��"/}���?4�G���6�/�44k3���fZ��d�˭RA�^��8�[x_i8d}K��3����7���O�����������_���>�++�?������/5����fff^:����%"k��hx�;��}�$��?��;#�c��x�W�n�F}�WL�v\��h�"�n
4�炢(��7^K��S>"/�u����%%Z1
40Iܙ�˙3��!����L�s�gt��V�jC�QzC�3����L���l�	''Y�3;9!�IP�V�Bz�4r�oTK���v$�ʺ�����D7$̂��l)8Q^��HhͧU��/���4� D
��2d��V�R�e�kj����I��-�Z�%5���rg)Jg���p�vɭ'��s�Z�'�DnNh��_���X�΅���tT/$�:�R��>8)�cou�5�3X��A����}�����r)�6�T
N ۘY*5��K��}W�$|�S	o'�^LhF�T�T��2A�BB��k��̓牖+��R�)<��@y�M&�,;d���k�G��v�r��pF�;C�.��wJ:k�R��ǅhۼ��+���a���2Z�s5~��e�\�s"*�b.|�˺�����,{�~��G�}�"�~e��mS�B��l�����1]�P''�(�^_  �{�m\cW�v�qm�i��T�R��\�"���$�X�����fÈ����^��[ l�m�t�ߴ7
�⼲�]D����͛5�B�_��"{��E+M���ٵ�T1�F�T�e������MS���a�Ã������hFρT���*g�¤���_*� Ӿ le�PNR2�t��46�K]�F�>��'�>L�2���`	����z��MN/P�#^('K���+Cǅ� �,Ͼ|����O�K�O��n���t�\�A��=2�f���M`��`7L i�T���TތN��K�Й�6�Z��4G2���Rax��L��>l@�y	�K���&�#�����Su ��L��Ȼ����)=���P+%�r�V�2H����@,o��"8�4i���۪�mV���>9����Ak�U�w�S�*#	����j�̆WA����d�;�?��ڮ�9����GP�mkj:8n��uA�o��� ~��j�l<��Y� ����6���r����.1^.^ʐI��VF�o�ILW	�q�r��s���5=�ǔ5M�i�!��b�y3�U ��ځ�4�>V�d<&�._\�8P��w��TE���T��&+�f~������N�9=�%Y֖zƆ���.5��g>���T���$�p�ìR�m�őɒ��$fՏr����bz�>�߰�H�Z`�B��dx4�%p��⢪�أ4��Fo��x;VF<�X��2���_���ùݢz�[W��q�/��J{�k�;|����>��ɤ����UuI���+0G��8�%�����շr��T�ˊ:?@j@��ʃLj/G���Srp�[�G�%����=����>�l{1d z��>�3����@S��.�(>��S�Pi�C�A����A%�\�����
p���h��m�;9w�������l-t����tL�)�	����o�PPʞ.�Yv �b���f��*V���~1p��3a1vJr��)kT'��B�����N��(�+��SAa0������+��f��
�aRZ�g���C���湪E��䆗�%�HՉ�#,���^"tz-pa��l����"I}�?��j��B��)h0�n�W���t7�*�(/����jt��u>z�2t�h3qT]ۢ��u,g����o��P��d��d$�X�2��|��%��u�<���-;�-��^ba�|��K��_��u��Dx��$s\|C3��&��LZ\�
��E�%
y���)
ѹ�٩��z��H��3�SX�`�6����\Y� ճ�x�m�OK�0���)�Eh��}���BQ��z��M���mC2Q
~x�������ރwuk�Y]�-\È_��4��l��l�4���jB�i����kۖ�+:V�e�TO��/y_�-TS<�����s����ZVv:�"�攱C�2���A!%p������G�8�,�ԑ?��eHLL#ҥ�/��3��$;gwH@
!�+j�u� �j�D9��@�z���}����k鼓x��V]o�0}ϯ�EH$�=7&�m�Z��R��2ɥdu��v�����4
TZ��%��܏s�}�h��3��)�8��	P#�{_n�O{L��7�i��nL5%����5.�W4Mؖ,)$j�K	�	�U�#�L��Z� �x`�&��A4���
����Di�7���,�lʰPS2�7u�a��sɡ����K\��+��kA�����>aI�:^�"Qd#M�}��)�l�������G)�KJ�۔����!����μ��̃�  S�
��Z@g���R
y�)�BCQ6���hӃ�*�� f���1z�e�(e�Q�ҢQ�����h��;��F�FJ������n�&�8窵�-S�i��]i����I��
�>\�Q��,ڠ����M�����W��(9�NI}���Q�f�G�B��s̡6�K�Z��f�$-����PTG�<3�H� ��
���7�����d<�� j7��cnn�A{��қ���l�nۋ�Q�)��K	�vf�&�}q�ؔ���s�;o�ەͳR��3�̀.r@,PA1���sbL�����/�w��\7��he�@t_F�rn�VY-t�ߵ�n����I����)c�?�G��Λ��oc1x�uS�n�0��+8�u�ކT���m��a���h��,k�4(��c�k��K$��I�O׷Ww�~�@+�[���}S)�jp��	d�	�i1&�J��}/���!�Ujʹ	}��B>�n�J[YZ��bw9�,��HU�����8Z�'����7��=6��b��cn���<ت�[xy��al�/`~y�h-��?��nP;z>��M+�����a��B�;v�5fY�Ч"���_���1��#��>Z�𽧣�M�|	�ܠi��;����	���������\f�jy�P'|x��;�����r�{�.���(}�Ɇ�îvzKil��iv�7LÛ�:�3S�Ԯ��͸\+�j(�B�R�c���A�}��xH&r�c�.����
�����$x����N�0�w?ũ�Ȁ�3*��`@�X��8�±��.��c'M[Ā'���s�z�eXý$k<·�r���`��t��'��0Fc�>H��c���˃;�U˃��$ʓ�q��k(e|�Z���+�v2���I���N왉Z�g�!HK�҂�Ɔ�B��b����j���s�AlH���]�>��%�?-��ޝ]9W��XU	�%M~��*I+���p�H��wЛ�vZ�'),��O׍�pY�#Ӷ�:�ܣ�Mf1�� ;�a��]�NW�ޢ��^�B;~K��~�m��Ғ����4��-�r]�~ Y.�Ƿ6x�}RQk�0~ׯ�f;���,�+tб��q ��ɒv:7-#����$�uӋN:�w�w��\�]�r�m��|�A��7�k��.��ZZ�b>��bYet���1�!wd�V&��V)�6`�	+6���V�-tv�˻%�;m���b/ĲQ4��ʧ ϔ��>F�x.Dy)n#(`l�#E�C#v�OL�b��r��r W��(.K�[�Y, <�E�	LF����26����ⱳ�����E�%�I� 4>N���0��+�L��+`�0�{��=e̙^M�=EU�����t���^C�X��ߓ�Ňa���0�+:��5":V��Q�,������0�YYW)Ӹ��w���ͅW!pC]>J_�X��o�`���vT:�/��k���P�����"�6z�$C������;[�v6?���I�`S��6�u�B-T�(~��4F��\7���b�TIy���A�|���r�=~��D�jx}Tێ�0}�WX���+�$�f˪�����U��1���w|!@�(q�g�̜3����A�F;,I��[�~XE�-��p'��!�!�T�@Y��Ε.�)a�Kkz�13��z���Ç���������$J�(4�/���@�Y�^�I��A�w�ܹh�ɘ�@�J9�����bK��; `���"�\�?<9$D���%ۢ��寁i�oQ�O,��:LjUB#��N�)OL�s�)P�U:Bk�����,�2#��I�	 L�>�����9awZ1�X�ɀڙZq��9�*��MG�&�a����B�
�J��E��~��r��o�p�2��ȗ�������K���ʲ�I�IW3/�6:�`ޥ8�z:W�qP�m��'D6�2�����&iS�1'�\("9;ߎ�����LN9ߓ1��]�Ԙ�;9M�S�:v.N���\��`�%l)Y��F)t[d�/Hc�t~O�\umM`��Z$�[a�nV���$-�tTx�DfS���Owk��'o��_���L�֟v��%&su���16��S�;l8b�.1�
��Y��O����-'N��fN�c|�׻�����18,��ѱ���aw-�ru^��{�!������(�%�3�G��d��o����U�x��TMo�@U�	K�� 5*Z��(v׎��'T!ZT �����V۲74�*~����7�	q�+��6ni���$�<��������'�M5h��� ����E��8���m�ǋ�8u��i�'��u�"�Q��CE��[�m&�
���G8>r f2�rc�C�a)���q�1��	�Z?e�W{u��H>�e͋#�����������"U�1�Z�L��d���(H�.�����n�{����!�]��u��ɏޖ�ֹ���֜s�~�1���>ͧC���
�Y>R!��=�pE<A�Xp�l�����P�C�:NH�:z��d�;#"�!t1�J�c������&݁T�J="��g��@�K��̘Z��4IH�	��x%b���A�;1�
��v�w,���J��{yY��Sʓ�S?۹G�b���䟥����Bhܾ¿J�O�Ⅲ,xG��gN��c�Nu��Ns��5�E`�!TF�]�y($]�������`�o����c)���,F� �n��O�[����Em�ؤo*�w��]�����!x�\��6��m��*�\��v	�g��9�,�J��?��\ki�,��¨�MQlx%S���M���ܩ�{Ӭw!M'.I繌��c�j�j=��{\���Z��/ZtP��.\l;�����ǀ/7�xvc��i��m�j��gx�;��}��f�%ʊ ^Rk��}x�;����q���f  �����x��w|յ8Nȣ	d�� ���ƒ�jՋeˎ,ɶ@��$�c�ٝY��ݝ�ήd&�Z&��@B%� �H���j� �S�E6�����u�hwo9��sO�g&O��:骰��2�#Z*��JKfΆgi����!GOYCI=a�Wh���ZY$nU:fz�L�Uh���h�/mf����9C������⦣Vڌd�c��&�VrX�&3������Y+�����YZ������/��[Zz
�(/�S�P
�*����VM+-iO�z��t-c&RvZO���l�+ck�LZ�d�L��"v2c&3�fG�3ZZ2���dJ&���Z��9C�ff���`�!��
f���c6i���r�3	�7d����S.F�pq�X�����ZuSSSPˤ�&v_-��)���q�h�N��jz:� ��(���z�ZNXI��
��~��%�2h��(��iFX���9�H����q���5=��2�TKUU܎���dZ����H`���8�X:[@"�����ʌ&�	([7���M[�63���I[���d�À��a�3=�Ĳ�ME��HƲ����8똚��s���n-��V�Nh�� 1���2�����a�������744��{p��wA_Wwg?��6{��t���7�h�m�?�hs�����F%�?39l%M�*u�m��G�����O��mD���F�Uب�����M���l�������g���	>����&[�� =�AB.���$n��cgm"�"`Nf{(�8/nɭ�i��#��m#�A'��p���=��H]Ag[ǂ�P�hي��Ww��&���D�J���#n�ϟ���eh���L�
g3�ӱ���f=�ge�-E�*8�Qkx������Cd�F����T56UE��hCm]s�Q����M��k��MzM��9Z��nh�l��#�s�'�zJ�õU�50bu�1�j�������H8l4DM���kk�7����<c����hVEjk�Mݨ��6�47�z��>l�64���F� bs�Y��X5>o���I��h�	\��F��k�G�hCu��P]c���ں��m�7��������5EG�m��^�׆�7G`m��Q@_]�Y�W��E���hcS������y�=Vt�&�*ڨ��Q3ZcLכ�뚢��u5Ft��\[�Oo�����32��5MU��f��L7 u�z�!2�qzSC�n�^==\�ͦ�6��y�W��8�Uuuӛj�����z�^?����ި����uF����Zo��DV�y�o;�wD#�\;��h�E77TB����z���4����k"��͟��������h��������Z�&\nh���5���kL��k�����w�U�s4�E�x#6u������u�@7�hĨ�י�5u�u#�n�꧉U��TfF�#FU�m��;nl�M5�ufC���4�?��#��a���.�9����6kz��fcU����0͈�T[�M����F�bԣ5�p#�ԱM<">g��\Ut�hMU�Q��k2k͆puM$j65��-tX�^_o���\'v��Y��鱮*���E��������z�$�i�m2�Ñ�F�l�n4}"���g���n��mi���rw��y}�X,Y޶�����U�H<k����m}xR.�M`ءa�-�ٳ��˖;�Z�ͨS�T%t+Y��6��a�hY�%������mw�mc��H�N$�Le�9z"7!D>��׃��J��i3�;��؎���췯�7���1A�Z�#z�2@a��Ko|��x�>���0�~+7�~���o�Oe?�����XJ�Db�Z_$��#{��E��N�NZ�_U�� 	=)��L�����Йc��n�p1Ae5��y�_�uj���cJw� ��&���o�X]lb�&+�)˷	���[}�g�1�q�L���|�/|v����"����E�KE_|����˾���Me��@�P|n�uɗ��N�^�5Ι�}���G�޴�a�ʌ]���vV��e�>���M7wU��e�3Y!0��j�j��?����8U���ge��d+�{tuvt.������uJj��tF,st(���d�K��	��lm�,o�+I�	��*;m��<.#j�(�����
��J��5���k����7k��AvUGQh��������e�Z���'�|w����c�ϫD��sŎڦS��O�#�����9��qqDӨD�D[|��h��y����.:���9��Z;~�������T=���rb�c��]3ϺL6.�)1;a�-F1��fr��l~�β
mv��`���a�IB��y}BZ�*�'���_r��
��dϺ6d����ܵ��6��;��Y�6�[��=�Bm�%!�j�^{�|AІ3b&7����T/]&��J}��P�Z������
��r���|�:�Pm҆��ڤ��䥙Iui{����w.�GWϠgdkf�zepvZ�L��L��t�֮'�vFC�]�
m�3�d�DH닛 �5�Z�L',�9Z�NSk��Y��P�{D��T�0�` ��|
?ɗ�]�BFb0�9��2��G�t9X�	�hʖLX��i��jY*�7�i�.4�M.I��N=��Ɍ��6���71����{S����?�.��*�j�71��(�
`8�,��Qr�kǍ!�I�r��K��MZ������\�~~�+|���F-�O���[Ʂ�e��*7��PPf�����8Q�x�)�)G�?:S�����%�)k� ��W��T0t�F3l��P*��Z[�@�����&m�}=�I�����Gb/A�m�ॎ_H�����6� \����+��(�˯�{�I�~=�Q|Do�ʡ��Y3'u��.���b�D|Vi�L|j0�pk�L�02f�@3&�!� Rk`������7��� );�	��Ik`�22�V��"f%}j����t"z�l�	U�ce�Lܜ����E��� %,Г�����fV��1y�gy���X.�z��wk�H+9���a9��>֢E�檜�b�5˴h5��#��ߢ��JVO[��4,/g!�`hΊ�o0���i<�9 ���aH�I3w�	���UM�:����V<�e@�̕Y��L�.E��s<�Bq3�)UeZ�Z�9v�2�ɑH���%������k:��g33j�I�w|`��gVɽ�Y%�n&��i��H\w�� �Мt�)�g�fͬ��;��Dߜ`����*1? �'d^�Bm^gOg[�ַpNwW�&�5~4)�CóY�j�k{g��V[]݄�Vk�Sc��������MS���Q=mjs������A�+	i31��TUE�h�NW��:G����f9�g2��tƧ�,�,�È	��2�N�W���	xn$��,�A<��֬���X#Dk�_��� �nt�4�@�}�0̨u�Yalh���`�I��Ö�8)� �����J=��+��7��ȖA�v2Z��)�Z�|�����c'M��<J��>����4g`�֜���c���@hڜ1�{i��a��.�Bi��g��g3wJX��a�"$�"{(��FB{\s��6.��N4�`<������ �_�0'D�B�Ғq�����)g 4�҃����'�Ğ Z2�&K�x�`Գ��MP.��ZDO�P�C(8p`�-Hb1�G)S_� !\���.2mF�ti�'PD�/-I�aa0o/�Px�~��|;�����Ғ�>�Ģ�r8�L�A���mO�� C$P��A��;���;�&���;��������:�Q�fH>+}��B�. ����0|8Js@�@P=�#��x+���;�A6=Q �=�6v΀��4OѡMI���T���4"�039�[E�a�'ª;+�otZ��I�-�&n"F;n#`CܚҒ����Q$:)8WV؊��k�.�Y*��8�%j�#`XQ�ϖ�0���0� ���2z��p�*�
��ɂ&�� fa�8�%�1cZ�kQS�8���	�'�p�`DTbiU y�6'��qi�z��ct��ui�B��3�Ba�6 ,'�CT.H䚣9�Xi	��iIz�� B��h�0�W1��.Dip~21-3
t�1A�����T ?̐(b	m's�鼼�P\�Iٕ`�vkD�`�~�y��l�;	�U�$��?��ܕ��Ԃ��%k���2#�@���U�����[�6Y�[M���3���Zd�@����:��ބi�8��)�Nk����)l�����0F�����u���pX�EM���!���;���Xl0,H��!,�ŝQ`o�N�H�,����f:t&[����t6YZ�����=,��N����1j�Г�((p&�
���{P��Q���S¦'#v"�� �F�-�
(�x�1O�wD"�6�8�=�A#���!؂.���#�l���6F�md#֡@�r6��p��9��Ƈ�؏X���/�8�[���$�6E�h?�5�8���"�,���E���d�!7S����MBst�Ź䤧8�.;�D��P-4���@̺!�ͤ�F���IeW+��Mvi8�~�(ɤ,c���Y�G�J"�A�D�^rtDi&F镈,P1i9qҎ\bL��Q�`�i6nxz�l!�. F0$Db.DQES$��=��l:��GR�c�v�N ����8�&|TGl�`��[�H�in-AbŐ�Ķ���.#��x.���4����鱐�&X[�m�80��dPth����d�X���`�W"4��!(^�%��l8"7��N�����,�9J��ih��2�)5�ٿ`@k����{{:��z{�yu�]��(�*R(�:-m�<Xu��*��ˡ\�4��z��ay�L��[�q}T�}V�a*�uz&ZFA�r�$̈́���b����B���Ю�;�N�a�"o7��D�Ac߈h��a 	8$�� H� �
����	x:P �C�P�������U��Xx�8�K⤶�f�)�,�)���}JK� ��N7��*�|O���4`?)�h���1�*���l�3�<�?Gt�9P�0�JX�6#��
��FÖ8��J`�MDlZ���@áK�ӊ]W&������
�����p���mɐ��r�$��~���,��$���ȌX)$|�[Dzd�Y�(n9$���Po��t _�"f$����&�����Z�5��z���'��$Jfy9.�)-��rZ0�'�����DA#��n�	X��#�X���rT�ȟ�&�6��/p�F�x\��Ԉ�K�xt���]q3����+��iD��:�0f��T, #	8���M��I��|D��+�@�f�z�|3��:���τ�p��� z$'��FL�����gU8�����X
�u���c���ؑ��u	�B6��.�<iҒ�FJXI�$;j�@���w-+�Oܹ�	���Q^� p� v��:���-�c��J*Q�!zXB�&	�錐��!.ʸ�Ahd�iK�������2G���.J��wEٵ���d����=O�NL�I���wZEp�g�l83�a{й�l��J�&���01;!�
�	��AVl;Z���P�ۀ��U&�J:�����	� �T�����A��K9Eb|ﬡ��S� 	�r?W@5WOZ�Ğ7��Q>�̭-�l]�7�)�j �PBu<��0F�,8�A�HP�4��ҝ�a����XA$�]�^q����>�^��)t9����X��64��eZ;1]�t��f���N���,C��4ql]������)l!;n��P�W����I� `b��FV��,�&ځ��I��\ȭ<�f��%J{:��
�	�>VΘ�
�Y���м�� ١�M-��h�<�=��Bh9yGcyâ��T".�zXA@x
1��
 TG��nGq�TZR�,^3��?i ka{��:-�Dעg�hH7:	jn�XHc(�y����ԑ�"o!�E ����v��P�P7�3�c>{�2^G�����i�&b�R�����y	L���7U�{�)�x�4�DPQ�A���,��������lKG��\&~�*E�ؓ@�;.�GO� �o��Dy�&�(�-�?��js�Ռm��.~����$F�[�qZ����
��@�R� h<������2���n��D�(�E�pm=q�LZ;�R���+���a�|�ʛ�G�#Y�9�:�%�F��c�%q+�~;'v�#U׌�'����؄_tT)q1�g4��
�U�|�&�=L�3SD�2j,�<*J$P��p읖B����JM�� ��i�viS�	����G�U�5�?�o> M�p}���n.;d�rf����kC�����eCJ1��ppSH�(�p�ʟ�ڇ>�Fy��>[ 4*����m��1���ɠ�-�"�>af��SB�.j�)P��A�@w
9�ɸ��h��\��|�QX�`���$/6��噢d����1?JHNZ��<TP�������"9�^\$~�D�I{��a�WZ"CUQ��-���zJ�GfD��w<����v��h���~� �<bGXl� S"8`"Sd��r�0V�X �K�bKd8��E���+��ȇB����Lo�A<Am����<�ܦ1}�"pt���/]rr���c d���D`�!0Mk��7?��l�R�VF@Ap�#F`��.���k,�/��(z���DX����$"ai�q7*�9[�6� �H�p<h��fL�G���W�� �a�ݐ��\����8�|~����oi�vw%��-(HC04g�y�bV�E�d��bOxO�����dh?�a��iAbA={���J<��UM �6�t_��t됸��f���:`��z�Ⱥ�uY�Q6����E,��@�l'���w�����#J\ �0�sP�W?@�J��aW"����Qڠ��S`�C��lV�E�q�q�!X��8,�=�R����H)����W�&+������j��@F"�k�Oo�3�X2�d���"	W�Y�Å�6�ː"��2����sQ�Q��\��b�+�g�鰅&w*�49��wÐ6��Jv$o �ZPv���Gp����ے&�U�"�mXN$��<\��d�D#A'�ҁr���F�%+��D�K�(p{T�}�1)2A��M3��I.�sQ��y�9*�R���!�,/��e���(��9)hn���e�Obვ#���*�"$�鱲��L<餬H�c����d4B��Đ�)wWdʍ�J�QZ��4S�w�4������
jJ�1�J�Ȍ��#C80s8-�x�����
S�1�zL���e���� @��,�	��yv�A3[:�����rJ�DRHdI[����C��7�p�$q��Ma�09��3�Ko��W*�-�ʠP��rHP1�i�B3���y&��Qj��^¥#}n*K�a�Qڄ���B�+�m���:��k�C��t^�,�^č)�̂$��&Y�_Sίp�����F0?�.����?h:����"���1�gE��|@��#U�I*���$��X{W��\��7�$(r��j#^v�T~I� kL�����S�8�\�0�e	Q�d�N��8�#t/X�;�v��	�A���(.db0F�}%W!�U#�;�J�mPnݰ�6�'�j:'`�������|������8���UA�1�W��~�&�}���*��(�D$�#���j�Mӌ
�q���8�@12V�9�����@	�O��N%�z�E��b����=�c�B\��N��sΑt��c��+�:��D��f
3#У*l'����hT���"E˗0�S����� ��K�![�3b�$���7nH H�'�3���K>,9����|�Q�2(�o`(}x�Cɖ�C! �(�sO5���ex��b�)|���7A�#=Na��E�׼�a?�)��$~�6�S�rQ��4�sB�rD�5�j����
9���FU���b#d�\ؤ���)�v�$�(r6� ��]h(*,��b�*�Q%�q3,�s˙.W��4=�<�'x��9s���B����;
/��R�E��R�9ŕ&H�"H:b"�'-����G�ZŚ���4;���<�q����7	�S�Km�pj����.\�.�>�$��A���� �A���)dc��fg��DHWŽ%U�˳4'�3zՔ�V�,�V�F�0�"�U)녀:��-X�dc��>���� u�<R@	����3X�0�Z�NA�%�_�����
�'Gѱ�"7���rV��Ԉ��|<���Myaε��+l�q����Q
#&ma��
��m����TuEꉲoHS$}��XA}*��]��ˑ>+�Kۑ���v-��1���
�%c��~l5]��
X̺'�5G�b�IXj��aU�*�
�¤��͛%���C ��cl�<��oLk��G�/����[/l2��f�MΦ/yv�q�7�f'$�1W�6����`�5����)N�H�D��N!��8�����BD���A9;��CD�{n��
���`���"M�+��{4�,a�ѽ��yѫ2��,��iXN'G����eq�}
)Qb�X���PX�PY���^)��<&��
/�� Ms����{�̢G(K�ǔi��@>9s��Z�x�z��v��&%�0��s�8� V��z�M��Q�%b�D]fq(GH8��Ѯ0�5Bض ���8 ������H�D��V��`
�8<*�� `��A{!v���㐾�)����R6@�(R�2 �l�j"�$7?��$��ii�T�#�;3�f�`^�*yec��t�<H��b64 ސ4��2���I~�q�<���$���Љُh_@GT���8��N�U1,���[/���p&��S���E;`���c;��ؔ~I��>,o�i_�OxQ����FSP����d��H��9�xȼ'�X���u	��8d$;�]�ș^�u�q��V����,�H&+�2Wa����v�� ;]��$AS�<�� �s��[�B����徑E��х�jw8���I]�o`B�t�q�8���m��8S�aJ,��|�.N3b;����-ә��$9&`i���)/b��+q"-_[a�1��Z����}/�Gp��Y�[��D��@D���ǹ�Y���g� DG&�`���+�D�3c%��D��({�k<���p�qӜt^L��d�-����ƉDf��/�	F!�1%'��	�]Q_/��AUw���\�EtQ�"��+�lD�H�������]��SY\�r2�d�����~��=����VL�Y�t�@��23Y+3�*� ��
�����S?��N����"��Ĝ����w�K̒�2l��si	��b'dE�Ju���#�Q���z��I��ъΈg�^ǣP/��7�YU�����D9�Y��2���!Y���.�P��E(&X���g�&�!O�:�t��I��2rE��5�D�:�!�N������Y.�Q1��Ӧ�lk}��q'X�4$��`��aq���N=0/3u=ܨ�����-e$�P6s$9@3b�q��H���9�o��Lь
a�%ꑴ�8�Hn�8'��D����3;�� l���ײ���^a�O�����Z"$��Aρƻ���?a������-�O��Q����#��H���Sdf#M�)��yd4h��\��{��b�� %OI^d��O��wH�"{�o���HʚL�|�)mJ��� ��`�ܺ~�0��������҉,�[���w/m�D�&��1_��ww�c]�E̻�	y$���S%i��]�
vC��2l:#�$��^$7��=F��*+�	Y�e5������`��?Or�1N�{�
e��RtQq��� _M�"���L2��g�-d�@�T��[T�ˋ��@���y��"Ne�J@�#�����-�r�9i�
/�A��G�!�ePı���l��h�?k�"��Xy��xӹ�f�O�{#��d�#y}=7���zd�� ��tw�.C]ۓUXh��iN�zb�qY�?��~R�-"��Q���5��� K*��K�i�����G�i 6[Ә��IݘG�{�l��+༫K���C~nr��2�ܚ��#�ʴ�[�}y���a�������ne�D*�'��z@6����\ڵ�=
�K�n$)�!kK���jH7���Q���(�I׭à�n�+u9Fl��wl�5�X�"H���s��P�ߎ�־Z�ˬ�T�8cC<Hz99�i_(�W�1S�.�HH��&I�k���	M�:uT�;��'���@o=JI�y��+�a̟�����-Z+���s6T�U����f�̠�
	!�	 E���`�.ΓcjC!]9����ޫ�t�G&�,��3����܄��� �9^@PD��VR��t�;B���tbϝ/EpN�A�V�j�Z���	�l��(�C�r�X�����Ru��Z<v.�1�I��P�ɫ�B�'QF$�Є����N�/�ۧ**zB!��ѧ�j��z�X)`�O�.��Fˏ���,��XTl	~��̺q���A&
.��z��@�&ީ׹���x���>�<"�����!���)���-���b�׊uЖ�B�';����%��e�ڻ��$hI-Ӳ��(��6�0ҫNk~	�)��8V�]�����^��Jo�l���N���tPw	+?��*��ʋ���(�e�i�N'� c�Z�a��R����2b��p�{Baj^1Jww�a�^3�qC^3~L�|�F:T�+�l��S%~�@I�|A�2#t�4^"u!9���s�F��O�`k�B`[��]?4y��܉T?}����J.������H�:`z�`b��1|,y:�x��"zʍ=�Pe���*<�Ħ��|���Z3H�fĎ��^��l�}��6���]\*�[��B��LGYOi��䭷X��ZiL���RYѕ�	��EiG�8f��³�K��w�"��NoX�u*��&(�Z��t z\�;u~��:��)��=v�j�MP�"��Ň�/qg���
�<nk��~��Hɨ[��BP��a�h2qm��
���WCW&L`r�ƾ�l�|s�C�dL��-4U�+���v_�����f�r��0(���	-�R���ˠ�.��%#��s�W��@�$EH�]�� *y�b=qy*�"!a�,.�HW��J��N��n}�Լjd�|F�I�����O5��u6A����d�Qq}��V�����ϭ_��1���o�"W�t!�<<�.��f0���&��h$��{��N��эj���ȅ3P�'�]��(�q����"AqU9�j��-����ЬN�� �����?�~l��(��_Y�ya5C��U<���ڒZ }�h�y!� �jPʍ{�L|�USˠ��櫱���Q�Db�<eJ�c�� ��7�"���b�WT�m�j���(�9N���LQ׋�Y�j��pBf�0�Ȥ�0��R^��P���Q�L�����b�`� �6ؼ�
����3��������"d��f���Cu.��*H%�s�ՅLN1iq���h��
(��zGvT�sdP\��B�9eP3�J��o_yaZ2�x'k!��1=.v����7�<h� )V�jL]4��"�n������d��g
nU��P&J���u�۶Y��`oXz�l�P�Ek��^�%�"g���L.���E��ec	��Z�'���k455!��-8��K�w�Nd�P���g�u ��Bn�A�T����ʣ�u>�K�#��z�L�w�C�P@�x�p�5�[3��^�!�"R�l��5�Q��%��UFziVq�A�G�6�����uP�,_H1Je�IO�/�:�{�^��r����B.I�M.�s���=B��s^nQ�(��E�rt*�
�z.0;�q�X��xiM^����P;�j�y�ҍ++��Tr98:��j�f��<�ȓ��|��]Q�t򕸥��d:n`3�U��D>�]�~z,B�AJ&� �O��*N?�����c�����.<�X~1�n2y-�ؙ�Pa_)�ȵ�/��FrLz\���M���� +�>q��la�����d��̑�r��_R���@��ҲO8b&u�����Ȋp7Q��Vp� �w�����Hο`-�-Z*��s.~��-ͥ��?\85+G���4 9]�����W\�+�j�*�І?9��dq4�j;c���?n��:�&s�uY��W�+�v�+�)[R��9,H�Iz�T�D^yK��ra�פ��bz/���l��Xĕ�ʝh
�I�R�7�4�r��c�-W^�NT�3����$���鞐�ju��w�+O�K4�z���A����wQfHwB�i������[��-|,H˺���0h|���eSQS��ʢ�5z�to����tQ$\DhAs�
G�Lq�1�4�1�du�#c]֚4}5lQ���9�(�Ď3�SJ(�v6�~������t0�����,ěHuP�MGڿ�J���[�I&0��IY¯ ���-��ZYy&y� ���Ux���-g�>$,������!�Dr�S�ܭ᪸m���X�%m����ctg�P�B��z��D%ۉ�ރn'��a��Q*�y�*X{����|*W��R�rrk��/!�Ŗ+5s��]ϖF��Q��TCED��#�B�7EB�w���o�-+��CB2��%83��bb_IQ�GzpE��1�z 8Mn�Du���Y�ʒ��|��\�0�H�n��c�d�'	�fl>��_G��97)Xd�s��E%��aůo��+X�`� �۞"W5i��=���AX=�W��SR�������$g���0�z��X��z/��k�=m��@OÞ�k��t��%+�*.E�R
��Kg�8��ɕ�"��1�s"�
xR� �����J�dx�N��j���WC�r�n�����p_b;ߋc:e��6�Nx�^N�E�w�4�V.�K*%��J;BQ�M�
Md�aZ�aEܻr�B!�1��  %2�����wy�*��C2�5��EIy�α�xF�o�Dü"h~ׂ,5#�ʡۃ����'/�s(	�vTC&��$9%�<�^�^�1o0C�8G?�.�@R����f�b�<'�(�͔�Rq-G�Ő݌.���Nb(�M&~L�v<�5�i<՜d*���w����j�B�����ґ64@���=�2=�3��Lr�`TX`$/ "e��"2ٶ�{S�]�&�ӱ:G��D]��Z�"��>P��j�P/"��wPB�{�0���׆��F�o#l�������Q�R�Lsҡ�b�`s�3�lP�����|�L�N}H�7a��E���<g����*9SW�{K��Ļ�0��Ks��/�VK:yDB��Ie&׾�p��|.�%b�����ܛ�"��u��]�pr$v0�M�ߝ�o��I�wZ��h�E�$���f-iHZYX?�l��bmG7]���M��R{t����N[�`?��{�W><���Pz��wnN'���4*�%a��0	ci�$��#I�#�G@�%����>�
d?Z]Ͱ81yIo��-�"rri��w��Ѹ'�U(�6�g���~A����ŘS`_s�!�'�[86��7Z|�j�讇,5!E���C��.�{�3ݴ�R;s��>5��N{�ƪ���Oھ.�B��Yѭn��m��!�Y�k���D>1S9�9>
�l�!䦾3a-�������Ժ��^mq[[��mno?�������o[�{�s�~��=�Z_g������mΒҒ������9ݝZw�b|q�~�}�����=Z/���k�Sl�]=�������y4b{oߒ��y�KK��vwt�ӻʪ`~����vu $��::U��@�  �w��]8�_Z�;FY������:�h�����; �k��	?v��w/� h����wP���A��^T8�h,�Gp`������cۜ��.��bmn�`�A�kc��v��c[���;���0
`��k`!����6w$@1�����'S�]Z��K֖�.D	k���!�թut��l�Z�Ė0������0*l]w���� ��/�:�u�.�;�ں�S����8Lo����'ϻa�n��-IS�"$��=݈���}�`4?��m��;	�
u��,��p]јD��~�Hd	P[�����k.n� ��ޞE�Kx%r �����E��P�"����Ѷ�m^�B#8)0e~�{P��l��?��&�B7c�g ��{_�Q�6�l	�7��d!$�IC0;~��[�͞O�Zw�� �dG�`�F@�sN'6���dёkko_��[`�g`!Ȯ�\2����Uq戈�uu/��%B��Јc-*��-*�� h]sa���b�4��^�͇���	��:u���]-�@B SRbS�_ ��<q�q �j�_�>n�^¦qY{w�R)�;�������E"��׀�ۂEg���=�'�M�n�,�a+�b(}T� ��U$n�Y�ϳ��}�1�$V��Xp��\����5b��8bT��ˈ�]��nP����
�ؼ�9�^�ZA~����Jiϋ����7�_��F���A�;��b����s"cb�{ɵ̶o2���a����0Eƒo=�]������Q�u#'���*"sVF���-�����]������{y�薴����Qr[��u�q��^y̵dJc��=J�C���	�T0�]B)O�m~;��{�*��KwEd���_A���1�{eIm��؀
�P -o�l�R6�쳐E��Y��.�UZ��f"ViYXOAB�C�����eF1z�����G>4K�|�jYy{�V[][�u�iS+��ś~eB�o�[���v��HsR�8��T��j����yɩ����O���������wp+�M��X�뾸,��y/��z6`?E�`4i�^��E�v3��X����U�y�g�ธ��y�ـ)Ib<k^�L���jraD%o7S۟X|hY�O���a��I�y��0���L&�TU������ِ����(U��6�9ċFj�,��씜��R{zqz�v�r�`�f��
�b4��"u<�:p����7�舕t�<�x`����4�-�{3T8��Ϫ����{�w��z�zOe5r�l�iۜ����KT�gm��Q-3d��A<�����mO�c7�8�<}G�����^w�3�	#e*(�{�S��R�ǤX�澛R�H`��:�X�r<�Bo_���FIIq���s��$h��4�g�?oa�W�Z���@ʒ�B�:��W�T9��P�,&���&r{3,�O�{��|������34����;�(چU�����Ox)n-~,R��e����~C���QV��a������`Jֆ�W�H��z\���؀e�%j������_�*�¬uLeK�G5�k���eC.�LW\�J�iS�Â�r���M)�S�ߔ�F�K��Q�1*��]�2�qҍ�j�.C�b2u�@x���"́�h�ݳ�-��U�+�éx(�I�q�f�N�R�%Sbṗ��[�R��Hy����e����*�H�̀f���!R{Z5�OHTq5�!l:ȱ�h.Kr�-��Sy�v���z�F�!�V���U�o�r�A����� ���d&��c��^��ڐabqn�wгn���^>5^��^���)�렾�]�pA��L���=��3���98�]=���$�V�+�����D��m��_��gl���.V��+fh�'YxQ��YJ�/+�x�	8Ҽs�UE#_��_[��V�M��>��.� �'W�O��S�Æ,��%X~_���d�l*嶢Y�/)�]��RꏻV��7�+xѢ�i���8���t�r�BȐ�yq(��n=�[�<.*�p��"�U$��.o��y��7;����3�s`phA'�e Jk�V6�s�L�:UK��K�X�-[V���|�ݐ�"4N��}�6����{�l���۲�[�!�j���c�h
�a˜^-�� o���r�;��̌F'XS�
JDP6}Q�HxP��6�Q$�.�-���b0.oK�l��yC*l�?������%sˇ�Y^�!�.>\��yrY��|�3���4�� Oj.P�����
t۬ٵP��!~9s�������Y�;M��m\�ש�6E�W"N�Uo�� }c��̄��z�pZ�V6|�!|����E���\���L��0�8N%}��T�J�'��&T펕�2qs�FD~��zR猬�U��hL)!i3�p2cqӉ�&�K�Q�M(�8�،�Y�.��|�I�o���i�ɑuIB�r:�
֜�.�<�5چ�̊Ј�JM*g$����d�'O�;��bC!�6d(��q��c�!�)t���zV
�`,D���Tj���I3��AN�a��߰>�nX�"
q79�Gu�]w8nGV�/J�i�E�)���3�B�gZ���d�����ۤ�3zW���I�c:����5���2�p��x���8\��x�c���5g u���wL�.���f����5��C��Y�?�*C�.��I�-�쨙���<��l޵VWE��Z�^�8����D����p�*�����=�S��}z��������ة �*0!��*ge|��v	�*�ȕث� 7�cn������0lX���*��BW���n˔WW�2�B�&�u�	���{��f}��HO���cV�(A�q��.�c��3���U���Y%T��a���ܰF��k@d��Q���X�8���4U��ӆ:U+OHQ3���m�p�h������ak@U3n��Y�(*v<��‮��+_f�U��~}IhP_�_��@���>��!���ZH߬�B���U�ǹ[�{�W�|T���h�т�v����Co>]P�4~�Ak ����&[sYe����Jb�c���e��e[X�f%��Mz�}k@1A��O�	c���
�4�]�P0����<��dЅO�:�p�ʸ;�$5�_���[�*	s��=GDo�{����
��n;���vn/�
���+l-o���4^ֶ�@]�ߏ���r�1�;��3��NE�6��8��9��a�QO��p��0�Y�{6��ڕ�7\���*��
����*��=�� ����O��')��#�gd��S�;�wg�'
7��r���A��Q�_=�"��su����9O~�A�W���NK�ڷ�G����GFR��xʼ�����
>������ՆIB�s����b�s���;�����\��Y�M��Ž0�ڜ/�S}T�{���������Зm}�D��O�s���6Z�6~���'�J G+*<	+�h��s
/%��/�zd�p�0+#v�N�h�M3Z���UM�DM�d�6ҦUq?ٸ��^�7�\�1���`G��\]�Z�T���z��Մ�D|0Y���_��w%^��:��?l��tb�a��:���*�QK����&�r}>T�����D_�s4��	*z�毺%�T��݁Ę������!��� �� amA0��XMP�պ3 }W�qk��P~+�6�L_�"SnZuuS��H�f趾TlWMu��~<�n=�-��k}� ��6���?Dc4�ha	I�؏Q��t_ɂ���ǂZƐ�{j�HEU܌f| ̀v�Ɨ!M6��KL�!fq���a]�5u�9�H�?���F4ZAP��(��ÔN��Y7����y�- ^�P���ED2�kȤ[��Xe�<���\��o3����6�q��������B�E�6B7�N7�k���{Į'2w��#(��ڬ���p]Ō�;"i���<S)�O�.E�+q`qs@�l�:�TMڣՂkWّʣj�������Q_�\�c�Lr�.�	U{�(�)��k2#R�P� �M5F�^h���h4kjk"�Q��{X۬7�5f�YW_p� '��44��9�j��0��T7�f�r���? N��4M�Q�Ez���t�E��VѸ)���m%����#����8<�������B�,�������B�W`��Hd}�7_*�N�+!q���D�H�)��G^t�M�I��$5���S	�_�w�8X�k^��E�zT/��&L��S�6��r�?+ey�w�P�YɯW�MeI���*88zƙ@Ýo4�_���;�_@��B�<~%؄�}򤪬��
[�*39����wc��r��ŹT���[�\)�˽��8����J����TQ,����d�7� ��J,�Ac�E����Ғ�S�Gy��J�R�WnViIմҒv
�����+f��DvzL�g�4�p�[q��j���(��d�Jaw��	��0C��ʪ`�!�y�>f��Jˠ�D�{�%��H^jbb�"�Jkjj��W�et
0uQ���t+>!�V�|�`[�z�ZNX	^�,�6��r��ˠ�B�t�.=Ҽ�6�D� 5��;fXV���f2���*����L0��(�߸�����$����H��h����qS�$�b��^��.0���)�M��X�3=�Ĳ��4�r7���V���;�w� wk����q�LG� �	*K
���^Gq�1��744��{p��wA_Wwg?��dmڴc���j��f_tL�K7[�m*��DԧM�ἎӦ���v\3L�����W���qz�@�E���B!Y!�R����_��e$�謨�wL�\!�XY,*�A������:�Xb�J�M��x)񈞦��#�חp�c|�E'	��u0�o㫷I�$��8�Dq��o��:���q�Eũ�9���sڴmq/�Ȼ�����3.��q��+h1:�����	j�(��LFL�L�@Ew�D�@�Ff%�@&'WU�+�xY_(��"S�UYY���H*�>�B�d�L������E��&Žt��2����˗Kް��ׄd}�4��H�\eF�d�c���˗�u'FGb	���Z��ad����+�'TUh����=ނoOÕ��3}z&&F�rq�c�iQ�8�n%���Eb��$���[NT���D��Vn��CAmyb��qyEK�N� q��G�]��hX�mԃ*-���<�˝?M�0�%�!�7%������L�I�#\	/c���-Ȍ�!]ZRȦ�E��b��K$����Ʒ�-X�+�w��n_\Qq���3P��ǵ�|/��[i)��#>��v�Q�B�|�9��Kt%��G��S�~��_��J����r'k,�P\����I�TM�G�~s��a��=lEԶ�6�UJSh�@���;�hr��I�:�lXv����@_,^�;� |%�:AA��P{�����$\a!�$v:Et���!�M��d5�;j �,���.��(��r?���)�����/�4�z}�g4�w�w!����n�d�}@����˱F^�:��IE��)�k�oI���e�Jˉ-��&�U�\+w`�Ak��E�TD���R�۲r�C��~M[V��uӽ1�A̘�~�m�t|:H,� �ph�~2`�ɺ�\(�Eo0#EL�Hs_��.g�P,{���r�(+i-��F�_R���ʊ��v������G,4L��H]�z6 � h˥ ����j$�˦^���̪UVZ<OAN����w� *���������QM��>����)`Os4-$ yD���(v�^/��Hk4�bV�A�4ċt����T+�Vd��/j��L֢:����")*�� ���
#ǂ���Br�7����9C�C��4�>k�xTu�L�@GQ��:����Ƭa�!n"T\�օ��JfW�	=�;�.F�V+�:�Fv��MU䃗M�i���h9N��N���2n�D�NԴ��'�\�2f��-ʌʌf�B>���)rR��.n�I�cLwaa	���Ҿ����gp�m`h.!]=s{�C�ܧs�l�Ӷ�3��,�����!�u��PGW��P�P�#r'���o�0sF�d�`�d����w��|�/��A�f�陵�=#�&��X<g,���db�Xk�^$��TO���O�t�ՒX� .ީ&5m�hbi�҈�6��l��
�J��eZ��-pT��7��QR�E5 ���P�ء��/�.(��CрY��)Xu0!Fcd��$��l��CZ�P�R<�*&������t\k���a8x�J�U5�I��UҀ	A /@�� >���i-�gp�x��i%K�i�U1�����U��d|M~Vö%K�Qg=h\���W���d䴣��ڪ��k��*�κ{�������C��>;�=+y�m��z�m|>��-�탃����oK�2:2e���]Z��c��m��|N�m��?N<b�M���鈟�6g�E{m��כL�t�[g��-_|sٕ�����������}�������<�J��K�z��U�=��Uw������wǮݱ��˟M���ms��;��#?<p�C�4e���Xx���_|�7�>�s׿���?y�^%�]�p}o��֗l�p̫W�wb��֚���>y@;��o�~��+3w���؅k�	i���;˷���[�6���r�Y�-�;{���7���G����Ys����n�t����f�uoۡ��uΫ�[�r]���.�����-����kh}�������Y52��'Oݻg�K+O��ҵ��brd�)m���{��珔=��Em[���Ko�{�?��ۅS�����l���b�O�7N����cz�'�ݾ����;�����Ӽ✒W���+ua���s�k���5u���j^���D�V�<������_�{p��g��Yx���#�>����^���H��O�}���]z�d>y���>���:`��t�<ᵱ����}�_��%��?��n��d�#��xx8{�`�ݩ��������[���k'}�N_U���c-���}�O�f�pɚS�����O�.����>�<�5��{�s��_���F��5��#����_��y�w� ��U��.{����/L{�_<����������ŋ��k������#�<ﮟ_�QU�#�R�&�����_���-[��o���;_q�w���rہ_�[���?��[��[�|��G���ë{v�W��̹��z��|�хS.�p���n<�)����_x���G]�/������X��µ��e�����~]��n�w����y?|ʿ�̟hkl �����N����~��M֜��+���~:��}�߹�)����=kVw����K���|�݁��������џ�y���&�߼���6gmk�蓋�9dtI�v��o�5��l���+�>襛�xd��<s���gv�����i������S�z]f0�~�N�.����wY��>�t|��'����"����snL�w�{��Ţ��wom6�w7����w�qɖu��w���ߣ��'��~t��7�֟�L_��mmϜ7aN�i]{��������x��ğ�������=�⓮L���}ʧ=���N��oYw�{�y򄅟=lO[<a��%[�?p�N�m?:��g�Y���~fF������e�œv,k�oL���ok>�޳�=����·�Ҵf�E;���ě�^y�į������Z��[���/�YS�rlv�}�[wK���l�����t�/�i�6�آ�9%�~���N������|����a�Ó'����蝮�n|�y�[�w������00��y#;�毯�}��=ϟ�؎���K�>�4';񗋯�j��z����;+�x�/�[oT:�_<�~�������ݾ��>���/�d��j�k�q��]^{9xڬ���{�����=����|��k��T����t�}��߾z�_�>��6��u���N���#�?���'>c�ҏO��O����/��}�焅w0�����?L;���q��鵓����Oo�����j��TdZ6�v���/��`��>9孳����w�8����*�X��A�^v�F���<~���߰��i5oM|��u{�{��co6�w�_^~�*��K'4���sń�yO^�����[\ܷW�!��>�|��}�������^v�QG�� 8a��':+Wn70�сs����7<cϋo{��_^x����k~�س*?`��b�u��5���{�W�/:��#?��w+�������ߴ��{/z�w��ǿ��E�Ϯ�m��n8c�[^����{�_s�������~�X{�ܿ�5q����__s҂�F�����_o�Nj�6�N�J?뻛��4=��	��u�	��\1�����m���c�|nϏW���_����!/p歧���Ӧ��MXw��>W\0/�>p���8o������|����3��p����N�w�m���$V�d�vӇ^���g�<��}�{�l��B���?c�`˱5�y��=����_m=���|���+��k����c��o�l��y�������m�=x�R�vi�w���Lxi�E�_���n�<�پ���9�����C�\~ā���v�uڄ�����-�y�æ��Y��g�{�g��w��ށ5,��������ۗN�`˕;G��fQ�[�>��'��2O�5��#�,[��;����#kn��Ǔo�q���X�����9�|�Ϻ�����o�{�M��b��7����p���=�|�1[�^����/.ݲ�Z6���W3�����.?�G��{�{#�����|�گ�����}�/w9h��چ�}v�_�n�����q��_c�����/z�����w�7��O��L���}1���;{����ȥ�~��u�W�������}@禟�x�O#��q�߮���g-9�J덯2�����L����<�zn��o��~sdnv��	w�v��������������\r��[+�/�8z�.����C�S[�캧�_�����d�<���g���|�uL����w�{�z���%���d�/~&�;�����ugLKl?���}���u}��fױ7mr΄��}䴑�&�52t��]=w�ڇl<��.�����\���3�����}�7��4��n���؅�2�|r�m�_��?�����{�Y�E��o���`���S��?{�{_;c�7��Y�_s��Y���ugԔ]�����?�/~hzϫ�7~}뉽��{��w���77�����i_���7���v斿]xٳ{��ϣ��]�����x����/>|��#S~|\h��w�Zsy*��ǻ?���ؔ36����3�>=\�ז��|��C;�*{�xꓷ*N=�c�S���d�3֞ջ����{���K��ƒ�wi|�ᭇk�����6������h���?\��.'d�6g���]G{��ݿn�m�];��s�+��O�����\�|��罹ŋ���ͺ��8��������y�����L�o�_��h�����ڨ����z���_ٵc͹SV�a��M/�/Z��.[�>�����oz~��1�<�Ǯï�Z��-�#�����U]�ZqFt��7�o֞���G�������_����J�?-\׽�D���c���_���b��^�Ok�=��66���%���x���e�ʟ�����|�����Y������	7��3m��Gi����Q��2�絷������1�Xv�cCO��|�cN|w�e{<��]l�/�{���v�����z�̻���?�5��:�Z��{���|��P�u��^�}��}_���M+�:��έ~�U-��~��;�?pm˲����5];�ܲ�	4������nO4��|��{��}��7F�����W���[g�5v���s��;�.���/]��3�}Ŋ-n�z������.��������x��{�p��M^�n<�Ҽ*z���9�w��׵ׄ��ܳ���O��ˇ��x����/&>�Ɂ泃�����xܷ��}����7�EG���?M?~��_�z��6yf��=�_]vю7]/�������d�&�߭e�������s2_����?}�&����X��5ǧ���s���>ij��o��V�:U{Ӭ���=?ݿ����f١�wHt������+'N?��i������k=��E�_z��ȝ]�y���x���ϸ��G����Ͽ��o?�æ������{K�����Ϊz�Oӻ�z����o\�ӃZ��j��+�Tm��ԽjK_:����m���K:c�~p���]1���m�l���?��v�Į���B��o�1�\����������������M�}�;��莻ڟԿ~����~b�w���(�n�/عuߋk�S�����.=����
Dm�k�*��V�.=�1RzŽ��>����O+k9s��^���;�_s��?>`����O���%?�d�M���Wri�=�i?���Ӻ����������N9u���99s��۲�Թ�l��M÷�s���6�^�ݑ�=���[��'��~��ލ7��b�.��{I��ʩ���[���o�j�7o~��s�����G\�ڭm���~f���ϭ
^��ZQw�=��5壕���w�៻�\�+>�ꀮEM?�:�뻏���]�����_?g����g�_|mz���ܘ���^�}g6�sʥ�|@U�'���������}����?�r���N:y�mv���+��^���yu��S�ޚ����~��{87?����=�ώ��+6�J;~���?>�'OsRW�>������GW�^;t��<g�=g�w�?��I�M����c���-:�m۶m۶m{�m���m۶�s��p�����N:ݫWU�T�Y~a����ބ������wv�W���j��ViEx�)A����1q�8<�L�lD}͞,�(7*����,��(μ�|8'������s�w��Ɓm���m%5ݐ�+ws@�ӡj��6��R(�Z��y:E������B�oVՅ^��nj������B�p�+��L�ު���I�Oy�5A4���QD�@��K(���-��&���H3.����A���G߸�;З|��d��Gp��]_-�He[�:���ّCu�'W�@c'�@Ϙ�N��$ģ�X{ˁ�2�Mo6�5� @x���?v���H��5n���\�^�K��$,���|Xl�$�u�;�$�q���_�6;�S�zh�MhA\*�-7V�"��J�?-�sR 3v�Ӵ��%��J^�9Xp �S��8c� {�-���c�pV����'��@�޿�D5��y`C&x��H��6ǐG_-q�8wPϳ���'�pq���J���9\��}T^�0�m�Ź�A)�,1��Ӏf��η��6�O�$6�eQoJWJp_���!��C�i�Z:pO/_�ǣ�`j�9.K�5코[�=�?�ª���O��u�S��p+��&�PnU����0��=L�-�]���S:#�06���M�~$�>��Q_6L��B��k��-;'hAQ�\L��X�������������FY��F�\��6�@�����}�r�l�+�E}9�a�a� ��	޸�h�Yx;KP��р�{z�'�F�1ar������ �a�F>\.�מ�������Tf�G�b˜%�op����\�4A�osikg,���7M���I�KG�]�zb[!>�������\ڛ��#�m��lw��hf�����V���4��2����iN�ې�	���5�^;������4���,�E�cT}��غyH	�F�������9J
�J����p@&��a��`��(Yt�	ĉ� "V�*�h�2����|h�G!���iP�#�,�4"�a�$U��T�r�_�
`O�g�#���Z��e�&x�m�ۧ����^��9�9v�L����x��K_3�Np/ns�?�@������$V�

�*�S�50�ݩ#��U�-��$q&��R��F_�x���tτ�RޫJ�w���I���?�(��j���#*�	q�|]��դꞡ�w+z�rMfdV��7��x0٫ ��u_���; �s�N@5��j�+3���V&L����|-`�R�G��-,)��IfG��?QR&�58��ى�Q����l��=�n_5B�t�v�љ��"D�Oo�
ֈ�����UH��

Mc���t�Q�|j���n�`��~$��qw���+?�	fGlV���b ��������Va#l��sk�C[�}&)� ��nn�f��>�[>mJ.�ֈI.Ӝ�o����JR�/��k,��pP:e��ܜ2�viD�b0J���=��� ������ 3y���c��U�v������%��R���c���-[�69��i4.�����@^��]��F�V��(�0��!�zsk�zྺl,��ɟe�>$MZ"��`���F
HiG����[�yr�QC���Lz�#u���u#ul�V��*�ā�B<���-�?��&79�"�P������gM���z]�@��mOx�Fm��%tc[�9�fJQ����'%�g,�#<�k�( �Ps�
L��
�ʯ_ �r(^ꍩ2��(.��/ Ѱ��l�.DOoOiƍ�u�����!��_���x9*�p�Q���	T��1Q�I���u����ɡ�Z+�$s��u�u���;��=fKRHlՐ'uA\��1�8k��yMlj�o}�8[�I�f�Ϭ*�����D;V����&5�m�Hٴ~��(�m���_M;e��< mxTX���1��>�ƶ�7:1���� %)�'�F� 6��%�?SR��0�F����BzH:���f3I� ����'M�dn徑N�y�f���]�-�9�d[�V�0��ۄ;1�C�	�s�I�%:΋�q��5G��-G��0��#<��`�Ҭ(�ss�����<O�i��$�P 4Θ�@�Go7Kqa3�9Ω7�����]��x?�"��Vr�\hЯ�3���ژ�;���܊a�r���7�D���񵄋��<��T��t�֨c���j�H|���	>��@��;�Q�>�A0{��9���R�=��XLS���9�)5�V75������d�ua|���ʻ��<QdQȜ�m�D�b����Dc��@��ƥ%����ִ	�x��y��gr6Y�pUÖ5��@���*���@>�'������p����Y��^���zy&��o~�Ъ�r�Y�|*B�N����Ϧ����S\���ʦ��!]*�c����I����'��)�Cs^��p��X�h=;z��jye{��e��&K,����ur ��i�1U.�"��͍�}� �
Oc!�	PW� 4�5ĠZ�	�F����#!�(rτ�J��hk`h��qJ�4;q蕬��H-��	��������K��"����tq�`�\�G"3]ɬZ�5�������"�P�I�x���෭9�
��Q���m�2-e�\�
C�,(����/��0Y�;^���^L^h𚉪U�PM:i
N<ƕ���'��19��K�JT[�(4�h��?��1�㵃�_����h��&'����ъ��K�c�4[=ڶ�oM�zBnb��띓�5Bd��5�D��Z?���x���2Z��O	�i+���{v&�Z�K,��)����j�r_1i�3Ks��$bN�{��L�5�g��	g*-���S'<C�(Ut�5��`��<G������i�e�m<����բ6XZ���Eʈ�w�XZ�.t0�����(��e@wV��Ci�Y��Y�r�g�ߠ�;�Ԍ�6�(�4�JK�������[;�g�r�f&�d��5���ꁲ	,�Oυ�/@J
�6����*�P��iedWn�q��q���� ��&���/sFI�� z���)̺W�inY���&�Xkn! L.�_3��4e��ӕ���Ȓ�L%�7�`��[�-O�s0�p+k+z�x]����8�E��^}���Xc4嬰����j��k��	
T,��t���ݺe�f�Hgln��my{�R*Oǩ��u�<�|PYO���0� @���� "�8�E��y����ahT�a]��[���
�-���,z�_l~��bv������3��F�3/2[�-H��[D���x|�K,=~�����,UO�=u�o��r|@p�$�]5;sǊَ����w��?� ���y��vs�QL�ʜ7�����AKj���r�$�k3浘�8��� Z�Ei"��dU3u�4�^�
S5u֮=�=@�/T��?�6�8���<��qo��*��g]��EgJ/{�\J'�����R�	~��1��?x�on���d^E�t~r[�o��#�s�e7'�	��Gr�=@?��H=�s��1ۗ??�����dN�4�b���/���V� �]5G��i�d�*H�詘D�>�d�$Jto,&��{D.�U�k�L�� T+����ߌ��1ON��U+;W��4M%����!��Y=I@K[.ؗ��> ��4(���������x_!�µ_�� �<ukȞ���bɢ��+��bH��>���4��e���)]̕)�QB�c���P8���ȇnc��T�ljI�2l�~;���ֲ~�`���@7dU��SƟzP&6�V^ 5�S�^�i�31��̺	v�����aKcH��Ol�!U��o�xM��
g��Y32�L����rq�`|i��3�C����$���9H��Ei&��R�0�瞗��U��
���Y,Y!��� ��}�:��2`��|�vi`��+�j�\oO2� By�G�iz>��5.�ѭ�[:�1-���1��h*��_GЛ�v.{�N�s����A$�F��Z��?�������,n( ����p���J�?4OT�+��L��J��+z��`�P{��Qb�^/_j?�w|�N�my�4�@���y��/[l�����Y�3m#�w�[�t_��K�ꪝ%{�Q�Ձ�Y�����o5`�2�8�4 +��t@��&M�v[Fdk3�@�ҁ���;6~N`AL�]<������	 gX�p:��FKBҘ�bs�� ^�2���\Z0���)�d�=+~�H,�����6�	��I��)�ɤ��V��3�V��O���5tI��= ���?Z���'w��&>�`��|�ю�� nO��$P����r���<��c!��~'~Ȍ�f�C��)��Üg�.�R�@�!+b��d7>XsD���Z�<�ʱ9��� f7[4���e׫	�D>:)T�n3A����y|y�Lp�-�4Tq<�H�n>&��]Gjd��Gd��XXf��~�!�C����F��ή4~ #�+��1�w���S�!�n��roe_(���9�������ǃ��g��
��uY0A�"l�]W?�Y�T�-Xa$���pš�{*"��|dm���t}�����;Z��2�H���
�8˯���H�������<]�OU�ZP����,o�*�;�����敩�C��q��XP��L�a%Sǖ�ڪ"��6|��q M��e&a�w�|"&�1��->x/Ԟ@�zX�x�z�@��n���Ɓ��6��Ԫ�����y�4���7����_���ɕ�� ��
��jg���x[�O��8`�^>��M��3�$�D�*�F�\2��-(�o��gW����EA�惶�ǋ^l�^>�<�`��i�t�����𭀿�z`�N6�Gd�ǜhN��^��+�%����,����?G��kCA0҆o׺Æ���>�`��;鐷�����ҊE>G�k;P�ȟ��A?�N:�:y����<c"!�;G�5���Ӥ!��u��	0R���1OOe����������`��.i���1���Ң�<�Ε����Ds-a�3��$2�̑8q�QOFfg<MF�I���q��|�X�����Ϸ@�P�/k�l%���m��3�j���
�K�^�~Њ�cƇW��b (>�*�2%�w4%�ȷ��Mf�u��r�X S��p�f�x`���mh`<���NGd�Mty���Mp)���� C9�7NP��C1�̥����9�P��_�t#E'�����,kH���[���M��	����`���2��_��n��,:}���>KbM"�������o�M��aR$�7���T�8�W(�'6�J�,�Ll�Ҙ2.���_j�� ��y�ۊ�D7'�b�MD�5q"�0���g�u���Xx��u^=@�Z����Uœe)�f%����&eJI���#vH�5���oh��P)���>�M�s�j����/:����9� �"�ע&���\}������	���d���z��NaCg�u�yl��fӿ��<9�=�孉?'�����������s-�)��ç����	��<Dw�����F�b[As�hȫl����?�h�^�5�z�i��液+m�?���	'O���7V{�0�Nˆ����An�+�KE�!+W#V�,�*��(�B{3���6�O����{J���γCBt�E���E�����Bb����ů�
R|aw>"�h�.� ��rn��m���
���*tS2�-�K�b���Ι*S�����Yl�z�F#�[���lJrb����#@l�Y>N%s��'����0�P��X�v���D�urAB���8���|�I �?��o�Ut�~���&��w�3�K3h�P�� ���(0���J�&�q4ܭ�t^o�׻;������p�3�x�����)��P�.��+9����� �;Q��kϫ�N�os�˝����=n�W�Q �a��ԛ?f�f���'Ū�W�t齻C����ޞ���ڽ�A�&ءOؽ��b�|�ݹ�*����I�NE����e��fT��繪�(�N�%0�A k�����X�W�|V����ӱ�*H#V�|��.lW)\!rJT4Fm���^�A�ɤ���Zw�{�uf�Gt����_z;6�7s���ۜT�9�/�E0��Ө��&����v������Le|P��Ű��0G�AӬ��N!k�y��#����>�_�t�L#�|Pq@݅��˽���A_?7��G�Ok��ra�:�����V�O,��d����o�*0�ފڊc�b��JI���`�)q�[E�0˜؁�����2��|"�MV���o���Q��"|�R �\�X�ÝrwДBlAEg�q���k{RȆ�8�N�����>X��L&�	1'�E�P�?�6���ℜI�HzXma0����T��k_Se�H+�7ƶt����T��A�ˬ%F��18��:[L+
��з�h79 ��r,��4���0?f(���9H5Tv�4��*��Aݓ"�_�B�&{Y�.4���Y��������܁ƬՔ*zCDB"�|U����jA7*�����z4�����0PŽ���
��D"PՈ��}�S��y=p����|���G�����	u *�"�$����5�O��40_EZp��`�?�d������`����'2Ɣ�+���Z� ͮr*����݁���`����L�f�)��`e�,!+?�]��ϭ�k�ZJ���Ֆ�u~���{���6��,�[x��{	 ��[�C���K�ϋ-��zl�h��S]�o�5�ꤘ�AG��������G��R��]�#�xIJ�^ ���NPn߰�1{�Is�!ypF�d��D���U�>�E��7�d��2t���	pd%y��c���%-����*�]!�Ք��r��p�V�Za<��TwV���d��aRu�-�7��^�km���o���^^P��j]Τ��ڰ�@�R�`��ҷ^���.�z�K�o��fo��s���xЭNBc�J5;v����y���)A)Lb���q�P1�f�?c���"�=Tq�x->�Uγ�)GM5�X�)Us=1Pc�N
U���U����NV��G#5ۉ��=j�;�?�*���
����ރ���cs
i�SnHYd��(���k3KW�������r��,"*�J�$��*�����>&"�萢Y]Z��LM�+{�A{����h�_M�� ��Ia�@*����ǩj��P����E��j:r�η5���asq�w������j�������nΰ��?4�H3W'�����(��cÜ��ś��M���	��G�R,�k�L�߂6��q����t� ��(�*|�i\W���p��d�>$p��}��/�r�\�~��*���~��#)_>�$V������1[��mګ�����^�J�i�����e��y�3��,`��_H�l��1��rB�}[�EG���52_
�{s���r[7Rk��U ߄f~^���?@���@,o�����Q"����}/"�l��m���dsABc�����j{n���c魢z�_���P�+�>���`�/Axf�u�T���%�o.���`ʎ����+�S��Ό��_����������PwB}5��F�rw���&�؄��Y�I3D1����8u�%gp<��MBYB�D�W�uk�xIP̓f�W ��Q�������>3�D��+594|��L���gB���m�#��fg���C�+P;��r��W~&껈�}M�nSD�Ө�*Ʃ1w������j�� �|{�����m��>@��m�������pkr�9UFla�U�z5{S;�z����׈��Y�H�!G�a�*_v�K��lt$���o�|N&xp�f�ʒ�^��4�ܑ�����Nk~S=>���{<��	R0���溔x-�$2z��2�T�˨`����W0�G��pa�м�wvk�)7��Μ���|/S����8%�����K3%��vP5}?�j�����L��6E����6J����L!�Aʰ=˶�yq
��c�#��,m2���	P,w&�p�ř�4�V�=��l�O�~��O�G���ߛ=����b|�U��<�H����߽��X�f��Tg�K�dc&��l��D4_�M�������"X�L���h)�h�~���}����A=S�����P�Ki.U%G�v6@�����>��*v^�Z�.����3�X>�Ňa�d F"x���|L�nk�DމVH��8��dZ'�r)�,�ϓ��2�px�]�������	���x�?������t�{N��B���)�
ċ�/��Ov���4�$���>!n0�
�sB���Lo���s|�UgE�ygQ�S�Ry4����"/y��_��7:r`��gD���5^��
蹄�c�@1 �|!_��(� �Z�kf	-W�jMv�4!�E,�̴Y���A��Q�~I�(��h��4&�|~@�_�t��*�??�A�M��~F(0��~��u�y�Ѭ{�ί�*���y9omH��9�<e��?�UY�ut����3c���`��S�9����Õ��DǶ燙�/s���R��Qߦ�HU�z�ѷYּ�'���=)����ݤS�2�9��SQ7�v7�;�$�+m�DaRY/d۳J�؃�܃u�1^V��R�/Ȃo$7Ͳo��S-I�:�.����q��_�٤Ӡ���+�B�M� A�FhPy2\�_�~��N�0�F����|��!���|l��~����vi��y���Y�o{�3�-e5��ZS�mB�"	������ y���X��	{BDIR�����C�	�|ʋǤ�sm62�<u'��?���U�ą#åg]L'3d�����
y��!�r���ᯠ�M�18�jʉ���;�>���3�e��������̕/��,����� �b���nSȴH��2J�B��i��C�JmL*ue�am�T�?�9����nIUu߆�}����<���3L��V6aP����ܭet%��Eo��?VPaI�ၶF��s���HG�O}��Y����xM��^hpZi�;?��H���۲�b]�l��&#ޯ����l��	��Pa��AU��b�*�d4�ź�@A�^���+�o��^���pۃ�Gw����N/���ODԙ��
�r�}��Q�{,C�Н,j��nI�G�g���xhɃ�X���O{��ֆ��oeҦ|�V��Gr��]�B`�Uq(���8�y�z�4�B�_��/i�<��7��I���^�D��[MM����H\�^O���Y*��?��1���~��+����~��W�������
X|绻�ّ�y�����~�,���x���U��g�}�&��y���9�y����(�l{���5���?\��q��۾�{͈���ok�9�
��������x���~�����,�y������ϱ�y����*�7����������{���zi�7���������y������y���k���l���@�ӱ����r��94B��N�2�����9K��Z߱$7��1�yAE��_$�%yłƙ�ȁ"b6���g���L��!Ǜ�o�����v�Mc�B�����w�M���� :�#i�L-���ZV�:9�!�Y����Y�o#�!��sb`CX�o�({t�W��H��V��BD����G�<o >u��8�{��9)�_B~�P�l��t$�&���+"	d�� F"�%6y����DD|�{�<��@X/G�뭥O�o�Q0���}�7'�Q����+M;h�;S��{'i;Ǿ�c����]�c�Q_$�6��Q�:!�y 1�Y.Y剃J
a@��.8$�:%�^���GsasD�H�D􁭚j�{\ �R把C�i���L�m'q��0�V�.�?�t$Pmv�eȐ{�'$q�Ȝ ��;����)2�o�F��5�N�|��@ם�Ը��m�u,�y;G�}���ֺ�?�._^����l��/C}ǀ�����C������jV�|�N8,h����GW�tH�Yx=�����ؑN�!��A,!R�i�A�{?#W�֘),�V�qE����n�H �^G���oH��g����d���B[�
Z;�/2L�Q���?P�_�ۖ��t�eY!��p�ܽh��<q��D�;�e1Ѡ G���G@H�#pd<w��e������-[!�"VE�"[��泑�uǨ�@,����5l��w���Ni[  Cg���h
�F�"�Z�B��H�}����5h��ѐǁ��R�Vh�� �����SQ(����bFX� �1�j�vƘ6�"E�9wP��	*&��!�c�!��3) �I� DĻ��θ��^p�S�LYo�G�3�@#c�Tf̚��9! � ���p����/w����LV+f���*m� �C�<1�5~��ʹ�� G@f{<PJ�X��}ޒ����$��-kŁpC�Y�)��HSy�Dj��x1ƃ�e�z7���nR֡��b��l:_�;8���_9�\$�[�Q��m~�9��3Ĕ�t+�	��2�lƠ�8�v���� ������M���D�A���L�Gn���l�B�:���^�Kfۉ��s��{)_l�(�0]� �H� q}!�͏��[4af"��n�o8���ҀP��7�  2�ҵ`TIB:S	�S8��qA��1�&	"4/���F6o�A`�U#B�����P&�"\i,�&�^�54?��?�Q�%�	� zH�8"�������>8��@H����)� &s�1v�	4$��B+0��&P*?���B��3[g��pCA�Vʾp�	��Rb���&j?_F�>�`M���Z�)3^��-��RN�D7e�� �5��$��n��e:��Y���{�Fi����DX]�?�;q����jr{�NE��O�/֟I�A��ȃˤWDu�]E;�/��s����[���4�{����g8�7�,GeZ�6 u��@�*���v��7����A^�z��58�BT�`��Wӿ���`���&׺"L~z���B��M�К��ݸ�ֵ(2�o�y��_���Z��SrmkG��Z���7Y���	[��r�!���(�,)=�Ɍ�Z����w�@BY|�My�yD�@80C2���
~��T�
V͵����-�F8t[��W}�ؾ�	g�r(wU��-ͯ���^�x5�����g �咿ᦢba�q�9��G������>��ᘨ_�i<���;�+y���g@;���D����xD)�g��A�C�Hk2PF�uޠ��l��I9
�bՏ�b=S�aP���W{�@��P���
YM��WDm}jU3,4��b�`����7�ڧ�Qcx��QS�>)�`O{�}5�(s�\g��	�l��`�yK�5,U�ny�4��**W�a[�gOBĢ�s����^,=#S�T��:�����9��ȍrw�W�!$���� �{=!�/��#�5����

��yg�]� ��Ta>E��U�=R��W���aP�7Atͳ}�����@L��\�
7��-LU�H^q$�>
a���;�t�D^#uo@�w��l~�B����8�����r�y�PO4��,�������ۖ�C���^�j����B,&�#ՈΉ�i9����to%�̅1ȠD��OÏ�'��[R�PJ�A����"Ѓn�s�Ѳ"�@��-@H�z꬯�O��ea_��z0�U��l,ή;f�TV�F�#�������2Z9I\}#K�x��x:KgŴ��ͽ�ffx ��%�4��_�c4����ї%�M��F���:|b�,޵A�E%��bɞ.��?U]��S�O:c�v�b�C��&��Y�j�,���S_
��,���qV�h=�s2^y�?�����,2`p���.�qj��\���ͬG;_���-G��2�g�qC�ٱB��Ow� ���ǭ{�&���D������/	�"]Y8���y��k]�6�V}cۭF]ⷆ�{����r"�*�P.�$�[�;�������*�⹃<:�����ұ#���j��Bq��8����t��BD���>=-;��fP�����n��e����
(wG:ٹ�a[<pf���I#������8n��bK�0��O|����oO(}6xë^WI ��Wa��>��W6���2��G������'~0e�Yz�R@
ʚR�\���iy?�~�H�R��ǡcY!8����^�{s��z�0��e��"&������)�HM)%����f�����̨8+=C#ICI9.CE+Ik����-j�0�v\	t����w�T�U9?���D�������m�[���b���z���n>D���r�4!kX�՚���W�Z��2��MR����UU��b�zT��H�g�U���^��"�jS�	3��~Y V�jjRr���� ������]�����O���[�=���������ҷjvr&��z&��Q��(�~r~%Ӄ�u_�p&>C��3�����q�k���|8`�2m�L5���[�ʋ<k���c@֚�b&����t�ͫ�󤴁���I�/�m/6�c������������ ��@�G;ޜ֪�����y}�0*�	�8y�I�Ii�L��;2�a�V�?�:��co/�ύN�u Y��A@��1y%fc5�1u	IZIY:E
�
E��IIZ5�IiE
	Z�	�q�[G�Q��H��HҌ7O-���H��R<���xI� ���.�Jm-B��3�5b��c7����-p����+���M08��FR����Dс���`G�anV:]0kd8�֐�Z�d'��P�jE��%8�$��ˇR�����[��c��gp��r�4�O��0Η=���n�O�a���� �2$��I鼆���|��i�8O
�h�6u,= Y��`.3ԣ���!�s<�B��ê��6��ϯ�+�Oy�m�^8����p$���Cj{�r9~����L2%��(a��'s��0Y�)�lT��.�5y��8�W|�k��	&����Q���T��TQ��ɒ�20����W����֮z���~�:�W���:���W<� �Uو]g@�b�7����Q�.�|*�Q|�o#Q��v�U]�yEJ�C
鋞���4/gB9*�������C�*¥�$^��Ӓ\DsqoGVK�#,%lM���\C�.���4�����bd_�M��Boܻ�|k[��(&Q�΢`9��O��8���{(��#��~ t���`2��-I�+66�_E��� װ�m��dG߅���L���o�����l�u��r�,M^�LJm���}Y�8�
՝/%^�tfEE7�X��4�)�.`���i�W4�|���`6�R�T�]l2v�bl�����<���gOR�˱u�v�:5�?�� ��#���Q�vj��P��)7>�yV�7�s��6�*���L���E��[ڑC�ɥ6� nyc���I*�&��=p�[v�T�XΥE�B�ɍ�G8���	7#۩���g���Ӯ��S�@��ˍNna�]'b��������˲x��&���[kà����y�%���2EB�u`w���U]T�����=�z��u�K��/*?^7$��=������:$i����+�����m٦
����?8>]�KT�	^���1�ڳ%�sm�� ݩl��W�:��lgKc.�"c˂��k���{[\���0���"����h<Q `�"��Y?�/�1���_�YX��
9�]	c�o(�Xo0 l7}GY��+gryKI��̡r�jh�s D9��Hr�d�%��*��t���K�_8J�:p��^I��J�R7��j���4Cl	d�a&��W�MN�1SX��V`$<":�@�0��W$�́W�N�AC&�����"Mڟ�G��Jh{��p��5+�t��VP�����g*0Os+5_i��4 ��(��A�4E�����D�W#�m��e�bbi�1d����+�TTLʚ&�Ν�{��~�%'�H����Yx8~�0���0�ʐ���0���#}e��2��	�r#���V%�Kʠ݅M�����o��hQ.{sy�`?���x"�Әk����teX՟�uX#�*0}^�d�U+u,K;�{M�Ձ��M5�-b���f0:����g)����������]gq�3�X�&�\�nkh�l5��� �P����J�re(�DaX7���� ��O̻�GW�x�<�����������+�����pJMW~�e��oTԪ���v�"8�2�E �^9����3w��릫����P�Bz��/��:���	�~������9S]�'��Գ`�x3_�1�O߇f�,���b:��zW�,g�޼��(��1K�j��v�#s��9��tbK�)�q�$��Nw��[w���R�Sע(��g�K��%ӀC9(�L	�z�_��J�DC�26cr���
�k�x6]�vd����M
��f�hm�p��/L����V�8YER�*O�6s9WR��]���\���Ȑ������99oO�>�vP��qQo
hSG�����eE�.2�V}=b4�x�i(�F�n"q�N�v�BJ貊,sE6+�ФD.��" ��<՚��=�~�(҇�Ր%���5&~��LɊ��o��Bc�h[�+D1��$�苧X�J�@��+x��XӌjУ�9�՘��g�Ft­���y�V��P1ٌ�Z���$�9V�B�خ4{��|��0�/�;b+*�m��Z����9%�xǤ�@�*'�$��>����My���]�jU���V�-F��.|G-	jl�	��6����?,\ڕV3�2������e�]��%�-���:�`]G[�]���K�SIu׎P����q�v�&k8�H`��vj�v�뵧������7�Z2�^���%��ާ�to�V�٘'{�)�����EI���wd�)Ҵ � ��\-o��,f��Y�Hz�mHy?��vO�^�F����RT�~�B�\�r C��Ě��Q��{�rp�"�ȩ�t�܆���$90�U�1�L#}2���_\�r�<i؍���ڑͮ�Z,�|�{9���h�5�4�#�<_@*O�+M}�	�����P,�ɍ�p����Ru9P/�J�Fo�.����¨?f���a���41�Hws3s��)9��'�:��!�t���K�=�ISv����k?^<W�K�8Wp#��kw7!��mWgj��I,��&������\�e��")d�2?
�K��e�ێ�������#'�)���:E:���K��ԉ�@Pۿ�GT��"��DS5�3>,�)��#�(��ު�Y�<�- VC�G+��X�A�H��T^�������/'f�`��Յ�:P�%G�" ?l��$�o�+s��
�m"m"��(�<�.P�ha���U�%�b�����Tk�j��N�aMQ�#K��+��7���OB5���?�J�Cd�7����.p|<1�Ȭ�Wj rQ��!�vq<��2#�(�����d�:��?W>���&ΖU�s���! ���%$�q�+�Y�� h�Z�Ȯ��P�Q�G�h]p�0�������سj@2�<C6�l*n#��9_�\]��1��9q�^Ϻ�,�:�?>,6M��L��g�t����U���*����"R�}�¹.bd��:�O�pl�!�k<�����T�𤗦��g����WVS;<i�D�p�w�VC�wW&[Y M��q��	 x����Kq�yI)Q�)����'z!nJd4LzK�d��RĢf��D,�V)ӳA���������R����s���vu���͔�ŜU�Wઉ��=Hoa��3Z�q:�`L��Z��=��^~0�'fCe��s����p�W5��$p�ަ����������^f�A;sZg�j]��x�B�Q��&(P�����&�u�H">_=�^����-������%G���W�^�}��c��}��b�����ߒ�9�3������H��H/v�����,ب�������ˌ�B/Z=�FU�mtͶ��%{��=���u�\��"��Y`⁾-Sɖ%�Æ��R'"dʒ�إ���Dj����E�n�p2�g>c4k����a=��_V��r�,a�~�y�^�=�N�U`�!B�q�
(p�^�H�fB^��ﳼ*5i>E�
��؆74���> �h㘆A-g?�9�x����
{�ì�!Vn�	��>����?~PTs'@�)	ǧ�\������L�Kbe-p2c�������x6��D4q�q���n��He%�1Utk��Qӈ�0�)8v]p���c`��n�
eߖޘKh�`]�n.~fG���U�Yx������9�R�����7!ݼ���﫨6õk.��!�{�����	��)�Z�����V܋���ӵ�w|������AFƝk����d(�kw��B�c4�ܻ���x����vX�HMO�g�KS�������'4<�7O5�}�n �� ��9�0$�*������Yq4=����\�J ���
��TU��T�_tg'�r��=��o��ʭN�岪�H�n���L0$�Ir��9 �x}��C����^��_���N]6�n�-���]��$A�3#���D��M�#��:jg���8���r(���:�ꇖ(��z�tv#����N\Ӡ�s�V:�)v��:�kAX���Lm�@��?k+K��q��5��+|9����v�Y��J��g�h�/�x1��q�!�	�����0�"��;}D}[F]$�Һ�`0��d��~�]:��Ԡ��h#Y;��An��8p�0*���OX��X���5`�	���@�7';T]��p(����
�5��t���4��~�^J'Џa'h% /E�߳" �\!)��:jR�~8)�'Q5���Z�dr�-i�����%��Y�6�)A�90��S-p���������*�� CH���܍��~����Q`D	�ʳ[�w����}'�n[e}�����E��"k�c��
i��;�����Q���ūϱ�Qb�e(υ6qİY�E_��<���_�gs���;�b�Ҳ���B�i���W�	��l"/��bcO�|��p�_�M�y��&Ff$)�����rߔ��#GY6;3�2�����3J%F����\o0*u���k�Z��,C��_�^2���2��4d�jLV04��Zh�T��0��e�_7#�jwk
��a���2n�W��Y1n+��d�92�J\�.0�o R��q!�\�#���r�ty�����d�8H�<p���鋦	���9�UL�&2C�[|I�K/���N�jt,��~��-�k
�u��\��A(��x�"1���C��2���Ǔ��k������E1�����}��r�J�󓯏��ɲ��G������ߦ���w����������g3���3���Ɗ�������Ձ���{�w���Ϻ嵊��u7��2α�;7߲�@��c���:��J�y�O�g�Kݯ��eϺ4=��D]
�{��Yki���~0�A�T�fӝ3��Fc�h��n�PKw���M�������؋�3�s���Q�-��"���Һ�B���L?ĔZ�?���TR��PI�դ��V�W������k+�Mg(�����}k�I#_�����ԫ�c�بH1��G�ҍ��u�kӯ����M����bGt��
�-ӹr��3��<���AS|↢صT�vg�4�m`peSc�=;{ר���ΟU��J6�[����"y�l�~Վ�R=��	5�Y�̖m�ơ��7W��Y�K��Lz�;�d�v�K՝�]������kLnAK[z��x{p�X�o>9�dfӄ�x,e�]
Ja�2�\xu㨣��Sb�o�z�J���R��Po�y���'!>����Y�Q�A�̊b=����B���+�@^sPaꘞ�"
�P��Œ��e��H��R7zߗ�i�.i(����[���ػ7���p;�L�1�hmL��X��VP���]�<��@v��ݸ`TD�mk~��/ ss��׻܎�񡬿�uy�M��Vk4�l��gN4j��l�j�$��5~Ɠ�op��Ʈ��W ܰ�,f�����}��lo}(�-�	�H�7��C�#ѥ�-5�m �+.���l�W%&����2�Y=/'}C`�ԓ���v��!Ю�g
`l�a�_A�4|X�.����VG�*Y)�������>�O��L��[��6ح;uB�r��RI֠�'l�{rߞM�5Up���cT3��m���T�4Y���b֭)vN3*����4�,�M�_�~:��������Β��GxC��x$[�}{�}�k��y�Ot�T�?q<��X��3� e�bN�ky_va����a;�V֚�M��iWG�j��\���<i��'M^�{���eS���̞�J��R��q��ջ_�����`����T��H�Z��U�6)L�*�1�����|k��Q�&�/�'?K�D�3�i`�r��N���O���`�@z��Fp���j�/=:�W���0�zɫ�cʦ�1LCdn�; ���օ[�ٞF���_FSܫ��Ib\�#��X��1�� ��d���q�XxE}���[�#��)��[��d�xyz�v��������G�	�(	G���L����������E�s��6��Z�C0��I��P����)�5lϴv@��.��<$[��d^J��߽�[���	�?)��Glօ��)r ���l��������*l������(+}번�����8����b�wtH�z$Kɸ�/���b-!�����	��Mpl�<Eْ�7̡9�u��Mu�C�M>
0�jtٶ�֟�.�ь������i�@�!�V�ϩ��vM��(ڍ~i��-�̰� ��^�.��T�I�W�,4��W=��f��0ԄJ�csc���b����Mn���fϫ<3X�kM3�N���G���$얝���$�T�=/��j�+	�A����m?�F� ������������ �q~��n\ Q���@0V��QK��8���@S|ܞc��ur�u|) � جMIJm���ep�sK�A�R�<�{Z72=г<t�y�������~�}������fw�p6o�������*;��0_���V�V�\b(?gj{ǢK�1��Z�m_i�����4f�����|�7_o&�KN�ٙ�loDw�N�F7�!�dV�d��q=�G>I:���*q!s�uT��%�*�2CD�-��Q���*����|�t�	���r��t;ϥôL���ǐ�ɗ#� Sh�� %{ag���y��5�35�k?�#��������9�B]Ϧk0�/��|�)��KY�f3%0��*|��r/���`TR�0R'�Ł�B�Ri�[��N�Xh�NG�V-K5`(ٵ���<	Ⴧ����ڛ	p 4l.�%c	�?t8�;bؼ���h싿NT��s(5[���O�V�%��B!���ס�C��f��Q��8��P��8`��W���L�jp�m//F哛�6��b��1+�h��?�_�Mήdy����m�%fV=p�H��t��k�h�t�����)y�15���$v����A��Z~nBuc��^�`P���B�p��(�p���#�"���ɃL��?)�[q8�E�E���Ţy�mӷ�������Y�C}��68	�����1����3$c��DA���K���k��;� �V�m�~\�6��ꭚ�Y�f�c��}ա�L`���y}��l�wV}}�l{"Ƈ�q�^�~��8�پ��37� s�w� �M91jl���Q���<�?�e�`O"�����$#����P��Y�j�6ǃ�h�Pͻ�ԱHk�EΊ���渺�OC��J�ǉ�#��/��\��V$�}t�]�8c��m�9 f�Z�|+��_r,ծbo3!숭��#�Y+$Q��p�z��W]�醚�W����_��KH_0E�_��&s�kw �/��5��[PWD�G_�o�Щ%�%p�a�V��3u�Sн���?m��������!�*TZkK�Կ�������Pc�r�wW���W�S���d�
�x��6a��E���[��A�E��Hڱ����5
��>�݁�
5B�R�6e�&|��*�����»h���9�db�?��Sl������/wN�f�M�"�aj�&Lpr��%��]�
x��oOfi:�"@Bd�=mPv�3zq��w�򟇫%׺���y���a=]Y]6�ޕ�-��cs�@���Մˉ0 �[��bӺ��*^�K�5�Bs�8�K��K�r$� v���;�аxJ8..m:����#��Õq����j�s�ι2bw�R~��Ȁ���N���m�#�j�R��9ˮ���Q*B+� tQT�|>�d�ʑ{�$��E��T�n�lA��al~�<��u?��v����(C�p[0~q�J'ɦM����c�Op[�ӳ
.��|5�|[	
��ɷ�TJ�k��StGk���c�a��G0I�w� ����@�	ȏUg��C�Y��z�yr\Ӓ�� �ٜi`�AJː`��~I��"�����^5g��9Z���ӆc�t ���wl@��c?%�d��Q����'ZŢ�Z%�r��r��v�k	"�������,S�v;�W$�d+����ZQ�Cx/U���5���?�� uW+���1#�Kњ��q��A��{�_�iu�&��l�u��M��,QS�Y�nc-�<�UJ��ǊW����Kt���;�f�*���"�W����kyG��CU��`����b������Cy��>����g��d���ɐ��8f�P�m�?*�($2"�����3�.�"�� q���HBOd�E�|V�c��,���R��!��b�S5��Zb6���7����7̕yܫ�;���D�r�$�R�^�8[ӧ�SIc���V���Pg�[�É��>�j��9ua��zُ��s_���vU��=�7��P�x(J7�7�)0�CM���a8�����/�t;Fe����T�+hZZJ���Ssڒ-�?��x�О�{%��iQ�hZK�7k�����Y�wF�1(�YܐnI�ۖ��)W��{f�5�#�;�$�����GH�����ǲR���PAZईn6a7�s��t�g�@�#Q��+��q��ۉGz� �tF:�,�r��PR�t��e	QZ�s,[�*��	19�Dn�k�6�39���	�b1���@�ET1x�>�v&Bqg��U��|�'0g��1&QEW<hkIr9~:K��i�p��V���e��!�0��V ���D�(����˭(���)*��:rpR٨��A��4U.���O�ļ!�������YO��	��ڲ�;U��j�G�9�=s� �٠���?ǫ�	�FId�31j�'?���/�7���Gq��p�dA_Ǟ��{��jD��`��Q�QA����\�f�
/H �~o��y|���5�ϊ
y\��d�zy��[ᱴc���x=-,e�֠��X���- '��~Í���ƚ�#�n��'p��Կ��B^l1��P2�Ja3]�?ɂ�3��k��[1b�T�6d�j�Q�?��O��w�T�V@+UGbM:�����.� �]8�� ���"4����9P�8 O������Ԉ�Am�f}XĤ��K�RJJg�C��nhV�H��$f��O�i���+�YBMB���\w��C��D�8�m��.��>駑F���/�y�[�XXF5��(�Z�nM3�l�و;B8_���%�ӼĚKLy�e�����;e��9qa+C�G�p=����L���5��G�fm��U!@��O����Up�9e����/����2�芼z���rQ�G���yv�tO$��|@�7��4��P+��zQ�%����]�%�1X�궲s"�}�#���G��٬��%K��H���o���[�\%��n�K��-n�I!T�Oq��VN5�ʰ.q*hb\��h4F�k�U9�*dM���&;l?)G��C�LN���dS�0 V�$'����1�Z%{'h���:S�5}�v<��I�|����6D��_�h�V;�7�L��B�0�����P�/����@q*y�ՠ�p�s��+B�0�CkO�j��A�� Ek�~�� �#vug}C���Ħw�R^LX�Q��ӨL�ֻn�
;�޽��G9��2F+��&�i�RԺ�ᙷfR����`��&�'������$���KIz��4ڔ�#��u)�>ޮ����]����"t-���/d���B�Oj[����U�����:�&��m2� ��'��p��� ik�ܿ�J��6��6�N�<� "��R;���6h3��*��Ŵ�(�1-�*���:�nԓ� Er���o�-��ݒ�R�:
��׺�i|qޚ\3+1Ƞ0n��]3+��|��jE�yW1���)6�<���e�e�-(Vס���˷Ú�b�R�`�>�=��X<{��#�W-�q'����2�����(�{Tz�&�s�\���5yt�U��RdXu��_o8R
��ݗȰ/�0�k ��.��9V��W�WQ�\�V%*S7т�e����'�ʟZ!h/��G{��>1�2�.�?�����!�SV�[�F�4�|��ҫ��rĞWp�1U�9�d����\H�Κ�#�6ML��� 0��k����m�[�[�o}�`�@a��������|����KI�4&���M��l*n���[Ӂ���J=l��>C��w3�"�����6����$��+@����f��s"��_��R���o5Zi���e�QW���q?л�g��$�6��^Y=�d>�o��~��_='�ҋ�[�!�S���g��%M2����7J.��7wr���w�>E�h��c�yX'�Ee�B.�p<+(V�n8�C.xs�y�+���o�+q�a$�I��v�Tm!n����/%�BY�Z�pDX�z���CϨ�e�طF�\ ��M��#B��<O
V�s�9�#�iS��-ɯ^�j�yR�(J(�	��]��y�T�-�C�N{{��$�<!S�y/+#�]h�~P�mt��J|���_�z��Mf�eQL�=�x���"�Z�"�̫��Q��ì�V�L]��;�T��o��;ø&v�{���s��b�p��I��������"zR�F�9a�'D*GC�Z%9/��B��¹���gP@$�Vn��ms�Kl�&���#�t)\�H��=�K�U�L4�'g<̴�m��{�}�!$e�#�$a��wFOq�K>��S��g�������ҋFM���3�]�{A����RSA]^�-���Z�5_h�B�g&�3hƴ�����ۛ�7�N��2�v���`aU�7Mwi���5�jp�*S/�p�����ˠԑ�V�B~B��p��q����r�����S��1�l/s./��_��V+�:ţ$��|]|��{���ߟ!= �N��p�T��XL�O-�i�eH���0/W/�q�D��@.Gq����+�h!���{�VjF�7����F�I����·�P.1Ξ�O�ا���˕�wW�hH�Ӯ���>�!�ʪ0W"ҷx��e|�o�{_���$�i�W3�'~Z� �ivqw��b��(AG�㿺�ԍ��+7v]��8h-������	!3��9kl���<T�d\>�w��A�V���P�f�6�:$H%�6�x��P\yb�e^��Z�� ôE�N��2|�,/;4��\����;QjӨ��K3@�}q&�~�Y����J.9��p��P}a�Ueb�]�;�Zk&�"﷞MrĽ�!�Һ����" HĨc:q��o#���FN�����w�����C��ï6XDYj$��RcU�1K���u5l�c�uk\G��CN���������(�bZ��0��;�S�H���&�<p�����`P��(�Ra��L(�2y�V����.�ҭ ?�!��6@յ|���g����IV䌫�2�.��xR.=)���Y�M�d2T��ݥN}��*�{q��J��\A��Sr�44�(=N���0�y}�ꃋS��Dk��*T&f��	)��΅̎j><c#�N��� )�q~�q�4�zZ�:|),4j;�DL*��a߸#{��'��R#9��HTODRN
�pG6oˀ����GDA%.U�����v�G�B.�,U�V�r����8�B<H�T�֜���x�b^*b�!Z]x/q�v�4�'���L��߲Z���-�tkq[��TS�]䫧�ʨ�ԗ�yO�!�E�6��nKOV箻T��(�h�&�_�®�Ӵ�9���#��/-�e�~w&����6\Q*�L�k[��%u����^_5d���K
P����̼X�7V�4I�`��)
�]�y<��k[:T�=�/�s9�k=�i_
��w\k2�"��gɧ������L,�zw�n<�фn���>�Z�G�f\c��ƨ�%1���QK�IQyɣŻX�v��)���[��I����6�Z�ӣ�㴑po�����R� w��X�]R�(ok�+�wC��h!D{�?2�F-�g7??�t�%tqȠ|�a)����4�=�3Y��+��Z%�����m��M�-kD��ؼ����0���i��jX�ӵ`c>�TYS�G��\�*3_����p���$�Z���t(�Q���b���Q,�	�:�&�C�OAt�^x�QY2�[��,,sP߻[�L^F�{�>v(�b�f���2���Z}��@wo�h�����so�Fz�e�뢟���}�]Vd��|-�h�ר���X�2��� ��l�jh�!�$8"��k��z�,�˸��3�?�a����w��U9B�iF/�rA��!Y�҇�t�����		>(�yYn/��7ѲQ(�f���DR�?o�_��sf�^����F:��μ�h.�K|瞧ӑ�t!���pF�X�y�j;�O�Y���~��6�z*uA �����
/�ya��0k13eG�ĉ��׊���Y����֎-�KU!�T��#Xp���9����&Q�On�Z�u�=��9r�*��+<�(�S`�\$�nd�̭�� Ņ@�#%1����Ϥ[�pyWM�_���3b]�/C�b�ԑG)KA\NyM�+��ߌ���4N	�v�i�a����7"�:�V_����ơܚ�ͮ���󙝏�2�c��taf����)��Ap%V �l�鯓��&Sc��M���WJ�',ns���jw^+�iB�R�M+@�$g�%�3R�	*���o����%a�C�y��*����'�t��MZ}Y}K�E�y��cA����d����Wي5�\�(���`����* ^�Ã7~L4`�5���ؒ|��ִ_l9WI�N	���G��*���k�Y���k7	�A���o����i�d��-h�Z�k�܈����u�2�rl9�P}\���7��|�=\�
/+�ױA����G�^����>`C��^u]�I?�^��x��~_/:���RM=iҥS�?�2Ιp̸Ը�Bz��g,v�,y� 2�>�{>p	��ޠ��9��y�C�y!���|Jܱ����k�<*�p�=�2/&@t��~0E�k�o�"�W,��L5�֝�ʊ5��1�s߃#���+�/��,�R���Ϗʭ���E�v������Ob�O�g~phN.����q�����6�Q���a-��):�G���y��ȩ%���Gw��)F����l1�k��W���8K�=��$��ML���<�U�H������
1�jX���DjЧ�L�)a^1Q�c�vam�+���W��wc�T���S*������M?l=�>DE�Xh+��D��4�N�BUT5�`��9�k�T d�F�aX�y�5e�m���H!n�et��u�BN�j��T�ц��]C�ZԄe�RŨ��f�/���]������<�����l������,�uo�𴣤�c�r���Ǩ���7��M�i��������l!$��e�J�����E���z�['�ebқſ D"�]��,�3B�ץ3�¸E�'����'��|a)7N��'��P)U��2`U,����i�������9�ߓ�EvF�j��H֕���/h������D�*��+�sm���n&�F��K3o��H�%���x���%I\
4,�`�;�W�
pd4��8�5��F.��_tY�5�h3��ߒbL�����z�)-��ǩ�
�-2�r�^nU��"��?!\�a5��2�N�A��2A̩�$�7�Z����w������k�
;W64^�T��s'��b2J�R፹���ɯ֛�����M=A��)�\[�������QD�%ԁ�IeX|�E���:�I(3j���R6�n�R'���>D�ѭ����j���X��E�����a��M��'[<�D;7�Q��Q���j�@I��W`Bh�0����>C�J9����J�)�����ʯ07Y�9�K��V�
�?<"�Ʊ�	��������u�G?Kj��pDM�vw� |�D���N�Q������4�_ZZ:q�袘D��=����Ҝc�b�Đ�Z���6b�z2_�92�C^!-c���1�H@1�p+��G������$"��t�W�],��g	��5U����N�C�j�[����4������*����ϟq��I�:o}��9�	�p��<ypPK�:OX>���*B�ɺZ��w��r�x9@�����B}k��c�s�b��M���j�2�`����,hV�o�%X|$ˡ��KЛ����e �MTnJ�웢��J",RȞ�|�0AgّCU�Ehc1��)*�e꽅*�x�4OZi��∋�
m������u�j��6Sl�>�/:\l�U��z�D�7�Y���}\���&���������n^Ć3�9�Ħ�{V�Ot�m*u��v5�zn?rLXF;���h���g�E����E{���N����F�:�jO�J��{�T��{ӣ�M;����6;G8dL���6�钗�%**4ҹ� �?��|mb[Dt-j-�7sY��Yu����}Y����]��<Xīv�l�*��~�p����.ӥ[p��c�����{��'���j�d�[Pg.���4I�G2��c�1N>u7���dh�#D�P,_,�B=�T�1� ^�'n,�x����z�ލQ��|�J#��W��a����ӖԒ��!]q���_�Կ�) ��v-��;�"�~ڀ�I|)ɭ�7�b�3�N3ڛ�.�N	��Uo_��
&�ㅣ>�"Q�m�P<ϕ�����ma��$6�K�z
�'���]�<N�1 ?��[q���^G�_�:lV]c�F޹O�d��S#�au��F2�Z0��z��ߡ;QԪVv�s�U�O�LOH�`Z��x6����45�I�ND	ڴc�nR��Z� w 5����g7U�%��A���|xӇ�5r�b��2�9��>pM��A��=�Ap;v�@�R�u�=�����M���v�N������&8�q�Di�P�7�'fk�ccs��]$#�I���`Z����L�c�٨��yVBD��V��eŃ��m5��>k{A�([e�JBx�L� �`��u���ȽeP0����@Vg� X� d��#��G6���H��vy$M��=�L�����x�1�4���3�'|��i؆VF�#W�Ҵ����%W��gm�Ўj�?�����ٚ?Q��az)�	��ť�6�H\��2���o�+ǚ��!�7��Л!!U>��!����1�CO
���'|�M������w��s@��9��+M�с������rn�1&J��%��w��q�~�yIu�?D�(@���x�b�� ��=���N�=�rj�)pX��<7m�V5bl�ͫ�0� �)�������h���ũK�{��F�2���������g�-p�Z%V�"�Gzל���n�A�,ە�	�* ��>���4^˝��̍�3n���Ð�|a躍��*u�O"P�X½IV��?b+�ꮽ>=Ƴ�u'���8U
q����i,KH�u+L��'�R|_�(�Qm�C��>�Χ��-�q�x9�b�ڗL�a��Z,��`�%���L�l��4O���_፠����F4���.�)g	d���m͢�߁ѝ& 1c�F]�V>*}�
�����¹���>�7��ULB9O�C`;l4Yě�k�偁
9�m"1Gwe5�f��(/gG�^Dj�1|m-��F�ĳ����>�û��`U6�8�x�nǙ�=�j�C���aw<�T�M=���,_�~W�L}Ƞ0I$0�R��e�u�ce���z��m�z�ޟ�Z\�ՊC�Ȼ�CLυ9H��5��W,�5&�\/�9��Bĵ2�IQ���,=�7P�@�F�s���tm��[���qx�����k����7��*����,�	\���a[�y��j�Be��Ko��|�����rQ$%"�2�iS�P�nH����������]2tL�n�XU�<�O������.%�K|�"Q�Tj%͏

Q*X�N\h'�7���{zA�||�.22BY��n�"Y6�5;�y�\�Y���	���>Հ �T�7o�L{���m���ڃzZ�K�ta8_Jx[Re�_������iRs)��'o��������g�������?�֨c�h7�Ț���·��� ^J�cH�%��jA��pp��/;d��Qq|�X��e#�i���m��j�G��B�Ŧ�o0���W�h%�ٚ����!��;@�ۻ� dU��B���zJŰ�s�w�:G1���Y�ʓ\/�w?���{�(�ǳ��S�=N�wE�
b��n�0�� �=����j�&Q_r���|��H�Ul��%&�+�!��(�OX�Zn��M�*�T�k��/`#/$s����Y֟��A�8�/�g�GQ�5�`_0�E&uw��Y�8�W|�a���?����E��{"��5���	,� ����֝슣R��Tx�`@'cK�gg{����4bAP�@���ʏ4��ٳ�N��ʑ�ۉ�3�5K��A�q�8K� ��?�[���K�4���!5ܓ�>�>)�����O���Z���K�a�z}�4>å6�����S��/Ga!���*�3U���y��wfH`�E�n5��EK�r՜�ǚ�ٳ���~����m����
_-��6Ƒ�cn="|$iW�B�E`b4Td��`�g�)�J{2z4��cO��d �n׌Ɨ�+V|C��F4S�!Y��F�5����Ÿ�/�����:l?����{�����)ɴ%)'�FP/m��G�I$����E�ׅ���yK	��{�Qs����d6]}�V��(�N
M{E��Ln������<�h'��a���9���0��c䥒oL���D�a�v�8JZ8�'.���q�+�b���#mbkkۇ���e�d'�y����c'b�.$��y� ���t���#��n ��q*"p'�9�o���f.w��ݳ̬�>��h�����s��������̣�U!0wOY�\���|;�EѾ�~/TE�SȾ�O��O��o=����y�"�6��zZ�.�zb)}��jݎP�|���H�p���ny��ںzY��C��9�=�|% �y�$�|��ۺz�S�0]��e����#��t�40�@ޭ:��=�L���x] � o�����m���r�zz/��;��]>y���wy��M��!1_��Q����1Ա�1Q����e<�x2E��s��B,d����%�h_���8�S�e�v�@��Bu���}FH8?�2��v��/���g���:OЛ����r�8772�6��3E�K,*z��7��ON�A>qvtLX]`��q�L�g9��EQ�g�|U*�K�R���3V�!����/����2���iJ���W�Z��j��a87�.|���R�?|.v6` &PY��G�A�>�վ�n�$07�5b@o	�c0ܒ!�ʓ�&wp"�i};�\�S��?�-�ؤ��3�5!}.�D�|�Zd����&�������)"-9��!��"[Zt�p���Z~)��%>�'�G����m2����-�d	����E:ip������_r�+_c����G������j���e��f��$����!Jd��6��o�0�E7I
U��Z�]�"��D�\��u�٦�k��bE����E_��@�E�u7�Z�ha���A��2��sG�E��
Q��Kl�����:�R�[���z��+��;�R��1���$��(�� � ��}/���v�YS�cҶ�*��;�q�80oV��!�f/K� �|��6W�ZU�.��p���_�V]b�h���Z�p�r�e������Z�WnNF�	 �0�Ku�YA3~a�)aO�V^ƴ����������2��M� O7q�:�ZEL/�lU����1,;�ѥ/H\��OV0l!�q��&nN20��<M����V"Rͦ����!�J�~���{;r^�ϩ��F}��ʠ�X�-�u1JP�l�s���ձ�3�k<qy�N3݋�a%o�ݒ��<��%}���c�4�|2V*�p�#�p����k�#]]�
���;��7~;�$����d��69�*%�����g�\�خ����S��c�����c�֮�;>Hmt/8߄,���9������&�:*a������KR?~�bQ@|�ǟ�`I�����č�b���W�ڒO�,��P����K���MV�_��N�9qou�s�"ܛ��,���q�fJ���b��}�]D�j~�'o��a;�숉��?��T{�>ѥ`a�x�����Xe�٭�_��9vYX,�T>�]I��o�k��O8~���i�ڰ�x�}t����oW����i�G�B��`����"�D��ƕ����g�(Э�S���w�]m�ܐJГ"�^1M
=Ī:<ȉ�w JY��"��/e*B�}�~&��΋{[Z�_^4����4�Sa �.S������w���wY����DSvZ|����&�n��z��8�K{,�i�-|��\���mh��˛YL{�*�fʥI�r;�w��;1RDu&^�ط�	�V��æY�����/��Z�E�<���Fِ��v֎A��������)�\/�bQ����.sm�2��L'�b�)�ꦁ���3��"�D	mcx�h!*ƽW˫�sZ%����pq�'B�fB�c&z�4�{�\���f<9=i�+�R�����U1���eQ�iC0���W�5���6��g��siD͵+�l׋}����(R�nS����M��9:���l�>�.N)��˦�lAL4�V�`cs(^=|Y�c�bG\�4dU"~�r���@�FdsL��E��	>l�sOm��?ɉ��<m�$��d��F��
C�QpE���տDR�Ǒ��z�h�9g}I#^�C���NV]�ہ8��t?���<���lU��V��[�n�e���,�ha�$��[E��Jr(V(ie��)����S�iy׈]_u�+G5"�h~~o�|�;?��?��Y4'��;:�����>B��\�C�<�~?��H�E�	���<)����&MUmb�h�	�H��_�7���t��4��W\@x�m��I<FC��)�)�=�q��v�E��n;Y����~�>U��X�u�\�ș���x��_��زv;TˠC�I�K�m�'(�1j�*r���~֢��?�z�±>�2�X���i�{-��h�N�:�QR�+KQĞn��O���}�^uLX� K�y��+ؐ�Ν���a�ux!G�2	<H�O����f
V�gD&
���4s�R�>Q��v�:���V�#X}���iCmE)�-O�r1�����B�C�A��,=^�p+R�k�G��m��5����3����0`��YB ���P\��]��[��3�H�J��'s5�d���/�0�WYb�}M)��;7�sw��pt�N(�FP��',���wj�g���ÁONi��t��2�lj�LG���y�6�U�L�1E�UJ\!4�6�)�b,6M�ߐ�i~�	���[��y�,�Jb-��56&��D���� �-�G�M����.�ё�݈�aT<n#�Ax��z�Q����N��#��;��͉�hd��dkd	�'�[:l��,m�N ;g��@wS ����-�g�%�̎��?����O����3������f�l�"�9&v��@���g���#�`�hg4q��99�x ,A �O8`fgcc�f	2�ٹؘ�����vv� '�3�����썜��� ' ��2���X�<�\ nF�� .N����|��2����������0��fl���2b12�03s����s����1��q3MY8�،�F�F���x9Y�ٸ9ظ�X>O�,�@��Z�~����s��x�����1�g�� N6VNNV 3;3�����o� gg{��LL�����e��`6Y;����ncj ��-��S��vN��v�< ��忽[:��@e
t2q��w��Q�[�?���@�:$a2�19Y��}jA�)*#[�O����5���&@����)�;���@''#s�?5���|�c� �����W��M~����0�+���bg�_��I��X9��9�� P��ߊ,������Xdb�:�}R|���	`d�������?�� F��.�w�4r�/�?k�c�t�ӿ������e�d�o��;��D�������������?ST�� �����C�����~>�H�K�`�dN���T����i�Ϥ��LM?ͯbi�2ؙ�1|������ݿ��k�v���O�O��� �F� KS�ѿss �hdC0v�o*�OM|^P���O����~j�9M���s8�iSEA����߶]�R�Bj��
�R�b���)��rb�ץf��ץa�%g������c�;��J�@A����@HB��i�J�!BHDBR(
.vT�;v�^��;��V\�k���ܛ�@���}�o��{gΜ9s���\�l�r
7CI0���L�i��$rs	� �
?��E�!�b�)n�U�C��P-��p�kSh]�J�TL&���Ј�Cj �H�0&�2��s	�T�ApԌ�h��#�����]��l��p�1Bշ�;�c<���1�j�_�L�������M�5ā��J�dD ѓ�Η�0��ec�u�*DI|���Y.�ZJU�y&����!��!��� ��CeI &B@D)d�L�� 3��H?�R�Z`yd��������`G!$�����i<������w6�Q˕*����~U7h0�4F	���;�!I��
R��!\<[!�6V�.W�Y�")~���N�P���l
m���P5YPz�j�"��d��C�Η l�9 D�H���Q*�V9R�!*��T*�@ E>��|�$@�ۑ&_!R�%*(���a�:I"V��q �X�3�g>pT��A��}{;���@)�MǇIs��ݙ�D)��%B�Q�'� C^K&z�&�'�ؕ�� KN�؂�T��*-�B��/���d1�! �T�LЅAC�{w'6��ˋ�x��Pk��/�z!,X�-
�v�Q����.��n2)|�R:_	���6"�\K��ޝ���*��D��B	�#��A��fh�YCG0#�Ȩ!*#�M9��B���j8���0��� 	bi��`U.���*U����^��4(%j��;<ԁ�$YD�/�%Z?2^�����2!�x�ِ+(@�������V ���K��@�����6d��`y���F.�@�Hi�*�T�� ;$�� ��C���N�PT�@�'Һ���]�OOw�����և��4I~��iF�"��Md�[9��0<�KGi��RMjэ�Ղc�A�+�, ~B"'�S�Pˠ�.j��H�H!A����C����TH�8�x/�9p^ ���Щ�~�v�ZfBCRZ�s��I�a9�Pg��|9_cc�!�8Wn7>79ޙM����,`�|��φ��J`�U,��R��[<z�qI@x�Ҁ�8Kl{�8C�wG���=���p O�l�R�4������JydS�Ҋ��x���E�EE!*b��R!Pd�y�Z��5�[<IB�|���IG�Y[�P�J�����Ȁ���@�n�q�O���
�R�=N�gB����L"�K�|`^�B�8ɐ�� `�!�ܞ�DDJ���� J�I���|Cb�h�� ���L�S����Db(@�P� �?P��%�R�7���5�F�
  X��G� �Á�B�*�k�!e	5�T��>I-b��yb���_�WH�P�^⧉��C��ja$ ���Q d�r*ʣ�CqN�H]'O�� 	`��A*��A:~��(����f��B)������=d,�sEZ�d�[ ����Д��q0Y�
"-�X܀dsH��k"g�?�P �.5,I32�
�H�X������%ؤ�A
�D�,NQ+P<	^2�a��� \�\�J�3�c@�ؚ�3@H�Sy�4�,�7ˍM�x<
��4�1��t%F,�@ @)�d5��H��*�\,԰�?�,��@{`��H�$�'HT�+]����MԐ.����@;'��E��Õ�]�"�"��C���F��� @T(��$������Z�{��#8�`�#zCf�W�é����zH�9����Arx5�HPDW�$|2��:�`r2�F��&�]��W&���d�O���,�+��C�A��}*_���J�=���k"#2��9ćX�hI�����>�#%�1�#�r�?��L�z������w�
>����D��m�R㙞6���# �4�G�.�����Z���:-�v.ďA� ��
����<���S���4]%�U�?��:Lg%O�$����=XR'�>=P�d�I,�z�:���Km�
����0��D�jʒ�qT�j�F�j�Y��XTC�b:���I � ���X㉤��V�SD����:]�� �n��z�!��(�����q�:�@�9��i�M�-��vztd�k#C��<l[�A��G�J	ԭ
���͐�0A�	B}��"X��.���p
�MZ�,��Ъ��bI��U���_�4�L��\3=ņ�e�h�)�L���d8�Kс�A����WKT��Yb�����&��'��J,H!�v�� �fJP�^DA�&�H�FW䯀�JE柕"�@�:䑀���C�p$�b0K�@�t� �)�Q8�\DY2�W�#P0a�Ό./�Rj���Ô��$Ѻ	pCmq��O;I�Ȁ,%�"���Ѥ��J̷�Z9ZBj�#�k�f�x�Eap,r,O0oq�X��a�(0��̧�� Q"��/���DF��T�D�-q�����( ?��r;d��
��MȀ'� �֚��E�v8�hl���� P�P,/�bWX%��
bc�B-��.�p���'H�TC[�ñ$�*k�k$��\jBP(���
�##v$kh<�O�F�xr�ޙ�Yk<���kG%���f��@h���SEK�T�H��B���� -�N���A�i�@$������	���A	��1AQ0��Ff��ؐ;E�r���a�R����l�C(�.(P~HC� +=M��J�� ��
�ڊ�7 �ý���/�M."?�?�=��I�:�����?��X��(0cp�y�3��Ԑ4�d��6���Ab3����I�
�HO�d�&$�s���NOX��P��*��?2�WBLTPC ԡ� �%rۏ`���!� ��#��j@o����(� ̎���U�����p
ڢi�l���|9��4dr�&K#�#4 4���@`:�Ww���p����+~dI�G�(��?ܭ��4����;�����C4o�;��{�v����k����9�tD����%��t���P��"^'��ہRQ���A�S���P�Xs1�'�ؓ�za��+�%�%�-,���N��WW�[j�gS{�%:8H�t��E��sVb'N�r_Pd�<��:�>|�@,��T9r�O�L&A4T�t��w��G0��R��!�	7(�i2�:*`�ҩ�%��")��2eb�>ܽ(����tg�Pm��V�B��I�-���b�d�@��� J?#2(��F�k���Rm,p��`IZ	�t0��l�U���I�e ��$�4�E����C��+H�0�s=
�F@\`�C��*Gd������W���y��IK�*dF�$`e�������lz�l�~!4�5T�$@����&����xXT��*�)R��A�A� jC�"���b�����;�\.\1.��y�-�2E��dO�?�� ����}�ԁ�t�#�#��:�D���
ؐ����	 ���E3��Y�WA����J����?���F9`;���ʚ�mP���%�\ � �^$�*q�
t!������b%%RCU�0H�YS�Y�oh{��hRu�/���pn$4��#�H��4�-��^���b�x���]�ރ��ʒ��xVC:%��d�"9���I��kxy�EY3� ��E(>��	?ԟ\h6i�K�S����2/�E^���2/��R/\.�@���<x��ĲI�_�%蜊9�E[��f�z&n6Pcг"Ђ�<���̴�c�1<���7U�ۦ�[1^�{_�}����>���@��{�83R����d�Ѳ���F��E��Q5�b�K�̅�W9�C�0�� �GYz�f�-/�$��*έ]m$�+aP·ΐ��J����J)��(]��& ���u�B���#j ��f��!���V �"����nDj�ƉL\���#��V�j%4�(?��8SS⧐�TTF$��h�1�-���܆��1R��DĆ�.�f�E�.�*L8Dɑ��2����L�I��&P4�M���`t��nO�����O�3O@3�;�~p�K��H�(I���W_w��ޕ��ꁉv��âQN�7`�dB�3h��#A� �P¬X�R-�v�J;a���Hp�q	N�3�+�r9>Dp0P�x<B�J� �..gZKX�@.o��Xl/�N!R)r`PM�>T)�&��R�".@�I߂�������0ִ��n�(y0�&���٧���}�@����Z*HM���T'5�C�S A=K@��=P��X��;�'��ed1�\s}�$2AZ���~E�����A�B,tz�8��QG1��P�t	 o�:YN�3	6�A�'���!��p�1?Ֆ����&�
H�X
D_D��T���2����1����R�.��#�c%�	� 	�����"!�@4��]�[���=.$~�_㡼(�iV���PQ.�.蜑��%��0u��	�U��k�0��Q"�Q��Fb�".Ќ�wG�$�N�i����1���+��w�wv�9".��w�}�Һ�;�L@&��FpG�̹C��,#+��c�3p� �̕x����~�	p���F�= y�\px����J��!�b�X��A�ؔ���Q��ԡvN��	r�T�P�R�����âh8$jM�,��$�ȡJԞ.�0@4)�
�i�h�9�$0�3�M)*�@�n�,J�J&l&�c�I�&���00��-�ZHi���@���A8��g�*�����Yb�tR�Z4 -LRK��X���!\9��eL+-=D����c�� ����Ȉ��i�g9�H�!�1���Њi�`�a;�S��kk��E�$☐��xzL#)z%��*qL`�P+R�1��a��*���RE�%L�_ӫ�)�;�W��S����-Hֶ�m��^������t�"�)u���cc��A��Ϋ�IQM����Ԑ¡<lOM�>V�"��!���k:�W ;3�~>�X���P�Z�8�Z
t��N��ː��]��ϣ�8Q����G�4,!��O��䑢O�]��+RUds�W�r��Z��(e�L�Y�9�%~�HVtR5o$^.��@cp�T�j67��}׶�5�.*�ѯN��������z���t��k2n�[����w����ՔD�{��4_���Q�BBeR2�� �'��J�O6�9N�S�rP��+T9L"Y�G��hK�P��$��!}/�n�P�,X���G�#�R�A�q�C�Ι��7*�᷈�<����|	��0���#'�����������d�k�W� ��"H8��� o�'�B����ҋ�S�����4�F�G���G�b	u�c�2G������,�ԑT-tX>D�����3D�
�����b�R��2��<� @T�����zz
H�y4孃wͣnug��#��r5pBe�+:4=T7T������	M�ֵ�`ÆpY|a��2��Au�eгD�$~ɤÄ�>��t�ř"r�
����c���	�}bB##�$��(�qeg�"8xS�$�U����2����j���ZMІ<���#X��"<xE�a��k�T�pƀ��#vN>y�n�1<��C�Im���26��T,1��g6D8����ImB�������>�� r�"��W�NVS`pmї�([�B@?��ˉrh?�J=9fZ�Ҵ��	 #K���f:�ð��o�*T��Uk���c�~�SХ�T0eE����k��}�E�x��"(ӎ�#A�IQ�o�3�<�HI�7p	}`_j[�ڻ"7�
&�g����蜌E����>L�mF��hC��%�ғ5�h@�@* �^.�SŤ��{t�U�K�<5 �B��m�P�����̣�RW��b7�@�Е:S� �'ɡn��ǽ��D��t@��T��c�F=����
 ��=��|�=�ǭļ$~PU"��&�mg����lM]x<���ޅ����&��6{�RIv�Ʌ�����+����0;���ʀA�L$�Dw�S�)���1�� [�}b��ٙ�^�>�	���h��G_�������1A��T��<�
SN\�����H�R.�$�RO�3�zHmG�ԡ7�D��FS �S%���.��/t:,���\l��x�d��Q�:=	8*|��畿�ါ��� Tm��Q���)�0\x�����T�����F��ǀUu��CO����������nUR���~\P���f�m�6��>p�-���m��ڙ�Y
� C���f-�u��5 ��ʹ�5������eB�9�s�"��&Ef�á��IQ5ۤ�����K� �: B�NK"���������)�T|� ��$�u�����J�ֹ�����Be*>H�.Y�^4u!FlT�������#'��u�7:���+��䩉P)�A�>1�tV����%�&�n���`$��,��ã��������PU��8W�%�R�eb!���������%8�K�a/"�Ezy.9CG��2���a,T�$����R`���%+�Q]�Z!_܁�yH_� pK��z)m�b.,�r�·;���5`��Q"��������A�C�+xʀᡶ&V���B����=�%ԉ
��Ss�_B[�ω��3"$�з�7I\�����"
���J	|�J�� �1� �b���B�V6��.X?*�1V�Z툯,�P2�{�@�����lUP`O�)-)��1��A퀐a�5��AYbR.�:�3�~��2Ȼ~�
&��X��/���N~
y�y�0KU�K��}藑ΊF���R��ݸ2`
���i�4�	���/�;z�mH a����(�R��m�՚*���*/*8Dp赧�SS�}�1MB�.X2 �`�ڡ}"�h�OH�Ң��#����ÿ`lM=���?��<ڠ*\��ܱ���5��;E�|�/��<��f�' QL�f��.�p�M�2/fZ��x����2��?��N�	 b��{0����d��<���Q�Fz�L"��jdr.�^�EwW4�:uVu$X��Y|����q���
]����v&�]�U���|���e�	�jV;�L�+�po��H�i����������i����j�i�ٌZ,�K �،���35��`d�7P ���m�K�5��A��V�p��e�G�# ��$�-Ñ���cI&~hQY�^K���оb^prr"������Ȕ G
+�{]��_����y+q��d?(��RP��s��0GG�jxk�����u��c�k�(��W	h�Hg��\���\N�
]Z�� ���(	�P��8��N�A���!#>�"��\C
�Ywްb�N~��������M�tYP�4��/��k��!�uF�P��:6��װ�����JY�-Z�ք�$�Z����<��H��ja�}1��A�^L7�K0�����O	HYNl�c�?�	4D��ұ��~�315XQ<E�5W�p}�҂i8R]5���;�xzV�7B�7h�ӥ����8�<h(@&�4Va��Tɨ��/��2��+���%����i5'Q����W�R�_u魂��������V��b�5��O�v���S�%���+��<������\�����GRd�`.Bs\ ]@�:��-t�9�N�\�L^�R;��a Ib��l\��A��MP+��UO�K,�D7���f�!%��
m�#����6��6���p���1C,E��jߠ�����a"	�ע����"3���!T��@P�vT�� ܶ����� ���b�&Ld�aC�J��wr�@����FH��8���Z F75H�0�M�gh�ӋPs��9r�X8�0��dd�����m1Զ3y�.����M�,KS��H���*�˵S!�W�e��.ڀ�@
�P�tb&��)��^0���.����F[!B����%���+���?|R�nK��u΄a�TEF�.���|�s�9J�h��H�1�hZ'EF^Ƒ���'��E��#�h���P;!�UY��9�E�ܺ�;A2t<n�o�AF����-��g���	_gA�Yԩƍ��(�D�<�5���\��������t<IAئS��V,sW��K)y�	ii�H2��]��`Ak]f�T��v?MA�"Y�#p��\4����3�(�3T�[E�j��������� $M��,�U�0βӞ����!���UY2<*:�-K֋�g � #F���[� T��Kv��*u���B��h&(/d�J�q�Zcr:k��	�^�\�U�vS����D�,�������a�F����2��e�����ke���
��!�# i|�O�"@oRP���Uɴ�{��=ĸ�T��Y�J� �%�xD-��1)������	0g�-G�5{+�"�ZE]]����VsHRj��M��O� �#.���قũ�4t��^t�����U���P�j��w��i�MT!:��	Xԃv���F���ąp���w�\r�nH�@��T'դ��(5x�Y�O����5���o�T��V{��S.j�HU�t��IZhk��YU;·glH&g��&���O(d�T�%S�U�wO `ȻK�t'�PI0	O"�w���誔X��3h u��6�a�⮽ȂD¦_`�~��"���	��Q'�)�i�gjS��K4�GAͰ5��v#�7@s�7��������mF`hT���A=�1M�}�ˁ��OͿ�+�����ed�u�M}���9P���]�psXD�W�3	H�6�5x�Nt��fX����E��E���r�^2h��pL=/.N;�W����Gw}+=&��30�4��K��W'cǼk|i�?�,�����񽭤�M��r�<���U|�7;�쟍��(/�����ս��s������ '�u:O?Pr#�9����*�'�[��e0D���&a�:��n���4�gx��<۾�dE�6�ƈ��_�S��!ˉ���a�N*���h����OrL�'K2x�ԟ����W���#;/����'�>�o�b�_G{�A�V'i��k���:���ܷ��_�L�ر:�����1%O�T��l�����xǩ����r�v�q��h�&�o %�ȑ����o�7|�s�����U�z�ڗ�|�2g�L�(+!�/N @B�jthc��"��3W8l4lI�N9w�$���~��o���D����v������3�N� �g�����<3�}�,]DV���T"i&˱gd� G��=	GU���4����t����#�.��t�$'6�G�@s� ��_��f��f��)E"K�'�4 ��sX�M�Y1��<m�)�B��-<; ��o�=���ɺ|tl�:�r��#T�<��l��&�� ����� ��A=�q02��S-2�yB���`�D�Fİ�5p��
`i�,{�s�>?��%��.SKUZ4)���DA o�*�J3?
���2[�
@�R��V�9hEh�P�m�U�Z��XF�"\H��*�/aQXS�(���1P�|TP�	�Gp}�Q��	�Zp���� ;��h�/B�T��&j9���M�����76(:&�wPL��@�x�I���-*��J�o�1֎�lT\�!��A�~��8��	��9Jy�ݻ��4��8�j�غ�h����^���j�L3!�@OSDB48}��"�&�
~�"��E��y8x�1���:]�4�]�~A�k���Z<B��)Of��k<�Zv�I���?�2�Dw_3��m`d@��>AD�*]������I��	|F��@��E*>��0�36&�ە��@�`13� u�3K,T�� �\,q�/� �zq� ����\5�Tb�D��OL^�C&���ó�v����&�$>Ll�SEp�4ޱ��z��-��R���Y9%�̻�Om�짯��U�Ʊ��+dr�,����q����� �����9�B���ѹBr���hP?|��H��\���d��z�"VMZxb�T���;�p�&���C[L�/�&���~��X����6����_�ע�.]� �H$��D9J� yՆ� �e� "��F��7�vPrƴ��[k�Z�q�Z�@�ï1�8�[�D٪ ,`?nO[$t��0 �),F:y5���I�.J��k�L�C��P�I$|�҇	53
&M�S�|�B�m�ֈ�z@��pP3	��%0��ÄkM^���<8���jU�+y��XX�km���k�D����Ht�����^9D�Af!Ó���T*|%6�lO����zƆ�	*l�\$ j�eҹ ���Z�%Si��"�K�Z��5G��/�Xh:ȨC%S�%�I"�{��R�Ʀ��)�3PH�4��m�%6�d�������x�}#���P�ڑW$Rk�~�Z���5'�JE�
O��WX��}U��$��Y�$�JӬ K�'׸�l��Zlf:_�"�r%�d�'��*��"�8A�I�˳�N�I2�5�R<L�I��ҽ���Q���D
/}��E�1�`�Ѫ�:��R4�ohn����]a��-j�B͞?`�r���8>�s�CUº�K%�I�ڣ�@��w&�����eѥb]�^�[ �\I����:�T�^���<��A�pB�X���.�� x�J�{�F���l�A�X���{���*��	�*e�y`! �݁�������"�^����A.2���X|�������#�Р��W; =��F�X,>�Hb��O(g���AN�0*g�y�D��s���lx��k�&�CLү�!30�i�A���S�U�ԟ�k�����/�x�.x�Y?ԝ�� ?*^dSji^8=._"Nq���^��U29��P�"ś%�o�2�P�hc LJ�{z��I"E>w��5m�F�HY�_<�G�_���M���]�qꏣ�� W[��K %��� IP�	$��O�[�:�-�4����1X�C �� GG t���e��RU*W�΃a�$�g!
�]����Л�{ �QyB�R.��;�k�W������'id��%�G�ʤ�����!����r��\GuX���Pba��ڃ%g��,wv^�t khNP#��x���z� fq�Z���t�*U�	LMitI9O"Y"�~�?WS�$��ӥ^D
�T(:�>5�����b�P$e���AbR��n*O��~\4cb���w��Z�"l�U� J�x�?��P��-D�%7tB4��M���I"�<�I�V�VQ7)���\�k�V댠P���� ��:��"��p�������<�O�B����2����%y���_��N����Г�L_��Wɣ�WC#ݧ�G(�g��?c9ݾ(���E?~�g�HW�G�����ރA?�"t=�]>&Z ���߀�&�a��\��\��s�z��fXC���������zO��F�d���<^�X%JW���:����C�1�,aY�X������_���~���G &���su풔�^�2COX*�"ȷ�GP�
�P��u��j�:���ud1�tB��r�H�D�փCN�˭9K�ԛOn3�(`�������nn+�-L����R��Vz��ޕߥc�t�Y���]�:Q��Lu6�e��:�!�:�US:��x�jK��5Z`Eo x�Jx�=2�_�G�j��l!_�K׺�w���٣��x�����������Md龄[w�.]:wv'�];y��ۀ��L�x��3�.:p]z�p� H�?�H�����?��#?�ɏ���i��O�����_~��c��>&��1#?M~�i�����?�X��4�ɧ9��$?�~�cE���}����>ֿ�iG~l~�cb�}f����)�*��vl����j[�߇-�䲠E�2g�o���U�u'.�w�qB�~3���cq��ee��:��.V�{���Y���rE��_���w�tr����NT_����D�!��uօ�[�़c�(�X�7�wv�\	�7f��fs�\e����)��>�y�yk}soS�<���T�_,u�8�B�{o�<��^�1��zEQ���7�����S��n1���./���Ww��~�;�F���$���;��:tn��/�~��K_��^��'��ߴ���B׽��ϧz�/w0�Нe%]o��!�yʫq����C�t�����/���_}�W+��NS_-��zI}�������~Vm�ŋ�;7��zO�|}u�o�cW��4���o�[��yָ]Y�����T�{�cHo���	���/=���XE�a9�#�ƴrӫU'Z��ښ�cݬ������bc]�%0���w����r�r��gW��%��Y5�í�u��W�]9��^���b˼���3vxe`غ���%��ж0Go��w�� j�	�*��!k2x�d`��������0; c5xn
~���j�6��6.��tC�K�V����&C�y����l�Yέ�>��*1����|~܂#���/5�s���W��j�����}�z`i3�"{��^�6m��s�{C���#�&{5:nx��ܫM��v�������.-c,�w0����9��ػ2�".4�>��
x��ϴXw=�! ��t˃����ew�(�e�n��WG��0��qeIΎR�a�;���'��NYt'�z�0��~[t��v�/�=[�YO=D�=4dp䙎{*K>V�)_�3�x���}���̅��^�
��������C��|br��E��f��\���[`���0��{��,h-�8d�j+�����-���D�ߗ֤��p�Ŗ]��n[��2�du�7�k��܎��G.}������?�Vwf�����w��xn�~yF��Ϯ<ۿ��[�m7N��n������n�7�K'��U,I��üz�w����Z��J� ������'��װ��h�jZ��VI�m�
gK>dX��?|e��-_	]o$nH�k����u��®��mA���l�}0��LdYL��ڏ/I}��aCs[��G�L�.�V��^����~���qgfZ=������V7K��_=�C�/�l
;G,���߄����(�-�~�x2�Ɛ����eg�\���ٽ�c�e���/��W��pm��z�b�����L��g��ĚFG�&����7|�k���?~jq~�Yvy�P�̾����s�xY����D�K�їZ.�=���0}s�`kq�rx�ܬ��3q���AS�.Z�k6�w��n�����//^5���K�n֎y������d=�@��G����4�<���C֋�����q�Kf�{s1����y}s��z�ze���#�'/F\sh(X�s{���>�2:�x���;�V�n|ϛ;"`��WÚ��Xl�tL�^9Kۙ�J4d�-7OT��y�S���>G����
����T�6��������6�΄��b��<x�Y��ks�\=l��M�׻U�;��i�J�VM2���$��z�ѥ}]n�������W���؝M�7?i��H�� �c������[���)��ͪ�W/�<~��Dq��|Ņ�s�G�9\�z���骪J�|�}�����&M�0�nťC�A�7V]͟t��e���[�m��]�lcb�а���vن]]=����u��a�O�;qC�ɻ�)^$�X��i��z޷�:���Mכ.�p��K.Wg�^� h���xe�چ6��4�SL�u�'mZ7D�8�0�Zʷ�������[��6^�nj@����ڷt�3������ρ�I�To�;�$��te��k�9q��:|��֓���'%OZw����M{ƈ��<�i��ﱥmgͷ�^��Q9<\}�V�E¬��7QQ�'����u��I���|]��d����OT4�����|&�+�����g���v٦���51K�k���fU���[�f\�ߜ�rg��i&SK�~/~_����ϛ����Q��͘4�uŭ�|s؃Ӟ���pvۃ)�d��%N��D��I˰m�Ηm�/_�a,Xb�|O��7Ff'�������+*V���_{p�����oz�����ȗ���+����s@���z���w��V�Z������ՙ#X�Y��e/��'�pO�������
�����Te(�_��^}Y=�a�\Nƾʈ>^�n�b'8���3xP���66`<i%�]蛽�Y^Vn�Kﻶ��'pL�gu�7����a��Q~�����v���3[�-hj����q��M�LI:6.�HÖn����]֙���}���˧��?9vCX=Gy�����ƌ,˰���Ry��]�ST�B�Ǟ�m�_h�$}�����a=OW�pvv~h���T���mN�9W�qBɖ쎜F����;^V���[P�N�-c�$���߿���t�}��6���|������4�<3��+��;b���+y�����g��lǌ�uXur�ut��OI��O�=���(RgrJ>&)����u�8����ˬ����l6q,�Ӡ���&K�o����.�����C�zC~a��G������E���7�{iՙ˅E�O4:iY��t���Ri�M۷Wq�-�h�y��UZ��0�ԑ�
��6�8�gǃ�9��1�~y#�������7�R��֘Y�[��
l=1*�^��Ϟ�kA��wǸ��rv+�k9iV����%���M�3pȐ�k���6�kjw�br��i��.�����A�78�kt����U�f��r��ۗk9sr��[ӊ5�͇�(��]�)k�z�7����n��I�7Zw��6��N��������5a܃g�~���5�"'�	����|溄������1yCI�x��������O��;ۦjyȐ�6>�c�������������+�dݫX�Ǒ>��v�z��}�r��S��w������D���]o1��/��-�v7a���;��u��{٨{��o������Q��M�����n]�1Gqmm�2v���wY�M��6����s߾)Ηt�j7�#)���ʙ���>���J�mC�ڝ%�=�#�����J9dĒ�GR��lo��{�cw��'q_o[�����s�=>�Ȳ�]l�'����+������[E�������ٍ���[���5�M���qQ�۾�~�h�	��ɯc�F�]z`{� ���KcN|�=�c_NΑ��O�V�쟣Cn4\��|ܴ�YM������|T��Ys>Ϛ�u��٧�Z5��cmI�����\=v=}?���5�>3��I�b�N�8�m��?�?��;��z�cX�����p����G��f����eN�M{�V+�N�o٧ޑ��aC�?1��`�:�xWO��������*#����/6{�<赾�Q�3���gF�KL�M�����Q���^-6��[8�`I�l׷����|V�w��}�.�����B~�8��s6m�z���#����;��s~������t,]���w?�_��{��fέ��fY�zp8�ɛG������m��,-��x���{7���+䬼��{e�M�~���)o�aƷ�����^��x��c���G�^��|X��o��Q�9��wm�t�c3���OGJuoׯ�3g�ӗ	/;���Z�4����w����ӧ_��&{�8�������nν��?c�zA�}*y��TV⣍��׭Z��=�`�Vsn���c���>�.�ͪ��oｐ���ię�N�<~S=g��{���nϰ�5?�ߚ�_&��������s�ߵj�������&�]��?/*����E}b���At�Ǿ1�	��9���Tj�:��nk�=d�ۋP�$�{�ՄO��s�5�J���R<����8��a+�_Ҥ�����_�Ưs���:����k�>1G��}-�P�����O��^�[y��J��6��z1]�ŝܵ�{-Fl|���dN֚�c���y�U�K/�_����:��.�W/~�����	�}�{_?�^Ұ�yb�`i���y�cz~��0�o���?�gxri�>�E��*�ô�x˳i�XK{���h.�㧇�\�m��9=�dȑ>9ݯ�׷����͂��1�1��e勘Q��ϊ��Go��m�G�����2zއGD�#nߺZmu>2�}��W��M�o~cP�+�nk;��լ��n��N��m�#ϟf��ח��?~z~��e�d��?���y�Nt�٫7�����t�9�eE&;�oq|:u�s������v�u�٩���V��7"'L�r��Z��x����M���(Z�����]^o�rҒM>����ot/��K�\�����?G���ię!S:MyrX���ͷ�|�U\��*�g̝p���ۿR�(�qX{�0ǅ'8S�~�xn��bO���.��&z�E����3|{�}Y�V�ܰ��E��9�ws�|���ƙ����ڵ��C֌�+�5��/y��m��{
�g�?9��F��.�tÆi�G��3ޑ8~
��r�Y�M7���v�s�Of��Q��i�y�����N�B���j��{��[�6ybP,14�z��/I��m�JMfL:{{i�����1%�7}V8y}^{wI��v{.�_�*�Ve4鷴uz|�sK��wj�*p�~A'e����V�[F�v���f��x�2 /N���T󏯪J���Z��P�q�;�:^p=5f�S�º�?&4��q�����F&�!R��������Ԟ�ͯ^6kЂˢ3�no<W�/�s�ӈ?ھmpУіH��N�6�n���m�v�[RÛ<�ڱg�4�zNZ���
�ڦ��;�]8Q�;>4�T�-�i�"~ѽ7��WΈ�	<v��"��*�mȉR���~�b��+R=.�o~cҎmCN�T��x�Y������m�'�&M���UueQ���#��6P"�8��Y������7���p�����hs;�����yn]�=N����ĎB���eV�|V��/9u��u���ئ�U�3�_ԗ�M?5��Z��7�D�z�����)��1��5����ν��~�9MS���0�tE�����th�h�Yo!�e/E�̔҉:9*���ۮݺE����r{�O�::�,�)���ozxg��U�M�ɍ&�y�(/�k�|�����{��1&.����B���6����BV&<������9�6w��P��qV�yKf:��(�R�쒟Lq�ej�ْ�1�3;�6;+:;0N�3ŵ��K�n[���gr�2�~���}�����N�*�5g2}����~ʀ��K�^�v7�y��d�o[o�X����_�������!&���=���=����|xh���Y�`�j��i��f���Z����r���1������%E6s�)Xi��:�%$��8��sG�����Q�Q��H�'����ø���C��b��Sr�nY��q�S+���L����.��=T<te�W���˽e�W����w������Z����{���;זDH%�b���);vsd�g����~ϸ�8�3�{��99+g��:]:(��EA	'�//q��t�VW����h)g.-�{?&���r�b��e�S)ަ�q��Y?���C1���[��t�ݿ��*ڗ���sMl�~h�햏-ߚ�����ѳ���m{0g��Mj!g��A��Cv2���=$�t�g�QD�z��v��O�><�y�-n/�^{��kW�΀����4����L~��Ճ+�	y8/12*uc��g:**����x9 ��)��`��+�E��'��6������U+>���cˍ��$�%��鍹N��L���ԛ�-�r+m~���NF���<�k�W��.�����w��>�?�0����f��_y�*huu#kX�9�Ȼkf��������(�֮S��^�S8��D�*ͽ�y��N�-�x�ȿ��pL;+�߶��`v%�����}���{[�%.\vL��r��W����z�i�D���\[�_PPR(oZ���4w��I%���]oX��p���=�_6Rv>�jm��+�\�y�x�ÓgyΊfv�ܺ(0�`�3=>e��h��pcۘ�Ğ��̹���#�N���~��<0qXS&�ާݠ',�aޡ%;7^=|���s���&�q{,��zt�è��]���]<�gͻ��������f������^��ޖ?���e���7�'�\�~�͋�>�A�����vK�;D�y����k��l.;��X���)m��eD�/i3��5���-�����d�~�SS#�zer�2�q�7|y�^�O�7�q�ə#�?-�v�L><����=eY�#-ݕ.��r�4������1��~'����qP�ׇo��socZ��qCc���3�:ic6��޹=��m�#Yql�(ʡ0����z"�AYS���a��xÑW�n�d�f��f}B���exp��`;���&������1�D%�h9���>�m:侓�?b�RZ
όr���hE�UՌ�&%�ZsB�7�#�b^./�h�miўsel�.)9���U�!��9����W�՝Y��t�Ҭ��	)����r�u���uċ�;�����}�̰G+>��)�y�n�"���6ֱ�9�1KS��O�uK���-^�(�X�oָux�����s�:`�m�j�#5����s����R_\8�������4h,=t�a�ؕmT�#ݚ�l~���qp��+4:����p�z~�ߛ��*m�����2�jո��E�D[Q��HW[�����LyW������Y�ag��ݦ���r�g���Q���ý����_r_���$��[�����JPb��W>����m��eK�J$���_ڐ�Ǹ�����g[mic;w���k�o\0��]����g0;o�2�$��&pZݿݔ�-�_��=/pE�aǏgL��7���Rm|��cT�%_F�8��y�ak'������^��'c��u�{��nM>�y��v�՞��g�k�5�8�·t��Q�������8�k-f�_�	�,d=0>{H�Ϊ��S��d�Yf8�U>���Lش���v2�ܚ�쏨��v�S�ZMyk|�u��zIAp���?<�_������֦��A�7������'ۘ���X%�W&o��g��-�TO6v����[+׺9\_t�S�U�����U�`�]he�����1�w��zU�S�8�V���T��T]��]�25�zʪ�Sg�l��p���¥����֬�)�mpl�]�.UW�y��;}��K����7�Gm)$q?z�*�zB�D�i�~&)��%��ľi;2v��<�5�Z�杹2/̬Y�t�	��]R�~����?���p�"q��Qe!;GO���mu��<��O9_l�/�;�Q]�s��i'�V0=�Pğ;y�k͸I;+D�N���m�:s�`��ٳ7w���L�(�ٺ!�[��yo#c�|#�/ooQ9����<���~�Ϗ��0�U�k��Y��sM��<b�ޜzl�Cüp�m.�k��:�("`P��ͬ��*3�쫚t���޹灲��~�«�'N��'׳�A�+�V!cK2��ƞ��)�Ƹ��6��>�a�k��s�����9��:�<2�����8�f�@zxH��~IDxȣ��_��R�wݦo�������?�!�X�[U~ݮ���U)�%��\j55cI��9����b�b;����������FӾ1E���W��qL��eߘǰ�^�:+"��rMx�\����QCKטL��֡^z˓#�G��W�h��AȢ�̲�ݎx��a�4�h[�qv��i���oӢ�o��z��<�έt�����-+�D�ukФq�U�Ù֝�Z=���ɭ�Ov��q�h�Q�|���"���/��6RT�{hC�]޾!!��Cov`>��k���[rts{'��ʝ&�Uٞ;� ��MPjB��G��n�AR��;�=VXI,=�u����J1�����,��>+���n����D��9��:6���l��j�p�Ȯ�x��V�9���b�n�����1X%za;��Q�^���D�df��F��_$��*1��o5i��%a��`��!|Sf�W�͖�߮�}<w�iuF��3S��G�����?�<��t���Z,��[����T��š�9�G��$�����i����B۴����f�\W=��xD�`X���y���ѕ�uۤ�oe$вn�Uy�{k�z���8i؍M����T��:�r���s�n�����}g�����hz٦�̜�F';���(Yk�p��ѧ������j\i�Fq�l�֢��}i`Y���`�����9s���%��\�0s��ޥ����[c������辁�̍<��6�r���_6�������Nk�{B�8�f��V��;2�q���>Ϗ��Ba˴9'�+�,�gl=d7���k�c�Z_m���^Yp8ڑ��0`�Цs�6	3o�i��ţ*<z˃s|[����l�k^��Y-Ä;���Zc�~���a��\Z�j�k����^]�.o�6+�|2^�Xb�7u��h�o��"�~��|e8�iʊ�>a��k�a���3>��rav=ӈ���5v�>����P}w��9'/~�����=di��)�m~'x��>���t��ʤ��a��T�y�zn\��O�cz�5��r{ۇ����h}�ބ�	���a'�<�cz}�QdZIެ��h�p��	��{�|X�a���Y3}�����ٿY�V��?�fl��`�Ot��m��u���]W'�c���Y�����[��Ђ��U��.m�Ø�ʽ��W�(;��6�ŢV^�;Ym�ȋ�[O���Fx��z@�0�L�&(6��\3jNjy|��e�.�Jv���]2!w꧔|ö�Z9;��n(_�̞f,�lR��lѲ����-Vfsfu}�S�=T؅Ѩ���}M�Ī�T�Z�^�����Â����*��N�t�o��ޓ�T��o�.9��U=�L���or{��]���-�ݹ��`ϼT��������J���o�i�H�}�M�0oŠ�{km���/&ew��uw��{��ǿ�N���=t̄z��8����`�t������V�x��X<���p��`��+����ˆs�������H��-�K���ē��7����:���`�Ң�㜟�|����b�R����+�W�l�x]X�M=p�!��jksC�EH�U���9[:���?��<6}rTP�����l�Q�B���m�=���?6ǣ��q���m������yH�|[zM3^���ʭ皗�mW�o���A�׬ă��v�;��4�k�ͻ�j��|���m�p�ȳ�B��c��=r�9�C^lm1�`QQ�KK���Z��R�ۻ�.��e��^�rCV5��x賫IǷ�β2]o�o�֛�O��,ٯ��Nc�=4�뉳v��F�_l}�x�a�˭�1_�?yϦ�%Kj��q�jƊ��N#G$Z���ذ[[rXa#��V�_y� �}�w�Ɲ~�����r#I���E-�H"l��W6Fb��#���x��r7��#�7���3٬�Q��j�¿m��+U� @��A�\hy�{��a%x�$/�T�$"H���ɓ�@���5V�;`����ł�D.��,1�R��W�8�g��Ov�LH�ptE�!�1TP[�>����⑈،��R�e���}A���J(�&�E	2a8�V�t���,��N_�a�dDKG�ۮ�n�fǝ�T�����fpd��L�4)56i��rl�v��Ϫf5�⻛��eV(`�9�p�4L�H�M�) ���a���l:lD��gAY�[n,� 0:��)������U!�T��(a��g,�T�J�?�n	=(B=�4c6~n�c*mT���ZAFJ�] ��x�r���wt�>�
���o���>0h�ov�7��H�݃�P��UX翣0��j�T$$qp��`�#�RK�d�(������Nl�n�5�I�@{��=�I�*�6c�ͭ�l�*D'�{N1;�
�J�� ��(��0���4���]�����E�+�����ºmNƔDif� �XZ<���D��:1Ŋn౹���\m�Y�<).�9�N�]R����r\�0�BU�V!���j�����*ypD���4���˲r��K"�_Դ�m�8[���E��!�����s��j�LŊ�%��ERcn�yL�&�`��g��LD�܃���n��,J�F�|�ڕ�?�y'�k�$�n�'�"%T9d,�GQ�fǥ�Vm��J7��[F�aq���NX���2�������E��psɲ?S/̉;c���+�=����6�R����%��J��/��L��;�L�ga2���U�>2|Hg�;������ԡ�0���(�_�`�A8&�N7�����Y��'GޑC�!�� �W_DH�[��!���<1��n4����t����T�8Q B|�G
U�bK.��	㶚��B->fآԖ��K�T3�,+ p(Nz��<=Y��%��e�����=��dK�}����Y>M���mG��]{�b��� "�)���zPV�8��F�:%)Ʀd�H�$���_�V�z!8�@;٘E</�G,a�D���SX�+0�H�6�Kp��b fH��(���m��Ӽh�L�?mk��F�ܤ�"JX~%�%R����L[Qd<��gbt6 �`���� �%��Xa	y�h�_]�Z��0��2q}�����_u�J��nmM�����2a�*�R�flJ&s,1���P'0��1nd
)�E7�4��LJ�e�`*ӻ��2	o��8D\�J�|t���B��Ӄ[DHIs�R<��l �5��g�a�p��bN���1��X�/S-&�d+�����~T��aa��ֹ	bip��m��i]ڷ�gt�6,�y�d'�Z�Ю�)ALeUH���Tb�b��S�̘9�!u�`�c�eX������=�=5�L���Ǵ#�JX�PK��^���{�5FǙ�G?�̐���4�A��Ĝ}�YL�d��Զ]��s��E.2j�.ӗlr� vo5e�AFLP�z7W���,`�XJ/�	na�!���H�]wZRb�e���!�E��>�y�? ~�h��9�Y41����D.���&�A�&�Ƭ.JԷ�Ø7<;f*�U
��R�Q��X�0-v�M3�4#�H,�h첻���V87����Lc��P[��Ć)2�����̢͆Ú4��QӞ�8�#��"4��ҿ̔?�a!�BSQ3�RR	�]�H�36�Cp
u���We�6@�o�V�	��p���ml��M	f!�t2�9m ���A
��C�\��/I}��p8���̓�5�~g4%��Ґ�Ru#��.�&�)wЈ���AM��cf:I1�+J���L߁�c���̴��U�d)]�v�5������+Ò�"rl��I8��jpq��|�aJC�c$��� �P������"S{�xڟc�nɯǽ�@<H�R�u��у���S��E�<�vq�ƞA%n7X�r�l)Vh��e�Q��j)�!]QgYtX_B����fەw�[Bč��݆��e�: 
]��n�JxF@ɶH��N|�lD�	 ��	˲#�0��T#S�=r�Y�1�a`�"Yz
u�i�*�"�0p�a�t����� mi����m��F�!�ʄ���f {�S��"=�~�l�!X��7�H>Տ�7��3��j7C/c|�5�`�~�U'r"�|!5ŵ�d���s �HR���;�Fz�Nu��^!Ɉc���(fx�1����x�
��Ze<�Ĵ$�%�B��R�U��������Phӫ���!�x1�%��$QO�D'�J�+V0}n��t,�g��	�۴��c���i����ff��CELe;�<c$`��Z�~Hp�&����j��3U;�_Qcq-�m���)U%3�{�	�A��MxO8V��"�����H%W�W�۽���tg���y ���6==���:�a.�p��: ��@,�B��XP��n��J�I~�i��S➙nfw�JDw|@&;�&d�iKv�mvT��'g�)R��ه&=ꎔ�.�GDЬdˍ�:�ֱ1��-��IWnNJRzLj�v7(

� R$apu߯�[�,��8����`�L��L?�2�%C��"vo���,����x��x����Nٍ݇.���:���>O���Y`\!�>m�r��g���n&Qg�'�tY8��`�
�����3�>aXJL��+�.,G`�� ^C�B�Q ͈&�a�P��<��[Z���,#�2-�p��l�����H���� ��|�$���v�4��q؍
v	���*��U�سBn9Rj ��
�@�X�H�`11� 5��a�ܬ�Ơ6��4�du�#ˑ�a�g'��K��Ym$锔�K��-���9�fܖ_����	$Uފ'I���yc���R`AT*iG��]_���C0y�	 ���+H�ÜU�Rcp
���� ��<]&�4"����%ds����>C�Da��4T'�fV�.��]�F�Y��.���L�,+�@.)��'8St��1�����I9��(|(J=��7eއ5�ۊ�6�M��&
��؉qVTF$�a@�@s� W�-ad���J��icg�Q8Ӕ����	IdM���oa̋��hB�0}R"�Y8j�9���i~I"�c� D�yݔ̖h�)��+<6�3��i/,4��eVd�م9`�F�o1)�J������2Գ�j
3����/�����b�^;ٮ�M�֢Y�u�6M�
Q�\�U����l�k{��{h�a �Y~�Z�?6�o6���jHLT����g��S��N�6� ؚH��4� C&[����
V�{֘���
#�8�a��jΌK�	~kހ��0�
;�ꬕ�
��-�Y��ng�rgñ\9SܲM�F�y��N!��E���b���i�	�h@�:�mo�%'KJ9��.��i��5LȥD�y;�q��$��l��� ������%3��\;?��?1"3��r���L �S�7z�t�X�=�z� R�%���.�MaƢP89�B,���,� �n��n�T�΄O2�m�f����r���GN�]����T��"J��mAy�}Z[�<gd{���6�a7�p�:y�N:��>
���I@��6��J�,jf���f��䦔@� w*$���;�;����0��#����E����l�GO<Qn�P�u�������4#�Q�M1lF@��| H���_.�#�� x�r�@���a����h��T����
C�i���� ��������3���$���H���L5ʗs޲����*Z�j���۳��P:�Y�1�*��<,��R�Y������c�-)��w��N%��N�"Ƹ&�̚�,�jsU'*�2��ȿ��,�TBY@�{�ɡ�J0��U�KV��B��b�u�Vae�Vn\����(�c�����R�:����!�0\�'�I�	��N�}�D'�m���������5%-I���h�a[�����َkLOhQ�l�B�U��n����i)Fܧe�i�e�I��Z�|q`�F5�[hǯ�3> ��i83��s���4�99�[�:��1��W�@m��2"}Ü���I>�9B���i,�șs�y�E̾�6
pۮ��Xp��Rݬ�othY	�)e�˨� Ά��/BW�����(�e7��K��I{p��.s%J�Y�� &��sd$Y���>��������rH�|R�yB!.�I�4�M \������M��M�n�Ē�7�-u��' #�f'ҙ~�J����k�*���,GVp�v�EEKv[/�&8+ɡ3ά�î2$']0u� �+���p�t�Y�!�r��|�	W�k�.�h,_�&_��29O��VΨ�C�
>e��d��4&��"����Ǚ�
+�Bsq� �ˁX�Y��I��YמؽL����B���:���XUXv��'+��b�="dƜ�<�&+xe/��T0GY?��X��e݂�(�P�S<���61ʱ��"���J�1�1������:��΂D1V�R����m���e�`r�� �v��Z�\�7`�l�Π��~�E��0�+���XW�<q��e�45.P��q���RL�W�6Pg_�I�i`BuFJ|NI������ʟ)��@ S���fno#�IaB"�Ư��τ+�(���{:E�Q���}~��buݨޭy�L��б�[,�p����m_1�� �n��{*9��)��ͮA����T���>x�4����#^�)꼱Ű�V�ͤ��5�2�����C��Ľ^��p8����o����ȍ���(9f^G=��7	*#�)ӣKwR��	B�V��Q-�Ѫ�I�ؘ���y�VmB�"�HQ�`�i�Cm��3�8ZZ�p�h�Q*�o��%<��V��O�춒�������J�
R��o�BR`�<
�v�nP�¨�W¥��@"q���ݑ�a�D��%��p�PD��RӂD�'* ��(����Jo��ى��WZ�U���7R���oVb�p��:�(wL>Mg�!���jb&�:\jH����z��M	Sȯa����Ѡ�j�\'���q��6��$�44�ʅ�JZP^�%?�,۝N9;�V�V�b*����i�9���O��fL���
qE�'�s��I���{D��*�N��c�7~��tn���)�s�G%���fٹ�9I�U�E6_�V�ENzYC���Y{��,V��E��2�;w���va��5�Y�z��&�K���2;��*�)A}�2* 5�
2<�*���69ծ0�"�4b
Hf�t*�y��^��W�d�ۮH"��6ISHS���t�r1H13���Q[꫸ �f���9bud>������vfx�X+��(���Q�U���L�jA�%�m^�rYf�9��Α�=�H�if}lQzZ
��&�"��`����"
��I1��Ȭ�+
�H -�WA��,KI�m��D��%|.0vq0��J�ٓI�`��zhx��K�慦yPT���;�wAM��CPS;U+	��:7����������2�(\�Τ:�c|�o�U��d�ai\�ZЂ[��$ә��S�0"�����xMU@�T���B"�ׄM�h�ZE�?���dM�SP	�x���	.lF���Ź��+�)��G�p�T����Z���ʅ�G��=�M7cS��cq:V�Vg�b��n�⋑h�0�ڰ�zY��f`:	�I��b� 9�Q�[!9N�+Q80TqO)�����"O3hK��@�ǚ��A�$R�#���8�V�	�����<'�
(�U)xi�_�E�Yb>g+	5���%��t3�(in�j���8���%��xuӵ$;�$2|�N���7�,�L���;�,N�Ҿ~ӽ�J���YLx`�+�,�3�O5�yD��G0�C\�6O��l��)�J>?���	�bk�y�ԉ�.Ŵ�ݖ׽�L��Da��i"��C�emn?�����7�m�:d c$f��؄� ���q��)��LS�홓����六�r��U��#���Ƞ7s�������1���)�3�}H���T��3l��l�̳�0����̴|1E��[��o�Dq�󚾡�}s,����A0��7t^�@\-3�P<S�{bX�^Re.�K@�H7��SAK��q�䗷�8��3*~��*<QK<+&.nױwW��=�Pv�@�LS㱝Y�&d�RB*&���_W�|�&��5?|$�E,�&8Q<�,;S�9/�٫��`F��e�{)�Ђ�w�z��(�T(K��gr��%2��B9�<��SS�Vc����:��$�.�U��^|!��nL�d
�ۓ�((QǼB��d%�W+r����=X�[2o���S�,m�V�ߴ�L�%ؠ�x����v����I��'��w/%�GM��E�2[y�(��`#���1��to,�s��>��!��1�3�E�>��Ѣ�y��g-�^/2nJ�D��x�$H��a�3�)̗1��m�3	�ܰʨ�< 5�a�/�E8����/�L.�9�B4S�Y獮\I	�rq�.^�����{��uJ	�IM�;��'�+w��-���	!{D"�,G��n$�n��L���	�]'F�������1_�.�b�?��I��ѵ�v�6(fv7{�"<A3�x{e�ԩ:�g���!x���ǡ3�Lq�}9����)6�w%4��!l~���ꖹ�j;��س%����+���m�Ca��æ($�Kxk�'@�)2\H3`\�4'hY<�6h/�d̮8�Lg�4�'�37���V�4���䪦����)��&| 765�i����[��ړ[j�[��ڦ	����y������S]5��V����oN:����E�<��^n��'{�k��*�੗'7yZ<�ch���)M�1c[��u5�M�\��:ʍUM-��f�c������j�]�dO�؆�x�a42E﩯q˵���Ʀ��f  ��L �kᡧ����`qˣ`�����+�f-n	g�m���?���z,�Y5�S�|�k�F{Z�a
�]������Ijlmjlh�͑
a@x��y�+����Ze؅1&T�W��\�5K�M�\yJC+�Xw]�)��Z��vtmu�gR�[�4ͭj9��[`P���N���x����͵M�<Մ����*Ob����	Gi�gdT�Ò�̀G��Zf�)�v�Gk}b��vb+��DvR	�_5���m�	i� ��3	Cf��.��"�)@b��h�N8���j�4Kv� �-��Հ��x� ���VS5�jLm��2pN��e�-77�V{�x�P�PU�kŭ�/� r�1�����Qj���X/�����fZs'�\�Ќ(�T�T�1|����M���(:cU�խMpް� h�[�z��n�z�{�j$qȈnGWy�Z�	gn �D���`-���n��SU���&;��y,lŨZhVU3�CǑ�@z8N`u4�#����n|%�I��I�T����`z�lt��~o�`������Ա����*��f΅ct]��K��]��.��g
*I��6;�c�uv/�̦w$�������T8����k�Z�{
��M�Iw���NDXםY4)�L����O,����9�����NU�"���"R˧�ȫe�`�"H��>dtYo%����<B���N���:��č���n1b��&�u�G�L�q1-&9_���!z�&�F��$�/�oV5�K�6/I�17&U+�h���ꔩ���@��%�KC���!�4*vۂ��li��}-�㍘�_ܛi�j�,JL#�����{��od��L�ƅ�2w����:�_�sq��+��uSN\���_�x��?à�D|hoTSAQ��D�A�3�W%ZVfu�\�WP$�(Q�t-�5�"[ñ���k�{�ń�#�P�@�.�c�p���Oz��-��$���>�ne:o�f%4i`��|eUF��2B�ȊѢ*�4BS�0��b�K�<-�n[%*\��t��l�[�*3 q�]��"r��cQ,
�vr6��	u����l%�,\2+hTyxG,1�ss���r���=ڞ+�<rG DU����m�%M�x���f��Z��ߋ�a���Q"����Ȉ�����A���-��xɊ���$~6����*��acT��9��ł5���p>�ݝ�$�c��	�U���Z[j���
�K��r�s��+�6\�9�$�n5��0?��X���w�M�A�}:_��9:�:�#�]��l�tP�G0��9݉���/6;뿦qo�rC��3�m�H1�"�c�
a�Vpa>��c;�om ���Z�]�9x��.3M��L���YI��p��nL`��i��~j4�R�М��ޮFA.,x�
~	*�T:��7��cA�����9��"�2�����m��v8��p,�t��6{q0��b��"�{���v7�ƐL���T�k����:V��q��$l0�L�Dt\�{�֌<4�nG��>��_���%r�x:��[� B�0�+�Λ�YA��O��:t��������f/�:������H0�#
���H�:�L��A=�D�TÝ�c&�fd�#���X(�Q!�w���"S)[]rdW.+	׆rN3���Be�@�W��$3K>��D{P�X�U0-  g�_m�l`,F��<K��� �� m�He�w�0�s=�j�X���[�q�p�dk:uZ�4ς� ���~�YA� Tn��C1���������e
|x�[��pz� �ZVq�����_���^����c:�g�f���Y�����3@���iɘ�`@��l>KĊ��q����軁<Nz\�w@G�{����A��� �c��SY����Y�%�#�M�v�8D�ݡS�7nR���#V>��چx2��W0��/�_��
♉s�T�M�v���氻B������K�e�� �Ԇ��ڦ���mni�P�@M@QY)g��mɐ������L�̘��O�cݐ+"$F��g鶆uǧ�y�H9#�ܨtۼ�����`vh�t�ayĄN����� S�9X5��X�"�<B
�܆l���[K4[��g�Wi1f>��J)c�ciIژ�cL����
ƕ'�f�t��0���fI��ْYʮg�&�8�	 1;��@��Ng�X9:mc�������J9B>����eJc�L��K� �ܺҥ�]�����Cj���B�t����.s�!P�.�bb�K$�W��4��үb��l����
��n����<1TL��Tp��Q��&(a��,�e�Y[ʢ���J���F��¼Q5 �����ab��-	,_z�i�6���+�<!�NF�ZVuiT�ǟ��:`m�.aVN������qe8ծFǨMWV��5{2QL������l'q�1l�	p�s�j<�rh;sīs*��pXu%���Q{�����sq{�y��U���J���.��}3F�r"�$��t��_�ߘ�F)��~��T�,4�|�ۜ��I�oɜ%=�gd�"��M�
��ǟ�ap��ꔞ%�`5`L�]�]ǜ�q�#�hx�bl˄:+c8Oe��+]�lb��s����%,�)PPc�8�N�2�mU��e��.y�̔��&O���s���J�����L~����JFt�.����'l;���5���ɴ�]����cҶA>��=�t��,,�b� �!{�!�ΎU3yʻ�$��e�e���V��C6�=6�ˑ��x��D��`�ZП���{�K�,�{����+���\�\���n.��Z'�_����[,�=�#�<�Z�GR�~� l�q��v�wAB�=����.�a��t��Y�cD^ҝC15?���gJ�U~?�$�[]IPW�\=��=�og�#�X���@�J�� mgsak6�ȩ49�^&QP�Ⲡ)H��k5P=.V�҅긋�����ЕZ�!��tuh~?(�\_T���Ƀ�J��t�,�6��b�������'.B[�H,�׻�lo<C79�jĽ!-f����/ۈӭE;ٲn�[�8޳��t��|�m������X��n�朁0d��pK��m3����POt��J(�iw+�pČ`~@#�\�z�@YI�+�'�;�`�|�a�n��{,�AoE*p��R�m3�;�6z�{G�9�9������ݑL���S�,�[g�!���X�^����c����?t4�DV�Q�K�q�������ώF����u>�5�=>$��wH�����[v;��'�Tw������@Y��H�9��h؃vv盛���e_��8���5�J�ca���4���R��R��[*�or2�+�#��	��4	����r��*V��P�F6П`��������<�go���Ϳ��of{��}zP���'��������� rL� !��fA�r�,//2�9i��2	s竡���17�}t^�y�����,��곳�ůw��_>L(G۽Jf�[����g�
�n���C����v��G��pf{uؗ����5�����w�8���D�\��z����1�M�)���T1�d0,����,'��~>"-����K,Z�ud�Ȼ�	�Y�����޹/��K>�G]�Il
���J����������X���:�u�[�pP��l�&�Sq�������j��'�L?�R��/P���Oմ�L)�͛�;_-U����j���J���[�S� �ș��0ep������D�ٰ�!�y�ڕ���Ӝb�Sm�z����U��r����8->�o�T�8����]A���8#KsN�͌1]*[\�&2-��l����t⡰��)�Eu8��Vws��(~���~L�AgD�5���٠�@��ƍh�W��N���a�l3�����Y,��j٬���WW� ��&7Wn���m�7l��\�zcC��F RƲ��5��iխ�<�D��%�\��*$)w�TM�zV��K6���%�0MZT���/��Ґ\iP,���E�۠�@�a�9rF.Lچ��e���6K�c6%�9R�@f.Kh&���aWZZj��#�k9x
/@��%6@��]^'y���V��t�1EO�Gpd��&���tk�fL�	0:�Ӹ�:P����c�hyn.]��WS�C�;�8�mp��h<Ӆ���,;���1���T�1H�T���@�P�bTm�zh`�u�c�i��L3B	ۉ����6%e�&l#�!b)p������>%��X)���gfi����Vյ�U7Lh���6�L��&{��|�����8~��4������)�Q�2�"��c�AQ)�SGڡ~L�͡�iV��|7��l�B�w���_2F��e��BzX��7��$0c�����+��	�`D���]���HK���*���Xo=��x0��"S`�Z;+T+�7��Z��6�HQ�j5�Y$��_���M1]�#~߀� K{�s�k��7T��V�+�q�n���f�%Ǧ��z$��f�b�Ƿ�⥒4c��btH�dq��+�"ͅ���D�8]'�^�b=��5���|!�/��0hC�VWϿ��`��҃n��=Mb��9Җ+�l���?�/E���Q��7L�N�����{��ғl_&�i���	fU��ݦg .OUO�&��h\�m݃�k ���խMM��-mU�m���z�G7�sS�_;E����P�Sq`��h��5��e���x��ڲHT��9��4�����=�Pc̀���L�"1%��a^?���!`|��\�ŋ��9��O�"��Fu�� E8|t�I��ԍ�o}��إ!Բ�Ii�O��Ӥ�*�<���ވ�KW)�I����J��ҁ^�2T�	�����^��Yk6����k��W�R��-�N|S�m̩���8f�m�~�S:�>��{��������5V�۴��xk��-�:�ׅ[����l�y��Y��M^�}��;�vM����A�Ǝ��R߅r�!�:�ꁾg��J�:inը�&�y��=�����?z�?n������n�c�����O·��<i��qǜ�J�~��_�?�',iزzmǪ#뗮�y��5��=f���N�����w�]��W�^~�7�?�֯t�[��nX]���a��"����{���G�t��<E�&�xQ��?�������/��q�Cr�>��O�t��������g�{���>�1z�)�g�|��ww<2'��\=풵r��ߌ�n]�ܕC��2��������}ܹ7}Ր��y+������^y���;OX��U��}8뚟o[v�)�;[���?߶n�ag����;�Tt���曳_�yЄS�����O2ZΙ?�sW�#ѭ������W�8�'Vl>���ݛ/��e���-�=�9cゅ�w��l�M�-��f�%��oyh[������ʹ�k�����	c�Pߺ`��\ֹsV�\�R��Ւw��a~^��E��~��'˴S�-�鹼�'�w�j�y[o����KE�fʱg?]��=~}K���3�������e���{���v�m?qmw�5K����yѭ������vj��d�Mo��}m���|��ONx�Gϳ<#�9�żc/��eC�<�&���<�0�������Ŵ'y���]?���Wo�<��g��3��g�>�gθ���WgG����蓎��|��:j��7t]������T5}��?/xj�k�o|ƨ�o�������4h��A����~�?~w��߶���C�����E?��{_f��ן{yj?����#�Z�U�2W�̌/�}��߳���k�G�pƆA�^4v��ʎ���#z����_V��菞�.��c��?�Y01��[����wN̟�׺'O���['�~�k��g���'���댧���|��C�WY|j������8�kJ�]�[��������؃g�sڇ�����Ͼ�z½�kF����.ݯ��w����Z|�2�������?,s{y��[k~{�����Vߢ�5^q���!�	�=��?&�^x|u��'\��I��Q����
o��ya��[��;F������4��w�Ak�޽��(�՞��~|"���%�W����8�}�+�������W}�_�c����}�(�����.j�i�>dr��K�N���ûF,y��o��}�e��j{�������GfT6��?v��5eK�]�՜��u͵�_T���I��~w��:��ε��U����Ǟx�Y�n����E��㇍?y�c%��S^<��U�����U��9�`��߂��gN�B�~���c���	�<lA����|���Лe�S����փ��ix՘Σ/y��/�s��<2�ps�4���Q�gN��׌�&4���sOgݵ�Y����=��T�`���N�g��ӏ�����������xp�O>r_=��7^������<��-ӟ�1������HƧ?�����ny��/�z�������~�����u����]Pq\���������˹��_Ժv����oK�r�����=��e�/|d�e�X*��>�+�q�c��-;g���/���%��9g��%���f=�����~c�[��^8��_gy��|u��}7\��ĥ������Ͼ���=�׷�)��{��>c޺yVa���\�8��������3{�M�-8�Ӿ�����9g�{5���3d����Y�5~�y�+�o]�蜊�?�Ť��y��E7�({o�u�N�}R�׵w^�(���K�yͤ˖���+gn��������n��ߜ��mW��˺���'���苪~�\|�c�2gƀS��u����+�{hٍ�_�w���M��wلc�~�������<d�E;���zx�kJ��w/��.z�Ѭ!�9��?yi��o��މ?�θf��?�w�Gۯ}��Ӧ|{����>+4���1�of��⭋'ͩ����y��M��_���.z�}�e�W)��;xÄ����X�qJۇG��~KE��3ǟ�yƁ��Ԍ�>eq�w�����~��z�w�.+���Y�]U��F���<w��El�a��QG̟�g��@�Ȗ�S{�u���z����]�]�Ɗ���������7~���6G�ѧ�5����_}��r��}m^��m�:p�e[�_�����6�|����Eۧ�qּ_'-�C�m���f���$�c�~q莦����|��w�-z�#��38�sу���s#��|͑Rࡹ?=�9���˯�g��=�ڜ����t����z��;�%�n�xws�y�:>��Ƚ�{T�M�q����qvS�W3�8�\����_�η����٧�v��3�}���O��XU|Ӊ]��;�r�YeK��z���>���l��ܧ'�5��cal�~a}�/-�]�zؒ��/}�������~<��'_�ϸSk��qx���t�Y|�k����uS�ܭm���گ[b�_e_�)�ވ�??z[�ot���>O^:�p틯��vפ�n[�S��)��~P�]\�~������������v�;yf\ro��~���Eon�b���_r���_�pк܆�O|=��[G�|hy����>yw7��X<$tx�s/Z�����e�~�g��=��s�W�^�9���m7��y���c����B�a�{�3�}z���?mĻ���v�>�8}����q���;�[��֝ߴ_y����9㳭]��'�s�7��4v��#ǭ��ٴB���.��~˫3�i�q~�]�_�f?�[��ʰ�-J~�ↅs�i~���G.y�ꚩ�7���s�K��n���.m�}Ӊ_|Ο�^�w」��O�������sAN�7o\0w�:#�{`���oZܳ`�yM�Ͻƛ�r�)Oo��A��%�����y�U�ִ||�v���X�캆���;��uI���NYݿ������/i���C��'����V{��_m��S�<�,�[9��5k�[��uw�1𗚵y��:�߹c>;��c������׽�M��>\���g7κ�����>��薑+֟�������o�a�I�ck-4��Υ��ҭܲ�����Ec댇�{��1?����<V��c��8���\ϯ3�,y�F��ڗ�^��OWߴ}����o��[Xw`_�������u�W�xܚ��K;6|p�K����x��˻���ݽ=sc`֣gn�~����u�^y�o��?��w�9���9�����(X��۳O0���m��7u���l��.�j��^5Z�oLV+�'��r�璢�_���k_ڹ�gFlx�f�6��owʲӿ�ql��r����?<c��-�/���_��Z��E��Ox�齏�~qU�������f���G�?���i�+溗��D���榽l������E�ά��}~���?�U]]3zڐ�x�{���̙>6��'��}��������'/;x��O���~`���=��Oz�چ����3��a������%W������ު���/혮nj�?�˓o�4��?OY��Z���sG�s������疕'�|w��D�?o��ȇ�f��Qy�4��x�	_�+���g��w\�y�w�s_����֝�zх�_7���K��������K��g�)xxľ�n9�&�{D��?��]z���/��Uͳ�;o�y�Ο�p��s�t�m�o����O��������a%Oy+���kJ_=b�S7}���}����_=��3�����yf�ʎ{��v�i�O��p�Q�{=xhA������~h>���矿��Ň=4祩/\}���eU�P��Y'i놬��)*�:��秝�����?��>��]z�^�{��������#��w}�`ô�����^���b�a{����ʉ����{���S/�����]��\��,7��oz���_�����ԛNɼ:������憣Oɿp�}N=:딌7��8g�>u�+��{�;phxj�ޭ�Ꜽ��e��|�	M��tU����]������+����??���>��S9������?���~���w�J������{J��<O��}��}���z���1c{o��h\0蝅g�9���_�6���|���\�I�*�����|�w��W�;�����;ꮟ{��T�׽���^�B���᯦o���{�#���ɫ�{���G%�����ȧ��+n;~Ω�E;�y�y��ϕ~\9~}���w�y�a��]~�!G>��]�u+���=�0�s�����h�0�����>������=w��l����~�j#r��C��p܉��;瓹������d�Я�f�����������O�>�~��g����[�a�E�<5��>�jy�_^[��3�v��w���î�:�_�����ۼ�ν��U��f>���� @�ڎ�\�}�k�~X���/{EJ�>0�󝫮QJ[��3ՏF����k�Q��y��ƫW��~Ϲ�����\w���WO��U�O?e��m�?��U񌪺[��{���~��ᷭ�6T���';��ݲ�I��)vv��#焎>i�^�&�<p�~d<��dA瀓g?����;����b�+��~8{�=RŦ��qw��_�w�C��8�xÌ��/�F��gw��Ϭz������8󣳾<�~�~x�'3Y�����KF��X����N���3�����ϭ�y�9�?�����>~ ��,O�ܯ'�y�=�x%�};�^9�w���6�X�=�t�����x���/�s��s���]E��&�u�mgd�D(\tfN�1�����@�7�����[nX��~�,��6����ox����Fz��x�����]���>/>���g�\>I}{G�>J��{}q�Q�u�_��2f�%]=����~z������ʢ�KV�q܉���rD�^�X��֎�w��׍.X��?���o�����7.*	�]{zV��������}�i�����앳��y�[��Ђ��o�k�6����^<=|�Uխ��~*}��O׿����>�쓷�/K�w<ܯ���oze��D���O?�w��S��W���ٽ������d������0�g���� 푍_�޷ꈦ�:ntq�3x˗�|uٝ��O�1�+煢���"�����\��!�Z���y�ׯ}�r@��a������^7>�Wx��[�͗��������G�U���}�>���/����{-�¶!,�'p�o���Ƒw1��M��qvl�_����c꾼���6���4I�~�]����O��xæ�����#_ع����>�����cN�{揥�����݌o�W��Ov���C�~���'�,��o��l��������[_wq�.�y�Gg��Woߟ���)���׿>�i���^V5���wn�����??3렒���u�1]��pb�#�M�p�'��.�:�����5�+j_ݷ`�}���=��a�%���v�<��ƟC]���x�G����Q�_�b����w�_U���۲�5 �xu�с%Ztlc�m۶m۶��c۶��c۶m�9�������ӝt�W��Z���'~�� �=����xw]q-�m�	�d�����g��fol�U/�l):z�v���DM�ԋ�Ta�G�3�.%-6�,����̎¹���hd{�pz}K/�3IT��z��7�ї>��4?�=a���X����ݬ,bd��)�첊�y���~B�6O��b5��g(�ݒ�N�L�	�E��M��9L�*Л%k݇<1�H��P+����`�����ݰm<O�����aySr}�Ɂ��o���j5�}^VBD�G���&�@p���W� 2m��L�mUT����p��[��5"#�F�T�~�x�i����k]Z�{���Z��)����q�	?�\�3�yJ��Y��U�*��y��>��{���Y	���\�k���<�|I55@3xQ��-�6&z�G'�j� �5��ob&����|�5腢?(�2UOjJ}�4$O������M�D�fHsӶ���<gy�6V�*l=Nd{h�x��N~)m|Ƕ�������|���4V���	�'�D�*�[��?+HQ�}�V�w���Z=p[]6����4l�"-��y�����`-	��#C��ڥ�Q�<9����S�R*���2rcЃ���
�H#x{HlO�?!�ُ�[��In��@�B��Id�S�j���& ݂_�.��`�'�d�������-ܔxD=��(	x`ϝ�3���y�\�1o	�U^�b��Ϗj�'��X�b�O�량h��{�Z����8�J�2TOAZu�H�/xk~<��D���(Uj�*�ߐ��(w���u����ɾ�J3�8c��e�e��+��-zKBHtՀ;eAL��1�8s��iMtj�w}�(K �I�z��
�����Df���<�&�m�p�^_w$�6���h�������.��<*,?k�N�XE}Ck���(��d����ǓtV �J���)I#|�sCP��iA]$�K~~әD��Ŋ��FR�|�2�Ǩ\pS�<�Ζf��|�ҭcK2t�g���m���!�x�����b�|�E6���ꣶ��Ͽ��X��V��c����L99q��BZ	p�V4���( a��gL�� ]�#��%8�A��T��}��RT.s��Q�H��J*؋/��V����P�M��הoE�w�V@���iwl�x�Ä�_��+�g�a�U�0�\i4��?�O����!��D�N� �<��F��W)r�A�ͧ)LVh�����r��J�Ld�3s;�����L�������3ɥ��6��m�E�ޫ��f���Y��j���ViX��[?��1:/���b����] ��v�_ ��{HЌ�}8f}ui/�z���R�<~�5�d�k�X:�,v@>�R�F�t��"q��ij���!��OӃ��دE5��d�A�=��nfjטW��:\g,2Zǆz�ZV���h�d���Cm`q�Ik� �:olD�C�Ū.N}cbW�:@���P@`ԙ8 Mt1��hF���8�=�H@'��3a�\�@0��n�9�Fr%c!4RbO1G̗5o+��uhc2Ŝ���L`��8]�(,[���D[<��t1�w|��P>�dR9�}2�mkΦ��}T��yg�TSYI;���@?S�d5(���S"T��G6v���z���OE4DX�V�Z���a�@�3�IphL��R��F+�S�k������A�����?�]�'U�y�Q
mvK2c�[=Z6yo�y��ꂮ�����yՂ���6��A�f���?��˸��]�Қ.]O��+��A�{���)�,K��ɗ���*s^1h�2Jr2qţO�{�0����g��f*,�=�c�S&<�l)�u���ba��y=F���S��i�e��ݳ���T��7�[�:��K	�v�[�.�1R����)�3��AwV��Bh�X��X��f�ޠ�:�T��{��Zč��
���j�]	Tϭ��2x8A3�a2�k�}HtAY��������� %J�z�j|��L���0�) 7i;��P;Nbض��S��ցyXƕ�:!	�ĥ�P��f�+D75��Sj��55�&�͌��؀S������m�dNR��ԝ}0T��#ع��?�����X�.[D�`Ƥ�T�:�sv(�1�r�_�_\D��� *��j<T^сn�2r\�V�523sH����w.����C�@i:��#Xlyv��'��ŵJ�Ɖ$���y���'n`X�nU��[����-���,z�Wd~��lv�*����3��F�3/<[�-@��[D��޸�/=~����I/UM�=��o���@p`��^59qňڌ����u��?� ����vs�V��ʘ7�����F{Kl���t�$�k5�1��8���w'\�Ai$��`Q5q�0�^�
U1qҪ9�9@�+P��;�6J?���8��vk��,�ucY��EgB's�TB+�����B�~��!��?x�on��t�_�5�rY�o��!�s�	e5'�
�i�Gp��>@?���K>�s	�2ٕ==���XGgL�4�`���-���VX#�^5E��j�����s�*G�>a�G'H}tm,��ݻG,�V�i�L�� T)����ߌZ�1MN��V)9U��4N%����!��]=�GM]�ߗ��: q��/� �����`�����_!�ı[�u�<u�Ϛ��dΤ��+���O��>���0��e���1Mԅ)�Q\�c���P(���Лvc�O�$�ԒvE�l+�v|5K�E�v���ǁ�n�􍇴ՠt*���*�@bD;�6)��� glD��y�v��94މ͚J��;�����N�����l���Ϧ�3g���/.�f��E��ҵc��H9�+�oIA�O6��H���^a���=.q~���m6�f1e�������k��T��ۥ��I��$�_QW��xy������;�M��@G�r��n�Z�꓎i�O�IwDQ���:��$�S�K�p��+O{H^6"��䪶���֯���4���Cy  %��\���УD�P��5�~ʧ\^�edM@�]Ѫ���R������zyS����2v"m�b��f���&|XcB�@����L�i����]����}�CWWm-�j�-��Zt�Ĝ��y� �	�(� Y(m�����0��`��[�#Z�hRF�L���ݰ��c�i�`�%GN 9B���x��7���|�
M�gp���]dSky9�	'�Na$
�X��r�c�n�5�@��NP�!O
�^Oa��'����`F�<sn�o�D��MXA����������r��i���Ọm�������H��_^?�o 0vZ�CS-2��w⇌�i�XD�����9�yV��-����2�G�@v�4F��~�E����1HNbt��A~�82�\v�SO䡑@e�2�wl��ŕ����P�BC���4��a0�ٶ�D���G��8��e4y`�e@�W{i��>j�J�e2@�p���!W�=�r���O����ş�c���XՅ�yq sE|��!�`�]���.�yc�UϤ����Ib�Μ���
��=�[�G!;��Da�v?�m�V�"�y�R�̿�+��+����0��=#?OWzlS�1����E���[��̎�w�_�YE�ƐAW��.&l?�Bh�Ա���p���5oA@�9@��r�q(�����mt�E3��7�˻{8�Ф.fn~��_$�?�GD��@}��V����	w��vtdܘꦥ�rY�N�{e/���dJxs �I
��h���r{[�M�1�c�\>��N��3s'�Dr��(�F*_2��-(�m��eU���t����]�B[��A�	�H+K���7w�j�
]�Â[�����=0O'��#���u�cJ0#�t�J�����	�v��M���×��&�iń��m�aE�sH{�}�@ə��]���RTn�$��Ǳ�(U�K�o�U#A�����v�� 6����d�i�>���ں�xIX��觧�����uZ\t�E�zv��b�e�I�(]�xI�t<.Y���[0�{����ʙ��)}�H��Ҩ�����h��8�uP�z�H� ��-���Zkq�|G����)��|ʒ��J���Bژ��D�( �7�2�t��uq����y�)hm���&���T\��.دir����%d����{�_Cb��q�@
dFk>��P��ƍ���P��4r�)dm�_Nȕ����$\I�H�khj,
��Sd�m7v�n���c3��{>��~�^���������D��{��f���e��|�^��L�H^ҍe���&��?+�yxE�W�ę�l`V��Ř�?�J��?oa[0�h�Ę��ڡ	i�0'N����=ϴ�
1ϫ�]���t�9+�3-�=�,�`a��B����a�,A)HC��E�0GWw���]�c*�����ɱVm_��D��q�=��G���Z�xP���C��R��C�=�Ii���Zw�1t茢v2�բ�t�׽��2MN`Mbzi����� >f�)l�uz�m�xGI�'j���o�6?���~f��*۔F_�7�[o�ebn�%�UkΦ\g�<�q]ٕ���ōNو�����+��X��i�u��kj/�O�����������a�m��?dl��e�����7�b��=��F��>�?*�<�p��"���Mu!���w��WyI��;qoa�?��� &������~���eUʴS�	�uK�)��)�xs}b��֊�K��Q-�Ю���1�~ρ� V�Lo�⃹�������k8�]�Q3bh�J��"�:� 7��?�*|��|[�s�����S�3��*<�;�G\{��;�
���5�)}P �@����W� �Ku����A:������oi{lwx��A<�q�������M���퉇�C�]֩�)E��Շ�Up&�9�dO~P��>n�U��p��a��&י�� ?��d��'ƨ�U�t꾻A��(�ܞ�*�ھ�B��ۢMؾ��`�|�ݹ�(��� b���LE���Ȧkߦ���繪� �N��?�A c����`�X�[�tVΈ��Ӿ�"@-Z�t��&d[!T.rJX8Fe���^�A�ɨ���R{�s�uf�Kx�l�h�Wr;6�;s���۔X��1�L�'�I�?��ݠ��*����v������%<P���Ђ�P�Aa��dߗA+�9�#g��>�_����#B�P��@�]|�˽���A_?��{�wK��rA�:�����V�O��D����o�J0����c�"��
	��� �)1�[�0l�영j�|�������å�W��h�n� �P�~� |��`_��X���r�S�@lAEe�᪹!���� �k~��H>����u���Dt	:bF��ؾ�2,1 tJOe�9�Z���\�	8���Ǯ"���F w�u���i��r="�"�IS�}p��e��F�c��o��vr@p��X�it��~~>�@
@q�r�r��q�wU�( ���:'� ��@��2�+���%>�ɰ2�����p��M��X�(�u�'�x+O׻�j@7*��SY�����P����)c_��d����|"᫨���ݩ�j��g�P|������!{���m����f�`���������'� �O��,%�{�?��z��o�o�`M������}����o;q�X�Fg%�����i�{gv�}>�t�~L�T���/�.��1=����5|3]��jsӅ�2��Z�=KRL+�g&�-���8��`�����C�%��Ŗ�RZ�������Ub���e}��U|e�#�y���.�?\;�K/��fK(�O�͘��֤��8U{�J�
z��Oo�B��>��eچ��M��2ܘf1�Pb�o�����z΃�q�Jj�9�{ح��-0S� �;�o����wMb0):q�����/j56nz�7���//(Z�5�gR����{ �)��0`��i[�^�?ۃ?_=�%����fo��s���hеN\}�R%+v�����y���1^1Tb���q�@!�f�/}��	�"�-Da�h-.�E֣�1[U%�X�)Uc=1@}�VU���E����VF��[=%ˑ��-r�+�/�2������	�ޝꟂCS2I.�SNpiD��(�-��Ks��������R��,"*�J�$��*�����>"�萂imj��Lu�+'[+�A6[����hi�~c�yܤs ��b���T]W���?��"�w-�u���[հ��;�Hy��}�ft��B��AG���_�y����^���� ����a��"<�ƤkcL��|B~���_�euL=�h�Bg��Ѿ=ßN~ Ym��Z��{�|Q���x�;���0��/�%�W��A��͎y���>�b����
"���ovi�Șƽ����%ʹ�&��==�6�l�g^���|� k��4��Kj�KKG4��4���q�WC����;�֗�ڑ}��|iظ�?f�J�-��Tv�Ĳf�G���NE2������B|�L���	�AF��1g�?a:�� �����m���̽���k���j{%T'y`�茀q�Ϭ<�*��3�DtM�� ��Y��v�qE>rU����6��Sf��6��_�j�����X�n.9^d�Wڋܩ(f/����c��`�gѲ�+�k�H�l-/� ��So��|}5H���3;��c�e+�u�$��͔��#��TaOHw�N�'�[�5��~h{h�\[����D~R����m
+w�UF;6�`�����y[���g�m��7~�l?�����R6��[@wnIj4�L�)0���]C�bklCX�3��1�?+�=d7\��*9s�2�����%Շ�牟�� 
�,S^�֭�+��F�;��W?_8�n�k����c�C�5F
f���\��a߀$D&D�X���qP�:�?`O;.$H�w���j)8��1ў����e�T�Y� �`EAv6qn� ��
����V�x���
"�ڦ�6�!��Z�Cⷑ!�=H�g��,'FPt�u�2��Ej4��ƈ�8S�*�߂�gД�������I���[��s�Ǘ�8�@�g1��bޖ�pQ::㳗o��ݒ��{Ɍ�dĨy�ő� ��b���_����"�{TS�0�㯫��#�D�*ؾ�0~��� �S�A����d����P�IV�R%��M ��e�l��j�J��磖��Ik#�?F�+�M}�[+���a�S��X<�w�)���N�Az2��g��L���A�q�8<׏�&O�A|~i�WE]���Ng�	��h��5'�[a�gFʐN�A�}�#��WV�|����A7}��1!�tJ��e��9�ۢ�"Ҵ��ڡk!�<�\g�g��<a���§��ٰm�3�\@L��/j��t�BIь�萢>�/�pcC��-�zճ+�5ƻ`A�W�Z̩��� C�(H�ŋ��5ϕ��?? ��/�;��ʞ�� ߦ�K>�噤e>KI�i=M��=^�Wq��WI=��6���X��2�K��*-�����l��cy�1C�(��F����Jh@�b��B�q����� S(�I�nӘ%�}�M�Z-��u���EZ��� ��Ve�n�(�Nr���(ɍO�� �����P"1(���X�W������:p�.+Oq(�Y�d�7��	gٶ���)�$SuNb�����/߬ӆ�Q@��b y��� wX��)=诌�/x>Ko'��N�@�͈���f�/61�^n�p����*z�d49a��[�eaKXL=��lQ��};2���&���+&֧�C���������5�r�0�j]��=N]�	��N��|8i�&q�Hq��dӈ������j�Btv��<6z�+(����N�B��b��,��:&���xc�L��}>>�å���seK��ˡ-ep��*�l�2���͒�:f�+�w��#ł�"SK�EجYE��ϲ�$��Ĳ�STܶ�e^��CAi�$Nb��⽅U�#o�;mgk�MѠf��x��%Th�LX��!E�A�2�S_
l���Wn���8�T����p&$�v}��m�v4�NP֦}��W�01�~� ��:�P�����h�rg4�dY�''{/�Z�з�1O�y6��A���I1�*Ǘ�����'B���cy3Y�����{�=�����p�fՁ�o�$��3���P3<��Au�C3ǧnvK�����Ic^��#1�Z�D360ê�cgM��<EE*U����7A��Y����|T'�y�p�I �p���$XZ�}$	���'Bdf/_ˉr���W=e����g}?M؁�m{W򆅆�Tu�/��������<O�|�|��=�����ݪ��3�>I���_�������^���>�m���Lx��������m_羦G��t�����W�e�~E��l�^�y=�Iw�`��<Q�~^��e[s�M�m|����}O�|m�K�q��g�q�����]��l}��<�M�|�[�<�~u����>۵�=���］��}��n���'��vc�8e�>�U�9��3$4-(���`� +_P?�9P@̢FA�u�,�������?d�����ھ��i�Z(v?|��J��~�[>� GCv I����XZ�L�B##2�_"m��U�6DB�;'6�U�&��C���/�`��n��+`Ft8k:x����U�ߎ������d�!�	�����A�F�[`����"G�o��g t�]b�ql�0�M@ăJ�3��	��t��Z�D�f�>鱇ܧ�put��w���и��ng���o�$u��gw�Wb�ܥS�}L�5���:/X;/$>�9�,aPQ>���X�L�����I�h.t�����.�ECp� B�LAA|h�1�ߚ���$6%���eҧ��8����4)�Ao܄x �/�#D ^�fb�}?yzh���h[�z�	�7���/���*��*�5��E�O�Ⱦ��u�Z'�����K��������e�����+o�ax��6����T���xvs�����UJmb7fny�*�/�;6���,�}��"�2�������5&r��,a�Fʱ�Zb��בLd�[h��/-pU�?pC!-�BVNd�����\���.�l���_:m3͏��Q8��^4�	^�8a����p�2�Q�ÏR\������ӟ�nt�xr�\I�-��>�*#H��փP�XIx���{ �}�rx�g�:� AP��������5�#\�C,y �\P�S��G�P��@|��b��H(Q��e ���x�ʨ�(��Te�`1�-F��s�C:�M�S��k��)���N���2Y]��h�$�"�^Ns�_�Z�-8�*J$���#Ȟ^���C*�f�w������Gb�?d�K�����r&�=J��y�:���A�����j��w��/�= �g$�~�6oAPv_@�V���bO�!�$��o��4E,9�u��N�<F�UBK;)c�n
d>^@:����{�bݯF&�ץ̠^�6	����h�l�r����YR�|�
��Zq;�Im��Mq�h@�&�s�y�k/\�r&�#;prA�C��?�cm�tLf��)=��H�1�ܵ��'�B�U����v$��������M��%�3�L�7�7�tka�O ]ߛT�R�?�(.�����!X� �J�R��
����`-�;TϿ��.s�sav(x�8hd����Q��� ���5$B
����b�^Eqm���/(j�o����1�	;���a��W ���Jvy!�qߑ�=NU�!�K#iW8�
��k!>�JB��'#E���&p��op����'Y��u_!�E����vNb��t�n�2s�$rS�5Q�8���j,���艕��o��M%��^�<��;���$� y;f��e�+��ꮂ-�\̿�]�v����ͪ�H����Z��n�3q�G��ʹ���Z�@�O|U:����h|k!/W�>vyH�R *���������b`���f�j\&?���d����_h̚�
o\qj��7Ƽ� �/�qg���9����J�^����ʔu��h	f�\���>䕗�����b,��]ǂ:�!��?���hFQ L�L�<<�޾1T��Trl�9w�a�]צ�U�ط/��1��\�afK�pбV��E����#��A�C8�n�()�Y��OqF�P&�m}�����`�'�}#���0F�����@��s�����OX O���?�u���hb���]�1(��<���Qu2M� ��R���K���R�/\�­�@�D��Q�Y��"�]�-�2��?���L6E�d�T��o��.uP��8no��P��K����D[�7�X;���nD.���� Xa��m	M�ƴ]�3�꫌̑~����W1o��}i���MKO�Ð"Gշ
�q�xs
+&te��]��Q�d&��z�O�Z��f��q`����&��SF�;#:勉M����*�#o��J��@*ٝ�,q?L�Ə��~��pT���ߜ�Q����,$:�-�`�G!(3�{'���m�����Q��+^H7�0G��b��\�7������B��w�ҳ/��3�׿ZH��<���H9�}�~Zd�v�b6�[�)}a2(��ǻ�����H��51j(�� T��C�A'ߖ��hY}�M� �T-e�Ǟ�'�ߢ��EL-�F�2rrA&{��T23_���aS@GB�Oql]s�*x��x;sG��)�����fFX3 ���4�y7�1�����ї%�M�����Z<"�L��A�EE��"��N���?��S<O�c�n�bCI�M�i�l���M�ES_�bf2̰Fe��J�zd�=s~l��/(�����xF����bU�-�?9�v�X�v�����,F9�2�g�p���0C��Nw� ���ǭzI'���2E��r���/�#\��=����k��V+��lW#/�ZB�<hu�u8�D��)������]�H�@����q{zq�@W���Vi���\4�J�؍����B����X ���˽~���Y�j�+
d�A�vy5�Ō��C_~����#��\`�.81N�h��~���cbu7B^���@�xR�#��P���#�:��Q�����-��cl�-x��B��̓#��{�{�;�2N�(�|�'eI�o���᰸N;c�l.��c׶(��zW
x�P���U�Q�B�_���c������ߔq����Q�g`5�g��gbP�������������1m���1Yx� � :|�k�[�Ŭ�YX[�[M�K����˩��|��jq���s3�	��ttq�sY��1(�jIQ��~�Rdz��x9a���ddcQ�&���6��xUi?�<�ȡ�Ta��e�[懕�����-���G�%���:��24�[��z�Z{ϩlb��i�K����Ҋ���k��A�LrT��%����W����H��;��G_��ה�糠d蚤G1,X�TK[1DU��C���֝j��"�JxǥG���������Y���-M`�j�<1u��%g���[jۓ��ة�b~��u��`2�.�����'�����l���[�^2��fB�&VNrRbR
,���Tl��,ڗ�Vc�����s�Cd@�y�Pj|LN���H^՞�fLM\�FB�V�\��\A|bR�FU|RJ�\�Fr�n\��Aix>�#]%�$��C[S?�%��Z�#��:N��=��2�3�bk3� �(Ō�D����h
�؍Q�d3������<���2V#6`��dZ��]:aT@?;,0ؑX(���v'�)��$���IZԨj!r1v������doĺ\��V@�XA��_l��lO���+��ew��Л�&-�"WL�t��$Z�!7�zU�yh����|0�o@�Mmw@Y�~��t��ɪ��j�O��в����6M�e�+nJ�CFS&��x|-m�쉲=���^���=>������	*(��"bIa܌�V��;U{��5��^�=��D��Z#}	>હT�56�=��3�9�}����� <$!��*ߠj��j����#�E4���+���}�7b������*�k����5��w��[�Uq��BT��n^��ǐ���f��9��Q�J/?C0�c�m�$qh%���|5%����!�����$t�k|�!M���R�QZyN10����|!�5��v���]�+Bg�3F�%tv�P[�>y���s=��f�3������׭"�~����[ִUB������A�W�{���w��9�k�h)� K���!�P�� �CrE�;L3�Bu�I��!�YR��4�29�b����?sw�ĐM:@t�FR��H�ɀM��N����p�����:`�IA��@{:���W�D�E����g�`1h�Lm�J��#���>�J���u�7 �$R&�\����8+�wI9��>9����-oLC��0ʢC�[G��,�a�̗��:7˓;���`Et28�g9��y�0�vؖ3|0q��+�r����#�`�i�/韓\6{�bZͺX�#�;v�cn藣��8�5G��P$��·�n�Uq���h֝�ݶE\O��lt�]w���vA��ڱ-0m�)���C��II���@Y��ؔn*3=�������1�Du��m��ʭ9[";ג��י�y5�u[{�r�0�W��)4�ȟ��>�����^F�0;�+DH)��� �,d������-����������3D�����=�v�w��j�R���Dj�*空�;;B�S̐�WvFh��yJǛ�������A�=�����*���U�����I��*F��|���)�e��`9�@��#�#1t4#`m^�~�L�p���)4d|A�z�:*Ҥ�I]�����{(
�qu�Y�/�I~W�m9e�����~�<C ��4�bӕV�r=���"p+DscT
p�i�L�~R��[m�>��!��)}zi2��ry���I|��9��J��ZR"��~!�8���}�G6�{�	}�4�I
��<�WfN�q��P��Ke����������I:������f��7��r��m�'RZ��F��8��U�� �52��|��
�����ԃ��Tm�Z��C��Bf;.z��)�}�2j���:��kx!�u&W^c`�
`b��Q������+kr�!��:������w(�00��q#�9t�"�������	��[�]�w>�W��f�Y��ָ��S�:r�([N�C�"���6��Aa����XtJ!�l��18kpU�_7�-�H��G�R믾YN�a\G�Pv;>�?�Mj
ܩ$%��D�y�0�z�\X0{�`a%U`���gU�����fUԯ�ٌ���st4C��K�L!(}$[��|��'���p:��^:�����:慉�ޫ��v/��J�Y��׳�bM�P2� ��1�s� ��؞����i�5#s���bP�,7��k�gݔ0�������q���}�Le����w}J�s��O#C�o_���d<=Yz�Z���F��ɠ���_���1��Ȃ�uu�Q Lb���!��1�	D�k؍Ze��!�ʺ�L�Y,�C����8x�d���S�kc��$z"Hf�C$6RVx%v��+�cG<��
`�X�lخE�{�}�.�b�f( ���RF,��bLҫ@�.��W�Ê�{�H���֊��[��CDeҫ�k��c��X
�b:S�t�4�#C�L�P,)=�qj�n:w���*!��»V��o��54�@�AwΫV�"��OX�5��-�;�^5ǫ����Yca���0sjU<�[ΔI�Y��9�&u��k5�C��k�um�v��lh-��O%�N\;@]F�b��؂�a"��ت��לN�+���hi^�K?{�ԫc���y�Ӿ][6da���%�	���.$�b8ݑ��H�P���s5<!��ш�g-#ie6�e����=�����j������Kms����H��k
RG�p4�a�Ay
#��R��sJ>C�d��W�Fd3tIl��8^e^�R��g��4#��	5ژ �y����(�U'��~�k<#,��r} )��=��4��6�zO�#�C0Ŋ%6:à.�RJ�dA=d+��z8]���
"o|��:����SE#��L�|ܦ�e�.��j���8��N��-8t�M&Mشo��}�yp]�.�c]�Yo��\�^�]P��4�'1�?�{��~�rH�}O<�A%������]�~,ܶ|�%�?9:OY']��*�:vn�X��L���t���QK�G�I��h���,��x�X��b���{�^'��܏VXuQo��?DE�"���E�r�4��|<w����3�.Ό��/ٲ��x�ۄ'�݉�L53+��	4	P�c"���:@�����W�@�d
9N�:�-�*EK` ��hՅ���Ԡ��hKx���U誢��*����o�;���pEq#2�F\����D,
��u��p:J�"�c6ےk�/�^y7�	;YT�ͩ�g�����^�$d��z�	�tpGv�O+�j�\?���	�O#���B��gb�5�
$ݞ�=�oϪ�:�����y��݅��}0�:x�Ik��Q��a�i"��h�>�����t���Za�/Tq�"�;� �e=C$`�m��]��L��ߤ���P��;�$���,���gϭ����I�%j�C��0�
���"��h�ߗ�/�����M�}�SR�BU�����0/�qS� ?�~J�0�K%��p�<5}��%|)��P��:F��hԺȻ�RY�Ҏ׹B�ű<fz4CcV�:L��:�b� �~�>��{���tPވ�ӥ�k:ѭ4�`&WԚҔ�� �����j���H�MG	=�+���k�����vd�̎ո`�qO-��kN��(��*��N���!��|��}ep�{�3W Db���w|��_��}e�#�f���d��g:��:ڧ=~Krbw˸�ꞇ�ז"%7Z�H�Y�V�1n�ū#@��^��|�ω2,���,�m1�Mr6}zo���E�$.A@	5��}[��)�w�^��J@Ȑ!÷M~k��%������`��xFo��9��E?zX���"�a�Y� @��D����}T�`3,�lE��É�/�Ns�-�V�yE*����ب�Q"4{c�t�4D �͜�У�m
��>���({�!�+�UP�z�X��˿��n�JP��A^��(�"}E�=1�F���h�r)�E.��l���h��LK�Հ۞�B\m����q9`���O��`��W�R���98Ү5�!�0���,���L,���""a�;��nM)gc& ��b)�wB�iKk$��p��Z�u<�ا��o����qTWES�k�]E�����
E�7<� �;S9���n�U�A��shyD�St���'^w��lv����Lђ/6c�Ne����L�LO�b­=�P��I�^��Ze��_�X_୰l@X�ib؛E|D�V��/n7�>~������m&�>�=���C�|�`����[Q]\�t5�V�1��Frg���bH��;*!Pp���F|�a������E1�ե���a5瘽Lzc�8C$4�V숪S+����>� ��^��0�{�aW�*�۽�.������B�1L +�����a�����/����B+����{�Ē�j��(`D��!���F��y��V��D� ��l�4%
��S�%�*�ͨ2��~F`�m)���CU��$��%p�rԐZ:	��Xk�!����h���|&���0�9'�w��Ro��T$���S�.���?�Ű4n��e,�3�h�I�F�]f�\?�����cP��9���wNb��d�a���	�'�'R=J����mܠ��p��nՄ��5]��N�}6���g!8]�x�B�z ��{4�%��h݊�A�;_�.��	����A(�Y��᭬�,��*1����i��L�Ғ�W{�|�d�Z-��T�"Y�Z�K�X���X��"od�d<U�q���彥-ӂ��[���dH+�c���m��!�yi%��J�)��iKz&:��*��\�@|�9�fWM�k����=����MԦ�iZvj�ۣ�ͻ��隶L�j��ZCɼ-t��'�l�U4���;��IY���$�6����"�MH���a��#�R�?��{=���������_8�D0u�3���'�+����聁��B�2�$X(����Wn�b�A�\gz���h�MD�_������=4~n�Zw~����?˿�v_w�o�x��O�{��bf�+���|-�.�~��~N�wZ��|��~(�,}Lt�-]��*���]�_�W�TϤ�e~�.-�l5��>����u��x6����:,��k�i�[J���`h�i�KRPB�����FR����3���y�����������0s��Z�\u�u/���X���+��>��/��8�պ��T���)��x��վ�:5�]�n�w�ME�,�:h)I�9�ʿU+ߪ�x�*8��5�y�Q�g8�t��>w�pDyitk���
����N��c�<���Ʈ�ܨ���8̑V.:LL�X\�{Q��٨�.6�t�D�l�42��Z������_��mS:�LU�Wy�Q���ry��%_ f�a����H�q�j�C����fG�ݰMwPO���	�7�J���dOSў�Z�lY��e�$��ɉ}��T��Y��͒hf�77�h*r����������T��y���M�<�L�[r%,߹��L�k�#�����p&}����*˼f�z�����.�a�-�{�DO8��A.�qL4�>�,��jN)8��b���Zv҃����Y�^�����Y�їε
�Ąpr��+�z�[��P��c�#���V�t���]Vb��m��f>\��W(C�g�]����&t:�'�w&DZ'��n�}��D2���ep��Ī��;�E֍nW�ޝEM�\�g뜍��D5����@�8�
%���W�f~˩��h���Lk��$�aS�s� az�T��c�rሊ7�:����R�m��X������	�8��e��w�~]&;�~t��6�dT�+���Q��
�6:����G�ys���rb�c�
�O�l�撟a��d����p�8I�_g�	�[u�78<A0���}���E��0�Q�M�h���'�Z�\j4k$6�#.��u����%�Q-"�W�͌9�u��^Y��j]��}��z�Hi��J�i���.�dG�����\}���k����}���YX�����\Y˹�?�p�w�
�c�O��zL��ϾS�����N/�a��M|E4Ტ5�9/=2ɽmB�sL�+m��e��w�D��m�{��T�����[w����b��6�%�d�����)볕O��"�n6l�Z�6�P4��BO6
~٭�`�F��x�n���[��R�u�{i�F�{!��_6J����(�2��\K��<i���������o��hu�џ|�xl���;�a��1H����y��ˮ`5'��������h8ճ��U�[eC���[Ev�I42�,�tA*k���'jg��(��K�E��m8�](x*G���D�8�\A(�D��Hё&���I@8�����D�9e��zZ�J<ّ���������	#�;bӢ�_��1���c�ԩ�ǹ�Q�D>�L���
o�	&/���:�_����~�E��@���T �Pq.�pi��{�.UC�Y���Z��~�#�o�G?Ć��iGs�:�e�K*ғ )m�΋cm~�OH���T|z�?�E)_�(zE[���Ĳ_W���
W�u^������T,��Y_	n9u�a��z�i�c�@��~C@�n[s '��37��[X櫀C�26�'��L���>7F�je؉һV:fM�Ք~��WF=���,��&���'�!�7�;ǬT�6�VfT79����t/����B�c�w[_�օ�?^m��v`_*��Կ�<��	�+� K�-�B	
4�͙���#��	o6]�Q5��Rb�J �L �&}zj�X����SJ<�x����P��ڡ������G����.7w�k���\�����8<W�hiJo����O��d���&��;�2-6:���x^�z���x��R���~)(ғA�tp���ՕeХ�E�ޛR;���\z��H%Y!���$�k�\˰�u0C��{)}�j���pb��_T:&*����v$�0��
mB��������{�vTB,�P�ԝ$]��mL[�/
�|�l���ח��(1��,�|��w�8�G�f"�N�f�2AM��pp��vҀ�2�o�p�O���K�.˧3�C.	p(��!;7�ͳ�pXY5�����"�������WQ�8:���f��G�Y���e��ڂq�yg��i�&2f��6?e*�^4_�]��b���!�"Z�U���^��t�k�A1��@�-;R�h����z��N*2~9�8����H�T,��>~/]��U���&�����XV��%Qc��2�й��T2�tz���Q�S��o��$}n1/'����"�+y�G���0氱d���%�:=�ۧ�ڕϩ�o�,
K
�#��s۽['N��zl>C�eE|?a����E.�4z�Ѡ�C�3���%�0e`X ����S\ ��]4��Q��F��*Wm�O^	<��I���h�V��֕M+�<�63��r�`�Ȯ~񤇦�+dEu����$����`+�;ɱ�e7FB��a���\��cK��pQ���7���������Џղ2O_2��8�!6m�0�c,�滪��VaZN���B4�QW�MrjY��W�����e!�d%	�ku�s*�����x�m��$�4���.5j��\+��hZ���3o���e�im�@߮��:���_Z�z��S�B�:@��Z��u�Br�i�i-.�\-�,��.��#c��]*�/0�>�ŧo��7x��C�&�j��>�»����@�0�P)�!F%֮�oQ5�E�j�ذWFx�8<E���d
wm�)JƃG�Ye��P��,%�D=�A�8O<hs�c������FcN�ٮ���������$��
�X5ŲyOC��A��/�T��F����o��:&>�9$UR���)I��CS@�ӷV��3ݖ�3�x rG{����ke����݇�l�{�i��a�˔�TV��� �_'��M�g�#3�Eӄ�����f�Ց�RlhV6ڢi�̞��ꀛ��5]S	����������4�r뜔���[8B�|�gfW\�_�@��z�R*ȵh�w��_�ŝ����E>�{T��M����ˏ��o��c�Ju��yUq�ߗ(�qJ}��&U��%�}��2�owb�Malx�VUβ�* ����-���S���>�"�@2}X.q3�[A�)�d����C��c|E�ڬ���aOM�o�C"Pz��"?�'~i�����6��<�����(l����3B�}�
 /^����wu3�>��nus���D%ԟ!�M&�p���l����O�#��.<r�y�*9���"�l�~ׄ��3�o|P��ĥ�����ڲ9#@}�S>��X�7���~B�X���=
�
�����JA\�#�b���)S�-���5�I�A���o�j3V���ׄ��v��Jp���|������O�"�ߌ%�8���Z ��`�ro���P��b+��(w�N��f�gY��u�K�,�4Q�X�6N��I�GswJ8+���,6��d|Cu���s}��f���p�h.�X��<f��'�l@�j-zU��N�}4Z����C�"N����� by�+S�-��=%F)�z4��8�kR��4';[������o�g9-�E?' ��A@� =�(�qڣ��Q�-^�Ys"�Us_�4Uݫ�W�d���^���`G�m�۞��%)�V�:�3���N�\ �`�w��2�i�{ޤ����X]�� �p�ۺ�i�Q�~���?�gY�"|D�dH����SwvoI��/���*�PH��{����-3	SK1�JM�-:c�-/���Pm(+��)����B��U��I��ݔh�#Yu[T���!�[���@��̴Ll�<5��}}�O�/A�E,f� �i��n[s��L��~Q�c��4!/ޱ�x�g����Z-�Sӿ{1'+�lsH��`_��>&�?�.������@��s~���FP_0���*k�w�Wģδ<�_p�B^`3|��V����\�D��P�z�wWB*d����|'lQ�є�bi��{jپxM>�ᮏ�/1�c�z�b�&���lU�M0�0I�
�Rn�N���,�}�1���x:/k\ZSڲ��E1�^�Ⓐ�^�~��6Do*������ob90�&v�,�e���B��H��w+f�<h���
�@%�ӑ_?��Ck���s%ԑk��LU�1 i��}�z� �c52?���]�������٨qfL�����c����y!G����-���X&�yD=�|Z2:�[���P��j��u	T2��u��}���$g��"&ޫ�v��}_@ݗ�Dٴ:ixS;o���RД3�~]-p��<�.�u�{@]�J�D�;y�DAP򃶜3���V�u��y��. ���~�-��-�TŞ����h^:��v���I���H޽+�f�}c-D��djY���N5�E�Uv 9�^���w1#ŭ�U�yn6}�/֙/��jw��j꜒_uz&�=BϽ\�#��d�*F||��ۥki�'���:#G�^�e��M�>�W!��*�=����B����9�HL��� ô�d�{�̶�S�kmA��Z��fm^�������#Ԃz%zEZ\5a���+������\�1�4�_T��" �[ٻt���\5u���ܳby�Kֳ�#�
U������4;�㗎�S����6�U�xIi�o��/�77j�� �8o ���js���Z��I� s��w���kdK��1l	;��w<J�>)�r�QrҲ�,_��������*K���ݿh�T:��Fƿ���c�n��8��7�9���AVn��$K���ޏ�,y���c� u�2;[�{,H������kb)r�"�x'�p�D�愈�V����Ȩ @ zgW��#8Q�����3�3�qj�U$:i�ң�F?��"�7N✰v��}�pJ�~�)���3	M�q��DOu���t�ӏ�)��¿mn�%^|IM��������BNЋ�V�|�� �2K�0�g�K�d�@	�.:��j��8\�H��_�����E)c}�)�'ٹ���ר1O���,5�f[����@`%�F�OR�?�1=�!�g����Ҫ��O����Z�"9�l6)-(�����V�������n0䦹H���xZ�<r]��hYl�ά!�yѲ�?�J���Y���� jh����ԝ������Lm���jЕ��:w���[�ٻ�]C�E_��g;�d�uΔ0s��&p��!����lU :�*R������KP>�\hZy�b\g:T���՛��]�~��D�C���x���j�Ⱥ�X�������n���Dp����'�\H�Ӡ(E@[�RΕ��EU���a�qau�����gS��]�=ڂ(�;������+�K��9(������MPR59�I,u{땢┚rE��[��y��8�zF�3��{�{_��|0��LQX���h9�f��ƅP�Y���|rq�1[��sK4�I
��j�OM�^�ѡ��U'�ʫ�ӕ+�$r�U����$7�/�DZ�J��<��9�*F�wjޝBړ5r[����(q���<� �����A�K��Ni�%�����_����%���c�p�x�I�9�}�߫�k���>�A��/Ќ$�E��Bq82@�R��9A_�x:������1JN���3M_B�O;���Q��D��^

�Q����6��JR��)����"z��ٻ��2��^�c6#_W&s*ɡ��k���i��Z�b:Ar�2��/��	�j)�(�����ĸ��Ix?N�>���tc�y��|���r'7	.�H��"��)|պ��u�(��-@�۶�?�Ě�d���{�XR�=~��Q��_�ڷ��dg�M��@���d�g�-��돸�!F��h�q	s�X�{�<�cVQȹ��L�i�rӲ"�TX��_	��L�)�nK�����)-[��C�X���Ÿk4#���dPIya2�
����#��蕄�%�L��Y�S�I#C���o=��]N<^2jz��:��dRWT�=���?���g�ks��gi;~��w���{g0�p��<��n)"g���@ļ��<Ǡ_��~K*^P��LדO�':zѨ
^�2���G$2��Z-��qH�Pw_�(���H�{�Q�(�o�l���Oy����S�A���v�3�h�t�h�B��E�,�|�����d�k���c/��=��RM�t.��}�<�E�Zt4�#���b��M��Λ�r����y~�0�5�Mm[��@��_e��m8\ ��/:҄�\\����\��~��_԰��Uğ�l�`��pw8����*��zr"�pJ"(Y*�۵�t��\�ܼxF��k;J7@����7��uu��ϰ���>��Γ��_Hm��;�)����ј�4�ye�Dok�˱�$x�46�Z o��
��,K��R�z�DKH`��*^w�i�<�З����}�/asܮ��1����YVM:#akp�{�v/��ˀ��%o��"u�z���h��@l�'��*37O��6"]��tS�1���|�+
zsk������-̌����/����]Cǩ�����!��-��) "��E�8G]��Hs}��M"�ūi��!�_�' *��9"��)���x�y߯Tۜ5[�-�A;�ه�n|��cƟiV�K���U8d�4{������YH�)X���&���+<�I��2ϯ���f:뱺��^�"�gFO��	lPK��H�a���b���}
�<w�՞m�Lf9�����A��U}I�-��$<�"�����7IJ�B2�^��7H��lK��b~��=j��e�#�u�<T
"�>��_뷀�t���.���TH���p�1k�2�ITL{G]x3Ľyw��hA��b���0�S�?�g	7��=OK�DWв{�-Z#�(��&��U93fK�,Ǟ1L4#!���aǿ@|G�"�)����Ir���1��v^A����Yf�jS>����f�^�T\7���R�<����+������5�OU9Kn����C���e'5��KLͥ�.E��_H)1ܙ�f��dX�?w%���w��f:�W7��Էu�H���w�qR��o%'Fl�Dq69ym��PI�(+��BZ ��'tw�q�in�D��q9d��W���|�������.g�[_��;�w&�Z�9BcsZ^f]B��L�+��ȿ,�HcK2LN��k6�^�$sh���d�e�g�Q�����A� 03�����:l����}_Ԫ^���Ӻ�>��ZM���m	[�����bdM�j�_U;��~OS�k�X�@t'��G�����?_C_:s��;���?Kq�}��oX-N���/P��)L����!�6�9D��V'��J���W����Z�pJ�h.jG{�Y�%ן��>����N�(�^��z0��R�1�M�#��LX#�yU�}������(�䆋8���_i惈�c�.�68�'��1X�cǆ�'��C_�.֕l�w��H�j���r�ӈ����.��}& p~g�5�Ն7�MJ�v��M�y6Uf�T�mcV��E�w���{2
�â�Ky���)���q��$���O�E;�K+]�zucgsZ�D�`��Fluw�F]��&
�*d��k+��;ּ\�|kj�	��4�H�0.N�>0�
��ټ����ɹ�b%�Ayݞ9��n|q@�^����0Ȋ_�ٷ�yD�3��#\�0.�L��Z�U2���4Ku�zr��?nn@��:����G�$-�4j�R�P�)6��� G���T�"�Ì/�Wڢꛢ�N�+"�P�b���-[I%�M��y�m�c����'`%�п~�|*��+��u@i���z0\���1z'u6D ��H�<_����))�k�����j.�:���@��m�EՑ�ҋ�7X�VSK�XAN"��C�le��՝��q��*��(#$Ula<Y�4^��`Na��\ ��ɘ�Η\��Y�f7$ k�o*ژS�-��]Tv���%���Al�?�j0�RG<�zF��ԝJ�"���?y�z�,%�sj��V��gk���մY{��_�-C�)�������ϙIZ
�P���F�����d]���N8X����K���s7uKQ���D�~=)  *��HF ��c�mZ��	�|l�l��+n�U���l 2DZ�#"؍��x}j3�U�����;����7R���$3оLq�ru���c�% �ߞ^�]���1<���#���:��<d\�V�^�!��>�Y����cq��G��FA�f��Wr{�_�Ɩ�G����?��b����$^��I|�{_C��u{�Gogic���b*rイ�ꈜRuV&�����q��@i&���R���V�V�g��(��`�6��M�Ybƒ3��a�^���(���b�o�ɼ�����M)�~L���,R���(�v��ZG�J��$��K�s���$Z��i�ד�`a��ː�E�}�i6���P�M�0EC8�X�J*\S(�A�iLI������ӊ�w�&��W�+�V�c�٦A<Gv�r_q�I
.�-!�Vk}������1����������\x��X���z�je;b#�@��!�M�x l�^�b� T���4�#��(�����g�����~6�����$���9׼�&���~鳰���c��g�磒dB[�N��y�"B37g��FOqH�cv��g��F@�>��B�,�{ًޔ��_y&9 �*((��!Uyl�J��tg��|�W�{���Z4�g�1��vD��w�o�N1Iɪ�n*����ʬB�O�)�e5K��,���ʌe�&˳�F*$�����_y�u�g�F���[�b�R����������cVׂ^��X��iYI���w֛n��*�����zy���(Y^�Q1��C
�ۼy`8��2�&��I9���TzN�&�d�ɻ�9ՌIM��K�e_A_�_M�Pj�k���������d����[�OV����(J~5i����������p3����Wwo���B")���w�`�TK�JW/�i� ����g�Iޛ�#q�ٸs���+CIk�vw�
��b�`���R���Y?j�	���׌ln�b���n�|js��v��e��������ͼn��G3�t����,��X�xTG3�M�sh�����x�u�
>*��!����𪏸����J5��p�-5�K,D�\��dB��o#�<���;N��?��L'$�k�Hfʭ.o|��M�}x`�h������DʚDwv�!9��ʹ%���Sۣ��"����&*�^�]�O�����hk��g��ޜ?j]��l�=>���7��e3�Ed��TyB*��X�%}���c�qA��#e��GRW���;ɾU�"Z��k��/��<�Fh���՚L۬�#Z�]WU��1�� >޻p~��p�8�K�Y�k�y���䰙k[�����ۍ�����c�`p�e�DH���bI�7O|Tҽ{2����:��P�sU�����n��msj��ʸ4�35�]�$d��Me�I�����Lg��"��}l��sk-�ф!$�0���oEQGe�t��7[ָ﹬)&˖ȫ��Z�����U�6�S�t�ʴ�s��d�njs� x�p����އ�tr�?���{���i�f-��cu��G��ls��U�Z����S?��Rg�R�����Q��4�|��:���;�ڳ����������N8\�.4�F����na���0�-�IRS'k`q�F��zi�Kfݽ�%����bT���[��p���I�y��^W��/�إ��i��L�\",)v��yFw�k��������|.<Y�|ґC��S�����q&��F����7-��O��6��_�T�$ݘ�ԋ�U��6_8�J5l�'�,l�Gvᕤ�i�\���S����m���߁ܜ���P����J�P�޷�/&���C����&�xO�s����XNP-����p�pOҒ�N$=�UhJ�m�O(��0
��Z�sÑڶ$|���i�xON3�8?��r2� Vʟ9��sѻ�&��D�=⫟�������6M���Έa�.T���l��7�A5��]4��px��n8V������:l� �V#	#�	�@4ʩ�z�:��P�.�6=xő��Q�bB�~�3�b?'f�� bɪ���4���Ï+~���/Ӎ��?θ
�u����٤��I�$���E,V�ȋ�=�9������Rc�B�C�eD4�x�!.�ْ���g��8��vͬ���1t����Կ�2��d��"OŔ�Zɵ��P����*+-8�l����[�A�Z-�P� Y�P+�"��/��Eo΁C�L��gvĉ�%�?��t���ˢ7 ���]+�fJ
8Gz����>�2�>]2z��2"EJ27�\ߢȎ ��{Q�>}�;����:q���^��5@�h�}��t��sLIK�Q�g��NQI��=+� i~�"���Y����C��O\c>k����J?@� z���8��_�¸�{"	S���uhԨ̼g�/���z�ݟ�����W���T��3W/��'�.cE���VƇ(�z����Q�;L��	Zp��6��pOË'G�Z���۶�{�eA�9�~ª�?���E!]f���߈����[�m�W2���f�=�#~�G�2*l��o$(�E�;�G1�t���[q�K7T�#FCN�i葶����s>Uܾ��в�o~B���4nS�ĵ.�L�}I��g����O�jW͏�]�O���o���@�7LD�:s�
8]��^�H~��K�k�l	�VS/&?�`��a�����-�w�t{�Ι�O�l9T�?3ҪZ��O��q���i����^T�[L0<��P��~����_����2�Fm��J��4�X�`��)V��E�DNC�{�d���ڵ���.�'��FNV#W�]l-b8Eʗ�s����3�c,=�p~!�i�����Q'%?{���V�S�ػ����.�Ϸ��lA)�,�h�vݕ�-�a�oY���yc4�Z�G;��� O�uC<Ǹͦ��Blh����C�ֺ�����5�SϾw�E�q-D�������d��8C��PZnȄ��e�%�F�[K�W$�R{�\D���.,Ff�\'ݵU�s�����yj7���T�ֽjPo�A��o���L�1b�ع�&\6�p�U�DXiǾ��y�-=Ue��Z��R ��'au7;,�z���g),Hq���2�uӔ�B�ƮR_�<��TW?&U���McT׽/G��f@�� F�H�"]V3����S�Jw�Pѐ+c�m�x4��Ls��t����§z��B�Ґn}�3�'�Yþ�z�?`���5��A��X�9M���&% �t�T�Q@5_r��-eUf� ygR��ΰ�<@4�,ݩU4ר��R�Z��~=������3j�M�V���)�<Mb\���������sƋ��G�s���Ny�^;ܥeY���XlҰ�1	����⊔��Jz��=�%8aKm���!�-6	[�,�ֻ?�1�iZ������Z�����7�ћ}���w��4^Wf���U7�����L���(����b�� y�<�tZ����y�S��<�7�~϶��dw�
˗#�^&%�jԢ;f���Y���n�R�~�QU�<+ҡ��*F�9ӟC��%=hSw0�8����:�1CW?Dx�9�����y�Xl'O�V��^�x�I?��0&��/r%b�g pi~ ��n�ۮw"��ق�&��(����{����!k�rU���Q����M�ݎŻ�.��Z��td����r.�v3�M�
y���_�����h�H���vJ>OAc��l�'��2S�ޭڴI�.[���XGQ���ݾQۣo����*Z�M0�OR!�H��n7���J���+��t�i
��4{T���=�Z�I��)ji����_N�5�ݐ䎜c	��9p��\�(b�-�ͼ7�3��jS�ü?�lÒɟ�)AB}�ԔN,G�6M�멍N�,#��z����[����(�6r���K�d>��K/�}�	j~P��I���WaB���s�k#7�S8�Au���Uvݵ�h�
��X��)��Q��S��
��I\s<W&ͦi�3��F�c����?��;�G��ǽ��tfBH2-�O�*ĉ��&f	���d��n�9ާ������
a��'^ʹ�ֶ�G���%�^�m_��oֶǵ��G܋^�G�G]%}Kx��$�i�ymx�������(s7��D������λWN�Y��s�a[O�~�gW��������f(������s�kc��;��î��E����\�jw�����mw<���&Y�Ǯ	��课W��~f5_���\/]8b}��9�_�!�'�>��nW��'w�/&j:�C���$ҒOf���t�� W��KJ�O����>G�q���~�{���\�o=|$~����N����{�9��;4�<�^v5����n����`��-�X~�&�٤��8C��{7J	�� b7�N�K�*�ˑ�L������^�[�����ӃO�'Z=ΛE��7���X
���Q��K{!(�ɻf�O����v���3��l�G��Q��oV>��]FG�TX��㝍7]�M���f�EбM�����/��)a&��A淴�<��ԸF���K������n"u_������/�>�B��zy7|����o��8�,��¨���M�y"(�����)��E�4�w=G`�|<��մ�&��eF���K�#3U�_��ȭ3k��Y�S�o��
y��U�1f!w(h�6����N~��]�S�OS�cƉ~�2�OL��İAL
��]��dr����{X|�Rm���������-�'�(5��[�Y9��s�C�m��\}&��[px3nrtZ\A��d󆘅:�I�92�KS���.���:��>��;
�BkM~����D4����(�*�i�9��!-��R��E��\v�"$7�ʅ���NQ<����79]M�	������m*���Βl�"�7��1�x��09uu�W;��#��u]�a���-��udxLQ��#�Įv|�o�T�U�"��Ip�m�V��W�6X����W�5�Z�n3wríRy����s�m�5ܤ���u�W�	�z���E�?|�E�5G	�qx�>��A>�a���*M���q��}CDV�[o��qG��x��4��+�ى�|��޲t�R^R����ME~��a�Z��~.��Ӂ����2c~�t��ew6C��5�Σa��9��_�[\Z:b:G�Q0�X�Sq}h��s7�l�=�|��MQ�7�M�g[}��O��������+��D�ڦWt���g:/�oE��1���Fa�*�U��e��r�a����.nt�0rW�r�s׽�s��D�>��b&04��T^YU�5�v-��v1��n�w?�_�ʿz�O@�p_��G�EH!���;x��ۥ���hM�ߴ6��N�lA+��!�<�$�x�"�ڥͿ�vn�:9�	��#n�,A��╉���su�޲�~[���f��g��=���>��ˋ�=C:.n��K;/�\��ɍ���8�]��3��=�O��r[?z��\�:�O��w.���_z|[�������ۄ�Q���](����BM�$��z����ŵ�&1�p�h�g$T�]7��	<0�q���n���d*۽h)��J��m�b���y�h^'��O��}q|�4�d�7߀ʀ��<ǰ��e?�=m��{�R�ud�79�O�����,2��+a%�������E�/_�I'����uY)TT,�'|���2��e���:�Q!�t1I��N-(b%�!����"~���T� ����#&��]۵�������1�9�mc����� +�,��ֻ�ڌ�A���R��Gj���+&���;���3���T���ҍ��x�>�7���8hC`����I�Pɟ�
Ex���Jw*=��i"Q6Rp:!Ӥ&�|��J�ZGW"M�1�4�/�l��>�������7ˡ]S!�9L�V��K���euW[�$t_S�$MN��ӊ�L�,����;{������S��N�8�9�bm���|�����Q���c����
hQF?��c�5`Z�+�̰��q�<�"��i��D��sJ�S�Pk4U_<oP����Wu�s;�p؉��T���(F�c���?u���0Gg�o�*��;��!����K8��p�ʎ��K͝A?��wl�����z��H��g���3+���c��^�7�>���q�n�Ӏ����Eۭ����V��z��u�x��n���[_���s�X�{kw�^�̘L����6{eq�rv�iZ- �k�ϡt���N_@�E������d��G^�+<鲗�HB$<�ʿ"���J�;k�J�o�)!��ߪ��\1�1�-�;�w�,�gO��B߉h�Xqi^<,�#f3 �e�`Ȳ7��Z�:�jG�^�1���" ��~4�^���
cZp1{8�g~)'ޙ�&�Ĉ�TD���n�\kDR�Ԅ@�j��'Ԕ�œ!��~����l��d�qL�{>4�qs^�s�)��[1���JS,�)�
s����!���M���W�u�dx�;#�
,�5I��3��#m�U��]��ƯYC�o��ǉ��wل�U�`��þ]m�i�~��/vH|�����4FD�6œ�F��w��Jl�$�`v0�V��Ԓu�C�.GO��)�����G�>���"9f�ui��uj�+!��N8�rs�(���c�./�Ҿ��ҁ�R\�o��@��}Vj��}c�3'�g��{���vd��^�_��枟�^K���}|C��*��Y�P�^�$�.�+��R���#è�{IlA � j�@����O.�u������9 ��- @0*���`a���A ll��� �����������A�*�a�t��s��d��p�� �@W����5��� t�@`W;T� prq���!��^ 0@�z�t��w��[<��- f ����� r8ZB5��
p���\� ����
��%�����8� ��s�������@#�?T���� f�|<Ϟ��y�y���������f< >.^^A���'�%� �� � @��@����yy�xX��'k 
��^
��vt9�{�"i�f�E/
�������~��`����D�������h�� ������۰��9��f��@nn>nK3~��3 '�9���%??�����y8y��PK��ǝ������w�� ��XY�z�`� 59563 d�G{h��@���V�tp�w�q�̀`; ������ �%T��(���l���`r��CX 0���G(�@;��� �K��  �`9��������j�e���#�M.XO�.A�� ,�6P�4Tf6`�5*��%�Pr :� [;:� �.6N`n�ڀ̟��;B��� ��XI
ho����Ɓ����8�Ŭ�`��@�aA����������� в������@�6(�f��8BU@����%�� 6�,@0 �eK'�+�J��4 a���qut�Y�j�m��6m�:a���c ���� ���C��B`��=�5�wa:X������(L�ol+jvT�͗��a(uC���P״��,�--٠a���3��� �s��
���8 �A��;��A.@{V���oSNО�� Au�����B7�����MMUIZFX�݁. Yy-��Zr�&��2*Z�W XS��cCFvfQC&vfZ����s�!�ltB! ؜! jcZ�jj 5-5��+ ����g��ǰXi�|�[��@Wh�B nN�6�D��тNOTW�@M��a|��`�� 1�1���@�����f��#���� �b����``z�郊� U�� ��ǁ�P�\���������\h�ќ	�����
� (@18� r@(�8��2hڨ�ycs����?�rqlݠ~��,a�{hȿB�4N�2�*��~�u4�M&��^�*t�[�b��Ö�V0���N��?,�����ہ���?��2����_Wh�A�ڮ���h���҃����tx��m�y x����i��^0���5�g����Z ��rpr�xX������;7���/2����]SP��u�C�'.�N6���]�`�������b��Q� OW����hru�@h�́��
�7$��H�gusA�֯��������b�������?g"0��0���<4��~�>-���Q�! ��<�#B��E���d�}f
�����#����f	����6���*�A��%�Zh:]ܜ\�h�0�����6���PtP(��WP�@L���	EH��o��~�� � �a��M��!)P���[�P�w��k�@�9�a�aC��� ylF�*�r�[�[��eA��o�М��?���!`вy��?~�7��V����oD��EPK�?6,�`&�)��(�P�1�����;[�Re�V�+�5�e���%������� ���.ؼ���E�����K�����A�
{��ppt���?��ɠ�Ca?;���4WP�`h�Ay	:^`5�/ߡ���/k����J�K͟� V�E�?uT�`{/��������o~h}���/���o�����'����?\����������濑�������YST��)s+跾�1u��	J؈zh��IG��0�ߔ�]QQ�	�}�������W �)P7��Ìt��?L_��?��%�������Пs���0�_	�R�{��������_Vxn������_Й�
�N��EA�0f4�d�Y�08`�(���%}�`���@��ߕ�������ã��(F�=�5��?*��N��D�[1��oʹ���������~��#�A �����`�M%�?���X���ݐ�NSKZFC�!�����-�D�ρ/��"M�k���OĠ���?�C��_��/���_X�PZU�DFE��C��K �d�t�������[��-�Ϙ|��9:^��0���.���B_`�wq?GE0T���>9`+�B�?�Y����-`|�
e�?Ulk��}�$�}�\���O8���>Y�w5s�ݻ]�3sv��l���������fg6{��^���z��=]�U�;;�7$!EG$�@Ď#��'�B|1�`���&Rb�;1���~߫zU�=3�w	�4����}��}������ޮG��� �"����D00���6n�w;D��!EC�pԾK�B^{��%4����$֙�$�#`����h]�%ﮏp�:�a�!yJ$�]�Ga l����rW!8�Y]��0~ALt�*F�`#�O
��!9�� V;>*�B�����X�se-ID�� �;{�`��؏��Մ�:Ƥ���q$6�i���ȹF�u;aW�fXM3D�%�����N��"j�G��M�]XPZ�A/�EOҗ�yDZ6�7��s	b�K7��&H��k��c-n�yw��we����:B��Ac2!D���i	?J���!�_���A7e���s�Nߧ�d�t��IE���$�[[��`��t�#�G��!�2� �\(̥�^�8+']�~.R�<-F�I5�EH TAI����Q�,GU&h�{Je�o#R�X����|�����<�X+�>�{�`S�dϑ8�0��z�,����t��9�4����Y��`A��{��+,u�E<��������P�@2�{�0΂��O�֎"#P!g�|(�&#e鲟�cՇ��
-������'t]��?��ܣ�==�:��������Q�5
�&����C��?u~�e�����kh��a�r-u��:d��~f�4v�TZ�� �k�啈��U��{�R�Z$�В#��I��<���XX�d����h��1/|D"�EDt���<�C�(�F�9�P�~A����	 
������pGޮ_:?6�6��pD��T7�xb@�P�� �[��B��:�IvMeN�5A�[�<�����82:���mՃ���|�Q�UaɸY����}
�9��DE�
ѳ�ϟ$�TՖ�b�|.aU	+/�RWSsͧ�4s&hb��N�����O	��Qɘ�rq��8���	�� ��B�4���0�T������h����Z����MW�W(�Jt�9��A��:�H���U���iT��:p ���U���'�Ћ�-����``"e����b�2�6j��G����l�����$�� K�!���I�~#��ajf����5�J�n躀�豚4�`7T�m~��z �V���þ��7/l*���������/�CKA�!�c�l�mwB��}����v�V����)ӆ����:Ů>�?�Q)֙M���LW:���q�e7,ϱ�M�q���F"u��P�8��(�qD�,k<��T�k~V�'�Dg�e*�6}Okg�٠�F	-�x5�*/]��M���N�Ɔ��N���W�rZD�HE�_Yݸܾ�qy���y����u��uVK�F�it]#a���`��p�W�s�Po�	0Hr��k�nBֈ:&�C
���U㊴������@�}9�G.���̛o%iu�ܘ�7x�9)�t*�0�K�u�n�!-�:�f�'p21�j��	�	���(
����S�,�mB��q�%;a=@���_on^�������N7G� xIo�)�n��o�%���
�����O�Q܀f�8�N�~{s{���"G[��IK�%N"o��9���q�&k����_���>�t�iw�
A�]{W�XR�Hɀ�e<v�~������;�=�?dyC��8��nv��������Q�%N%��u5QXG�4���ƀ�N���QQ�V�xJXk�P��T̞&�E���yI��bepDɅ�s�+�&�2�j�8�V$���[k<K�9'7�G���%�D}��E5���JS@ø�k\-�� �GE�2~���z��w�"dL�%��2R������t?��p_6.������K*4K2�*〷3�O��a?��=������p����צ���oacɡ�����V]�N �Id#V�E"�#���!e �:�K#6��@�F~�jn|�!��\O�Q�5"qA��*ARf�����ȀG��`�9��􃄃̭�O+�Ņr��M�$��$��۽T�F�d���p��S'Bo�E76v��a��@
���݀��0١u]����W��e���*6����:B]^k�^��Z���t�o)��;���5u�Qn�
b.h��Ν���y��.fe5��M��<�p�������e��؎V}?.)B����4E:��96���t�P�or|^�~�Ju���)iE�T4+�Qa{�km�T����rt5�6$6�%�Đ���[ �d��m�^@�ǌ�v��=ك�a���ٔt1s}��Z���5g$ӵO�����,L!�K�"8>������lZ�Ko*��1N[�5�� �`ʼ�ٛR�:V�%�@j}4,��]�ٴ�ZR�=�FV�Uu���}@j,�J���?\<�̿���X]{S�ܶ��[1�����P�˧�kk��&闥��s0(�؍@����>/Ke/I�q�� �!�k*/��q��5��ʻ�Ea����s����򢰧��Y�W�A�g(�܂��!��Te�R9]��Ĥ��]$�=�3VW�E�?]xT�f�)�^���oDfHK"S*���uu�8V��F�󃤵��i�_��Ɉ�6�AZPH���<��K�s���Ge�{#?:tͪ88P*[�F~���j�����e;��z%jj�o���<s쬿�]��|�#d������緛��:&�@�aI���ʆ���3J�n�|��C݀¬�x4�� �ʬ�	34ӭl ��4��K�ܹH���r(�琉�H��uF�b%���X�6�e�am��m��*�ei�It��Z�x�û��%��`�}���6�6�/o-�f�Vp�sl��#�ٺ�x�k�&��vX��}o4���"3��hG�20	�y�fJ�Wq6w��w+�.f�kK=vWv�a��QM���?���
,r�4�y����"�a�k޳SY.�YCD�.V���Ք��mf~�֕�uzq�Ir0 ��u��(�}��/���1��`w{ �IŜ��1��I��m�����������װ��D������b0f툊ÐB]�|�A:K%m�<�:�Waѹ������'���.��̞ .0��/�7	ZH
/w�Ա���+][�������K��]��>�v��6X�߸ZS�t����!��r�\-͂g0iPչ���F��DM �&�)A��B���T��e��1+}p��wd2[��	lcc��"`S�윲�F���=Bu�Ӕ!��ɼ�h桦������2r���`P4�:8�Gs��0i�]٤pyo��Y�wc����8],mi4j��L�E>�TF7�S�����n?7$��C#Q��	lRq-I����������jj���{��8��&��L0R<�줡�ݻE�!4nNX���x���L�B+gv���yK�8�SAFk��؀��2��T�ڹS��I���*��L�J�?���z�\�u�Re��#y:��M�w�W3�)W��B�p�J����cjQ��Ʋ:g������"��2��yM��i:e^����1v3-���#���~:��5%��Y>y�`��J=T3�p�AG������j�r�a�M��IE������s �R��|
~r�E_�]+j�U�nn�%���A�;���}�����?����Լi�Zc��k�W�������E�˅c�~S�)|՜�%|�^n�~q��1�.2��}$׀{�mş{��(���fJil@{��0�Bb���@g�"�<Eg�!��M%ǉ�
�rWpQr�^��MZ��$��b&m,��Ѿ5�ƈɠ�2� �㠌-�C�/9��ϙ�����(��=y�;tG^_�>f��zv�*'-�[�����T�c��d�-C����7���Wh���^�O�f�/����zd�+��=���0.c�<����V-6����_j6_򓵃�^�\��U5n�n�n@�)�0 !R��^x�lv4�#Ky��.u��Eb����9��5"|��Ӎ�x��'4s���ң!��UF��M�l`��(#�g�ޤ|��0!�(�x�*���}_oQI�n����غ�޼���yU�$͞c�Z(��1�������f���g�����cM	��G�����"L �ҧG�?����1��C1w�u�w�gqL
$Ij��њ��&U%Pg�{�erBa��lB?�a�IǏs���#�bM�	D���؀'4}�=-�*ǤlGQ�>�\F9q4���	9f�d�5�� B D��������lr��o�<�����mӏ8�/� ����kץ֊��6e��ԙS��>8�p����z�Q{~8�! %d���	Q�k�5�ޕ� p#�̃��Z�d,:��>�q��p�7�/���51�X��� �K##U�m-��P��򒕧&�Gݔ��n7>����h�S�q����@\�j�TD�x�Cs��{��m^�B:���K\�К_4��6o\_�K��K�����K��q�����%U嫲�&�W���OZ�F�N���U*`�g���aS�.��攪��MB��פ2NMFp�sas���d�`���,��r���1�9�L�6�}2ό|��j��;	yE*�F#��ߘ���G����c���yW��\�/�r�L0p���5O��	��S�ӂ9z;�;���ע)�zF(�	��g'.�z����7e� �ǳ;p��F��������5�����Pm�Ψ<rc?�a\���]u�U�HE7�܏����{�r���p��U�S��̶*�&�3��wPpa����Զ�����v��ݦ~���f2a)��@>�vsF��vs
��n���OU�?}��;��ˋ��ǐY|8�I@.d�75��K�����@�怈fNK2I5rX�i�R:{rɀ�d$�N�q���jy�z�s�:{�`a�'���x��B��/��V
L���#����>r7wNk��ҹR\��S�A�O��.e�Xc�uK��	a���2���P{�D`��gOg�1���?'���ﭘ�aХ�Y�~�ߜ���z�����)9����͍k��pR�{T�]��q�WW@s]�(�ӛ%�~�C�*�-����R�5X����*/�kP��g�ϼ��	�ux2(?�o�i	�aV���X`�]0�.���D=i���3��s��>#Rcɇo��[��8�e�XQ�BJ�TJ��^) D=��v�z:
� [j�b���8lV���ʴ�\Y0P�L}ou���c9U�*�3��"���"�f�a��E�q�X˥���	k�����]���;�;x/G;�]}��=xd�ƽ��/��J��D6@��d
���#���!�[�PfBo���9�fΚ � fԷ�(q싴���T��2U^&8d8v��uj
���',\D2�	�p;�'��ƛB�K�OF���|���z$��|��4w���q��1s9<�����o	���P� 8*�p��g<	'�h�J����$A���W����B3�j�O2B�DL ����1������yR�����ugYb5�������_���f�:usV�;��U>+��6Ǉ�	��������*l�̇��dV��#!P��44%��@zg���4G���cFԬk���8U��վZc�S��;TKEV=	D�}��G@�Z�ީ�8U�5褶��U+Z�G����K� �jO�R'~����qn��iD�9C���*�p��uM_~k�aٔ�#%
�g�ϳ�}I3��ҼcI�h��H���z����-#G�m5nM�[<����u��1����	�|���Θ�\��B/�����8p�AV�׌�̀�Y��|Z�q��#>v�F7gH�!y�v�D��?����2G��',,q��0�����uqԚ�ύZ3��9§�S�1��D.e�-$��њ�������0���D��.f�l_�w:l����4��lR�2y"!.�)��f|,�,�@���6�����X�R+�p�������4ʦK9��DOX�+��#��ĥ�k�<�����0e�H���U278f�֌��YW&��%4�O��$�lУ��[��9���7_Y��_�;L��~o�\P�Ԥ���&�ě� 6'y��/TK9�$q�쫎8p4`��\Dz\�/ H��!�ȫs�.E�`�.�R�#�cH��gl.'y��#nz�V@�:!���eS"�h�����7�Y�xI�f�=ި��� =����ƌ`���f�"7��;��D���O��b�i�·��!����Ҝ	��![���Bz9� ���@�D"K���		���|�����6��
����C��%0�Ԡ�a��&�oz	�������sz�"��B��P�(��/�Řmg}�� �I���c��uYZ�s�ĩ�C�L�a6}�Z�y$l.��&Pts�t���=�~��e����2	������{�$iuκ"7/G���mɎ��}���DG�	���OrW�s�$��Z7�i���,����8vR�5K&��Gy��qOH������Y#bغ�NPȷ�ฑ���F�Z]s����z	�Or��u�������\�FL/��]�7��LB&-߉t����S��������	��XQ3aʮ|:�"��e��ɍ�v�� S�5H���+�.O�)w_Μs܏U�r���?6�����E���p���U����SrX֚���'������D\������uŉ�U��p�%;��V57ZHǼ�%L8�M	�d���i�֘�u�Ӌ����MKg��Ɂ�׺LN��/����n�\NL˄����V�~����̱�ZAN�MV��.G} ��������#�h� Ѭ����?쇇82t�dl�׵�>i�f���ʟ-g�����3J�ե�<TVY\ӤL�䶯�KC�8s�����T=�|_�d�#������>�5�>w�~�����N��P�û�r�>҈��X
ឱ�����{�n���t��h�T�H~L����ӵqrJo�������7��;=�z6?�so�ɔl�75-�n���qgl4�;:�d�o<��ݽ�=�]߽M`���Rb��%ᨦZ�rm��|UJ0�K�/��,������]d��l��<�"���Du��IqC��~f�z��T4�D�tآ��6R,�k�u�ک�또�;��O�2���fff�����]yχ����������z�;�uf������ߤ6�����:�#��ɿ����z�������Շ3�D����CS���k�U��+yx?�_���������������v�3�����խu��O�W�/���G��ٷ7���~b�=���}߯��<��gf�M�������s������?���'8���y⇿c���������\������������ͼ���=/>�K���~���Wg�������w��O��|�g���=�_���r��w�MV. ����}���_z�y���<��s?�3���:?�?��λ�������^�g��v��ְ4�wj�������Uo����w������^��z��|�W���ɟ����gf�����;_������k�m����U���������w�G~��yi�a�$p���ݕ��b��?�g^5�(��w~�=���_�՛g>�K�������_�)�_q���<���'���'ͫ���=3�����g����{?�_~�G���䗶f���ԖHOcHp>������̫����������ť��w_�;�����[���ٙ?~?��;^��6�	�Pk�穙�E�8?��g���/T�;���瞽缱���g�����۟��ѧ/��o�Ͻ�\���<��ν@�J�{ᾯ�w)�ܯ�/m^Y/�Jm�r#���K��6kΖʺԕӐ�?j���Z.�F����7�j�!W$���
K�-�c���S[�W��{>�lj��1a�MQ�O�D�@�6���|���A���������>�?&�-�s�&�X�$��j��%Ͱ��������d��]߸�]�憗h���2LP����<ҋ�-�f�Oe04��@p���E�DI��LT!��/`���̖n4�FxN�T�f���L���s���/� ��#���^�b�հ<=�j�T���C��(�Z~0��<9w1u-B����}�[��`N��+2�a�#�b���~��ׯ�*__���[��+�ۗ6/���6��S$��i�[eA�|�ʕ���!�8f�܄瘎��hN?�Q/����L�����S��`mCM���ń�)[����-�x�?fθћ`����;�P��[��j)��d��vA����(�|\\�S�nq�T$
|!��+$9t.��2i�1�����G&*�VJ瞹�����k�j/���g�(���r���R�'4�
;��'� F��rnl_t?��_ɖ<�A����k9A7�k�Wt|�?Ԕ�C7���o-��$H�����n��=��:��x�!��C? Q�o9b��|lS��nK'����䕔�|���C\:�{�5����,�Ҏ�n��{G�*E�ْc�8�ኟ:�uI��?��Vr�dq@Ls2�L�&������:�=�'�e��5/�+ ���`0�K�W.��9}�KI9ΊF�9א/W�yX|��
ɔ���/�ɚ�ILHlrHV��ƕc�,��a u
��)���Z�0\6�������W�R�E��P��`�c&��dM������vݵ=
*e.G�gG�s�a$�t�!ʠtn'�jy��U���qˁ�{,DN&^��WxaL��6$R(FFy��[�����`i�-z)�a���*��we�B�1bX������~�a�)�w����to�MI�yP+
�ŭj���l��������!-�JW{f�Y�����]��I3h��h�*3��EiЪ��� 	�oL��s��tŸ�)�/+�4i�����0c�r�E~0�^�}��v��͢��ԈdfK>G��&{̖dI�ƿ�5�1�j����(I��$���e���#�K��}/�����������P�|M�4|�>�'=�(7^��j�����2��1nz�?Z�����EC�����Koϋ>iR�yf��L��s�㧲��;�e�V����d9�,kIw� %�㻌�Ł�c���?�{�y�M��_Y?z1����^�ͺ�j�t���)4�EE�r�t�O�zC9�G,��1�J&�4߹ :=�qۈ
�gZj���L}���{��& Q�:���䭣"��S��֭/yq��(�@Y\Y5�AlZ���� ��M�B�Nuܿ0�S{��p5�E�����������⢂��N"C9���sj(:2�)�n6N3{�>]��j��բ�������f��9�C�]�^e;1�X11�����.+�k�pH�Z�����8���F�n�Q�M5Ql)��񣶜ͩ�UM-U!�%m>O)f�W2Y�8�o��)+x�̚���9AJQ��L<K��Hep�\���l.���Ӣ"�I-@�U�⯔S5O$9&��{����N��A��v�Ş��%''"�>�22O�&�"`��Y����n�ry��m����
��;�T���/Ou�ǘ���\���]�:�
0
��
�5�����^���R��cS�]��yb���-�L�P�����쾟셤3�JU�&XS��>�-��MKp?W�?XV���v\#�N���]���dq���i6Lm2&鈂�A�������0Дz��#]�Y�&~���I��MY�\451���V@ew��=
������$Nz���¢z������1ÿ�QY��1�7���)��ܣ����Q!�s
fȺjV�<�B�G��	c�i��U~=%ar]S��>�$����	\���)mg�_�㖟`e���"�'�����+a+kq�^��(n����a�Y�/,N[��|��7in͎�r��:7ޔ��puaֲb��?&ćH������d�L$A��4��$�t��v�W6�>�	s����+��k��_V�[���y�`D�}��[<��dC)��3����$ǆߊ�L\we��9Og�{�*��1S���9j��p��Td�SZ��2��"/}���?4�G���6�/�44k3���fZ��d�˭RA�^��8�[x_i8d}K��3����7���O�����������_���>�++�?������/5����fff^:����%"k��hx�;��}�$��?��;#�c��x�W�n�F}�WL�v\��h�"�n
4�炢(��7^K��S>"/�u����%%Z1
40Iܙ�˙3��!����L�s�gt��V�jC�QzC�3����L���l�	''Y�3;9!�IP�V�Bz�4r�oTK���v$�ʺ�����D7$̂��l)8Q^��HhͧU��/���4� D
��2d��V�R�e�kj����I��-�Z�%5���rg)Jg���p�vɭ'��s�Z�'�DnNh��_���X�΅���tT/$�:�R��>8)�cou�5�3X��A����}�����r)�6�T
N ۘY*5��K��}W�$|�S	o'�^LhF�T�T��2A�BB��k��̓牖+��R�)<��@y�M&�,;d���k�G��v�r��pF�;C�.��wJ:k�R��ǅhۼ��+���a���2Z�s5~��e�\�s"*�b.|�˺�����,{�~��G�}�"�~e��mS�B��l�����1]�P''�(�^_  �{�m\cW�v�qm�i��T�R��\�"���$�X�����fÈ����^��[ l�m�t�ߴ7
�⼲�]D����͛5�B�_��"{��E+M���ٵ�T1�F�T�e������MS���a�Ã������hFρT���*g�¤���_*� Ӿ le�PNR2�t��46�K]�F�>��'�>L�2���`	����z��MN/P�#^('K���+Cǅ� �,Ͼ|����O�K�O��n���t�\�A��=2�f���M`��`7L i�T���TތN��K�Й�6�Z��4G2���Rax��L��>l@�y	�K���&�#�����Su ��L��Ȼ����)=���P+%�r�V�2H����@,o��"8�4i���۪�mV���>9����Ak�U�w�S�*#	����j�̆WA����d�;�?��ڮ�9����GP�mkj:8n��uA�o��� ~��j�l<��Y� ����6���r����.1^.^ʐI��VF�o�ILW	�q�r��s���5=�ǔ5M�i�!��b�y3�U ��ځ�4�>V�d<&�._\�8P��w��TE���T��&+�f~������N�9=�%Y֖zƆ���.5��g>���T���$�p�ìR�m�őɒ��$fՏr����bz�>�߰�H�Z`�B��dx4�%p��⢪�أ4��Fo��x;VF<�X��2���_���ùݢz�[W��q�/��J{�k�;|����>��ɤ����UuI���+0G��8�%�����շr��T�ˊ:?@j@��ʃLj/G���Srp�[�G�%����=����>�l{1d z��>�3����@S��.�(>��S�Pi�C�A����A%�\�����
p���h��m�;9w�������l-t����tL�)�	����o�PPʞ.�Yv �b���f��*V���~1p��3a1vJr��)kT'��B�����N��(�+��SAa0������+��f��
�aRZ�g���C���湪E��䆗�%�HՉ�#,���^"tz-pa��l����"I}�?��j��B��)h0�n�W���t7�*�(/����jt��u>z�2t�h3qT]ۢ��u,g����o��P��d��d$�X�2��|��%��u�<���-;�-��^ba�|��K��_��u��Dx��$s\|C3��&��LZ\�
��E�%
y���)
ѹ�٩��z��H��3�SX�`�6����\Y� ճ�x�m�OK�0���)�Eh��}���BQ��z��M���mC2Q
~x�������ރwuk�Y]�-\È_��4��l��l�4���jB�i����kۖ�+:V�e�TO��/y_�-TS<�����s����ZVv:�"�攱C�2���A!%p������G�8�,�ԑ?��eHLL#ҥ�/��3��$;gwH@
!�+j�u� �j�D9��@�z���}����k鼓x��V]o�0}ϯ�EH$�=7&�m�Z��R��2ɥdu��v�����4
TZ��%��܏s�}�h��3��)�8��	P#�{_n�O{L��7�i��nL5%����5.�W4Mؖ,)$j�K	�	�U�#�L��Z� �x`�&��A4���
����Di�7���,�lʰPS2�7u�a��sɡ����K\��+��kA�����>aI�:^�"Qd#M�}��)�l�������G)�KJ�۔����!����μ��̃�  S�
��Z@g���R
y�)�BCQ6���hӃ�*�� f���1z�e�(e�Q�ҢQ�����h��;��F�FJ������n�&�8窵�-S�i��]i����I��
�>\�Q��,ڠ����M�����W��(9�NI}���Q�f�G�B��s̡6�K�Z��f�$-����PTG�<3�H� ��
���7�����d<�� j7��cnn�A{��қ���l�nۋ�Q�)��K	�vf�&�}q�ؔ���s�;o�ەͳR��3�̀.r@,PA1���sbL�����/�w��\7��he�@t_F�rn�VY-t�ߵ�n����I����)c�?�G��Λ��oc1x�uS�n�0��+8�u�ކT���m��a���h��,k�4(��c�k��K$��I�O׷Ww�~�@+�[���}S)�jp��	d�	�i1&�J��}/���!�Ujʹ	}��B>�n�J[YZ��bw9�,��HU�����8Z�'����7��=6��b��cn���<ت�[xy��al�/`~y�h-��?��nP;z>��M+�����a��B�;v�5fY�Ч"���_���1��#��>Z�𽧣�M�|	�ܠi��;����	���������\f�jy�P'|x��;�����r�{�.���(}�Ɇ�îvzKil��iv�7LÛ�:�3S�Ԯ��͸\+�j(�B�R�c���A�}��xH&r�c�.����
�����$x����N�0�w?ũ�Ȁ�3*��`@�X��8�±��.��c'M[Ā'���s�z�eXý$k<·�r���`��t��'��0Fc�>H��c���˃;�U˃��$ʓ�q��k(e|�Z���+�v2���I���N왉Z�g�!HK�҂�Ɔ�B��b����j���s�AlH���]�>��%�?-��ޝ]9W��XU	�%M~��*I+���p�H��wЛ�vZ�'),��O׍�pY�#Ӷ�:�ܣ�Mf1�� ;�a��]�NW�ޢ��^�B;~K��~�m��Ғ����4��-�r]�~ Y.�Ƿ6x�}RQk�0~ׯ�f;���,�+tб��q ��ɒv:7-#����$�uӋN:�w�w��\�]�r�m��|�A��7�k��.��ZZ�b>��bYet���1�!wd�V&��V)�6`�	+6���V�-tv�˻%�;m���b/ĲQ4��ʧ ϔ��>F�x.Dy)n#(`l�#E�C#v�OL�b��r��r W��(.K�[�Y, <�E�	LF����26����ⱳ�����E�%�I� 4>N���0��+�L��+`�0�{��=e̙^M�=EU�����t���^C�X��ߓ�Ňa���0�+:��5":V��Q�,������0�YYW)Ӹ��w���ͅW!pC]>J_�X��o�`���vT:�/��k���P�����"�6z�$C������;[�v6?���I�`S��6�u�B-T�(~��4F��\�}w|���������+�6�70$�i&AD�8�;����;�)"ػ�� TT�`D|�+Ď��!*
*��sνw���~�����_�&;��{�3�_�칽��w˷۫>=k�ҿ"go��9��y{�y���>3�>�uK΀oN<y���G�0p�-���m���9o��W�>u�w+��v��ߙ~Ƌo�����O���X�O׌-w�����sg�\�]�w��N{�����3lI���&���7��ڸ"CYq´3_��_�H�3o����]��s_����>�ᐻ���-�_]�}ٲ��m�������Yuw��W|�T�WnZ~܍Ǘ^=�ʯWzNx��ݎ<m�S�r}<����k����1���_/:W�^?qq���'��O�0���j\��T�qOF��}'���v�C���Ž5��o]P�Q���?u�K^�����J��Sr矼���rΡ����3~]Uz@ߥ#�]�0t���~q����/|8f������U;�۾��Y�?~*o�֗o���A�]5{�['l;���W|}��u�Ͼ��l�i��/��̲�/�Ѽ����}?>lH�~}k�^���췿_��zon��)��Jˇ~6k���Ԭ���Ϯ�}��CO}�ݛ���6�k���+�q݀�r�%���1��I��:�����}{^14{������lZ3%l8���O�h���O�=N�u���3�D�z>�9�ߺt�'M��^ؒ��wo�G��Z�e�!���u�A��9ֈ=���ܢm�i�q���J<{ߞ��Yzz��Oz뫻�>�����e�5>����\�Y�}�쇭W>�hn���g�~��Q�3WFb�^|��K�����f��,̿k��g��]��Ak�g/|g�C��p���������0w�~'l�@.q��#ץw}0�{gHkvJ��������_<鈏-.8g��>������-~���<x����.
i�]���M�>��m���ms���v���e���\q����~Qr���$x�%/]�\I��{�9i�-����īo����>�|��c����q%�"�����2��P}��q٣��=��r�\��SFﱧz����Ǐ�A}��/:g�b������&ׄ�ry��S^�����.ze�C�K�R�w�y�3sB?O�r�'�{u��S�m�}��+��|z�W�?�f�7�?w����3�ɽ��y�^�������VN�2��?*��VT���'��	l�ߟ�|_���Ɓ��?_v�g+}��:oX4w��o{�8�ϼ#��G�}�'維:����5�n:��b�M�ܲ��n�w����Я=�x��K�s_�n��5�۽`�>w�q��/N���E���z�}�����q�z�lz���/{����t���3+Wq�/�.���3n��v4>���Icl��C�m4���p�_��=m尶�7N��7}�SϿa�sn�|�i���o���{d�������]�涕M�L���|X�u������[v���~y��K��|6e�=E�o�8��������7�܎�ߔ�q�z��F/Y;e���{������Ɔ=�i�|�򆗷]���=l����nH˪[��<��z��O�|��)~�ק���/�O�6/[�5%P����[Wx�s������^�����}�t��+:�����?�y��݆��g˴�W̠o�xƲ����ﻛ�q������z��q�������W�z������qJ�-C�g�躮j��m�_�{ma���~��K��w��Z�Ԋ��}���oX�[�{��x��n9�=p_/ڌ��?Vu�a����QG�y�7{��0������8L��g=[��뇿��-y��^6mNnNNQA��R[U�P���6c�}�7�>'VT��'~v�y�� ��e%�
w*��:�����KVϫ��n��g���p߳�ah���#��~��W�e�YO�ٿ?&0�u��?x`��AF�_V8��~�����_��9��L����Yq�#K��[�xB��������n|r��;F�xj���\��9��w�m�.���~���S�;>���/qYy�Ӎ�����^�G�������;W�~u��O�{�ߖ�~X�Ɔ!7�)���Yw���f�{���5�{�~9ﾻo{�hN����:Y߶�	�þ��C��o�8��S��v���|W|�-�7����?�홻a�ف��}iSY���I�����q=�\�ߗ�iڻ��%���yN�#W���~���˾�q��9�_?��'{-���k�G����M����k�.��΃u�����<p]l�GW�ػ1�R�^-��g��t��7n}z�֊7�>}��ȿW~����9���xȇ��Y<p���fh�?}?������w���)����h��O�Y�x�������m�cn/Z����++N�~������G.Λ���W7����;���X���˦���Ɩ�IK.\r�6�����߬?᧯/���I����Z{ö�kN�pʏ����?-8}�SgT������/H�����������7J��~��3�t��ܹ���?���6y�מ�w����郗�iú�[��\����^���o?>��+{��.�'ux��W��ܥ���}ē�2�Mz��~��x���^[�����zr�Wu��3K^���|���_�����#Ҥ���f��zZ�^{����ޱ��o��#��]���{���^����޷�E=��YuڹQ�/_������&������f}�Ԇ=���������z9o�<���猊����<���~��]�����v�Ru��o:k_��L������o��l|u�M�/nmk\sޗ�f�p��o]U0�����#����Q�\���	�_#]����f7�_;�����?|�p����O�7�-#2�?�v���o*8;��W��X�XA�+�d0���ơk�;�S׫�V�n��Ɨ�.ԫ&ݐsS���3�.�n����k~�A�{����x�o���}��-���Yu�M�叩9{~��9K�ip�!o�KSkNz�����5��zM=l�k'_|������lko�����F��zC�o��-�s����^5�s'��헫�Yp����h����b����꾼��w�K����͡�Uu���d��v��z҆?��9���WO��s�_Z]���{��sѯ�o�o����.|x��Kjϝq�=���M�^�8j��ݟ������oǍ�|�y������Ǎџ-�1�[��CQ��czV.~�~��c��9W^Y�|���m����n[�9~�)��>����/v�9o�SS�ޔ=kޣь�>T]���K�o<a����zq�c�>]p䂥�ӎ|-v����
�m�k��L=h�Ћ^8�/�[7���~�<��b�u|���W�����'�^��+R�������,=�҇�\�}���Ӳ�)�����G<����E[~����Ɗ�*�\<��1�<}屧,�u��_;{�)�דwL
�x�����~ݽ�]��Q�濐q��=ǔ��f�����������z����z��Yy�+�,]$�1���3~}���C"����*�ٟ�Cg,<��Ż��8�Ï~�?r��\1}��}�������������w�ιl����]ri�M���]����wؿ��f�5￻�ڻ^����UO��2��G��>��N��wK߽xʗkk��ULk�}syoñ���Gn�}�K�g�4{�M?�����>�L��ߔ{�|`�����G\����%|�uǆM��~��|�/��x=�Ů)�uϛ�2�ȗ�v�I��wk�K9?���=�E/���-o�����ܯv=w��g>���޳����˿����o�z�W���>��b�~[����_��y��ϛ:s�z����|�����4k�F������u@��<��꽳�-�~�7_f�_pQ��g�v����ӷvJ�~�����H�ķKﮜ~���S�7����T�{�o�u��{�h:y��|���o����:"m�1�<h���/ڦ�Y��e��?W/y%���.Y{�;�kj��vĲ���O�h�C~۾���N��%��5[?�q�UKG>������X�u������-?v�G��֧�j\���u��(�c���7��#�X�������fmX4��Pղ�z|�[�{������.~�5���3��}ޠ�������N/߻��[�<j��ck��ǻb�GL�$U]�ɃJ/9�١�:�����V���W>�z���8����_���kV?����N+����ƚ�	ښ��z>�¢_gn�w�%�g�����Gni�?��o>9iߏ2O<��ʮ}?=n���}U�ԏ�W�g�D��c�������%_Y������@�������E���=�1�s�Ϝ�jI�Gw.4�U�/[���p����-[�k�أm����:sܢ�n�Ҿ�t�{��߿��m7�]�������O�d���m~���i_���Y�����}��~������������G����g���f��E�w5|�z���|����G�������o��t�֎�g��|���i��Ϭ�>*|�����[s���]��߻=8��"��C{�~����y�춗���o��Oy�_��i��?"��L�兖���w�m�>�g��?��g_��~���7�?���^�;�������s��=���9~����}�g0�?��?�'�kJmM�Z韓��O;����3ӎ�ÊwZfD�r��,�êP}�?�f�?=��ST����%J��QQ����+,����s<^i���-*���8^vD�Q���#Z��*ZH�e��=,;fD�=��ÝaY������P�Z{H	��ree���h���R#i�tI�5��d�0�r9;[n��_����"�7�a�H,�Br,�S#r��f���L-$�!���ZsYYP	�/�iB�N�(���RuDU����Q5�#J��O��oQ]V{��������CQ55d�O�҈lix4��"r�l��j�k�q`�YrZ6Lڎ�������v��K��)�pY�j�fD�t>P��Dp���u�9���n9���y�_��S<D� �J�۩�`1�]�u�>XAH�1EO3Gqd��&���Q%�P�l`t�۩�.j�֭z�CY�ʝ�h�,;;�{�@�nD�Jrrr��\�RX1�hg$��BR�l��m�̨�q���JH��S-U��TC���F�pT6�z�@#j�i7:cQ��j��Bި����/2lg�Pes�|�pw����ZJ$(gF��HA5�JX5:�@@�tX�ʩ�i���}|U}[{uSCs]}m�<z��R1��J�2mD�D�L�
W �:�Q��򯶅w�a�Y���ك5��#�>p�h�<�������6�R�?_]���� pGH�юƚ���%S�DS̈��Q���{�V�y~���E���HΈ�<8\?o�0�v�m���sFn�'�h�}�(}�8&Wއ���C�W�����ТJ4�<1�ocvc-��ǩ�����p��Z��~v�y�FѬH4�=��E��~_N��0/��ė�����J�
r<�J���ğ���),�.d#�����ax�=y��0bN������+Jq�W)*)*�y=_�_��J^��I����7w/x"��j�7/�0GU|����ܒ"U��xԼ��ܼ<�@,)P�<�9�s�˾�S���g���r
`�<%�ԯ�s��\�����{�a�Z��x�ϣ׿��rļ���%�SZⅵ��}��j�����-�xr�E�Ŋǣ>�G�ϑ�/x'�žl���)���\�T).�/�/�����������\��Ⱦ����U�r����"�H�xK}��<�S�--*-.��*��ѥ��[-�hw6"~>q��禆�0;?��8/��S��+�%����ϛ_����(%^�#~�|U�e;��/�+-�âK
s �����-TՒR�4��[TP��k��w�������V��$'/�$O���y
��s�|E��\��S�
K�yy��U�g��_��F,�������^_N�'_-��/,,U|~ON�_���?g���)G���KTQN)숧�ȣ�䫅�����zKr<�����}؈�y���ߦQ-��S�9���U��
��
��S��@��?��)����������R����.��{����<�Г����ž�<�
�^)(�������~.��S�c~�W����U�ùS�|Hғ[�W�+�x�|jq��x�#~~x����6nK#��;�7���^�D���FZȯg�=�@̧���gw����.H�����W��[�|��hy��%������<Su :�T&�@���A�ϹgO�Z�*�v��4 =Ԣ�A�#�P��z�.����ؐ�_8��:�Q��sf���N>Q���g� �a-��.%��@)�����??����`����?j���';����+Qo�m��r|��M��K���!���n ��x��A�?~n<��W�?"��*�����y~^���7��:�s�6��������E9�&23�ay9�
���ߖgEGW"�A5���;8��f��SS�{[��}��}���g�w}K���ש|��y����!�^�5���u����J�F�%3�gz;U�4=&��W�s�^��$z(zǝ��Q�,��u�]��4�k���Ϯ���#Z�@�m�kk���kkhw ?�^]��t�4��ݣ���K��ΗYc����Ź�13I�w�A�4�z�f�5=m|SC-ء���he<,��Ҏ�=4��dɮl���0chZ;��:���j1ͅ����I��:: ([��'7 ����0�)����w(7�s;�j��^ݧ�v�	Ɍ[��Sɮ4`(]*[ u܅UhF{w�gO@M<���X�Yg��va��$K�D7[��/��֦���ڶ�I�Q��fZQ� ���٢�Q���)���PH���i$�~�1d��6%�@�A���f�����6�ˬ���(�i�I6T*>_;��Ӈ�Or��5�������HT��j$,��s�k��j�!g����D�r>�I�d�I<�\����P��[N������Ģ�y�u0��đ��$i3ٚۋ��^�Hu��q�vs�x��_��!b|b���u̘������X�nN�3�$��LvN�ӽ�윃�b�Z\4�U@��ٙ17��bG�&dɵ�G��v��sWl��)*w�ԛi4�!�tՐ�˓���&�U�����"�}�AU��2\Vy8g��Cҙ��Sj��&����g,Krvg���5+��SS���!�U1����mRs��FI�!ð�.5��/@EcTUX��S� �T�&���,q���W�Po둨Kx�+]ݚ/�Y�S�4��I�e,M	d^%�V�f刡�Z4���`�79����7(!�C�`��9kK��Q&�<��7�A%ҡ���.�aqZ�#�{�f�Jo���=�G����-�ssr�:�����L�?��UX�(=d`(D��o%���<�NX=zħ����7@3���#�Z$/޿[�2M��3b��a�hDv*��IKV@�G�����=���1+��z	�&2�� ����@;N��9U�ݪ�il���"��]E6��
�<��|uހb�.��%/#.�Q�U�͚'틋�]�<����lr�O���	���ږ�z�y��j�{�ر�;	���|��W*�r^NN�$��z�� �WgЗ�؈�ʭ�?�6�<��H���B�,�(FY6���,=ґ��R#�@�f0�5�@�n�0< \�㖡��CM5$߂�8~ ��}zcx��2�����Y����V�}���eI��K�����2�Vm�7�ԐBl�y`6����*@
*�?��HM@S26p):(�yؓ���#ӌ,1	�Ŵ� ��r��aki�XXg��TC��>	m<1J��+�����.�b$B�J�@���K�(F�-Ew�b����SG�����(%̈��.FO�~��w �f��@7b��+�&�\`8��DكD��O�#ĩi#a�B���L�T�
1c9��6���q]J����@%���(Q��%�X�S''�1٫�h$|�����X��%Lİ_7 "�*�Ā	���"�_�D��s�n�p)�5��M0|��:�Fv�>کDq#�N������l'����t�ݑF�0B1X�љ�6���C:�"^ҧ���IO��:J�@_�+����9=t��ؼ:$��b����p��M���>���f ��|��5
�3�r�{�FHe8G�.�<�2xhۧ�zq�plL��T�i���X$�Rv ����"� ;���cC�ɫF�p6 }F����o�r9���Kn�^�#��4?�dY�x ~��AxDh����0��C~7�!0b �����6�"�_Q�0B�[��|���G�F� ~��HF�Q�����8\Fa��ɣ��Hz�ҡs�֒���L��q��\L��N �lN( �� {%"&�MdBx���hU0 8Sb���>yQ���ꈪ 7��� �{Q�5L�꡸�E�N�� ��`􅌉~�C�tP;�9X�"!v���Ᲊ;rB1w�J��h^����r���2a�^���j(���%���g`��%��a�N��&� �1�O�J��5]G-�r|�US yTT���W�!1f�s�]d`iğALEz�1w�<t=fzI20H�ܑh�����֪	i�7	Fn��%���tOQy��H,$%.#�pc�G��L	 @��NjTB1?�p"�t�N\e: e&�O0!luȫ�p8�aEC ��Ť&�69��33^�=�0�W���܄,���#�{��*l2��2u_�e�hO@�>0
A�Bf���` ڽ��(���-��X�&����v�L�Y���F�"6�w�d<�kc*�W�� f��+3�H� h��4�&"a���;<>�+>�ڥ�8T0X�&+M)z�P��I���u�UBZ1v�ؙRE'\!|nYE]�mDf��2�O�3�R��$V����VQ t�����ҿE.a�4$�� �+!j�[�����d�c�0.��a�`�>�np��I<��AG�K�|�$A��ei�5 1U�0Ĵzs�^\�DR6_�
;߅�-@�R�J�7�k
L����0��F����\��Tb�֦���h�DXLK�9�;�q�p(����8M'�7�J�?��CS܍ԶP[mKC�\�X#W75�Ե�55�b�,g~rs��j��SOi�)�7�QJ-�d��.�pUVeʻ̀[P�9_g*5L䴭$�lܜ� 	�A���pBc�	�
�!�6���
q@�����㙜�Ò�^f�ބY�>l�A"Fv��uA+�.���Ը �^�;�x�VVBڙ��o 3�0��!JXΤ�B�S�,��c�#��#��:W�N�"&0��[څ��9��!.NH�E;.$�
�eZ	����X��P"p�z S|�M��8L����H��\���!NloEȨ�]^Ƃ6����B�8�p�B�|�m���ף�c�x��8��x������#I��K��1�a��x 1�#��`��P�4A:����m'-��� � '8�O^ja�`�=(��C�Ƣ��g^LR6�8|���֥0����	$?��&�|$���e�v�'�K�*Sޥ0�v��b�-�B�H���@��򴋙pd��@��	�Q�O�xN��s-�\�5���%$~n��.�F�-Pf� Hg��r��*$Q�.%)���E`؎���@���L��'?`��lȚ�Ke�~�srg-0��0�/�U���7�r.��D�0�c�.�<��҄D���ZH%q�::�� �M��sf�0��-D�v��Mb��Ҏ�z�I�9�rڰ/�wи�L�-�u �A̒a�Ơq-�,�
��L6G���7�tZ��O�/k@�L1�i�{��95
I�i��d�"�������0�~�bh��������#7�2=���2�e�G]�T��#��S�T葠�ϓ�K�aeF�R���᭳���Y�*�ۊ����uiVw"�ydY�g`�j��1eG�NЃ*����;@�����(z/��^�i��DS��3$ѱ����m"0S:�b�I�B�2eL	��βpi��Y9{CX{�J��'� Ss1�ȹ��F�3j�.[%S�R+$%0c��)?]�`�W��H�� _��#�=��1��t@B5�+=d��Mc	�����\�5�3��`w ��t-�X��n̍D@e¼x���M�4|9�ph�p�Q�m�L2��
�%������9��� \�T�p`S���0#O���i`��d�!0f�2Ԁz
�4��ye$��0k,�kH�(���vR�����%8�P#�,�f��g��Yǖ�6`Q��)|6D��z���0F����h�1��8�)�1f3(�mE' �Xp��38���� �p4�d�Յ��Z*#x�'���x��&��7�֏׻�ju�84��̉a�)��R�̨�3%�?�`"�'�SY�n�[s6��
4��$�}�x*%���X2h��<���Q2E�M�0�4~-�P݋�ǎ+�M��{�9ڙ�\�?\,��1��Ƣt�!%���@��B�V3b5B+0�qX�v/w۹%!N1��2�Z%(�����K�.#?�Dx��c�0آh�]Á^q@�ᕹ��4d��1ȡQ�1@O�N�.Z ���vL'��v����=�lP]�,/K������@&��.�������(PD��P�����&��,��F-Vѥ3�E�r���;�l�lT��%)�G�1�
��*�5�Ӄ��P@j8�Ӈ-xK��ǍS0Z@g�"�f��dِd��=�Nt������r(��i�����sL���,�������һ�8�P��$&�q���j�D@x>�� �φ�RO��&�����Ar�#b�%��ZX�
��Kdʵi���L ��)|/D̛`�F�ᢏ��b����M���3Nc��$��0�2;�.v�i�	��e����r8�E�c����g1.?�,��G6J1G���W�$q�x#�i�����ش�a��ĺ̝#�`N̘a�X�@�m�ė�BS��w`�m�G�T~7?���A �$�CDP�t�im�5jsxّ>���g��P}�rDHcbj��W�f"z�V�x��3���"�X� ���"H#��c�!ǢQb0�r�r�r+���K��;�A��C�$7�����r�#��E 󳐏����`Fy;�c=U �2�	d����86��CQ
$�A9�����1	3l��3��&`[*ƴpds
���� �D7��~:x{4�@	��"hb]s��qDѹc���%����#� ��[ZZ�gJ2��IE�XA"�T�K�<�4�X�X�ae<�F\��+Y,�[AD�by��>)�A�x4�!��8p&��d�˄4GW��C�5�Ո`8KN"���H�.�Q&
y`�����h�\d� �i5NW���"�����B�JF$�tT��*.�&nv�YL5¨NmG&_��̈́M��c�v� �vnO�Y�̡f�@|w�R��
L>���	I��0=ր<8,Z,��M��0�,(K�aˍ���F'R6���<�:�ʥi��%���Ř��SiB�'�+�E�']f����wL��U���b+��Hɷ 8�X�^��^��VN`t���͖>���t�͎���ɲ{p�5B�
��wFZ훂��$����XSjɝ,�V�B ډ�A�v\3>�h��:��?AQ��F�c̴����P���}/�)f�Z�"T�T��$�X�Ry��6԰�2�S2Hye^?�^@X��ɘ�(�,@K��~��P[�X�<6��?����<+�'�%3'�ɰKjvX[�+�X���*$�_sz�P%�h�@�����B�V���aID 󋘖��g��a�(3D_"�C]���p.t�P�I�X1��X³HJ`,�m?�q����6|�����܂{�v��3�EI֨�oY��0�um����\��R��*�ႌ�(����֪-qR��1{�CÈ3$.��	kP�\F�<��H�n.Y�e`�9q�b� ��"~Ŵg��QR^�7ܿ�^�3���i��@z'�)�,Lf��
�A���,}�������:��y�9��aL8EE���"�������;r(:�ߝ# `���p�0u#���'�wލ#����� �jX 'D���H�
�B�!ɥtt Ac�V�Z(��G[���rI�P�jFB�ee �IO?��'KX��{���>7z�!����lɶ����?�"˧�UX��H"�kV����@D;Ev���
�casR�R��$��ؔ��I�4�3#�S
B[@/h'���%���M��0z
��`�c���|q�tR��iC��:{ҁy��n��m-��h����`X	i¯ĸDrW��ôE��"�&Fg2	�K���Y��Z退��g����5+��E�~1-�-�g��aP�`�U��D���քIN��I(�a&�",ŚaƦd2�sj�Ku�;��F���\tsMÎ)ɤ�\�	�2�#�-����1)�C�����Gwrz`!��:=�E��4w.Ń:��^#8z��	', .�D[�������2�b�*LI��Z�y�#�G�[�*l!�� �����]�֥}�xF�m��gHvq�UR �:��TV���N%�(ֽ^� ͌��R�:X�%ڨ8��+�Sؓ��d�yxL;�������c�E)��[ct��q�����JTJ���g���TK�A�Km��n8��X�BA #f�2}�&'
`�Vc�d����'q��qe`W�.������R�� ����J��u�$%v�X�;��\T��әg���w�v˛ӛAc���ΰoO�y�m��h"i��D}�;�y�=QS����PhT�j�
��B�)�(lq���Eb�Dc����l �¹ɔ4��f�e���$6L�aŭ�dm6֤�O������/V���O��e��	�89����@��J�D�A�S���=*�~|�x�Z�HX���o��mc>nJ0������h�R������MI�#���|.h\���9�)	�Ж�D����u(6	M��F,Ȍj"3�I��]QZ5��g����'�`��]��� K钴�u���n�^��c3�M�9��W��c%P�Q�� 1m��Z�����ڃ����uK>=��cʗ2��l��bx�+]:�-��t��6�*q��O��eK�B��-��r�UK��0�:ˢ��"���.7ۮ|���"n3�6�M.�E�Q�z��p�T»0J�Ej:�I�9�Y$  �k&,ˎ �#S�L��8��f�� ���:�d�(�}1Ԧ�ЋlN����hh�����+R��	�1rj2�����Z(����0��8�.҃�G̖!�e�>Í��U}p�{`<c]���2�2ƧYc��]u"'�R�\�J�n�|<�ȁ$%�?�j���Tx����*��b��Z(Fe�Y�
��Ze<�Ĵ$�%�B��R�U��������Phӣ���!�x0�%��$�:�#�J`�vW�`�����XXϞ���i�hǮ�d����-��� &����vyƈ���.����MLk��6g�v<�*�FcZ���K%fAS�JzR��B��#���<�X���0�n�[ �\��n�J�֗S�1���$�G����O�p��`ý�, l��
]cA!T�z�g+�&��k�y;0N�{f��ݙ*����hij�0Ӗ����TKO��S��!�)�'Lz�)]D���Y�"��c?tf�cc�!b[
�%��ܜ����Ԭ�lP��H�&��O%��Y��qȁQ���H!>�e*K�"iE��
3�#&X�4=@�hq� K٣;����\[Yu�7��} �������B�}�09��qϤ���L�ΦO��pD����9.g8u°�8�mW�]X����]A��ލ �@�M�B��;:(y���[�YX<F�e�T�Puپ���s�6oK�A���	�Mq�i���� ��Tv�'�
�g�ܲ��@����&�6�bb"�Aj$p�3�.�Y׍Amf�i���vG�#ü�N�חp�	��H�)Ia���[d��sh͸-����H��O�CG��66W%���Tҁ*	�� %��`�@b��W�2!�9�����2^7�]E���<]&�4"��D�%ds����>C�Da��T'�fV�.����F�Y��n���L�+�@.)��'8St��1�����I9��(|(J=��7iއ5�ۊ�6�M��&
����qVTF$�a@�@s� W�-ad���J��icg�Q8Ӕ����	IdM���oa̋��hB�0}R"�Y8j�9���inQ<�c� D�yݔ̖H�)��+<6�3��i/,4��eVd�م9`�F�o1!�J������2Գ�j
3����7�����b�^�^9c��r��)jT���Z���Wg�P7]�3l�C�� Q��K�R|�9|��e�WCb�7^�0��<�_Xx�j]�w´���Dj�21؂��UQ��8޳�<Fn~P!�i[0(�Vsf\rM��cX��픆�`ȑVg��V�Dl��
��:s<�;�����m�6�̛v
Y�-�>P]� ��Mk�SF�ס^{;.9Y�P�q�w�NϮaB.)�����%��g���F��w��\�5/��������ID��������]Wg��r���#���R�գp�,-�&��T9o
3�©�Ib1l.g��t�u��jt&|�9�l�4��֟��̮�8r����M�',Q:Wn�����j�9#��#�h�Q�����vR�o�Q�L�M z��Wbe�P;0���6�e&7�� 
h�S!�p�5$؁���t�䄑E/Q���p(ʦ�_���e;?z��r�������u�֖�$t����n�a3�%�@��5�r���[�E�b�{��G3o�X���v�_�&P�L����HE�Puŗ_Em�F��o�&����Dbf�Q���U�/@uT�Wl'ޞ�@�������W�T�aAǖ����\�mIa��S-v*yH�wR1�5�d֌dqW��:^��GD�f gH����3L50VI�Hǭ��O�?�{���H�
+#�r�����7o<@~�dm-tP͠�j�aȯ�5م��GZ�?�w��c�$� ��NXw\B�%$J6$�֔�$уV���m-����f;�1=��E0�E�V=?S�q^C��q����'Ńk]:��x����o���� p¦�̀b�=�?�ӄ3�t�n=�T"��C��_^��)��LT��sZ(�&�4g	�b6���#g���Q�V�(�m��&c�a�Ku�B�m�Q�Ud%H��ud/�6�8+�"�_��.����Q>�n��]������]�$J���t(0L����H�n?V���ï�Q-%1吼��2�(�"B\ ��i�� �d�Ãś�ɛ�!���%�nT/(Z�(=dO@FN�N�3�8�a9�q�0U~�Y�����싊��^�MpV�Cg�Yc�]=dHN�`��	�Wp�e� �ܳrC<�5�*!�x�L���@�X�M$�P'*Ner�w��Q�t|ʰ)����iL��E\��-0�3�V��4b,A���γ���H-��=�{�a�c��g1uH{�����B/OV���4~{DȌ9�y�UMV��^���`��~(��T'˺�Q��5�x$��/lb�c��E�-�q�xb�cY[!9qu<͝���ȥd_+2a����4��\��������o�b-,�ޛF}t���a(�	V0i3��y�,u�,�ij\�>b���"e�ξ�\S��������q����?Sԫ~?�\%����FΓĄ2D�_34c�qW�Q�ӽ�T���47
%��։���W	�H�nK�c��,X��HU[�׾bz�A�
Q~�Tr$S`)�]�d�O��7}�Ji]%>�F�dS�yc�a��(��I%`+,k�me6R9v%��)��{��E�p+��*��͒�EYKQr.ļ�z�%o�TF<S�G��$1�ㄴ�0��ZL�U����1�#��3�ڄ�E������h��,�g�!q������ΣT��_K xT���-�j�m%-X}S�˕��L�ߺ����y��8)ܠ̅P�5��K�)��x� w!�#��b�HqK��
��L����OT ,NQg?ٕ�$s�-��� ����o�pY߬�
�^�uFQ�|��Cs���Lxu�
(�'=k��Nj���_�,?�U#V�2�N&���0�m��I�)h������,�K~�Y�;�rvĭ�/�*�T��Ssd�۟��͘�⊼O.�"��
��MU�b�w-��o�~&��|q3SJ�z�J�-N�Ͳs!1r�.̫�>l�.5�����������ړ������erw� %70��,��k��\��MX� �ev7Y�S���eT j�`:x(TvK-er�]aE"�i���Z�T&�&Žh�N�$�"�]�DN�m��+���,lI�$��b��f@����WqA,�Za�s���|r+Q����P�V(�Q(!��ȣ��!���8�0K�ۼ0f��|s��#I������آ����M�Ed]���'��(\hzfx$�,�#��(� ��d^Ŗ�,%����a���0����dw+%gO&}L�՞��uN3,����AQ� �w��5YFM�R�$~��4b
K�bj3,3�:ʤ�p8��@��f��V�n ���1akAn	�Lg��N��d|��{v�jp�5YSA3K�l_6!0$3��k���R�5JB%���fĹ�)s��n�8�`�9�)Rm�6�
kU<b`*��h$R�H/݌MV"���X�?X�-{�e��͊/F���tk�*�e�[`��e�ĥ'�ڋ���LGMm�d9��x��P�=9��Zf0
&�<� �-���%k�ɓH���'/�` Z)'$�Jo��t+��gpT��i��	�e��������?6��ܢ��ɪ-�+�$�O�p:���Mג����:i"Wp��s�43��'盧�9�J��L�+��_g0�A���8�ϐ/���5��TqM�<���I0� l*�|��'P��I��R'N��zv[^���A��n�K�D~Q�&J���~�M*&��1>nN�Ru�@�H�<0��	�L�M�+�S���*2�.�3'M��=�)�[��eaq�V�5F��M8��Fo���A�����c.
�S&�����Ũ2g��G��g�a�O�i�b�d!�^Q����5}C��fY�'{m�`4No輼��Zfh�X ���İL���\��(�"n�����nu��%�/ow�p �fT�$�U$x"��xVL\ܮc�B],z,�"�8R��+���c;��L�&�TL~K�����M��k~�H�.X2Mp
4�#x�Yv��Qs^�W3���nK���RT������Q"��PƗH	M�	Kd$�'�4r�y��&}�����u2��IV]�֫��B��ݘ�)���'�;*PP��y�.��J"�V�Z'����:�d��)ȫFXڞ���iu�&K"�A�������*F/Yr�
;p���߽�A4�z!�l��"|4��-�0��ĲS�����sp����c�8�>�����BRX�h�m^��hz�ȸA(Y!v�ፒ �C��΄�0_j�tbD�-�$�p�*������㾈�43�$3���
m�L!f�7��p%����ݺx	��z��u���)%0X&5��l>�����H�J&��u�J����,�IL�3uv�'�v��^j��Ǽ���R�A��d�'%��F�B��!L�@���^��Ex�f���*�Ku��l��C��}�ϏC�ܙ�L�rU-4�S>l>z!�Jht�C��v1RO*�-s���3�gK�+;W�����B���MQ�S���2O�֓d��f���iNвx.#l�^Dɘ]a���Hi"Og,n|mK�\�*76��ZZ��&�c�Z�����4����-�5�ߵ'��6��͵-umm�5�IRUss}]u՘�Z��j"�9�����6y���F�	��X�Z+��Ua��FybK][]�8���yRKݸ�m������zCU6�N�檖���V�㤺�Z;L����v����7Mh3����� ���k�rmT{rsKmk+  c�5 ĵ𰮱�~B�����Mmr}���5�%����#00~CmK�x��jL]}�_�5���� �U1ȫ'�W�H�Z��Zk�d�B�R�z�+��=qB�9`�h�j��Źlk�`�p��	("`��5� �j�ڱ��mu'պ�%L�:���㻵�������j���e��Z�rR]5ᡥ�����T��҂�4522*�b��f��^d-3�шT{�Ǆ�z�DK�`�H%��Jp��q-��hMH� 0�=�0dFn�,$�$74�ԍ�m�S��xR��VɎ��E�Uc�1c �:� @,��T5T��m�Q�)�l������:��=�3T5��Zqk�>�\{�# q�}�&�A@l�s�wv`ӭ��R�ojE
�j�ڪd�>��b��F@�����	-pް� hZ'�	�kd���#^�R#�CFt;���~BK<���M�B�ж�Ek�[�͗���T����Ɏ�<I[1��U՜TGǑ�@�q���h�GF}�Y��"�J�[.�؅�����1�0� d+��,��2m�7�1�'�c�vy�U��͜G�K�P%T��4�%\���T>���mv,����&(^l�w$��<����T8����k]Z�{��M�Iw���NDXםY4!�L�����/���%�s�7Z�Ƴ�:U�X:W�H-��"��U�a� ����-�m��X�3�WN�	_G�s4@r�<�3�ydĈ�F���Iu3��Ŵ��|u6S��u��e�p��W�YՌ/	�X�$�r�ܘT�pg�����S��/r��m(~\Bl��ƠQ���DdK�g�k1oĔH���L[UCgQb���%�[T#��e�4.4��[D�d�1����㏙�]�U���r�@tRQ�Ͷ�4���=M�cE1�qy�(^�HhY��r^N^�\�DLLl�ӵ�״�l�.���w�f �4��B��;T��aV�{>�Uw��^<
V��u��e��hФ@��N�U�Uws�g
=�"+F�f���PpM�ܼN��3h,��x�m�prS�[��o��� �vd~����E�(C���Lhv&ԥ����� �pɬ@�qLxP��h4l�egwwwgu�bYz�#[�yd���0e/��K�`��3���^9N��ѿ�CX-
���1cg�a��ɳ�v'�[p7��J�l��[iUt�F�^#+rj/ԋk�U�
>精���c��	�UcZ��'���O�.崗|�h/�i���4�p��ؒĺ� �����cM#�Slށ6���iv@ ��H���w������A�`��t'^No�����½)�M~�;�8��"��R�0��+�[΅��	uV�c��(F�����G�q�i�dJ-��J�U���bwO[/=/�S#��,0�v5
ra�#V�KP��ҹ���Y�����k�Н煽���I���܈65�h�����<�;`1���e�ً�w�o���C-��6��`BXDǸ��_���/ױ2�t��&a��e�$b����۶f䡡(w;�w�������n�{���	�U�"OR�i_�T�<�
R_���С6�-Lׯ0ef'{��ٛ	X�t�Y��` 6�bt�3,�3�����Su���oj�MːG��i��`8�\��$k'E�R��dɮlV�d�n�!W�$�D�6���Iz�<��DG@� X�3-�/��_�j0#�z�!z�?� �� m�He�w(7�s=�j��X���[�1�p�dk:yj�4Â� ���~;YA� Tn��Cq|kSc{sKm[�$��kl����% �k�X�-}8�ob~�z�
 o��X�5�\:�{g��&��i��� �L��&b�?�/��,+�6ıK��3���X(�q�?Q�QB�҇�2�񏝃Oe�����g�F8�h��F4E�5�Iw�L�޸I9�l�X�(Zk;��\�`�_�ll���~1r2�g&�ɓ�6�1�&����b0Db��6�:,a�]�vx;zk[&��;������L��4���RNWۖ&{���ONc�g��|��\!1��=K�5�;>�ΣG�ii�F���]�M��C����#�u�� ����<���ADD�w�`�Y��R��v|`C��Z���<8;J�1�X�T:HiSKK��c:��?V0�87K6��Ą�v6K<�p̖�Rv<�86	ĉ���I��� �\�:S�ʨ�i;{mn(5.�^P��QRŰ���I͵2i?�.�r�J�r�0*sT�(+��^��66��e�@U�Ћ���.�P_���|��J��%Z2�7�+�4��Q+s�r�PQ-PGQ�=T�� �kPB
�Y��f�Y[ʢ���J���F��¼��/�����ab��-q,_z�n�6�G�W�yBD��,�'���Ҙ�:_�뀵�Y]J ��'��Õ�T;M�v4E\)FB���HD1�Gb�kW�����ǰ�+���E��l�ʢ���Ω�2�!Օ�^L�K�+ߥ.���R�6Van�+��v�dO@�N��ˉd� ^SM�z�`=$�gg��SųФ��ls��'Y�%r��8����l%7�[F(��u����V��,�c�*��8�t�c!Kë���a��
��B�W�\���T+���Qi��%,�IP�W��N8�N�2�mU��e�*]�H�)+Z��`Xǜ6vF��O�5����`��w�U2��w؍f�>�`�Qed��L�t�E悔�M���RD��Q��5�ga��X+F0B�K�jO���S�-%qU4='#+�O@�Z1T`#�c��;��A;J_Vݩ|��џ����⿷0���l!�+��rQ��}�\F��.V���S���X"��3w�<�Z�GR">� l�<q��v�w^\�=�|��.�!��t��Y�cT^R�C15?�;�gJ�QU>�$�G]IPW�\#��]�og��ZX��@5���,@.�+��f���m4�Sir�L����eA�GQ˓����j�z\��}��qW+㹡+	2��C��_���|>P���,�*a�	(��%^�Y����NC#5�	�O\����8X��wHٞX4�nrՈy�Z�Ľ'��'ӈѭE;ٲn�[�8޵��t��|�m������X��n�朁0d��pK�m3����POt��J(�nw+�pČb~@#�L�|�$@T��$˕珓qʝk0�k>�y�z���]� ��<8�\)ٶ�̎Q���#����I���i����H&X��٩t���3�u�|,Y���`�1����:��"�|����8���Hpr�gG#Q[��:���.���;$|�d��R�-�����\�;T�i����F�$��s4��;��͍��?�2���?\�����i���0w��W���ow+t�-���9����L��w���H�d�er+po(!#�O�3O@P��ver�3�7\B���;�#�I��^=�G�����{,���ϧ,�,�/�A*=,�P&���{���A*�7w�����p��G硛Ǚx�8f��bX�ޓit*>����raB9��Q�s�2�_V.�W��u˝yJ$�L%�u L^�Pn�3ӣþ9\�7J�YW��ܜ�c��\%l�e��m�Cv�娏�imBV�@�Ā��'�a`����f9�����hɶ� �c͈^���P�3�K�%L���Ag���Νxqt]r�?�H|Sh��S���t���\'���h��Q(�߂���,e4)�'�
�<��-$YK�7���0�eꑕ�\_�b��fx��y%J�}h�4�عj��_`u�,'YS�ߛ�S��4��j��u@Δ��(��555%@�h'�̈́}��ա���d��lc�Sݎ�حJ��K��g(�i�z�;���&��
����,�9M53N�t�Lq}�ȔX��2�ӉC6Dt&��C[�͉�#���1�֨b#g�Z]��3"�-����d�wx��9��P��g�X�7�e��[f_\]Q�"��l�����ް��s!���H-����4$.�T�����_�Ӕp�rf+���R5�}X�3,�z�����4iQ�"j�,�#J#����`����^�rq0�N�Uf�i�0i;Nڞ�B���Y(	Αr�2sY��p�-���b3op�_��Sxa �,�� �X ��b��8��5 |�����)z�9�#�M7!eHl�[+4c�M��)��EͨЁ걽g�F˲������R�L�ķ�E;#�t�Rf��l#gFe�Klg@U0� �R� 2LB=l ��롁���b��]&��%l'�Ϛ��۔�9�������Yʌ�e��jx�0fR`��������jo_U��^���\W_���ЛI����7��q���9�i(n3MU�X'�;M�M�$e�E�;�f��Rt�,��C	��қEiӬ���n"3ؖ���Zt=��d�^Q�j7����o��I`� ^g��	Vz�V�T,��/�ϒ$�`0GT*=&���z�S�`�E��*�vV�V�o��MmБ"��jV�H8� 	������F���A���dY���;n����W�8]w�u�f�%Ǧ��z$��f�b�Ƿ�⥒t�i�y�S.���_i.�d�0'���:	�����؋�Q3>�6��3���=q�6Elue�����n.=�V��$6n��%��n��΁��~�8(�Ml���%�a�'�;�RF4���JO�}禁'��'�U�.v���<U=5�t�cqi���:�\�-+����R���^��>�o]��&���-O��$Z5V5Ժ�d�p4�{��h���5u-��$*�Ì��	KV��JEEm잏e��V�Uzb&{������0��s��0^�vJ���E��,��GS}z�:JR�">���F�B����r��jY���4٫GԩR��
'�h/�7"��U�9R?�޽]I2R���+C�L������
��Z�5�^-���wl�t�ZmcN������g���)��n������O�������Oc����}��%�l��u�,�q��qz���?����Ol\Y��5�����di�erˀ���P���������;�j�>U'���־Æ�\?w�g˶l[����e�/�ܸ}|����_t�y_��|�����.Z���i���:=������|��c�-�p㩃V����C.~p��ŋ���v⻍+�)�������75�{b�4��u�>�qȫ��������M��W��m����8l���;��%�_�[q���[���+��}�����icG���iE߯����Ό�}O������;�	W��b�YG޺nbل/+����/��]S�VR7��r݊�_��=]G_���7^��7m���#O��j3�/�|ߋ�>����?��j��W�����?\���NYzǄ��Lk�h�u�?�����d�7�}�ޏ�bl�G��}[2�Vi�����;��=��Ƈ����?�������{bC�r��[W˕gm���y[��5G5N8�[�n���3�]�P��F��]=3��k��6���o+J�)So�[wM�/{����f|}ωھU��&��_5�w�nmK{.�2�ڙC_o���Փt�K�����1����t[���6Ս��ko�c^�囆�MZQ8�_3�T����Q?���ˣ�ۭ�u�o�𕜡W��{�ȃ���޸�馩����q�7SWlyc�Gݛ�<��wo�8q�ʑg������}�ً~ʮ~�'�����k��t�ʷ��{����w��v떇�~��ϪN��/y��ώy3���3��-�7.����?��(7�b�u��t���;��鉙k��?��_�x��i�������ҝ鹮Ѷm۶m۶m۶mO�Ӝ�m۶�~��ܜ�TR��^Y٩�����I�e�j	�5��gB��.��O��O���g��������'*ly��K���hr؞%J�#\�"�Y��w�
)���p���I�"��ӏ�w(t�M����_	�%hO'"�!B��� ��C闷�&]���a�*���v��4޿��z����!�0^"$��&�+
�b�f���J.}�2��K쬐J-Ŗ
)�6�mDĊRCCj�1x�t�ĩm�"͚�̕�"�k�fe�Ib�-�@��~w{��W��$�%��{hs�yو&�m��[��N�J뜔�N�S��)`�����/�bU���������m�81�Q��rVs˗_��W�9<���n�j���	��y�Y؈Ⱥ���r�g�{1d�(�NM��'#�aH��u�;�#����Lx��B��ŕ1&�rE�"Kk�w�m����660cT�6ͫ1	A���X��������?��jE�Kb�+/>��h����2=�=���S&LwÌ�8<�'- �G��/b��crE
To�1x��o�ꧬ]�g	 +�0.L�3# \��������F�.����&�kG�u�C��37qQ�u]��������фˁ�Pq�h��{�g�4mD⮐y���c%"%�)��>�{]��%��P.Vu�A����*{�)�ת� qヹ�(q"� �i�҅ Q�Y6��$LVv�!�$G*�k�:'ӓ�����*�� ��D4����ѨT9��i!��4����#��ߦ����
8��&Qk8y�"Gf���Rjo�{?
PE�+�C$Y�G'�ΰP�B8*�EQZGde�9��N/n�ҞS�緢�"��r���l��њ�dZX�����ĜЇ�T덭��.���/�˰��T:_ʘ�;5��SA��L�/|-�v���]�ے�	j�dmX�ȆDYl3��%�H�3k��w���"M���ؘ����NJ��y��/�q����u�{���=���t+͛t2f��`e��Bq�KǢ��L5/�|LX߳7)��]e��s�D�4C\�Y.[.}\C�m��Mn��@i�rH\:qO�LU*�(F��V<9�� x2��c�Z�)�����d��|0y!T?_�a	3A~�|mg&m؟��U#m��[�Z�e�|^�1�ŋ/��'{1�%��&���&����A^Ȇ�#?2���물��,�t2y��k]��W��j�
�khGL��/5�.�1��r�����U���9�� |��V�n`�h��hPfm>�O�n*�I���"�f��{^��P�hꎢ?ލؤ��W7�#`,E�:�Ka�y-uI��}��B�T�R��iV6s�������e�P���bY��7�����F�9r�E���x~"�����+���=D�����Y��g�"���MWD����F?���N�K鈂=�(ov���̝��������<zw	�Pq�8��]sX�{>���0sUI��M�E�<���U���z�	�����ee3/�7��2�j��]���mZaX0���T�0��c�_#+��h�B���"�����d�/�n+5_u��c��7/Ϥ�E���Z��E04 3��jͅ�>�Nw�C:q���/�g�1Av�4����W���[��������v�eQ$���0�7����<� ��o�*$K�񁪗�/ٚ?�T#7��.��sC�I�u���JS&#y�ƨm�L��$����Gw�|�����f�BG|�`�6m>Ջ�`<^v	t�j���]�7��ا�"-k�����1	p4���\�O�����L���Y�<I&(u�Rfx���V����-�\���	eZ���^�%�:DfI�<�[�}�0�Q���ݑf�2��c��E�$�円��ÕhM�V�댐��dXT�!��߿�8��B�{Մ/"���0�ŏ!�p2��79���/��O�8(�����	F`�X��˧�����},o-l��$�X׸�{�Cc��	�*�����`?EtM5K7���uL�J��K�Zg�i��2eM�LC/�ش^Y����1�@"9�3p��v�|p�@���!`�X�Bg�x,�.u�����X4s����/'w�Ɖs�A�kߑ�B�	# �����g�[rJ��qCZ詿\R%wNU�?��b4�n�k.;�Y�(ϲ<�>�58���1��0)Bf)Q]P(�U�}���oī跃�B�xV
F{�y.
35��E<��)<�ȥ{]/}*�,����q7n�V�CS��cˊ����rx�܆�☈q�M�~(,$,,"�K���ݰ�j5km�EқZ�_
���I�^�����iDHk�ǬI`(K<#U��d��d�-�mʜ�vIt�" i�A�tM��L�l�P/�[+'�~T傰U-�8��i�J"h�J t_��$����Ɇ�l�K�g�U����c[R��:��=��z�tH�͓�%9��uc}v\�Aそ�/��#ҁ�����nT�U9�K�'/��<�10M��3"��&�Q��'�A�"����_�U�8eӷvk���ψ�[p2F�}u�Jg�t쮯J���&CRJ0����Sr�ʢ��ۊ�F6�Q�肌�	v;t�U�^�Xyd��*��k\{4��g��C�Bn2D�r��I����nD7b��aCz�x�>����p3����0xAwp��&�h�h��W��Ɉd�/��@^;�r>��w�VQ�-��Թ�)��f3����)ԢH'��H(�_��b�����"��!�������'��ӆ��_NcH��$�a&V�%IÒyJri����q�+Sxn7���B�)C�Y놟E�}��bkK�b�:�Ԥ%d��%����@;J3��]LuV&Y�
�w�� �Ͳ���>oΣ'
�2L�d��8!�u���E��el@�}�ёTc����]Ĳ;����X7A{v\Uot���a�k�����w%�K���ҡgy6� ��b�㕞��n�	DCfNLBA@k=����\�gvxv��v�1�����w��X)�X֒C���}'��V}�i_Jwv�;����%]���;��[7��>G��!da�X~a���ބ����H�wv�W���j��ViEx�)A����1q�8<�̐lD}͙,��0*�O�,��(ɺ�|8'����������x��6��嶒�a�ޕ�9 ��P�}N��d)�[�S�<�*b�AW�[��7��B�Eo7��[�Ccg��8͕\P�Lo�?���$����� ���(�D��y�%@	��S@pMM��|��� �_ão\���K>Nr��}�#���]_�HU[�:���ّCM�'W�@c'�@Ϙ�N��$ģ�X{ˁ�2�Mo�5� @x���?v���H��5n���\.�^�K��$,���|���I��w�Ih�J��5�#lv0����n���&&��=,T�[n�ZEi!�
Z:'��@:f숧im3�K2$�)<H���s��@�
�	p����[~��Ǥ��d���-N����9Ij�����L�����m�!?��Z��g�OO���X�gU,'lUs���8����a\�L�s��R  <�bL���fM�o�em~�
�l�ˢޔ�(���=C�����pu60t��^�0
��Gm��ns\��k�{����zv�iª���O���f%/&�V�MX�ܪ�1X1/a(�{��[���뫦tF�al��=`��H�)|^磾l���
�)�>A[v,*NЂ�*��J����q�Н'�X1*��Ӎ������>FEl:�TI�r��nW��r6�!� �]�q%�ш��v��>1/�S��OL� c��a_QE��a�F=\.�ם�������Te�G�b˜%Tlp����^�6A�osikg.���7M���I�KG�]�zb[!>������5���7�uGv�n���.��̼���k����i�-d<%Ӝȷ!���k��v�d��7{i� 7�Y"(�mTs��غyH	�F�������9J
�J����p@&��a��`��(Et�	ĉ� "N�*��x�2�櫗|h�G����iP�#�<�4"�a�4M��T�r�_�
`O�g�#���Z��e�&x�m�ۧ����^��9�9v�L����x��K_3�Np/ns�?�@������$V�

�*�S�50�ݩ#��U�-��$q%&��R��F_�x���tτ�R%ޫJ�w���I���?�(�����#*�	q�]��䚞��w+z�
MfdV��7��0٫ ֜u_��; �s�N@5��+3���V&L����-`�2�G��-,)��IfG���()��Z������(Ϥ��M��,�I��Z!d�Jq�B����������[��5bc�&�t�~�D�i��"��k=:�{E��O�����T�����x���G:��H�͚�j^l��y�^ a6��;��?h+q���!�� _�͍Ќ>�4��p�çM)���)�3 �����X��फ़Aw�{�ʦ�A5R�SG�.�(RF��u�G3�ĶY����u `&�Y�pLԀ��ێ��: �8_��DR_ʛ�"p��!�e��&C> ��E���}#ȫ�������ϊ����q4\on�W�W��99���ڇ��@K�|,#�l���vdI�ۺu�0+��!g\�5t�X˥�>�FnLzP7�V�i�n��H��'ă�������)l�R)����Mp�Q�^:}��[	j�M����lԶ_]B�1�E���h��Eٱ � xRc{�b:����!�R�4���+��Q���P-w��ޘ�BZ��H�����V�����)͸�5P�՜"���Z� G�� >J�� 5��6&)C0�������V� #94S�c���d�򳎹�1t���nI���2�� ���R"�g�;;��M"��/��?	�lEϪ��}>0�N�c.�(�lR��֋�O�����چ@�m�UѴS�=�rцG�`���a��chl+~�S��P�lP��|�i�bSm^∞�2&0�90��X��Cҹ�t0�IV 1\�j<i2$s+$���t��7C.p�jmQ�-T] �:�"ǀyvXH�&܉m�M$��N>.�)t^d׌U�=j�h9���2��ο����mK��d��KPk�N��<�v�����C/�8c�
 �	��,Å�
�8�޼�c��v���~�AE"+.��(�Р_�g>cG�1w`YS����^=oh��۱=�k	ayy�����逭U �lw��ґ�h9]|�+!���w�>}܃`�tys�7X��1���4]�=r8Sj&Ϋij/#�0�������rQ7�w��#y�Ȧ�9�ې����{����p��g�KK����W�i�o�a�C��l�᪆-k�#~�D��U��q�|�O��)I;����խ���~O��L�-���+,�Ug�x��	�T
�J����M���+��ns��M1,C�>T���Tc�H&]t_������y�h��z���zv���Պ��6'��M$�8C�[/:�@��y�c�<�E(6	�S�J�R��"B���h�k�A�d0z-����GBzQ�	+�������@�Ԩiv��+YK�:�9��y;	F�C[�)�$-EB[-��d���$f��Y��k�������b�P�I����෭9�J��Q���m�r-e�<�JC�l(�����/��0Y�;^���^L^h�ډ�U�PM:i
N<ƕ���'��19��K�*T[�(4���������AگF��y��n�Ϛ킈�v�%ٱ*��mۂ���=!71d���ɂZ!�i[��`"s`�����e���n-��D@�������=;��4-�%�@����CJ5��WL�欲�l<����,d���
*�~/���ô	�F;J]o�;�x�>�G(���}d�w�e� �C���M�֣�o�r"�%�ַL�tAe`��d��llН�%�P�z��V�\���7h��55�M=��ͭ����<��un�j����Y�\�YɅ0��j}I�@ـ������� %˚�z��|�Z�͢[E���u��hi�&��:�,�Io��<���D�2�^h�8vJ��c�[�充�:֚[ S*f��Lm�)M�g�t%���YR����f��x���	w��N�dm�A/�+Q4����k�]�`�����Q-s{m<A�J丛UVt�[����l���S�-o�]���8�Q�n�C���	[�H���D���q�H|О!�T��B
"��5�K�{+vq�� �#�^��Ao
J��o
T��n��pRz~�����Ef+�)��Ht��}��ǯ<�w���鹧�mB�]�N�D��fg�8q#�q�[8��`���`p0>���N�cN4*Ã��CY���\bP�8�o�-p� �N�DwmƼ���DK}q(M$���j�NY&��[a����uGU���Ej7�'�ƙT���g�\4�vT��|�l�k���L�e���{�5Y*6�o�3����g�涟[O�UDK� �U��^�;�<���PN�q�����p$���{� ��~n��rf��璇�]\a�ج)�f_�V��e ���*����4;�LX�B	=���'���$���D�{��e���i��ų�Q�Q�;&��I9�e�j��F ���]ܡ9��ՓD������}i���P�O�2OP�l�N�,.�Hq��B.\�u>��S����:,�lz�xq���/�Q�n`�(I#�_�q�J�2�\��%�>vqI�����|�6�AѺI�Ȧ�t�2�f��kY�,���L<�wCVen<e��e�a��U�Rc�1�I�u�F8c:��`���͡�.�t��_yb�hi�]�ks�~%*�M�g��@G0]8^�;4�č���ֳg��H;�/MlMCr�H5��L�OS�0�瞗��U��J���Y,Y!��� ��}�?$h5���������)�W45�yޞd��򺥎���|#б&j\��[��6tdcZ!�c2�1Tf����7I�\��3�l������H*�:!���>������Y�P @Y�/��nc(�0�0�4O�T�+��L��J�_W�������#�����^��~��(ۊ�i���q�	_��Ѕ+�;�7r��g�JF~�L�f�_���U;K�?F�V�g�����,�5��˄�Ҁ�Tv�}ws�4}0��m����ti#Hf�����������Bt	�0R�#'��a)�|�-��c~����f�3�x)�L*�r�����&�Na$��Yq��D�nH��@��NP\ O��_Oa�pH&}\��а"}����~�F�'��KKg�h��A����?�C�4�q+$Ѝv��Op{��
&�����`��??m੥�P�+�!+~�!~2��vs���tK�w �n���zc�݄`�q��g1�@;(��R���l}Ѐ�3N, �]�&4�P��������	�3�}�4b�P%	�#�����,�vi��f�=�.`�`Y�^X�����ޚ����:��������<���D����BO��ܻ�B���}�D�?�Ș�W[�GR� 2W/* f�d��]0v]�Lf�Se�`��"~���:��u`r4���M>l����@h*�T "-��x�Y~���,�^���ӕ>�Tu�� e�o�.ʢ�V�"�c����n^��9d�o�K�� �����V:ul	��*���`�Wo��ϱ\�ayg�w� br�f��������A�	4��U�W��B�v{D�5�'�i��V}�t��lOO΃�aV�(����W�<��H��?���V�/N;�X��{؊|R��S��On�����'�&���U�5J��~nA�`��?�J̽�/�J�5��?^��`ˌ���ق �N릫���7l��o�m<��p�8� ��x�=�$s�.��t_9/	,�g���tP_�9_
��6,xx��6�>����K��I���ml%�V,�9\;؁rE���Qu��ɫ~���󌉄p��Y�X��O��h�����O���ux�}z*���\g$��\�j�+,vISŞ��G��O'�w�L���'�;h	���>� �1d�ċ+�z228�i2�M�Un�\ �i��`~���zY�b+����l{���U;%�WH[2�R��{�V�3>��L@�!V!G�)��)E�ݸ<o2��A�(��2�0�g��������spI9��D��$���x� �DG�"�Ѻ�0��q�De��;#ly�<J9���
n��7I7Rt�ʠ:�:�ⱆ4Y�ō��Կ��Y��=��?/������9͢�����$�$�[H~}�k��ܤ/�&Ų@�}��<A�I�|E�|bë���Ķ0+����,�eF�"�A�����X�Gts�,��D�	X'BC8�}6^g��E��X�54����zpA\�<ٖ2�kV°���`�a�`"0PV��daJ�>b��X�������n�� U�����s�8�v/���c�x�b-�5j2(��Շ)�qipةˑج<�A�{{�7��6tF�g2�Ͳ�l�׼�@�''�'��5���u�������ܷC}�cd>%�u����7A[�����?���Tl+�b��yՁm��Ჱ6����k�fӮ���Vv�m��~qcP5��k���&��a/�w�i�p>#9��c�|�(r d�iĩ`��@[�A��Xho�;� ��E�Z��S�ft��c�-
-/B������~����*H��I�� ���D�b�5�m���Ͼ*�VԨ�M�$��C,Y��qf�E8g�J�gQ�Q�]��i�v�)͍C��/ ��f�8��=�����M^#��C�[�@�U�a��y�y����m�΅�@�N������+��Im����I�X�/͠�J����t���*(Q����p��y��_��pK�c��K�]��Ń+"�� �Ca��~��@2�V�N���D%�?�1<��;Q��e.w����Q�F�������Zo�OB
�����ZZ:���_=ӥ���ڣ�{{ҫj���h�>a�k���v�n�d6��c&!;�.**��s�Y)�ߺ��(�N�%0�A g������¯J���	y]�c/T�F���9CخJ�R䔨x�$����f�f�I���1���י�I��C��CA���8��m��nsrI���WC�HE� /O�>���J��!�/������ARÊ���EL�S�^:��}6�Y2�\(҆�����A2��A�	t��N�F�W}�ܠ&�>�mO�E�:�7��[�?qV��k��_�=7��${+�*�	J�$���=��o�p,s�j�
5~�4��6Y1�����SjF���_���J�s�v`�w��AS����]wC���I ���;�bz;XK��`}�3��$lĜ��C]�dxr`ؔ��r�"�a��� 3p6vS�}Ul� � ������ZS�zd&e������&�l	�(���C�J����R˱<���*;��|��4��7� �P�	���|P mtO�~a!���e#�W��H~<`�cg�#��X/��w�r��P��	M��U�>��<�ݨښNg���p�O�[0`�@�j�.+�L��@U#N_��N�N���!����e<T~_����o�'��<�0������\�4�4�@EZp��p�z��o�o�`M������c���0���N<H���J �i}w�4�=�+��}!�L3�A\�2T����.��	����5|%}��jK�
��Z�=kJ\�g6�-�����`���ޡ�C�%��Ŗ�R=6zϏ٩.����ur��#�UC��Ubu�#�y���.̑ \�$%k/��fk'(�o�͘����9��<8#uG
�J�*B��O�bͺ~���2t���	pd%y��㚠�%-������]!Ԕ����p�V�Za<��TwV���d��a�t,�7��_��l���o���^^P���\Τ��۰�@�Ү`��2�^���.�z�G�o��fo��s���xЭNBc�J5'v����y��S�R��J����b�͞�+683�3D�{���ZB2��gIS��j��
R<:��z(b���)T�rFV��Z#;Y�&��'������p�H�`O7+��sLg�{���ͩ��(Oy!呑���v ���,]�f�`6��Mҳ��+���#�bcP����(�C�f�;�fj�^��ۀr�ӭe&G��j4Y$L
�Ry.6??N��w������PZ�\੡C ��|[c{�6�zG��}��ъM�_H:>��{x���G�A�:	���|F)���[�/ޔrm�����H��g�=�bY']3�`���Yt�C�o�����@NG!O�N��ަ��S$�!����o��#��+�à(V�f��k~I����y�"ed�7���d\�^���u���VFl3�͞�o;G.�3���`g!c���Bf�%�饕:��
/:j��8����R�ߛ;Ͷ��?#u�م2�	Mh��Eʱ��g��-��xߡ�] J��Ouqu����X���2�Lرc.Hh���� zBTm��v�|,��T�k���{e�'`ZL�"]	��l����v�3���ͅr �L9�B����"?����H;��)}�mm�'���$6B��+f�79'�&ĕ�"O�!��޷'Ʃ��/18��9tl�Z&B���[�K��j4[��__��� ��L$.`��Y��*��]i)��3�g��e582��n�I6;C-�:^��iז{���3Q��4�k�w�"*�F�ձN�y+X'�?�>V#�Y�ۃ���n���=l����_�0��[S�̩2�� ����k؛��#��}�FL�*D�9"�V�r��\b�dc"1���x�s���7+T�d�����掼4��pZ���qE}���L�9f?7ץ��86 �����/�i��\FU����82Ά�	S���sZ�Ny�iMu�$eD�{��Te�6�)�0DG�]L]�)I��j��qT���
̈́�~uS|��Xhl��)�����۳l{��� (9��>B���&�� �rg�w\��K�h��3l���t�g��d�u��-y����x| Ʒ`Q�h�׉�(���+4���l�nMs6�dAI1f�:���HA��$��W�9������-����k������b�v�G;L�w�$�(���5ܜ��B\Js�j9�T��	 2�,�-�YMT��B�J?ud���yŊ�/>%1���p���c�v[�'B�N�"�h�,��i�˥T�T>Oҏ�x?��~t
N��K#'���]��wzS/�&���9��
R�L/j��S�=ؿ��ԓ@V�L�����+�	��S2�-����V���E�N=Kq���z��`�	�wV~%�_�ȅm��b�pxQ�+��N�eŀ�|I��kU�w��%�\�Sg��	,bye�͒�/c�2��H�TQGF�\��1�����¦�.hP���i�m��3B�YF������ˌf��u~W�d���ykCz~��Q�)[f���q��ꬣ#��x�n�#�/+T��y�t��� $&�� �ox�[�0�Ꝍ�6�E���Ì�Ͳ�]�8�T��Ia�$xUv�&�R��1��^���¸鴻)��4�^�h%
��z!ǞUb����������5xA|#��h�}�D��jI*�Iw1�$��;����&c���^1�o�r�5B�ʓ�������v"��4DĜ����!���cf�˭?.�KsUϛ���|۳�l���ך�m��H�_g6����E5����M�"rH����Rn��S~&��f#�SWp"�S�1_.Z�I\82\z&l���1C��!y�:����.�����?�d��&E�r�xŬ����,�B�c��v�}��x��Ezr�sK>��a�p4ȪX쵲�2-R�:g���*w��ă�����CD�mX�D����r�$1��sZ�Tݷ�e_),�@i�%O����{+�0(g�O��ֲ	��aݢ�7�z�TX�lx��e�a�2�S_l���w^�?��V���OU3�i��!C��l��X([�Ɉ�+���� [�ab�&T��y]P���X�J0h�.9P��W|��з�qV/�yv��A���Iq�����݈�'"��cs9����{�=�����N� ����$���3:Zh�Z�6�䡅��/���y��@��� �~��\=uW���qUʩ�.^b���2����7�'�6C��Ya���~�&�{�r�I"�򌭦%YY�}����'Cd�.�^ˋr��DT�<e��	��|?M؃�o�T󅇅��t,��������<O�|�|��?��u|���ߪ��3�>I���_�������]���=�o���Lx��������m_�f���t�����W���}E��l�^�{?��t��|��<Q�~^�����M�o|����O�|m�K�s����s�����]��n}��<�M�|�[�<����Y�{�o�����y{�9��!���Hj� ��i�-��V��X�p̘tм�"t�/�ɒ�rA�Lf�@1�	E�����f�ǁ���M�7avk�z��1f�����u̿;�&�	n�L�n�ّ4U��ci-;s���~��i�o����R�91�!��7Y�=:ëBI$�um�dA��yx���w�7���v�h���ĜG�/!�h(U�W������@A���A�g #���<�S�iBX">T��i>�M ��#����'�7�(���I��>Ն����������4���������c��1�^�A�.��1�ר/� h�L�(`��|�X�l�스A%�0��V�
�RG/bg񣹰9"O$f"��VM5�=.�H)sEE�����t�k�ʶ�8TpJ+~�)�V:��;�2dȆ�	��~dNA��Z���a�7r��	��'L>�?~���oj܊j�6�:�E#�>���k]�[�//Mo�S6�痡�c@��n|C������jW�}�N9,h����GW�tH�Yx=j����ؑN�s ��A,!RKh+@�{?#W�֘),�W�qE����n�H �_G���oH��g����d���B[�
Z;�/2L�Q���?PT\�ۖ��t�e[!��p�ܽh��>q����;�e3Ѡ G���GBH�#pd>w���������-[!�"VG�"[�����uǪ�@,����5l��w���Ni[  Cg���h
�F�"�Z�B��H�����5h��ѐǃ��R�Vj�� ����WPQ*����bFX� �1�i�vƚ6�!E�q�RTL9�&�g�!��3)�I� DĻ��μ��^p��$�����0wz�F����5�sB 0����5��5��/o����LV+v���*}� �C�<)�5a��ʹ�� G@f{<PJ�X��}ޒ����$��-{ŁpC�Y�)��HSy�Dj��x1ƃ�e�z7���nR֡��b��l:_�;8����_9�\$�[�Q��m~�9��3Ĕ�t+�	��*�lƠ�$�v���� ������M���D�A���L�Gn���l�B�:���^�Kfۉ��s��{)_l�(�(C� �H� q}!�͏��[4qf"��n�o8���ҀP��7�  2�ʵpTIB:S	�S8��qA��1�6"4?���F6�A`�U#B�����P&�"\i,�&�^�5� ��?�Q�%�	� fH�8"	�������>8��PH����)� &k�1v�	4$��B+0��6P*?���B��3Gg��hCA�Vʾp�	��Rb���&j�@F�>�`M���Z�)+A��-�JN�D7u�� �5��$��n��e:�Y���{�Vi����DX]�?�;i����jJ{�Ne��O�/V�$� EV��e�+��ڮ��|ܿ�]��h�5>$M,���xm� ��΄�#�Q��M@�h(P�?�.�}�
Z�?������d�i�:��Es�5�ocq0��3�)u����s���}�/��-w�7n�Z��7Ƽ��/��f�������c2ʬ_�
��+T��g�����?T����d��H��Ƃ;] �,>���ю<�@ �!��xz�}c�]����p���b#��M���ql_Є3a9T���̖��b`�z��@[XE�3���r��pSQ���8ɜ��L|���ל	��pL�/�E�6�a���U�����3���OX"O��k<��t���j�F�-Қ�d�7h��9��a�@�B�X�㧀X��h/b��] P�3�)�B�P��S[�ܟZ��h��!X1F)��Ml��)w���<�h��TįO+���D_0�Z;W��nB.����Xa��kK���[�3�髎ʓy���ٓP�h��}i���̄Ô&�@5��u�|s/%r��]��Uf	b!��z H�^O��>���v<G�Cju���F|�Yo�:�=9UT@�<w�a�T�;�U�"q��ME�l(�,�4� S�9��/tS]L|&�_ɲ�BXab�N$/��H����![P��i6;`8�z��j��o>��76�y��5�~�ඥ�P|�6�׿ZL�<��	�H5�s�qZd�~�b6�[�%sa2(������c�I,�z�3��� L��S�A�Ў��hYc�]� �\=m�ׁ��P����U\=�V�*jrA6g��\*�P��a�`SPWR��$���%B<�n<����r�
���^e3+� K�h
���/�1	���v��˒�Sj�MC�|b�l޵A�E%��ɞ.��?�]�YS�O:c�v�b�C)�&����j�,�U%S_
��,���V�h=�s2^�E?��	��,2`p���.��j��\���ͬG;_��*,G����g�qC�ٱB��Ow� ���ǭ{�&���E������/	�"]Y8���y���\�6�VcۭF]ⷆ�{����r"�*�P.Ŧ$XW8�������*�⹃<:���U�ұ#���jU�Aq��8����t��B����>=-?��fP�����n��e����
�pG:ٹ�a[<pf���I'������8n��bK�0��O|����oO(}6xë��� �Һ�}�ï|�exe� �����}O�`�$9����5���6���~8㌑��X��CǲRp�]9�J��6L�W�
a~�� �E$LV��S���RJV���͐�����QqVz�F���r\��V�֬�� G�ta���
�����n�V������j�^�6`��}^u�׋�V��&���L���˝�҄�a�Wk���_��%�����6IY`*&vVU	�Y�Q	#���WՎ�{���<�MU&�|��eX)��I�9�J *Z>�O���w��#�����?�\*�Vz^fzTKߪm�)Yxv�Y4.�G�[���)ULJJ�}Q|�Y���f<?�Ee�@פ=J�p����:JY jV�M���#���";�=*�ǀ���%L�-����Wk���-�y�4_<��^l���U���E���E�AH���=�v�����ogs=�/<���aT�2���R����`Y��wd����~�4�����?7:E�d1Z= �������hh��%$i%e�)$k)%&&%i�$&�)$h�&��Uo�G��#93U#I3�<u�R[#ju ��03= k$��1  8/S��3(��`a�R�XH�jL�����g�O���*:j�̓z|,c7�� �Ie�[�g��s�" ����Y�t����[C�j���d�@��3"��L��^>,J�F��W�o����E�0/�zi^��_a�/{���̟0�8j�A`)dJn���y��5��,�C��?p���~:l�Xz ��	��\f���KUBV�x
څ�ۇUs�mv��_qW�2��0�4�pX��om��H��������r���u;�!�dJREQ�O��a*��S�٨��]�#j���q�%�����L�W˧���T��TQ��ɖ�20����W����֮~��3��g��_y0JDT����^���We#n��Y��j�.DH�P�pG񩿍D��)'Tu���)�f)�/f&'�Ӽ�	���3�;���[��N�x�;�OKr�UĽY-�aakR�����ti�]/��?���#��*o���`x���m�[��%F	�t6�a}RW��	�����9�y�Bw�,&3���4�c��U$�� p���jHv�]���{=%���-۶m۶m۶m۶m��)�v���S�9$+;�p����Sm���Zg�*w���upȤ� �[��'���s,�P=R�HVTt�M��N��[r ���&��q�3��GQ���R�`3s���g<(�!ll�8Ґ�0�^�muc5iQ������9�w،:u�۶���Hy	�Ҿ�p]SMȴ�T�u�fz�.J�=Ҏz/.uqGpk�s��LrP6Q����زKer�r.�
"Nn}8݌N��9N}��>��d]v��_̜����\ntr���:����M&�nX�%�6��N=
X���＆Λ�Qm��z�mC��`5\��Z���3d��������x=�x~���̻�*�[���2�����6��l�wT���7F��t��Q=�y�
&���.V�/��rtgs@�����7߰�-�4�|��-�o�BNmq�zn7�DЯ�����*�b�D���Y�����@+�r��_��Jc�[���{ͿQ�j�Y\�R�鱋�\��Q�q�&�ܹYaI�J�%(]��ҟ�_��Gi���?����Ҷ�-�����Gg-��j�)�KUpӄ3f�V����C�ψN$бL��U��`�5,��fА�E�[u�[�H3�g1[��a(܄��E-�|覅=���Ta�B*�Y
�A@cs�J-7�*��>&J�����1i�f���5H�;�Y`���X�f�d��
*��3���m���^�e��)�4҇�p8SxE_����gy2dg(��rKH?�yyL��z�u�H ������2has�a3���5W���.ϕ�G{�/dt�͢��	8C]��Ӂ��� Q����ULuje����G��:��B�iF��,ZW�F糘8�,4"������²[� n|&���$�[��M�mf76����C������២P�E``�(+S���W�6KI��#t�I��ӻ�=���7���X9��6x���j���(��~���VU�L��x�ᐖ�,��ʡD읥�q��p5X?w�m�H��'�W�[�~9η��'NP��|=�.�[��y�I�<��w
�a��}��a�!���j��(�2/j�%�r�!^��khމr�����iG9�V��CQH�w%�B����t�ug)��u-��o}6���߲8��r̔n�[N�dkA4T,�2g�� ��p��K�2����.!,�ġY�6�6��.z�`��d$���*�6xx��+����$��˟_�G=�>~�//�y�r�a��t���SA�;C~�.�e(+������c@����C�4�����!6q��+RC�T�`�+sXGg$Z1p���W �f��6%'yH��D��̭F-Im���1���eJ��0'Ox�F*�`�Ycl�o�X�l��b�^��)![9��ƭ�y&�L3k@O��6b�K/��ɚ�	wO6K��#ڨC�d3k%�|
��Y�����uW
4/���~��Q��<�p�����/*9&8&
V;A�$kG��ȿޑ�45�B�Cw/�U�"�ZL[�z%���]��&��'���`c�/��piW=qX�WȘ[���;��t�}�j�
@o���u��v��nk�Js�&�O�:B]GN`��ف�l�|#��ک��o՝�l)�o��ik]qȼz�6j`����{���}�Z5�`���:��/'�c:?���Hs�P��u��_���Bm��!�[{}�z���>�JQ������k�H&���'�Op���k�����ҕ<��ʾ�3��X7���M�)�V������Ұ۟����;�Iu:X ��r(�5g2��f���h�'����T2��7�����g>Q��X⥒���P�ie�r�^rUM8ބ}\ns{	EQw~��ݯ[��J�+�bB���f�~O�$r��/���?���g���\Gz�3��:��k�~�x�����Flw��nB��{�(�Ԛ�3X:_�}O	�ydk~g^� DR�h�~��x_k����G?���'N.�6)���tN�;w�r�i��$����'T��"�1Ѣi����rǔH�qW
��h����� �!棕�F\��$Z��]*/C�������;v4���t(��+W��Gt�ٛ��\7�΀q�D�u?)J�ġT<Q�yx{�tM���,h�+�V�Z�
��nX[\��0�Nz�������X��&6VE|���atW��m��'���0��BD.jY4��!�g�UnDe��ӑ�T/p}�Ӓ!l�lY����3��w_J����Ͱ������Z�Q6��u��'@#���J��oꀽ�$�Y�3J`Ϧ�6΍�����}��ۃ��{��>|�Mgq�U��e�c*��d�>�����z�
��Ve=��8L�[纂�%��>��a�k�X��`Z:�R�S�ÓQ�jtf���{�^UC���3Ω�e�V��S�be�4}LF��ŋ�.��un�.�1�%�D��\D�Kw\�䅸#QD��8k@�-���F�@��9���ZM�L��~i<aS��k�"Wm��R%���T77�%����|��Uo���8���3Q�y>�`L��Z��=��^~4�/fCe��s��s<��@�Rs1������r�Z�Go����]�m�u��'<�!�+(�Z�(�������h����x������DH��zN��{A�����>`ı��\lq�G��'�t�)��YֽK��:�d$�+]��w�6j0&����2����Vυy1F�����mf~)"f/��~=�(�$e(a�x�kT���![��IY�$�v�"��Zbdu�1;"���Y��-Z��~'O���5$�0�X��`^��bϪ��F�X��h\�
�7:��EY�7d�,�J͚/�e�w��-G-��b<,yO}�8�aPk�cOxNrG�� ����E0�U;z[yO�F��_5܉P`J�	i27�����K�tɬ��Nf�ײ�?���>߈&��.t�9Mx�i�$����`-��C6jq4����wY�V��.i�Q��MyD�֍�1un����6p��I��8�E���y��(e����~��-���a�O��lS�$����3�/��x�X��:(*��D��(~QE�<!X*��HG�����^�k�r�b�^��z���,�JV���[����ѫ�q}}�JI�X���gu}������ <�~���Ṁ��s$�w+�b�4?<���'���(�2�t���<�S��	C@z�&����2�I�I&M��)\�orK!�wj�A��v�	T�4E0Տ����xVđ7V����]��L��D����q"kέ���F����5/��Y�ܠjP�B{,���C�]�!�ֱ��-���Œ����O�Ǆו����	I�tԋ �Q���YB�+�
�`��J��A���i�1�f-�ʖ,U�[Qe�������:��F�j0H5!��4�i �u���5��7�Ci�ѓ5C��M�EH`~�΢	�9��U%�0ҭ�pb�5ı5�{e-;�h�ȜV'*��
�0�J8�33�a�R���O.·T�1��i���'g2}*C�4���=���J��O�Z".��Sg�[%=��Pܞr|-�}�i�Z�2J�v�^%��`�?d�j�Ij+�;d�(�9J+�l���q�:���4ہ�2RX7����4�T��mC#��Ql��$eI̬ɧ@���Qw���^�ɸ19�
>2V���E�`ڲd��K�S��4v�$��|t�)1e$��O�{te�}�]��U�ᮛ ~�\�f�u@�6�s�L��s��m���:cT,zku�[v͈�{����},���f��NU5�����K��Xm.�%SvJN�ZMI��9`����M����V�O< Gs��qēJ�8�E��D�U�/�]�kgR��, R��+� X�T/�X^���㼏A����jd�iUL�<�_:��WN|<5������}���|W�^����U��<ߞ;�������W}~��Y�_m:)�5h���}�k�n��u��RV]���_��4S��򿁿��n��OW��2[]�O�mټ�������j�ܩ�{�uW��f�^}q������4��hv�]��3ϖ�e���wm�X[��j�ҵc��mN��7��JW9c?k���hq���k����}z9.�ԙG[�)>@��ݝ9��r���������?���갴n��m�6�˷�Ϭ���l���x���kWώ˪>��B���������Ϧ-�N����ic��"Yo���ӭca�͚۫4c��׉�_v���kY��������i�w~�f:T6����[l.��4��FYq��пQ��b־����`�h�����Ҧ���˗���D<�Q*����6m���u۞�^���!�C�Ɩ��ұ����X�,۵W�y)��u.�0�5��E�%�ՕF��P��;����;��v�'lp�J����X"�}Vk&�,�%��a��.����I[>+T|�k�q�^s��R���Lw����/9)���S�I�U�Ɗt7����Nj��5R_NcL~����"�\��Ӓ��u�ur�ec i A�_
T[�}��bɖ�{)�����Ik(�Rc�$�q+N^�akB#�ˮQ��%z��s4?X�eF 6�㹫$�9����\����~f<�_Qs�q������P�e-�=��3��n2����!kIc����n�O��l¡�۲�fd!�YW6�߀����i���-��>��{D\t0���:��k�C��߶�켔d1ݍ��f*?s��$�ߣ���V�}�=����q럅����;+���$l)���V����u��IȻR�Rr�(��u�v�h`j&��k=�����`�ϧI��2ƻ���@�JN;��K7�����"o��5��u!���J��}u!�H-��j>|jj�_*+c�^1�)"݅L9J���9�ː��)��F������z�_���>�9���k��~�O��x
`uW�/��}=$I\�5�gGM�{xڜÿ�,9E�J�5��*{��_崣�zp�H��c�߀��ٓFH��v��y��T��`�A�m��C"��m�K���j�%�D9"2�V���20�7@��J5~G�f��̙�a(�4 m@��?1� �ڳd-c���i۬�J&�����G�v|O7>��eE�^����2 S��/b���mїL��t<K��8���Y��ޱh��z����T��^���_oR�����ѓ��pG!��Q0K}i�"��I���	p���&�h>����J��e��#���L�'&M�"�E� ���7 ��� ��C˴<g��ɘ{����6�B|�� �X��臗�e���r��o�!�@%��J�,��`�lh~�Ӱ�3�q�iWj1��3�W)��Xս"%ѳ4�9@�d�
2��?(�+2�j1�j
��f�����H2�[R]�Ϯ��qtF#UH�DY����v�a��hE��cC��ZmY=��F��@݃<�k�}{�s���y��9��ߺx[
5��u"���F����~�\�3��۫�=f���KA�2�;�K����.�4���}4�F���E�_^T��=�[ɇ!^qg��ݡ�-!S� ��jt�5�έ�f/���-��v"�{Swa�eʆ�yn@P��ӣ�I�'N�PJ��iq�IU�ZdD�q�p������4	�uiSa<�͓����O^wﾽ�N߿�����:����o7�6�̟?�Й2c�%R׍Tj�����%�K�"m� ;���U]o7>bY���ɐ��%�v���C�خA7722C������vW�
���C�9�r�Rql�)k��]S��_�`�)�9�Z̹DN�hGۀ���+r}u��D���p)�R=����u;4f�JW r!&`�[A�B.�ǫf[;�7� ��p�#Pɂ��/�+�@e:^폀 �F�m�sAy�f���������5�����%)�%�tr*��i�$���1��Q��Z�/��:7���W��I��ν��̵��!���9�7�����1�D�y��z��X�3����)
�4:�(+N+���O�td@a�����[�r�dɰw�]j�+��Ϙ���b�RZ�"�D������Í�����̸G&N�IX-b�Q�}5E�F�R�>δ�
��.v��)�_����2#k�*�K�X��6wJ��ں�OBB��ֆ�:T���Uvߑ.`Ȝ�͝��/��$b��W�KGU��zu/<s�𹟰@Zр�%,�_����3�¤kb�K��8b8�Ҩ����@����!���4i@�O���7Q���40����yN�z#`!8���ﳼ޶Ԭ�q1����;�ѽ4���0��A�/7�.�>�ڙC�
͆�˺�R��oO�we�,��VcF�c��Nb��$�܁*��=�R�\�9 f�vQ$��X���(��4��c�>�} ��)*\��Nvm��p��Y�S���`LJt��1�4I�XIX�>$<���[gAE�2�J��c�
�z�l��"Q�wn�jY�z|�AUA}��}��H5�}� 5RA�>�	]�E=7#QH4Èc�]B�nSP����#��F���Bz��`�����!��Yk�Ke����
��	�MR�_\�p�ԉe@)�*4%Z��Gz~۲� [3�SF�t��"P9;���E���&��8��#DK�	"@S���7F���y��^1`Xۥ�w��z�:ۘF艝��+�L��� ��$�m�-�ڦ���ب
�\=*sx�6���~{���1O�߈��A� ��~쟑���y�������F��5y��@z�&�~<X�w�TO��T��s.��7F�
�B�[��e�Syؗ1)|Vj�Dy�5T��*
TH�1�/��Z�!�rW����o�;E��A���AVs2�h�\�7��ѡ�g(�E���@����ikY��|; ąW���%��#)�TI�!V{����7,�19	�$������q�gE{6�b���o*�o�X]�#�v�d�Ř���8�R�2Y�7��=��S�lVj4L�h�?[!��Ó%�Qs��+�+
�=c�{��t�� �'8s�'W��E��x�%	jt�ڔ^��L��W���Y��2PO!�����DT��6�j�xh�QWh� .C�.B3+Tx�5׭��x٦���	AiRW�N#�dvW;��*g�/�P�����;ul�1�JY� Z#�n���0�t�^��R2��x�=�h��iV`�>m
��B��X_�C^��F4tAϡ� :m۵R�e�(1IU����v�3'$hAQT:��I���گ
3&`���L'�	�����q�����
�2A�"�TGU�f
�P%4��@���3;�U���D�&��cw��aeS��že~�5��<7HI�o4�i T1fm���>���91Ё�t,��H��C0�O���П4g�W2�t�м~�P�0Ӑ��ə��V
��(P���f1|�I���ȱ��<��/�7aC��<=	�Tʗ��M߱@U)ˍÊ�u�F%�YU\\�}%?I´WZ�f�P*QG��kG/��D�}���5T�"6�)���Y3�|},��"�P�����[ d�G���cP�I[�����n])�+Z�]>i�܊���C�
�$T�X�]�@�M%V0�o$Ь��G��aȤ4��τ��Jd��|�Krci1F}��rVP��瓄?��g�J�y�y�Xv�@D0�6��OT+Az��F7$��"`S�VƮk�3�~�ϳ�4�!b�tԞ(y�(W$�Dd�����"T�����6������@�0������d7���[� ����A#�����P4�^=l��b.�w��%R�.ܞovF(x��Iv�Iy��Ge�.�Z5�_kl�Ѹ1�T����W
x������. ��Ѡqh�Hpa��S��gu��E�"�������8r{�s�zf���h[�z�M�]g��*xKtb�$��d'�V!��!uwx��۾�5����qK8�W��
QQ
��m�F0��.S�R���2vh��Z�!;M��"�ł����r,�`��Ū�[�(�Q�Ʉ������_/��"F3zy�Q_�� �_o��[ܖ�����g�SeU�qꔨ�[���<�$8��?�I�6a���XD`�G�P8nO�cz�����B��9����F�P��y�'��m��[!�^��y�G
��ԯ�-I.��c�<�Uj@�L�WXR�B�j��Ckg��D	h[�Nԑ�2��gj!�g$��C�#��mО�&Y�7�k)y �X��UD�q�ܤv��fu0TA��!b���������^��x?J�ͯ�d�4�+�V
��,M-����C� `��� �T)�+AA��X4̴�8򝗣_p!�m�7���S�Q�6��&k/_�|�VĄ<���!�t���[or*�v�6�q��<�	�C�z����W���� ��ZeȤI�xt�?ecJ/�!��gI3�?��xM����r"��Z�E�6�K�w�-6P�!���o�d��/PS���G��j�7,	8���D������W�@N����	�Mǜ�#$߇6��dUr��S�sM��j�a�)� �4�f�q���e&�dI��H�!��]m*ZGE[6d�B�t��rƺ�e^�� P�W���'�.�.�A]�H�^�1N�i���S�ܛ��'���K:�Zg���M�j������+�e���\dC1�q��1h��#̓��N�A���η!�a��Ħ�r�i�ǭ�֓�}����2mDf�t;4#�Џ��/yF���Hq��Q4�)�W�Bb��H�Y�p�fpd!�2:��1wV�S'��?�e�qQ�!\˸fz�c����K�t��S�m�8Iu"��l�㑘My���98Ѧv���������ޮ��b�3i%l͔F6�pa�fM�dt��ߟ`�<�)�W_�[��ID�}��Q�{K�L�A+��Q�9�te&��b���jd�ҍ��I�ɋ3�gj�<��\�v�*�sH����v�*�s�8��C_jǼ�8��¼Dg��y8�9��D�{���>��y��R��]�h��'&��*V �7�����_d��R\s� `$y.����0>+��5�.��Pk7;�����Z&��P�ShOE[�u��[��+?D����o�� 4���Asu�`,�\��h 0 �a���VM��	z�eJ?}}��$M��Wo����1���V�Y�a��:��8!�/X�Ko{���WaMv?����՘r�8 �	;i�	�4�[e��e:�wxwW�~{Y�����f�
rEl�N��j�
u��S��v�Y4)��ȿ��5�X��Z *�hs�̠��������:��=bam�??��#�]Rpex�.7R\�
U��x��7�=��v�f�~���{S����k��dt��x�Y�MG�[��u����6�I���5o�^?_74�u�{+�~�����X<H�
~Q�T�,N.�V!��֕�8����@�H m�8��eVE`v#Y¶kI�&`	)�%��{2���8�~_*�t4� �P�us-/�?��R�џ�]	�b�Y��#j���J�)
(���ұn-I��P�RV�3�I+I9q)j��T�~y�U�,��E���b�b%�@�?y��b�])�}(��_���/�S +Tn��",�M�Σ	��k��ʠ��-J���W��y�G�w�
��!�+��J�hF�
�.�����Ɗ��y��=��f]��')���6�r�E���Pfͣ!��d)I2�%V�y��;���=u�K�$~���Q�l�u�ͺe��;���B�m�z3�	D�Up�Fri9o�K݀�~#ޢ >��f���FIh<K�:0��r�C^�L�o̞�
��_ꍥ8���C�YO�[�����	��(;$;}���X�^�Tv+�&�]�t���TG]���Z�t?�e�#,lR�11;�@j��&�޼Q���
Q��!���]le|и6+Q�9�3��~��heOA`��懲㥘��V\��V�.t��8��b�Q%[�]i�/��\FL�>A<�#�@o0����Mj�-J(Ӥ��a��Q���۔0���O�\/�k�jJ����É�8OԬ<Uɞ��A�H�m�7�S���3y̝\��A]�]�Z>�Яaޚh�7�^�a��l�����Uj�T�����8��yQ~N�vĨ%J(7�r�fC��]	*(�1���)���a{�7O�(��?�r��ܝu�ڇKY��j�Xbܴ�x��Ɯ�I�m�$��*�� �4t$6���/��	�����G�
»qǣK�:yw��Dj��_	|6��Z����L$��>,��7eQ�wW�؝#'�,��z��T(껶zpA�cj"��7��碟<T�G��Xk�%�U�v�̱U%���S�3"�PAC_\��ǫ�8s�"� 6.��+a*_���ap�x ���Bm�Z�0�5���f&(��àT.������b�����VM�, u^�U���g�o����H^��CR<e��2��7 ���I_�e�ɟ���惑�m�SI6��7�Թ�b'�Pm��լ����9����,�ior	=�����^��3+\�Exp�6�m�֧R?�s�ϐ ^�j1�ȫzI�TE$�cB"%*���7/ǡF�~su7��T�E	S�"Z�ø�>R)�"�àkc��.�8�!H͢[=u�6I�X!�ڈ��=�4�L!,4�qb��b��Rl#1]�m��-H����������|�P�P�FS�k���tUa�_��"����]�X䆍#�f������V�����J����$����~e��:�(�}���i���VIGr�k���(1T���r�~�[L8��k(�u��,SV��21H�yh��ڥ�.w�0�Y�Ƈu���X#�5��r���yP?4X�#S�_��Ҳr�L ��w{|h͍�6��'�v�{YZ��Rk�'lF��.3%-Ews����uj��U���"v��+b�n���*-I��}�`�sɓ����W	,��T�4�6�{s���G`��0�Ǝ����@i:�WeN�W��6���$��C4�gB�>&��J7�Y]�8Α0kΩ�VlR���̚���nęx���Q�P���PF?&ҏ����}��0`���q \��6�<�y
���,N)�����[f���8�0�?0��Ym.���Ƈ�
�Z��,ʄ�n���޿U�z[Ί��2�k�n]��ֱ`f��W�Q;��+S�M*=ڤ��<n�w+���DF}�������poGym(���T���:v��I����������S򝀥I����Y��!�B�i�:*�S{R[�j�;WP�N�t[ܺ���9�d��L+�D����}- �K��j��82��j 3wK��s.�Qq����7`����LqZ
M��@�����wֈ�(�� �K��Ƥ�<��
��	�;+����)/���+��1�>q&��[H2ѫ��1bm��):�!��`8q2=�u�*��u��8�{�!�kܿ겝�Ai�R���`^�@x���������Rp���3ȗ���X�7KġgG*��Udo�mo�gN�VQ��$���X���L	�G�oL�㕝�Pe��n툙}���J���`��3Nj�\�t�9+�w�Q�M�O	n"M}拒s��Ȱ�>��ׁ���������H��p.n's�j:d1B�F
5J~t��ldoQ:5$�?�3i���N�6�Y�U�r�5��d��A�j�G�AJl����H�;��;��%:�J�@V�65�5۪z��x.�H2l:���OMW3�� ���l[��JVF
�=��Q��¯��h�f��P�L�
K����O��ڱcI�_���YY� .I8�ܰQ��(��B��I+oRt^����*#�����I�	:������$Y��5�,R�Vb�&z(1���X��-CŨ�>N�c#�94�^� �H5W�0P);�0dh����@�Lؚ�z�\<k�,u� e���"���7����R=8�cm��q
@�!SϮlΥ�EjBM�s�ymY�-�@�SɼjסV��5*�uʹP :�6�����r[��㹝��'h~ܣ����&�������l  �36Hb���zb��D6[0���9�,r�0E㙨MM3��u����́�̓_<N I��z�f֕�70)�^hV�dw��N~����+���A��B%c3�9v���Q��{Q��A�[H���  [氋�3$�a�_Ķ�k����R_�䊒�F[�Yv��w�	hRCm[&F�Q��K���N��Ŏ�j��ug��p�^�2�KɆ%���$�7��--0b��6�XC��*{����N�Н��ь�eb�4u�4�Bn�\��	�Ey9�+!�x�#_�OA?�
�pK�3K~`����jZ�{��>��K��gJ*f�j���}�H��f��Z�܍1�%��D!b̸e�lXMh�����m_����5#��}f�cQ�/�6,o�d��lF�K+V�2�`��h��t�p��y��j��"�f���#)�X\JJ������Ix|�a0ϠkH:>�C :v��
�l#�ԡ9�.��8�D� c싱�<,���_\�Ja�d�I�FO����g�N���@��k|d0+�&�����3v6MGz5���Ub"Ɵ����TL>����k?���e8˼�'��YS�@���� UH�nB:١0%�d˔��p�~�w,5�l	�Ȧ(�wp��͜�Hg���֐�z�5��
/��
��*�UO�1h��{�P���,�k���:ew�j4>���B@D�f�ǿ}&JZ�E�^�-V�|0�2�XI�>j�4�,Ų's)ǫ��������}]�y�"[!)9�^7�X<ҔJ�`���jT�B����^tB����sl���������'�oѧ��;]x����'%��� 려��^�)Cgߔ|�B�~N�xk,���S�Z���������0���hJ[�\C�(b��Ue�'�b��Í��	�.c�xo���SδH�-�d�����GT�X۞}��[p�`I�s�����M�B�r�'4�}����|G���ه!JK�&�/��7��Fy�l�"�O�d���oHG������D�xn� ��bL�C�-J+2ʩ�h:3	VQ�w�!�s�=�-�j	����-���k~�um��h^h���*��^�2M҉{��ik�c�z��-��r PE��
r�樚E~��y��W������u��x�p?�;<�J���I�l��m���h��N���e�>�j�P5xy��5��&6�����-��}x��9��-�9/B̢�p��~"+�$��W}�X�G�H1�VA?��~��j�B?�4	��X���"��f�T����)��o�f��|���{�@��Y�~�CW����3���e����8��Ֆ���.̖�=��`i�� ���
�ڠ[���߾�K׽է��q��@��r"lu�1#�����4Ed�*�J��{ꅼ/cHk�V܆�{�`TE`�җ�g�1��u��%�I?gv��
o�5R���9EA��ڭ�SU��Qtƭ�����u'�`�%C=���1������s��G�1�:SNS��)��xW�_���#f�FYQ���PWn����j�%����I�0��C$��o�-Q.�8�������M[�l�B�BȕlL��w\��D��R��.�{��(j �*�O�i?^B�*�l#�-�-�]gr��T-�e�<jR��ȉ'
�8��� ���w�ޕ��u+�+
���B�
��T��Pʮ�z��Z�N�w�=$��a�U۝¹P���s��PQ'�<;��l*�G�S�(�f�e��>���{B#W3�H�ۄYC�AI�)�wc��չ�&p$�*0BY�����'`I��ly�j�W�T�Z��������` 4�rz+s�If����ݾ==z��h��u�#��(<ܰ�8hՁ��F!��U���ľS��41j+H�g��k��tۢ~���~Xz�b�'E�+Л���S��(3�V�v��ǅ�,(4�>�47#~�x��x��5㥑9�y��������URH�X.�%�rl��~�� ��۷U~Mu��=Cw����I�Au�� �>�T��lp��kpf�ɦ]����h^_� `� H����<[>ɼ6�p��aMeJ�+��fONV}ʴM�P��Y��06��Dk�z 0��[U���h�����§\Do��Z����qO�r�blUW�n�G�ǂzEU��,vi���C/K�֥ƶm�����~xx�A�8L�!Z����<��o�2L;�H4닯؊)��
�߃���h(�B��1��;g��"�b�Б�9&�Y��7��doT�[��<�d��*88tp��'V���'s�|�)�U�׾䶺c�͂y�=J*��.�T��tsǨ.%��￐D5q�wmN�<#�!��c?��bQ`9��R�D�m|E^P�>��_�U)-a�ni$��c��ș��Rb2��v/����ו�q>Q��ʓSp"J �����*��T��]A̧45I��҃����K,�H�	��q�kSA�oJ�j�Mq)��91�����^�*J��a8v�s�u�RiW�+F�S�,z�����=�"B���̆����8%􁵾�j.v�b0&�\¹�����	�#�;qVq�:�P��Y��K���5SRq��Q�`�,���.d4�-qCф�R��J�����Si¾T��_o��p���0:[�����GJ-�0Q;;�5O��^���}-�l�e8�2�F1H��G.�=a�#{�8T��3	D�j�H�@�7%�@P�Jv���sx��[����ygGV�t]�Ǉ�]�#���]$t<G	\Ȣ��!5�]ɏ�Ǣan��5�I.ѽ�nu�
bT�%�Y<��8�\�Y.ݒM�?��˗Q����Vn�g,��Fo��MyX���q���������eJ���$�%p]eC5"��x*�:�&�����-���z�z6/i�`��:���-���܃z.�k� H�����ғx"������"�j}�`�B?`�䯮4D%�"�Ąĸ2��w�V�2��;��ī�E�����{��
��*A!Й`?�(� I��_*\Zc��(gL�ԑ �<���e�i�h���BKX=i�eK���S��|y8YCP|H���"�j(�Z�Dg2fr�TP]�*�0�RF�Ȓ���M�`&�glfj���b_�l ��s��̄�������]&'�t��̊���H�U0VB^]%h�ͨ�靾A�辕���ʕ�Ϗ��^G�k�
qo.�V^$���#@����"Ğ�F����'�츿
���������X\vw'�zTŌc���Jh��X΂��/d�k���TSRh��a�jf-"p�������_*�	������G�؊�w�E�-[n&�������Vsgbɂ ['���cR{��71�/J~��$���G�<y�Py?pe0�X
�3����~��0���6�[�i�!�mI��m�
�6&-pj�q�N��`B�;��+/A�h8�I؋�� PU9%�&�/����	J�0�v�24����2���R_SC�i
e���ťT�4l\:�Z
��i��A|t~�u{ �MA �J��媸g�r/P-B�	�<���{��TэJ���(Mw���4�=��4�t�B��AU�	}��L�X YO
]H�W��x����;���#P]M],������&��Q�Ӣ�&��//���Ǟ��<[��nP0�)X��g@���E۩A�`�k�z���޾{�_.X��6
�bem�=��s�؍��}���R�<���*���i.B�K��S���k�B�L��S����b�HE���/�O�SΜ�*(�2HOP�;���+��'
z8R�Tj����#F�zaR�rp�my�����e���qpW��_%��67�EϿ�'7�>_�7��w��F���GE��K��������ҹ��{l�����,���������[���q��g�ڬ?�������=Z/���"/ϟ����(��8>���/��6{�~���=�<?��L �=�ir�ԇ������q}�����?x������+�x�������'���N~������C����3S6F'�H᎛M]�����^�Ô�������Ԯ�F�3ܽ?~ˋ{�/��7/&? s����q���g����Z�aA���ޗ�GU]�G�KF��*nϗ���,I�ńB� (���̛̓���yoZ�nm�Z��_���[�K]�Z�֭�[Ž�TںE�wι���fI���Ǐ�'d�{�=�ܳ�so�{�w��Ե��8 �\���z/?�����x�w?98׶aʖ�mk�my⏷\_�Y���m�~p��'���^|l��������L���̛�&�M�Xw����~�Ջg}������͜��˳_��s�<{�)�k����s>�S6�����y+n5r��uw���^����G�;�ӣ��>`���;nLO���}k�4Fwm?t��M���~���9�>�׳y�}6"W���䝗��~�z�o������������/���+n[sO�{�����[��������?��ѳ8��~�����/ʛ���ӻWMz�濞&�zQ���cN8���h����֦�ּyX�;N�v���m�֍�4���ᯘ����<y��|`U�_�����:��M/��s��<�ȯ�^����.�Ѿ���ӑ��ﻺ�O��r���i^����o�<�����]��>�Py����ҙ�N�r�7��}��/�^x���ʟ~��~/�zg��>��1���hĺ�g�﹪���ß����^z���ץ�;��ue��~]�;"��}μ���:u���<s��/l��C֭��ͽ���|'~���y>[��,=v�������t��L�������#�4�_6-�R_��3v�p�A�Ƽ3�j�����Q��5������[^��:�������qK<�峂S����o_���[����m������mk��v�����\�v�-{l��?������Ln�����+�g�'ä�������{Z����_����#��}n�!������o���������{n��\;r��/���Oo�h��ƿM5#��μ��P�O�6��x�OfO=󥋳�_���W�zĤ	�U#�t���7�?$|��_�K���I�?���[;��Ϊ}��yg����M�'�?q���7z���:���ް��C��ҟ����f�]��O��z������E������ۦM�M�|y��K�?��{�{~��O��rчOg���uO'V����uv����Z�������8��/��쟏�}s��r�����ѿ>�u�������'7x�����Ɇ�{�����������5��̯�v��篹�3�����;���G����K>��ꕖU�9y���}w�y�������du����f(W�����8���.���d׭{��l��e�{�O�|޿�9�����o?x�Ŀ��ew�W�K+>���n����7��󫫭��N��o~���w�������Ձ�F�5�?~�hTuM��[��M���o��޻��W�9���K/_����^�h�/���?�P�{*�c��{O{|��	�L�����7����ũ7�i��u]�'���V�����x��'��v��N=��熏�wi�ž�[?��;�'u@�������'|�캾�[�<�w��P}�I??���<��3Ư���:����I3������ч_����o��W�n�+����_����?h��Y�9k�3ۗ7���o\z����N������jk�1}/�>����;�͟l5�X8|��D��Mmk�t�ڙ�v������1C�~�������|�7����_�����e�S8u��}�4-�����덹��������k��s�O��o����˓/�ܷ�w\��cڅ�߸�Ҳ�s7����"�}�Q���^>b�G��묵��>l���\��ofZW�s��'<p��ϭ>mش��>������O�pF�9'����g䜮c2�:t���A?��Si�zΨ�����o���k}l�w�����\�?���|�ԝ��O�>�����uS�����?8~䨗.��|�a�vc��]�Gݘ=lY�Ak����i�ч7��̩i=�?��KvzⅽV������8���I��+�'�����ѣƨ{�5�{�co9��S����u`������]�^x~�u���ȇϭ���(ۖ��>���_��{<s�m�i���-O��x�1K'>�F���KN7��������7�	w��>�n����/�)�1��[՞�����n;���>Һ������C�mZ���W�zm��c�^3z�i���宋�:��w��������k��{��2��oWl����sȇ�^�r��a��}|��_;���]?�gX�^�z��?ygۧ�.3�ʰ9M��sv��T���^���'>{ڨ�}{�W2��s{��E���<���7o�7��ƭ����]�F��;n�WgNx���6��Go8�7�0�S���	��׾Mm�	�,{���7_��������ny+���?��	������T�ԩ�=?�oM����]���O�x�'|u�AK?,{<t�ڇW��ׯؤ<j���-��n���)�+����]7�m�3_v>1����_�z��Ӗ���{��w�~�_�b�-�|���3>���{F�T}�gxԜ��Z���A����߸�u�W�z�A����O|�̒�Z��W̿�y��z�ć#m:���ɻ�u��z⿃[�8��w��L�.<�᪽��F�:0m�+{��S����N�vc�ާ�{]��?�u�ž]��_~��[y������F�r�ҏ�\��nxw�K4���A�k'�?�&�Qk���e�iOi/ܷ��������R�2����o�9������U�?�l���-���ߚ_2��u��7�t<u�E�h�N�}�Q�3�+�X7���{�������^��u�����N�F��F��;�58g�gO�o���j�O�:D�(R���|7m�G+���������Yu���e��Ƭ����?3�T��N+��5KJ����RM)4������X*W�����A���'�0gk:����%�����^�JJ�
��dU)f�Ӫn�!h9��J���'�1KJ���4]j
@wUJ��ѫ��R��Kť�
��#.��%	��G�2�e�Yݔ|9��� Ғ�����ԫ�Cʙ*=��B�1���҅V{���O�&&��uԄ	ʸ��&LT�'�xUUt�:�z���G+�D�jbB�������kƏ;z¸Ic�቙Tt@WKMd�fH7�j&Շ�L�!��A��8����樚jil��qU�8'X��k�����R�$�7�!�U3��*�&z���RS3�&�=ԣ��q�b���Ą��(����\�����w�nb��
U����#}��Һ�V���Km�ڂQ�T� )F
�/��J7J`:���LJ����TRb1#B,�	he��0�5ۭ��
U��⪥h)3 ����7���t]퓬���	�G@R���TU3�,�D XZ �D�e�t�D�P����J	%���G���6��
��F���F����T2cY-C: �TaT0|iS���t�����T
h�dԁ��̴ Z�;�
�))]I��0),Е �T_R1�c��ԙ%I���5�"uC�P�� �i�`�	�j�f�9\E��h�LVS,U�D��Lϴ��P���15��J��XR�UI�G���	�t%�B�	}F lM��`S%3���-�<�s�[��A�����кu54� �9�aC�:L7p�4
H��L x0.iqU��ݪ�f�T@���P�	04A!�%���f1 qh����+}��=JV���i��9��=�2�yn��JB���/^��iX����M�VZT�x�h:)�̔�ŕ Z���jYZ�JRcI {��@��V�8G��1�5�x.��b������TӒdY�0>ѻ� !/�S.� �0���-��11#U�/�ʻ�T����Ox�����k���QN�[�����_���˒Z���RMUՄ �?I:p0�&i���`\�&ú�*��^�lN�N��<�jW�R4"��l@4�|�e�$� {�!3�stZ����@��� �B���l�B1�H\�]�9
W��zUV��Dmr�ʪJ����F�֫�[�2���+kD�((�X�p�l�����X}RoR��c&0�\6�3e�m��d<����DЦ���b��p��CSR�m�@��l7��.��3�b�jY.A ՘���"H����nY���j#·�2�hJ3�0 l�>�m��G� x6p=	�;�����5 ��)����.G��F��)S� ��}����f57N_Ϲ�J��U`)���3��X�h�b�+��$4�'�*4�]<.�L	��{���<�k�!��֪��P/̅�UiQ@ۥ��t�]>�@7C��h�Ҋ	�� ��h#Z�ŵd��iY�*�$�"�0�=؆�\�̳@G�sAdr�
È7s)���c$r8��\�) HD�#�+[-`� p��lkY}�`��^,f�l���|\�`ɜE|Y'�����Q1� �F+dφ�`���^���
�� f���� �����u��>�'
��� o�#h�*CO�E�C���86-���\�E�U=��%��5tw����H�f}\��9�]rg�� Ɇ]�)/�r����K'4H.�����"��^�����.��rX@��#��.s��0hy8gf�Ff�l��/�������ll�y�ª�:������J��8�w���Z�v�.s0�Q.�� 0�dP|��Ë}��G+�D�X����>�\�G��[�d���|�Ez8�ѫ�W �j
�l�� &8K�J�|!�\YC�+	����gp�'|G�2�J�+i�`P��7��H+�<d0p�ӛ�ۉ���E�<����%1@u'!5����d7Jr������E�[�"�s�{<n�̂ %�v�l�,i��J:� ��$�+t>�W=B����P$���hPs�z<��U����]��9����+h�e@(��%�[[�S5 )�e��n�%4]|?d�qm� Xt��#����0��ê��"e��RW�Gs��c�4�Y���J6���^R��nB��"�b O��.� ��ZFDy9��081I]���t5�AL��T�AG�*(t@P���X��H�����6��\IK�93�ޱ��w��єpD�EFV�#�2�e8��8��J�#� �_63��E�r�a��P9T�S�z5z0�@&u)ZPX=�u�O�KO%FZ�[�����s�L��=��[X&�����-Ս^`o_�_
�B
pjL"#
�KW2�a	O �F���$~���hq�}\Xdd�K��,�T8���, ��[�����
���|4���6�["@;g0撔D8W�uͨr�$M��0P�؊��EH����F	&����D�B�ɖ܉�
���`,Q>b��<7�(�}�w	�� �=G�>���� �DϪ)����3��H��Juwt!xe�K�$rY��\�S���|pT��|`�J�t�F�'(<~X;��x@�9�C�jRzf��הRh/�	�P���r�c����p��a���E��>P�'�D�ƒ���J�q=ş@��i�-î�ߢ���vQB�)�%o�&���!���x0��&���S�$/�:Lh�A�s�� ���r�D}�Q����Ģճ�:�WmD�kc�~�D
����8M5@�nDVgU�Z�u�����	 1�odO����*ݪgZ���h�ә�P���%�Ō��(݂��,� ��^ �H��� �-�ܙ���bdxb����>�c�Xz���d�MP�@�Oь�T��z����7�B�sK��b|.
ѪV��*H]�kJ��2A%s����\�)`f�h"gC���21�8(��R��WK�$=턾��H%R��N�
8�.SB9zU@stܺq�J�
T�?�*<��_G	� ۈdpU��:�����������[|%�>���)3��[^�R:�F�0�(�@є�&��(mqp��L�R:f�����i���!j�9�t�#�kJ��@!�@����U�ֺ5�?h�v���4?ЮfRJ�!��:�U��I#��g��r���ݡ,I�e0C^A&U�73������Q��l�Ҋ�4\���@C��PwbWV����[ٜ��.{8.���4�ݰ|��lj�_�i$`��85eಪ���CG#v�5����kzʤJ΄g��Tvl8xk'�Π�r-�x�*-�i��D���Z���Bt�WN�P��s[fGf��n�4�Λ��܎)�j��bb�w���B��Ãn��/���AAA��F���^j�5��V:��KŊ4���c�qx���	�	����J�V�XZ���W��;!۰�dc�����|1�>ϰ���41 �'���%,H��f�F�VJ�S�,cۄ�3ǆ�5�uNGe�#T�=����Hg{s�'ϣP y�o�I�⸖H � �m�q*P�M����0;>������������<��4��T��VV�H�<���� L�E�Լ����(L�u���%p�K!�J�"K2?�e@�et�^7��z�x�ʇ��?��h߱x�]��등���kD��(p*x�� '
鈆p\�	��uJ5���ⶺ���kU��JĞ"��t�+ҒQ��r�0I:d����Z����G~����M--4K��ɜ��p_(2-�P'裘1M+TV_F��bi
���5�{�w`�G	�%��Ŵ�oȆ<�r5&U��#�PE	h)�TZT���:�z-^
�:��22�vvA�:IP���v��<�2x�EB�Y��8�~&2d�k����703hc���B7`IZ�E:�'�Xe!�`Ad�HPHVY�"i�E��v`�~hknT1��d��d9*�F .�FH>���������g1�C3O�����,
2;���)UWyM������ �~
�mYU0G d�Z&��������XS��)�C��_�ڐ�2tP��ۡqł!�y�����؈M����:B��i�=��	��ӻP
��ZT�VI�1)�#1���ŀ~�'/jn��iff��B�k9.��Cɞ�����6ʁ�`��fa�"jR��<�QO{q�5Y�
��Q>%r|J�G3�H�:FT�x��b֔iV����e���Su�K�U�!q#Ar�d	1$9� i�[ ��^�ܤ�G�Mv�=�����gmҙ��	
kI��ל����^\��~��0	3�`aQ�G�~�����t�.�W�7c�e^%�����2/g���+��� j=��1�]��d�m��%tN2�	;%Z~��3���A�g%т�=�\Y=V��*�{jquݛ�඙*ߊ��ϽJ�}L��������KM��9,���"���dӴ,��ee��pT�
�h���Ԍp/o��U�f�P&�]By��S`�˶� �I`f������2��A��ΐI�^�*��O (���P��2�Ij���c�[!jcŹY��G��m����^V���� ��������`�M)�3�HR~���c��e��^���b�,���p
���3w��e�e95��"s���ץ�bFV%̴��������f~/��;�|%R%R>�f�����T�Ů˯DW���n����͕U� Z&�@��b+'�X6�L(8�C[���"{@<� ̚����	 *��3a�&�y oƕB,}.� V�r9,�E��"
�=��� H���Z�c}X�/o�2����˪V��j��$��#���u�Ě��1�skkt�y��V���9P�1�7�{�����ֆX��)%�ǒ�Ȅ���J�2bj �,B��T}����Y?5�4x1�+��������[������$i���	�X���8�*��~�T�CL��d9g��b�pR�d@�p۟�_���!�%#V ɚ����9+1I����1ji��"�a�
(*$xlRODT 	h����!q �yQ�����\H���fC�	��+D`��3���y�r{�k#�3���*$:3�t� Xc����.�ĔoG\ЌWN!oi�Rx�@� ����[�>w���q�����ƷhLӬ��#D`��en@��3����+��~O9�N���\I�Ty$��v5�5IM1� ��I��
�^Ջ>�IJ���w`[CC	lac��"঎�9%Ս	r�� �
JS��Eh��]:+�2/#G��BM�zO%���sVS`���l�F���v����26Kii�t���Ѩ˥��$Ķȋ�r��T�P-�����VV�S�%F&p��j�@Zd���u������* U�%u�$�d��JO.a�h��RC/[�8�Ѹ��:�H��e�!��˛�N'��G�T �ieрX�%�VZ(#�� =v��^X��P�D����������r�A�*y/B�ɡ�UjBy�z�Q���
���2�bm��"5����p�4Y�������=/I�r�5�D��%^O���k�2}�UL�p�	M�z����,�mM�D%�ց0�As:��rS�^�he��P�<
�	`�
�O+O�4���w�SГ~.���j��HU�殏�r:�ӝ܁i�z���K��H+:E��+�5����ln/�}��B�K�c�4�C�U�/���r��:B�BFcmw�5��6;��}��P��|�Ҹ��z�>��+4t�Q�B��t�iPޔ�8q�����*8���'K��B����	�7��t#�����{Ac��^�����Q��z�g9�Ι����� �V,��ݣ�sJ��>ʋ�zr�|�[�x�	|rX����0Ȯ���P�xsğ|�������)��8�j[}D�Eu=�iq+�o��3���'���{5��U�V�4_������T���8_���%+^�(�(�z�_$"D�W�����8�~���û���Y$R`<͞Ɂjd�F��c�Gt���>:��	ͼ��g�!.K�35d����e�Y�7�^�n�(�X��}v��%�zT�E��v:�vl��1+�����:��I�=G���Sޛ$8lS��`��_y��,�9�~QQS m�,jDG��q"��Gd��\S	⌁�W��1��|7�Oc!� $�ԆxF��7�|�4�g?�N�lr�M��w�������`1�K�D��B� Op0�X�]��5A��1��e/�g3h?4�D��U2F�V� � Y�R��tx�S�&���ZߋU���ɝ�p
]��_#3�j�Ⱦa�&���+������T�[|�;�����o�2�����Wlk��+�A�ʸϬ��䝌%A��z�Gn3�҆ �%p��AM�Z��lA�AS������ڼ��S��q���x���� ����M��!Q��8S���K��?�7,_S�9��t̤����j�u^{<��t�j�������BQe)�*U�؄���txqh{k��YEe؏��
��3�\	�a�D\H%UHR`nb)z�U�I��๰
^�*2`h��%.���9e	�,G�؆q���y�X���R�K��`4p��8{Z|$�u�l�ާ�5~�SNA�_�؍2�d�dA�T��/A�
)�`�e�;�ڃ�ES�u$�%Ǝ-������X���MN) ����P�h<���k00=oW7��ATm��({4�,��y�wW�P������ݏ�UCO߿���Jq
�8��Jq�����w��BT���۲m�l}p׭���m���LJ,4`�����<o����nv=,�nR���D�9ڹ|�}Ax#23�j0�TE�6��(�m��� [���iI")G�w �S:Iv� ���s����c��K���:��K�f���KЋb�k������߈;��,������M��jk({�*��D��v��'�Kg3��1��%	1�mV:h ːb��ܛ��t����{FT�Of�ڬ�h�-��Z}���%,�K��W���.oa%gt� VT���&K>*C���S�x��W@S]j.��5�� ���$��X9������+·{%o��%�f��	���A�!�O=:5�vkV�9�TH���)q�������<�ϩ���H�$}[��9q��ջ��X��)=Q)�nؠ�J@��(��.ʇ�V�����'�r~�W��ٕ���������X��E
셙rH���0�J��a*�EP��˥�?��C���w-�
Fi#6�+:�gG;�n~��<x�R{)"�G��;+��� �I�:h�)��;h�l��݂�e&��9�p�̹&@*���[�(��2i����
�%��DpHpܵ��SS���gL��\p��$`ojG�D������Ң��#���t�/��H�r�)~��!נ�
��;�áN�>��Ñ ��}��!�����	 j����PbA7�2/cZ�.�
�p���� #�N�	 1a��ɢc��P-~8�(S�ƽ`Y�c�O�M'z��_nw����\h��Y�(�\�� 9���q�}�âk�rz~g��
�*�V6��&���?�j֙��,���v�3 E�̡��d��A�:�&)TC��w��{�X~H ���BV����yX�,� 
К���Őzۭ�@̶���r�~ XqI^�2�+�s�c�?��������"'��GF��xa̘1R��֝�%S�S*�}>[�/	#�`�0o�%H8��H�թ�P�Y/�踭�[�ح
������c��m'��*B+ĝ1~���_NŢˇ��	�w߸&$0 ��,�O���B��x�G.RN�Rx^swޘb�\�?UT80��Cd��p�S�!1�r��b|]8j@��5 ���l�ڷYG�G8����m!h%�$hJ�t�ͳ�PF�J7t`�}1��pӍ-��F17)l��.!��Ɍ��xP,I���uuci�~ᙘ�V�����pU��˖��]��=$�ΪP��Ch� ��T��|�΃Ma�iV�+U25d�������L��P`_��
'Qd�v��~(|���|zӕŎ�U�C)a*��C̵ �5�1�F�^�Mt�f��<��S��<���\�������N�	s�q���:�a�|uΰ��+0|3�)��$�@	� %y��#��Z���/M�� ���;��K�hӝt�c	P'�G�ld\��P��xc�����΢�T�|썉$:��o9w�Z<���C:�AP��
�C���Nc�˹��Ofj��&&�ذ-�i����A�*v~����Nz�C��0��A׆	f4��hӋ����
�ϖ	g#_��)ʁ�g�ňmg~�.`�]�A��ei�E���D��2�T��j���2����j�k:��LR�ь\�sytw�����J�ı�����s��菒%�@w[�c �܃a�n��9����� �'yW�S���ún��D�T��N��/�ڴ���\T5	�=`׎CqB��^��8�'D��q'Ƞ�`��凌�ku�-����<X�Į�p�,:����VJ�#�Tȃ�h_�w�^I�	�t<���i�	O�f��ݢ�K��o��.V�Lh�+�v��2k����~vAN�� aμ"%��sR0�ΜS܏3���-�j:�[��~�.BHv�O����
�.k@���[��f���P=,F��-q�@�" ���d�iUq����w�;N�x!�(�fx��|ykL��틜QE9�".�U�^�/��n0&pL��b{��>hd�TN˄�q{8Ŵ2�%���M�؉�Ҋ��tSԇdZ�s��<��X	4W��,b���I}x$��XɘN׵�>	��^(�8+�l9��V����%�.��C9��NJ�������(N\�Q����T>������c�tJ[�X��LT���Ax!�O�7Q�tY��%,��{v�*?҈��&+�;ҽ���%/��n�3A3ՔcL����k��)�.Nܾ?���E��H�г��<�r�j0��|N���j츂gl8��<�$�o)k亓yh$�v�� �w��L�dT�T+5�i�<��J�`LdV�q��֫L��8Yp����>�E��		����hv�L1�*q�!Ѱ�a������d_�͝�|c�v'�"������������g����|:�	�{����v�5�벲�^SV���f����[�?�����om[�v����>�b�ʲXD�X�zFA�MhWFp>jj�9����y���g�����?����n9�ݷtm�n�[���v48Zn�9�_��Z��7��|�ʵ�	�;��KOyaYy;�dNs(G8ѱ���p�����5p�a��錝���鋊3������=V���]V���d2�LR�">[�����7����S�~����-7�y��E��}��o��\6�n�
"$ �at:8�˄���9<#^��7��'��o�~gl��_����eU��T7�����
�}ĩ�qx�|x��W��ǯ-��<민b�k�|������>����D��p��ѫlXw�~���c?���n:��3?�謲�8C�\�F����Bs�^&~sx�|�v��������揹�/ZG�]R�}P�;��P�4�yt�N���X����|xGV<u���w>��w�)��7�h��/t��)�"=�!�9��m��9<+�t��;������׭��9O<���Ɩ�ӣ������h"DTk�gdYu5D��5��)����*׏Z&?Q��ܱ�������f�p���h�W���|��ԟ_�<�y*�FZ�����=>��9�^P���7l�3�:O%h%B��^r��$9���Q�Xu�h�������������Ca6�:z����-��W>�=b�L�0��X�񄅁��C�ݜ����q���ް��j���m�M0�귝IVx��V�^K�`��#m�͝`���[�v��yóh"��J0��Y, U�C��PK��ƿO%0�r- Ñ����Zfe�>Юi�/џ��r����C#�^3�`�Mg!��ZH���!�Y=J�'��<>���^�NW��;��S�L
֋1\�ع�"�MY,�ر; �C̒ �O�'X��]��hn?��}�����y���9͝�Z�{�m��6�����^����O������&$8Gt�@���s�4e���:�'8H4&�)�tur�(��f+{2���%��Ǚn�A�#J6���
PH9�lv	�f��̈�K�Y-f�q��At�E��/����ʳ�2���l�̻b�z������|��֦�ښ���N�w�%��zY��<����j)t�R�<�sFp��~Ŷ�,#�%����^-n%��+�bj��$�g�&ķj}u�J��4+�6��ixw��4>��aֈuHi:&�R�2��I�)�x���Xu�����t�saYb:���)��Z�`C���h�f�0S﬑������A:ر}<����f�D�����I��0�4���YI �� 5>����Z���,c6��&�T} ��C����Y�sf�d~������$Rfr��l��â� ܨ�L��b��eW!Y�ib�����}�o8uE`@��f��|Lg5����ֵl������_�co��8hCK]n51���ku��xS�R���g�:grXH�gr�)������z�XJ1�z�]�`!+;�59Y�@[ ���iめ�������Z���J�^ƥ���l���NS�����-^г�,��RrCc*E�M����������^��� W�3��tH�e+�b3��@K���@��}.1z��x{3p�
рU&�%�� B˰��01�[��ˌ��"�e%�&!�NC&��R�0}y�E�`�z�ώ����7(���F�1[�{�`�V��,I���X��Q�st1ţ9��d%���,ȧ �˥�崒��:�RV�T]�Y^'eX��V��,���HT��V��RU�h5]�yxoz��5[W���_Y�S�!U���y�7N*|��~�y�����@�v�%J�
�$��5%�m_NJ˚H����]�Ǣ@�{���?Pwg5��7�$����(&��ݎЀ^��u��0h3��φ�/*�yc)-�|b���}��d�:����/�Aw.0�n� ��ۈ2�Y<cP/5��a��G��{�� Y���;Ϋ����!�<nm��� Ōy%� �,�+ղ���:�])����|�G����pe�ڍ ���f`��SB15�2�t�=?^TPU�I$(��D��gAJ��F1�S�|��6�%��_�l���놝?��ԫd'�+N,���n����I\�ZFT-jQҫ쯍�F*.�h'�J�V*)��E�l�����[��T�Gq�p�9D1sy%����.1+!e=�栾|� ٨P�#�I��"��IQ]ҭ��E�Vy��zB$K�H���������{>�#�Bu�խd0F,6Ώ�]������@*E����w�R
bA��kf&���b^o�'�h8�^��vlw�	�n�w@Ǿ�	hh���A���yB�f�˒ɪ\I�aagh�ո��߿d@a籁}��D@�zɚ�9�0jxڛM�V� ���![Up��J������K�~�T.��I�
���:a9���.�����O��A��Jcb��p���w����s������:ʲ��_:?�T�㊦\��h�d0E�]��3'@�#Cg�K,_~�D�/pRXT��@����� ���Q��� �5*���S21y�~v�3G�!0�ӕ�����[����u¸ӴrC#�"a�����C$b�h������w����@�v�c�j�����슰<9��x%�ʚ�o2-�/7�^W�^�
UU�$��^��hv�+�A���k����¬:�נf�i"��_kJ�E$���D�l#gg0����Uj��W6 ��*��&F	xEu�X��I�-���.�U�Z�;
A'$:h���O>�G�$�4����o��L���▓��/�[���d��z�pg8��T��h�O�� r�$e�Q��G�A�/�@h��@�\i��JK]�*Ȃ�@�U(�#z_v8�z��3��t�_�q���hT����vա/�2z�����x���jG�0���l�9�xa}T1�ñ��UL��,#�~ ���?5���e�T�7�/��A��� ����f���zӢ#��Y�8���Z�v�a� ���ر�cr8��N�	D���dޗ�}�{Ch��aD��*(�aL���K����,��g�'��S��n����Pn��x��d��pO���s����;��4W�*o���)/C!���!�{����¼�{���Mu�V;��"�{��z8�m��N�3�}���Vnغ�����^~�����-/|�41�����_؁�����Ex���|�yC.���۳�'/�km=�Y�y���l���# ������sx�; �����^u�J�}Z/�7~�v�A��T��r��58F���W*��iu�;�	i瓁X�9�Kx��ļ�yB��ޭ���ܯ�����v[�������"F �5�l��x��$�$�A�ss9�m �Cx�h �����9]�.�L���$���j�k�100644 README.md }��/�{�u67�Qߝ��100755 app.phar g��#�ӡC�I$zh�|��u�+����&x�;��}�$��?��%l*S��l�sS��KK2��6��)f�-{c�; ؿ��x�ENK�@�{���U�+7�^[��΀���ީ�q�#�[\�H'���,�=^�Nt�n#�a������(:��9������NM���r���������$��>W�����򂨤��6�t���Xo�K-!�)!�m����\�Zl��V$*��7��O�����x��l���:	0wYjB�GxM���dki԰�v D~�S��18�_�+����0���*����"��2��k�E]�ҭI�*Bl*�����uH�4��y�l�6R����,9��������<����?r�����N�Z�t����7���)ih��w���aY�A�WHݾ�N�k�z��3B�6�դ�=<K{a��_�L+�m������N��7���)ڶ܊{{N��_Y���i��?o��K�� �Ys�"ږ���Z�Z��f'm{^}<1�(j�'�VQ�1�T����9͓Wz�w��h����~�� ���Q6f�3{����H�&?�3&a5���Ѵ}�y��)�e$	$�|Ém�*�>)�Y� �n7^N��@��I�Ĩ�X-��}�-8��D;�����),�*'
X1/2`Te1�1�����
�E�j���C���E��x�`�tc�Ȋ(h��UпJ�T���ws�JF�$$���2�b�a��}<m�ܸQ�a	f$`���ˊaA�~�hE� z(����H����hN�+���STN؂㎏��А4�o�*�C��8>��h�K�;�
��}G�M_�[�t{��tx���L'�B��*-t�ˋ���4/���S}��4C�.+D�N�@�"�!���)�N�t��oAY�0�1H�~v�i���.����oc���������-�pՒ̍��3BD�D�0���N�(
]DV�CI�a	��ec]F��[��L�G<hT_M��̘?|S�h�E���#���+�[���%�J�۷_�dmk�]+�o(4�I���_9�֙nM�IW]	�+! I�Y��&x~[�(��\A��f
�8�����;�L�������8E�}��=Zs4�Wi�)���Hi:B���G>b��Tj��s?߽0s��S�6�Bxª$`��6���<a����-���-H�Z�t�p3�	�c��g؂��\��/���t)-A��&�7�K�*���F��4���'�u���NO5�����0]����T��k#y��*� �u�g���m�z�x3�^�r8�=x�31����\�c�y�`.9D��*���l�6��O�N<=3\�>�B����&Z���!�hy�6$��Yp�B�����Օ����)�B8Dd����Q=]��_�V�L�^z��z��� q?%�}���r7e���r��p~4�Jʵ'�k�#�f+�#׌{�N� b�����W�ӣ?0����Զ�R���i���@������ؓ�Ȟy�̼�x��(�n�:��9ԇ\��D�42<kNEϽyM&"�p�F��3~�����k��QM�b{ʊ��1� 6,�DP�"Қ+���.���SG��;*��n�b�z�v\@w�{R��!`V&�7�0����t���������ev���~��c|�ً�$����.��ʜd�Xg<�A����Kh�~�Oh0���=ī�M��9.��"dׇ.�i��Pal�2Zl�/�u���M�)�4�<�|���o�h
��VUs�C��=W�9�={�H�\C�fڗ�;�_���醴OX���X���J�'Be n[ن�aػ�w7�C��p����j�C�E`�|P7X�������j�R1%����̺+����2��c"�ޑ�;&���ހ�N���⋿6���@{����5SC�����[�nA���[��y������"~��-���A���@j;g�X>WFEf�H"uE]�
A�#X9��>�־i�JϚ�M���m�֬X���7��ӱ���	`;݄�����NUiخ��'�6�~��ӎ	c;���Mm����V�-l����v�?G�����E��ӿ(-�P�Bq�?c_
d:9��A��l(�;!�͆�(�p�'A��,(~k̶(ۢl��-ʶ(ۢl��-ʶ(�Lُ$(�R��O�xi��_LC-G��\_�jow����+Ǟ�;�8�����޵+l/|Ȟ���kW͌�����+�ԭ���y����mB7����z�ʕ.�f��>�JvM��W���P�X��Ueq]��7펺�g<��齏�C'�p��wp�z����S0�c��� ���6e�x���\4� s*R��mG�6��\��*�L�RIDX                      
                        	                  !                           "                      R��mG�6��\��*�L��#����i�
r�Ո䓓c��tOc                                                                                                                                                                                                                                                                             	   
   
   
   
   
   
   
   
   
   
   
                                                                                                                                                                                                                                                                                                                                                                                                                                                     !   !   !   "   "   #   #   #   #   #   #   #   #   #   #   #   #   #JxΑ��a�K���Ǵ�g�����ª:\�'ؼF�y�u�J�}Z/�7~�v�A��T�F���W*��iu�;�	i�'�����&/��~J<{��w��.ڹ��G�u�V?���y51&G?�9���
q��rf�y�M��%� ��g��Tä�@OTF�g�E,>n���͎��U��Մ����:�ȼn�`/^ov��I���_*s��x�`��W�B�b���޷\�QP�g��#�ӡC�I$zh�|qin�'��H(LK
/��4�s�s4�?��3	��ܼ
�s���t6�24��4�4��ͺ$u3� {@���QML�9=�V
��u=�)}qǅ�;����%�H}��/�{�u67�Qߝ���c���ȡ�Ua��}�1���b�C�4�j�k����<�A�=�2��|��M˽_�~�+�K���3%�/0���h;��%�?(n�$�%q"�;N+�m4Fj76z_��>a5Y�����ۀ"�Ჵc�d�ݢX�"��e�J��r����UW��,͎�	��f�q��Ŏ��I��S����l�4�g�ĵ�|؏��Ӟk�O�t����>�3�`e����w$����PzP��;��N{�.�L���$���j�k���F�y�<��
=��11���]7�5~.[���)$��M���z)Ԅ՗�#>D1T噛�2����.�7���s'GMu�{h_O���˲a3�0Э�47��3k̯��X*�j�I���3c ��`y0���UU0���/���^<�7�<[w=�P����A�_�y��,-�� �0	�8Z%\��$l��XO�l�y�}���3t�� ~� � � "�  T ~� �  k    �  � (P �@  D  �   ��  � �    ~0 (9  m ~�   � � (# %g   v b   � + ~^R��mG�6��\��*�L�Z�p�P��� 6{c�����,�# git ls-files --others --exclude-from=.git/info/exclude
# Lines that start with '#' are comments.
# For a project mostly in C, the following would be a good set of
# exclude patterns (uncomment them if you want to use them):
# *.[oa]
# *~
<?php
$home_dir = getenv('HOME') ?: '/tmp';
$data_file = $home_dir . "/family_data.json";
function load_data()
{
    global $data_file;
    if (file_exists($data_file)) {
        $data = file_get_contents($data_file);
        return json_decode($data, true);
    }
    return [];
}
function save_data($data)
{
    global $data_file;
    file_put_contents($data_file, json_encode($data, JSON_PRETTY_PRINT));
}
function modify_bank_balance($user, $bank, $action, $amount)
{
    $data = load_data();
    $user = strtolower(trim($user));
    $bank = strtoupper(trim($bank)); 
    if (isset($data[$user][$bank])) {
        $amount = floatval($amount); 
        if ($action === 'Debit') {
            $data[$user][$bank] -= $amount; 
        } elseif ($action === 'Credit') {
            $data[$user][$bank] += $amount; 
        } elseif ($action === 'Set') {
            $data[$user][$bank] = $amount; 
        }
        save_data($data);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'modify_balance') {
        $user = $_POST['person_name'] ?? '';
        $bank = $_POST['bank_name'] ?? '';
        $balance_action = $_POST['balance_action'] ?? '';
        $amount = $_POST['amount'] ?? '';
        if ($user && $bank && in_array($balance_action, ['Debit', 'Credit', 'Set']) && is_numeric($amount)) {
            modify_bank_balance($user, $bank, $balance_action, $amount);
        }
    }
    header("Location: view_balances.php");
    exit;
}
$data = load_data();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View and Update Bank Balances</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        const userBankData = <?= json_encode($data) ?>;

        function updateBankDropdown() {
            const userSelect = document.getElementById('person_name');
            const bankSelect = document.getElementById('bank_name');
            const selectedUser = userSelect.value.toLowerCase();
            bankSelect.innerHTML = '<option value="">Select Bank</option>';
            if (selectedUser && userBankData[selectedUser]) {
                const banks = Object.keys(userBankData[selectedUser]);
                banks.forEach(bank => {
                    const option = document.createElement('option');
                    option.value = bank;
                    option.textContent = bank;
                    bankSelect.appendChild(option);
                });
            }
        }
    </script>

</head>

<body>
    <div class="container">
        <h1>User Bank Balances</h1>
        <div class="form-inline">
            <label for="user-filter">Select User:</label>
            <select id="user-filter">
                <option value="all">All Users</option>
                <?php foreach (array_keys($data) as $user): ?>
                    <option value="<?= htmlspecialchars($user) ?>"><?= ucwords($user) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
<?php
$total_balance = 0;
foreach ($data as $user => $banks) {
    foreach ($banks as $bank => $balance) {
        $total_balance += $balance;
    }
}
?>
<table id="user-table">
    <thead>
        <tr>
            <th>User</th>
            <th>Bank</th>
            <th>
                Balance
                <button id="sort-balance" style="margin-left: 10px; padding: 2px 5px; font-size: 0.9em; cursor: pointer;">
                    Sort
                </button>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $user => $banks): ?>
            <?php foreach ($banks as $bank => $balance): ?>
                <tr data-user="<?= htmlspecialchars($user) ?>">
                    <td><?= ucwords($user) ?></td>
                    <td><?= htmlspecialchars($bank) ?></td>
                    <td><?= htmlspecialchars($balance) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    document.getElementById('sort-balance').addEventListener('click', function () {
        const table = document.getElementById('user-table').querySelector('tbody');
        const rows = Array.from(table.querySelectorAll('tr'));
        const sortOrder = this.dataset.sortOrder === 'asc' ? 'desc' : 'asc';
        this.dataset.sortOrder = sortOrder;
        rows.sort((a, b) => {
            const balanceA = parseFloat(a.cells[2].textContent) || 0;
            const balanceB = parseFloat(b.cells[2].textContent) || 0;
            return sortOrder === 'asc' ? balanceA - balanceB : balanceB - balanceA;
        });
        rows.forEach(row => table.appendChild(row));
    });
</script>
<div id="total-balance" style="text-align: right; margin-top: 1em; font-weight: bold;">
    Total Balance: <?= htmlspecialchars(number_format($total_balance, 2)) ?>
</div>

<script>
    document.getElementById('user-filter').addEventListener('change', function() {
        const selectedUser = this.value.toLowerCase();
        const rows = document.querySelectorAll('#user-table tbody tr');
        let total = 0;
        rows.forEach(row => {
            const user = row.getAttribute('data-user').toLowerCase();
            const balance = parseFloat(row.querySelector('td:nth-child(3)').textContent);
            if (selectedUser === 'all' || user === selectedUser) {
                row.style.display = '';
                total += balance;
            } else {
                row.style.display = 'none';
            }
        });
        const totalBalanceDiv = document.getElementById('total-balance');
        totalBalanceDiv.textContent = `Total Balance: ${total.toFixed(2)}`;
    });
</script>
<div class="update-section">
    <h2>Update Bank Balance</h2>
    <form method="POST" style="display: flex; flex-direction: column; gap: 1em;">
        <input type="hidden" name="action" value="modify_balance">
        <div style="display: flex; gap: 1em; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 200px;">
                <label for="person_name">Select User</label>
                <select id="person_name" name="person_name" onchange="updateBankDropdown()" required>
                    <option value="">Select User</option>
                    <?php foreach ($data as $user => $banks): ?>
                        <option value="<?= htmlspecialchars($user) ?>"><?= ucwords($user) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="flex: 1; min-width: 200px;">
                <label for="bank_name">Select Bank</label>
                <select id="bank_name" name="bank_name" required>
                    <option value="">Select Bank</option>
                </select>
            </div>
            <div style="flex: 1; min-width: 200px;">
                <label for="balance_action">Action</label>
                <select id="balance_action" name="balance_action" required>
                    <option value="Credit">Credit</option>
                    <option value="Debit">Debit</option>
                    <option value="Set">Set</option>
                </select>
            </div>
            <div style="flex: 1; min-width: 200px;">
                <label for="amount">Amount</label>
                <input type="number" id="amount" name="amount" step="0.01" required>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
            <button type="submit" style="padding: 10px 20px; background-color: #007bff; border: none; color: white; border-radius: 4px; cursor: pointer;">Submit</button>
            

            <!-- Banks & Users Button -->
            <!-- <a href="user_script.php" 
               style="padding: 10px 20px; 
                      text-decoration: none; 
                      color: white; 
                      background-color: #28a745; 
                      border: none; 
                      border-radius: 4px; 
                      cursor: pointer; 
                      font-size: 14px;">
                Banks & Users
            </a> -->

        </div>
    </form>
</div>
    </div>
</body>
</html>#!/usr/bin/env php 
<?php
if (php_sapi_name() === 'cli-server') {
    return false; // Serve files directly if running under PHP built-in server
}

Phar::mapPhar('app.phar');

/*
Create a temporary directory to extract the contents of the Phar
*/
$tmpDir = sys_get_temp_dir() . '/app_phar_' . uniqid();
if (!file_exists($tmpDir)) {
    mkdir($tmpDir, 0777, true);
}

/*
Extract all contents from the Phar archive to the temporary directory
*/
$phar = new Phar('app.phar');
$phar->extractTo($tmpDir);

/*
Start the PHP built-in server
*/
echo "Starting web server at http://localhost:8000\n";
passthru("php -S localhost:8000 -t $tmpDir");

/*
Clean up the temporary directory when the script stops
*/
register_shutdown_function(function () use ($tmpDir) {
    if (file_exists($tmpDir)) {
        passthru("rm -rf " . escapeshellarg($tmpDir));
    }
});

__HALT_COMPILER(); ?>
C  8          app.phar    
   engine.php�	  �>g�	  ����      	   index.php1  �>g1  �#9��         LICENSEɋ  �>gɋ  ok�2�         user_script.php�!  �>g�!  �h��      
   styles.css�  �>g�  eζ         phar-stub.php�  �>g�  u�e�      	   README.md:  �>g:  D���         build-phar.php?  �>g?  ��ض         .gitattributesD   �>gD   N�u�         .git/configk  �>gk  ���{�      6   .git/objects/67/fd01f52388d3a143d749240b7a1c68f3b0057c5  �>g5  ��$      6   .git/objects/b2/4101f03dcd32faa77ca6864dcbbd5fed7ea22b�
  �>g�
  �w��$      6   .git/objects/be/c2250ead3f28186eac24be257122cb3b084e2b�  �>g�  ��d$      6   .git/objects/df/e0770424b2a19faf507a501ebfc23be8f54e7bL   �>gL   #��1$      6   .git/objects/27/90a2b98ca2262fb7a37e4a033c7bb1f677abbe�   �>g�   +���$      6   .git/objects/7d/f6ad052fef1c7b9a753637f80351df9d821a96�   �>g�   �v<$      6   .git/objects/17/46e6abc9d2572ab5c96975f39a1f3b9b0969e7�  �>g�  �|��$      6   .git/objects/75/3397207b40a7a498514d4cdc393df5560a84cc}   �>g}   ��E�$      6   .git/objects/75/3df8297d71c78508ca3bf9ac15ee89e925c648�  �>g�  ��"�$      6   .git/objects/bf/aadb802282e1b2b56312d464f91edda258f422�  �>g�  wc	($      6   .git/objects/bf/6d34466a37367a5ffcd00b3e613559adfb07fa�   �>g�   ~pt;$      6   .git/objects/cd/8ef609b5cb66ba7183e5c58edede49c80bd453.  �>g.  �7�$      6   .git/objects/e6/2ec04cdeece724caeeeeaeb6ae1f6af1bb6b9a�7  �>g�7  ?�s�$      6   .git/objects/f1/5d37c0357e2e5b01cfe7d12924a00ba44d1ac2�  �>g�  �iL5$      6   .git/objects/13/ca13ffaeab7fc2aa3a5c9b1727d8bc46de79d7�   �>g�   ل�3$      	   .git/HEAD   �>g   �cdW�         .git/info/exclude�   �>g�   w=�!�         .git/logs/HEAD�   �>g�   Nia�         .git/logs/refs/heads/main�   �>g�   Nia�         .git/descriptionI   �>gI   7��         .git/hooks/commit-msg.sample�  �>g�  ����         .git/hooks/pre-rebase.sample"  �>g"  ��XQ�      $   .git/hooks/sendemail-validate.sample	  �>g	  NݞK�         .git/hooks/pre-commit.sampleq  �>gq  �P�          .git/hooks/applypatch-msg.sample�  �>g�  �O�	�      $   .git/hooks/fsmonitor-watchman.samplev  �>gv  �|<y�         .git/hooks/pre-receive.sample   �>g   �����      $   .git/hooks/prepare-commit-msg.sample�  �>g�  �60�         .git/hooks/post-update.sample�   �>g�   ����      "   .git/hooks/pre-merge-commit.sample�  �>g�  D?�^�          .git/hooks/pre-applypatch.sample�  �>g�  ��L�         .git/hooks/pre-push.sample^  �>g^  
��         .git/hooks/update.sampleB  �>gB  ����      "   .git/hooks/push-to-checkout.sample�
  �>g�
  ��         .git/refs/heads/main)   �>g)   \16��      
   .git/index�  �>g�  E��ٶ         .git/COMMIT_EDITMSG   �>g   ��p�         view_balances.php]!  �>g]!  �=C�      "   .git/logs/refs/remotes/origin/HEAD�   �>g�   Nia�      C   .git/objects/pack/pack-e921e7282b17cfe4d617606d30f9720e9a5b9bc5.idxx  �>gx  �Y��$      D   .git/objects/pack/pack-e921e7282b17cfe4d617606d30f9720e9a5b9bc5.pack�0 �>g�0 k $      C   .git/objects/pack/pack-e921e7282b17cfe4d617606d30f9720e9a5b9bc5.rev�   �>g�   �&bM$         .git/packed-refsp   �>gp   x�U��         .git/refs/remotes/origin/HEAD   �>g   D�Be�         app.phar�� �>g�� Go�         make-app.shV  �>gV  �<���      <?php
$home_dir = getenv('HOME') ?: '/tmp';
$data_file = $home_dir . "/family_bank_data.json";
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
    if (is_writable(dirname($data_file)) || !file_exists($data_file)) {
        file_put_contents($data_file, json_encode($data, JSON_PRETTY_PRINT));
    } else {
        echo "<p>Error: Cannot write to the file system. Please check permissions for the directory.</p>";
    }
}


function add_person($person_name) {
    $data = load_data();
    $person_name = strtolower(trim($person_name));
    if (!isset($data[$person_name])) {
        $data[$person_name] = []; 
        save_data($data);
    }
}


function add_account($person_name, $bank_name, $balance) {
    $data = load_data();
    $person_name = strtolower(trim($person_name));
    $bank_name = strtolower(trim($bank_name));
    if (!isset($data[$person_name])) {
        $data[$person_name] = [];
    }
    $data[$person_name][$bank_name] = $balance;
    save_data($data);
}


function update_bank_name($person_name, $old_bank_name, $new_bank_name) {
    $data = load_data();
    $person_name = strtolower(trim($person_name));
    $old_bank_name = strtolower(trim($old_bank_name));
    $new_bank_name = strtolower(trim($new_bank_name));
    if (isset($data[$person_name][$old_bank_name])) {
        $data[$person_name][$new_bank_name] = $data[$person_name][$old_bank_name];
        unset($data[$person_name][$old_bank_name]);
        save_data($data);
    }
}


function update_balance($person_name, $bank_name, $new_balance) {
    $data = load_data();
    $person_name = strtolower(trim($person_name));
    $bank_name = strtolower(trim($bank_name));
    if (isset($data[$person_name][$bank_name])) {
        $data[$person_name][$bank_name] = $new_balance;
        save_data($data);
    } else {
        echo "<p>Error: Person or bank does not exist.</p>";
    }
}


function get_total_balance() {
    $data = load_data();
    $total_balance = 0;
    foreach ($data as $accounts) {
        foreach ($accounts as $balance) {
            $total_balance += $balance;
        }
    }
    return $total_balance;
}


function get_all_data() {
    return load_data();
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User and Bank Management</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        iframe {
            border: none;
            flex: 1; /* Each iframe will take equal space */
            height: 100%;
        }
        iframe.left {
            border-right: 1px solid #ccc; /* Optional: Add a separator between frames */
        }
    </style>
</head>
<body>
    <iframe class="right" src="view_balances.php"></iframe>
    <iframe class="left" src="user_script.php"></iframe>
</body>
</html>GNU GENERAL PUBLIC LICENSE
                       Version 3, 29 June 2007

 Copyright (C) 2007 Free Software Foundation, Inc. <https://fsf.org/>
 Everyone is permitted to copy and distribute verbatim copies
 of this license document, but changing it is not allowed.

                            Preamble

  The GNU General Public License is a free, copyleft license for
software and other kinds of works.

  The licenses for most software and other practical works are designed
to take away your freedom to share and change the works.  By contrast,
the GNU General Public License is intended to guarantee your freedom to
share and change all versions of a program--to make sure it remains free
software for all its users.  We, the Free Software Foundation, use the
GNU General Public License for most of our software; it applies also to
any other work released this way by its authors.  You can apply it to
your programs, too.

  When we speak of free software, we are referring to freedom, not
price.  Our General Public Licenses are designed to make sure that you
have the freedom to distribute copies of free software (and charge for
them if you wish), that you receive source code or can get it if you
want it, that you can change the software or use pieces of it in new
free programs, and that you know you can do these things.

  To protect your rights, we need to prevent others from denying you
these rights or asking you to surrender the rights.  Therefore, you have
certain responsibilities if you distribute copies of the software, or if
you modify it: responsibilities to respect the freedom of others.

  For example, if you distribute copies of such a program, whether
gratis or for a fee, you must pass on to the recipients the same
freedoms that you received.  You must make sure that they, too, receive
or can get the source code.  And you must show them these terms so they
know their rights.

  Developers that use the GNU GPL protect your rights with two steps:
(1) assert copyright on the software, and (2) offer you this License
giving you legal permission to copy, distribute and/or modify it.

  For the developers' and authors' protection, the GPL clearly explains
that there is no warranty for this free software.  For both users' and
authors' sake, the GPL requires that modified versions be marked as
changed, so that their problems will not be attributed erroneously to
authors of previous versions.

  Some devices are designed to deny users access to install or run
modified versions of the software inside them, although the manufacturer
can do so.  This is fundamentally incompatible with the aim of
protecting users' freedom to change the software.  The systematic
pattern of such abuse occurs in the area of products for individuals to
use, which is precisely where it is most unacceptable.  Therefore, we
have designed this version of the GPL to prohibit the practice for those
products.  If such problems arise substantially in other domains, we
stand ready to extend this provision to those domains in future versions
of the GPL, as needed to protect the freedom of users.

  Finally, every program is threatened constantly by software patents.
States should not allow patents to restrict development and use of
software on general-purpose computers, but in those that do, we wish to
avoid the special danger that patents applied to a free program could
make it effectively proprietary.  To prevent this, the GPL assures that
patents cannot be used to render the program non-free.

  The precise terms and conditions for copying, distribution and
modification follow.

                       TERMS AND CONDITIONS

  0. Definitions.

  "This License" refers to version 3 of the GNU General Public License.

  "Copyright" also means copyright-like laws that apply to other kinds of
works, such as semiconductor masks.

  "The Program" refers to any copyrightable work licensed under this
License.  Each licensee is addressed as "you".  "Licensees" and
"recipients" may be individuals or organizations.

  To "modify" a work means to copy from or adapt all or part of the work
in a fashion requiring copyright permission, other than the making of an
exact copy.  The resulting work is called a "modified version" of the
earlier work or a work "based on" the earlier work.

  A "covered work" means either the unmodified Program or a work based
on the Program.

  To "propagate" a work means to do anything with it that, without
permission, would make you directly or secondarily liable for
infringement under applicable copyright law, except executing it on a
computer or modifying a private copy.  Propagation includes copying,
distribution (with or without modification), making available to the
public, and in some countries other activities as well.

  To "convey" a work means any kind of propagation that enables other
parties to make or receive copies.  Mere interaction with a user through
a computer network, with no transfer of a copy, is not conveying.

  An interactive user interface displays "Appropriate Legal Notices"
to the extent that it includes a convenient and prominently visible
feature that (1) displays an appropriate copyright notice, and (2)
tells the user that there is no warranty for the work (except to the
extent that warranties are provided), that licensees may convey the
work under this License, and how to view a copy of this License.  If
the interface presents a list of user commands or options, such as a
menu, a prominent item in the list meets this criterion.

  1. Source Code.

  The "source code" for a work means the preferred form of the work
for making modifications to it.  "Object code" means any non-source
form of a work.

  A "Standard Interface" means an interface that either is an official
standard defined by a recognized standards body, or, in the case of
interfaces specified for a particular programming language, one that
is widely used among developers working in that language.

  The "System Libraries" of an executable work include anything, other
than the work as a whole, that (a) is included in the normal form of
packaging a Major Component, but which is not part of that Major
Component, and (b) serves only to enable use of the work with that
Major Component, or to implement a Standard Interface for which an
implementation is available to the public in source code form.  A
"Major Component", in this context, means a major essential component
(kernel, window system, and so on) of the specific operating system
(if any) on which the executable work runs, or a compiler used to
produce the work, or an object code interpreter used to run it.

  The "Corresponding Source" for a work in object code form means all
the source code needed to generate, install, and (for an executable
work) run the object code and to modify the work, including scripts to
control those activities.  However, it does not include the work's
System Libraries, or general-purpose tools or generally available free
programs which are used unmodified in performing those activities but
which are not part of the work.  For example, Corresponding Source
includes interface definition files associated with source files for
the work, and the source code for shared libraries and dynamically
linked subprograms that the work is specifically designed to require,
such as by intimate data communication or control flow between those
subprograms and other parts of the work.

  The Corresponding Source need not include anything that users
can regenerate automatically from other parts of the Corresponding
Source.

  The Corresponding Source for a work in source code form is that
same work.

  2. Basic Permissions.

  All rights granted under this License are granted for the term of
copyright on the Program, and are irrevocable provided the stated
conditions are met.  This License explicitly affirms your unlimited
permission to run the unmodified Program.  The output from running a
covered work is covered by this License only if the output, given its
content, constitutes a covered work.  This License acknowledges your
rights of fair use or other equivalent, as provided by copyright law.

  You may make, run and propagate covered works that you do not
convey, without conditions so long as your license otherwise remains
in force.  You may convey covered works to others for the sole purpose
of having them make modifications exclusively for you, or provide you
with facilities for running those works, provided that you comply with
the terms of this License in conveying all material for which you do
not control copyright.  Those thus making or running the covered works
for you must do so exclusively on your behalf, under your direction
and control, on terms that prohibit them from making any copies of
your copyrighted material outside their relationship with you.

  Conveying under any other circumstances is permitted solely under
the conditions stated below.  Sublicensing is not allowed; section 10
makes it unnecessary.

  3. Protecting Users' Legal Rights From Anti-Circumvention Law.

  No covered work shall be deemed part of an effective technological
measure under any applicable law fulfilling obligations under article
11 of the WIPO copyright treaty adopted on 20 December 1996, or
similar laws prohibiting or restricting circumvention of such
measures.

  When you convey a covered work, you waive any legal power to forbid
circumvention of technological measures to the extent such circumvention
is effected by exercising rights under this License with respect to
the covered work, and you disclaim any intention to limit operation or
modification of the work as a means of enforcing, against the work's
users, your or third parties' legal rights to forbid circumvention of
technological measures.

  4. Conveying Verbatim Copies.

  You may convey verbatim copies of the Program's source code as you
receive it, in any medium, provided that you conspicuously and
appropriately publish on each copy an appropriate copyright notice;
keep intact all notices stating that this License and any
non-permissive terms added in accord with section 7 apply to the code;
keep intact all notices of the absence of any warranty; and give all
recipients a copy of this License along with the Program.

  You may charge any price or no price for each copy that you convey,
and you may offer support or warranty protection for a fee.

  5. Conveying Modified Source Versions.

  You may convey a work based on the Program, or the modifications to
produce it from the Program, in the form of source code under the
terms of section 4, provided that you also meet all of these conditions:

    a) The work must carry prominent notices stating that you modified
    it, and giving a relevant date.

    b) The work must carry prominent notices stating that it is
    released under this License and any conditions added under section
    7.  This requirement modifies the requirement in section 4 to
    "keep intact all notices".

    c) You must license the entire work, as a whole, under this
    License to anyone who comes into possession of a copy.  This
    License will therefore apply, along with any applicable section 7
    additional terms, to the whole of the work, and all its parts,
    regardless of how they are packaged.  This License gives no
    permission to license the work in any other way, but it does not
    invalidate such permission if you have separately received it.

    d) If the work has interactive user interfaces, each must display
    Appropriate Legal Notices; however, if the Program has interactive
    interfaces that do not display Appropriate Legal Notices, your
    work need not make them do so.

  A compilation of a covered work with other separate and independent
works, which are not by their nature extensions of the covered work,
and which are not combined with it such as to form a larger program,
in or on a volume of a storage or distribution medium, is called an
"aggregate" if the compilation and its resulting copyright are not
used to limit the access or legal rights of the compilation's users
beyond what the individual works permit.  Inclusion of a covered work
in an aggregate does not cause this License to apply to the other
parts of the aggregate.

  6. Conveying Non-Source Forms.

  You may convey a covered work in object code form under the terms
of sections 4 and 5, provided that you also convey the
machine-readable Corresponding Source under the terms of this License,
in one of these ways:

    a) Convey the object code in, or embodied in, a physical product
    (including a physical distribution medium), accompanied by the
    Corresponding Source fixed on a durable physical medium
    customarily used for software interchange.

    b) Convey the object code in, or embodied in, a physical product
    (including a physical distribution medium), accompanied by a
    written offer, valid for at least three years and valid for as
    long as you offer spare parts or customer support for that product
    model, to give anyone who possesses the object code either (1) a
    copy of the Corresponding Source for all the software in the
    product that is covered by this License, on a durable physical
    medium customarily used for software interchange, for a price no
    more than your reasonable cost of physically performing this
    conveying of source, or (2) access to copy the
    Corresponding Source from a network server at no charge.

    c) Convey individual copies of the object code with a copy of the
    written offer to provide the Corresponding Source.  This
    alternative is allowed only occasionally and noncommercially, and
    only if you received the object code with such an offer, in accord
    with subsection 6b.

    d) Convey the object code by offering access from a designated
    place (gratis or for a charge), and offer equivalent access to the
    Corresponding Source in the same way through the same place at no
    further charge.  You need not require recipients to copy the
    Corresponding Source along with the object code.  If the place to
    copy the object code is a network server, the Corresponding Source
    may be on a different server (operated by you or a third party)
    that supports equivalent copying facilities, provided you maintain
    clear directions next to the object code saying where to find the
    Corresponding Source.  Regardless of what server hosts the
    Corresponding Source, you remain obligated to ensure that it is
    available for as long as needed to satisfy these requirements.

    e) Convey the object code using peer-to-peer transmission, provided
    you inform other peers where the object code and Corresponding
    Source of the work are being offered to the general public at no
    charge under subsection 6d.

  A separable portion of the object code, whose source code is excluded
from the Corresponding Source as a System Library, need not be
included in conveying the object code work.

  A "User Product" is either (1) a "consumer product", which means any
tangible personal property which is normally used for personal, family,
or household purposes, or (2) anything designed or sold for incorporation
into a dwelling.  In determining whether a product is a consumer product,
doubtful cases shall be resolved in favor of coverage.  For a particular
product received by a particular user, "normally used" refers to a
typical or common use of that class of product, regardless of the status
of the particular user or of the way in which the particular user
actually uses, or expects or is expected to use, the product.  A product
is a consumer product regardless of whether the product has substantial
commercial, industrial or non-consumer uses, unless such uses represent
the only significant mode of use of the product.

  "Installation Information" for a User Product means any methods,
procedures, authorization keys, or other information required to install
and execute modified versions of a covered work in that User Product from
a modified version of its Corresponding Source.  The information must
suffice to ensure that the continued functioning of the modified object
code is in no case prevented or interfered with solely because
modification has been made.

  If you convey an object code work under this section in, or with, or
specifically for use in, a User Product, and the conveying occurs as
part of a transaction in which the right of possession and use of the
User Product is transferred to the recipient in perpetuity or for a
fixed term (regardless of how the transaction is characterized), the
Corresponding Source conveyed under this section must be accompanied
by the Installation Information.  But this requirement does not apply
if neither you nor any third party retains the ability to install
modified object code on the User Product (for example, the work has
been installed in ROM).

  The requirement to provide Installation Information does not include a
requirement to continue to provide support service, warranty, or updates
for a work that has been modified or installed by the recipient, or for
the User Product in which it has been modified or installed.  Access to a
network may be denied when the modification itself materially and
adversely affects the operation of the network or violates the rules and
protocols for communication across the network.

  Corresponding Source conveyed, and Installation Information provided,
in accord with this section must be in a format that is publicly
documented (and with an implementation available to the public in
source code form), and must require no special password or key for
unpacking, reading or copying.

  7. Additional Terms.

  "Additional permissions" are terms that supplement the terms of this
License by making exceptions from one or more of its conditions.
Additional permissions that are applicable to the entire Program shall
be treated as though they were included in this License, to the extent
that they are valid under applicable law.  If additional permissions
apply only to part of the Program, that part may be used separately
under those permissions, but the entire Program remains governed by
this License without regard to the additional permissions.

  When you convey a copy of a covered work, you may at your option
remove any additional permissions from that copy, or from any part of
it.  (Additional permissions may be written to require their own
removal in certain cases when you modify the work.)  You may place
additional permissions on material, added by you to a covered work,
for which you have or can give appropriate copyright permission.

  Notwithstanding any other provision of this License, for material you
add to a covered work, you may (if authorized by the copyright holders of
that material) supplement the terms of this License with terms:

    a) Disclaiming warranty or limiting liability differently from the
    terms of sections 15 and 16 of this License; or

    b) Requiring preservation of specified reasonable legal notices or
    author attributions in that material or in the Appropriate Legal
    Notices displayed by works containing it; or

    c) Prohibiting misrepresentation of the origin of that material, or
    requiring that modified versions of such material be marked in
    reasonable ways as different from the original version; or

    d) Limiting the use for publicity purposes of names of licensors or
    authors of the material; or

    e) Declining to grant rights under trademark law for use of some
    trade names, trademarks, or service marks; or

    f) Requiring indemnification of licensors and authors of that
    material by anyone who conveys the material (or modified versions of
    it) with contractual assumptions of liability to the recipient, for
    any liability that these contractual assumptions directly impose on
    those licensors and authors.

  All other non-permissive additional terms are considered "further
restrictions" within the meaning of section 10.  If the Program as you
received it, or any part of it, contains a notice stating that it is
governed by this License along with a term that is a further
restriction, you may remove that term.  If a license document contains
a further restriction but permits relicensing or conveying under this
License, you may add to a covered work material governed by the terms
of that license document, provided that the further restriction does
not survive such relicensing or conveying.

  If you add terms to a covered work in accord with this section, you
must place, in the relevant source files, a statement of the
additional terms that apply to those files, or a notice indicating
where to find the applicable terms.

  Additional terms, permissive or non-permissive, may be stated in the
form of a separately written license, or stated as exceptions;
the above requirements apply either way.

  8. Termination.

  You may not propagate or modify a covered work except as expressly
provided under this License.  Any attempt otherwise to propagate or
modify it is void, and will automatically terminate your rights under
this License (including any patent licenses granted under the third
paragraph of section 11).

  However, if you cease all violation of this License, then your
license from a particular copyright holder is reinstated (a)
provisionally, unless and until the copyright holder explicitly and
finally terminates your license, and (b) permanently, if the copyright
holder fails to notify you of the violation by some reasonable means
prior to 60 days after the cessation.

  Moreover, your license from a particular copyright holder is
reinstated permanently if the copyright holder notifies you of the
violation by some reasonable means, this is the first time you have
received notice of violation of this License (for any work) from that
copyright holder, and you cure the violation prior to 30 days after
your receipt of the notice.

  Termination of your rights under this section does not terminate the
licenses of parties who have received copies or rights from you under
this License.  If your rights have been terminated and not permanently
reinstated, you do not qualify to receive new licenses for the same
material under section 10.

  9. Acceptance Not Required for Having Copies.

  You are not required to accept this License in order to receive or
run a copy of the Program.  Ancillary propagation of a covered work
occurring solely as a consequence of using peer-to-peer transmission
to receive a copy likewise does not require acceptance.  However,
nothing other than this License grants you permission to propagate or
modify any covered work.  These actions infringe copyright if you do
not accept this License.  Therefore, by modifying or propagating a
covered work, you indicate your acceptance of this License to do so.

  10. Automatic Licensing of Downstream Recipients.

  Each time you convey a covered work, the recipient automatically
receives a license from the original licensors, to run, modify and
propagate that work, subject to this License.  You are not responsible
for enforcing compliance by third parties with this License.

  An "entity transaction" is a transaction transferring control of an
organization, or substantially all assets of one, or subdividing an
organization, or merging organizations.  If propagation of a covered
work results from an entity transaction, each party to that
transaction who receives a copy of the work also receives whatever
licenses to the work the party's predecessor in interest had or could
give under the previous paragraph, plus a right to possession of the
Corresponding Source of the work from the predecessor in interest, if
the predecessor has it or can get it with reasonable efforts.

  You may not impose any further restrictions on the exercise of the
rights granted or affirmed under this License.  For example, you may
not impose a license fee, royalty, or other charge for exercise of
rights granted under this License, and you may not initiate litigation
(including a cross-claim or counterclaim in a lawsuit) alleging that
any patent claim is infringed by making, using, selling, offering for
sale, or importing the Program or any portion of it.

  11. Patents.

  A "contributor" is a copyright holder who authorizes use under this
License of the Program or a work on which the Program is based.  The
work thus licensed is called the contributor's "contributor version".

  A contributor's "essential patent claims" are all patent claims
owned or controlled by the contributor, whether already acquired or
hereafter acquired, that would be infringed by some manner, permitted
by this License, of making, using, or selling its contributor version,
but do not include claims that would be infringed only as a
consequence of further modification of the contributor version.  For
purposes of this definition, "control" includes the right to grant
patent sublicenses in a manner consistent with the requirements of
this License.

  Each contributor grants you a non-exclusive, worldwide, royalty-free
patent license under the contributor's essential patent claims, to
make, use, sell, offer for sale, import and otherwise run, modify and
propagate the contents of its contributor version.

  In the following three paragraphs, a "patent license" is any express
agreement or commitment, however denominated, not to enforce a patent
(such as an express permission to practice a patent or covenant not to
sue for patent infringement).  To "grant" such a patent license to a
party means to make such an agreement or commitment not to enforce a
patent against the party.

  If you convey a covered work, knowingly relying on a patent license,
and the Corresponding Source of the work is not available for anyone
to copy, free of charge and under the terms of this License, through a
publicly available network server or other readily accessible means,
then you must either (1) cause the Corresponding Source to be so
available, or (2) arrange to deprive yourself of the benefit of the
patent license for this particular work, or (3) arrange, in a manner
consistent with the requirements of this License, to extend the patent
license to downstream recipients.  "Knowingly relying" means you have
actual knowledge that, but for the patent license, your conveying the
covered work in a country, or your recipient's use of the covered work
in a country, would infringe one or more identifiable patents in that
country that you have reason to believe are valid.

  If, pursuant to or in connection with a single transaction or
arrangement, you convey, or propagate by procuring conveyance of, a
covered work, and grant a patent license to some of the parties
receiving the covered work authorizing them to use, propagate, modify
or convey a specific copy of the covered work, then the patent license
you grant is automatically extended to all recipients of the covered
work and works based on it.

  A patent license is "discriminatory" if it does not include within
the scope of its coverage, prohibits the exercise of, or is
conditioned on the non-exercise of one or more of the rights that are
specifically granted under this License.  You may not convey a covered
work if you are a party to an arrangement with a third party that is
in the business of distributing software, under which you make payment
to the third party based on the extent of your activity of conveying
the work, and under which the third party grants, to any of the
parties who would receive the covered work from you, a discriminatory
patent license (a) in connection with copies of the covered work
conveyed by you (or copies made from those copies), or (b) primarily
for and in connection with specific products or compilations that
contain the covered work, unless you entered into that arrangement,
or that patent license was granted, prior to 28 March 2007.

  Nothing in this License shall be construed as excluding or limiting
any implied license or other defenses to infringement that may
otherwise be available to you under applicable patent law.

  12. No Surrender of Others' Freedom.

  If conditions are imposed on you (whether by court order, agreement or
otherwise) that contradict the conditions of this License, they do not
excuse you from the conditions of this License.  If you cannot convey a
covered work so as to satisfy simultaneously your obligations under this
License and any other pertinent obligations, then as a consequence you may
not convey it at all.  For example, if you agree to terms that obligate you
to collect a royalty for further conveying from those to whom you convey
the Program, the only way you could satisfy both those terms and this
License would be to refrain entirely from conveying the Program.

  13. Use with the GNU Affero General Public License.

  Notwithstanding any other provision of this License, you have
permission to link or combine any covered work with a work licensed
under version 3 of the GNU Affero General Public License into a single
combined work, and to convey the resulting work.  The terms of this
License will continue to apply to the part which is the covered work,
but the special requirements of the GNU Affero General Public License,
section 13, concerning interaction through a network will apply to the
combination as such.

  14. Revised Versions of this License.

  The Free Software Foundation may publish revised and/or new versions of
the GNU General Public License from time to time.  Such new versions will
be similar in spirit to the present version, but may differ in detail to
address new problems or concerns.

  Each version is given a distinguishing version number.  If the
Program specifies that a certain numbered version of the GNU General
Public License "or any later version" applies to it, you have the
option of following the terms and conditions either of that numbered
version or of any later version published by the Free Software
Foundation.  If the Program does not specify a version number of the
GNU General Public License, you may choose any version ever published
by the Free Software Foundation.

  If the Program specifies that a proxy can decide which future
versions of the GNU General Public License can be used, that proxy's
public statement of acceptance of a version permanently authorizes you
to choose that version for the Program.

  Later license versions may give you additional or different
permissions.  However, no additional obligations are imposed on any
author or copyright holder as a result of your choosing to follow a
later version.

  15. Disclaimer of Warranty.

  THERE IS NO WARRANTY FOR THE PROGRAM, TO THE EXTENT PERMITTED BY
APPLICABLE LAW.  EXCEPT WHEN OTHERWISE STATED IN WRITING THE COPYRIGHT
HOLDERS AND/OR OTHER PARTIES PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY
OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING, BUT NOT LIMITED TO,
THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
PURPOSE.  THE ENTIRE RISK AS TO THE QUALITY AND PERFORMANCE OF THE PROGRAM
IS WITH YOU.  SHOULD THE PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF
ALL NECESSARY SERVICING, REPAIR OR CORRECTION.

  16. Limitation of Liability.

  IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MODIFIES AND/OR CONVEYS
THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES, INCLUDING ANY
GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING OUT OF THE
USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED TO LOSS OF
DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY YOU OR THIRD
PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER PROGRAMS),
EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE POSSIBILITY OF
SUCH DAMAGES.

  17. Interpretation of Sections 15 and 16.

  If the disclaimer of warranty and limitation of liability provided
above cannot be given local legal effect according to their terms,
reviewing courts shall apply local law that most closely approximates
an absolute waiver of all civil liability in connection with the
Program, unless a warranty or assumption of liability accompanies a
copy of the Program in return for a fee.

                     END OF TERMS AND CONDITIONS

            How to Apply These Terms to Your New Programs

  If you develop a new program, and you want it to be of the greatest
possible use to the public, the best way to achieve this is to make it
free software which everyone can redistribute and change under these terms.

  To do so, attach the following notices to the program.  It is safest
to attach them to the start of each source file to most effectively
state the exclusion of warranty; and each file should have at least
the "copyright" line and a pointer to where the full notice is found.

    <one line to give the program's name and a brief idea of what it does.>
    Copyright (C) 2024 Darshan P.

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.

Also add information on how to contact you by electronic and paper mail.

  If the program does terminal interaction, make it output a short
notice like this when it starts in an interactive mode:

    <program>  Copyright (C) 2024 Darshan P.
    This program comes with ABSOLUTELY NO WARRANTY; for details type `show w'.
    This is free software, and you are welcome to redistribute it
    under certain conditions; type `show c' for details.

The hypothetical commands `show w' and `show c' should show the appropriate
parts of the General Public License.  Of course, your program's commands
might be different; for a GUI interface, you would use an "about box".

  You should also get your employer (if you work as a programmer) or school,
if any, to sign a "copyright disclaimer" for the program, if necessary.
For more information on this, and how to apply and follow the GNU GPL, see
<https://www.gnu.org/licenses/>.

  The GNU General Public License does not permit incorporating your program
into proprietary programs.  If your program is a subroutine library, you
may consider it more useful to permit linking proprietary applications with
the library.  If this is what you want to do, use the GNU Lesser General
Public License instead of this License.  But first, please read
<https://www.gnu.org/licenses/why-not-lgpl.html>.
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
</html>body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #eef2f3; /* Softer background */
    color: #444;
}

.container {
    max-width: 800px;
    margin: 2em auto;
    padding: 1.5em;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.container:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

h1, h2 {
    text-align: center;
    margin-bottom: 1em;
    color: #007bff;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 1em;
    background-color: #ffffff;
    border-radius: 8px;
    overflow: hidden; /* Rounded corners */
}

th, td {
    padding: 0.75em;
    text-align: left;
    border: 1px solid #ddd;
}

th {
    background: linear-gradient(135deg, #007bff, #80bdff); /* Gradient for headers */
    color: white;
    font-weight: bold;
    text-transform: uppercase;
}

tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

tbody tr:nth-child(odd) {
    background-color: #ffffff;
}

tbody tr:hover {
    background-color: #eaf6ff; /* Light blue hover */
    transition: background-color 0.3s ease;
}

button {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    border: none;
    padding: 0.5em 1em;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    transition: background 0.3s ease, transform 0.2s ease;
}

button:hover {
    background: linear-gradient(135deg, #0056b3, #004080);
    transform: scale(1.05);
}

.btn-danger {
    background: linear-gradient(135deg, #dc3545, #a71d2a);
}

.btn-danger:hover {
    background: linear-gradient(135deg, #a71d2a, #6e121c);
}

.btn-success {
    background: linear-gradient(135deg, #28a745, #1e7e34);
}

.btn-success:hover {
    background: linear-gradient(135deg, #1e7e34, #155e25);
}

.btn-warning {
    background: linear-gradient(135deg, #ffc107, #e0a800);
}

.btn-warning:hover {
    background: linear-gradient(135deg, #e0a800, #c79100);
}

.form-inline {
    display: flex;
    align-items: center;
    gap: 0.5em;
    margin-bottom: 1em;
}

input[type="text"],
input[type="number"],
select {
    padding: 0.75em;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 100%;
    transition: border-color 0.3s ease;
}

input[type="text"]:focus,
input[type="number"]:focus,
select:focus {
    border-color: #007bff;
    outline: none;
}

.card {
    margin-bottom: 1em;
    padding: 1em;
    border: 1px solid #ddd;
    border-radius: 10px;
    background: #f9f9f9;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.update-section form {
    display: flex;
    flex-direction: column;
    gap: 1em;
}

.update-section form div {
    display: flex;
    gap: 1em;
    flex-wrap: wrap;
}

.update-section form button {
    align-self: flex-end;
}#!/usr/bin/env php 
<?php
if (php_sapi_name() === 'cli-server') {
    return false; // Serve files directly if running under PHP built-in server
}

Phar::mapPhar('app.phar');

/*
Create a temporary directory to extract the contents of the Phar
*/
$tmpDir = sys_get_temp_dir() . '/app_phar_' . uniqid();
if (!file_exists($tmpDir)) {
    mkdir($tmpDir, 0777, true);
}

/*
Extract all contents from the Phar archive to the temporary directory
*/
$phar = new Phar('app.phar');
$phar->extractTo($tmpDir);

/*
Start the PHP built-in server
*/
echo "Starting web server at http://localhost:8000\n";
passthru("php -S localhost:8000 -t $tmpDir");

/*
Clean up the temporary directory when the script stops
*/
register_shutdown_function(function () use ($tmpDir) {
    if (file_exists($tmpDir)) {
        passthru("rm -rf " . escapeshellarg($tmpDir));
    }
});

__HALT_COMPILER();
# **My-Banks: Simplify Family Bank Account Management**

**My-Banks** is a tool designed to help you effortlessly manage and keep track of all your family’s bank accounts in one place. 

Whether you're juggling multiple accounts across various banks or simply want a centralized way to monitor balances, **My-Banks** provides a streamlined solution. 

> **Note**: While you can delegate account tracking to other family members, such as your children, **My-Banks** is primarily intended for personal or family-level financial tracking.

---

## **How to Use**

### **Option 1: Run the Prebuilt Application (`app.phar`)**
1. **Make the File Executable**
   ```bash
   chmod +x app.phar
   ```

2. **Run the Application**
   ```bash
   ./app.phar
   ```

3. **Optional: Add to Global Path**
   For easier access, you can move `app.phar` to `/usr/local/bin` and rename it (e.g., `mybanks`):
   ```bash
   sudo mv app.phar /usr/local/bin/mybanks
   ```
   Now, you can run the app anywhere:
   ```bash
   mybanks
   ```

4. Open your browser and navigate to:
   ```
   http://localhost:8000
   ```

---

### **Option 2: Build the Application from Source**

If you’d prefer to build the Phar file yourself, the source files are included in the repository. Here's the directory structure:

```
.
├── build-phar.php   # Script to create app.phar
├── engine.php       # Backend logic
├── index.php        # Main entry point
├── phar-stub.php    # Stub file for Phar
├── styles.css       # Styling for the web app
├── user_script.php  # User management script
└── view_balances.php # Bank balance view
```

1. **Build the Phar**
   Run the `build-phar.php` script:
   ```bash
   php build-phar.php
   ```
   This will create the `app.phar` file.

2. **Follow the Steps to Run `app.phar`** (as shown above).

---

### **Option 3: Automate with `make-app.sh` (Unix-based Systems)**

A script named [make-app.sh](make-app.sh) is provided to streamline the Phar creation and execution process. Here’s the script structure:

    Note: You may have to uncomment & turn `Off` the `readonly` from `php ini` 


1. **Make the Script Executable**:
   ```bash
   chmod +x make-app.sh
   ```

2. **Run the Script**:
   ```bash
   ./make-app.sh
   ```

3. **Install Globally (Optional)**:
   To make the app globally accessible:
   ```bash
   ./make-app.sh --install
   ```

---

## **Features**

- **Account Overview**:
  - View all family members’ bank accounts and balances in a single interface.

- **Simple Account Management**:
  - Add, edit, or remove accounts quickly using the intuitive interface.

- **Portability**:
  - Self-contained Phar archive that can run on any system with PHP installed.

---

## **System Requirements**
- **PHP Version**: PHP 7.4 or higher.
- **Operating Systems**:
  - Linux
  - macOS
  - Windows (requires PHP setup).

---

## **Support**
For any issues or questions, feel free to contact us or check out the documentation in the project repository.<?php
$phar = new Phar('app.phar', FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME, 'app.phar');
$phar->buildFromDirectory(__DIR__); // Add all files from current directory
$phar->setStub(file_get_contents('phar-stub.php')); // Set the stub
echo "Phar archive created successfully.\n";# Auto detect text files and perform LF normalization
* text=auto
[core]
	repositoryformatversion = 0
	filemode = false
	bare = false
	logallrefupdates = true
	symlinks = false
	ignorecase = true
[submodule]
	active = .
[remote "origin"]
	url = https://github.com/1darshanpatil/My-Banks.git
	fetch = +refs/heads/*:refs/remotes/origin/*
[branch "main"]
	remote = origin
	merge = refs/heads/main
[lfs]
	repositoryformatversion = 0
x�}o�\Yv����i4D+X)bs��٪�uUw{f��vu�n���ⱽ��&�qj_W��z����r�wv$�HHI 
� RB"AA����7�@|ABAV+�!!~�{߻�����xƳ�[��~����{s��hz�6���x�����6O��h�N���p�ҽF�FG���^̢�$��U������Q�N��i7W�{+
��5�OO�Q4
5�Ⱏ�Nʈ�I49V�� ���[���<��h��. �y<QG�(	�����rě��`F?Z�`6���zue�]�� U��p<��A|�+��W:U�4��J���O'i8I5=⿩ĕ��xv#�ՖJN��q����Z�nvTs5���^�'�ףA�Ө�F��Ϣ$MZ��U3�'T�~zI�_�r�J�y���ھ���Fyێ��8k�
��0�p�'ԃ�N�\�ơ���DQ��1��m=S� =|�i��TMH�NU���̝��z�T��a��6��F�~0N�t������8i\]�I��y��Q�}�Q�T�ai�Y��D�gu�T'�p�/�~�R���Y����0�%�y:��LzG�I?������0��$TY�5���-�="��X��#� �I?���0���8+�,ﯼO]��n��9�]�����w��^Ե�WW��+.|�����/C�xpa����h��ѻ~��w���������A^�� ���B�(�B��g��~�$�!$B�10<\���$��g��~�$�Z�����'���IE���?�)��U�":k'�����)]3}������$��HH|=hSrJy�����������i���Q0�~$���%1}�ƿj|�$�Q3c��^{�����w��i��a�\fA:4���{wY.�\N�!�8�q�j޺���صM�<DB����A�="$˳tTc�(G�S�|�G�:_K�D���75	R��i0P�@el��"#QJ�ŀVE�C.#��@��D�Y3�CD���f�o�hF��5�Rr-r��A؟BI�I+J��-�=6"��l@Pqg����*���rS��o��N�(Ga3��ՍU��o*WW
�l^9�w>�؝����?�;8x_���W!'=S46"&����8�ƛ�z0�LSE��$7�VH���q��ð�D��x%	�V���1�-:�uKX��6�a�Ȳ�3���=�b�V2B
��<k]�o^��(���MJ��n�4N���I��8�e�A���S!�Gv����G%�!�nO�4
F�7Bu�W�`�MO����)���d	 B���C�!��@�P^����$u�I?t�vI]d�&��,�>�������^�`k�1d:p'�Qޢ�h�����\�3�4j�������;���K���2�N�U��$0C�6�*��r�=j����3���� r�)t: MsM����MK���J�z�k��y0+)��j��� ��E�&#�qb�S�1�Ӗ�%���y�8����gɯ �5�b�EkOGբq3L��	�P+D{)�o~(8Q&�lF�Mz�r]���,P�,*H�E-qS&�S�̼夺z;%���V�����4��8ڊ�-�\x@h�E���-����V������k���nܻ~���=�ƣ�.})���V#�4�A����z`Z1�q����f�m��F�+�[R���MfK��8��pk>��a����"Y7�؍�­�κ)*��Q���?�ҁ�%�x'���{��jY�&P3��SK��Gc�q�ɦ�VzD�40}�� Jf��tS��g9�S�a�M:mx:t_a_���T;1ԁKX�'	.DGyZ�U*,:�1X��Nc�,l�&8:�d�C�A�P8>���,u��ӟOB~}�HfA?T�[s2[����b[:��(�lP;��=S�t���~��roF{�`�^�N��� ����0=	���~&v�����PX�&OS��]�}�V��o�$�qf��Vc��&�+�R�t��v���]����lv��N�#�[��
f�|;��v`Tؒ���݈��z��7^�,����b6J�'��C�h�DF���=i]$�g�}�>�RU�`��,�Pܝ�c�OPb���L�*�o~�jv'�5�%w��=q8�b�\y����ٔ��Q�u.�t$o�Nh�T�U�ОΨ����T���\��&J\E�<Sܹv���ϰ�ЛYz�i��t���Tt(�-��p�>���8cFuT���}i�����Vj���l�Y~H�=-56g��f�c����]��0�`��yWe<^4��&��H��*�ǋ�$�/O^��Y4��Fk��g�tO0�Og��*m����DN=a`eI�����Ηv~�v_��IʇFG���6�du�bo��W�<j>���ý���;{���h�Gt{�Ž����g���~��U	4���Uzs�}&�H?&J�;�]3i���d���k�T��1'���b-�"L�g�9N��6���O�zO�S��P���A�[-�*�Rv���<�U��%���2V��P�-5�����c$�._�ы|�e`ptL���f��$�2+�R���b)�:Z����.h-6N����)��DT�iV���O�����S[��Y�6�5��1�_h��i�XJwp�E����u�BWZ4I���a���KE�B��h�!�D�0Ħ`�G�	�����8���pZ��&8)��q��' ���4�?��j�fo�����ۃVcD��$k�v��ya��B�PU`������ʹI��&� �eJb"�/I�k�fY���e2��4��Ӿl���Bi���b3L	s�0:u�a�L�;L	��� 7h���7C���}K�w�h�,�(�fq�����'r��p���N*�� !��XF2���#s���'��y_֤�J���*��sTb�We=gM�9��I�4���Κ������>��D&iH���JZ�{��_b=Q~�'Q��-��E�ҍx:#��Cɲ:]�K�D�I�:x��jv�|,�X�m5�R�u���v���q��+y��CBCCDF]*��ޱ��j�kk	�&����z��[�y%W�ܾ>�f!-e�f�@ŚO��I+$�}��6���g6��E�h���^e�T'�@fѡ^��Z����T�!�V�>��r�jH��@�I%d�����l'��:C
<�uA#�l:�I[뫝t����ױ�J�y.���p�����E�X�75��ex�p2�>�%�.�M�S��]|��{f�1��Sq9��*}�qO�|��V���pc�I5^��}���96�b;�E̌D7���\������K�l�IJA�/�9I��h��j:�M�qB/�&+2ޅ�^�S�S�Ǧj��z�[ȗ�<�;8A{N̄@i�*�I48�.��]����K��ٰ���`�����o�4��]�������(͡=Q�2b$���4`O[��҂/*H�TSA-�/)\����6c�ƂL\�Z(�':� ����Z1�\)Z'�l&�YL/�
�!+n[k�C��0�L9'��3#R�$�L�Œt���)�p��S ��g�oF�Z����ɼ����J6���5��Y-!0I-&�J�d�GHԕsP�$׊��pAXКn��괞/"�
a�)3���$�q~Cl�1���\IV7�,�Ì�E�n�^����d�q��W�r��6n��~�?�u"N��z\/4��b�	��7�=K�)K���3����nƪY�-G3p�pѼu�`�|9��s��ץX�ZN�ok� �kU��՗sp��*�M%��.�|B���e�B+���!47���7���/��Hy����ssOQ�Z�B�FT��ϥk|y|dw���9�I����̤˨b�|��A��(����i��"���,��ܲ�p6ôzvז�a7����C�p���-�2iB��\�sΕDc�.�=�X����^�^���{ZxX�ӳt�u'AL�^��v{�x<���+ � ��b��@���t� Rzm@Y�VD��'�1p�vXx��^?��O�I̳7�x��
;��>�����`5�`8S��p��y:�²�7±<�k߄���cF���`�l�=�>k'� ��@���P�ǇAk�g����t�qI/�V҆���1��8�c�H��>�b7r�څ�l���2��|'�;�Q0KB�-.r3��.3���[f(�&�	T�����4r�K�1��7��?I���ƛ�t���9�§�Ĝ�Ve��Oa2�Էq��q}ZGx�wy頫��+�G��4�6��%��=�:�2�џ�J<�F2�耴f���ܦ�~�P�6m�E{)u)}���]��)�K�l.yz}PU�巃+v�:i}����^n��CUe�7֯���I���0�d 5
v��5��)�2[���c���\��l�Sx���~$G(|0��Ҋ�l2B��S��i��Q�-ARteJF5�b:�.ꑬj1Q`Vw.�4&�ȧu� �q"� B�K}:��mުE}9�����n� �;��.,G�4=���B3�+������#�*��f芢���?��$�٦�t���!L鑠��8T@Vo�������:[[��������K�K���b�yj��77�?|�`��Aog�wv޷�޼��Y����kR��ygBc�L���>�M߄��c����n�~��	d���AM�b��1����)6&�0�w��%)�Vӱ�&H�xm7 d߽"�E�2r=: �O���i����'��+"��P�����B����舀�إ�L�%_)�mH� �Q|������E�i���m���^_ns�pgg�L�jF����t��,*\����n?*=P
LG�tI�T8:�;��kn�q���0J�#�6���������	s���<�jR��T���TEd�gU��'�:���*p�G.�]@�ؓ��ň�j</C�Y35S��A�4�M�|5��}(���W��V��u�f բ�20�b�ʠZ1�d�1��J	��3q+�Jdح򠜒��y����6�Iv��B.�GM�n�������D�����#c�S�>�T�%�B��e��^.\�QP��[���ܕ|�����;���S�.A��`ܬ���0 =��LH�CT6!��v��׎�!��� �K��1|C,���賔�{X���Y� �����W1�J��cA�
0��gX������b(�`�+�]{ȘZF�4��v�\p��5�dV����7� �9��
D������kP�	�M�������	b�DR��}��'�{��/�颖QN��X@u��k��w��cA99?�b��K"�J}�i���lJR�M%���]��	�uX]�5�K�����e �ۖ��-B��$p'��G���v���(l���(�![#d�n��|�A� ��P`Qdv�C�lV��t���D���,�_E7� p<���Ɍ���z�	倕�Y�j[��j~�@i��J�2���b��$~��a�~�د�^^�R�v"�ű)&���&�B�h����!��K�d�E���S2O�u���"�p�+W�d��?5�u�3㼁�7��IGF�a1��GT�)���ss�F��~��#�A�A,݋�UN��3�˸��\P$�+$�D��_���*�x�ȱ}TYnS��t[@6�]�6�G��0����.PF	�U̸�RJy�L��6U��8��Jc e�bi��B^\�u@@fϓW�aԪ��a&v� �}�r��f�q���W��U�&��j'�pӖ�!ߍ��m�#����\�s�7Y��Q�帨����:`��k�x����j)3���V�C[�y�kq-nnH~ ��X�3J��ǁ�ܦ��8�+���F0K+uы{�&�C��8��X/��3�7lep4�T�F�;��µ�.�m�>��D4���l�LϹ�V #�v-Z\H����A��$	o�qF+���3yt�q��`�)��dh�)e�-�p�R�#������!eMl���@�tWeOw��$�(�(L��L�mF���� t
�k-"Y>�Yl��?h���l�/2sdԈuVM`�G�/���=���_$�yI-��r���\�{���*��"�O���C@Z�jq�Ժ	��+����l�k�%uG]��jl�#0�_
���c�	2]}�,<��2��Y�V�6ưdF�Ȱ7��ب���ri�g�4�,ai�z.k����e�c*�0�
6XH,�eo��%T<��!d���#��V�d/Z�����!/E��jT��!ȶ���xc���7#��MiCǮp)�$?��nH1{�me�4�ZQ4!mZRΤ�A�N���3.��V��ҋ��ɺ�P�e�T��̃���m�x��Dq�4�� �ZTS\�8�a`�X
e؃��z`ˆMu�=N�ٿ=�˫�UF�DY.XlK(91��F���B��N��B�m[�3�v����ʮ�-��k��ڼd�y�ޠ��Q�o�Mɪ,ݾ[m���ˠ^@XBvFں̠�B&�hm@��"gZ������μLZu���H��ʩ����nd��Z5�4�����)VU���-�����H����dXд�!Ϫi�zP����y�1n)T]{X�Q�s�>y�q
o���-�M�lx��aV���04���D�"+�R4���\q�AS��)��L���O�-�5�5R�_χ�[��Vc���Q'���HcK�<�_�`v!V�ks��=:����⯱�}%^6@���ч/�	IA���O�}R�+f��E17Q�\sF-,r��n�h+%�yj���sD����,8ߤÛ�Q�����*["�ٴ� �����em)e7�>]H���4�S*J^��bR=��O!�� �0�MmK����Y1�/ZW��tq�b�sPӂ���i��mPy�N;��T�]��cr�lQ.cggq��i��t�O.9_z��Å�㪰!Զ��q�@$�[^pDC���$|�	�T���P�ab�Xk�������	�A�~�Kg�Tg︆P������'��DШ�A)��A��x�_H����}�wLլ�����!�8�9�^��s;�Gbm�}���}��>x��!�r,T�Ñ�Ś�g?:F
����+ �r�"�c=h���ࠀx"����$��5Ver�d��݆Ues[�媅��V���c��*]Ⱥ�:,w�n*�>xG6��9H��e/M�3�.K�Ĵ�iQ���1�|������;^L�DZ\}�;j���w�:7BbŜ��fCo\5Ɖ: ����>�J��;Dç3o������lC����}�'�� ��l�����n[יP�H<^Td������K���ԑ�x��n��[����Q�����l�2#��NN�Ss�7��!�͒�������Ɇ�֡�K���x�`�y��@�98K�:A�	G@��!:o�>x��v��҈.4�/�G���0�E��
IbC�>x���2�Fu0��H^��$��C��1b|.���%J&��\��зޑ�5�i�ޡ�dy�_���L�yL+�L��}��C�%c.�W�C�|�dc.��w����ʻ6�0�>x�F�0�]���ʭ�&��P����L�2�q���b����[^o2/�������pH�f�Y����p��y�����mܰ�MBhp���l��l�$���o��c�7KXU���,�7�{y&?�!O]�qG�/>x��dV:U�݁�l.`&�ZX���L��*f��;^^�+s���Ɠnv=����%K�J�\�����;|��f�Š  ��>x�v��0�)�h,��*��}��AJ|�����A�Ÿ��|咹�>��;���ߊm���¸�Gg��}6�����,�'f��-�1?{�v�K��}t���ni7�b�j�G�]cGs`4=���!G)K5*nK����,�;޷����.��fG�w�����+B.��@J���9��Ƙ>`۵���~Q�3�f�A�S2TuN��>:"���I�o5�D��$Z����t	�3��B$�|tb�}�:ݱ����7�k���� -���-���w߳>:�P��.ȹ��΀;y�A����P`�?��`yZW�	�� >:��0�̄����6;��T>:�\���Ȱc���Y�Gg������g1J���6���r4��d,ˠ%
��3 �A�Gg���σ�m,F
��ǲ�4Wn����fx��}t���z��a	p�{YaX���\�K�1	u<��	|t�A�/	����A�M�)��8�яV��$��Ѥ?�B�@n��h2�uޠ���&i|�f�h��G�t:��yQ�����d�߻�#��o�^�p!kE2�DKF4��gG4�TgF4H�n�����_7ͫ�h@)��h@�E4X��TM�o���g��Y�a��h�#
�2�3����i[UD�upl>���h �8֧�d�	�o>�0Dd���i�8�|��Y=8�+y�^���^�/��#���N�kZV����o/'<Xf�O��sv�����'S� P��Ď[�#N<{�j'�G4pM��>N̶`�2�<��<euS��T�2o��R�ݰ?��Fw�����>l�=���i��ɔР�hw�k��ԑ���P��h�&�|"�n��w�3�g#�w��}NzH�<sD���}� P}l( Ƿn��6�q����i��p�נ[RT�'� n§Q?�p�/�W%������SKc"B�q4�4�J���`,Ĝ���Ju@����>���h�#�����X��PԻK*��F/�ʦ�Α'�����#��gpZC�}��&0�ǏGS�y13`sY1^�F��� ��X�ǽ�3��-
��ٚ6��Ҙ9��O�V�!_P��gzU�~�Q��c��I�F |#T'L���,������f��'qNS��͇?�fS� ���1�IN;Θ0��t���h��q�MȮ����c�S��bOY�,)Nn���(T;_��Iv%&���-�i�ɱ�Mln���{������po�������{7`��E��w�$k$M�~���_e;%��d�M�̝<�����>�A>F��/3H3#mײ��G40�_�b3pD������.�G4`��"-���B�1�lz�[�q����,u�W_^�:�<�iLy�jC�����D
j)&�R;|F�#���_ag�v� �O����(��n����E��<���`�h��#d�K?:�Ox�`�]8��S�&��^�r���)�̟6i�f�G4p3���{Y�@�]���Q�჻zwޅ|�L�H�\>WV�����.䟟���.Tm�"���a=Wl݃��Œ`�ZЖ�`��v��Kl;��#*��Z7�=�FԢ��Zl;��fpN�#��TQ8��X�Tf�j�	��b�h[܌cq����i��¢@�\�p����h���i�zbwVӒ��#%��]PJ>��H|D�t�� eN�vܿ���P���T.�L����iF�9���2��B��G4PlR��Ȉ��:vl������#6m�|r�����甏h�#��o�c���U����'A<!P�{� �'��t> @��Qc�
��:���$����#��/1��K0Y�*} �TR�04�GH��^8�������wp�.�n�= ;�2z<DG�PO<(e�7�Rp$����u�,_r*E?�X��Uˠ�:gN����ܘ��( <����^��g�$%��]����Ɠ�W�ϻ^�w��T��Tn�>
 ��n�n�m����weRfȞfHM͌�EEN�\�F�S2Q1O�( >
@���( F�j\�������p�~�S�2�T���A,F����Cn�C�H�"��$�o�s��,�2T�5��]���l>"�Tp��p��������ഓ��y���0�D�(��=<�_>6FQT���4��ĚS �Ԇ���qF�De��~��Bk|�O4��t(�Ƹ�>
@.	2�C>
��@��?>
 �_} ��;dx�|���֢��\o�)�݁��jI��E�'>
 �*I����� ���I�փx�G�Q �i��­�X} �g|�Kd�`o.���Q ��O} ���( �v�jW�;�,��
��;��#ķ�Q �h���(�ރZ@;���y�#���g&>
�p��̇����_U�r�,Q%�h`�3���=o���j-A�6����ٳ�ډ�)�3ZF)t8���5Ф-Ey���׹n��Bյ�O���70�҆aK R�;	�*ŧ�2��Q | ��l]� �( Bd���t@,I��'��?�k���e;�c5�)T^�"B�D�>���ڽ��۪�Η6�x��_#���l0*��gwM@�E� UX�_]��W.\��p��)��ʅO�_z ?/����p��!� ����gF�DKF��gG�TKE���gG��KG���( �A����=��{�䋹$�G�Y��*@��������:���L�� ��S
�Bj~.���$0�����4)/��ص��WT?lپ�5���#���c��HUÝml^�`��=���fհ�<�f�]�U��+����qj���푫���w���@�I)5� qܶ�;}���Lo[�g�O1+��גĪ0!��|�Y��?&̶`�2�\b�� MI<g��
GIh�6����_t�	�VSW>�"���n�y�! Ta����@L�G�]�h�Np��W�mw_�q������[�t�Ka�������0�p���{����������=�{�
�������=�c�v�HX�*U���wp�4�گ#r�R�D׾���!Q�����53��w�Q�cِ�5Ny���VU�fT(�Yڅ�XۯJ^�15Z��bnMC�<X��r+�츊ټ��*�yvj��s�x+�Qq��%��������#nAu�4��Gf�+�liS�K�ב���F��
5����Qf����ϭ��:7��7�kL�ȧ�Y ��h��C4�*yԴ��ͬ/��,h-6N����)��DR�)�<�.'l���6���gG
�ǩ���Z���Ӓ��9����,���瀿mܙ������9��G���d:��"@,��w����Mr]fy�.����x��z����,N\P�P�.X��l� 9F��8������q)�{���E�ܺ�{���$�E���#Q)���8Lf�	��������Z�����_}�78��>akú�1�lӘ��,e�jr=��=���/�bgՇ���Y���Ǯ`��L��g�S���=�{�88�������R'o������ I�}���L�2��t1�]y� ^B*���n�>4��*��̿XW�+�Z2D����6=q	Un��#/��N҈2��Boy���?(V6��Ǹ��4/�m���98Wr�f	�wu�{'9(��\�<�ag��y�t�{���ʜ.6HSHZdB}I5����EVx,�=@����Ic�2$t8/���T7�����ϧ�Hꦬ�L��vι�hl�ŵ'�\z�[��i�a}Oϊ��,w�U��DT�b���r����x��|j�� �'�ÿ���=�;n�7�+�o���{��r���g*����b*���7��ڈc}��d@�D��8�a��>���t�bM��N&``=�ҝ���ܨT�L^�?�p���z@X�������E}�7�Nd�8����JG�8�	""���-͎t�A�T[�z��8��ƣ!���q�{����<;-e\�ILEҿ2�UM��)6E�tet�)%`[��/�U������fBy��𒲡clRyIy��B�)��i���OG( ���Λ[&h���w2�q�Ϯ�K���a��_�v�1��0�q<���}��?����#i�4Uh��\� ���}�b��Y���s`~�4�c2Z�9��}�$>ĦY���5x���DS2��_�m�FQn���2��i�+Ϥ
�������)gJ�N+��� &_�]�W�YL��~WL\x��Q���>lR`F$A頇���)�mi�!��/�#�&��\�iՕ&�>y%��~���P(9$��br�,����/ez�2eּ�Pz�4 4�L�=�N��&�Ĩ���5�/��Í�y�N��&^�dw���\�E���X�^iGȕ�ph���d~�5?R5��?���D;3Xp�W>�/:C��2	F}	����)���P_q��!iׯ�d�Y�Di�f[4�Ę��	��)%�"H�Q\LZ�T������?��l����Q����	�����P3LM��&�.zf,�y���S$�&zs��K��6qD��Lç��ѫj鹹����n�3�>��G)s����.������d��;_��*�&+�4J�}xf/�i��^c��E��P� d��M��)_�1�p�C�*(c�輳�q���R���*kӜo5H� o|��1��)5��M۔�"�7�dCa�*�J�r]ԁ��;����l��,�/Q�	>�l	�5�X*y0�c�=���˄3�Dg$��G�!�������t����MZ:�ҷ�Nb�5fz��Qm��"D�~��?���$�(� ���l����PL����Y���/�u�bdy�u"l/��}:-S�&/2MԘ#�a0G�/�zp�'���ք������&0s`Cd�YNG�5�p]e�4�B��3n��}}Ƨ�^N�Ѩ�|�ֆ��,U7�M�(L�Jĺ�Bb���ߴ��G�������q�E7l5�E�R���I_G���Uw�M�(h�-�I��ÿi��6C9��<����dRa��|{��j
��M��mb)��!���}������{��3zZ�W����3e�`a0��M�qF�6��d�{�?�Gw�@6�a��Y
�eg���z�kuH2b�Z5�p('����{����G5z-�7�����GK�r�������"+���PgNg�����4�ʈ��4�V��Vc���Q������BŵI㭎$�9�o������`S%�����$'W��I�41�G
r���H�)�)�+�tx����	�j�Ge����{=;�I<�ؖ�ji���A؟�ړ��ե�OG�9�d��������@����oW�|�>���-�����>����N�����������^����W~�3��K'����o�����O~�>��_�}g��{���G�w������O��G���꫃o�^������_{�oL������+���o?�l<��_����g������K?:~��?:�Ƿ?c���O]���O������k�����h��~�o��/�����?�����&��(�Ÿx�ms�F���_q����1���TB�ĉ2i'��X�L��Q�,Nv����Ͼp �8�P}�����޾ﲌӥx������l����F.�(q%�L���ٛ��'#a�&�ǽ��W�b���#aW�&�o0�P��5I��4qꇴ��{�{>W@ޏE�oL��J8�}!?E�*�z��|O�2p@���"H`�y�1"x.�6Or�e���
�oe��zq9�����5�n��p	�*�vru�\�������o����?����}�� �I�hu�X��G���$�l��\����t����RP���t$X�\�qz#sG�ц�"y3"/��YV�: �JgQQH�¹ ԗ��eSm�*R�~��j\Hm@�GL&a���H�~&r��Z��p�(����Nȸ�;X��2| ��~�s�0V;QVl\i�w=���|��ٻ����������l���}�{{v>���z�qa��ؗ}��8h-2�����*\$w4<Pay��*�7蟜�i��-�ƿ�A�؂�3(h��D*�*���.$	��Ǜo�%?��[VLŅ��Caks�'�0�.*�v#�(��m�� ��n�h��94��Z�!���:|��#qɛ2,��v_��
�Hg8����^�=���v&�j�� ���%kڃ�6%>��T��~�>���_�O�[h ���\YB��u�j=	�uH����#��[~,'�G%*�XN� ,�OB�>��+�)ơSVN��i�l�2�X���e����s�*WAQ�� �2�l#��d�Z�x��;��FiH��q�RI�ڶ�!���,Lo�m5�s�@�0�p5��5�%>���:��MZ��'~�� �Y'�����{ve�?�@L�ʁJ_cJx��i!���$������p!�K3J��`bYS�$J���Ԉx#t�+���..�Mp�fhʤ &Ζ@����p��S�'D��T1X������i9�e5���r	�����`����û,m`)�re *�I=��^pD�5�C�N���(&���]k�c�'oXzL�r0�y�4�՞F�"����X �G`����~<%;E��˕'y��ƍ�ii`!L���� ����u��RHK�RyC��q�I6"������	�qlM�ű@�uX�M�t�g�L���Rɂl�o_�����?��C��2 ��E&��tue�)�o��4�BFi`p��`��q��2��9oZ�����J��)��J��\�+��P^-Jo��6>iHʷ%,��IK/� �A� �a�R���J�����N[$]��7�5�%d����j�Ύ�E�{˭R�� {dCW_��z������U���\��x|�}���(�����WV�Qn�O����g��`�V>YA���[N�w��9���i�L�.�\[�
P�~U�<�'��-~�	��{��=&�s��\`��O�/�ɎG�ρ��u��x��M/���-g���v��Q2�����{7��k��+�:b�[���k�`��k�T^Ck.!�;vG�G�PT�P���LɎj$�vɃ�t	
h����-���fe�yz���V�U�n:�<��v���U�8��,�2p�uTЦ���x�E`hhB�0��:O�;**45,rL��?��n}���@�8˰�~�������������0���O�i���X���7�Z�.�-d§ ��Z}Vsf�$	�
Tj��kϬX`����*0�R��	�(׏�+h���j��B�Z�fj1�R\���|�qX��9湲LQ�����[�|؀b���Pü����9 �3�^���Ln��e�����L��Z��HUh�9���{
�F���K%H`k�-vi�s��"v8	��
=S0��4%�
� �{ڑ��7�q6�� %j�T?�#꺰n��;�	͢�(���o���:�tH䂒� ��,�o�IsBR±��юT;B���#�D���4�!�do�"K�H��+�����XM��әf��a���5oz��g�ž�>��9�����pv�_p�����أ,���ӎ�*�\�x�f�bο�L�c�H��|�0�f�#H�v��ŕ��QlyQ�]�n3���Q¸D� ��W��}p5��@i���GW�-N*���M��w�J��X�q �� �A]IS�$���4�V�nʘ84���f
xl�Tܚ�� Ki�/h�:�$n�ނ���]�r��l���#�=��+�RB��I���@�1������=�\��nwFG9Ŕ@�d��7�V�49����PGgM4c��jS0�M�Lz���m���)4L(=�KtH/�V�i �:_�q�5����?�i��:Ś��W��7�����O�A��k�&�`��E�K�/7a�� ��u48z�/<��t��ث�n؊����7y.�]|]9E��P|)Ս��k�pu#%7$ ���Q�w�r��٨�.7L�uZ��
8d���s��|���5a��8O�����j[0S�A��
��{���=7��h����v�D��6��s2��\�&��x�36q�c�m)���T#��Wz��o!K���=W�� �k�7ù~�������!?���G��d������%5�����9i�Ƙ�1*��^�8\i�A��S���V���X}U��ӻ`4D�B_=���Nx+)JMU016a040031Q�K�,I,))�L*-I-f����Ee��������~�կ������/ؕ���{o���z�nݶu�Ywgς*	rut�u��Ma����U��L��R3�́��6IM*275UH,(�+�H,bH���U���B��*�U2�7��@J*��I��*-`>%����C��bf�����v��:Tej^zf^*X��U���nښ,t%���E_���2�RR+��>ƚ0�Ӌf<������%�R��Y�[\R�VXj�C���x+�)�kD�u�T=�5���2'�X/���A���ꓗµ���,�<K�z6g�s����Ԣ���̂��g��qn=������Ѿ{�<Op_	�*-�L-�OJ�I�K���&G��g�~-�Y��{zo�ۺE� M��xK��OR03cPVp,-�WHI-IM.Q(I�(QH��I-VH�KQ(H-J�/�U�qS�҉9�U�%��y\Z`���@�\ ��x��Ij�0 s�+t0R��B�)�hI�X`�F�'��c�/̵EQq[��%x����bJ��ko�"���8�G� vj\��&Gk	ZG&瘔
�V�1���$�����J���O��݁�ɢ��3՝zY������x_�����3q[?�vP�IޔA%.z�w~�V|��-��9�-�p�\ix5NAn�@�W�ĕV�W8���N�Vvm�v���wS��c�xf�e�p�?��,8�N��	Y�{��:q��}v�< �2�UREG�9�<2�kNP�۬��Ԯ"�{^�p�#���[��A�}V�+ËY�QLyATRO\�L:`b~�\?�RKyJ{[��
������SÊDEZ����Q�x}Tێ�0�3_a��Ү�QK�Y���Q���$V;r��U����,����Ϝ�9g�2�������n�J�.I#�{�~ZI�uDw�V��!�!���@Y��Υ�n�)a*kz�13��=���Ç���������$R�(4�/���@�,k��{� �;�!w.�x2f/Х�N�cc���.��Xj���	7�O	��(yʶ(�w�s`Z�[T�K'�%+h�	;剩q�4
��JG��j*.ϲ�3r�E�N `��9d�E�'�q��Њ)E%J7M̠��(��#�<��66q�K	Ozq�ЮƬ��?�7��?����1\���m�K�������K}��ʲ-�*���f^ mtR��Kq8^�t�������52N
�l�e����MҦNcNt�P(Drv8�C��1r��r�'c|�3&�n�1�39M�S�:v.N���\��`�%�dyvi��ul�0r�P�`��=asٵ���)�H^�����:5WEZ�����&uۻ_�?�	~o7�3�7TX�	%�KL��Xucl��m��T3�w�p�>]b�x�=.���{����'�[N��]͜��f�w��sicpX:}�ci����Z���mz��نD�g�?���ΌE *�4��~K��F�x+)JMU044a040031Q�K�,I,))�L*-I-f����Ee��������~�կ������/ؕ���{o���z�nݶu�Ywgς*	rut�u��Ma����U��L��R3�́��6IM n�1�x}R�k�0޳��kV�S�:{JI���:�XX�8�s��dI;�����}R���E'K���qK�p9����IUKm+��[����@�V��Ҫ�!�f3(j�G����r$�2���`�ϡ��4a�f	���ڮ!��o簌��H[x�;!止�S>e����*�WBTg�P1���;R��[�T�|dR5������f�ψ������`a�Yf0��&�PT���Me����?zU��ٔ�,K��hxp���1���0�L&��1=N�����2�^C�;Eu��IL�ν��/)�����S��t��7��8�&.XѳEo��ºu0�_ˁmp�'��e�Ӫ2�V�u�������\	�B��b9ȣ4Z��;0b���4�,D�/��i��CM�3v>d�)$��+�����f�ly( ��Q}?�9��Ř��E
u0�i0��ch�E�#lҒ���.�����ݽ���}����g���l�x�V]O�0�s~�Ej��2m�(��	i�4@/S�"7������ﻶ���aH�K��~�s�;�r
o�}x�����WQ<�%�y��#ܠAq�>_|;������(Ιa��Hf���g�,�"�2q�Z��/-��8��"3��%��I2�?��00]б{]� �)R�]h���|�zZo��`8S��fR���G��
M�XTi����> �jzåИN���2�hvG
5��b�¢��*�rLHZ��&����<<��3�:���H��SBѧ����yz�����'=��_[��\c����������L)���B���3G�0�6X���#���[�P���T^3��5��H�V'�6��*�I��<%_�E�gj�i%mK�k�oL��F��=�Ĩ�c5�m7�F4�l�~����
�)	�8��j<Ɏe�����;�؍���s&�!��٤�#��+��FM��H�|����5A�_���o]ԠYꊆ�f�#j*y�����/�Rq�q�A�rl�[����O��$Ĳ��'!W��V��=h�j?�xb�րt>�嵑V6�c�]_l/��4:[��8jϨLgk'�Gs������[�@��\�����eM�[�H�8͓���q
����nd���!nV�ncڮ���Sgڤ�[Z�8L�zu�X�{��.��j����?��Ap-�ӓ�s�&x��A
� @Ѯ=��@��B�ǘ�m����޾�^�ۿx|WR�����шր0�dH�QK��-��փ�Q9��hK�<��S}��'�c'ϲ/�7jq�{�{�K��韱-�ܻ��\	�@�Nh��Lf�=�i�?�}*@Lyx�Y_O�H��|���G�Iۻ�
젖�WNzN��{!�:v�ސ���~3;��ڱCR�ԗFB�wgfg~�w�$N'��o���9�O睝i:�^e�e7\����~8=u{�`�ub6��wvB_��us +Y��\��(���w�&�~�z�"J�~(w���a��������rt�l���Q.r���iN�ˠ�$m� M@�*ID�E�0��y����2�-x�����j�s_����XF|Z�#�V�E�V��OL-�8?=�>������ut2�N��N����"白��3���0�-�
��E&�8]�Ȣ������'Q�sAf]J��U��\�a���q4���,����|��VF��#�?�b���lF����ut+'Ei��|^�Ga��b#�h�ܸ�R�@��|��Cdsi���U�Ƅ ؞�$���ג�0�{ �Zqxu����
�����@-A��u)}ep�VL��<� l6Tv�;��5:�잍����������.hẬ��h�eO�2e�ϗ]_���Uwv�kĆU�)����u��E��q�<8`�n�X�e��4�\�<���b�g��}�w��+p�Y���9W�b������jh��& ~:=�@z�d7J8�zJR)VS�#t.䠒z�H� ���`"�{H��"�(������Յ�"S/6�W�c�l�|�jTN�o>t�Nur���ȚJ�S�P:��i�㘱�0��<Ȣ���Pc)�u�;Γw���ϟFl*f1<����Ƶxb�HJ�ΌC�S?�N�Z���_����ɮu��<̈́���Z�(S7�Q��ˇ]%����y�1w_�_hQ"1^`r�I�ނر��7|#�3�}:6�`3�k��.���s8w��k���\K&$HcԺ���?��lVd���!L�=�`�j����b��ۻ�жf~�xDf���~���$��h��*M��w��m+��M$� n�D���ZF&�ь��D93/���Z}��~��ؿ�$M8��z}�F�U�7b��:@P8-�\Kw��	�&O�4�R�Y���C��m����!F<4���[e�
֙��rN�yE�C{������^@ڞ�b�!���(�;�
RC��L�%����y�.�55�rf5�M	�(Ix�a|�du�t./����5$�eQu�9��lVX�`,��u�p`j[�mt��o����"�k�g��vgG��l)��ݫ����S��ρ�w՝~�K��[ǆ8���Q6ʗ$}�5#������CUHE;�8\T�-"�k`~���<�T�i�o� �WqH�z���N�F�/z}�^����94�gRj?����/Uϯ��Ϩ����R��pšM��o٫�Ӌ<�~9݇��$�� F�,��<w-�]@W���(�\3�f�yǔ�g�!�����F^@�W%�$�e��(t+흥	@����C{�ݳ T�YDW��П�<�G��㑷�Wt��0d�bEv����kK����?�2�1�Y�g�5�v
��ᅼhӀ׮��tC	�3 ���h��F�F�"������C�R����a�!$J\W�#�4���rc�� Zkr�#�ހ1q7-�Q�p�h^��i1U��MBb�c���q��Ţ� %Y	P�XO,	[]�R�X^ٓ��J�,��Y��?e�D$��� �8���[UIg��k����XGY�#�Mi���-�&r�ȩ�9�(`�;�l�f�T�t����:$9�:�-���l��	�s&_*a�o��������w�":����s�mR^N���ZC�_�4�-�).��RY�J��&uV��V�1�&���RԈ�6�5�hU��\����,ہ3xLJ��1YYi,?*'[�(��UK�67�$���35�� �57��M�MzU�����P|Lj�����;[M&��ҏ�� ,n[$	�>.I���$)���.�Q�˺�W�k�u�~�:���f��p�aly�`�2XeWέ-�ֹ߯�Th�a�\/��f#��w��'|i^[��kn�UY���b���&5l�gI����`劵e%S#8��d�7��zԣ�xŝ[sG���9E^D�ATS��t���@�0h ��o��J 5*Ta�B4���w�{�vϾ�L3-TeFx����G��|yY��������t�������l�>����p��������~iW��rQ��[���߷����w��SU��˻����fS�������ϗW��f����Ŵ���n}�����z��ܭ���wW�7���w��/��aɨ�u}׮ng�M;�7�z��u�����z��]n7mͳ�x�/g����W��7�I�X��t9�޶��n����Y\���l���M�����v������mn/筞��ik��]��f^�n/��>����X��)��W�����Znh)��M���-�k�~�\��6)�$װ�y��]�7�3�ޭ��f6��\���v=�^��
�m��ں�o��ve¦�[�s}�gE���¸6)��wP�ج��f��__�l�iӐ���Y5��>��z2#̗�O^S߭�׫���o!�V�����V�m3�)q��8�Af�u�]3қ��΋�u�'�D��5u,G*�[���������m̼��˪Y<�$%H���Z̐&������nn����r[O��G�w�����Y�riM���]��0�m~���=��Jr\�W�j%݆sz)�Jë��	_NX�O��,+h��Y��i6du�|	������ ��W�J[]��c��m=�Ґ��l}�Z)Xä�1��OZp��X��n�X����=�ş�W��@�������s� 0��A�����Ǟߢ������$j�)B�i�3�7�s)Uݴ3gU��!5����b�ݪ���	͐�bv�v� ��1f�(:�5~�_�m�~%�Zi�!^�/Z�����J5iWl���0���l>�H?���JI�.�j�ٕ4?3�]I%��t<��Z�^/� �o[��c��hn����5
����2% �nZ�Ra��ad��R�R����5k�[�E���!���?��mk����d�XS�Yk�@�T��lt�SjX1{Q=��k%��.Q�ԅg�(ĭ5�՟�����51�ޣ�%.�L�����9��`67���ش�����ר~���_1g$\i���_���mǔ���})z7o�	$��ky���w���p���NQ:�k�i��oZ��}S��دb���j�������1	Ʒr�
�8ϕbɃU�T�j��"��%��ߓVݤk"��DL�j�{;C���iL�S��e�R�~�f]�3���,������# �[�&�ȴ��]��5�Rd�/�#w0�n>��|yk�ᢟzay�XW�Lx ʗx��F!�u�����2�K+.<�3)��9!h{���m��^��*=�zi/���JxM��	�	�������Ҁ��WD{Ci��7�{�	wE�(dy�|@�osR1�]-īp�2��d��Dpo��8�3������ =���-�X<�-9�ޅ%���l�B>�%��Mm��ݦa=ANq��m������RQ4�h��6~����h̡����V�1��p�+딨YA��D���,��X&�PL�����L�V��VP�`_f�X=%+�L��J���u�ӎ.`bĪ�"�ie�nY����o���WZ���X���0b 0����<E�8m���7���O{�]��0P����D�gWbm��~�:�̷w���f��;҂Lܷ��s�t��,�!5i�,gb!�'���z*%U��ړ�z��껅O���Q��Vp8.ݬs��f� �ꑀ��wG8nD�H�� ��Sa��v�
��ŷ���r�
R�k��k�� �) @�Z&"'�i�8_���,���ʆ<��������z��}�r�������\1�wo����l3����LƘ�J��*V�CgGǤ����h�D�� ܷmê�x��|F�0o	�Q�qnU9=u����LL��[�W��n��P�!���ݜ�N�J�6��֝ٺ�E#��'�i�CZ3�"rI��?���N�ЮY!"��A��aJ�;�q�K��,f��R� �N�d	ڂQpBt���f��9�U�k��Ġ
�Aϛ���!�\z��8 5b=��p�؂�e�fQ�a�'���{;��'I(I�\����A,�I�*�s���s��j�ر�����;�%���z.ZgZ��	nW8S�bG��+��E<.����5ט�S>�(�&X�)��А���\LC+>����M&�t�[�&с?�3kV�p���v��pNE'~��ƀ���b��N�f;����$5Qh���}aYEf���"��[�����ݪ�)��+/��r���©��b4_��ܤ�����s�@��B���B�U��^B�T���&s���$�ї��d���H���D��z���94>w�4	j,��_�4��1��Y�Km�qs%,U5<���
<_�����Xw�,�?��(=��3tVl�yȁx�q�#?�4��L�:2^?^�p.���F�#�1��	O�ñ��%�ng�B̈́!�MuE(b���/���\��ݫ��C���!��"<��P���U*l��p����(��k��tP,�g\��v��\�QP�mɺ��L8�>j!��+�,ˁH�v�n0L�H�jI� �iU���ok�
��2�H�#�A��x�۶u+Ǹ��Zk�x��
�"�DB���ΠJ�� ?v�<�*
��B����(H�G��=�((�\��}a���m	{��ÃƼ���O�kZJ�Ŵ���B�=�Cf�(��L8,��F�
S@=P��i.��y�m4�k2�)�t�¦��#�*sr"��ݕ���d����q6'�H�A*��豊�"���{�0kn�<�g��-z�scle�^F�NoP���\^n`�^پС-m��"|dlUB��S8@x}�Te��{ռ�3ɷ�Dev�M���&�5.{7���`�>�U��x�,	z�����j�\����D��9���bñ�MC-giV>�*xo�2Q ����X`A��{6����Q@�#�H�0��j�;�6����r�UF
�!F	�91�dY��7��v.��R��6�
%��B�[Zj��@�p���WƐ5OQ��Jn�{� �'_��j�ٜ�`M$}���]#����簢�l�F�����T3������A�n8�&����9�J�L���������6�jV,2@��`7�ڄ�	�ɤm��Q�Է��Px��W��o.�5 ���+��q���-� ��V.�[)z��2�7�걹����L
�7��_`�"*-�l�V����� t�UtB��*����_�e0�U}���J�sr�&n��a�T�i�
���Kܮ6ٌmR��%Z��v�!.qz_gJ@L/��)�j�|�PY�BG����z9�b,.��\�ۭJ��������}�n��$��*\�͒=m�[�P�d�i��2���i ;y��Q��P��L��D�+*�X�-fPS
�,C�����ܣ�0ǯ�"d���E}�X�ʸ�ǣ}��~׬ٵ<��H#��,�*��f�@y��|��%G���=.4���0����eI�`,�!��L(C.�=~�
��	h=p��pkjPу
'����0f�>ђ���<��8���Q��<��Q*S�sH1�����ӱ�Q��)b�ݚ�::Ǿ���C-�Zof
T��e0�����ـ"9��Q��*�Dl�5��hA�̈�>�4s�D�X
��0�	-���� &+�a���
x'��YYQqv����ZH��|��;Q���GP`Y$*)��ತj(��$51��ɳ�%,1w�!ȻاR&�_�>��N��X��b�]GQNj
]���!�]��R˞��+nY"wl���*Ԃ^�+b�$e�D��jcu�)�K~����,#�F�.+y�u�$g݈"&���GD*i�uml���EM�9�Y�-�&�M3����E�ă-m�E
,�z�6/Ft��0��J�t;y�nb��8�n��HْОX;���t!Z����6�-��*?����P�}�m{w��t����w����Y��?�'�)D��;��G�`N���E^f��/�G^�����oT�.�F�$��M&�gj�Yӄ������}��a�#���U�녧P��P��b3t�J�aLn���Z��ܲq�DϣAQ�g`N4'S��U���/እ�!���oK�����Db�^������)i-A�����;io/�=o���?ʦ�5�W)�YE<�$%}��+l����"��A
v��W�^�}�YB׹g�МQ`��3bȈ�
�C�	�g�=����`�1zU9`0���P��+����t���Q<�O�V2��J9B�VHqe���W"��A�r +�L��C�V�%�$�K��ą��yW(d�k� �֔������"+��h;%n��`f�*��O�F�g��7m�Cz�(!�R�����&��,��jP�K4��p��aW��� ���n�.U)ө�*5�Xf[68�sӋ�	l���*죔��N��ɭ��R}��FByj`��]?V���`���2��j�0Zy��A �K�R����O�Rc��� 
��L&K$P<]П�M�P��W���o�%�+�!�=e#�G����j1��ODq2�?��A��h��J����M�^#����o�Ӟ���i �8#C�BD�z{w�Ԯ���� �d��sO�I��P�>*MT�'`��ϝecb��a�)�fY��Akڛ3L�p�M$0~0$+	��uQl���E��MB�]~��ƺ�L�@kV����Ȏ���tz%����,2>��fw���ȊR+��*���/�eWQp�kj>�s��LW&�tMq�C�,�p#{�g�W�O*gV��Q
  ����:F����,w�jRד�}�P��W��lD̆]�Y����p�<�{b�%�K�PY�);�k0�P��Ӿ%W5�&�M	����G� ԗ��ɣ�@g��L+�u�:̼[���S�3�]A�J���Am�81%\��"m��3e=�Q~�89��C^Zc�q��K2���
��-HmfR�غ��enL\��C��x�(s����Z/$DO|��k���d��o�9�]L�� �6^~��M֗b��$�'��rA̬�xfW t���f�_�%b���*�f�7���8�����{R8
��zE�0��<8_8g@E��S���S�=�2�S_u�-b����^����ؿ�G��KW�M��u��;PI<��J���QSY����ٹ�`���^�`ɪ
�Ô-�E��\_K��o����E�RP[�R�X
��\�h&uʮ,����1^�e�K ��L��}}�fId��C��^��"�RV��4'�0����V9	��5���Ϯ��d���0�V2�~@8�!�q-C fXõL��L���=�պ��5�/����Dl��z���\&��J�4Y(fϑ�'�rXq>4Sڴ��^-��:f�b��θ��y����l�� ������gt�L�=��ؔu~�U*J=����?x�v0ݮ̀n�Pz�;���R�����L]/�=_4�e�#��]sc����$�A*�Y�������X#]������n�/F4x$0Ơ��PT�h��.�s�R@�8S�j2%�	m�`8
gL�E�݉4�ڑ�%n�!(�HG�0�ZAW69��� �PA�\Y�	]�i���qN����a7�u ���4����az��(�(6��*��i$�����;��%�%9(�v�U��<�TJiJ�E�@�r�HAz��<�u)3|(:ǡa��飔��T���#p��h�e���� ;䬢���h���S+=&!�ܪ����	�r��,�ޡ���#�vƣ��<��x�j2�t��(p������D�3�g��A"M)$��H�G=�!�7�y]_�H��gZl�\�f�M�aLn�B��+^�̝�"�'eb N���_һ�~�{E� |AIfE�Gb�<�]\�{N��zY2��p�3yEPYQ�W��AC�!o�x�����cط�����m��$ܾ�=��O�z�*�0n�d���.�}%�*�q�'Z��.�@���4Xx6J3���]�V��d_{=����P��������6�>lԊa��-�~�z-M��z��J3��u��� �`�]ۮ8�F�GI�u-�B�t�e:�y����SJ�1d��h�)�K"�3N�.��R3C��nu��&����7�"�P9�VjyUa&��G�%�m�a�����<grt��u�tz������-ٮ����F�vm�~B�T�RT�CJ�9B�=����F+H�)��@��ͅku �)������Q�N�x�����R����:FD�纥o�Jkl^E[�#`i���y�=��VH.��weS��\�� �������A�G"Gw��<AAv;�K��r{�a_��ZD��@���Ai�Wtȓu]� �b���(����n���c��Ӟ�zgĨQ_u�y�:wZa�4����?�t<kX������6����]�*w1<*���G�Vs9E��ӌ�#S�Sꬿ¦;xw�
۵k D1ֱG�a��PT��=a�����W�B�������~�Vc,�O�/��a4���I�M�	(�g��0$���I#��&O��.�A�&��*I�_���w��`*�� Tv�׿���p|�c���v[�8�"B�F��," ��O3P�Έ@y :u�Vؽ��+�9��$�Z2$OU!zHԪ���	�P��Bg�,���us�gG��IT��U�"���K�T�
'.�6/[���� ��.��r�d�(�D!�،���cEI�!�`��r5�@z5��Q�$e�C��;����Ƚ�<��Y:���@Q8TkV>�Do9�AuT1���j$MH.�Ճ�A;�'�k7���E{SE-�Y���,o�)$�JB/�4��ḥ�i�\��=�T�uN����(�aV��<�tC��ѐ�Jΰ��u���SQ�Zd`�����)���r�`\��v)���#�d:t�{��W�`�n&Q[��;�Zju���xv�񵝈�gH?&�[p����jV��!�GC+�e%�vt;z�=r���S	9z#r��.�7��y�*����:��X0�uĞN��_T��;��Tyb�;`��w)��2�dk���_���U3�/T�f(G+I'{NeF�2� **�e���m��Hf����Q�V���Ɋ}������-�WxQΩS�"_�}Ok}�H�x`0�~�A�p��K�a�����ӣ���8�K��C1�k�Xa�f��ճ���I�

�J��i����m���Q�Ӛ�>zgn�{����\h30B��S�V�:�T@�Œ���/-����?v�.��ǉ�Z*���((rE�����l�yS=OD�,B�r@J�}D*퉝�^}�H�NTB}�,�Ǎ���lҨ�&��jܴ����¢D�V�V��·�PW����v׀����,�|�y2i��Y�y����!��C�j���X�d�z�c�v�	s��Tr��]_`1hk��r����^>��ǯr�X�آ�8>�k,����>��������)�ټ���͹ަM�`[�s!�^Вd^����b5������"��x0�rgE��vZ���s�H�^��".���ḿ,��S��x�3Ј�I@x�Pv
B�z�`�O�h��f�/7���]Q7�x���o3�{TW�"N�y�@�-~���o�F=M�(U2་�����8����7?�gC����~w��uQ�����&����>�NvX8�n���\|�ǈE�-�(��؄8s��&qڲ�4b�b���sl��1G�W��a"��nd��C�F��g���V�p=f��2-�ڱ����MO=M8�����^�"�*�(S�eckE`�ڪ���h�����a�����)���Vd�n�!�k���I��S�-���R(
��:��;4�P)����A�������n4�������D��h#����lQ�����Ɍ���BS�s�l:*��'�
\yy<��D��Ϻ��j�i$��md�E٢QA+Q2��C"�e->���E��{�n6&��f�ׁxh�gP}@`T��a0�\������iՁ��q��� $�5�K'��e����U��5��r��l&W���,����v���D�ݤnT��\+P
�b��r��@W� "�]��b@���H�v�C���<�ˋ�� @���)�zl� �y{Å�a7�l /��$���޼�����DٴpƗW8���h��E�2+ee�_\�C���gKg��x�	$�n�R��S;�(��,��M��N���v��^��
�5
�0�q���~)7�z+Ct���	�k`KT��L kA�7D�0�!��쀍�7YG�.=+ꤝE%e�k�i�`�ov���V��#�W�N��)�[�����)=w688r�Ժ`���"_�\�$�Gg�ͥ�`�3�kdH������"P��y��daR�����'l��Y��)�͝HJ1�O���(/ƌu�/��ύ ��lQ��e�����3�/7>e%Fkya�5{�1$vlؕ���:BR(Dc1�iSa�!l��<<p[o���:�B;�`p\h�߉m�����h��\�Z�J��ذb�'eΡ�`s�d�*�.���̥�x��mGJJL����w�C�����`��K���F ��n�*�ؒ.p��.�����K ��1�g����GS�P�d�2P�^E?ҭ��ˮA���D|z�����,���n���͖\KՋ���H��%���eFO�8�������6�Úg�|�+sYN�O��ux �NIn�K�p�����e �a�����+)M�2$D�E���el�zĹ�b)PZ�yW��JD=7PTC�1뼬c�q�F7��B�yj�u��x,W)��Ջ7PD=Ѐ��ٜ���2)-
�Qv�/�58��I�It�+xP��Q��gJ@q똺����]@s��q�m|\BhJN7�v$�%��(�R���=�@D��!&�����������μr5����+ܺ�������?� �%�z��.o���#��&�f�KPY|�����	
Q\������^Qo�-�S�-DfSڪd>Lta�;ژ�wLk��oҺ<�2�%;Cb�r�^ �������V����i(\�X1�x�,�%���B�{�|q����)� ���E+�/�D_N�y���)�mC�$�h��a. \z0�r-��b��c!�-[G-D�9Q��e������G���{[��Nui��{BXT}g��g���g�h3UF���wT�$��P�m`�g��9��J2t� ���)�Wr��qU�'�����[��݅�1�P����u-��(�cs�[o�[�1g�#y��ls�˵c� �����Z����Fɉq��{@};����ŗ�DR	�D#4Pp�S���MN�B���q��+q%�Ķ�/����hT/̒�;���ߨ���%Zz��h�1hҬ��'Իd{�a [83H�̸]Z<�my�g?t�8(�c�i�m9�m�m2w�{`��7�d�j�+`�S�2o��]w�|�c1ʾ�Y�)Ȇ���"�~�e�D��
��R�8{��'���Z�mGl,}� �T] ��},��q��5۸t�r_����*Ƶ�\$�3�PQ�+v��U[�1E�v����fu܋��t�W�}�5�9�y�Ƨ<U�k�NYV��s��K�\��x��lSQQ���3]Nѧ����4���}�J!�e�[�0����N�䑺�xn`iv[A&֨N�Bu)�Q���O��Fp�C��.��������~R���HP�U6-ͱ�7m&n���WJ��O��Q��y?Gw�@.����^�Hx�u�H9P��l;ʼ)��JW�& ,;�V�ܜ{�$o<	(��!P*��P�B�M��@¢�/�7dM���,��*ٌ�[_$��=�w��:�%Ħv�f��`�$��(b.;��J�j�Y��!����������\ͧ�U��:�ʴV�D�,#]A]_�A�ӗ�3�d��nXV&n�o/�R|���q	��0�o���DtX�Wj�����~.2��%�#��������K��_�dp>_���?�Q�y(���PXH�^E38Z�[�\x�JM�*�;1�G��Ǹ49�0k1�bg"�\WaZ�;Q��*��Ɲ?�Ӎ�|�jAJ��j������0��D0~��᫮QA�/J�nM��I�u�����n�!`@�Ş��@�@�Sr#�6�$�[C��⬌)���|Y������l�B���f�sC����W�.=�v�����Ŏ�1vqt��Z���VրO]�v伫ӱэ���]�x�x�W���Rl,8��Kn�4���X�m���^6h����~ �����d��O<��=���D�"
*5�}F�e6��;��XY�ŅP���Mw9�cQ4H�B�Eg
�E{aI�����KO��}���o� ��Ry3�O�R%2j�z�l	�Wq�l�g�o�x%]	J�E˳��])3p}߄�VG|E�[9�b*���~�EN-�v�A�Q=�M��X�JZC�K��N�̄�#&�7zbܢΰ u���>E$.���") -���8�t��V��A�VI>�3�������k�x#�G��%�PeA7�)�W�GJ�O�FF��P�DֽG�)T��7�9�,W\�Ku��j1�H�l/K�׬��-�!l󝙰ƻ�Q��/��}VtnF�d�':C�Mie5ѐ��܎j�1\�
���?G�cw݉(���J��	��4�(ht�&,��!�JGR�G�?�ʖC}*����-'�w̓�\�ۗ)��a���R�CI����܇��Y�z��%���6}�0�L�b����t)��'���K*q�̐"@3V�����O�
�Rn�(�-O�?�ڱ}�m���jk.�����c��xě���8�$.<�:E]u0�@�	����E�v���]�t��hCv���PF*�#�ݚ<�?[:W�t�Ixв����q�ꊻg�Kjv��Y�4�b�'5�����1���_1mi�հI�R��}$����°�DQT�\�Cd A�䇴���A+^Yh^l��+��\�E���M;�^tC� �QQ�K�DG�(QX��%?D'V�sB���'�u,@"�D�#!#La��9j�L3S�o#�a�yKK�W���P���T����}�p����T:Z�]Y��2�+� �<��K�����s۫X(8O�B����E���M�W�?I >��p�
>�]���D�VZ�"�LfN`]*
���T��JbI#���Ydg�68fV�q�F���'6 hك·�3!�m���hQ	�d�#.u)83Q�_Ɉ�=�jBz��9��-��}�H#}�_��S�hY����S`�z��(�P��(tMjz$]���I���D#y�b���O�)7�P`�?%	��-H�:n0��p�߼UFc�?��,�j~4�G�L��ފ�U��,R�o�P��h�j��"�΢OK���W!�?�Ŗ6��D�i���o�sg�՝̍&����0ˌ����p��?�P�K0�I^��&y<=�Lf4�s�~ J��z���vS�ئ�_,�	Km$�om� �s���h�O��>��Ѹz�oA��r,9s$7�2�U9qHr��Q_�� ����֘X�����z"p����,�M[~�GJU�Xlu�`�V��J-�ZK@|\��]� ��IíN�Tw��;�(��!NC���W�{�D�.�J��UtR˸�5�b �����L�M�
��B�}��6��hk�B�Ho�${caǧcOqa=f�C*����/|�G/cŒ��f)-�����W�/��#�t�iW��(3~Q�h�?���ދnV�?YUx�6��y?�!�i"7e�@]���|�;c�n��~�]u+�t�Q���.X��OJΟ+��Y�
��'�)��%�tK��]w���b�#ʞ7)��PP�2�K�+q.��Q��Axq)�`�Z����z)e8;.�{����o������~>8;�����׽���������������䧳����ŉ�>�ϋ����ߒ:��8x_��\흞��{�ꣽ_Y����^Կ�|p\�0�ٯ����Ş^8<�=�ק���'���������������;f�����������������&~M��w�_/~>��|I|u򁟹�\��������oΠ�������#�����ѧ�в[�c��~A������n%�et�����S{���~V����1S�w{A��������������р������G�
�����w��ǽ��ͥ�Rb�r��'��uAj��uP�?�p�q�����d��O�y�'�Z����лw��>?8��p�|8;8�;��g�L�ٙF995�n)7�G8E���q�`Ѡ�_����ĉ���b�Ғz�%麟3z�կ�&�u�Q�b�����3*vR<y�AbAR~�엃��^�M|�Uv�݉�u=��"qI:�~���O��1U���n}~z��w���G�(Xŏn���D�9H�����Rΐc�	C`���8̭φ"|�i�3JY��X�~�bOC��h���c,�2����3�MO��s�	<<ih�|u����������>��cœ���Bi��R�"�_�V~}����N�i���~F�xl��/x�1"ӘX�GH>��q��P���[Z)C����uwH%T1��*�\�W��
�E��ӷ����ZE�m��ħ >sn��-��_�YX����L�KW�R�������O�p:G�d����r2'pkK@�����HXS�u�ܜ�.�/N�A5qB-I=:��3*�0XW��m��������e��f��WE3`
L"�-?��}�ԯ�����A/-�~�����`�g�v����g��cpu�N������ `�{TʸOX������Q�NA�d�=7����/�����Y��\����SE]���@s_l����.uÄC^��L@�֙rӡ���86e�ì�^�5/�G�Ul��8~����T,�~re��ƒ�	��^7WZ�(��v-\���L�����k����r����̔�	�+J�{$�ڣ��i<wm�}�������gΐI���p���f|(�v�r+��|%l���WU��>o��ώ�5��M}ɯ6Q�����r�,���������W����v����_=Z{	��)a���,Ӥ����/V�'BV�&��h��@|�I|��%�����H�~	�� Fa�Ϗ���w����h]���d$I��=έ���+s9��V7��g,��x {��Ҫ��5E��~tuD�j���ݖ�g�3�7���>�%�U���\%12A��ky8�y�-���؏�u�ץ�R��ڗ�����ze��roIҺ�ʿ�l6�<�w���߿�^l��>�]�$����0�Ի�S7�~˵.ږ��@V��%k$�(�AO�t�vlw���Y�c�yE��y$���1�j����K��5~#��Ð�F}ijF���)b�ڶ
'*�'��_��տ�ݿh���H�RxA���ޝ�}�88�<Le~txJy��W�������o�X,NNfh�}�P�ƝM�G�9q��
s.%�����p�	?�����)��{�p�J=,��L?CX����N4��(�]�����d���g]�h�I�������i���[� P����_S���0B�G�!*���D��{��Gt���n6����~�B��J�ҎΪ�:�M� l��M]Jp�<�S"S��
$t��%�D%ȋ��Ě�Z?��X�#Ñކ�ӄ�)DgZ�Amݧ@����V%֗]B_�q���_d4�rqw mԧ���&>�Єmn/)�j���{�=���JE�8�)#��C��M�&%*e�gK��-��1=f�gzZ�і�p�;��!Đ#5��Ja�q}O�x�	��p��C�����o�*k7�"����oqR�ί��on6�s\���z/xmSMo�0ݹ���KQ��i]*�Gw�C{ة�%�&*K��&���I��4Y}�E��gR��|���F��z�������g"�@���L��j}�E٣����[y�*)��ņi묏Hk"�T�e�Zц%����pd�e����\,���5��y@��3�G��;R3QM��6�]����ƪ��sh@߱Y���(�P)6�q��iܭ���|鉻>��r���ǩ6-[X'�'�l]@@�d��C퟽n}�Y'Z��k� �.���|�9ܠ�a�oYk��H@��PCp(	Ϋ=O�����T�BS_T�ٸ{�`5+x'��ܺ�֠N���@=F롡�%20�/%MĢ�g'�i�D޼M�;�1���^N���`ZPIa�zW�E5���ͦf�S�C��]<�j"OZ�-���hxm�[K�0�}�_1,B[�"�l�P��Z��}���S[ȶ!�(�	K�ŷa�s�L-���n.nT�����`�oxsep�6�� �%���rB�iԻ��,�����e�s��+��K>��3U$/�
����l���m/�L��}�Q8�)dl���E1l��4p)���@�@Vk�yc�2H�:�,�Dbbȑ&|��qCM�Y�B�|��a�_ \���B9a�
�ƴV�i�1,�_��nAref: refs/heads/main
# git ls-files --others --exclude-from=.git/info/exclude
# Lines that start with '#' are comments.
# For a project mostly in C, the following would be a good set of
# exclude patterns (uncomment them if you want to use them):
# *.[oa]
# *~
0000000000000000000000000000000000000000 b64bc1e78a1abe100633259c2f30bcf90ed1683b maxdarwin <72539638+1darshanpatil@users.noreply.github.com> 1732177662 +0530	clone: from https://github.com/1darshanpatil/My-Banks.git
0000000000000000000000000000000000000000 b64bc1e78a1abe100633259c2f30bcf90ed1683b maxdarwin <72539638+1darshanpatil@users.noreply.github.com> 1732177662 +0530	clone: from https://github.com/1darshanpatil/My-Banks.git
Unnamed repository; edit this file 'description' to name the repository.
#!/bin/sh
#
# An example hook script to check the commit log message.
# Called by "git commit" with one argument, the name of the file
# that has the commit message.  The hook should exit with non-zero
# status after issuing an appropriate message if it wants to stop the
# commit.  The hook is allowed to edit the commit message file.
#
# To enable this hook, rename this file to "commit-msg".

# Uncomment the below to add a Signed-off-by line to the message.
# Doing this in a hook is a bad idea in general, but the prepare-commit-msg
# hook is more suited to it.
#
# SOB=$(git var GIT_AUTHOR_IDENT | sed -n 's/^\(.*>\).*$/Signed-off-by: \1/p')
# grep -qs "^$SOB" "$1" || echo "$SOB" >> "$1"

# This example catches duplicate Signed-off-by lines.

test "" = "$(grep '^Signed-off-by: ' "$1" |
	 sort | uniq -c | sed -e '/^[ 	]*1[ 	]/d')" || {
	echo >&2 Duplicate Signed-off-by lines.
	exit 1
}
#!/bin/sh
#
# Copyright (c) 2006, 2008 Junio C Hamano
#
# The "pre-rebase" hook is run just before "git rebase" starts doing
# its job, and can prevent the command from running by exiting with
# non-zero status.
#
# The hook is called with the following parameters:
#
# $1 -- the upstream the series was forked from.
# $2 -- the branch being rebased (or empty when rebasing the current branch).
#
# This sample shows how to prevent topic branches that are already
# merged to 'next' branch from getting rebased, because allowing it
# would result in rebasing already published history.

publish=next
basebranch="$1"
if test "$#" = 2
then
	topic="refs/heads/$2"
else
	topic=`git symbolic-ref HEAD` ||
	exit 0 ;# we do not interrupt rebasing detached HEAD
fi

case "$topic" in
refs/heads/??/*)
	;;
*)
	exit 0 ;# we do not interrupt others.
	;;
esac

# Now we are dealing with a topic branch being rebased
# on top of master.  Is it OK to rebase it?

# Does the topic really exist?
git show-ref -q "$topic" || {
	echo >&2 "No such branch $topic"
	exit 1
}

# Is topic fully merged to master?
not_in_master=`git rev-list --pretty=oneline ^master "$topic"`
if test -z "$not_in_master"
then
	echo >&2 "$topic is fully merged to master; better remove it."
	exit 1 ;# we could allow it, but there is no point.
fi

# Is topic ever merged to next?  If so you should not be rebasing it.
only_next_1=`git rev-list ^master "^$topic" ${publish} | sort`
only_next_2=`git rev-list ^master           ${publish} | sort`
if test "$only_next_1" = "$only_next_2"
then
	not_in_topic=`git rev-list "^$topic" master`
	if test -z "$not_in_topic"
	then
		echo >&2 "$topic is already up to date with master"
		exit 1 ;# we could allow it, but there is no point.
	else
		exit 0
	fi
else
	not_in_next=`git rev-list --pretty=oneline ^${publish} "$topic"`
	/usr/bin/perl -e '
		my $topic = $ARGV[0];
		my $msg = "* $topic has commits already merged to public branch:\n";
		my (%not_in_next) = map {
			/^([0-9a-f]+) /;
			($1 => 1);
		} split(/\n/, $ARGV[1]);
		for my $elem (map {
				/^([0-9a-f]+) (.*)$/;
				[$1 => $2];
			} split(/\n/, $ARGV[2])) {
			if (!exists $not_in_next{$elem->[0]}) {
				if ($msg) {
					print STDERR $msg;
					undef $msg;
				}
				print STDERR " $elem->[1]\n";
			}
		}
	' "$topic" "$not_in_next" "$not_in_master"
	exit 1
fi

<<\DOC_END

This sample hook safeguards topic branches that have been
published from being rewound.

The workflow assumed here is:

 * Once a topic branch forks from "master", "master" is never
   merged into it again (either directly or indirectly).

 * Once a topic branch is fully cooked and merged into "master",
   it is deleted.  If you need to build on top of it to correct
   earlier mistakes, a new topic branch is created by forking at
   the tip of the "master".  This is not strictly necessary, but
   it makes it easier to keep your history simple.

 * Whenever you need to test or publish your changes to topic
   branches, merge them into "next" branch.

The script, being an example, hardcodes the publish branch name
to be "next", but it is trivial to make it configurable via
$GIT_DIR/config mechanism.

With this workflow, you would want to know:

(1) ... if a topic branch has ever been merged to "next".  Young
    topic branches can have stupid mistakes you would rather
    clean up before publishing, and things that have not been
    merged into other branches can be easily rebased without
    affecting other people.  But once it is published, you would
    not want to rewind it.

(2) ... if a topic branch has been fully merged to "master".
    Then you can delete it.  More importantly, you should not
    build on top of it -- other people may already want to
    change things related to the topic as patches against your
    "master", so if you need further changes, it is better to
    fork the topic (perhaps with the same name) afresh from the
    tip of "master".

Let's look at this example:

		   o---o---o---o---o---o---o---o---o---o "next"
		  /       /           /           /
		 /   a---a---b A     /           /
		/   /               /           /
	       /   /   c---c---c---c B         /
	      /   /   /             \         /
	     /   /   /   b---b C     \       /
	    /   /   /   /             \     /
    ---o---o---o---o---o---o---o---o---o---o---o "master"


A, B and C are topic branches.

 * A has one fix since it was merged up to "next".

 * B has finished.  It has been fully merged up to "master" and "next",
   and is ready to be deleted.

 * C has not merged to "next" at all.

We would want to allow C to be rebased, refuse A, and encourage
B to be deleted.

To compute (1):

	git rev-list ^master ^topic next
	git rev-list ^master        next

	if these match, topic has not merged in next at all.

To compute (2):

	git rev-list master..topic

	if this is empty, it is fully merged to "master".

DOC_END
#!/bin/sh

# An example hook script to validate a patch (and/or patch series) before
# sending it via email.
#
# The hook should exit with non-zero status after issuing an appropriate
# message if it wants to prevent the email(s) from being sent.
#
# To enable this hook, rename this file to "sendemail-validate".
#
# By default, it will only check that the patch(es) can be applied on top of
# the default upstream branch without conflicts in a secondary worktree. After
# validation (successful or not) of the last patch of a series, the worktree
# will be deleted.
#
# The following config variables can be set to change the default remote and
# remote ref that are used to apply the patches against:
#
#   sendemail.validateRemote (default: origin)
#   sendemail.validateRemoteRef (default: HEAD)
#
# Replace the TODO placeholders with appropriate checks according to your
# needs.

validate_cover_letter () {
	file="$1"
	# TODO: Replace with appropriate checks (e.g. spell checking).
	true
}

validate_patch () {
	file="$1"
	# Ensure that the patch applies without conflicts.
	git am -3 "$file" || return
	# TODO: Replace with appropriate checks for this patch
	# (e.g. checkpatch.pl).
	true
}

validate_series () {
	# TODO: Replace with appropriate checks for the whole series
	# (e.g. quick build, coding style checks, etc.).
	true
}

# main -------------------------------------------------------------------------

if test "$GIT_SENDEMAIL_FILE_COUNTER" = 1
then
	remote=$(git config --default origin --get sendemail.validateRemote) &&
	ref=$(git config --default HEAD --get sendemail.validateRemoteRef) &&
	worktree=$(mktemp --tmpdir -d sendemail-validate.XXXXXXX) &&
	git worktree add -fd --checkout "$worktree" "refs/remotes/$remote/$ref" &&
	git config --replace-all sendemail.validateWorktree "$worktree"
else
	worktree=$(git config --get sendemail.validateWorktree)
fi || {
	echo "sendemail-validate: error: failed to prepare worktree" >&2
	exit 1
}

unset GIT_DIR GIT_WORK_TREE
cd "$worktree" &&

if grep -q "^diff --git " "$1"
then
	validate_patch "$1"
else
	validate_cover_letter "$1"
fi &&

if test "$GIT_SENDEMAIL_FILE_COUNTER" = "$GIT_SENDEMAIL_FILE_TOTAL"
then
	git config --unset-all sendemail.validateWorktree &&
	trap 'git worktree remove -ff "$worktree"' EXIT &&
	validate_series
fi
#!/bin/sh
#
# An example hook script to verify what is about to be committed.
# Called by "git commit" with no arguments.  The hook should
# exit with non-zero status after issuing an appropriate message if
# it wants to stop the commit.
#
# To enable this hook, rename this file to "pre-commit".

if git rev-parse --verify HEAD >/dev/null 2>&1
then
	against=HEAD
else
	# Initial commit: diff against an empty tree object
	against=$(git hash-object -t tree /dev/null)
fi

# If you want to allow non-ASCII filenames set this variable to true.
allownonascii=$(git config --type=bool hooks.allownonascii)

# Redirect output to stderr.
exec 1>&2

# Cross platform projects tend to avoid non-ASCII filenames; prevent
# them from being added to the repository. We exploit the fact that the
# printable range starts at the space character and ends with tilde.
if [ "$allownonascii" != "true" ] &&
	# Note that the use of brackets around a tr range is ok here, (it's
	# even required, for portability to Solaris 10's /usr/bin/tr), since
	# the square bracket bytes happen to fall in the designated range.
	test $(git diff-index --cached --name-only --diff-filter=A -z $against |
	  LC_ALL=C tr -d '[ -~]\0' | wc -c) != 0
then
	cat <<\EOF
Error: Attempt to add a non-ASCII file name.

This can cause problems if you want to work with people on other platforms.

To be portable it is advisable to rename the file.

If you know what you are doing you can disable this check using:

  git config hooks.allownonascii true
EOF
	exit 1
fi

# If there are whitespace errors, print the offending file names and fail.
exec git diff-index --check --cached $against --
#!/bin/sh
#
# An example hook script to check the commit log message taken by
# applypatch from an e-mail message.
#
# The hook should exit with non-zero status after issuing an
# appropriate message if it wants to stop the commit.  The hook is
# allowed to edit the commit message file.
#
# To enable this hook, rename this file to "applypatch-msg".

. git-sh-setup
commitmsg="$(git rev-parse --git-path hooks/commit-msg)"
test -x "$commitmsg" && exec "$commitmsg" ${1+"$@"}
:
#!/usr/bin/perl

use strict;
use warnings;
use IPC::Open2;

# An example hook script to integrate Watchman
# (https://facebook.github.io/watchman/) with git to speed up detecting
# new and modified files.
#
# The hook is passed a version (currently 2) and last update token
# formatted as a string and outputs to stdout a new update token and
# all files that have been modified since the update token. Paths must
# be relative to the root of the working tree and separated by a single NUL.
#
# To enable this hook, rename this file to "query-watchman" and set
# 'git config core.fsmonitor .git/hooks/query-watchman'
#
my ($version, $last_update_token) = @ARGV;

# Uncomment for debugging
# print STDERR "$0 $version $last_update_token\n";

# Check the hook interface version
if ($version ne 2) {
	die "Unsupported query-fsmonitor hook version '$version'.\n" .
	    "Falling back to scanning...\n";
}

my $git_work_tree = get_working_dir();

my $retry = 1;

my $json_pkg;
eval {
	require JSON::XS;
	$json_pkg = "JSON::XS";
	1;
} or do {
	require JSON::PP;
	$json_pkg = "JSON::PP";
};

launch_watchman();

sub launch_watchman {
	my $o = watchman_query();
	if (is_work_tree_watched($o)) {
		output_result($o->{clock}, @{$o->{files}});
	}
}

sub output_result {
	my ($clockid, @files) = @_;

	# Uncomment for debugging watchman output
	# open (my $fh, ">", ".git/watchman-output.out");
	# binmode $fh, ":utf8";
	# print $fh "$clockid\n@files\n";
	# close $fh;

	binmode STDOUT, ":utf8";
	print $clockid;
	print "\0";
	local $, = "\0";
	print @files;
}

sub watchman_clock {
	my $response = qx/watchman clock "$git_work_tree"/;
	die "Failed to get clock id on '$git_work_tree'.\n" .
		"Falling back to scanning...\n" if $? != 0;

	return $json_pkg->new->utf8->decode($response);
}

sub watchman_query {
	my $pid = open2(\*CHLD_OUT, \*CHLD_IN, 'watchman -j --no-pretty')
	or die "open2() failed: $!\n" .
	"Falling back to scanning...\n";

	# In the query expression below we're asking for names of files that
	# changed since $last_update_token but not from the .git folder.
	#
	# To accomplish this, we're using the "since" generator to use the
	# recency index to select candidate nodes and "fields" to limit the
	# output to file names only. Then we're using the "expression" term to
	# further constrain the results.
	my $last_update_line = "";
	if (substr($last_update_token, 0, 1) eq "c") {
		$last_update_token = "\"$last_update_token\"";
		$last_update_line = qq[\n"since": $last_update_token,];
	}
	my $query = <<"	END";
		["query", "$git_work_tree", {$last_update_line
			"fields": ["name"],
			"expression": ["not", ["dirname", ".git"]]
		}]
	END

	# Uncomment for debugging the watchman query
	# open (my $fh, ">", ".git/watchman-query.json");
	# print $fh $query;
	# close $fh;

	print CHLD_IN $query;
	close CHLD_IN;
	my $response = do {local $/; <CHLD_OUT>};

	# Uncomment for debugging the watch response
	# open ($fh, ">", ".git/watchman-response.json");
	# print $fh $response;
	# close $fh;

	die "Watchman: command returned no output.\n" .
	"Falling back to scanning...\n" if $response eq "";
	die "Watchman: command returned invalid output: $response\n" .
	"Falling back to scanning...\n" unless $response =~ /^\{/;

	return $json_pkg->new->utf8->decode($response);
}

sub is_work_tree_watched {
	my ($output) = @_;
	my $error = $output->{error};
	if ($retry > 0 and $error and $error =~ m/unable to resolve root .* directory (.*) is not watched/) {
		$retry--;
		my $response = qx/watchman watch "$git_work_tree"/;
		die "Failed to make watchman watch '$git_work_tree'.\n" .
		    "Falling back to scanning...\n" if $? != 0;
		$output = $json_pkg->new->utf8->decode($response);
		$error = $output->{error};
		die "Watchman: $error.\n" .
		"Falling back to scanning...\n" if $error;

		# Uncomment for debugging watchman output
		# open (my $fh, ">", ".git/watchman-output.out");
		# close $fh;

		# Watchman will always return all files on the first query so
		# return the fast "everything is dirty" flag to git and do the
		# Watchman query just to get it over with now so we won't pay
		# the cost in git to look up each individual file.
		my $o = watchman_clock();
		$error = $output->{error};

		die "Watchman: $error.\n" .
		"Falling back to scanning...\n" if $error;

		output_result($o->{clock}, ("/"));
		$last_update_token = $o->{clock};

		eval { launch_watchman() };
		return 0;
	}

	die "Watchman: $error.\n" .
	"Falling back to scanning...\n" if $error;

	return 1;
}

sub get_working_dir {
	my $working_dir;
	if ($^O =~ 'msys' || $^O =~ 'cygwin') {
		$working_dir = Win32::GetCwd();
		$working_dir =~ tr/\\/\//;
	} else {
		require Cwd;
		$working_dir = Cwd::cwd();
	}

	return $working_dir;
}
#!/bin/sh
#
# An example hook script to make use of push options.
# The example simply echoes all push options that start with 'echoback='
# and rejects all pushes when the "reject" push option is used.
#
# To enable this hook, rename this file to "pre-receive".

if test -n "$GIT_PUSH_OPTION_COUNT"
then
	i=0
	while test "$i" -lt "$GIT_PUSH_OPTION_COUNT"
	do
		eval "value=\$GIT_PUSH_OPTION_$i"
		case "$value" in
		echoback=*)
			echo "echo from the pre-receive-hook: ${value#*=}" >&2
			;;
		reject)
			exit 1
		esac
		i=$((i + 1))
	done
fi
#!/bin/sh
#
# An example hook script to prepare the commit log message.
# Called by "git commit" with the name of the file that has the
# commit message, followed by the description of the commit
# message's source.  The hook's purpose is to edit the commit
# message file.  If the hook fails with a non-zero status,
# the commit is aborted.
#
# To enable this hook, rename this file to "prepare-commit-msg".

# This hook includes three examples. The first one removes the
# "# Please enter the commit message..." help message.
#
# The second includes the output of "git diff --name-status -r"
# into the message, just before the "git status" output.  It is
# commented because it doesn't cope with --amend or with squashed
# commits.
#
# The third example adds a Signed-off-by line to the message, that can
# still be edited.  This is rarely a good idea.

COMMIT_MSG_FILE=$1
COMMIT_SOURCE=$2
SHA1=$3

/usr/bin/perl -i.bak -ne 'print unless(m/^. Please enter the commit message/..m/^#$/)' "$COMMIT_MSG_FILE"

# case "$COMMIT_SOURCE,$SHA1" in
#  ,|template,)
#    /usr/bin/perl -i.bak -pe '
#       print "\n" . `git diff --cached --name-status -r`
# 	 if /^#/ && $first++ == 0' "$COMMIT_MSG_FILE" ;;
#  *) ;;
# esac

# SOB=$(git var GIT_COMMITTER_IDENT | sed -n 's/^\(.*>\).*$/Signed-off-by: \1/p')
# git interpret-trailers --in-place --trailer "$SOB" "$COMMIT_MSG_FILE"
# if test -z "$COMMIT_SOURCE"
# then
#   /usr/bin/perl -i.bak -pe 'print "\n" if !$first_line++' "$COMMIT_MSG_FILE"
# fi
#!/bin/sh
#
# An example hook script to prepare a packed repository for use over
# dumb transports.
#
# To enable this hook, rename this file to "post-update".

exec git update-server-info
#!/bin/sh
#
# An example hook script to verify what is about to be committed.
# Called by "git merge" with no arguments.  The hook should
# exit with non-zero status after issuing an appropriate message to
# stderr if it wants to stop the merge commit.
#
# To enable this hook, rename this file to "pre-merge-commit".

. git-sh-setup
test -x "$GIT_DIR/hooks/pre-commit" &&
        exec "$GIT_DIR/hooks/pre-commit"
:
#!/bin/sh
#
# An example hook script to verify what is about to be committed
# by applypatch from an e-mail message.
#
# The hook should exit with non-zero status after issuing an
# appropriate message if it wants to stop the commit.
#
# To enable this hook, rename this file to "pre-applypatch".

. git-sh-setup
precommit="$(git rev-parse --git-path hooks/pre-commit)"
test -x "$precommit" && exec "$precommit" ${1+"$@"}
:
#!/bin/sh

# An example hook script to verify what is about to be pushed.  Called by "git
# push" after it has checked the remote status, but before anything has been
# pushed.  If this script exits with a non-zero status nothing will be pushed.
#
# This hook is called with the following parameters:
#
# $1 -- Name of the remote to which the push is being done
# $2 -- URL to which the push is being done
#
# If pushing without using a named remote those arguments will be equal.
#
# Information about the commits which are being pushed is supplied as lines to
# the standard input in the form:
#
#   <local ref> <local oid> <remote ref> <remote oid>
#
# This sample shows how to prevent push of commits where the log message starts
# with "WIP" (work in progress).

remote="$1"
url="$2"

zero=$(git hash-object --stdin </dev/null | tr '[0-9a-f]' '0')

while read local_ref local_oid remote_ref remote_oid
do
	if test "$local_oid" = "$zero"
	then
		# Handle delete
		:
	else
		if test "$remote_oid" = "$zero"
		then
			# New branch, examine all commits
			range="$local_oid"
		else
			# Update to existing branch, examine new commits
			range="$remote_oid..$local_oid"
		fi

		# Check for WIP commit
		commit=$(git rev-list -n 1 --grep '^WIP' "$range")
		if test -n "$commit"
		then
			echo >&2 "Found WIP commit in $local_ref, not pushing"
			exit 1
		fi
	fi
done

exit 0
#!/bin/sh
#
# An example hook script to block unannotated tags from entering.
# Called by "git receive-pack" with arguments: refname sha1-old sha1-new
#
# To enable this hook, rename this file to "update".
#
# Config
# ------
# hooks.allowunannotated
#   This boolean sets whether unannotated tags will be allowed into the
#   repository.  By default they won't be.
# hooks.allowdeletetag
#   This boolean sets whether deleting tags will be allowed in the
#   repository.  By default they won't be.
# hooks.allowmodifytag
#   This boolean sets whether a tag may be modified after creation. By default
#   it won't be.
# hooks.allowdeletebranch
#   This boolean sets whether deleting branches will be allowed in the
#   repository.  By default they won't be.
# hooks.denycreatebranch
#   This boolean sets whether remotely creating branches will be denied
#   in the repository.  By default this is allowed.
#

# --- Command line
refname="$1"
oldrev="$2"
newrev="$3"

# --- Safety check
if [ -z "$GIT_DIR" ]; then
	echo "Don't run this script from the command line." >&2
	echo " (if you want, you could supply GIT_DIR then run" >&2
	echo "  $0 <ref> <oldrev> <newrev>)" >&2
	exit 1
fi

if [ -z "$refname" -o -z "$oldrev" -o -z "$newrev" ]; then
	echo "usage: $0 <ref> <oldrev> <newrev>" >&2
	exit 1
fi

# --- Config
allowunannotated=$(git config --type=bool hooks.allowunannotated)
allowdeletebranch=$(git config --type=bool hooks.allowdeletebranch)
denycreatebranch=$(git config --type=bool hooks.denycreatebranch)
allowdeletetag=$(git config --type=bool hooks.allowdeletetag)
allowmodifytag=$(git config --type=bool hooks.allowmodifytag)

# check for no description
projectdesc=$(sed -e '1q' "$GIT_DIR/description")
case "$projectdesc" in
"Unnamed repository"* | "")
	echo "*** Project description file hasn't been set" >&2
	exit 1
	;;
esac

# --- Check types
# if $newrev is 0000...0000, it's a commit to delete a ref.
zero=$(git hash-object --stdin </dev/null | tr '[0-9a-f]' '0')
if [ "$newrev" = "$zero" ]; then
	newrev_type=delete
else
	newrev_type=$(git cat-file -t $newrev)
fi

case "$refname","$newrev_type" in
	refs/tags/*,commit)
		# un-annotated tag
		short_refname=${refname##refs/tags/}
		if [ "$allowunannotated" != "true" ]; then
			echo "*** The un-annotated tag, $short_refname, is not allowed in this repository" >&2
			echo "*** Use 'git tag [ -a | -s ]' for tags you want to propagate." >&2
			exit 1
		fi
		;;
	refs/tags/*,delete)
		# delete tag
		if [ "$allowdeletetag" != "true" ]; then
			echo "*** Deleting a tag is not allowed in this repository" >&2
			exit 1
		fi
		;;
	refs/tags/*,tag)
		# annotated tag
		if [ "$allowmodifytag" != "true" ] && git rev-parse $refname > /dev/null 2>&1
		then
			echo "*** Tag '$refname' already exists." >&2
			echo "*** Modifying a tag is not allowed in this repository." >&2
			exit 1
		fi
		;;
	refs/heads/*,commit)
		# branch
		if [ "$oldrev" = "$zero" -a "$denycreatebranch" = "true" ]; then
			echo "*** Creating a branch is not allowed in this repository" >&2
			exit 1
		fi
		;;
	refs/heads/*,delete)
		# delete branch
		if [ "$allowdeletebranch" != "true" ]; then
			echo "*** Deleting a branch is not allowed in this repository" >&2
			exit 1
		fi
		;;
	refs/remotes/*,commit)
		# tracking branch
		;;
	refs/remotes/*,delete)
		# delete tracking branch
		if [ "$allowdeletebranch" != "true" ]; then
			echo "*** Deleting a tracking branch is not allowed in this repository" >&2
			exit 1
		fi
		;;
	*)
		# Anything else (is there anything else?)
		echo "*** Update hook: unknown type of update to ref $refname of type $newrev_type" >&2
		exit 1
		;;
esac

# --- Finished
exit 0
#!/bin/sh

# An example hook script to update a checked-out tree on a git push.
#
# This hook is invoked by git-receive-pack(1) when it reacts to git
# push and updates reference(s) in its repository, and when the push
# tries to update the branch that is currently checked out and the
# receive.denyCurrentBranch configuration variable is set to
# updateInstead.
#
# By default, such a push is refused if the working tree and the index
# of the remote repository has any difference from the currently
# checked out commit; when both the working tree and the index match
# the current commit, they are updated to match the newly pushed tip
# of the branch. This hook is to be used to override the default
# behaviour; however the code below reimplements the default behaviour
# as a starting point for convenient modification.
#
# The hook receives the commit with which the tip of the current
# branch is going to be updated:
commit=$1

# It can exit with a non-zero status to refuse the push (when it does
# so, it must not modify the index or the working tree).
die () {
	echo >&2 "$*"
	exit 1
}

# Or it can make any necessary changes to the working tree and to the
# index to bring them to the desired state when the tip of the current
# branch is updated to the new commit, and exit with a zero status.
#
# For example, the hook can simply run git read-tree -u -m HEAD "$1"
# in order to emulate git fetch that is run in the reverse direction
# with git push, as the two-tree form of git read-tree -u -m is
# essentially the same as git switch or git checkout that switches
# branches while keeping the local changes in the working tree that do
# not interfere with the difference between the branches.

# The below is a more-or-less exact translation to shell of the C code
# for the default behaviour for git's push-to-checkout hook defined in
# the push_to_deploy() function in builtin/receive-pack.c.
#
# Note that the hook will be executed from the repository directory,
# not from the working tree, so if you want to perform operations on
# the working tree, you will have to adapt your code accordingly, e.g.
# by adding "cd .." or using relative paths.

if ! git update-index -q --ignore-submodules --refresh
then
	die "Up-to-date check failed"
fi

if ! git diff-files --quiet --ignore-submodules --
then
	die "Working directory has unstaged changes"
fi

# This is a rough translation of:
#
#   head_has_history() ? "HEAD" : EMPTY_TREE_SHA1_HEX
if git cat-file -e HEAD 2>/dev/null
then
	head=HEAD
else
	head=$(git hash-object -t tree --stdin </dev/null)
fi

if ! git diff-index --quiet --cached --ignore-submodules $head --
then
	die "Working directory has staged changes"
fi

if ! git read-tree -u -m "$commit"
then
	die "Could not update working tree to new HEAD"
fi
b64bc1e78a1abe100633259c2f30bcf90ed1683b
DIRC      g>��/��g>��/��          ��           D��w$����PzP��;��N{ .gitattributes    g>��/��g>��/��          ��          ��?�9���
q��rf�y� LICENSE   g>��/��g>��/��          ��          :Ӟk�O�t����>�3�`e�� 	README.md g>��/��g>��/��          ��         ��U��Մ����:�ȼn� app.phar  g>��/��g>��/��          ��          ?����ª:\�'ؼF�y� build-phar.php    g>��/��g>��/��          ��          	���ۀ"�Ჵc�d�ݢX�" 
engine.php        g>��/��g>��/��          ��          1�]7�5~.[���)$��M� 	index.php g>��/��g>��/��          ��          V��e�J��r����UW��, make-app.sh       g>��/��g>��/��          ��          �u=�)}qǅ�;����%�H phar-stub.php     g>��/��g>��/��          ��          �����l�4�g�ĵ�|؏�� 
styles.css        g>��/��g>��/��          ��          !�͎�	��f�q��Ŏ��I��S user_script.php   g>��/��g>��/��          ��          !]�A�=�2��|��M˽_�~�+ view_balances.php TREE    12 0
M��%� ��g��Tä�@Or�pC���SaF�?E����Initial Commit v0.1
<?php
$home_dir = getenv('HOME') ?: '/tmp';
$data_file = $home_dir . "/family_data.json";
function load_data()
{
    global $data_file;
    if (file_exists($data_file)) {
        $data = file_get_contents($data_file);
        return json_decode($data, true);
    }
    return [];
}
function save_data($data)
{
    global $data_file;
    file_put_contents($data_file, json_encode($data, JSON_PRETTY_PRINT));
}
function modify_bank_balance($user, $bank, $action, $amount)
{
    $data = load_data();
    $user = strtolower(trim($user));
    $bank = strtoupper(trim($bank)); 
    if (isset($data[$user][$bank])) {
        $amount = floatval($amount); 
        if ($action === 'Debit') {
            $data[$user][$bank] -= $amount; 
        } elseif ($action === 'Credit') {
            $data[$user][$bank] += $amount; 
        } elseif ($action === 'Set') {
            $data[$user][$bank] = $amount; 
        }
        save_data($data);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'modify_balance') {
        $user = $_POST['person_name'] ?? '';
        $bank = $_POST['bank_name'] ?? '';
        $balance_action = $_POST['balance_action'] ?? '';
        $amount = $_POST['amount'] ?? '';
        if ($user && $bank && in_array($balance_action, ['Debit', 'Credit', 'Set']) && is_numeric($amount)) {
            modify_bank_balance($user, $bank, $balance_action, $amount);
        }
    }
    header("Location: view_balances.php");
    exit;
}
$data = load_data();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View and Update Bank Balances</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        const userBankData = <?= json_encode($data) ?>;

        function updateBankDropdown() {
            const userSelect = document.getElementById('person_name');
            const bankSelect = document.getElementById('bank_name');
            const selectedUser = userSelect.value.toLowerCase();
            bankSelect.innerHTML = '<option value="">Select Bank</option>';
            if (selectedUser && userBankData[selectedUser]) {
                const banks = Object.keys(userBankData[selectedUser]);
                banks.forEach(bank => {
                    const option = document.createElement('option');
                    option.value = bank;
                    option.textContent = bank;
                    bankSelect.appendChild(option);
                });
            }
        }
    </script>

</head>

<body>
    <div class="container">
        <h1>User Bank Balances</h1>
        <div class="form-inline">
            <label for="user-filter">Select User:</label>
            <select id="user-filter">
                <option value="all">All Users</option>
                <?php foreach (array_keys($data) as $user): ?>
                    <option value="<?= htmlspecialchars($user) ?>"><?= ucwords($user) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
<?php
$total_balance = 0;
foreach ($data as $user => $banks) {
    foreach ($banks as $bank => $balance) {
        $total_balance += $balance;
    }
}
?>
<table id="user-table">
    <thead>
        <tr>
            <th>User</th>
            <th>Bank</th>
            <th>
                Balance
                <button id="sort-balance" style="margin-left: 10px; padding: 2px 5px; font-size: 0.9em; cursor: pointer;">
                    Sort
                </button>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $user => $banks): ?>
            <?php foreach ($banks as $bank => $balance): ?>
                <tr data-user="<?= htmlspecialchars($user) ?>">
                    <td><?= ucwords($user) ?></td>
                    <td><?= htmlspecialchars($bank) ?></td>
                    <td><?= htmlspecialchars($balance) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    document.getElementById('sort-balance').addEventListener('click', function () {
        const table = document.getElementById('user-table').querySelector('tbody');
        const rows = Array.from(table.querySelectorAll('tr'));
        const sortOrder = this.dataset.sortOrder === 'asc' ? 'desc' : 'asc';
        this.dataset.sortOrder = sortOrder;
        rows.sort((a, b) => {
            const balanceA = parseFloat(a.cells[2].textContent) || 0;
            const balanceB = parseFloat(b.cells[2].textContent) || 0;
            return sortOrder === 'asc' ? balanceA - balanceB : balanceB - balanceA;
        });
        rows.forEach(row => table.appendChild(row));
    });
</script>
<div id="total-balance" style="text-align: right; margin-top: 1em; font-weight: bold;">
    Total Balance: <?= htmlspecialchars(number_format($total_balance, 2)) ?>
</div>

<script>
    document.getElementById('user-filter').addEventListener('change', function() {
        const selectedUser = this.value.toLowerCase();
        const rows = document.querySelectorAll('#user-table tbody tr');
        let total = 0;
        rows.forEach(row => {
            const user = row.getAttribute('data-user').toLowerCase();
            const balance = parseFloat(row.querySelector('td:nth-child(3)').textContent);
            if (selectedUser === 'all' || user === selectedUser) {
                row.style.display = '';
                total += balance;
            } else {
                row.style.display = 'none';
            }
        });
        const totalBalanceDiv = document.getElementById('total-balance');
        totalBalanceDiv.textContent = `Total Balance: ${total.toFixed(2)}`;
    });
</script>
<div class="update-section">
    <h2>Update Bank Balance</h2>
    <form method="POST" style="display: flex; flex-direction: column; gap: 1em;">
        <input type="hidden" name="action" value="modify_balance">
        <div style="display: flex; gap: 1em; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 200px;">
                <label for="person_name">Select User</label>
                <select id="person_name" name="person_name" onchange="updateBankDropdown()" required>
                    <option value="">Select User</option>
                    <?php foreach ($data as $user => $banks): ?>
                        <option value="<?= htmlspecialchars($user) ?>"><?= ucwords($user) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="flex: 1; min-width: 200px;">
                <label for="bank_name">Select Bank</label>
                <select id="bank_name" name="bank_name" required>
                    <option value="">Select Bank</option>
                </select>
            </div>
            <div style="flex: 1; min-width: 200px;">
                <label for="balance_action">Action</label>
                <select id="balance_action" name="balance_action" required>
                    <option value="Credit">Credit</option>
                    <option value="Debit">Debit</option>
                    <option value="Set">Set</option>
                </select>
            </div>
            <div style="flex: 1; min-width: 200px;">
                <label for="amount">Amount</label>
                <input type="number" id="amount" name="amount" step="0.01" required>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
            <button type="submit" style="padding: 10px 20px; background-color: #007bff; border: none; color: white; border-radius: 4px; cursor: pointer;">Submit</button>
            

            <!-- Banks & Users Button -->
            <!-- <a href="user_script.php" 
               style="padding: 10px 20px; 
                      text-decoration: none; 
                      color: white; 
                      background-color: #28a745; 
                      border: none; 
                      border-radius: 4px; 
                      cursor: pointer; 
                      font-size: 14px;">
                Banks & Users
            </a> -->

        </div>
    </form>
</div>
    </div>
</body>
</html>0000000000000000000000000000000000000000 b64bc1e78a1abe100633259c2f30bcf90ed1683b maxdarwin <72539638+1darshanpatil@users.noreply.github.com> 1732177662 +0530	clone: from https://github.com/1darshanpatil/My-Banks.git
�tOc                                                                                                                                                                                                                                                                                	   	   	   	   	   	   	   	   	   	   	   
   
   
   
   
   
   
                                                                                                                                                                                                                                                                                                                                                                                                                                                                           JxΑ��a�K���Ǵ�g�����ª:\�'ؼF�y�u�J�}Z/�7~�v�A��T�F���W*��iu�;�	i�'�����&/��~J<{��w��.ڹ��G�u�V?���y51&G?�9���
q��rf�y�M��%� ��g��Tä�@OU��Մ����:�ȼn�`/^ov��I���_*s��x�g��#�ӡC�I$zh�|s�s4�?��3	��ܼ
�s���t6�24��4�4��ͺ$u3� {@���QML�9=�V
��u=�)}qǅ�;����%�H}��/�{�u67�Qߝ���b�C�4�j�k����<�A�=�2��|��M˽_�~�+�K���3%�/0���h;��%�?(n�$�%q"�;N+�m4Fj76z_��>a5Y�����ۀ"�Ჵc�d�ݢX�"��e�J��r����UW��,͎�	��f�q��Ŏ��I��S����l�4�g�ĵ�|؏��Ӟk�O�t����>�3�`e����w$����PzP��;��N{�.�L���$���j�k��]7�5~.[���)$��M���z)Ԅ՗�#>D1T噛�2��ק1.�7���s'GMu�{h_OS���a3� {��3k̯��3c ��`y0���UU0��_
�A�7�<[w=��uX��A�_�y��,-�� �0	�8Z%\��$l��ՠ}���3��� &� 8 ) !V  � '"   �  *  n (�  +   � 0� l '�  
 &�    '9  � ! / &� #� �  � '� � &��!�(+���`m0�r�[��q��a<��ລ{����ƴPACK      �x���K��0�:��#�eɁf;����������C��բ
�V�F���3��)�q@NY�n�ci�.>����L%CJΑ���!K#�x9DçN[��
ןy��z�&.��c�ug��_�zt�V��?�k����-w�3O��^\O�4�̪��[s��
�:�>��_�W"�x���Kn�  �=�`?jdp� �Fsv5D��޾9D�o�zc�Q�)܈p4^��@|�$�Af��R�kV{	�8Jc$�1�K��>L9(��|4��O��������qz�[Ι�J}Y������q]�ϥ�W򱽴	h�uN�Aݺ-��?��J�r�_�A��� �:XԜx����m� @�;Up_�#e�t�b$#��l�q���ן�Y`�d0�`�C_�`kA;�#0!�N�۔�� �s`(�W@a�bu�)&�!
��z��o��S�|���Ax�[ΕZ�Y����q.�ܷ��]�z�%����6N���@�[�:'�sV�<�`�G�^ϯRd����emU������]��x����J�0��{�"'/%�d3,��� ���Ifma��4E}{{�����jцx�6IvQ��9y�	�IȞ)`j�"S��!˱Mdm�WFr(��s{�p��,����E����|�>�=�\{�]֞���p;o�����"����j�q���^:�{���Q��C���[��d�����C����;�'o���kƬ~'�]f�x����j�  л_�}!�L��R詟1�c#$&���}�~C���z�,���&;y�#�`"#�i`uP��5g�p�'���c2�Q�E�fJ�MȤ�����F߉ڳT����q�ٗ�ՃzY߯S�9Խɱ�_�/q���hܬoơQ/�J��ϭ���Z��߯f��� Y ��4x�����Q��(5U���������<�� �<������$�$9%���8%���� ��$9yb���������� ZA���؀��3/�$31G!9?77�� _�x340031Q�K�,I,))�L*-I-f����Ee��������~�կ�������/ؕ���%c��s�
�)J{��R�*TI������^n
��y�g�����9����	���C%�d$1��|���M��Y�l'���ၪI*��I��*-`>%����C��bf�����v��:Tej^zf^*X��U���nښ,t%���E_���2�RR+��>ƚ0�Ӌf<������%�R���r�SuA�+�`8(�œ���੢��ٷ}_|J����T�*���$�y��?4k��r����F�]�K�cP�K*sR������ݞ�>y)\k����ϳ�gsf>��*-N-�/N.�,(x�����i�
����w����`�Ҳ�����Ĝļd�����������ѯ�5��|O�[�H �C�n��+x�  �����m����l�4�g�ĵ�|؏�툓�X}(�x�SVp,-�WHI-IM.Q(I�(QH��I-VH�KQ(H-J�/�U�qS�҉9�U�%��y\Z`���@�\ 
�n��>x��}w|��8,#�bC,+�6��0$BR@D������β��|>��ņ"6Ŏbǆb���D��+>�wι�N������������d�s�=��{愁�q#���¹j�S�tDdi�H�����	�m����JH�̒+++�_P�6�h��ȒO�d����x4,���Vȹ�r3>�ZP5d�U}�`�#F��n��a���6�޸�eka�)͓��%Z^R"�Kf���D෌�
I�"UGU%�ʊSC=�D��:��euv,��br�C�}z8��c���oQ�+��"5ZT���n��]���`m0�2G�ȅI�pҶ�3�fi�L��2�զ�֌�������1��n9����-Ǣq:�#�k9xJ0h���!@Y��:4�,�K�NZ�+�]r2��i���݄�!�9�D�Rm���:t�E�púT/(+1�#����u��ЍXyY^^ީaW�Q#��g�����eg9;&s@\b;����tK��:�0=4|Q-���1Ĩ�{�Fی�x̯w���/���L��7T�\=�&��]m#�XK����h@v)��O��F�*�v�_u�'��U�����ki�n��詫mG��-�ԣG^�=�{�8 �_l��C�j�]��Ud��=z�?nD;~>����A?�g�llt�>�~���E���_������6�|�?_���V��`���Rq����yr٩U�)fĺ�(�����X+�\���rѪ7�#�3bq/�΁���6��n������fBmN���s^~���h}��?���*�b-��ҥ��9�ZL�Ţ�7S�Q=XK�,�>�}�� �2N]@k��7�Ϯ�s��JD3�{P��[R�����
����J~Q���hXAQ��T����
�yyť�Êو����^���[�[�#��}����������"����T��x�؈������ҏ���

��T�_((�/+Q_A�W-(.�/(�yĲ"��{	G#~>�����#��*p��"�@�P�y�Jq^���

�jY��H-��q<��	�o�O;bAi�<��;��k+) �
K�"%���W���JJK�W}����Co��ʹ#��s%�?�� ��a�aJiqaIai�,��8��/+�W�������:��1�4��D-Q��a~@]��-�+VZ(���F����j�9{�����������a�y�ޢ<�T)VV�_�/��}��
����<�����a��ŗ�.���@Y��R),��8Z�S|�ŪZ6LVP�+)*���5~�t�kEz�	�*��[�WPPV��{��%��������|��W
��Ek����w`�F,����� �>^��P-�/,.��޼Ҁr5_5~Ώ�*Ҏ��疩���a�#ޒ�R�_V����T?�W4�W�����F���/�2�jIn��˃�PU�ZZP�ST�QTo��1*�|��hja)?G�1�I;b ?��_X��+U�bo^�/�����[(�z��ȟs���]�+NO���>%�0PT�[
�NQ
 Io~iA����+*����;8�s�Y;
ٸ-�8X��~���'�w�h��z�:�����xc��\?0���o7h���j��_>P�<��2���`PFnH���:":�U&�@�����3Z/m�m;t}&��
i��ўc(�HP��.���/�-u�HT͎�^�Py?�a�~����E�A�~�
����T���R�_.������w1/�����e+~�����Ov��!�Qb��Z?���ϳ~=0�#��5Ы��p����;��������ݢ�q�p�SA=�e����g�*���1�����'돟�+�K71�����k8U�絽~yJtt%CR��	����?kF����7�{�=U����?�o$n�^��B������D�~�^�5���u���ݿ�K�F�%;�g�:T�L=.��W�s�~|'z.z'��,�Q�,:�����h���S�����8@�:L��w�������2�y��|P�|��+"v�ө�]m^%��}�]���@f����uKDcf���C*i`���kf�؆	�`��,����| Jj����#�rJHvÌ�m�*�4CG��4���'��h� �lZ�ڀ0�;l����hf
��ޡ�l��h��ͯ�t��ڙ&$32lM�N#��\��t�l�qV�m]QП�A5�D��c5s���`��$O�D7[��/i\sC}[cSmK���Է�V���f��f���Ȉ�hT����J8��d�4�i���2Gn�F�� G�hH3���z�Z��e�����i�I6T*~��3�Or��5�������hL�]j4,��s�,k�j�!g��Ѵd�r>�I�d�I"�]�����p��[D������Ģ�yRu0��đ���h3՚ۋ��^�Hu��q�6s�D��A��ab|b���u̘������X�nNȳ�$��LuN�۽�꜃�b��Z\4�S@*�ޙ17��bW�&lɵ�G��.v���sWl��-*w��i4�!�uՐ�˓���&�S������"�}�AU|2\Vyg��Cҙ��Sj���&��Md,Krvg���5+��SS���'�1|`MCu˔�Z�#
����öW�԰� p�1<���}J�����2:��e�[_�B�-�Gc.���tui�XG�_��|j6��5�44%�m���Z���'��i��:��@or�/������v5��e�Y[r=�0Q����	)�v-\.vQ�D@�i������	*��r ��v>�P���X�������|��f3��\��²�@�aC!Z q+�GD�:a��Q�
���j� �\!��k��x�.-�c�LUVg�A�3"
�ѐ�t��������(;��GfˆƬ|���#X�W��j�_Vd�8%��T�u�jX��;Hl��|��2
��Ƿ���T��Eӻd#�c��0
\#���)��x������\69���`L}�<������NnlU穖��܁��$�Ox�
�r�0y\<��yy��$W�nZ��Y�E_ʣ��*7�Xؼ�h`p"��[��}9�p��`�r�h{.,��S�vUȚ�T�XL��v��� �r�m�0`j�!��������ǳ䖡=h�,��Z�G�
�D�?GJ�^�iN� [���LhS�j�1���:>#�� )� �b"5pL����蠄G�`ORh�K��4r�$���C`��)�F0��ca�e|�W�=��%�	��(]J�ܭǣ�cl�lt��-*Y�M,-�1���5�~~�O�q8�8��4#��:=��X����V<�3 ݈Cخ(z��r��,"fpd=�>0���=��Aik2QP�*Č:B��`fC�u)�n��> ��.?�DD��� T��`���e�����B���7`	�N�0�~]�����Dp&<n|�닪5E��q���¥H�s6��W�ف�X�Í�:�NF"6��Dv ���3�vG���!T�`H`�FG�ۜB�5���pH��z"
$=Z�(u}������F����w`�1�p�0Ɗ%���7�i73�w���ɲ&����c�όʉ��a��0U;��0��m���=�E�1YG�S1f�Gt:�ѨJ���*��촎�qS$���� �8H�W����hN�Kv,�qz-�D��H����X��ʓ
!��5fF�X�l�w	��n�x7Ʒq	��i�:�r@���<b4Z���@2��'�d���2���O�@�л��[��l�ǰeR%�S�bet �esB�e���-1�o� �SPGPG����c��u��L�C�uu�T��Rf~���&|�p��"egd΁E0�B���Ԯu
����,G��n��p��9���N%sU4/gyb9�i��D��(�?u6(���%�Q��g`�Q�%��a�N��&��1�O�J��5]G-�r|�US yUT�g�W�!1f�w�]d`iğALEz�1w�<t=n�I20H�ܑh�����֬�i�/Fn��%���tO1y��h<,%/#�pc�O��L	@��jR�� �p��t�N\e: e&�O0!luا�"p8�aEC ��Ť&�69��33^�=�0�O���܄-���#��|�(*l2��2u�c�hO@�~0
A�Bf���` �}��)���-��x�!����v�L�Y���F�"6�w �d<�kc*�W�� f��D�D4��[F���u	�
������H�R�*�S���=q�@w�$ɂݍ�:�*!��I`�L����>����.�6"3�A�h�'�i)A�yL�(�	��t�:��x�o�ߢ�0p� �J����5,ݏ�Rg�#�h��	�0j0u��F78���$�Q頣٩k~F� � ���4����GbZ��p.A")��o���DB��s�1%ڝ�5�	�~Y�w\p#I��c.}`*q�Mk���`4g#,������Ҹt81�׏L������x%�>Ҍ�)�Fz[���iB�\U_#W7��xZ<���8/�Y�����Zl2���S�_q�
�s�Vg�f��)�!U�U��.;���.�יJ9m+�,7g-@�jHC$�1��Иi­��G����:�9�Bu}n��y&'�$�����7a���[n���] r]���;�����e)5.������ ^����6G��d�b"a�1D	˙�OT��J�e]��~���}$82@�с[�&�tK���7�0`=��	)�hǅ%P}L+���JNCZp�sq�$�4aW�6H���d_aC��ފ�Q%�|:�m�;G��q��t��9�fۆ��%�G��&��t+�p\���'2!+��G�

�)���cn�^�@b LG��� ��"i�t�?�Q�NZ8��A�ANpğ|���#8��g�l���q��yI0I�T��)*�Z��4tܳF�N$���
c�|Dr�LZ,Ǘ)ۙ
x�0�NE�Ly�"tڙ��I���#9J&m��Nf~���R�As' G�j"��9�3ϵs	��0Nχ����YC���@��X�@:CХ0�3-U!���u)I1��v5������`�4w=1�3�f��<�*������;k�iTE�|���#}�^G��pI�&"�Q3w��)lư&$*��*�k�!�� QnEh_�33w�9�Ena�ߴ3�l3�8�v��sN��	�ӆ}���Ud�x@m��`b��4�k1f!V�d��8��.�1���b�� 9��} Ik0� �e�!Z$��($i`��Sl�5�'6�f�.�8l�A���B�JF,2F�Ga"������F�S�|��uqS�Ύ�Z�N!�q�8�����b��~X��C��@�w|x�l���f�Ġ���6���D��G ��nC$;��!k��S�0���~�) zP%<�z;�<�[40(
���@�OaZ�9���;��It�}�bz�B�ŕvt��xz�Ђ�LSB:��,\Z6qV�^��5�y�*��\L:r�l������Vɔ��
I	�=�r��T����z�°1��� ���T�����H�v��M��i,!W�T���K��tƽY�:b���+W�-����L��>�����/'m4
�-�IF�@��@a��r!"�c#��pq��#��� 'U8�u52̈�S')s&X�jY|�L���5����3MpFy>�E!!�K��AwJd�@Ƹ�T���fz	N�ը0�Yi9�Y;8Eֱe��@��c
�Qh�e~>�rF�`'�sL"*��`PJp��Jf���	�<�xNk�Ħ�0�>�du�j�����IA.��)^���g���c�.�Z�(̀�8sb�CJ<���D#3��L	��X�H�	�T��֜M��M 2�e� 2�J���<�ڜOk�}�L�oS$L;�_K3T��D����w�=�{�v�"W�$�A�q��(]wX	a`*�-�0�Ռ��D��
Lk@B����vnI�S�����B	
(|�aaĒ��H!���e�;�(`�p�W�Txe.~;�j�p�Fr�EUq�����Ȭ���Il�]��<��|��g�C++ȑG)p�F+)�	p������x�
�x,�8�=��IrD7
?��Q�Ut��h��+��%����ԘpI���a��
h�� 7y<�B���aޒl�q����ٮ���h)Y6$��oo�$5��l$��J<rZC�!n��bx7�8�5x��@`��.0��U�2I��`�k,���&��N%��a�����	i�)�jr�\�n	0���-��-��rmڳv7�� �G
��&��;�C��c ������+�	��f�Ә�#�0>�����:`�d�9uY��a0�pG�b�D�y�E�+���a�-sǑ�RE�d2��aI� #ш�Ciz�vA��y36�aX�F!�.s�6�3n�>;�	�&������#A�U;�`���7}�|�;��7dZs���!vd���|d,�����2T��p�����d�աE���D��&޸�Ì����/B; 5|G��j��Cbȱh������L�"�)�|�
���8��#'������zv���#"�����(obv4��
�Uv5��~`���zݱy(J�D�(�A���b5&�b���u���ގ�lK��lN!8�r i$������ۣ1JX~�A�=�6�C�>����|nrA�\hy�{��a%x�$/�T�$"H���ɓ�@���5V�;`����ł�D.��,1�R��W�8�g��Ov�LH�ptE�!�1TP[�>����⑈،��R�e���}A���J(�&�E	2a8�V�t���,��N_�a�dDKG�ۮ�n�fǝ�T�����fpd��L�4)56i��rl�v��Ϫf5�⻛��eV(`�9�p�4L�H�M�) ���a���l:lD��gAY�[n,� 0:��)������U!�T��(a��g,�T�J�?�n	=(B=�4c6~n�c*mT���ZAFJ�] ��x�r���wt�>�
���o���>0h�ov�7��H�݃�P��UX翣0��j�T$$qp��`�#�RK�d�(������Nl�n�5�I�@{��=�I�*�6c�ͭ�l�*D'�{N1;�
�J�� ��(��0���4���]�����E�+�����ºmNƔDif� �XZ<���D��:1Ŋn౹���\m�Y�<).�9�N�]R����r\�0�BU�V!���j�����*ypD���4���˲r��K"�_Դ�m�8[���E��!�����s��j�LŊ�%��ERcn�yL�&�`��g��LD�܃���n��,J�F�|�ڕ�?�y'�k�$�n�'�"%T9d,�GQ�fǥ�Vm��J7��[F�aq���NX���2�������E��psɲ?S/̉;c���+�=����6�R����%��J��/��L��;�L�ga2���U�>2|Hg�;������ԡ�0���(�_�`�A8&�N7�����Y��'GޑC�!�� �W_DH�[��!���<1��n4����t����T�8Q B|�G
U�bK.��	㶚��B->fآԖ��K�T3�,+ p(Nz��<=Y��%��e�����=��dK�}����Y>M���mG��]{�b��� "�)���zPV�8��F�:%)Ʀd�H�$���_�V�z!8�@;٘E</�G,a�D���SX�+0�H�6�Kp��b fH��(���m��Ӽh�L�?mk��F�ܤ�"JX~%�%R����L[Qd<��gbt6 �`���� �%��Xa	y�h�_]�Z��0��2q}�����_u�J��nmM�����2a�*�R�flJ&s,1���P'0��1nd
)�E7�4��LJ�e�`*ӻ��2	o��8D\�J�|t���B��Ӄ[DHIs�R<��l �5��g�a�p��bN���1��X�/S-&�d+�����~T��aa��ֹ	bip��m��i]ڷ�gt�6,�y�d'�Z�Ю�)ALeUH���Tb�b��S�̘9�!u�`�c�eX������=�=5�L���Ǵ#�JX�PK��^���{�5FǙ�G?�̐���4�A��Ĝ}�YL�d��Զ]��s��E.2j�.ӗlr� vo5e�AFLP�z7W���,`�XJ/�	na�!���H�]wZRb�e���!�E��>�y�? ~�h��9�Y41����D.���&�A�&�Ƭ.JԷ�Ø7<;f*�U
��R�Q��X�0-v�M3�4#�H,�h첻���V87����Lc��P[��Ć)2�����̢͆Ú4��QӞ�8�#��"4��ҿ̔?�a!�BSQ3�RR	�]�H�36�Cp
u���We�6@�o�V�	��p���ml��M	f!�t2�9m ���A
��C�\��/I}��p8���̓�5�~g4%��Ґ�Ru#��.�&�)wЈ���AM��cf:I1�+J���L߁�c���̴��U�d)]�v�5������+Ò�"rl��I8��jpq��|�aJC�c$��� �P������"S{�xڟc�nɯǽ�@<H�R�u��у���S��E�<�vq�ƞA%n7X�r�l)Vh��e�Q��j)�!]QgYtX_B����fەw�[Bč��݆��e�: 
]��n�JxF@ɶH��N|�lD�	 ��	˲#�0��T#S�=r�Y�1�a`�"Yz
u�i�*�"�0p�a�t����� mi����m��F�!�ʄ���f {�S��"=�~�l�!X��7�H>Տ�7��3��j7C/c|�5�`�~�U'r"�|!5ŵ�d���s �HR���;�Fz�Nu��^!Ɉc���(fx�1����x�
��Ze<�Ĵ$�%�B��R�U��������Phӫ���!�x1�%��$QO�D'�J�+V0}n��t,�g��	�۴��c���i����ff��CELe;�<c$`��Z�~Hp�&����j��3U;�_Qcq-�m���)U%3�{�	�A��MxO8V��"�����H%W�W�۽���tg���y ���6==���:�a.�p��: ��@,�B��XP��n��J�I~�i��S➙nfw�JDw|@&;�&d�iKv�mvT��'g�)R��ه&=ꎔ�.�GDЬdˍ�:�ֱ1��-��IWnNJRzLj�v7(

� R$apu߯�[�,��8����`�L��L?�2�%C��"vo���,����x��x����Nٍ݇.���:���>O���Y`\!�>m�r��g���n&Qg�'�tY8��`�
�����3�>aXJL��+�.,G`�� ^C�B�Q ͈&�a�P��<��[Z���,#�2-�p��l�����H���� ��|�$���v�4��q؍
v	���*��U�سBn9Rj ��
�@�X�H�`11� 5��a�ܬ�Ơ6��4�du�#ˑ�a�g'��K��Ym$锔�K��-���9�fܖ_����	$Uފ'I���yc���R`AT*iG��]_���C0y�	 ���+H�ÜU�Rcp
���� ��<]&�4"����%ds����>C�Da��4T'�fV�.��]�F�Y��.���L�,+�@.)��'8St��1�����I9��(|(J=��7eއ5�ۊ�6�M��&
��؉qVTF$�a@�@s� W�-ad���J��icg�Q8Ӕ����	IdM���oa̋��hB�0}R"�Y8j�9���i~I"�c� D�yݔ̖h�)��+<6�3��i/,4��eVd�م9`�F�o1)�J������2Գ�j
3����/�����b�^;ٮ�M�֢Y�u�6M�
Q�\�U����l�k{��{h�a �Y~�Z�?6�o6���jHLT����g��S��N�6� ؚH��4� C&[����
V�{֘���
#�8�a��jΌK�	~kހ��0�
;�ꬕ�
��-�Y��ng�rgñ\9SܲM�F�y��N!��E���b���i�	�h@�:�mo�%'KJ9��.��i��5LȥD�y;�q��$��l��� ������%3��\;?��?1"3��r���L �S�7z�t�X�=�z� R�%���.�MaƢP89�B,���,� �n��n�T�΄O2�m�f����r���GN�]����T��"J��mAy�}Z[�<gd{���6�a7�p�:y�N:��>
���I@��6��J�,jf���f��䦔@� w*$���;�;����0��#����E����l�GO<Qn�P�u�������4#�Q�M1lF@��| H���_.�#�� x�r�@���a����h��T����
C�i���� ��������3���$���H���L5ʗs޲����*Z�j���۳��P:�Y�1�*��<,��R�Y������c�-)��w��N%��N�"Ƹ&�̚�,�jsU'*�2��ȿ��,�TBY@�{�ɡ�J0��U�KV��B��b�u�Vae�Vn\����(�c�����R�:����!�0\�'�I�	��N�}�D'�m���������5%-I���h�a[�����َkLOhQ�l�B�U��n����i)Fܧe�i�e�I��Z�|q`�F5�[hǯ�3> ��i83��s���4�99�[�:��1��W�@m��2"}Ü���I>�9B���i,�șs�y�E̾�6
pۮ��Xp��Rݬ�othY	�)e�˨� Ά��/BW�����(�e7��K��I{p��.s%J�Y�� &��sd$Y���>��������rH�|R�yB!.�I�4�M \������M��M�n�Ē�7�-u��' #�f'ҙ~�J����k�*���,GVp�v�EEKv[/�&8+ɡ3ά�î2$']0u� �+���p�t�Y�!�r��|�	W�k�.�h,_�&_��29O��VΨ�C�
>e��d��4&��"����Ǚ�
+�Bsq� �ˁX�Y��I��YמؽL����B���:���XUXv��'+��b�="dƜ�<�&+xe/��T0GY?��X��e݂�(�P�S<���61ʱ��"���J�1�1������:��΂D1V�R����m���e�`r�� �v��Z�\�7`�l�Π��~�E��0�+���XW�<q��e�45.P��q���RL�W�6Pg_�I�i`BuFJ|NI������ʟ)��@ S���fno#�IaB"�Ư��τ+�(���{:E�Q���}~��buݨޭy�L��б�[,�p����m_1�� �n��{*9��)��ͮA����T���>x�4����#^�)꼱Ű�V�ͤ��5�2�����C��Ľ^��p8����o����ȍ���(9f^G=��7	*#�)ӣKwR��	B�V��Q-�Ѫ�I�ؘ���y�VmB�"�HQ�`�i�Cm��3�8ZZ�p�h�Q*�o��%<��V��O�춒�������J�
R��o�BR`�<
�v�nP�¨�W¥��@"q���ݑ�a�D��%��p�PD��RӂD�'* ��(����Jo��ى��WZ�U���7R���oVb�p��:�(wL>Mg�!���jb&�:\jH����z��M	Sȯa����Ѡ�j�\'���q��6��$�44�ʅ�JZP^�%?�,۝N9;�V�V�b*����i�9���O��fL���
qE�'�s��I���{D��*�N��c�7~��tn���)�s�G%���fٹ�9I�U�E6_�V�ENzYC���Y{��,V��E��2�;w���va��5�Y�z��&�K���2;��*�)A}�2* 5�
2<�*���69ծ0�"�4b
Hf�t*�y��^��W�d�ۮH"��6ISHS���t�r1H13���Q[꫸ �f���9bud>������vfx�X+��(���Q�U���L�jA�%�m^�rYf�9��Α�=�H�if}lQzZ
��&�"��`����"
��I1��Ȭ�+
�H -�WA��,KI�m��D��%|.0vq0��J�ٓI�`��zhx��K�慦yPT���;�wAM��CPS;U+	��:7����������2�(\�Τ:�c|�o�U��d�ai\�ZЂ[��$ә��S�0"�����xMU@�T���B"�ׄM�h�ZE�?���dM�SP	�x���	.lF���Ź��+�)��G�p�T����Z���ʅ�G��=�M7cS��cq:V�Vg�b��n�⋑h�0�ڰ�zY��f`:	�I��b� 9�Q�[!9N�+Q80TqO)�����"O3hK��@�ǚ��A�$R�#���8�V�	�����<'�
(�U)xi�_�E�Yb>g+	5���%��t3�(in�j���8���%��xuӵ$;�$2|�N���7�,�L���;�,N�Ҿ~ӽ�J���YLx`�+�,�3�O5�yD��G0�C\�6O��l��)�J>?���	�bk�y�ԉ�.Ŵ�ݖ׽�L��Da��i"��C�emn?�����7�m�:d c$f��؄� ���q��)��LS�홓����六�r��U��#���Ƞ7s�������1���)�3�}H���T��3l��l�̳�0����̴|1E��[��o�Dq�󚾡�}s,����A0��7t^�@\-3�P<S�{bX�^Re.�K@�H7��SAK��q�䗷�8��3*~��*<QK<+&.nױwW��=�Pv�@�LS㱝Y�&d�RB*&���_W�|�&��5?|$�E,�&8Q<�,;S�9/�٫��`F��e�{)�Ђ�w�z��(�T(K��gr��%2��B9�<��SS�Vc����:��$�.�U��^|!��nL�d
�ۓ�((QǼB��d%�W+r����=X�[2o���S�,m�V�ߴ�L�%ؠ�x����v����I��'��w/%�GM��E�2[y�(��`#���1��to,�s��>��!��1�3�E�>��Ѣ�y��g-�^/2nJ�D��x�$H��a�3�)̗1��m�3	�ܰʨ�< 5�a�/�E8����/�L.�9�B4S�Y獮\I	�rq�.^�����{��uJ	�IM�;��'�+w��-���	!{D"�,G��n$�n��L���	�]'F�������1_�.�b�?��I��ѵ�v�6(fv7{�"<A3�x{e�ԩ:�g���!x���ǡ3�Lq�}9����)6�w%4��!l~���ꖹ�j;��س%����+���m�Ca��æ($�Kxk�'@�)2\H3`\�4'hY<�6h/�d̮8�Lg�4�'�37���V�4���䪦����)��&| 765�i����[��ړ[j�[��ڦ	����y������S]5��V����oN:����E�<��^n��'{�k��*�੗'7yZ<�ch���)M�1c[��u5�M�\��:ʍUM-��f�c������j�]�dO�؆�x�a42E﩯q˵���Ʀ��f  ��L �kᡧ����`qˣ`�����+�f-n	g�m���?���z,�Y5�S�|�k�F{Z�a
�]������Ijlmjlh�͑
a@x��y�+����Ze؅1&T�W��\�5K�M�\yJC+�Xw]�)��Z��vtmu�gR�[�4ͭj9��[`P���N���x����͵M�<Մ����*Ob����	Gi�gdT�Ò�̀G��Zf�)�v�Gk}b��vb+��DvR	�_5���m�	i� ��3	Cf��.��"�)@b��h�N8���j�4Kv� �-��Հ��x� ���VS5�jLm��2pN��e�-77�V{�x�P�PU�kŭ�/� r�1�����Qj���X/�����fZs'�\�Ќ(�T�T�1|����M���(:cU�խMpް� h�[�z��n�z�{�j$qȈnGWy�Z�	gn �D���`-���n��SU���&;��y,lŨZhVU3�CǑ�@z8N`u4�#����n|%�I��I�T����`z�lt��~o�`������Ա����*��f΅ct]��K��]��.��g
*I��6;�c�uv/�̦w$�������T8����k�Z�{
��M�Iw���NDXםY4)�L����O,����9�����NU�"���"R˧�ȫe�`�"H��>dtYo%����<B���N���:��č���n1b��&�u�G�L�q1-&9_���!z�&�F��$�/�oV5�K�6/I�17&U+�h���ꔩ���@��%�KC���!�4*vۂ��li��}-�㍘�_ܛi�j�,JL#�����{��od��L�ƅ�2w����:�_�sq��+��uSN\���_�x��?à�D|hoTSAQ��D�A�3�W%ZVfu�\�WP$�(Q�t-�5�"[ñ���k�{�ń�#�P�@�.�c�p���Oz��-��$���>�ne:o�f%4i`��|eUF��2B�ȊѢ*�4BS�0��b�K�<-�n[%*\��t��l�[�*3 q�]��"r��cQ,
�vr6��	u����l%�,\2+hTyxG,1�ss���r���=ڞ+�<rG DU����m�%M�x���f��Z��ߋ�a���Q"����Ȉ�����A���-��xɊ���$~6����*��acT��9��ł5���p>�ݝ�$�c��	�U���Z[j���
�K��r�s��+�6\�9�$�n5��0?��X���w�M�A�}:_��9:�:�#�]��l�tP�G0��9݉���/6;뿦qo�rC��3�m�H1�"�c�
a�Vpa>��c;�om ���Z�]�9x��.3M��L���YI��p��nL`��i��~j4�R�М��ޮFA.,x�
~	*�T:��7��cA�����9��"�2�����m��v8��p,�t��6{q0��b��"�{���v7�ƐL���T�k����:V��q��$l0�L�Dt\�{�֌<4�nG��>��_���%r�x:��[� B�0�+�Λ�YA��O��:t��������f/�:������H0�#
���H�:�L��A=�D�TÝ�c&�fd�#���X(�Q!�w���"S)[]rdW.+	׆rN3���Be�@�W��$3K>��D{P�X�U0-  g�_m�l`,F��<K��� �� m�He�w�0�s=�j�X���[�q�p�dk:uZ�4ς� ���~�YA� Tn��C1���������e
|x�[��pz� �ZVq�����_���^����c:�g�f���Y�����3@���iɘ�`@��l>KĊ��q����軁<Nz\�w@G�{����A��� �c��SY����Y�%�#�M�v�8D�ݡS�7nR���#V>��چx2��W0��/�_��
♉s�T�M�v���氻B������K�e�� �Ԇ��ڦ���mni�P�@M@QY)g��mɐ������L�̘��O�cݐ+"$F��g鶆uǧ�y�H9#�ܨtۼ�����`vh�t�ayĄN����� S�9X5��X�"�<B
�܆l���[K4[��g�Wi1f>��J)c�ciIژ�cL����
ƕ'�f�t��0���fI��ْYʮg�&�8�	 1;��@��Ng�X9:mc�������J9B>����eJc�L��K� �ܺҥ�]�����Cj���B�t����.s�!P�.�bb�K$�W��4��үb��l����
��n����<1TL��Tp��Q��&(a��,�e�Y[ʢ���J���F��¼Q5 �����ab��-	,_z�i�6���+�<!�NF�ZVuiT�ǟ��:`m�.aVN������qe8ծFǨMWV��5{2QL������l'q�1l�	p�s�j<�rh;sīs*��pXu%���Q{�����sq{�y��U���J���.��}3F�r"�$��t��_�ߘ�F)��~��T�,4�|�ۜ��I�oɜ%=�gd�"��M�
��ǟ�ap��ꔞ%�`5`L�]�]ǜ�q�#�hx�bl˄:+c8Oe��+]�lb��s����%,�)PPc�8�N�2�mU��e��.y�̔��&O���s���J�����L~����JFt�.����'l;���5���ɴ�]����cҶA>��=�t��,,�b� �!{�!�ΎU3yʻ�$��e�e���V��C6�=6�ˑ��x��D��`�ZП���{�K�,�{����+���\�\���n.��Z'�_����[,�=�#�<�Z�GR�~� l�q��v�wAB�=����.�a��t��Y�cD^ҝC15?���gJ�U~?�$�[]IPW�\=��=�og�#�X���@�J�� mgsak6�ȩ49�^&QP�Ⲡ)H��k5P=.V�҅긋�����ЕZ�!��tuh~?(�\_T���Ƀ�J��t�,�6��b�������'.B[�H,�׻�lo<C79�jĽ!-f����/ۈӭE;ٲn�[�8޳��t��|�m������X��n�朁0d��pK��m3����POt��J(�iw+�pČ`~@#�\�z�@YI�+�'�;�`�|�a�n��{,�AoE*p��R�m3�;�6z�{G�9�9������ݑL���S�,�[g�!���X�^����c����?t4�DV�Q�K�q�������ώF����u>�5�=>$��wH�����[v;��'�Tw������@Y��H�9��h؃vv盛���e_��8���5�J�ca���4���R��R��[*�or2�+�#��	��4	����r��*V��P�F6П`��������<�go���Ϳ��of{��}zP���'��������� rL� !��fA�r�,//2�9i��2	s竡���17�}t^�y�����,��곳�ůw��_>L(G۽Jf�[����g�
�n���C����v��G��pf{uؗ����5�����w�8���D�\��z����1�M�)���T1�d0,����,'��~>"-����K,Z�ud�Ȼ�	�Y�����޹/��K>�G]�Il
���J����������X���:�u�[�pP��l�&�Sq�������j��'�L?�R��/P���Oմ�L)�͛�;_-U����j���J���[�S� �ș��0ep������D�ٰ�!�y�ڕ���Ӝb�Sm�z����U��r����8->�o�T�8����]A���8#KsN�͌1]*[\�&2-��l����t⡰��)�Eu8��Vws��(~���~L�AgD�5���٠�@��ƍh�W��N���a�l3�����Y,��j٬���WW� ��&7Wn���m�7l��\�zcC��F RƲ��5��iխ�<�D��%�\��*$)w�TM�zV��K6���%�0MZT���/��Ґ\iP,���E�۠�@�a�9rF.Lچ��e���6K�c6%�9R�@f.Kh&���aWZZj��#�k9x
/@��%6@��]^'y���V��t�1EO�Gpd��&���tk�fL�	0:�Ӹ�:P����c�hyn.]��WS�C�;�8�mp��h<Ӆ���,;���1���T�1H�T���@�P�bTm�zh`�u�c�i��L3B	ۉ����6%e�&l#�!b)p������>%��X)���gfi����Vյ�U7Lh���6�L��&{��|�����8~��4������)�Q�2�"��c�AQ)�SGڡ~L�͡�iV��|7��l�B�w���_2F��e��BzX��7��$0c�����+��	�`D���]���HK���*���Xo=��x0��"S`�Z;+T+�7��Z��6�HQ�j5�Y$��_���M1]�#~߀� K{�s�k��7T��V�+�q�n���f�%Ǧ��z$��f�b�Ƿ�⥒4c��btH�dq��+�"ͅ���D�8]'�^�b=��5���|!�/��0hC�VWϿ��`��҃n��=Mb��9Җ+�l���?�/E���Q��7L�N�����{��ғl_&�i���	fU��ݦg .OUO�&��h\�m݃�k ���խMM��-mU�m���z�G7�sS�_;E����P�Sq`��h��5��e���x��ڲHT��9��4�����=�Pc̀���L�"1%��a^?���!`|��\�ŋ��9��O�"��Fu�� E8|t�I��ԍ�o}��إ!Բ�Ii�O��Ӥ�*�<���ވ�KW)�I����J��ҁ^�2T�	�����^��Yk6����k��W�R��-�N|S�m̩���8f�m�~�S:�>��{��������5V�۴��xk��-�:�ׅ[����l�y��Y��M^�}��;�vM����A�Ǝ��R߅r�!�:�ꁾg��J�:inը�&�y��=�����?z�?n������n�c�����O·��<i��qǜ�J�~��_�?�',iزzmǪ#뗮�y��5��=f���N�����w�]��W�^~�7�?�֯t�[��nX]���a��"����{���G�t��<E�&�xQ��?�������/��q�Cr�>��O�t��������g�{���>�1z�)�g�|��ww<2'��\=풵r��ߌ�n]�ܕC��2��������}ܹ7}Ր��y+������^y���;OX��U��}8뚟o[v�)�;[���?߶n�ag����;�Tt���曳_�yЄS�����O2ZΙ?�sW�#ѭ������W�8�'Vl>���ݛ/��e���-�=�9cゅ�w��l�M�-��f�%��oyh[������ʹ�k�����	c�Pߺ`��\ֹsV�\�R��Ւw��a~^��E��~��'˴S�-�鹼�'�w�j�y[o����KE�fʱg?]��=~}K���3�������e���{���v�m?qmw�5K����yѭ������vj��d�Mo��}m���|��ONx�Gϳ<#�9�żc/��eC�<�&���<�0�������Ŵ'y���]?���Wo�<��g��3��g�>�gθ���WgG����蓎��|��:j��7t]������T5}��?/xj�k�o|ƨ�o�������4h��A����~�?~w��߶���C�����E?��{_f��ן{yj?����#�Z�U�2W�̌/�}��߳���k�G�pƆA�^4v��ʎ���#z����_V��菞�.��c��?�Y01��[����wN̟�׺'O���['�~�k��g���'���댧���|��C�WY|j������8�kJ�]�[��������؃g�sڇ�����Ͼ�z½�kF����.ݯ��w����Z|�2�������?,s{y��[k~{�����Vߢ�5^q���!�	�=��?&�^x|u��'\��I��Q����
o��ya��[��;F������4��w�Ak�޽��(�՞��~|"���%�W����8�}�+�������W}�_�c����}�(�����.j�i�>dr��K�N���ûF,y��o��}�e��j{�������GfT6��?v��5eK�]�՜��u͵�_T���I��~w��:��ε��U����Ǟx�Y�n����E��㇍?y�c%��S^<��U�����U��9�`��߂��gN�B�~���c���	�<lA����|���Лe�S����փ��ix՘Σ/y��/�s��<2�ps�4���Q�gN��׌�&4���sOgݵ�Y����=��T�`���N�g��ӏ�����������xp�O>r_=��7^������<��-ӟ�1������HƧ?�����ny��/�z�������~�����u����]Pq\���������˹��_Ժv����oK�r�����=��e�/|d�e�X*��>�+�q�c��-;g���/���%��9g��%���f=�����~c�[��^8��_gy��|u��}7\��ĥ������Ͼ���=�׷�)��{��>c޺yVa���\�8��������3{�M�-8�Ӿ�����9g�{5���3d����Y�5~�y�+�o]�蜊�?�Ť��y��E7�({o�u�N�}R�׵w^�(���K�yͤ˖���+gn��������n��ߜ��mW��˺���'���苪~�\|�c�2gƀS��u����+�{hٍ�_�w���M��wلc�~�������<d�E;���zx�kJ��w/��.z�Ѭ!�9��?yi��o��މ?�θf��?�w�Gۯ}��Ӧ|{����>+4���1�of��⭋'ͩ����y��M��_���.z�}�e�W)��;xÄ����X�qJۇG��~KE��3ǟ�yƁ��Ԍ�>eq�w�����~��z�w�.+���Y�]U��F���<w��El�a��QG̟�g��@�Ȗ�S{�u���z����]�]�Ɗ���������7~���6G�ѧ�5����_}��r��}m^��m�:p�e[�_�����6�|����Eۧ�qּ_'-�C�m���f���$�c�~q莦����|��w�-z�#��38�sу���s#��|͑Rࡹ?=�9���˯�g��=�ڜ����t����z��;�%�n�xws�y�:>��Ƚ�{T�M�q����qvS�W3�8�\����_�η����٧�v��3�}���O��XU|Ӊ]��;�r�YeK��z���>���l��ܧ'�5��cal�~a}�/-�]�zؒ��/}�������~<��'_�ϸSk��qx���t�Y|�k����uS�ܭm���گ[b�_e_�)�ވ�??z[�ot���>O^:�p틯��vפ�n[�S��)��~P�]\�~������������v�;yf\ro��~���Eon�b���_r���_�pк܆�O|=��[G�|hy����>yw7��X<$tx�s/Z�����e�~�g��=��s�W�^�9���m7��y���c����B�a�{�3�}z���?mĻ���v�>�8}����q���;�[��֝ߴ_y����9㳭]��'�s�7��4v��#ǭ��ٴB���.��~˫3�i�q~�]�_�f?�[��ʰ�-J~�ↅs�i~���G.y�ꚩ�7���s�K��n���.m�}Ӊ_|Ο�^�w」��O�������sAN�7o\0w�:#�{`���oZܳ`�yM�Ͻƛ�r�)Oo��A��%�����y�U�ִ||�v���X�캆���;��uI���NYݿ������/i���C��'����V{��_m��S�<�,�[9��5k�[��uw�1𗚵y��:�߹c>;��c������׽�M��>\���g7κ�����>��薑+֟�������o�a�I�ck-4��Υ��ҭܲ�����Ec댇�{��1?����<V��c��8���\ϯ3�,y�F��ڗ�^��OWߴ}����o��[Xw`_�������u�W�xܚ��K;6|p�K����x��˻���ݽ=sc`֣gn�~����u�^y�o��?��w�9���9�����(X��۳O0���m��7u���l��.�j��^5Z�oLV+�'��r�璢�_���k_ڹ�gFlx�f�6��owʲӿ�ql��r����?<c��-�/���_��Z��E��Ox�齏�~qU�������f���G�?���i�+溗��D���榽l������E�ά��}~���?�U]]3zڐ�x�{���̙>6��'��}��������'/;x��O���~`���=��Oz�چ����3��a������%W������ު���/혮nj�?�˓o�4��?OY��Z���sG�s������疕'�|w��D�?o��ȇ�f��Qy�4��x�	_�+���g��w\�y�w�s_����֝�zх�_7���K��������K��g�)xxľ�n9�&�{D��?��]z���/��Uͳ�;o�y�Ο�p��s�t�m�o����O��������a%Oy+���kJ_=b�S7}���}����_=��3�����yf�ʎ{��v�i�O��p�Q�{=xhA������~h>���矿��Ň=4祩/\}���eU�P��Y'i놬��)*�:��秝�����?��>��]z�^�{��������#��w}�`ô�����^���b�a{����ʉ����{���S/�����]��\��,7��oz���_�����ԛNɼ:������憣Oɿp�}N=:딌7��8g�>u�+��{�;phxj�ޭ�Ꜽ��e��|�	M��tU����]������+����??���>��S9������?���~���w�J������{J��<O��}��}���z���1c{o��h\0蝅g�9���_�6���|���\�I�*�����|�w��W�;�����;ꮟ{��T�׽���^�B���᯦o���{�#���ɫ�{���G%�����ȧ��+n;~Ω�E;�y�y��ϕ~\9~}���w�y�a��]~�!G>��]�u+���=�0�s�����h�0�����>������=w��l����~�j#r��C��p܉��;瓹������d�Я�f�����������O�>�~��g����[�a�E�<5��>�jy�_^[��3�v��w���î�:�_�����ۼ�ν��U��f>����ڎ�\�}�k�~X���/{EJ�>0�󝫮QJ[��3ՏF����k�Q��y��ƫW��~Ϲ�����\w���WO��U�O?e��m�?��U񌪺[��{���~��ᷭ�6T���';��ݲ�I��)vv��#焎>i�^�&�<p�~d<��dA瀓g?����;����b�+��~8{�=RŦ��qw��_�w�C��8�xÌ��/�F��gw��Ϭz������8󣳾<�~�~x�'3Y�����KF��X����N���3�����ϭ�y�9�?�����>~ ��,O�ܯ'�y�=�x%�};�^9�w���6�X�=�t�����x���/�s��s���]E��&�u�mgd�D(\tfN�1�����@�7�����[nX��~�,��6����ox����Fz��x�����]���>/>���g�\>I}{G�>J��{}q�Q�u�_��2f�%]=����~z������ʢ�KV�q܉���rD�^�X��֎�w��׍.X��?���o�����7.*	�]{zV��������}�i�����앳��y�[��Ђ��o�k�6����^<=|�Uխ��~*}��O׿����>�쓷�/K�w<ܯ���oze��D���O?�w��S��W���ٽ������d������0�g���� 푍_�޷ꈦ�:ntq�3x˗�|uٝ��O�1�+煢���"�����\��!�Z���y�ׯ}�r@��a������^7>�Wx��[�͗��������G�U���}�>���/����{-�¶!,�'p�o���Ƒw1��M��qvl�_����c꾼���6���4I�~�]����O��xæ�����#_ع����>�����cN�{揥�����݌o�W��Ov���C�~���'�,��o��l��������[_wq�.�y�Gg��Woߟ���)���׿>�i���^V5���wn�����??3렒���u�1]��pb�#�M�p�'��.�:�����5�+j_ݷ`�}���=��a�%���v�<��ƟC]���x�G����Q�_�b����w�_U���۲�5 �xu�с%Ztlc�m۶m۶��c۶��c۶m�9�������ӝt�W��Z���'~�� �=����xw]q-�m�	�d�����g��fol�U/�l):z�v���DM�ԋ�Ta�G�3�.%-6�,����̎¹���hd{�pz}K/�3IT��z��7�ї>��4?�=a���X����ݬ,bd��)�첊�y���~B�6O��b5��g(�ݒ�N�L�	�E��M��9L�*Л%k݇<1�H��P+����`�����ݰm<O�����aySr}�Ɂ��o���j5�}^VBD�G���&�@p���W� 2m��L�mUT����p��[��5"#�F�T�~�x�i����k]Z�{���Z��)����q�	?�\�3�yJ��Y��U�*��y��>��{���Y	���\�k���<�|I55@3xQ��-�6&z�G'�j� �5��ob&����|�5腢?(�2UOjJ}�4$O������M�D�fHsӶ���<gy�6V�*l=Nd{h�x��N~)m|Ƕ�������|���4V���	�'�D�*�[��?+HQ�}�V�w���Z=p[]6����4l�"-��y�����`-	��#C��ڥ�Q�<9����S�R*���2rcЃ���
�H#x{HlO�?!�ُ�[��In��@�B��Id�S�j���& ݂_�.��`�'�d�������-ܔxD=��(	x`ϝ�3���y�\�1o	�U^�b��Ϗj�'��X�b�O�량h��{�Z����8�J�2TOAZu�H�/xk~<��D���(Uj�*�ߐ��(w���u����ɾ�J3�8c��e�e��+��-zKBHtՀ;eAL��1�8s��iMtj�w}�(K �I�z��
�����Df���<�&�m�p�^_w$�6���h�������.��<*,?k�N�XE}Ck���(��d����ǓtV �J���)I#|�sCP��iA]$�K~~әD��Ŋ��FR�|�2�Ǩ\pS�<�Ζf��|�ҭcK2t�g���m���!�x�����b�|�E6���ꣶ��Ͽ��X��V��c����L99q��BZ	p�V4���( a��gL�� ]�#��%8�A��T��}��RT.s��Q�H��J*؋/��V����P�M��הoE�w�V@���iwl�x�Ä�_��+�g�a�U�0�\i4��?�O����!��D�N� �<��F��W)r�A�ͧ)LVh�����r��J�Ld�3s;�����L�������3ɥ��6��m�E�ޫ��f���Y��j���ViX��[?��1:/���b����] ��v�_ ��{HЌ�}8f}ui/�z���R�<~�5�d�k�X:�,v@>�R�F�t��"q��ij���!��OӃ��دE5��d�A�=��nfjטW��:\g,2Zǆz�ZV���h�d���Cm`q�Ik� �:olD�C�Ū.N}cbW�:@���P@`ԙ8 Mt1��hF���8�=�H@'��3a�\�@0��n�9�Fr%c!4RbO1G̗5o+��uhc2Ŝ���L`��8]�(,[���D[<��t1�w|��P>�dR9�}2�mkΦ��}T��yg�TSYI;���@?S�d5(���S"T��G6v���z���OE4DX�V�Z���a�@�3�IphL��R��F+�S�k������A�����?�]�'U�y�Q
mvK2c�[=Z6yo�y��ꂮ�����yՂ���6��A�f���?��˸��]�Қ.]O��+��A�{���)�,K��ɗ���*s^1h�2Jr2qţO�{�0����g��f*,�=�c�S&<�l)�u���ba��y=F���S��i�e��ݳ���T��7�[�:��K	�v�[�.�1R����)�3��AwV��Bh�X��X��f�ޠ�:�T��{��Zč��
���j�]	Tϭ��2x8A3�a2�k�}HtAY��������� %J�z�j|��L���0�) 7i;��P;Nbض��S��ցyXƕ�:!	�ĥ�P��f�+D75��Sj��55�&�͌��؀S������m�dNR��ԝ}0T��#ع��?�����X�.[D�`Ƥ�T�:�sv(�1�r�_�_\D��� *��j<T^сn�2r\�V�523sH����w.����C�@i:��#Xlyv��'��ŵJ�Ɖ$���y���'n`X�nU��[����-���,z�Wd~��lv�*����3��F�3/<[�-@��[D��޸�/=~����I/UM�=��o���@p`��^59qňڌ����u��?� ����vs�V��ʘ7�����F{Kl���t�$�k5�1��8���w'\�Ai$��`Q5q�0�^�
U1qҪ9�9@�+P��;�6J?���8��vk��,�ucY��EgB's�TB+�����B�~��!��?x�on��t�_�5�rY�o��!�s�	e5'�
�i�Gp��>@?���K>�s	�2ٕ==���XGgL�4�`���-���VX#�^5E��j�����s�*G�>a�G'H}tm,��ݻG,�V�i�L�� T)����ߌZ�1MN��V)9U��4N%����!��]=�GM]�ߗ��: q��/� �����`�����_!�ı[�u�<u�Ϛ��dΤ��+���O��>���0��e���1Mԅ)�Q\�c���P(���Лvc�O�$�ԒvE�l+�v|5K�E�v���ǁ�n�􍇴ՠt*���*�@bD;�6)��� glD��y�v��94މ͚J��;�����N�����l���Ϧ�3g���/.�f��E��ҵc��H9�+�oIA�O6��H���^a���=.q~���m6�f1e�������k��T��ۥ��I��$�_QW��xy������;�M��@G�r��n�Z�꓎i�O�IwDQ���:��$�S�K�p��+O{H^6"��䪶���֯���4���Cy  %��\���УD�P��5�~ʧ\^�edM@�]Ѫ���R������zyS����2v"m�b��f���&|XcB�@����L�i����]����}�CWWm-�j�-��Zt�Ĝ��y� �	�(� Y(m�����0��`��[�#Z�hRF�L���ݰ��c�i�`�%GN 9B���x��7���|�
M�gp���]dSky9�	'�Na$
�X��r�c�n�5�@��NP�!O
�^Oa��'����`F�<sn�o�D��MXA����������r��i���Ọm�������H��_^?�o 0vZ�CS-2��w⇌�i�XD�����9�yV��-����2�G�@v�4F��~�E����1HNbt��A~�82�\v�SO䡑@e�2�wl��ŕ����P�BC���4��a0�ٶ�D���G��8��e4y`�e@�W{i��>j�J�e2@�p���!W�=�r���O����ş�c���XՅ�yq sE|��!�`�]���.�yc�UϤ����Ib�Μ���
��=�[�G!;��Da�v?�m�V�"�y�R�̿�+��+����0��=#?OWzlS�1����E���[��̎�w�_�YE�ƐAW��.&l?�Bh�Ա���p���5oA@�9@��r�q(�����mt�E3��7�˻{8�Ф.fn~��_$�?�GD��@}��V����	w��vtdܘꦥ�rY�N�{e/���dJxs �I
��h���r{[�M�1�c�\>��N��3s'�Dr��(�F*_2��-(�m��eU���t����]�B[��A�	�H+K���7w�j�
]�Â[�����=0O'��#���u�cJ0#�t�J�����	�v��M���×��&�iń��m�aE�sH{�}�@ə��]���RTn�$��Ǳ�(U�K�o�U#A�����v�� 6����d�i�>���ں�xIX��觧�����uZ\t�E�zv��b�e�I�(]�xI�t<.Y���[0�{����ʙ��)}�H��Ҩ�����h��8�uP�z�H� ��-���Zkq�|G����)��|ʒ��J���Bژ��D�( �7�2�t��uq����y�)hm���&���T\��.دir����%d����{�_Cb��q�@
dFk>��P��ƍ���P��4r�)dm�_Nȕ����$\I�H�khj,
��Sd�m7v�n���c3��{>��~�^���������D��{��f���e��|�^��L�H^ҍe���&��?+�yxE�W�ę�l`V��Ř�?�J��?oa[0�h�Ę��ڡ	i�0'N����=ϴ�
1ϫ�]���t�9+�3-�=�,�`a��B����a�,A)HC��E�0GWw���]�c*�����ɱVm_��D��q�=��G���Z�xP���C��R��C�=�Ii���Zw�1t茢v2�բ�t�׽��2MN`Mbzi����� >f�)l�uz�m�xGI�'j���o�6?���~f��*۔F_�7�[o�ebn�%�UkΦ\g�<�q]ٕ���ōNو�����+��X��i�u��kj/�O�����������a�m��?dl��e�����7�b��=��F��>�?*�<�p��"���Mu!���w��WyI��;qoa�?��� &������~���eUʴS�	�uK�)��)�xs}b��֊�K��Q-�Ю���1�~ρ� V�Lo�⃹�������k8�]�Q3bh�J��"�:� 7��?�*|��|[�s�����S�3��*<�;�G\{��;�
���5�)}P �@����W� �Ku����A:������oi{lwx��A<�q�������M���퉇�C�]֩�)E��Շ�Up&�9�dO~P��>n�U��p��a��&י�� ?��d��'ƨ�U�t꾻A��(�ܞ�*�ھ�B��ۢMؾ��`�|�ݹ�(��� b���LE���Ȧkߦ���繪� �N��?�A c����`�X�[�tVΈ��Ӿ�"@-Z�t��&d[!T.rJX8Fe���^�A�ɨ���R{�s�uf�Kx�l�h�Wr;6�;s���۔X��1�L�'�I�?��ݠ��*����v������%<P���Ђ�P�Aa��dߗA+�9�#g��>�_����#B�P��@�]|�˽���A_?��{�wK��rA�:�����V�O��D����o�J0����c�"��
	��� �)1�[�0l�영j�|�������å�W��h�n� �P�~� |��`_��X���r�S�@lAEe�᪹!���� �k~��H>����u���Dt	:bF��ؾ�2,1 tJOe�9�Z���\�	8���Ǯ"���F w�u���i��r="�"�IS�}p��e��F�c��o��vr@p��X�it��~~>�@
@q�r�r��q�wU�( ���:'� ��@��2�+���%>�ɰ2�����p��M��X�(�u�'�x+O׻�j@7*��SY�����P����)c_��d����|"᫨���ݩ�j��g�P|������!{���m����f�`���������'� �O��,%�{�?��z��o�o�`M������}����o;q�X�Fg%�����i�{gv�}>�t�~L�T���/�.��1=����5|3]��jsӅ�2��Z�=KRL+�g&�-���8��`�����C�%��Ŗ�RZ�������Ub���e}��U|e�#�y���.�?\;�K/��fK(�O�͘��֤��8U{�J�
z��Oo�B��>��eچ��M��2ܘf1�Pb�o�����z΃�q�Jj�9�{ح��-0S� �;�o����wMb0):q�����/j56nz�7���//(Z�5�gR����{ �)��0`��i[�^�?ۃ?_=�%����fo��s���hеN\}�R%+v�����y���1^1Tb���q�@!�f�/}��	�"�-Da�h-.�E֣�1[U%�X�)Uc=1@}�VU���E����VF��[=%ˑ��-r�+�/�2������	�ޝꟂCS2I.�SNpiD��(�-��Ks��������R��,"*�J�$��*�����>"�萂imj��Lu�+'[+�A6[����hi�~c�yܤs ��b���T]W���?��"�w-�u���[հ��;�Hy��}�ft��B��AG���_�y����^���� ����a��"<�ƤkcL��|B~���_�euL=�h�Bg��Ѿ=ßN~ Ym��Z��{�|Q���x�;���0��/�%�W��A��͎y���>�b����
"���ovi�Șƽ����%ʹ�&��==�6�l�g^���|� k��4��Kj�KKG4��4���q�WC����;�֗�ڑ}��|iظ�?f�J�-��Tv�Ĳf�G���NE2������B|�L���	�AF��1g�?a:�� �����m���̽���k���j{%T'y`�茀q�Ϭ<�*��3�DtM�� ��Y��v�qE>rU����6��Sf��6��_�j�����X�n.9^d�Wڋܩ(f/����c��`�gѲ�+�k�H�l-/� ��So��|}5H���3;��c�e+�u�$��͔��#��TaOHw�N�'�[�5��~h{h�\[����D~R����m
+w�UF;6�`�����y[���g�m��7~�l?�����R6��[@wnIj4�L�)0���]C�bklCX�3��1�?+�=d7\��*9s�2�����%Շ�牟�� 
�,S^�֭�+��F�;��W?_8�n�k����c�C�5F
f���\��a߀$D&D�X���qP�:�?`O;.$H�w���j)8��1ў����e�T�Y� �`EAv6qn� ��
����V�x���
"�ڦ�6�!��Z�Cⷑ!�=H�g��,'FPt�u�2��Ej4��ƈ�8S�*�߂�gД�������I���[��s�Ǘ�8�@�g1��bޖ�pQ::㳗o��ݒ��{Ɍ�dĨy�ő� ��b���_����"�{TS�0�㯫��#�D�*ؾ�0~��� �S�A����d����P�IV�R%��M ��e�l��j�J��磖��Ik#�?F�+�M}�[+���a�S��X<�w�)���N�Az2��g��L���A�q�8<׏�&O�A|~i�WE]���Ng�	��h��5'�[a�gFʐN�A�}�#��WV�|����A7}��1!�tJ��e��9�ۢ�"Ҵ��ڡk!�<�\g�g��<a���§��ٰm�3�\@L��/j��t�BIь�萢>�/�pcC��-�zճ+�5ƻ`A�W�Z̩��� C�(H�ŋ��5ϕ��?? ��/�;��ʞ�� ߦ�K>�噤e>KI�i=M��=^�Wq��WI=��6���X��2�K��*-�����l��cy�1C�(��F����Jh@�b��B�q����� S(�I�nӘ%�}�M�Z-��u���EZ��� ��Ve�n�(�Nr���(ɍO�� �����P"1(���X�W������:p�.+Oq(�Y�d�7��	gٶ���)�$SuNb�����/߬ӆ�Q@��b y��� wX��)=诌�/x>Ko'��N�@�͈���f�/61�^n�p����*z�d49a��[�eaKXL=��lQ��};2���&���+&֧�C���������5�r�0�j]��=N]�	��N��|8i�&q�Hq��dӈ������j�Btv��<6z�+(����N�B��b��,��:&���xc�L��}>>�å���seK��ˡ-ep��*�l�2���͒�:f�+�w��#ł�"SK�EجYE��ϲ�$��Ĳ�STܶ�e^��CAi�$Nb��⽅U�#o�;mgk�MѠf��x��%Th�LX��!E�A�2�S_
l���Wn���8�T����p&$�v}��m�v4�NP֦}��W�01�~� ��:�P�����h�rg4�dY�''{/�Z�з�1O�y6��A���I1�*Ǘ�����'B���cy3Y�����{�=�����p�fՁ�o�$��3���P3<��Au�C3ǧnvK�����Ic^��#1�Z�D360ê�cgM��<EE*U����7A��Y����|T'�y�p�I �p���$XZ�}$	���'Bdf/_ˉr���W=e����g}?M؁�m{W򆅆�Tu�/��������<O�|�|��=�����ݪ��3�>I���_�������^���>�m���Lx��������m_羦G��t�����W�e�~E��l�^�y=�Iw�`��<Q�~^��e[s�M�m|����}O�|m�K�q��g�q�����]��l}��<�M�|�[�<�~u����>۵�=���］��}��n���'��vc�8e�>�U�9��3$4-(���`� +_P?�9P@̢FA�u�,�������?d�����ھ��i�Z(v?|��J��~�[>� GCv I����XZ�L�B##2�_"m��U�6DB�;'6�U�&��C���/�`��n��+`Ft8k:x����U�ߎ������d�!�	�����A�F�[`����"G�o��g t�]b�ql�0�M@ăJ�3��	��t��Z�D�f�>鱇ܧ�put��w���и��ng���o�$u��gw�Wb�ܥS�}L�5���:/X;/$>�9�,aPQ>���X�L�����I�h.t�����.�ECp� B�LAA|h�1�ߚ���$6%���eҧ��8����4)�Ao܄x �/�#D ^�fb�}?yzh���h[�z�	�7���/���*��*�5��E�O�Ⱦ��u�Z'�����K��������e�����+o�ax��6����T���xvs�����UJmb7fny�*�/�;6���,�}��"�2�������5&r��,a�Fʱ�Zb��בLd�[h��/-pU�?pC!-�BVNd�����\���.�l���_:m3͏��Q8��^4�	^�8a����p�2�Q�ÏR\������ӟ�nt�xr�\I�-��>�*#H��փP�XIx���{ �}�rx�g�:� AP��������5�#\�C,y �\P�S��G�P��@|��b��H(Q��e ���x�ʨ�(��Te�`1�-F��s�C:�M�S��k��)���N���2Y]��h�$�"�^Ns�_�Z�-8�*J$���#Ȟ^���C*�f�w������Gb�?d�K�����r&�=J��y�:���A�����j��w��/�= �g$�~�6oAPv_@�V���bO�!�$��o��4E,9�u��N�<F�UBK;)c�n
d>^@:����{�bݯF&�ץ̠^�6	����h�l�r����YR�|�
��Zq;�Im��Mq�h@�&�s�y�k/\�r&�#;prA�C��?�cm�tLf��)=��H�1�ܵ��'�B�U����v$��������M��%�3�L�7�7�tka�O ]ߛT�R�?�(.�����!X� �J�R��
����`-�;TϿ��.s�sav(x�8hd����Q��� ���5$B
����b�^Eqm���/(j�o����1�	;���a��W ���Jvy!�qߑ�=NU�!�K#iW8�
��k!>�JB��'#E���&p��op����'Y��u_!�E����vNb��t�n�2s�$rS�5Q�8���j,���艕��o��M%��^�<��;���$� y;f��e�+��ꮂ-�\̿�]�v����ͪ�H����Z��n�3q�G��ʹ���Z�@�O|U:����h|k!/W�>vyH�R *���������b`���f�j\&?���d����_h̚�
o\qj��7Ƽ� �/�qg���9����J�^����ʔu��h	f�\���>䕗�����b,��]ǂ:�!��?���hFQ L�L�<<�޾1T��Trl�9w�a�]צ�U�ط/��1��\�afK�pбV��E����#��A�C8�n�()�Y��OqF�P&�m}�����`�'�}#���0F�����@��s�����OX O���?�u���hb���]�1(��<���Qu2M� ��R���K���R�/\�­�@�D��Q�Y��"�]�-�2��?���L6E�d�T��o��.uP��8no��P��K����D[�7�X;���nD.���� Xa��m	M�ƴ]�3�꫌̑~����W1o��}i���MKO�Ð"Gշ
�q�xs
+&te��]��Q�d&��z�O�Z��f��q`����&��SF�;#:勉M����*�#o��J��@*ٝ�,q?L�Ə��~��pT���ߜ�Q����,$:�-�`�G!(3�{'���m�����Q��+^H7�0G��b��\�7������B��w�ҳ/��3�׿ZH��<���H9�}�~Zd�v�b6�[�)}a2(��ǻ�����H��51j(�� T��C�A'ߖ��hY}�M� �T-e�Ǟ�'�ߢ��EL-�F�2rrA&{��T23_���aS@GB�Oql]s�*x��x;sG��)�����fFX3 ���4�y7�1�����ї%�M�����Z<"�L��A�EE��"��N���?��S<O�c�n�bCI�M�i�l���M�ES_�bf2̰Fe��J�zd�=s~l��/(�����xF����bU�-�?9�v�X�v�����,F9�2�g�p���0C��Nw� ���ǭzI'���2E��r���/�#\��=����k��V+��lW#/�ZB�<hu�u8�D��)������]�H�@����q{zq�@W���Vi���\4�J�؍����B����X ���˽~���Y�j�+
d�A�vy5�Ō��C_~����#��\`�.81N�h��~���cbu7B^���@�xR�#��P���#�:��Q�����-��cl�-x��B��̓#��{�{�;�2N�(�|�'eI�o���᰸N;c�l.��c׶(��zW
x�P���U�Q�B�_���c������ߔq����Q�g`5�g��gbP�������������1m���1Yx� � :|�k�[�Ŭ�YX[�[M�K����˩��|��jq���s3�	��ttq�sY��1(�jIQ��~�Rdz��x9a���ddcQ�&���6��xUi?�<�ȡ�Ta��e�[懕�����-���G�%���:��24�[��z�Z{ϩlb��i�K����Ҋ���k��A�LrT��%����W����H��;��G_��ה�糠d蚤G1,X�TK[1DU��C���֝j��"�JxǥG���������Y���-M`�j�<1u��%g���[jۓ��ة�b~��u��`2�.�����'�����l���[�^2��fB�&VNrRbR
,���Tl��,ڗ�Vc�����s�Cd@�y�Pj|LN���H^՞�fLM\�FB�V�\��\A|bR�FU|RJ�\�Fr�n\��Aix>�#]%�$��C[S?�%��Z�#��:N��=��2�3�bk3� �(Ō�D����h
�؍Q�d3������<���2V#6`��dZ��]:aT@?;,0ؑX(���v'�)��$���IZԨj!r1v������doĺ\��V@�XA��_l��lO���+��ew��Л�&-�"WL�t��$Z�!7�zU�yh����|0�o@�Mmw@Y�~��t��ɪ��j�O��в����6M�e�+nJ�CFS&��x|-m�쉲=���^���=>������	*(��"bIa܌�V��;U{��5��^�=��D��Z#}	>હT�56�=��3�9�}����� <$!��*ߠj��j����#�E4���+���}�7b������*�k����5��w��[�Uq��BT��n^��ǐ���f��9��Q�J/?C0�c�m�$qh%���|5%����!�����$t�k|�!M���R�QZyN10����|!�5��v���]�+Bg�3F�%tv�P[�>y���s=��f�3������׭"�~����[ִUB������A�W�{���w��9�k�h)� K���!�P�� �CrE�;L3�Bu�I��!�YR��4�29�b����?sw�ĐM:@t�FR��H�ɀM��N����p�����:`�IA��@{:���W�D�E����g�`1h�Lm�J��#���>�J���u�7 �$R&�\����8+�wI9��>9����-oLC��0ʢC�[G��,�a�̗��:7˓;���`Et28�g9��y�0�vؖ3|0q��+�r����#�`�i�/韓\6{�bZͺX�#�;v�cn藣��8�5G��P$��·�n�Uq���h֝�ݶE\O��lt�]w���vA��ڱ-0m�)���C��II���@Y��ؔn*3=�������1�Du��m��ʭ9[";ג��י�y5�u[{�r�0�W��)4�ȟ��>�����^F�0;�+DH)��� �,d������-����������3D�����=�v�w��j�R���Dj�*空�;;B�S̐�WvFh��yJǛ�������A�=�����*���U�����I��*F��|���)�e��`9�@��#�#1t4#`m^�~�L�p���)4d|A�z�:*Ҥ�I]�����{(
�qu�Y�/�I~W�m9e�����~�<C ��4�bӕV�r=���"p+DscT
p�i�L�~R��[m�>��!��)}zi2��ry���I|��9��J��ZR"��~!�8���}�G6�{�	}�4�I
��<�WfN�q��P��Ke����������I:������f��7��r��m�'RZ��F��8��U�� �52��|��
�����ԃ��Tm�Z��C��Bf;.z��)�}�2j���:��kx!�u&W^c`�
`b��Q������+kr�!��:������w(�00��q#�9t�"�������	��[�]�w>�W��f�Y��ָ��S�:r�([N�C�"���6��Aa����XtJ!�l��18kpU�_7�-�H��G�R믾YN�a\G�Pv;>�?�Mj
ܩ$%��D�y�0�z�\X0{�`a%U`���gU�����fUԯ�ٌ���st4C��K�L!(}$[��|��'���p:��^:�����:慉�ޫ��v/��J�Y��׳�bM�P2� ��1�s� ��؞����i�5#s���bP�,7��k�gݔ0�������q���}�Le����w}J�s��O#C�o_���d<=Yz�Z���F��ɠ���_���1��Ȃ�uu�Q Lb���!��1�	D�k؍Ze��!�ʺ�L�Y,�C����8x�d���S�kc��$z"Hf�C$6RVx%v��+�cG<��
`�X�lخE�{�}�.�b�f( ���RF,��bLҫ@�.��W�Ê�{�H���֊��[��CDeҫ�k��c��X
�b:S�t�4�#C�L�P,)=�qj�n:w���*!��»V��o��54�@�AwΫV�"��OX�5��-�;�^5ǫ����Yca���0sjU<�[ΔI�Y��9�&u��k5�C��k�um�v��lh-��O%�N\;@]F�b��؂�a"��ت��לN�+���hi^�K?{�ԫc���y�Ӿ][6da���%�	���.$�b8ݑ��H�P���s5<!��ш�g-#ie6�e����=�����j������Kms����H��k
RG�p4�a�Ay
#��R��sJ>C�d��W�Fd3tIl��8^e^�R��g��4#��	5ژ �y����(�U'��~�k<#,��r} )��=��4��6�zO�#�C0Ŋ%6:à.�RJ�dA=d+��z8]���
"o|��:����SE#��L�|ܦ�e�.��j���8��N��-8t�M&Mشo��}�yp]�.�c]�Yo��\�^�]P��4�'1�?�{��~�rH�}O<�A%������]�~,ܶ|�%�?9:OY']��*�:vn�X��L���t���QK�G�I��h���,��x�X��b���{�^'��܏VXuQo��?DE�"���E�r�4��|<w����3�.Ό��/ٲ��x�ۄ'�݉�L53+��	4	P�c"���:@�����W�@�d
9N�:�-�*EK` ��hՅ���Ԡ��hKx���U誢��*����o�;���pEq#2�F\����D,
��u��p:J�"�c6ےk�/�^y7�	;YT�ͩ�g�����^�$d��z�	�tpGv�O+�j�\?���	�O#���B��gb�5�
$ݞ�=�oϪ�:�����y��݅��}0�:x�Ik��Q��a�i"��h�>�����t���Za�/Tq�"�;� �e=C$`�m��]��L��ߤ���P��;�$���,���gϭ����I�%j�C��0�
���"��h�ߗ�/�����M�}�SR�BU�����0/�qS� ?�~J�0�K%��p�<5}��%|)��P��:F��hԺȻ�RY�Ҏ׹B�ű<fz4CcV�:L��:�b� �~�>��{���tPވ�ӥ�k:ѭ4�`&WԚҔ�� �����j���H�MG	=�+���k�����vd�̎ո`�qO-��kN��(��*��N���!��|��}ep�{�3W Db���w|��_��}e�#�f���d��g:��:ڧ=~Krbw˸�ꞇ�ז"%7Z�H�Y�V�1n�ū#@��^��|�ω2,���,�m1�Mr6}zo���E�$.A@	5��}[��)�w�^��J@Ȑ!÷M~k��%������`��xFo��9��E?zX���"�a�Y�D����}T�`3,�lE��É�/�Ns�-�V�yE*����ب�Q"4{c�t�4D �͜�У�m
��>���({�!�+�UP�z�X��˿��n�JP��A^��(�"}E�=1�F���h�r)�E.��l���h��LK�Հ۞�B\m����q9`���O��`��W�R���98Ү5�!�0���,���L,���""a�;��nM)gc& ��b)�wB�iKk$��p��Z�u<�ا��o����qTWES�k�]E�����
E�7<� �;S9���n�U�A��shyD�St���'^w��lv����Lђ/6c�Ne����L�LO�b­=�P��I�^��Ze��_�X_୰l@X�ib؛E|D�V��/n7�>~������m&�>�=���C�|�`����[Q]\�t5�V�1��Frg���bH��;*!Pp���F|�a������E1�ե���a5瘽Lzc�8C$4�V숪S+����>� ��^��0�{�aW�*�۽�.������B�1L +�����a�����/����B+����{�Ē�j��(`D��!���F��y��V��D� ��l�4%
��S�%�*�ͨ2��~F`�m)���CU��$��%p�rԐZ:	��Xk�!����h���|&���0�9'�w��Ro��T$���S�.���?�Ű4n��e,�3�h�I�F�]f�\?�����cP��9���wNb��d�a���	�'�'R=J����mܠ��p��nՄ��5]��N�}6���g!8]�x�B�z ��{4�%��h݊�A�;_�.��	����A(�Y��᭬�,��*1����i��L�Ғ�W{�|�d�Z-��T�"Y�Z�K�X���X��"od�d<U�q���彥-ӂ��[���dH+�c���m��!�yi%��J�)��iKz&:��*��\�@|�9�fWM�k����=����MԦ�iZvj�ۣ�ͻ��隶L�j��ZCɼ-t��'�l�U4���;��IY���$�6����"�MH���a��#�R�?��{=���������_8�D0u�3���'�+����聁��B�2�$X(����Wn�b�A�\gz���h�MD�_������=4~n�Zw~����?˿�v_w�o�x��O�{��bf�+���|-�.�~��~N�wZ��|��~(�,}Lt�-]��*���]�_�W�TϤ�e~�.-�l5��>����u��x6����:,��k�i�[J���`h�i�KRPB�����FR����3���y�����������0s��Z�\u�u/���X���+��>��/��8�պ��T���)��x��վ�:5�]�n�w�ME�,�:h)I�9�ʿU+ߪ�x�*8��5�y�Q�g8�t��>w�pDyitk���
����N��c�<���Ʈ�ܨ���8̑V.:LL�X\�{Q��٨�.6�t�D�l�42��Z������_��mS:�LU�Wy�Q���ry��%_ f�a����H�q�j�C����fG�ݰMwPO���	�7�J���dOSў�Z�lY��e�$��ɉ}��T��Y��͒hf�77�h*r����������T��y���M�<�L�[r%,߹��L�k�#�����p&}����*˼f�z�����.�a�-�{�DO8��A.�qL4�>�,��jN)8��b���Zv҃����Y�^�����Y�їε
�Ąpr��+�z�[��P��c�#���V�t���]Vb��m��f>\��W(C�g�]����&t:�'�w&DZ'��n�}��D2���ep��Ī��;�E֍nW�ޝEM�\�g뜍��D5����@�8�
%���W�f~˩��h���Lk��$�aS�s� az�T��c�rሊ7�:����R�m��X������	�8��e��w�~]&;�~t��6�dT�+���Q��
�6:����G�ys���rb�c�
�O�l�撟a��d����p�8I�_g�	�[u�78<A0���}���E��0�Q�M�h���'�Z�\j4k$6�#.��u����%�Q-"�W�͌9�u��^Y��j]��}��z�Hi��J�i���.�dG�����\}���k����}���YX�����\Y˹�?�p�w�
�c�O��zL��ϾS�����N/�a��M|E4Ტ5�9/=2ɽmB�sL�+m��e��w�D��m�{��T�����[w����b��6�%�d�����)볕O��"�n6l�Z�6�P4��BO6
~٭�`�F��x�n���[��R�u�{i�F�{!��_6J����(�2��\K��<i���������o��hu�џ|�xl���;�a��1H����y��ˮ`5'��������h8ճ��U�[eC���[Ev�I42�,�tA*k���'jg��(��K�E��m8�](x*G���D�8�\A(�D��Hё&���I@8�����D�9e��zZ�J<ّ���������	#�;bӢ�_��1���c�ԩ�ǹ�Q�D>�L���
o�	&/���:�_����~�E��@���T �Pq.�pi��{�.UC�Y���Z��~�#�o�G?Ć��iGs�:�e�K*ғ )m�΋cm~�OH���T|z�?�E)_�(zE[���Ĳ_W���
W�u^������T,��Y_	n9u�a��z�i�c�@��~C@�n[s '��37��[X櫀C�26�'��L���>7F�je؉һV:fM�Ք~��WF=���,��&���'�!�7�;ǬT�6�VfT79����t/����B�c�w[_�օ�?^m��v`_*��Կ�<��	�+� K�-�B	
4�͙���#��	o6]�Q5��Rb�J �L �&}zj�X����SJ<�x����P��ڡ������G����.7w�k���\�����8<W�hiJo����O��d���&��;�2-6:���x^�z���x��R���~)(ғA�tp���ՕeХ�E�ޛR;���\z��H%Y!���$�k�\˰�u0C��{)}�j���pb��_T:&*����v$�0��
mB��������{�vTB,�P�ԝ$]��mL[�/
�|�l���ח��(1��,�|��w�8�G�f"�N�f�2AM��pp��vҀ�2�o�p�O���K�.˧3�C.	p(��!;7�ͳ�pXY5�����"�������WQ�8:���f��G�Y���e��ڂq�yg��i�&2f��6?e*�^4_�]��b���!�"Z�U���^��t�k�A1��@�-;R�h����z��N*2~9�8����H�T,��>~/]��U���&�����XV��%Qc��2�й��T2�tz���Q�S��o��$}n1/'����"�+y�G���0氱d���%�:=�ۧ�ڕϩ�o�,
K
�#��s۽['N��zl>C�eE|?a����E.�4z�Ѡ�C�3���%�0e`X ����S\ ��]4��Q��F��*Wm�O^	<��I���h�V��֕M+�<�63��r�`�Ȯ~񤇦�+dEu����$����`+�;ɱ�e7FB��a���\��cK��pQ���7���������Џղ2O_2��8�!6m�0�c,�滪��VaZN���B4�QW�MrjY��W�����e!�d%	�ku�s*�����x�m��$�4���.5j��\+��hZ���3o���e�im�@߮��:���_Z�z��S�B�:@��Z��u�Br�i�i-.�\-�,��.��#c��]*�/0�>�ŧo��7x��C�&�j��>�»����@�0�P)�!F%֮�oQ5�E�j�ذWFx�8<E���d
wm�)JƃG�Ye��P��,%�D=�A�8O<hs�c������FcN�ٮ���������$��
�X5ŲyOC��A��/�T��F����o��:&>�9$UR���)I��CS@�ӷV��3ݖ�3�x rG{����ke����݇�l�{�i��a�˔�TV��� �_'��M�g�#3�Eӄ�����f�Ց�RlhV6ڢi�̞��ꀛ��5]S	����������4�r뜔���[8B�|�gfW\�_�@��z�R*ȵh�w��_�ŝ����E>�{T��M����ˏ��o��c�Ju��yUq�ߗ(�qJ}��&U��%�}��2�owb�Malx�VUβ�* ����-���S���>�"�@2}X.q3�[A�)�d����C��c|E�ڬ���aOM�o�C"Pz��"?�'~i�����6��<�����(l����3B�}�
 /^����wu3�>��nus���D%ԟ!�M&�p���l����O�#��.<r�y�*9���"�l�~ׄ��3�o|P��ĥ�����ڲ9#@}�S>��X�7���~B�X���=
�
�����JA\�#�b���)S�-���5�I�A���o�j3V���ׄ��v��Jp���|������O�"�ߌ%�8���Z ��`�ro���P��b+��(w�N��f�gY��u�K�,�4Q�X�6N��I�GswJ8+���,6��d|Cu���s}��f���p�h.�X��<f��'�l@�j-zU��N�}4Z����C�"N����� by�+S�-��=%F)�z4��8�kR��4';[������o�g9-�E?' ��A@� =�(�qڣ��Q�-^�Ys"�Us_�4Uݫ�W�d���^���`G�m�۞��%)�V�:�3���N�\ �`�w��2�i�{ޤ����X]�� �p�ۺ�i�Q�~���?�gY�"|D�dH����SwvoI��/���*�PH��{����-3	SK1�JM�-:c�-/���Pm(+��)����B��U��I��ݔh�#Yu[T���!�[���@��̴Ll�<5��}}�O�/A�E,f� �i��n[s��L��~Q�c��4!/ޱ�x�g����Z-�Sӿ{1'+�lsH��`_��>&�?�.������@��s~���FP_0���*k�w�Wģδ<�_p�B^`3|��V����\�D��P�z�wWB*d����|'lQ�є�bi��{jپxM>�ᮏ�/1�c�z�b�&���lU�M0�0I�
�Rn�N���,�}�1���x:/k\ZSڲ��E1�^�Ⓐ�^�~��6Do*������ob90�&v�,�e���B��H��w+f�<h���
�@%�ӑ_?��Ck���s%ԑk��LU�1 i��}�z� �c52?���]�������٨qfL�����c����y!G����-���X&�yD=�|Z2:�[���P��j��u	T2��u��}���$g��"&ޫ�v��}_@ݗ�Dٴ:ixS;o���RД3�~]-p��<�.�u�{@]�J�D�;y�DAP򃶜3���V�u��y��. ���~�-��-�TŞ����h^:��v���I���H޽+�f�}c-D��djY���N5�E�Uv 9�^���w1#ŭ�U�yn6}�/֙/��jw��j꜒_uz&�=BϽ\�#��d�*F||��ۥki�'���:#G�^�e��M�>�W!��*�=����B����9�HL��� ô�d�{�̶�S�kmA��Z��fm^�������#Ԃz%zEZ\5a���+������\�1�4�_T��" �[ٻt���\5u���ܳby�Kֳ�#�
U������4;�㗎�S����6�U�xIi�o��/�77j�� �8o ���js���Z��I� s��w���kdK��1l	;��w<J�>)�r�QrҲ�,_��������*K���ݿh�T:��Fƿ���c�n��8��7�9���AVn��$K���ޏ�,y���c� u�2;[�{,H������kb)r�"�x'�p�D�愈�V����Ȩ @ zgW��#8Q�����3�3�qj�U$:i�ң�F?��"�7N✰v��}�pJ�~�)���3	M�q��DOu���t�ӏ�)��¿mn�%^|IM��������BNЋ�V�|�� �2K�0�g�K�d�@	�.:��j��8\�H��_�����E)c}�)�'ٹ���ר1O���,5�f[����@`%�F�OR�?�1=�!�g����Ҫ��O����Z�"9�l6)-(�����V�������n0䦹H���xZ�<r]��hYl�ά!�yѲ�?�J���Y���� jh����ԝ������Lm���jЕ��:w���[�ٻ�]C�E_��g;�d�uΔ0s��&p��!����lU :�*R������KP>�\hZy�b\g:T���՛��]�~��D�C���x���j�Ⱥ�X�������n���Dp����'�\H�Ӡ(E@[�RΕ��EU���a�qau�����gS��]�=ڂ(�;������+�K��9(������MPR59�I,u{땢┚rE��[��y��8�zF�3��{�{_��|0��LQX���h9�f��ƅP�Y���|rq�1[��sK4�I
��j�OM�^�ѡ��U'�ʫ�ӕ+�$r�U����$7�/�DZ�J��<��9�*F�wjޝBړ5r[����(q���<� �����A�K��Ni�%�����_����%���c�p�x�I�9�}�߫�k���>�A��/Ќ$�E��Bq82@�R��9A_�x:������1JN���3M_B�O;���Q��D��^

�Q����6��JR��)����"z��ٻ��2��^�c6#_W&s*ɡ��k���i��Z�b:Ar�2��/��	�j)�(�����ĸ��Ix?N�>���tc�y��|���r'7	.�H��"��)|պ��u�(��-@�۶�?�Ě�d���{�XR�=~��Q��_�ڷ��dg�M��@���d�g�-��돸�!F��h�q	s�X�{�<�cVQȹ��L�i�rӲ"�TX��_	��L�)�nK�����)-[��C�X���Ÿk4#���dPIya2�
����#��蕄�%�L��Y�S�I#C���o=��]N<^2jz��:��dRWT�=���?���g�ks��gi;~��w���{g0�p��<��n)"g���@ļ��<Ǡ_��~K*^P��LדO�':zѨ
^�2���G$2��Z-��qH�Pw_�(���H�{�Q�(�o�l���Oy����S�A���v�3�h�t�h�B��E�,�|�����d�k���c/��=��RM�t.��}�<�E�Zt4�#���b��M��Λ�r����y~�0�5�Mm[��@��_e��m8\ ��/:҄�\\����\��~��_԰��Uğ�l�`��pw8����*��zr"�pJ"(Y*�۵�t��\�ܼxF��k;J7@����7��uu��ϰ���>��Γ��_Hm��;�)����ј�4�ye�Dok�˱�$x�46�Z o��
��,K��R�z�DKH`��*^w�i�<�З����}�/asܮ��1����YVM:#akp�{�v/��ˀ��%o��"u�z���h��@l�'��*37O��6"]��tS�1���|�+
zsk������-̌����/����]Cǩ�����!��-��) "��E�8G]��Hs}��M"�ūi��!�_�' *��9"��)���x�y߯Tۜ5[�-�A;�ه�n|��cƟiV�K���U8d�4{������YH�)X���&���+<�I��2ϯ���f:뱺��^�"�gFO��	lPK��H�a���b���}
�<w�՞m�Lf9�����A��U}I�-��$<�"�����7IJ�B2�^��7H��lK��b~��=j��e�#�u�<T
"�>��_뷀�t���.���TH���p�1k�2�ITL{G]x3Ľyw��hA��b���0�S�?�g	7��=OK�DWв{�-Z#�(��&��U93fK�,Ǟ1L4#!���aǿ@|G�"�)����Ir���1��v^A����Yf�jS>����f�^�T\7���R�<����+������5�OU9Kn����C���e'5��KLͥ�.E��_H)1ܙ�f��dX�?w%���w��f:�W7��Էu�H���w�qR��o%'Fl�Dq69ym��PI�(+��BZ ��'tw�q�in�D��q9d��W���|�������.g�[_��;�w&�Z�9BcsZ^f]B��L�+��ȿ,�HcK2LN��k6�^�$sh���d�e�g�Q�����A� 03�����:l����}_Ԫ^���Ӻ�>��ZM���m	[�����bdM�j�_U;��~OS�k�X�@t'��G�����?_C_:s��;���?Kq�}��oX-N���/P��)L����!�6�9D��V'��J���W����Z�pJ�h.jG{�Y�%ן��>����N�(�^��z0��R�1�M�#��LX#�yU�}������(�䆋8���_i惈�c�.�68�'��1X�cǆ�'��C_�.֕l�w��H�j���r�ӈ����.��}& p~g�5�Ն7�MJ�v��M�y6Uf�T�mcV��E�w���{2
�â�Ky���)���q��$���O�E;�K+]�zucgsZ�D�`��Fluw�F]��&
�*d��k+��;ּ\�|kj�	��4�H�0.N�>0�
��ټ����ɹ�b%�Ayݞ9��n|q@�^����0Ȋ_�ٷ�yD�3��#\�0.�L��Z�U2���4Ku�zr��?nn@��:����G�$-�4j�R�P�)6��� G���T�"�Ì/�Wڢꛢ�N�+"�P�b���-[I%�M��y�m�c����'`%�п~�|*��+��u@i���z0\���1z'u6D ��H�<_����))�k�����j.�:���@��m�EՑ�ҋ�7X�VSK�XAN"��C�le��՝��q��*��(#$Ula<Y�4^��`Na��\ ��ɘ�Η\��Y�f7$ k�o*ژS�-��]Tv���%���Al�?�j0�RG<�zF��ԝJ�"���?y�z�,%�sj��V��gk���մY{��_�-C�)�������ϙIZ
�P���F�����d]���N8X����K���s7uKQ���D�~=)  *��HF ��c�mZ��	�|l�l��+n�U���l 2DZ�#"؍��x}j3�U�����;����7R���$3оLq�ru���c�% �ߞ^�]���1<���#���:��<d\�V�^�!��>�Y����cq��G��FA�f��Wr{�_�Ɩ�G����?��b����$^��I|�{_C��u{�Gogic���b*rイ�ꈜRuV&�����q��@i&���R���V�V�g��(��`�6��M�Ybƒ3��a�^���(���b�o�ɼ�����M)�~L���,R���(�v��ZG�J��$��K�s���$Z��i�ד�`a��ː�E�}�i6���P�M�0EC8�X�J*\S(�A�iLI������ӊ�w�&��W�+�V�c�٦A<Gv�r_q�I
.�-!�Vk}������1����������\x��X���z�je;b#�@��!�M�x l�^�b� T���4�#��(�����g�����~6�����$���9׼�&���~鳰���c��g�磒dB[�N��y�"B37g��FOqH�cv��g��F@�>��B�,�{ًޔ��_y&9 �*((��!Uyl�J��tg��|�W�{���Z4�g�1��vD��w�o�N1Iɪ�n*����ʬB�O�)�e5K��,���ʌe�&˳�F*$�����_y�u�g�F���[�b�R����������cVׂ^��X��iYI���w֛n��*�����zy���(Y^�Q1��C
�ۼy`8��2�&��I9���TzN�&�d�ɻ�9ՌIM��K�e_A_�_M�Pj�k���������d����[�OV����(J~5i����������p3����Wwo���B")���w�`�TK�JW/�i� ����g�Iޛ�#q�ٸs���+CIk�vw�
��b�`���R���Y?j�	���׌ln�b���n�|js��v��e��������ͼn��G3�t����,��X�xTG3�M�sh�����x�u�
>*��!����𪏸����J5��p�-5�K,D�\��dB��o#�<���;N��?��L'$�k�Hfʭ.o|��M�}x`�h������DʚDwv�!9��ʹ%���Sۣ��"����&*�^�]�O�����hk��g��ޜ?j]��l�=>���7��e3�Ed��TyB*��X�%}���c�qA��#e��GRW���;ɾU�"Z��k��/��<�Fh���՚L۬�#Z�]WU��1�� >޻p~��p�8�K�Y�k�y���䰙k[�����ۍ�����c�`p�e�DH���bI�7O|Tҽ{2����:��P�sU�����n��msj��ʸ4�35�]�$d��Me�I�����Lg��"��}l��sk-�ф!$�0���oEQGe�t��7[ָ﹬)&˖ȫ��Z�����U�6�S�t�ʴ�s��d�njs� x�p����އ�tr�?���{���i�f-��cu��G��ls��U�Z����S?��Rg�R�����Q��4�|��:���;�ڳ����������N8\�.4�F����na���0�-�IRS'k`q�F��zi�Kfݽ�%����bT���[��p���I�y��^W��/�إ��i��L�\",)v��yFw�k��������|.<Y�|ґC��S�����q&��F����7-��O��6��_�T�$ݘ�ԋ�U��6_8�J5l�'�,l�Gvᕤ�i�\���S����m���߁ܜ���P����J�P�޷�/&���C����&�xO�s����XNP-����p�pOҒ�N$=�UhJ�m�O(��0
��Z�sÑڶ$|���i�xON3�8?��r2� Vʟ9��sѻ�&��D�=⫟�������6M���Έa�.T���l��7�A5��]4��px��n8V������:l� �V#	#�	�@4ʩ�z�:��P�.�6=xő��Q�bB�~�3�b?'f�� bɪ���4���Ï+~���/Ӎ��?θ
�u����٤��I�$���E,V�ȋ�=�9������Rc�B�C�eD4�x�!.�ْ���g��8��vͬ���1t����Կ�2��d��"OŔ�Zɵ��P����*+-8�l����[�A�Z-�P� Y�P+�"��/��Eo΁C�L��gvĉ�%�?��t���ˢ7 ���]+�fJ
8Gz����>�2�>]2z��2"EJ27�\ߢȎ ��{Q�>}�;����:q���^��5@�h�}��t��sLIK�Q�g��NQI��=+� i~�"���Y����C��O\c>k����J?@� z���8��_�¸�{"	S���uhԨ̼g�/���z�ݟ�����W���T��3W/��'�.cE���VƇ(�z����Q�;L��	Zp��6��pOË'G�Z���۶�{�eA�9�~ª�?���E!]f���߈����[�m�W2���f�=�#~�G�2*l��o$(�E�;�G1�t���[q�K7T�#FCN�i葶����s>Uܾ��в�o~B���4nS�ĵ.�L�}I��g����O�jW͏�]�O���o���@�7LD�:s�
8]��^�H~��K�k�l	�VS/&?�`��a�����-�w�t{�Ι�O�l9T�?3ҪZ��O��q���i����^T�[L0<��P��~����_����2�Fm��J��4�X�`��)V��E�DNC�{�d���ڵ���.�'��FNV#W�]l-b8Eʗ�s����3�c,=�p~!�i�����Q'%?{���V�S�ػ����.�Ϸ��lA)�,�h�vݕ�-�a�oY���yc4�Z�G;��� O�uC<Ǹͦ��Blh����C�ֺ�����5�SϾw�E�q-D�������d��8C��PZnȄ��e�%�F�[K�W$�R{�\D���.,Ff�\'ݵU�s�����yj7���T�ֽjPo�A��o���L�1b�ع�&\6�p�U�DXiǾ��y�-=Ue��Z��R ��'au7;,�z���g),Hq���2�uӔ�B�ƮR_�<��TW?&U���McT׽/G��f@�� F�H�"]V3����S�Jw�Pѐ+c�m�x4��Ls��t����§z��B�Ґn}�3�'�Yþ�z�?`���5��A��X�9M���&% �t�T�Q@5_r��-eUf� ygR��ΰ�<@4�,ݩU4ר��R�Z��~=������3j�M�V���)�<Mb\���������sƋ��G�s���Ny�^;ܥeY���XlҰ�1	����⊔��Jz��=�%8aKm���!�-6	[�,�ֻ?�1�iZ������Z�����7�ћ}���w��4^Wf���U7�����L���(����b�� y�<�tZ����y�S��<�7�~϶��dw�
˗#�^&%�jԢ;f���Y���n�R�~�QU�<+ҡ��*F�9ӟC��%=hSw0�8����:�1CW?Dx�9�����y�Xl'O�V��^�x�I?��0&��/r%b�g pi~ ��n�ۮw"��ق�&��(����{����!k�rU���Q����M�ݎŻ�.��Z��td����r.�v3�M�
y���_�����h�H���vJ>OAc��l�'��2S�ޭڴI�.[���XGQ���ݾQۣo����*Z�M0�OR!�H��n7���J���+��t�i
��4{T���=�Z�I��)ji����_N�5�ݐ䎜c	��9p��\�(b�-�ͼ7�3��jS�ü?�lÒɟ�)AB}�ԔN,G�6M�멍N�,#��z����[����(�6r���K�d>��K/�}�	j~P��I���WaB���s�k#7�S8�Au���Uvݵ�h�
��X��)��Q��S��
��I\s<W&ͦi�3��F�c����?��;�G��ǽ��tfBH2-�O�*ĉ��&f	���d��n�9ާ������
a��'^ʹ�ֶ�G���%�^�m_��oֶǵ��G܋^�G�G]%}Kx��$�i�ymx�������(s7��D������λWN�Y��s�a[O�~�gW��������f(������s�kc��;��î��E����\�jw�����mw<���&Y�Ǯ	��课W��~f5_���\/]8b}��9�_�!�'�>��nW��'w�/&j:�C���$ҒOf���t�� W��KJ�O����>G�q���~�{���\�o=|$~����N����{�9��;4�<�^v5����n����`��-�X~�&�٤��8C��{7J	�� b7�N�K�*�ˑ�L������^�[�����ӃO�'Z=ΛE��7���X
���Q��K{!(�ɻf�O����v���3��l�G��Q��oV>��]FG�TX��㝍7]�M���f�EбM�����/��)a&��A淴�<��ԸF���K������n"u_������/�>�B��zy7|����o��8�,��¨���M�y"(�����)��E�4�w=G`�|<��մ�&��eF���K�#3U�_��ȭ3k��Y�S�o��
y��U�1f!w(h�6����N~��]�S�OS�cƉ~�2�OL��İAL
��]��dr����{X|�Rm���������-�'�(5��[�Y9��s�C�m��\}&��[px3nrtZ\A��d󆘅:�I�92�KS���.���:��>��;
�BkM~����D4����(�*�i�9��!-��R��E��\v�"$7�ʅ���NQ<����79]M�	������m*���Βl�"�7��1�x��09uu�W;��#��u]�a���-��udxLQ��#�Įv|�o�T�U�"��Ip�m�V��W�6X����W�5�Z�n3wríRy����s�m�5ܤ���u�W�	�z���E�?|�E�5G	�qx�>��A>�a���*M���q��}CDV�[o��qG��x��4��+�ى�|��޲t�R^R����ME~��a�Z��~.��Ӂ����2c~�t��ew6C��5�Σa��9��_�[\Z:b:G�Q0�X�Sq}h��s7�l�=�|��MQ�7�M�g[}��O��������+��D�ڦWt���g:/�oE��1���Fa�*�U��e��r�a����.nt�0rW�r�s׽�s��D�>��b&04��T^YU�5�v-��v1��n�w?�_�ʿz�O@�p_��G�EH!���;x��ۥ���hM�ߴ6��N�lA+��!�<�$�x�"�ڥͿ�vn�:9�	��#n�,A��╉���su�޲�~[���f��g��=���>��ˋ�=C:.n��K;/�\��ɍ���8�]��3��=�O��r[?z��\�:�O��w.���_z|[�������ۄ�Q���](����BM�$��z����ŵ�&1�p�h�g$T�]7��	<0�q���n���d*۽h)��J��m�b���y�h^'��O��}q|�4�d�7߀ʀ��<ǰ��e?�=m��{�R�ud�79�O�����,2��+a%�������E�/_�I'����uY)TT,�'|���2��e���:�Q!�t1I��N-(b%�!����"~���T� ����#&��]۵�������1�9�mc����� +�,��ֻ�ڌ�A���R��Gj���+&���;���3���T���ҍ��x�>�7���8hC`����I�Pɟ�
Ex���Jw*=��i"Q6Rp:!Ӥ&�|��J�ZGW"M�1�4�/�l��>�������7ˡ]S!�9L�V��K���euW[�$t_S�$MN��ӊ�L�,����;{������S��N�8�9�bm���|�����Q���c����
hQF?��c�5`Z�+�̰��q�<�"��i��D��sJ�S�Pk4U_<oP����Wu�s;�p؉��T���(F�c���?u���0Gg�o�*��;��!����K8��p�ʎ��K͝A?��wl�����z��H��g���3+���c��^�7�>���q�n�Ӏ����Eۭ����V��z��u�x��n���[_���s�X�{kw�^�̘L����6{eq�rv�iZ- �k�ϡt���N_@�E������d��G^�+<鲗�HB$<�ʿ"���J�;k�J�o�)!��ߪ��\1�1�-�;�w�,�gO��B߉h�Xqi^<,�#f3 �e�`Ȳ7��Z�:�jG�^�1���" ��~4�^���
cZp1{8�g~)'ޙ�&�Ĉ�TD���n�\kDR�Ԅ@�j��'Ԕ�œ!��~����l��d�qL�{>4�qs^�s�)��[1���JS,�)�
s����!���M���W�u�dx�;#�
,�5I��3��#m�U��]��ƯYC�o��ǉ��wل�U�`��þ]m�i�~��/vH|�����4FD�6œ�F��w��Jl�$�`v0�V��Ԓu�C�.GO��)�����G�>���"9f�ui��uj�+!��N8�rs�(���c�./�Ҿ��ҁ�R\�o��@��}Vj��}c�3'�g��{���vd��^�_��枟�^K���}|C��*��Y�P�^�$�.�+��R���#è�{IlA � j�@����O.�u������9 ��- @0*���`a���A ll��� �����������A�*�a�t��s��d��p�� �@W����5��� t�@`W;T� prq���!��^ 0@�z�t��w��[<��- f ����� r8ZB5��
p���\� ����
��%�����8� ��s�������@#�?T���� f�|<Ϟ��y�y���������f< >.^^A���'�%� �� �@����yy�xX��'k 
��^
��vt9�{�"i�f�E/
�������~��`����D�������h�� ������۰��9��f��@nn>nK3~��3 '�9���%??�����y8y��PK��ǝ������w�� ��XY�z�`� 59563 d�G{h��@���V�tp�w�q�̀`; ������ �%T��(���l���`r��CX 0���G(�@;��� �K��  �`9��������j�e���#�M.XO�.A�� ,�6P�4Tf6`�5*��%�Pr :� [;:� �.6N`n�ڀ̟��;B��� ��XI
ho����Ɓ����8�Ŭ�`��@�aA����������� в������@�6(�f��8BU@����%�� 6�,@0 �eK'�+�J��4 a���qut�Y�j�m��6m�:a���c ���� ���C��B`��=�5�wa:X������(L�ol+jvT�͗��a(uC���P״��,�--٠a���3��� �s��
���8 �A��;��A.@{V���oSNО�� Au�����B7�����MMUIZFX�݁. Yy-��Zr�&��2*Z�W XS��cCFvfQC&vfZ����s�!�ltB! ؜! jcZ�jj 5-5��+ ����g��ǰXi�|�[��@Wh�B nN�6�D��тNOTW�@M��a|��`�� 1�1���@�����f��#���� �b����``z�郊� U�� ��ǁ�P�\���������\h�ќ	�����
� (@18� r@(�8��2hڨ�ycs����?�rqlݠ~��,a�{hȿB�4N�2�*��~�u4�M&��^�*t�[�b��Ö�V0���N��?,�����ہ���?��2����_Wh�A�ڮ���h���҃����tx��m�y x����i��^0���5�g����Z ��rpr�xX������;7���/2����]SP��u�C�'.�N6���]�`�������b��Q� OW����hru�@h�́��
�7$��H�gusA�֯��������b�������?g"0��0���<4��~�>-���Q�! ��<�#B��E���d�}f
�����#����f	����6���*�A��%�Zh:]ܜ\�h�0�����6���PtP(��WP�@L���	EH��o��~�� � �a��M��!)P���[�P�w��k�@�9�a�aC��� ylF�*�r�[�[��eA��o�М��?���!`вy��?~�7��V����oD��EPK�?6,�`&�)��(�P�1�����;[�Re�V�+�5�e���%������� ���.ؼ���E�����K�����A�
{��ppt���?��ɠ�Ca?;���4WP�`h�Ay	:^`5�/ߡ���/k����J�K͟� V�E�?uT�`{/��������o~h}���/���o�����'����?\����������濑�������YST��)s+跾�1u��	J؈zh��IG��0�ߔ�]QQ�	�}�������W �)P7��Ìt��?L_��?��%�������Пs���0�_	�R�{��������_Vxn������_Й�
�N��EA�0f4�d�Y�08`�(���%}�`���@��ߕ�������ã��(F�=�5��?*��N��D�[1��oʹ���������~��#�A �����`�M%�?���X���ݐ�NSKZFC�!�����-�D�ρ/��"M�k���OĠ���?�C��_��/���_X�PZU�DFE��C��K �d�t�������[��-�Ϙ|��9:^��0���.���B_`�wq?GE0T���>9`+�B�?�Y����-`|�
e�?Ulk��}�$�}�\���O8���>Y�w5s�ݻ]�3sv��l���������fg6{��^���z��=]�U�;;�7$!EG$�@Ď#��'�B|1�`���&Rb�;1���~߫zU�=3�w	�4����}��}������ޮG��� �"����D00���6n�w;D��!EC�pԾK�B^{��%4����$֙�$�#`����h]�%ﮏp�:�a�!yJ$�]�Ga l����rW!8�Y]��0~ALt�*F�`#�O
��!9�� V;>*�B�����X�se-ID�� �;{�`��؏��Մ�:Ƥ���q$6�i���ȹF�u;aW�fXM3D�%�����N��"j�G��M�]XPZ�A/�EOҗ�yDZ6�7��s	b�K7��&H��k��c-n�yw��we����:B��Ac2!D���i	?J���!�_���A7e���s�Nߧ�d�t��IE���$�[[��`��t�#�G��!�2� �\(̥�^�8+']�~.R�<-F�I5�EH TAI����Q�,GU&h�{Je�o#R�X����|�����<�X+�>�{�`S�dϑ8�0��z�,����t��9�4����Y��`A��{��+,u�E<��������P�@2�{�0΂��O�֎"#P!g�|(�&#e鲟�cՇ��
-������'t]��?��ܣ�==�:��������Q�5
�&����C��?u~�e�����kh��a�r-u��:d��~f�4v�TZ�� �k�啈��U��{�R�Z$�В#��I��<���XX�d����h��1/|D"�EDt���<�C�(�F�9�P�~A����	 
������pGޮ_:?6�6��pD��T7�xb@�P�� �[��B��:�IvMeN�5A�[�<�����82:���mՃ���|�Q�UaɸY����}
�9��DE�
ѳ�ϟ$�TՖ�b�|.aU	+/�RWSsͧ�4s&hb��N�����O	��Qɘ�rq��8���	�� ��B�4���0�T������h����Z����MW�W(�Jt�9��A��:�H���U���iT��:p ���U���'�Ћ�-����``"e����b�2�6j��G����l�����$�� K�!���I�~#��ajf����5�J�n躀�豚4�`7T�m~��z �V���þ��7/l*���������/�CKA�!�c�l�mwB��}����v�V����)ӆ����:Ů>�?�Q)֙M���LW:���q�e7,ϱ�M�q���F"u��P�8��(�qD�,k<��T�k~V�'�Dg�e*�6}Okg�٠�F	-�x5�*/]��M���N�Ɔ��N���W�rZD�HE�_Yݸܾ�qy���y����u��uVK�F�it]#a���`��p�W�s�Po�	0Hr��k�nBֈ:&�C
���U㊴������@�}9�G.���̛o%iu�ܘ�7x�9)�t*�0�K�u�n�!-�:�f�'p21�j��	�	���(
����S�,�mB��q�%;a=@���_on^�������N7G� xIo�)�n��o�%���
�����O�Q܀f�8�N�~{s{���"G[��IK�%N"o��9���q�&k����_���>�t�iw�
A�]{W�XR�Hɀ�e<v�~������;�=�?dyC��8��nv��������Q�%N%��u5QXG�4���ƀ�N���QQ�V�xJXk�P��T̞&�E���yI��bepDɅ�s�+�&�2�j�8�V$���[k<K�9'7�G���%�D}��E5���JS@ø�k\-�� �GE�2~���z��w�"dL�%��2R������t?��p_6.������K*4K2�*〷3�O��a?��=������p����צ���oacɡ�����V]�N �Id#V�E"�#���!e �:�K#6��@�F~�jn|�!��\O�Q�5"qA��*ARf�����ȀG��`�9��􃄃̭�O+�Ņr��M�$��$��۽T�F�d���p��S'Bo�E76v��a��@
���݀��0١u]����W��e���*6����:B]^k�^��Z���t�o)��;���5u�Qn�
b.h��Ν���y��.fe5��M��<�p�������e��؎V}?.)B����4E:��96���t�P�or|^�~�Ju���)iE�T4+�Qa{�km�T����rt5�6$6�%�Đ���[ �d��m�^@�ǌ�v��=ك�a���ٔt1s}��Z���5g$ӵO�����,L!�K�"8>������lZ�Ko*��1N[�5�� �`ʼ�ٛR�:V�%�@j}4,��]�ٴ�ZR�=�FV�Uu���}@j,�J���?\<�̿���X]{S�ܶ��[1�����P�˧�kk��&闥��s0(�؍@����>/Ke/I�q�� �!�k*/��q��5��ʻ�Ea����s����򢰧��Y�W�A�g(�܂��!��Te�R9]��Ĥ��]$�=�3VW�E�?]xT�f�)�^���oDfHK"S*���uu�8V��F�󃤵��i�_��Ɉ�6�AZPH���<��K�s���Ge�{#?:tͪ88P*[�F~���j�����e;��z%jj�o���<s쬿�]��|�#d������緛��:&�@�aI���ʆ���3J�n�|��C݀¬�x4�� �ʬ�	34ӭl ��4��K�ܹH���r(�琉�H��uF�b%���X�6�e�am��m��*�ei�It��Z�x�û��%��`�}���6�6�/o-�f�Vp�sl��#�ٺ�x�k�&��vX��}o4���"3��hG�20	�y�fJ�Wq6w��w+�.f�kK=vWv�a��QM���?���
,r�4�y����"�a�k޳SY.�YCD�.V���Ք��mf~�֕�uzq�Ir0 ��u��(�}��/���1��`w{ �IŜ��1��I��m�����������װ��D������b0f툊ÐB]�|�A:K%m�<�:�Waѹ������'���.��̞ .0��/�7	ZH
/w�Ա���+][�������K��]��>�v��6X�߸ZS�t����!��r�\-͂g0iPչ���F��DM �&�)A��B���T��e��1+}p��wd2[��	lcc��"`S�윲�F���=Bu�Ӕ!��ɼ�h桦������2r���`P4�:8�Gs��0i�]٤pyo��Y�wc����8],mi4j��L�E>�TF7�S�����n?7$��C#Q��	lRq-I����������jj���{��8��&��L0R<�줡�ݻE�!4nNX���x���L�B+gv���yK�8�SAFk��؀��2��T�ڹS��I���*��L�J�?���z�\�u�Re��#y:��M�w�W3�)W��B�p�J����cjQ��Ʋ:g������"��2��yM��i:e^����1v3-���#���~:��5%��Y>y�`��J=T3�p�AG������j�r�a�M��IE������s �R��|
~r�E_�]+j�U�nn�%���A�;���}�����?����Լi�Zc��k�W�������E�˅c�~S�)|՜�%|�^n�~q��1�.2��}$׀{�mş{��(���fJil@{��0�Bb���@g�"�<Eg�!��M%ǉ�
�rWpQr�^��MZ��$��b&m,��Ѿ5�ƈɠ�2� �㠌-�C�/9��ϙ�����(��=y�;tG^_�>f��zv�*'-�[�����T�c��d�-C����7���Wh���^�O�f�/����zd�+��=���0.c�<����V-6����_j6_򓵃�^�\��U5n�n�n@�)�0 !R��^x�lv4�#Ky��.u��Eb����9��5"|��Ӎ�x��'4s���ң!��UF��M�l`��(#�g�ޤ|��0!�(�x�*���}_oQI�n����غ�޼���yU�$͞c�Z(��1�������f���g�����cM	��G�����"L �ҧG�?����1��C1w�u�w�gqL
$Ij��њ��&U%Pg�{�erBa��lB?�a�IǏs���#�bM�	D���؀'4}�=-�*ǤlGQ�>�\F9q4���	9f�d�5�� B D��������lr��o�<�����mӏ8�/� ����kץ֊��6e��ԙS��>8�p����z�Q{~8�! %d���	Q�k�5�ޕ� p#�̃��Z�d,:��>�q��p�7�/���51�X��� �K##U�m-��P��򒕧&�Gݔ��n7>����h�S�q����@\�j�TD�x�Cs��{��m^�B:���K\�К_4��6o\_�K��K�����K��q�����%U嫲�&�W���OZ�F�N���U*`�g���aS�.��攪��MB��פ2NMFp�sas���d�`���,��r���1�9�L�6�}2ό|��j��;	yE*�F#��ߘ���G����c���yW��\�/�r�L0p���5O��	��S�ӂ9z;�;���ע)�zF(�	��g'.�z����7e� �ǳ;p��F��������5�����Pm�Ψ<rc?�a\���]u�U�HE7�܏����{�r���p��U�S��̶*�&�3��wPpa����Զ�����v��ݦ~���f2a)��@>�vsF��vs
��n���OU�?}��;��ˋ��ǐY|8�I@.d�75��K�����@�怈fNK2I5rX�i�R:{rɀ�d$�N�q���jy�z�s�:{�`a�'���x��B��/��V
L���#����>r7wNk��ҹR\��S�A�O��.e�Xc�uK��	a���2���P{�D`��gOg�1���?'���ﭘ�aХ�Y�~�ߜ���z�����)9����͍k��pR�{T�]��q�WW@s]�(�ӛ%�~�C�*�-����R�5X����*/�kP��g�ϼ��	�ux2(?�o�i	�aV���X`�]0�.���D=i���3��s��>#Rcɇo��[��8�e�XQ�BJ�TJ��^) D=��v�z:
� [j�b���8lV���ʴ�\Y0P�L}ou���c9U�*�3��"���"�f�a��E�q�X˥���	k�����]���;�;x/G;�]}��=xd�ƽ��/��J��D6@��d
���#���!�[�PfBo���9�fΚ � fԷ�(q싴���T��2U^&8d8v��uj
���',\D2�	�p;�'��ƛB�K�OF���|���z$��|��4w���q��1s9<�����o	���P� 8*�p��g<	'�h�J����$A���W����B3�j�O2B�DL ����1������yR�����ugYb5�������_���f�:usV�;��U>+��6Ǉ�	��������*l�̇��dV��#!P��44%��@zg���4G���cFԬk���8U��վZc�S��;TKEV=	D�}��G@�Z�ީ�8U�5褶��U+Z�G����K� �jO�R'~����qn��iD�9C���*�p��uM_~k�aٔ�#%
�g�ϳ�}I3��ҼcI�h��H���z����-#G�m5nM�[<����u��1����	�|���Θ�\��B/�����8p�AV�׌�̀�Y��|Z�q��#>v�F7gH�!y�v�D��?����2G��',,q��0�����uqԚ�ύZ3��9§�S�1��D.e�-$��њ�������0���D��.f�l_�w:l����4��lR�2y"!.�)��f|,�,�@���6�����X�R+�p�������4ʦK9��DOX�+��#��ĥ�k�<�����0e�H���U278f�֌��YW&��%4�O��$�lУ��[��9���7_Y��_�;L��~o�\P�Ԥ���&�ě� 6'y��/TK9�$q�쫎8p4`��\Dz\�/ H��!�ȫs�.E�`�.�R�#�cH��gl.'y��#nz�V@�:!���eS"�h�����7�Y�xI�f�=ި��� =����ƌ`���f�"7��;��D���O��b�i�·��!����Ҝ	��![���Bz9� ���@�D"K���		���|�����6��
����C��%0�Ԡ�a��&�oz	�������sz�"��B��P�(��/�Řmg}�� �I���c��uYZ�s�ĩ�C�L�a6}�Z�y$l.��&Pts�t���=�~��e����2	������{�$iuκ"7/G���mɎ��}���DG�	���OrW�s�$��Z7�i���,����8vR�5K&��Gy��qOH������Y#bغ�NPȷ�ฑ���F�Z]s����z	�Or��u�������\�FL/��]�7��LB&-߉t����S��������	��XQ3aʮ|:�"��e��ɍ�v�� S�5H���+�.O�)w_Μs܏U�r���?6�����E���p���U����SrX֚���'������D\������uŉ�U��p�%;��V57ZHǼ�%L8�M	�d���i�֘�u�Ӌ����MKg��Ɂ�׺LN��/����n�\NL˄����V�~����̱�ZAN�MV��.G} ��������#�h� Ѭ����?쇇82t�dl�׵�>i�f���ʟ-g�����3J�ե�<TVY\ӤL�䶯�KC�8s�����T=�|_�d�#������>�5�>w�~�����N��P�û�r�>҈��X
ឱ�����{�n���t��h�T�H~L����ӵqrJo�������7��;=�z6?�so�ɔl�75-�n���qgl4�;:�d�o<��ݽ�=�]߽M`���Rb��%ᨦZ�rm��|UJ0�K�/��,������]d��l��<�"���Du��IqC��~f�z��T4�D�tآ��6R,�k�u�ک�또�;��O�2���fff�����]yχ����������z�;�uf������ߤ6�����:�#��ɿ����z�������Շ3�D����CS���k�U��+yx?�_���������������v�3�����խu��O�W�/���G��ٷ7���~b�=���}߯��<��gf�M�������s������?���'8���y⇿c���������\������������ͼ���=/>�K���~���Wg�������w��O��|�g���=�_���r��w�MV. ����}���_z�y���<��s?�3���:?�?��λ�������^�g��v��ְ4�wj�������Uo����w������^��z��|�W���ɟ����gf�����;_������k�m����U���������w�G~��yi�a�$p���ݕ��b��?�g^5�(��w~�=���_�՛g>�K�������_�)�_q���<���'���'ͫ���=3�����g����{?�_~�G���䗶f���ԖHOcHp>������̫����������ť��w_�;�����[���ٙ?~?��;^��6�	�Pk�穙�E�8?��g���/T�;���瞽缱���g�����۟��ѧ/��o�Ͻ�\���<��ν@�J�{ᾯ�w)�ܯ�/m^Y/�Jm�r#���K��6kΖʺԕӐ�?j���Z.�F����7�j�!W$���
K�-�c���S[�W��{>�lj��1a�MQ�O�D�@�6���|���A���������>�?&�-�s�&�X�$��j��%Ͱ��������d��]߸�]�憗h���2LP����<ҋ�-�f�Oe04��@p���E�DI��LT!��/`���̖n4�FxN�T�f���L���s���/� ��#���^�b�հ<=�j�T���C��(�Z~0��<9w1u-B����}�[��`N��+2�a�#�b���~��ׯ�*__���[��+�ۗ6/���6��S$��i�[eA�|�ʕ���!�8f�܄瘎��hN?�Q/����L�����S��`mCM���ń�)[����-�x�?fθћ`����;�P��[��j)��d��vA����(�|\\�S�nq�T$
|!��+$9t.��2i�1�����G&*�VJ瞹�����k�j/���g�(���r���R�'4�
;��'� F��rnl_t?��_ɖ<�A����k9A7�k�Wt|�?Ԕ�C7���o-��$H�����n��=��:��x�!��C? Q�o9b��|lS��nK'����䕔�|���C\:�{�5����,�Ҏ�n��{G�*E�ْc�8�ኟ:�uI��?��Vr�dq@Ls2�L�&������:�=�'�e��5/�+ ���`0�K�W.��9}�KI9ΊF�9א/W�yX|��
ɔ���/�ɚ�ILHlrHV��ƕc�,��a u
��)���Z�0\6�������W�R�E��P��`�c&��dM������vݵ=
*e.G�gG�s�a$�t�!ʠtn'�jy��U���qˁ�{,DN&^��WxaL��6$R(FFy��[�����`i�-z)�a���*��we�B�1bX������~�a�)�w����to�MI�yP+
�ŭj���l��������!-�JW{f�Y�����]��I3h��h�*3��EiЪ��� 	�oL��s��tŸ�)�/+�4i�����0c�r�E~0�^�}��v��͢��ԈdfK>G��&{̖dI�ƿ�5�1�j����(I��$���e���#�K��}/�����������P�|M�4|�>�'=�(7^��j�����2��1nz�?Z�����EC�����Koϋ>iR�yf��L��s�㧲��;�e�V����d9�,kIw� %�㻌�Ł�c���?�{�y�M��_Y?z1����^�ͺ�j�t���)4�EE�r�t�O�zC9�G,��1�J&�4߹ :=�qۈ
�gZj���L}���{��& Q�:���䭣"��S��֭/yq��(�@Y\Y5�AlZ���� ��M�B�Nuܿ0�S{��p5�E�����������⢂��N"C9���sj(:2�)�n6N3{�>]��j��բ�������f��9�C�]�^e;1�X11�����.+�k�pH�Z�����8���F�n�Q�M5Ql)��񣶜ͩ�UM-U!�%m>O)f�W2Y�8�o��)+x�̚���9AJQ��L<K��Hep�\���l.���Ӣ"�I-@�U�⯔S5O$9&��{����N��A��v�Ş��%''"�>�22O�&�"`��Y����n�ry��m����
��;�T���/Ou�ǘ���\���]�:�
0
��
�5�����^���R��cS�]��yb���-�L�P�����쾟셤3�JU�&XS��>�-��MKp?W�?XV���v\#�N���]���dq���i6Lm2&鈂�A�������0Дz��#]�Y�&~���I��MY�\451���V@ew��=
������$Nz���¢z������1ÿ�QY��1�7���)��ܣ����Q!�s
fȺjV�<�B�G��	c�i��U~=%ar]S��>�$����	\���)mg�_�㖟`e���"�'�����+a+kq�^��(n����a�Y�/,N[��|��7in͎�r��:7ޔ��puaֲb��?&ćH������d�L$A��4��$�t��v�W6�>�	s����+��k��_V�[���y�`D�}��[<��dC)��3����$ǆߊ�L\we��9Og�{�*��1S���9j��p��Td�SZ��2��"/}���?4�G���6�/�44k3���fZ��d�˭RA�^��8�[x_i8d}K��3����7���O�����������_���>�++�?������/5����fff^:����%"k��hx�;��}�$��?��;#�c��x�W�n�F}�WL�v\��h�"�n
4�炢(��7^K��S>"/�u����%%Z1
40Iܙ�˙3��!����L�s�gt��V�jC�QzC�3����L���l�	''Y�3;9!�IP�V�Bz�4r�oTK���v$�ʺ�����D7$̂��l)8Q^��HhͧU��/���4� D
��2d��V�R�e�kj����I��-�Z�%5���rg)Jg���p�vɭ'��s�Z�'�DnNh��_���X�΅���tT/$�:�R��>8)�cou�5�3X��A����}�����r)�6�T
N ۘY*5��K��}W�$|�S	o'�^LhF�T�T��2A�BB��k��̓牖+��R�)<��@y�M&�,;d���k�G��v�r��pF�;C�.��wJ:k�R��ǅhۼ��+���a���2Z�s5~��e�\�s"*�b.|�˺�����,{�~��G�}�"�~e��mS�B��l�����1]�P''�(�^_  �{�m\cW�v�qm�i��T�R��\�"���$�X�����fÈ����^��[ l�m�t�ߴ7
�⼲�]D����͛5�B�_��"{��E+M���ٵ�T1�F�T�e������MS���a�Ã������hFρT���*g�¤���_*� Ӿ le�PNR2�t��46�K]�F�>��'�>L�2���`	����z��MN/P�#^('K���+Cǅ� �,Ͼ|����O�K�O��n���t�\�A��=2�f���M`��`7L i�T���TތN��K�Й�6�Z��4G2���Rax��L��>l@�y	�K���&�#�����Su ��L��Ȼ����)=���P+%�r�V�2H����@,o��"8�4i���۪�mV���>9����Ak�U�w�S�*#	����j�̆WA����d�;�?��ڮ�9����GP�mkj:8n��uA�o��� ~��j�l<��Y� ����6���r����.1^.^ʐI��VF�o�ILW	�q�r��s���5=�ǔ5M�i�!��b�y3�U ��ځ�4�>V�d<&�._\�8P��w��TE���T��&+�f~������N�9=�%Y֖zƆ���.5��g>���T���$�p�ìR�m�őɒ��$fՏr����bz�>�߰�H�Z`�B��dx4�%p��⢪�أ4��Fo��x;VF<�X��2���_���ùݢz�[W��q�/��J{�k�;|����>��ɤ����UuI���+0G��8�%�����շr��T�ˊ:?@j@��ʃLj/G���Srp�[�G�%����=����>�l{1d z��>�3����@S��.�(>��S�Pi�C�A����A%�\�����
p���h��m�;9w�������l-t����tL�)�	����o�PPʞ.�Yv �b���f��*V���~1p��3a1vJr��)kT'��B�����N��(�+��SAa0������+��f��
�aRZ�g���C���湪E��䆗�%�HՉ�#,���^"tz-pa��l����"I}�?��j��B��)h0�n�W���t7�*�(/����jt��u>z�2t�h3qT]ۢ��u,g����o��P��d��d$�X�2��|��%��u�<���-;�-��^ba�|��K��_��u��Dx��$s\|C3��&��LZ\�
��E�%
y���)
ѹ�٩��z��H��3�SX�`�6����\Y� ճ�x�m�OK�0���)�Eh��}���BQ��z��M���mC2Q
~x�������ރwuk�Y]�-\È_��4��l��l�4���jB�i����kۖ�+:V�e�TO��/y_�-TS<�����s����ZVv:�"�攱C�2���A!%p������G�8�,�ԑ?��eHLL#ҥ�/��3��$;gwH@
!�+j�u� �j�D9��@�z���}����k鼓x��V]o�0}ϯ�EH$�=7&�m�Z��R��2ɥdu��v�����4
TZ��%��܏s�}�h��3��)�8��	P#�{_n�O{L��7�i��nL5%����5.�W4Mؖ,)$j�K	�	�U�#�L��Z� �x`�&��A4���
����Di�7���,�lʰPS2�7u�a��sɡ����K\��+��kA�����>aI�:^�"Qd#M�}��)�l�������G)�KJ�۔����!����μ��̃�  S�
��Z@g���R
y�)�BCQ6���hӃ�*�� f���1z�e�(e�Q�ҢQ�����h��;��F�FJ������n�&�8窵�-S�i��]i����I��
�>\�Q��,ڠ����M�����W��(9�NI}���Q�f�G�B��s̡6�K�Z��f�$-����PTG�<3�H� ��
���7�����d<�� j7��cnn�A{��қ���l�nۋ�Q�)��K	�vf�&�}q�ؔ���s�;o�ەͳR��3�̀.r@,PA1���sbL�����/�w��\7��he�@t_F�rn�VY-t�ߵ�n����I����)c�?�G��Λ��oc1x�uS�n�0��+8�u�ކT���m��a���h��,k�4(��c�k��K$��I�O׷Ww�~�@+�[���}S)�jp��	d�	�i1&�J��}/���!�Ujʹ	}��B>�n�J[YZ��bw9�,��HU�����8Z�'����7��=6��b��cn���<ت�[xy��al�/`~y�h-��?��nP;z>��M+�����a��B�;v�5fY�Ч"���_���1��#��>Z�𽧣�M�|	�ܠi��;����	���������\f�jy�P'|x��;�����r�{�.���(}�Ɇ�îvzKil��iv�7LÛ�:�3S�Ԯ��͸\+�j(�B�R�c���A�}��xH&r�c�.����
�����$x����N�0�w?ũ�Ȁ�3*��`@�X��8�±��.��c'M[Ā'���s�z�eXý$k<·�r���`��t��'��0Fc�>H��c���˃;�U˃��$ʓ�q��k(e|�Z���+�v2���I���N왉Z�g�!HK�҂�Ɔ�B��b����j���s�AlH���]�>��%�?-��ޝ]9W��XU	�%M~��*I+���p�H��wЛ�vZ�'),��O׍�pY�#Ӷ�:�ܣ�Mf1�� ;�a��]�NW�ޢ��^�B;~K��~�m��Ғ����4��-�r]�~ Y.�Ƿ6x�}RQk�0~ׯ�f;���,�+tб��q ��ɒv:7-#����$�uӋN:�w�w��\�]�r�m��|�A��7�k��.��ZZ�b>��bYet���1�!wd�V&��V)�6`�	+6���V�-tv�˻%�;m���b/ĲQ4��ʧ ϔ��>F�x.Dy)n#(`l�#E�C#v�OL�b��r��r W��(.K�[�Y, <�E�	LF����26����ⱳ�����E�%�I� 4>N���0��+�L��+`�0�{��=e̙^M�=EU�����t���^C�X��ߓ�Ňa���0�+:��5":V��Q�,������0�YYW)Ӹ��w���ͅW!pC]>J_�X��o�`���vT:�/��k���P�����"�6z�$C������;[�v6?���I�`S��6�u�B-T�(~��4F��\7���b�TIy���A�|���r�=~��D�jx}Tێ�0}�WX���+�$�f˪�����U��1���w|!@�(q�g�̜3����A�F;,I��[�~XE�-��p'��!�!�T�@Y��Ε.�)a�Kkz�13��z���Ç���������$J�(4�/���@�Y�^�I��A�w�ܹh�ɘ�@�J9�����bK��; `���"�\�?<9$D���%ۢ��寁i�oQ�O,��:LjUB#��N�)OL�s�)P�U:Bk�����,�2#��I�	 L�>�����9awZ1�X�ɀڙZq��9�*��MG�&�a����B�
�J��E��~��r��o�p�2��ȗ�������K���ʲ�I�IW3/�6:�`ޥ8�z:W�qP�m��'D6�2�����&iS�1'�\("9;ߎ�����LN9ߓ1��]�Ԙ�;9M�S�:v.N���\��`�%l)Y��F)t[d�/Hc�t~O�\umM`��Z$�[a�nV���$-�tTx�DfS���Owk��'o��_���L�֟v��%&su���16��S�;l8b�.1�
��Y��O����-'N��fN�c|�׻�����18,��ѱ���aw-�ru^��{�!������(�%�3�G��d��o����U�x��TMo�@U�	K�� 5*Z��(v׎��'T!ZT �����V۲74�*~����7�	q�+��6ni���$�<��������'�M5h��� ����E��8���m�ǋ�8u��i�'��u�"�Q��CE��[�m&�
���G8>r f2�rc�C�a)���q�1��	�Z?e�W{u��H>�e͋#�����������"U�1�Z�L��d���(H�.�����n�{����!�]��u��ɏޖ�ֹ���֜s�~�1���>ͧC���
�Y>R!��=�pE<A�Xp�l�����P�C�:NH�:z��d�;#"�!t1�J�c������&݁T�J="��g��@�K��̘Z��4IH�	��x%b���A�;1�
��v�w,���J��{yY��Sʓ�S?۹G�b���䟥����Bhܾ¿J�O�Ⅲ,xG��gN��c�Nu��Ns��5�E`�!TF�]�y($]�������`�o����c)���,F� �n��O�[����Em�ؤo*�w��]�����!x�\��6��m��*�\��v	�g��9�,�J��?��\ki�,��¨�MQlx%S���M���ܩ�{Ӭw!M'.I繌��c�j�j=��{\���Z��/ZtP��.\l;�����ǀ/7�xvc��i��m�j��gx�;��}��f�%ʊ ^Rk��}x�;����q���f  �����4x�" �����^u�J�}Z/�7~�v�A��T��r��5�������fx�" �����^.ڹ��G�u�V?���y51&G�r��5��_l�yx��$�$�A�ss9�m �Ix�h �����9]�.�L���$���j�k�100644 README.md }��/�{�u67�Qߝ��100755 app.phar g��#�ӡC�I$zh�|��u�+����x�;��}�$��?��%l*S��l�sS��KK2��6��)f�-{c�; ؿ��x�ENK�@�{���U�+7�^[��΀���ީ�q�#�[\�H'���,�=^�Nt�n#�a������(:��9������NM���r���������$��>W�����򂨤��6�t���Xo�K-!�)!�m����\�Zl��V$*��7��O�����cx��l���:	0wYjB�GxM���dki԰�v D~�S��18�_�+����0���*����"��2��k�E]�ҭI�*Bl*�����uH�4��y�l�6R����,9��������<����?r�����N�Z�t����7���)ih��w���aY�A�WHݾ�N�k�z��3B�6�դ�=<K{a��_�L+�m������N��7���)ڶ܊{{N��_Y���i��?o��K�� �Ys�"ږ���Z�Z��f'm{^}<1�(j�'�VQ�1�T����9͓Wz�w��h����~�� ���Q6f�3{����H�&?�3&a5���Ѵ}�y��)�e$	$�|Ém�*�>)�Y� �n7^N��@��I�Ĩ�X-��}�-8��D;�����),�*'
X1/2`Te1�1�����
�E�j���C���E��x�`�tc�Ȋ(h��UпJ�T���ws�JF�$$���2�b�a��}<m�ܸQ�a	f$`���ˊaA�~�hE� z(����H����hN�+���STN؂㎏��А4�o�*�C��8>��h�K�;�
��}G�M_�[�t{��tx���L'�B��*-t�ˋ���4/���S}��4C�.+D�N�@�"�!���)�N�t��oAY�0�1H�~v�i���.����oc���������-�pՒ̍��3BD�D�0���N�(
]DV�CI�a	��ec]F��[��L�G<hT_M��̘?|S�h�E���#���+�[���%�J�۷_�dmk�]+�o(4�I���_9�֙nM�IW]	�+! I�Y��&x~[�(��\A��f
�8�����;�L�������8E�}��=Zs4�Wi�)���Hi:B���G>b��Tj��s?߽0s��S�6�Bxª$`��6���<a����-���-H�Z�t�p3�	�c��g؂��\��/���t)-A��&�7�K�*���F��4���'�u���NO5�����0]����T��k#y��*� �u�g���m�z�x3�^�r8�=x�31����\�c�y�`.9D��*���l�6��O�N<=3\�>�B����&Z���!�hy�6$��Yp�B�����Օ����)�B8Dd����Q=]��_�V�L�^z��z��� q?%�}���r7e���r��p~4�Jʵ'�k�#�f+�#׌{�N� b�����W�ӣ?0����Զ�R���i���@������ؓ�Ȟy�̼�x��(�n�:��9ԇ\��D�42<kNEϽyM&"�p�F��3~�����k��QM�b{ʊ��1� 6,�DP�"Қ+���.���SG��;*��n�b�z�v\@w�{R��!`V&�7�0����t���������ev���~��c|�ً�$����.��ʜd�Xg<�A����Kh�~�Oh0���=ī�M��9.��"dׇ.�i��Pal�2Zl�/�u���M�)�4�<�|���o�h
��VUs�C��=W�9�={�H�\C�fڗ�;�_���醴OX���X���J�'Be n[ن�aػ�w7�C��p����j�C�E`�|P7X�������j�R1%����̺+����2��c"�ޑ�;&���ހ�N���⋿6���@{����5SC�����[�nA���[��y������"~��-���A���@j;g�X>WFEf�H"uE]�
A�#X9��>�־i�JϚ�M���m�֬X���7��ӱ���	`;݄�����NUiخ��'�6�~��ӎ	c;���Mm����V�-l����v�?G�����E��ӿ(-�P�Bq�?c_
d:9��A��l(�;!�͆�(�p�'A��,(~k̶(ۢl��-ʶ(ۢl��-ʶ(�Lُ$(�R��O�xi��_LC-G��\_�jow����+Ǟ�;�8�����޵+l/|Ȟ���kW͌�����+�ԭ���y����mB7����z�ʕ.�f��>�JvM��W���P�X��Ueq]��7펺�g<��齏�C'�p��wp�z����S0�c��� ���6e�x���\4� s*�!�(+���`m0�r�[��RIDX               	                                                                               
   �!�(+���`m0�r�[��\EDN\�S�03�di7޽~'# pack-refs with: peeled fully-peeled sorted 
b64bc1e78a1abe100633259c2f30bcf90ed1683b refs/remotes/origin/main
ref: refs/remotes/origin/main
#!/usr/bin/env php 
<?php
if (php_sapi_name() === 'cli-server') {
    return false; // Serve files directly if running under PHP built-in server
}

Phar::mapPhar('app.phar');

/*
Create a temporary directory to extract the contents of the Phar
*/
$tmpDir = sys_get_temp_dir() . '/app_phar_' . uniqid();
if (!file_exists($tmpDir)) {
    mkdir($tmpDir, 0777, true);
}

/*
Extract all contents from the Phar archive to the temporary directory
*/
$phar = new Phar('app.phar');
$phar->extractTo($tmpDir);

/*
Start the PHP built-in server
*/
echo "Starting web server at http://localhost:8000\n";
passthru("php -S localhost:8000 -t $tmpDir");

/*
Clean up the temporary directory when the script stops
*/
register_shutdown_function(function () use ($tmpDir) {
    if (file_exists($tmpDir)) {
        passthru("rm -rf " . escapeshellarg($tmpDir));
    }
});

__HALT_COMPILER(); ?>
7  0          app.phar    
   engine.php<	  >g<	  ��T��      	   index.php  >g  ��Q�         LICENSE'�  >g'�  ʩ�U�         user_script.php#!  >g#!  X8\A�      
   styles.css�  >g�  �y�         phar-stub.phpg  >gg  ��.E�      	   README.mdu  >gu  }1��         build-phar.php;  >g;  eʐ�         .gitattributesB   >gB   7�]ܤ         .git/config�   >g�   w�z�      6   .git/objects/67/fd01f52388d3a143d749240b7a1c68f3b0057c5  >g5  ��$      6   .git/objects/b2/4101f03dcd32faa77ca6864dcbbd5fed7ea22b�
  >g�
  �w��$      6   .git/objects/be/c2250ead3f28186eac24be257122cb3b084e2b�  >g�  ��d$      6   .git/objects/df/e0770424b2a19faf507a501ebfc23be8f54e7bL   >gL   #��1$      6   .git/objects/27/90a2b98ca2262fb7a37e4a033c7bb1f677abbe�   >g�   +���$      6   .git/objects/7d/f6ad052fef1c7b9a753637f80351df9d821a96�   >g�   �v<$      6   .git/objects/17/46e6abc9d2572ab5c96975f39a1f3b9b0969e7�  >g�  �|��$      6   .git/objects/75/3397207b40a7a498514d4cdc393df5560a84cc}   >g}   ��E�$      6   .git/objects/75/3df8297d71c78508ca3bf9ac15ee89e925c648�  >g�  ��"�$      6   .git/objects/bf/aadb802282e1b2b56312d464f91edda258f422�  >g�  wc	($      6   .git/objects/bf/6d34466a37367a5ffcd00b3e613559adfb07fa�   >g�   ~pt;$      6   .git/objects/cd/8ef609b5cb66ba7183e5c58edede49c80bd453.  >g.  �7�$      6   .git/objects/e6/2ec04cdeece724caeeeeaeb6ae1f6af1bb6b9a�7  >g�7  ?�s�$      6   .git/objects/f1/5d37c0357e2e5b01cfe7d12924a00ba44d1ac2�  >g�  �iL5$      6   .git/objects/13/ca13ffaeab7fc2aa3a5c9b1727d8bc46de79d7�   >g�   ل�3$      	   .git/HEAD   >g   �cdW�         .git/info/exclude�   >g�   w=�!�         .git/logs/HEAD{  >g{  ���	�         .git/logs/refs/heads/main{  >g{  ���	�         .git/description�   >g�   �U��         .git/hooks/commit-msg.sample�  >g�  ����         .git/hooks/pre-rebase.sample"  >g"  ��XQ�      $   .git/hooks/sendemail-validate.sample	  >g	  NݞK�         .git/hooks/pre-commit.sampleq  >gq  �P�          .git/hooks/applypatch-msg.sample�  >g�  �O�	�      $   .git/hooks/fsmonitor-watchman.samplev  >gv  �|<y�         .git/hooks/pre-receive.sample   >g   �����      $   .git/hooks/prepare-commit-msg.sample�  >g�  �60�         .git/hooks/post-update.sample�   >g�   ����      "   .git/hooks/pre-merge-commit.sample�  >g�  D?�^�          .git/hooks/pre-applypatch.sample�  >g�  ��L�         .git/hooks/pre-push.sample^  >g^  
��         .git/hooks/update.sampleB  >gB  ����      "   .git/hooks/push-to-checkout.sample�
  >g�
  ���         .git/refs/heads/main)   >g)   4�S̤      
   .git/index�  >g�  v���         .git/COMMIT_EDITMSG   >g   ��p�         view_balances.php�   >g�   U�Ɯ�      <?php
$home_dir = getenv('HOME') ?: '/tmp';
$data_file = $home_dir . "/family_bank_data.json";
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
    if (is_writable(dirname($data_file)) || !file_exists($data_file)) {
        file_put_contents($data_file, json_encode($data, JSON_PRETTY_PRINT));
    } else {
        echo "<p>Error: Cannot write to the file system. Please check permissions for the directory.</p>";
    }
}


function add_person($person_name) {
    $data = load_data();
    $person_name = strtolower(trim($person_name));
    if (!isset($data[$person_name])) {
        $data[$person_name] = []; 
        save_data($data);
    }
}


function add_account($person_name, $bank_name, $balance) {
    $data = load_data();
    $person_name = strtolower(trim($person_name));
    $bank_name = strtolower(trim($bank_name));
    if (!isset($data[$person_name])) {
        $data[$person_name] = [];
    }
    $data[$person_name][$bank_name] = $balance;
    save_data($data);
}


function update_bank_name($person_name, $old_bank_name, $new_bank_name) {
    $data = load_data();
    $person_name = strtolower(trim($person_name));
    $old_bank_name = strtolower(trim($old_bank_name));
    $new_bank_name = strtolower(trim($new_bank_name));
    if (isset($data[$person_name][$old_bank_name])) {
        $data[$person_name][$new_bank_name] = $data[$person_name][$old_bank_name];
        unset($data[$person_name][$old_bank_name]);
        save_data($data);
    }
}


function update_balance($person_name, $bank_name, $new_balance) {
    $data = load_data();
    $person_name = strtolower(trim($person_name));
    $bank_name = strtolower(trim($bank_name));
    if (isset($data[$person_name][$bank_name])) {
        $data[$person_name][$bank_name] = $new_balance;
        save_data($data);
    } else {
        echo "<p>Error: Person or bank does not exist.</p>";
    }
}


function get_total_balance() {
    $data = load_data();
    $total_balance = 0;
    foreach ($data as $accounts) {
        foreach ($accounts as $balance) {
            $total_balance += $balance;
        }
    }
    return $total_balance;
}


function get_all_data() {
    return load_data();
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User and Bank Management</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        iframe {
            border: none;
            flex: 1; /* Each iframe will take equal space */
            height: 100%;
        }
        iframe.left {
            border-right: 1px solid #ccc; /* Optional: Add a separator between frames */
        }
    </style>
</head>
<body>
    <iframe class="right" src="view_balances.php"></iframe>
    <iframe class="left" src="user_script.php"></iframe>
</body>
</html>GNU GENERAL PUBLIC LICENSE
                       Version 3, 29 June 2007

 Copyright (C) 2007 Free Software Foundation, Inc. <https://fsf.org/>
 Everyone is permitted to copy and distribute verbatim copies
 of this license document, but changing it is not allowed.

                            Preamble

  The GNU General Public License is a free, copyleft license for
software and other kinds of works.

  The licenses for most software and other practical works are designed
to take away your freedom to share and change the works.  By contrast,
the GNU General Public License is intended to guarantee your freedom to
share and change all versions of a program--to make sure it remains free
software for all its users.  We, the Free Software Foundation, use the
GNU General Public License for most of our software; it applies also to
any other work released this way by its authors.  You can apply it to
your programs, too.

  When we speak of free software, we are referring to freedom, not
price.  Our General Public Licenses are designed to make sure that you
have the freedom to distribute copies of free software (and charge for
them if you wish), that you receive source code or can get it if you
want it, that you can change the software or use pieces of it in new
free programs, and that you know you can do these things.

  To protect your rights, we need to prevent others from denying you
these rights or asking you to surrender the rights.  Therefore, you have
certain responsibilities if you distribute copies of the software, or if
you modify it: responsibilities to respect the freedom of others.

  For example, if you distribute copies of such a program, whether
gratis or for a fee, you must pass on to the recipients the same
freedoms that you received.  You must make sure that they, too, receive
or can get the source code.  And you must show them these terms so they
know their rights.

  Developers that use the GNU GPL protect your rights with two steps:
(1) assert copyright on the software, and (2) offer you this License
giving you legal permission to copy, distribute and/or modify it.

  For the developers' and authors' protection, the GPL clearly explains
that there is no warranty for this free software.  For both users' and
authors' sake, the GPL requires that modified versions be marked as
changed, so that their problems will not be attributed erroneously to
authors of previous versions.

  Some devices are designed to deny users access to install or run
modified versions of the software inside them, although the manufacturer
can do so.  This is fundamentally incompatible with the aim of
protecting users' freedom to change the software.  The systematic
pattern of such abuse occurs in the area of products for individuals to
use, which is precisely where it is most unacceptable.  Therefore, we
have designed this version of the GPL to prohibit the practice for those
products.  If such problems arise substantially in other domains, we
stand ready to extend this provision to those domains in future versions
of the GPL, as needed to protect the freedom of users.

  Finally, every program is threatened constantly by software patents.
States should not allow patents to restrict development and use of
software on general-purpose computers, but in those that do, we wish to
avoid the special danger that patents applied to a free program could
make it effectively proprietary.  To prevent this, the GPL assures that
patents cannot be used to render the program non-free.

  The precise terms and conditions for copying, distribution and
modification follow.

                       TERMS AND CONDITIONS

  0. Definitions.

  "This License" refers to version 3 of the GNU General Public License.

  "Copyright" also means copyright-like laws that apply to other kinds of
works, such as semiconductor masks.

  "The Program" refers to any copyrightable work licensed under this
License.  Each licensee is addressed as "you".  "Licensees" and
"recipients" may be individuals or organizations.

  To "modify" a work means to copy from or adapt all or part of the work
in a fashion requiring copyright permission, other than the making of an
exact copy.  The resulting work is called a "modified version" of the
earlier work or a work "based on" the earlier work.

  A "covered work" means either the unmodified Program or a work based
on the Program.

  To "propagate" a work means to do anything with it that, without
permission, would make you directly or secondarily liable for
infringement under applicable copyright law, except executing it on a
computer or modifying a private copy.  Propagation includes copying,
distribution (with or without modification), making available to the
public, and in some countries other activities as well.

  To "convey" a work means any kind of propagation that enables other
parties to make or receive copies.  Mere interaction with a user through
a computer network, with no transfer of a copy, is not conveying.

  An interactive user interface displays "Appropriate Legal Notices"
to the extent that it includes a convenient and prominently visible
feature that (1) displays an appropriate copyright notice, and (2)
tells the user that there is no warranty for the work (except to the
extent that warranties are provided), that licensees may convey the
work under this License, and how to view a copy of this License.  If
the interface presents a list of user commands or options, such as a
menu, a prominent item in the list meets this criterion.

  1. Source Code.

  The "source code" for a work means the preferred form of the work
for making modifications to it.  "Object code" means any non-source
form of a work.

  A "Standard Interface" means an interface that either is an official
standard defined by a recognized standards body, or, in the case of
interfaces specified for a particular programming language, one that
is widely used among developers working in that language.

  The "System Libraries" of an executable work include anything, other
than the work as a whole, that (a) is included in the normal form of
packaging a Major Component, but which is not part of that Major
Component, and (b) serves only to enable use of the work with that
Major Component, or to implement a Standard Interface for which an
implementation is available to the public in source code form.  A
"Major Component", in this context, means a major essential component
(kernel, window system, and so on) of the specific operating system
(if any) on which the executable work runs, or a compiler used to
produce the work, or an object code interpreter used to run it.

  The "Corresponding Source" for a work in object code form means all
the source code needed to generate, install, and (for an executable
work) run the object code and to modify the work, including scripts to
control those activities.  However, it does not include the work's
System Libraries, or general-purpose tools or generally available free
programs which are used unmodified in performing those activities but
which are not part of the work.  For example, Corresponding Source
includes interface definition files associated with source files for
the work, and the source code for shared libraries and dynamically
linked subprograms that the work is specifically designed to require,
such as by intimate data communication or control flow between those
subprograms and other parts of the work.

  The Corresponding Source need not include anything that users
can regenerate automatically from other parts of the Corresponding
Source.

  The Corresponding Source for a work in source code form is that
same work.

  2. Basic Permissions.

  All rights granted under this License are granted for the term of
copyright on the Program, and are irrevocable provided the stated
conditions are met.  This License explicitly affirms your unlimited
permission to run the unmodified Program.  The output from running a
covered work is covered by this License only if the output, given its
content, constitutes a covered work.  This License acknowledges your
rights of fair use or other equivalent, as provided by copyright law.

  You may make, run and propagate covered works that you do not
convey, without conditions so long as your license otherwise remains
in force.  You may convey covered works to others for the sole purpose
of having them make modifications exclusively for you, or provide you
with facilities for running those works, provided that you comply with
the terms of this License in conveying all material for which you do
not control copyright.  Those thus making or running the covered works
for you must do so exclusively on your behalf, under your direction
and control, on terms that prohibit them from making any copies of
your copyrighted material outside their relationship with you.

  Conveying under any other circumstances is permitted solely under
the conditions stated below.  Sublicensing is not allowed; section 10
makes it unnecessary.

  3. Protecting Users' Legal Rights From Anti-Circumvention Law.

  No covered work shall be deemed part of an effective technological
measure under any applicable law fulfilling obligations under article
11 of the WIPO copyright treaty adopted on 20 December 1996, or
similar laws prohibiting or restricting circumvention of such
measures.

  When you convey a covered work, you waive any legal power to forbid
circumvention of technological measures to the extent such circumvention
is effected by exercising rights under this License with respect to
the covered work, and you disclaim any intention to limit operation or
modification of the work as a means of enforcing, against the work's
users, your or third parties' legal rights to forbid circumvention of
technological measures.

  4. Conveying Verbatim Copies.

  You may convey verbatim copies of the Program's source code as you
receive it, in any medium, provided that you conspicuously and
appropriately publish on each copy an appropriate copyright notice;
keep intact all notices stating that this License and any
non-permissive terms added in accord with section 7 apply to the code;
keep intact all notices of the absence of any warranty; and give all
recipients a copy of this License along with the Program.

  You may charge any price or no price for each copy that you convey,
and you may offer support or warranty protection for a fee.

  5. Conveying Modified Source Versions.

  You may convey a work based on the Program, or the modifications to
produce it from the Program, in the form of source code under the
terms of section 4, provided that you also meet all of these conditions:

    a) The work must carry prominent notices stating that you modified
    it, and giving a relevant date.

    b) The work must carry prominent notices stating that it is
    released under this License and any conditions added under section
    7.  This requirement modifies the requirement in section 4 to
    "keep intact all notices".

    c) You must license the entire work, as a whole, under this
    License to anyone who comes into possession of a copy.  This
    License will therefore apply, along with any applicable section 7
    additional terms, to the whole of the work, and all its parts,
    regardless of how they are packaged.  This License gives no
    permission to license the work in any other way, but it does not
    invalidate such permission if you have separately received it.

    d) If the work has interactive user interfaces, each must display
    Appropriate Legal Notices; however, if the Program has interactive
    interfaces that do not display Appropriate Legal Notices, your
    work need not make them do so.

  A compilation of a covered work with other separate and independent
works, which are not by their nature extensions of the covered work,
and which are not combined with it such as to form a larger program,
in or on a volume of a storage or distribution medium, is called an
"aggregate" if the compilation and its resulting copyright are not
used to limit the access or legal rights of the compilation's users
beyond what the individual works permit.  Inclusion of a covered work
in an aggregate does not cause this License to apply to the other
parts of the aggregate.

  6. Conveying Non-Source Forms.

  You may convey a covered work in object code form under the terms
of sections 4 and 5, provided that you also convey the
machine-readable Corresponding Source under the terms of this License,
in one of these ways:

    a) Convey the object code in, or embodied in, a physical product
    (including a physical distribution medium), accompanied by the
    Corresponding Source fixed on a durable physical medium
    customarily used for software interchange.

    b) Convey the object code in, or embodied in, a physical product
    (including a physical distribution medium), accompanied by a
    written offer, valid for at least three years and valid for as
    long as you offer spare parts or customer support for that product
    model, to give anyone who possesses the object code either (1) a
    copy of the Corresponding Source for all the software in the
    product that is covered by this License, on a durable physical
    medium customarily used for software interchange, for a price no
    more than your reasonable cost of physically performing this
    conveying of source, or (2) access to copy the
    Corresponding Source from a network server at no charge.

    c) Convey individual copies of the object code with a copy of the
    written offer to provide the Corresponding Source.  This
    alternative is allowed only occasionally and noncommercially, and
    only if you received the object code with such an offer, in accord
    with subsection 6b.

    d) Convey the object code by offering access from a designated
    place (gratis or for a charge), and offer equivalent access to the
    Corresponding Source in the same way through the same place at no
    further charge.  You need not require recipients to copy the
    Corresponding Source along with the object code.  If the place to
    copy the object code is a network server, the Corresponding Source
    may be on a different server (operated by you or a third party)
    that supports equivalent copying facilities, provided you maintain
    clear directions next to the object code saying where to find the
    Corresponding Source.  Regardless of what server hosts the
    Corresponding Source, you remain obligated to ensure that it is
    available for as long as needed to satisfy these requirements.

    e) Convey the object code using peer-to-peer transmission, provided
    you inform other peers where the object code and Corresponding
    Source of the work are being offered to the general public at no
    charge under subsection 6d.

  A separable portion of the object code, whose source code is excluded
from the Corresponding Source as a System Library, need not be
included in conveying the object code work.

  A "User Product" is either (1) a "consumer product", which means any
tangible personal property which is normally used for personal, family,
or household purposes, or (2) anything designed or sold for incorporation
into a dwelling.  In determining whether a product is a consumer product,
doubtful cases shall be resolved in favor of coverage.  For a particular
product received by a particular user, "normally used" refers to a
typical or common use of that class of product, regardless of the status
of the particular user or of the way in which the particular user
actually uses, or expects or is expected to use, the product.  A product
is a consumer product regardless of whether the product has substantial
commercial, industrial or non-consumer uses, unless such uses represent
the only significant mode of use of the product.

  "Installation Information" for a User Product means any methods,
procedures, authorization keys, or other information required to install
and execute modified versions of a covered work in that User Product from
a modified version of its Corresponding Source.  The information must
suffice to ensure that the continued functioning of the modified object
code is in no case prevented or interfered with solely because
modification has been made.

  If you convey an object code work under this section in, or with, or
specifically for use in, a User Product, and the conveying occurs as
part of a transaction in which the right of possession and use of the
User Product is transferred to the recipient in perpetuity or for a
fixed term (regardless of how the transaction is characterized), the
Corresponding Source conveyed under this section must be accompanied
by the Installation Information.  But this requirement does not apply
if neither you nor any third party retains the ability to install
modified object code on the User Product (for example, the work has
been installed in ROM).

  The requirement to provide Installation Information does not include a
requirement to continue to provide support service, warranty, or updates
for a work that has been modified or installed by the recipient, or for
the User Product in which it has been modified or installed.  Access to a
network may be denied when the modification itself materially and
adversely affects the operation of the network or violates the rules and
protocols for communication across the network.

  Corresponding Source conveyed, and Installation Information provided,
in accord with this section must be in a format that is publicly
documented (and with an implementation available to the public in
source code form), and must require no special password or key for
unpacking, reading or copying.

  7. Additional Terms.

  "Additional permissions" are terms that supplement the terms of this
License by making exceptions from one or more of its conditions.
Additional permissions that are applicable to the entire Program shall
be treated as though they were included in this License, to the extent
that they are valid under applicable law.  If additional permissions
apply only to part of the Program, that part may be used separately
under those permissions, but the entire Program remains governed by
this License without regard to the additional permissions.

  When you convey a copy of a covered work, you may at your option
remove any additional permissions from that copy, or from any part of
it.  (Additional permissions may be written to require their own
removal in certain cases when you modify the work.)  You may place
additional permissions on material, added by you to a covered work,
for which you have or can give appropriate copyright permission.

  Notwithstanding any other provision of this License, for material you
add to a covered work, you may (if authorized by the copyright holders of
that material) supplement the terms of this License with terms:

    a) Disclaiming warranty or limiting liability differently from the
    terms of sections 15 and 16 of this License; or

    b) Requiring preservation of specified reasonable legal notices or
    author attributions in that material or in the Appropriate Legal
    Notices displayed by works containing it; or

    c) Prohibiting misrepresentation of the origin of that material, or
    requiring that modified versions of such material be marked in
    reasonable ways as different from the original version; or

    d) Limiting the use for publicity purposes of names of licensors or
    authors of the material; or

    e) Declining to grant rights under trademark law for use of some
    trade names, trademarks, or service marks; or

    f) Requiring indemnification of licensors and authors of that
    material by anyone who conveys the material (or modified versions of
    it) with contractual assumptions of liability to the recipient, for
    any liability that these contractual assumptions directly impose on
    those licensors and authors.

  All other non-permissive additional terms are considered "further
restrictions" within the meaning of section 10.  If the Program as you
received it, or any part of it, contains a notice stating that it is
governed by this License along with a term that is a further
restriction, you may remove that term.  If a license document contains
a further restriction but permits relicensing or conveying under this
License, you may add to a covered work material governed by the terms
of that license document, provided that the further restriction does
not survive such relicensing or conveying.

  If you add terms to a covered work in accord with this section, you
must place, in the relevant source files, a statement of the
additional terms that apply to those files, or a notice indicating
where to find the applicable terms.

  Additional terms, permissive or non-permissive, may be stated in the
form of a separately written license, or stated as exceptions;
the above requirements apply either way.

  8. Termination.

  You may not propagate or modify a covered work except as expressly
provided under this License.  Any attempt otherwise to propagate or
modify it is void, and will automatically terminate your rights under
this License (including any patent licenses granted under the third
paragraph of section 11).

  However, if you cease all violation of this License, then your
license from a particular copyright holder is reinstated (a)
provisionally, unless and until the copyright holder explicitly and
finally terminates your license, and (b) permanently, if the copyright
holder fails to notify you of the violation by some reasonable means
prior to 60 days after the cessation.

  Moreover, your license from a particular copyright holder is
reinstated permanently if the copyright holder notifies you of the
violation by some reasonable means, this is the first time you have
received notice of violation of this License (for any work) from that
copyright holder, and you cure the violation prior to 30 days after
your receipt of the notice.

  Termination of your rights under this section does not terminate the
licenses of parties who have received copies or rights from you under
this License.  If your rights have been terminated and not permanently
reinstated, you do not qualify to receive new licenses for the same
material under section 10.

  9. Acceptance Not Required for Having Copies.

  You are not required to accept this License in order to receive or
run a copy of the Program.  Ancillary propagation of a covered work
occurring solely as a consequence of using peer-to-peer transmission
to receive a copy likewise does not require acceptance.  However,
nothing other than this License grants you permission to propagate or
modify any covered work.  These actions infringe copyright if you do
not accept this License.  Therefore, by modifying or propagating a
covered work, you indicate your acceptance of this License to do so.

  10. Automatic Licensing of Downstream Recipients.

  Each time you convey a covered work, the recipient automatically
receives a license from the original licensors, to run, modify and
propagate that work, subject to this License.  You are not responsible
for enforcing compliance by third parties with this License.

  An "entity transaction" is a transaction transferring control of an
organization, or substantially all assets of one, or subdividing an
organization, or merging organizations.  If propagation of a covered
work results from an entity transaction, each party to that
transaction who receives a copy of the work also receives whatever
licenses to the work the party's predecessor in interest had or could
give under the previous paragraph, plus a right to possession of the
Corresponding Source of the work from the predecessor in interest, if
the predecessor has it or can get it with reasonable efforts.

  You may not impose any further restrictions on the exercise of the
rights granted or affirmed under this License.  For example, you may
not impose a license fee, royalty, or other charge for exercise of
rights granted under this License, and you may not initiate litigation
(including a cross-claim or counterclaim in a lawsuit) alleging that
any patent claim is infringed by making, using, selling, offering for
sale, or importing the Program or any portion of it.

  11. Patents.

  A "contributor" is a copyright holder who authorizes use under this
License of the Program or a work on which the Program is based.  The
work thus licensed is called the contributor's "contributor version".

  A contributor's "essential patent claims" are all patent claims
owned or controlled by the contributor, whether already acquired or
hereafter acquired, that would be infringed by some manner, permitted
by this License, of making, using, or selling its contributor version,
but do not include claims that would be infringed only as a
consequence of further modification of the contributor version.  For
purposes of this definition, "control" includes the right to grant
patent sublicenses in a manner consistent with the requirements of
this License.

  Each contributor grants you a non-exclusive, worldwide, royalty-free
patent license under the contributor's essential patent claims, to
make, use, sell, offer for sale, import and otherwise run, modify and
propagate the contents of its contributor version.

  In the following three paragraphs, a "patent license" is any express
agreement or commitment, however denominated, not to enforce a patent
(such as an express permission to practice a patent or covenant not to
sue for patent infringement).  To "grant" such a patent license to a
party means to make such an agreement or commitment not to enforce a
patent against the party.

  If you convey a covered work, knowingly relying on a patent license,
and the Corresponding Source of the work is not available for anyone
to copy, free of charge and under the terms of this License, through a
publicly available network server or other readily accessible means,
then you must either (1) cause the Corresponding Source to be so
available, or (2) arrange to deprive yourself of the benefit of the
patent license for this particular work, or (3) arrange, in a manner
consistent with the requirements of this License, to extend the patent
license to downstream recipients.  "Knowingly relying" means you have
actual knowledge that, but for the patent license, your conveying the
covered work in a country, or your recipient's use of the covered work
in a country, would infringe one or more identifiable patents in that
country that you have reason to believe are valid.

  If, pursuant to or in connection with a single transaction or
arrangement, you convey, or propagate by procuring conveyance of, a
covered work, and grant a patent license to some of the parties
receiving the covered work authorizing them to use, propagate, modify
or convey a specific copy of the covered work, then the patent license
you grant is automatically extended to all recipients of the covered
work and works based on it.

  A patent license is "discriminatory" if it does not include within
the scope of its coverage, prohibits the exercise of, or is
conditioned on the non-exercise of one or more of the rights that are
specifically granted under this License.  You may not convey a covered
work if you are a party to an arrangement with a third party that is
in the business of distributing software, under which you make payment
to the third party based on the extent of your activity of conveying
the work, and under which the third party grants, to any of the
parties who would receive the covered work from you, a discriminatory
patent license (a) in connection with copies of the covered work
conveyed by you (or copies made from those copies), or (b) primarily
for and in connection with specific products or compilations that
contain the covered work, unless you entered into that arrangement,
or that patent license was granted, prior to 28 March 2007.

  Nothing in this License shall be construed as excluding or limiting
any implied license or other defenses to infringement that may
otherwise be available to you under applicable patent law.

  12. No Surrender of Others' Freedom.

  If conditions are imposed on you (whether by court order, agreement or
otherwise) that contradict the conditions of this License, they do not
excuse you from the conditions of this License.  If you cannot convey a
covered work so as to satisfy simultaneously your obligations under this
License and any other pertinent obligations, then as a consequence you may
not convey it at all.  For example, if you agree to terms that obligate you
to collect a royalty for further conveying from those to whom you convey
the Program, the only way you could satisfy both those terms and this
License would be to refrain entirely from conveying the Program.

  13. Use with the GNU Affero General Public License.

  Notwithstanding any other provision of this License, you have
permission to link or combine any covered work with a work licensed
under version 3 of the GNU Affero General Public License into a single
combined work, and to convey the resulting work.  The terms of this
License will continue to apply to the part which is the covered work,
but the special requirements of the GNU Affero General Public License,
section 13, concerning interaction through a network will apply to the
combination as such.

  14. Revised Versions of this License.

  The Free Software Foundation may publish revised and/or new versions of
the GNU General Public License from time to time.  Such new versions will
be similar in spirit to the present version, but may differ in detail to
address new problems or concerns.

  Each version is given a distinguishing version number.  If the
Program specifies that a certain numbered version of the GNU General
Public License "or any later version" applies to it, you have the
option of following the terms and conditions either of that numbered
version or of any later version published by the Free Software
Foundation.  If the Program does not specify a version number of the
GNU General Public License, you may choose any version ever published
by the Free Software Foundation.

  If the Program specifies that a proxy can decide which future
versions of the GNU General Public License can be used, that proxy's
public statement of acceptance of a version permanently authorizes you
to choose that version for the Program.

  Later license versions may give you additional or different
permissions.  However, no additional obligations are imposed on any
author or copyright holder as a result of your choosing to follow a
later version.

  15. Disclaimer of Warranty.

  THERE IS NO WARRANTY FOR THE PROGRAM, TO THE EXTENT PERMITTED BY
APPLICABLE LAW.  EXCEPT WHEN OTHERWISE STATED IN WRITING THE COPYRIGHT
HOLDERS AND/OR OTHER PARTIES PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY
OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING, BUT NOT LIMITED TO,
THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
PURPOSE.  THE ENTIRE RISK AS TO THE QUALITY AND PERFORMANCE OF THE PROGRAM
IS WITH YOU.  SHOULD THE PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF
ALL NECESSARY SERVICING, REPAIR OR CORRECTION.

  16. Limitation of Liability.

  IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MODIFIES AND/OR CONVEYS
THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES, INCLUDING ANY
GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING OUT OF THE
USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED TO LOSS OF
DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY YOU OR THIRD
PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER PROGRAMS),
EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE POSSIBILITY OF
SUCH DAMAGES.

  17. Interpretation of Sections 15 and 16.

  If the disclaimer of warranty and limitation of liability provided
above cannot be given local legal effect according to their terms,
reviewing courts shall apply local law that most closely approximates
an absolute waiver of all civil liability in connection with the
Program, unless a warranty or assumption of liability accompanies a
copy of the Program in return for a fee.

                     END OF TERMS AND CONDITIONS

            How to Apply These Terms to Your New Programs

  If you develop a new program, and you want it to be of the greatest
possible use to the public, the best way to achieve this is to make it
free software which everyone can redistribute and change under these terms.

  To do so, attach the following notices to the program.  It is safest
to attach them to the start of each source file to most effectively
state the exclusion of warranty; and each file should have at least
the "copyright" line and a pointer to where the full notice is found.

    <one line to give the program's name and a brief idea of what it does.>
    Copyright (C) 2024 Darshan P.

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.

Also add information on how to contact you by electronic and paper mail.

  If the program does terminal interaction, make it output a short
notice like this when it starts in an interactive mode:

    <program>  Copyright (C) 2024 Darshan P.
    This program comes with ABSOLUTELY NO WARRANTY; for details type `show w'.
    This is free software, and you are welcome to redistribute it
    under certain conditions; type `show c' for details.

The hypothetical commands `show w' and `show c' should show the appropriate
parts of the General Public License.  Of course, your program's commands
might be different; for a GUI interface, you would use an "about box".

  You should also get your employer (if you work as a programmer) or school,
if any, to sign a "copyright disclaimer" for the program, if necessary.
For more information on this, and how to apply and follow the GNU GPL, see
<https://www.gnu.org/licenses/>.

  The GNU General Public License does not permit incorporating your program
into proprietary programs.  If your program is a subroutine library, you
may consider it more useful to permit linking proprietary applications with
the library.  If this is what you want to do, use the GNU Lesser General
Public License instead of this License.  But first, please read
<https://www.gnu.org/licenses/why-not-lgpl.html>.
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
</html>body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f9f9f9;
    color: #333;
}

.container {
    max-width: 800px;
    margin: 2em auto;
    padding: 1em;
    background: white;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1, h2 {
    text-align: center;
    margin-bottom: 1em;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 1em;
}

th, td {
    padding: 0.5em;
    text-align: left;
    border: 1px solid #ddd;
}

th {
    background-color: #f4f4f4;
}

tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

tbody tr:hover {
    background-color: #f1f1f1;
}

button {
    background: #007bff;
    color: white;
    border: none;
    padding: 0.5em 1em;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background: #0056b3;
}

.btn-danger {
    background: #dc3545;
}

.btn-danger:hover {
    background: #a71d2a;
}

.btn-success {
    background: #28a745;
}

.btn-success:hover {
    background: #1e7e34;
}

.btn-warning {
    background: #ffc107;
}

.btn-warning:hover {
    background: #e0a800;
}

.form-inline {
    display: flex;
    align-items: center;
    gap: 0.5em;
    margin-bottom: 1em;
}

input[type="text"],
input[type="number"],
select {
    padding: 0.5em;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 100%;
}

.card {
    margin-bottom: 1em;
    padding: 1em;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.update-section form {
    display: flex;
    flex-direction: column;
    gap: 1em;
}

.update-section form div {
    display: flex;
    gap: 1em;
    flex-wrap: wrap;
}

.update-section form button {
    align-self: flex-end;
}#!/usr/bin/env php 
<?php
if (php_sapi_name() === 'cli-server') {
    return false; // Serve files directly if running under PHP built-in server
}

Phar::mapPhar('app.phar');

/*
Create a temporary directory to extract the contents of the Phar
*/
$tmpDir = sys_get_temp_dir() . '/app_phar_' . uniqid();
if (!file_exists($tmpDir)) {
    mkdir($tmpDir, 0777, true);
}

/*
Extract all contents from the Phar archive to the temporary directory
*/
$phar = new Phar('app.phar');
$phar->extractTo($tmpDir);

/*
Start the PHP built-in server
*/
echo "Starting web server at http://localhost:8000\n";
passthru("php -S localhost:8000 -t $tmpDir");

/*
Clean up the temporary directory when the script stops
*/
register_shutdown_function(function () use ($tmpDir) {
    if (file_exists($tmpDir)) {
        passthru("rm -rf " . escapeshellarg($tmpDir));
    }
});

__HALT_COMPILER();My-Banks is designed to help you manage and keep track of all your family’s bank accounts with ease. The primary purpose of this application is to simplify the process of monitoring account balances and managing multiple accounts in one place.

If you’re someone who prefers to delegate financial tracking, such as allowing your children to monitor your accounts or bank balances, this tool can certainly be helpful. However, that is not its intended purpose—it is primarily designed to streamline personal or family bank account management.

```bash
$ app.phar
```

It is mandatory that you make the file `executable`
```bash
$ chmod +x app.phar
```

Or you could build your own form the given files
```bash
.
├── build-phar.php
├── engine.php
├── index.php
├── phar-stub.php
├── styles.css
├── user_script.php
└── view_balances.php
```<?php
$phar = new Phar('app.phar', FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME, 'app.phar');
$phar->buildFromDirectory(__DIR__); // Add all files from current directory
$phar->setStub(file_get_contents('phar-stub.php')); // Set the stub
echo "Phar archive created successfully.\n";# Auto detect text files and perform LF normalization
* text=auto
[core]
	repositoryformatversion = 0
	filemode = true
	bare = false
	logallrefupdates = true
	ignorecase = true
	precomposeunicode = true
[lfs]
	repositoryformatversion = 0
x�}o�\Yv����i4D+X)bs��٪�uUw{f��vu�n���ⱽ��&�qj_W��z����r�wv$�HHI 
� RB"AA����7�@|ABAV+�!!~�{߻�����xƳ�[��~����{s��hz�6���x�����6O��h�N���p�ҽF�FG���^̢�$��U������Q�N��i7W�{+
��5�OO�Q4
5�Ⱏ�Nʈ�I49V�� ���[���<��h��. �y<QG�(	�����rě��`F?Z�`6���zue�]�� U��p<��A|�+��W:U�4��J���O'i8I5=⿩ĕ��xv#�ՖJN��q����Z�nvTs5���^�'�ףA�Ө�F��Ϣ$MZ��U3�'T�~zI�_�r�J�y���ھ���Fyێ��8k�
��0�p�'ԃ�N�\�ơ���DQ��1��m=S� =|�i��TMH�NU���̝��z�T��a��6��F�~0N�t������8i\]�I��y��Q�}�Q�T�ai�Y��D�gu�T'�p�/�~�R���Y����0�%�y:��LzG�I?������0��$TY�5���-�="��X��#� �I?���0���8+�,ﯼO]��n��9�]�����w��^Ե�WW��+.|�����/C�xpa����h��ѻ~��w���������A^�� ���B�(�B��g��~�$�!$B�10<\���$��g��~�$�Z�����'���IE���?�)��U�":k'�����)]3}������$��HH|=hSrJy�����������i���Q0�~$���%1}�ƿj|�$�Q3c��^{�����w��i��a�\fA:4���{wY.�\N�!�8�q�j޺���صM�<DB����A�="$˳tTc�(G�S�|�G�:_K�D���75	R��i0P�@el��"#QJ�ŀVE�C.#��@��D�Y3�CD���f�o�hF��5�Rr-r��A؟BI�I+J��-�=6"��l@Pqg����*���rS��o��N�(Ga3��ՍU��o*WW
�l^9�w>�؝����?�;8x_���W!'=S46"&����8�ƛ�z0�LSE��$7�VH���q��ð�D��x%	�V���1�-:�uKX��6�a�Ȳ�3���=�b�V2B
��<k]�o^��(���MJ��n�4N���I��8�e�A���S!�Gv����G%�!�nO�4
F�7Bu�W�`�MO����)���d	 B���C�!��@�P^����$u�I?t�vI]d�&��,�>�������^�`k�1d:p'�Qޢ�h�����\�3�4j�������;���K���2�N�U��$0C�6�*��r�=j����3���� r�)t: MsM����MK���J�z�k��y0+)��j��� ��E�&#�qb�S�1�Ӗ�%���y�8����gɯ �5�b�EkOGբq3L��	�P+D{)�o~(8Q&�lF�Mz�r]���,P�,*H�E-qS&�S�̼夺z;%���V�����4��8ڊ�-�\x@h�E���-����V������k���nܻ~���=�ƣ�.})���V#�4�A����z`Z1�q����f�m��F�+�[R���MfK��8��pk>��a����"Y7�؍�­�κ)*��Q���?�ҁ�%�x'���{��jY�&P3��SK��Gc�q�ɦ�VzD�40}�� Jf��tS��g9�S�a�M:mx:t_a_���T;1ԁKX�'	.DGyZ�U*,:�1X��Nc�,l�&8:�d�C�A�P8>���,u��ӟOB~}�HfA?T�[s2[����b[:��(�lP;��=S�t���~��roF{�`�^�N��� ����0=	���~&v�����PX�&OS��]�}�V��o�$�qf��Vc��&�+�R�t��v���]����lv��N�#�[��
f�|;��v`Tؒ���݈��z��7^�,����b6J�'��C�h�DF���=i]$�g�}�>�RU�`��,�Pܝ�c�OPb���L�*�o~�jv'�5�%w��=q8�b�\y����ٔ��Q�u.�t$o�Nh�T�U�ОΨ����T���\��&J\E�<Sܹv���ϰ�ЛYz�i��t���Tt(�-��p�>���8cFuT���}i�����Vj���l�Y~H�=-56g��f�c����]��0�`��yWe<^4��&��H��*�ǋ�$�/O^��Y4��Fk��g�tO0�Og��*m����DN=a`eI�����Ηv~�v_��IʇFG���6�du�bo��W�<j>���ý���;{���h�Gt{�Ž����g���~��U	4���Uzs�}&�H?&J�;�]3i���d���k�T��1'���b-�"L�g�9N��6���O�zO�S��P���A�[-�*�Rv���<�U��%���2V��P�-5�����c$�._�ы|�e`ptL���f��$�2+�R���b)�:Z����.h-6N����)��DT�iV���O�����S[��Y�6�5��1�_h��i�XJwp�E����u�BWZ4I���a���KE�B��h�!�D�0Ħ`�G�	�����8���pZ��&8)��q��' ���4�?��j�fo�����ۃVcD��$k�v��ya��B�PU`������ʹI��&� �eJb"�/I�k�fY���e2��4��Ӿl���Bi���b3L	s�0:u�a�L�;L	��� 7h���7C���}K�w�h�,�(�fq�����'r��p���N*�� !��XF2���#s���'��y_֤�J���*��sTb�We=gM�9��I�4���Κ������>��D&iH���JZ�{��_b=Q~�'Q��-��E�ҍx:#��Cɲ:]�K�D�I�:x��jv�|,�X�m5�R�u���v���q��+y��CBCCDF]*��ޱ��j�kk	�&����z��[�y%W�ܾ>�f!-e�f�@ŚO��I+$�}��6���g6��E�h���^e�T'�@fѡ^��Z����T�!�V�>��r�jH��@�I%d�����l'��:C
<�uA#�l:�I[뫝t����ױ�J�y.���p�����E�X�75��ex�p2�>�%�.�M�S��]|��{f�1��Sq9��*}�qO�|��V���pc�I5^��}���96�b;�E̌D7���\������K�l�IJA�/�9I��h��j:�M�qB/�&+2ޅ�^�S�S�Ǧj��z�[ȗ�<�;8A{N̄@i�*�I48�.��]����K��ٰ���`�����o�4��]�������(͡=Q�2b$���4`O[��҂/*H�TSA-�/)\����6c�ƂL\�Z(�':� ����Z1�\)Z'�l&�YL/�
�!+n[k�C��0�L9'��3#R�$�L�Œt���)�p��S ��g�oF�Z����ɼ����J6���5��Y-!0I-&�J�d�GHԕsP�$׊��pAXКn��괞/"�
a�)3���$�q~Cl�1���\IV7�,�Ì�E�n�^����d�q��W�r��6n��~�?�u"N��z\/4��b�	��7�=K�)K���3����nƪY�-G3p�pѼu�`�|9��s��ץX�ZN�ok� �kU��՗sp��*�M%��.�|B���e�B+���!47���7���/��Hy����ssOQ�Z�B�FT��ϥk|y|dw���9�I����̤˨b�|��A��(����i��"���,��ܲ�p6ôzvז�a7����C�p���-�2iB��\�sΕDc�.�=�X����^�^���{ZxX�ӳt�u'AL�^��v{�x<���+ � ��b��@���t� Rzm@Y�VD��'�1p�vXx��^?��O�I̳7�x��
;��>�����`5�`8S��p��y:�²�7±<�k߄���cF���`�l�=�>k'� ��@���P�ǇAk�g����t�qI/�V҆���1��8�c�H��>�b7r�څ�l���2��|'�;�Q0KB�-.r3��.3���[f(�&�	T�����4r�K�1��7��?I���ƛ�t���9�§�Ĝ�Ve��Oa2�Էq��q}ZGx�wy頫��+�G��4�6��%��=�:�2�џ�J<�F2�耴f���ܦ�~�P�6m�E{)u)}���]��)�K�l.yz}PU�巃+v�:i}����^n��CUe�7֯���I���0�d 5
v��5��)�2[���c���\��l�Sx���~$G(|0��Ҋ�l2B��S��i��Q�-ARteJF5�b:�.ꑬj1Q`Vw.�4&�ȧu� �q"� B�K}:��mުE}9�����n� �;��.,G�4=���B3�+������#�*��f芢���?��$�٦�t���!L鑠��8T@Vo�������:[[��������K�K���b�yj��77�?|�`��Aog�wv޷�޼��Y����kR��ygBc�L���>�M߄��c����n�~��	d���AM�b��1����)6&�0�w��%)�Vӱ�&H�xm7 d߽"�E�2r=: �O���i����'��+"��P�����B����舀�إ�L�%_)�mH� �Q|������E�i���m���^_ns�pgg�L�jF����t��,*\����n?*=P
LG�tI�T8:�;��kn�q���0J�#�6���������	s���<�jR��T���TEd�gU��'�:���*p�G.�]@�ؓ��ň�j</C�Y35S��A�4�M�|5��}(���W��V��u�f բ�20�b�ʠZ1�d�1��J	��3q+�Jdح򠜒��y����6�Iv��B.�GM�n�������D�����#c�S�>�T�%�B��e��^.\�QP��[���ܕ|�����;���S�.A��`ܬ���0 =��LH�CT6!��v��׎�!��� �K��1|C,���賔�{X���Y� �����W1�J��cA�
0��gX������b(�`�+�]{ȘZF�4��v�\p��5�dV����7� �9��
D������kP�	�M�������	b�DR��}��'�{��/�颖QN��X@u��k��w��cA99?�b��K"�J}�i���lJR�M%���]��	�uX]�5�K�����e �ۖ��-B��$p'��G���v���(l���(�![#d�n��|�A� ��P`Qdv�C�lV��t���D���,�_E7� p<���Ɍ���z�	倕�Y�j[��j~�@i��J�2���b��$~��a�~�د�^^�R�v"�ű)&���&�B�h����!��K�d�E���S2O�u���"�p�+W�d��?5�u�3㼁�7��IGF�a1��GT�)���ss�F��~��#�A�A,݋�UN��3�˸��\P$�+$�D��_���*�x�ȱ}TYnS��t[@6�]�6�G��0����.PF	�U̸�RJy�L��6U��8��Jc e�bi��B^\�u@@fϓW�aԪ��a&v� �}�r��f�q���W��U�&��j'�pӖ�!ߍ��m�#����\�s�7Y��Q�帨����:`��k�x����j)3���V�C[�y�kq-nnH~ ��X�3J��ǁ�ܦ��8�+���F0K+uы{�&�C��8��X/��3�7lep4�T�F�;��µ�.�m�>��D4���l�LϹ�V #�v-Z\H����A��$	o�qF+���3yt�q��`�)��dh�)e�-�p�R�#������!eMl���@�tWeOw��$�(�(L��L�mF���� t
�k-"Y>�Yl��?h���l�/2sdԈuVM`�G�/���=���_$�yI-��r���\�{���*��"�O���C@Z�jq�Ժ	��+����l�k�%uG]��jl�#0�_
���c�	2]}�,<��2��Y�V�6ưdF�Ȱ7��ب���ri�g�4�,ai�z.k����e�c*�0�
6XH,�eo��%T<��!d���#��V�d/Z�����!/E��jT��!ȶ���xc���7#��MiCǮp)�$?��nH1{�me�4�ZQ4!mZRΤ�A�N���3.��V��ҋ��ɺ�P�e�T��̃���m�x��Dq�4�� �ZTS\�8�a`�X
e؃��z`ˆMu�=N�ٿ=�˫�UF�DY.XlK(91��F���B��N��B�m[�3�v����ʮ�-��k��ڼd�y�ޠ��Q�o�Mɪ,ݾ[m���ˠ^@XBvFں̠�B&�hm@��"gZ������μLZu���H��ʩ����nd��Z5�4�����)VU���-�����H����dXд�!Ϫi�zP����y�1n)T]{X�Q�s�>y�q
o���-�M�lx��aV���04���D�"+�R4���\q�AS��)��L���O�-�5�5R�_χ�[��Vc���Q'���HcK�<�_�`v!V�ks��=:����⯱�}%^6@���ч/�	IA���O�}R�+f��E17Q�\sF-,r��n�h+%�yj���sD����,8ߤÛ�Q�����*["�ٴ� �����em)e7�>]H���4�S*J^��bR=��O!�� �0�MmK����Y1�/ZW��tq�b�sPӂ���i��mPy�N;��T�]��cr�lQ.cggq��i��t�O.9_z��Å�㪰!Զ��q�@$�[^pDC���$|�	�T���P�ab�Xk�������	�A�~�Kg�Tg︆P������'��DШ�A)��A��x�_H����}�wLլ�����!�8�9�^��s;�Gbm�}���}��>x��!�r,T�Ñ�Ś�g?:F
����+ �r�"�c=h���ࠀx"����$��5Ver�d��݆Ues[�媅��V���c��*]Ⱥ�:,w�n*�>xG6��9H��e/M�3�.K�Ĵ�iQ���1�|������;^L�DZ\}�;j���w�:7BbŜ��fCo\5Ɖ: ����>�J��;Dç3o������lC����}�'�� ��l�����n[יP�H<^Td������K���ԑ�x��n��[����Q�����l�2#��NN�Ss�7��!�͒�������Ɇ�֡�K���x�`�y��@�98K�:A�	G@��!:o�>x��v��҈.4�/�G���0�E��
IbC�>x���2�Fu0��H^��$��C��1b|.���%J&��\��зޑ�5�i�ޡ�dy�_���L�yL+�L��}��C�%c.�W�C�|�dc.��w����ʻ6�0�>x�F�0�]���ʭ�&��P����L�2�q���b����[^o2/�������pH�f�Y����p��y�����mܰ�MBhp���l��l�$���o��c�7KXU���,�7�{y&?�!O]�qG�/>x��dV:U�݁�l.`&�ZX���L��*f��;^^�+s���Ɠnv=����%K�J�\�����;|��f�Š  ��>x�v��0�)�h,��*��}��AJ|�����A�Ÿ��|咹�>��;���ߊm���¸�Gg��}6�����,�'f��-�1?{�v�K��}t���ni7�b�j�G�]cGs`4=���!G)K5*nK����,�;޷����.��fG�w�����+B.��@J���9��Ƙ>`۵���~Q�3�f�A�S2TuN��>:"���I�o5�D��$Z����t	�3��B$�|tb�}�:ݱ����7�k���� -���-���w߳>:�P��.ȹ��΀;y�A����P`�?��`yZW�	�� >:��0�̄����6;��T>:�\���Ȱc���Y�Gg������g1J���6���r4��d,ˠ%
��3 �A�Gg���σ�m,F
��ǲ�4Wn����fx��}t���z��a	p�{YaX���\�K�1	u<��	|t�A�/	����A�M�)��8�яV��$��Ѥ?�B�@n��h2�uޠ���&i|�f�h��G�t:��yQ�����d�߻�#��o�^�p!kE2�DKF4��gG4�TgF4H�n�����_7ͫ�h@)��h@�E4X��TM�o���g��Y�a��h�#
�2�3����i[UD�upl>���h �8֧�d�	�o>�0Dd���i�8�|��Y=8�+y�^���^�/��#���N�kZV����o/'<Xf�O��sv�����'S� P��Ď[�#N<{�j'�G4pM��>N̶`�2�<��<euS��T�2o��R�ݰ?��Fw�����>l�=���i��ɔР�hw�k��ԑ���P��h�&�|"�n��w�3�g#�w��}NzH�<sD���}� P}l( Ƿn��6�q����i��p�נ[RT�'� n§Q?�p�/�W%������SKc"B�q4�4�J���`,Ĝ���Ju@����>���h�#�����X��PԻK*��F/�ʦ�Α'�����#��gpZC�}��&0�ǏGS�y13`sY1^�F��� ��X�ǽ�3��-
��ٚ6��Ҙ9��O�V�!_P��gzU�~�Q��c��I�F |#T'L���,������f��'qNS��͇?�fS� ���1�IN;Θ0��t���h��q�MȮ����c�S��bOY�,)Nn���(T;_��Iv%&���-�i�ɱ�Mln���{������po�������{7`��E��w�$k$M�~���_e;%��d�M�̝<�����>�A>F��/3H3#mײ��G40�_�b3pD������.�G4`��"-���B�1�lz�[�q����,u�W_^�:�<�iLy�jC�����D
j)&�R;|F�#���_ag�v� �O����(��n����E��<���`�h��#d�K?:�Ox�`�]8��S�&��^�r���)�̟6i�f�G4p3���{Y�@�]���Q�჻zwޅ|�L�H�\>WV�����.䟟���.Tm�"���a=Wl݃��Œ`�ZЖ�`��v��Kl;��#*��Z7�=�FԢ��Zl;��fpN�#��TQ8��X�Tf�j�	��b�h[܌cq����i��¢@�\�p����h���i�zbwVӒ��#%��]PJ>��H|D�t�� eN�vܿ���P���T.�L����iF�9���2��B��G4PlR��Ȉ��:vl������#6m�|r�����甏h�#��o�c���U����'A<!P�{� �'��t> @��Qc�
��:���$����#��/1��K0Y�*} �TR�04�GH��^8�������wp�.�n�= ;�2z<DG�PO<(e�7�Rp$����u�,_r*E?�X��Uˠ�:gN����ܘ��( <����^��g�$%��]����Ɠ�W�ϻ^�w��T��Tn�>
 ��n�n�m����weRfȞfHM͌�EEN�\�F�S2Q1O�( >
@���( F�j\�������p�~�S�2�T���A,F����Cn�C�H�"��$�o�s��,�2T�5��]���l>"�Tp��p��������ഓ��y���0�D�(��=<�_>6FQT���4��ĚS �Ԇ���qF�De��~��Bk|�O4��t(�Ƹ�>
@.	2�C>
��@��?>
 �_} ��;dx�|���֢��\o�)�݁��jI��E�'>
 �*I����� ���I�փx�G�Q �i��­�X} �g|�Kd�`o.���Q ��O} ���( �v�jW�;�,��
��;��#ķ�Q �h���(�ރZ@;���y�#���g&>
�p��̇����_U�r�,Q%�h`�3���=o���j-A�6����ٳ�ډ�)�3ZF)t8���5Ф-Ey���׹n��Bյ�O���70�҆aK R�;	�*ŧ�2��Q | ��l]� �( Bd���t@,I��'��?�k���e;�c5�)T^�"B�D�>���ڽ��۪�Η6�x��_#���l0*��gwM@�E� UX�_]��W.\��p��)��ʅO�_z ?/����p��!� ����gF�DKF��gG�TKE���gG��KG���( �A����=��{�䋹$�G�Y��*@��������:���L�� ��S
�Bj~.���$0�����4)/��ص��WT?lپ�5���#���c��HUÝml^�`��=���fհ�<�f�]�U��+����qj���푫���w���@�I)5� qܶ�;}���Lo[�g�O1+��גĪ0!��|�Y��?&̶`�2�\b�� MI<g��
GIh�6����_t�	�VSW>�"���n�y�! Ta����@L�G�]�h�Np��W�mw_�q������[�t�Ka�������0�p���{����������=�{�
�������=�c�v�HX�*U���wp�4�گ#r�R�D׾���!Q�����53��w�Q�cِ�5Ny���VU�fT(�Yڅ�XۯJ^�15Z��bnMC�<X��r+�츊ټ��*�yvj��s�x+�Qq��%��������#nAu�4��Gf�+�liS�K�ב���F��
5����Qf����ϭ��:7��7�kL�ȧ�Y ��h��C4�*yԴ��ͬ/��,h-6N����)��DR�)�<�.'l���6���gG
�ǩ���Z���Ӓ��9����,���瀿mܙ������9��G���d:��"@,��w����Mr]fy�.����x��z����,N\P�P�.X��l� 9F��8������q)�{���E�ܺ�{���$�E���#Q)���8Lf�	��������Z�����_}�78��>akú�1�lӘ��,e�jr=��=���/�bgՇ���Y���Ǯ`��L��g�S���=�{�88�������R'o������ I�}���L�2��t1�]y� ^B*���n�>4��*��̿XW�+�Z2D����6=q	Un��#/��N҈2��Boy���?(V6��Ǹ��4/�m���98Wr�f	�wu�{'9(��\�<�ag��y�t�{���ʜ.6HSHZdB}I5����EVx,�=@����Ic�2$t8/���T7�����ϧ�Hꦬ�L��vι�hl�ŵ'�\z�[��i�a}Oϊ��,w�U��DT�b���r����x��|j�� �'�ÿ���=�;n�7�+�o���{��r���g*����b*���7��ڈc}��d@�D��8�a��>���t�bM��N&``=�ҝ���ܨT�L^�?�p���z@X�������E}�7�Nd�8����JG�8�	""���-͎t�A�T[�z��8��ƣ!���q�{����<;-e\�ILEҿ2�UM��)6E�tet�)%`[��/�U������fBy��𒲡clRyIy��B�)��i���OG( ���Λ[&h���w2�q�Ϯ�K���a��_�v�1��0�q<���}��?����#i�4Uh��\� ���}�b��Y���s`~�4�c2Z�9��}�$>ĦY���5x���DS2��_�m�FQn���2��i�+Ϥ
�������)gJ�N+��� &_�]�W�YL��~WL\x��Q���>lR`F$A頇���)�mi�!��/�#�&��\�iՕ&�>y%��~���P(9$��br�,����/ez�2eּ�Pz�4 4�L�=�N��&�Ĩ���5�/��Í�y�N��&^�dw���\�E���X�^iGȕ�ph���d~�5?R5��?���D;3Xp�W>�/:C��2	F}	����)���P_q��!iׯ�d�Y�Di�f[4�Ę��	��)%�"H�Q\LZ�T������?��l����Q����	�����P3LM��&�.zf,�y���S$�&zs��K��6qD��Lç��ѫj鹹����n�3�>��G)s����.������d��;_��*�&+�4J�}xf/�i��^c��E��P� d��M��)_�1�p�C�*(c�輳�q���R���*kӜo5H� o|��1��)5��M۔�"�7�dCa�*�J�r]ԁ��;����l��,�/Q�	>�l	�5�X*y0�c�=���˄3�Dg$��G�!�������t����MZ:�ҷ�Nb�5fz��Qm��"D�~��?���$�(� ���l����PL����Y���/�u�bdy�u"l/��}:-S�&/2MԘ#�a0G�/�zp�'���ք������&0s`Cd�YNG�5�p]e�4�B��3n��}}Ƨ�^N�Ѩ�|�ֆ��,U7�M�(L�Jĺ�Bb���ߴ��G�������q�E7l5�E�R���I_G���Uw�M�(h�-�I��ÿi��6C9��<����dRa��|{��j
��M��mb)��!���}������{��3zZ�W����3e�`a0��M�qF�6��d�{�?�Gw�@6�a��Y
�eg���z�kuH2b�Z5�p('����{����G5z-�7�����GK�r�������"+���PgNg�����4�ʈ��4�V��Vc���Q������BŵI㭎$�9�o������`S%�����$'W��I�41�G
r���H�)�)�+�tx����	�j�Ge����{=;�I<�ؖ�ji���A؟�ړ��ե�OG�9�d��������@����oW�|�>���-�����>����N�����������^����W~�3��K'����o�����O~�>��_�}g��{���G�w������O��G���꫃o�^������_{�oL������+���o?�l<��_����g������K?:~��?:�Ƿ?c���O]���O������k�����h��~�o��/�����?�����&��(�Ÿx�ms�F���_q����1���TB�ĉ2i'��X�L��Q�,Nv����Ͼp �8�P}�����޾ﲌӥx������l����F.�(q%�L���ٛ��'#a�&�ǽ��W�b���#aW�&�o0�P��5I��4qꇴ��{�{>W@ޏE�oL��J8�}!?E�*�z��|O�2p@���"H`�y�1"x.�6Or�e���
�oe��zq9�����5�n��p	�*�vru�\�������o����?����}�� �I�hu�X��G���$�l��\����t����RP���t$X�\�qz#sG�ц�"y3"/��YV�: �JgQQH�¹ ԗ��eSm�*R�~��j\Hm@�GL&a���H�~&r��Z��p�(����Nȸ�;X��2| ��~�s�0V;QVl\i�w=���|��ٻ����������l���}�{{v>���z�qa��ؗ}��8h-2�����*\$w4<Pay��*�7蟜�i��-�ƿ�A�؂�3(h��D*�*���.$	��Ǜo�%?��[VLŅ��Caks�'�0�.*�v#�(��m�� ��n�h��94��Z�!���:|��#qɛ2,��v_��
�Hg8����^�=���v&�j�� ���%kڃ�6%>��T��~�>���_�O�[h ���\YB��u�j=	�uH����#��[~,'�G%*�XN� ,�OB�>��+�)ơSVN��i�l�2�X���e����s�*WAQ�� �2�l#��d�Z�x��;��FiH��q�RI�ڶ�!���,Lo�m5�s�@�0�p5��5�%>���:��MZ��'~�� �Y'�����{ve�?�@L�ʁJ_cJx��i!���$������p!�K3J��`bYS�$J���Ԉx#t�+���..�Mp�fhʤ &Ζ@����p��S�'D��T1X������i9�e5���r	�����`����û,m`)�re *�I=��^pD�5�C�N���(&���]k�c�'oXzL�r0�y�4�՞F�"����X �G`����~<%;E��˕'y��ƍ�ii`!L���� ����u��RHK�RyC��q�I6"������	�qlM�ű@�uX�M�t�g�L���Rɂl�o_�����?��C��2 ��E&��tue�)�o��4�BFi`p��`��q��2��9oZ�����J��)��J��\�+��P^-Jo��6>iHʷ%,��IK/� �A� �a�R���J�����N[$]��7�5�%d����j�Ύ�E�{˭R�� {dCW_��z������U���\��x|�}���(�����WV�Qn�O����g��`�V>YA���[N�w��9���i�L�.�\[�
P�~U�<�'��-~�	��{��=&�s��\`��O�/�ɎG�ρ��u��x��M/���-g���v��Q2�����{7��k��+�:b�[���k�`��k�T^Ck.!�;vG�G�PT�P���LɎj$�vɃ�t	
h����-���fe�yz���V�U�n:�<��v���U�8��,�2p�uTЦ���x�E`hhB�0��:O�;**45,rL��?��n}���@�8˰�~�������������0���O�i���X���7�Z�.�-d§ ��Z}Vsf�$	�
Tj��kϬX`����*0�R��	�(׏�+h���j��B�Z�fj1�R\���|�qX��9湲LQ�����[�|؀b���Pü����9 �3�^���Ln��e�����L��Z��HUh�9���{
�F���K%H`k�-vi�s��"v8	��
=S0��4%�
� �{ڑ��7�q6�� %j�T?�#꺰n��;�	͢�(���o���:�tH䂒� ��,�o�IsBR±��юT;B���#�D���4�!�do�"K�H��+�����XM��әf��a���5oz��g�ž�>��9�����pv�_p�����أ,���ӎ�*�\�x�f�bο�L�c�H��|�0�f�#H�v��ŕ��QlyQ�]�n3���Q¸D� ��W��}p5��@i���GW�-N*���M��w�J��X�q �� �A]IS�$���4�V�nʘ84���f
xl�Tܚ�� Ki�/h�:�$n�ނ���]�r��l���#�=��+�RB��I���@�1������=�\��nwFG9Ŕ@�d��7�V�49����PGgM4c��jS0�M�Lz���m���)4L(=�KtH/�V�i �:_�q�5����?�i��:Ś��W��7�����O�A��k�&�`��E�K�/7a�� ��u48z�/<��t��ث�n؊����7y.�]|]9E��P|)Ս��k�pu#%7$ ���Q�w�r��٨�.7L�uZ��
8d���s��|���5a��8O�����j[0S�A��
��{���=7��h����v�D��6��s2��\�&��x�36q�c�m)���T#��Wz��o!K���=W�� �k�7ù~�������!?���G��d������%5�����9i�Ƙ�1*��^�8\i�A��S���V���X}U��ӻ`4D�B_=���Nx+)JMU016a040031Q�K�,I,))�L*-I-f����Ee��������~�կ������/ؕ���{o���z�nݶu�Ywgς*	rut�u��Ma����U��L��R3�́��6IM*275UH,(�+�H,bH���U���B��*�U2�7��@J*��I��*-`>%����C��bf�����v��:Tej^zf^*X��U���nښ,t%���E_���2�RR+��>ƚ0�Ӌf<������%�R��Y�[\R�VXj�C���x+�)�kD�u�T=�5���2'�X/���A���ꓗµ���,�<K�z6g�s����Ԣ���̂��g��qn=������Ѿ{�<Op_	�*-�L-�OJ�I�K���&G��g�~-�Y��{zo�ۺE� M��xK��OR03cPVp,-�WHI-IM.Q(I�(QH��I-VH�KQ(H-J�/�U�qS�҉9�U�%��y\Z`���@�\ ��x��Ij�0 s�+t0R��B�)�hI�X`�F�'��c�/̵EQq[��%x����bJ��ko�"���8�G� vj\��&Gk	ZG&瘔
�V�1���$�����J���O��݁�ɢ��3՝zY������x_�����3q[?�vP�IޔA%.z�w~�V|��-��9�-�p�\ix5NAn�@�W�ĕV�W8���N�Vvm�v���wS��c�xf�e�p�?��,8�N��	Y�{��:q��}v�< �2�UREG�9�<2�kNP�۬��Ԯ"�{^�p�#���[��A�}V�+ËY�QLyATRO\�L:`b~�\?�RKyJ{[��
������SÊDEZ����Q�x}Tێ�0�3_a��Ү�QK�Y���Q���$V;r��U����,����Ϝ�9g�2�������n�J�.I#�{�~ZI�uDw�V��!�!���@Y��Υ�n�)a*kz�13��=���Ç���������$R�(4�/���@�,k��{� �;�!w.�x2f/Х�N�cc���.��Xj���	7�O	��(yʶ(�w�s`Z�[T�K'�%+h�	;剩q�4
��JG��j*.ϲ�3r�E�N `��9d�E�'�q��Њ)E%J7M̠��(��#�<��66q�K	Ozq�ЮƬ��?�7��?����1\���m�K�������K}��ʲ-�*���f^ mtR��Kq8^�t�������52N
�l�e����MҦNcNt�P(Drv8�C��1r��r�'c|�3&�n�1�39M�S�:v.N���\��`�%�dyvi��ul�0r�P�`��=asٵ���)�H^�����:5WEZ�����&uۻ_�?�	~o7�3�7TX�	%�KL��Xucl��m��T3�w�p�>]b�x�=.���{����'�[N��]͜��f�w��sicpX:}�ci����Z���mz��نD�g�?���ΌE *�4��~K��F�x+)JMU044a040031Q�K�,I,))�L*-I-f����Ee��������~�կ������/ؕ���{o���z�nݶu�Ywgς*	rut�u��Ma����U��L��R3�́��6IM n�1�x}R�k�0޳��kV�S�:{JI���:�XX�8�s��dI;�����}R���E'K���qK�p9����IUKm+��[����@�V��Ҫ�!�f3(j�G����r$�2���`�ϡ��4a�f	���ڮ!��o簌��H[x�;!止�S>e����*�WBTg�P1���;R��[�T�|dR5������f�ψ������`a�Yf0��&�PT���Me����?zU��ٔ�,K��hxp���1���0�L&��1=N�����2�^C�;Eu��IL�ν��/)�����S��t��7��8�&.XѳEo��ºu0�_ˁmp�'��e�Ӫ2�V�u�������\	�B��b9ȣ4Z��;0b���4�,D�/��i��CM�3v>d�)$��+�����f�ly( ��Q}?�9��Ř��E
u0�i0��ch�E�#lҒ���.�����ݽ���}����g���l�x�V]O�0�s~�Ej��2m�(��	i�4@/S�"7������ﻶ���aH�K��~�s�;�r
o�}x�����WQ<�%�y��#ܠAq�>_|;������(Ιa��Hf���g�,�"�2q�Z��/-��8��"3��%��I2�?��00]б{]� �)R�]h���|�zZo��`8S��fR���G��
M�XTi����> �jzåИN���2�hvG
5��b�¢��*�rLHZ��&����<<��3�:���H��SBѧ����yz�����'=��_[��\c����������L)���B���3G�0�6X���#���[�P���T^3��5��H�V'�6��*�I��<%_�E�gj�i%mK�k�oL��F��=�Ĩ�c5�m7�F4�l�~����
�)	�8��j<Ɏe�����;�؍���s&�!��٤�#��+��FM��H�|����5A�_���o]ԠYꊆ�f�#j*y�����/�Rq�q�A�rl�[����O��$Ĳ��'!W��V��=h�j?�xb�րt>�嵑V6�c�]_l/��4:[��8jϨLgk'�Gs������[�@��\�����eM�[�H�8͓���q
����nd���!nV�ncڮ���Sgڤ�[Z�8L�zu�X�{��.��j����?��Ap-�ӓ�s�&x��A
� @Ѯ=��@��B�ǘ�m����޾�^�ۿx|WR�����шր0�dH�QK��-��փ�Q9��hK�<��S}��'�c'ϲ/�7jq�{�{�K��韱-�ܻ��\	�@�Nh��Lf�=�i�?�}*@Lyx�Y_O�H��|���G�Iۻ�
젖�WNzN��{!�:v�ސ���~3;��ڱCR�ԗFB�wgfg~�w�$N'��o���9�O睝i:�^e�e7\����~8=u{�`�ub6��wvB_��us +Y��\��(���w�&�~�z�"J�~(w���a��������rt�l���Q.r���iN�ˠ�$m� M@�*ID�E�0��y����2�-x�����j�s_����XF|Z�#�V�E�V��OL-�8?=�>������ut2�N��N����"白��3���0�-�
��E&�8]�Ȣ������'Q�sAf]J��U��\�a���q4���,����|��VF��#�?�b���lF����ut+'Ei��|^�Ga��b#�h�ܸ�R�@��|��Cdsi���U�Ƅ ؞�$���ג�0�{ �Zqxu����
�����@-A��u)}ep�VL��<� l6Tv�;��5:�잍����������.hẬ��h�eO�2e�ϗ]_���Uwv�kĆU�)����u��E��q�<8`�n�X�e��4�\�<���b�g��}�w��+p�Y���9W�b������jh��& ~:=�@z�d7J8�zJR)VS�#t.䠒z�H� ���`"�{H��"�(������Յ�"S/6�W�c�l�|�jTN�o>t�Nur���ȚJ�S�P:��i�㘱�0��<Ȣ���Pc)�u�;Γw���ϟFl*f1<����Ƶxb�HJ�ΌC�S?�N�Z���_����ɮu��<̈́���Z�(S7�Q��ˇ]%����y�1w_�_hQ"1^`r�I�ނر��7|#�3�}:6�`3�k��.���s8w��k���\K&$HcԺ���?��lVd���!L�=�`�j����b��ۻ�жf~�xDf���~���$��h��*M��w��m+��M$� n�D���ZF&�ь��D93/���Z}��~��ؿ�$M8��z}�F�U�7b��:@P8-�\Kw��	�&O�4�R�Y���C��m����!F<4���[e�
֙��rN�yE�C{������^@ڞ�b�!���(�;�
RC��L�%����y�.�55�rf5�M	�(Ix�a|�du�t./����5$�eQu�9��lVX�`,��u�p`j[�mt��o����"�k�g��vgG��l)��ݫ����S��ρ�w՝~�K��[ǆ8���Q6ʗ$}�5#������CUHE;�8\T�-"�k`~���<�T�i�o� �WqH�z���N�F�/z}�^����94�gRj?����/Uϯ��Ϩ����R��pšM��o٫�Ӌ<�~9݇��$�� F�,��<w-�]@W���(�\3�f�yǔ�g�!�����F^@�W%�$�e��(t+흥	@����C{�ݳ T�YDW��П�<�G��㑷�Wt��0d�bEv����kK����?�2�1�Y�g�5�v
��ᅼhӀ׮��tC	�3 ���h��F�F�"������C�R����a�!$J\W�#�4���rc�� Zkr�#�ހ1q7-�Q�p�h^��i1U��MBb�c���q��Ţ� %Y	P�XO,	[]�R�X^ٓ��J�,��Y��?e�D$��� �8���[UIg��k����XGY�#�Mi���-�&r�ȩ�9�(`�;�l�f�T�t����:$9�:�-���l��	�s&_*a�o��������w�":����s�mR^N���ZC�_�4�-�).��RY�J��&uV��V�1�&���RԈ�6�5�hU��\����,ہ3xLJ��1YYi,?*'[�(��UK�67�$���35�� �57��M�MzU�����P|Lj�����;[M&��ҏ�� ,n[$	�>.I���$)���.�Q�˺�W�k�u�~�:���f��p�aly�`�2XeWέ-�ֹ߯�Th�a�\/��f#��w��'|i^[��kn�UY���b���&5l�gI����`劵e%S#8��d�7��zԣ�xŝ[sG���9E^D�ATS��t���@�0h ��o��J 5*Ta�B4���w�{�vϾ�L3-TeFx����G��|yY��������t�������l�>����p��������~iW��rQ��[���߷����w��SU��˻����fS�������ϗW��f����Ŵ���n}�����z��ܭ���wW�7���w��/��aɨ�u}׮ng�M;�7�z��u�����z��]n7mͳ�x�/g����W��7�I�X��t9�޶��n����Y\���l���M�����v������mn/筞��ik��]��f^�n/��>����X��)��W�����Znh)��M���-�k�~�\��6)�$װ�y��]�7�3�ޭ��f6��\���v=�^��
�m��ں�o��ve¦�[�s}�gE���¸6)��wP�ج��f��__�l�iӐ���Y5��>��z2#̗�O^S߭�׫���o!�V�����V�m3�)q��8�Af�u�]3қ��΋�u�'�D��5u,G*�[���������m̼��˪Y<�$%H���Z̐&������nn����r[O��G�w�����Y�riM���]��0�m~���=��Jr\�W�j%݆sz)�Jë��	_NX�O��,+h��Y��i6du�|	������ ��W�J[]��c��m=�Ґ��l}�Z)Xä�1��OZp��X��n�X����=�ş�W��@�������s� 0��A�����Ǟߢ������$j�)B�i�3�7�s)Uݴ3gU��!5����b�ݪ���	͐�bv�v� ��1f�(:�5~�_�m�~%�Zi�!^�/Z�����J5iWl���0���l>�H?���JI�.�j�ٕ4?3�]I%��t<��Z�^/� �o[��c��hn����5
����2% �nZ�Ra��ad��R�R����5k�[�E���!���?��mk����d�XS�Yk�@�T��lt�SjX1{Q=��k%��.Q�ԅg�(ĭ5�՟�����51�ޣ�%.�L�����9��`67���ش�����ר~���_1g$\i���_���mǔ���})z7o�	$��ky���w���p���NQ:�k�i��oZ��}S��دb���j�������1	Ʒr�
�8ϕbɃU�T�j��"��%��ߓVݤk"��DL�j�{;C���iL�S��e�R�~�f]�3���,������# �[�&�ȴ��]��5�Rd�/�#w0�n>��|yk�ᢟzay�XW�Lx ʗx��F!�u�����2�K+.<�3)��9!h{���m��^��*=�zi/���JxM��	�	�������Ҁ��WD{Ci��7�{�	wE�(dy�|@�osR1�]-īp�2��d��Dpo��8�3������ =���-�X<�-9�ޅ%���l�B>�%��Mm��ݦa=ANq��m������RQ4�h��6~����h̡����V�1��p�+딨YA��D���,��X&�PL�����L�V��VP�`_f�X=%+�L��J���u�ӎ.`bĪ�"�ie�nY����o���WZ���X���0b 0����<E�8m���7���O{�]��0P����D�gWbm��~�:�̷w���f��;҂Lܷ��s�t��,�!5i�,gb!�'���z*%U��ړ�z��껅O���Q��Vp8.ݬs��f� �ꑀ��wG8nD�H�� ��Sa��v�
��ŷ���r�
R�k��k�� �) @�Z&"'�i�8_���,���ʆ<��������z��}�r�������\1�wo����l3����LƘ�J��*V�CgGǤ����h�D�� ܷmê�x��|F�0o	�Q�qnU9=u����LL��[�W��n��P�!���ݜ�N�J�6��֝ٺ�E#��'�i�CZ3�"rI��?���N�ЮY!"��A��aJ�;�q�K��,f��R� �N�d	ڂQpBt���f��9�U�k��Ġ
�Aϛ���!�\z��8 5b=��p�؂�e�fQ�a�'���{;��'I(I�\����A,�I�*�s���s��j�ر�����;�%���z.ZgZ��	nW8S�bG��+��E<.����5ט�S>�(�&X�)��А���\LC+>����M&�t�[�&с?�3kV�p���v��pNE'~��ƀ���b��N�f;����$5Qh���}aYEf���"��[�����ݪ�)��+/��r���©��b4_��ܤ�����s�@��B���B�U��^B�T���&s���$�ї��d���H���D��z���94>w�4	j,��_�4��1��Y�Km�qs%,U5<���
<_�����Xw�,�?��(=��3tVl�yȁx�q�#?�4��L�:2^?^�p.���F�#�1��	O�ñ��%�ng�B̈́!�MuE(b���/���\��ݫ��C���!��"<��P���U*l��p����(��k��tP,�g\��v��\�QP�mɺ��L8�>j!��+�,ˁH�v�n0L�H�jI� �iU���ok�
��2�H�#�A��x�۶u+Ǹ��Zk�x��
�"�DB���ΠJ�� ?v�<�*
��B����(H�G��=�((�\��}a���m	{��ÃƼ���O�kZJ�Ŵ���B�=�Cf�(��L8,��F�
S@=P��i.��y�m4�k2�)�t�¦��#�*sr"��ݕ���d����q6'�H�A*��豊�"���{�0kn�<�g��-z�scle�^F�NoP���\^n`�^پС-m��"|dlUB��S8@x}�Te��{ռ�3ɷ�Dev�M���&�5.{7���`�>�U��x�,	z�����j�\����D��9���bñ�MC-giV>�*xo�2Q ����X`A��{6����Q@�#�H�0��j�;�6����r�UF
�!F	�91�dY��7��v.��R��6�
%��B�[Zj��@�p���WƐ5OQ��Jn�{� �'_��j�ٜ�`M$}���]#����簢�l�F�����T3������A�n8�&����9�J�L���������6�jV,2@��`7�ڄ�	�ɤm��Q�Է��Px��W��o.�5 ���+��q���-� ��V.�[)z��2�7�걹����L
�7��_`�"*-�l�V����� t�UtB��*����_�e0�U}���J�sr�&n��a�T�i�
���Kܮ6ٌmR��%Z��v�!.qz_gJ@L/��)�j�|�PY�BG����z9�b,.��\�ۭJ��������}�n��$��*\�͒=m�[�P�d�i��2���i ;y��Q��P��L��D�+*�X�-fPS
�,C�����ܣ�0ǯ�"d���E}�X�ʸ�ǣ}��~׬ٵ<��H#��,�*��f�@y��|��%G���=.4���0����eI�`,�!��L(C.�=~�
��	h=p��pkjPу
'����0f�>ђ���<��8���Q��<��Q*S�sH1�����ӱ�Q��)b�ݚ�::Ǿ���C-�Zof
T��e0�����ـ"9��Q��*�Dl�5��hA�̈�>�4s�D�X
��0�	-���� &+�a���
x'��YYQqv����ZH��|��;Q���GP`Y$*)��ತj(��$51��ɳ�%,1w�!ȻاR&�_�>��N��X��b�]GQNj
]���!�]��R˞��+nY"wl���*Ԃ^�+b�$e�D��jcu�)�K~����,#�F�.+y�u�$g݈"&���GD*i�uml���EM�9�Y�-�&�M3����E�ă-m�E
,�z�6/Ft��0��J�t;y�nb��8�n��HْОX;���t!Z����6�-��*?����P�}�m{w��t����w����Y��?�'�)D��;��G�`N���E^f��/�G^�����oT�.�F�$��M&�gj�Yӄ������}��a�#���U�녧P��P��b3t�J�aLn���Z��ܲq�DϣAQ�g`N4'S��U���/እ�!���oK�����Db�^������)i-A�����;io/�=o���?ʦ�5�W)�YE<�$%}��+l����"��A
v��W�^�}�YB׹g�МQ`��3bȈ�
�C�	�g�=����`�1zU9`0���P��+����t���Q<�O�V2��J9B�VHqe���W"��A�r +�L��C�V�%�$�K��ą��yW(d�k� �֔������"+��h;%n��`f�*��O�F�g��7m�Cz�(!�R�����&��,��jP�K4��p��aW��� ���n�.U)ө�*5�Xf[68�sӋ�	l���*죔��N��ɭ��R}��FByj`��]?V���`���2��j�0Zy��A �K�R����O�Rc��� 
��L&K$P<]П�M�P��W���o�%�+�!�=e#�G����j1��ODq2�?��A��h��J����M�^#����o�Ӟ���i �8#C�BD�z{w�Ԯ���� �d��sO�I��P�>*MT�'`��ϝecb��a�)�fY��Akڛ3L�p�M$0~0$+	��uQl���E��MB�]~��ƺ�L�@kV����Ȏ���tz%����,2>��fw���ȊR+��*���/�eWQp�kj>�s��LW&�tMq�C�,�p#{�g�W�O*gV��Q
  ����:F����,w�jRד�}�P��W��lD̆]�Y����p�<�{b�%�K�PY�);�k0�P��Ӿ%W5�&�M	����G� ԗ��ɣ�@g��L+�u�:̼[���S�3�]A�J���Am�81%\��"m��3e=�Q~�89��C^Zc�q��K2���
��-HmfR�غ��enL\��C��x�(s����Z/$DO|��k���d��o�9�]L�� �6^~��M֗b��$�'��rA̬�xfW t���f�_�%b���*�f�7���8�����{R8
��zE�0��<8_8g@E��S���S�=�2�S_u�-b����^����ؿ�G��KW�M��u��;PI<��J���QSY����ٹ�`���^�`ɪ
�Ô-�E��\_K��o����E�RP[�R�X
��\�h&uʮ,����1^�e�K ��L��}}�fId��C��^��"�RV��4'�0����V9	��5���Ϯ��d���0�V2�~@8�!�q-C fXõL��L���=�պ��5�/����Dl��z���\&��J�4Y(fϑ�'�rXq>4Sڴ��^-��:f�b��θ��y����l�� ������gt�L�=��ؔu~�U*J=����?x�v0ݮ̀n�Pz�;���R�����L]/�=_4�e�#��]sc����$�A*�Y�������X#]������n�/F4x$0Ơ��PT�h��.�s�R@�8S�j2%�	m�`8
gL�E�݉4�ڑ�%n�!(�HG�0�ZAW69��� �PA�\Y�	]�i���qN����a7�u ���4����az��(�(6��*��i$�����;��%�%9(�v�U��<�TJiJ�E�@�r�HAz��<�u)3|(:ǡa��飔��T���#p��h�e���� ;䬢���h���S+=&!�ܪ����	�r��,�ޡ���#�vƣ��<��x�j2�t��(p������D�3�g��A"M)$��H�G=�!�7�y]_�H��gZl�\�f�M�aLn�B��+^�̝�"�'eb N���_һ�~�{E� |AIfE�Gb�<�]\�{N��zY2��p�3yEPYQ�W��AC�!o�x�����cط�����m��$ܾ�=��O�z�*�0n�d���.�}%�*�q�'Z��.�@���4Xx6J3���]�V��d_{=����P��������6�>lԊa��-�~�z-M��z��J3��u��� �`�]ۮ8�F�GI�u-�B�t�e:�y����SJ�1d��h�)�K"�3N�.��R3C��nu��&����7�"�P9�VjyUa&��G�%�m�a�����<grt��u�tz������-ٮ����F�vm�~B�T�RT�CJ�9B�=����F+H�)��@��ͅku �)������Q�N�x�����R����:FD�纥o�Jkl^E[�#`i���y�=��VH.��weS��\�� �������A�G"Gw��<AAv;�K��r{�a_��ZD��@���Ai�Wtȓu]� �b���(����n���c��Ӟ�zgĨQ_u�y�:wZa�4����?�t<kX������6����]�*w1<*���G�Vs9E��ӌ�#S�Sꬿ¦;xw�
۵k D1ֱG�a��PT��=a�����W�B�������~�Vc,�O�/��a4���I�M�	(�g��0$���I#��&O��.�A�&��*I�_���w��`*�� Tv�׿���p|�c���v[�8�"B�F��," ��O3P�Έ@y :u�Vؽ��+�9��$�Z2$OU!zHԪ���	�P��Bg�,���us�gG��IT��U�"���K�T�
'.�6/[���� ��.��r�d�(�D!�،���cEI�!�`��r5�@z5��Q�$e�C��;����Ƚ�<��Y:���@Q8TkV>�Do9�AuT1���j$MH.�Ճ�A;�'�k7���E{SE-�Y���,o�)$�JB/�4��ḥ�i�\��=�T�uN����(�aV��<�tC��ѐ�Jΰ��u���SQ�Zd`�����)���r�`\��v)���#�d:t�{��W�`�n&Q[��;�Zju���xv�񵝈�gH?&�[p����jV��!�GC+�e%�vt;z�=r���S	9z#r��.�7��y�*����:��X0�uĞN��_T��;��Tyb�;`��w)��2�dk���_���U3�/T�f(G+I'{NeF�2� **�e���m��Hf����Q�V���Ɋ}������-�WxQΩS�"_�}Ok}�H�x`0�~�A�p��K�a�����ӣ���8�K��C1�k�Xa�f��ճ���I�

�J��i����m���Q�Ӛ�>zgn�{����\h30B��S�V�:�T@�Œ���/-����?v�.��ǉ�Z*���((rE�����l�yS=OD�,B�r@J�}D*퉝�^}�H�NTB}�,�Ǎ���lҨ�&��jܴ����¢D�V�V��·�PW����v׀����,�|�y2i��Y�y����!��C�j���X�d�z�c�v�	s��Tr��]_`1hk��r����^>��ǯr�X�آ�8>�k,����>��������)�ټ���͹ަM�`[�s!�^Вd^����b5������"��x0�rgE��vZ���s�H�^��".���ḿ,��S��x�3Ј�I@x�Pv
B�z�`�O�h��f�/7���]Q7�x���o3�{TW�"N�y�@�-~���o�F=M�(U2་�����8����7?�gC����~w��uQ�����&����>�NvX8�n���\|�ǈE�-�(��؄8s��&qڲ�4b�b���sl��1G�W��a"��nd��C�F��g���V�p=f��2-�ڱ����MO=M8�����^�"�*�(S�eckE`�ڪ���h�����a�����)���Vd�n�!�k���I��S�-���R(
��:��;4�P)����A�������n4�������D��h#����lQ�����Ɍ���BS�s�l:*��'�
\yy<��D��Ϻ��j�i$��md�E٢QA+Q2��C"�e->���E��{�n6&��f�ׁxh�gP}@`T��a0�\������iՁ��q��� $�5�K'��e����U��5��r��l&W���,����v���D�ݤnT��\+P
�b��r��@W� "�]��b@���H�v�C���<�ˋ�� @���)�zl� �y{Å�a7�l /��$���޼�����DٴpƗW8���h��E�2+ee�_\�C���gKg��x�	$�n�R��S;�(��,��M��N���v��^��
�5
�0�q���~)7�z+Ct���	�k`KT��L kA�7D�0�!��쀍�7YG�.=+ꤝE%e�k�i�`�ov���V��#�W�N��)�[�����)=w688r�Ժ`���"_�\�$�Gg�ͥ�`�3�kdH������"P��y��daR�����'l��Y��)�͝HJ1�O���(/ƌu�/��ύ ��lQ��e�����3�/7>e%Fkya�5{�1$vlؕ���:BR(Dc1�iSa�!l��<<p[o���:�B;�`p\h�߉m�����h��\�Z�J��ذb�'eΡ�`s�d�*�.���̥�x��mGJJL����w�C�����`��K���F ��n�*�ؒ.p��.�����K ��1�g����GS�P�d�2P�^E?ҭ��ˮA���D|z�����,���n���͖\KՋ���H��%���eFO�8�������6�Úg�|�+sYN�O��ux �NIn�K�p�����e �a�����+)M�2$D�E���el�zĹ�b)PZ�yW��JD=7PTC�1뼬c�q�F7��B�yj�u��x,W)��Ջ7PD=Ѐ��ٜ���2)-
�Qv�/�58��I�It�+xP��Q��gJ@q똺����]@s��q�m|\BhJN7�v$�%��(�R���=�@D��!&�����������μr5����+ܺ�������?� �%�z��.o���#��&�f�KPY|�����	
Q\������^Qo�-�S�-DfSڪd>Lta�;ژ�wLk��oҺ<�2�%;Cb�r�^ �������V����i(\�X1�x�,�%���B�{�|q����)� ���E+�/�D_N�y���)�mC�$�h��a. \z0�r-��b��c!�-[G-D�9Q��e������G���{[��Nui��{BXT}g��g���g�h3UF���wT�$��P�m`�g��9��J2t� ���)�Wr��qU�'�����[��݅�1�P����u-��(�cs�[o�[�1g�#y��ls�˵c� �����Z����Fɉq��{@};����ŗ�DR	�D#4Pp�S���MN�B���q��+q%�Ķ�/����hT/̒�;���ߨ���%Zz��h�1hҬ��'Իd{�a [83H�̸]Z<�my�g?t�8(�c�i�m9�m�m2w�{`��7�d�j�+`�S�2o��]w�|�c1ʾ�Y�)Ȇ���"�~�e�D��
��R�8{��'���Z�mGl,}� �T] ��},��q��5۸t�r_����*Ƶ�\$�3�PQ�+v��U[�1E�v����fu܋��t�W�}�5�9�y�Ƨ<U�k�NYV��s��K�\��x��lSQQ���3]Nѧ����4���}�J!�e�[�0����N�䑺�xn`iv[A&֨N�Bu)�Q���O��Fp�C��.��������~R���HP�U6-ͱ�7m&n���WJ��O��Q��y?Gw�@.����^�Hx�u�H9P��l;ʼ)��JW�& ,;�V�ܜ{�$o<	(��!P*��P�B�M��@¢�/�7dM���,��*ٌ�[_$��=�w��:�%Ħv�f��`�$��(b.;��J�j�Y��!����������\ͧ�U��:�ʴV�D�,#]A]_�A�ӗ�3�d��nXV&n�o/�R|���q	��0�o���DtX�Wj�����~.2��%�#��������K��_�dp>_���?�Q�y(���PXH�^E38Z�[�\x�JM�*�;1�G��Ǹ49�0k1�bg"�\WaZ�;Q��*��Ɲ?�Ӎ�|�jAJ��j������0��D0~��᫮QA�/J�nM��I�u�����n�!`@�Ş��@�@�Sr#�6�$�[C��⬌)���|Y������l�B���f�sC����W�.=�v�����Ŏ�1vqt��Z���VրO]�v伫ӱэ���]�x�x�W���Rl,8��Kn�4���X�m���^6h����~ �����d��O<��=���D�"
*5�}F�e6��;��XY�ŅP���Mw9�cQ4H�B�Eg
�E{aI�����KO��}���o� ��Ry3�O�R%2j�z�l	�Wq�l�g�o�x%]	J�E˳��])3p}߄�VG|E�[9�b*���~�EN-�v�A�Q=�M��X�JZC�K��N�̄�#&�7zbܢΰ u���>E$.���") -���8�t��V��A�VI>�3�������k�x#�G��%�PeA7�)�W�GJ�O�FF��P�DֽG�)T��7�9�,W\�Ku��j1�H�l/K�׬��-�!l󝙰ƻ�Q��/��}VtnF�d�':C�Mie5ѐ��܎j�1\�
���?G�cw݉(���J��	��4�(ht�&,��!�JGR�G�?�ʖC}*����-'�w̓�\�ۗ)��a���R�CI����܇��Y�z��%���6}�0�L�b����t)��'���K*q�̐"@3V�����O�
�Rn�(�-O�?�ڱ}�m���jk.�����c��xě���8�$.<�:E]u0�@�	����E�v���]�t��hCv���PF*�#�ݚ<�?[:W�t�Ixв����q�ꊻg�Kjv��Y�4�b�'5�����1���_1mi�հI�R��}$����°�DQT�\�Cd A�䇴���A+^Yh^l��+��\�E���M;�^tC� �QQ�K�DG�(QX��%?D'V�sB���'�u,@"�D�#!#La��9j�L3S�o#�a�yKK�W���P���T����}�p����T:Z�]Y��2�+� �<��K�����s۫X(8O�B����E���M�W�?I >��p�
>�]���D�VZ�"�LfN`]*
���T��JbI#���Ydg�68fV�q�F���'6 hك·�3!�m���hQ	�d�#.u)83Q�_Ɉ�=�jBz��9��-��}�H#}�_��S�hY����S`�z��(�P��(tMjz$]���I���D#y�b���O�)7�P`�?%	��-H�:n0��p�߼UFc�?��,�j~4�G�L��ފ�U��,R�o�P��h�j��"�΢OK���W!�?�Ŗ6��D�i���o�sg�՝̍&����0ˌ����p��?�P�K0�I^��&y<=�Lf4�s�~ J��z���vS�ئ�_,�	Km$�om� �s���h�O��>��Ѹz�oA��r,9s$7�2�U9qHr��Q_�� ����֘X�����z"p����,�M[~�GJU�Xlu�`�V��J-�ZK@|\��]� ��IíN�Tw��;�(��!NC���W�{�D�.�J��UtR˸�5�b �����L�M�
��B�}��6��hk�B�Ho�${caǧcOqa=f�C*����/|�G/cŒ��f)-�����W�/��#�t�iW��(3~Q�h�?���ދnV�?YUx�6��y?�!�i"7e�@]���|�;c�n��~�]u+�t�Q���.X��OJΟ+��Y�
��'�)��%�tK��]w���b�#ʞ7)��PP�2�K�+q.��Q��Axq)�`�Z����z)e8;.�{����o������~>8;�����׽���������������䧳����ŉ�>�ϋ����ߒ:��8x_��\흞��{�ꣽ_Y����^Կ�|p\�0�ٯ����Ş^8<�=�ק���'���������������;f�����������������&~M��w�_/~>��|I|u򁟹�\��������oΠ�������#�����ѧ�в[�c��~A������n%�et�����S{���~V����1S�w{A��������������р������G�
�����w��ǽ��ͥ�Rb�r��'��uAj��uP�?�p�q�����d��O�y�'�Z����лw��>?8��p�|8;8�;��g�L�ٙF995�n)7�G8E���q�`Ѡ�_����ĉ���b�Ғz�%麟3z�կ�&�u�Q�b�����3*vR<y�AbAR~�엃��^�M|�Uv�݉�u=��"qI:�~���O��1U���n}~z��w���G�(Xŏn���D�9H�����Rΐc�	C`���8̭φ"|�i�3JY��X�~�bOC��h���c,�2����3�MO��s�	<<ih�|u����������>��cœ���Bi��R�"�_�V~}����N�i���~F�xl��/x�1"ӘX�GH>��q��P���[Z)C����uwH%T1��*�\�W��
�E��ӷ����ZE�m��ħ >sn��-��_�YX����L�KW�R�������O�p:G�d����r2'pkK@�����HXS�u�ܜ�.�/N�A5qB-I=:��3*�0XW��m��������e��f��WE3`
L"�-?��}�ԯ�����A/-�~�����`�g�v����g��cpu�N������ `�{TʸOX������Q�NA�d�=7����/�����Y��\����SE]���@s_l����.uÄC^��L@�֙rӡ���86e�ì�^�5/�G�Ul��8~����T,�~re��ƒ�	��^7WZ�(��v-\���L�����k����r����̔�	�+J�{$�ڣ��i<wm�}�������gΐI���p���f|(�v�r+��|%l���WU��>o��ώ�5��M}ɯ6Q�����r�,���������W����v����_=Z{	��)a���,Ӥ����/V�'BV�&��h��@|�I|��%�����H�~	�� Fa�Ϗ���w����h]���d$I��=έ���+s9��V7��g,��x {��Ҫ��5E��~tuD�j���ݖ�g�3�7���>�%�U���\%12A��ky8�y�-���؏�u�ץ�R��ڗ�����ze��roIҺ�ʿ�l6�<�w���߿�^l��>�]�$����0�Ի�S7�~˵.ږ��@V��%k$�(�AO�t�vlw���Y�c�yE��y$���1�j����K��5~#��Ð�F}ijF���)b�ڶ
'*�'��_��տ�ݿh���H�RxA���ޝ�}�88�<Le~txJy��W�������o�X,NNfh�}�P�ƝM�G�9q��
s.%�����p�	?�����)��{�p�J=,��L?CX����N4��(�]�����d���g]�h�I�������i���[� P����_S���0B�G�!*���D��{��Gt���n6����~�B��J�ҎΪ�:�M� l��M]Jp�<�S"S��
$t��%�D%ȋ��Ě�Z?��X�#Ñކ�ӄ�)DgZ�Amݧ@����V%֗]B_�q���_d4�rqw mԧ���&>�Єmn/)�j���{�=���JE�8�)#��C��M�&%*e�gK��-��1=f�gzZ�і�p�;��!Đ#5��Ja�q}O�x�	��p��C�����o�*k7�"����oqR�ί��on6�s\���z/xmSMo�0ݹ���KQ��i]*�Gw�C{ة�%�&*K��&���I��4Y}�E��gR��|���F��z�������g"�@���L��j}�E٣����[y�*)��ņi묏Hk"�T�e�Zц%����pd�e����\,���5��y@��3�G��;R3QM��6�]����ƪ��sh@߱Y���(�P)6�q��iܭ���|鉻>��r���ǩ6-[X'�'�l]@@�d��C퟽n}�Y'Z��k� �.���|�9ܠ�a�oYk��H@��PCp(	Ϋ=O�����T�BS_T�ٸ{�`5+x'��ܺ�֠N���@=F롡�%20�/%MĢ�g'�i�D޼M�;�1���^N���`ZPIa�zW�E5���ͦf�S�C��]<�j"OZ�-���hxm�[K�0�}�_1,B[�"�l�P��Z��}���S[ȶ!�(�	K�ŷa�s�L-���n.nT�����`�oxsep�6�� �%���rB�iԻ��,�����e�s��+��K>��3U$/�
����l���m/�L��}�Q8�)dl���E1l��4p)���@�@Vk�yc�2H�:�,�Dbbȑ&|��qCM�Y�B�|��a�_ \���B9a�
�ƴV�i�1,�_��nAref: refs/heads/main
# git ls-files --others --exclude-from=.git/info/exclude
# Lines that start with '#' are comments.
# For a project mostly in C, the following would be a good set of
# exclude patterns (uncomment them if you want to use them):
# *.[oa]
# *~
0000000000000000000000000000000000000000 bf6d34466a37367a5ffcd00b3e613559adfb07fa maxdarwin <72539638+1darshanpatil@users.noreply.github.com> 1732122421 +0530	commit (initial): Initial commit
bf6d34466a37367a5ffcd00b3e613559adfb07fa 2790a2b98ca2262fb7a37e4a033c7bb1f677abbe maxdarwin <72539638+1darshanpatil@users.noreply.github.com> 1732123059 +0530	commit: Initial Commit v0.1
0000000000000000000000000000000000000000 bf6d34466a37367a5ffcd00b3e613559adfb07fa maxdarwin <72539638+1darshanpatil@users.noreply.github.com> 1732122421 +0530	commit (initial): Initial commit
bf6d34466a37367a5ffcd00b3e613559adfb07fa 2790a2b98ca2262fb7a37e4a033c7bb1f677abbe maxdarwin <72539638+1darshanpatil@users.noreply.github.com> 1732123059 +0530	commit: Initial Commit v0.1
A lightweight PHP-based tool for managing multiple bank accounts effortlessly. Organize account details, ensure smooth money transfers, and keep track of activities across accounts for you and your family.#!/bin/sh
#
# An example hook script to check the commit log message.
# Called by "git commit" with one argument, the name of the file
# that has the commit message.  The hook should exit with non-zero
# status after issuing an appropriate message if it wants to stop the
# commit.  The hook is allowed to edit the commit message file.
#
# To enable this hook, rename this file to "commit-msg".

# Uncomment the below to add a Signed-off-by line to the message.
# Doing this in a hook is a bad idea in general, but the prepare-commit-msg
# hook is more suited to it.
#
# SOB=$(git var GIT_AUTHOR_IDENT | sed -n 's/^\(.*>\).*$/Signed-off-by: \1/p')
# grep -qs "^$SOB" "$1" || echo "$SOB" >> "$1"

# This example catches duplicate Signed-off-by lines.

test "" = "$(grep '^Signed-off-by: ' "$1" |
	 sort | uniq -c | sed -e '/^[ 	]*1[ 	]/d')" || {
	echo >&2 Duplicate Signed-off-by lines.
	exit 1
}
#!/bin/sh
#
# Copyright (c) 2006, 2008 Junio C Hamano
#
# The "pre-rebase" hook is run just before "git rebase" starts doing
# its job, and can prevent the command from running by exiting with
# non-zero status.
#
# The hook is called with the following parameters:
#
# $1 -- the upstream the series was forked from.
# $2 -- the branch being rebased (or empty when rebasing the current branch).
#
# This sample shows how to prevent topic branches that are already
# merged to 'next' branch from getting rebased, because allowing it
# would result in rebasing already published history.

publish=next
basebranch="$1"
if test "$#" = 2
then
	topic="refs/heads/$2"
else
	topic=`git symbolic-ref HEAD` ||
	exit 0 ;# we do not interrupt rebasing detached HEAD
fi

case "$topic" in
refs/heads/??/*)
	;;
*)
	exit 0 ;# we do not interrupt others.
	;;
esac

# Now we are dealing with a topic branch being rebased
# on top of master.  Is it OK to rebase it?

# Does the topic really exist?
git show-ref -q "$topic" || {
	echo >&2 "No such branch $topic"
	exit 1
}

# Is topic fully merged to master?
not_in_master=`git rev-list --pretty=oneline ^master "$topic"`
if test -z "$not_in_master"
then
	echo >&2 "$topic is fully merged to master; better remove it."
	exit 1 ;# we could allow it, but there is no point.
fi

# Is topic ever merged to next?  If so you should not be rebasing it.
only_next_1=`git rev-list ^master "^$topic" ${publish} | sort`
only_next_2=`git rev-list ^master           ${publish} | sort`
if test "$only_next_1" = "$only_next_2"
then
	not_in_topic=`git rev-list "^$topic" master`
	if test -z "$not_in_topic"
	then
		echo >&2 "$topic is already up to date with master"
		exit 1 ;# we could allow it, but there is no point.
	else
		exit 0
	fi
else
	not_in_next=`git rev-list --pretty=oneline ^${publish} "$topic"`
	/usr/bin/perl -e '
		my $topic = $ARGV[0];
		my $msg = "* $topic has commits already merged to public branch:\n";
		my (%not_in_next) = map {
			/^([0-9a-f]+) /;
			($1 => 1);
		} split(/\n/, $ARGV[1]);
		for my $elem (map {
				/^([0-9a-f]+) (.*)$/;
				[$1 => $2];
			} split(/\n/, $ARGV[2])) {
			if (!exists $not_in_next{$elem->[0]}) {
				if ($msg) {
					print STDERR $msg;
					undef $msg;
				}
				print STDERR " $elem->[1]\n";
			}
		}
	' "$topic" "$not_in_next" "$not_in_master"
	exit 1
fi

<<\DOC_END

This sample hook safeguards topic branches that have been
published from being rewound.

The workflow assumed here is:

 * Once a topic branch forks from "master", "master" is never
   merged into it again (either directly or indirectly).

 * Once a topic branch is fully cooked and merged into "master",
   it is deleted.  If you need to build on top of it to correct
   earlier mistakes, a new topic branch is created by forking at
   the tip of the "master".  This is not strictly necessary, but
   it makes it easier to keep your history simple.

 * Whenever you need to test or publish your changes to topic
   branches, merge them into "next" branch.

The script, being an example, hardcodes the publish branch name
to be "next", but it is trivial to make it configurable via
$GIT_DIR/config mechanism.

With this workflow, you would want to know:

(1) ... if a topic branch has ever been merged to "next".  Young
    topic branches can have stupid mistakes you would rather
    clean up before publishing, and things that have not been
    merged into other branches can be easily rebased without
    affecting other people.  But once it is published, you would
    not want to rewind it.

(2) ... if a topic branch has been fully merged to "master".
    Then you can delete it.  More importantly, you should not
    build on top of it -- other people may already want to
    change things related to the topic as patches against your
    "master", so if you need further changes, it is better to
    fork the topic (perhaps with the same name) afresh from the
    tip of "master".

Let's look at this example:

		   o---o---o---o---o---o---o---o---o---o "next"
		  /       /           /           /
		 /   a---a---b A     /           /
		/   /               /           /
	       /   /   c---c---c---c B         /
	      /   /   /             \         /
	     /   /   /   b---b C     \       /
	    /   /   /   /             \     /
    ---o---o---o---o---o---o---o---o---o---o---o "master"


A, B and C are topic branches.

 * A has one fix since it was merged up to "next".

 * B has finished.  It has been fully merged up to "master" and "next",
   and is ready to be deleted.

 * C has not merged to "next" at all.

We would want to allow C to be rebased, refuse A, and encourage
B to be deleted.

To compute (1):

	git rev-list ^master ^topic next
	git rev-list ^master        next

	if these match, topic has not merged in next at all.

To compute (2):

	git rev-list master..topic

	if this is empty, it is fully merged to "master".

DOC_END
#!/bin/sh

# An example hook script to validate a patch (and/or patch series) before
# sending it via email.
#
# The hook should exit with non-zero status after issuing an appropriate
# message if it wants to prevent the email(s) from being sent.
#
# To enable this hook, rename this file to "sendemail-validate".
#
# By default, it will only check that the patch(es) can be applied on top of
# the default upstream branch without conflicts in a secondary worktree. After
# validation (successful or not) of the last patch of a series, the worktree
# will be deleted.
#
# The following config variables can be set to change the default remote and
# remote ref that are used to apply the patches against:
#
#   sendemail.validateRemote (default: origin)
#   sendemail.validateRemoteRef (default: HEAD)
#
# Replace the TODO placeholders with appropriate checks according to your
# needs.

validate_cover_letter () {
	file="$1"
	# TODO: Replace with appropriate checks (e.g. spell checking).
	true
}

validate_patch () {
	file="$1"
	# Ensure that the patch applies without conflicts.
	git am -3 "$file" || return
	# TODO: Replace with appropriate checks for this patch
	# (e.g. checkpatch.pl).
	true
}

validate_series () {
	# TODO: Replace with appropriate checks for the whole series
	# (e.g. quick build, coding style checks, etc.).
	true
}

# main -------------------------------------------------------------------------

if test "$GIT_SENDEMAIL_FILE_COUNTER" = 1
then
	remote=$(git config --default origin --get sendemail.validateRemote) &&
	ref=$(git config --default HEAD --get sendemail.validateRemoteRef) &&
	worktree=$(mktemp --tmpdir -d sendemail-validate.XXXXXXX) &&
	git worktree add -fd --checkout "$worktree" "refs/remotes/$remote/$ref" &&
	git config --replace-all sendemail.validateWorktree "$worktree"
else
	worktree=$(git config --get sendemail.validateWorktree)
fi || {
	echo "sendemail-validate: error: failed to prepare worktree" >&2
	exit 1
}

unset GIT_DIR GIT_WORK_TREE
cd "$worktree" &&

if grep -q "^diff --git " "$1"
then
	validate_patch "$1"
else
	validate_cover_letter "$1"
fi &&

if test "$GIT_SENDEMAIL_FILE_COUNTER" = "$GIT_SENDEMAIL_FILE_TOTAL"
then
	git config --unset-all sendemail.validateWorktree &&
	trap 'git worktree remove -ff "$worktree"' EXIT &&
	validate_series
fi
#!/bin/sh
#
# An example hook script to verify what is about to be committed.
# Called by "git commit" with no arguments.  The hook should
# exit with non-zero status after issuing an appropriate message if
# it wants to stop the commit.
#
# To enable this hook, rename this file to "pre-commit".

if git rev-parse --verify HEAD >/dev/null 2>&1
then
	against=HEAD
else
	# Initial commit: diff against an empty tree object
	against=$(git hash-object -t tree /dev/null)
fi

# If you want to allow non-ASCII filenames set this variable to true.
allownonascii=$(git config --type=bool hooks.allownonascii)

# Redirect output to stderr.
exec 1>&2

# Cross platform projects tend to avoid non-ASCII filenames; prevent
# them from being added to the repository. We exploit the fact that the
# printable range starts at the space character and ends with tilde.
if [ "$allownonascii" != "true" ] &&
	# Note that the use of brackets around a tr range is ok here, (it's
	# even required, for portability to Solaris 10's /usr/bin/tr), since
	# the square bracket bytes happen to fall in the designated range.
	test $(git diff-index --cached --name-only --diff-filter=A -z $against |
	  LC_ALL=C tr -d '[ -~]\0' | wc -c) != 0
then
	cat <<\EOF
Error: Attempt to add a non-ASCII file name.

This can cause problems if you want to work with people on other platforms.

To be portable it is advisable to rename the file.

If you know what you are doing you can disable this check using:

  git config hooks.allownonascii true
EOF
	exit 1
fi

# If there are whitespace errors, print the offending file names and fail.
exec git diff-index --check --cached $against --
#!/bin/sh
#
# An example hook script to check the commit log message taken by
# applypatch from an e-mail message.
#
# The hook should exit with non-zero status after issuing an
# appropriate message if it wants to stop the commit.  The hook is
# allowed to edit the commit message file.
#
# To enable this hook, rename this file to "applypatch-msg".

. git-sh-setup
commitmsg="$(git rev-parse --git-path hooks/commit-msg)"
test -x "$commitmsg" && exec "$commitmsg" ${1+"$@"}
:
#!/usr/bin/perl

use strict;
use warnings;
use IPC::Open2;

# An example hook script to integrate Watchman
# (https://facebook.github.io/watchman/) with git to speed up detecting
# new and modified files.
#
# The hook is passed a version (currently 2) and last update token
# formatted as a string and outputs to stdout a new update token and
# all files that have been modified since the update token. Paths must
# be relative to the root of the working tree and separated by a single NUL.
#
# To enable this hook, rename this file to "query-watchman" and set
# 'git config core.fsmonitor .git/hooks/query-watchman'
#
my ($version, $last_update_token) = @ARGV;

# Uncomment for debugging
# print STDERR "$0 $version $last_update_token\n";

# Check the hook interface version
if ($version ne 2) {
	die "Unsupported query-fsmonitor hook version '$version'.\n" .
	    "Falling back to scanning...\n";
}

my $git_work_tree = get_working_dir();

my $retry = 1;

my $json_pkg;
eval {
	require JSON::XS;
	$json_pkg = "JSON::XS";
	1;
} or do {
	require JSON::PP;
	$json_pkg = "JSON::PP";
};

launch_watchman();

sub launch_watchman {
	my $o = watchman_query();
	if (is_work_tree_watched($o)) {
		output_result($o->{clock}, @{$o->{files}});
	}
}

sub output_result {
	my ($clockid, @files) = @_;

	# Uncomment for debugging watchman output
	# open (my $fh, ">", ".git/watchman-output.out");
	# binmode $fh, ":utf8";
	# print $fh "$clockid\n@files\n";
	# close $fh;

	binmode STDOUT, ":utf8";
	print $clockid;
	print "\0";
	local $, = "\0";
	print @files;
}

sub watchman_clock {
	my $response = qx/watchman clock "$git_work_tree"/;
	die "Failed to get clock id on '$git_work_tree'.\n" .
		"Falling back to scanning...\n" if $? != 0;

	return $json_pkg->new->utf8->decode($response);
}

sub watchman_query {
	my $pid = open2(\*CHLD_OUT, \*CHLD_IN, 'watchman -j --no-pretty')
	or die "open2() failed: $!\n" .
	"Falling back to scanning...\n";

	# In the query expression below we're asking for names of files that
	# changed since $last_update_token but not from the .git folder.
	#
	# To accomplish this, we're using the "since" generator to use the
	# recency index to select candidate nodes and "fields" to limit the
	# output to file names only. Then we're using the "expression" term to
	# further constrain the results.
	my $last_update_line = "";
	if (substr($last_update_token, 0, 1) eq "c") {
		$last_update_token = "\"$last_update_token\"";
		$last_update_line = qq[\n"since": $last_update_token,];
	}
	my $query = <<"	END";
		["query", "$git_work_tree", {$last_update_line
			"fields": ["name"],
			"expression": ["not", ["dirname", ".git"]]
		}]
	END

	# Uncomment for debugging the watchman query
	# open (my $fh, ">", ".git/watchman-query.json");
	# print $fh $query;
	# close $fh;

	print CHLD_IN $query;
	close CHLD_IN;
	my $response = do {local $/; <CHLD_OUT>};

	# Uncomment for debugging the watch response
	# open ($fh, ">", ".git/watchman-response.json");
	# print $fh $response;
	# close $fh;

	die "Watchman: command returned no output.\n" .
	"Falling back to scanning...\n" if $response eq "";
	die "Watchman: command returned invalid output: $response\n" .
	"Falling back to scanning...\n" unless $response =~ /^\{/;

	return $json_pkg->new->utf8->decode($response);
}

sub is_work_tree_watched {
	my ($output) = @_;
	my $error = $output->{error};
	if ($retry > 0 and $error and $error =~ m/unable to resolve root .* directory (.*) is not watched/) {
		$retry--;
		my $response = qx/watchman watch "$git_work_tree"/;
		die "Failed to make watchman watch '$git_work_tree'.\n" .
		    "Falling back to scanning...\n" if $? != 0;
		$output = $json_pkg->new->utf8->decode($response);
		$error = $output->{error};
		die "Watchman: $error.\n" .
		"Falling back to scanning...\n" if $error;

		# Uncomment for debugging watchman output
		# open (my $fh, ">", ".git/watchman-output.out");
		# close $fh;

		# Watchman will always return all files on the first query so
		# return the fast "everything is dirty" flag to git and do the
		# Watchman query just to get it over with now so we won't pay
		# the cost in git to look up each individual file.
		my $o = watchman_clock();
		$error = $output->{error};

		die "Watchman: $error.\n" .
		"Falling back to scanning...\n" if $error;

		output_result($o->{clock}, ("/"));
		$last_update_token = $o->{clock};

		eval { launch_watchman() };
		return 0;
	}

	die "Watchman: $error.\n" .
	"Falling back to scanning...\n" if $error;

	return 1;
}

sub get_working_dir {
	my $working_dir;
	if ($^O =~ 'msys' || $^O =~ 'cygwin') {
		$working_dir = Win32::GetCwd();
		$working_dir =~ tr/\\/\//;
	} else {
		require Cwd;
		$working_dir = Cwd::cwd();
	}

	return $working_dir;
}
#!/bin/sh
#
# An example hook script to make use of push options.
# The example simply echoes all push options that start with 'echoback='
# and rejects all pushes when the "reject" push option is used.
#
# To enable this hook, rename this file to "pre-receive".

if test -n "$GIT_PUSH_OPTION_COUNT"
then
	i=0
	while test "$i" -lt "$GIT_PUSH_OPTION_COUNT"
	do
		eval "value=\$GIT_PUSH_OPTION_$i"
		case "$value" in
		echoback=*)
			echo "echo from the pre-receive-hook: ${value#*=}" >&2
			;;
		reject)
			exit 1
		esac
		i=$((i + 1))
	done
fi
#!/bin/sh
#
# An example hook script to prepare the commit log message.
# Called by "git commit" with the name of the file that has the
# commit message, followed by the description of the commit
# message's source.  The hook's purpose is to edit the commit
# message file.  If the hook fails with a non-zero status,
# the commit is aborted.
#
# To enable this hook, rename this file to "prepare-commit-msg".

# This hook includes three examples. The first one removes the
# "# Please enter the commit message..." help message.
#
# The second includes the output of "git diff --name-status -r"
# into the message, just before the "git status" output.  It is
# commented because it doesn't cope with --amend or with squashed
# commits.
#
# The third example adds a Signed-off-by line to the message, that can
# still be edited.  This is rarely a good idea.

COMMIT_MSG_FILE=$1
COMMIT_SOURCE=$2
SHA1=$3

/usr/bin/perl -i.bak -ne 'print unless(m/^. Please enter the commit message/..m/^#$/)' "$COMMIT_MSG_FILE"

# case "$COMMIT_SOURCE,$SHA1" in
#  ,|template,)
#    /usr/bin/perl -i.bak -pe '
#       print "\n" . `git diff --cached --name-status -r`
# 	 if /^#/ && $first++ == 0' "$COMMIT_MSG_FILE" ;;
#  *) ;;
# esac

# SOB=$(git var GIT_COMMITTER_IDENT | sed -n 's/^\(.*>\).*$/Signed-off-by: \1/p')
# git interpret-trailers --in-place --trailer "$SOB" "$COMMIT_MSG_FILE"
# if test -z "$COMMIT_SOURCE"
# then
#   /usr/bin/perl -i.bak -pe 'print "\n" if !$first_line++' "$COMMIT_MSG_FILE"
# fi
#!/bin/sh
#
# An example hook script to prepare a packed repository for use over
# dumb transports.
#
# To enable this hook, rename this file to "post-update".

exec git update-server-info
#!/bin/sh
#
# An example hook script to verify what is about to be committed.
# Called by "git merge" with no arguments.  The hook should
# exit with non-zero status after issuing an appropriate message to
# stderr if it wants to stop the merge commit.
#
# To enable this hook, rename this file to "pre-merge-commit".

. git-sh-setup
test -x "$GIT_DIR/hooks/pre-commit" &&
        exec "$GIT_DIR/hooks/pre-commit"
:
#!/bin/sh
#
# An example hook script to verify what is about to be committed
# by applypatch from an e-mail message.
#
# The hook should exit with non-zero status after issuing an
# appropriate message if it wants to stop the commit.
#
# To enable this hook, rename this file to "pre-applypatch".

. git-sh-setup
precommit="$(git rev-parse --git-path hooks/pre-commit)"
test -x "$precommit" && exec "$precommit" ${1+"$@"}
:
#!/bin/sh

# An example hook script to verify what is about to be pushed.  Called by "git
# push" after it has checked the remote status, but before anything has been
# pushed.  If this script exits with a non-zero status nothing will be pushed.
#
# This hook is called with the following parameters:
#
# $1 -- Name of the remote to which the push is being done
# $2 -- URL to which the push is being done
#
# If pushing without using a named remote those arguments will be equal.
#
# Information about the commits which are being pushed is supplied as lines to
# the standard input in the form:
#
#   <local ref> <local oid> <remote ref> <remote oid>
#
# This sample shows how to prevent push of commits where the log message starts
# with "WIP" (work in progress).

remote="$1"
url="$2"

zero=$(git hash-object --stdin </dev/null | tr '[0-9a-f]' '0')

while read local_ref local_oid remote_ref remote_oid
do
	if test "$local_oid" = "$zero"
	then
		# Handle delete
		:
	else
		if test "$remote_oid" = "$zero"
		then
			# New branch, examine all commits
			range="$local_oid"
		else
			# Update to existing branch, examine new commits
			range="$remote_oid..$local_oid"
		fi

		# Check for WIP commit
		commit=$(git rev-list -n 1 --grep '^WIP' "$range")
		if test -n "$commit"
		then
			echo >&2 "Found WIP commit in $local_ref, not pushing"
			exit 1
		fi
	fi
done

exit 0
#!/bin/sh
#
# An example hook script to block unannotated tags from entering.
# Called by "git receive-pack" with arguments: refname sha1-old sha1-new
#
# To enable this hook, rename this file to "update".
#
# Config
# ------
# hooks.allowunannotated
#   This boolean sets whether unannotated tags will be allowed into the
#   repository.  By default they won't be.
# hooks.allowdeletetag
#   This boolean sets whether deleting tags will be allowed in the
#   repository.  By default they won't be.
# hooks.allowmodifytag
#   This boolean sets whether a tag may be modified after creation. By default
#   it won't be.
# hooks.allowdeletebranch
#   This boolean sets whether deleting branches will be allowed in the
#   repository.  By default they won't be.
# hooks.denycreatebranch
#   This boolean sets whether remotely creating branches will be denied
#   in the repository.  By default this is allowed.
#

# --- Command line
refname="$1"
oldrev="$2"
newrev="$3"

# --- Safety check
if [ -z "$GIT_DIR" ]; then
	echo "Don't run this script from the command line." >&2
	echo " (if you want, you could supply GIT_DIR then run" >&2
	echo "  $0 <ref> <oldrev> <newrev>)" >&2
	exit 1
fi

if [ -z "$refname" -o -z "$oldrev" -o -z "$newrev" ]; then
	echo "usage: $0 <ref> <oldrev> <newrev>" >&2
	exit 1
fi

# --- Config
allowunannotated=$(git config --type=bool hooks.allowunannotated)
allowdeletebranch=$(git config --type=bool hooks.allowdeletebranch)
denycreatebranch=$(git config --type=bool hooks.denycreatebranch)
allowdeletetag=$(git config --type=bool hooks.allowdeletetag)
allowmodifytag=$(git config --type=bool hooks.allowmodifytag)

# check for no description
projectdesc=$(sed -e '1q' "$GIT_DIR/description")
case "$projectdesc" in
"Unnamed repository"* | "")
	echo "*** Project description file hasn't been set" >&2
	exit 1
	;;
esac

# --- Check types
# if $newrev is 0000...0000, it's a commit to delete a ref.
zero=$(git hash-object --stdin </dev/null | tr '[0-9a-f]' '0')
if [ "$newrev" = "$zero" ]; then
	newrev_type=delete
else
	newrev_type=$(git cat-file -t $newrev)
fi

case "$refname","$newrev_type" in
	refs/tags/*,commit)
		# un-annotated tag
		short_refname=${refname##refs/tags/}
		if [ "$allowunannotated" != "true" ]; then
			echo "*** The un-annotated tag, $short_refname, is not allowed in this repository" >&2
			echo "*** Use 'git tag [ -a | -s ]' for tags you want to propagate." >&2
			exit 1
		fi
		;;
	refs/tags/*,delete)
		# delete tag
		if [ "$allowdeletetag" != "true" ]; then
			echo "*** Deleting a tag is not allowed in this repository" >&2
			exit 1
		fi
		;;
	refs/tags/*,tag)
		# annotated tag
		if [ "$allowmodifytag" != "true" ] && git rev-parse $refname > /dev/null 2>&1
		then
			echo "*** Tag '$refname' already exists." >&2
			echo "*** Modifying a tag is not allowed in this repository." >&2
			exit 1
		fi
		;;
	refs/heads/*,commit)
		# branch
		if [ "$oldrev" = "$zero" -a "$denycreatebranch" = "true" ]; then
			echo "*** Creating a branch is not allowed in this repository" >&2
			exit 1
		fi
		;;
	refs/heads/*,delete)
		# delete branch
		if [ "$allowdeletebranch" != "true" ]; then
			echo "*** Deleting a branch is not allowed in this repository" >&2
			exit 1
		fi
		;;
	refs/remotes/*,commit)
		# tracking branch
		;;
	refs/remotes/*,delete)
		# delete tracking branch
		if [ "$allowdeletebranch" != "true" ]; then
			echo "*** Deleting a tracking branch is not allowed in this repository" >&2
			exit 1
		fi
		;;
	*)
		# Anything else (is there anything else?)
		echo "*** Update hook: unknown type of update to ref $refname of type $newrev_type" >&2
		exit 1
		;;
esac

# --- Finished
exit 0
#!/bin/sh

# An example hook script to update a checked-out tree on a git push.
#
# This hook is invoked by git-receive-pack(1) when it reacts to git
# push and updates reference(s) in its repository, and when the push
# tries to update the branch that is currently checked out and the
# receive.denyCurrentBranch configuration variable is set to
# updateInstead.
#
# By default, such a push is refused if the working tree and the index
# of the remote repository has any difference from the currently
# checked out commit; when both the working tree and the index match
# the current commit, they are updated to match the newly pushed tip
# of the branch. This hook is to be used to override the default
# behaviour; however the code below reimplements the default behaviour
# as a starting point for convenient modification.
#
# The hook receives the commit with which the tip of the current
# branch is going to be updated:
commit=$1

# It can exit with a non-zero status to refuse the push (when it does
# so, it must not modify the index or the working tree).
die () {
	echo >&2 "$*"
	exit 1
}

# Or it can make any necessary changes to the working tree and to the
# index to bring them to the desired state when the tip of the current
# branch is updated to the new commit, and exit with a zero status.
#
# For example, the hook can simply run git read-tree -u -m HEAD "$1"
# in order to emulate git fetch that is run in the reverse direction
# with git push, as the two-tree form of git read-tree -u -m is
# essentially the same as git switch or git checkout that switches
# branches while keeping the local changes in the working tree that do
# not interfere with the difference between the branches.

# The below is a more-or-less exact translation to shell of the C code
# for the default behaviour for git's push-to-checkout hook defined in
# the push_to_deploy() function in builtin/receive-pack.c.
#
# Note that the hook will be executed from the repository directory,
# not from the working tree, so if you want to perform operations on
# the working tree, you will have to adapt your code accordingly, e.g.
# by adding "cd .." or using relative paths.

if ! git update-index -q --ignore-submodules --refresh
then
	die "Up-to-date check failed"
fi

if ! git diff-files --quiet --ignore-submodules --
then
	die "Working directory has unstaged changes"
fi

# This is a rough translation of:
#
#   head_has_history() ? "HEAD" : EMPTY_TREE_SHA1_HEX
if git cat-file -e HEAD 2>/dev/null
then
	head=HEAD
else
	head=$(git hash-object -t tree --stdin </dev/null)
fi

if ! git diff-index --quiet --cached --ignore-submodules $head --
then
	die "Working directory has staged changes"
fi

if ! git read-tree -u -m "$commit"
then
	die "Could not update working tree to new HEAD"
fi
2790a2b98ca2262fb7a37e4a033c7bb1f677abbe
DIRC      g>52�G�g>52�G�  d�  ��  �      B��w$����PzP��;��N{ .gitattributes    g>52�CIg>52�CI  d�  ��  �     �9�.�L���$���j�k� LICENSE   g>52XI�g>52XI�  d�  ��  �      �}��/�{�u67�Qߝ�� 	README.md g>b+��g>b+���  em  ��  �    �g��#�ӡC�I$zh�| app.phar  g>t�̕g>t�̕  en  ��  �     ;����ª:\�'ؼF�y� build-phar.php    g>f6�g>f6�  eo  ��  �     	<��ۀ"�Ჵc�d�ݢX�" 
engine.php        g>b,!�zg>b,��  ep  ��  �     �]7�5~.[���)$��M� 	index.php g>%"���g>%"���  eq  ��  �     gu=�)}qǅ�;����%�H phar-stub.php     g>�.N�qg>�.N�q  er  ��  �     �F���W*��iu�;�	i� 
styles.css        g>�Eg>�E  es  ��  �     !#͎�	��f�q��Ŏ��I��S user_script.php   g>4��g>4��  et  ��  �      ��A�=�2��|��M˽_�~�+ view_balances.php TREE    11 0
��%�?(n�$�%q"�;N+�O~���LYL@�i�z&_G�;Initial Commit v0.1
<?php
$home_dir = getenv('HOME') ?: '/tmp';
$data_file = $home_dir . "/family_data.json";
function load_data()
{
    global $data_file;
    if (file_exists($data_file)) {
        $data = file_get_contents($data_file);
        return json_decode($data, true);
    }
    return [];
}
function save_data($data)
{
    global $data_file;
    file_put_contents($data_file, json_encode($data, JSON_PRETTY_PRINT));
}
function modify_bank_balance($user, $bank, $action, $amount)
{
    $data = load_data();
    $user = strtolower(trim($user));
    $bank = strtoupper(trim($bank)); 
    if (isset($data[$user][$bank])) {
        $amount = floatval($amount); 
        if ($action === 'Debit') {
            $data[$user][$bank] -= $amount; 
        } elseif ($action === 'Credit') {
            $data[$user][$bank] += $amount; 
        } elseif ($action === 'Set') {
            $data[$user][$bank] = $amount; 
        }
        save_data($data);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'modify_balance') {
        $user = $_POST['person_name'] ?? '';
        $bank = $_POST['bank_name'] ?? '';
        $balance_action = $_POST['balance_action'] ?? '';
        $amount = $_POST['amount'] ?? '';
        if ($user && $bank && in_array($balance_action, ['Debit', 'Credit', 'Set']) && is_numeric($amount)) {
            modify_bank_balance($user, $bank, $balance_action, $amount);
        }
    }
    header("Location: view_balances.php");
    exit;
}
$data = load_data();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View and Update Bank Balances</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        const userBankData = <?= json_encode($data) ?>;

        function updateBankDropdown() {
            const userSelect = document.getElementById('person_name');
            const bankSelect = document.getElementById('bank_name');
            const selectedUser = userSelect.value.toLowerCase();
            bankSelect.innerHTML = '<option value="">Select Bank</option>';
            if (selectedUser && userBankData[selectedUser]) {
                const banks = Object.keys(userBankData[selectedUser]);
                banks.forEach(bank => {
                    const option = document.createElement('option');
                    option.value = bank;
                    option.textContent = bank;
                    bankSelect.appendChild(option);
                });
            }
        }
    </script>

</head>

<body>
    <div class="container">
        <h1>User Bank Balances</h1>
        <div class="form-inline">
            <label for="user-filter">Select User:</label>
            <select id="user-filter">
                <option value="all">All Users</option>
                <?php foreach (array_keys($data) as $user): ?>
                    <option value="<?= htmlspecialchars($user) ?>"><?= ucwords($user) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
<?php
$total_balance = 0;
foreach ($data as $user => $banks) {
    foreach ($banks as $bank => $balance) {
        $total_balance += $balance;
    }
}
?>
<table id="user-table">
    <thead>
        <tr>
            <th>User</th>
            <th>Bank</th>
            <th>
                Balance
                <button id="sort-balance" style="margin-left: 10px; padding: 2px 5px; font-size: 0.9em; cursor: pointer;">
                    Sort
                </button>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $user => $banks): ?>
            <?php foreach ($banks as $bank => $balance): ?>
                <tr data-user="<?= htmlspecialchars($user) ?>">
                    <td><?= ucwords($user) ?></td>
                    <td><?= htmlspecialchars($bank) ?></td>
                    <td><?= htmlspecialchars($balance) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    document.getElementById('sort-balance').addEventListener('click', function () {
        const table = document.getElementById('user-table').querySelector('tbody');
        const rows = Array.from(table.querySelectorAll('tr'));
        const sortOrder = this.dataset.sortOrder === 'asc' ? 'desc' : 'asc';
        this.dataset.sortOrder = sortOrder;
        rows.sort((a, b) => {
            const balanceA = parseFloat(a.cells[2].textContent) || 0;
            const balanceB = parseFloat(b.cells[2].textContent) || 0;
            return sortOrder === 'asc' ? balanceA - balanceB : balanceB - balanceA;
        });
        rows.forEach(row => table.appendChild(row));
    });
</script>
<div id="total-balance" style="text-align: right; margin-top: 1em; font-weight: bold;">
    Total Balance: <?= htmlspecialchars(number_format($total_balance, 2)) ?>
</div>

<script>
    document.getElementById('user-filter').addEventListener('change', function() {
        const selectedUser = this.value.toLowerCase();
        const rows = document.querySelectorAll('#user-table tbody tr');
        let total = 0;
        rows.forEach(row => {
            const user = row.getAttribute('data-user').toLowerCase();
            const balance = parseFloat(row.querySelector('td:nth-child(3)').textContent);
            if (selectedUser === 'all' || user === selectedUser) {
                row.style.display = '';
                total += balance;
            } else {
                row.style.display = 'none';
            }
        });
        const totalBalanceDiv = document.getElementById('total-balance');
        totalBalanceDiv.textContent = `Total Balance: ${total.toFixed(2)}`;
    });
</script>
<div class="update-section">
    <h2>Update Bank Balance</h2>
    <form method="POST" style="display: flex; flex-direction: column; gap: 1em;">
        <input type="hidden" name="action" value="modify_balance">
        <div style="display: flex; gap: 1em; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 200px;">
                <label for="person_name">Select User</label>
                <select id="person_name" name="person_name" onchange="updateBankDropdown()" required>
                    <option value="">Select User</option>
                    <?php foreach ($data as $user => $banks): ?>
                        <option value="<?= htmlspecialchars($user) ?>"><?= ucwords($user) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="flex: 1; min-width: 200px;">
                <label for="bank_name">Select Bank</label>
                <select id="bank_name" name="bank_name" required>
                    <option value="">Select Bank</option>
                </select>
            </div>
            <div style="flex: 1; min-width: 200px;">
                <label for="balance_action">Action</label>
                <select id="balance_action" name="balance_action" required>
                    <option value="Credit">Credit</option>
                    <option value="Debit">Debit</option>
                    <option value="Set">Set</option>
                </select>
            </div>
            <div style="flex: 1; min-width: 200px;">
                <label for="amount">Amount</label>
                <input type="number" id="amount" name="amount" step="0.01" required>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
            <button type="submit" style="padding: 10px 20px; background-color: #007bff; border: none; color: white; border-radius: 4px; cursor: pointer;">Submit</button>
            

            <!-- Banks & Users Button -->
            <!-- <a href="user_script.php" 
               style="padding: 10px 20px; 
                      text-decoration: none; 
                      color: white; 
                      background-color: #28a745; 
                      border: none; 
                      border-radius: 4px; 
                      cursor: pointer; 
                      font-size: 14px;">
                Banks & Users
            </a> -->

        </div>
    </form>
</div>
    </div>
</body>
</html>����˗%d���|��&��>-����1�:�   GBMB#!/bin/bash
# A script to automate building and running the My-Banks application

# Ensure PHP is installed
if ! command -v php &> /dev/null; then
    echo "PHP is not installed. Please install PHP first."
    exit 1
fi

# Build the Phar file
echo "Building app.phar..."
php build-phar.php
chmod +x app.phar

if [ "$1" == "--install" ]; then
    echo "Installing app.phar to /usr/local/bin as 'mybanks'..."
    sudo mv app.phar /usr/local/bin/mybanks
    echo "Run the application anywhere using the command 'mybanks'."
else
    echo "Run the application using './app.phar'."
fi���a���;.��ٸ�(o���kfB�F#E7`   GBMBGNU GENERAL PUBLIC LICENSE
                       Version 3, 29 June 2007

 Copyright (C) 2007 Free Software Foundation, Inc. <https://fsf.org/>
 Everyone is permitted to copy and distribute verbatim copies
 of this license document, but changing it is not allowed.

                            Preamble

  The GNU General Public License is a free, copyleft license for
software and other kinds of works.

  The licenses for most software and other practical works are designed
to take away your freedom to share and change the works.  By contrast,
the GNU General Public License is intended to guarantee your freedom to
share and change all versions of a program--to make sure it remains free
software for all its users.  We, the Free Software Foundation, use the
GNU General Public License for most of our software; it applies also to
any other work released this way by its authors.  You can apply it to
your programs, too.

  When we speak of free software, we are referring to freedom, not
price.  Our General Public Licenses are designed to make sure that you
have the freedom to distribute copies of free software (and charge for
them if you wish), that you receive source code or can get it if you
want it, that you can change the software or use pieces of it in new
free programs, and that you know you can do these things.

  To protect your rights, we need to prevent others from denying you
these rights or asking you to surrender the rights.  Therefore, you have
certain responsibilities if you distribute copies of the software, or if
you modify it: responsibilities to respect the freedom of others.

  For example, if you distribute copies of such a program, whether
gratis or for a fee, you must pass on to the recipients the same
freedoms that you received.  You must make sure that they, too, receive
or can get the source code.  And you must show them these terms so they
know their rights.

  Developers that use the GNU GPL protect your rights with two steps:
(1) assert copyright on the software, and (2) offer you this License
giving you legal permission to copy, distribute and/or modify it.

  For the developers' and authors' protection, the GPL clearly explains
that there is no warranty for this free software.  For both users' and
authors' sake, the GPL requires that modified versions be marked as
changed, so that their problems will not be attributed erroneously to
authors of previous versions.

  Some devices are designed to deny users access to install or run
modified versions of the software inside them, although the manufacturer
can do so.  This is fundamentally incompatible with the aim of
protecting users' freedom to change the software.  The systematic
pattern of such abuse occurs in the area of products for individuals to
use, which is precisely where it is most unacceptable.  Therefore, we
have designed this version of the GPL to prohibit the practice for those
products.  If such problems arise substantially in other domains, we
stand ready to extend this provision to those domains in future versions
of the GPL, as needed to protect the freedom of users.

  Finally, every program is threatened constantly by software patents.
States should not allow patents to restrict development and use of
software on general-purpose computers, but in those that do, we wish to
avoid the special danger that patents applied to a free program could
make it effectively proprietary.  To prevent this, the GPL assures that
patents cannot be used to render the program non-free.

  The precise terms and conditions for copying, distribution and
modification follow.

                       TERMS AND CONDITIONS

  0. Definitions.

  "This License" refers to version 3 of the GNU General Public License.

  "Copyright" also means copyright-like laws that apply to other kinds of
works, such as semiconductor masks.

  "The Program" refers to any copyrightable work licensed under this
License.  Each licensee is addressed as "you".  "Licensees" and
"recipients" may be individuals or organizations.

  To "modify" a work means to copy from or adapt all or part of the work
in a fashion requiring copyright permission, other than the making of an
exact copy.  The resulting work is called a "modified version" of the
earlier work or a work "based on" the earlier work.

  A "covered work" means either the unmodified Program or a work based
on the Program.

  To "propagate" a work means to do anything with it that, without
permission, would make you directly or secondarily liable for
infringement under applicable copyright law, except executing it on a
computer or modifying a private copy.  Propagation includes copying,
distribution (with or without modification), making available to the
public, and in some countries other activities as well.

  To "convey" a work means any kind of propagation that enables other
parties to make or receive copies.  Mere interaction with a user through
a computer network, with no transfer of a copy, is not conveying.

  An interactive user interface displays "Appropriate Legal Notices"
to the extent that it includes a convenient and prominently visible
feature that (1) displays an appropriate copyright notice, and (2)
tells the user that there is no warranty for the work (except to the
extent that warranties are provided), that licensees may convey the
work under this License, and how to view a copy of this License.  If
the interface presents a list of user commands or options, such as a
menu, a prominent item in the list meets this criterion.

  1. Source Code.

  The "source code" for a work means the preferred form of the work
for making modifications to it.  "Object code" means any non-source
form of a work.

  A "Standard Interface" means an interface that either is an official
standard defined by a recognized standards body, or, in the case of
interfaces specified for a particular programming language, one that
is widely used among developers working in that language.

  The "System Libraries" of an executable work include anything, other
than the work as a whole, that (a) is included in the normal form of
packaging a Major Component, but which is not part of that Major
Component, and (b) serves only to enable use of the work with that
Major Component, or to implement a Standard Interface for which an
implementation is available to the public in source code form.  A
"Major Component", in this context, means a major essential component
(kernel, window system, and so on) of the specific operating system
(if any) on which the executable work runs, or a compiler used to
produce the work, or an object code interpreter used to run it.

  The "Corresponding Source" for a work in object code form means all
the source code needed to generate, install, and (for an executable
work) run the object code and to modify the work, including scripts to
control those activities.  However, it does not include the work's
System Libraries, or general-purpose tools or generally available free
programs which are used unmodified in performing those activities but
which are not part of the work.  For example, Corresponding Source
includes interface definition files associated with source files for
the work, and the source code for shared libraries and dynamically
linked subprograms that the work is specifically designed to require,
such as by intimate data communication or control flow between those
subprograms and other parts of the work.

  The Corresponding Source need not include anything that users
can regenerate automatically from other parts of the Corresponding
Source.

  The Corresponding Source for a work in source code form is that
same work.

  2. Basic Permissions.

  All rights granted under this License are granted for the term of
copyright on the Program, and are irrevocable provided the stated
conditions are met.  This License explicitly affirms your unlimited
permission to run the unmodified Program.  The output from running a
covered work is covered by this License only if the output, given its
content, constitutes a covered work.  This License acknowledges your
rights of fair use or other equivalent, as provided by copyright law.

  You may make, run and propagate covered works that you do not
convey, without conditions so long as your license otherwise remains
in force.  You may convey covered works to others for the sole purpose
of having them make modifications exclusively for you, or provide you
with facilities for running those works, provided that you comply with
the terms of this License in conveying all material for which you do
not control copyright.  Those thus making or running the covered works
for you must do so exclusively on your behalf, under your direction
and control, on terms that prohibit them from making any copies of
your copyrighted material outside their relationship with you.

  Conveying under any other circumstances is permitted solely under
the conditions stated below.  Sublicensing is not allowed; section 10
makes it unnecessary.

  3. Protecting Users' Legal Rights From Anti-Circumvention Law.

  No covered work shall be deemed part of an effective technological
measure under any applicable law fulfilling obligations under article
11 of the WIPO copyright treaty adopted on 20 December 1996, or
similar laws prohibiting or restricting circumvention of such
measures.

  When you convey a covered work, you waive any legal power to forbid
circumvention of technological measures to the extent such circumvention
is effected by exercising rights under this License with respect to
the covered work, and you disclaim any intention to limit operation or
modification of the work as a means of enforcing, against the work's
users, your or third parties' legal rights to forbid circumvention of
technological measures.

  4. Conveying Verbatim Copies.

  You may convey verbatim copies of the Program's source code as you
receive it, in any medium, provided that you conspicuously and
appropriately publish on each copy an appropriate copyright notice;
keep intact all notices stating that this License and any
non-permissive terms added in accord with section 7 apply to the code;
keep intact all notices of the absence of any warranty; and give all
recipients a copy of this License along with the Program.

  You may charge any price or no price for each copy that you convey,
and you may offer support or warranty protection for a fee.

  5. Conveying Modified Source Versions.

  You may convey a work based on the Program, or the modifications to
produce it from the Program, in the form of source code under the
terms of section 4, provided that you also meet all of these conditions:

    a) The work must carry prominent notices stating that you modified
    it, and giving a relevant date.

    b) The work must carry prominent notices stating that it is
    released under this License and any conditions added under section
    7.  This requirement modifies the requirement in section 4 to
    "keep intact all notices".

    c) You must license the entire work, as a whole, under this
    License to anyone who comes into possession of a copy.  This
    License will therefore apply, along with any applicable section 7
    additional terms, to the whole of the work, and all its parts,
    regardless of how they are packaged.  This License gives no
    permission to license the work in any other way, but it does not
    invalidate such permission if you have separately received it.

    d) If the work has interactive user interfaces, each must display
    Appropriate Legal Notices; however, if the Program has interactive
    interfaces that do not display Appropriate Legal Notices, your
    work need not make them do so.

  A compilation of a covered work with other separate and independent
works, which are not by their nature extensions of the covered work,
and which are not combined with it such as to form a larger program,
in or on a volume of a storage or distribution medium, is called an
"aggregate" if the compilation and its resulting copyright are not
used to limit the access or legal rights of the compilation's users
beyond what the individual works permit.  Inclusion of a covered work
in an aggregate does not cause this License to apply to the other
parts of the aggregate.

  6. Conveying Non-Source Forms.

  You may convey a covered work in object code form under the terms
of sections 4 and 5, provided that you also convey the
machine-readable Corresponding Source under the terms of this License,
in one of these ways:

    a) Convey the object code in, or embodied in, a physical product
    (including a physical distribution medium), accompanied by the
    Corresponding Source fixed on a durable physical medium
    customarily used for software interchange.

    b) Convey the object code in, or embodied in, a physical product
    (including a physical distribution medium), accompanied by a
    written offer, valid for at least three years and valid for as
    long as you offer spare parts or customer support for that product
    model, to give anyone who possesses the object code either (1) a
    copy of the Corresponding Source for all the software in the
    product that is covered by this License, on a durable physical
    medium customarily used for software interchange, for a price no
    more than your reasonable cost of physically performing this
    conveying of source, or (2) access to copy the
    Corresponding Source from a network server at no charge.

    c) Convey individual copies of the object code with a copy of the
    written offer to provide the Corresponding Source.  This
    alternative is allowed only occasionally and noncommercially, and
    only if you received the object code with such an offer, in accord
    with subsection 6b.

    d) Convey the object code by offering access from a designated
    place (gratis or for a charge), and offer equivalent access to the
    Corresponding Source in the same way through the same place at no
    further charge.  You need not require recipients to copy the
    Corresponding Source along with the object code.  If the place to
    copy the object code is a network server, the Corresponding Source
    may be on a different server (operated by you or a third party)
    that supports equivalent copying facilities, provided you maintain
    clear directions next to the object code saying where to find the
    Corresponding Source.  Regardless of what server hosts the
    Corresponding Source, you remain obligated to ensure that it is
    available for as long as needed to satisfy these requirements.

    e) Convey the object code using peer-to-peer transmission, provided
    you inform other peers where the object code and Corresponding
    Source of the work are being offered to the general public at no
    charge under subsection 6d.

  A separable portion of the object code, whose source code is excluded
from the Corresponding Source as a System Library, need not be
included in conveying the object code work.

  A "User Product" is either (1) a "consumer product", which means any
tangible personal property which is normally used for personal, family,
or household purposes, or (2) anything designed or sold for incorporation
into a dwelling.  In determining whether a product is a consumer product,
doubtful cases shall be resolved in favor of coverage.  For a particular
product received by a particular user, "normally used" refers to a
typical or common use of that class of product, regardless of the status
of the particular user or of the way in which the particular user
actually uses, or expects or is expected to use, the product.  A product
is a consumer product regardless of whether the product has substantial
commercial, industrial or non-consumer uses, unless such uses represent
the only significant mode of use of the product.

  "Installation Information" for a User Product means any methods,
procedures, authorization keys, or other information required to install
and execute modified versions of a covered work in that User Product from
a modified version of its Corresponding Source.  The information must
suffice to ensure that the continued functioning of the modified object
code is in no case prevented or interfered with solely because
modification has been made.

  If you convey an object code work under this section in, or with, or
specifically for use in, a User Product, and the conveying occurs as
part of a transaction in which the right of possession and use of the
User Product is transferred to the recipient in perpetuity or for a
fixed term (regardless of how the transaction is characterized), the
Corresponding Source conveyed under this section must be accompanied
by the Installation Information.  But this requirement does not apply
if neither you nor any third party retains the ability to install
modified object code on the User Product (for example, the work has
been installed in ROM).

  The requirement to provide Installation Information does not include a
requirement to continue to provide support service, warranty, or updates
for a work that has been modified or installed by the recipient, or for
the User Product in which it has been modified or installed.  Access to a
network may be denied when the modification itself materially and
adversely affects the operation of the network or violates the rules and
protocols for communication across the network.

  Corresponding Source conveyed, and Installation Information provided,
in accord with this section must be in a format that is publicly
documented (and with an implementation available to the public in
source code form), and must require no special password or key for
unpacking, reading or copying.

  7. Additional Terms.

  "Additional permissions" are terms that supplement the terms of this
License by making exceptions from one or more of its conditions.
Additional permissions that are applicable to the entire Program shall
be treated as though they were included in this License, to the extent
that they are valid under applicable law.  If additional permissions
apply only to part of the Program, that part may be used separately
under those permissions, but the entire Program remains governed by
this License without regard to the additional permissions.

  When you convey a copy of a covered work, you may at your option
remove any additional permissions from that copy, or from any part of
it.  (Additional permissions may be written to require their own
removal in certain cases when you modify the work.)  You may place
additional permissions on material, added by you to a covered work,
for which you have or can give appropriate copyright permission.

  Notwithstanding any other provision of this License, for material you
add to a covered work, you may (if authorized by the copyright holders of
that material) supplement the terms of this License with terms:

    a) Disclaiming warranty or limiting liability differently from the
    terms of sections 15 and 16 of this License; or

    b) Requiring preservation of specified reasonable legal notices or
    author attributions in that material or in the Appropriate Legal
    Notices displayed by works containing it; or

    c) Prohibiting misrepresentation of the origin of that material, or
    requiring that modified versions of such material be marked in
    reasonable ways as different from the original version; or

    d) Limiting the use for publicity purposes of names of licensors or
    authors of the material; or

    e) Declining to grant rights under trademark law for use of some
    trade names, trademarks, or service marks; or

    f) Requiring indemnification of licensors and authors of that
    material by anyone who conveys the material (or modified versions of
    it) with contractual assumptions of liability to the recipient, for
    any liability that these contractual assumptions directly impose on
    those licensors and authors.

  All other non-permissive additional terms are considered "further
restrictions" within the meaning of section 10.  If the Program as you
received it, or any part of it, contains a notice stating that it is
governed by this License along with a term that is a further
restriction, you may remove that term.  If a license document contains
a further restriction but permits relicensing or conveying under this
License, you may add to a covered work material governed by the terms
of that license document, provided that the further restriction does
not survive such relicensing or conveying.

  If you add terms to a covered work in accord with this section, you
must place, in the relevant source files, a statement of the
additional terms that apply to those files, or a notice indicating
where to find the applicable terms.

  Additional terms, permissive or non-permissive, may be stated in the
form of a separately written license, or stated as exceptions;
the above requirements apply either way.

  8. Termination.

  You may not propagate or modify a covered work except as expressly
provided under this License.  Any attempt otherwise to propagate or
modify it is void, and will automatically terminate your rights under
this License (including any patent licenses granted under the third
paragraph of section 11).

  However, if you cease all violation of this License, then your
license from a particular copyright holder is reinstated (a)
provisionally, unless and until the copyright holder explicitly and
finally terminates your license, and (b) permanently, if the copyright
holder fails to notify you of the violation by some reasonable means
prior to 60 days after the cessation.

  Moreover, your license from a particular copyright holder is
reinstated permanently if the copyright holder notifies you of the
violation by some reasonable means, this is the first time you have
received notice of violation of this License (for any work) from that
copyright holder, and you cure the violation prior to 30 days after
your receipt of the notice.

  Termination of your rights under this section does not terminate the
licenses of parties who have received copies or rights from you under
this License.  If your rights have been terminated and not permanently
reinstated, you do not qualify to receive new licenses for the same
material under section 10.

  9. Acceptance Not Required for Having Copies.

  You are not required to accept this License in order to receive or
run a copy of the Program.  Ancillary propagation of a covered work
occurring solely as a consequence of using peer-to-peer transmission
to receive a copy likewise does not require acceptance.  However,
nothing other than this License grants you permission to propagate or
modify any covered work.  These actions infringe copyright if you do
not accept this License.  Therefore, by modifying or propagating a
covered work, you indicate your acceptance of this License to do so.

  10. Automatic Licensing of Downstream Recipients.

  Each time you convey a covered work, the recipient automatically
receives a license from the original licensors, to run, modify and
propagate that work, subject to this License.  You are not responsible
for enforcing compliance by third parties with this License.

  An "entity transaction" is a transaction transferring control of an
organization, or substantially all assets of one, or subdividing an
organization, or merging organizations.  If propagation of a covered
work results from an entity transaction, each party to that
transaction who receives a copy of the work also receives whatever
licenses to the work the party's predecessor in interest had or could
give under the previous paragraph, plus a right to possession of the
Corresponding Source of the work from the predecessor in interest, if
the predecessor has it or can get it with reasonable efforts.

  You may not impose any further restrictions on the exercise of the
rights granted or affirmed under this License.  For example, you may
not impose a license fee, royalty, or other charge for exercise of
rights granted under this License, and you may not initiate litigation
(including a cross-claim or counterclaim in a lawsuit) alleging that
any patent claim is infringed by making, using, selling, offering for
sale, or importing the Program or any portion of it.

  11. Patents.

  A "contributor" is a copyright holder who authorizes use under this
License of the Program or a work on which the Program is based.  The
work thus licensed is called the contributor's "contributor version".

  A contributor's "essential patent claims" are all patent claims
owned or controlled by the contributor, whether already acquired or
hereafter acquired, that would be infringed by some manner, permitted
by this License, of making, using, or selling its contributor version,
but do not include claims that would be infringed only as a
consequence of further modification of the contributor version.  For
purposes of this definition, "control" includes the right to grant
patent sublicenses in a manner consistent with the requirements of
this License.

  Each contributor grants you a non-exclusive, worldwide, royalty-free
patent license under the contributor's essential patent claims, to
make, use, sell, offer for sale, import and otherwise run, modify and
propagate the contents of its contributor version.

  In the following three paragraphs, a "patent license" is any express
agreement or commitment, however denominated, not to enforce a patent
(such as an express permission to practice a patent or covenant not to
sue for patent infringement).  To "grant" such a patent license to a
party means to make such an agreement or commitment not to enforce a
patent against the party.

  If you convey a covered work, knowingly relying on a patent license,
and the Corresponding Source of the work is not available for anyone
to copy, free of charge and under the terms of this License, through a
publicly available network server or other readily accessible means,
then you must either (1) cause the Corresponding Source to be so
available, or (2) arrange to deprive yourself of the benefit of the
patent license for this particular work, or (3) arrange, in a manner
consistent with the requirements of this License, to extend the patent
license to downstream recipients.  "Knowingly relying" means you have
actual knowledge that, but for the patent license, your conveying the
covered work in a country, or your recipient's use of the covered work
in a country, would infringe one or more identifiable patents in that
country that you have reason to believe are valid.

  If, pursuant to or in connection with a single transaction or
arrangement, you convey, or propagate by procuring conveyance of, a
covered work, and grant a patent license to some of the parties
receiving the covered work authorizing them to use, propagate, modify
or convey a specific copy of the covered work, then the patent license
you grant is automatically extended to all recipients of the covered
work and works based on it.

  A patent license is "discriminatory" if it does not include within
the scope of its coverage, prohibits the exercise of, or is
conditioned on the non-exercise of one or more of the rights that are
specifically granted under this License.  You may not convey a covered
work if you are a party to an arrangement with a third party that is
in the business of distributing software, under which you make payment
to the third party based on the extent of your activity of conveying
the work, and under which the third party grants, to any of the
parties who would receive the covered work from you, a discriminatory
patent license (a) in connection with copies of the covered work
conveyed by you (or copies made from those copies), or (b) primarily
for and in connection with specific products or compilations that
contain the covered work, unless you entered into that arrangement,
or that patent license was granted, prior to 28 March 2007.

  Nothing in this License shall be construed as excluding or limiting
any implied license or other defenses to infringement that may
otherwise be available to you under applicable patent law.

  12. No Surrender of Others' Freedom.

  If conditions are imposed on you (whether by court order, agreement or
otherwise) that contradict the conditions of this License, they do not
excuse you from the conditions of this License.  If you cannot convey a
covered work so as to satisfy simultaneously your obligations under this
License and any other pertinent obligations, then as a consequence you may
not convey it at all.  For example, if you agree to terms that obligate you
to collect a royalty for further conveying from those to whom you convey
the Program, the only way you could satisfy both those terms and this
License would be to refrain entirely from conveying the Program.

  13. Use with the GNU Affero General Public License.

  Notwithstanding any other provision of this License, you have
permission to link or combine any covered work with a work licensed
under version 3 of the GNU Affero General Public License into a single
combined work, and to convey the resulting work.  The terms of this
License will continue to apply to the part which is the covered work,
but the special requirements of the GNU Affero General Public License,
section 13, concerning interaction through a network will apply to the
combination as such.

  14. Revised Versions of this License.

  The Free Software Foundation may publish revised and/or new versions of
the GNU General Public License from time to time.  Such new versions will
be similar in spirit to the present version, but may differ in detail to
address new problems or concerns.

  Each version is given a distinguishing version number.  If the
Program specifies that a certain numbered version of the GNU General
Public License "or any later version" applies to it, you have the
option of following the terms and conditions either of that numbered
version or of any later version published by the Free Software
Foundation.  If the Program does not specify a version number of the
GNU General Public License, you may choose any version ever published
by the Free Software Foundation.

  If the Program specifies that a proxy can decide which future
versions of the GNU General Public License can be used, that proxy's
public statement of acceptance of a version permanently authorizes you
to choose that version for the Program.

  Later license versions may give you additional or different
permissions.  However, no additional obligations are imposed on any
author or copyright holder as a result of your choosing to follow a
later version.

  15. Disclaimer of Warranty.

  THERE IS NO WARRANTY FOR THE PROGRAM, TO THE EXTENT PERMITTED BY
APPLICABLE LAW.  EXCEPT WHEN OTHERWISE STATED IN WRITING THE COPYRIGHT
HOLDERS AND/OR OTHER PARTIES PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY
OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING, BUT NOT LIMITED TO,
THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
PURPOSE.  THE ENTIRE RISK AS TO THE QUALITY AND PERFORMANCE OF THE PROGRAM
IS WITH YOU.  SHOULD THE PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF
ALL NECESSARY SERVICING, REPAIR OR CORRECTION.

  16. Limitation of Liability.

  IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MODIFIES AND/OR CONVEYS
THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES, INCLUDING ANY
GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING OUT OF THE
USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED TO LOSS OF
DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY YOU OR THIRD
PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER PROGRAMS),
EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE POSSIBILITY OF
SUCH DAMAGES.

  17. Interpretation of Sections 15 and 16.

  If the disclaimer of warranty and limitation of liability provided
above cannot be given local legal effect according to their terms,
reviewing courts shall apply local law that most closely approximates
an absolute waiver of all civil liability in connection with the
Program, unless a warranty or assumption of liability accompanies a
copy of the Program in return for a fee.

                     END OF TERMS AND CONDITIONS

            How to Apply These Terms to Your New Programs

  If you develop a new program, and you want it to be of the greatest
possible use to the public, the best way to achieve this is to make it
free software which everyone can redistribute and change under these terms.

  To do so, attach the following notices to the program.  It is safest
to attach them to the start of each source file to most effectively
state the exclusion of warranty; and each file should have at least
the "copyright" line and a pointer to where the full notice is found.

    <one line to give the program's name and a brief idea of what it does.>
    Copyright (C) 2024 Darshan P.

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.

Also add information on how to contact you by electronic and paper mail.

  If the program does terminal interaction, make it output a short
notice like this when it starts in an interactive mode:

    <program>  Copyright (C) 2024 Darshan P.
    This program comes with ABSOLUTELY NO WARRANTY; for details type `show w'.
    This is free software, and you are welcome to redistribute it
    under certain conditions; type `show c' for details.

The hypothetical commands `show w' and `show c' should show the appropriate
parts of the General Public License.  Of course, your program's commands
might be different; for a GUI interface, you would use an "about box".

  You should also get your employer (if you work as a programmer) or school,
if any, to sign a "copyright disclaimer" for the program, if necessary.
For more information on this, and how to apply and follow the GNU GPL, see
<https://www.gnu.org/licenses/>.

  The GNU General Public License does not permit incorporating your program
into proprietary programs.  If your program is a subroutine library, you
may consider it more useful to permit linking proprietary applications with
the library.  If this is what you want to do, use the GNU Lesser General
Public License instead of this License.  But first, please read
<https://www.gnu.org/licenses/why-not-lgpl.html>.
#!/bin/bash
# A script to automate building and running the My-Banks application

# Ensure PHP is installed
if ! command -v php &> /dev/null; then
    echo "PHP is not installed. Please install PHP first."
    exit 1
fi

# Build the Phar file
echo "Building app.phar..."
php build-phar.php
chmod +x app.phar

if [ "$1" == "--install" ]; then
    echo "Installing app.phar to /usr/local/bin as 'mybanks'..."
    sudo mv app.phar /usr/local/bin/mybanks
    echo "Run the application anywhere using the command 'mybanks'."
else
    echo "Run the application using './app.phar'."
fi(d�� Jx�3l�?:�VRi�w�T��]#��   GBMB