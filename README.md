# E-DAQIQ

> A SaaS law firm management platform. Built for Moroccan legal practices — case management, client portal, document vault, billing, and analytics in one system.

[![Status](https://img.shields.io/badge/status-completed-blue?style=flat-square)](https://github.com/DDOSooS)
[![Laravel](https://img.shields.io/badge/Laravel-10-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://mysql.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=flat-square&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![Role](https://img.shields.io/badge/role-team%20lead-0A0A0A?style=flat-square)](https://github.com/DDOSooS)

---

## Overview

E-DAQIQ (*دقيق* — precise) is a multi-tenant SaaS platform designed for law firms. It replaces scattered spreadsheets, paper files, and disconnected billing tools with a single, role-aware system that gives every actor in a firm exactly the access they need.

Built as a complete product: multi-role authentication, full case lifecycle management, a client-facing portal, document storage, invoice generation, and a reporting dashboard — all in one Laravel application.

---

## The Problem

Law firms, particularly in Morocco, manage highly sensitive work across fragmented tools: cases tracked in Excel, documents sent over email, invoices generated manually, and client communication handled informally. This creates compliance risks, billing gaps, and no audit trail.

E-DAQIQ consolidates this into a single platform with role-based access control so that lawyers, admins, and clients each see and do exactly what they're supposed to — nothing more.

---

## Features

### Case & Matter Management
- Create and track cases through their full lifecycle: `Open → Active → Pending → Closed`
- Assign cases to specific lawyers with deadline tracking
- Attach documents, notes, and hearings to each case
- Filter and search across all cases by status, lawyer, client, or date

### Client Portal
- Dedicated client-facing dashboard — clients log in and see only their own cases
- Real-time case status updates visible to clients without lawyer involvement
- Secure document download for case-related files shared by the firm
- Invoice history and payment status

### Document Management
- Upload and organize documents per case
- Version tracking — new uploads don't overwrite previous files
- Access control enforced at the document level by role
- Download history per document for audit purposes

### Billing & Invoicing
- Generate invoices directly from a case record
- Track payment status: `Pending`, `Paid`, `Overdue`
- Invoice PDF generation
- Billing history per client and per case

### User Roles & Permissions

| Role | Access |
|---|---|
| **Super Admin** | Full platform access: manage firms, users, billing, system settings |
| **Firm Admin** | Manage firm users, all cases, documents, invoices within their firm |
| **Lawyer** | Access assigned cases, upload documents, log hearings and notes |
| **Client** | View own cases, download shared documents, view invoices |

### Reporting & Analytics
- Dashboard with key metrics: active cases, revenue, overdue invoices, cases by status
- Per-lawyer performance overview: case load, closed cases, billable hours
- Monthly revenue breakdown with visual charts
- Exportable reports (CSV)

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend framework | [Laravel 10](https://laravel.com) |
| Database | MySQL 8.0 |
| Frontend | Bootstrap 5 · jQuery · Custom CSS |
| Authentication | Laravel Breeze + custom role middleware |
| PDF generation | Laravel DomPDF |
| Charts | Chart.js |
| File storage | Laravel Storage (local / S3-compatible) |

---

## Architecture

```
E-DAQIQ (Laravel MVC)
│
├── Multi-tenancy layer          → Each firm is isolated; data scoped by firm_id
│
├── Auth & roles middleware      → Guards enforce role access on every route
│
├── Modules
│   ├── Cases                   → Full CRUD + status machine + relationships
│   ├── Clients                 → Client profiles + portal access management
│   ├── Documents               → Upload, version, access control
│   ├── Invoices                → Generation, PDF export, payment tracking
│   └── Reports                 → Aggregated queries → Chart.js dashboard
│
├── Client Portal (sub-app)     → Separate route group + layout for clients
│
└── Admin Panel                 → Firm and user management for super admin
```

---

## Database Schema (Core Tables)

```
firms           → id, name, plan, created_at
users           → id, firm_id, role, name, email, password
cases           → id, firm_id, client_id, lawyer_id, title, status, opened_at, closed_at
hearings        → id, case_id, date, notes
documents       → id, case_id, uploaded_by, path, version, created_at
invoices        → id, case_id, client_id, amount, status, due_date, paid_at
invoice_items   → id, invoice_id, description, quantity, unit_price
```

---

## Getting Started

### Requirements

- PHP 8.1+
- Composer
- MySQL 8.0
- Node.js 18+ (for asset compilation)

### Installation

```bash
git clone https://github.com/DDOSooS/e-daqiq
cd e-daqiq

# Install PHP dependencies
composer install

# Install JS dependencies
npm install && npm run build

# Configure environment
cp .env.example .env
php artisan key:generate

# Set up database
# Update DB_* values in .env, then:
php artisan migrate --seed

# Start local server
php artisan serve
```

### Default Credentials (Seeded)

| Role | Email | Password |
|---|---|---|
| Super Admin | superadmin@edaqiq.com | password |
| Firm Admin | admin@lawfirm.com | password |
| Lawyer | lawyer@lawfirm.com | password |
| Client | client@lawfirm.com | password |

---

## Project Context

**Team lead** on a team of 3 developers. Responsibilities included:

- System architecture and database schema design
- Laravel project structure and coding conventions
- Role-based access control implementation
- Case management and billing modules
- Code review and integration

---

## Roadmap

- [ ] Multi-language support (Arabic / French / English)
- [ ] Email notifications for case updates and invoice due dates
- [ ] Cloud file storage (S3)
- [ ] Subscription billing (Stripe / CMI)
- [ ] Mobile-responsive client portal
- [ ] REST API for future mobile app

---

## Author

**Abdessalam Gherghouch** — Team Lead
Student at 1337 · [GitHub](https://github.com/DDOSooS) · [LinkedIn](https://www.linkedin.com/in/abdessalam-gherghouch-51084b23a/) · [Portfolio](https://abdessalam.vercel.app)
