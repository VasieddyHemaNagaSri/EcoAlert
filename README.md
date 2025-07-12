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
