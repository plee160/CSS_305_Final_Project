CSS 305 – Final Project: Car Parts Catalog System
Student: Samuel Boye
Course: CSS 305 – Web Development
Project Type: Full-Stack PHP + MySQL Application
Hosting: Hostinger (Live Deployment)
📌 Project Overview

This project is a full-stack web application demonstrating CRUD operations, authentication, secure data handling, and MySQL database integration.
The system is designed for employees and managers of a car parts store who need to manage, search, and update parts and supplier information.

This application includes:

User authentication (login, logout, role handling)

Catalog of car parts

Supplier management

Add/Edit/Delete parts

Server-side validation

Secure SQL operations using prepared statements

Dashboard with quick summaries

Hostinger deployment

📌 The 5 W’s
Who

Employees, managers, and inventory clerks working at a car parts shop who need fast access to product and stock information.

What

A web-based internal catalog system that allows users to view, add, edit, and remove parts; track suppliers; and maintain accurate inventory data.

When

Used during daily store operations to track stock, update items, and assist customers.

Where

Hosted on Hostinger. Can be accessed on store computers, office desktops, and approved remote devices.

Why

Manual inventory tracking is error-prone. This system streamlines operations, reduces mistakes, improves stock visibility, and supports better restocking and sales decisions.

📌 Project Goals

Implement complete CRUD functionality

Capture and validate user input

Store data securely in a MySQL database

Retrieve and display dynamic data using PHP

Implement authentication and role-based access

Debug and test for security (SQL injection, CSRF)

Deploy a functioning system to Hostinger

Document development progress clearly

📌 Recommended Repository Structure (Best Practice)

This is the optimized layout for a professional, clean PHP project.
(It improves your old structure while keeping all your files.)

/your-project-root
│
├── README.md                  ← Full documentation
├── styles.css                 ← Global stylesheet
├── index.html                 ← Public landing/login page
│
├── /images                    ← UI images, logos, assets
│
├── /designs                   ← Diagrams, mockups, Lucidchart exports
│   ├── database-schema.png
│   └── wireframes/
│
├── /public                    ← Public-facing pages
│   ├── catalog.php
│   ├── suppliers.php
│   ├── users.php
│   ├── part-details.php
│   ├── newUser.html
│   ├── login.php
│   └── logout.php
│
├── /parts                     ← CRUD pages for parts
│   ├── part-create.php
│   ├── part-edit.php
│   └── part-delete.php
│
├── /suppliers
│   ├── supplier-edit.php
│   └── supplier-delete.php
│
├── /account
│   ├── account_edit.php
│   ├── change_password.php
│   └── deleteUser.php
│
├── /backend                   ← All backend PHP logic
│   ├── db.php                 ← Database connection
│   ├── session_check.php
│   ├── csrf.php
│   ├── authenticate.php
│   ├── newUser.php
│   ├── userUpdate.php
│   ├── part-create-handler.php
│   ├── part-edit-handler.php
│   ├── part-delete-handler.php
│   └── supplier-edit-handler.php
│
└── /validators                ← Server-side validation helpers
