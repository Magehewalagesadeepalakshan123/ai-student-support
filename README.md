# 🤖 AI-Powered Student Support System

An AI-powered web application developed to provide students with faster and more organized academic and technical support.

The system includes separate **Student, Staff, and Admin portals**, an AI-based student assistant, support ticket management, FAQs, notices, a knowledge base, and system analytics.

---

## 📌 Project Overview

The **AI-Powered Student Support System** is designed to help students quickly find answers to common university-related questions and communicate with support staff when additional assistance is required.

The AI Assistant searches information stored in the system's Knowledge Base and provides relevant responses. If reliable information is unavailable, students can create a support ticket for assistance from a staff member.

---

## ✨ Main Features

### 👨‍🎓 Student Portal

- Student registration and login
- Student dashboard
- AI Student Assistant
- AI question history
- View FAQs
- View university notices
- Create support tickets
- View ticket status
- Reply to staff messages
- View recent tickets
- Manage profile

### 👨‍💼 Staff Portal

- Staff dashboard
- View student support tickets
- View ticket details
- Assign tickets
- Reply to students
- Update ticket status
- Mark tickets as:
  - Pending
  - In Progress
  - Resolved
  - Closed

### 🛠️ Admin Portal

- Admin dashboard
- Manage students
- Manage staff accounts
- Manage support categories
- Manage FAQs
- Manage notices
- Manage Knowledge Base articles
- View AI activity
- View unanswered AI questions
- View ticket statistics
- Reports and analytics
- User activation/deactivation

---

## 🤖 AI Assistant

The system includes an AI-powered student support assistant.

### AI Workflow

```text
Student Question
       ↓
Question Processing
       ↓
Knowledge Base Search
       ↓
Relevant Information Found?
       ↓
       ├── Yes
       │     ↓
       │  Trusted Knowledge Context
       │     ↓
       │  AI Response Generation
       │     ↓
       │  Answer Displayed to Student
       │
       └── No
             ↓
       Suggest FAQ or Support Ticket



       🧠 AI Features
- Knowledge Base retrieval
- Keyword matching
- Synonym-based matching
- Relevance scoring
- Confidence scoring
- Grounded AI responses
- AI question history
- Unanswered question tracking
- Knowledge source identification
- Support-ticket fallback
🎫 Support Ticket System
Students can create support requests by selecting a category and providing a subject, description, and priority.
Staff members can then:
1. View the ticket
2. Assign the ticket
3. Reply to the student
4. Update its status
5. Resolve or close the ticket
Students and staff can communicate through a two-way ticket conversation system.
🔐 Role-Based Access Control
The system contains three user roles:
Role	Access
Student	AI Assistant, FAQs, Notices, Tickets, Profile
Staff	Dashboard, Support Tickets, Ticket Replies
Admin	Full system management and analytics


Laravel middleware is used to prevent users from accessing unauthorized portals.
🛠️ Technologies Used
Backend
- Laravel 12
- PHP
- Laravel Eloquent ORM
Frontend
- Blade Templates
- Tailwind CSS
- JavaScript
- Vite
Database
- MySQL
- phpMyAdmin
AI
- OpenAI API
- Knowledge Base Retrieval
- Keyword and Relevance Matching
Development Tools
- Visual Studio Code
- XAMPP
- Composer
- Node.js
- npm
- Git
- GitHub
🗄️ Main Database Tables
The system uses tables including:
users
categories
tickets
ticket_replies
faqs
notices
knowledge_articles
ai_questions

📊 Reports & Analytics
The Admin Portal provides information such as:
- Number of students
- Number of staff members
- Total support tickets
- Pending tickets
- In-progress tickets
- Resolved tickets
- Closed tickets
- Total AI questions
- AI answers found
- Unanswered AI questions
- Popular support categories
- Recent system activity


▶️ Running the Project Later
After closing everything, use these steps:
1. Open XAMPP
2. Start MySQL
3. Open the project in VS Code
4. Run:
php artisan serve

5. Open another terminal and run:
npm run dev

6. Open:
http://127.0.0.1:8000

📷 Project Screenshots
Student Dashboard
 
AI Assistant
 
Support Tickets
 
Staff Dashboard
 
Admin Dashboard
 
Knowledge Base
 
Reports & Analytics
 
Add the corresponding screenshots inside a folder named screenshots.

📁 Project Structure
ai-student-support/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   │
│   ├── Models/
│   └── Services/
│
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
│   └── views/
│       ├── admin/
│       ├── auth/
│       ├── staff/
│       └── student/
│
├── routes/
│   └── web.php
│
├── tests/
├── .env.example
├── artisan
├── composer.json
├── package.json
└── README.md

🔒 Security Features
- Authentication
- Password hashing
- CSRF protection
- Role-based middleware
- Form validation
- Protected Admin routes
- Protected Staff routes
- Student ticket ownership validation
- Environment-based API key configuration
🎯 Project Purpose
The main purpose of this project is to improve student support by combining traditional support-ticket management with AI-assisted question answering.
It provides students with faster access to information while allowing staff and administrators to manage complex support requests efficiently.
