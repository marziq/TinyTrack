<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Baby Health ChatBot</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
	<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
	<style>
		body {
			background: #f5f5f5;
			margin: 0;
			height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		.chat-container {
			background: #fff;
			width: 100%;
			max-width: 600px;
			height: 90vh;
			display: flex;
			flex-direction: column;
			border-radius: 15px 15px 0 0; /* ⬅️ only top rounded */
			box-shadow: 0 4px 20px rgba(0,0,0,0.1);
			overflow: hidden;
		}
		.chat-header {
            background: #4CAF50;
            color: white;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: flex-start; /* ⬅️ align left */
            flex-shrink: 0;
        }
		.chat-header img {
			width: 32px;
			height: 32px;
			border-radius: 50%;
			margin-right: 10px;
		}
		#chatbox {
            flex: 1; /* fill remaining space */
            overflow-y: auto;
            padding: 10px;
            background: #fefefe;
            border-top: 1px solid #ccc;
            border-bottom: none;
        }

        .chat-input {
            background: #fff;
            flex-shrink: 0;
            margin: 0;
            padding: 8px; /* add slight breathing space */
            border-top: 1px solid #ccc; /* separate from chatbox */
        }

        .chat-input .form-control {
            flex: 1;
            min-height: 45px;
            border-radius: 8px 0 0 8px;
            border-right: none;
            text-align: left;          /* ✅ text starts from left */
            text-justify: inter-word;  /* ✅ justify long text */
            padding-left: 10px;        /* small padding for neat look */
        }
        .message {
            display: flex;
            align-items: flex-end; /* avatars align to bottom of bubble */
            margin: 10px 0;
        }

        /* Bot messages on the left */
        .message.bot {
            flex-direction: row;           /* bubble on left */
            justify-content: flex-start;
        }
        .message.bot .avatar {
            margin-right: 8px;
            margin-left: 0;
        }

        /* User messages on the right */
        .message.user {
            flex-direction: row;   /* bubble on right */
            justify-content: flex-end;     /* avatar stays on the right */
            text-align: right;
        }
        .message.user .avatar {
            margin-left: 8px;  /* space between bubble and avatar */
            margin-right: 0;
        }

        .bubble {
            padding: 10px 15px;
            border-radius: 18px;
            max-width: 70%;
            word-wrap: break-word;
        }
        .bot .bubble {
            background: #eaeaea;
            color: #000;
            border-top-left-radius: 0;
        }
        .user .bubble {
            background: #d1ffd6;
            color: #000;
            border-top-right-radius: 0;
        }

        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
        }

        .input-group .btn {
            border-radius: 0 8px 8px 0;
        }
	</style>
</head>
<body>
	<div class="chat-container">
		<!-- Header -->
		<div class="chat-header">
            <img src="{{ asset('img/sage.ico') }}" alt="Sage Avatar">
			<h4 class="m-0">Sage</h4>
		</div>

		<!-- Chat Area -->
		<div id="chatbox"></div>

		<!-- Input -->
		<div class="chat-input">
            <div class="input-group">
                <input type="text" class="form-control" id="userInput" placeholder="Enter your message" />
                <button class="btn btn-success" onclick="sendMessage()">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>
        </div>

	</div>

	<script>
        async function sendMessage() {
            const inputField = document.getElementById("userInput");
            const input = inputField.value.trim();
            if (!input) return;

            const chatbox = document.getElementById("chatbox");

            // User message with avatar
            const userMessage = document.createElement("div");
            userMessage.className = "message user";
            userMessage.innerHTML = `
                <div class="bubble">${input}</div>
                <img src="https://cdn-icons-png.flaticon.com/512/1077/1077012.png" class="avatar" alt="User" />
            `;
            chatbox.appendChild(userMessage);
            chatbox.scrollTop = chatbox.scrollHeight;

            inputField.value = "";

            // Bot typing placeholder
            const botMessage = document.createElement("div");
            botMessage.className = "message bot";
            botMessage.innerHTML = `
                <img src="{{ asset('img/sage.ico') }}" alt="Sage Avatar">
                <div class="bubble">Typing...</div>
            `;
            chatbox.appendChild(botMessage);
            chatbox.scrollTop = chatbox.scrollHeight;

            try {
                const response = await fetch("https://openrouter.ai/api/v1/chat/completions", {
                    method: "POST",
                    headers: {
                        "Authorization": "Bearer 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",
                        "HTTP-Referer": "https://www.TinyTrack.com",
                        "X-Title": "TinyTrack Sage Chatbot",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        model: "meta-llama/llama-3.3-70b-instruct:free",
                        messages: [{ role: "user", content: input }]
                    })
                });

                const data = await response.json();
                console.log("Raw API response:", data);

                //Rate limit Error Handling
                // ✅ First check: did the HTTP request itself fail?
                if (!response.ok) {
                    let errorMessage = "⚠️ Something went wrong.";

                    if (response.status === 429) {
                        errorMessage = "⚠️ Sorry Sage cannot give response because rate limit exceeded. Please wait and try again.";
                    } else if (response.status >= 500) {
                        errorMessage = "⚠️ Server error. Please try again later.";
                    }

                    botMessage.querySelector(".bubble").innerText = errorMessage;
                    return;
                }

                // ✅ Second check: did OpenRouter return an error object?
                if (data.error) {
                    let errorMessage = "⚠️ " + (data.error.message || "Unknown error from AI service.");
                    botMessage.querySelector(".bubble").innerText = errorMessage;
                    return;
                }

                // ✅ Success case
                const markdownText =
                    data.choices?.[0]?.message?.content ||
                    data.choices?.[0]?.content ||
                    "⚠️ No response received.";
                botMessage.querySelector(".bubble").innerHTML = marked.parse(markdownText);

            } catch (error) {
                botMessage.querySelector(".bubble").innerText = "Error: " + error.message;
            }

            chatbox.scrollTop = chatbox.scrollHeight;
        }
    </script>
</body>
</html>
