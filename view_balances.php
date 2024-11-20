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
</html>