# BRT Management System

## Overview

This project is a **BRT (Blume Reserve Ticket) Management System** developed using **Laravel** on the backend and **Vue.js** on the frontend. The system provides real-time updates using **Ably** and **Pusher** for broadcasting events, allowing administrators to monitor and manage BRT statistics in real-time.

## Features

- **User Authentication**: Secure user registration and login system using Laravel's built-in authentication.
- **BRT Management**: Users can create, update, and delete BRTs. Each BRT has unique attributes such as reserved amount and status (active or expired).
- **Real-Time Updates**: Real-time updates using **Ably** and **Laravel Echo** with **Pusher** to broadcast `BRTUpdated` events.
- **Admin Dashboard**: Provides an overview of BRT statistics, including:
  - Total number of BRTs (created, active, expired).
  - Total reserved amount of Blume Coins.
  - Analytics trends for BRTs created per day, week, and month.
- **Event Broadcasting**: The system uses **Ably** for real-time communication between the Laravel backend and Vue.js frontend.
  
## Technologies Used

- **Laravel**: Backend framework to handle authentication, API requests, and event broadcasting.
- **Vue.js**: Frontend framework for reactive UI and real-time updates.
- **Ably**: WebSocket communication for broadcasting real-time events.
- **Pusher**: Used with Laravel Echo to enable real-time broadcasting.
- **Laravel Echo**: Simplifies subscribing to real-time events on the frontend using WebSockets.
- **SQLite**: Simple database setup for local development.

## Installation

### Prerequisites

- PHP >= 8.0
- Composer
- Node.js and NPM
- Ably account (for WebSocket communication)
- Pusher account (if needed for WebSocket communication)

### Step-by-Step Setup

1. **Clone the repository**:

   ```bash
   git clone https://github.com/Arshadiqball/-Blume-Reserve-Ticket-.git
   cd brt-management

2. **Install backend dependencies**:

composer install
npm install
cp .env.example .env

3. Make sure to set the following keys in your .env file:
    APP_NAME=BRT Management System
    APP_URL=http://localhost

    BROADCAST_DRIVER=ably
    QUEUE_CONNECTION=sync

    ABLY_KEY=your-ably-api-key

    PUSHER_APP_ID=your-pusher-app-id
    PUSHER_APP_KEY=your-pusher-app-key
    PUSHER_APP_SECRET=your-pusher-app-secret
    PUSHER_APP_CLUSTER=mt1  # or any other region

4. php artisan migrate
5. npm run dev
6. php artisan queue:work
