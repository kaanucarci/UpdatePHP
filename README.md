# Update PHP

**Update PHP** is a basic version control and auto-update system designed for developers who manage multiple web projects that share common modules. With this system, consistency is ensured across all projects, and manual update errors are prevented.

## 📁 Project Structure

The system is built on three main folders:

### 1. `UpdatePHP`
This is the core of the system. You enter:
- The URL of the project where the update was made
- The filenames of the updated files

### 2. `UpdatedFTP`
This folder serves as the source for updated code.  
The system fetches files from here.  
**Example URL:** `https://www.example.com/`

### 3. `FtpToBeUpdated`
This folder should exist in the root directory of each FTP-based project that needs to be updated.

---

## 🔁 How It Works

1. The user inputs the URL of the updated project and the list of updated file names via the `UpdatePHP` interface.
2. The system pulls the updated files from the `UpdatedFTP` project.
3. Then it:
   - Takes backups of all projects inside the `FtpToBeUpdated` folder.
   - Replaces the old files with the new ones.

---

## ✅ Benefits

- Automatically updates multiple web projects with minimal effort.
- Prevents human error caused by manual updates.
- Saves time and ensures consistency across projects.

---

## 📌 Use Case Example

If you have **30 different web projects**, and you make a change in 1 of them, Update PHP allows you to automatically apply those changes to the other 29 projects.

---

## ⚠️ Notes

- Make sure the FTP structure and file permissions are correctly set.
- Always test the update process on a few projects before applying to all.

---

Happy coding! 🚀
