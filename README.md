# Package Manager

This repository contains the source code for a PHP-based package management system developed using XAMPP. The project allows users to add, manage, and delete packages using a web interface.

## Repository URL

[GitHub Repository](https://github.com/Youcode-Classe-E-2024-2025/achraf_sikal-package)

## Prerequisites

To run this project locally, ensure you have the following:

1. **XAMPP**
   - Download and install XAMPP from [apachefriends.org](https://www.apachefriends.org/).
   - Ensure Apache and MySQL are running in the XAMPP Control Panel.

2. **Web Browser**
   - A modern web browser to access the application.

3. **Git** (optional)
   - Install Git if you wish to clone the repository using the command line.
   - [Git Downloads](https://git-scm.com/downloads)

## Setup Instructions

1. **Clone the Repository**
   ```bash
   git clone https://github.com/Youcode-Classe-E-2024-2025/achraf_sikal-package.git
   ```

2. **Move the Project to XAMPP Directory**
   - Copy or move the project folder to the `htdocs` directory in your XAMPP installation path.
     
     Example:
     ```
     C:\xampp\htdocs\achraf_sikal-package
     ```

3. **Set Up the Database**
   - Open `phpMyAdmin` by navigating to [http://localhost/phpmyadmin](http://localhost/phpmyadmin) in your browser.
   - Create a new database by running the following command:
     ```sql
     CREATE DATABASE package_manager;
     ```
   - Import the `data.sql` file:
     1. Select the newly created database (`package_manager`).
     2. Go to the **Import** tab.
     3. Choose the `data.sql` file from the project directory and click **Go**.

4. **Run the Application**
   - Open your web browser and navigate to:
     ```
     http://localhost/achraf_sikal-package
     ```

## File Structure

```
package_manager/
|├── assets/
|   ├── images/
|       ├── package-x-generic.svg
|       └── trash-solid.svg
|├── .gitignore
|├── add.php
|├── data.php
|├── data.sql
|├── helpers.php
|├── index.php
|└── package.php
```

## Features

- Add new packages.
- Delete packages.
- Manage package details.

## Database Schema

The database includes the following tables:

- **autors**: Stores author information.
- **packages**: Stores package details.
- **versions**: Tracks versions of each package.
- **tags**: Stores tags associated with packages.
- **dependencies**: Defines parent-child relationships between packages.
- **packages_tags**: Maps tags to packages.
- **autors_packages**: Links authors to packages.

### Sample Data

The `data.sql` file includes:

- Predefined authors, packages, versions, tags, and relationships.
- Example entries for packages such as "Library A" and "Framework B".

## Contributing

If you would like to contribute to this project:

1. Fork the repository.
2. Create a new branch:
   ```bash
   git checkout -b feature-name
   ```
3. Commit your changes:
   ```bash
   git commit -m "Add feature description"
   ```
4. Push to the branch:
   ```bash
   git push origin feature-name
   ```
5. Open a pull request.

## License

This project is licensed under the MIT License. See the LICENSE file for details.

---

For any questions or issues, please open an issue in the GitHub repository.

