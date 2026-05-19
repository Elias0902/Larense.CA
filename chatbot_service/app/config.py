# app/config.py

# importa dependencias
import os
from dotenv import load_dotenv

# funcion de carga
load_dotenv()

# clase de settings del microservicio
class Settings:

    # Servidor
    APP_NAME: str = "Chatbot Microservice"
    APP_HOST: str = os.getenv("APP_HOST", "0.0.0.0")
    APP_PORT: int = int(os.getenv("APP_PORT", "5000"))
    DEBUG: bool = os.getenv("DEBUG", "False").lower() == "true"

    # Gemini
    GEMINI_API_KEY: str = os.getenv("GEMINI_API_KEY", "")
    GEMINI_MODEL: str = os.getenv("MODEL_NAME", "gemini-2.0-flash")

    # (Opcional) OpenAI
    OPENAI_API_KEY: str = os.getenv("OPENAI_API_KEY", "")
    OPENAI_MODEL: str = os.getenv("OPENAI_MODEL", "gpt-4o-mini")
    
    # API del sistema PHP
    PHP_API_BASE_URL: str = os.getenv("PHP_API_BASE_URL", "http://localhost:80/api")
    PHP_API_KEY: str = os.getenv("PHP_API_KEY", "")

    # Seguridad
    CHATBOT_API_KEY: str = os.getenv("CHATBOT_API_KEY", "")

    # Base de datos (conexión directa)
    DB_HOST: str = os.getenv("DB_HOST", "localhost")
    DB_USER: str = os.getenv("DB_USER", "root")
    DB_PASSWORD: str = os.getenv("DB_PASSWORD", "")
    DB_NAME: str = os.getenv("DB_NAME", "larence")
    DB_PORT: int = int(os.getenv("DB_PORT", "3306"))

# var global
settings = Settings()