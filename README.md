# **My-Banks: Simplify Family Bank Account Management**

**My-Banks** is a tool designed to help you effortlessly manage and keep track of all your family’s bank accounts in one place. 

Whether you're juggling multiple accounts across various banks or simply want a centralized way to monitor balances, **My-Banks** provides a streamlined solution. 

> **Note**: While you can delegate account tracking to other family members, such as your children, **My-Banks** is primarily intended for personal or family-level financial tracking.

---

## **How to Use**

### **Option 1: Run the Prebuilt Application (`executable files`)**
1. **Find the Executable Files**  
   Locate the following files in the `executables` folder:
   ```bash
   ├── executables
   │   ├── unix_based_machines.php
   │   └── windows-executable.phar
   ```

2. **Based on Operating System**  

   - **Unix/Linux/macOS Users**:  
     Run `unix_based_machines.php` by navigating to the folder in your terminal and executing:
     ```bash
     php unix_based_machines.php
     ```

   - **Windows Users**:  
     Run `windows-executable.phar` by opening Command Prompt or PowerShell, navigating to the folder, and executing:
     ```bash
     php windows-executable.phar
     ```

   - Make sure PHP is installed and added to your system's PATH for the commands to work.

3. **Optional: Add to Global Path**  
   For easier access, move `app.phar` to `/usr/local/bin` (Linux/macOS) or a globally accessible directory (Windows) and rename it (e.g., `mybanks`):
   ```bash
   sudo mv app.phar /usr/local/bin/mybanks
   ```
   Now, you can run the app from any directory:
   ```bash
   mybanks
   ```

4. **Open the Application**  
   Once the app is running, open your web browser and navigate to:
   ```
   http://localhost:8000
   ```

5. **Verify Functionality**  
   Check the interface to ensure all features are functioning as expected. You can now manage and track your family's bank accounts seamlessly.

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
├── LICENSE
├── README.md
├── build-phar.php
├── engine.php
├── executables
│   ├── unics_based_machines.php
│   └── windows-executable.phar
├── index.php
├── make-app.sh
├── phar-stub.php
├── styles.css
├── user_script.php
└── view_balances.php
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
   
   ```bash 
   ;phar.readonly = On  # Original line
   phar.readonly = Off  # Updated line
   ```

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


# Troubleshooting and Documentation for Brew-Installed PHP

## Common Errors and Solutions for Homebrew-Installed PHP

| **Error**                                        | **Cause**                                                                                 | **Solution**                                                                                     |
|--------------------------------------------------|------------------------------------------------------------------------------------------|-------------------------------------------------------------------------------------------------|
| `phar.readonly => On => On`                      | `phar.readonly` is set to `On` in the Homebrew PHP configuration.                         | Update `/opt/homebrew/etc/php/8.x/php.ini` (replace `8.x` with your PHP version) and restart PHP. |
| `chmod: app.phar: No such file or directory`     | Build failed; `.phar` file was not created.                                              | Check logs, fix build errors, and retry after cleaning up with `rm -f app.phar`.                 |
| `Could not open input file: ./unics_based_machines.phar` | Missing execute permissions or incorrect path.                                            | Use `chmod +x` and verify the file path.                                                        |
| `zsh: no such file or directory: ./make-app.sh`  | Script is not in the current directory.                                                  | Navigate to the correct directory (`cd <path>`) or provide the full path to the script.          |
| `mv: rename app.phar to /usr/local/bin/mybanks: No such file or directory` | `.phar` file was not created successfully due to a build error.                           | Ensure `phar.readonly` is `Off`, clean up, and rebuild.                                          |
| `mv: Permission denied`                          | Lack of permissions to copy `.phar` to `/usr/local/bin`.                                 | Use `sudo ./make-app.sh --install` or provide the password when prompted during the install.     |
| `brew services restart php` fails               | PHP service is not properly installed or configured in Homebrew.                        | Reinstall PHP via Homebrew: `brew reinstall php`.                                                |
| `PHP extensions missing`                        | Required PHP extensions (e.g., `phar`) are not enabled in the Homebrew installation.      | Check `/opt/homebrew/etc/php/8.x/php.ini` to ensure extensions are enabled.                      |

## Steps for Brew-Installed PHP

### 1. Verify PHP Installation
- Check the installed PHP version and confirm Homebrew's PHP path:
  ```bash
  php --version
  which php




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
For any issues or questions, feel free to contact us or check out the documentation in the project repository.
