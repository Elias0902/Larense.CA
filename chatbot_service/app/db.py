# app/db.py
import pymysql
from app.config import settings

def get_db_connection():
    return pymysql.connect(
        host=settings.DB_HOST,
        user=settings.DB_USER,
        password=settings.DB_PASSWORD,
        database=settings.DB_NAME,
        port=settings.DB_PORT,
        cursorclass=pymysql.cursors.DictCursor
    )

async def ejecutar_consulta(sql: str, params: tuple = ()):
    """Ejecuta una consulta SQL y retorna los resultados (solo SELECT)."""
    with get_db_connection() as conn:
        with conn.cursor() as cursor:
            cursor.execute(sql, params)
            return cursor.fetchall()