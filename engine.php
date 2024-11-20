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
?>