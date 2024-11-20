
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
A script named `make-app.sh` is provided to streamline the Phar creation and execution process. Here’s the script structure:

```bash
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
```
Note: You may have to uncomment & turn `Off` the `readonly` from `php ini` 

# Make it executable
chmod +x app.phar

# Optional: Move to /usr/local/bin for global access
if [ "$1" == "--install" ]; then
    echo "Installing app.phar to /usr/local/bin as 'mybanks'..."
    sudo mv app.phar /usr/local/bin/mybanks
    echo "Run the application anywhere using the command 'mybanks'."
else
    echo "Run the application using './app.phar'."
fi
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
