# 🧾 New System SA - Sales Automation Platform

A PHP-based sales management and reporting system for insurance policy tracking and automated monthly reporting. This system helps streamline the sales process, generate detailed PDF reports per user, and send monthly performance summaries via email using PHPMailer.

---

## 🚀 Features

- 🔐 User authentication & session management
- 📈 Real-time and monthly sales tracking
- 📊 Dynamic PDF report generation (using FPDF)
- 📤 Automated email sending with PDF attachments (via PHPMailer)
- 🧮 Monthly summary breakdown (MCFP / FP)
- 📂 Organized codebase with reusable classes and database abstraction
- 🏢 Role-based data display (`SPO`, `TL`, `Staff`)
- 🕒 Timezone adjusted (`Asia/Colombo`) timestamping
- ✅ Summary logging in DB (`summery_t`) to prevent duplicate reporting

---

## 🛠️ Technologies Used

- 🐘 PHP (core backend)
- 📄 FPDF (PDF generation)
- ✉️ PHPMailer (email delivery)
- 🧮 MySQL (database)
- 🎨 HTML / CSS (frontend, minimal)
- 🔧 JavaScript (form validation / interaction)

---

## 📦 Folder Structure

```bash
new-system-sa/
├── email_send/           # PHPMailer dependencies
├── fpdf/                 # FPDF library for PDF rendering
├── reports/              # Optional: where PDF files can be stored/generated
├── assets/               # Logo, styles (if used)
├── db/connection.php     # MySQL DB connection
├── generate_report.php   # Core logic for monthly PDF and email
├── index.php             # Login or dashboard
├── README.md             # ← This file!
