# 🛠️ LuminaraBali.com - Internal Management System

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![React](https://img.shields.io/badge/React-20232A?style=for-the-badge&logo=react&logoColor=61DAFB)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Midtrans](https://img.shields.io/badge/Midtrans-Payment-blue?style=for-the-badge&logo=credit-card&logoColor=white)

**Internal Backend System for Luminara Photobooth Operations**

</div>

---

## 📖 About

**LuminaraBali.com** is an internal management system used exclusively by **Luminara Photobooth** to handle business operations in Bali, Indonesia.

This system is **NOT a public platform** - it's an internal tool for Luminara staff to manage:
- Photobooth transactions (Midtrans payment gateway integration)
- Event bookings and customer management
- Digital invitation template creation

### What It Does

- 💳 **Payment Processing**: Midtrans integration for QRIS, Virtual Accounts, E-Wallet payments
- 📅 **Booking Management**: Track photobooth event bookings and customer data
- 💌 **Invitation Creator**: Drag-and-drop template editor for digital wedding/event invitations (In Progress)
- 📊 **Transaction History**: Complete audit trail of all payments

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|------------|
| **Backend** | Laravel 12 (PHP 8.2+) |
| **Frontend** | React 18, TypeScript, TailwindCSS v4 |
| **Build Tool** | Vite |
| **State Management** | Zustand + Immer |
| **Drag & Drop** | react-dnd |
| **Database** | MySQL / MariaDB |
| **Payment** | Midtrans Snap API |

---

## 🚀 Installation & Setup

### **1. Clone & Install**
```bash
git clone https://github.com/Andndre/luminarabali.com.git
cd luminarabali.com
composer install
npm install
```

### **2. Environment Configuration**
```bash
cp .env.example .env
php artisan key:generate
```

Configure your `.env`:
```env
# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=luminara

# Midtrans Payment
MIDTRANS_MERCHANT_ID=your_merchant_id
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_IS_PRODUCTION=false
```

### **3. Database Setup**
```bash
php artisan migrate
php artisan db:seed
```

### **4. Build Assets**
```bash
npm run build
```

### **5. Run Development Server**
```bash
# Backend
php artisan serve

# Frontend (Vite dev server)
npm run dev
```

---

## 🎯 Project Status

| Feature | Status |
|---------|--------|
| Payment Processing | ✅ Complete |
| Midtrans Integration | ✅ Complete |
| Transaction Sync | ✅ Complete |
| Booking Management | ✅ Complete |
| Customer Management | ✅ Complete |
| **Invitation Creator** | 🚧 **In Progress** |
| Gallery Management | 📝 Planned |

---

## 🔌 API Endpoints

### Payment & Transactions
| Method | Endpoint | Description |
|--------|----------|-------------|
| `POST` | `/api/transaction` | Create new transaction |
| `GET` | `/api/transaction/{orderId}` | Check transaction status |
| `POST` | `/api/transaction/{orderId}/sync` | Force sync with Midtrans |

---

## 📄 License

**INTERNAL USE ONLY** - Proprietary software for Luminara Photobooth business operations.

---

## 👥 Team

- **Developer**: [Andndre](https://github.com/Andndre)
- **Collaborator**: [GusYudhi](https://github.com/GusYudhi)
- **Company**: Luminara Photobooth Bali
