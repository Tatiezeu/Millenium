# Millenium Management System Summary

## 1. Actors and Use Cases

Here are the primary actors and their specific interactions with the platform:

### **Client (Customer)**
* **Use Cases:**
  * **Authentication:** Register, log in, verify account, and enable 2FA.
  * **Profile Management:** Update personal details, bio, and profile picture.
  * **Orders:** Browse menu services, place dine-in or delivery orders, and track order status.
  * **Reservations:** Check table availability and book a reservation.
  * **Information:**  browse the restaurant gallery.

### **Waiter**
* **Use Cases:**
  * **Order Management:** Take orders directly from guests and submit them to the kitchen.
  * **Table Management:** Monitor table occupancy, assign guests to tables, and update table statuses.
  * **Service:** Serve food/drinks and update order status to 'served'.

### **Cooks**
* **Use Cases:**
  * **Kitchen Queue:** View incoming 'pending' orders.
  * **Preparation:** Mark orders as 'preparing' and then 'ready' when the food is cooked, notifying the Waiter or Delivery Agent.

### **Delivery Agent**
* **Use Cases:**
  * **Delivery Tracking:** View orders marked for delivery.
  * **Status Updates:** Update order statuses to 'out for delivery' and eventually 'delivered' upon successful drop-off.

### **Cashier**
* **Use Cases:**
  * **Sales & Payments:** Process payments for completed orders and record them as Sales.
  * **Receipts:** Generate and print receipts for clients.

### **Restaurant Manager**
* **Use Cases:**
  * **Operational Oversight:** Monitor active orders, reservations, and table turnover.
  * **Staff Management:** Oversee Waiters, Cooks, and Delivery Agents.
  * **Reports & Analytics:** Generate, view, and print daily sales and activity reports to monitor restaurant performance.
  * **Dispute Resolution:** Handle escalated customer complaints or order issues.

### **Admin**
* **Use Cases:**
  * **System Control:** Manage all user and staff accounts (role assignments).
  * **Menu & Assets:** Add, edit, or remove `Services` (meals/drinks), `Events`, and `Gallery` items.
  * **Configuration:** Define new tables, categories, pricing, and update global application settings.

---

## 2. Entities, Fields, and Relationships

Below is the database entity architecture based on the Eloquent Models (`MongoDB\Laravel\Eloquent\Model`):

### **User**
* **Description:** Represents an authenticated user in the system (Client, Staff, Cashier, or Admin).
* **Fields:** `name`, `email`, `password`, `phone`, `role`, `profile_picture`, `status`, `is_2fa_enabled`, `two_factor_code`, `verification_code`
* **Relationships:**
  * `hasOne Profile` (A user has one extended profile)
  * `hasMany Order` (A user places many orders)
  * `hasMany Reservation` (A user makes many reservations)
  * `hasMany Sale` (As a cashier processing sales)
  * `hasMany Report` (As an admin generating reports)
  * `hasMany Notification` (As sender or receiver)

### **Profile**
* **Description:** Extended information about a user.
* **Fields:** `user_id`, `first_name`, `last_name`, `bio`, `address`, `city`, `country`
* **Relationships:**
  * `belongsTo User` (Linked to a single user account)

### **Table (`restaurant_tables`)**
* **Description:** Represents a physical table in the restaurant.
* **Fields:** `title`, `seats`, `category` (Standard, Medium, First Class), `price`, `area`, `status`
* **Relationships:**
  * `hasMany Order` (Orders linked to a specific table)
  * `hasMany Reservation` (Reservations made for this table)

### **Service (`services`)**
* **Description:** Menu items offered by the restaurant.
* **Fields:** `name`, `type` (meal/drink), `category`, `price`, `description`, `image`
* **Relationships:**
  * *None strictly defined* (Services are likely stored within the `items` JSON array in an `Order`).

### **Order**
* **Description:** A food/drink request placed by a user.
* **Fields:** `user_id`, `table_id`, `items`, `total_price`, `status`, `notes`, `service_type` (served/delivered), `location`, `address`, `preparation_time`
* **Methods:** `getItemsSummaryAttribute()` (Returns a comma-separated preview of items)
* **Relationships:**
  * `belongsTo User` (The client who placed the order)
  * `belongsTo Table` (The table the order is being served to, if applicable)
  * `hasOne Sale` (An order becomes a sale once paid)

### **Sale**
* **Description:** Represents a completed, paid transaction.
* **Fields:** `order_id`, `items`, `amount`, `payment_method`, `cashier_id`
* **Relationships:**
  * `belongsTo Order` (The original order fulfilled)
  * `belongsTo User` (The cashier who processed the payment, via `cashier_id`)

### **Reservation**
* **Description:** A booking made by a client for a table.
* **Fields:** `table_id`, `user_id`, `guest_name`, `guest_count`, `reservation_date`, `reservation_time`, `status`, `notes`
* **Relationships:**
  * `belongsTo User` (The user who booked it)
  * `belongsTo Table` (The table reserved)

### **Notification**
* **Description:** System alerts or direct messages between users.
* **Fields:** `sender_id`, `receiver_id`, `message`, `type`, `is_read`, `attachments`, `parent_id`
* **Relationships:**
  * `belongsTo User` (As the sender)
  * `belongsTo User` (As the receiver)

### **Report**
* **Description:** System-generated metrics and analytics.
* **Fields:** `title`, `type` (sales, inventory, etc.), `data`, `generated_by`, `period_start`, `period_end`
* **Relationships:**
  * `belongsTo User` (The admin/manager who generated it, via `generated_by`)

### **Event**
* **Description:** Occasions or special dates hosted by the restaurant.
* **Fields:** `title`, `description`, `date`, `time`, `location`, `image_path`, `status`
* **Relationships:** *Standalone entity.*

### **Gallery**
* **Description:** Promotional images displayed to the clients.
* **Fields:** `title`, `image_path`, `category`
* **Relationships:** *Standalone entity.*

### **Setting**
* **Description:** Global application configurations.
* **Fields:** `key`, `value`
* **Methods:** `get($key, $default)`, `set($key, $value)`
* **Relationships:** *Standalone entity.*
