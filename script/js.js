document.getElementById("subscribeForm").addEventListener("submit", async function (e) {
    e.preventDefault();
    const email = document.getElementById("user-email").value;

    try {
        const response = await fetch("http://localhost:3000/subscribe", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ email }),
        });

        if (response.ok) {
            alert("Subscription successful!");
        } else {
            alert("Failed to subscribe. Please try again.");
        }
    } catch (error) {
        console.error("Error:", error);
        alert("Error occurred while subscribing.");
    }
});