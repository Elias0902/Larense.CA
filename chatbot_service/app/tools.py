# app/tools.py
import json
import pymysql
from app.config import settings

async def ejecutar_sql(sql: str) -> str:
    """Ejecuta solo SELECT y retorna resultados formateados."""
    sql_upper = sql.strip().upper()
    if not sql_upper.startswith("SELECT"):
        return "❌ Solo se permiten consultas SELECT."
    try:
        connection = pymysql.connect(
            host=settings.DB_HOST,
            user=settings.DB_USER,
            password=settings.DB_PASSWORD,
            database=settings.DB_NAME,
            port=settings.DB_PORT,
            cursorclass=pymysql.cursors.DictCursor
        )
        with connection.cursor() as cursor:
            cursor.execute(sql)
            rows = cursor.fetchall()
        connection.close()
        if not rows:
            return "No se encontraron resultados."
        if len(rows) == 1:
            return json.dumps(rows[0], indent=2, ensure_ascii=False)
        else:
            limited = rows[:20]
            return f"Se encontraron {len(rows)} registros. Los primeros {len(limited)}:\n" + "\n".join(
                f"{i+1}. {json.dumps(row, ensure_ascii=False)}" for i, row in enumerate(limited)
            )
    except Exception as e:
        return f"Error SQL: {str(e)}"

TOOL_MAP = {
    "ejecutar_sql": ejecutar_sql,
}

TOOLS_DEFINITION = [
    {
        "name": "ejecutar_sql",
        "description": "Ejecuta una consulta SQL SELECT para obtener información de la base de datos. Puedes usar joins, subconsultas, funciones de agregación (COUNT, SUM, AVG, etc.) y cualquier cláusula SELECT válida. No uses INSERT/UPDATE/DELETE.",
        "parameters": {
            "type": "object",
            "properties": {
                "sql": {
                    "type": "string",
                    "description": "Consulta SQL SELECT completa"
                }
            },
            "required": ["sql"]
        }
    }
]