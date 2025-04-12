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
```
🧪 How It Works
✅ Users input sales data (police_t)

📆 At the end of the month, script:

Queries users with sales last month

Summarizes MCFP/FP values

Generates a PDF for each user

Sends it via email

Logs the report in summery_t

📬 Each user receives a detailed monthly PDF with totals.

🖥️ Setup Instructions
Clone the repository

bash
Copy
Edit
git clone https://github.com/Diluna123/new-system-sa.git
cd new-system-sa
Setup the database

Import your SQL schema (make sure users, police_t, summery_t tables exist)

Update DB credentials in connection.php

Configure Email

In generate_report.php, set your Gmail SMTP credentials:

php
Copy
Edit
$mail->Username = 'your_email@gmail.com';
$mail->Password = 'your_app_password';
Run report generator

Either schedule it with a CRON job

Or manually run via browser or CLI:

nginx
Copy
Edit
php generate_report.php
📷 Screenshots (Optional)
Add screenshots of the dashboard, reports, or email preview here.

🙌 Credits
Developed by Diluna

PDF engine: FPDF

Mailer: PHPMailer

📬 Contact
Got questions or feedback?

📧 Email: dilunasithija111@gmail.com

💼 LinkedIn: Diluna's Profile (replace with your actual link)

📄 License
This project is licensed under the MIT License. See LICENSE for details.

yaml
Copy
Edit

---

Let me know if you want me to help you **add this directly to the repo**, or generate a `LICENSE` file too!
