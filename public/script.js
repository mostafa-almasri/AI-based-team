document.addEventListener("DOMContentLoaded", function() {
    const chatWindow = document.getElementById('chatWindow');
    const chatMessageInput = document.getElementById('chatMessage');
    const chatThread = document.getElementById('chatThread');

    const currentUserId = 'yourCurrentUserId'; // استبدل هذا بقيمة المستخدم الحالي

    // إضافة حدث عند إرسال النموذج
    chatWindow.onsubmit = function(e) {
        e.preventDefault(); // منع إعادة تحميل الصفحة
        const messageText = chatMessageInput.value; // الحصول على نص الرسالة

        if (!messageText.trim()) return; // تحقق من عدم إرسال رسالة فارغة

        // إضافة الرسالة إلى واجهة المستخدم
        addMessageToChatThread(currentUserId, messageText);
        
        // مسح حقل إدخال الرسالة
        chatMessageInput.value = '';

        // إرسال الرسالة إلى الخادم عبر AJAX
        sendMessageToServer(messageText);
    };

    function addMessageToChatThread(userId, message) {
        const chatNewThread = document.createElement('li');
        chatNewThread.textContent = message; // إضافة النص

        // تحديد نوع الرسالة بناءً على هوية المستخدم
        if (userId === currentUserId) {
            chatNewThread.className = 'sent'; // رسالة مرسلة
        } else {
            chatNewThread.className = 'received'; // رسالة مستلمة
        }

        chatThread.appendChild(chatNewThread); // إضافة الرسالة إلى القائمة
        chatThread.scrollTop = chatThread.scrollHeight; // التمرير لأسفل
    }

    function sendMessageToServer(message) {
        fetch('/chat/store-message', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ 
                receiver_id: receiverId,
                message: message 
            })
        })
        .then(response => {
            if (!response.ok) {
                console.error("Error saving message", response);
                return response.text().then(text => { console.error(text); }); // ستحصل على محتوى الاستجابة كـ نص
            }
            return response.json(); 
        })
        .then(data => {
            console.log("Message saved successfully:", data);
        })
        .catch(error => {
            console.error("Error:", error);
        });
    }
});
