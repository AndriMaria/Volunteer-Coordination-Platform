# Volunteer Coordination Platform

## About
A web platform for coordinating volunteers during natural disasters, developed collaboratively with 2 teammates as part of our Web Programming course in university. The platform supports 3 types of users — Admin, Rescuer and Citizen — each with their own interface and functionality.

## 🛠️ Technologies
![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat&logo=javascript&logoColor=black)
![HTML](https://img.shields.io/badge/HTML%2FCSS-E34F26?style=flat&logo=html5&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=flat&logo=mysql&logoColor=white)
- **XAMPP** & **phpMyAdmin**
- **Leaflet.js** — Interactive maps
- **Chart.js** — Statistics charts
- **Bootstrap 5** — UI styling
- **jQuery & AJAX** — Dynamic data loading
- **PhpStorm** — IDE

## 👥 User Roles

### 🔑 Admin
- Login/Logout with session management
- Manage warehouse: add, edit and remove items and categories
- Upload items and categories from a JSON file
- View interactive map with markers for requests, offers and vehicles
- View warehouse inventory filtered by category
- View bar charts for new and completed requests and offers
- Create rescuer accounts
- Create announcements for citizens

### 🚒 Rescuer
- Login/Logout with session management
- View interactive map with draggable vehicle marker
- Load items from base warehouse (only when within 100 meters of base)
- Unload items back to base warehouse
- View current vehicle inventory in a table
- Distance calculated using Haversine formula

### 👤 Citizen
- Register with name, last name, phone number, username and password
- Login/Logout with session management
- Submit requests for items by category with people count
- View list of current and past requests with status and dates
- View announcements from admin
- Submit offers for items from announcements
- Cancel pending offers
- View list of current and past offers with status and dates

## 📁 File Structure

| File | Description |
|---|---|
| `index.php` | Login page for all 3 user types |
| `register.php` | Citizen registration |
| `connect.php` | Database connection (not included) |
| `validate_admin/civilian/rescuer.php` | Login validation per user type |
| `exit.php` | Logout and session cleanup |
| `check_session.php` | Session validation via AJAX |
| `view_map_admin/civilian/rescuer.php` | Map views per user type using Leaflet.js |
| `create_announcement.php` | Create announcements with items |
| `fetch_announcement_items.php` | Fetch announcements and their items |
| `new_request.php` | Submit a new citizen request |
| `fetch_requests.php` | Fetch citizen requests |
| `submit_offer.php` | Submit a citizen offer |
| `get_user_offer_and_cancel.php` | View and cancel offers |
| `get_inventory.php` | Fetch warehouse inventory filtered by category |
| `get_items.php` | Fetch items by category |
| `get_categories.php` | Fetch all categories |
| `manage_categories.php` | Add or update categories |
| `manage_items.php` | Add or update items |
| `remove_item.php` | Delete an item |
| `upload_json.php` | Upload items and categories from JSON |
| `load_items.php` | Rescuer loads items to vehicle |
| `unload_items.php` | Rescuer unloads items to base |
| `get_rescuer_items.php` | Fetch rescuer vehicle inventory |
| `create_rescue_account.php` | Admin creates rescuer account |
| `request_get_chart.php/js` | Bar chart for requests statistics |
| `offers_request_get_chart.php/js` | Bar chart for offers statistics |
| `inventory.js` | Dynamic inventory table with category filter |
| `warehouse.js` | Warehouse management with AJAX |
| `create_request.js` | Dynamic item/category selection for requests |
| `fetch_requests.js` | Fetch and display citizen requests |
| `load_items.js` | Load/unload items with distance check |
| `anadyomeno_para8yro.js` | Modal popup for item selection |

## 📖 The Process
We started by designing the database and setting up the three login flows for Admin, Rescuer and Citizen. Then we built each user's interface separately. The map functionality was implemented using Leaflet.js with draggable markers. The rescuer's load/unload system uses the Haversine formula to calculate the distance from the base. All data is loaded dynamically using AJAX without page refreshes. Finally we added statistics charts using Chart.js.

## 🎓 What I Learned
- **PHP & MySQL** — Server-side development with prepared statements
- **Session Management** — Login/logout and session validation
- **AJAX** — Loading and submitting data dynamically
- **Leaflet.js** — Building interactive maps with custom markers
- **Chart.js** — Visualizing data with bar charts
- **Geolocation** — Calculating distances with the Haversine formula
- **Bootstrap** — Responsive UI design
- **Team Collaboration** — Working in a team of 3
---
🎓 *University Web Programming project | Team of 3*
