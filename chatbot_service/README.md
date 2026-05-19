# 🤖 Natys Asistente - Microservicio de IA

Microservicio independiente en Python (FastAPI) que proporciona un asistente virtual inteligente para el sistema de gestión Larense C.A. El asistente responde preguntas sobre pedidos, créditos, productos, proveedores, producción y más, utilizando exclusivamente consultas SQL SELECT a la base de datos.

## ✨ Características

- **🧠 Acceso total a la BD** mediante `ejecutar_sql` (SELECT, JOINs, subconsultas, funciones de agregación).
- **🔐 Seguro**: Solo permite consultas SELECT, nunca modifica datos.
- **📊 Análisis avanzado**: Puede analizar patrones de compra, predecir próximos pedidos, sugerir promociones basadas en historial.
- **🔄 Multi‑proveedor**: Compatible con Gemini, OpenAI, LocalAI, DeepSeek (cambiando variable de entorno).
- **💬 Conversaciones con memoria**: Mantiene el contexto de la conversación por sesión.
- **🚀 Fácil integración**: API REST con autenticación por API Key.

## 📁 Estructura del Proyecto
chatbot_service/
├── app/
│ ├── init.py # Identificador del paquete
│ ├── main.py # Punto de entrada FastAPI
│ ├── config.py # Variables de entorno y settings
│ ├── models.py # Pydantic models (ChatRequest, ChatResponse)
│ ├── tools.py # Única herramienta: ejecutar_sql
│ ├── chat_engine.py # Lógica del chatbot (system prompt, llamada a IA)
│ └── routes.py # Endpoints (/api/v1/chat, /health)
├── requirements.txt # Dependencias Python
├── .env # Configuración (API keys, BD, etc.)
└── README.md


## 🚀 Instalación y Configuración

### 1. Requisitos previos

- Python 3.11 o superior
- MySQL (el mismo que usa tu sistema PHP)
- (Opcional) Entorno virtual de Python

### 2. Clonar / ubicarse en la carpeta del microservicio

```bash
cd C:\xampp\htdocs\larence\chatbot_service

python -m venv venv
# Windows:
venv\Scripts\activate
# Linux/Mac:
source venv/bin/activate
# instalar dependencias
pip install -r requirements.txt
#ejecutar microservicio
uvicorn app.main:app --reload --port 5000

🔌 Endpoints
Método	Endpoint	Descripción	Autenticación
POST	/api/v1/chat	Envía un mensaje al chatbot	Header X-API-Key
GET	/api/v1/health	Verifica estado y configuración	No requiere

⚠️ Solución de problemas
Problema	Posible solución
429 RESOURCE_EXHAUSTED	Has agotado la cuota gratuita de Gemini. Espera o cambia a otro proveedor (OpenAI, DeepSeek, LocalAI).
Error de conexión a MySQL	Verifica credenciales en .env y que MySQL esté corriendo.
No se encuentra el módulo 'google'	Ejecuta pip install google-generativeai.
API Key inválida	Asegúrate de enviar el header X-API-Key con el mismo valor que en .env.
📜 Licencia
Desarrollado para Larense C.A. – Uso interno.