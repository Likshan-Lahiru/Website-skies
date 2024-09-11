const express = require("express");
const mysql = require("mysql2");
const bodyParser = require("body-parser");
const cors = require("cors");
const nodemailer = require("nodemailer");

const app = express();
app.use(cors());
app.use(bodyParser.json());

const db = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "Ijse@1234",
    database: "skies",
});

db.connect((err) => {
    if (err) {
        console.error("Error connecting to the database:", err);
        return;
    }
    console.log("Connected to the MySQL database.");
});


const transporter = nodemailer.createTransport({
    service: "gmail",
    auth: {
        user: "lahiru212001@gmail.com",
        pass: "wfqm qbdm fxrc npkq"
    },
});

const sendWelcomeEmail = (toEmail) => {
    const mailOptions = {
        from: "your-email@gmail.com",
        to: toEmail,
        subject: "Welcome to SKIES Store!",
        text: `Welcome to SKIES store!

1000+ products are available in our online store with over 2 years of trusted commitment to delivering good products as you wish. For more details, contact our customer support.

Thank you for joining with our store!`,
    };

    transporter.sendMail(mailOptions, (error, info) => {
        if (error) {
            console.error("Error sending email:", error);
        } else {
            console.log("Email sent: " + info.response);
        }
    });
};

app.post("/subscribe", (req, res) => {
    const { email } = req.body;

    if (!email) {
        return res.status(400).send("Email is required");
    }

    const query = "INSERT INTO promotions (userEmail) VALUES (?)";

    db.query(query, [email], (err, result) => {
        if (err) {
            console.error("Error inserting email:", err);
            return res.status(500).send("Failed to subscribe.");
        }

        // Send Welcome Email
        sendWelcomeEmail(email);

        res.status(200).send("Subscription successful.");
    });
});

const PORT = 3000;
app.listen(PORT, () => {
    console.log(`Server running on http://localhost:${PORT}`);
});
