<?php
/**
 * Natys Asistente - Asistente virtual del sistema Larense C.A
 * Widget flotante en la esquina inferior derecha
 * Caracteristicas: Proactiva, conocimiento total del sistema, filtro de seguridad
 */
?>

<!-- Chatbot Widget Container -->
<div id="natys-asistente" class="chatbot-widget">
    <!-- Botón flotante -->
    <div class="chatbot-toggle" id="chatbotToggle" onclick="toggleChatbot()">
        <div class="chatbot-avatar">
            <i class="fas fa-robot"></i>
            <span class="chatbot-status online"></span>
        </div>
        <div class="chatbot-label">Natys</div>
    </div>

    <!-- Ventana del chat -->
    <div class="chatbot-window" id="chatbotWindow">
        <!-- Header -->
        <div class="chatbot-header">
            <div class="chatbot-header-info">
                <div class="chatbot-avatar-small">
                    <i class="fas fa-robot"></i>
                    <span class="chatbot-status online"></span>
                </div>
                <div class="chatbot-title">
                    <h6>Natys Asistente</h6>
                    <small>Tu ayuda inteligente</small>
                </div>
            </div>
            <div class="chatbot-actions">
                <button class="btn-minimize" onclick="minimizeChatbot()">
                    <i class="fas fa-minus"></i>
                </button>
                <button class="btn-close" onclick="closeChatbot()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Área de mensajes -->
        <div class="chatbot-messages" id="chatbotMessages">
            <div class="message bot-message">
                <div class="message-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="message-content">
                    <p>¡Hola! Soy <b>Natys Asistente</b> 🤖</p>
                    <p>Conozco todo el sistema de Larense C.A y estoy aquí para ayudarte.</p>
                    <p><b>Puedo informarte sobre:</b></p>
                    <ul>
                        <li>📦 <b>Productos:</b> Galletas disponibles y agotadas</li>
                        <li>📊 <b>Inventario:</b> Stock en tiempo real</li>
                        <li>🛒 <b>Ventas:</b> Pedidos hoy, semana, mes</li>
                        <li>👥 <b>Clientes:</b> Total por categoria</li>
                        <li>� <b>Precios:</b> Consulta cualquier producto</li>
                        <li>📈 <b>Estadisticas:</b> Lo mas vendido, tendencias</li>
                    </ul>
                    <p><i>Preguntame lo que necesites. Mi lenguaje es siempre respetuoso y profesional.</i></p>
                    <p>¿Que te gustaria saber? 😊</p>
                </div>
                <span class="message-time"><?php echo date('H:i'); ?></span>
            </div>
        </div>

        <!-- Sugerencias rápidas - Natys es proactiva -->
        <div class="chatbot-suggestions" id="chatbotSuggestions">
            <button class="suggestion-chip" onclick="sendSuggestion('Dime el estado actual del sistema')">
                📊 Estado del sistema
            </button>
            <button class="suggestion-chip" onclick="sendSuggestion('Que productos tenemos disponibles')">
                📦 Productos disponibles
            </button>
            <button class="suggestion-chip" onclick="sendSuggestion('Cuales son las ventas de hoy')">
                � Ventas hoy
            </button>
            <button class="suggestion-chip" onclick="sendSuggestion('Que esta agotado o en stock bajo')">
                ⚠️ Alertas de stock
            </button>
            <button class="suggestion-chip" onclick="sendSuggestion('Cuantos clientes tenemos')">
                👥 Total clientes
            </button>
            <button class="suggestion-chip" onclick="sendSuggestion('Cual es la galleta mas vendida')">
                🏆 Mas vendido
            </button>
        </div>

        <!-- Input area -->
        <div class="chatbot-input-area">
            <div class="chatbot-input-wrapper">
                <input 
                    type="text" 
                    id="chatbotInput" 
                    class="chatbot-input" 
                    placeholder="Escribe tu consulta..."
                    onkeypress="handleKeyPress(event)"
                    autocomplete="off"
                >
                <button class="btn-emoji" onclick="toggleEmojiPicker()">
                    <i class="far fa-smile"></i>
                </button>
            </div>
            <button class="btn-send" onclick="sendMessage()" id="btnSend">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>

        <!-- Indicador de typing -->
        <div class="chatbot-typing" id="chatbotTyping" style="display: none;">
            <div class="typing-indicator">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <small>Natys esta escribiendo...</small>
        </div>
    </div>
</div>

<!-- Emoji Picker (simple) -->
<div class="emoji-picker" id="emojiPicker" style="display: none;">
    <div class="emoji-grid">
        <span onclick="addEmoji('👋')">👋</span>
        <span onclick="addEmoji('👍')">👍</span>
        <span onclick="addEmoji('❤️')">❤️</span>
        <span onclick="addEmoji('😊')">😊</span>
        <span onclick="addEmoji('🎉')">🎉</span>
        <span onclick="addEmoji('🔥')">🔥</span>
        <span onclick="addEmoji('👏')">👏</span>
        <span onclick="addEmoji('😎')">😎</span>
        <span onclick="addEmoji('🤔')">🤔</span>
        <span onclick="addEmoji('👌')">👌</span>
        <span onclick="addEmoji('✅')">✅</span>
        <span onclick="addEmoji('📦')">📦</span>
    </div>
</div>

<style>
/* === NATYS ASISTENTE STYLES === */

.chatbot-widget {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
    font-family: inherit;
}

/* Botón flotante */
.chatbot-toggle {
    background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%);
    border-radius: 50px;
    padding: 12px 20px 12px 12px;
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    box-shadow: 0 4px 20px rgba(204, 29, 29, 0.4);
    transition: all 0.3s ease;
    border: none;
    color: white;
}

.chatbot-toggle:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 25px rgba(204, 29, 29, 0.5);
}

.chatbot-avatar {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.chatbot-avatar i {
    font-size: 18px;
    color: white;
}

.chatbot-status {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: 2px solid #cc1d1d;
}

.chatbot-status.online {
    background: #28a745;
    animation: pulse-status 2s infinite;
}

@keyframes pulse-status {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}

.chatbot-label {
    font-weight: 600;
    font-size: 14px;
}

/* Ventana del chat */
.chatbot-window {
    position: absolute;
    bottom: 70px;
    right: 0;
    width: 380px;
    height: 550px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    display: none;
    flex-direction: column;
    overflow: hidden;
    border: 1px solid #e9ecef;
}

.chatbot-window.active {
    display: flex;
    animation: slideUp 0.3s ease;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Header */
.chatbot-header {
    background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%);
    padding: 15px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: white;
}

.chatbot-header-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.chatbot-avatar-small {
    width: 36px;
    height: 36px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.chatbot-avatar-small i {
    font-size: 16px;
}

.chatbot-title h6 {
    margin: 0;
    font-size: 14px;
    font-weight: 600;
}

.chatbot-title small {
    opacity: 0.8;
    font-size: 11px;
}

.chatbot-actions {
    display: flex;
    gap: 8px;
}

.chatbot-actions button {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.chatbot-actions button:hover {
    background: rgba(255, 255, 255, 0.3);
}

/* Área de mensajes */
.chatbot-messages {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    background: #f8f9fa;
}

.chatbot-messages::-webkit-scrollbar {
    width: 6px;
}

.chatbot-messages::-webkit-scrollbar-track {
    background: transparent;
}

.chatbot-messages::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 3px;
}

.message {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.bot-message {
    align-items: flex-start;
}

.user-message {
    align-items: flex-end;
    flex-direction: row-reverse;
}

.message-avatar {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.message-avatar i {
    font-size: 14px;
    color: white;
}

.user-message .message-avatar {
    background: #6c757d;
}

.message-content {
    max-width: 75%;
    padding: 12px 16px;
    border-radius: 18px;
    font-size: 13px;
    line-height: 1.5;
}

.bot-message .message-content {
    background: white;
    color: #333;
    border-bottom-left-radius: 4px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.bot-message .message-content ul {
    margin: 8px 0;
    padding-left: 20px;
}

.bot-message .message-content li {
    margin-bottom: 4px;
}

.user-message .message-content {
    background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%);
    color: white;
    border-bottom-right-radius: 4px;
}

.message-time {
    font-size: 10px;
    color: #999;
    margin-top: 4px;
}

/* Sugerencias */
.chatbot-suggestions {
    padding: 10px 15px;
    background: white;
    border-top: 1px solid #e9ecef;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    max-height: 80px;
    overflow-y: auto;
}

.suggestion-chip {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #cc1d1d;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.suggestion-chip:hover {
    background: #cc1d1d;
    color: white;
    border-color: #cc1d1d;
}

/* Input area */
.chatbot-input-area {
    padding: 15px;
    background: white;
    border-top: 1px solid #e9ecef;
    display: flex;
    gap: 10px;
    align-items: center;
}

.chatbot-input-wrapper {
    flex: 1;
    position: relative;
}

.chatbot-input {
    width: 100%;
    padding: 12px 40px 12px 15px;
    border: 1px solid #e9ecef;
    border-radius: 25px;
    font-size: 13px;
    outline: none;
    transition: all 0.2s ease;
}

.chatbot-input:focus {
    border-color: #cc1d1d;
    box-shadow: 0 0 0 3px rgba(204, 29, 29, 0.1);
}

.btn-emoji {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #999;
    cursor: pointer;
    padding: 8px;
    transition: color 0.2s ease;
}

.btn-emoji:hover {
    color: #cc1d1d;
}

.btn-send {
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%);
    border: none;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.btn-send:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(204, 29, 29, 0.3);
}

.btn-send:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Typing indicator */
.chatbot-typing {
    padding: 10px 20px;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    gap: 10px;
}

.typing-indicator {
    display: flex;
    gap: 4px;
}

.typing-indicator span {
    width: 8px;
    height: 8px;
    background: #cc1d1d;
    border-radius: 50%;
    animation: typing 1.4s infinite ease-in-out both;
}

.typing-indicator span:nth-child(1) {
    animation-delay: -0.32s;
}

.typing-indicator span:nth-child(2) {
    animation-delay: -0.16s;
}

@keyframes typing {
    0%, 80%, 100% { transform: scale(0.6); opacity: 0.5; }
    40% { transform: scale(1); opacity: 1; }
}

/* Emoji picker */
.emoji-picker {
    position: absolute;
    bottom: 80px;
    right: 20px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    padding: 15px;
    z-index: 10000;
}

.emoji-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 8px;
}

.emoji-grid span {
    font-size: 20px;
    cursor: pointer;
    padding: 5px;
    border-radius: 8px;
    transition: background 0.2s ease;
    text-align: center;
}

.emoji-grid span:hover {
    background: #f0f0f0;
}

/* Responsive */
@media (max-width: 480px) {
    .chatbot-window {
        width: calc(100vw - 40px);
        height: 60vh;
        right: 10px;
        bottom: 80px;
    }
    
    .chatbot-widget {
        right: 10px;
        bottom: 10px;
    }
}

/* Mensaje de error */
.message-error {
    background: #fee2e2 !important;
    color: #dc2626 !important;
    border: 1px solid #fecaca;
}

/* Mensaje de carga */
.message-loading {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #666;
}

/* Tablas en mensajes */
.message-content table {
    width: 100%;
    border-collapse: collapse;
    margin: 10px 0;
    font-size: 12px;
}

.message-content th,
.message-content td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #e9ecef;
}

.message-content th {
    background: #f8f9fa;
    font-weight: 600;
}
</style>

<script>
// === NATYS ASISTENTE JAVASCRIPT ===

let chatbotOpen = false;
let isTyping = false;

// Alternar visibilidad del chatbot
function toggleChatbot() {
    const window_el = document.getElementById('chatbotWindow');
    chatbotOpen = !chatbotOpen;
    
    if (chatbotOpen) {
        window_el.classList.add('active');
        document.getElementById('chatbotInput').focus();
    } else {
        window_el.classList.remove('active');
    }
}

// Minimizar chatbot
function minimizeChatbot() {
    const window_el = document.getElementById('chatbotWindow');
    window_el.classList.remove('active');
    chatbotOpen = false;
}

// Cerrar chatbot
function closeChatbot() {
    const window_el = document.getElementById('chatbotWindow');
    window_el.classList.remove('active');
    chatbotOpen = false;
}

// Enviar mensaje desde sugerencia
function sendSuggestion(text) {
    document.getElementById('chatbotInput').value = text;
    sendMessage();
}

// Manejar tecla Enter
function handleKeyPress(event) {
    if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault();
        sendMessage();
    }
}

// Enviar mensaje
async function sendMessage() {
    const input = document.getElementById('chatbotInput');
    const message = input.value.trim();
    
    if (!message || isTyping) return;
    
    // Agregar mensaje del usuario
    addUserMessage(message);
    input.value = '';
    
    // Mostrar typing
    showTyping();
    
    try {
        // Enviar al backend
        const response = await fetch('api/chatbot.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                message: message,
                session_id: getSessionId()
            })
        });
        
        const data = await response.json();
        
        // Ocultar typing y mostrar respuesta
        hideTyping();
        
        if (data.success) {
            addBotMessage(data.response);
        } else {
            addBotMessage('Lo siento, hubo un error al procesar tu consulta. ¿Podrías intentarlo de nuevo? 😅', true);
        }
        
    } catch (error) {
        hideTyping();
        addBotMessage('Lo siento, no pude conectarme con el servidor. Verifica tu conexión. 🔌', true);
        console.error('Chatbot error:', error);
    }
}

// Agregar mensaje del usuario
function addUserMessage(text) {
    const messagesContainer = document.getElementById('chatbotMessages');
    const time = new Date().toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
    
    const messageHTML = `
        <div class="message user-message">
            <div class="message-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="message-content">
                <p>${escapeHtml(text)}</p>
            </div>
            <span class="message-time">${time}</span>
        </div>
    `;
    
    messagesContainer.insertAdjacentHTML('beforeend', messageHTML);
    scrollToBottom();
}

// Agregar mensaje del bot
function addBotMessage(text, isError = false) {
    const messagesContainer = document.getElementById('chatbotMessages');
    const time = new Date().toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
    
    const errorClass = isError ? 'message-error' : '';
    
    const messageHTML = `
        <div class="message bot-message">
            <div class="message-avatar">
                <i class="fas fa-robot"></i>
            </div>
            <div class="message-content ${errorClass}">
                ${text}
            </div>
            <span class="message-time">${time}</span>
        </div>
    `;
    
    messagesContainer.insertAdjacentHTML('beforeend', messageHTML);
    scrollToBottom();
}

// Mostrar indicador de typing
function showTyping() {
    isTyping = true;
    document.getElementById('chatbotTyping').style.display = 'flex';
    document.getElementById('btnSend').disabled = true;
    scrollToBottom();
}

// Ocultar indicador de typing
function hideTyping() {
    isTyping = false;
    document.getElementById('chatbotTyping').style.display = 'none';
    document.getElementById('btnSend').disabled = false;
}

// Scroll al final
function scrollToBottom() {
    const messagesContainer = document.getElementById('chatbotMessages');
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

// Alternar emoji picker
function toggleEmojiPicker() {
    const picker = document.getElementById('emojiPicker');
    picker.style.display = picker.style.display === 'none' ? 'block' : 'none';
}

// Agregar emoji al input
function addEmoji(emoji) {
    const input = document.getElementById('chatbotInput');
    input.value += emoji;
    input.focus();
    document.getElementById('emojiPicker').style.display = 'none';
}

// Escape HTML para seguridad
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Obtener o crear ID de sesión
function getSessionId() {
    let sessionId = localStorage.getItem('chatbot_session_id');
    if (!sessionId) {
        sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        localStorage.setItem('chatbot_session_id', sessionId);
    }
    return sessionId;
}

// Cerrar emoji picker al hacer clic fuera
document.addEventListener('click', function(e) {
    const picker = document.getElementById('emojiPicker');
    const btnEmoji = document.querySelector('.btn-emoji');
    
    if (picker.style.display === 'block' && 
        !picker.contains(e.target) && 
        !btnEmoji.contains(e.target)) {
        picker.style.display = 'none';
    }
});

// Abrir chatbot automáticamente después de 5 segundos (opcional)
// setTimeout(() => {
//     if (!chatbotOpen) {
//         toggleChatbot();
//     }
// }, 5000);
</script>
