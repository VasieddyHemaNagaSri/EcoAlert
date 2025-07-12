# 🌿✨ **EcoAlert** — Intelligent Temperature Monitoring for Plant Health

**EcoAlert** is a smart web application designed to help horticulturists, gardeners, and nursery owners protect their plants by monitoring real-time weather data and sending instant alerts when temperatures become dangerous.

---

## ✅ **Features**

- 🌱 User registration & secure login
- 📍 Add up to 3 plants with location details
- 🌡️ Fetches real-time weather data
- ⚠️ Instant notifications if weather temperature exceeds safe plant thresholds
- 🔄 Update plant details or monitored location anytime
- 📱 Fully responsive design (works on laptops, tablets & mobiles)

---

## 🛠 **Technologies Used**

- **Frontend:** HTML, CSS, JavaScript (with Swiper slider)
- **Backend:** PHP
- **Database:** MySQL
- **API:** Weather API
- **Notifications:** Email or web push (depending on setup)

---

## 📦 **Project Structure**

```plaintext
EcoAlert/
├── index.html              # Home page
├── login.html              # Login / Sign-in page
├── set_notification.php    # Add/update plant notifications
├── css/
│   └── style.css           # Stylesheet
├── js/
│   └── script.js           # JavaScript logic
├── php/
│   ├── register.php        # Handle user registration
│   ├── login.php           # Handle login
│   ├── update_plants.php   # Update plant data
│   └── notify.php          # Notification logic
└── README.md

```
---
⚙️ How It Works
User signs up and logs in.

Adds up to three plants and a location.

The system fetches current weather temperature for the location.

If temperature exceeds the required temperature for any plant, a notification is triggered.

Users can log in later to update or add new plants.
---
🌍 Target Users
Nurseries

Gardeners & home garden enthusiasts

Horticulturists
---
🎯 Purpose
EcoAlert aims to:

Enhance climate resilience in horticulture 🌱

Help users act quickly to protect plants

Promote sustainable, technology-driven gardening practices
---
✏️ Future Enhancements
Replace email alerts with real-time push notifications

Dashboard with temperature and plant health analytics

Support more than 3 plants per user

Optional integration with IoT sensors

AI-powered plant care recommendations
